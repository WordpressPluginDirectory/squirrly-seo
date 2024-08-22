<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Focus Page List view
 *
 * Called from Focus Page Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php $view->loadScripts(); ?>
	<?php do_action( 'sq_notices' ); ?>

    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4 pb-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?><?php if ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>
                            <i class="text-black-50 mx-1">/</i> <?php echo esc_html__( "Focus Pages Details", 'squirrly-seo' ); ?><?php } ?>
                    </div>
                    <h3 class="mt-4">
						<?php echo esc_html__( "Focus Pages", 'squirrly-seo' ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small m-0 p-0">
						<?php echo esc_html__( "Focus Pages bring you clear methods to take your pages from never found to always found on Google. Rank your pages by influencing the right ranking factors. Turn everything that you see here to Green and you will win.", 'squirrly-seo' ); ?>
                    </div>

                    <div id="sq_focuspages" class="col-12 m-0 p-0 border-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

						<?php
						//used for filtering the labels before calling the Focus pages ajax
						$keyword_labels = SQ_Classes_Helpers_Tools::getValue( 'slabel', array() );
						if ( ! is_array( $keyword_labels ) && $keyword_labels <> '' ) {
							$keyword_labels = explode( ',', $keyword_labels );
						}
						if ( ! empty( $keyword_labels ) ) {
							foreach ( $keyword_labels as $label ) {
								?>
                                <label for="sq_circle_label_input"></label>
                                <input id="sq_circle_label_input" type="checkbox" class="sq_circle_label_input" value="<?php echo esc_attr( $label ) ?>" checked="checked" style="display: none"/><?php
							}
						}
						?>
                        <div class="col-12 m-0 p-0 my-5">
                            <div class="sq_focuspages_content" style="min-height: 150px">
								<?php $view->show_view( 'FocusPages/FocusPages' ); ?>
                            </div>
                        </div>

						<?php do_action( 'sq_focuspages_after' ); ?>

                    </div>
                </div>

				<?php if ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>
                    <div class="sq_tips col-12 m-0 p-0 my-5">
                        <h5 class="text-left my-3 font-weight-bold">
                            <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                        </h5>
                        <ul class="mx-4 my-1">
                            <li class="text-left"><?php echo esc_html__( "Whether you’re reporting to a client, a superior, or your team, Squirrly makes it easy to showcase the fruits of your labor.", 'squirrly-seo' ); ?></li>
                            <li class="text-left"><?php echo esc_html__( "Take screenshots of the Progress and Achievements data or integrate them inside reports you create to show evidence of progress.", 'squirrly-seo' ); ?></li>
                            <li class="text-left"><?php echo esc_html__( "Improve productivity while building client trust and showing the impact of your work.", 'squirrly-seo' ); ?></li>
                            <li class="text-left"><?php echo esc_html__( "Use Squirrly-generated data to show how your campaigns have resulted in more traffic, engagement and how you’ve helped increase online visibility.", 'squirrly-seo' ); ?></li>
                        </ul>
                    </div>
				<?php } else { ?>
                    <div class="sq_tips col-12 m-0 p-0 my-5">
                        <h5 class="text-left my-3 font-weight-bold">
                            <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                        </h5>
                        <ul class="mx-4 my-1">
                            <li class="text-left"><?php echo esc_html__( "Focus Pages Business: Add maximum 10 page(s) in Focus Pages and request a new audit for each page every 5 mins.", 'squirrly-seo' ); ?></li>
                            <li class="text-left"><?php echo esc_html__( "Note: remember that it takes anywhere between 1 minute to 5 minutes to generate the new audit for a focus page. There is a lot of processing involved.", 'squirrly-seo' ); ?></li>
                        </ul>
                    </div>
				<?php } ?>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>
            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">

                    <div class="sq_focuspages_assistant"></div>

					<?php do_action( 'sq_focuspages_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="sq_previewurl_modal" tabindex="-1" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 100% !important;">
        <div class="modal-content bg-white rounded-0">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo esc_html__( "Squirrly Inspect URL", 'squirrly-seo' ); ?></h4>
                <i class="fa-solid fa-refresh" style="font-family: FontAwesome, Arial, sans-serif;font-size: 20px !important;cursor: pointer;margin: 7px 10px !important;" onclick="jQuery('#sq_previewurl_modal').sq_inspectURL()"></i>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="min-height: 200px; height:calc(100vh - 120px); overflow-y: auto;">
            </div>
        </div>
    </div>
</div>
