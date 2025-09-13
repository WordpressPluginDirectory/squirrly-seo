<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Settings {

	/**
	 * Save the settings in sq_options
	 *
	 * @return void
	 */
	public function saveSettings() {

		//Save the settings
		$this->saveValues( $_POST );

		//Save custom links
		if ( SQ_Classes_Helpers_Tools::getIsset( 'links_permission' ) ) {
			$links = SQ_Classes_Helpers_Tools::getValue( 'links_permission', '', true );
			$links = explode( PHP_EOL, $links );
			$links = str_replace( "\r", "", $links );

			if ( ! empty( $links ) ) {
				SQ_Classes_Helpers_Tools::saveOptions('sq_external_exception', array_unique( $links ));
			}
		}

		//Make sure we get the Sitemap data from the form
		if ( $sitemap = SQ_Classes_Helpers_Tools::getValue( 'sitemap' ) ) {
			foreach ( SQ_Classes_Helpers_Tools::$options['sq_sitemap'] as $key => $value ) {
				if ( isset( $sitemap[ $key ] ) ) {
					SQ_Classes_Helpers_Tools::$options['sq_sitemap'][ $key ][1] = (int) $sitemap[ $key ];
				} elseif ( $key <> 'sitemap' ) {
					SQ_Classes_Helpers_Tools::$options['sq_sitemap'][ $key ][1] = 0;
				}
			}

		}

		//delete other sitemap xml files from root
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) && file_exists( ABSPATH . "/" . 'sitemap.xml' ) ) {
			@rename( ABSPATH . "/" . 'sitemap.xml', ABSPATH . "/" . 'sitemap_ren' . time() . '.xml' );
		}

		//Save custom robots
		if ( SQ_Classes_Helpers_Tools::getIsset( 'robots_permission' ) ) {
			$robots = SQ_Classes_Helpers_Tools::getValue( 'robots_permission', '', true );
			$robots = explode( PHP_EOL, $robots );
			$robots = str_replace( "\r", "", $robots );

			if ( ! empty( $robots ) ) {

				if ( file_exists( ABSPATH . "/" . 'robots.txt' ) ) {
					@rename( ABSPATH . "/" . 'robots.txt', ABSPATH . "/" . 'robots_ren' . time() . '.txt' );
				}

				SQ_Classes_Helpers_Tools::saveOptions('sq_robots_permission', $robots);
			}
		}

		//Save custom llms
		if ( SQ_Classes_Helpers_Tools::getIsset( 'llms_permission' ) ) {
			$llms = SQ_Classes_Helpers_Tools::getValue( 'llms_permission', '', true );
			$llms = explode( PHP_EOL, $llms );
			$llms = str_replace( "\r", "", $llms );

			if ( ! empty( $llms ) ) {

				if ( file_exists( ABSPATH . "/" . 'llms.txt' ) ) {
					@rename( ABSPATH . "/" . 'llms.txt', ABSPATH . "/" . 'llms_ren' . time() . '.txt' );
				}

				SQ_Classes_Helpers_Tools::saveOptions('sq_llms_permission', $llms);
			}
		}

		/* if there is an icon to upload */
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ) ) {
			if ( ! empty( $_FILES['favicon'] ) ) {
				if ( $return = SQ_Classes_ObjController::getClass( 'SQ_Models_Ico' )->addFavicon( $_FILES['favicon'] ) ) {
					if ( $return['favicon'] <> '' ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'favicon', strtolower( basename( $return['favicon'] ) ) );
					}
				}
			}
		}

		SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone']                       = SQ_Classes_Helpers_Sanitize::checkTelephone( SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'] );
		SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['contactPoint']['telephone'] = SQ_Classes_Helpers_Sanitize::checkTelephone( SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['contactPoint']['telephone'] );


		//save the options in database
		SQ_Classes_Helpers_Tools::saveOptions();

		//empty the sitemap cache on settings save
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_do_cache' ) ) {
			SQ_Classes_Helpers_Tools::emptyLocalCache();
		}

		//reset the report time
		SQ_Classes_Helpers_Tools::saveOptions( 'seoreport_time', false );

		//trigger action after settings are saved
		do_action( 'sq_save_settings_after' );
	}

	/**
	 * Save the form submit values in sq_option row in wp_options table
	 *
	 * @param $params
	 */
	public function saveValues( $params ) {
		if ( ! empty( $params ) ) {

			//Save the option values
			foreach ( $params as $key => $value ) {
				if ( in_array( $key, array_keys( SQ_Classes_Helpers_Tools::$options ) ) ) {

					//Sanitize each value from subarray
					$value = SQ_Classes_Helpers_Tools::getValue( $key );
					$value = SQ_Classes_Helpers_Sanitize::sanitizeField( $value );

					//Initialize the array for some options
					if ( $key == 'sq_sla_exclude_post_types' ) {
						SQ_Classes_Helpers_Tools::$options[ $key ] = array();
					}

					if ( is_array( SQ_Classes_Helpers_Tools::$options[ $key ] ) ) {

						//Save the array values
						if ( is_array( $value ) ) {
							if ( ! empty( $value ) ) {

								foreach ( $value as $subkey => $subvalue ) {

									switch ( $subkey ) {
										case 'google_wt':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkGoogleWTCode( $value[ $subkey ] );
											break;
										case 'bing_wt':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkBingWTCode( $value[ $subkey ] );
											break;
										case 'baidu_wt':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkBaiduWTCode( $value[ $subkey ] );
											break;
										case 'yandex_wt':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkYandexWTCode( $value[ $subkey ] );
											break;
										case 'pinterest_verify':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkPinterestCode( $value[ $subkey ] );
											break;
										case 'google_analytics':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkGoogleAnalyticsCode( $value[ $subkey ] );
											break;
										case 'facebook_pixel':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkFacebookPixel( $value[ $subkey ] );
											break;
										case 'twitter_site':
											$subvalue                                             = SQ_Classes_Helpers_Sanitize::checkTwitterAccount( $value[ $subkey ] );
											SQ_Classes_Helpers_Tools::$options[ $key ]['twitter'] = SQ_Classes_Helpers_Sanitize::checkTwitterAccountName( $value[ $subkey ] );
											break;
										case 'facebook_site':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkFacebookAccount( $value[ $subkey ] );
											break;
										case 'pinterest_url':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkPinterestAccount( $value[ $subkey ] );
											break;
										case 'instagram_url':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkInstagramAccount( $value[ $subkey ] );
											break;
										case 'linkedin_url':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkLinkeinAccount( $value[ $subkey ] );
											break;
										case 'youtube_url':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkYoutubeAccount( $value[ $subkey ] );
											break;
										case 'fb_admins':
											if ( is_array( $value[ $subkey ] ) && ! empty( $value[ $subkey ] ) ) {
												foreach ( $value[ $subkey ] as $index => $admin ) {
													$value[ $subkey ][ $index ] = SQ_Classes_Helpers_Sanitize::checkFacebookAdminCode( $admin );
												}

												$subvalue = $value[ $subkey ];
											}
											break;
										case 'fbadminapp':
											$subvalue = SQ_Classes_Helpers_Sanitize::checkFacebookApp( $value[ $subkey ] );
											break;
									}

									SQ_Classes_Helpers_Tools::$options[ $key ][ $subkey ] = $subvalue;
								}
							}
						}

						// save options in db
						SQ_Classes_Helpers_Tools::saveOptions();

					} else {
						// save option in db
						SQ_Classes_Helpers_Tools::saveOptions( $key, $value );
					}
				}
			}

			do_action( 'sq_save_settings_after', $params );
		}
	}

}
