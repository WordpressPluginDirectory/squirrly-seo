<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Clicks extends SQ_Models_Abstract_Assistant {

	protected $_category = 'clicks';
	protected $_keyword = false;
	protected $_clicks = false;

	const CLICKS_MINVAL = 10;

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		if ( $this->_audit->sq_analytics_gsc_connected ) {
			if ( isset( $this->_audit->data->sq_analytics_gsc->keyword ) && $this->_audit->data->sq_analytics_gsc->keyword <> '' && isset( $this->_audit->data->sq_analytics_gsc->clicks ) ) {

				$this->_keyword = $this->_audit->data->sq_analytics_gsc->keyword;
				$this->_clicks  = $this->_audit->data->sq_analytics_gsc->clicks;

			} elseif ( isset( $this->_audit->data->sq_seo_keywords->value ) ) {
				$this->_keyword = $this->_audit->data->sq_seo_keywords->value;
				$this->_clicks  = 0;
			}

		} else {
			$this->_error = true;

		}
	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'clicks' => array(
				'title'       => esc_html__( "Clicks from Search Engine in the last 3 months", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Clicks from Search Engine in the last 3 months. %s Clicks show you how many users clicked on your Focus Page after they searched for your keyword and saw your page in Google’s Search Results. %s To get more clicks for this page: Focus on creating attractive texts and make sure the info in the Snippet is 100%% Optimized with the Assistant inside the Bulk SEO section of Squirrly.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),

		);
	}

	/*********************************************/
	/**
	 * Check if the Google Search Console is connected
	 *
	 * @return string
	 */
	public function getHeader() {
		$header = '<li class="completed">';
		$header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header .= '</li>';

		$header .= '<li class="completed">';
		if ( ! $this->_audit->sq_analytics_gsc_connected ) {
			$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster' ) . '"  class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Connect Google Search", 'squirrly-seo' ) . '</a>';
		} elseif ( $this->_keyword ) {
			$header .= $this->getUsedKeywords();
			$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research', array( 'keyword=' . esc_attr( $this->_keyword ) ) ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Do a research", 'squirrly-seo' ) . '</a>';
		} else {
			if ( isset( $this->_post->ID ) ) {
				$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'post.php?post=' . (int) $this->_post->ID . '&action=edit' );
				if ( $this->_post->post_type <> 'profile' ) {
					$edit_link = get_edit_post_link( $this->_post->ID, false );
				}

				$header .= '<div class="font-weight-bold text-black-50 m-0 px-3 text-center">' . esc_html__( "No Keyword found in Squirrly Live Assistant", 'squirrly-seo' ) . '</div>';
				$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Do a research", 'squirrly-seo' ) . '</a>';
				if ( isset( $this->_post->ID ) ) {
					$header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 my-2">' . esc_html__( "Optimize for a keyword", 'squirrly-seo' ) . '</a>';
				}
			}
		}
		$header .= '</li>';

		return $header;
	}

	/**
	 * Customize the Color for this tasks
	 *
	 * @param  $completed
	 *
	 * @return string
	 */
	public function getColor( $completed ) {
		if ( ! $completed ) {
			return self::TASK_INCOMPLETE;
		}

		return parent::getColor( $completed );
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
		} elseif ( $this->_error && ! $this->_audit->sq_analytics_gsc_connected ) {
			return esc_html__( "Connect to Google Search Console.", 'squirrly-seo' );
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
	 * Show the value for this page
	 *
	 * @return bool|int
	 */
	public function getValue() {
		if ( ! $this->isError() ) {
			return number_format( (int) $this->_clicks, 0, '.', ',' );
		}

		return false;
	}

	/**
	 * Check if there are clicks on this page
	 *
	 * @return bool|WP_Error
	 */
	public function checkclicks( $task ) {
		if ( $this->_clicks !== false ) {
			$task['completed'] = ( $this->_clicks >= self::CLICKS_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}
}
