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

                        <div class="col-12 p-0 m-0 mt-5 mb-3 text-center">
                            <div class="group_autoload d-flex justify-content-center btn-group btn-group-lg mt-3" role="group">
                                <div class="font-weight-bold" style="font-size: 1.2rem">
                                    <span class="sq_logo sq_logo_30 align-top mr-2"></span><?php echo esc_html__( "Your site is now ready for Search Engines!", 'squirrly-seo' ); ?>
                                </div>
                            </div>
                            <div class="text-center mt-4"><?php echo esc_html__( "Watch the video below to get a quick introduction to Squirrly SEO. The short video shows what you can find in each section (where you can find the Next SEO Goals, Focus Pages, Rankings, and more).", 'squirrly-seo' ); ?>
                                :
                            </div>
                        </div>

                        <div class="col-12 m-0 p-0 my-5">
                            <iframe width="800" height="500" src="https://www.youtube.com/embed/3q2g4kx1jrA" title="YouTube video player" style="width: 100%; height: 500px;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>

                        <div class="col-12 row m-0 p-0 my-5">
                            <div class="col m-0 p-0 text-center">
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php?post_type=post&keyword=' . SQ_Classes_Helpers_Tools::getValue( 'keyword', '' ) ) ) ?>" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "SEO Beginner: Start Here", 'squirrly-seo' ); ?>
                                    > </a>
                            </div>
                            <div class="col m-0 p-0 text-center">
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings' ) ) ?>" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "SEO Expert: Start Here", 'squirrly-seo' ); ?>
                                    > </a>
                            </div>
                        </div>

                    </div>

                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
        </div>
    </div>
</div>

