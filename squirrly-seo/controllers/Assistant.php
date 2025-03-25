<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Assistant extends SQ_Classes_FrontController {

	/** @var object $checkin With Cloud Data about the current account limits */
	public $checkin;

	/** @var SQ_Models_Domain_Post List (used in the view) */
	public $post;

	/** @var array Task labels */
	public $labels = array();

	/** @var false|SQ_Models_Domain_Post[] All pages that are sent to the view */
	public $pages = false;


	function init() {

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'assistant' ) );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'seosettings' );

		if ( method_exists( $this, $tab ) ) {
			if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
				call_user_func( array( $this, $tab ) );
			}
		}

		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
			wp_enqueue_style( 'media-views' );
		}

		$this->show_view( 'Assistant/' . esc_attr( ucfirst( $tab ) ) );

		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
	}

	public function assistant() {
		//Checkin to API V2
		$this->checkin = SQ_Classes_RemoteController::checkin();
	}


	public function bulkseo() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bulkseo' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'labels' );

		if( $this->pages === false ){
			$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( '' );
		}

		if ( ! empty( $labels ) || count( (array) $this->pages ) > 1 ) {
			//Get the labels for view use
			$this->labels = SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->getLabels();
		}
	}


	public function types() {

	}

	public function automation() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'highlight' );
		SQ_Classes_ObjController::getClass( 'SQ_Controllers_Patterns' )->init();


		add_filter( 'sq_automation_validate_pattern', function ( $pattern ) {

			if ( in_array( $pattern, array(
				'elementor_library',
				'ct_template',
				'oxy_user_library',
				'fusion_template',
				'shop_2'
			) ) ) {
				return false;
			}

			if ( in_array( $pattern, array_keys( SQ_Classes_Helpers_Tools::getOption( 'patterns' ) ) ) ) {
				return false;
			}

			return true;

		} );

		add_filter( 'sq_jsonld_types', function ( $jsonld_types, $post_type ) {
			if ( in_array( $post_type, array(
				'search',
				'category',
				'tag',
				'archive',
				'attachment',
				'404',
				'tax-post_tag',
				'tax-post_cat',
				'tax-product_tag',
				'tax-product_cat'
			) ) ) {
				$jsonld_types = array( 'website' );
			}
			if ( in_array( $post_type, array( 'home', 'shop' ) ) ) {
				$jsonld_types = array( 'website', 'local store', 'local restaurant' );
			}
			if ( $post_type == 'profile' ) {
				$jsonld_types = array( 'profile' );
			}
			if ( $post_type == 'product' ) {
				$jsonld_types = array( 'product', 'video' );
			}

			return $jsonld_types;
		}, 11, 2 );

		add_filter( 'sq_pattern_item', function ( $pattern ) {
			$itemname = ucwords( str_replace( array( '-', '_' ), ' ', esc_attr( $pattern ) ) );
			if ( $pattern == 'tax-product_cat' ) {
				$itemname = "Product Category";
			} elseif ( $pattern == 'tax-product_tag' ) {
				$itemname = "Product Tag";
			}

			return $itemname;
		} );

		add_filter( 'sq_automation_patterns', function ( $patterns ) {

			if ( ! empty( $patterns ) ) {
				foreach ( $patterns as $pattern => $type ) {
					if ( in_array( $pattern, array(
						'product',
						'shop',
						'tax-product_cat',
						'tax-product_tag',
						'tax-product_shipping_class'
					) ) ) {
						if ( ! SQ_Classes_Helpers_Tools::isEcommerce() ) {
							unset( $patterns[ $pattern ] );
						}
					}
				}
			}

			return $patterns;

		} );

	}


	/**
	 * Called when action is triggered
	 *
	 * @return void
	 */
	public function action() {

		parent::action();

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			///////////////////////////////////////////LIVE ASSISTANT SETTINGS
			case 'sq_settings_assistant':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					return;
				}

				//Save the settings
				if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Settings' )->saveValues( $_POST );
				}

				//show the saved message
				SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );

				break;
			case 'sq_bulkseo_search':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					return;
				}

				$search      = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
				$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( $search );

				break;
			case 'sq_ajax_assistant_bulkseo':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				$response = array();
				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$post_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );
				$term_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'term_id', 0 );
				$taxonomy  = SQ_Classes_Helpers_Tools::getValue( 'taxonomy', '' );
				$post_type = SQ_Classes_Helpers_Tools::getValue( 'post_type', '' );

				//Set the Labels and Categories
				SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->init();
				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {
					$this->post = SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->parsePage( $post )->getPage();
				}

				$json              = array();
				$json['html']      = $this->get_view( 'Assistant/BulkseoRow' );
				$json['html_dest'] = "#sq_row_" . $this->post->hash;

				$json['assistant'] = '';
				$categories        = apply_filters( 'sq_assistant_categories_page', $this->post->hash );
				if ( ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						if ( isset( $category->assistant ) ) {
							$json['assistant'] .= $category->assistant;
						}
					}
				}
				$json['assistant_dest'] = "#sq_assistant_" . $this->post->hash;

				echo wp_json_encode( $json );
				exit();
			case 'sq_ajax_search_pages':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				$response = array();
				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$search = (string) SQ_Classes_Helpers_Tools::getValue( 'q', '' );

				if ( $search <> '' ) {
					//check if search by URL and remove the root
					if ( wp_http_validate_url( $search ) && strpos( $search, home_url() ) !== false ) {
						$search = str_replace( home_url(), '', $search );
						$search = '/' . trim( $search, '/' );
					}
				}

				//change search query
				add_filter( 'sq_get_pages_before', function ( $query ) {

					$query['post_type']      = get_post_types( array( 'public' => true ) );
					$query['post_status']    = array( 'publish', 'pending', 'future' );
					$query['paged']          = 1;
					$query['posts_per_page'] = 1000;
					$query['orderby']        = 'date';
					$query['order']          = 'DESC';

					return $query;
				} );

				//transform posts in a multidimensional array
				add_filter( 'sq_wpposts', function ( $posts ) {
					if ( ! empty( $posts ) ) {
						foreach ( $posts as &$post ) {
							$post = array(
								'ID'          => $post->ID,
								'title'       => SQ_Classes_Helpers_Sanitize::clearTitle( $post->sq->title ),
								'description' => SQ_Classes_Helpers_Sanitize::clearDescription( $post->sq->description ),
								'keywords'    => SQ_Classes_Helpers_Sanitize::clearKeywords( $post->sq->keywords ),
								'url'         => str_replace( home_url(), '', untrailingslashit( $post->url ) ),
							);
						}
					}

					return $posts;
				}, 11, 1 );

				//run the query and get the pages
				$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( $search );

				if ( ! empty( $this->pages ) ) {
					$this->pages = array_slice( $this->pages, 0, 20 );
					wp_send_json_success( $this->pages );
				}

				wp_send_json_error( esc_html__( 'Not Page found!', 'squirrly-seo' ) );
			case 'sq_ajax_assistant':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$input = SQ_Classes_Helpers_Tools::getValue( 'input', '' );
				$value = (bool) SQ_Classes_Helpers_Tools::getValue( 'value', false );
				if ( $input ) {
					//unpack the input into expected variables
					list( $category_name, $name, $option ) = explode( '|', $input );
					$dbtasks = json_decode( get_option( SQ_TASKS ), true );

					if ( $category_name <> '' && $name <> '' ) {
						if ( ! $option ) {
							$option = 'active';
						}
						$dbtasks[ $category_name ][ $name ][ $option ] = $value;
						update_option( SQ_TASKS, wp_json_encode( $dbtasks ) );
					}

					$response['data'] = SQ_Classes_Error::showNotices( esc_html__( "Saved", 'squirrly-seo' ), 'success' );
					echo wp_json_encode( $response );
					exit;
				}

				$response['data'] = SQ_Classes_Error::showNotices( esc_html__( "Error: Could not save the data.", 'squirrly-seo' ), 'error' );
				echo wp_json_encode( $response );
				exit();

		}


	}
}
