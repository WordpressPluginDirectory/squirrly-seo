<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Knowledge Base Block view
 *
 * Called from all views with Knowledge Base
 */
?>
<?php if ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ) ) { ?>
	<?php $page = apply_filters( 'sq_page', SQ_Classes_Helpers_Tools::getValue( 'page', '' ) ); ?>
	<?php $tab = SQ_Classes_Helpers_Tools::getValue( 'tab', '' ); ?>
    <div class="sq_knowledge p-0 m-0 pb-5">
		<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) { ?>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-left">
                    <a href="https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#connect_to_cloud" target="_blank">Why
                        connect to Squirrly Cloud?</a>
                </li>
                <li class="list-group-item text-left">
                    <a href="https://howto12.squirrly.co/wordpress-seo/squirrly-seo-error-messages/" target="_blank">I
                        <strong>receive an error</strong> while login.</a>
                </li>
            </ul>
		<?php } elseif ( $page == 'sq_onboarding' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_onboardinghelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">How
                                        to set the SEO in just 2 minutes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize-social-media.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="text-dark" target="_blank">How
                                        to optimize Social Media for each post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/rich-snippets.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="text-dark" target="_blank">How
                                        to activate Rich Snippets for Google</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/activate_amp_support.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" class="text-dark" target="_blank">How
                                        to activate AMP Support</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_onpagesetup' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_onpagesetuphelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/import_seo.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" class="text-dark" target="_blank">How
                                        to <strong>Import SEO</strong> from other SEO plugins</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#top_10_race" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/get_on_top_10.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#top_10_race" class="text-dark" target="_blank">How
                                        to get on <strong>TOP 10 Google</strong>?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/next-seo-goals/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/use_next_seo_goals.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/next-seo-goals/" class="text-dark" target="_blank">How
                                        to use <strong>Next SEO Goals</strong>?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize_a_post_with_briefcase.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" class="text-dark" target="_blank">How
                                        to optimize a post with Briefcase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_dashboard' || $page == 'sq_checkseo' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_dashboardhelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/import_seo.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" class="text-dark" target="_blank">How
                                        to <strong>Import SEO</strong> from other SEO plugins</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#top_10_race" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/get_on_top_10.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#top_10_race" class="text-dark" target="_blank">How
                                        to get on <strong>TOP 10 Google</strong>?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/next-seo-goals/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/use_next_seo_goals.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/next-seo-goals/" class="text-dark" target="_blank">How
                                        to use <strong>Next SEO Goals</strong>?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize_a_post_with_briefcase.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" class="text-dark" target="_blank">How
                                        to optimize a post with Briefcase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_research' && $tab == 'research' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_briefcasehelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/marketingtools/google-100-cares-about-keywords/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/google-cares.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/marketingtools/google-100-cares-about-keywords/" class="text-dark" target="_blank">
                                        Google Wants to See Keywords In Your Pages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/keyword-research-and-seo-strategy/#find_new_keywords" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/keyword-strategy.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/keyword-research-and-seo-strategy/#find_new_keywords" class="text-dark" target="_blank">How
                                        to Find New Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/ht_kb/140-countries-for-which-you-can-use-the-keyword-research-tool/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/140-languages.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/ht_kb/140-countries-for-which-you-can-use-the-keyword-research-tool/" class="text-dark" target="_blank">140
                                        Countries for Which You Can Use the Keyword Research Tool</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/how-to-write-a-long-tail-keyword/ " class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/long-tail-keyword.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/how-to-write-a-long-tail-keyword/ " class="text-dark" target="_blank">How
                                        To Write a Long Tail Keyword</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_research' && $tab == 'briefcase' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_briefcasehelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/marketingtools/google-100-cares-about-keywords/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/google-cares.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/marketingtools/google-100-cares-about-keywords/" class="text-dark" target="_blank">
                                        Google Wants to See Keywords In Your Pages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/keyword-research-and-seo-strategy/#find_new_keywords" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/keyword-strategy.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/keyword-research-and-seo-strategy/#find_new_keywords" class="text-dark" target="_blank">How
                                        to Find New Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_keyword_info" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/more-info-about-briefcase.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_keyword_info" class="text-dark" target="_blank">How
                                        to Access More Info about your Briefcase Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/how-to-write-a-long-tail-keyword/ " class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/long-tail-keyword.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/how-to-write-a-long-tail-keyword/ " class="text-dark" target="_blank">How
                                        To Write a Long Tail Keyword</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_research' && $tab == 'suggested' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_briefcasehelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/does-squirrly-have-a-long-tail-keyword-finder/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/learn-about-squirrly-keyword-research.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/does-squirrly-have-a-long-tail-keyword-finder/" class="text-dark" target="_blank">Learn
                                        about Squirrly's Keyword Research Assistant</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/seo/#chapter3" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/chapter-2.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/seo/#chapter3" class="text-dark" target="_blank">Understanding
                                        SEO Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/keyword-research-and-seo-strategy/#suggestions" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/how-to-add-keywords-into-briefcase.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/keyword-research-and-seo-strategy/#suggestions" class="text-dark" target="_blank">How
                                        to Add Suggested Keywords to Briefcase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/training-on-how-to-rank-for-certain-keywords/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/how-to-rank.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/training-on-how-to-rank-for-certain-keywords/" class="text-dark" target="_blank">Training
                                        on How to Rank for Certain Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_research' && $tab == 'history' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_briefcasehelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#history_to_briefcase" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/how-to-add-keywords-into-briefcase.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#history_to_briefcase" class="text-dark" target="_blank">Add
                                        Keywords to Briefcase from Keywords History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#history_to_optimize" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize-for-keyword.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#history_to_optimize" class="text-dark" target="_blank">Optimize
                                        for Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/for-how-many-keywords-can-i-optimize-a-blog-post/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize-for-multiple-keywords.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/for-how-many-keywords-can-i-optimize-a-blog-post/" class="text-dark" target="_blank">Optimize
                                        for Multiple Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/how-does-squirrly-determine-if-a-keyword-is-easy-to-rank-for/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/easy-to-rank.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/how-does-squirrly-determine-if-a-keyword-is-easy-to-rank-for/" class="text-dark" target="_blank">How
                                        Does Squirrly Know if a Keyword is Easy to Rank for?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_research' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_briefcasehelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#labels" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/learn_about_briefcase_labels.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#labels" class="text-dark" target="_blank">Learn
                                        About Squirrly Briefcase Labels</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_add_keyword" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/how-to-add-keywords-into-briefcase.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_add_keyword" class="text-dark" target="_blank">How
                                        to add Keywords into Briefcase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://fourhourseo.com/pro-course-6-how-to-organize-and-manage-your-keyword-portfolio/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/how_to_categorize_keywords.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://fourhourseo.com/pro-course-6-how-to-organize-and-manage-your-keyword-portfolio/" class="text-dark" target="_blank">How
                                        to categorize Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/how_to_backup_keywords.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" class="text-dark" target="_blank">How
                                        to back up/restore Keywords</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_assistant' && $tab == 'settings' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_assistanthelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#copyright_free_images" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add_copyright_free_images.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#copyright_free_images" class="text-dark" target="_blank">How
                                        to add Copyright Free Images</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/why-is-the-squirrly-live-assistant-not-loading-in-the-post-editor/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/checklist.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/why-is-the-squirrly-live-assistant-not-loading-in-the-post-editor/" class="text-dark" target="_blank">Squirrly
                                        Live Assistant not showing</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#after_optimization" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/what_to_do_after_i_optimize_a_post.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#after_optimization" class="text-dark" target="_blank">What
                                        to do after I optimize a post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#automation_custom_lengths" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/customize-lenghts.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#automation_custom_lengths" class="text-dark" target="_blank">How
                                        to Customize the Lengths for Each Meta</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_assistant' && $tab == 'assistant' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_assistanthelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/difference-between-focus-pages-and-the-seo-live-assistant/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/live-assistant-vs-focus-pages.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/difference-between-focus-pages-and-the-seo-live-assistant/" class="text-dark" target="_blank">The
                                        Difference between Focus Pages and the SEO Live Assistant</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/marketingtools/do-on-page-seo-like-a-pro/ " class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/on-page-seo.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/marketingtools/do-on-page-seo-like-a-pro/ " class="text-dark" target="_blank">Do
                                        On-Page SEO Like a PRO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/seo/#chapter4" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/on-page-optimization.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/seo/#chapter4" class="text-dark" target="_blank">An
                                        Introduction to On-Page Optimization</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize_with_squirrly_live_assistant.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" class="text-dark" target="_blank">Optimize
                                        100% with Squirrly Live Assistant</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_seosettings' && $tab == 'metas' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_settingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">How
                                        to set the SEO in just 2 minutes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/marketingtools/the-4-types-of-duplicate-content/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/checklist.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/marketingtools/the-4-types-of-duplicate-content/" class="text-dark" target="_blank">The
                                        4 Types of Duplicate Content</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/seo/#chapter2" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/rich-snippets.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/seo/#chapter2" class="text-dark" target="_blank">Must-have
                                        Meta Tags</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/ht_kb/from-where-can-i-customize-snippets-for-my-pages/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/activate_amp_support.png' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/ht_kb/from-where-can-i-customize-snippets-for-my-pages/" class="text-dark" target="_blank">Multiple
                                        Ways to Customize Your Snippets</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_seosettings' && $tab == 'backup' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_settingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">How
                                        to set the SEO in just 2 minutes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/ht_kb/use-squirrly-in-compatibility-mode-with-other-seo-plugins/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/compatible.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/ht_kb/use-squirrly-in-compatibility-mode-with-other-seo-plugins/" class="text-dark" target="_blank">Use
                                        Squirrly In Compatibility Mode with other SEO Plugins</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/import.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" class="text-dark" target="_blank">How
                                        to Import SEO and Settings from Other Plugins</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#restore_seo" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/restore.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#restore_seo" class="text-dark" target="_blank">How
                                        to Restore Settings and SEO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_seosettings' && $tab == 'webmaster' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_settingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">How
                                        to set the SEO in just 2 minutes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/if-squirrly-takes-data-from-ga-and-gsc-why-cant-i-just-use-those-tools/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/make-data-actionable.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/if-squirrly-takes-data-from-ga-and-gsc-why-cant-i-just-use-those-tools/" class="text-dark" target="_blank">How
                                        Squirrly Helps Make Data Actionable</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/webmaster-tools.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/" class="text-dark" target="_blank">How
                                        to Connect to Different Webmaster Tools</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/amp.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" class="text-dark" target="_blank">How
                                        to activate AMP Support</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_seosettings' && $tab == 'jsonld' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_settingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">How
                                        to set the SEO in just 2 minutes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/special-features-for-local-seo/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/local-seo.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/special-features-for-local-seo/" class="text-dark" target="_blank">Special
                                        Features for Local SEO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/rich-snippets.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="text-dark" target="_blank">How
                                        to activate Rich Snippets for Google</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/how-can-i-make-my-site-stand-out-in-search-results/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/make-your-site-stand-out.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/how-can-i-make-my-site-stand-out-in-search-results/" class="text-dark" target="_blank">Make
                                        Your Site Stand Out In Search Results</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_seosettings' && $tab == 'social' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_settingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">How
                                        to set the SEO in just 2 minutes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize-social-media.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="text-dark" target="_blank">How
                                        to optimize Social Media for each post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/social-media-settings/#social_accounts" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add-social-media.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/social-media-settings/#social_accounts" class="text-dark" target="_blank">How
                                        to Add Your Social Media Accounts</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/how-can-i-control-how-my-posts-look-like-when-i-share-them-on-facebook/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/looks-on-facebook.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/how-can-i-control-how-my-posts-look-like-when-i-share-them-on-facebook/" class="text-dark" target="_blank">Control
                                        How Your Posts Look Like When Shared on Facebook</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_seosettings' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_settingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://www.squirrly.co/seo/#chapter5" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/technical-seo.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://www.squirrly.co/seo/#chapter5" class="text-dark" target="_blank">Technical
                                        SEO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/website-favicon-settings/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/website-icon.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/website-favicon-settings/" class="text-dark" target="_blank">Website
                                        Icon Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/remove-no-index-pages-from-the-sitemap-using-squirrly/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/remove-from-sitemap.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/remove-no-index-pages-from-the-sitemap-using-squirrly/" class="text-dark" target="_blank">How
                                        to Remove no-index Pages from the Sitemap</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/whats-a-sitemap-and-why-do-i-need-one/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/what-is-a-sitemap.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/whats-a-sitemap-and-why-do-i-need-one/" class="text-dark" target="_blank">What's
                                        a Sitemap & Why Do I Need One?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_automation' && $tab == 'settings' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_automationhelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">Learn
                                        to set up your SEO in just 2 minutes.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#automation_custom_lengths" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/customize-lenghts.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#automation_custom_lengths" class="text-dark" target="_blank">How
                                        to Customize the Lengths for Each Meta</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#title_automation" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/title.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#title_automation" class="text-dark" target="_blank">SEO
                                        Automation for Title</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#description_automation" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/description.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#description_automation" class="text-dark" target="_blank">
                                        SEO Automation for Description</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_assistant'  && $tab == 'automation') { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_automationhelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/seo-in-2-minutes.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-automation/" class="text-dark" target="_blank">Learn
                                        to set up your SEO in just 2 minutes.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/optimize-social-media.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="text-dark" target="_blank">How
                                        to optimize Social Media for each post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/rich-snippets.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="text-dark" target="_blank">How
                                        to activate Rich Snippets for Google</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#add_post_type" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/new-post-automation.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-automation/#add_post_type" class="text-dark" target="_blank">How
                                        to Add New Post Types for Automation </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_bulkseo' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_bulkseohelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/bulk-seo/#bulk_seo_features" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/bulk-seo-features.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/bulk-seo/#bulk_seo_features" class="text-dark" target="_blank">Bulk
                                        SEO Features</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_search" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/search.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/bulk-seo/#bulk_seo_search" class="text-dark" target="_blank">How
                                        to Search in BULK SEO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/bulk-seo/#bulk_seo_snippet_metas" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/edit-meta.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/bulk-seo/#bulk_seo_snippet_metas" class="text-dark" target="_blank">How
                                        to Edit the METAs Section</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/bulk-seo/#301_redirect" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/redirect.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/bulk-seo/#301_redirect" class="text-dark" target="_blank">How
                                        to Set Up a 301 Redirect</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<?php } elseif ( $page == 'sq_focuspages' && $tab == 'addpage' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_focuspageshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/focus-pages-page-audits/#what_are_focus_pages" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/what-are-focus-pages.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/focus-pages-page-audits/#what_are_focus_pages" class="text-dark" target="_blank">What
                                        Are Focus Pages?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/can-a-product-page-in-woocommerce-be-used-as-a-focus-page/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/woocommerce-focus-pages.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/can-a-product-page-in-woocommerce-be-used-as-a-focus-page/" class="text-dark" target="_blank">Using
                                        a Product Page in WooCommerce as a Focus Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/what-if-i-replace-my-focus-page-with-another/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/replace-a-focus-page.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/what-if-i-replace-my-focus-page-with-another/" class="text-dark" target="_blank">Replacing
                                        a Focus Page with Another</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/ht_kb/if-i-want-to-create-a-new-focus-page-should-it-be-a-post-or-a-page/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/post-vs-page.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/ht_kb/if-i-want-to-create-a-new-focus-page-should-it-be-a-post-or-a-page/" class="text-dark" target="_blank">Post
                                        vs Page as a Focus Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_focuspages' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_focuspageshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#add_new_focus_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add-focus-page.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#add_new_focus_page" class="text-dark" target="_blank">How
                                        to add a new Focus Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#remove_focus_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/remove-focus-page.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#remove_focus_page" class="text-dark" target="_blank">How
                                        to remove a Focus Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/focus-pages-page-audits/#chance_to_rank" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/chance-to-rank.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/focus-pages-page-audits/#chance_to_rank" class="text-dark" target="_blank">What
                                        is Chance to Rank?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/how-to-change-main-keyword-for-a-focus-page/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/change-main-keyword.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/how-to-change-main-keyword-for-a-focus-page/" class="text-dark" target="_blank">How
                                        to Change the Main Keyword</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_audits' && $tab == 'settings' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_auditshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#how_seo_audit_works" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/audit-works.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#how_seo_audit_works" class="text-dark" target="_blank">How
                                        does the Audit work?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add-a-page-in-audit.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" class="text-dark" target="_blank">How
                                        to add a page in Audit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#delete_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/remove-audit.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#delete_page" class="text-dark" target="_blank">How
                                        to remove a page from Audits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-audit/#progress" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/check-progress.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-audit/#progress" class="text-dark" target="_blank">How
                                        to Check Your Progress & Achievements</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_audits' && $tab == 'addpage' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_auditshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#how_seo_audit_works" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/audit-works.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#how_seo_audit_works" class="text-dark" target="_blank">How
                                        does the Audit work?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add-a-page-in-audit.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" class="text-dark" target="_blank">How
                                        to add a page in Audit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#delete_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/remove-audit.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#delete_page" class="text-dark" target="_blank">How
                                        to remove a page from Audits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/knowledge-base/seo-audit/#progress" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/check-progress.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/knowledge-base/seo-audit/#progress" class="text-dark" target="_blank">How
                                        to Check Your Progress & Achievements</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_audits' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_auditshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#how_seo_audit_works" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/audit-works.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#how_seo_audit_works" class="text-dark" target="_blank">How
                                        does the Audit work?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add-a-page-in-audit.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" class="text-dark" target="_blank">How
                                        to add a page in Audit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#delete_page" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/remove-audit.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#delete_page" class="text-dark" target="_blank">How
                                        to remove a page from Audits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/seo-audit/#compare_audits" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/check-progress.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/seo-audit/#compare_audits" class="text-dark" target="_blank">How
                                        to Compare SEO Audits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_rankings' && $tab == 'settings' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_rankingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#change_ranking_country" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/ranking-country.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#change_ranking_country" class="text-dark" target="_blank">How
                                        to Change Ranking Country</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#change_ranking_language" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/language.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#change_ranking_language" class="text-dark" target="_blank">How
                                        to Change Ranking Language</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#change_ranking_device" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/device.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#change_ranking_device" class="text-dark" target="_blank">How
                                        to Change Ranking Device</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/faq/what-is-the-serp-checker-cloud/" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/cloud.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/faq/what-is-the-serp-checker-cloud/" class="text-dark" target="_blank">What
                                        is the SERP Checker Cloud?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } elseif ( $page == 'sq_rankings' ) { ?>
            <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_rankingshelp' ) ?></div>

            <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#add_keyword_ranking" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/add-new-keyword.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#add_keyword_ranking" class="text-dark" target="_blank">How
                                        to add a Keyword in Rankings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#sync_keyword_ranking" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/sync.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#sync_keyword_ranking" class="text-dark" target="_blank">How
                                        to sync a Keyword with GSC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#remove_keyword_ranking" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/remove.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#remove_keyword_ranking" class="text-dark" target="_blank">How
                                        to remove a keyword from Rankings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 py-0 mb-5">
                    <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0 text-center">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#check_keyword_information" class="text-dark" target="_blank"><img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/keyword-data.jpg' ) ?>" alt="" style="width: 100%"></a>
                            </div>
                            <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                <div class="pt-3 pb-1" style="color: #696868">
                                    <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#check_keyword_information" class="text-dark" target="_blank">Check
                                        the Keyword Impressions, Clicks and Optimization</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php } ?>

        <div class="col-12 text-right p-0 m-0 pr-3">
            <a href="<?php echo esc_url( _SQ_HOWTO_URL_ ) ?>" class="text-dark font-weight-bold" target="_blank">Go to
                Knowledge Base >></a></div>

    </div>
<?php } ?>
