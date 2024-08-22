<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Snippet Jsonld view
 *
 * Called from Snippet Controller
 */
?>
<?php

//Check if the patterns are loaded for this post
$loadpatterns = true;
if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) || ! $view->post->sq->do_pattern ) {
	$loadpatterns = false;
}

//Set the preview title and description in case Squirrly SEO is switched off for Title and Description
$preview_title       = ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ? $view->post->sq->title : $view->post->post_title );
$preview_description = ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ? $view->post->sq->description : $view->post->post_excerpt );
$preview_keywords    = ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_keywords' ) ? $view->post->sq->keywords : '' );

?>
<div class="sq-card sq-border-0 sq-m-0 sq-p-0">
	<?php if ( ! $view->post->sq->do_metas ) { ?>
        <div class="sq-row sq-mx-0 sq-px-0">
            <div class="sq-text-center sq-col-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf( esc_html__( "Post Type (%s) was excluded from %s Squirrly > Automation %s. Squirrly SEO will not load for this post type on the frontend", "squirrly-seo" ), '<strong>' . esc_html( $view->post->post_type ) . '</strong>', '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . esc_attr( $view->post->post_type ) ) . '" target="_blank"><strong>', '</strong></a>' ) ?></div>
        </div>
	<?php } else { ?>
        <div class="sq-card-body sq_tab_meta sq_tabcontent sq-m-0 sq-px-0 sq-py-4 <?php echo ( $view->post->sq_adm->doseo == 0 ) ? 'sq-d-none' : ''; ?>">
			<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ) { ?>
                <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                    <div class="sq-col-12 sq-p-0 sq-text-center sq-small">
                        <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                        <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo esc_html__( "Activate Metas", "squirrly-seo" ); ?></button>
                    </div>
                </div>
			<?php } ?>
            <div class="sq-col-12 sq-m-0 sq-p-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ) ? 'sq_deactivated' : '' ); ?>">

                <div class="sq-col-sm sq-text-right sq-m-0 sq-p-0 sq-mb-2 sq-pb-2">
                    <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-link sq-px-3 sq-rounded-0 sq-font-weight-bold" value="<?php echo esc_attr__( "Refresh", "squirrly-seo" ) ?>"/>
                    <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-mx-5 sq-rounded-0" value="<?php echo esc_attr__( "Save", "squirrly-seo" ) ?>"/>
                </div>

                <div class="sq_snippet_submenu sq-col-12 sq-p-0 sq-m-0 sq-bg-nav">
                    <ul class="sq-col-12 sq-p-0 sq-m-0 sq-nav sq-nav-tabs">
                        <li class="sq-nav-item">
                            <a href="#sqtabmetas<?php echo esc_attr( $view->post->hash ) ?>1" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold active" data-toggle="sqtab"><?php echo esc_html__( "Edit Metas", "squirrly-seo" ) ?></a>
                        </li>
                        <li class="sq-nav-item">
                            <a href="#sqtabmetas<?php echo esc_attr( $view->post->hash ) ?>2" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold" data-toggle="sqtab"><?php echo esc_html__( "Preview", "squirrly-seo" ) ?></a>
                        </li>
                    </ul>
                </div>

                <div class="sq-tab-content sq-d-flex sq-flex-column sq-flex-grow-1 sq-bg-white sq-p-3">
                    <div id="sqtabmetas<?php echo esc_attr( $view->post->hash ) ?>1" class="sq-tab-panel" role="tabpanel">

                        <div class="sq-row sq-mx-0 sq-px-0">
                            <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
								<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ) { ?>
                                    <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                        <div class="sq-col-12 sq-p-0 sq-text-right">
                                            <input type="hidden" id="activate_sq_auto_title" value="1"/>
                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_title" data-action="sq_ajax_seosettings_save" data-name="sq_auto_title"><?php echo esc_html__( "Activate Title", "squirrly-seo" ); ?></button>
                                        </div>
                                    </div>
								<?php } ?>
                                <div class="sq-col-12 sq-row sq-p-0 sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ) ? 'sq_deactivated' : '' ); ?>">
                                    <div class="sq-col-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
										<?php echo esc_html__( "Title", "squirrly-seo" ); ?>:
                                        <div class="sq-small sq-text-black-50 sq-my-3"><?php echo sprintf( esc_html__( "Tips: Length %s-%s chars", "squirrly-seo" ), 10, (int) $view->post->sq_adm->title_maxlength ); ?></div>
                                    </div>
                                    <div class="sq-col-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo( ( $loadpatterns === true ) ? 'sq_pattern_field' : '' ) ?>" data-patternid="<?php echo esc_attr( $view->post->hash ) ?>">
                                        <textarea autocomplete="off" rows="1" name="sq_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo( $loadpatterns ? esc_attr__( "Pattern", "squirrly-seo" ) . ': ' . esc_attr( $view->post->sq_adm->patterns->title ) : esc_attr( $view->post->sq->title ) ) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle( $view->post->sq_adm->title ) ?></textarea>
                                        <input type="hidden" id="sq_title_preview_<?php echo esc_attr( $view->post->hash ) ?>" name="sq_title_preview" value="<?php echo esc_attr( $view->post->sq->title ) ?>">

                                        <div class="sq-col-12 sq-px-0">
                                            <div class="sq-text-right sq-small">
                                                <span class="sq_length" data-maxlength="<?php echo (int) $view->post->sq_adm->title_maxlength ?>"><?php echo( isset( $view->post->sq_adm->title ) ? strlen( $view->post->sq_adm->title ) : 0 ) ?>/<?php echo (int) $view->post->sq_adm->title_maxlength ?></span>
                                            </div>
                                        </div>

                                        <div class="sq-actions">
                                            <div class="sq-action">
                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo esc_attr( $view->post->sq->title ) ?>"></span>
                                                <span class="sq-action-title" title="<?php echo esc_attr( $view->post->sq->title ) ?>"><?php echo esc_html__( "Current Title", "squirrly-seo" ) ?>: <span class="sq-title-value"><?php echo esc_html( $view->post->sq->title ) ?></span></span>
                                            </div>
											<?php if ( isset( $view->post->post_title ) && $view->post->post_title <> '' ) { ?>
                                                <div class="sq-action">
                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr( $view->post->post_title ) ?>"></span>
                                                    <span class="sq-action-title" title="<?php echo esc_attr( $view->post->post_title ) ?>"><?php echo esc_html__( "Default Title", "squirrly-seo" ) ?>: <span><?php echo esc_html( $view->post->post_title ) ?></span></span>
                                                </div>
											<?php } ?>

											<?php if ( $loadpatterns && $view->post->sq_adm->patterns->title <> '' ) { ?>
                                                <div class="sq-action">
                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr( $view->post->sq_adm->patterns->title ) ?>"></span>
                                                    <span class="sq-action-title" title="<?php echo esc_attr( $view->post->sq_adm->patterns->title ) ?>"><?php echo( ( $loadpatterns === true ) ? esc_html__( "Pattern", "squirrly-seo" ) . ': <span>' . esc_html( $view->post->sq_adm->patterns->title ) . '</span>' : '' ) ?></span>
                                                </div>
											<?php } ?>

                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
								<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ) { ?>
                                    <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                        <div class="sq-col-12 sq-p-0 sq-text-right">
                                            <input type="hidden" id="activate_sq_auto_description" value="1"/>
                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_description" data-action="sq_ajax_seosettings_save" data-name="sq_auto_description"><?php echo esc_html__( "Activate Description", "squirrly-seo" ); ?></button>
                                        </div>
                                    </div>
								<?php } ?>
                                <div class="sq-col-12 sq-row sq-p-0 sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ) ? 'sq_deactivated' : '' ); ?>">
                                    <div class="sq-col-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
										<?php echo esc_html__( "Meta Description", "squirrly-seo" ); ?>:
                                        <div class="sq-small sq-text-black-50 sq-my-3"><?php echo sprintf( esc_html__( "Tips: Length %s-%s chars", "squirrly-seo" ), 10, $view->post->sq_adm->description_maxlength ); ?></div>
                                    </div>
                                    <div class="sq-col-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo( ( $loadpatterns === true ) ? 'sq_pattern_field' : '' ) ?>" data-patternid="<?php echo esc_attr( $view->post->hash ) ?>">
                                        <textarea autocomplete="off" rows="3" name="sq_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo( $loadpatterns ? esc_html__( "Pattern", "squirrly-seo" ) . ': ' . esc_attr( $view->post->sq_adm->patterns->description ) : esc_attr( $view->post->sq->description ) ) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription( $view->post->sq_adm->description ) ?></textarea>
                                        <input type="hidden" id="sq_description_preview_<?php echo esc_attr( $view->post->hash ) ?>" name="sq_description_preview" value="<?php echo esc_attr( $view->post->sq->description ) ?>">

                                        <div class="sq-col-12 sq-px-0">
                                            <div class="sq-text-right sq-small">
                                                <span class="sq_length" data-maxlength="<?php echo (int) $view->post->sq_adm->description_maxlength ?>"><?php echo( isset( $view->post->sq_adm->description ) ? strlen( $view->post->sq_adm->description ) : 0 ) ?>/<?php echo (int) $view->post->sq_adm->description_maxlength ?></span>
                                            </div>
                                        </div>

                                        <div class="sq-actions">
											<?php if ( isset( $view->post->sq->description ) && $view->post->sq->description <> '' ) { ?>
                                                <div class="sq-action">
                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo esc_attr( $view->post->sq->description ) ?>"></span>
                                                    <span class="sq-action-title" title="<?php echo esc_attr( $view->post->sq->description ) ?>"><?php echo esc_html__( "Current Description", "squirrly-seo" ) ?>: <span><?php echo esc_html( $view->post->sq->description ) ?></span></span>
                                                </div>
											<?php } ?>

											<?php if ( isset( $view->post->post_excerpt ) && $view->post->post_excerpt <> '' ) { ?>
                                                <div class="sq-action">
                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr( $view->post->post_excerpt ) ?>"></span>
                                                    <span class="sq-action-title" title="<?php echo esc_attr( $view->post->post_excerpt ) ?>"><?php echo esc_html__( "Default Description", "squirrly-seo" ) ?>: <span><?php echo esc_html( $view->post->post_excerpt ) ?></span></span>
                                                </div>
											<?php } ?>

											<?php if ( $loadpatterns && $view->post->sq_adm->patterns->description <> '' ) { ?>
                                                <div class="sq-action">
                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr( $view->post->sq_adm->patterns->description ) ?>"></span>
                                                    <span class="sq-action-title" title="<?php echo esc_attr( $view->post->sq_adm->patterns->description ) ?>"><?php echo( ( $loadpatterns === true ) ? esc_html__( "Pattern", "squirrly-seo" ) . ': ' . '<span>' . esc_html( $view->post->sq_adm->patterns->description ) . '</span>' : '' ) ?></span>
                                                </div>
											<?php } ?>

                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
								<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_keywords' ) ) { ?>
                                    <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                        <div class="sq-col-12 sq-p-0 sq-text-right">
                                            <input type="hidden" id="activate_sq_auto_keywords" value="1"/>
                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_keywords" data-action="sq_ajax_seosettings_save" data-name="sq_auto_keywords"><?php echo esc_html__( "Activate Keywords", "squirrly-seo" ); ?></button>
                                        </div>
                                    </div>
								<?php } ?>
                                <div class="sq-col-12 sq-row sq-p-0 sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_keywords' ) ) ? 'sq_deactivated' : '' ); ?>">
                                    <div class="sq-col-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
										<?php echo esc_html__( "Meta Keywords", "squirrly-seo" ); ?>:
                                        <div class="sq-small sq-text-black-50 sq-my-3"><?php echo esc_html__( "Tips: Keywords you want your content to be found for", "squirrly-seo" ); ?></div>
                                    </div>
                                    <div class="sq-col-9 sq-p-0 sq-m-0">
                                        <input type="text" autocomplete="off" name="sq_keywords" class="sq-form-control sq-input-lg" value="<?php echo SQ_Classes_Helpers_Sanitize::clearKeywords( $view->post->sq_adm->keywords ) ?>" placeholder="<?php echo esc_attr__( "+ Add keyword", "squirrly-seo" ) ?>"/>
                                    </div>

                                </div>

                            </div>

							<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ) { ?>
                                <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
									<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_canonical' ) ) { ?>
                                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                            <div class="sq-col-12 sq-p-0 sq-text-right">
                                                <input type="hidden" id="activate_sq_auto_canonical" value="1"/>
                                                <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_canonical" data-action="sq_ajax_seosettings_save" data-name="sq_auto_canonical"><?php echo esc_html__( "Activate Canonical", "squirrly-seo" ); ?></button>
                                            </div>
                                        </div>
									<?php } ?>
                                    <div class="sq-col-12 sq-row sq-p-0 sq-input-group sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_canonical' ) ) ? 'sq_deactivated' : '' ); ?>">
                                        <div class="sq-col-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
											<?php echo esc_html__( "Canonical link", "squirrly-seo" ); ?>:
                                            <div class="sq-small sq-text-black-50 sq-my-3"><?php echo esc_html__( "Leave it blank if you don't have an external canonical", 'squirrly-seo' ); ?></div>
                                        </div>
                                        <div class="sq-col-9 sq-p-0 sq-input-group sq-input-group-lg">
                                            <input type="text" autocomplete="off" name="sq_canonical" class="sq-form-control sq-input-lg sq-toggle" value="<?php echo( $view->post->sq_adm->canonical ? esc_url( urldecode( $view->post->sq_adm->canonical ) ) : '' ) ?>" placeholder="<?php echo esc_attr__( "Found", 'squirrly-seo' ) . ': ' . ( $view->post->url ? esc_url( urldecode( $view->post->url ) ) : '' ) ?>"/>

                                            <div class="sq-actions">
												<?php if ( ! is_admin() && ! is_network_admin() ) { ?>
                                                    <div class="sq-action">
                                                        <span style="display: none" class="sq-value sq-canonical-value" data-value=""></span>
                                                        <span class="sq-action-title"><?php echo esc_html__( "Current", 'squirrly-seo' ) ?>: <span class="sq-canonical-value"></span></span>
                                                    </div>
												<?php } ?>
												<?php if ( isset( $view->post->url ) && $view->post->url <> '' ) { ?>
                                                    <div class="sq-action">
                                                        <span style="display: none" class="sq-value" data-value="<?php echo esc_url( $view->post->url ) ?>"></span>
                                                        <span class="sq-action-title" title="<?php echo esc_url( $view->post->url ) ?>"><?php echo esc_html__( "Default Link", 'squirrly-seo' ) ?>: <span><?php echo esc_url( urldecode( $view->post->url ) ) ?></span></span>
                                                    </div>
												<?php } ?>

                                            </div>
                                        </div>


                                    </div>

                                </div>
							<?php } ?>
                        </div>

                    </div>
                    <div id="sqtabmetas<?php echo esc_attr( $view->post->hash ) ?>2" class="sq-tab-panel" role="tabpanel">

                        <div class="sq-col-12 sq-m-0 sq-p-0">
                            <div class="sq_message"><?php echo esc_html__( "How this page will appear on Search Engines", 'squirrly-seo' ) ?>
                                :
                            </div>
                        </div>
						<?php if ( $view->post->post_title <> esc_html__( "Auto Draft" ) && $view->post->post_title <> esc_html__( "AUTO-DRAFT" ) ) { ?>
                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                    <li class="sq_snippet_title sq-text-primary sq-font-weight-bold" title="<?php echo esc_attr( $preview_title ) ?>"><?php echo esc_html( $preview_title ) ?></li>
                                    <li class="sq_snippet_url sq-text-link" title="<?php echo esc_url( urldecode( $view->post->url ) ) ?>"><?php echo esc_url( urldecode( $view->post->url ) ) ?></li>
                                    <li class="sq_snippet_description sq-text-black-50" title="<?php echo esc_attr( $preview_description ) ?>"><?php echo esc_html( $preview_description ) ?></li>
                                    <li class="sq_snippet_keywords sq-text-black-50"><?php echo esc_html( $preview_keywords ) ?></li>
                                </ul>
                            </div>
						<?php } else { ?>
                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                <div style="padding: 20px"><?php echo esc_html__( "Please save the post first to be able to edit the Squirrly SEO Snippet", 'squirrly-seo' ) ?></div>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
	<?php } ?>

    <div class="sq-card-footer sq-border-0 sq-py-0 sq-my-0 <?php echo ( $view->post->sq_adm->doseo == 0 ) ? 'sq-mt-5' : ''; ?>">
        <div class="sq-row sq-mx-0 sq-px-0">
            <div class="sq-text-center sq-col-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ( $view->post->sq_adm->doseo == 1 ) ? 'display: none' : ''; ?>">
				<?php echo esc_html__( "To edit the snippet, you have to activate Squirrly SEO for this page first", 'squirrly-seo' ) ?>
            </div>
        </div>
        <div class="sq-row border-top">

            <div class="sq-col-8 sq-row sq-my-0 sq-mx-0 sq-px-0">
                <div class="sq-checker sq-col-12 sq-row sq-my-2 sq-py-0 sq-px-4">
                    <div class="sq-col-12 sq-p-2 sq-switch redblue sq-switch-sm">
                        <input type="checkbox" id="sq_doseo_<?php echo esc_attr( $view->post->hash ) ?>" name="sq_doseo" class="sq-switch" <?php echo ( $view->post->sq_adm->doseo == 1 ) ? 'checked="checked"' : ''; ?> value="1"/>
                        <label for="sq_doseo_<?php echo esc_attr( $view->post->hash ) ?>" class="sq-ml-2"><?php echo esc_html__( "Activate Squirrly Snippet for this page", 'squirrly-seo' ); ?></label>
                    </div>
                </div>
            </div>
            <div class="sq-col-4 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50" style="font-size: 9px !important;">
				<?php echo esc_html__( "Post Type", 'squirrly-seo' ) ?>:
				<?php echo esc_attr( $view->post->post_type ) ?> |
				<?php echo esc_html__( "Term", 'squirrly-seo' ) ?>:
				<?php echo esc_attr( $view->post->taxonomy ) ?> <br/>
				<?php echo esc_html__( "OG", 'squirrly-seo' ) ?>:
				<?php echo esc_attr( $view->post->sq->og_type ) ?> |
				<?php echo esc_html__( "JSON-LD", 'squirrly-seo' ) ?>:
				<?php
				if ( isset( $view->post->sq->jsonld_types ) && ! empty( $view->post->sq->jsonld_types ) ) {
					echo esc_attr( join( ',', $view->post->sq->jsonld_types ) );
				}
				?>
            </div>
        </div>
    </div>
</div>