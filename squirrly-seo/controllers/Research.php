<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Class SQ_Controllers_Research
 *
 * This class manages the research-related functionalities of the Squirrly SEO plugin.
 * It includes keyword research, displaying and updating labels, managing keyword suggestions, and interacting with external APIs for the generation of data.
 * The class also handles various views and their respective data loading requirements.
 */
class SQ_Controllers_Research extends SQ_Classes_FrontController {

	public $args = array();
	public $blogs;
	public $kr;
	//--
	public $keywords = array();
	public $suggested = array();
	public $rankkeywords = array();
	public $labels = array();

	// countries and languages
	public $countries = array();
	public $languages = array();

	//post id
	public $post_id = false;
	//--
	public $index;
	public $error;
	public $user;
	//--
	/** @var string used in the view */
	public $country;

	/**
	 * @var int $max_num_pages Total number of results
	 */
	public $max_num_pages = 0;
	public $total = 0;

	/**
	 *
	 *
	 * @var object Checkin process with Squirrly Cloud
	 */
	public $checkin;

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

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'research' ) );

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'datatables' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'research' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'labels' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( $tab );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'chart' );

		if ( method_exists( $this, $tab ) ) {
			if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
				call_user_func( array( $this, $tab ) );
			}
		}

		$this->show_view( 'Research/' . esc_attr( ucfirst( $tab ) ) );


		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
	}

	public function addkeyword() {
		$this->research();

		$this->show_view( 'Research/Research' );

		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
	}

	public function research() {

		$countries = SQ_Classes_RemoteController::getKrCountries();
		$languages = SQ_Classes_RemoteController::getKrLanguages();

		if ( ! is_wp_error( $countries ) ) {
			$this->countries = $countries;
		} else {
			$this->error = $countries->get_error_message();
		}

		if ( ! is_wp_error( $languages ) ) {
			$this->languages = $languages;
		} else {
			$this->error = $languages->get_error_message();
		}
	}

	public function briefcase() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'briefcase' );

		if ( empty( $this->args ) ){
			$sort   = SQ_Classes_Helpers_Tools::getValue( 'ssort', 'rank' );
			$order  = SQ_Classes_Helpers_Tools::getValue( 'sorder', 'asc' );
			$page   = SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
			$num    = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

			$this->args = array(
				'start'  => ( $page - 1 ) * $num,
				'limit'  => $num,
				'sort'   => $sort,
				'order'  => $order,
				'search' => '',
			);
		}

		$response = SQ_Classes_RemoteController::getBriefcase( $this->args );

		//check for errors
		if ( is_wp_error( $response ) ) {

			SQ_Classes_Error::setError( esc_html__( "Can't load data!", _SQ_PLUGIN_NAME_ ) );
			$response = false;

		} elseif ( ! empty( $response ) ) {

			if ( $this->total = apply_filters( 'sq_total_records', ( isset( $response->keywords ) ? count( $response->keywords ) : 0 ) ) ) {
				$this->max_num_pages = ceil( $this->total / $this->args['limit'] );
			}

		}

		if ( isset( $response->keywords ) && ! empty( $response->keywords ) ) {
			$this->keywords = $response->keywords;
		} else {
			$this->error = sprintf( esc_html__( "No keyword found. %s Show all %s keywords from Briefcase.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) . '">', '</a>' );
		}

		if ( isset( $response->labels ) ) {
			$this->labels = $response->labels;
		}

	}

	public function labels() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'briefcase' );


		//prepare call
		if ( empty( $this->args ) ){
			$page   = SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
			$num    = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

			$this->args = array(
				'start'  => ( $page - 1 ) * $num,
				'limit'  => $num,
				'search' => '',
			);
		}

		$response = SQ_Classes_RemoteController::getBriefcaseLabels( $this->args );

		//check for errors
		if ( is_wp_error( $response ) ) {

			SQ_Classes_Error::setError( esc_html__( "Can't load data!", _SQ_PLUGIN_NAME_ ) );
			$response = false;

		} elseif ( is_array( $response ) && ! empty( $response ) ) {

			//prepare the pagination if there is a total number for array
			if ( $this->total = apply_filters( 'sq_total_records', count( $response ) ) ) {
				$this->max_num_pages = ceil( $this->total / $this->args['limit'] );
			}

		}

		$this->labels = $response;

	}

	public function suggested() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'briefcase' );

		//prepare call
		if ( empty( $this->args ) ){
			$page   = SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
			$num    = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

			$this->args = array(
				'start'  => ( $page - 1 ) * $num,
				'limit'  => $num,
				'search' => '',
			);
		}

		//get the API data
		$response = SQ_Classes_RemoteController::getKrFound( $this->args );

		//check for errors
		if ( is_wp_error( $response ) ) {

			SQ_Classes_Error::setError( esc_html__( "Can't load data!", _SQ_PLUGIN_NAME_ ) );
			$response = false;

		} elseif ( is_array( $response ) && ! empty( $response ) ) {

			//prepare the pagination if there is a total number for array
			if ( $this->total = apply_filters( 'sq_total_records', count( $response ) ) ) {
				$this->max_num_pages = ceil( $this->total / $this->args['limit'] );
			}

		}

		//get results
		$this->suggested = $response;

		$labels = SQ_Classes_RemoteController::getBriefcaseLabels();

		//check for errors
		if ( ! is_wp_error( $labels ) ) {
			$this->labels = $labels;
		}

	}

	public function history() {

		//prepare call
		if ( empty( $this->args ) ){
			$page   = SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
			$num    = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

			$this->args = array(
				'start'  => ( $page - 1 ) * $num,
				'limit'  => $num,
				'search' => '',
			);
		}
		//get the API data
		$response = SQ_Classes_RemoteController::getKRHistory( $this->args );

		//check for errors
		if ( is_wp_error( $response ) ) {

			SQ_Classes_Error::setError( esc_html__( "Can't load data!", _SQ_PLUGIN_NAME_ ) );
			$response = false;

		} elseif ( is_array( $response ) && ! empty( $response ) ) {

			//prepare the pagination if there is a total number for array
			if ( $this->total = apply_filters( 'sq_total_records', count( $response ) ) ) {
				$this->max_num_pages = ceil( $this->total / $this->args['limit'] );
			}

		}

		$this->kr = $response;

	}

	/**
	 * Return the text for the stats in details
	 *
	 * @param  $key
	 * @param  $index
	 *
	 * @return string
	 */
	public function getReasearchStatsText( $key, $index ) {
		$stats = array(
			'tw' => array(
				esc_html__( "very few", 'squirrly-seo' ),
				esc_html__( "few", 'squirrly-seo' ),
				esc_html__( "few", 'squirrly-seo' ),
				esc_html__( "few", 'squirrly-seo' ),
				esc_html__( "few", 'squirrly-seo' ),
				esc_html__( "some", 'squirrly-seo' ),
				esc_html__( "some", 'squirrly-seo' ),
				esc_html__( "some", 'squirrly-seo' ),
				esc_html__( "some", 'squirrly-seo' ),
				esc_html__( "many", 'squirrly-seo' ),
				esc_html__( "many", 'squirrly-seo' )
			),
			'sc' => array(
				esc_html__( "very low ranking chance", 'squirrly-seo' ),
				esc_html__( "very low ranking chance", 'squirrly-seo' ),
				esc_html__( "low ranking chance", 'squirrly-seo' ),
				esc_html__( "low ranking chance", 'squirrly-seo' ),
				esc_html__( "modest ranking chance", 'squirrly-seo' ),
				esc_html__( "modest ranking chance", 'squirrly-seo' ),
				esc_html__( "decent ranking chance", 'squirrly-seo' ),
				esc_html__( "decent ranking chance", 'squirrly-seo' ),
				esc_html__( "high ranking chance", 'squirrly-seo' ),
				esc_html__( "very high ranking chance", 'squirrly-seo' ),
				esc_html__( "very high ranking chance", 'squirrly-seo' )
			),
		);

		if ( isset( $stats[ $key ][ $index ] ) ) {
			return $stats[ $key ][ $index ];
		}

		return '';
	}

	/**
	 * Called when action is triggered
	 *
	 * @return void
	 */
	public function action() {
		parent::action();

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_research_search':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					return;
				}

				$search = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
				$labels = SQ_Classes_Helpers_Tools::getValue( 'slabel' );
				$sort   = SQ_Classes_Helpers_Tools::getValue( 'ssort', 'rank' );
				$order  = SQ_Classes_Helpers_Tools::getValue( 'sorder', 'asc' );
				$page   = SQ_Classes_Helpers_Tools::getValue( 'spage', 1 );
				$num    = SQ_Classes_Helpers_Tools::getValue( 'snum', SQ_Classes_Helpers_Tools::getOption( 'sq_posts_per_page' ) );

				$this->args = array(
					'start'  => ( $page - 1 ) * $num,
					'limit'  => $num,
					'sort'   => $sort,
					'order'  => $order,
					'search' => $search,
				);

				if ( $labels && ! empty( $labels ) ) {
					$this->args['label'] = join( ',', $labels );
				}

				break;

			case 'sq_briefcase_addkeyword':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					SQ_Classes_Helpers_Tools::setHeader( 'json' );

					if ( SQ_Classes_Helpers_Tools::isAjax() ) {
						echo wp_json_encode( $response );
						exit();
					} else {
						SQ_Classes_Error::setError( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );
					}
				}

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$keyword   = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );
				$do_serp   = (int) SQ_Classes_Helpers_Tools::getValue( 'doserp', 0 );
				$is_hidden = (int) SQ_Classes_Helpers_Tools::getValue( 'hidden', 0 );

				if ( $keyword <> '' ) {
					//set ignore on API
					$args              = array();
					$args['keyword']   = $keyword;
					$args['do_serp']   = $do_serp;
					$args['is_hidden'] = $is_hidden;
					SQ_Classes_RemoteController::addBriefcaseKeyword( $args );

					if ( SQ_Classes_Helpers_Tools::isAjax() ) {
						if ( $do_serp ) {
							echo wp_json_encode( array( 'message' => esc_html__( "Keyword Saved. The rank check will be ready in a minute.", 'squirrly-seo' ) ) );
						} else {
							echo wp_json_encode( array( 'message' => esc_html__( "Keyword Saved!", 'squirrly-seo' ) ) );
						}
						exit();
					} else {
						SQ_Classes_Error::setMessage( esc_html__( "Keyword Saved!", 'squirrly-seo' ) );
					}
				} else {
					if ( SQ_Classes_Helpers_Tools::isAjax() ) {
						echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
						exit();
					} else {
						SQ_Classes_Error::setError( esc_html__( "Invalid params!", 'squirrly-seo' ) );
					}
				}
				break;
			case 'sq_briefcase_deletekeyword':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keyword = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );

				if ( $keyword <> '' ) {
					//set ignore on API
					$args            = array();
					$args['keyword'] = stripslashes( $keyword );
					SQ_Classes_RemoteController::removeBriefcaseKeyword( $args );

					echo wp_json_encode( array( 'message' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_briefcase_deletefound':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keyword = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );

				if ( $keyword <> '' ) {
					//set ignore on API
					$args            = array();
					$args['keyword'] = stripslashes( $keyword );
					SQ_Classes_RemoteController::removeKrFound( $args );

					echo wp_json_encode( array( 'message' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
			/**********************************/ case 'sq_briefcase_addlabel':

			SQ_Classes_Helpers_Tools::setHeader( 'json' );

			if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
				$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
				echo wp_json_encode( $response );
				exit();
			}

			$name  = (string) SQ_Classes_Helpers_Tools::getValue( 'name', '' );
			$color = (string) SQ_Classes_Helpers_Tools::getValue( 'color', '#ffffff' );

			if ( $name <> '' && $color <> '' ) {
				$args = array();

				$args['name']  = $name;
				$args['color'] = $color;
				$json          = SQ_Classes_RemoteController::addBriefcaseLabel( $args );

				if ( ! is_wp_error( $json ) ) {
					echo wp_json_encode( array( 'saved' => esc_html__( "Saved!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => $json->get_error_message() ) );
				}

			} else {
				echo wp_json_encode( array( 'error' => esc_html__( "Invalid Label or Color!", 'squirrly-seo' ) ) );
			}
			exit();
			case 'sq_briefcase_editlabel':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}


				$id    = (int) SQ_Classes_Helpers_Tools::getValue( 'id', 0 );
				$name  = (string) SQ_Classes_Helpers_Tools::getValue( 'name', 0 );
				$color = (string) SQ_Classes_Helpers_Tools::getValue( 'color', '#ffffff' );

				if ( $id > 0 && $name <> '' && $color <> '' ) {
					$args = array();

					$args['id']    = $id;
					$args['name']  = $name;
					$args['color'] = $color;
					SQ_Classes_RemoteController::saveBriefcaseLabel( $args );

					echo wp_json_encode( array( 'saved' => esc_html__( "Saved!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_briefcase_deletelabel':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$id = (int) SQ_Classes_Helpers_Tools::getValue( 'id', 0 );

				if ( $id > 0 ) {
					//set ignore on API
					$args = array();

					$args['id'] = $id;
					SQ_Classes_RemoteController::removeBriefcaseLabel( $args );

					echo wp_json_encode( array( 'deleted' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_briefcase_keywordlabel':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				$keyword = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );
				$labels  = SQ_Classes_Helpers_Tools::getValue( 'labels', array() );

				if ( $keyword <> '' ) {
					$args = array();

					$args['keyword'] = $keyword;

					$args['labels'] = '';
					if ( is_array( $labels ) && ! empty( $labels ) ) {
						$args['labels'] = join( ',', $labels );
					}

					SQ_Classes_RemoteController::saveBriefcaseKeywordLabel( $args );

					echo wp_json_encode( array( 'saved' => esc_html__( "Saved!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid Keyword!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_briefcase_backup':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					SQ_Classes_Error::setError( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );

					return;
				}

				$args          = array();
				$args['limit'] = - 1;
				$briefcase     = SQ_Classes_RemoteController::getBriefcase( $args );

				if ( isset( $briefcase->keywords ) && ! empty( $briefcase->keywords ) ) {
					$fp = fopen( _SQ_CACHE_DIR_ . 'file.txt', 'w' );
					foreach ( $briefcase->keywords as $row ) {
						fwrite( $fp, $row->keyword . PHP_EOL );
					}
					fclose( $fp );

					header( "Content-type: text;" );
					header( "Content-Encoding: UTF-8" );
					header( "Content-Disposition: attachment; filename=squirrly-briefcase-" . gmdate( 'Y-m-d' ) . ".txt" );
					header( "Pragma: no-cache" );
					header( "Expires: 0" );
					readfile( _SQ_CACHE_DIR_ . 'file.txt' );
				} else {
					SQ_Classes_Error::setError( esc_html__( "No keywords in Briefcase to backup", 'squirrly-seo' ) );

					return;
				}

				exit();
			case 'sq_briefcase_restore':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					SQ_Classes_Error::setError( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );

					return;
				}

				if ( ! empty( $_FILES['sq_upload_file'] ) && $_FILES['sq_upload_file']['tmp_name'] <> '' ) {
					$fp = fopen( $_FILES['sq_upload_file']['tmp_name'], 'rb' );

					try {
						$data     = '';
						$keywords = array();

						while ( ( $line = fgets( $fp ) ) !== false ) {
							$data .= $line;
						}

						if ( $data = json_decode( $data ) ) {
							if ( is_array( $data ) and ! empty( $data ) ) {
								foreach ( $data as $row ) {
									if ( isset( $row->keyword ) ) {
										$keywords[] = $row->keyword;
									}
								}
							}
						} else {
							//Get the data from CSV
							$fp = fopen( $_FILES['sq_upload_file']['tmp_name'], 'rb' );

							while ( ( $data = fgetcsv( $fp, 1000, ";" ) ) !== false ) {
								if ( ! isset( $data[0] ) || $data[0] == '' || strlen( $data[0] ) > 255 || is_numeric( $data[0] ) ) {
									SQ_Classes_Error::setError( esc_html__( "Error! The backup is not valid.", 'squirrly-seo' ) . " <br /> " );
									break;
								}

								if ( is_string( $data[0] ) && $data[0] <> '' ) {
									$keywords[] = strip_tags( $data[0] );
								}
							}

							if ( empty( $keywords ) ) {
								$fp = fopen( $_FILES['sq_upload_file']['tmp_name'], 'rb' );

								while ( ( $data = fgetcsv( $fp, 1000, "," ) ) !== false ) {
									if ( ! isset( $data[0] ) || $data[0] == '' || strlen( $data[0] ) > 255 || is_numeric( $data[0] ) ) {
										SQ_Classes_Error::setError( esc_html__( "Error! The backup is not valid.", 'squirrly-seo' ) . " <br /> " );
										break;
									}

									if ( is_string( $data[0] ) && $data[0] <> '' ) {
										$keywords[] = strip_tags( $data[0] );
									}
								}
							}


						}

						if ( ! empty( $keywords ) ) {
							$keywords = array_chunk( $keywords, 20 );

							foreach ( $keywords as $chunk ) {
								SQ_Classes_RemoteController::importBriefcaseKeywords( array( 'keywords' => json_encode( $chunk ) ) );
							}

							SQ_Classes_Error::setMessage( esc_html__( "Great! The backup is restored.", 'squirrly-seo' ) . " <br /> " );
						} else {
							SQ_Classes_Error::setError( esc_html__( "Error! The backup is not valid.", 'squirrly-seo' ) . " <br /> " );
						}
					} catch ( Exception $e ) {
						SQ_Classes_Error::setError( esc_html__( "Error! The backup is not valid.", 'squirrly-seo' ) . " <br /> " );
					}
				} else {
					SQ_Classes_Error::setError( esc_html__( "Error! You have to enter a previously saved backup file.", 'squirrly-seo' ) . " <br /> " );
				}
				break;
			case 'sq_briefcase_savemain':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$post_id = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );
				$keyword = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );

				if ( $post_id > 0 && $keyword <> '' ) {
					$args = array();

					$args['post_id'] = $post_id;
					$args['keyword'] = $keyword;
					SQ_Classes_RemoteController::saveBriefcaseMainKeyword( $args );

					echo wp_json_encode( array( 'saved' => esc_html__( "Saved!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();

			/*************************************************** AJAX *********/ case 'sq_ajax_briefcase_doserp':

			SQ_Classes_Helpers_Tools::setHeader( 'json' );

			if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
				$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
				echo wp_json_encode( $response );
				exit();
			}

			$json    = array();
			$keyword = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );

			if ( $keyword <> '' ) {
				$args            = array();
				$args['keyword'] = $keyword;
				if ( SQ_Classes_RemoteController::addSerpKeyword( $args ) === false ) {
					$json['error'] = SQ_Classes_Error::showNotices( esc_html__( "Could not add the keyword to SERP Check. Please try again.", 'squirrly-seo' ), 'error' );
				} else {
					$json['message'] = SQ_Classes_Error::showNotices( esc_html__( "The keyword is added to SERP Check.", 'squirrly-seo' ), 'success' );
				}
			} else {
				$json['error'] = SQ_Classes_Error::showNotices( esc_html__( "Invalid parameters.", 'squirrly-seo' ), 'error' );
			}

			SQ_Classes_Helpers_Tools::setHeader( 'json' );
			echo wp_json_encode( $json );
			exit();
			case 'sq_ajax_research_others':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keyword = SQ_Classes_Helpers_Tools::getValue( 'keyword', false );
				$country = SQ_Classes_Helpers_Tools::getValue( 'country', 'com' );
				$lang    = SQ_Classes_Helpers_Tools::getValue( 'lang', 'en' );

				if ( $keyword ) {
					$args            = array();
					$args['keyword'] = $keyword;
					$args['country'] = $country;
					$args['lang']    = $lang;
					$json            = SQ_Classes_RemoteController::getKROthers( $args );

					if ( ! is_wp_error( $json ) ) {
						if ( isset( $json->keywords ) ) {
							echo wp_json_encode( array( 'keywords' => $json->keywords ) );
						}
					} else {
						echo wp_json_encode( array( 'error' => $json->get_error_message() ) );
					}
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}

				exit();
			case 'sq_ajax_research_process':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keywords = SQ_Classes_Helpers_Tools::getValue( 'keywords', false );
				$lang     = SQ_Classes_Helpers_Tools::getValue( 'lang', 'en' );
				$country  = SQ_Classes_Helpers_Tools::getValue( 'country', 'com' );

				$count         = (int) SQ_Classes_Helpers_Tools::getValue( 'count', 10 );
				$id            = (int) SQ_Classes_Helpers_Tools::getValue( 'id', 0 );
				$this->post_id = SQ_Classes_Helpers_Tools::getValue( 'post_id', false );

				$labels = SQ_Classes_RemoteController::getBriefcaseLabels();

				//check for errors
				if ( ! is_wp_error( $labels ) ) {
					$this->labels = $labels;
				}

				if ( $id > 0 ) {
					$args       = array();
					$args['id'] = $id;
					$this->kr   = SQ_Classes_RemoteController::getKRSuggestion( $args );

					if ( ! is_wp_error( $this->kr ) ) {
						if ( ! empty( $this->kr ) ) {
							//Get the briefcase keywords
							if ( $briefcase = SQ_Classes_RemoteController::getBriefcase() ) {
								if ( ! is_wp_error( $briefcase ) ) {
									if ( isset( $briefcase->keywords ) ) {
										$this->keywords = $briefcase->keywords;
									}
								}
							}

							//research ready, return the results
							echo wp_json_encode( array(
								'done' => true,
								'html' => $this->get_view( 'Research/ResearchDetails' )
							) );
						} else {
							//still loading
							echo wp_json_encode( array( 'done' => false ) );
						}
					} else {
						//show the keywords in results to be able to add them to brifcase
						$keywords = explode( ',', $keywords );
						if ( ! empty( $keywords ) ) {
							foreach ( $keywords as $keyword ) {
								$this->kr[] = json_decode( wp_json_encode( array(
											'keyword' => $keyword,
										) ) );
							}
						}
						echo wp_json_encode( array(
							'done' => true,
							'html' => $this->get_view( 'Research/ResearchDetails' )
						) );

					}
				} elseif ( $keywords ) {
					$args            = array();
					$args['q']       = $keywords;
					$args['country'] = $country;
					$args['lang']    = $lang;
					$args['count']   = $count;
					$process         = SQ_Classes_RemoteController::setKRSuggestion( $args );

					if ( ! is_wp_error( $process ) ) {
						if ( isset( $process->id ) ) {
							//Get the briefcase keywords
							echo wp_json_encode( array( 'done' => false, 'id' => $process->id ) );

						}
					} else {
						if ( $process->get_error_code() == 'limit_exceeded' ) {
							echo wp_json_encode( array(
								'done'  => true,
								'error' => esc_html__( "Keyword Research limit exceeded", 'squirrly-seo' )
							) );
						} else {
							echo wp_json_encode( array( 'done' => true, 'error' => $process->get_error_message() ) );
						}
					}
				} else {
					echo wp_json_encode( array(
						'done'  => true,
						'error' => esc_html__( "Invalid params!", 'squirrly-seo' )
					) );
				}
				exit();
			case 'sq_ajax_research_history':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$labels = SQ_Classes_RemoteController::getBriefcaseLabels();

				//check for errors
				if ( ! is_wp_error( $labels ) ) {
					$this->labels = $labels;
				}

				$id = (int) SQ_Classes_Helpers_Tools::getValue( 'id', 0 );

				if ( $id > 0 ) {
					$args       = $this->kr = array();
					$args['id'] = $id;
					$krHistory  = SQ_Classes_RemoteController::getKRHistory( $args );

					if ( ! empty( $krHistory ) ) { //get only the first report
						$this->kr = current( $krHistory );
					}

					//Get the briefcase keywords
					if ( $briefcase = SQ_Classes_RemoteController::getBriefcase() ) {
						if ( ! is_wp_error( $briefcase ) ) {
							if ( isset( $briefcase->keywords ) ) {
								$this->keywords = $briefcase->keywords;
							}
						}
					}

					echo wp_json_encode( array( 'html' => $this->get_view( 'Research/HistoryDetails' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();

			case 'sq_ajax_briefcase_bulk_delete':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keywords = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				if ( ! empty( $keywords ) ) {
					//set ignore on API
					$args             = array();
					$args['keywords'] = $keywords;
					SQ_Classes_RemoteController::removeBriefcaseKeywords( $args );

					echo wp_json_encode( array( 'message' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_ajax_briefcase_bulk_label':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keywords = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );
				$labels   = SQ_Classes_Helpers_Tools::getValue( 'labels', array() );

				if ( is_array( $labels ) && ! empty( $labels ) ) {
					$labels = join( ',', $labels );
				}

				if ( ! empty( $keywords ) ) {

					$args = array();

					$args['keywords'] = $keywords;
					$args['labels']   = $labels;
					SQ_Classes_RemoteController::saveBriefcaseKeywordsLabel( $args );

					echo wp_json_encode( array( 'message' => esc_html__( "Saved!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid Keyword!", 'squirrly-seo' ) ) );
				}

				exit();
			case 'sq_ajax_briefcase_bulk_doserp':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$keywords = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				if ( ! empty( $keywords ) ) {
					$args             = array();
					$args['keywords'] = $keywords;
					SQ_Classes_RemoteController::addSerpKeywords( $args );

					echo wp_json_encode( array( 'message' => esc_html__( "The keywords are added to SERP Check!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid Keyword!", 'squirrly-seo' ) ) );
				}
				exit();
			case 'sq_ajax_labels_bulk_delete':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$inputs = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

				if ( ! empty( $inputs ) ) {
					$args       = array();
					$args['id'] = $inputs;
					SQ_Classes_RemoteController::removeBriefcaseLabel( $args );

					echo wp_json_encode( array( 'message' => esc_html__( "Deleted!", 'squirrly-seo' ) ) );
				} else {
					echo wp_json_encode( array( 'error' => esc_html__( "Invalid params!", 'squirrly-seo' ) ) );
				}
				exit();
		}


	}
}
