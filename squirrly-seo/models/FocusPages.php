<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_FocusPages {

	protected $_task;
	//Focus pages Categories
	protected $_task_categories_labels;
	protected $_task_categories;

	//Processed Assistant Tasks and Categories
	protected $_assistant_tasks;
	protected $_assistant_categories;

	/**
	 *
	 *
	 * @var SQ_Models_Domain_FocusPage
	 */
	protected $_focuspage;

	public function init() {

		$this->_task_categories = array(
			'indexability' => esc_html__( "Visibility", 'squirrly-seo' ),
			'keyword'      => esc_html__( "Keyword", 'squirrly-seo' ),
			'strategy'     => esc_html__( "Strategy", 'squirrly-seo' ),
			'content'      => esc_html__( "SEO Content", 'squirrly-seo' ),
			'length'       => esc_html__( "Words / Page", 'squirrly-seo' ),
			'onpage'       => esc_html__( "Platform SEO", 'squirrly-seo' ),
			'snippet'      => esc_html__( "Snippet", 'squirrly-seo' ),
			'image'        => esc_html__( "SEO Image", 'squirrly-seo' ),
			'traffic'      => esc_html__( "Traffic Health", 'squirrly-seo' ),
			'audit'        => esc_html__( "Platform Health", 'squirrly-seo' ),
			'authority'    => esc_html__( "Page Authority", 'squirrly-seo' ),
			'social'       => esc_html__( "Social Signals", 'squirrly-seo' ),
			'backlinks'    => esc_html__( "Backlinks", 'squirrly-seo' ),
			'innerlinks'   => esc_html__( "Inner Links", 'squirrly-seo' ),
			'nofollow'     => esc_html__( "Outbound Links", 'squirrly-seo' ),
			'accuracy'     => esc_html__( "Accuracy", 'squirrly-seo' ),
			'ctr'          => esc_html__( "CTR", 'squirrly-seo' ),
			'impressions'  => esc_html__( "Impressions", 'squirrly-seo' ),
			'clicks'       => esc_html__( "Clicks", 'squirrly-seo' ),
		);

		foreach ( $this->_task_categories as $category => $title ) {
			$this->_task_categories_labels[ $category ] = array(
				'color' => '#D32F2F',
				'name'  => $title,
				'show'  => false
			);
		}

		return $this;
	}

	/**
	 * Parse all categories for a single page
	 *
	 * @param SQ_Models_Domain_FocusPage $focuspage
	 * @param array $labels
	 *
	 * @return $this
	 */
	public function parseFocusPage( SQ_Models_Domain_FocusPage $focuspage, $labels = array() ) {
		//set focus pages from API
		$this->_focuspage = $focuspage;

		//call  focus page tasks for all categories
		$this->parseAllTasks();
		$assistant_tasks = apply_filters( 'sq_assistant_tasks', array() );

		$this->_assistant_categories[ $this->_focuspage->id ] = apply_filters( 'sq_assistant_categories', array() );
		//remove the filters for the next focus page
		remove_all_filters( 'sq_assistant_tasks' );
		remove_all_filters( 'sq_assistant_categories' );

		foreach ( $this->_task_categories as $category => $array ) {

			if ( ! empty( $assistant_tasks[ $category ] ) ) {
				$this->_assistant_categories[ $this->_focuspage->id ][ $category ]['assistant'] = $this->getAssistant( $category, $assistant_tasks[ $category ], $this->_assistant_categories[ $this->_focuspage->id ][ $category ] );
			}

			//if the category is NOT complete and doesn't have erros
			if ( isset( $this->_assistant_categories[ $this->_focuspage->id ][ $category ] ) ) {
				if ( ! $this->_assistant_categories[ $this->_focuspage->id ][ $category ]['completed'] && ! $this->_assistant_categories[ $this->_focuspage->id ][ $category ]['error'] ) {
					$this->_task_categories_labels[ $category ]['show'] = true;
				}
			}

		}

		$audit = $this->_focuspage->getAudit();

		if ( ! isset( $audit->properties ) || ! isset( $audit->data->sq_seo_keywords->value ) || $audit->data->sq_seo_keywords->value == '' ) {
			$this->_focuspage->visibility = 'N/A';
		} else {
			$post = $this->_focuspage->getWppost();
			if ( $post->post_status <> 'publish' ) { //just if the Focus Page is public
				$this->_focuspage->visibility  = 'N/A';
				$this->_focuspage->audit_error = 404;
			}
		}

		//set the categories for this page
		add_filter( 'sq_assistant_categories_page', array( $this, 'getAssistantCategories' ) );


		return $this;
	}

	public function getCategories() {
		return json_decode( wp_json_encode( $this->_task_categories ) );
	}

	public function getAssistantCategories( $id ) {
		return json_decode( wp_json_encode( $this->_assistant_categories[ $id ] ) );
	}

	public function getLabels() {
		return json_decode( wp_json_encode( apply_filters( 'sq_categories_labels', $this->_task_categories_labels ) ) );
	}

	public function getFocusPage() {
		return $this->_focuspage;
	}

	public function getAssistant( $category_name = '', $tasks = array(), $category = array() ) {
		$content = '';
		if ( ! empty( $tasks ) && ! empty( $category ) ) {
			$content .= '<ul id="sq_assistant_tasks_' . $category_name . '_' . $this->_focuspage->id . '" class="p-0 m-0" style="display:none;">';
			$content .= ( isset( $category['header'] ) ? $category['header'] : '' );

			foreach ( $tasks as $name => $task ) {
				$task_content = '<li class="sq_task row ' . ( isset( $task['status'] ) ? $task['status'] : '' ) . '" data-category="' . $category_name . '" data-name="' . $name . '" data-active="' . $task['active'] . '" data-completed="' . $task['completed'] . '"  data-dismiss="modal">
                            <i class="fa-solid fa-check" title="' . wp_strip_all_tags( $task['error_message'] ) . '"></i>
                            <h4>' . $task['title'] . '</h4>
                            <div class="description" style="display: none">' . $task['description'] . '</div>
                            <div class="message" style="display: none">' . $task['error_message'] . '</div>
                            </li>';

				//Change task format ondemand
				$content .= apply_filters( 'sq_assistant_' . $category_name . '_task_' . $name, $task_content, $task );

				//remove the filters for the next focus page
				remove_all_filters( 'sq_assistant_' . $category_name . '_task_' . $name );

			}

			$content .= '</ul>';
		}

		return $content;
	}


	/**
	 * Get the admin Menu Tabs
	 *
	 * @return void
	 */
	public function parseAllTasks() {
		foreach ( $this->_task_categories as $category => $title ) {

			SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_' . ucfirst( $category ) )->setAudit( $this->_focuspage->getAudit() )//set the audit received from API
			                        ->setPost( $this->_focuspage->getWppost() )//set the local post in focuspage model
			                        ->init();
		}
	}

}
