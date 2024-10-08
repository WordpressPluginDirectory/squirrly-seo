<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * User Account
 */
class SQ_Controllers_Account extends SQ_Classes_FrontController {

	/**
	 *
	 *
	 * @var object Checkin process
	 */
	public $checkin;

	public function action() {
		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_account_disconnect':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					return;
				}

				SQ_Classes_Helpers_Tools::saveOptions( 'sq_api', false );
				SQ_Classes_Helpers_Tools::saveOptions( 'sq_cloud_connect', false );
				SQ_Classes_Helpers_Tools::saveOptions( 'sq_cloud_token', false );

				break;
			case 'sq_ajax_account_getaccount':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$json = array();

				$this->checkin = SQ_Classes_RemoteController::checkin();

				if ( ! is_wp_error( $this->checkin ) ) {

					$json['html'] = $this->get_view( 'Blocks/Account' );

					if ( SQ_Classes_Error::isError() ) {
						$json['error'] = SQ_Classes_Error::getError();
					}

				}
				echo wp_json_encode( $json );
				exit();
		}
	}
}
