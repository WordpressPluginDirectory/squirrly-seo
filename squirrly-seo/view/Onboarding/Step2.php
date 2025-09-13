<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>

    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>

        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">

                <div class="col-12 p-0 m-0 mb-5">
					<?php $view->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ); ?>

                    <div class="col-12 p-0 m-0 mt-5 mb-3 text-center">
                        <div class="group_autoload d-flex justify-content-center btn-group btn-group-lg mt-3" role="group">
                            <div class="font-weight-bold" style="font-size: 1.2rem">
                                <span class="sq_logo sq_logo_30 align-top mr-2"></span><?php echo esc_html__( "Your Private SEO Consultant Sets Up the SEO for Your WordPress", 'squirrly-seo' ); ?>
                                :
                            </div>
                        </div>
                    </div>
                    <div id="sq_onboarding" class="col-8 row my-0 mx-auto p-0">
                        <form id="sq_onboarding_form" method="post" action="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'step3' ) ) ?>" class="p-0 m-0">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_onboarding_save' ); ?>
                            <input type="hidden" name="action" value="sq_onboarding_save"/>


							<?php
							$patterns    = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
							$sitemap     = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap' );
							$sitemapshow = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_show' );
							$socials     = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'socials' ) ) );
							?>

                            <h3 class="card-title mt-4">
                                <span class="checker col-12 row m-0 p-0">
                                    <span class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <span class=""><?php echo esc_html__( "Sitemaps XML", 'squirrly-seo' ); ?></span>
                                        <input type="hidden" name="sq_auto_sitemap" value="0"/>
                                        <input type="checkbox" id="sq_auto_sitemap" name="sq_auto_sitemap" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_sitemap" class="ml-2 mt-1"></label>
                                    </span>
                                </span>
                            </h3>
                            <div class="sq_auto_sitemap">
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_home" name="sitemap[sitemap-home]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-home'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_home" class="ml-1"><?php echo esc_html__( "Home Page", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for the Home page.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-home' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-home' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_news" name="sitemap[sitemap-news]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-news'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_news" class="ml-1"><?php echo esc_html__( "Google News", 'squirrly-seo' ); ?>
                                                <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#news_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </label>
                                            <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "Only if you have a News website. Make sure you submit your website to %sGoogle News%s first.", 'squirrly-seo' ), '<a href="https://support.google.com/news/publisher-center/answer/9607025" target="_blank">', '</a>' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-news' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-news' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_post" name="sitemap[sitemap-post]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-post'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_post" class="ml-1"><?php echo esc_html__( "Posts", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your posts.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-posts' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-posts' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_attachment" name="sitemap[sitemap-attachment]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-attachment'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_attachment" class="ml-1"><?php echo esc_html__( "Attachments", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Recommended if you have a photography website.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-attachment' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-attachment' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_category" name="sitemap[sitemap-category]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-category'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_category" class="ml-1"><?php echo esc_html__( "Categories", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your post categories.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-category' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-category' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_post_tag" name="sitemap[sitemap-post_tag]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-post_tag'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_post_tag" class="ml-1"><?php echo esc_html__( "Tags", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your post tags.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-post_tag' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-post_tag' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_page" name="sitemap[sitemap-page]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-page'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_page" class="ml-1"><?php echo esc_html__( "Pages", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your pages.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-page' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-page' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_archive" name="sitemap[sitemap-archive]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-archive'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_archive" class="ml-1"><?php echo esc_html__( "Archive", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your archive links.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-archive' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-archive' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_custom-tax" name="sitemap[sitemap-custom-tax]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-custom-tax'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_custom-tax" class="ml-1"><?php echo esc_html__( "Custom Taxonomies", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your custom post type categories and tags.", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-tax' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-tax' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="checkbox" id="sq_sitemap_custom-post" name="sitemap[sitemap-custom-post]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-custom-post'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                            <label for="sq_sitemap_custom-post" class="ml-1"><?php echo esc_html__( "Custom Posts", 'squirrly-seo' ); ?></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your custom post types (other than WordPress posts and pages).", 'squirrly-seo' ); ?><?php echo '<a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-post' ) ) . '" target="_blank" style="font-size: 13px; text-decoration: none; color: #999;"><strong>' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getXmlUrl( 'sitemap-custom-post' ) ) . '</strong></a>' ?></div>
                                        </div>
                                    </div>
                                </div>

								<?php if ( SQ_Classes_Helpers_Tools::isEcommerce() ) { //check for ecommerce product ?>
                                    <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                        <div class="checker col-12 row m-0 p-0 ml-4">
                                            <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                <input type="checkbox" id="sq_sitemap_product" name="sitemap[sitemap-product]" class="sq-switch" value="1" <?php echo( ( $sitemap['sitemap-product'][1] == 1 ) ? 'checked="checked"' : '' ); ?> />
                                                <label for="sq_sitemap_product" class="ml-1"><?php echo esc_html__( "Products", 'squirrly-seo' ); ?>
                                                    <a href="https://howto12.squirrly.co/kb/sitemap-xml-settings/#product_sitemap" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                </label>
                                                <div class="small text-black-50 ml-5"><?php echo esc_html__( "Build the sitemap for your e-commerce products.", 'squirrly-seo' ); ?></div>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>

                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
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
                                    <div class="checker col-12 row m-0 p-0 ml-4">
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
                                    <div class="checker col-12 row m-0 p-0 ml-4">
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
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="sq_sitemap_exclude_noindex" value="0"/>
                                            <input type="checkbox" id="sq_sitemap_exclude_noindex" name="sq_sitemap_exclude_noindex" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                            <label for="sq_sitemap_exclude_noindex" class="ml-1"><?php echo esc_html__( "Automatically exclude from sitemap the URLs with 'Noindex'", 'squirrly-seo' ); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="card-title mt-4">
                                <span class="checker col-12 row m-0 p-0">
                                    <span class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <span class=""><?php echo esc_html__( "Robots.txt", 'squirrly-seo' ); ?></span>
                                        <input type="hidden" name="sq_auto_robots" value="0"/>
                                        <input type="checkbox" id="sq_auto_robots" name="sq_auto_robots" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_robots" class="ml-2 mt-1"></label>
                                    </span>
                                    <span class="col-12 row m-0 p-0 sq_auto_robots">
                                        <span class="small text-black-50"><?php echo esc_html__( "A robots.txt file tells search engine crawlers which pages or files the crawler can or can't request from your site.", 'squirrly-seo' ); ?></span>
                                    </span>
                                </span>
                            </h3>

                            <h3 class="card-title mt-4">
                                <span class="checker col-12 row m-0 p-0">
                                    <span class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <span class=""><?php echo esc_html__( "Llms.txt", 'squirrly-seo' ); ?></span>
                                        <input type="hidden" name="sq_auto_llms" value="0"/>
                                        <input type="checkbox" id="sq_auto_llms" name="sq_auto_llms" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_llms' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_llms" class="ml-2 mt-1"></label>
                                    </span>
                                    <span class="col-12 row m-0 p-0 sq_auto_llms">
                                        <span class="small text-black-50"><?php echo esc_html__( "Control how AI search engines and language model crawlers can access and use your website’s content.", 'squirrly-seo' ); ?></span>
                                    </span>
                                </span>
                            </h3>


                            <h3 class="card-title mt-4">
                                <span class="checker col-12 row m-0 p-0">
                                    <span class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <span class=""><?php echo esc_html__( "SEO METAs", 'squirrly-seo' ); ?></span>
                                        <input type="hidden" name="sq_auto_metas" value="0"/>
                                        <input type="checkbox" id="sq_auto_metas" name="sq_auto_metas" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_metas" class="ml-2 mt-1"></label>
                                    </span>
                                    <span class="col-12 row m-0 p-0 sq_auto_metas">
                                        <span class="small text-black-50"><?php echo esc_html__( "Add all Search Engine METAs like Title, Description, Canonical Link, Dublin Core, Robots and more.", 'squirrly-seo' ); ?></span>
                                    </span>
                                </span>
                            </h3>

                            <div class="col-12 row m-0 p-0 my-5 sq_auto_metas">
                                <div class="checker col-12 row m-0 p-0 ml-4">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_auto_title" value="0"/>
                                        <input type="checkbox" id="sq_auto_title" name="sq_auto_title" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_title" class="ml-1"><?php echo esc_html__( "Optimize the Titles", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/seo-metas/#Optimize-The-Titles" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Title Tag in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", 'squirrly-seo' ); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5 sq_auto_metas">
                                <div class="checker col-12 row m-0 p-0 ml-4">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_auto_description" value="0"/>
                                        <input type="checkbox" id="sq_auto_description" name="sq_auto_description" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_description" class="ml-1"><?php echo esc_html__( "Optimize Descriptions", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/seo-metas/#Optimize-The-Description" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Description meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", 'squirrly-seo' ); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="sq_auto_metas">
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
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
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="sq_auto_canonical" value="0"/>
                                            <input type="checkbox" id="sq_auto_canonical" name="sq_auto_canonical" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_canonical' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                            <label for="sq_auto_canonical" class="ml-1"><?php echo esc_html__( "Add Canonical Meta Link", 'squirrly-seo' ); ?>
                                                <a href="https://howto12.squirrly.co/kb/seo-metas/#Add-Canonical-Meta-Link" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add canonical link meta in the page header. You can customize the canonical link on each page.", 'squirrly-seo' ); ?></div>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Also add prev & next links METAs in the page header when navigate between blog pages.", 'squirrly-seo' ); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
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
                                    <div class="checker col-12 row m-0 p-0 ml-4">
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
                            </div>
                            <h3 class="card-title mt-4"><?php echo esc_html__( "Social Media", 'squirrly-seo' ); ?></h3>

                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="checker col-12 row m-0 p-0 ml-4">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_auto_facebook" value="0"/>
                                        <input type="checkbox" id="sq_auto_facebook" name="sq_auto_facebook" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                        <label for="sq_auto_facebook" class="ml-1"><?php echo esc_html__( "Activate Open Graph", 'squirrly-seo' ); ?></label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Social Open Graph protocol so that your Facebook shares look good.", 'squirrly-seo' ); ?></div>
                                        <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "You can always update an URL on Facebook if you change its Social Media Image. Visit %sOpen Graph Debugger%s", 'squirrly-seo' ), '<a href="https://developers.facebook.com/tools/debug/?q=' . esc_url( home_url() ) . '" target="_blank" ><strong>', '</strong></a>' ); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row m-0 p-0 my-5">
                                <div class="checker col-12 row m-0 p-0 ml-4">
                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <input type="hidden" name="sq_auto_twitter" value="0"/>
                                        <input type="checkbox" id="sq_auto_twitter" name="sq_auto_twitter" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                        <label for="sq_auto_twitter" class="ml-1"><?php echo esc_html__( "Activate Twitter Card", 'squirrly-seo' ); ?></label>
                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the Twitter Card in your tweets so that your Twitter shares look good.", 'squirrly-seo' ); ?></div>
                                        <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "Make sure you validate the twitter card with your Twitter account. Visit %sTwitter Card Validator%s", 'squirrly-seo' ), '<a href="https://cards-dev.twitter.com/validator?url=' . esc_url( home_url() ) . '" target="_blank" ><strong>', '</strong></a>' ); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="sq_auto_twitter">
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="socials[twitter_card_type]" value="summary"/>
                                            <input type="checkbox" id="twitter_card_type" name="socials[twitter_card_type]" class="sq-switch" <?php echo( $socials->twitter_card_type == 'summary_large_image' ? 'checked="checked"' : '' ) ?> value="summary_large_image"/>
                                            <label for="twitter_card_type" class="ml-1"><?php echo esc_html__( "Share Large Images", 'squirrly-seo' ); ?>
                                                <a href="https://howto12.squirrly.co/kb/social-media-settings/#twitter_card_large_images" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Activate this option only if you upload images with sizes between 500px and 4096px width in Twitter Card.", 'squirrly-seo' ); ?></div>
                                            <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "This option will show the twitter card image as a shared image and not as a summary. Visit %sSummary Card with Large Image%s", 'squirrly-seo' ), '<a href="https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary-card-with-large-image.html" target="_blank" ><strong>', '</strong></a>' ); ?></div>
                                            <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "Every change needs %sTwitter Card Validator%s", 'squirrly-seo' ), '<a href="https://cards-dev.twitter.com/validator?url=' . esc_url( home_url() ) . '" target="_blank" ><strong>', '</strong></a>' ); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="card-title mt-4">
                                <span class="checker col-12 row m-0 p-0">
                                    <span class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <span class=""><?php echo esc_html__( "Rich Snippets", 'squirrly-seo' ); ?></span>
                                        <input type="hidden" name="sq_auto_jsonld" value="0"/>
                                        <input type="checkbox" id="sq_auto_jsonld" name="sq_auto_jsonld" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_jsonld" class="ml-2 mt-1"></label>
                                    </span>
                                    <span class="col-12 row m-0 p-0 sq_auto_jsonld">
                                        <span class="small text-black-50"><?php echo esc_html__( "JSON-LD structured data influences how Google will create rich snippets for your URLs.", 'squirrly-seo' ); ?></span>
                                    </span>
                                </span>
                            </h3>

                            <div class="sq_auto_jsonld">
                                <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="sq_jsonld_breadcrumbs" value="0"/>
                                            <input type="checkbox" id="sq_jsonld_breadcrumbs" name="sq_jsonld_breadcrumbs" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_breadcrumbs' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                            <label for="sq_jsonld_breadcrumbs" class="ml-1"><?php echo esc_html__( "Add Breadcrumbs in Json-LD", 'squirrly-seo' ); ?>
                                                <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#breadcrumbs_schema" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </label>
                                            <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add the BreadcrumbsList Schema into Json-LD including all parent categories.", 'squirrly-seo' ); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="card-title mt-4">
                                <span class="checker col-12 row m-0 p-0">
                                    <span class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                        <span class=""><?php echo esc_html__( "SEO Automation", 'squirrly-seo' ); ?></span>
                                        <input type="hidden" name="sq_auto_pattern" value="0"/>
                                        <input type="checkbox" id="sq_auto_pattern" name="sq_auto_pattern" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="sq_auto_pattern" class="ml-2 mt-1"></label>
                                    </span>
                                    <span class="col-12 row m-0 p-0 sq_auto_pattern">
                                        <span class="small text-black-50"><?php echo esc_html__( "Use the Pattern system to prevent Title and Description duplicates between posts.", 'squirrly-seo' ); ?></span>
                                    </span>
                                </span>
                            </h3>

                            <div class="sq_auto_jsonld">
                                <h3 class="card-title mt-4"><?php echo esc_html__( "Extra Options", 'squirrly-seo' ); ?></h3>

                                <div class="col-12 row m-0 p-0 my-5">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="sq_auto_jsonld_local" value="0"/>
                                            <input type="checkbox" id="sq_auto_jsonld_local" name="sq_auto_jsonld_local" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                            <label for="sq_auto_jsonld_local" class="ml-1"><?php echo esc_html__( "Local SEO", 'squirrly-seo' ); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="sq_jsonld_woocommerce" value="0"/>
                                            <input type="checkbox" id="sq_jsonld_woocommerce" name="sq_jsonld_woocommerce" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_woocommerce' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                            <label for="sq_jsonld_woocommerce" class="ml-1"><?php echo esc_html__( "E-commerce", 'squirrly-seo' ); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row m-0 p-0 my-5">
                                    <div class="checker col-12 row m-0 p-0 ml-4">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="sq_jsonld_personal" value="0"/>
                                            <input type="checkbox" id="sq_jsonld_personal" name="sq_jsonld_personal" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_personal' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                            <label for="sq_jsonld_personal" class="ml-1"><?php echo esc_html__( "Personal Brand Rich Snippets", 'squirrly-seo' ); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 m-0 p-0 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save & Continue", 'squirrly-seo' ); ?>
                                    >>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
        </div>
    </div>
</div>

