<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_FocusPages extends SQ_Classes_FrontController {

	/** @var object Checkin process with Squirrly Cloud */
	public $checkin;

	/** @var array list of tasks labels */
	public $labels = array();

	/** @var false|SQ_Models_Domain_Post[] found pages in DB */
	public $pages = false;

	/** @var SQ_Models_Domain_FocusPage[] of focus pages from API */
	public $focuspages = array();

	/** @var SQ_Models_Domain_FocusPage Used in the view for defining the Focus Page row */
	public $focuspage;

	/** @var SQ_Models_Domain_Post */
	public $post;

	/** @var WP_Post used for innerlinks */
	public $innerlinks;
	/**
	 * @var int $max_num_pages Total number of results
	 */
	public $max_num_pages = 0;

	/**
	 * Initiate the class if called from menu
	 *
	 * @return mixed|void
	 */
	function init() {

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'pagelist' ) );

		//Show connection only for the Focus Pages and not Inner links
		if ( in_array( $tab, array( 'addpage', 'pagelist', 'login', 'register' ) ) ) {

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
		}

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'seosettings' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'chart' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'knob' );

		if ( method_exists( $this, $tab ) ) {
			if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
				call_user_func( array( $this, $tab ) );
			}
		}

		add_action( 'sq_focuspages_after', function () {
			//get the modal window for the assistant popup
			echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
		} );

		add_action( 'sq_innerlinks_after', function () {
			//get the modal window for the innerlinks popup
			echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getInnerlinksModal();
		} );

		$this->show_view( 'FocusPages/' . esc_attr( ucfirst( $tab ) ) );

	}

	/**
	 * Load for Add Focus Page menu tab
	 */
	public function addpage() {
		// Get the default pages
		if( $this->pages === false ){
			$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( '' );
		}

		//get also the focus pages
		$this->focuspages = SQ_Classes_RemoteController::getFocusPages();

		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as &$focuspage ) {
				$focuspage = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_FocusPage', $focuspage );
			}
		}
	}

	/**
	 * Called for List of the Focus Pages
	 */
	public function pagelist() {
		//Set the Labels and Categories
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'focuspages' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'labels' );

		//Set the focus pages and labels
		$this->setFocusPages();
	}

	/**
	 * Called for List of the Focus Pages
	 */
	public function innerlinks() {

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'focuspages' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-ajax-select' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'datatables' );

		$page   = (int)SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
		$search = SQ_Classes_Helpers_Tools::getValue( 'squery' );
		$type   = SQ_Classes_Helpers_Tools::getValue( 'stype' );
		$num    = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

		$args = array(
			'start'  => ( $page - 1 ) * $num,
			'num'    => $num,
			'search' => $search,
		);

		$this->innerlinks = SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->getSqInnerlinks( $args );

		if ( is_wp_error( $this->innerlinks ) ) {

			SQ_Classes_Error::setError( esc_html__( "Can't load data!", _SQ_PLUGIN_NAME_ ) );
			$this->innerlinks = false;

		} elseif ( ! empty( $this->innerlinks ) ) {

			if ( $type || ( $search && trim( $search ) <> '' ) ) {

				foreach ( $this->innerlinks as $id => $innerlink ) {

					$from_url = get_permalink( $innerlink->from_post_id );
					$to_url   = get_permalink( $innerlink->to_post_id );

					if ( $search ) {
						if ( SQ_Classes_Helpers_Tools::findStr( $innerlink->keyword, $search ) === false && SQ_Classes_Helpers_Tools::findStr( $from_url, $search ) === false && SQ_Classes_Helpers_Tools::findStr( $to_url, $search ) === false ) {

							unset( $this->innerlinks[ $id ] );
						}
					}

					if ( $type ) {
						if ( $type == 'nofollow' && ! $innerlink->nofollow ) {
							unset( $this->innerlinks[ $id ] );
						}

						if ( $type == 'blank' && ! $innerlink->blank ) {
							unset( $this->innerlinks[ $id ] );
						}
					}

				}
			}

			$this->max_num_pages = ceil( count( $this->innerlinks ) / $num );

			$start            = ( $page - 1 ) * $num;
			$this->innerlinks = array_slice( $this->innerlinks, (int) $start, (int) $num );
		}

	}

	/**
	 * Set the Focus Pages and Labels
	 */
	public function setFocusPages() {
		$labels    = SQ_Classes_Helpers_Tools::getValue( 'slabel', array() );
		$days_back = (int) SQ_Classes_Helpers_Tools::getValue( 'days_back', 90 );
		$sid       = SQ_Classes_Helpers_Tools::getValue( 'sid' );

		SQ_Classes_ObjController::getClass( 'SQ_Models_FocusPages' )->init();
		$this->checkin = SQ_Classes_RemoteController::checkin();

		if ( $focuspages = SQ_Classes_RemoteController::getFocusPages() ) {

			if ( is_wp_error( $focuspages ) ) {
				SQ_Classes_Error::setError( 'Could not load the Focus Pages.' );
			} else {

				//Get the audits for the focus pages
				$audits = SQ_Classes_RemoteController::getFocusAudits( array(
					'post_id'   => $sid,
					'days_back' => $days_back
				) );

				if ( ! empty( $focuspages ) ) {
					foreach ( $focuspages as $focuspage ) {

						//Add the audit data if exists
						if ( ! is_wp_error( $audits ) ) {
							if ( isset( $focuspage->user_post_id ) && ! empty( $audits ) ) {
								foreach ( $audits as $audit ) {
									if ( $focuspage->user_post_id == $audit->user_post_id ) {
										if ( isset( $audit->audit ) ) {
											$audit->audit = json_decode( $audit->audit );
										} //set the audit data
										if ( isset( $audit->stats ) ) {
											$audit->stats = json_decode( $audit->stats );
										} //set the stats and progress data
										$focuspage = (object) array_merge( (array) $focuspage, (array) $audit );
										break;
									}
								}
							}
						}

						/** @var SQ_Models_Domain_FocusPage $focuspage */
						$focuspage = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_FocusPage', $focuspage );

						//set the connection info with GSC and GA
						$focuspage->audit->sq_analytics_gsc_connected    = ( isset( $this->checkin->connection_gsc ) ? $this->checkin->connection_gsc : 0 );
						$focuspage->audit->sq_analytics_google_connected = ( isset( $this->checkin->connection_ga ) ? $this->checkin->connection_ga : 0 );
						$focuspage->audit->sq_subscription_serpcheck     = ( isset( $this->checkin->subscription_serpcheck ) ? $this->checkin->subscription_serpcheck : 0 );

						//If there is a local page, then show focus
						if ( $focuspage->getWppost() ) {
							//if post_id is set, show only that focus page
							if ( $sid && $focuspage->id <> $sid ) {
								continue;
							}

							$this->focuspages[] = SQ_Classes_ObjController::getClass( 'SQ_Models_FocusPages' )->parseFocusPage( $focuspage, $labels )->getFocusPage();

						} elseif ( $focuspage->user_post_id ) {
							SQ_Classes_Error::setError( esc_html__( "Focus Page does not exist or was deleted from your website.", 'squirrly-seo' ) );
							SQ_Classes_RemoteController::deleteFocusPage( array( 'user_post_id' => $focuspage->user_post_id ) );
						}
					}
				}
			}
		}

		//Remove the blank focus pages
		$this->focuspages = array_filter( $this->focuspages );

		//Get the labels for view use
		if ( ! empty( $labels ) || count( (array) $this->focuspages ) > 1 ) {
			$this->labels = SQ_Classes_ObjController::getClass( 'SQ_Models_FocusPages' )->getLabels();
		}
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
                      chartArea:{width:"85%",height:"80%"},
                      enableInteractivity: "true",
                      tooltip: {trigger: "auto"},
                      vAxis: {
                          direction: ((reverse) ? -1 : 1),
                          title: "",
                          viewWindowMode:"explicit",
                          viewWindow: {
                              max:100,
                              min:0
                          }},
                      hAxis: {
                          title: "",
                          baselineColor: "transparent",
                          gridlineColor: "transparent",
                          textPosition: "none"
                      } ,
                      seriesType: "bars",
                      series: {2: {type: "line"}},
                      legend: {position: "bottom"},
                      colors:["#6200EE"]
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById(id));
                    chart.draw(data, options);
                    return chart;
                }
                function drawRankingChart(id, values, reverse) {
                    var data = google.visualization.arrayToDataTable(values);

                    var options = {

                        curveType: "function",
                        title: "",
                        chartArea:{width:"100%",height:"100%"},
                        enableInteractivity: "true",
                        tooltip: {trigger: "auto"},
                        pointSize: "2",
                        colors: ["#6200EE"],
                        hAxis: {
                          baselineColor: "transparent",
                           gridlineColor: "transparent",
                           textPosition: "none"
                        } ,
                        vAxis:{
                          direction: ((reverse) ? -1 : 1),
                          baselineColor: "transparent",
                          gridlineColor: "transparent",
                          textPosition: "none"
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById(id));
                    chart.draw(data, options);
                    return chart;
                }
                function drawTrafficChart(id, values, reverse) {
                     var data = google.visualization.arrayToDataTable(values);

                    var options = {

                      title : "",
                      chartArea:{width:"85%",height:"80%"},
                      enableInteractivity: "true",
                      tooltip: {trigger: "auto"},
                      vAxis: {
                          direction: ((reverse) ? -1 : 1),
                          title: "",
                          viewWindowMode:"explicit"
                      },
                      hAxis: {
                          title: "",
                          baselineColor: "transparent",
                          gridlineColor: "transparent",
                          textPosition: "none"
                      } ,
                      seriesType: "bars",
                      series: {2: {type: "line"}},
                      legend: {position: "bottom"},
                      colors:["#6200EE"]
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
			case 'sq_focus_pages_settings':

				//Save the settings
				if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Settings' )->saveSettings();
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_innelinks_link_template', wp_kses( $_POST['sq_innelinks_link_template'], array(
						'a' => array(
							'href'  => array(),
							'class' => array(),
							'style' => array(),
							'title' => array()
						)
					) ) );
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_innelinks_exclude_tags', SQ_Classes_Helpers_Tools::getValue( 'sq_innelinks_exclude_tags', array() ) );
				}

				//save the options in database
				SQ_Classes_Helpers_Tools::saveOptions();

				//show the saved message
				if ( ! SQ_Classes_Error::isError() ) {
					SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );
				}

				break;
			case 'sq_focuspages_search':
				$search      = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
				$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( $search );

				break;
			case 'sq_focuspages_inspecturl':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$json = array();

				$post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );

				//Set the focus pages and labels
				$args            = array();
				$args['post_id'] = $post_id;
				if ( $json['html'] = SQ_Classes_RemoteController::getInspectURL( $args ) ) {

					//Support for international languages
					if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
						if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
							$json['html'] = iconv( 'UTF-8', 'UTF-8//IGNORE', $json['html'] );
						}
					}
				}

				if ( SQ_Classes_Error::isError() ) {
					$json['error'] = SQ_Classes_Error::getError();
				}

				echo wp_json_encode( $json );
				exit();
			case 'sq_focuspages_getpage':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$json = array();

				//Set the focus pages and labels
				$this->setFocusPages();

				$json['html'] = $this->get_view( 'FocusPages/FocusPages' );

				//Support for international languages
				if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
					if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
						$json['html'] = iconv( 'UTF-8', 'UTF-8//IGNORE', $json['html'] );
					}
				}

				if ( SQ_Classes_Error::isError() ) {
					$json['error'] = SQ_Classes_Error::getError();
				}

				echo wp_json_encode( $json );
				exit();
			case 'sq_focuspages_getinnerlinks':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$json = array();

				$post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );

				//get the innerlinks for a local buffer
				if ( ! $this->innerlinks = get_transient( 'sq_innerlinks_suggestion' ) ) {

					$args            = array();
					$args['post_id'] = $post_id;
					$args['found']   = 0;
					if ( $this->innerlinks = SQ_Classes_RemoteController::getFocusPageInnerlinks( $args ) ) {

						if ( is_wp_error( $this->innerlinks ) ) {
							$json['error'] = $this->innerlinks->get_error_message();
						} else {

							if ( ! empty( $this->innerlinks ) ) {

								$local_innerlinks = SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->getSqInnerlinks( array() );

								if ( is_wp_error( $local_innerlinks ) ) {
									$json['error'] = $local_innerlinks->get_error_message();
								} elseif ( ! empty( $local_innerlinks ) ) {
									$allow = array( 'from_post_id' => '', 'to_post_id' => '', 'keyword' => '' );

									//Compare the innerlinks found by the Cloud
									$local_innerlinks = array_map( function ( $innerlink ) use ( $allow ) {
										return array_intersect_key( $innerlink->toArray(), $allow );
									}, (array) $local_innerlinks );

									$this->innerlinks = array_map( function ( $innerlink ) use ( $allow ) {
										return array_intersect_key( (array) $innerlink, $allow );
									}, (array) $this->innerlinks );

									$this->innerlinks = array_udiff( $this->innerlinks, $local_innerlinks, function ( $array1, $array2 ) {
										return strcmp( json_encode( $array1 ), json_encode( $array2 ) );
									} );

								}

								if ( ! empty( $this->innerlinks ) ) {
									foreach ( $this->innerlinks as $index => $innerlink ) {
										$innerlink = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Innerlink', $innerlink );

										if ( $innerlink->found ){
											unset( $this->innerlinks[ $index ] );
										}elseif ( ! $from_post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $innerlink->from_post_id ) ) {
											unset( $this->innerlinks[ $index ] );
										} else {
											$valid = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $from_post->post_content, $innerlink->keyword, $innerlink->from_post_id );

											if ( in_array( $from_post->post_type, array(
												'elementor_library',
												'ct_template',
												'oxy_user_library',
												'fusion_template',
												'shop_2',
												'profile'
											) ) ) {
												unset( $this->innerlinks[ $index ] );
											}

											if ( ! $valid || ! isset( $from_post->ID ) || $from_post->post_status <> 'publish' || ! post_type_exists( $from_post->post_type ) || $from_post->post_type == 'profile' ) {
												unset( $this->innerlinks[ $index ] );
											}
										}
									}
								}

								if ( ! empty( $this->innerlinks ) ) {
									set_transient( 'sq_innerlinks_suggestion', $this->innerlinks, HOUR_IN_SECONDS );
								}

							}

						}
					}

				}

				if ( ! empty( $this->innerlinks ) ) {
					$json['innerlinks'] = $this->innerlinks;
				}

				$json['html'] = $this->get_view( 'Blocks/Innerlinks' );

				echo wp_json_encode( $json );
				exit();
			case 'sq_focuspages_addinnerlink':

				$keyword       = SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );
				$from_post_id  = (int) SQ_Classes_Helpers_Tools::getValue( 'from_post_id', 0 );
				$from_post_ids = SQ_Classes_Helpers_Tools::getValue( 'from_post_ids', array() );
				$to_post_id    = (int) SQ_Classes_Helpers_Tools::getValue( 'to_post_id', 0 );
				$nofollow      = (int) SQ_Classes_Helpers_Tools::getValue( 'nofollow' );
				$blank         = (int) SQ_Classes_Helpers_Tools::getValue( 'blank' );
				$id            = SQ_Classes_Helpers_Tools::getValue( 'id' );

				delete_transient( 'sq_innerlinks_suggestion' );

				// Add inner Links
				if ( ! $id && ! empty( $from_post_ids ) ) {
					foreach ( $from_post_ids as $from_post_id ) {
						if ( $from_post_id && $to_post_id && $from_post_id <> $to_post_id && $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $from_post_id ) ) {

							// Check if the keyword exists in the post content and is valid for inner link
							$valid = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $post->post_content, $keyword, $to_post_id );

							/** @var SQ_Models_Domain_Innerlink $innerlink */
							$innerlink = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Innerlink', array(
								'from_post_id' => (int) $from_post_id,
								'to_post_id'   => $to_post_id,
								'keyword'      => $keyword,
								'valid'        => $valid,
							) )->toArray();

							if ( $nofollow !== false ) {
								$innerlink['nofollow'] = $nofollow;
							}

							if ( $blank !== false ) {
								$innerlink['blank'] = $blank;
							}

							// Set the innerlink ID
							$id = substr( md5( join( "", (array) $innerlink ) ), 0, 10 );

							// Check the optimizations and save them locally
							$innerlinks        = $post->sq->innerlinks;
							$innerlinks[ $id ] = $innerlink;
							$post->sq->innerlinks    = $innerlinks;

							SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->updateSqSeo( $post, $post->sq );

							//send the post to API
							$args                 = array();
							$args['from_post_id'] = (int) $from_post_id;
							$args['to_post_id']   = $to_post_id;
							$args['keyword']      = $keyword;
							$args['found']        = $valid;

							SQ_Classes_RemoteController::setFocusPageInnerlink( $args );

						}

					}

					if ( SQ_Classes_Helpers_Tools::isAjax() ) {
						wp_send_json_success( esc_html__( "Inner link is saved.", 'squirrly-seo' ) );
					} else {
						SQ_Classes_Error::setMessage( esc_html__( "Inner link is saved.", 'squirrly-seo' ) . " <br /> " );
					}

				} elseif ( $id && $from_post_id && $to_post_id && $from_post_id <> $to_post_id && $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $from_post_id ) ) {

					//Check if the keyword exists in the post content and is valid for inner link
					$valid = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $post->post_content, $keyword, $to_post_id );

					//Set the innerlink in post
					$innerlinks = $post->sq->innerlinks;
					if ( isset( $innerlinks[ $id ] )  ) {

						if ( $keyword ) {
							$innerlinks[ $id ]['keyword'] = $keyword;
						}

						if ( $nofollow ) {
							$innerlinks[ $id ]['nofollow'] = $nofollow;
						}

						if ( $blank ) {
							$innerlinks[ $id ]['blank'] = $blank;
						}

						$post->sq->innerlinks = $innerlinks;

						SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->updateSqSeo( $post, $post->sq );

					}

					//send the post to API
					$args                 = array();
					$args['from_post_id'] = $from_post_id;
					$args['to_post_id']   = $to_post_id;
					$args['keyword']      = $keyword;
					$args['found']        = $valid;

					SQ_Classes_RemoteController::setFocusPageInnerlink( $args );

					if ( SQ_Classes_Helpers_Tools::isAjax() ) {
						wp_send_json_success( esc_html__( "Inner link is saved.", 'squirrly-seo' ) );
					} else {
						SQ_Classes_Error::setMessage( esc_html__( "Inner link is saved.", 'squirrly-seo' ) . " <br /> " );
					}

				} else {

					if ( SQ_Classes_Helpers_Tools::isAjax() ) {
						wp_send_json_error( sprintf( esc_html__( "Error! Could not add the innerlink.", 'squirrly-seo' ), $from_post_id ) );
					} else {
						SQ_Classes_Error::setError( sprintf( esc_html__( "Error! Could not add the innerlink.", 'squirrly-seo' ), $from_post_id ) );
					}
				}

				break;
			case 'sq_focuspages_checkinnerlink':

				delete_transient( 'sq_innerlinks_suggestion' );

				$from_post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'from_post_id', 0 );
				$id      = SQ_Classes_Helpers_Tools::getValue( 'id' );

				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $from_post_id ) ) {

					//Set the innerlink in post
					$innerlinks = $post->sq->innerlinks;

					if ( isset( $innerlinks[ $id ] ) ) {

						//Check if the keyword exists in the post content and is valid for inner link
						$innerlinks[ $id ]['valid'] = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $post->post_content, $innerlinks[ $id ]['keyword'], $innerlinks[ $id ]['to_post_id'] );

						if ( $innerlinks[ $id ]['valid'] ) {

							//send the post to API
							$args                 = array();
							$args['from_post_id'] = $innerlinks[ $id ]['from_post_id'];
							$args['to_post_id']   = $innerlinks[ $id ]['to_post_id'];
							$args['keyword']      = $innerlinks[ $id ]['keyword'];
							$args['found']        = $innerlinks[ $id ]['valid'];

							SQ_Classes_RemoteController::setFocusPageInnerlink( $args );

							SQ_Classes_Error::setMessage( esc_html__( "Keyword found & Inner Link valid.", 'squirrly-seo' ) . " <br /> " );
						} else {
							SQ_Classes_Error::setError( esc_html__( "Keyword not found in content", 'squirrly-seo' ) . " <br /> " );
						}

						$post->sq->innerlinks = $innerlinks;

					}


					SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->updateSqSeo( $post, $post->sq );

				}

				break;
			case 'sq_focuspages_deleteinnerlink':

				delete_transient( 'sq_innerlinks_suggestion' );

				$from_post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'from_post_id', 0 );
				$id      = SQ_Classes_Helpers_Tools::getValue( 'id' );

				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $from_post_id ) ) {

					//Set the innerlink in post
					$innerlinks = $post->sq->innerlinks;
					if ( isset( $innerlinks[ $id ] )  ) {
						//send the post to API
						$args                 = array();
						$args['from_post_id'] = $innerlinks[ $id ]['from_post_id'];
						$args['to_post_id']   = $innerlinks[ $id ]['to_post_id'];
						$args['keyword']      = $innerlinks[ $id ]['keyword'];
						SQ_Classes_RemoteController::deleteFocusPageInnerlink( $args );

						unset( $innerlinks[ $id ] );

						$post->sq->innerlinks = $innerlinks;

						SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->updateSqSeo( $post, $post->sq );

						SQ_Classes_Error::setMessage( esc_html__( "Inner Link Removed", 'squirrly-seo' ) . " <br /> " );
					} else {
						SQ_Classes_Error::setError( esc_html__( "Could not delete the innerlink", 'squirrly-seo' ) . " <br /> " );
					}

				}

				break;

			case 'sq_focuspages_addnew':

				$term_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'term_id', 0 );
				$taxonomy  = SQ_Classes_Helpers_Tools::getValue( 'taxonomy', '' );
				$post_type = SQ_Classes_Helpers_Tools::getValue( 'type', '' );

				if ( $post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 ) ) {
					if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {
						//Save the post data in DB with the hash
						SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->savePost( $post );

						if ( $post->post_status == 'publish' && $post->ID == $post_id ) {
							//send the post to API
							$args              = array();
							$args['post_id']   = $post->ID;
							$args['hash']      = $post->hash;
							$args['permalink'] = $post->url;
							if ( $focuspage = SQ_Classes_RemoteController::addFocusPage( $args ) ) {
								if ( ! is_wp_error( $focuspage ) ) {
									SQ_Classes_Error::setMessage( esc_html__( "Focus page is added. The audit may take a while so please be patient.", 'squirrly-seo' ) . " <br /> " );
									if ( isset( $focuspage->user_post_id ) ) {
										set_transient( 'sq_auditpage_' . $focuspage->user_post_id, time() );

										SQ_Classes_Helpers_Tools::saveOptions( 'seoreport_time', false );
									}
								} elseif ( $focuspage->get_error_message() == 'limit_exceed' ) {
									$this->checkin = SQ_Classes_RemoteController::checkin();
									if(isset($this->checkin->subscription_focus_pages) && !$this->checkin->subscription_focus_pages){
										SQ_Classes_Error::setError( sprintf(esc_html__( "You have reached the maximum number of focus pages for this website (max: %d).", 'squirrly-seo' ) . " <br /> ", (int)$this->checkin->subscription_max_focus_pages ) );
									}else{
										SQ_Classes_Error::setError( sprintf(esc_html__( "You have reached the maximum number of focus pages per your account (max: %d).", 'squirrly-seo' ) . " <br /> " , (int)$this->checkin->subscription_max_focus_pages_all) );
									}
								}
							} else {
								SQ_Classes_Error::setError( esc_html__( "Error! Could not add the focus page.", 'squirrly-seo' ) . " <br /> " );
							}
						} else {
							SQ_Classes_Error::setError( esc_html__( "Error! This focus page is not public.", 'squirrly-seo' ) . " <br /> " );
						}

					} else {
						SQ_Classes_Error::setError( sprintf( esc_html__( "Error! Could not find the focus page %d in your website.", 'squirrly-seo' ), $post_id ) . " <br /> " );
					}
				}
				break;
			case 'sq_focuspages_update':

				$post_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );
				$term_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'term_id', 0 );
				$taxonomy  = SQ_Classes_Helpers_Tools::getValue( 'taxonomy', '' );
				$post_type = SQ_Classes_Helpers_Tools::getValue( 'type', '' );

				if ( $id = (int) SQ_Classes_Helpers_Tools::getValue( 'id', 0 ) ) {
					if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {

						//Save the post data in DB with the hash
						SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->savePost( $post );

						//send the post to API
						$args              = array();
						$args['post_id']   = $id;
						$args['hash']      = $post->hash;
						$args['permalink'] = $post->url;
						if ( $focuspage = SQ_Classes_RemoteController::updateFocusPage( $args ) ) {

							if ( ! is_wp_error( $focuspage ) ) {
								SQ_Classes_Error::setMessage( esc_html__( "Focus page sent for recheck. It may take a while so please be patient.", 'squirrly-seo' ) . " <br /> " );
								set_transient( 'sq_auditpage_' . $id, time() );
							} elseif ( $focuspage->get_error_message() == 'too_many_attempts' ) {
								SQ_Classes_Error::setError( esc_html__( "You've made too many requests, please wait a few minutes.", 'squirrly-seo' ) . " <br /> " );
							}

						} else {
							SQ_Classes_Error::setError( esc_html__( "You've made too many requests, please wait a few minutes.", 'squirrly-seo' ) . " <br /> " );
							set_transient( 'sq_auditpage_' . $id, time() );
						}

					} else {
						SQ_Classes_Error::setError( sprintf( esc_html__( "Error! Could not find the focus page %d in your website.", 'squirrly-seo' ), $post_id ) . " <br /> " );
					}
				}
				break;
			case 'sq_focuspages_delete':

				if ( $id = SQ_Classes_Helpers_Tools::getValue( 'id' ) ) {
					SQ_Classes_RemoteController::deleteFocusPage( array( 'user_post_id' => $id ) );
					SQ_Classes_Error::setMessage( esc_html__( "The focus page is removed from monitoring", 'squirrly-seo' ) . " <br /> " );
				} else {
					SQ_Classes_Error::setError( esc_html__( "Invalid params!", 'squirrly-seo' ) . " <br /> " );
				}

				break;

			case 'sq_ajax_innerlinks_bulk_check':
				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				$ids = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				$innerlinks = SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->getSqInnerlinks( array() );

				if ( ! empty( $ids ) ) {
					foreach ( $ids as $id ) {
						if ( in_array( $id, array_keys( $innerlinks ) ) ) {
							if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $innerlinks[ $id ]->from_post_id ) ) {
								//check the optimizations and save them locally
								add_filter( 'sq_seo_before_update', function ( $sq ) use ( $post, $id ) {
									//Set the innerlink in post
									$innerlinks = $sq->innerlinks;

									if ( isset( $innerlinks[ $id ] ) ) {
										//Check if the keyword exists in the post content and is valid for inner link
										$innerlinks[ $id ]['valid'] = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $post->post_content, $innerlinks[ $id ]['keyword'], $innerlinks[ $id ]['to_post_id'] );
									}

									$sq->innerlinks = $innerlinks;

									return $sq;
								}, 11, 1 );

								SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->updateSqSeo( $post );

							}
						}

					}

					echo wp_json_encode( array( 'message' => esc_html__( "Check Finished!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}

				exit();
			case 'sq_ajax_innerlinks_bulk_delete':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				$ids = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				$innerlinks = SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->getSqInnerlinks( array() );

				if ( ! empty( $ids ) ) {
					foreach ( $ids as $id ) {
						if ( in_array( $id, array_keys( $innerlinks ) ) ) {
							if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $innerlinks[ $id ]->from_post_id ) ) {

								//Set the innerlink in post
								$innerlinks = $post->sq->innerlinks;
								if ( isset( $innerlinks[ $id ] ) ) {
									unset( $innerlinks[ $id ] );
								}
								$post->sq->innerlinks = $innerlinks;

								SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->updateSqSeo( $post, $post->sq );

							}
						}

					}

					echo wp_json_encode( array( 'message' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
					delete_transient( 'sq_innerlinks_suggestion' );

				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}

				exit();
		}

	}

}
