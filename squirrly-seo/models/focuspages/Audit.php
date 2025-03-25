<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Audit extends SQ_Models_Abstract_Assistant {

	protected $_category = 'audit';
	protected $_siteaudit = false;
	protected $_loading_time = false;

	protected $_duplicate_titles = false;
	protected $_duplicate_descriptions = false;
	protected $_empty_titles = false;
	protected $_empty_descriptions = false;

	const SCORE_MINVAL = 70;
	const SPEED_MAXVAL = 2;

	public function init() {
		if ( isset( $this->_audit->data ) ) {

			$this->_siteaudit = SQ_Classes_RemoteController::getAudit();

			if ( is_wp_error( $this->_siteaudit ) ) {
				$this->_error = true;
			}


			if ( isset( $this->_siteaudit->audit ) && isset( $this->_siteaudit->urls ) ) {

				foreach ( $this->_siteaudit->audit as $group => $tasks ) {

					if ( ! empty( $tasks ) ) {
						foreach ( $tasks as $task ) {
							if ( isset( $task->audit_task ) && $task->audit_task == 'DuplicateTitles' ) {
								$this->_duplicate_titles = $task;

								if ( ! empty( $this->_duplicate_titles->urls ) ) {
									foreach ( $this->_duplicate_titles->urls as &$row ) {
										if ( is_object( $this->_siteaudit->urls ) && isset( $this->_siteaudit->urls->$row ) ) {
											$row = $this->_siteaudit->urls->$row;
										}
									}
								}

							}
							if ( isset( $task->audit_task ) && $task->audit_task == 'DuplicateDescription' ) {
								$this->_duplicate_descriptions = $task;

								if ( ! empty( $this->_duplicate_descriptions->urls ) ) {
									foreach ( $this->_duplicate_descriptions->urls as &$row ) {
										if ( is_object( $this->_siteaudit->urls ) && isset( $this->_siteaudit->urls->$row ) ) {
											$row = $this->_siteaudit->urls->$row;
										}
									}
								}
							}
							if ( isset( $task->audit_task ) && $task->audit_task == 'EmptyTitles' ) {
								$this->_empty_titles = $task;

								if ( ! empty( $this->_empty_titles->urls ) ) {
									foreach ( $this->_empty_titles->urls as &$row ) {
										if ( is_object( $this->_siteaudit->urls ) && isset( $this->_siteaudit->urls->$row ) ) {
											$row = $this->_siteaudit->urls->$row;
										}
									}
								}
							}
							if ( isset( $task->audit_task ) && $task->audit_task == 'EmptyDescription' ) {
								$this->_empty_descriptions = $task;

								if ( ! empty( $this->_empty_descriptions->urls ) ) {
									foreach ( $this->_empty_descriptions->urls as &$row ) {
										if ( is_object( $this->_siteaudit->urls ) && isset( $this->_siteaudit->urls->$row ) ) {
											$row = $this->_siteaudit->urls->$row;
										}
									}
								}
							}

						}
					}
				}
			}

			if ( isset( $this->_audit->data->sq_seo_meta->loading_time ) ) {
				$this->_loading_time = $this->_audit->data->sq_seo_meta->loading_time;
			}

		} else {
			$this->_error = true;
		}

		parent::init();

	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'score'                => array(
				'title'       => sprintf( esc_html__( "Audit score is over %s", 'squirrly-seo' ), self::SCORE_MINVAL . '%' ),
				'value'       => ( isset( $this->_siteaudit->score ) ? $this->_siteaudit->score : 0 ) . '%',
				'penalty'     => 5,
				'description' => sprintf( esc_html__( "Even though we recommend getting an Audit score of 84 or above, a score of %s will do. %s The %sAudit%s made by Squirrly takes a lot of things into account: blogging, SEO, social media, links, authority, traffic. All these aspects contribute directly or indirectly to the overall SEO of your site. %s Therefore, without a good score on your Audit it's quite probable for Google not to position your pages high enough, because overall your website is not doing good enough for it to be considered a priority. %s A page will not rank high if most of the website has low quality SEO and low marketing metrics.", 'squirrly-seo' ), self::SCORE_MINVAL, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits' ) . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />' ),
			),
			'duplicatetitle'       => array(
				'title'       => esc_html__( "No duplicate titles", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Make sure that you don't have duplicate titles across pages from your site. %s If you do, then use canonical links to point the duplicate pages towards the original. %s Otherwise, if it's too hard to customize too many titles at once, simply use the Patterns feature from Squirrly. You'll be able to define patterns, so that your titles will seem to be unique. %s Go to %s Squirrly > Automation > Configuration %s. There you will find the Patterns tab.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '" target="_blank">', '</a>' ),
			),
			'duplicatedescription' => array(
				'title'       => esc_html__( "No duplicate description", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Make sure that your pages do not have duplicate descriptions. %s This is super easy to fix if you're using the SEO Automation feature from Squirrly SEO, because it will generate your META description automatically from the content of your page (in case you didn't already place a custom description). %s If you want to fix this problem by giving the problematic pages their own custom descriptions: go to the %sSquirrly SEO > Bulk SEO%s and see which pages have this problem.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" target="_blank">', '</a>' ),
			),
			'title'                => array(
				'title'       => esc_html__( "No empty titles", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Make sure that you do not have pages with empty titles. %s This means: pages where you haven't placed a META title in your Snippet. %s Features like SEO Automation or SEO Snippet from Squirrly SEO will help you easily fix this problem by either automating or customizing descriptions for your pages.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
			'description'          => array(
				'title'       => esc_html__( "No empty descriptions", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Make sure that you do not have pages with empty descriptions. %s This means: pages where you haven't placed a META description. %s Features like SEO Automation or SEO Snippet from Squirrly SEO will help you easily fix this problem by either automating or customizing descriptions for your pages.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
			'speed'                => array(
				'title'       => esc_html__( "SEO speed", 'squirrly-seo' ),
				'value'       => ( $this->_loading_time ? $this->_loading_time . ' ' . esc_html__( "sec", 'squirrly-seo' ) : '' ),
				'description' => sprintf( esc_html__( "You need to get good loading times for your pages. %s Good loading times will help you rank higher in Google, while pages that load very slowly will drag you down in search results.", 'squirrly-seo' ), '<br /><br />' ),
			),
			'mobile'               => array(
				'title'       => esc_html__( "Mobile-friendly", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Your website must be mobile friendly. %s It used to be an optional thing for Google until now, but it made it quite mandatory. %s Google prefers to display sites which are mobile friendly higher in search results, because most people search using mobile devices these days.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
		);


	}

	/*********************************************/
	/**
	 * Show button in header to go to audit page
	 *
	 * @return string
	 */
	public function getHeader() {
		$header = '<li class="completed">';
		if ( $this->_siteaudit && isset( $this->_siteaudit->score ) ) {
			$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits' ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Go to Audit", 'squirrly-seo' ) . '</a>';
		} else {
			$header .= '<div class="font-weight-bold text-warning text-center">' . esc_html__( "Note! The audit is not ready yet", 'squirrly-seo' ) . '</div>
                        <a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits' ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Request a new audit", 'squirrly-seo' ) . '</a>';
		}
		$header .= '</li>';

		return $header;
	}

	/**
	 * API Audit sq_audit_queue
	 * Check Audit Score
	 * The score must be over SCORE_MINVAL value
	 *
	 * @return bool|WP_Error
	 */
	public function checkScore( $task ) {
		if ( $this->_siteaudit && isset( $this->_siteaudit->score ) ) {
			$task['completed'] = ( (int) $this->_siteaudit->score >= self::SCORE_MINVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;

	}

	/**
	 * API Audit sq_audit_queue
	 * Check duplicate titles in the audit for the verified pages
	 *
	 * @return bool|WP_Error
	 */
	public function checkDuplicatetitle( $task ) {
		if ( $this->_duplicate_titles ) {
			if ( isset( $this->duplicate_titles->urls ) && ! empty( $this->_duplicate_titles->urls ) ) {
				$task['value'] = '<br />';
				foreach ( $this->_duplicate_titles->urls as $url ) {
					$task['value'] .= esc_html__( "URL", 'squirrly-seo' ) . ': ' . $url . '<br />';
				}
			}
			$task['completed'] = (bool) $this->_duplicate_titles->complete;

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * API Audit sq_audit_queue
	 * Check duplicate descriptions in the audit for the verified pages
	 *
	 * @return bool|WP_Error
	 */
	public function checkDuplicatedescription( $task ) {
		if ( $this->_duplicate_descriptions ) {
			if ( isset( $this->_duplicate_descriptions->urls ) && ! empty( $this->_duplicate_descriptions->urls ) ) {
				$task['value'] = '<br />';
				foreach ( $this->_duplicate_descriptions->urls as $url ) {
					$task['value'] .= esc_html__( "URL", 'squirrly-seo' ) . ': ' . $url . '<br />';
				}
			}
			$task['completed'] = (bool) $this->_duplicate_descriptions->complete;

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * API Audit sq_audit_queue
	 * Check empty titles in the audit for the verified pages
	 *
	 * @return bool|WP_Error
	 */
	public function checkTitle( $task ) {
		if ( $this->_empty_titles ) {
			$task['completed'] = true;

			if ( isset( $this->_empty_titles->urls ) && ! empty( $this->_empty_titles->urls ) ) {
				foreach ( $this->_empty_titles->urls as $url ) {
					if ( rtrim( $url, '/' ) == rtrim( $this->_post->url, '/' ) ) {
						$task['value']     = $url;
						$task['completed'] = false;
					}
				}
			}

			return $task;
		}

		$task['error'] = true;

		return $task;
	}

	/**
	 * API Audit sq_audit_queue
	 * Check empty descriptions in the audit for the verified pages
	 *
	 * @return bool|WP_Error
	 */
	public function checkDescription( $task ) {
		if ( $this->_empty_descriptions ) {
			$task['completed'] = true;

			if ( isset( $this->_empty_descriptions->urls ) && ! empty( $this->_empty_descriptions->urls ) ) {
				foreach ( $this->_empty_descriptions->urls as $url ) {
					if ( rtrim( $url, '/' ) == rtrim( $this->_post->url, '/' ) ) {
						$task['value']     = $url;
						$task['completed'] = false;
					}
				}
			}

			return $task;

		}


		$task['error'] = true;

		return $task;

	}

	/**
	 * API Audit sq_seo_meta
	 * Check current page loading speed
	 *
	 * @return bool|WP_Error
	 */
	public function checkSpeed( $task ) {
		if ( isset( $this->_audit->data->sq_seo_meta->loading_time ) ) {
			$task['completed'] = ( $this->_audit->data->sq_seo_meta->loading_time <= self::SPEED_MAXVAL );

			return $task;
		}

		$task['error'] = true;

		return $task;

	}

	/**
	 * API Audit sq_seo_meta
	 * Check if the page viewport exists
	 *
	 * @return bool|WP_Error
	 */
	public function checkMobile( $task ) {
		if ( isset( $this->_audit->data->sq_seo_meta->viewport ) ) {
			$task['completed'] = ( $this->_audit->data->sq_seo_meta->viewport <> '' );

			return $task;
		}

		$task['error'] = true;

		return $task;

	}
}
