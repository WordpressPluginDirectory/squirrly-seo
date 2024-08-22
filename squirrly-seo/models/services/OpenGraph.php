<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Services_OpenGraph extends SQ_Models_Abstract_Seo {

	/**
	 * Facebook locales
	 *
	 * @var array
	 */
	const locales = [
		'af_ZA', // Afrikaans.
		'ak_GH', // Akan.
		'am_ET', // Amharic.
		'ar_AR', // Arabic.
		'as_IN', // Assamese.
		'ay_BO', // Aymara.
		'az_AZ', // Azerbaijani.
		'be_BY', // Belarusian.
		'bg_BG', // Bulgarian.
		'bp_IN', // Bhojpuri.
		'bn_IN', // Bengali.
		'br_FR', // Breton.
		'bs_BA', // Bosnian.
		'ca_ES', // Catalan.
		'cb_IQ', // Sorani Kurdish.
		'ck_US', // Cherokee.
		'co_FR', // Corsican.
		'cs_CZ', // Czech.
		'cx_PH', // Cebuano.
		'cy_GB', // Welsh.
		'da_DK', // Danish.
		'de_DE', // German.
		'el_GR', // Greek.
		'en_GB', // English (UK).
		'en_PI', // English (Pirate).
		'en_UD', // English (Upside Down).
		'en_US', // English (US).
		'em_ZM',
		'eo_EO', // Esperanto.
		'es_ES', // Spanish (Spain).
		'es_LA', // Spanish.
		'es_MX', // Spanish (Mexico).
		'et_EE', // Estonian.
		'eu_ES', // Basque.
		'fa_IR', // Persian.
		'fb_LT', // Leet Speak.
		'ff_NG', // Fulah.
		'fi_FI', // Finnish.
		'fo_FO', // Faroese.
		'fr_CA', // French (Canada).
		'fr_FR', // French (France).
		'fy_NL', // Frisian.
		'ga_IE', // Irish.
		'gl_ES', // Galician.
		'gn_PY', // Guarani.
		'gu_IN', // Gujarati.
		'gx_GR', // Classical Greek.
		'ha_NG', // Hausa.
		'he_IL', // Hebrew.
		'hi_IN', // Hindi.
		'hr_HR', // Croatian.
		'hu_HU', // Hungarian.
		'ht_HT', // Haitian Creole.
		'hy_AM', // Armenian.
		'id_ID', // Indonesian.
		'ig_NG', // Igbo.
		'is_IS', // Icelandic.
		'it_IT', // Italian.
		'ik_US',
		'iu_CA',
		'ja_JP', // Japanese.
		'ja_KS', // Japanese (Kansai).
		'jv_ID', // Javanese.
		'ka_GE', // Georgian.
		'kk_KZ', // Kazakh.
		'km_KH', // Khmer.
		'kn_IN', // Kannada.
		'ko_KR', // Korean.
		'ks_IN', // Kashmiri.
		'ku_TR', // Kurdish (Kurmanji).
		'ky_KG', // Kyrgyz.
		'la_VA', // Latin.
		'lg_UG', // Ganda.
		'li_NL', // Limburgish.
		'ln_CD', // Lingala.
		'lo_LA', // Lao.
		'lt_LT', // Lithuanian.
		'lv_LV', // Latvian.
		'mg_MG', // Malagasy.
		'mi_NZ', // Maori.
		'mk_MK', // Macedonian.
		'ml_IN', // Malayalam.
		'mn_MN', // Mongolian.
		'mr_IN', // Marathi.
		'ms_MY', // Malay.
		'mt_MT', // Maltese.
		'my_MM', // Burmese.
		'nb_NO', // Norwegian (bokmal).
		'nd_ZW', // Ndebele.
		'ne_NP', // Nepali.
		'nl_BE', // Dutch (Belgie).
		'nl_NL', // Dutch.
		'nn_NO', // Norwegian (nynorsk).
		'nr_ZA', // Southern Ndebele.
		'ns_ZA', // Northern Sotho.
		'ny_MW', // Chewa.
		'om_ET', // Oromo.
		'or_IN', // Oriya.
		'pa_IN', // Punjabi.
		'pl_PL', // Polish.
		'ps_AF', // Pashto.
		'pt_BR', // Portuguese (Brazil).
		'pt_PT', // Portuguese (Portugal).
		'qc_GT', // Quiché.
		'qu_PE', // Quechua.
		'qr_GR',
		'qz_MM', // Burmese (Zawgyi).
		'rm_CH', // Romansh.
		'ro_RO', // Romanian.
		'ru_RU', // Russian.
		'rw_RW', // Kinyarwanda.
		'sa_IN', // Sanskrit.
		'sc_IT', // Sardinian.
		'se_NO', // Northern Sami.
		'si_LK', // Sinhala.
		'su_ID', // Sundanese.
		'sk_SK', // Slovak.
		'sl_SI', // Slovenian.
		'sn_ZW', // Shona.
		'so_SO', // Somali.
		'sq_AL', // Albanian.
		'sr_RS', // Serbian.
		'ss_SZ', // Swazi.
		'st_ZA', // Southern Sotho.
		'sv_SE', // Swedish.
		'sw_KE', // Swahili.
		'sy_SY', // Syriac.
		'sz_PL', // Silesian.
		'ta_IN', // Tamil.
		'te_IN', // Telugu.
		'tg_TJ', // Tajik.
		'th_TH', // Thai.
		'tk_TM', // Turkmen.
		'tl_PH', // Filipino.
		'tl_ST', // Klingon.
		'tn_BW', // Tswana.
		'tr_TR', // Turkish.
		'ts_ZA', // Tsonga.
		'tt_RU', // Tatar.
		'tz_MA', // Tamazight.
		'uk_UA', // Ukrainian.
		'ur_PK', // Urdu.
		'uz_UZ', // Uzbek.
		've_ZA', // Venda.
		'vi_VN', // Vietnamese.
		'wo_SN', // Wolof.
		'xh_ZA', // Xhosa.
		'yi_DE', // Yiddish.
		'yo_NG', // Yoruba.
		'zh_CN', // Simplified Chinese (China).
		'zh_HK', // Traditional Chinese (Hong Kong).
		'zh_TW', // Traditional Chinese (Taiwan).
		'zu_ZA', // Zulu.
		'zz_TR', // Zazaki.
	];

	public function __construct() {
		parent::__construct();

		if ( isset( $this->_post->sq->doseo ) && $this->_post->sq->doseo ) {
			if ( ! $this->_post->sq->do_og ) {
				add_filter( 'sq_open_graph', array( $this, 'returnFalse' ) );

				return;
			}

			add_filter( 'sq_locale', array( $this, 'setLocale' ) );
			add_filter( 'sq_html_prefix', array( $this, 'addOGPrefix' ) );

			add_filter( 'sq_open_graph', array( $this, 'generateOpenGraph' ) );
			add_filter( 'sq_open_graph', array( $this, 'packOpenGraph' ), 99 );
		} else {
			add_filter( 'sq_open_graph', array( $this, 'returnFalse' ) );
		}

	}

	public function addOGPrefix( $prefix = '' ) {
		$prefix .= 'og: http://ogp.me/ns#';
		if ( ! empty( $this->_post->socials->fb_admins ) || $this->_post->socials->fbadminapp <> '' ) {
			$prefix .= ' fb: http://ogp.me/ns/fb#';
		}

		return $prefix;
	}

	public function generateOpenGraph( $og ) {
		if ( ! $og ) {
			$og = array();
		}

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) ) {
			if ( $this->_post->url <> '' ) {
				$og['og:url'] = apply_filters( 'sq_canonical_url', urldecode( esc_url( $this->_post->url ) ) );
			}

			if ( $this->_post->sq->og_title <> '' ) {
				$og['og:title'] = SQ_Classes_Helpers_Sanitize::clearTitle( $this->_post->sq->og_title );
			} else {
				$og['og:title'] = SQ_Classes_Helpers_Sanitize::clearTitle( $this->_post->sq->title );
				if ( $og['og:title'] <> '' && strlen( $og['og:title'] ) > $this->_post->sq->og_title_maxlength ) {
					$og['og:title'] = $this->truncate( $og['og:title'], 10, $this->_post->sq->og_title_maxlength );
				}
			}

			if ( $this->_post->sq->og_description <> '' ) {
				$og['og:description'] = SQ_Classes_Helpers_Sanitize::clearDescription( $this->_post->sq->og_description );
			} else {
				$og['og:description'] = SQ_Classes_Helpers_Sanitize::clearDescription( $this->_post->sq->description );
				if ( $og['og:description'] <> '' && strlen( $og['og:description'] ) > $this->_post->sq->og_description_maxlength ) {
					$og['og:description'] = $this->truncate( $og['og:description'], 10, $this->_post->sq->og_description_maxlength );
				}
			}

			if ( $this->_post->sq->og_type <> '' ) {
				if ( $this->_post->sq->og_type == 'newsarticle' ) {
					$og['og:type'] = 'article';
				} else {
					$og['og:type'] = $this->_post->sq->og_type;
				}
			} else {
				$og['og:type'] = 'website';
			}

			if ( $this->_post->sq->og_media <> '' ) {
				$og['og:image']       = $this->_post->sq->og_media;
				$og['og:image:width'] = '500';

				$imagetype = $this->getImageType( $this->_post->sq->og_media );
				if ( $imagetype ) {
					$og['og:image:type'] = $imagetype;
				}

				if ( $og['og:type'] == 'video' ) {
					$this->_setMedia( $og );
				}
			} else {
				$this->_setMedia( $og );
			}

			//Get the default global image for Open Graph
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_og_image' ) ) {
				if ( ! isset( $og['og:image'] ) ) {
					$og['og:image']       = SQ_Classes_Helpers_Tools::getOption( 'sq_og_image' );
					$og['og:image:width'] = '500';

					$imagetype = $this->getImageType( SQ_Classes_Helpers_Tools::getOption( 'sq_og_image' ) );
					if ( $imagetype ) {
						$og['og:image:type'] = $imagetype;
					}
				}
			}

			$og['og:site_name'] = get_bloginfo( 'title' );
			$og['og:locale']    = apply_filters( 'sq_locale', get_locale() );

			if ( $this->_post->socials->fbadminapp <> '' ) {
				$og['fb:app_id'] = $this->_post->socials->fbadminapp;
			}

			if ( ! empty( $this->_post->socials->fb_admins ) ) {
				foreach ( $this->_post->socials->fb_admins as $admin ) {
					if ( isset( $admin->id ) ) {
						$og['fb:admins'][] = $admin->id;
					}
				}
			}

			if ( $this->_post->sq->og_type == 'article' ) {
				if ( isset( $this->_post->post_date ) && $this->_post->post_date <> '' ) {
					$og['og:publish_date']        = date( "c", strtotime( $this->_post->post_date ) );
					$og['article:published_time'] = date( "c", strtotime( $this->_post->post_date ) );
				}
				if ( isset( $this->_post->post_modified ) && $this->_post->post_modified <> '' ) {
					$og['article:modified_time'] = date( "c", strtotime( $this->_post->post_modified ) );
				}
				if ( isset( $this->_post->category ) && $this->_post->category <> '' ) {
					$og['article:section'] = $this->_post->category;
				} else {
					$category = get_the_category( $this->_post->ID );
					if ( ! empty( $category ) && $category[0]->cat_name <> 'Uncategorized' ) {
						$og['article:section'] = $category[0]->cat_name;
					}
				}

				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_global_person' ) ) {
					$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
					if ( isset( $jsonld['Person']['name'] ) && $jsonld['Person']['name'] <> '' ) {
						$og['article:author'] = $jsonld['Person']['name'];
					}
				} elseif ( (int) $this->_post->post_author > 0 ) {
					$author = get_user_by( 'ID', (int) $this->_post->post_author );
					if ( isset( $author->display_name ) ) {
						$og['article:author'] = $author->display_name;
					}
				}

				if ( $this->_post->sq->keywords <> '' ) {
					$keywords = explode( ',', $this->_post->sq->keywords );
				}
				if ( ! empty( $keywords ) ) {
					foreach ( $keywords as $keyword ) {
						$og['article:tag'][] = $keyword;
					}
				}

				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_keywordtag' ) ) {
					$posttags = get_the_tags( $this->_post->post_id );
					if ( ! empty( $posttags ) ) {
						foreach ( $posttags as $tag ) {
							$og['article:tag'][] = $tag->name;
						}
					}
				}

			} elseif ( $this->_post->post_type == 'profile' && $this->_post->post_author <> '' ) {
				if ( strpos( $this->_post->post_author, " " ) !== false ) {
					$author = explode( " ", $this->_post->post_author );
				} else {
					$author = array( $this->_post->post_author );
				}
				$og['profile:first_name'] = $author[0];
				if ( isset( $author[1] ) ) {
					$og['profile:last_name'] = $author[1];
				}
			} elseif ( $this->_post->post_type === 'product' ) {
				if ( $this->_post->category <> '' ) {
					$og['product:category'] = $this->_post->category;
				}

				if ( (int) $this->_post->sq->primary_category > 0 ) {
					$category = get_term( (int) $this->_post->sq->primary_category, 'product_cat' );
					if ( isset( $category->name ) && $category->name <> '' ) {
						$og['product:category'] = $category->name;
					}
				}

				global $product;
				if ( class_exists( 'WC_Product' ) && $product instanceof WC_Product ) {
					$currency      = 'USD';
					$regular_price = $sale_price = $price = $sales_price_from = $sales_price_to = 0;


					//Product ID
					$og['product:retailer_item_id'] = ( method_exists( $product, 'get_sku' ) ) ? ( $product->get_sku() <> '' ? $product->get_sku() : '' ) : '';

					//Product Brand
					$sq_woocommerce = get_post_meta( $this->_post->ID, '_sq_woocommerce', true );
					if ( isset( $sq_woocommerce['brand'] ) && $sq_woocommerce['brand'] <> '' ) {
						$og['brand'] = $sq_woocommerce['brand'];
					}

					if ( method_exists( $product, 'is_on_backorder' ) && $product->is_on_backorder() ) {
						$og['product:availability'] = __( 'On backorder', 'woocommerce' );
					} elseif ( method_exists( $product, 'is_in_stock' ) && $product->is_in_stock() ) {
						$og['product:availability'] = __( 'In stock', 'woocommerce' );
					} else {
						$og['product:availability'] = __( 'Out of stock', 'woocommerce' );
					}

					if ( method_exists( $product, 'get_regular_price' ) ) {
						$regular_price = $product->get_regular_price();
					}

					if ( method_exists( $product, 'get_sale_price' ) ) {
						$sale_price = $product->get_sale_price();

						if ( $sale_price > 0 && method_exists( $product, 'get_date_on_sale_from' ) && method_exists( $product, 'get_date_on_sale_to' ) ) {
							$sales_price_from = $product->get_date_on_sale_from();
							$sales_price_to   = $product->get_date_on_sale_to();
							if ( is_a( $sales_price_from, 'WC_DateTime' ) && method_exists( $sales_price_from, 'getTimestamp' ) ) {
								$sales_price_from = $sales_price_from->getTimestamp();
							}
							if ( is_a( $sales_price_to, 'WC_DateTime' ) && method_exists( $sales_price_to, 'getTimestamp' ) ) {
								$sales_price_to = $sales_price_to->getTimestamp();
							}
						}
					}
					if ( method_exists( $product, 'get_price' ) ) {
						$price = $product->get_price();
					}

					if ( function_exists( 'get_woocommerce_currency' ) ) {
						$currency = get_woocommerce_currency();
					}

					if ( $regular_price > 0 && $regular_price <> $price ) {
						//Get the price with VAT if exists
						if ( function_exists( 'wc_get_price_including_tax' ) && function_exists( 'wc_tax_enabled' ) ) {
							if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
								$regular_price = wc_get_price_including_tax( $product, array( 'price' => $regular_price ) );
							}
						}

						$og['product:original_price:amount']   = wc_format_decimal( $regular_price, wc_get_price_decimals() );
						$og['product:original_price:currency'] = $currency;
					}

					if ( $price > 0 ) {
						//Get the price with VAT if exists
						if ( function_exists( 'wc_get_price_including_tax' ) && function_exists( 'wc_tax_enabled' ) ) {
							if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
								$price = wc_get_price_including_tax( $product, array( 'price' => $price ) );
							}
						}

						$og['product:price:amount']   = wc_format_decimal( $price, wc_get_price_decimals() );
						$og['product:price:currency'] = $currency;
					}

					if ( $sale_price > 0 ) {
						//Get the price with VAT if exists
						if ( function_exists( 'wc_get_price_including_tax' ) && function_exists( 'wc_tax_enabled' ) ) {
							if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
								$sale_price = wc_get_price_including_tax( $product, array( 'price' => $sale_price ) );
							}
						}

						$og['product:sale_price:amount']   = wc_format_decimal( $sale_price, wc_get_price_decimals() );
						$og['product:sale_price:currency'] = $currency;

						if ( $sales_price_from > 0 ) {
							$og['product:sale_price:start'] = date( "Y-m-d", $sales_price_from );
						}
						if ( $sales_price_to ) {
							$og['product:sale_price:end'] = date( "Y-m-d", $sales_price_to );
						}

					}


				}
			}

		}

		return $og;
	}

	protected function _setMedia( &$og ) {
		if ( $og['og:type'] == 'video' ) {
			if ( $videos = $this->getPostVideos() ) {
				if ( ! empty( $videos ) ) {
					$video = current( $videos );
					if ( $video['src'] <> '' ) {
						$video['src'] = preg_replace( '/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"\'>\s]+)/si', "https://www.youtube.com/v/$1", $video['src'] );

						$og['og:video']            = $video['src'];
						$og['og:video:url']        = $video['src'];
						$og['og:video:secure_url'] = $video['src'];
						$og['og:video:type']       = ( ( strpos( $video['src'], 'mp4' ) !== false ) ? 'video/mp4' : 'application/x-shockwave-flash' );
						$og['og:video:width']      = '640';
						$og['og:video:height']     = '360';
						if ( isset( $video['thumbnail'] ) && $video['thumbnail'] <> '' ) {
							$og['og:image'] = $video['thumbnail'];
						}
					}
				}
			}
		} else {
			$images = $this->getPostImages();
			if ( ! empty( $images ) ) {
				$image = current( $images );
				if ( isset( $image['src'] ) ) {
					$og['og:image'] = $image['src'];
					if ( isset( $image['width'] ) ) {
						$og['og:image:width'] = $image['width'];
					}
					if ( isset( $image['height'] ) ) {
						$og['og:image:height'] = $image['height'];
					}

					$imagetype = $this->getImageType( $image['src'] );
					if ( $imagetype ) {
						$og['og:image:type'] = $imagetype;
					}
				}
			}
		}
	}

	/**
	 * Sanitize locale.
	 *
	 * @param string $locale
	 *
	 * @return string
	 */
	public function sanitize( $locale ) {
		$fix_locales = array(
			'ca' => 'ca_ES',
			'en' => 'en_US',
			'el' => 'el_GR',
			'et' => 'et_EE',
			'ja' => 'ja_JP',
			'sq' => 'sq_AL',
			'uk' => 'uk_UA',
			'vi' => 'vi_VN',
			'zh' => 'zh_CN',
			'te' => 'te_IN',
			'ur' => 'ur_PK',
			'cy' => 'cy_GB',
			'eu' => 'eu_ES',
			'th' => 'th_TH',
			'af' => 'af_ZA',
			'hy' => 'hy_AM',
			'gu' => 'gu_IN',
			'kn' => 'kn_IN',
			'mr' => 'mr_IN',
			'kk' => 'kk_KZ',
			'lv' => 'lv_LV',
			'sw' => 'sw_KE',
			'tl' => 'tl_PH',
			'ps' => 'ps_AF',
			'as' => 'as_IN',
		);

		if ( isset( $fix_locales[ $locale ] ) ) {
			$locale = $fix_locales[ $locale ];
		}

		// Convert locales like "es" to "es_ES", in case that works for the given locale (sometimes it does).
		if ( 2 === strlen( $locale ) ) {
			$locale = strtolower( $locale ) . '_' . strtoupper( $locale );
		}

		return $locale;
	}

	/**
	 * Validate FB .
	 *
	 * @param string $locale .
	 *
	 * @return string
	 */
	public function validate( $locale ) {
		if ( in_array( $locale, self::locales, true ) ) {
			return $locale;
		}

		$locale = strtolower( substr( $locale, 0, 2 ) ) . '_' . strtoupper( substr( $locale, 0, 2 ) );

		return in_array( $locale, self::locales, true ) ? $locale : SQ_Classes_Helpers_Tools::getOption( 'sq_og_locale' );
	}

	/**
	 * Set local meta for FB
	 *
	 * @param $locale
	 *
	 * @return string
	 */
	public function setLocale( $locale ) {

		//if WPML is installed, get the local language
		if ( function_exists( 'wpml_get_language_information' ) && (int) $this->_post->ID > 0 ) {
			if ( $language = wpml_get_language_information( (int) $this->_post->ID ) ) {
				if ( ! is_wp_error( $language ) && isset( $language['locale'] ) ) {
					if ( $locale <> 'en' ) {
						$locale = $language['locale'];
					}
				}
			}
		}

		if ( function_exists( 'weglot_get_current_language' ) ) {
			$locale = weglot_get_current_language();
		}

		$locale = $this->sanitize( $locale );
		return $this->validate( $locale );

	}

	/**
	 * Pack the OpenGraph to meta format
	 *
	 * @param array $og
	 *
	 * @return bool|string
	 */
	public function packOpenGraph( $og = array() ) {
		if ( ! empty( $og ) ) {
			foreach ( $og as $key => &$value ) {

				if ( is_array( $value ) ) {
					$str = '';
					foreach ( $value as $subvalue ) {
						$str .= '<meta property="' . $key . '" content="' . $subvalue . '" />' . ( ( count( (array) $value ) > 1 ) ? "\n" : '' );
					}
					$value = $str;
				} else {
					$value = '<meta property="' . $key . '" content="' . $value . '" />';
				}
			}

			return "\n" . join( "\n", array_values( $og ) );
		}

		return false;
	}

}
