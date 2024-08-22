<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Assistant extends SQ_Classes_FrontController {

	/** @var object $checkin With Cloud Data about the current account limits */
	public $checkin;

	function init() {

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'assistant' ) );

		if ( method_exists( $this, $tab ) ) {
			call_user_func( array( $this, $tab ) );
		}

		$this->show_view( 'Assistant/' . esc_attr( ucfirst( $tab ) ) );

		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
	}

	public function assistant() {
		//Checkin to API V2
		$this->checkin = SQ_Classes_RemoteController::checkin();
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
