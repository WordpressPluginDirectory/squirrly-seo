<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Content extends SQ_Models_Abstract_Assistant {

	protected $_category = 'content';

	protected $_keyword = false;
	protected $_optimization = false;
	protected $_modified = false;

	const OPTIMIZATION_MINVAL = 75;
	const UPDATEDAT_MAXVAL = 3;

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		if ( isset( $this->_audit->data->sq_seo_keywords->optimization_percent ) ) {
			$this->_optimization = $this->_audit->data->sq_seo_keywords->optimization_percent;
		}
		if ( isset( $this->_audit->data->sq_seo_keywords->value ) ) {
			$this->_keyword = $this->_audit->data->sq_seo_keywords->value;
		}
		if ( isset( $this->_audit->data->sq_seo_briefcase ) && ! empty( $this->_audit->data->sq_seo_briefcase ) ) {
			foreach ( $this->_audit->data->sq_seo_briefcase as $lsikeyword ) {
				if ( strcasecmp( $lsikeyword->keyword, $this->_keyword ) == 0 ) {
					$this->_optimization = $lsikeyword->optimized;
				}
			}
		}
		if ( isset( $this->_post->post_modified ) ) {
			$this->_modified = $this->_post->post_modified;
		}

	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'optimization' => array(
				'title'       => sprintf( esc_html__( "Optimize to %s", 'squirrly-seo' ), self::OPTIMIZATION_MINVAL . '%' ),
				'value'       => (int) $this->_optimization . '%',
				'description' => sprintf( esc_html__( "Make sure this Focus Page is optimized to %s using the %s Squirrly SEO Live Assistant %s. %s As you can see clearly on Google search result pages, Googles tries to find the closest match (inside web content) to what the user searched for. %s That is why using this method of optimizing a page as outlined by the Live Assistant feature is mandatory. %s Don't worry about over-optimizing anything, as the Live Assistant checks for many over-optimization traps you may fall into.", 'squirrly-seo' ), self::OPTIMIZATION_MINVAL . '%', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant' ) . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
			'snippet'      => array(
				'title'       => esc_html__( "Snippet is green", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "The tasks inside the %s Snippet %s  section of the Focus Pages feature must all be completed. %s Why? %s If the Snippet elements are Not completed, then your Focus Page is not 100%% optimized. %s We've built this SEO Content section especially because we wanted to help you understand that there's a lot more to On-Page SEO than just a content analysis, or a snippet. You need all these elements working together in order to achieve high rankings.", 'squirrly-seo' ), '<strong style="color: darkred;">', '</strong>', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
			'onpageseo'    => array(
				'title'       => esc_html__( "Platform SEO is green", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Make sure that the Platform SEO section is green for this Focus Page. %s Because WordPress is such a vast CMS with many customization possibilities, it happens to many website owners, business owners and developers, that custom post types from their site remain completely without SEO codes and other important settings. %s This task makes sure that everything is properly set up.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
			'updates'      => array(
				'title'       => esc_html__( "Fresh content update", 'squirrly-seo' ),
				'value'       => $this->_modified,
				'description' => sprintf( esc_html__( "Last Update Date for your Content: needs to be in the last 3 months. %s If it's not, then go and edit your page. %s Google prefers pages where the website owners keep updating the content. %s Why? %s Because it's one of the easiest ways to ensure that the content on the page keeps being relevant.", 'squirrly-seo' ), self::UPDATEDAT_MAXVAL, '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),

		);

	}

	/*********************************************/
	public function getHeader() {
		$edit_link = '';
		$header    = '<li class="completed">';
		$header    .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header    .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header    .= '</li>';


		$header .= '<li class="completed">';
		if ( $this->_keyword ) {
			$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php?keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' ) );
			if ( isset( $this->_post->ID ) ) {
				$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'post.php?post=' . (int) $this->_post->ID . '&keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' ) . '&action=edit' );
				if ( $this->_post->post_type <> 'profile' ) {
					$edit_link = get_edit_post_link( $this->_post->ID, false ) . '&keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' );
				}
			}

			$header .= $this->getUsedKeywords();
			if ( (int) $this->_post->ID > 0 ) {
				$header .= '<a href="' . $edit_link . '" target="_blank" class="sq_research_selectit btn btn-primary text-white col-10 offset-1 my-2" data-keyword="' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword ) . '">' . esc_html__( "Optimize for this", 'squirrly-seo' ) . '</a>';
			}
		} else {
			$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php' );
			if ( isset( $this->_post->ID ) ) {
				$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'post.php?post=' . (int) $this->_post->ID . '&action=edit' );
				if ( $this->_post->post_type <> 'profile' ) {
					$edit_link = get_edit_post_link( $this->_post->ID, false );
				}
			}

			$header .= '<div class="font-weight-bold text-black-50 m-0 px-3 text-center">' . esc_html__( "No Keyword found in Squirrly Live Assistant", 'squirrly-seo' ) . '</div>';
			$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Do a research", 'squirrly-seo' ) . '</a>';

			if ( isset( $this->_post->ID ) ) {
				$header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 my-2">' . esc_html__( "Optimize for a keyword", 'squirrly-seo' ) . '</a>';
			}
		}
		$header .= '</li>';

		return $header;
	}


	/**
	 * Keyword optimization required
	 *
	 * @param  $title
	 *
	 * @return string
	 */
	public function getTitle( $title ) {
		if ( $this->_error && ! $this->_keyword ) {
			return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
		} elseif ( ! $this->_completed && ! $this->_indexed ) {
			foreach ( $this->_tasks[ $this->_category ] as $task ) {
				if ( $task['completed'] === false ) {
					return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
				}
			}
		}

		return parent::getTitle( $title );
	}

	/**
	 * API Post Optimization
	 *
	 * @return bool|WP_Error
	 */
	public function checkOptimization( $task ) {
		if ( $this->_optimization !== false ) {
			$task['completed'] = ( $this->_optimization >= self::OPTIMIZATION_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * Call all Snippet functions and make sure they all return true
	 *
	 * @return bool
	 */
	public function checkSnippet( $task ) {
		$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Snippet' );
		$assistant->setAudit( $this->_audit );
		$assistant->setPost( $this->_post );
		$assistant->init();

		$tasks = $assistant->parseTasks( $this->_tasks );

		$task['completed'] = true;
		foreach ( $tasks['snippet'] as $name => $snippettask ) {
			if ( $snippettask['completed'] == false ) {
				$task['completed'] = false;
			}
		}

		return $task;
	}

	/**
	 * Call all On page functions and make sure they all return true
	 *
	 * @return bool
	 */
	public function checkOnpageseo( $task ) {
		/** @var SQ_Models_Focuspages_Onpage $tasks */
		$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Onpage' );
		$assistant->setAudit( $this->_audit );
		$assistant->setPost( $this->_post );
		$assistant->init();

		$tasks = $assistant->parseTasks( $this->_tasks );

		$task['completed'] = true;
		foreach ( $tasks['onpage'] as $onpagetask ) {
			if ( $onpagetask['completed'] == false ) {
				$task['completed'] = false;
			}
		}

		return $task;
	}

	/**
	 * Check if the last modified date is less than 3 months
	 *
	 * @return bool|WP_Error
	 */
	public function checkUpdates( $task ) {
		if ( $this->_modified !== false ) {
			$task['completed'] = ( strtotime( $this->_modified ) >= ( time() - ( self::UPDATEDAT_MAXVAL * 30 * 3600 * 24 ) ) );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}
}
