<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_ImportExport {

	public function __construct() {
		add_filter( 'sq_themes', array( $this, 'getAvailableThemes' ), 10, 1 );
		add_filter( 'sq_importList', array( $this, 'importList' ) );
	}

	public function importList() {
		if ( $list = SQ_Classes_Helpers_Tools::getOption( 'importList' ) ) {
			return $list;
		}

		$themes = array(
			'builder'      => array(
				'title'        => '_builder_seo_title',
				'description' => '_builder_seo_description',
				'keywords'     => '_builder_seo_keywords',
			),
			'catalyst'     => array(
				'title'        => '_catalyst_title',
				'description' => '_catalyst_description',
				'keywords'     => '_catalyst_keywords',
				'noindex'      => '_catalyst_noindex',
				'nofollow'     => '_catalyst_nofollow',
				'noarchive'    => '_catalyst_noarchive',
			),
			'frugal'       => array(
				'title'        => '_title',
				'description' => '_description',
				'keywords'     => '_keywords',
				'noindex'      => '_noindex',
				'nofollow'     => '_nofollow',
			),
			'genesis'      => array(
				'title'        => '_genesis_title',
				'description' => '_genesis_description',
				'keywords'     => '_genesis_keywords',
				'noindex'      => '_genesis_noindex',
				'nofollow'     => '_genesis_nofollow',
				'noarchive'    => '_genesis_noarchive',
				'canonical'    => '_genesis_canonical_uri',
				'redirect'     => 'redirect',
			),
			'headway'      => array(
				'title'        => '_title',
				'description' => '_description',
				'keywords'     => '_keywords',
			),
			'hybrid'       => array(
				'title'        => 'Title',
				'description' => 'Description',
				'keywords'     => 'Keywords',
			),
			'thesis'       => array(
				'title'       => 'thesis_title',
				'description' => 'thesis_description',
				'keywords'    => 'thesis_keywords',
				'redirect'    => 'thesis_redirect',
			),
			'wooframework' => array(
				'title'       => 'seo_title',
				'description' => 'seo_description',
				'keywords'    => 'seo_keywords',
			),
		);

		$plugins = array(
			'add-meta-tags'              => array(
				'title'       => '_amt_title',
				'description' => '_amt_description',
				'keywords'    => '_amt_keywords',
			),
			'gregs-high-performance-seo' => array(
				'title'       => '_ghpseo_secondary_title',
				'description' => '_ghpseo_alternative_description',
				'keywords'    => '_ghpseo_keywords',
			),
			'headspace2'                 => array(
				'title'       => '_headspace_page_title',
				'description' => '_headspace_description',
				'keywords'    => '_headspace_keywords',
			),
			'platinum-seo-pack'          => array(
				'title'       => 'title',
				'description' => 'description',
				'keywords'    => 'keywords',
			),
			'seo-pressor'                => array(
				'title'       => '_seopressor_meta_title',
				'description' => '_seopressor_meta_description',
			),
			'wp-seopress'                => array(
				'title'          => '_seopress_titles_title',
				'description'    => '_seopress_titles_desc',
				'keywords'       => '_seopress_analysis_target_kw',
				'canonical'      => '_seopress_robots_canonical',
				'og_title'       => '_seopress_social_fb_title',
				'og_description' => '_seopress_social_fb_desc',
				'og_media'       => '_seopress_social_fb_img',
				'tw_title'       => '_seopress_social_twitter_title',
				'tw_description' => '_seopress_social_twitter_desc',
				'tw_media'       => '_seopress_social_twitter_img',
				'redirect'       => '_seopress_redirections_value',
				'redirect_type'  => '_seopress_redirections_type',
				'noindex'        => '_seopress_robots_index',
				'nofollow'       => '_seopress_robots_follow',
			),
			'seo-title-tag'              => array(
				'Custom Doctitle'  => 'title_tag',
				'META Description' => 'meta_description',
			),
			'seo-ultimate'               => array(
				'title'       => '_su_title',
				'description' => '_su_description',
				'keywords'    => '_su_keywords',
				'noindex'     => '_su_meta_robots_noindex',
				'nofollow'    => '_su_meta_robots_nofollow',
			),
			'seo-by-rank-math'           => array(
				'title'          => 'rank_math_title',
				'description'    => 'rank_math_description',
				'keywords'       => 'rank_math_focus_keyword',
				'canonical'      => 'rank_math_canonical_url',
				'og_title'       => 'rank_math_facebook_title',
				'og_description' => 'rank_math_facebook_description',
				'og_media'       => 'rank_math_facebook_image',
				'tw_title'       => 'rank_math_twitter_title',
				'tw_description' => 'rank_math_twitter_description',
				'tw_media'       => 'rank_math_twitter_image',
				'robots'         => 'rank_math_robots'
			),
			'wordpress-seo'              => array(
				'title'            => '_yoast_wpseo_title',
				'description'      => '_yoast_wpseo_metadesc',
				'keywords'         => '_yoast_wpseo_focuskw',
				'noindex'          => '_yoast_wpseo_meta-robots-noindex',
				'nofollow'         => '_yoast_wpseo_meta-robots-nofollow',
				'robots'           => '_yoast_wpseo_meta-robots-adv',
				'canonical'        => '_yoast_wpseo_canonical',
				'redirect'         => '_yoast_wpseo_redirect',
				'focuspage'        => 'yst_is_cornerstone',
				'og_title'         => '_yoast_wpseo_opengraph-title',
				'og_description'   => '_yoast_wpseo_opengraph-description',
				'og_media'         => '_yoast_wpseo_opengraph-image',
				'tw_title'         => '_yoast_wpseo_twitter-title',
				'tw_description'   => '_yoast_wpseo_twitter-description',
				'tw_media'         => '_yoast_wpseo_twitter-image',
				'primary_category' => '_yoast_wpseo_primary_category',
			),
			'all-in-one-seo-pack'        => array(
				'title'          => '_aioseo_title',
				'description'    => '_aioseo_description',
				'keywords'       => '_aioseo_keywords',
				'noindex'        => '_aioseo_noindex',
				'nofollow'       => '_aioseo_nofollow',
				'canonical'      => '_aioseo_custom_link',
				'og_title'       => '_aioseo_og_title',
				'og_description' => '_aioseo_og_description',
				'tw_title'       => '_aioseo_twitter_title',
				'tw_description' => '_aioseo_twitter_description',
			),
			'autodescription'            => array(
				'title'          => '_genesis_title',
				'description'    => '_genesis_description',
				'noindex'        => '_genesis_noindex',
				'nofollow'       => '_genesis_nofollow',
				'canonical'      => '_genesis_canonical_uri',
				'og_title'       => '_open_graph_title',
				'og_description' => '_open_graph_description',
				'og_media'       => '_social_image_url',
				'tw_title'       => '_twitter_title',
				'tw_description' => '_twitter_description',
				'redirect'       => 'redirect',
				'redirect_type'  => '301',
			),
		);
		$themes  = apply_filters( 'sq_themes', $themes );
		$plugins = apply_filters( 'sq_plugins', $plugins );

		$list = array_merge( (array) $plugins, (array) $themes );

		return $list;
	}

	/**
	 * Get the actual name of the plugin/theme
	 *
	 * @param  $path
	 *
	 * @return string
	 */
	public function getName( $path ) {
		switch ( $path ) {
			case 'wordpress-seo':
				return 'Yoast SEO';
			case 'wp-seopress':
				return 'SEO Press';
			case 'seo-by-rank-math':
				return 'Rank Math';
			case 'autodescription':
				return 'SEO Framework';
			default:
				return ucwords( str_replace( '-', ' ', $path ) );
		}
	}


	/**
	 * Rename all the plugin names with a hash
	 */
	public function getAvailablePlugins( $plugins ) {
		$found = array();

		$all_plugins = (array) get_option( 'active_plugins', array() );
		$plugins     = array_keys( $plugins );

		if ( is_multisite() ) {
			$all_plugins = array_merge( $all_plugins, array_keys( (array) get_site_option( 'active_sitewide_plugins' ) ) );
		}

		foreach ( $all_plugins as $plugin ) {
			if ( strpos( $plugin, '/' ) !== false ) {
				$plugin = substr( $plugin, 0, strpos( $plugin, '/' ) );
			}

			if ( in_array( $plugin, $plugins ) ) {
				$found[ $plugin ] = $plugin;
			}
		}

		return $found;
	}

	public function getActivePlugins( $plugins ) {
		$found = array();

		$all_plugins = get_option( 'active_plugins' );

		foreach ( $all_plugins as $plugin ) {
			if ( strpos( $plugin, '/' ) !== false ) {
				$plugin = substr( $plugin, 0, strpos( $plugin, '/' ) );
			}
			if ( isset( $plugins[ $plugin ] ) ) {
				$found[ $plugin ] = $plugins[ $plugin ];
			}
		}

		return $found;
	}

	/**
	 * Rename all the themes name with a hash
	 */
	public function getAvailableThemes( $themes ) {
		$found = array();

		$all_themes = search_theme_directories();

		foreach ( $all_themes as $theme => $value ) {
			if ( isset( $themes[ $theme ] ) ) {
				$found[] = $themes[ $theme ];
			}
		}

		return $found;
	}

	/**
	 * @param  $platform
	 *
	 * @return boolean
	 */
	public function importDBSettings( $platform ) {
		$imported  = false;
		$platforms = apply_filters( 'sq_importList', false );
		if ( $platform <> '' && isset( $platforms[ $platform ] ) ) {

			if ( $platform == 'wordpress-seo' ) {

				if ( $yoast_socials = get_option( 'wpseo_social' ) ) {
					$socials = SQ_Classes_Helpers_Tools::getOption( 'socials' );
					$codes   = SQ_Classes_Helpers_Tools::getOption( 'codes' );
					foreach ( $yoast_socials as $key => $yoast_social ) {
						if ( $yoast_social <> '' && isset( $socials[ $key ] ) ) {
							$socials[ $key ] = $yoast_social;
						}
					}
					if ( ! empty( $socials ) ) {
						if ( isset( $yoast_socials['plus-publisher'] ) && $yoast_socials['plus-publisher'] <> '' ) {
							$socials['plus_publisher'] = $yoast_socials['plus-publisher'];
						}
						if ( isset( $yoast_socials['pinterestverify'] ) && $yoast_socials['pinterestverify'] <> '' ) {
							$codes['pinterest_verify'] = $yoast_socials['pinterestverify'];
						}
						SQ_Classes_Helpers_Tools::saveOptions( 'socials', $socials );
						SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );
						$imported = true;
					}
				}

				if ( $yoast_titles = get_option( 'wpseo_titles' ) ) {
					$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
					if ( isset( $yoast_titles['company_logo'] ) && $yoast_titles['company_logo'] <> '' ) {
						$jsonld['Organization']['logo'] = $yoast_titles['company_logo'];
					}
					if ( isset( $yoast_titles['person_logo'] ) && $yoast_titles['person_logo'] <> '' ) {
						$jsonld['Person']['image']['url'] = $yoast_titles['person_logo'];
					}
					if ( isset( $yoast_titles['company_name'] ) && $yoast_titles['company_name'] <> '' ) {
						$jsonld['Organization']['name'] = $yoast_titles['company_name'];
					}
					if ( isset( $yoast_titles['company_or_person'] ) && $yoast_titles['company_or_person'] == 'person' ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld_type', 'Person' );
						if ( isset( $yoast_titles['company_or_person_user_id'] ) && (int) $yoast_titles['company_or_person_user_id'] > 0 ) {
							$user = get_userdata( (int) $yoast_titles['company_or_person_user_id'] );
							if ( $user && isset( $user->display_name ) ) {
								$jsonld['Person']['name'] = $user->display_name;
							}
						}
					}
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld', $jsonld );

				}

				if ( $yoast_codes = get_option( 'wpseo' ) ) {
					$codes = SQ_Classes_Helpers_Tools::getOption( 'codes' );
					if ( ! empty( $codes ) ) {
						if ( isset( $yoast_codes['msverify'] ) && $yoast_codes['msverify'] <> '' ) {
							$codes['bing_wt'] = $yoast_codes['msverify'];
						}
						if ( isset( $yoast_codes['googleverify'] ) && $yoast_codes['googleverify'] <> '' ) {
							$codes['google_wt'] = $yoast_codes['googleverify'];
						}
						SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );
						$imported = true;
					}
				}
			}

			if ( $platform == 'all-in-one-seo-pack' ) {
				if ( $options = get_option( 'aioseo_options' ) ) {
					$options = json_decode( $options, true );

					$socials = SQ_Classes_Helpers_Tools::getOption( 'socials' );
					$codes   = SQ_Classes_Helpers_Tools::getOption( 'codes' );

					if ( isset( $options['social']['profiles']['urls']['facebookPageUrl'] ) && $options['social']['profiles']['urls']['facebookPageUrl'] <> '' ) {
						$socials['facebook_site'] = $options['social']['profiles']['urls']['facebookPageUrl'];
					}
					if ( isset( $options['social']['profiles']['urls']['twitterUrl'] ) && $options['social']['profiles']['urls']['twitterUrl'] <> '' ) {
						$socials['twitter_site'] = $options['social']['profiles']['urls']['twitterUrl'];
					}
					if ( isset( $options['social']['profiles']['urls']['instagramUrl'] ) && $options['social']['profiles']['urls']['instagramUrl'] <> '' ) {
						$socials['instagram_url'] = $options['social']['profiles']['urls']['instagramUrl'];
					}
					if ( isset( $options['social']['profiles']['urls']['pinterestUrl'] ) && $options['social']['profiles']['urls']['pinterestUrl'] <> '' ) {
						$socials['pinterest_url'] = $options['social']['profiles']['urls']['pinterestUrl'];
					}
					if ( isset( $options['social']['profiles']['urls']['youtubeUrl'] ) && $options['social']['profiles']['urls']['youtubeUrl'] <> '' ) {
						$socials['youtube_url'] = $options['social']['profiles']['urls']['youtubeUrl'];
					}
					if ( isset( $options['social']['profiles']['urls']['linkedinUrl'] ) && $options['social']['profiles']['urls']['linkedinUrl'] <> '' ) {
						$socials['linkedin_url'] = $options['social']['profiles']['urls']['linkedinUrl'];
					}
					if ( isset( $options['social']['profiles']['urls']['myspace_url'] ) && $options['social']['profiles']['urls']['myspace_url'] <> '' ) {
						$socials['myspaceUrl'] = $options['social']['profiles']['urls']['myspace_url'];
					}

					if ( isset( $options['social']['facebook']['general']['defaultImagePosts'] ) && $options['social']['facebook']['general']['defaultImagePosts'] <> '' ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_og_image', $options['social']['facebook']['general']['defaultImagePosts'] );
					}
					if ( isset( $options['social']['twitter']['general']['defaultImagePosts'] ) && $options['social']['twitter']['general']['defaultImagePosts'] <> '' ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_og_image', $options['social']['twitter']['general']['defaultImagePosts'] );
					}

					$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );

					if ( isset( $options['searchAppearance']['global']['schema']['organizationName'] ) && $options['searchAppearance']['global']['schema']['organizationName'] <> '' ) {
						$jsonld['Organization']['name'] = $options['searchAppearance']['global']['schema']['organizationName'];
					}
					if ( isset( $options['searchAppearance']['global']['schema']['organizationLogo'] ) && $options['searchAppearance']['global']['schema']['organizationLogo'] <> '' ) {
						$jsonld['Organization']['logo'] = $options['searchAppearance']['global']['schema']['organizationLogo'];
					}
					if ( isset( $options['searchAppearance']['global']['schema']['phone'] ) && $options['searchAppearance']['global']['schema']['phone'] <> '' ) {
						$jsonld['Organization']['contactPoint']['telephone'] = $options['searchAppearance']['global']['schema']['phone'];
					}
					if ( isset( $options['searchAppearance']['global']['schema']['contactType'] ) && $options['searchAppearance']['global']['schema']['contactType'] <> '' ) {
						$jsonld['Organization']['contactPoint']['contactType'] = $options['searchAppearance']['global']['schema']['contactType'];
					}
					if ( isset( $options['searchAppearance']['global']['schema']['personName'] ) && $options['searchAppearance']['global']['schema']['personName'] <> '' ) {
						$jsonld['Person']['name'] = $options['searchAppearance']['global']['schema']['personName'];
					}
					if ( isset( $options['searchAppearance']['global']['schema']['personLogo'] ) && $options['searchAppearance']['global']['schema']['personLogo'] <> '' ) {
						$jsonld['Person']['image']['url'] = $options['searchAppearance']['global']['schema']['personLogo'];
					}

					if ( isset( $options['webmasterTools']['bing'] ) && $options['webmasterTools']['bing'] <> '' ) {
						$codes['bing_wt'] = $options['webmasterTools']['bing'];
					}
					if ( isset( $options['webmasterTools']['pinterest'] ) && $options['webmasterTools']['pinterest'] <> '' ) {
						$codes['pinterest_verify'] = $options['webmasterTools']['pinterest'];
					}
					if ( isset( $options['webmasterTools']['google'] ) && $options['webmasterTools']['google'] <> '' ) {
						$codes['google_analytics'] = $options['webmasterTools']['google'];
					}
					if ( isset( $options['webmasterTools']['yandex'] ) && $options['webmasterTools']['yandex'] <> '' ) {
						$codes['yandex_wt'] = $options['webmasterTools']['yandex'];
					}
					if ( isset( $options['webmasterTools']['baidu'] ) && $options['webmasterTools']['baidu'] <> '' ) {
						$codes['baidu_wt'] = $options['webmasterTools']['baidu'];
					}
					if ( isset( $options['webmasterTools']['norton'] ) && $options['webmasterTools']['norton'] <> '' ) {
						$codes['norton_verify'] = $options['webmasterTools']['norton'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'socials', $socials );
					SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld', $jsonld );

					$imported = true;
				}
			}

			if ( $platform == 'seo-by-rank-math' ) {

				if ( $options = get_option( 'rank-math-options-general' ) ) {
					$codes = SQ_Classes_Helpers_Tools::getOption( 'codes' );

					if ( isset( $options['attachment_redirect_urls'] ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_attachment_redirect', ( $options['attachment_redirect_urls'] == 'on' ) );
					}

					if ( isset( $options['nofollow_external_links'] ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_external_nofollow', ( $options['nofollow_external_links'] == 'on' ) );
					}

					if ( isset( $options['new_window_external_links'] ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_external_blank', ( $options['new_window_external_links'] == 'on' ) );
					}

					if ( isset( $options['breadcrumbs'] ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld_breadcrumbs', ( $options['breadcrumbs'] == 'on' ) );
					}

					if ( isset( $options['product_brand'] ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld_product_custom', ( $options['product_brand'] == 'on' ) );
					}

					if ( isset( $options['google_verify'] ) && $options['google_verify'] <> '' ) {
						$codes['google_wt'] = $options['google_verify'];
					}
					if ( isset( $options['bing_verify'] ) && $options['bing_verify'] <> '' ) {
						$codes['bing_wt'] = $options['bing_verify'];
					}
					if ( isset( $options['pinterest_verify'] ) && $options['pinterest_verify'] <> '' ) {
						$codes['pinterest_verify'] = $options['pinterest_verify'];
					}
					if ( isset( $options['yandex_verify'] ) && $options['yandex_verify'] <> '' ) {
						$codes['yandex_wt'] = $options['yandex_verify'];
					}
					if ( isset( $options['baidu_verify'] ) && $options['baidu_verify'] <> '' ) {
						$codes['baidu_wt'] = $options['baidu_verify'];
					}
					if ( isset( $options['norton_verify'] ) && $options['norton_verify'] <> '' ) {
						$codes['norton_verify'] = $options['norton_verify'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );

					$imported = true;
				}

				if ( $options = get_option( 'rank-math-options-titles' ) ) {
					$jsonld  = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
					$socials = SQ_Classes_Helpers_Tools::getOption( 'socials' );

					if ( isset( $options['price_range'] ) && $options['price_range'] <> '' ) {
						$jsonld['sq_jsonld_local']['priceRange'] = $options['price_range'];
					}
					if ( isset( $options['local_address']['streetAddress'] ) && $options['local_address']['streetAddress'] <> '' ) {
						$jsonld['Organization']['address']['streetAddress'] = $options['local_address']['streetAddress'];
					}
					if ( isset( $options['local_address']['addressLocality'] ) && $options['local_address']['addressLocality'] <> '' ) {
						$jsonld['Organization']['address']['addressLocality'] = $options['local_address']['addressLocality'];
					}
					if ( isset( $options['local_address']['addressRegion'] ) && $options['local_address']['addressRegion'] <> '' ) {
						$jsonld['Organization']['address']['addressRegion'] = $options['local_address']['addressRegion'];
					}
					if ( isset( $options['local_address']['addressCountry'] ) && $options['local_address']['addressCountry'] <> '' ) {
						$jsonld['Organization']['address']['addressCountry'] = $options['local_address']['addressCountry'];
					}
					if ( isset( $options['local_address']['postalCode'] ) && $options['local_address']['postalCode'] <> '' ) {
						$jsonld['Organization']['address']['postalCode'] = $options['local_address']['postalCode'];
					}
					if ( isset( $options['knowledgegraph_logo'] ) && $options['knowledgegraph_logo'] <> '' ) {
						$jsonld['Organization']['logo'] = $options['knowledgegraph_logo'];
					}
					if ( isset( $options['knowledgegraph_name'] ) && $options['knowledgegraph_name'] <> '' ) {
						$jsonld['Organization']['name'] = $options['knowledgegraph_name'];
					}


					if ( isset( $options['social_url_facebook'] ) && $options['social_url_facebook'] <> '' ) {
						$socials['facebook_site'] = $options['social_url_facebook'];
					}
					if ( isset( $options['twitter_author_names'] ) && $options['twitter_author_names'] <> '' ) {
						$socials['twitter_site'] = $options['twitter_author_names'];
					}
					if ( isset( $options['facebook_admin_id'] ) && $options['facebook_admin_id'] <> '' ) {
						$socials['fb_admins'] = array( $options['facebook_admin_id'] );
					}
					if ( isset( $options['facebook_app_id'] ) && $options['facebook_app_id'] <> '' ) {
						$socials['fbadminapp'] = $options['facebook_app_id'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld', $jsonld );
					SQ_Classes_Helpers_Tools::saveOptions( 'socials', $socials );

				}


			}

			if ( $platform == 'autodescription' ) {
				if ( $options = get_option( 'autodescription-site-settings' ) ) {
					$jsonld  = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
					$socials = SQ_Classes_Helpers_Tools::getOption( 'socials' );
					$codes   = SQ_Classes_Helpers_Tools::getOption( 'codes' );

					if ( isset( $options['attachment_redirect_urls'] ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_attachment_redirect', ( $options['attachment_redirect_urls'] == 'on' ) );
					}

					if ( isset( $options['facebook_appid'] ) && $options['facebook_appid'] <> '' ) {
						$socials['fbadminapp'] = $options['facebook_appid'];
					}
					if ( isset( $options['facebook_publisher'] ) && $options['facebook_publisher'] <> '' ) {
						$socials['facebook_site'] = $options['facebook_publisher'];
					}
					if ( isset( $options['twitter_site'] ) && $options['twitter_site'] <> '' ) {
						$socials['twitter_site'] = $options['twitter_site'];
					}

					if ( isset( $options['knowledge_name'] ) && $options['knowledge_name'] <> '' ) {
						$jsonld['Organization']['name'] = $options['knowledge_name'];
					}
					if ( isset( $options['knowledge_logo_url'] ) && $options['knowledge_logo_url'] <> '' ) {
						$jsonld['Organization']['logo'] = $options['knowledge_logo_url'];
					}

					if ( isset( $options['google_verification'] ) && $options['google_verification'] <> '' ) {
						$codes['google_wt'] = $options['google_verification'];
					}
					if ( isset( $options['bing_verification'] ) && $options['bing_verification'] <> '' ) {
						$codes['bing_wt'] = $options['bing_verification'];
					}
					if ( isset( $options['pint_verification'] ) && $options['pint_verification'] <> '' ) {
						$codes['pinterest_verify'] = $options['pint_verification'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );
					SQ_Classes_Helpers_Tools::saveOptions( 'socials', $socials );
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld', $jsonld );

					$imported = true;
				}
			}

			if ( $platform == 'premium-seo-pack' ) {
				if ( $options = json_decode( get_option( '_psp_options' ), true ) ) {
					$socials = $options['socials'];
					$codes   = $options['codes'];
					$jsonld  = $options['psp_jsonld'];

					SQ_Classes_Helpers_Tools::saveOptions( 'socials', $socials );
					SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld', $jsonld );

					$imported = true;
				}
			}

			if ( $platform == 'wp-seopress' ) {
				if ( $options = get_option( 'seopress_social_option_name' ) ) {

					$jsonld  = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
					$socials = SQ_Classes_Helpers_Tools::getOption( 'socials' );


					if ( isset( $options['seopress_social_knowledge_name'] ) && $options['seopress_social_knowledge_name'] <> '' ) {
						$jsonld['Organization']['name'] = $options['seopress_social_knowledge_name'];
					}
					if ( isset( $options['seopress_social_knowledge_img'] ) && $options['seopress_social_knowledge_img'] <> '' ) {
						$jsonld['Organization']['logo'] = $options['seopress_social_knowledge_img'];
					}
					if ( isset( $options['seopress_social_knowledge_phone'] ) && $options['seopress_social_knowledge_phone'] <> '' ) {
						$jsonld['Organization']['contactPoint']['telephone'] = $options['seopress_social_knowledge_phone'];
					}
					if ( isset( $options['seopress_social_knowledge_contact_type'] ) && $options['seopress_social_knowledge_contact_type'] <> '' ) {
						$jsonld['Organization']['contactPoint']['contactType'] = $options['seopress_social_knowledge_contact_type'];
					}

					if ( isset( $options['seopress_social_accounts_facebook'] ) && $options['seopress_social_accounts_facebook'] <> '' ) {
						$socials['facebook_site'] = $options['seopress_social_accounts_facebook'];
					}
					if ( isset( $options['seopress_social_accounts_twitter'] ) && $options['seopress_social_accounts_twitter'] <> '' ) {
						$socials['twitter_site'] = $options['seopress_social_accounts_twitter'];
					}
					if ( isset( $options['seopress_social_accounts_pinterest'] ) && $options['seopress_social_accounts_pinterest'] <> '' ) {
						$socials['pinterest_url'] = $options['seopress_social_accounts_pinterest'];
					}
					if ( isset( $options['seopress_social_accounts_instagram'] ) && $options['seopress_social_accounts_instagram'] <> '' ) {
						$socials['instagram_url'] = $options['seopress_social_accounts_instagram'];
					}
					if ( isset( $options['seopress_social_accounts_youtube'] ) && $options['seopress_social_accounts_youtube'] <> '' ) {
						$socials['youtube_url'] = $options['seopress_social_accounts_youtube'];
					}
					if ( isset( $options['seopress_social_accounts_linkedin'] ) && $options['seopress_social_accounts_linkedin'] <> '' ) {
						$socials['linkedin_url'] = $options['seopress_social_accounts_linkedin'];
					}


					if ( isset( $options['seopress_social_facebook_img'] ) && $options['seopress_social_facebook_img'] <> '' ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_og_image', $options['seopress_social_facebook_img'] );
					}

					if ( isset( $options['seopress_social_twitter_card_img'] ) && $options['seopress_social_twitter_card_img'] <> '' ) {
						SQ_Classes_Helpers_Tools::saveOptions( 'sq_tc_image', $options['seopress_social_twitter_card_img'] );
					}

					if ( isset( $options['seopress_social_facebook_admin_id'] ) && $options['seopress_social_facebook_admin_id'] <> '' ) {
						$socials['fb_admins'] = array( $options['seopress_social_facebook_admin_id'] );
					}
					if ( isset( $options['seopress_social_facebook_app_id'] ) && $options['seopress_social_facebook_app_id'] <> '' ) {
						$socials['fbadminapp'] = $options['seopress_social_facebook_app_id'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'socials', $socials );
					SQ_Classes_Helpers_Tools::saveOptions( 'sq_jsonld', $jsonld );

					$imported = true;
				}

				if ( $options = get_option( 'seopress_google_analytics_option_name' ) ) {
					$codes = SQ_Classes_Helpers_Tools::getOption( 'codes' );

					if ( isset( $options['seopress_google_analytics_ua'] ) && $options['seopress_google_analytics_ua'] <> '' ) {
						$codes['google_analytics'] = $options['seopress_google_analytics_ua'];
					}
					if ( isset( $options['seopress_google_analytics_ga4'] ) && $options['seopress_google_analytics_ga4'] <> '' ) {
						$codes['google_analytics'] = $options['seopress_google_analytics_ga4'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'codes', $codes );

				}
			}

		}

		return $imported;
	}

	public function importDBSeo( $platform ) {
		global $wpdb;

		$platforms = apply_filters( 'sq_importList', false );
		if ( $platform <> '' && isset( $platforms[ $platform ] ) ) {
			$meta_keys = $platforms[ $platform ];
			$metas     = array();

			if ( ! empty( $meta_keys ) ) {
				$placeholders = array_fill( 0, count( $meta_keys ), '%s' );

				$meta_keys = array_flip( $meta_keys );

				$query = "SELECT * FROM `$wpdb->postmeta` WHERE meta_key IN (" . join( ",", $placeholders ) . ");";
				if ( $rows = $wpdb->get_results( $wpdb->prepare( $query, array_keys( $meta_keys ) ), OBJECT ) ) {
					foreach ( $rows as $row ) {

						if ( isset( $meta_keys[ $row->meta_key ] ) && $row->meta_value <> '' ) {
							if ( $post = get_post( $row->post_id ) ) {

								//set the hash for each post type
								if ( in_array( $post->post_type, array(
									'post',
									'page',
									'product',
									'cartflows_step'
								) ) ) {
									$hash = md5( $post->ID );
								} else {
									$hash = md5( $post->post_type . $post->ID );
								}

								$metas[ $hash ]['post_id']   = $post->ID;
								$metas[ $hash ]['post_type'] = $post->post_type;
								$metas[ $hash ]['url']       = get_permalink( $post->ID );

								$value = $row->meta_value;

								//encode the emoji to prevent unserialize errors
								$value = wp_encode_emoji( $value );

								if ( strpos( $value, '%%' ) !== false ) {
									$value = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', $value );
								}

								if ( function_exists( 'mb_detect_encoding' ) && function_exists( 'iconv' ) ) {
									if ( $encoding = mb_detect_encoding( $value ) ) {
										if ( $encoding <> 'UTF-8' ) {

											//support for international languages
											if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
												if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
													$value = iconv( $encoding, 'UTF-8', $value );
												}
											}


										}
									}
								}

								if ( $row->meta_key == 'rank_math_robots' ) {
									$value                      = unserialize( $value );
									$metas[ $hash ]['noindex']  = in_array( 'noindex', (array) $value );
									$metas[ $hash ]['nofollow'] = in_array( 'nofollow', (array) $value );
								} else {
									$metas[ $hash ][ $meta_keys[ $row->meta_key ] ] = stripslashes( $value );
								}
							}
						}
					}
				}


				if ( $platform == 'seo-by-rank-math' ) {
					$query = "SELECT * FROM `$wpdb->termmeta` WHERE meta_key IN (" . join( ",", $placeholders ) . ");";
					if ( $rows = $wpdb->get_results( $wpdb->prepare( $query, array_keys( $meta_keys ) ), OBJECT ) ) {
						foreach ( $rows as $row ) {

							if ( isset( $meta_keys[ $row->meta_key ] ) && $row->meta_value <> '' ) {
								if ( $term = get_term( $row->term_id ) ) {
									//set the hash for each post type
									$hash                       = md5( $term->taxonomy . $term->term_id );
									$metas[ $hash ]['term_id']  = $term->term_id;
									$metas[ $hash ]['taxonomy'] = $term->taxonomy;
									$metas[ $hash ]['url']      = get_term_link( $term->term_id, $term->taxonomy );

									$value = $row->meta_value;

									//encode the emoji to prevent unserialize errors
									$value = wp_encode_emoji( $value );

									if ( strpos( $value, '%%' ) !== false ) {
										$value = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', $value );
									}

									if ( function_exists( 'mb_detect_encoding' ) && function_exists( 'iconv' ) ) {
										if ( $encoding = mb_detect_encoding( $value ) ) {
											if ( $encoding <> 'UTF-8' ) {

												//support for international languages
												if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
													if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
														$value = iconv( $encoding, 'UTF-8', $value );
													}
												}

											}
										}
									}

									if ( $row->meta_key == 'rank_math_robots' ) {
										$value                      = unserialize( $value );
										$metas[ $hash ]['noindex']  = in_array( 'noindex', (array) $value );
										$metas[ $hash ]['nofollow'] = in_array( 'nofollow', (array) $value );
									} else {
										$metas[ $hash ][ $meta_keys[ $row->meta_key ] ] = stripslashes( $value );
									}
								}
							}

						}

					}
				}
			}

			if ( $platform == 'wordpress-seo' ) {
				$meta_keys    = array(
					'title'       => 'wpseo_title',
					'description' => 'wpseo_metadesc',
					'noindex'     => 'wpseo_noindex_author',
				);
				$placeholders = array_fill( 0, count( $meta_keys ), '%s' );

				// get the users data
				$query = "SELECT * FROM `$wpdb->usermeta` WHERE meta_key IN (" . join( ",", $placeholders ) . ");";

				$meta_keys = array_flip( $meta_keys );
				if ( $rows = $wpdb->get_results( $wpdb->prepare( $query, array_keys( $meta_keys ) ), OBJECT ) ) {
					foreach ( $rows as $row ) {
						if ( isset( $meta_keys[ $row->meta_key ] ) && $row->meta_value <> '' ) {
							//set the hash for each profile
							$hash                        = md5( 'profile' . $row->user_id );
							$metas[ $hash ]['post_id']   = (int) $row->user_id;
							$metas[ $hash ]['post_type'] = 'profile';
							if ( function_exists( 'bp_core_get_user_domain' ) ) {
								$metas[ $hash ]['url'] = bp_core_get_user_domain( $row->user_id );
							} else {
								$metas[ $hash ]['url'] = get_author_posts_url( $row->user_id );
							}

							$value = $row->meta_value;

							//encode the emoji to prevent unserialize errors
							$value = wp_encode_emoji( $value );

							if ( strpos( $value, '%%' ) !== false ) {
								$value = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', $value );
							}

							if ( function_exists( 'mb_detect_encoding' ) && function_exists( 'iconv' ) ) {
								if ( $encoding = mb_detect_encoding( $value ) ) {
									if ( $encoding <> 'UTF-8' ) {

										//support for international languages
										if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
											if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
												$value = iconv( $encoding, 'UTF-8', $value );
											}
										}
									}
								}
							}

							if ( $meta_keys[ $row->meta_key ] == 'noindex' ) {
								$metas[ $hash ][ $meta_keys[ $row->meta_key ] ] = ( $value == 'on' );
							} else {
								$metas[ $hash ][ $meta_keys[ $row->meta_key ] ] = stripslashes( $value );
							}

						}
					}

				}

				//get taxonomies
				if ( $taxonomies = get_option( 'wpseo_taxonomy_meta' ) ) {
					if ( ! empty( $taxonomies ) ) {
						foreach ( $taxonomies as $taxonomie => $terms ) {
							if ( ! empty( $terms ) ) {
								if ( $taxonomie <> 'category' ) {
									$taxonomie = 'tax-' . $taxonomie;
								}
								foreach ( $terms as $term_id => $taxmetas ) {
									if ( ! empty( $taxmetas ) ) {
										if ( ! is_wp_error( get_term_link( $term_id ) ) ) {
											$metas[ md5( $taxonomie . $term_id ) ]['url']       = get_term_link( $term_id );
											$metas[ md5( $taxonomie . $term_id ) ]['term_id']   = $term_id;
											$metas[ md5( $taxonomie . $term_id ) ]['taxonomie'] = $taxonomie;
											foreach ( $taxmetas as $meta_key => $meta_value ) {
												if ( $meta_key == 'wpseo_desc' ) {
													$meta_key = '_yoast_wpseo_metadesc';
												} else {
													$meta_key = '_yoast_' . $meta_key;
												}

												if ( isset( $meta_keys[ $meta_key ] ) ) {
													$metas[ md5( $taxonomie . $term_id ) ][ $meta_keys[ $meta_key ] ] = stripslashes( $meta_value );
												}
											}
										}
									}
								}
							}
						}
					}
				}

				//get all patterns from Yoast
				if ( $yoast_patterns = get_option( 'wpseo_titles' ) ) {
					if ( ! empty( $yoast_patterns ) ) {
						$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );

						foreach ( $patterns as $path => &$values ) {
							switch ( $path ) {
								case 'profile':
									$path = 'author';
									break;
								case 'category':
									$path = 'tax-category';
									break;
								case 'tag':
									$path = 'tax-post_tag';
									break;
							}

							if ( isset( $yoast_patterns["title-pt$path"] ) && $yoast_patterns["title-pt$path"] <> '' ) {
								$values['title'] = $yoast_patterns["title-pt$path"];
							}
							if ( isset( $yoast_patterns["metadesc-pt$path"] ) && $yoast_patterns["metadesc-pt$path"] <> '' ) {
								$values['description'] = $yoast_patterns["metadesc-pt$path"];
							}
							if ( isset( $yoast_patterns["noindex-pt$path"] ) && $yoast_patterns["noindex-pt$path"] <> '' ) {
								$values['noindex'] = $yoast_patterns["noindex-pt$path"];
							}
							if ( isset( $yoast_patterns['separator'] ) && $yoast_patterns['separator'] <> '' ) {
								$values['sep'] = $yoast_patterns['separator'];
							}
							if ( isset( $yoast_patterns["title-$path-wpseo"] ) && $yoast_patterns["title-$path-wpseo"] <> '' ) {
								$values['title'] = $yoast_patterns["title-$path-wpseo"];
							}
							if ( isset( $yoast_patterns["metadesc-$path-wpseo"] ) && $yoast_patterns["metadesc-$path-wpseo"] <> '' ) {
								$values['description'] = $yoast_patterns["metadesc-$path-wpseo"];
							}
							if ( isset( $yoast_patterns["noindex-$path-wpseo"] ) ) {
								$values['noindex'] = (int) $yoast_patterns["noindex-$path-wpseo"];
							}
							if ( isset( $yoast_patterns["disable-$path-wpseo"] ) ) {
								$values['disable'] = (int) $yoast_patterns["disable-$path-wpseo"];
							}

							if ( isset( $yoast_patterns["title-$path"] ) && $yoast_patterns["title-$path"] <> '' ) {
								$values['title'] = $yoast_patterns["title-$path"];
							}
							if ( isset( $yoast_patterns["metadesc-$path"] ) && $yoast_patterns["metadesc-$path"] <> '' ) {
								$values['description'] = $yoast_patterns["metadesc-$path"];
							}
							if ( isset( $yoast_patterns["noindex-$path"] ) ) {
								$values['noindex'] = (int) $yoast_patterns["noindex-$path"];
							}
							if ( isset( $yoast_patterns["disable-$path"] ) ) {
								$values['disable'] = (int) $yoast_patterns["disable-$path"];
							}

							foreach ( $values as &$value ) {

								if ( is_string( $value ) && strpos( $value, '%%' ) !== false ) {
									//encode the emoji to prevent unserialize errors
									$value = wp_encode_emoji( $value );

									$value = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', $value );
								}
							}

							//Replace all patterns for imported metas
							if ( ! empty( $metas ) ) {
								foreach ( $metas as &$meta ) {
									if ( is_array( $meta ) ) {
										foreach ( $meta as &$field ) {
											$field = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', $field );
										}
									}
								}
							}
						}

						SQ_Classes_Helpers_Tools::saveOptions( 'patterns', $patterns );
					}
				}


				// get the woocommerce seo data
				$posts = $wpdb->get_results( 'SELECT `post_id`,`meta_value` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = "wpseo_global_identifier_values";', OBJECT );

				if ( ! empty( $posts ) ) {
					$wc_fields = array(
						'mpn'  => 'mpn',
						'gtin' => 'gtin8',
						'ean'  => 'gtin13',
						'upc'  => 'gtin12',
						'isbn' => 'isbn'
					);

					foreach ( $posts as $post ) {
						if ( $post->meta_value <> '' ) {
							$sq_woocommerce = array();

							$data = unserialize( $post->meta_value );
							foreach ( $wc_fields as $field => $value ) {
								if ( isset( $data[ $value ] ) && $data[ $value ] <> '' ) {
									$sq_woocommerce[ $field ] = $data[ $value ];
								}
							}

							if ( ! empty( $sq_woocommerce ) ) {
								update_post_meta( $post->post_id, '_sq_woocommerce', $sq_woocommerce );
							}

						}
					}
				}
			}

			if ( $platform == 'all-in-one-seo-pack' ) {
				if ( $options = get_option( 'aioseo_options' ) ) {
					$options = json_decode( $options, true );
					if ( isset( $options['searchAppearance']['dynamic'] ) ) {
						$options = $options['searchAppearance']['dynamic'];
					}

					$patterns    = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
					$findreplace = array(
						'page_title'           => 'title',
						'post_title'           => 'title',
						'post_excerpt'         => 'excerpt',
						'post_content'         => 'excerpt',
						'page_excerpt'         => 'excerpt',
						'page_content'         => 'excerpt',
						'post_date'            => 'date',
						'page_date'            => 'date',
						'archive_title'        => 'title',
						'site_title'           => 'sitename',
						'tagline'              => 'sitedesc',
						'blog_description'     => 'sitedesc',
						'category_title'       => 'category',
						'author_name'          => 'name',
						'author_first_name'    => 'name',
						'author_last_name'     => 'name',
						'categories'           => 'category',
						'tax_name'             => 'term_title',
						'taxonomy_title'       => 'term_title',
						'page_author_nicename' => 'name',
						'description'          => 'excerpt',
						'request_words'        => 'searchphrase',
						'search'               => 'searchphrase',
						'current_date'         => 'currentdate',
						'current_day'          => 'currentday',
						'current_month'        => 'currentmonth',
						'current_year'         => 'currentyear',
						'separator_sa'         => 'sep',
						'permalink'            => 'guid',
					);

					//Replace all patterns for imported metas
					if ( ! empty( $metas ) ) {
						foreach ( $metas as &$meta ) {
							if ( is_array( $meta ) ) {
								foreach ( $meta as &$field ) {
									$field = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $field ) );
								}
							}
						}
					}

					//replace the patterns automation
					if ( isset( $options['postTypes']['post']['title'] ) && $options['postTypes']['post']['title'] <> '' ) {
						$patterns['post']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['post']['title'] ) );
					}
					if ( isset( $options['postTypes']['post']['metaDescription'] ) && $options['postTypes']['post']['metaDescription'] <> '' ) {
						$patterns['post']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['post']['metaDescription'] ) );
					}


					if ( isset( $options['postTypes']['page']['title'] ) && $options['postTypes']['page']['title'] <> '' ) {
						$patterns['page']['title'] = preg_replace( '/#([a-z_]+)\s/', '{{$1}} ', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['page']['title'] ) );
					}
					if ( isset( $options['postTypes']['page']['metaDescription'] ) && $options['postTypes']['page']['metaDescription'] <> '' ) {
						$patterns['page']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['page']['metaDescription'] ) );
					}

					if ( isset( $options['postTypes']['attachment']['title'] ) && $options['postTypes']['attachment']['title'] <> '' ) {
						$patterns['attachment']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['attachment']['title'] ) );
					}
					if ( isset( $options['postTypes']['attachment']['metaDescription'] ) && $options['postTypes']['attachment']['metaDescription'] <> '' ) {
						$patterns['attachment']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['attachment']['metaDescription'] ) );
					}

					if ( isset( $options['postTypes']['product']['title'] ) && $options['postTypes']['product']['title'] <> '' ) {
						$patterns['product']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['product']['title'] ) );
					}
					if ( isset( $options['postTypes']['product']['metaDescription'] ) && $options['postTypes']['product']['metaDescription'] <> '' ) {
						$patterns['product']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['product']['metaDescription'] ) );
					}

					if ( isset( $options['postTypes']['product']['title'] ) && $options['postTypes']['product']['title'] <> '' ) {
						$patterns['product']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['product']['title'] ) );
					}
					if ( isset( $options['postTypes']['product']['metaDescription'] ) && $options['postTypes']['product']['metaDescription'] <> '' ) {
						$patterns['product']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['postTypes']['product']['metaDescription'] ) );
					}

					if ( isset( $options['taxonomies']['category']['title'] ) && $options['taxonomies']['category']['title'] <> '' ) {
						$patterns['category']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['category']['title'] ) );
					}
					if ( isset( $options['taxonomies']['category']['metaDescription'] ) && $options['taxonomies']['category']['metaDescription'] <> '' ) {
						$patterns['category']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['category']['metaDescription'] ) );
					}

					if ( isset( $options['taxonomies']['post_tag']['title'] ) && $options['taxonomies']['post_tag']['title'] <> '' ) {
						$patterns['tag']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['post_tag']['title'] ) );
					}
					if ( isset( $options['taxonomies']['post_tag']['metaDescription'] ) && $options['taxonomies']['post_tag']['metaDescription'] <> '' ) {
						$patterns['tag']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['post_tag']['metaDescription'] ) );
					}

					if ( isset( $options['taxonomies']['product_cat']['title'] ) && $options['taxonomies']['product_cat']['title'] <> '' ) {
						$patterns['tax-product_cat']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['product_cat']['title'] ) );
					}
					if ( isset( $options['taxonomies']['product_cat']['metaDescription'] ) && $options['taxonomies']['product_cat']['metaDescription'] <> '' ) {
						$patterns['tax-product_cat']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['product_cat']['metaDescription'] ) );
					}

					if ( isset( $options['taxonomies']['product_tag']['title'] ) && $options['taxonomies']['product_tag']['title'] <> '' ) {
						$patterns['tax-product_tag']['title'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['product_tag']['title'] ) );
					}
					if ( isset( $options['taxonomies']['product_tag']['metaDescription'] ) && $options['taxonomies']['product_tag']['metaDescription'] <> '' ) {
						$patterns['tax-product_tag']['description'] = preg_replace( '/#([a-z_]+)/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['taxonomies']['product_tag']['metaDescription'] ) );
					}


					if ( isset( $options['postTypes']['post']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['post']['noindex'] = (int) $options['postTypes']['post']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['postTypes']['post']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['post']['nofollow'] = (int) $options['postTypes']['post']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['postTypes']['page']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['page']['noindex'] = (int) $options['postTypes']['page']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['postTypes']['page']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['page']['nofollow'] = (int) $options['postTypes']['page']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['postTypes']['attachment']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['attachment']['noindex'] = (int) $options['postTypes']['attachment']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['postTypes']['attachment']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['attachment']['nofollow'] = (int) $options['postTypes']['attachment']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['postTypes']['product']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['product']['noindex'] = (int) $options['postTypes']['product']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['postTypes']['product']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['product']['nofollow'] = (int) $options['postTypes']['product']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['taxonomies']['category']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['category']['noindex'] = (int) $options['taxonomies']['category']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['taxonomies']['category']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['category']['nofollow'] = (int) $options['taxonomies']['category']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['taxonomies']['post_tag']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['tag']['noindex'] = (int) $options['taxonomies']['post_tag']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['taxonomies']['post_tag']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['tag']['nofollow'] = (int) $options['taxonomies']['post_tag']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['taxonomies']['product_cat']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['tax-product_cat']['noindex'] = (int) $options['taxonomies']['product_cat']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['taxonomies']['product_cat']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['tax-product_cat']['nofollow'] = (int) $options['taxonomies']['product_cat']['advanced']['robotsMeta']['nofollow'];
					}
					if ( isset( $options['taxonomies']['product_tag']['advanced']['robotsMeta']['noindex'] ) ) {
						$patterns['tax-product_tag']['noindex'] = (int) $options['taxonomies']['product_tag']['advanced']['robotsMeta']['noindex'];
					}
					if ( isset( $options['taxonomies']['product_tag']['advanced']['robotsMeta']['nofollow'] ) ) {
						$patterns['tax-product_tag']['nofollow'] = (int) $options['taxonomies']['product_tag']['advanced']['robotsMeta']['nofollow'];
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'patterns', $patterns );
				}
			}

			if ( $platform == 'wp-seopress' ) {
				if ( $options = get_option( 'seopress_titles_option_name' ) ) {

					$patterns    = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
					$findreplace = array(
						'sitetitle'             => 'sitename',
						'tagline'               => 'sitedesc',
						'post_title'            => 'title',
						'post_excerpt'          => 'excerpt',
						'post_date'             => 'date',
						'post_modified_date'    => 'modified',
						'post_author'           => 'name',
						'post_category'         => 'category',
						'post_tag'              => 'tag',
						'_category_title'       => 'title',
						'_category_description' => 'category_description',
						'tag_title'             => 'title',
						'tag_description'       => 'tag_description',
						'term_title'            => 'term_title',
						'term_description'      => 'term_description',
						'search_keywords'       => 'searchphrase',
						'current_pagination'    => 'page',
						'cpt_plural'            => 'title',
						'archive_title'         => 'title',
						'archive_date'          => 'date',
						'archive_date_day'      => 'date',
						'archive_date_month'    => 'date',
						'archive_date_year'     => 'date',
						'author_bio'            => 'excerpt',
						'wc_single_cat'         => 'primary_category',
						'wc_single_tag'         => 'tag',
						'wc_single_short_desc'  => 'excerpt',
						'wc_single_price'       => 'product_price',
					);

					//Replace all patterns for imported metas
					if ( ! empty( $metas ) ) {
						foreach ( $metas as &$meta ) {
							if ( is_array( $meta ) ) {
								foreach ( $meta as $name => &$field ) {
									if ( $name == 'title' || $name == 'description' ) {
										$field = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $field ) );
									}
								}
							}
						}
					}

					if ( isset( $options['seopress_titles_home_site_title'] ) && $options['seopress_titles_home_site_title'] <> '' ) {
						$patterns['home']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_home_site_title'] ) );
					}
					if ( isset( $options['seopress_titles_home_site_desc'] ) && $options['seopress_titles_home_site_desc'] <> '' ) {
						$patterns['home']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_home_site_desc'] ) );
					}

					if ( isset( $options['seopress_titles_single_titles']['post']['title'] ) && $options['seopress_titles_single_titles']['post']['title'] <> '' ) {
						$patterns['post']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_single_titles']['post']['title'] ) );
					}
					if ( isset( $options['seopress_titles_single_titles']['post']['description'] ) && $options['seopress_titles_single_titles']['post']['description'] <> '' ) {
						$patterns['post']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_single_titles']['post']['description'] ) );
					}

					if ( isset( $options['seopress_titles_single_titles']['page']['title'] ) && $options['seopress_titles_single_titles']['page']['title'] <> '' ) {
						$patterns['page']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_single_titles']['page']['title'] ) );
					}
					if ( isset( $options['seopress_titles_single_titles']['page']['description'] ) && $options['seopress_titles_single_titles']['page']['description'] <> '' ) {
						$patterns['page']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_single_titles']['page']['description'] ) );
					}

					if ( isset( $options['seopress_titles_single_titles']['product']['title'] ) && $options['seopress_titles_single_titles']['product']['title'] <> '' ) {
						$patterns['product']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_single_titles']['product']['title'] ) );
					}
					if ( isset( $options['seopress_titles_single_titles']['product']['description'] ) && $options['seopress_titles_single_titles']['product']['description'] <> '' ) {
						$patterns['product']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_single_titles']['product']['description'] ) );
					}

					if ( isset( $options['seopress_titles_tax_titles']['category']['title'] ) && $options['seopress_titles_tax_titles']['category']['title'] <> '' ) {
						$patterns['category']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['category']['title'] ) );
					}
					if ( isset( $options['seopress_titles_tax_titles']['category']['description'] ) && $options['seopress_titles_tax_titles']['category']['description'] <> '' ) {
						$patterns['category']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['category']['description'] ) );
					}

					if ( isset( $options['seopress_titles_tax_titles']['post_tag']['title'] ) && $options['seopress_titles_tax_titles']['post_tag']['title'] <> '' ) {
						$patterns['tax-post_tag']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['post_tag']['title'] ) );
					}
					if ( isset( $options['seopress_titles_tax_titles']['post_tag']['description'] ) && $options['seopress_titles_tax_titles']['post_tag']['description'] <> '' ) {
						$patterns['tax-post_tag']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['post_tag']['description'] ) );
					}

					if ( isset( $options['seopress_titles_tax_titles']['product_cat']['title'] ) && $options['seopress_titles_tax_titles']['product_cat']['title'] <> '' ) {
						$patterns['tax-product_cat']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['product_cat']['title'] ) );
					}
					if ( isset( $options['seopress_titles_tax_titles']['product_cat']['description'] ) && $options['seopress_titles_tax_titles']['product_cat']['description'] <> '' ) {
						$patterns['tax-product_cat']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['product_cat']['description'] ) );
					}

					if ( isset( $options['seopress_titles_tax_titles']['product_tag']['title'] ) && $options['seopress_titles_tax_titles']['product_tag']['title'] <> '' ) {
						$patterns['tax-product_tag']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['product_tag']['title'] ) );
					}
					if ( isset( $options['seopress_titles_tax_titles']['product_tag']['description'] ) && $options['seopress_titles_tax_titles']['product_tag']['description'] <> '' ) {
						$patterns['tax-product_tag']['description'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_tax_titles']['product_tag']['description'] ) );
					}

					if ( isset( $options['seopress_titles_archive_titles']['post']['title'] ) && $options['seopress_titles_archive_titles']['post']['title'] <> '' ) {
						$patterns['archive']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_archive_titles']['post']['title'] ) );
					}

					if ( isset( $options['seopress_titles_archives_author_title'] ) && $options['seopress_titles_archives_author_title'] <> '' ) {
						$patterns['profile']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_archives_author_title'] ) );
					}

					if ( isset( $options['seopress_titles_archives_search_title'] ) && $options['seopress_titles_archives_search_title'] <> '' ) {
						$patterns['search']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_archives_search_title'] ) );
					}

					if ( isset( $options['seopress_titles_archives_404_title'] ) && $options['seopress_titles_archives_404_title'] <> '' ) {
						$patterns['404']['title'] = preg_replace( '/%%([^\%]+)%%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['seopress_titles_archives_404_title'] ) );
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'patterns', $patterns );
				}
			}

			if ( $platform == 'seo-by-rank-math' ) {
				if ( $options = get_option( 'rank-math-options-titles' ) ) {

					$patterns    = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
					$findreplace = array(
						'search_query'           => 'searchphrase',
						'term'                   => 'term_title',
						'category'               => 'primary_category',
						'categories'             => 'category',
						'term_title_description' => 'term_description',
					);

					//Replace all patterns for imported metas
					if ( ! empty( $metas ) ) {
						foreach ( $metas as &$meta ) {
							if ( is_array( $meta ) ) {
								foreach ( $meta as $name => &$field ) {
									if ( $name == 'title' || $name == 'description' ) {
										$field = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $field ) );
									}
								}
							}
						}
					}

					if ( isset( $options['homepage_title'] ) && $options['homepage_title'] <> '' ) {
						$patterns['home']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['homepage_title'] ) );

					}
					if ( isset( $options['homepage_description'] ) && $options['homepage_description'] <> '' ) {
						$patterns['home']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['homepage_description'] ) );
					}

					if ( isset( $options['pt_post_title'] ) && $options['pt_post_title'] <> '' ) {
						$patterns['post']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_post_title'] ) );
					}
					if ( isset( $options['pt_post_description'] ) && $options['pt_post_description'] <> '' ) {
						$patterns['post']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_post_description'] ) );
					}

					if ( isset( $options['pt_page_title'] ) && $options['pt_page_title'] <> '' ) {
						$patterns['page']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_page_title'] ) );
					}
					if ( isset( $options['pt_page_description'] ) && $options['pt_page_description'] <> '' ) {
						$patterns['page']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_page_description'] ) );
					}

					if ( isset( $options['pt_attachment_title'] ) && $options['pt_attachment_title'] <> '' ) {
						$patterns['attachment']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_attachment_title'] ) );
					}
					if ( isset( $options['pt_attachment_description'] ) && $options['pt_attachment_description'] <> '' ) {
						$patterns['attachment']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_attachment_description'] ) );
					}

					if ( isset( $options['pt_product_title'] ) && $options['pt_product_title'] <> '' ) {
						$patterns['product']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_product_title'] ) );
					}
					if ( isset( $options['pt_product_description'] ) && $options['pt_product_description'] <> '' ) {
						$patterns['product']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['pt_product_description'] ) );
					}

					if ( isset( $options['tax_category_title'] ) && $options['tax_category_title'] <> '' ) {
						$patterns['category']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_category_title'] ) );
					}
					if ( isset( $options['tax_category_description'] ) && $options['tax_category_description'] <> '' ) {
						$patterns['category']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_category_description'] ) );
					}

					if ( isset( $options['tax_post_tag_title'] ) && $options['tax_post_tag_title'] <> '' ) {
						$patterns['tag']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_post_tag_title'] ) );
					}
					if ( isset( $options['tax_post_tag_description'] ) && $options['tax_post_tag_description'] <> '' ) {
						$patterns['tag']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_post_tag_description'] ) );
					}

					if ( isset( $options['tax_post_format_title'] ) && $options['tax_post_format_title'] <> '' ) {
						$patterns['tax-post_format']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_post_format_title'] ) );
					}

					if ( isset( $options['tax_product_cat_title'] ) && $options['tax_product_cat_title'] <> '' ) {
						$patterns['tax-product_cat']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_product_cat_title'] ) );
					}
					if ( isset( $options['tax_product_cat_description'] ) && $options['tax_product_cat_description'] <> '' ) {
						$patterns['tax-product_cat']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_product_cat_description'] ) );
					}

					if ( isset( $options['tax_product_tag_title'] ) && $options['tax_product_tag_title'] <> '' ) {
						$patterns['tax-product_tag']['title'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_product_tag_title'] ) );
					}
					if ( isset( $options['tax_product_tag_description'] ) && $options['tax_product_tag_description'] <> '' ) {
						$patterns['tax-product_tag']['description'] = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['tax_product_tag_description'] ) );
					}

					SQ_Classes_Helpers_Tools::saveOptions( 'patterns', $patterns );

					if ( ( isset( $options['homepage_title'] ) && $options['homepage_title'] <> '' ) || isset( $options['homepage_description'] ) && $options['homepage_description'] <> '' ) {
						$url  = home_url();
						$post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setHomePage();

						$post->sq->doseo          = 1;
						$post->sq->title          = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['homepage_title'] ) );
						$post->sq->description    = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['homepage_description'] ) );
						$post->sq->og_title       = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['homepage_facebook_title'] ) );
						$post->sq->og_description = preg_replace( '/%([^\%]+)%/', '{{$1}}', str_replace( array_keys( $findreplace ), array_values( $findreplace ), $options['homepage_facebook_description'] ) );

						if ( isset( $options['homepage_facebook_image'] ) && $options['homepage_facebook_image'] <> '' ) {
							$post->sq->og_media = $options['homepage_facebook_image'];
						}

						SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->saveSqSEO( $url, $post->hash, maybe_serialize( array(
									'ID'        => 0,
									'post_type' => 'home',
									'term_id'   => 0,
									'taxonomy'  => '',
								) ), maybe_serialize( $post->sq->toArray() ), gmdate( 'Y-m-d H:i:s' ) );
					}
				}


			}

			if ( $platform == 'premium-seo-pack' ) {
				global $wpdb;

				$tables = $wpdb->get_col( 'SHOW TABLES' );
				foreach ( $tables as $table ) {
					if ( $table == $wpdb->prefix . strtolower( 'psp' ) ) {
						$table = $wpdb->prefix . "psp";
						if ( $rows = $wpdb->get_results( "SELECT * FROM `$table`", OBJECT ) ) {
							foreach ( $rows as $row ) {
								$metas[ $row->url_hash ]['post_id'] = $row->post_id;
								$metas[ $row->url_hash ]['url']     = $row->URL;
								$metas[ $row->url_hash ]['seo']     = $row->seo;
							}
						}
						break;
					}
				}

				return $metas;
			}

			if ( $platform == 'autodescription' ) {
				if ( $options = get_option( 'autodescription-site-settings' ) ) {
					///////////////////////////////////////////
					/////////////////////////////FIRST PAGE OPTIMIZATION
					if ( ( isset( $options['homepage_title'] ) && $options['homepage_title'] <> '' ) || isset( $options['homepage_description'] ) && $options['homepage_description'] <> '' ) {
						$url  = home_url();
						$post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setHomePage();

						$post->sq->doseo       = 1;
						$post->sq->title       = $options['homepage_title'];
						$post->sq->description = $options['homepage_description'];

						if ( isset( $options['homepage_social_image_url'] ) && $options['homepage_social_image_url'] <> '' ) {
							$post->sq->og_media = $options['homepage_social_image_url'];
						}

						SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->saveSqSEO( $url, $post->hash, maybe_serialize( array(
									'ID'        => 0,
									'post_type' => 'home',
									'term_id'   => 0,
									'taxonomy'  => '',
								) ), maybe_serialize( $post->sq->toArray() ), gmdate( 'Y-m-d H:i:s' ) );
					}
				}
			}
		}

		return $metas;
	}

	/**
	 * Create a Squirrly SEO export jsonld
	 *
	 * @return string
	 */
	function exportTableData() {
		global $wpdb;

		$tables = $wpdb->get_col( 'SHOW TABLES' );
		$output = array();
		$keys   = array(
			'title',
			'description',
			'keywords',
			'canonical',
			'tw_media',
			'tw_title',
			'tw_description',
			'tw_type',
			'og_title',
			'og_description',
			'og_author',
			'og_type',
			'og_media',
			'optimizations',
			'redirect'
		);
		foreach ( $tables as $table ) {
			if ( $table == $wpdb->prefix . _SQ_DB_ ) {
				$results = $wpdb->get_results( "SELECT post,seo FROM `$table`" );
				foreach ( $results as $row ) {
					$post     = (array) unserialize( $row->post );
					$seo      = (array) unserialize( $row->seo );
					$seo      = array_intersect_key( $seo, array_flip( $keys ) );
					$output[] = array_merge( $post, $seo );
				}
				break;
			}
		}
		$wpdb->flush();

		return json_encode( $output );
	}

	/**
	 * Create a Squirrly SEO Backup
	 *
	 * @return string
	 */
	function createTableBackup() {
		global $wpdb;

		$tables = $wpdb->get_col( 'SHOW TABLES' );
		$output = '';
		foreach ( $tables as $table ) {
			if ( $table == $wpdb->prefix . _SQ_DB_ ) {
				$result  = $wpdb->get_results( "SELECT * FROM `$table`", ARRAY_N );
				$columns = $wpdb->get_results( "SHOW COLUMNS FROM `$table`", ARRAY_N );
				for ( $i = 0; $i < count( (array) $result ); $i ++ ) {
					$row    = $result[ $i ];
					$output .= "INSERT INTO `$table` (";
					for ( $col = 0; $col < count( (array) $columns ); $col ++ ) {
						$output .= ( isset( $columns[ $col ][0] ) ? $columns[ $col ][0] : "''" );
						if ( $col < ( count( (array) $columns ) - 1 ) ) {
							$output .= ',';
						}
					}
					$output .= ') VALUES(';
					for ( $j = 0; $j < count( (array) $result[0] ); $j ++ ) {
						$row[ $j ] = str_replace( array( "\'", "'" ), array( "'", "\'" ), $row[ $j ] );
						$output    .= ( isset( $row[ $j ] ) ? "'" . $row[ $j ] . "'" : "''" );
						if ( $j < ( count( (array) $result[0] ) - 1 ) ) {
							$output .= ',';
						}
					}
					$output .= ")\n";
				}
				$output .= "\n";
				break;
			}
		}
		$wpdb->flush();

		return $output;
	}

	/**
	 * Restore a Squirrly SEO backup
	 *
	 * @param  $queries
	 * @param bool $overwrite
	 *
	 * @return bool
	 */
	public function executeSql( $queries, $overwrite = true ) {
		global $wpdb;

		if ( is_array( $queries ) && ! empty( $queries ) ) {

			foreach ( (array) $queries as $query ) {
				$query = trim( $query, PHP_EOL );
				if ( ! empty( $query ) && strlen( $query ) > 1 ) {

					if ( strpos( $query, 'CREATE TABLE' ) !== false ) {
						continue;
					}

					//get each row from query
					if ( strpos( $query, '(' ) !== false && strpos( $query, ')' ) !== false && strpos( $query, 'VALUES' ) !== false ) {
						$fields = substr( $query, strpos( $query, '(' ) + 1 );
						$fields = substr( $fields, 0, strpos( $fields, ')' ) );
						$fields = explode( ",", trim( $fields ) );

						$values = substr( $query, strpos( $query, 'VALUES' ) + 6 );
						if ( strpos( $query, 'ON DUPLICATE' ) !== false ) {
							$values = substr( $values, 0, strpos( $values, 'ON DUPLICATE' ) );
						}

						$values = explode( "','", trim( trim( $values ), '();' ) );
						$values = array_map( function ( $value ) {
							return trim( $value, "'" );
						}, $values );

						//Correct the old backups
						if ( in_array( 'post_id', $fields ) ) {
							foreach ( $fields as $index => $field ) {
								if ( $field == 'post_id' ) {
									unset( $fields[ $index ] );
									unset( $values[ $index ] );
								}
							}
						}

						//Make sure the values match with the fields
						if ( ! empty( $fields ) && ! empty( $values ) && count( $fields ) == count( $values ) ) {

							$placeholders = array_fill( 0, count( $values ), '%s' );

							if ( $overwrite ) {
								$query = "INSERT INTO `" . $wpdb->prefix . _SQ_DB_ . "` (" . join( ",", $fields ) . ") 
                                          VALUES (" . join( ",", $placeholders ) . ") ON DUPLICATE KEY 
                                          UPDATE " . join( " = %s,", $fields ) . " = %s";
							} else {
								$query = "INSERT INTO `" . $wpdb->prefix . _SQ_DB_ . "` (" . join( ",", $fields ) . ") 
                                          VALUES (" . join( ",", $placeholders ) . ") ";
							}
							$wpdb->query( $wpdb->prepare( $query, array_merge( $values, $values ) ) );

						}

					}

				}
			}

			return true;
		}

		return false;
	}
}
