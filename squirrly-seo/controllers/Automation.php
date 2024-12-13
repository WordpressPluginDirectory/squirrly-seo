<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Automation extends SQ_Classes_FrontController {

	public $pages = array();

	/**
	 * Called when action is triggered
	 *
	 * @return void
	 */
	public function action() {
		parent::action();

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {

			///////////////////////////////////////////SEO SETTINGS AUTOMATION
			case 'sq_seosettings_automation':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					return;
				}

				if ( ! SQ_Classes_Helpers_Tools::isAjax() ) {

					//Save automation settings
					if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
						SQ_Classes_ObjController::getClass( 'SQ_Models_Settings' )->saveValues( $_POST );
					}

				} elseif ( SQ_Classes_Helpers_Tools::getValue( 'patterns' ) ) {
					//Save configuration
					SQ_Classes_Helpers_Tools::saveOptions( '404_url_redirect', SQ_Classes_Helpers_Tools::getValue( '404_url_redirect' ) );
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_attachment_redirect', SQ_Classes_Helpers_Tools::getValue( 'sq_attachment_redirect' ) );
					SQ_Classes_Helpers_Tools::saveOptions( 'patterns', SQ_Classes_Helpers_Tools::getValue( 'patterns' ) );

					//trigger action after settings are saved
					do_action( 'sq_save_settings_after', $_POST );
				}

				if ( SQ_Classes_Helpers_Tools::isAjax() ) {
					SQ_Classes_Helpers_Tools::setHeader( 'json' );

					$json = array();

					if ( SQ_Classes_Error::isError() ) {
						$json['error'] = SQ_Classes_Error::getError();
					} else {
						$json['data'] = SQ_Classes_Error::showNotices( esc_html__( "Saved", 'squirrly-seo' ), 'success' );
					}

					echo wp_json_encode( $json );
					exit();
				}

				//show the saved message
				if ( ! SQ_Classes_Error::isError() ) {
					SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );
				}

				break;
			case 'sq_automation_addpostype':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					return;
				}

				//Get the new post type
				$posttype = SQ_Classes_Helpers_Tools::getValue( 'posttype' );
				$filter   = array( 'public' => true, '_builtin' => false );
				$types    = get_post_types( $filter );
				foreach ( $types as $pattern => $type ) {
					if ( $post_type_obj = get_post_type_object( $pattern ) ) {
						if ( $post_type_obj->has_archive ) {
							$types[ 'archive-' . $pattern ] = 'archive-' . $pattern;
						}
					}
				}

				$filter     = array( 'public' => true, );
				$taxonomies = get_taxonomies( $filter );
				foreach ( $taxonomies as $pattern => $type ) {
					$types[ 'tax-' . $pattern ] = 'tax-' . $pattern;
				}

				//If the post type is in the list of types
				if ( $posttype && in_array( $posttype, $types ) ) {
					$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
					//if the post type does not already exist
					if ( ! isset( $patterns[ $posttype ] ) ) {
						//add the custom rights to the new post type
						$patterns[ $posttype ]              = $patterns['custom'];
						$patterns[ $posttype ]['protected'] = 0;
						//save the options in database
						SQ_Classes_Helpers_Tools::saveOptions( 'patterns', $patterns );

						SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );
						break;
					}
				}


				//Return error in case the post is not saved
				SQ_Classes_Error::setError( esc_html__( "Could not add the post type.", 'squirrly-seo' ) );
				break;

			/************************ Automation *******************************************************/ case 'sq_ajax_automation_deletepostype':

			SQ_Classes_Helpers_Tools::setHeader( 'json' );
			$response = array();

			if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
				$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
				echo wp_json_encode( $response );
				exit();
			}

			//Get the new post type
			$posttype = SQ_Classes_Helpers_Tools::getValue( 'value' );

			//If the post type is in the list of types
			if ( $posttype && $posttype <> '' ) {
				$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
				//if the post type exists in the patterns
				if ( isset( $patterns[ $posttype ] ) ) {
					//add the custom rights to the new post type
					unset( $patterns[ $posttype ] );

					//save the options in database
					SQ_Classes_Helpers_Tools::saveOptions( 'patterns', $patterns );

					$response['data'] = SQ_Classes_Error::showNotices( esc_html__( "Saved", 'squirrly-seo' ), 'success' );
					echo wp_json_encode( $response );
					exit();
				}
			}


			//Return error in case the post is not saved
			$response['data'] = SQ_Classes_Error::showNotices( esc_html__( "Could not add the post type.", 'squirrly-seo' ), 'error' );
			echo wp_json_encode( $response );
			exit();

		}

	}

}
