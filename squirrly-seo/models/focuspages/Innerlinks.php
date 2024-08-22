<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Innerlinks extends SQ_Models_Abstract_Assistant {

	protected $_category = 'innerlinks';
	public $_permalink = false;
	public $_inner_links = false;

	const INNERS_MINVAL = 5;
	const INNERS_RECOMMENDED = 20;

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		$this->_permalink = ( isset( $this->_post->url ) && $this->_post->url <> '' ? $this->_post->url : $this->_audit->permalink );
		$path             = parse_url( $this->_permalink, PHP_URL_PATH );
		if ( $path == '' ) {
			$path = $this->_permalink;
		}

		if ( $this->_permalink <> '' ) {

			if ( isset( $this->_audit->data->sq_seo_innerlinks ) && $this->_audit->data->sq_seo_innerlinks ) {

				$this->_inner_links = 0;

				if ( isset( $this->_audit->data->sq_seo_innerlinks->inner_links ) ) {
					$this->_inner_links = (int) $this->_audit->data->sq_seo_innerlinks->inner_links;
				}

			} else {
				$this->_error = true;
			}

		}

	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );
		$path = parse_url( $this->_permalink, PHP_URL_PATH );
		if ( $path == '' ) {
			$path = $this->_permalink;
		}

		$this->_tasks[ $this->_category ] = array(
			'innerlinks' => array(
				'title'       => sprintf( esc_html__( "Get %s inner links", 'squirrly-seo' ), self::INNERS_MINVAL ),
				'value'       => number_format( (int) $this->_inner_links, 0, '.', ',' ) . ' ' . esc_html__( "inner links to", 'squirrly-seo' ) . ': ' . $path,
				'penalty'     => 5,
				'description' => sprintf( esc_html__( "Get %s Inner Links %s Recommended is: %s %s Inner Links are links that you send from one URL of your site to another URL of your site. %s Since your Focus Pages are the most important pages in your site, you should make sure that you link to them from many pages of your website. %s Note! We check the links present in the content of each post of your website.", 'squirrly-seo' ), self::INNERS_MINVAL, '<br /><br />', self::INNERS_RECOMMENDED, '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
		);
	}

	/*********************************************/
	public function getHeader() {
		$header = '<li class="completed">';
		$header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header .= '</li>';

		if ( isset( $this->_post->ID ) ) {
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_innelinks' ) ) {
				$header .= '<li class="completed">';
				$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'innerlinks' ) . '" class="btn btn-primary text-white col-12 mt-3" data-post_id="' . $this->_post->ID . '" data-post_type="' . $this->_post->post_type . '">' . esc_html__( "Inner Links Assistant", 'squirrly-seo' ) . '</a>';
				$header .= '</li>';
			}
		}

		return $header;
	}

	public function getTitle( $title ) {

		if ( ! $this->_completed && ! $this->_indexed ) {
			foreach ( $this->_tasks[ $this->_category ] as $task ) {
				if ( $task['completed'] === false ) {
					return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
				}
			}
		}

		return parent::getTitle( $title );
	}

	/**
	 * Get the inner links from the other posts
	 *
	 * @return bool|WP_Error
	 */
	public function checkInnerlinks( $task ) {
		if ( $this->_permalink <> '' ) {
			$task['completed'] = ( (int) $this->_inner_links && (int) $this->_inner_links >= self::INNERS_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

}
