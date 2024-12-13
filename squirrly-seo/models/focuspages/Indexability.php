<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Indexability extends SQ_Models_Abstract_Assistant {

	protected $_category = 'indexability';
	public $_robots = false;
	public $_noindex = false;
	public $_nofollow = false;
	public $_dositemap = false;
	public $_canonical = false;
	public $_permalink = false;

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		//check the noindex and nofollow from API
		if ( isset( $this->_audit->data->sq_seo_meta->noindex ) && $this->_audit->data->sq_seo_meta->noindex <> '' ) {
			$this->_robots   = $this->_audit->data->sq_seo_meta->noindex;
			$this->_nofollow = strpos( $this->_robots, 'nofollow' );
			$this->_noindex  = strpos( $this->_robots, 'noindex' );
		}

		//check if included in sitemap
		if ( isset( $this->_post->sq->do_sitemap ) ) {
			$this->_dositemap = $this->_post->sq->do_sitemap;
		}

		//get the canonical from audit
		if ( isset( $this->_audit->data->sq_seo_meta->canonical ) && $this->_audit->data->sq_seo_meta->canonical <> '' ) {
			$this->_canonical = $this->_audit->data->sq_seo_meta->canonical;
		}

		if ( isset( $this->_audit->data->serp_checker->position ) && $this->_audit->data->serp_checker->position ) {
			$this->_dbtasks[ $this->_category ]['gscindex'][ $this->_post->ID ] = true;
			$this->saveDBTasks();
		}

		//get the local permalink
		$this->_permalink = ( isset( $this->_post->url ) && $this->_post->url <> '' ? $this->_post->url : $this->_audit->permalink );
	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'noindex'   => array(
				'title'       => esc_html__( "Yes, do index", 'squirrly-seo' ),
				'penalty'     => 100,
				'value'       => ( $this->_robots ? $this->_robots : esc_html__( "no restrictions", 'squirrly-seo' ) ),
				'description' => sprintf( esc_html__( "To complete this task, go and look at all the places where you could have added instructions for Google not to index this page from your site. %s Make sure that there is no such instruction added to %sWordPress > Settings%s, or in a theme, or in a plugin, or in Squirrly SEO's Snippet for this page. Also, make sure you don't block this page in your %srobots.txt%s file. %s Sometimes, you will want certain pages from your site not to be indexed. Now is not the case, however. %s If you see a check mark for this task, then it means that you did not specify to Google that it should NOT index the page. %s Therefore, you allow Google to index the page. %s Since this is a Focus Page, you must allow Google to index it, in order for it to appear in search result pages.", 'squirrly-seo' ), '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'options-general.php' ) . '" target="_blank">', '</a>', '<a href="/robots.txt" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
			'nofollow'  => array(
				'title'       => esc_html__( "Yes, do follow", 'squirrly-seo' ),
				'penalty'     => 20,
				'value'       => ( $this->_robots ? $this->_robots : esc_html__( "no restrictions", 'squirrly-seo' ) ),
				'description' => sprintf( esc_html__( "To complete this task, make sure that you do NOT have a no-follow attribute for this Focus Page. %s This task gets verified from multiple sources. %s However, if you want to be 100%% certain in the future  that everything is perfect, use just Squirrly SEO, because it will ease both your setup and the system check. %s With Squirrly SEO, you could easily check this setting in the %sSnippet section%s. %s Many themes and plugins could interfere with settings.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" target="_blank">', '</a>', '<br /><br />' ),
			),
			'sitemap'   => array(
				'title'       => esc_html__( "Present in sitemap", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Checks whether or not your page is available in your %sXML Sitemap%s. %s Use the Sitemap from %s Squirrly > Technical SEO > Tweaks and Sitemap %s. %s Make sure this Focus Page is included in the sitemap generated by Squirrly SEO. %s In the best practices section you can find ideas for why it can make sense to remove pages from your sitemap.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo', array(
						'sid=' . ( isset( $this->_post->ID ) ? $this->_post->ID : '' ),
						'stype=' . ( isset( $this->_post->post_type ) ? $this->_post->post_type : '' )
					) ) . '" target="_blank">', '</a>', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks', array( '#tab=sitemap' ) ) . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />' ),
			),
			'gscindex'  => array(
				'title'       => esc_html__( "Manual index request", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Click the button to %s Ask Google to re-index %s this page. %s Disclaimer: This task will automatically be marked as complete once you click on the button and it takes you to Google Search Console. It's up to you to make 100%% sure that you do tell Google to either index or re-index this page. %s Perform a manual request for Google to re-index this page. %s This is super important to do whenever you make important changes to your pages. Otherwise, Google will still have the old version of your page. %s If Google keeps having the older version, then it doesn't matter if you've improved the page. %s When you click the Ask Google to Re-Index button, Squirrly will use the Google Search Console API to send Google the request on your behalf.", 'squirrly-seo' ), '<strong>', '</strong>', '<br /><br /><em>', '</em><br /><br />', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
			'canonical' => array(
				'title'       => esc_html__( "Canonical link", 'squirrly-seo' ),
				'value'       => '<br />' . esc_html__( "Canonical", 'squirrly-seo' ) . ': ' . ( $this->_canonical && $this->_canonical <> '' ? $this->_canonical : esc_html__( "No Canonical", 'squirrly-seo' ) ) . '<br />' . esc_html__( "Post URL", 'squirrly-seo' ) . ': ' . ( $this->_permalink && $this->_permalink <> '' ? $this->_permalink : esc_html__( "No URL", 'squirrly-seo' ) ),
				'penalty'     => 20,
				'description' => sprintf( esc_html__( "This page should have a canonical link to itself, indicating that it is indeed the original content. %s You can not have pages with canonical links to other sites and pages, because you could not rank for them. Why? Because a canonical link to another URL would mean that the other URL is the one worth indexing. (the original one) %s To complete this task, go and make sure that this page does NOT have a canonical link attribute pointing to another page. %s You can easily control this in the future by using the %sSnippet feature%s of Squirrly SEO.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" target="_blank">', '</a>' ),
			),
			'permalink' => array(
				'title'       => esc_html__( "Permalink structure is good", 'squirrly-seo' ),
				'value'       => ( $this->_canonical ? $this->_canonical : $this->_permalink ),
				'description' => sprintf( esc_html__( "Make your LINKS SEO-Friendly in %sWordPress > Settings > Permalinks%s %s That is where WordPress allows you to change the permalink structure. %s Your URLs (the links from your site) should be super easy to read. This makes your site Human-friendly as well.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'options-permalink.php' ) . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />' ),
			),
		);
	}

	/*********************************************/
	public function getHeader() {

		$header = '<li class="completed">';
		$header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header .= '</li>';

		if ( ! $this->_audit->sq_analytics_gsc_connected ) {
			$header .= '<li class="completed">
                    <a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster' ) . '" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Connect Google Search", 'squirrly-seo' ) . '</a>
                </li>';
		} else {
			$header .= '<li class="completed text-center sq_save_ajax">
                        <input type="hidden" id="sq_indexability_completed" value="1"/>
                        <button type="button" class="btn btn-primary text-white mx-auto px-4" data-redirect="https://search.google.com/search-console/inspect" data-input="sq_indexability_completed" data-action="sq_ajax_assistant" data-name="indexability|gscindex|' . $this->_post->ID . '" >' . esc_html__( "Ask Google to Re-Index", 'squirrly-seo' ) . ' >></button>
                    </li>';
		}

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

	public function getTitle( $title ) {

		foreach ( $this->_tasks[ $this->_category ] as $task ) {
			if ( $task['completed'] === false ) {
				return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
			}
		}

		return parent::getTitle( $title );
	}

	/*
	 * WordPress Noindex, Squirrly Noindex, Not present in robots.txt | API Noindex
	 * Check with Google Search Console if the permalink is crawlable
	 * @return bool|WP_Error
	 */
	public function checkNoindex( $task ) {
		$task['completed'] = ( $this->_noindex === false );

		return $task;

	}

	/**
	 * Squirrly Nofollow | API Nofollow
	 *
	 * @return bool|WP_Error
	 */
	public function checkNofollow( $task ) {
		$task['completed'] = ( $this->_nofollow === false );

		return $task;
	}

	/**
	 * Squirrly Sitemap activated, Squirrly Sitemap switched on
	 *
	 * @return bool|WP_Error
	 */
	public function checkSitemap( $task ) {
		$task['completed'] = $this->_dositemap;

		return $task;
	}

	/**
	 * Task with disclamer button. Complete on click | API Search Console check
	 *
	 * @return bool|WP_Error
	 */
	public function checkGscindex( $task ) {
		if ( isset( $this->_dbtasks[ $this->_category ]['gscindex'][ $this->_post->ID ] ) && $this->_dbtasks[ $this->_category ]['gscindex'][ $this->_post->ID ] ) {
			$task['completed'] = true;

			return $task;
		}

		if ( isset( $this->_audit->data->serp_checker->position ) && $this->_audit->data->serp_checker->position ) {
			$task['completed'] = true;

			return $task;
		}

		if ( $this->_audit->sq_analytics_gsc_connected ) {
			$task['completed'] = true;

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * Squirrly Canonical to be set this URL | API Canonical
	 *
	 * @return bool|WP_Error
	 */
	public function checkCanonical( $task ) {
		if ( $this->_canonical && $this->_permalink ) {
			$task['completed'] = strcasecmp( rtrim( $this->_canonical, '/' ), rtrim( $this->_permalink, '/' ) == 0 );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * Squirrly Permalink to be user-friendly | API Permalink
	 *
	 * @return bool|WP_Error
	 */
	public function checkPermalink( $task ) {
		if ( $this->_canonical <> '' ) {
			$task['completed'] = ( stripos( $this->_canonical, 'p=' ) === false );

			return $task;
		} elseif ( $this->_permalink <> '' ) {
			$task['completed'] = ( stripos( $this->_permalink, 'p=' ) === false );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}
}
