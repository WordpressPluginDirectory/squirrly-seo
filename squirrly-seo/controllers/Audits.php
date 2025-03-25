<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Audits extends SQ_Classes_FrontController {

	/** @var object Checkin process */
	public $checkin;

	public $blogs;
	public $audit;
	public $audits;

	/** @var SQ_Models_Domain_AuditPage List (used in the view) */
	public $auditpage;

	/** @var SQ_Models_Domain_AuditPage[] List (used in the view) */
	public $auditpages;

	/** @var false|SQ_Models_Domain_Post[] All pages that are sent to the view */
	public $pages = false;

	/**
	 *
	 *
	 * @var int Audit history limit
	 */
	public $limit = 10;

	function init() {

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) {
			$this->show_view( 'Errors/Connect' );

			return;
		}

		//Checkin to API V2
		$this->checkin = SQ_Classes_RemoteController::checkin();

		if ( is_wp_error( $this->checkin ) ) {
			if ( $this->checkin->get_error_message() == 'no_data' ) {
				$this->show_view( 'Errors/Error' );

				return;
			} elseif ( $this->checkin->get_error_message() == 'maintenance' ) {
				$this->show_view( 'Errors/Maintenance' );

				return;
			}
		}

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'audits' ) );

		if ( method_exists( $this, $tab ) ) {
			if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
				call_user_func( array( $this, $tab ) );
			}
		}

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'audits' );

		$this->show_view( 'Audits/' . esc_attr( ucfirst( $tab ) ) );

		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
	}

	/**
	 * Load for Add Audit Page menu tab
	 */
	public function addpage() {
		// Get the default pages
		if( $this->pages === false ){
			$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( '' );
		}

		// Get the audit  pages
		$this->auditpage = SQ_Classes_RemoteController::getAuditPages();

		if ( is_wp_error( $this->auditpage ) ) {
			$this->auditpage = false;
		}

	}

	public function compare() {

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'audits' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'knob' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'scrolltotop' );

	}

	public function audit() {
		$days_back = (int) SQ_Classes_Helpers_Tools::getValue( 'days_back', 30 );
		$sid       = (int) SQ_Classes_Helpers_Tools::getValue( 'sid' );

		if ( $sid ) {

			$this->audit = SQ_Classes_RemoteController::getAudit( array( 'id' => $sid, 'days_back' => $days_back ) );

			if ( $auditpages = SQ_Classes_RemoteController::getAuditPages() ) {

				if ( is_wp_error( $auditpages ) ) {
					SQ_Classes_Error::setError( 'Could not load the Audit Pages.' );
				} else {

					if ( ! empty( $auditpages ) ) {
						foreach ( $auditpages as $auditpage ) {

							/** @var SQ_Models_Domain_FocusPage $auditpage */
							$auditpage = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_AuditPage', $auditpage );

							//If there is a local page, then show focus
							if ( $auditpage->getWppost() ) {
								$this->auditpages[] = SQ_Classes_ObjController::getClass( 'SQ_Models_Audits' )->parseAuditPage( $auditpage )->getAuditPage();
							}

						}
					}

					if ( ! is_wp_error( $this->audit ) ) {
						$this->audit = $this->model->prepareAudit( $this->audit );
					}
				}

			}

		} else {
			SQ_Classes_Error::setError( esc_html__( "The audit was not found. Please load another audit.", 'squirrly-seo' ) );

		}

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'audits' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'knob' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'scrolltotop' );
		SQ_Classes_Error::clearErrors();

	}

	public function audits() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'audits' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'knob' );

		$this->setAuditPages();
	}

	/**
	 * Set the audit pages and populate them
	 *
	 * @return mixed
	 */
	public function setAuditPages() {
		if ( is_array( $this->auditpages ) && ! empty( $this->auditpages ) ) {
			return $this->auditpages;
		}

		$days_back   = (int) SQ_Classes_Helpers_Tools::getValue( 'days_back', 30 );
		$this->audit = SQ_Classes_RemoteController::getAudit( array( 'days_back' => $days_back ) );

		if ( is_wp_error( $this->audit ) ) {
			SQ_Classes_Error::setError( esc_html__( "Could not load the Audit Page.", 'squirrly-seo' ) );
		} elseif ( $auditpages = SQ_Classes_RemoteController::getAuditPages() ) {

			if ( is_wp_error( $auditpages ) ) {
				SQ_Classes_Error::setError( 'Could not load the Audit Pages.' );
			} else {

				if ( ! empty( $auditpages ) ) {
					foreach ( $auditpages as $auditpage ) {

						/** @var SQ_Models_Domain_FocusPage $auditpage */
						$auditpage = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_AuditPage', $auditpage );

						//If there is a local page, then show focus
						$this->auditpages[] = SQ_Classes_ObjController::getClass( 'SQ_Models_Audits' )->parseAuditPage( $auditpage )->getAuditPage();
					}
				}
			}
		}

		return $this->auditpages;
	}

	/**
	 * Load the Google Chart
	 *
	 * @return void
	 */
	public function loadScripts() {
		echo '<script>
               function drawScoreChart(id, values, reverse) {
                    var data = google.visualization.arrayToDataTable(values);

                    var options = {

                      title : "",
                      chartArea:{width:"80%",height:"70%"},
                      vAxis: {title: "",
                            viewWindowMode:"explicit",
                            viewWindow: {
                              max:100,
                              min:0
                            }},
                      hAxis: {title: ""},
                      seriesType: "bars",
                      series: {2: {type: "line"}},
                      legend: {position: "bottom"},
                      colors:["#6200EE","#589ee4"]
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById(id));
                    chart.draw(data, options);
                    return chart;
                }
          </script>';
	}

	/**
	 * Called when action is triggered
	 *
	 * @return void
	 */
	public function action() {
		parent::action();

		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
			if ( SQ_Classes_Helpers_Tools::isAjax() ) {
				wp_send_json_error( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );
			} else {
				SQ_Classes_Error::setError( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );
			}
		}

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_audits_settings':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					return;
				}

				$email = sanitize_email( SQ_Classes_Helpers_Tools::getValue( 'sq_audit_email' ) );
				SQ_Classes_Helpers_Tools::saveOptions( 'sq_audit_email', $email );

				if ( $email <> '' ) {

					//Save the settings on API too
					$args                = array();
					$args['audit_email'] = $email;
					SQ_Classes_RemoteController::saveSettings( $args );
					///////////////////////////////

					//show the saved message
					SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );
				} else {
					SQ_Classes_Error::setError( esc_html__( "Not a valid email address.", 'squirrly-seo' ) );

				}

				break;
			case 'sq_auditpages_getaudit':

				$json = array();

				//Set all audit pages
				$this->setAuditPages();

				$json['stats'] = $this->get_view( 'Audits/AuditStats' );
				$json['html']  = $this->get_view( 'Audits/AuditPages' );

				//Support for international languages
				if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
					if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
						$json['html'] = iconv( 'UTF-8', 'UTF-8//IGNORE', $json['html'] );
					}
				}

				if ( SQ_Classes_Helpers_Tools::isAjax() ) {
					SQ_Classes_Helpers_Tools::setHeader( 'json' );

					if ( SQ_Classes_Error::isError() ) {
						$json['error'] = SQ_Classes_Error::getError();
					}

					if ( SQ_Classes_Helpers_Tools::getValue( 'sq_debug' ) == 'on' ) {
						return;
					}
					echo wp_json_encode( $json );
					exit();
				}
				break;
			case 'sq_audits_search':

				$search      = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
				$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( $search );

				break;
			case 'sq_audits_compare':
				$sids         = SQ_Classes_Helpers_Tools::getValue( 'sid' );
				$this->audits = array();

				//get all the ids
				if ( $sids && ! empty( $sids ) ) {
					foreach ( $sids as $sid ) {
						$audit = SQ_Classes_RemoteController::getAudit( array( 'id' => $sid ) );

						//Don't add error audits
						if ( ! is_wp_error( $audit ) ) {
							$this->audits[] = $this->model->prepareAudit( $audit );
						}
					}

				}

				break;
			case 'sq_audits_addnew':

				$post_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );
				$term_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'term_id', 0 );
				$taxonomy  = SQ_Classes_Helpers_Tools::getValue( 'taxonomy', '' );
				$post_type = SQ_Classes_Helpers_Tools::getValue( 'type', '' );

				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {

					//Save the post data in DB with the hash
					SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->savePost( $post );

					$args              = array();
					$args['post_id']   = $post->ID;
					$args['hash']      = $post->hash;
					$args['permalink'] = $post->url;
					if ( $auditpage = SQ_Classes_RemoteController::addAuditPage( $args ) ) {
						if ( ! is_wp_error( $auditpage ) ) {
							SQ_Classes_Error::setMessage( esc_html__( "Audit page is added. The audit may take a while so please be patient.", 'squirrly-seo' ) . " <br /> " );
							set_transient( 'sq_auditpage_all', time() );
						} elseif ( $auditpage->get_error_message() == 'limit_exceed' ) {
							SQ_Classes_Error::setError( esc_html__( "You reached the maximum number of audit pages for your account.", 'squirrly-seo' ) . " <br /> " );
						}
					} else {
						SQ_Classes_Error::setError( esc_html__( "Error! Could not add the audit page.", 'squirrly-seo' ) . " <br /> " );
					}

				} else {
					SQ_Classes_Error::setError( esc_html__( "Error! Could not find the audit page in your website.", 'squirrly-seo' ) . " <br /> " );
				}
				break;
			case 'sq_audits_page_update':

				$post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );

				if ( $post_id ) {
					$args            = array();
					$args['post_id'] = $post_id;

					if ( $auditpage = SQ_Classes_RemoteController::updateAudit( $args ) ) {
						if ( ! is_wp_error( $auditpage ) ) {
							SQ_Classes_Error::setMessage( esc_html__( "Audit page sent for recheck. It may take a while so please be patient.", 'squirrly-seo' ) . " <br /> " );
						} elseif ( $auditpage->get_error_message() == 'too_many_attempts' ) {
							SQ_Classes_Error::setError( esc_html__( "You've made too many requests, you can request one page audit per hour.", 'squirrly-seo' ) . " <br /> " );
						} else {
							SQ_Classes_Error::setError( esc_html__( "The page could not be sent for reaudit.", 'squirrly-seo' ) . " <br /> " );
						}
					} else {
						SQ_Classes_Error::setError( esc_html__( "The page could not be sent for reaudit.", 'squirrly-seo' ) . " <br /> " );
					}
				}
				break;
			case 'sq_audits_update':

				$auditpage = SQ_Classes_RemoteController::updateAudit();

				if ( ! is_wp_error( $auditpage ) ) {
					SQ_Classes_Error::setMessage( esc_html__( "Audit page sent for recheck. It may take a while so please be patient.", 'squirrly-seo' ) . " <br /> " );
					set_transient( 'sq_auditpage_all', time() );
				} elseif ( $auditpage->get_error_message() == 'too_many_attempts' ) {
					SQ_Classes_Error::setError( esc_html__( "The audit for all pages can be made once an hour.", 'squirrly-seo' ) . " <br /> " );
				}
				break;
			case 'sq_audits_delete':

				if ( $post_id = SQ_Classes_Helpers_Tools::getValue( 'id', false ) ) {
					SQ_Classes_RemoteController::deleteAuditPage( array( 'user_post_id' => $post_id ) );
					SQ_Classes_Error::setError( esc_html__( "The page is removed from SEO Audit.", 'squirrly-seo' ) . " <br /> ", 'success' );
				} else {
					SQ_Classes_Error::setError( esc_html__( "Invalid params!", 'squirrly-seo' ) . " <br /> " );
				}

				break;
		}

	}
}
