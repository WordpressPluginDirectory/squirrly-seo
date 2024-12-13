<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Top Notice view
 *
 */
?>
<div id="sq_wrap" class="sq_overview">
		<?php $view->show_view( 'Blocks/Toolbar' ); ?>

		<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_onboarding' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_notification' ) ) {
			if ( isset( $view->checkin->notification ) && $view->checkin->notification <> '' ) {
				echo $view->checkin->notification;
			}
		} ?>

        <div class="d-flex flex-row bg-white my-0 p-0 m-0">

			<?php $view->show_view( 'Blocks/Menu' ); ?>

            <div class="sq_flex flex-grow-1 bg-light m-0 p-0 px-4">

                <?php

                $report_time = SQ_Classes_Helpers_Tools::getOption( 'seoreport_time' );
                if ( ! $report_time || ( time() - (int) $report_time ) > ( 3600 * 12 ) ) {
	                ?>
                    <script>
                        (function ($) {
                            $(document).ready(function () {
                                $('#sq_wrap').sq_CheckSEO().processGoals();
                            });
                        })(jQuery);
                    </script>
                    <?php
                }

                if ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seogoals' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_onboarding' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_notification' ) ) {
                    $tasks_incompleted = SQ_Classes_ObjController::getClass( 'SQ_Controllers_CheckSeo' )->getNotifications();
                    if( !empty( $tasks_incompleted ) ) {

	                    $tasks_incompleted = array_filter(array_map(function($row){
                            if ( in_array( $row['status'], array( 'completed', 'done', 'ignore' ) ) ) {
                                return false;
                            }
                            return $row;
                        }, $tasks_incompleted));

                        ?>
                        <nav id="sq_notification" class="navbar p-0 m-0 mt-3 py-2 bg-white">
                            <div class="container-fluid p-0 m-0">
                                <div class="justify-content-start col p-0 m-0 px-3" id="navigation">
                                    <div class="col p-0 m-0 text-dark" style="font-size: 0.8rem"><?php echo sprintf( esc_html__('The AI SEO Consultant has %s Action Items you should check to improve your rankings right away.', 'squirrly-seo'), '<span style="display: inline;color: white;background: red;border-radius: 25%;padding: 3px 7px;">'.count((array)$tasks_incompleted).'</span>') ?></div>
                                </div>
                                <div class="justify-content-end p-0 m-0">
                                    <div class="col p-0 m-0 mr-3">
                                        <a href="<?php echo esc_url(SQ_Classes_Helpers_Tools::getAdminUrl('sq_checkseo')) ?>" class="btn btn-sm btn-primary p-1 px-3 m-0" >See Next SEO Goals from AI Consultant</a>
                                        <span class="sq_save_ajax">
                                            <button class="btn btn-link p-1 px-3 m-0 " data-action="sq_ajax_seosettings_save" data-name="sq_notification" data-value="0" data-javascript="$('#sq_notification').hide();">x</button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </nav>
                    <?php }?>
                <?php }?>

                <div class="d-flex flex-row bg-white m-0 mt-5 p-0">
                    <div class="col-6 p-0 p-5 m-0" style="background: linear-gradient( rgba(100, 100, 100, 0.6), rgba(50, 50, 50, 1) ), url('<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/aisq.jpeg' ) ?>'); background-repeat: no-repeat; background-position: center center; background-size: cover; min-height: 400px">
                        <div class="m-0 p-0 shadow-0 rounded-0" >
                            <div class="col-12 d-flex align-items-center m-0 p-0">
                                <div class="p-0 m-0 mb-5">
                                    <h3 class="p-0 m-0 font-weight-bold text-white">
					                    <?php echo esc_html__( "Configure your SEO", "squirrly-seo" ) ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="col-12 d-flex align-items-center m-0 p-0 mt-4">
                                <div class="p-0 m-0 mb-5 text-white">
	                                <?php echo esc_html__( "Launch our installation wizard to quickly and easily configure the basic SEO Settings for your site.", "squirrly-seo" ) ?>
                                </div>
                            </div>

                            <div class="col-12 d-flex align-items-center m-0 p-0 mt-5">
                                <a class="col-12 btn bg-white text-dark" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding') ) ?>" style="text-decoration: none">
				                    <?php echo esc_html__( "Setup in 5 mins!", "squirrly-seo" ) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-4">
                        <div class="col-12 m-0 p-0 shadow-0 rounded-0">
                            <h3 class="p-0 m-0">
			                    <?php echo esc_html__( "Squirrly SEO Suite", "squirrly-seo" ) ?>:
                            </h3>
                            <div>
			                    <?php echo esc_html__( "The Only Holistic SEO Plugin on the market covers and replaces many SEO software you would buy for your site", "squirrly-seo" ) ?>:
                            </div>
                        </div>

                        <div class="col-12 m-0 p-0 mt-2">
                            <div class="card px-3 py-1 mx-0 my-2">
                                <div class="card-body p-0 m-0">
                                    <div class="row p-0 m-0">
                                        <div class="py-2 px-0 m-0"><img src="https://ps.w.org/squirrly-seo/assets/icon-256x256.png" style="width: 50px"></div>
                                        <div class="col p-0 px-3 m-0">
                                            <div class="font-weight-bold">Squirrly SEO Free</div>
                                            <div class="text-success"><?php echo esc_html__( "Active", "squirrly-seo" ) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card px-3 py-1 mx-0 my-2">
                                <div class="card-body p-0 m-0">
                                    <div class="row p-0 m-0">
                                        <div class="py-2 px-0 m-0"><img src="https://ps.w.org/squirrly-seo/assets/icon-256x256.png" style="width: 50px" ></div>
                                        <div class="col p-0 px-3 m-0">
                                            <div class="font-weight-bold">Premium Plan for Squirrly SEO</div>
					                        <?php
					                        if ( isset( $view->checkin->subscription_status ) && $view->checkin->subscription_status == 'active' ){ ?>
                                                <div class="text-success"><?php echo esc_html__( "Active", "squirrly-seo" ) ?></div>
					                        <?php }else{ ?>
                                                <div class="row p-0 m-0">
                                                    <div class="text-danger"><?php echo esc_html__( "Inactive", "squirrly-seo" ) ?></div>
                                                    <a href="https://plugin.squirrly.co/wordpress-seo-pricing/" class="btn btn-sm btn-primary p-0 m-0 px-2 mx-3 font-weight-normal" style="min-width: 250px" target="_blank"><?php echo esc_html__( "Upgrade", "squirrly-seo" ) ?> <i class="dashicons dashicons-external" style="font-size:12px;vertical-align:-2px;height:10px;"></i></a>
                                                </div>
                                                <div class="text-black-50" style="font-size: 11px;"><?php echo esc_html__( "(upgrade is made on the SaaS side. No plugin re-install required)", "squirrly-seo" ) ?></div>
					                        <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card px-3 py-1 mx-0 my-2">
                                <div class="card-body p-0 m-0">
                                    <div class="row p-0 m-0">
                                        <div class="py-2 px-0 m-0"><img src="https://ps.w.org/squirrly-seo/assets/icon-256x256.png" style="width: 50px; font-size: invert(1);"></div>
                                        <div class="col p-0 px-3 m-0">
                                            <div class="font-weight-bold">Advanced Pack by Squirrly SEO</div>
					                        <?php if(SQ_Classes_Helpers_Tools::isPluginInstalled('squirrly-seo-pack/index.php')){ ?>
                                                <div class="text-success"><?php echo esc_html__( "Active", "squirrly-seo" ) ?></div>
					                        <?php }else{ ?>
                                                <form method="post" class="col-12 row p-0 m-0">
							                        <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_advanced_install', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_advanced_install"/>
                                                    <div class="text-danger p-0 m-0"><?php echo esc_html__( "Inactive", "squirrly-seo" ) ?></div>
                                                    <button type="submit" class="btn btn-sm btn-primary p-0 m-0 px-3 mx-3 font-weight-normal" style="min-width: 250px;">
								                        <?php echo esc_html__( "Install now with one click. It's free.", 'squirrly-seo' ) ?>
                                                    </button>
                                                </form>
					                        <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-0 m-0 py-3 ">
		                        <?php if ( !SQ_Classes_Helpers_DevKit::getOption( 'sq_auto_devkit' ) ) { ?>
                                    <span class="font-weight-bold"><?php echo esc_html__( "Do you have SEO clients?", "squirrly-seo" ) ?></span>
                                    <a href="https://howto12.squirrly.co/kb/web-dev-kit-all-plugin-customization-options/" class="p-0 m-0 mx-2 font-weight-normal" target="_blank"><?php echo esc_html__( "learn how to configure different packages for them and customize their experience. Your clients will love your agency more!", "squirrly-seo" ) ?> <i class="dashicons dashicons-external" style="font-size:12px;vertical-align:-2px;height:10px;"></i></a>
		                        <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>

				<?php
				$page = SQ_Classes_Helpers_Tools::getValue( 'page' );
				$tabs = SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getTabs( $page );

				foreach ( $tabs as $id => $tab ) {
					if ( $tab['show'] ) {
						if ( isset( $tab['function'] ) && $tab['function'] ) {
							$name = explode( '/', $id );
							if ( isset( $name[1] ) ) {
								echo '<div class="sq_breadcrumbs mt-5">' . SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getBreadcrumbs( $name[1] ) . '</div>';
							}
							call_user_func( $tab['function'] );
						}
					}
				}
				?>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

        </div>
    </div>

<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_mode' ) && ! SQ_Classes_Helpers_Tools::getOption( 'sq_onboarding' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ) ) { ?>
    <div id="sq_onboarding_modal" tabindex="-1" class="modal" role="dialog">
        <div class="modal-dialog" style="max-width: 100%; margin: 110px 24px;">
            <div class="modal-content bg-white rounded-0" style="width: 958px; margin: 0 0 auto auto;">
                <div class="modal-header">
                    <div class="row col-12 m-0 p-0">
                        <div class="m-0 p-0 align-middle"><i class="sq_logo sq_logo_30"></i></div>
                        <div class="col-11 m-0 px-3 align-middle text-left">
                            <h5 class="modal-title">
                                <?php echo sprintf( esc_html__( "First, you need to activate the %s recommended mode %s or the %s expert mode %s!", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding' ) ) . '">', '</a>', '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding' ) ) . '">', '</a>' ); ?>
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding' ) ) ?>" class="btn btn-sm btn-primary ml-3"><?php echo esc_html__( "Let's do this", "squirrly-seo" ); ?>
                                </a>
                            </h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function ($) {
            $(document).ready(function () {
                $("#sq_onboarding_modal").modal({backdrop: 'static', keyboard: false});
            });
        })(jQuery);
    </script>

<?php } ?>