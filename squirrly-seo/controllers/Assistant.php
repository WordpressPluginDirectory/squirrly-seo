<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Assistant extends SQ_Classes_FrontController {

	/** @var object $checkin With Cloud Data about the current account limits */
	public $checkin;

	function init() {

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'assistant' ) );

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
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'assistant' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'seosettings' );

		if ( method_exists( $this, $tab ) ) {
			call_user_func( array( $this, $tab ) );
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

		$search      = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
		$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( $search );

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
		SQ_Classes_Helpers_Tools::setHeader( 'json' );

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
