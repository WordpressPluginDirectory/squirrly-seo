<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * METAs view
 *
 * Called from Settings Controller
 */
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
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">

				<?php do_action( 'sq_form_notices' ); ?>
                <form method="POST">
					<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_save', 'sq_nonce' ); ?>
                    <input type="hidden" name="action" value="sq_seosettings_save"/>

                    <div class="col-12 p-0 m-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                        <h3 class="mt-4 card-title">
							<?php echo esc_html__( "SEO METAs", 'squirrly-seo' ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/seo-metas/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                            </div>
                        </h3>
                        <div class="col-7 small m-0 p-0">
							<?php echo esc_html__( "Add all Search Engine METAs like Title, Description, Canonical Link, Dublin Core, Robots and more.", 'squirrly-seo' ); ?>
                        </div>

						<?php $view->show_view( 'Blocks/SubMenuHeader' ); ?>
                        <div class="d-flex flex-row p-0 m-0 bg-white">
							<?php $view->show_view( 'Blocks/SubMenu' ); ?>

                            <div class="d-flex flex-column flex-grow-1 m-0 p-0">
                                <div id="onpage" class="col-12 py-0 px-4 m-0 tab-panel tab-panel-first active">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Manage On-Page SEO Metas", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/seo-metas/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_title" value="0"/>
                                                    <input type="checkbox" id="sq_auto_title" name="sq_auto_title" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_title" class="ml-1"><?php echo esc_html__( "Optimize the Titles", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Optimize-The-Titles" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "If you switch off this option, Squirrly will add noindex mAdd the Title Tag in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.eta for this post type.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_description" value="0"/>
                                                    <input type="checkbox" id="sq_auto_description" name="sq_auto_description" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_description" class="ml-1"><?php echo esc_html__( "Optimize Descriptions", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Optimize-The-Description" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Description meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_keywords" value="0"/>
                                                    <input type="checkbox" id="sq_auto_keywords" name="sq_auto_keywords" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_keywords' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_keywords" class="ml-1"><?php echo esc_html__( "Optimize Keywords", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Optimize-Keywords" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Keyword meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "This meta is not mandatory for Google but other search engines still use it for ranking", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_canonical" value="0"/>
                                                    <input type="checkbox" id="sq_auto_canonical" name="sq_auto_canonical" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_canonical' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_canonical" class="ml-1"><?php echo esc_html__( "Add Canonical Meta Link", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-Canonical-Meta-Link" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add Canonical Link META in the page header. You can customize the canonical link on each page.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Also add prev & next links METAs in the page header when navigate between blog pages.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_dublincore" value="0"/>
                                                    <input type="checkbox" id="sq_auto_dublincore" name="sq_auto_dublincore" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_dublincore' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_dublincore" class="ml-1"><?php echo esc_html__( "Add Dublin Core Meta", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-Dublin-Core-Meta" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Dublin Core meta in the page header.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_noindex" value="0"/>
                                                    <input type="checkbox" id="sq_auto_noindex" name="sq_auto_noindex" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_noindex" class="ml-1"><?php echo esc_html__( "Add Robots Meta", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-Robots-Meta" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Index/Noindex and Follow/Nofollow options in Squirrly SEO Snippet.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add googlebot and bingbot METAs for better performance.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_metas_onpage_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>

                                </div>
                                <div id="settings" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "More SEO Settings", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_keywordtag" value="0"/>
                                                    <input type="checkbox" id="sq_keywordtag" name="sq_keywordtag" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_keywordtag' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_keywordtag" class="ml-1"><?php echo esc_html__( "Add the Post tags in Keyword META", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-The-Post-Tags-in-Keyword-Meta" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add all the tags from your posts as keywords. Not recommended when you use Keywords in Squirrly SEO Snippet.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_use_frontend" value="0"/>
                                                    <input type="checkbox" id="sq_use_frontend" name="sq_use_frontend" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_use_frontend' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_use_frontend" class="ml-1"><?php echo esc_html__( "Activate SEO Snippet in Frontend", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-Snippet-in-Frontend" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Load Squirrly SEO Snippet in Frontend to customize the SEO directly from page preview.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_metas_settings_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="advanced" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Advanced Settings", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
										<?php $metas = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'sq_metas' ) ) ); ?>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_metas_title_maxlength"><?php echo esc_html__( "Title Length", 'squirrly-seo' ); ?>
                                                    :
                                                    <a href="https://howto12.squirrly.co/kb/seo-metas/#lengths" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                            </div>
                                            <div class="col-6 p-0 input-group input-group-sm">
                                                <input id="sq_metas_title_maxlength" type="text" class="form-control bg-input" name="sq_metas[title_maxlength]" value="<?php echo (int) $metas->title_maxlength ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_metas_description_maxlength"><?php echo esc_html__( "Description Length", 'squirrly-seo' ); ?>
                                                    :
                                                    <a href="https://howto12.squirrly.co/kb/seo-metas/#lengths" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                            </div>
                                            <div class="col-6 p-0 input-group input-group-sm">
                                                <input id="sq_metas_description_maxlength" type="text" class="form-control bg-input" name="sq_metas[description_maxlength]" value="<?php echo (int) $metas->description_maxlength ?>"/>
                                            </div>
                                        </div>

										<?php do_action( 'sq_metas_advanced_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </form>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo sprintf( esc_html__( "Use the %s SEO Automation %s to setup SEO Patterns based on Post Types for global optimization.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) ) . '">', '</a>' ); ?></li>
                        <li class="text-left"><?php echo sprintf( esc_html__( "Use %s Bulk SEO %s to optimize the SEO Snippet for each page on your website.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) ) . '">', '</a>' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
