<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Automation > Settings view
 *
 * Called from Automation Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", "squirrly-seo" ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">
					<?php $metas = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'sq_metas' ) ) ); ?>
                    <form method="POST">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_automation', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_seosettings_automation"/>

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                        <h3 class="mt-4 card-title">
							<?php echo esc_html__( "META Lengths", "squirrly-seo" ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" target="_blank"><i class="fa-solid fa-question-circle" style="margin: 0;"></i></a>
                            </div>
                        </h3>
                        <div class="col-7 small m-0 p-0">
							<?php echo esc_html__( "Change the lengths for each META on automation", "squirrly-seo" ); ?>
                        </div>

                        <div class="col-12 p-0 m-0 my-5">

                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="title_maxlength"><?php echo esc_html__( "Title Length", "squirrly-seo" ); ?>
                                        :
                                        <a href="https://howto12.squirrly.co/kb/seo-automation/#automation_custom_lengths" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                </div>
                                <div class="col-6 p-0 input-group input-group-sm">
                                    <input id="title_maxlength" type="text" class="form-control bg-input" name="sq_metas[title_maxlength]" value="<?php echo (int) $metas->title_maxlength ?>"/>
                                </div>
                            </div>

                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="description_maxlength"><?php echo esc_html__( "Description Length", "squirrly-seo" ); ?>
                                        :
                                        <a href="https://howto12.squirrly.co/kb/seo-automation/#automation_custom_lengths" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                </div>
                                <div class="col-6 p-0 input-group input-group-sm">
                                    <input id="description_maxlength" type="text" class="form-control bg-input" name="sq_metas[description_maxlength]" value="<?php echo (int) $metas->description_maxlength ?>"/>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="og_title_maxlength"><?php echo esc_html__( "Open Graph Title Length", "squirrly-seo" ); ?>
                                        :</label>
                                </div>
                                <div class="col-6 p-0 input-group input-group-sm">
                                    <input id="og_title_maxlength" type="text" class="form-control bg-input" name="sq_metas[og_title_maxlength]" value="<?php echo (int) $metas->og_title_maxlength ?>"/>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="og_description_maxlength"><?php echo esc_html__( "Open Graph Description Length", "squirrly-seo" ); ?>
                                        :</label>
                                </div>
                                <div class="col-6 p-0 input-group input-group-sm">
                                    <input id="og_description_maxlength" type="text" class="form-control bg-input" name="sq_metas[og_description_maxlength]" value="<?php echo (int) $metas->og_description_maxlength ?>"/>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="tw_title_maxlength"><?php echo esc_html__( "Twitter Card Title Length", "squirrly-seo" ); ?>
                                        :</label>
                                </div>
                                <div class="col-6 p-0 input-group input-group-sm">
                                    <input id="tw_title_maxlength" type="text" class="form-control bg-input" name="sq_metas[tw_title_maxlength]" value="<?php echo (int) $metas->tw_title_maxlength ?>"/>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="tw_description_maxlength"><?php echo esc_html__( "Twitter Card Description Length", "squirrly-seo" ); ?>
                                        :</label>
                                </div>
                                <div class="col-6 p-0 input-group input-group-sm">
                                    <input id="tw_description_maxlength" type="text" class="form-control bg-input" name="sq_metas[tw_description_maxlength]" value="<?php echo (int) $metas->tw_description_maxlength ?>"/>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="jsonld_title_maxlength"><?php echo esc_html__( "JSON-LD Title Length", "squirrly-seo" ); ?>
                                        :</label>
                                </div>
                                <div class="col-6 m-0 p-0 input-group input-group-sm">
                                    <input id="jsonld_title_maxlength" type="text" class="form-control bg-input" name="sq_metas[jsonld_title_maxlength]" value="<?php echo (int) $metas->jsonld_title_maxlength ?>"/>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="col-4 m-0 p-0 font-weight-bold">
                                    <label for="jsonld_description_maxlength"><?php echo esc_html__( "JSON-LD Description Length", "squirrly-seo" ); ?>
                                        :</label>
                                </div>
                                <div class="col-6 m-0 p-0 input-group input-group-sm">
                                    <input id="jsonld_description_maxlength" type="text" class="form-control bg-input" name="sq_metas[jsonld_description_maxlength]" value="<?php echo (int) $metas->jsonld_description_maxlength ?>"/>
                                </div>
                            </div>

							<?php do_action( 'sq_automation_settings_after' ); ?>

                            <div class="col-12 m-0 p-0 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", "squirrly-seo" ); ?></button>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "There have been several occasions in which platforms like Google and Twitter have increased their Description length limit and even the META Title length limit.", "squirrly-seo" ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Squirrly SEO offers you full customization of the META lengths so that you don’t have to wait for plugin updates when these sort of things happen, and if Twitter, for example, decides to increase the number of characters it will display for a post’s description when shared on their platform.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_automation_settings_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
