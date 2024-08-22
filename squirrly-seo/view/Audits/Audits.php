<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Main Audit Page view
 *
 * Called from Audits Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php $view->loadScripts(); ?>

	<?php do_action( 'sq_notices' ); ?>

    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", "squirrly-seo" ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?></div>
                    <h3 class="mt-4">
						<?php echo esc_html__( "SEO Audits", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/seo-audit/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small m-0 p-0">
						<?php echo esc_html__( "Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic", "squirrly-seo" ); ?>
                    </div>

                    <div id="sq_audits" class="col-12 m-0 p-0 border-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

                        <div class="col-12 m-0 p-0 my-5">
                            <div class="card-content sq_auditstatus_content m-0">
								<?php $view->show_view( 'Audits/AuditStats' ); ?>
                            </div>
                        </div>

						<?php do_action( 'sq_audits_stats_after' ); ?>

                    </div>

                    <div class="col-12 m-0 p-0 my-5">
                        <div class="sq_auditpages_content">
							<?php $view->show_view( 'Audits/AuditPages' ); ?>
                        </div>
                    </div>

					<?php do_action( 'sq_audits_after' ); ?>

                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
                        <li class="text-left small"><?php echo esc_html__( "At a page level, you can request a new audit once an hour, by clicking on the corresponding three vertical dots and then clicking on Request New Audit.", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "Every page that you add to the Audit can also be verified manually by clicking on the corresponding three vertical dots and then clicking on Inspect URL.", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "This will open a report that will show you if you managed to fix certain issues for that page.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>
            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_audits_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="sq_previewurl_modal" tabindex="-1" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 100% !important;">
        <div class="modal-content bg-white rounded-0">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo esc_html__( "Squirrly Inspect URL", "squirrly-seo" ); ?></h4>
                <i class="fa-solid fa-refresh" style="font-family: FontAwesome, Arial, sans-serif;font-size: 20px !important;cursor: pointer;margin: 7px 10px !important;" onclick="jQuery('#sq_previewurl_modal').sq_inspectURL()"></i>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="min-height: 200px; height:calc(100vh - 120px); overflow-y: auto;">
            </div>
        </div>
    </div>
</div>
