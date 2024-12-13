<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Socials view
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
							<?php echo esc_html__( "Social Media", 'squirrly-seo' ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/social-media-settings/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
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

                            <div class="d-flex flex-column flex-grow-1 m-0 p-0">

                                <div id="opengraph" class="col-12 py-0 px-4 m-0 tab-panel tab-panel-first active">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Open Graph Settings", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/social-media-settings/#open_graph" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="small text-black-50"><?php echo esc_html__( "Add the Social Open Graph protocol so that your Facebook shares look good.", 'squirrly-seo' ); ?></div>
                                        <div class="small text-black-50"><?php echo sprintf( esc_html__( "You can always update an URL on Facebook if you change its Social Media Image. Visit %sOpen Graph Debugger%s", 'squirrly-seo' ), '<a href="https://developers.facebook.com/tools/debug/?q=' . esc_url( home_url() ) . '" target="_blank" ><strong>', '</strong></a>' ); ?></div>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
										<?php $socials = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'socials' ) ) ); ?>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-12 row m-0 p-0">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
                                                    <label for="sq_og_image"><?php echo esc_html__( "Default Open Graph Image", 'squirrly-seo' ); ?>
                                                        :</label>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Set an Open Graph default Image to load when you don't have an image set for a specific URL.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                    <input id="sq_og_image" type="text" class="form-control bg-input" name="sq_og_image" value="<?php echo esc_url( ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) <> '' ) ? SQ_Classes_Helpers_Tools::getOption( 'sq_og_image' ) : '' ) ?>" placeholder="<?php echo esc_attr__( "Select your file here", 'squirrly-seo' ); ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-0" data-destination="sq_og_image" value="<?php echo esc_attr__( "Select Image", 'squirrly-seo' ) ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-12 row m-0 p-0 my-3">
                                                <div class="col-4 m-0 p-0">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Facebook Share Language", 'squirrly-seo' ); ?>
                                                        :
                                                        <a href="https://howto12.squirrly.co/kb/social-media-settings/#share_language" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Use this so that Facebook can automatically translate the text into the reader's language", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group">
                                                    <select name="sq_og_locale" class="form-control bg-input mb-1 border">
                                                        <option value="en_US">English (US)</option>
                                                        <option value="af_ZA">Afrikaans</option>
                                                        <option value="ak_GH">Akan</option>
                                                        <option value="am_ET">Amharic</option>
                                                        <option value="ar_AR">Arabic</option>
                                                        <option value="as_IN">Assamese</option>
                                                        <option value="ay_BO">Aymara</option>
                                                        <option value="az_AZ">Azerbaijani</option>
                                                        <option value="be_BY">Belarusian</option>
                                                        <option value="bg_BG">Bulgarian</option>
                                                        <option value="bn_IN">Bengali</option>
                                                        <option value="br_FR">Breton</option>
                                                        <option value="bs_BA">Bosnian</option>
                                                        <option value="ca_ES">Catalan</option>
                                                        <option value="cb_IQ">Sorani Kurdish</option>
                                                        <option value="ck_US">Cherokee</option>
                                                        <option value="co_FR">Corsican</option>
                                                        <option value="cs_CZ">Czech</option>
                                                        <option value="cx_PH">Cebuano</option>
                                                        <option value="cy_GB">Welsh</option>
                                                        <option value="da_DK">Danish</option>
                                                        <option value="de_DE">German</option>
                                                        <option value="el_GR">Greek</option>
                                                        <option value="en_GB">English (UK)</option>
                                                        <option value="en_IN">English (India)</option>
                                                        <option value="en_PI">English (Pirate)</option>
                                                        <option value="en_UD">English (Upside Down)</option>
                                                        <option value="eo_EO">Esperanto</option>
                                                        <option value="es_CL">Spanish (Chile)</option>
                                                        <option value="es_CO">Spanish (Colombia)</option>
                                                        <option value="es_ES">Spanish (Spain)</option>
                                                        <option value="es_LA">Spanish</option>
                                                        <option value="es_MX">Spanish (Mexico)</option>
                                                        <option value="es_VE">Spanish (Venezuela)</option>
                                                        <option value="et_EE">Estonian</option>
                                                        <option value="eu_ES">Basque</option>
                                                        <option value="fa_IR">Persian</option>
                                                        <option value="fb_LT">Leet Speak</option>
                                                        <option value="ff_NG">Fulah</option>
                                                        <option value="fi_FI">Finnish</option>
                                                        <option value="fo_FO">Faroese</option>
                                                        <option value="fr_CA">French (Canada)</option>
                                                        <option value="fr_FR">French (France)</option>
                                                        <option value="fy_NL">Frisian</option>
                                                        <option value="ga_IE">Irish</option>
                                                        <option value="gl_ES">Galician</option>
                                                        <option value="gn_PY">Guarani</option>
                                                        <option value="gu_IN">Gujarati</option>
                                                        <option value="gx_GR">Classical Greek</option>
                                                        <option value="ha_NG">Hausa</option>
                                                        <option value="he_IL">Hebrew</option>
                                                        <option value="hi_IN">Hindi</option>
                                                        <option value="hr_HR">Croatian</option>
                                                        <option value="hu_HU">Hungarian</option>
                                                        <option value="hy_AM">Armenian</option>
                                                        <option value="id_ID">Indonesian</option>
                                                        <option value="ig_NG">Igbo</option>
                                                        <option value="is_IS">Icelandic</option>
                                                        <option value="it_IT">Italian</option>
                                                        <option value="ja_JP">Japanese</option>
                                                        <option value="ja_KS">Japanese (Kansai)</option>
                                                        <option value="jv_ID">Javanese</option>
                                                        <option value="ka_GE">Georgian</option>
                                                        <option value="kk_KZ">Kazakh</option>
                                                        <option value="km_KH">Khmer</option>
                                                        <option value="kn_IN">Kannada</option>
                                                        <option value="ko_KR">Korean</option>
                                                        <option value="ku_TR">Kurdish (Kurmanji)</option>
                                                        <option value="la_VA">Latin</option>
                                                        <option value="lg_UG">Ganda</option>
                                                        <option value="li_NL">Limburgish</option>
                                                        <option value="ln_CD">Lingala</option>
                                                        <option value="lo_LA">Lao</option>
                                                        <option value="lt_LT">Lithuanian</option>
                                                        <option value="lv_LV">Latvian</option>
                                                        <option value="mg_MG">Malagasy</option>
                                                        <option value="mk_MK">Macedonian</option>
                                                        <option value="ml_IN">Malayalam</option>
                                                        <option value="mn_MN">Mongolian</option>
                                                        <option value="mr_IN">Marathi</option>
                                                        <option value="ms_MY">Malay</option>
                                                        <option value="mt_MT">Maltese</option>
                                                        <option value="my_MM">Burmese</option>
                                                        <option value="nb_NO">Norwegian (bokmal)</option>
                                                        <option value="nd_ZW">Ndebele</option>
                                                        <option value="ne_NP">Nepali</option>
                                                        <option value="nl_BE">Dutch (België)</option>
                                                        <option value="nl_NL">Dutch</option>
                                                        <option value="nn_NO">Norwegian (nynorsk)</option>
                                                        <option value="ny_MW">Chewa</option>
                                                        <option value="or_IN">Oriya</option>
                                                        <option value="pa_IN">Punjabi</option>
                                                        <option value="pl_PL">Polish</option>
                                                        <option value="ps_AF">Pashto</option>
                                                        <option value="pt_BR">Portuguese (Brazil)</option>
                                                        <option value="pt_PT">Portuguese (Portugal)</option>
                                                        <option value="qu_PE">Quechua</option>
                                                        <option value="rm_CH">Romansh</option>
                                                        <option value="ro_RO">Romanian</option>
                                                        <option value="ru_RU">Russian</option>
                                                        <option value="rw_RW">Kinyarwanda</option>
                                                        <option value="sa_IN">Sanskrit</option>
                                                        <option value="sc_IT">Sardinian</option>
                                                        <option value="se_NO">Northern Sámi</option>
                                                        <option value="si_LK">Sinhala</option>
                                                        <option value="sk_SK">Slovak</option>
                                                        <option value="sl_SI">Slovenian</option>
                                                        <option value="sn_ZW">Shona</option>
                                                        <option value="so_SO">Somali</option>
                                                        <option value="sq_AL">Albanian</option>
                                                        <option value="sr_RS">Serbian</option>
                                                        <option value="sv_SE">Swedish</option>
                                                        <option value="sw_KE">Swahili</option>
                                                        <option value="sy_SY">Syriac</option>
                                                        <option value="sz_PL">Silesian</option>
                                                        <option value="ta_IN">Tamil</option>
                                                        <option value="te_IN">Telugu</option>
                                                        <option value="tg_TJ">Tajik</option>
                                                        <option value="th_TH">Thai</option>
                                                        <option value="tk_TM">Turkmen</option>
                                                        <option value="tl_PH">Filipino</option>
                                                        <option value="tl_ST">Klingon</option>
                                                        <option value="tr_TR">Turkish</option>
                                                        <option value="tt_RU">Tatar</option>
                                                        <option value="tz_MA">Tamazight</option>
                                                        <option value="uk_UA">Ukrainian</option>
                                                        <option value="ur_PK">Urdu</option>
                                                        <option value="uz_UZ">Uzbek</option>
                                                        <option value="vi_VN">Vietnamese</option>
                                                        <option value="wo_SN">Wolof</option>
                                                        <option value="xh_ZA">Xhosa</option>
                                                        <option value="yi_DE">Yiddish</option>
                                                        <option value="yo_NG">Yoruba</option>
                                                        <option value="zh_CN">Simplified Chinese (China)</option>
                                                        <option value="zh_HK">Traditional Chinese (Hong Kong)</option>
                                                        <option value="zh_TW">Traditional Chinese (Taiwan)</option>
                                                        <option value="zu_ZA">Zulu</option>
                                                        <option value="zz_TR">Zazaki</option>
                                                    </select>
                                                    <script>jQuery('select[name=sq_og_locale]').val('<?php echo esc_attr( SQ_Classes_Helpers_Tools::getOption( 'sq_og_locale' ) ) ?>').attr('selected', true);</script>
                                                </div>
                                            </div>

                                            <div class="col-12 row m-0 p-0 my-3 sq_advanced">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Facebook App ID", 'squirrly-seo' ); ?>:
                                                    <a href="https://howto12.squirrly.co/kb/social-media-settings/#open_graph_app_id" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo sprintf( esc_html__( "Add the %sFacebook App ID%s to create a connection between your Facebook Page and your Website.", 'squirrly-seo' ), '<a href="https://developers.facebook.com/apps/" target="_blank"><strong>', '</strong></a>' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[fbadminapp]" value="<?php echo( ( $socials->fbadminapp <> '' ) ? esc_attr( $socials->fbadminapp ) : '' ) ?>"/>
                                                </div>
                                            </div>

											<?php
											if ( ! empty( $socials->fb_admins ) ) {
												foreach ( $socials->fb_admins as $index => $values ) {
													if ( $index > 0 && ! isset( $values->id ) && ! $values ) {
														continue;
													}
													?>
                                                    <div class="col-12 row m-0 p-0 my-3">
														<?php if ( $index > 0 ) { ?>
                                                            <button type="button" class="close" aria-label="Close" onclick="jQuery(this).parent().remove();" style="position: absolute; float: right;right: 10px;top: 15px;left: auto;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
														<?php } ?>
                                                        <div class="col-4 m-0 p-0 font-weight-bold">
															<?php echo esc_html__( "Facebook Admin ID", 'squirrly-seo' ); ?>
                                                            :
                                                            <a href="https://howto12.squirrly.co/kb/social-media-settings/#open_graph_admin_id" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                            <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Similar to Facebook App ID, Facebook Admin ID connects your Facebook Page to your Website.", 'squirrly-seo' ); ?></div>
                                                        </div>
                                                        <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                            <input type="text" class="form-control bg-input" name="socials[fb_admins][]" value="<?php echo( isset( $values->id ) ? esc_attr( $values->id ) : esc_attr( $values ) ) ?>"/>
                                                        </div>
                                                    </div>
												<?php }
											} else {
												?>
                                                <div class="col-12 row m-0 p-0 my-3 sq_advanced">
                                                    <div class="col-4 m-0 p-0 font-weight-bold">
														<?php echo esc_html__( "Facebook Admin ID", 'squirrly-seo' ); ?>
                                                        :
                                                        <div class="small text-black-50 my-1"><?php echo esc_html__( "Similar to Facebook App ID, Facebook Admin ID connects your Facebook Page to your Website.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                    <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="socials[fb_admins][]" value=""/>
                                                    </div>
                                                </div>
											<?php } ?>
                                            <div class="col-12 row m-0 p-0 my-3 sq_fb_admins" style="display: none">
                                                <button type="button" class="close" aria-label="Close" onclick="jQuery(this).parent().remove();" style="position: absolute; float: right;right: 10px;top: 15px;left: auto;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Facebook Admin ID", 'squirrly-seo' ); ?>:
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[fb_admins][]" value=""/>
                                                </div>
                                            </div>
                                            <div class="col-12 m-0 p-0 text-center sq_advanced">
                                                <button type="button" class="btn rounded-0 btn-default btn-sm p-2 m-0 m-0" onclick="var $clone = jQuery('.sq_fb_admins:last').clone(); jQuery('.sq_fb_admins:last').before($clone); $clone.show();"><?php echo esc_html__( "Add multiple Facebook Admin IDs", 'squirrly-seo' ); ?></button>
                                            </div>
                                        </div>

										<?php do_action( 'sq_social_opengraph_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="twittercard" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Twitter Card Settings", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/social-media-settings/#twitter_card" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="small text-black-50"><?php echo esc_html__( "Add the Twitter Card in your tweets so that your Twitter shares look good.", 'squirrly-seo' ); ?></div>
                                        <div class="small text-black-50"><?php echo sprintf( esc_html__( "Make sure you validate the twitter card with your Twitter account. Visit %sTwitter Card Validator%s", 'squirrly-seo' ), '<a href="https://cards-dev.twitter.com/validator?url=' . esc_url( home_url() ) . '" target="_blank" ><strong>', '</strong></a>' ); ?></div>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-12 row m-0 p-0">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Default Twitter Card Image", 'squirrly-seo' ); ?>
                                                    :
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Set a Twitter Card default Image to load when you don't have an image set for a specific URL.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                    <input id="sq_tc_image" type="text" class="form-control bg-input" name="sq_tc_image" value="<?php echo esc_url( ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) <> '' ) ? SQ_Classes_Helpers_Tools::getOption( 'sq_tc_image' ) : '' ) ?>" placeholder="<?php echo esc_attr__( "Select your file here", 'squirrly-seo' ) ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-0" data-destination="sq_tc_image" value="<?php echo esc_attr__( "Select Image", 'squirrly-seo' ) ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
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

										<?php do_action( 'sq_social_twittercard_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="accounts" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Social Media Accounts", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Twitter Profile URL", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1"><?php echo "https://twitter.com/XXXXX"; ?></div>
                                                <div class="small text-info my-1"><?php echo esc_html__( "Required for Twitter Card Validator", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="socials[twitter_site]" value="<?php echo( ( isset( $socials->twitter_site ) ) ? esc_attr( $socials->twitter_site ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Facebook Profile or Page URL", 'squirrly-seo' ); ?>
                                                :
                                                <div class="small text-black-50 my-1"><?php echo "https://facebook.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="socials[facebook_site]" value="<?php echo( ( isset( $socials->facebook_site ) ) ? esc_attr( $socials->facebook_site ) : '' ) ?>"/>
                                            </div>
                                        </div>


                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "LinkedIn Profile URL", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1"><?php echo "https://linkedin.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="socials[linkedin_url]" value="<?php echo( ( isset( $socials->linkedin_url ) ) ? esc_attr( $socials->linkedin_url ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Pinterest Profile URL", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1"><?php echo "https://pinterest.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="socials[pinterest_url]" value="<?php echo( ( isset( $socials->pinterest_url ) ) ? esc_attr( $socials->pinterest_url ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Instagram Profile URL", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1"><?php echo "https://instagram.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="socials[instagram_url]" value="<?php echo( ( isset( $socials->instagram_url ) ) ? esc_attr( $socials->instagram_url ) : '' ) ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Youtube Channel URL", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1"><?php echo "https://youtube.com/channel/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="socials[youtube_url]" value="<?php echo( ( isset( $socials->youtube_url ) ) ? esc_attr( $socials->youtube_url ) : '' ) ?>"/>
                                            </div>
                                        </div>

										<?php do_action( 'sq_social_accounts_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="advanced" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Advanced Settings", 'squirrly-seo' ); ?></h3>
                                    </div>

									<?php $metas = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'sq_metas' ) ) ); ?>
                                    <div class="col-12 m-0 p-0 my-5">

										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Open Graph Title Length", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[og_title_maxlength]" value="<?php echo (int) $metas->og_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Open Graph Description Length", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[og_description_maxlength]" value="<?php echo (int) $metas->og_description_maxlength ?>"/>
                                                </div>
                                            </div>
										<?php } ?>
										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) { ?>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Twitter Card Title Length", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[tw_title_maxlength]" value="<?php echo (int) $metas->tw_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Twitter Card Description Length", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[tw_description_maxlength]" value="<?php echo (int) $metas->tw_description_maxlength ?>"/>
                                                </div>
                                            </div>
										<?php } ?>

										<?php do_action( 'sq_social_advanced_after' ); ?>

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
                        <li class="text-left"><?php echo esc_html__( "Once the Squirrly SEO settings for social media are activated, the process is made automatically and all the website URLs will have the right look when shared on Social Media.", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo sprintf( esc_html__( "Use %s Bulk SEO %s to configure Open Graph Settings and Twitter Card Settings for each page on your website.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) ) . '" target="_blank">', '</a>' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_social_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
