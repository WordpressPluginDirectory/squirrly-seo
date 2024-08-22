<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Backlinks extends SQ_Models_Abstract_Assistant {

	protected $_category = 'backlinks';

	protected $_moz_page_backlinks = false;
	protected $_majestic_page_backlinks = false;
	protected $_majestic_unique_domain = false;

	const BACKLINKS_MINVAL = 100;
	const DOMAINS_MINVAL = 30;
	const MAJESTIC_MINVAL = 100;

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		if ( ! isset( $this->_audit->data->sq_analytics_moz->page_backlinks ) && ! isset( $this->_audit->data->sq_analytics_majestic->page_backlinks ) && ! isset( $this->_audit->data->sq_analytics_majestic->page_backlinks ) ) {
			$this->_error = true;
		}

		if ( isset( $this->_audit->data->sq_analytics_moz->page_backlinks ) ) {
			$this->_moz_page_backlinks = $this->_audit->data->sq_analytics_moz->page_backlinks;
		}
		if ( isset( $this->_audit->data->sq_analytics_majestic->unique_domain ) ) {
			$this->_majestic_unique_domain = $this->_audit->data->sq_analytics_majestic->unique_domain;
		}
		if ( isset( $this->_audit->data->sq_analytics_majestic->page_backlinks ) ) {
			$this->_majestic_page_backlinks = $this->_audit->data->sq_analytics_majestic->page_backlinks;
		}
	}

	/**
	 * Customize the tasks header
	 *
	 * @return string
	 */
	public function getHeader() {
		$header = '<li class="completed">';
		$header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header .= '</li>';

		return $header;
	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'backlinks' => array(
				'title'       => sprintf( esc_html__( "At Least %s MOZ BackLinks", 'squirrly-seo' ), self::BACKLINKS_MINVAL ),
				'value'       => number_format( $this->_moz_page_backlinks, 0, '.', ',' ) . ' ' . esc_html__( "backlinks", 'squirrly-seo' ),
				'penalty'     => 10,
				'description' => sprintf( esc_html__( "At Least %s Moz Backlinks %s We use Moz’s API to show you data about the number of backlinks your site has. %s There is no one exact recipe, but having at least %s backlinks from authority websites will definitely help you rank better in the long run. %s To build a good Backlinks strategy, focus on social media sharing, guest posting, blog comments, Quora comments, ads, and more. %s PRO TIP %s : Day 8 of the 14 Days Journey to Better Ranking will give you more ideas of tactics you can employ in order to build good backlinks for your Focus Pages.", 'squirrly-seo' ), self::BACKLINKS_MINVAL, '<br /><br />', '<br /><br />', self::BACKLINKS_MINVAL, '<br /><br />', '<br /><br /><strong class="text-primary">', '</strong>' ),
			),
			'domains'   => array(
				'title'       => sprintf( esc_html__( "At Least %s Referring Domains", 'squirrly-seo' ), self::DOMAINS_MINVAL ),
				'value'       => number_format( $this->_majestic_unique_domain, 0, '.', ',' ) . ' ' . esc_html__( "unique domains", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "At Least %s Referring Domains %s A referring domain is an external website that links to your site. %s How this is counted: if your page has a backlink from the Wall Street Journal - it has one referring domain. If your page has a backlink from the Wall Street Journal and one from Forbes, that's two referring domains. Two backlinks from Forbes - that’s still counted as ONE referring domain. %s Having a variety of relevant, high-quality sites linking back to your pages as opposed to just having the same site linking to you over and over again will give you an edge when it comes to increasing your authority and rankings.", 'squirrly-seo' ), self::DOMAINS_MINVAL, '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
			'majestic'  => array(
				'title'       => sprintf( esc_html__( "At Least %s Majestic SEO Links", 'squirrly-seo' ), self::MAJESTIC_MINVAL ),
				'value'       => number_format( $this->_majestic_page_backlinks, 0, '.', ',' ) . ' ' . esc_html__( "backlinks", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "At Least %s Majestic SEO Links %s Squirrly SEO integrates with Majestic to retrieve information related to the number of links you’ve received for this Focus Page. %s High-quality backlinks improve your site’s authority and help you rank higher in search engine results pages. Build a strong backlink profile by focusing on getting lots of backlinks from multiple domains with a high DA (domain authority).", 'squirrly-seo' ), self::MAJESTIC_MINVAL, '<br /><br />', '<br /><br />' ),
			),
		);
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
	/*********************************************/

	/**
	 * Check the moz found backlinks to be grater than BACKLINKS_MINVAL
	 *
	 * @return bool|WP_Error
	 */
	public function checkBacklinks( $task ) {
		if ( $this->_moz_page_backlinks !== false ) {
			$task['completed'] = ( $this->_moz_page_backlinks >= self::BACKLINKS_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * Check the majestic referral domains to be greater than DOMAINS_MINVAL
	 *
	 * @return bool|WP_Error
	 */
	public function checkDomains( $task ) {
		if ( $this->_majestic_unique_domain !== false ) {
			$task['completed'] = ( $this->_majestic_unique_domain >= self::DOMAINS_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * Check the majestic found links to be grater than MAJESTIC_MINVAL
	 *
	 * @return bool|WP_Error
	 */
	public function checkMajestic( $task ) {
		if ( $this->_majestic_page_backlinks !== false ) {
			$task['completed'] = ( $this->_majestic_page_backlinks >= self::MAJESTIC_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}
}
