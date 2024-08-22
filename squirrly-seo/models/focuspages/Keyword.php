<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Keyword must be the live assistant. The last optimized keyword
 * Class SQ_Models_Focuspages_Keyword
 */
class SQ_Models_Focuspages_Keyword extends SQ_Models_Abstract_Assistant {

	protected $_category = 'keyword';

	protected $_keyword = false;
	protected $_competition = false;
	protected $_trend = false;
	protected $_volume = false;

	const COMPETITION_SCORE = 5;
	const COMPETITION_SCORE_NICHE = 3;
	const IMPRESSIONS_MINVAL = 2;
	const TREND_SCORE = 5;
	const TREND_SCORE_NICHE = 3;


	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		if ( isset( $this->_audit->data->sq_seo_keywords->value ) ) {
			$this->_keyword = $this->_audit->data->sq_seo_keywords->value;
		}

		if ( isset( $this->_audit->data->sq_seo_keywords->research->sc ) ) {
			$this->_competition = $this->_audit->data->sq_seo_keywords->research->sc;
			$this->_trend       = $this->_audit->data->sq_seo_keywords->research->td;
			$this->_volume      = $this->_audit->data->sq_seo_keywords->research->sv;
		}

	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'competition' => array(
				'title'       => esc_html__( "Keyword Competition", 'squirrly-seo' ),
				'value'       => ( $this->_competition ? $this->_competition->text : false ),
				'penalty'     => 15,
				'description' => sprintf( esc_html__( "To complete this task you must make sure that the main keyword you're optimizing this Focus Page for has low competition. %s The Squirrly SEO software suite uses our proprietary Market Intelligence feature to determine the chance that your site has of outranking the current TOP 10 of Google for the desired keyword you're targeting. %s If you really want to have a clear shot at ranking, make sure the competition is low for the keyword you choose.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
			//            'impressions' => array(
			//                'title' => esc_html__("Search volume", 'squirrly-seo'),
			//                'value' => (isset($this->_volume->absolute) ? (is_numeric($this->_volume->absolute) ? number_format($this->_volume->absolute, 0, '.', ',') : $this->_volume->absolute) : ''),
			//                'description' => sprintf(esc_html__("To complete this task, go and find a keyword that has a good search volume. (meaning that many people search on Google for this keyword every single month). %s The Research features from Squirrly SEO will indicate if the volume is big enough. %s Since these are the most important pages on your website, you need to make sure that you get the maximum number of people possible to find this page. %s If you target keyword searches with low volumes, then you'll end up having just 2 or 3 people every month visiting this page. And then all the effort will have been for nothing.", 'squirrly-seo'), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
			//            ),
			//            'trend' => array(
			//                'title' => esc_html__("Google Trend", 'squirrly-seo'),
			//                'value' => ($this->_trend ? $this->_trend->text : false),
			//                'description' => sprintf(esc_html__("Trend levels required to get the Green Check on this task: %s - Steady %s - Going Up %s - Sky-rocketing %s we take the trend from the previous 3 months. %s If you target a search query with a bad trend you'll end up seeing little traffic to this page in the long run. %s Why ? A declining trend shows that Google Users are losing interest in that topic or keyword and will continue to do so in the future. %s Therefore, even though you could get much traffic right now after you rank this page, in the near future you'll get very little traffic even if you'd end up on Position 1 in Google Search.", 'squirrly-seo'), '<br />', '<br />', '<br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
			//            ),
		);
	}

	/*********************************************/
	/**
	 * API Keyword Detected
	 *
	 * @return string
	 */
	public function getHeader() {
		$header = '<li class="completed">';
		$header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header .= '</li>';

		$header .= '<li class="completed">';

		$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php' );
		if ( isset( $this->_post->ID ) ) {
			$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'post.php?post=' . (int) $this->_post->ID . '&action=edit' );
			if ( $this->_post->post_type <> 'profile' ) {
				$edit_link = get_edit_post_link( $this->_post->ID, false );
			}
		}

		$research_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' );

		if ( $this->_keyword ) {

			$research_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research', array( 'keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' ) ) );
			if ( isset( $this->_post->ID ) ) {
				$research_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research', array(
					'keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' ),
					'post_id=' . $this->_post->ID
				) );
			}

			if ( $this->_competition && $this->_trend ) {
				$header .= $this->getUsedKeywords();
				$header .= '<a href="' . $research_link . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3" >' . esc_html__( "Find Better Keywords", 'squirrly-seo' ) . '</a>';
			} else {
				$header .= $this->getUsedKeywords();
				$header .= '<a href="' . $research_link . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Do a research", 'squirrly-seo' ) . '</a>';
			}

			$header .= '<a href="' . $edit_link . '&keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' ) . '" target="_blank" class="sq_research_selectit btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Optimize for this", 'squirrly-seo' ) . '</a>';

		} elseif ( isset( $this->_post->ID ) ) {

			$header .= '<div class="font-weight-bold text-black-50 m-0 px-3 text-center">' . esc_html__( "No Keyword found in Squirrly Live Assistant", 'squirrly-seo' ) . '</div>';
			if ( isset( $this->_post->ID ) ) {
				$header .= '<a href="' . $research_link . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Do a research", 'squirrly-seo' ) . '</a>';
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
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkCompetition( $task ) {
		if ( $this->_competition !== false ) {
			//In case the volume is not high for this keyword, it may be a niche
			if ( $this->_volume !== false && $this->_volume->value < self::IMPRESSIONS_MINVAL ) {
				$task['completed'] = ( $this->_competition->value >= self::COMPETITION_SCORE_NICHE );
				if ( $task['completed'] ) {
					$task['value'] = esc_html__( "Decent ranking chance, based on the fact that it might be a niche keyword", 'squirrly-seo' );
				}
			} else {
				$task['completed'] = ( $this->_competition->value >= self::COMPETITION_SCORE );
			}

			return $task;
		}

		if ( ! $this->_keyword ) {
			$task['error_message'] = esc_html__( "No Keyword Found", 'squirrly-seo' ) . '. ' . esc_html__( "Please add a keyword first in Squirrly Live Assistant.", 'squirrly-seo' );
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkImpressions( $task ) {
		if ( $this->_volume !== false ) {
			$task['completed'] = ( $this->_volume->value >= self::IMPRESSIONS_MINVAL );

			return $task;
		}

		if ( ! $this->_keyword ) {
			$task['error_message'] = esc_html__( "No Keyword Found", 'squirrly-seo' ) . '. ' . esc_html__( "Please add a keyword first in Squirrly Live Assistant.", 'squirrly-seo' );
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkTrend( $task ) {
		if ( $this->_trend !== false ) {
			//In case the volume is not high for this keyword, it may be a niche
			if ( $this->_volume !== false && $this->_volume->value < self::IMPRESSIONS_MINVAL ) {
				$task['completed'] = ( $this->_trend->value >= self::TREND_SCORE_NICHE );
			} else {
				$task['completed'] = ( $this->_trend->value >= self::TREND_SCORE );
			}

			return $task;
		}

		if ( ! $this->_keyword ) {
			$task['error_message'] = esc_html__( "No Keyword Found", 'squirrly-seo' ) . '. ' . esc_html__( "Please add a keyword first in Squirrly Live Assistant.", 'squirrly-seo' );
		}

		$task['error'] = true;

		return $task;
	}

}
