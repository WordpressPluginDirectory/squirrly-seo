<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * JsonLD view
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
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>
                <form method="POST">
					<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_save', 'sq_nonce' ); ?>
                    <input type="hidden" name="action" value="sq_seosettings_save"/>

                    <div class="col-12 p-0 m-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                        <h3 class="mt-4 card-title">
							<?php echo esc_html__( "Rich Snippets", 'squirrly-seo' ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                            </div>
                        </h3>
                        <div class="col-7 small m-0 p-0">
							<?php echo esc_html__( "JSON-LD structured data influences how Google will create rich snippets for your URLs.", 'squirrly-seo' ); ?>
                        </div>
                        <div class="col-7 small m-0 p-0 py-2">
							<?php echo esc_html__( "Test your Rich Snippets using the JSON-LD validator. If that one says all is good, then all is good. It's then up to Google's search engine to decide if it 'wants' to start generating rich snippets for you. You can't do anything else than just to pass the validation. However, a good score in the SEO Audit by Squirrly will prove to Google that your site deserves rich results in search.", 'squirrly-seo' ); ?>
                        </div>

						<?php $view->show_view( 'Blocks/SubMenuHeader' ); ?>
                        <div class="d-flex flex-row p-0 m-0 bg-white">
							<?php $view->show_view( 'Blocks/SubMenu' ); ?>
							<?php
							$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
							$jsonldtype = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_type' );
							?>

                            <div class="d-flex flex-column flex-grow-1 m-0 p-0">

                                <div id="company" class="col-12 py-0 px-4 m-0 tab-panel tab-panel-first active">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Company", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="small text-danger my-1 pr-3"><?php echo esc_html__( "ONLY use this if you have a company", 'squirrly-seo' ); ?></div>

                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_name"><?php echo esc_html__( "Your Organization Name", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3">e.g. COMPANY LTD</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_name" type="text" class="form-control bg-input" name="sq_jsonld[Organization][name]" value="<?php echo( ( isset( $jsonld['Organization']['name'] ) && $jsonld['Organization']['name'] <> '' ) ? esc_attr( $jsonld['Organization']['name'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_url"><?php echo esc_html__( "Company URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "leave it empty if it's the website URL", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_url" type="text" class="form-control bg-input" name="sq_jsonld[Organization][url]" value="<?php echo( ( isset( $jsonld['Organization']['url'] ) && $jsonld['Organization']['url'] <> '' ) ? esc_attr( $jsonld['Organization']['url'] ) : '' ) ?>" placeholder="<?php echo home_url() ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_logo_organization"><?php echo esc_html__( "Logo URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select an image from Media Library.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_logo_organization" type="text" class="form-control bg-input" name="sq_jsonld[Organization][logo][url]" value="<?php echo( ( isset( $jsonld['Organization']['logo']['url'] ) && $jsonld['Organization']['logo']['url'] <> '' ) ? esc_url( $jsonld['Organization']['logo']['url'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "Select your file here", 'squirrly-seo' ) ?>"/>
                                                <input type="button" class="sq_imageselect btn btn-primary rounded-0" data-destination="sq_jsonld_logo_organization" value="<?php echo esc_attr__( "Select Image", 'squirrly-seo' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_description"><?php echo esc_html__( "Short Description", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "A short description about the company (20-50 words).", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 p-0">
                                                <textarea id="sq_jsonld_Organization_description" class="form-control" name="sq_jsonld[Organization][description]" rows="3"><?php echo( ( isset( $jsonld['Organization']['description'] ) && $jsonld['Organization']['description'] <> '' ) ? esc_textarea( $jsonld['Organization']['description'] ) : '' ) ?></textarea>
                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_company_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>

                                </div>
                                <div id="personal" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Personal Brand / Author", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Profile" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="small text-danger my-1 pr-3"><?php echo esc_html__( "Only use this if you have a personal brand. You can combine this with JSON-LD for companies, local SEO and more. One doesn't exclude the others.", 'squirrly-seo' ); ?></div>

                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Person_name"><?php echo esc_html__( "Your Name", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Profile" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3">e.g. John Smith</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Person_name" type="text" class="form-control bg-input" name="sq_jsonld[Person][name]" value="<?php echo( ( isset( $jsonld['Person']['name'] ) && $jsonld['Person']['name'] <> '' ) ? esc_attr( $jsonld['Person']['name'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Person_jobTitle"><?php echo esc_html__( "Job Title", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1">e.g. Sales Manager</div>
                                            </div>
                                            <div class="col-5 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Person_jobTitle" type="text" class="form-control bg-input" name="sq_jsonld[Person][jobTitle]" value="<?php echo( ( isset( $jsonld['Person']['jobTitle'] ) && $jsonld['Person']['jobTitle'] <> '' ) ? esc_attr( $jsonld['Person']['jobTitle'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_logo_person"><?php echo esc_html__( "Logo URL", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select an image from Media Library.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_logo_person" type="text" class="form-control bg-input" name="sq_jsonld[Person][image][url]" value="<?php echo( ( isset( $jsonld['Person']['image']['url'] ) && $jsonld['Person']['image']['url'] <> '' ) ? esc_url( $jsonld['Person']['image']['url'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "Select your file here", 'squirrly-seo' ) ?>"/>
                                                <input type="button" class="sq_imageselect form-control btn btn-primary rounded-0 col-3" data-destination="sq_jsonld_logo_person" value="<?php echo esc_attr__( "Select Image", 'squirrly-seo' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Person_telephone"><?php echo esc_html__( "Contact Phone", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. +1-541-754-3010</div>
                                            </div>
                                            <div class="col-5 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Person_telephone" type="text" class="form-control bg-input" name="sq_jsonld[Person][telephone]" value="<?php echo( ( isset( $jsonld['Person']['telephone'] ) && $jsonld['Person']['telephone'] <> '' ) ? esc_attr( $jsonld['Person']['telephone'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Person_description"><?php echo esc_html__( "Short Description", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "A short description about your job title.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-8 p-0">
                                                <textarea id="sq_jsonld_Person_description" class="form-control" name="sq_jsonld[Person][description]" rows="3"><?php echo( ( isset( $jsonld['Person']['description'] ) && $jsonld['Person']['description'] <> '' ) ? esc_textarea( $jsonld['Person']['description'] ) : '' ) ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_global_person" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_global_person" name="sq_jsonld_global_person" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_global_person' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_jsonld_global_person" class="ml-1"><?php echo esc_html__( "Set this person as a global author", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#global_author" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Overwrite the posts/pages author(s) with this author in Json-LD.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_personal_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>

                                </div>
                                <div id="woocommerce" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "WooCommerce", 'squirrly-seo' ); ?>
                                            <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_woocommerce" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_woocommerce" name="sq_jsonld_woocommerce" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_woocommerce' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_jsonld_woocommerce" class="ml-1"><?php echo esc_html__( "Add Support For Woocommerce", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Improve the WooCommerce  Product and Orders Schema by enabling Squirrly to add the required data.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sq_jsonld_woocommerce">
                                            <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_product_custom" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_product_custom" name="sq_jsonld_product_custom" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_product_custom' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                        <label for="sq_jsonld_product_custom" class="ml-1"><?php echo esc_html__( "Add Custom Data for WooCommerce Products", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Enable Squirrly to include additional metadata fields for WooCommerce Products: MPN, ISBN, EAN, UPC, GTIN, Brand, Review.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="checker col-12 row m-0 p-0">
                                                    <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_product_defaults" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_product_defaults" name="sq_jsonld_product_defaults" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_product_defaults' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                        <label for="sq_jsonld_product_defaults" class="ml-1"><?php echo esc_html__( "Add Default Data for Woocommerce Products", 'squirrly-seo' ); ?>
                                                            <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="small text-black-50 ml-5"><?php echo esc_html__( "Add default data for JSON-LD AggregateRating, Offers, Sku, MPN when they are missing from the product to avoid GSC errors.", 'squirrly-seo' ); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_woocommerce_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>

                                </div>
                                <div id="localseo" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Local SEO", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_streetAddress"><?php echo esc_html__( "Address", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. 38 avenue de l'Opera
                                                </div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_streetAddress" type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][streetAddress]" value="<?php echo( ( isset( $jsonld['Organization']['address']['streetAddress'] ) && $jsonld['Organization']['address']['streetAddress'] ) ? esc_attr( $jsonld['Organization']['address']['streetAddress'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_address_addressLocality"><?php echo esc_html__( "City", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. Paris</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_address_addressLocality" type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressLocality]" value="<?php echo( ( isset( $jsonld['Organization']['address']['addressLocality'] ) && $jsonld['Organization']['address']['addressLocality'] ) ? esc_attr( $jsonld['Organization']['address']['addressLocality'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_address_addressRegion"><?php echo esc_html__( "County", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. County / State</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_address_addressRegion" type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressRegion]" value="<?php echo( ( isset( $jsonld['Organization']['address']['addressRegion'] ) && $jsonld['Organization']['address']['addressRegion'] ) ? esc_attr( $jsonld['Organization']['address']['addressRegion'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_address_addressCountry"><?php echo esc_html__( "Country", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. US</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_address_addressCountry" type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressCountry]" value="<?php echo( ( isset( $jsonld['Organization']['address']['addressCountry'] ) && $jsonld['Organization']['address']['addressCountry'] ) ? esc_attr( $jsonld['Organization']['address']['addressCountry'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_address_postalCode"><?php echo esc_html__( "Postal Code", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. F-75002</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_address_postalCode" type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][postalCode]" value="<?php echo( ( isset( $jsonld['Organization']['address']['postalCode'] ) && $jsonld['Organization']['address']['postalCode'] ) ? esc_attr( $jsonld['Organization']['address']['postalCode'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_Organization_contactPoint_telephone"><?php echo esc_html__( "Contact Phone", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. +1-541-754-3010</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_Organization_contactPoint_telephone" type="text" class="form-control bg-input" name="sq_jsonld[Organization][contactPoint][telephone]" value="<?php echo( ( isset( $jsonld['Organization']['contactPoint']['telephone'] ) && $jsonld['Organization']['contactPoint']['telephone'] ) ? esc_attr( $jsonld['Organization']['contactPoint']['telephone'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0">
                                                <label for="sq_jsonld_Organization_contactPoint_contactType" class="font-weight-bold"><?php echo esc_html__( "Contact Type", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3"></div>
                                            </div>
                                            <div class="col-8 m-0 p-0 input-group">
                                                <select id="sq_jsonld_Organization_contactPoint_contactType" name="sq_jsonld[Organization][contactPoint][contactType]" class="form-control bg-input mb-1 border">
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

										<?php do_action( 'sq_jsonld_localseo_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>


                                </div>
                                <div id="location" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "GEO Location", 'squirrly-seo' ); ?></h3>

                                        <div class="col-12 m-0 p-0 py-2">
                                            <div class="col-10 text-black-50 p-0"><?php echo sprintf( esc_html__( "Download the file %s for GEO Coordonates to import into %s Google Earth %s.", 'squirrly-seo' ), '<strong><a href="' . esc_url( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getKmlUrl( 'locations' ) ) . '">' . esc_html( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' )->getKmlUrl( 'locations' ) ) . '</a></strong>', '<a href="https://support.google.com/earth/answer/7365595?co=GENIE.Platform%3DDesktop&hl=en" target="_blank" >', '</a>' ); ?></div>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
												<?php echo esc_html__( "GEO Settings", 'squirrly-seo' ); ?>:
                                                <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#local_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Latitude & Longitude of your store/business.", 'squirrly-seo' ); ?></div>
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

                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_location_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="hours" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Opening Hours", 'squirrly-seo' ); ?></h3>
                                    </div>

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
                                                        <div class="col-4  m-0 p-0 py-2 text-right">
                                                            <label for="sq_jsonld_local_openingHoursSpecification"><?php echo esc_html__( "Opens", 'squirrly-seo' ); ?>
                                                                :</label>
                                                        </div>
                                                        <div class="col">
                                                            <input id="sq_jsonld_local_openingHoursSpecification" type="text" class="form-control bg-input" name="sq_jsonld_local[openingHoursSpecification][<?php echo esc_attr( $index ) ?>][opens]" value="<?php echo( ( $jsonldLocal['openingHoursSpecification'][ $index ]['opens'] ) ? esc_attr( $jsonldLocal['openingHoursSpecification'][ $index ]['opens'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "08:00", 'squirrly-seo' ); ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 m-0 p-0 pl-2">
                                                    <div class="row">
                                                        <div class="col-4 m-0 p-0 py-2 text-right">
                                                            <label for="sq_jsonld_local_openingHoursSpecification"><?php echo esc_html__( "Closes", 'squirrly-seo' ); ?>
                                                                :</label>
                                                        </div>
                                                        <div class="col">
                                                            <input id="sq_jsonld_local_openingHoursSpecification" type="text" class="form-control bg-input" name="sq_jsonld_local[openingHoursSpecification][<?php echo esc_attr( $index ) ?>][closes]" value="<?php echo( ( $jsonldLocal['openingHoursSpecification'][ $index ]['closes'] ) ? esc_attr( $jsonldLocal['openingHoursSpecification'][ $index ]['closes'] ) : '' ) ?>" placeholder="<?php echo esc_attr__( "23:00", 'squirrly-seo' ); ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										<?php } ?>

										<?php do_action( 'sq_jsonld_hours_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="restaurant" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Local Restaurant", 'squirrly-seo' ); ?></h3>
                                        <div class="col-12 m-0 p-0 text-danger">
											<?php echo esc_html__( "ONLY use this if you have a restaurant, pizza place, bar, pub, etc. Otherwise, leave blank.", 'squirrly-seo' ); ?>
                                            :
                                        </div>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_local_priceRange"><?php echo esc_html__( "Price Range", 'squirrly-seo' ); ?>
                                                    :</label>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <select id="sq_jsonld_local_priceRange" name="sq_jsonld_local[priceRange]" class="form-control bg-input mb-1 border">
                                                    <option value=""></option>
                                                    <option value="$" <?php echo( ( $jsonldLocal['priceRange'] == '$' ) ? 'selected="selected"' : '' ); ?>>
                                                        $
                                                    </option>
                                                    <option value="$$" <?php echo( ( $jsonldLocal['priceRange'] == '$$' ) ? 'selected="selected"' : '' ); ?>>
                                                        $$
                                                    </option>
                                                    <option value="$$$" <?php echo( ( $jsonldLocal['priceRange'] == '$$$' ) ? 'selected="selected"' : '' ); ?>>
                                                        $$$
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_local_servesCuisine"><?php echo esc_html__( "Serves Cuisine", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">e.g. American, Italiano</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_local_servesCuisine" type="text" class="form-control bg-input" name="sq_jsonld_local[servesCuisine]" value="<?php echo( ( $jsonldLocal['servesCuisine'] ) ? esc_attr( $jsonldLocal['servesCuisine'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_local_menu"><?php echo esc_html__( "Menu Link", 'squirrly-seo' ); ?>
                                                    :</label>
                                                <div class="small text-black-50 my-1 pr-3">Restaurant Menu URL</div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input id="sq_jsonld_local_menu" type="text" class="form-control bg-input" name="sq_jsonld_local[menu]" value="<?php echo( ( $jsonldLocal['menu'] ) ? esc_attr( $jsonldLocal['menu'] ) : '' ) ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_jsonld_local_acceptsReservations"><?php echo esc_html__( "Accept Reservations", 'squirrly-seo' ); ?>
                                                    :</label>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <select id="sq_jsonld_local_acceptsReservations" name="sq_jsonld_local[acceptsReservations]" class="form-control bg-input mb-1 border">
                                                    <option value=""></option>
                                                    <option value="False" <?php echo( ( $jsonldLocal['acceptsReservations'] == 'False' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "No" ); ?></option>
                                                    <option value="True" <?php echo( ( $jsonldLocal['acceptsReservations'] == 'True' ) ? 'selected="selected"' : '' ); ?>><?php echo esc_html__( "Yes" ); ?></option>
                                                </select>
                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_restaurant_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="settings" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "More Json-LD Settings", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="checker col-12 row m-0 p-0">
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

                                        <div class="col-12 row m-0 p-0 my-5 sq_advanced">
                                            <div class="checker col-12 row m-0 p-0">
                                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_clearcode" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_clearcode" name="sq_jsonld_clearcode" class="sq-switch" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_clearcode' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                                    <label for="sq_jsonld_clearcode" class="ml-1"><?php echo esc_html__( "Remove other Json-LD from page", 'squirrly-seo' ); ?>
                                                        <a href="https://howto12.squirrly.co/kb/json-ld-structured-data/#remove_duplicates" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="small text-black-50 ml-5"><?php echo esc_html__( "Clear the Json-LD from other plugins and theme to avoid duplicate schemas.", 'squirrly-seo' ); ?></div>
                                                </div>
                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_settings_after' ); ?>

                                        <div class="col-12 m-0 p-0 mt-5">
                                            <button type="submit" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Save Settings", 'squirrly-seo' ); ?></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="advanced" class="col-12 py-0 px-4 m-0 tab-panel">

                                    <div class="col-12 m-0 p-0 my-2">
                                        <h3 class="card-title"><?php echo esc_html__( "Advanced Settings", 'squirrly-seo' ); ?></h3>
                                    </div>

                                    <div class="col-12 m-0 p-0 my-5">
										<?php $metas = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'sq_metas' ) ) ); ?>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_metas_jsonld_title_maxlength"><?php echo esc_html__( "JSON-LD Title Length", 'squirrly-seo' ); ?>
                                                    :</label>
                                            </div>
                                            <div class="col-6 m-0 p-0 input-group input-group-sm">
                                                <input id="sq_metas_jsonld_title_maxlength" type="text" class="form-control bg-input" name="sq_metas[jsonld_title_maxlength]" value="<?php echo (int) $metas->jsonld_title_maxlength ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-4 m-0 p-0 font-weight-bold">
                                                <label for="sq_metas_jsonld_description_maxlength"><?php echo esc_html__( "JSON-LD Description Length", 'squirrly-seo' ); ?>
                                                    :</label>
                                            </div>
                                            <div class="col-6 m-0 p-0 input-group input-group-sm">
                                                <input id="sq_metas_jsonld_description_maxlength" type="text" class="form-control bg-input" name="sq_metas[jsonld_description_maxlength]" value="<?php echo (int) $metas->jsonld_description_maxlength ?>"/>
                                            </div>
                                        </div>

										<?php do_action( 'sq_jsonld_advanced_after' ); ?>


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
                        <li class="text-left"><?php echo esc_html__( "Want to optimize JSON-LD Schema (Rich Snippets) on all pages?", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo sprintf( esc_html__( "Use the %s SEO Automation %s to setup the Json-LD type based on Post Types.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) ) . '" target="_blank">', '</a>' ); ?></li>
                        <li class="text-left"><?php echo sprintf( esc_html__( "Use %s Bulk SEO %s to optimize the JSON-LD in the SEO Snippet for each page on your website.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) ) . '" target="_blank">', '</a>' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
