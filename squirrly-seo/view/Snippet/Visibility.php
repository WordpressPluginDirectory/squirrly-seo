<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Snippet Visibility view
 *
 * Called from Snippet Controller
 */

//Check if the patterns are loaded for this post
$loadpatterns = true;
if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) || ! $view->post->sq->do_pattern ) {
	$loadpatterns = false;
}

$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
if ( ! isset( $patterns[ $view->post->post_type ] ) && isset( $patterns['custom'] ) ) {
	$patterns[ $view->post->post_type ] = $patterns['custom'];
}
?>
<div class="sq-card sq-border-0">
	<?php if ( get_option( 'blog_public' ) == 0 ) { ?>
        <div class="sq-row sq-mx-0 sq-px-0">
            <div class="sq-text-center sq-col-12 sq-mt-5 sq-mx-0 sq-px-0 sq-text-danger">
				<?php echo sprintf( esc_html__( "You selected '%s' in %sSettings > Reading%s. %s It's important to uncheck that option.", "squirrly-seo" ), esc_html__( "Discourage search engines from indexing this site" ), '<a href="' . esc_url( admin_url( 'options-reading.php' ) ) . '" target="_blank"><strong>', '</strong></a>', '<br />' ) ?>
            </div>
        </div>
	<?php } ?>
    <div class="sq-card-body sq_tab_visibility sq_tabcontent sq-m-0 sq-px-0 sq-py-4 <?php echo ( $view->post->sq_adm->doseo == 0 ) ? 'sq-d-none' : ''; ?>">

        <div class="sq-col-sm sq-text-right sq-m-0 sq-p-0 sq-mb-2 sq-pb-2">
            <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-link sq-px-3 sq-rounded-0 sq-font-weight-bold" value="<?php echo esc_attr__( "Refresh", "squirrly-seo" ) ?>"/>
            <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-mx-5 sq-rounded-0" value="<?php echo esc_attr__( "Save", "squirrly-seo" ) ?>"/>
        </div>

        <div class="sq_snippet_submenu sq-col-12 sq-p-0 sq-m-0 sq-bg-nav">
            <ul class="sq-col-12 sq-p-0 sq-m-0 sq-nav sq-nav-tabs">
                <li class="sq-nav-item">
                    <a href="#sqtabvisibility<?php echo esc_attr( $view->post->hash ) ?>1" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold active" data-toggle="sqtab"><?php echo esc_html__( "Edit Visibility", "squirrly-seo" ) ?></a>
                </li>
            </ul>
        </div>

        <div class="sq-tab-content sq-d-flex sq-flex-column sq-flex-grow-1 sq-bg-white sq-p-3">
            <div id="sqtabvisibility<?php echo esc_attr( $view->post->hash ) ?>1" class="sq-tab-panel" role="tabpanel">


                <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
					<?php if ( isset( $patterns[ $view->post->post_type ]['noindex'] ) && $patterns[ $view->post->post_type ]['noindex'] ) { ?>
                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                            <div class="sq-col-12 sq-p-0 sq-text-center sq-small">
								<?php echo sprintf( esc_html__( "This Post Type (%s) has Nofollow set in Automation. See %s Squirrly > Automation > Configuration %s.", "squirrly-seo" ), esc_attr( $view->post->post_type ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . esc_attr( $view->post->post_type ) ) . '" target="_blank"><strong>', '</strong></a>' ) ?>
                            </div>
                        </div>
					<?php } elseif ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) { ?>
                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                            <div class="sq-col-12 sq-p-0 sq-text-right">
                                <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo esc_html__( "Activate Robots Meta", "squirrly-seo" ); ?></button>
                            </div>
                        </div>
					<?php } ?>
                    <div class="sq-col-12 sq-row sq-p-0 sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) || $patterns[ $view->post->post_type ]['noindex'] ) ? 'sq_deactivated' : '' ); ?>">
                        <div class="sq-col-12 sq-row sq-my-0 sq-mx-0 sq-px-0">


                            <div class="sq-checker sq-col-12 sq-row sq-my-0 sq-py-0 sq-px-4">
                                <div class="sq-col-12 sq-p-2 sq-switch redblue sq-switch-sm">
                                    <input type="checkbox" id="sq_noindex_<?php echo esc_attr( $view->post->hash ) ?>" name="sq_noindex" class="sq-switch" <?php echo ( $view->post->sq_adm->noindex <> 1 ) ? 'checked="checked"' : ''; ?> value="0"/>
                                    <label for="sq_noindex_<?php echo esc_attr( $view->post->hash ) ?>" class="sq-m-0"><?php echo esc_html__( "Let Google Index This Page", "squirrly-seo" ); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

					<?php if ( isset( $patterns[ $view->post->post_type ]['nofollow'] ) && $patterns[ $view->post->post_type ]['nofollow'] ) { ?>
                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                            <div class="sq-col-12 sq-p-0 sq-text-center sq-small">
								<?php echo sprintf( esc_html__( "This Post Type (%s) has Nofollow set in Automation. See %s Squirrly > Automation > Configuration %s.", "squirrly-seo" ), esc_attr( $view->post->post_type ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . esc_attr( $view->post->post_type ) ) . '" target="_blank"><strong>', '</strong></a>' ) ?>
                            </div>
                        </div>
					<?php } elseif ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) { ?>
                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                            <div class="sq-col-12 sq-p-0 sq-text-right">
                                <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo esc_html__( "Activate Robots Meta", "squirrly-seo" ); ?></button>
                            </div>
                        </div>
					<?php } ?>
                    <div class="sq-col-12 sq-row sq-p-0 sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) || $patterns[ $view->post->post_type ]['nofollow'] ) ? 'sq_deactivated' : '' ); ?>">
                        <div class="sq-col-12 sq-row sq-my-0 sq-mx-0 sq-px-0">


                            <div class="sq-checker sq-col-12 sq-row sq-my-0 sq-py-0 sq-px-4">
                                <div class="sq-col-12 sq-p-2 sq-switch redblue sq-switch-sm">
                                    <input type="checkbox" id="sq_nofollow_<?php echo esc_attr( $view->post->hash ) ?>" name="sq_nofollow" class="sq-switch" <?php echo ( $view->post->sq_adm->nofollow <> 1 ) ? 'checked="checked"' : ''; ?> value="0"/>
                                    <label for="sq_nofollow_<?php echo esc_attr( $view->post->hash ) ?>" class="sq-m-0"><?php echo esc_html__( "Send Authority to this page", "squirrly-seo" ); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="sq-col-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
					<?php if ( ! $view->post->sq->do_sitemap ) { ?>
                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                            <div class="sq-col-12 sq-p-0 sq-text-center sq-small">
								<?php echo sprintf( esc_html__( "Show in sitemap for this Post Type (%s) was excluded from %s Squirrly > Automation > Configuration %s.", "squirrly-seo" ), esc_attr( $view->post->post_type ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . esc_attr( $view->post->post_type ) ) . '" target="_blank"><strong>', '</strong></a>' ) ?>
                            </div>
                        </div>
					<?php } elseif ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ) { ?>
                        <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                            <div class="sq-col-12 sq-p-0 sq-text-right">
                                <input type="hidden" id="activate_sq_auto_sitemap" value="1"/>
                                <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_sitemap" data-action="sq_ajax_seosettings_save" data-name="sq_auto_sitemap"><?php echo esc_html__( "Activate Sitemap", "squirrly-seo" ); ?></button>
                            </div>
                        </div>
					<?php } ?>
                    <div class="sq-col-12 sq-row sq-p-0 sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) || ! $view->post->sq->do_sitemap ) ? 'sq_deactivated' : '' ); ?>">
                        <div class="sq-col-12 sq-row sq-my-0 sq-mx-0 sq-px-0">

                            <div class="sq-checker sq-col-12 sq-row sq-my-0 sq-py-0 sq-px-4">
                                <div class="sq-col-12 sq-p-2 sq-switch redblue sq-switch-sm">
                                    <input type="checkbox" id="sq_nositemap_<?php echo esc_attr( $view->post->hash ) ?>" name="sq_nositemap" class="sq-switch" <?php echo ( $view->post->sq_adm->nositemap == 0 ) ? 'checked="checked"' : ''; ?> value="0"/>
                                    <label for="sq_nositemap_<?php echo esc_attr( $view->post->hash ) ?>" class="sq-m-0"><?php echo esc_html__( "Show it in Sitemap.xml", 'squirrly-seo' ); ?></label>
                                    <div class="sq-small sq-text-black-50 sq-ml-5 sq-mt-2"><?php echo esc_html__( "Don't show in Sitemap XML a page set as Noindex.", 'squirrly-seo' ); ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
				<?php if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'squirrly-seo-pack/index.php' ) ) { ?>
                    <div class="sq-col-12 sq-border-top sq-row sq-m-0 sq-p-2">
                        <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_redirects' ) ) ?>" class="text-primary"><?php echo esc_html__( "Manage Redirects", 'squirrly-seo' ); ?></a>
                    </div>
				<?php } elseif ( SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ) { ?>
                    <div class="sq-col-12 sq-border-top sq-row sq-mx-0 sq-px-0 sq-my-3 sq-py-4">
						<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_redirects' ) ) { ?>
                            <div class="sq_deactivated_label sq-col-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                <div class="sq-col-12 sq-p-0 sq-text-right">
                                    <input type="hidden" id="activate_sq_auto_redirects" value="1"/>
                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_redirects" data-action="sq_ajax_seosettings_save" data-name="sq_auto_redirects"><?php echo esc_html__( "Activate Redirects", 'squirrly-seo' ); ?></button>
                                </div>
                            </div>
						<?php } ?>
                        <div class="sq-col-12 sq-row sq-p-0 sq-input-group sq-m-0 <?php echo( ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_redirects' ) ) ? 'sq_deactivated' : '' ); ?>">
                            <div class="sq-col-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
								<?php echo esc_html__( "301 Redirect", 'squirrly-seo' ); ?>:
                                <div class="sq-small sq-text-black-50 sq-my-3"><?php echo esc_html__( "Leave it blank if you don't want to add a 301 redirect to another URL", 'squirrly-seo' ); ?></div>
                            </div>
                            <div class="sq-col-9 sq-p-0 sq-input-group sq-input-group-lg">
                                <input type="text" autocomplete="off" name="sq_redirect" class="sq-form-control sq-input-lg sq-toggle" value="<?php echo( ( $view->post->sq_adm->redirect && $view->post->sq_adm->redirect <> '' ) ? esc_url( urldecode( $view->post->sq_adm->redirect ) ) : '' ) ?>"/>
                            </div>
                        </div>

                    </div>
				<?php } ?>

            </div>
        </div>

    </div>

    <div class="sq-card-footer sq-border-0 sq-py-0 sq-my-0 <?php echo ( $view->post->sq_adm->doseo == 0 ) ? 'sq-mt-5' : ''; ?>">
        <div class="sq-row sq-mx-0 sq-px-0">
            <div class="sq-text-center sq-col-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ( $view->post->sq_adm->doseo == 1 ) ? 'display: none' : ''; ?>">
				<?php echo esc_html__( "To edit the snippet, you have to activate Squirrly SEO for this page first", 'squirrly-seo' ) ?>
            </div>
        </div>

    </div>
</div>
