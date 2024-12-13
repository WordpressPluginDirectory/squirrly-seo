<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Webmasters view
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


                <div class="col-12 p-0 m-0">
					<?php do_action( 'sq_subscription_notices' ); ?>

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Connect Tools", 'squirrly-seo' ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
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
						<?php
						$codes   = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'codes' ) ) );
						$connect = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'connect' ) ) );
						?>

                        <div class="d-flex flex-column flex-grow-1 m-0 p-0">

                            <div id="connect" class="col-12 py-0 px-4 m-0 tab-panel tab-panel-first active">

                                <div class="col-12 m-0 p-0 my-2">
                                    <h3 class="card-title"><?php echo esc_html__( "Connect Tools", 'squirrly-seo' ); ?>
                                        <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                    </h3>
                                </div>

                                <div class="col-12 m-0 p-0 my-5">
                                    <div class="col-12 row m-0 p-0 my-5">
										<?php if ( $connect->google_analytics ) { ?>
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Google Analytics", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#google_analytics" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "You are connected to Google Analytics", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0">
												<?php
												$json = SQ_Classes_RemoteController::getGAProperties();
												if ( ! is_wp_error( $json ) && isset( $json->properties ) ) {
													$properties  = $json->properties;
													$property_id = $json->property_id;

													if ( ! $property_id ) {
														$matched_properties = array();

														foreach ( $properties as $property ) {
															if ( strpos( $property->website_url, parse_url( home_url(), PHP_URL_HOST ) ) !== false ) {
																$matched_properties[] = $property;
															}
														}

														if ( empty( $matched_properties ) ) {
															$matched_properties = $properties;
														}
														?>
                                                        <form id="sq_ga_property_form" method="post" class="p-0 m-0">
															<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_ga_save', 'sq_nonce' ); ?>
                                                            <input type="hidden" name="action" value="sq_seosettings_ga_save"/>
                                                            <select name="property_id" class="d-inline-block m-0 p-1" style="width: 100%; max-width: 100%; overflow: hidden"
                                                                    onchange="if(confirm('Do you select this property?')){jQuery('form#sq_ga_property_form').submit();}">
                                                                <option value=""></option>
																<?php foreach ( $matched_properties as $property ) { ?>
                                                                    <option value="<?php echo esc_attr( $property->property_id ) ?>"><?php echo esc_url( $property->website_url ); ?>
                                                                        (<?php echo esc_attr( $property->ga_id ) ?>)
                                                                    </option>
																<?php } ?>
                                                            </select>
                                                        </form>
													<?php } else {
														foreach ( $properties as $property ) {
															if ( $property->property_id == $property_id ) {
																?>
                                                                <div class="border text-black-50 p-2 font-weight-bold"><?php echo esc_url( $property->website_url ); ?>
                                                                    (<?php echo esc_attr( $property->ga_id ) ?>)
                                                                </div>
																<?php
																break;
															}
														}
													}
												}
												?>

                                                <form method="post" class="p-0 m-0 text-right" onsubmit="if(!confirm('Are you sure?')){return false;}">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_ga_revoke', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_ga_revoke"/>
                                                    <button type="submit" class="btn btn-link text-primary">
														<?php echo esc_html__( "Disconnect", 'squirrly-seo' ) ?>
                                                    </button>
                                                </form>
                                            </div>
										<?php } else { ?>
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Google Analytics", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#google_analytics" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Connect to Google Analytics", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0">

                                                <div class="sq_analytics_step1 mt-1">
                                                    <a href="<?php echo esc_url( SQ_Classes_RemoteController::getApiLink( 'gaoauth' ) ); ?>" onclick="jQuery('.sq_analytics_step1').hide();jQuery('.sq_analytics_step2').show();jQuery(this).sq_clearCache();" target="_blank" type="button" class="btn btn-primary w-100 text-white connect-button connect btn-lg">
                                                        <span class="fasq-brands fa-google"></span> <?php echo esc_html__( "Sign in", 'squirrly-seo' ); ?>
                                                    </a>
                                                </div>
                                                <div class="sq_analytics_step2 mt-1" style="display: none">
                                                    <form method="post" class="p-0 m-0">
														<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_ga_check', 'sq_nonce' ); ?>
                                                        <input type="hidden" name="action" value="sq_seosettings_ga_check"/>
                                                        <button type="submit" class="btn btn-warning w-100 text-white btn-lg">
                                                            <span class="fasq-brands fa-google"></span> <?php echo esc_html__( "Check connection", 'squirrly-seo' ); ?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
										<?php } ?>

                                    </div>
                                </div>

                                <div class="col-12 m-0 p-0 my-5">
                                    <div class="col-12 row m-0 p-0 my-5">
										<?php if ( $connect->google_search_console ) { ?>
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Google Search Console", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#gsc" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "You are connected to Google Search Console", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0">
                                                <div class="border text-black-50 p-2 font-weight-bold"><?php echo esc_url( home_url() ) ?></div>

                                                <form method="post" class="p-0 m-0 text-right" onsubmit="if(!confirm('Are you sure?')){return false;}">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_gsc_revoke', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_gsc_revoke"/>
                                                    <button type="submit" class="btn btn-link text-primary">
														<?php echo esc_html__( "Disconnect", 'squirrly-seo' ) ?>
                                                    </button>
                                                </form>
                                            </div>
										<?php } else { ?>
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Google Search Console", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#gsc" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Connect to Google Search Console", 'squirrly-seo' ); ?></div>
                                            </div>

                                            <div class="col-8 m-0 p-0">
                                                <div class="sq_gsc_step1 mt-1">
                                                    <a href="<?php echo esc_url( SQ_Classes_RemoteController::getApiLink( 'gscoauth' ) ); ?>" onclick="jQuery('.sq_gsc_step1').hide();jQuery('.sq_gsc_step2').show();jQuery(this).sq_clearCache();" target="_blank" type="button" class="btn btn-primary w-100 text-white connect-button connect btn-lg">
                                                        <span class="fasq-brands fa-google"></span> <?php echo esc_html__( "Sign in", 'squirrly-seo' ); ?>
                                                    </a>
                                                </div>
                                                <div class="sq_gsc_step2 mt-1" style="display: none">
                                                    <form method="post" class="p-0 m-0">
														<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_gsc_check', 'sq_nonce' ); ?>
                                                        <input type="hidden" name="action" value="sq_seosettings_gsc_check"/>
                                                        <button type="submit" class="btn btn-warning w-100 text-white btn-lg">
                                                            <span class="fasq-brands fa-google"></span> <?php echo esc_html__( "Check connection", 'squirrly-seo' ); ?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
										<?php } ?>

                                    </div>
                                </div>

                            </div>

                            <form method="POST">
								<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_save', 'sq_nonce' ); ?>
                                <input type="hidden" name="action" value="sq_seosettings_save"/>

                                <div id="trackers" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Place Trackers", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
										<?php
										$codes   = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'codes' ) ) );
										$connect = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'connect' ) ) );
										?>

										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ) ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
													<?php echo esc_html__( "Google Analytics ID", 'squirrly-seo' ); ?>:
                                                    <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#google_analytics" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Squirrly adds the Google Tracking script for your Analytics ID. %sGet the Analytics ID%s", 'squirrly-seo' ), '<a href="https://analytics.google.com/analytics/web/" target="_blank"><strong>', '</strong></a>' ); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="google_analytics" type="text" class="form-control bg-input" name="codes[google_analytics]" value="<?php echo( ( isset( $codes->google_analytics ) ) ? esc_attr( $codes->google_analytics ) : '' ) ?>" placeholder="UA-XXXX or G-XXXX"/>
													<?php if ( $connect->google_analytics ) { ?>
                                                        <div class="my-0 mx-2">
                                                            <button id="sq_ga_button" type="button" class=" btn btn-block btn-warning btn-lg">
																<?php echo esc_html__( "Get GA Code", 'squirrly-seo' ); ?>
                                                            </button>
                                                        </div>
													<?php } ?>
                                                </div>
                                            </div>

                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
													<?php echo esc_html__( "Google Tracking Mode", 'squirrly-seo' ); ?>:
                                                    <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#receive_tracking_code" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Choose gtag.js if you use %sGoogle Tag Manager%s or the %sGoogle Analytics 4%s. Otherwise select analytics.js to track the website traffic.", 'squirrly-seo' ), '<a href="https://tagmanager.google.com/" target="_blank"><strong>', '</strong></a>', '<a href="https://support.google.com/analytics/answer/10089681" target="_blank"><strong>', '</strong></a>' ); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <select name="sq_analytics_google_js" class="form-control bg-input mb-1 border">
                                                        <option value="analytics" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_analytics_google_js' ) == 'analytics' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "analytics.js", 'squirrly-seo' ); ?></option>
                                                        <option value="gtag" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_analytics_google_js' ) == 'gtag' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "gtag.js", 'squirrly-seo' ); ?></option>
                                                    </select>
                                                </div>

                                                <div class="col-12 text-center p-0 my-4">
                                                    <h6><?php echo sprintf( esc_html__( "%sNeed Help Connecting Google Analytics?%s", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/faq/how-do-i-connect-google-analytics-both-tracking-code-and-the-api-connection/" target="_blank">', '</a>' ) ?></h6>
                                                </div>
                                            </div>
										<?php } ?>


										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pixels' ) ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
													<?php echo esc_html__( "Facebook Pixel", 'squirrly-seo' ); ?>:
                                                    <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#facebook_pixel" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Use FB Pixel to track the visitors events and to use Facebook Ads more efficient. %sLearn More%s", 'squirrly-seo' ), '<a href="https://developers.facebook.com/docs/facebook-pixel" target="_blank"><strong>', '</strong></a>' ); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[facebook_pixel]" value="<?php echo( ( isset( $codes->facebook_pixel ) ) ? esc_attr( $codes->facebook_pixel ) : '' ) ?>"/>
                                                </div>
                                            </div>
										<?php } ?>

										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_webmasters' ) ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
													<?php echo esc_html__( "Google Search Console", 'squirrly-seo' ); ?>
                                                    :
                                                    <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#gsc" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the Google META verification code to connect to %sGoogle Search Console%s", 'squirrly-seo' ), '<a href="https://www.google.com/webmasters/verification/verification?siteUrl=' . esc_url( home_url() ) . '&priorities=vmeta" target="_blank">', '</a>' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                    <input id="google_wt" type="text" class="form-control bg-input" name="codes[google_wt]" value="<?php echo( ( isset( $codes->google_wt ) ) ? esc_attr( $codes->google_wt ) : '' ) ?>"/>
													<?php if ( $connect->google_search_console ) { ?>
                                                        <div class="my-0 mx-2">
                                                            <button id="sq_webmaster_button" type="button" class=" btn btn-block btn-warning btn-lg">
																<?php echo esc_html__( "Get GSC Code", 'squirrly-seo' ); ?>
                                                            </button>
                                                        </div>
													<?php } ?>
                                                </div>

                                                <div class="col-12 text-center p-0 my-4">
                                                    <h6><?php echo sprintf( esc_html__( "%sNeed Help Connecting Google Search Console?%s", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/faq/need-help-connecting-google-search-console-both-tracking-code-and-api-connection/" target="_blank">', '</a>' ) ?></h6>
                                                </div>
                                            </div>
										<?php } ?>

										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ) ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_tracking_logged_users" value="0"/>
                                                        <input type="checkbox" id="sq_tracking_logged_users" name="sq_tracking_logged_users" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_tracking_logged_users' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                        <label for="sq_tracking_logged_users" class="ml-1"><?php echo esc_html__( "Load Tracking for Logged Users", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#logged_users" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Load the tracking codes for logged users too.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_tracking_ip_users" value="0"/>
                                                        <input type="checkbox" id="sq_tracking_ip_users" name="sq_tracking_ip_users" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_tracking_ip_users' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                        <label for="sq_tracking_ip_users" class="ml-1"><?php echo esc_html__( "Track IP addresses in Google Analytics", 'squirrly-seo' ); ?></label>
                                                        <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "Store visitor IP address in Google Analytics (%s IP Anonymization in Google Analytics %s)", 'squirrly-seo' ), '<a href="https://support.google.com/analytics/answer/2763052" target="_blank">', '</a>' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
										<?php } ?>

										<?php do_action( 'sq_webmaster_trackers_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>
                                    </div>

                                </div>
                                <div id="amp" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "AMP", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_auto_amp" value="0"/>
                                                    <input type="checkbox" id="sq_auto_amp" name="sq_auto_amp" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_amp' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_auto_amp" class="ml-1"><?php echo esc_html__( "Load the AMP Support on AMP pages", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo sprintf( esc_html__( "Load the Accelerate Mobile Pages (AMP) support for plugins like %sAMP for WP%s or %sAMP%s detected", 'squirrly-seo' ), '<a href="https://wordpress.org/plugins/accelerated-mobile-pages/" target="_blank">', '</a>', '<a href="https://wordpress.org/plugins/amp/" target="_blank">', '</a>' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_webmaster_amp_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>
                                    </div>

                                </div>
                                <div id="webmasters" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Webmaster Extras", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Bing Webmaster Tools", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#bing_webmaster" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the Bing META verification code to connect to %sBing Webmaster Tool%s", 'squirrly-seo' ), '<a href="https://www.bing.com/toolbox/webmaster/" target="_blank">', '</a>' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="codes[bing_wt]" value="<?php echo( ( isset( $codes->bing_wt ) ) ? esc_attr( $codes->bing_wt ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Baidu Webmaster Tools", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#baidu_webmaster" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the Baidu META verification code to connect to %sBaidu Webmaster Tool%s", 'squirrly-seo' ), '<a href="https://ziyuan.baidu.com/site/" target="_blank">', '</a>' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="codes[baidu_wt]" value="<?php echo( ( isset( $codes->baidu_wt ) ) ? esc_attr( $codes->baidu_wt ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Yandex Webmaster Code", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#yandex_webmaster" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the Yandex META verification code to connect to %sYandex Webmaster Tool%s", 'squirrly-seo' ), '<a href="https://webmaster.yandex.com/sites/" target="_blank">', '</a>' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="codes[yandex_wt]" value="<?php echo( ( isset( $codes->yandex_wt ) ) ? esc_attr( $codes->yandex_wt ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Pinterest Website Validator Code", 'squirrly-seo' ); ?>
                                                :
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#pinterest_validation" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the Pinterest verification code to connect your website to your Pinterest account. Visit the %sRich Pins Validator%s", 'squirrly-seo' ), '<a href="https://developers.pinterest.com/tools/url-debugger/" target="_blank">', '</a>' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="codes[pinterest_verify]" value="<?php echo( ( isset( $codes->pinterest_verify ) ) ? esc_attr( $codes->pinterest_verify ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="col-4 m-0 p-0 pr-2 font-weight-bold">
												<?php echo esc_html__( "Norton Safe Web Code", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/webmaster-tools-settings/#norton_safe_code" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the Norton Safe Web verification code or ID to connect your website to Norton Safe Web. Visit the %sNorton Ownership Verification Page%s", 'squirrly-seo' ), '<a href="https://support.norton.com/sp/en/in/home/current/solutions/kb20090410134005EN" target="_blank">', '</a>' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="codes[norton_verify]" value="<?php echo( ( isset( $codes->norton_verify ) ) ? esc_attr( $codes->norton_verify ) : '' ) ?>"/>
                                            </div>
                                        </div>

										<?php do_action( 'sq_webmaster_webmasters_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>


                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "We have only added some of the webmaster tools you see here in this section of Squirrly due to different requests from users in relevant countries.", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "It’s NOT mandatory to fill in all the fields from this section and connect your website to all the Webmaster tools in this section.", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Only set up the connections that are relevant for your site and strategy.", 'squirrly-seo' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_webmaster_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
