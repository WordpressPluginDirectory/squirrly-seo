<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Automation > Configuration view
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
                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                </div>

	            <?php
	            $filter = array( 'public' => true, '_builtin' => false );
	            $types  = get_post_types( $filter );

	            $new_types = array();
	            if ( ! empty( $types ) ) {
		            foreach ( $types as $pattern => $name ) {
			            if ( apply_filters( 'sq_automation_validate_pattern', $pattern ) ) {
				            $new_types[ $pattern ] = $name;
			            }
		            }
	            }

	            if ( ! empty( $types ) ) {
		            foreach ( $types as $pattern => $name ) {
			            if ( ! apply_filters( 'sq_automation_validate_pattern', $pattern ) ) {
				            continue;
			            }

			            if ( $post_type_obj = get_post_type_object( $pattern ) ) {
				            if ( ! $post_type_obj->has_archive ) {
					            continue;
				            }
			            }

			            if ( in_array( 'archive-' . $pattern, array_keys( SQ_Classes_Helpers_Tools::getOption( 'patterns' ) ) ) ) {
				            continue;
			            }

			            $new_types[ 'archive-' . $pattern ] = $name;
		            }
	            }

	            $filter = array( 'public' => true, );
	            $taxonomies = get_taxonomies( $filter );
	            if ( ! empty( $taxonomies ) ) {
		            foreach ( $taxonomies as $pattern => $name ) {
			            if ( in_array( $pattern, array(
				            'post_tag',
				            'post_format',
				            'product_cat',
				            'product_tag',
				            'product_shipping_class'
			            ) ) ) {
				            continue;
			            }

			            if ( in_array( 'tax-' . $pattern, array_keys( SQ_Classes_Helpers_Tools::getOption( 'patterns' ) ) ) ) {
				            continue;
			            }
			            $new_types[ 'tax-' . $pattern ] = $name;
		            }
	            }

	            if ( ! empty( $new_types ) ) { ?>
                    <div class="col-12 p-0 m-0">
                        <form method="POST">
                            <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_automation_addpostype', 'sq_nonce' ); ?>
                            <input type="hidden" name="action" value="sq_automation_addpostype"/>

                            <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?></div>
                            <h3 class="mt-4 card-title">
                                <?php echo esc_html__( "Automation", "squirrly-seo" ); ?>
                                <div class="sq_help_question d-inline">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" target="_blank"><i class="fa-solid fa-question-circle" style="margin: 0;"></i></a>
                                </div>
                            </h3>
                            <div class="col-7 small m-0 p-0">
                                <?php echo esc_html__( "Add ALL Your Post Types to the Automation section and ensure all your site is covered with excellent SEO.", "squirrly-seo" ); ?>
                            </div>

                            <div class="col-12 p-0 m-0 my-5">


                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-12 row py-2 mx-0 my-3">
                                            <div class="col-4 p-1">
                                                <div class="font-weight-bold">
                                                    <?php echo esc_html__( "Add Post Type", "squirrly-seo" ); ?>
                                                    :<a href="https://howto12.squirrly.co/kb/seo-automation/#add_post_type" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                </div>
                                                <div class="small text-black-50"><?php echo esc_html__( "Add new post types in the list and customize the automation for it.", "squirrly-seo" ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group">
                                                <label for="sq_select_post_types"></label><select id="sq_select_post_types" name="posttype" class="form-control bg-input m-0">
                                                    <?php
                                                    foreach ( $new_types as $pattern => $name ) {
                                                        ?>
                                                        <option value="<?php echo esc_attr( $pattern ) ?>"><?php echo esc_html( ucwords( str_replace( array(
                                                                '-',
                                                                '_'
                                                            ), ' ', $pattern ) ) ); ?> (<?php echo esc_html( $pattern ) ?>)
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                                <button type="submit" class="btn btn-primary rounded-0"><?php echo esc_html__( "Add Post Type", "squirrly-seo" ); ?></button>

                                            </div>
                                        </div>
                                    </div>



                                <?php do_action( 'sq_automation_types_after' ); ?>

                            </div>
                        </form>
                    </div>
	            <?php } ?>

                <div class="col-12 p-0 m-0">
                    <form method="POST" class="sq_save_ajax_form">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_automation', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_seosettings_automation"/>

                        <h3 class="mt-4 card-title">
		                    <?php echo esc_html__( "Automation - Configurations", "squirrly-seo" ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" target="_blank"><i class="fa-solid fa-question-circle" style="margin: 0;"></i></a>
                            </div>
                        </h3>

                        <div class="col-12 p-0 m-0">

							<?php $view->show_view( 'Blocks/SubMenuHeader' ); ?>
                            <div class="d-flex flex-row p-0 m-0 bg-white">
								<?php $view->show_view( 'Blocks/SubMenu' ); ?>

                                <div class="d-flex flex-column flex-grow-1 m-0 p-0">
									<?php
									$filter = array( 'public' => true, '_builtin' => false );
									$types  = get_post_types( $filter );
									$types['post'] = 'post'; //add post type post

									$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
									$patterns = apply_filters( 'sq_automation_patterns', $patterns );

									if ( ! empty( $patterns ) ) {
										foreach ( $patterns as $pattern => $type ) {
											$itemname = apply_filters( 'sq_pattern_item', $pattern );
											?>

                                            <div id="sq_<?php echo esc_attr( $pattern ) ?>" class="col-12 m-0 py-0 px-4 tab-panel <?php if ( $pattern == 'home' ) { ?>tab-panel-first active<?php } ?>">

                                                <div class="col-12 p-0 m-0 my-3">

                                                    <h4 class="col-12 m-0 p-0 text-center text-black">
														<?php echo esc_html( $itemname ); ?> <?php if ( $pattern <> 'home' ) { ?>
                                                            <span class="text-black-50">
                                                            (<?php echo esc_html( $pattern ) ?>)</span><?php } ?>
                                                    </h4>

                                                    <h4 class="col-12 m-0 p-0 text-center text-black-50 my-5 sq_doseo_<?php echo esc_attr( $pattern ) ?>" <?php echo( ( ! isset( $type['doseo'] ) || $type['doseo'] ) ? 'style="display: none"' : '' ) ?>>
														<?php echo esc_html__( "Squirrly SEO is not active on this post type.", "squirrly-seo" ); ?>
                                                    </h4>

                                                    <div class="sq_patterns_<?php echo esc_attr( $pattern ) ?>_doseo" style="position: relative; ">

														<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) ) { ?>
                                                            <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax" style="top: 105px">
                                                                <div class="sq-col-12 sq-p-0 sq-text-center sq-small">
                                                                    <input type="hidden" id="activate_sq_auto_pattern" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_pattern" data-action="sq_ajax_seosettings_save" data-name="sq_auto_pattern"><?php echo esc_html__( "Activate Patterns", "squirrly-seo" ); ?></button>
                                                                </div>
                                                            </div>
														<?php } ?>

                                                        <div class="p-0 m-0 <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) ? '' : 'sq_deactivated' ) ?>">
                                                            <div class="col-12 row p-0 mx-2 my-5">
                                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                                    <label for="patterns_<?php echo esc_attr( $pattern ) ?>_title"><?php echo esc_html__( "Title", "squirrly-seo" ); ?>
                                                                        :</label>
                                                                    <a href="https://howto12.squirrly.co/kb/seo-automation/#title_automation" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                    <div class="small text-black-50 mt-1 mb-0"><?php echo esc_html__( "Recommended Length: 10-75 chars", "squirrly-seo" ); ?></div>
                                                                </div>
                                                                <div class="col-8 p-0 sq_pattern_field">
                                                                    <textarea id="patterns_<?php echo esc_attr( $pattern ) ?>_title" rows="1" class="form-control bg-input" name="patterns[<?php echo esc_attr( $pattern ) ?>][title]"><?php echo ( isset( $type['title'] ) ) ? esc_html( $type['title'] ) : '' ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 row p-0 mx-2 my-5">
                                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                                    <label for="patterns_<?php echo esc_attr( $pattern ) ?>_description"><?php echo esc_html__( "Description", "squirrly-seo" ); ?>
                                                                        :</label>
                                                                    <a href="https://howto12.squirrly.co/kb/seo-automation/#description_automation" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                    <div class="small text-black-50 mt-1 mb-0"><?php echo esc_html__( "Recommended Length: 70-320 chars", "squirrly-seo" ); ?></div>
                                                                </div>
                                                                <div class="col-8 p-0 sq_pattern_field">
                                                                    <textarea id="patterns_<?php echo esc_attr( $pattern ) ?>_description" class="form-control" name="patterns[<?php echo esc_attr( $pattern ) ?>][description]" rows="5"><?php echo( isset( $type['description'] ) ? esc_html( $type['description'] ) : '' ) ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 row p-0 mx-2 my-5">
                                                                <div class="col-4 p-1 font-weight-bold">
                                                                    <label for="patterns_<?php echo esc_attr( $pattern ) ?>_sep"><?php echo esc_html__( "Separator", "squirrly-seo" ); ?>
                                                                        :</label>
                                                                    <a href="https://howto12.squirrly.co/kb/seo-automation/#separator" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                    <div class="small text-black-50 mt-1 mb-0"><?php echo esc_html__( "Use a separator to help users read the most relevant part of your title and increase Conversion Rate.", "squirrly-seo" ); ?></div>
                                                                </div>
                                                                <div class="col-4 p-0">
                                                                    <select id="patterns_<?php echo esc_attr( $pattern ) ?>_sep" name="patterns[<?php echo esc_attr( $pattern ) ?>][sep]" class="form-control bg-input mb-1 border">
																		<?php
																		$seps = json_decode( SQ_ALL_SEP, true );

																		foreach ( $seps as $sep => $code ) { ?>
                                                                            <option value="<?php echo esc_attr( $sep ) ?>" <?php echo ( isset( $type['sep'] ) && $type['sep'] == $sep ) ? 'selected="selected"' : '' ?>><?php echo esc_html( $code ) ?></option>
																		<?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ) { ?>
															<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) { ?>
                                                                <div class="col-12 row p-0 m-0 my-5">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][noindex]" value="1"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_noindex" name="patterns[<?php echo esc_attr( $pattern ) ?>][noindex]" class="sq-switch" <?php echo( ( isset( $type['noindex'] ) && $type['noindex'] == 0 ) ? 'checked="checked"' : '' ) ?> value="0"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_noindex" class="ml-1"><?php echo esc_html__( "Let Google Index it", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#let_google_index" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "If you switch off this option, Squirrly will add noindex meta for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
															<?php } ?>


															<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) { ?>
                                                                <div class="col-12 row m-0 p-0 my-5">
                                                                    <div class="checker col-12 row m-0 p-0">
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) || ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) ? 'sq_deactivated' : '' ); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][nofollow]" value="1"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_nofollow" name="patterns[<?php echo esc_attr( $pattern ) ?>][nofollow]" class="sq-switch" <?php echo( ( isset( $type['nofollow'] ) && $type['nofollow'] == 0 ) ? 'checked="checked"' : '' ) ?> value="0"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_nofollow" class="ml-1"><?php echo esc_html__( "Send Authority to it", "squirrly-seo" ); ?>
                                                                                <a href="https://howto12.squirrly.co/kb/seo-automation/#send_authority" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "If you switch off this option, Squirrly will add 'nofollow' meta for this post type.", "squirrly-seo" ); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
															<?php } ?>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) && $pattern <> 'profile' && $pattern <> 'search' && $pattern <> '404' ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_sitemap]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_sitemap" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_sitemap]" class="sq-switch" <?php echo( ( isset( $type['do_sitemap'] ) && $type['do_sitemap'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_sitemap" class="ml-1"><?php echo esc_html__( "Include In Sitemap", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#send_to_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO include this post type in Squirrly Sitemap XML.", "squirrly-seo" ); ?></div>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "If you switch off this option, Squirrly will not load the Sitemap for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>

															<?php
															$sitemap = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap' );
															if ( isset( $sitemap['sitemap-news'][1] ) && $sitemap['sitemap-news'][1] && in_array( $pattern, array_keys( $types ) ) ) { ?>
                                                                <div class="col-12 row m-0 p-0 my-5  sq_patterns_<?php echo esc_attr( $pattern ) ?>_noindex">
                                                                    <div class="checker col-12 row m-0 p-0">
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][google_news]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_google_news" name="patterns[<?php echo esc_attr( $pattern ) ?>][google_news]" class="sq-switch" <?php echo( ( isset( $type['google_news'] ) && $type['google_news'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_google_news" class="ml-1"><?php echo esc_html__( "Include In Google News Sitemap", "squirrly-seo" ); ?></label>
                                                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO include this post type in Google News Sitemap.", "squirrly-seo" ); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
															<?php } ?>
														<?php } ?>

														<?php if ( ! isset( $type['do_redirects'] ) ) {
															$type['do_redirects'] = 0;
														} ?>

														<?php if ( in_array( $pattern, array_keys( $types ) ) || in_array( $pattern, array(
																'post',
																'page',
																'404'
															) ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_redirects]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_redirects" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_redirects]" class="sq-switch" <?php echo( ( isset( $type['do_redirects'] ) && $type['do_redirects'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_redirects" class="ml-1"><?php echo esc_html__( "Redirect Broken URLs", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#redirect_404_links" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Redirect the 404 URL in case it is changed with a new one in Post Editor.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( $pattern == '404' ) { ?>
                                                            <div class="col-12 row py-2 mx-0 my-3">
                                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                                    <label for="404_url_redirect"><?php echo esc_html__( "Default Redirect URL", "squirrly-seo" ); ?>
                                                                        :</label>
                                                                    <a href="https://howto12.squirrly.co/kb/seo-automation/#redirect_404_links" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "Add the default URL for the Broken URLs when no permalink is found.", "squirrly-seo" ); ?></div>
                                                                </div>
                                                                <div class="col-8 p-0 m-0 my-3">
                                                                    <input id="404_url_redirect" type="text" class="form-control bg-input" name="404_url_redirect" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getOption( '404_url_redirect' ) ) ?>"/>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( $pattern == 'attachment' ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="sq_attachment_redirect" value="0"/>
                                                                        <input type="checkbox" id="sq_attachment_redirect" name="sq_attachment_redirect" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_attachment_redirect' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_attachment_redirect" class="ml-1"><?php echo esc_html__( "Redirect Attachments Page", "squirrly-seo" ); ?></label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Redirect the attachment page to its image URL.", "squirrly-seo" ); ?></div>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Recommended if your website is not a photography website.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_metas]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_metas" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_metas]" class="sq-switch" <?php echo( ( isset( $type['do_metas'] ) && $type['do_metas'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_metas" class="ml-1"><?php echo esc_html__( "Load SEO Metas", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_squirrly_metas" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO load the Title, Description, Keyword METAs for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_pattern]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_pattern" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_pattern]" class="sq-switch" <?php echo( ( isset( $type['do_pattern'] ) && $type['do_pattern'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_pattern" class="ml-1"><?php echo esc_html__( "Load Squirrly Patterns", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_squirrly_patterns" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO load the Patterns for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_jsonld]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_jsonld" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_jsonld]" class="sq-switch" <?php echo( ( isset( $type['do_jsonld'] ) && $type['do_jsonld'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_jsonld" class="ml-1"><?php echo esc_html__( "Load JSON-LD Structured Data", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_jsonld_schema" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO load the JSON-LD Schema for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>

                                                                    <div class="col-12 row m-0 mt-5 p-0  sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_jsonld">
                                                                        <div class="col-7 p-1 pr-2">
                                                                            <div class="font-weight-bold">
                                                                                <label for="patterns_<?php echo esc_attr( $pattern ) ?>_jsonld_types"><?php echo esc_html__( "JSON-LD Type", "squirrly-seo" ); ?>
                                                                                    :</label>
                                                                                <a href="https://howto12.squirrly.co/kb/seo-automation/#load_jsonld_schema" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </div>
                                                                            <div class="small text-black-50"><?php echo esc_html__( "JSON-LD will load the Schema for the selected types.", "squirrly-seo" ); ?></div>
                                                                        </div>
																		<?php
																		$jsonld_types = json_decode( SQ_ALL_JSONLD_TYPES, true );
																		$jsonld_types = apply_filters( 'sq_jsonld_types', $jsonld_types, $pattern );
																		$reusable_jsonld_types = apply_filters( 'sq_reusable_jsonld_types', array() );
																		$jsonld_types = array_map( 'strtolower', $jsonld_types );

																		$post_jsonld_types = array();
																		if ( ! empty( $type['jsonld_types'] ) ) {
																			$post_jsonld_types = array_map( 'strtolower', $type['jsonld_types'] );
																		}
																		?>
                                                                        <div class="col-5 p-0">
                                                                            <select id="patterns_<?php echo esc_attr( $pattern ) ?>_jsonld_types" <?php echo( ( count( $jsonld_types ) > 1 ) ? 'multiple' : '' ) ?> name="patterns[<?php echo esc_attr( $pattern ) ?>][jsonld_types][]" class="selectpicker form-control bg-input mb-1 border" style="min-height: 100px;">
																				<?php foreach ( $jsonld_types as $jsonld_type ) { ?>
                                                                                    <option <?php echo( ( ! empty( $post_jsonld_types ) && in_array( $jsonld_type, $post_jsonld_types ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $jsonld_type ) ?>">
																						<?php echo esc_html( ucfirst( $jsonld_type ) ) ?>
                                                                                    </option>
																				<?php } ?>
																				<?php
																				if ( ! empty( $reusable_jsonld_types ) ) {
																					foreach ( $reusable_jsonld_types as $jsonld_id => $reusable_jsonld_type ) { ?>
                                                                                        <option <?php echo( ( ! empty( $post_jsonld_types ) && in_array( $jsonld_id, $post_jsonld_types ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $jsonld_id ) ?>">
																							<?php echo esc_html( ucfirst( $reusable_jsonld_type ) ) ?>
                                                                                        </option>
																					<?php }
																				} ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_og]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_og" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_og]" class="sq-switch" <?php echo( ( isset( $type['do_og'] ) && $type['do_og'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_og" class="ml-1"><?php echo esc_html__( "Load Squirrly Open Graph", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_open_graph" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO load the Open Graph for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>

                                                                    <div class="col-12 row m-0 mt-5 mb-3 p-0 sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_og">
                                                                        <div class="col-7 p-1 pr-2">
                                                                            <div class="font-weight-bold">
                                                                                <label for="patterns_<?php echo esc_attr( $pattern ) ?>_og_type"><?php echo esc_html__( "Open Graph Type", "squirrly-seo" ); ?>
                                                                                    :</label>
                                                                                <a href="https://howto12.squirrly.co/kb/seo-automation/#load_open_graph" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </div>
                                                                            <div class="small text-black-50"><?php echo esc_html__( "Select which Open Graph type to load for this post type.", "squirrly-seo" ); ?></div>
                                                                        </div>
																		<?php
																		$post_types = json_decode( SQ_ALL_OG_TYPES, true );

																		if ( in_array( $pattern, array(
																			'home',
																			'search',
																			'category',
																			'tag',
																			'archive',
																			'404',
																			'attachment',
																			'tax-post_tag',
																			'tax-post_cat',
																			'tax-product_tag',
																			'tax-product_cat',
																			'shop'
																		) ) ) {
																			$post_types = array( 'website' );
																		}
																		if ( $pattern == 'profile' ) {
																			$post_types = array( 'profile' );
																		}
																		if ( $pattern == 'product' ) {
																			$post_types = array( 'product' );
																		}
																		?>
                                                                        <div class="col-5 p-0">
                                                                            <select id="patterns_<?php echo esc_attr( $pattern ) ?>_og_type" name="patterns[<?php echo esc_attr( $pattern ) ?>][og_type]" class="form-control bg-input mb-1 border">
																				<?php foreach ( $post_types as $post_type => $og_type ) { ?>
                                                                                    <option <?php echo( ( isset( $type['og_type'] ) && $type['og_type'] == $og_type ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $og_type ) ?>">
																						<?php echo esc_html( ucfirst( $og_type ) ) ?>
                                                                                    </option>
																				<?php } ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_twc]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_twc" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_twc]" class="sq-switch" <?php echo( ( isset( $type['do_twc'] ) && $type['do_twc'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_twc" class="ml-1"><?php echo esc_html__( "Load Squirrly Twitter Card", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_twitter_card" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Squirrly SEO load the Twitter Card for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_analytics]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_analytics" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_analytics]" class="sq-switch" <?php echo( ( isset( $type['do_analytics'] ) && $type['do_analytics'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_analytics" class="ml-1"><?php echo esc_html__( "Load Google Analytics Tracking Script", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_analytics_tracking" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Google Analytics Tracking to load for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>


														<?php } ?>

														<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pixels' ) ) { ?>
                                                            <div class="col-12 row m-0 p-0 my-5">
                                                                <div class="checker col-12 row m-0 p-0">
                                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                        <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_fpixel]" value="0"/>
                                                                        <input type="checkbox" id="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_fpixel" name="patterns[<?php echo esc_attr( $pattern ) ?>][do_fpixel]" class="sq-switch" <?php echo( ( isset( $type['do_fpixel'] ) && $type['do_fpixel'] == 1 ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                                        <label for="sq_patterns_<?php echo esc_attr( $pattern ) ?>_do_fpixel" class="ml-1"><?php echo esc_html__( "Load Facebook Pixel Tracking Script", "squirrly-seo" ); ?>
                                                                            <a href="https://howto12.squirrly.co/kb/seo-automation/#load_facebook_pixel" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        </label>
                                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Let Facebook Pixel Tracking to load for this post type.", "squirrly-seo" ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
														<?php } ?>

														<?php do_action( 'sq_automation_configuration_after' ); ?>

                                                        <div class="col-12 m-0 p-0 mt-5">
                                                            <input type="hidden" name="patterns[<?php echo esc_attr( $pattern ) ?>][protected]" value="<?php echo esc_attr( ( $type['protected'] ?? 0 ) ) ?>">
                                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", "squirrly-seo" ); ?></button>
                                                        </div>

                                                    </div>

													<?php if ( $pattern <> 'custom' && ( ! isset( $type['protected'] ) || ! $type['protected'] ) ) { ?>
                                                        <div class="col-12 row m-0 p-3 sq_save_ajax">
                                                            <div class="col-12 p-0 text-right">
                                                                <input type="hidden" id="sq_delete_post_types_<?php echo esc_attr( $pattern ) ?>" value="<?php echo esc_attr( $pattern ) ?>"/>
                                                                <button type="button" data-confirm="<?php echo esc_attr( sprintf( __( "Do you want to delete the automation for %s?", "squirrly-seo" ), ucwords( str_replace( array(
																	'-',
																	'_'
																), array( ' ' ), $pattern ) ) ) ); ?>" data-input="sq_delete_post_types_<?php echo esc_attr( $pattern ) ?>" data-action="sq_ajax_automation_deletepostype" data-name="post_type" class="btn btn-link btn-sm text-black-50 rounded-0"><?php echo sprintf( esc_html__( "Remove automation for %s", "squirrly-seo" ), esc_attr( ucwords( str_replace( array(
																		'-',
																		'_'
																	), array( ' ' ), $pattern ) ) ) ); ?></button>
                                                            </div>
                                                        </div>
													<?php } ?>


                                                </div>

                                            </div>

										<?php }
									} ?>


                                </div>

                            </div>


                            <div class="col-12 p-0 m-0 my-5">
                                <h3 class="card-title">
									<?php echo esc_html__( "Squirrly Patterns", "squirrly-seo" ); ?>
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/#add_patterns" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                </h3>
                                <div class="col-12 text-left m-0 p-0">
                                    <div class="col-7 small m-0 p-0"><?php echo esc_html__( "Use the Pattern system to prevent Title and Description duplicates between posts", "squirrly-seo" ); ?></div>
                                </div>

                                <div class="col-12 text-left m-0 p-0 py-3">
                                    <div class="m-3 px-5"><?php echo esc_html__( "Patterns change the codes like {{title}} with the actual value of the post Title.", "squirrly-seo" ); ?></div>
                                    <div class="m-3 px-5"><?php echo esc_html__( "In Squirrly, each post type in your site comes with a predefined posting pattern when displayed onto your website. However, based on your site's purpose and needs, you can also decide what information these patterns will include.", "squirrly-seo" ); ?></div>
                                    <div class="m-3 px-5"><?php echo esc_html__( "Once you set up a pattern for a particular post type, only the content required by your custom sequence will be displayed.", "squirrly-seo" ); ?></div>
                                    <div class="m-3 px-5"><?php echo sprintf( esc_html__( "Squirrly lets you see how the customized patterns will apply when posts/pages are shared across social media or search engine feeds. You just need to go to %s Squirrly's Bulk SEO section %s and see the meta information for each post type.", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) ) . '" ><strong>', '</strong></a>' ); ?></div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "From this section, you can quickly work on your site globally and set up the SEO for it in just a few minutes.", "squirrly-seo" ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "If you are an SEO beginner, it’s not necessary to make any major changes in the Automation section.", "squirrly-seo" ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "If you are an SEO expert or an advanced user, you’ll be able to easily customize the Automation for every post type.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>
            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_automation_configuration_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
