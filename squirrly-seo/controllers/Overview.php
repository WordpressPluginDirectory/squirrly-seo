<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Home
 */
class SQ_Controllers_Overview extends SQ_Classes_FrontController {
	/**
	 * @var object Checkin process with Squirrly Cloud
	 */
	public $checkin;

	public function init() {

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) {
			$this->show_view( 'Errors/Connect' );

			return;
		}

		//Checkin to API V2
		$this->checkin = SQ_Classes_RemoteController::checkin();

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'dashboard' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'checkseo' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'account' );

		parent::init();

	}

	public function getJourneyNotification() {
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
			return;
		}

		//Get the username of the current user
		$username = '';
		if ( get_current_user_id() ) {
			$user_info = get_userdata( get_current_user_id() );
			if ( ! $username = $user_info->first_name ) {
				$username = $user_info->user_login;
			}
		}

		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_seojourney' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_alert_journey' ) ) {
			if ( ( time() - strtotime( SQ_Classes_Helpers_Tools::getOption( 'sq_installed' ) ) ) / ( 3600 * 24 ) > 4 ) { ?>
                <div class="alert alert-warning text-center m-0 mt-2 p-2">
                    <form method="post" class="p-0 m-0">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_alerts_close', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_alerts_close"/>
                        <input type="hidden" name="alert" value="sq_alert_journey"/>
                        <button type="submit" class="btn float-right bg-transparent p-0 m-0">x</button>
                    </form>
					<?php echo sprintf( esc_html__( "%s, why don't you start a two weeks journey for better rankings? %sStart driving your most valuable pages to Better Rankings today with your current plan.%s", 'squirrly-seo' ), '<strong>' . esc_attr( $username ) . '</strong>', '<br /><a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'journey' ) . '" style="font-weight: bold;" >', '</a>' ); ?>
                </div>
				<?php
			}
		}
	}

}
