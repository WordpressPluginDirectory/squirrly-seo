<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Audit Settings view
 *
 * Called from Audits Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
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

                <form method="POST">
					<?php do_action( 'sq_form_notices' ); ?>
					<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_audits_settings', 'sq_nonce' ); ?>
                    <input type="hidden" name="action" value="sq_audits_settings"/>

                    <div class="col-12 p-0 m-0">

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                        <h3 class="mt-4 card-title">
							<?php echo esc_html__( "Audit Settings", "squirrly-seo" ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#seo_audit_settings" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                            </div>
                        </h3>

                        <div id="sq_auditsettings" class="col-12 p-0 m-0">
                            <div class="col-12 m-0 p-0">
                                <div class="col-12 row p-0 m-0 my-5">
                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                        <label for="sq_audit_email"><?php echo esc_html__( "Audit Email", "squirrly-seo" ); ?>
                                            :</label>
                                        <div class="small text-black-50 my-1"><?php echo esc_html__( "Enter the email address on which you want to receive the weekly audits.", "squirrly-seo" ); ?></div>
                                    </div>
                                    <div class="col-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" id="sq_audit_email" name="sq_audit_email" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getOption( 'sq_audit_email' ) ) ?>"/>
                                    </div>
                                </div>

                            </div>

							<?php do_action( 'sq_audit_settings_after' ); ?>

                            <div class="col-12 m-0 p-0">
                                <button type="submit" class="btn rounded-0 btn-primary btn-lg py-2 px-5"><?php echo esc_html__( "Save Settings", "squirrly-seo" ); ?></button>
                            </div>
                        </div>

                    </div>


                </form>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_audit_settings_side_after' ); ?>

                </div>
            </div>
        </div>

    </div>
</div>
