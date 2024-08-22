<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Error view
 *
 */
?>
<?php
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-reboot' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>

        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>

                    <div id="sq_onboarding" class="col-6 my-0 mx-auto p-0">

                        <div class="col-12 p-0 m-0 mt-5 mb-3 text-center">
                            <div class="group_autoload d-flex justify-content-center btn-group btn-group-lg mt-3" role="group">
                                <div class="font-weight-bold" style="font-size: 1.2rem">
                                    <span class="sq_logo sq_logo_30 align-top mr-2"></span><?php echo esc_html__( "Squirrly SEO - Advanced Pack", 'squirrly-seo' ); ?>
                                </div>
                            </div>
                            <div class="text-center mt-4"><?php echo esc_html__( "This amazing feature isn't included in the basic plugin. Want to unlock it? Simply install or activate the Squirrly SEO - Advanced Pack and enjoy the full range of capabilities.", 'squirrly-seo' ); ?>
                                :
                            </div>
                            <div class="text-center mt-4"><?php echo esc_html__( "Let's take your SEO to the next level!", 'squirrly-seo' ); ?></div>
                        </div>


                        <div class="col-12 row m-0 p-0 my-5 text-center">
                            <form method="post" class="col-12 p-0 m-0">
								<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_advanced_install', 'sq_nonce' ); ?>
                                <input type="hidden" name="action" value="sq_advanced_install"/>
                                <button type="submit" class="btn btn-primary">
									<?php echo esc_html__( "Install/Activate Squirrly SEO - Advanced Pack", 'squirrly-seo' ) ?>
                                </button>
                            </form>
                            <div class="col-12 text-center mt-4">
                                <div class="col-8 text-black-50 small mx-auto"><?php echo esc_html__( "(* the plugin has no extra cost, gets installed / activated automatically inside WP when you click the button, and uses the same account)", 'squirrly-seo' ); ?></div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
