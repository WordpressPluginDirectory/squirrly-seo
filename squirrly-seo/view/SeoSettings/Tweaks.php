<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Tweaks view
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
                <form method="POST" enctype="multipart/form-data">
					<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_save', 'sq_nonce' ); ?>
                    <input type="hidden" name="action" value="sq_seosettings_save"/>

                    <div class="col-12 p-0 m-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                        <h3 class="mt-4 card-title">
							<?php echo esc_html__( "Tweaks And Sitemap", 'squirrly-seo' ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                            </div>
                        </h3>
                        <div class="col-7 small m-0 p-0">
							<?php echo esc_html__( "Control your search engine and social media feed coverage of all the content on your WP site, automatically.", 'squirrly-seo' ); ?>
                        </div>
                        <div class="col-7 small m-0 p-0 py-2">
							<?php echo esc_html__( "By configuring these, you will get higher Audit scores. Many more options are available if you switch to Expert Mode.", 'squirrly-seo' ); ?>
                        </div>

						<?php $view->show_view( 'Blocks/SubMenuHeader' ); ?>
                        <div class="d-flex flex-row p-0 m-0 bg-white">
							<?php $view->show_view( 'Blocks/SubMenu' ); ?>

                            <div class="d-flex flex-column flex-grow-1 m-0 p-04">
								<?php
								$patterns    = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
								$sitemap     = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap' );
								$sitemapshow = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_show' );
								?>
                                <div id="sitemap" class="col-12 py-0 px-4 m-0 tab-panel tab-panel-first active">

                                    <div class="col-12 row m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Build Sitemaps for", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#post_types" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                        </h3>
                                        <div class="col-12 small m-0 p-0">
											<?php echo sprintf( esc_html__( "Check the sitemap you want Squirrly to build for your website. Your sitemap will be %s", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap' ) ) . '" target="_blank"><strong>' . esc_html( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap' ) ) . '</strong></a>' ); ?>
                                        </div>
                                        <div class="col-12 small m-0 p-0 py-2">
											<?php echo esc_html__( "After you activate your sitemaps, check to make sure they have data. Uncheck them if they don't have URLs in order to avoid Google errors.", 'squirrly-seo' ); ?>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 m-0 p-0 border-bottom">
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="col-4 m-0 p-0">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Blogging Frequency", 'squirrly-seo' ); ?>
                                                        :
                                                        <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#blogging_frequency" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "How often do you write new posts?", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group">
                                                    <select name="sq_sitemap_frequency" class="form-control bg-input mb-1 border">
                                                        <option value="hourly" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) == 'hourly' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "every hour", 'squirrly-seo' ); ?></option>
                                                        <option value="daily" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) == 'daily' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "every day", 'squirrly-seo' ); ?></option>
                                                        <option value="weekly" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) == 'weekly' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "1-3 times per week", 'squirrly-seo' ); ?></option>
                                                        <option value="monthly" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) == 'monthly' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "1-3 times per month", 'squirrly-seo' ); ?></option>
                                                        <option value="yearly" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) == 'yearly' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "1-3 times per year", 'squirrly-seo' ); ?></option>
                                                    </select>
                                                </div>
                                            </div>

											<?php if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang/polylang.php' ) || SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang-pro/polylang.php' ) ) { ?>
                                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                    <div class="checker col-12 row m-0 p-0">
                                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                            <input type="hidden" name="sq_sitemap_combinelangs" value="0"/>
                                                            <input type="checkbox" id="sq_sitemap_combinelangs" name="sq_sitemap_combinelangs" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_combinelangs' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                                            <label for="sq_sitemap_combinelangs" class="ml-1"><?php echo esc_html__( "Combine Languages in Sitemap", 'squirrly-seo' ); ?>
                                                                <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#polylang" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                            </label>
                                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add all languages in the same sitemap.xml file", 'squirrly-seo' ); ?></div>
                                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "If not selected, you have to add the language slug for each snippet. e.g. /en/sitemap.xml", 'squirrly-seo' ); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
											<?php } ?>

                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_home" name="sitemap[sitemap-home]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-home'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_home" class="ml-1"><?php echo esc_html__( "Home Page", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for the Home page.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-home' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_html( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-home' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'home';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_news" name="sitemap[sitemap-news]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-news'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_news" class="ml-1"><?php echo esc_html__( "Google News", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#news_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "Only if you have a News website. Make sure you submit your website to %sGoogle News%s first.", 'squirrly-seo' ), '<a href="https://support.google.com/news/publisher-center/answer/9607025" target="_blank">', '</a>' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-news' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-news' ) ) . '</strong></a>' ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_post" name="sitemap[sitemap-post]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-post'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_post" class="ml-1"><?php echo esc_html__( "Posts", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your posts.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-posts' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-posts' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'post';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_attachment" name="sitemap[sitemap-attachment]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-attachment'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_attachment" class="ml-1"><?php echo esc_html__( "Attachments", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Recommended if you have a photography website.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-attachment' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-attachment' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'attachment';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_category" name="sitemap[sitemap-category]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-category'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_category" class="ml-1"><?php echo esc_html__( "Categories", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your post categories.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-category' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-category' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'category';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_post_tag" name="sitemap[sitemap-post_tag]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-post_tag'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_post_tag" class="ml-1"><?php echo esc_html__( "Tags", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your post tags.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-post_tag' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-post_tag' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'tag';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_page" name="sitemap[sitemap-page]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-page'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_page" class="ml-1"><?php echo esc_html__( "Pages", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your pages.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-page' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-page' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'page';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_archive" name="sitemap[sitemap-archive]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-archive'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_archive" class="ml-1"><?php echo esc_html__( "Archive", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your archive links.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-archive' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-archive' ) ) . '</strong></a>' ?></div>
														<?php
														$pname = 'archive';
														if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                            <div class="small text-danger ml-5">
                                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																	<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                </a>
                                                            </div>
														<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_custom-tax" name="sitemap[sitemap-custom-tax]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-custom-tax'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_custom-tax" class="ml-1"><?php echo esc_html__( "Custom Taxonomies", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your custom post type categories and tags.", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-tax' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-tax' ) ) . '</strong></a>' ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="checkbox" id="sq_sitemap_custom-post" name="sitemap[sitemap-custom-post]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-custom-post'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                        <label for="sq_sitemap_custom-post" class="ml-1"><?php echo esc_html__( "Custom Posts", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your custom post types (other than WordPress posts and pages).", 'squirrly-seo' ); ?></div>
                                                        <div class="small text-black-50 ml-5"><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-post' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-post' ) ) . '</strong></a>' ?></div>
                                                    </div>
                                                </div>
                                            </div>

											<?php if ( SQ_Classes_Helpers_Tools::isEcommerce() ) { //check for ecommerce product ?>
                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="checker col-12 row m-0 p-0">
                                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                            <input type="checkbox" id="sq_sitemap_product" name="sitemap[sitemap-product]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-product'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                            <label for="sq_sitemap_product" class="ml-1"><?php echo esc_html__( "Products", 'squirrly-seo' ); ?>
                                                                <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#product_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                            </label>
                                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your e-commerce products.", 'squirrly-seo' ); ?></div>
															<?php
															$pname = 'product';
															if ( isset( $patterns[ $pname ]['do_sitemap'] ) && ! $patterns[ $pname ]['do_sitemap'] ) { ?>
                                                                <div class="small text-danger ml-5">
                                                                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( "#tab=sq_$pname" ) ) ) ?>">
																		<?php echo esc_html__( "Deactivated from SEO Automation.", 'squirrly-seo' ); ?>
                                                                    </a>
                                                                </div>
															<?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
											<?php } ?>
                                        </div>

                                        <div class="col-12 m-0 p-0">
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_show[images]" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_show_images" name="sq_sitemap_show[images]" class="sq-switch" <?php echo( ( $sitemapshow['images'] ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                                        <label for="sq_sitemap_show_images" class="ml-1"><?php echo esc_html__( "Include Images in Sitemap", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#image_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the image tag for each post with feature image to index your images in Google Image Search.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_show[videos]" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_show_video" name="sq_sitemap_show[videos]" class="sq-switch" <?php echo( ( $sitemapshow['videos'] ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                                        <label for="sq_sitemap_show_video" class="ml-1"><?php echo esc_html__( "Include Videos in Sitemap", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#video_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the video tag for each post with embed video in it.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_ping" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_ping" name="sq_sitemap_ping" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_ping' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                                        <label for="sq_sitemap_ping" class="ml-1"><?php echo esc_html__( "Ping New Posts to Search Engines", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#ping_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Ping your sitemap to Search Engines when a new post is published.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_exclude_noindex" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_exclude_noindex" name="sq_sitemap_exclude_noindex" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                                        <label for="sq_sitemap_exclude_noindex" class="ml-1"><?php echo esc_html__( "Automatically Exclude URLs With 'Noindex'", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "This feature automatically removes URLs marked as 'Noindex' from your sitemap, ensuring they are not included in search engine indexing.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sitemap_do_cache" value="0"/>
                                                        <input type="checkbox" id="sq_sitemap_do_cache" name="sq_sitemap_do_cache" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_do_cache' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                                        <label for="sq_sitemap_do_cache" class="ml-1"><?php echo esc_html__( "Use Cache to Enhance Loading Speed", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Enhance the website's loading speed and conserve the server resources by using this option, which involves storing a pre-generated copy of your sitemap data.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="col-4 m-0 p-0">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Sitemap Pagination", 'squirrly-seo' ); ?>
                                                        :
                                                        <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#sitemap_pagination" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </div>
                                                    <div class="small text-black-50"><?php echo esc_html__( "Split the sitemap records in pages to prevent slow sitemap loading.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group">
                                                    <select name="sq_sitemap_perpage" class="form-control bg-input mb-1 border">
                                                        <option value="5" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '5' ) ? 'selected="selected"' : '' ); ?>>
                                                            5
                                                        </option>
                                                        <option value="10" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '10' ) ? 'selected="selected"' : '' ); ?>>
                                                            10
                                                        </option>
                                                        <option value="50" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '50' ) ? 'selected="selected"' : '' ); ?>>
                                                            50
                                                        </option>
                                                        <option value="100" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '100' ) ? 'selected="selected"' : '' ); ?>>
                                                            100
                                                        </option>
                                                        <option value="500" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '500' ) ? 'selected="selected"' : '' ); ?>>
                                                            500
                                                        </option>
                                                        <option value="1000" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '1000' ) ? 'selected="selected"' : '' ); ?>>
                                                            1000
                                                        </option>
                                                        <option value="5000" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_perpage' ) == '5000' ) ? 'selected="selected"' : '' ); ?>>
                                                            5000
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

											<?php do_action( 'sq_tweaks_sitemap_after' ); ?>

                                            <div class="col-12 m-0 p-0 mt-5">
                                                <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="links" class="col-12 py-0 px-4 m-0 tab-panel">
                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "SEO Links & Redirects", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#post_types" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                        </h3>
                                        <div class="col-12 small m-0 p-0">
											<?php echo esc_html__( "Increase the website authority by not sending authority to all external links.", 'squirrly-seo' ); ?>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_attachment_redirect" value="0"/>
                                                    <input type="checkbox" id="sq_attachment_redirect" name="sq_attachment_redirect" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_attachment_redirect' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_attachment_redirect" class="ml-1"><?php echo esc_html__( "Redirect Attachments Page", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-links/#redirect_attachments" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Redirect the attachment page to its image URL.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Recommended if your website is not a photography website.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_external_nofollow" value="0"/>
                                                    <input type="checkbox" id="sq_external_nofollow" name="sq_external_nofollow" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_external_nofollow' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_external_nofollow" class="ml-1"><?php echo esc_html__( "Add Nofollow to external links", 'squirrly-seo' ); ?>
                                                        (BETA)
                                                        <a href="https://howto12.squirrly.co/kb/seo-links/#nofollow_external" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the 'nofollow' attribute to all external links and stop losing authority.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_external_blank" value="0"/>
                                                    <input type="checkbox" id="sq_external_blank" name="sq_external_blank" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_external_blank' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_external_blank" class="ml-1"><?php echo esc_html__( "Open external links in New Tab", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-links/#newtab_external" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the '_blank' attribute to all external links to open them in a new tab.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 h-100 my-4">
                                            <div class="col-4 p-0 pr-3 font-weight-bold">
												<?php echo esc_html__( "Domain Exception", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/seo-links/#external_domain_exception" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Add external links for who you don't want to apply the nofollow.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 p-0 form-group">
                                                <textarea class="form-control" name="links_permission" rows="5"><?php echo esc_html( implode( PHP_EOL, (array) SQ_Classes_Helpers_Tools::getOption( 'sq_external_exception' ) ) ); ?></textarea>
                                            </div>
                                        </div>

										<?php do_action( 'sq_tweaks_links_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>


                                        <div class="col-12 m-0 p-0 my-4">
                                            <h3 class="card-title"><?php echo esc_html__( "Redirect Broken URLs", 'squirrly-seo' ); ?></h3>

                                            <div class="col-12 m-0 p-0 mt-3">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation#tab=sq_post' ) ?>" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( " Manage redirects for each Post Type", 'squirrly-seo' ); ?>
                                                    <i class="fa-solid fa-link"></i></a>
                                            </div>

                                            <div class="sq_tips col-12 m-0 p-0 my-5">
                                                <h5 class="text-left my-3 font-weight-bold">
                                                    <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips: How to redirect broken URLs?", 'squirrly-seo' ); ?>
                                                </h5>
                                                <ul class="mx-4">
                                                    <li class="text-left"><?php echo sprintf( esc_html__( "Use the %s SEO Automation %s to set up the broken URLs redirect if you change a post/page slug.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '" target="_blank" >', '</a>' ); ?></li>
                                                    <li class="text-left"><?php echo esc_html__( "Squirrly SEO will add a 301 redirect to the new slug without losing any SEO authority.", 'squirrly-seo' ); ?></li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div id="robots" class="col-12 py-0 px-4 m-0 tab-panel">
                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Robots File", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/robots-txt-settings/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="col-12 small m-0 p-0">
											<?php echo esc_html__( "A robots.txt file tells search engine crawlers which pages or files the crawler can or can't request from your site.", 'squirrly-seo' ); ?>
                                        </div>
                                        <div class="small text-black-50 my-1 pr-3"><?php echo '<a href="'.esc_url( home_url('robots.txt')).'" target="_blank">'.esc_url( home_url('robots.txt')).'</a>' ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0 my-5">
                                        <div class="col-4 p-0 pr-3 font-weight-bold">
											<?php echo esc_html__( "Edit the Robots.txt data", 'squirrly-seo' ); ?>:
                                            <a href="https://howto12.squirrly.co/kb/robots-txt-settings/#default_robots" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Does not physically create the robots.txt file. The best option for WP Multisite.", 'squirrly-seo' ), '<a href="https://developers.facebook.com/apps/" target="_blank"><strong>', '</strong></a>' ); ?></div>
                                        </div>

                                        <div class="col-8 p-0 m-0 form-group">
                                            <?php
	                                            $robots_permission = SQ_Classes_Helpers_Tools::getOption( 'sq_robots_permission' );

                                                if ( ! empty( $robots_permission ) ) {
	                                                $robots_permission = implode( PHP_EOL, (array) $robots_permission );
                                                } else {
                                                    $robots_permission = '';
                                                }
                                            ?>
                                            <textarea class="form-control" name="robots_permission" rows="10"><?php echo $robots_permission ?></textarea>

                                            <div class="col-12 py-3 px-0 text-danger">
												<?php echo esc_html__( "Edit the Robots.txt only if you know what you're doing. Adding wrong rules in Robots can lead to SEO ranking errors or block your posts in Google.", 'squirrly-seo' ); ?>
                                            </div>
                                        </div>

										<?php do_action( 'sq_tweaks_robots_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>

                                </div>
                                <div id="llms" class="col-12 py-0 px-4 m-0 tab-panel">
                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "LLMs File", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/llms-txt-settings/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="col-12 small m-0 p-0">
											<?php echo esc_html__( "Enable and configure rules for AI crawlers and language models, controlling how your site’s content can be accessed and used by AI search engines.", 'squirrly-seo' ); ?>
                                        </div>
                                        <div class="small text-black-50 my-1 pr-3"><?php echo '<a href="'.esc_url( home_url('llms.txt')).'" target="_blank">'.esc_url( home_url('llms.txt')).'</a>' ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0 my-5">
                                        <div class="col-4 p-0 pr-3 font-weight-bold">
											<?php echo esc_html__( "Edit the Llms.txt data", 'squirrly-seo' ); ?>:
                                            <a href="https://howto12.squirrly.co/kb/llms-txt-settings/#default" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Does not physically create the llms.txt file. The best option for WP Multisite.", 'squirrly-seo' ), '<a href="https://developers.facebook.com/apps/" target="_blank"><strong>', '</strong></a>' ); ?></div>
                                        </div>

                                        <div class="col-8 p-0 m-0 form-group">
                                            <?php
	                                            $llms_permission = SQ_Classes_Helpers_Tools::getOption( 'sq_llms_permission' );

                                                if ( ! empty( $llms_permission ) ) {
                                                    $llms_permission = implode( PHP_EOL, (array) $llms_permission );
                                                } else{
                                                    $llms_permission = '';
                                                }
                                            ?>
                                            <textarea class="form-control" name="llms_permission" rows="10"><?php echo $llms_permission ?></textarea>

                                            <div class="col-12 py-3 px-0 text-danger">
												<?php echo esc_html__( "Edit the Llms.txt only if you know what you're doing. Adding wrong rules in LLMs can lead to SEO ranking errors or block AI indexing.", 'squirrly-seo' ); ?>
                                            </div>
                                        </div>

										<?php do_action( 'sq_tweaks_llms_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>

                                </div>
                                <div id="favicon" class="col-12 py-0 px-4 m-0 tab-panel">
                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Website Icon", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/website-favicon-settings/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="col-12 small m-0 p-0">
											<?php echo esc_html__( "Add your website icon in the browser tabs and on other devices like iPhone, iPad and Android phones.", 'squirrly-seo' ); ?>
                                        </div>
                                    </div>

                                    <div class="col-12 row m-0 p-0 my-5">
                                        <div class="col-12 row m-0 p-0 my-4">
                                            <div class="col-4 p-0 pr-3">
                                                <div class="font-weight-bold"><?php echo esc_html__( "Upload file", 'squirrly-seo' ); ?>
                                                    :
                                                    <a href="https://howto12.squirrly.co/kb/website-favicon-settings/#upload_icon" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                </div>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Upload a jpg, jpeg, png or ico file.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-1 m-0 p-2 text-center input-group">
												<?php if ( SQ_Classes_Helpers_Tools::getOption( 'favicon' ) <> '' && file_exists( _SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) ) ) { ?>
                                                    <img src="<?php echo esc_url( _SQ_CACHE_URL_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) ) ?>" alt="" style="float: left; margin-top: 1px;width: 32px;height: 32px;"/>
												<?php } ?>
                                            </div>
                                            <div class="col-7 m-0 p-0 input-group">
                                                <div class="form-group my-2">
                                                    <input type="file" class="form-control-file" name="favicon">
                                                </div>
                                                <button type="submit" class="btn btn-sm rounded-0 btn-primary px-2 mx-1" style="min-width: 90px"><?php echo esc_html__( "Upload", 'squirrly-seo' ); ?></button>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_favicon_apple" value="0"/>
                                                    <input type="checkbox" id="sq_favicon_apple" name="sq_favicon_apple" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_favicon_apple' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_favicon_apple" class="ml-1"><?php echo esc_html__( "Add Apple Touch Icons", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/website-favicon-settings/#apple_icon" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Also load the favicon for Apple devices.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row py-2 mx-0 my-3">
                                            <span class="col-12 px-0 small text-black-50 font-italic">- <?php echo esc_html__( "If you don't see the new icon in your browser, empty the browser cache and refresh the page.", 'squirrly-seo' ); ?></span>
                                            <span class="col-12 px-0 small text-black-50 font-italic">- <?php echo esc_html__( "Accepted file types: JPG, JPEG, GIF and PNG.", 'squirrly-seo' ); ?></span>
                                            <span class="col-12 px-0 small text-black-50 font-italic">- <?php echo esc_html__( "Does not physically create the favicon.ico file. The best option for Multisites.", 'squirrly-seo' ); ?></span>
                                        </div>

										<?php do_action( 'sq_tweaks_favicon_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>
                                    </div>
                                </div>

                                <div id="advanced" class="col-12 py-0 px-4 m-0 tab-panel">
                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Advanced Settings", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/advanced-seo-settings/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">


                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_use_frontend" value="0"/>
                                                    <input type="checkbox" id="sq_use_frontend" name="sq_use_frontend" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_use_frontend' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_use_frontend" class="ml-1"><?php echo esc_html__( "Load SEO Snippet in Frontend", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-Snippet-in-Frontend" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Load Squirrly SEO Snippet in Frontend to customize the SEO directly from page preview.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_use_backend" value="0"/>
                                                    <input type="checkbox" id="sq_use_backend" name="sq_use_backend" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_use_backend' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_use_backend" class="ml-1"><?php echo esc_html__( "Load Squirrly Admin Bar in Backend", 'squirrly-seo' ); ?></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Load Squirrly SEO in the admin bar of the backend for convenient access to its features.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_use_dashboard" value="0"/>
                                                    <input type="checkbox" id="sq_use_dashboard" name="sq_use_dashboard" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_use_dashboard' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_use_dashboard" class="ml-1"><?php echo esc_html__( "Load Squirrly Widget in Admin Dashboard", 'squirrly-seo' ); ?></label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Embed the Squirrly SEO goals widget within the admin dashboard to provide a quick overview of daily SEO objectives.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_load_css" value="0"/>
                                                    <input type="checkbox" id="sq_load_css" name="sq_load_css" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_load_css' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_load_css" class="ml-1"><?php echo esc_html__( "Load Squirrly Frontend CSS", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/advanced-seo-settings/#frontend_css" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Load Squirrly SEO CSS for article inserted from Squirrly Blogging Assistant.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_minify" value="0"/>
                                                    <input type="checkbox" id="sq_minify" name="sq_minify" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_minify' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_minify" class="ml-1"><?php echo esc_html__( "Minify Squirrly SEO Metas", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/advanced-seo-settings/#minify_metas" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Minify the METAs in source code to optimize the page load time.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Remove comments and newlines from Squirrly SEO Metas.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_laterload" value="0"/>
                                                    <input type="checkbox" id="sq_laterload" name="sq_laterload" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_laterload' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_laterload" class="ml-1"><?php echo esc_html__( "Load Squirrly SEO Late Buffer", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/advanced-seo-settings/#late_loading_buffer" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Wait all plugins to load before loading Squirrly SEO frontend buffer.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "For compatibility with some Cache and CDN plugins.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_non_utf8_support" value="0"/>
                                                        <input type="checkbox" id="sq_non_utf8_support" name="sq_non_utf8_support" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                        <label for="sq_non_utf8_support" class="ml-1"><?php echo esc_html__( "Multilingual Support", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/advanced-seo-settings/#late_loading_buffer" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Convert the other encodings to UTF8 and avoid ajax errors.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
										<?php } ?>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_complete_uninstall" value="0"/>
                                                    <input type="checkbox" id="sq_complete_uninstall" name="sq_complete_uninstall" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_complete_uninstall' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_complete_uninstall" class="ml-1"><?php echo esc_html__( "Delete Squirrly SEO Table on Uninstall", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/advanced-seo-settings/#delete_uninstall" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Delete Squirrly SEO table and options on uninstall.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_tweaks_advanced_after' ); ?>

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
                        <li class="text-left"><?php echo esc_html__( "You have the option to choose the post types for which you want Squirrly to build a sitemap. If you don’t use a post type, there’s NO reason why you should activate the option for it.", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo sprintf( esc_html__( "Use the %s SEO Automation %s to set up the broken URLs redirect if you change a post/page slug.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '" target="_blank">', '</a>' ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Squirrly SEO will add a 301 redirect to the new slug without losing any SEO authority.", 'squirrly-seo' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php echo SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_tweaks_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
