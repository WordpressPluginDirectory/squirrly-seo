<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Account Block view for user details and limits
 *
 * Called from Overview Controller
 */
?>
<?php
$whole = $decimal = 0;

if ( isset( $view->checkin->product_price ) && (int) $view->checkin->product_price > 0 ) {
	list( $whole, $decimal ) = explode( '.', number_format( $view->checkin->product_price, 2 ) );
}
if ( isset( $view->checkin->subscription_status ) && isset( $view->checkin->product_name ) ) {
	if ( $view->checkin->subscription_status == 'active' && $view->checkin->product_name == 'Free' ) {
		$view->checkin->product_name = 'Free + Bonus';
	}
}

?>
<?php if ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_account_info' ) && SQ_Classes_Helpers_Tools::userCan( 'manage_options' ) ) { ?>
    <i class="sq_account_info_avatar sq_icons sq_icons_small fa-solid fa-user" style="font-size: 20px;"></i>

    <div class="sq_account_info_content col-12 p-0 m-0 border-0 shadow text-left" style="display: none">
        <div class="position-relative">
            <div class="row author mx-3 my-2 py-2 border-bottom">
				<?php if ( isset( $view->checkin->subscription_email ) ) { ?>
                    <div class="col-3 p-0 m-0">
                        <img src="https://s.gravatar.com/avatar/<?php echo esc_attr( md5( $view->checkin->subscription_email ) ) ?>?s=50" alt="" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="col py-0 px-1 m-0">
						<?php echo esc_html( sanitize_email( $view->checkin->subscription_email ) ) ?>
						<?php if ( isset( $view->checkin->subscription_paid ) && isset( $view->checkin->subscription_expires ) && $view->checkin->subscription_paid && $view->checkin->subscription_expires ) { ?>
                            <div class="small <?php echo esc_attr( ( ( time() - strtotime( $view->checkin->subscription_expires ) > 0 ) ? 'text-danger' : '' ) ) ?>" style="font-size: 12px; line-height: 20px;"><?php echo sprintf( esc_html__( "Due Date: %s", "squirrly-seo" ), esc_attr( gmdate( 'd M Y', strtotime( $view->checkin->subscription_expires ) ) ) ); ?>
                                <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) ) ?>" class="bg-primary text-white px-1" target="_blank"><?php echo esc_html( $view->checkin->product_name ) ?></a>
                            </div>
						<?php } elseif ( isset( $view->checkin->subscription_expires ) && $view->checkin->subscription_expires ) { ?>
                            <div class="small" style="font-size: 12px; line-height: 20px;">
                                <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) ) ?>" class="bg-primary text-white px-1" target="_blank"><?php echo esc_html( $view->checkin->product_name ) ?></a>
                            </div>
						<?php } elseif ( isset( $view->checkin->subscription_expires ) && ! $view->checkin->subscription_expires ) { ?>
                            <div class="small" style="font-size: 12px; line-height: 20px;"><?php echo esc_html__( "Expires: never", "squirrly-seo" ); ?>
                                <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) ) ?>" class="bg-primary text-white px-1" target="_blank"><?php echo esc_html( $view->checkin->product_name ) ?></a>
                            </div>
						<?php } ?>
                    </div>
				<?php } ?>
            </div>
            <div class="my-3 mx-4">
                <ul class="p-0 m-0">
					<?php if ( isset( $view->checkin->subscription_max_focus_pages ) && isset( $view->checkin->subscription_focus_pages ) && (int) $view->checkin->subscription_max_focus_pages > 0 ) {
						?>
                        <li class="m-0 p-0 py-3">
                            <div class="row m-0 p-0">
                                <div class="col-1 m-0 p-0 mr-1"><i class="fa-solid fa-bullseye-arrow"></i></div>
                                <div class="col m-0 p-0" style="line-height: 15px;">
                                    <div class="row m-0 p-0"><?php echo esc_html__( "Focus Pages", "squirrly-seo" ) ?>
                                        <span class="col text-right p-0" style="font-size: 12px"><?php echo (int) $view->checkin->subscription_focus_pages . '/' . (int) $view->checkin->subscription_max_focus_pages ?></span>
                                    </div>
                                    <progress class="w-100" max="<?php echo (int) $view->checkin->subscription_max_focus_pages ?>" value="<?php echo (int) $view->checkin->subscription_focus_pages ?>"></progress>
                                </div>
                            </div>
                        </li>
					<?php } ?>

					<?php if ( isset( $view->checkin->subscription_max_audit_pages ) && isset( $view->checkin->subscription_audit_pages ) && (int) $view->checkin->subscription_max_audit_pages > 0 ) { ?>
                        <li class="m-0 p-0 py-3">
                            <div class="row m-0 p-0">
                                <div class="col-1 m-0 p-0 mr-1"><i class="fa-solid fa-chart-column"></i></div>
                                <div class="col m-0 p-0" style="line-height: 15px;">
                                    <div class="row m-0 p-0"><?php echo esc_html__( "Audit Pages", "squirrly-seo" ) ?>
                                        <span class="col text-right p-0" style="font-size: 12px"><?php echo (int) $view->checkin->subscription_audit_pages . '/' . (int) $view->checkin->subscription_max_audit_pages ?></span>
                                    </div>
                                    <progress class="w-100" max="<?php echo (int) $view->checkin->subscription_max_audit_pages ?>" value="<?php echo (int) $view->checkin->subscription_audit_pages ?>"></progress>
                                </div>
                            </div>
                        </li>
					<?php } ?>

					<?php
					if ( isset( $view->checkin->subscription_max_kr ) && isset( $view->checkin->subscription_kr ) && (int) $view->checkin->subscription_max_kr > 0 ) {
						?>
                        <li class="m-0 p-0 py-3">
                            <div class="row m-0 p-0">
                                <div class="col-1 m-0 p-0 mr-1"><i class="fa-solid fa-key"></i></div>
                                <div class="col m-0 p-0" style="line-height: 15px;">
                                    <div class="row m-0 p-0"><?php echo esc_html__( "Keywords Lookups", "squirrly-seo" ) ?>
                                        <span class="col text-right p-0" style="font-size: 12px"><?php echo (int) $view->checkin->subscription_kr . '/' . (int) $view->checkin->subscription_max_kr ?></span>
                                    </div>
                                    <progress class="w-100" max="<?php echo (int) $view->checkin->subscription_max_kr ?>" value="<?php echo (int) $view->checkin->subscription_kr ?>"></progress>
                                </div>
                            </div>
                        </li>
					<?php } ?>

					<?php
					if ( isset( $view->checkin->subscription_max_serps ) && isset( $view->checkin->subscription_serps ) && (int) $view->checkin->subscription_max_serps > 0 ) {
						?>
                        <li class="m-0 p-0 py-3">
                            <div class="row m-0 p-0">
                                <div class="col-1 m-0 p-0 mr-1"><i class="fa-solid fa-chart-line"></i></div>
                                <div class="col m-0 p-0" style="line-height: 15px;">
                                    <div class="row m-0 p-0"><?php echo esc_html__( "SERP Lookups", "squirrly-seo" ) ?>
                                        <span class="col text-right p-0" style="font-size: 12px"><?php echo (int) $view->checkin->subscription_serps . '/' . (int) $view->checkin->subscription_max_serps ?></span>
                                    </div>
                                    <progress class="w-100" max="<?php echo (int) $view->checkin->subscription_max_serps ?>" value="<?php echo (int) $view->checkin->subscription_serps ?>"></progress>
                                </div>
                            </div>
                        </li>
					<?php } ?>



					<?php if ( isset( $view->checkin->subscription_limits_reset ) && $view->checkin->subscription_limits_reset <> '' && strtotime( $view->checkin->subscription_limits_reset ) > time() ) { ?>
                        <li class="m-0 p-0 py-2 text-center">
							<?php echo esc_html__( "Reset day", "squirrly-seo" ) ?>:
                            <span class="col text-left p-0 font-weight-bold"><?php echo esc_html( wp_date( get_option( 'date_format' ), strtotime( $view->checkin->subscription_limits_reset ) ) ) ?></span>
                        </li>
					<?php } ?>
                </ul>
            </div>

            <div class="border-top py-2 px-3 mt-2 text-center">
                <div class="small">
                    <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'dashboard' ) ) ?>" target="_blank"><?php echo esc_html__( "Want to hide this section from your customers?", "squirrly-seo" ) ?></a>
                </div>
            </div>

            <div class="my-3 mx-4">
                <div class="row p-0 m-0 my-3">
                    <div class="col-1 m-0 p-0 mr-2"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                    <div class="col m-0 p-0">
                        <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'plans' ) ) ?>" target="_blank"><?php echo esc_html__( "Upgrade your account", "squirrly-seo" ) ?></a>
                    </div>
                </div>
                <div class="row p-0 m-0 my-3">
                    <div class="col-1 m-0 p-0 mr-2"><i class="fa-solid fa-wallet"></i></div>
                    <div class="col m-0 p-0">
                        <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) ) ?>" target="_blank"><?php echo esc_html__( "Billing info", "squirrly-seo" ) ?></a>
                    </div>
                </div>
                <div class="row p-0 m-0 my-3">
                    <div class="col-1 m-0 p-0 mr-2"><i class="fa-solid fa-gear"></i></div>
                    <div class="col m-0 p-0">
                        <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'profile' ) ) ?>" target="_blank"><?php echo esc_html__( "Account settings", "squirrly-seo" ) ?></a>
                    </div>
                </div>
                <div class="row p-0 m-0 my-3">
                    <div class="col-1 m-0 p-0 mr-2"><i class="fa-solid fa-cloud"></i></div>
                    <div class="col m-0 p-0">
                        <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'dashboard' ) ) ?>" target="_blank"><?php echo esc_html__( "Squirrly Cloud", "squirrly-seo" ) ?></a>
                    </div>
                </div>
                <div class="row p-0 m-0 my-3">
                    <div class="col-1 m-0 p-0 mr-2"><i class="fa-solid fa-cloud"></i></div>
                    <div class="col m-0 p-0">
                        <a href="<?php echo esc_url( _SQ_SUPPORT_URL_ ) ?>" target="_blank"><?php echo esc_html__( "Support", "squirrly-seo" ) ?></a>
                    </div>
                </div>

                <div class="row p-0 m-0 my-3">
                    <div class="col-1 m-0 p-0 mr-2"><i class="fa-solid fa-sign-out"></i></div>
                    <div class="col m-0 p-0">
                        <form method="post" class="p-0 m-0">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_account_disconnect', 'sq_nonce' ); ?>
                            <input type="hidden" name="action" value="sq_account_disconnect"/>
                            <button type="submit" class="btn text-primary btn-link bg-transparent p-0 m-0">
								<?php echo esc_html__( "Disconnect", "squirrly-seo" ) ?>
                            </button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
<?php }
