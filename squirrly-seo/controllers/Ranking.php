<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Ranking extends SQ_Classes_FrontController {

	public $info;
	public $ranks;
	//--
	public $suggested;
	public $keywords;

	/**
	 * @var object Checkin process with Squirrly Cloud
	 */
	public $checkin;

	/**
	 * @var int $max_num_pages Total number of results
	 */
	public $max_num_pages = 0;
	public $total = 0;

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

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'rankings' ) );

		if ( method_exists( $this, $tab ) ) {
			call_user_func( array( $this, $tab ) );
		}

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-reboot' );
		if ( is_rtl() ) {
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'popper' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap.rtl' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'rtl' );
		} else {
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap' );
		}
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'switchery' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'datatables' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'assistant' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'rankings' );

		$this->show_view( 'Ranking/' . esc_attr( ucfirst( $tab ) ) );

		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();

	}

	/**
	 * Call the rankings
	 */
	public function rankings() {
		$days_back = (int) SQ_Classes_Helpers_Tools::getValue( 'days_back', 30 );
		$search    = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
		$strict    = (string) SQ_Classes_Helpers_Tools::getValue( 'strict', '' );
		$sort      = SQ_Classes_Helpers_Tools::getValue( 'ssort', 'rank' );
		$order     = SQ_Classes_Helpers_Tools::getValue( 'sorder', 'asc' );
		$page      = SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
		$num       = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

		if ( $search ) {
			$search = sanitize_text_field( $search );
		}

		//prepare call
		$args = array(
			'start'      => ( $page - 1 ) * $num,
			'limit'      => $num,
			'sort'       => $sort,
			'order'      => $order,
			'keyword'    => $search,
			'strict'     => $strict,
			'days_back'  => $days_back,
			'has_change' => (string) SQ_Classes_Helpers_Tools::getValue( 'schanges', '' ),
			'has_ranks'  => (string) SQ_Classes_Helpers_Tools::getValue( 'ranked', '' ),
		);

		if ( $this->info = SQ_Classes_RemoteController::getRanksStats( $args ) ) {
			if ( is_wp_error( $this->info ) ) {
				$this->info = array();
			}
		}

		//get the API data
		$response = SQ_Classes_RemoteController::getRanks( $args );

		//check for errors
		if ( is_wp_error( $response ) ) {

			SQ_Classes_Error::setError( esc_html__( "Can't load data!", _SQ_PLUGIN_NAME_ ) );
			$response = false;

		} elseif ( is_array( $response ) && ! empty( $response ) ) {

			//prepare the pagination if there is a total number for array
			if ( $this->total = apply_filters( 'sq_total_records', count( $response ) ) ) {
				$this->max_num_pages = ceil( $this->total / $num );
			}

		}

		$this->ranks = $response;
	}

	public function gscsync() {

		$this->suggested = array();

		if ( $this->checkin->connection_gsc ) {
			$args                 = array();
			$args['max_results']  = '100';
			$args['max_position'] = '100';
			if ( $this->suggested = SQ_Classes_RemoteController::syncGSC( $args ) ) {
				if ( is_wp_error( $this->suggested ) ) {
					if ( $this->suggested->get_error_code() == 'token_expired' ) {
						SQ_Classes_Error::setError( esc_html__( "GSC Token Expired. Reconnect Google Search Console from 'Technical SEO > Connect Tools'.", 'squirrly-seo' ) );
					} else {
						SQ_Classes_Error::setError( esc_html__( "Could not load data.", 'squirrly-seo' ) );
					}
				}
			}
		}

	}

	/**
	 * Called when action is triggered
	 *
	 * @return void
	 */
	public function action() {
		parent::action();

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {

			case 'sq_ranking_settings':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
					return;
				}

				//Save the settings
				if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Settings' )->saveValues( $_POST );
				}

				//Save the settings on API too
				$args                       = array();
				$args['sq_google_country']  = SQ_Classes_Helpers_Tools::getValue( 'sq_google_country' );
				$args['sq_google_language'] = SQ_Classes_Helpers_Tools::getValue( 'sq_google_language' );
				$args['sq_google_device']   = SQ_Classes_Helpers_Tools::getValue( 'sq_google_device' );
				SQ_Classes_RemoteController::saveSettings( $args );
				///////////////////////////////

				//show the saved message
				SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );

				break;
			case 'sq_serp_refresh_post':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
					return;
				}

				$keyword = SQ_Classes_Helpers_Tools::getValue( 'keyword' );
				if ( $keyword ) {
					$args            = array();
					$args['keyword'] = $keyword;
					if ( SQ_Classes_RemoteController::checkPostRank( $args ) === false ) {
						SQ_Classes_Error::setError( sprintf( esc_html__( "Could not refresh the rank. Please check your SERP credits %s here %s", 'squirrly-seo' ), '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) . '">', '</a>' ) );
					} else {
						SQ_Classes_Error::setMessage( sprintf( esc_html__( "%s is queued and the rank will be checked soon.", 'squirrly-seo' ), '<strong>' . $keyword . '</strong>' ) );
					}
				}

				break;
			case 'sq_serp_delete_keyword':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
					return;
				}

				$keyword = SQ_Classes_Helpers_Tools::getValue( 'keyword' );

				if ( $keyword ) {
					$response = SQ_Classes_RemoteController::deleteSerpKeyword( array( 'keyword' => $keyword ) );
					if ( ! is_wp_error( $response ) ) {
						SQ_Classes_Error::setMessage( esc_html__( "The keyword is deleted.", 'squirrly-seo' ) . " <br /> " );
					} else {
						SQ_Classes_Error::setError( esc_html__( "Could not delete the keyword!", 'squirrly-seo' ) . " <br /> " );
					}
				} else {
					SQ_Classes_Error::setError( esc_html__( "Invalid params!", 'squirrly-seo' ) . " <br /> " );
				}
				break;
			case 'sq_ajax_rank_bulk_delete':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$inputs = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				if ( ! empty( $inputs ) ) {
					foreach ( $inputs as $keyword ) {
						if ( $keyword <> '' ) {
							$args            = array();
							$args['keyword'] = $keyword;
							SQ_Classes_RemoteController::deleteSerpKeyword( $args );
						}
					}

					echo wp_json_encode( array( 'message' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_ajax_rank_bulk_refresh':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$inputs = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				if ( ! empty( $inputs ) ) {
					foreach ( $inputs as $keyword ) {
						if ( $keyword <> '' ) {
							$args            = array();
							$args['keyword'] = $keyword;
							SQ_Classes_RemoteController::checkPostRank( $args );
						}
					}

					echo wp_json_encode( array( 'message' => esc_html__( "Sent!", 'squirrly-seo' ) ) );

				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();

		}
	}

	public function loadScripts() {
		echo '<script type="text/javascript">
               function drawChart(id, values, reverse) {
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
          </script>';
	}

}
