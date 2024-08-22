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
                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_onpagesetup' ) ?></div>

                    <form id="sq_onboarding_form" method="post" action="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'step2' ) ) ?>" class="p-0 m-0">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_onboarding_save', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_onboarding_save"/>
                        <input type="hidden" name="sq_mode" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getOption( 'sq_mode' ) ) ?>"/>

                        <div class="col-12 p-0 m-0 my-5 text-center">
                            <div class="group_autoload d-flex justify-content-center btn-group btn-group-lg mt-3" role="group">
                                <button type="button" class="btn btn-outline-info m-1 py-4 px-4 sq_no_seo <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_mode' ) == 0 ) ? 'active' : '' ) ?>"><?php echo esc_html__( "No SEO Configuration", 'squirrly-seo' ); ?></button>
                                <button type="button" class="btn btn-outline-info m-1 py-4 px-4 sq_recommended_seo <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_mode' ) == 1 ) ? 'active' : '' ) ?>"><?php echo esc_html__( "SEO Recommended Mode", 'squirrly-seo' ); ?></button>
                                <button type="button" class="btn btn-outline-info m-1 py-4 px-4 sq_expert_seo <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_mode' ) == 2 ) ? 'active' : '' ) ?>"><?php echo esc_html__( "SEO Expert Mode", 'squirrly-seo' ); ?></button>

                                <script>
                                    (function ($) {

                                        $(document).ready(function () {

                                            $(".sq_no_seo").on('click', function () {
                                                $('input[name=sq_mode]').val('0');
                                                $('#sq_onboarding_form').submit();
                                            });

                                            $(".sq_recommended_seo").on('click', function () {
                                                $('input[name=sq_mode]').val('1');
                                                //$('#sq_onboarding_recommended').modal('show');
                                                $('#sq_onboarding_form').submit();
                                            });

                                            $(".sq_expert_seo").on('click', function () {
                                                $('input[name=sq_mode]').val('2');
                                                $('#sq_onboarding_form').submit();
                                            });

                                        });
                                    })(jQuery);
                                </script>

                            </div>
                            <div class="col-12 p-0 m-0 my-3 text-center">
                                <div class="card-title text-center"><?php echo esc_html__( "If you have already configured the Squirrly SEO plug in on a different site.", 'squirrly-seo' ); ?></div>
                            </div>
                            <div class="col-12 p-0 m-0 my-3 text-center">
                                <div class="card-title text-center">
                                    <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/" target="_blank"><?php echo esc_html__( "Learn how you can import the same settings on this site as well", 'squirrly-seo' ); ?>
                                        >></a></div>
                            </div>
                        </div>
                    </form>

					<?php if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'wordpress-seo/wp-seo.php' ) ) { ?>
                        <div class="text-center">
                            <a href="https://completeseofunnel.com/yoast-alternative/" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/sq-vs-yoast.png' ) ?>" alt="" style="width: 900px; max-width: 100%;"></a>
                        </div>
					<?php } elseif ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'seo-by-rank-math/rank-math.php' ) ) { ?>
                        <div class="text-center">
                            <a href="https://completeseofunnel.com/rankmath-alternative/" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/sq-vs-rank-math.png' ) ?>" alt="" style="width: 900px; max-width: 100%;"></a>
                        </div>
					<?php } elseif ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'wp-seopress/seopress.php' ) ) { ?>
                        <div class="text-center">
                            <a href="https://completeseofunnel.com/seopress-alternative/" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/sq-vs-seo-press.png' ) ?>" alt="" style="width: 900px; max-width: 100%;"></a>
                        </div>
					<?php } elseif ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) || SQ_Classes_Helpers_Tools::isPluginInstalled( 'all-in-one-seo-pack-pro/all_in_one_seo_pack.php' ) ) { ?>
                        <div class="text-center">
                            <a href="https://completeseofunnel.com/allinoneseo-alternative/" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/sq-vs-all-in-one-seo.png' ) ?>" alt="" style="width: 900px; max-width: 100%;"></a>
                        </div>
					<?php } ?>

                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
        </div>
    </div>
</div>

<div id="sq_onboarding_recommended" tabindex="-1" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-white rounded-0">
            <div class="modal-header">
                <div class="row col-12 m-0 p-0">
                    <div class="m-0 p-0 align-middle"><i class="sq_logo sq_logo_30"></i></div>
                    <div class="col-11 m-0 px-3 align-middle text-left">
                        <h5 class="modal-title"><?php echo esc_html__( "What will be activated", 'squirrly-seo' ); ?>
                            :</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">
				<?php echo esc_html__( 'Squirrly Sitemap XML', 'squirrly-seo' ) ?>
            </div>
            <div class="modal-footer" style="border-bottom: 1px solid #ddd;">
                <button type="button" class="btn btn-link text-black-50" onclick="jQuery('#sq_onboarding_recommended').modal('hide');"><?php echo esc_html__( "Cancel", 'squirrly-seo' ); ?></button>
                <button type="button" class="btn btn-primary" onclick="jQuery('#sq_onboarding_form').submit();"><?php echo esc_html__( "Continue", 'squirrly-seo' ); ?></button>
            </div>
        </div>
    </div>
</div>
