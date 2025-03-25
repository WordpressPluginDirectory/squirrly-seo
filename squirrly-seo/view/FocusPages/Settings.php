<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Focus Page Settings view
 *
 * Called from Focus Page Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
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

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab', 'settings' ) ) ?></div>

	            <?php do_action( 'sq_form_notices' ); ?>

                <form method="POST">
					<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focus_pages_settings' ); ?>
                    <input type="hidden" name="action" value="sq_focus_pages_settings"/>

                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Focus Pages Settings", 'squirrly-seo' ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#settings" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>

                    <div id="sq_seosettings" class="col-12 p-0 m-0">

                        <div class="col-12 m-0 p-0 my-5">

                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="checker col-12 row m-0 p-0">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_auto_innelinks" value="0"/>
                                        <input type="checkbox" id="sq_auto_innelinks" name="sq_auto_innelinks" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_innelinks' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                        <label for="sq_auto_innelinks" class="ml-1"><?php echo esc_html__( "Use Inner Links Assistant", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#activate" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                        </label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Activate Inner Links to Focus Pages based on optimized keywords", 'squirrly-seo' ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 row p-0 m-0 my-5 sq_auto_innelinks sq_advanced">
                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                    <label for="sq_innelinks_links_per_keyword"><?php echo esc_html__( "Maximum Inner Links Per Keyword", 'squirrly-seo' ); ?>
                                        :</label>
                                    <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#max_links_per_keyword" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "The maximum number of keywords that will have links to a Focus Page once it is found.", 'squirrly-seo' ); ?></div>
                                </div>
                                <div class="col-2 p-0 input-group">
                                    <input id="sq_innelinks_links_per_keyword" type="number" name="sq_innelinks_links_per_keyword" class="form-control bg-input" value="<?php echo (int) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_links_per_keyword' ) ?>"/>
                                </div>
                            </div>

                            <div class="col-12 row p-0 m-0 my-5 sq_auto_innelinks sq_advanced">
                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                    <label for="sq_innelinks_links_per_target"><?php echo esc_html__( "Maximum Inner Links Per Target", 'squirrly-seo' ); ?>
                                        :</label>
                                    <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#max_links_per_target" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "The maximum number of links that will point to a Focus Page once a keyword is found.", 'squirrly-seo' ); ?></div>
                                </div>
                                <div class="col-2 p-0 input-group">
                                    <input id="sq_innelinks_links_per_target" type="number" name="sq_innelinks_links_per_target" class="form-control bg-input" value="<?php echo (int) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_links_per_target' ) ?>"/>
                                </div>
                            </div>

                            <div class="col-12 row m-0 p-0 my-5 sq_auto_innelinks sq_advanced">
                                <div class="checker col-12 row m-0 p-0">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_innelinks_link_nofollow" value="0"/>
                                        <input type="checkbox" id="sq_innelinks_link_nofollow" name="sq_innelinks_link_nofollow" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                        <label for="sq_innelinks_link_nofollow" class="ml-1"><?php echo esc_html__( "Default NoFollow Inner Links", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#nofollow" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                        </label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add re=nofollow by default to all inner links.", 'squirrly-seo' ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 row m-0 p-0 my-5 sq_auto_innelinks ">
                                <div class="checker col-12 row m-0 p-0">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_innelinks_link_blank" value="0"/>
                                        <input type="checkbox" id="sq_innelinks_link_blank" name="sq_innelinks_link_blank" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_blank' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                        <label for="sq_innelinks_link_blank" class="ml-1"><?php echo esc_html__( "Default Open Inner Links in New Tab", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#blank" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                        </label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Open all inner links in a new tab by default.", 'squirrly-seo' ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 row p-0 m-0 my-5 sq_auto_innelinks sq_advanced">
                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                    <label for="sq_innelinks_link_template"><?php echo esc_html__( "Linking Template", 'squirrly-seo' ); ?>
                                        :</label>
                                </div>
                                <div class="col-8 p-0 input-group">
                                    <input id="sq_innelinks_link_template" type="text" name="sq_innelinks_link_template" class="form-control bg-input" value="<?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_template' ) <> '' ? esc_html( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_template' ) ) : '' ) ?>" placeholder="<?php echo esc_attr( SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Replacement' )->getDefaultLinkTemplate() ) ?>"/>
                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "Formatting for the output of generated internal links can be done using placeholders: {{url}} represents the target URL, and {{keyword}} represents the generated anchor text.", 'squirrly-seo' ); ?></div>
                                </div>
                            </div>

                            <div class="col-12 row m-0 p-0 sq_auto_innelinks">
                                <div class="col-4 p-0 font-weight-bold">
                                    <label for="sq_innelinks_exclude_tags"><?php echo esc_html__( "Exclude Tags From Inner Linking", 'squirrly-seo' ); ?>
                                        :</label>
                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "Select the HTML areas that will be excluded from innerlinking.", 'squirrly-seo' ); ?></div>
                                </div>

                                <div class="col-8 p-0 m-0 form-group" style="max-width: 600px">

                                    <select id="sq_innelinks_exclude_tags" multiple name="sq_innelinks_exclude_tags[]" class="selectpicker form-control mb-1" data-live-search="true">
										<?php

										$tags = array(
											'headline'       => __( 'Headlines', 'squirrly-seo' ) . ' (<h1-6>)',
											'strong'         => __( 'Strong text', 'squirrly-seo' ) . ' (<strong>)',
											'tables'         => __( 'Tables', 'squirrly-seo' ) . ' (<table>)',
											'caption'        => __( 'Image captions', 'squirrly-seo' ) . ' (<figcaption>)',
											'order_list'     => __( 'Ordered lists', 'squirrly-seo' ) . ' (<ol>)',
											'unordered_list' => __( 'Unordered lists', 'squirrly-seo' ) . ' (<ul>)',
											'blockquotes'    => __( 'Blockquotes', 'squirrly-seo' ) . ' (<blockquote>)',
											'italic'         => __( 'Italic text', 'squirrly-seo' ) . ' (<em>)',
											'quotes'         => __( 'Inline quotes', 'squirrly-seo' ) . ' (<cite>)',
											'sourcecode'     => __( 'Sourcecode', 'squirrly-seo' ) . ' (<code>)',
										);
										foreach ( $tags as $value => $title ) {
											echo '<option value="' . esc_attr( $value ) . '" ' . ( in_array( $value, (array) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_exclude_tags' ) ) ? 'selected="selected"' : '' ) . '>' . esc_html( $title ) . '</option>';
										} ?>
                                    </select>

                                </div>

                            </div>

                        </div>

						<?php do_action( 'sq_focus_pages_settings_after' ); ?>

                        <div class="col-12 m-0 p-0">
                            <button type="submit" class="btn rounded-0 btn-primary btn-lg py-2 px-5"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                        </div>
                    </div>


                </form>


            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_focus_pages_settings_side_after' ); ?>

                </div>
            </div>
        </div>

    </div>
</div>
