<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}
?>
<?php
$socials = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'socials' ) ) );
$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
$jsonldtype = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_type' );
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

                    <div id="sq_onboarding" class="col-8 row my-0 mx-auto p-0">
                        <form id="sq_onboarding_form" method="post" action="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'step5' ) ) ?>" class="col-12 p-0 m-0">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_onboarding_save' ); ?>
                            <input type="hidden" name="action" value="sq_onboarding_save"/>

                            <div class="col-12 row m-0 p-0">
                                <div class="col-12 p-0 m-0 mt-5 mb-3 text-center">
                                    <div class="group_autoload d-flex justify-content-center btn-group btn-group-lg mt-3" role="group">
                                        <div class="font-weight-bold" style="font-size: 1.2rem">
                                            <span class="sq_logo sq_logo_30 align-top mr-2"></span><?php echo esc_html__( "Enter your personalized content here", 'squirrly-seo' ); ?>
                                            :
                                        </div>
                                    </div>
                                    <div class="text-center mt-4"><?php echo esc_html__( "Congrats! You activated all the features you needed to.", 'squirrly-seo' ); ?></div>
                                    <div class="text-center"><?php echo esc_html__( "Now all you have to do is add the custom content that is unique to your business.", 'squirrly-seo' ); ?></div>

                                </div>

                                <div class="col-12 m-0 p-0">
									<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) { ?>

                                        <h3 class="card-title mt-5"><?php echo esc_html__( "Social Media", 'squirrly-seo' ); ?>
                                            (<?php echo esc_html__( "only add the ones you already have", 'squirrly-seo' ); ?>
                                            )</h3>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="socials_twitter_site"><?php echo esc_html__( "Twitter Profile URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1"><?php echo "https://twitter.com/XXXXX"; ?></div>
                                                <div class="small text-info my-1"><?php echo esc_html__( "Required for Twitter Card Validator", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input id="socials_twitter_site" type="text" class="form-control bg-input" name="socials[twitter_site]" value="<?php echo( ( isset( $socials->twitter_site ) ) ? esc_attr( $socials->twitter_site ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="socials_facebook_site"><?php echo esc_html__( "Facebook Profile or Page URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1"><?php echo "https://facebook.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input id="socials_facebook_site" type="text" class="form-control bg-input" name="socials[facebook_site]" value="<?php echo( ( isset( $socials->facebook_site ) ) ? esc_attr( $socials->facebook_site ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="socials_linkedin_url"><?php echo esc_html__( "LinkedIn Profile URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1"><?php echo "https://linkedin.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input id="socials_linkedin_url" type="text" class="form-control bg-input" name="socials[linkedin_url]" value="<?php echo( ( isset( $socials->linkedin_url ) ) ? esc_attr( $socials->linkedin_url ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="socials_pinterest_url"><?php echo esc_html__( "Pinterest Profile URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1"><?php echo "https://pinterest.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input id="socials_pinterest_url" type="text" class="form-control bg-input" name="socials[pinterest_url]" value="<?php echo( ( isset( $socials->pinterest_url ) ) ? esc_attr( $socials->pinterest_url ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="socials_instagram_url"><?php echo esc_html__( "Instagram Profile URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1"><?php echo "https://instagram.com/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input id="socials_instagram_url" type="text" class="form-control bg-input" name="socials[instagram_url]" value="<?php echo( ( isset( $socials->instagram_url ) ) ? esc_attr( $socials->instagram_url ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="socials_youtube_url"><?php echo esc_html__( "Youtube Channel URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1"><?php echo "https://youtube.com/channel/XXXXX"; ?></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group input-group-lg">
                                                <input id="socials_youtube_url" type="text" class="form-control bg-input" name="socials[youtube_url]" value="<?php echo( ( isset( $socials->youtube_url ) ) ? esc_attr( $socials->youtube_url ) : '' ) ?>"/>
                                            </div>
                                        </div>
									<?php } ?>

									<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ) ) { ?>

                                        <h3 class="card-title mt-5"><?php echo esc_html__( "Rich Snippets", 'squirrly-seo' ); ?>
                                            : <?php echo esc_html__( "JSON-LD Schema", 'squirrly-seo' ); ?></h3>

										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_personal' ) ) { ?>

                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0">
                                                    <label for="sq_jsonld_type" class="font-weight-bold"><?php echo esc_html__( "JSON-LD Type: ", 'squirrly-seo' ); ?>
                                                        :</label>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select between a Personal or a Business website type.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group">
                                                    <select id="sq_jsonld_type" name="sq_jsonld_type" class="form-control bg-input mb-1 border">
                                                        <option value="Organization"><?php echo esc_html__( "Organization", 'squirrly-seo' ); ?></option>
                                                        <option value="Person"><?php echo esc_html__( "Person", 'squirrly-seo' ); ?></option>
                                                    </select>
                                                </div>
                                            </div>


										<?php } ?>


                                        <div class="col-12 m-0 p-0 my-5 tab-panel-Organization">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
                                                    <label for="sq_jsonld_Organization_name"><?php echo esc_html__( "Your Organization Name", 'squirrly-seo' ); ?>
                                                        :</label>
                                                    <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1">e.g. COMPANY LTD</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="sq_jsonld_Organization_name" type="text" class="form-control bg-input" name="sq_jsonld[Organization][name]" value="<?php echo( ( isset( $jsonld['Organization']['name'] ) && $jsonld['Organization']['name'] <> '' ) ? esc_attr( $jsonld['Organization']['name'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Logo URL", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <label for="sq_jsonld_logo_organization"></label><input id="sq_jsonld_logo_organization" type="text" class="form-control bg-input" name="sq_jsonld[Organization][logo][url]" value="<?php echo( ( isset( $jsonld['Organization']['logo']['url'] ) && $jsonld['Organization']['logo']['url'] <> '' ) ? esc_url( $jsonld['Organization']['logo']['url'] ) : '' ) ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-0" data-destination="sq_jsonld_logo_organization" value="<?php echo esc_attr__( "Select Image", 'squirrly-seo' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
                                                    <label for="sq_jsonld_Organization_description"><?php echo esc_html__( "Short Description", 'squirrly-seo' ); ?>
                                                        :</label>
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "A short description about the company. 20-50 words.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-8 p-0">
                                                    <textarea id="sq_jsonld_Organization_description" class="form-control" name="sq_jsonld[Organization][description]" rows="3"><?php echo( ( isset( $jsonld['Organization']['description'] ) && $jsonld['Organization']['description'] <> '' ) ? esc_textarea( $jsonld['Organization']['description'] ) : '' ) ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Address", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1">e.g. 38 avenue de l'Opera
                                                    </div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][streetAddress]" value="<?php echo( ( isset( $jsonld['Organization']['address']['streetAddress'] ) && $jsonld['Organization']['address']['streetAddress'] ) ? esc_attr( $jsonld['Organization']['address']['streetAddress'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "City", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1">e.g. Paris</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressLocality]" value="<?php echo( ( isset( $jsonld['Organization']['address']['addressLocality'] ) && $jsonld['Organization']['address']['addressLocality'] ) ? esc_attr( $jsonld['Organization']['address']['addressLocality'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "County", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1">e.g. County / State</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressRegion]" value="<?php echo( ( isset( $jsonld['Organization']['address']['addressRegion'] ) && $jsonld['Organization']['address']['addressRegion'] ) ? esc_attr( $jsonld['Organization']['address']['addressRegion'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Country", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1">e.g. US</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressCountry]" value="<?php echo( ( isset( $jsonld['Organization']['address']['addressCountry'] ) && $jsonld['Organization']['address']['addressCountry'] ) ? esc_attr( $jsonld['Organization']['address']['addressCountry'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Postal Code", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1">e.g. F-75002</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][postalCode]" value="<?php echo( ( isset( $jsonld['Organization']['address']['postalCode'] ) && $jsonld['Organization']['address']['postalCode'] ) ? esc_attr( $jsonld['Organization']['address']['postalCode'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "Contact Phone", 'squirrly-seo' ); ?>:
                                                    <div class="small text-black-50 my-1">e.g. +1-541-754-3010</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][contactPoint][telephone]" value="<?php echo( ( isset( $jsonld['Organization']['contactPoint']['telephone'] ) && $jsonld['Organization']['contactPoint']['telephone'] ) ? esc_attr( $jsonld['Organization']['contactPoint']['telephone'] ) : '' ) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Contact Type", 'squirrly-seo' ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-8 m-0 p-0 input-group">
                                                    <select name="sq_jsonld[Organization][contactPoint][contactType]" class="form-control bg-input mb-1 border">
                                                        <option value=""></option>
                                                        <option value="customer service" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'customer service' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Customer Service", 'squirrly-seo' ); ?></option>
                                                        <option value="technical support" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'technical support' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Technical Support", 'squirrly-seo' ); ?></option>
                                                        <option value="billing support" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'billing support' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Billing Support", 'squirrly-seo' ); ?></option>
                                                        <option value="bill payment" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'bill payment' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Bill Payment", 'squirrly-seo' ); ?></option>
                                                        <option value="sales" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'sales' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Sales", 'squirrly-seo' ); ?></option>
                                                        <option value="reservations" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'reservations' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Reservations", 'squirrly-seo' ); ?></option>
                                                        <option value="credit card support" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'credit card support' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Credit Card Support", 'squirrly-seo' ); ?></option>
                                                        <option value="emergency" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'emergency' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Emergency", 'squirrly-seo' ); ?></option>
                                                        <option value="baggage tracking" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'baggage tracking' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Baggage Tracking", 'squirrly-seo' ); ?></option>
                                                        <option value="roadside assistance" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'roadside assistance' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Roadside Assistance", 'squirrly-seo' ); ?></option>
                                                        <option value="package tracking" <?php echo( ( isset( $jsonld['Organization']['contactPoint']['contactType'] ) && $jsonld['Organization']['contactPoint']['contactType'] == 'package tracking' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Package Tracking", 'squirrly-seo' ); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

										<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_personal' ) ) { ?>
                                            <div class="col-12 m-0 p-0 my-5 tab-panel-Person" style="display: none">

                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="col-4 m-0 p-0 font-weight-bold">
														<?php echo esc_html__( "Your Name", 'squirrly-seo' ); ?>:
                                                        <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Profile" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        <div class="small text-black-50 my-1 pr-3">e.g. John Smith</div>
                                                    </div>
                                                    <div class="col-8 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="sq_jsonld[Person][name]" value="<?php echo( ( isset( $jsonld['Person']['name'] ) && $jsonld['Person']['name'] <> '' ) ? esc_attr( $jsonld['Person']['name'] ) : '' ) ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="col-4 m-0 p-0 font-weight-bold">
														<?php echo esc_html__( "Job Title", 'squirrly-seo' ); ?>:
                                                        <div class="small text-black-50 my-1">e.g. Sales Manager</div>
                                                    </div>
                                                    <div class="col-5 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="sq_jsonld[Person][jobTitle]" value="<?php echo( ( isset( $jsonld['Person']['jobTitle'] ) && $jsonld['Person']['jobTitle'] <> '' ) ? esc_attr( $jsonld['Person']['jobTitle'] ) : '' ) ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="col-4 m-0 p-0 font-weight-bold">
														<?php echo esc_html__( "Logo URL", 'squirrly-seo' ); ?>:
                                                        <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select an image from Media Library.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                    <div class="col-8 p-0 input-group input-group-lg">
                                                        <input id="sq_jsonld_logo_person" type="text" class="form-control bg-input" name="sq_jsonld[Person][image][url]" value="<?php echo( ( isset( $jsonld['Person']['image']['url'] ) && $jsonld['Person']['image']['url'] <> '' ) ? esc_url( $jsonld['Person']['image']['url'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "Select your file here", 'squirrly-seo' ) ?>"/>
                                                        <input type="button" class="sq_imageselect form-control btn btn-primary rounded-0 col-3" data-destination="sq_jsonld_logo_person" value="<?php echo esc_attr__( "Select Image", 'squirrly-seo' ) ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="col-4 m-0 p-0 font-weight-bold">
														<?php echo esc_html__( "Contact Phone", 'squirrly-seo' ); ?>:
                                                        <div class="small text-black-50 my-1 pr-3">e.g.
                                                            +1-541-754-3010
                                                        </div>
                                                    </div>
                                                    <div class="col-5 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="sq_jsonld[Person][telephone]" value="<?php echo( ( isset( $jsonld['Person']['telephone'] ) && $jsonld['Person']['telephone'] <> '' ) ? esc_attr( $jsonld['Person']['telephone'] ) : '' ) ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="col-4 m-0 p-0 font-weight-bold">
														<?php echo esc_html__( "Short Description", 'squirrly-seo' ); ?>
                                                        :
                                                        <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "A short description about your job title.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                    <div class="col-8 p-0">
                                                        <textarea class="form-control" name="sq_jsonld[Person][description]" rows="3"><?php echo( ( isset( $jsonld['Person']['description'] ) && $jsonld['Person']['description'] <> '' ) ? esc_textarea( $jsonld['Person']['description'] ) : '' ) ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
										<?php } ?>
									<?php } ?>

									<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ) ) { ?>

                                        <h3 class="card-title mt-5"><?php echo esc_html__( "GEO Location", 'squirrly-seo' ); ?>
                                            :</h3>
                                        <div class="col-12 m-0 p-0 my-5">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-4 m-0 p-0 font-weight-bold">
													<?php echo esc_html__( "GEO Settings", 'squirrly-seo' ); ?>:
                                                    <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#local_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__( "Latitude & Longitude of your store/business.", 'squirrly-seo' ); ?></div>
                                                    <div class="small text-black-50 my-1">
                                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank"><?php echo esc_html__( "Get GEO Coordonates based on address.", 'squirrly-seo' ); ?></a>
                                                    </div>
                                                </div>
                                                <div class="col-8 p-0">
                                                    <div class="row px-3">
                                                        <div class="col-5 py-0 pl-0 pr-2">
                                                            <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][place][geo][latitude]" value="<?php echo( ( isset( $jsonld['Organization']['place']['geo']['latitude'] ) && $jsonld['Organization']['place']['geo']['latitude'] ) ? esc_attr( $jsonld['Organization']['place']['geo']['latitude'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "latitude", 'squirrly-seo' ); ?>"/>
                                                        </div>
                                                        <div class="col-5 py-0 pl-2 pr-0">
                                                            <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][place][geo][longitude]" value="<?php echo( ( isset( $jsonld['Organization']['place']['geo']['longitude'] ) && $jsonld['Organization']['place']['geo']['longitude'] ) ? esc_attr( $jsonld['Organization']['place']['geo']['longitude'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "longitude", 'squirrly-seo' ); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="row px-3 pt-2">
                                                        <div class="col-10 text-black-50 p-0"><?php echo sprintf( esc_html__( "Download the file %s for GEO Coordonates to import into %s Google Earth %s.", 'squirrly-seo' ), '<strong><a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getKmlUrl( 'locations' ) ) . '">' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getKmlUrl( 'locations' ) ) . '</a></strong>', '<a href="https://support.google.com/earth/answer/7365595?co=GENIE.Platform%3DDesktop&hl=en" target="_blank" >', '</a>' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h3 class="card-title mt-5"><?php echo esc_html__( "Opening Hours", 'squirrly-seo' ); ?>
                                            :</h3>
                                        <div class="col-12 m-0 p-0 my-5">
											<?php
											$jsonldLocal = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_local' );
											$dayOfWeek   = array(
												'Monday',
												'Tuesday',
												'Wednesday',
												'Thursday',
												'Friday',
												'Saturday',
												'Sunday'
											);

											foreach ( $dayOfWeek as $index => $value ) { ?>
                                                <div class="col-12 row m-0 p-0 my-5">
                                                    <div class="col-4 m-0 p-0 font-weight-bold"><?php echo esc_html( $value ); ?></div>
                                                    <div class="col-4 m-0 p-0 pr-2">
                                                        <div class="row">
                                                            <div class="col-4  m-0 p-0 py-2 text-right"><?php echo esc_html__( "Opens", 'squirrly-seo' ); ?>
                                                                :
                                                            </div>
                                                            <div class="col">
                                                                <input type="text" class="form-control bg-input" name="sq_jsonld_local[openingHoursSpecification][<?php echo esc_attr( $index ) ?>][opens]" value="<?php echo( ( $jsonldLocal['openingHoursSpecification'][ $index ]['opens'] ) ? esc_attr( $jsonldLocal['openingHoursSpecification'][ $index ]['opens'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "08:00", 'squirrly-seo' ); ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 m-0 p-0 pl-2">
                                                        <div class="row">
                                                            <div class="col-4 m-0 p-0 py-2 text-right"><?php echo esc_html__( "Closes", 'squirrly-seo' ); ?>
                                                                :
                                                            </div>
                                                            <div class="col">
                                                                <input type="text" class="form-control bg-input" name="sq_jsonld_local[openingHoursSpecification][<?php echo esc_attr( $index ) ?>][closes]" value="<?php echo( ( $jsonldLocal['openingHoursSpecification'][ $index ]['closes'] ) ? esc_attr( $jsonldLocal['openingHoursSpecification'][ $index ]['closes'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "23:00", 'squirrly-seo' ); ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
											<?php } ?>

                                        </div>
                                        <h3 class="card-title mt-5"><?php echo esc_html__( "Local Restaurant", 'squirrly-seo' ); ?>
                                            :</h3>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Price Range", 'squirrly-seo' ); ?>:
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <select name="sq_jsonld_local[priceRange]" class="form-control bg-input mb-1 border">
                                                    <option value=""></option>
                                                    <option value="$" <?php echo( ( isset( $jsonldLocal['priceRange'] ) && $jsonldLocal['priceRange'] == '$' ) ? 'selected="selected"' : '' ); ?>>
                                                        $
                                                    </option>
                                                    <option value="$$" <?php echo( ( isset( $jsonldLocal['priceRange'] ) && $jsonldLocal['priceRange'] == '$$' ) ? 'selected="selected"' : '' ); ?>>
                                                        $$
                                                    </option>
                                                    <option value="$$$" <?php echo( ( isset( $jsonldLocal['priceRange'] ) && $jsonldLocal['priceRange'] == '$$$' ) ? 'selected="selected"' : '' ); ?>>
                                                        $$
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Serves Cuisine", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1">e.g. American, Italiano</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="sq_jsonld_local[servesCuisine]" value="<?php echo( ( isset( $jsonldLocal['servesCuisine'] ) && $jsonldLocal['servesCuisine'] ) ? esc_attr( $jsonldLocal['servesCuisine'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Menu Link", 'squirrly-seo' ); ?>:
                                                <div class="small text-black-50 my-1">Restaurant Menu URL</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="sq_jsonld_local[menu]" value="<?php echo( ( isset( $jsonldLocal['menu'] ) && $jsonldLocal['menu'] ) ? esc_attr( $jsonldLocal['menu'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "Accept Reservations", 'squirrly-seo' ); ?>:
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <select name="sq_jsonld_local[acceptsReservations]" class="form-control bg-input mb-1 border">
                                                    <option value=""></option>
                                                    <option value="False" <?php echo( ( isset( $jsonldLocal['acceptsReservations'] ) && $jsonldLocal['acceptsReservations'] == 'False' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "No" ); ?></option>
                                                    <option value="True" <?php echo( ( isset( $jsonldLocal['acceptsReservations'] ) && $jsonldLocal['acceptsReservations'] == 'True' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Yes" ); ?></option>
                                                </select>
                                            </div>
                                        </div>
									<?php } ?>

                                </div>

                            </div>

                            <div class="col-12 m-0 p-0 my-5">
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

