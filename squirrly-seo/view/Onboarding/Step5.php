<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>

    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>

        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">

                <div class="col-12 p-0 m-0 mb-5">
					<?php $view->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ); ?>

                    <div id="sq_onboarding" class="col-6 my-0 mx-auto p-0">
                        <form id="sq_onboarding_form" method="post" action="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'step6' ) ) ?>" class="p-0 m-0">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_onboarding_save' ); ?>
                            <input type="hidden" name="action" value="sq_onboarding_save"/>


                            <div class="col-12 p-0 m-0 mt-5 mb-3 text-center">
                                <div class="group_autoload d-flex justify-content-center btn-group btn-group-lg mt-3" role="group">
                                    <div class="font-weight-bold" style="font-size: 1.2rem">
                                        <span class="sq_logo sq_logo_30 align-top mr-2"></span><?php echo esc_html__( "Mention the topic of your site", 'squirrly-seo' ); ?>
                                        :
                                    </div>
                                </div>
                                <div class="text-center mt-4"><?php echo esc_html__( "What is your website about? ex: cleaning services", 'squirrly-seo' ); ?>
                                    :
                                </div>
                            </div>

                            <div class="col-12 m-0 p-0 my-5">
                                <label for="new_keyword"></label><input id="new_keyword" type="text" class="form-control sq_input_keyword" name="keyword" autofocus placeholder="<?php echo esc_attr__( "Write what your site is about...", 'squirrly-seo' ) ?>">
                            </div>

                            <div class="col-12 m-0 p-0 my-5 text-center">
                                <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save & Continue", 'squirrly-seo' ); ?>
                                    >>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

