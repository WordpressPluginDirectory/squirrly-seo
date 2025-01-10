<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Compatibility with other plugins and themes
 * Class SQ_Models_Compatibility
 */
class SQ_Models_Compatibility {

	/**
	 * @var array set Woocommerce custom fields
	 */
	public $wc_inventory_fields;
	public $wc_advanced_fields;

	/**
	 * Check compatibility for late loading buffer
	 */
	public function checkCompatibility() {
		//if the lateloading param is not set in config
		if ( ! defined( 'SQ_LATELOADING' ) ) {

			//compatible with other cache plugins
			if ( defined( 'CE_FILE' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

			//Compatibility with Hummingbird Plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'hummingbird-performance/wp-hummingbird.php' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

			//Compatibility with Deep Core PRO plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'deep-core-pro/deep-core-pro.php' ) && SQ_Classes_Helpers_Tools::isPluginInstalled( 'js_composer/js_composer.php' ) ) {
				add_action( 'plugins_loaded', array( $this, 'hookDeepPRO' ) );
			}

			//Compatibility with Buddypress Plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'buddypress/bp-loader.php' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
				add_action( 'template_redirect', array( $this, 'setBuddyPressPage' ), PHP_INT_MAX );
			}

			//Compatibility with TranslatePress Plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'translatepress-multilingual/index.php' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );

				add_filter( 'sq_sitemap_language', function ( $language ) {

					add_filter( 'home_url', function ( $url ) {
						if ( class_exists( 'TRP_Translate_Press' ) ) {
							$settings      = get_option( 'trp_settings', false );
							$trp           = TRP_Translate_Press::get_trp_instance();
							$url_converter = $trp->get_component( 'url_converter' );
							$current_lang  = $url_converter->get_lang_from_url_string( $url_converter->cur_page_url() );
							if ( ! empty( $current_lang ) && $current_lang <> $settings['default-language'] ) {
								if ( ! SQ_Classes_Helpers_Tools::findStr( $url, '/' . $settings['url-slugs'][ $current_lang ] ) ) {
									return trailingslashit( trailingslashit( $url ) . $settings['url-slugs'][ $current_lang ] );
								}
							}
						}

						return $url;
					}, PHP_INT_MAX );

					return $language;
				} );
			}

			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang/polylang.php' ) || SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang-pro/polylang.php' ) ) {

				add_filter( 'sq_sitemap_language', function ( $language ) {
					global $polylang;

					//Polylang
					if ( $polylang && function_exists( 'pll_default_language' ) && isset( $polylang->links_model ) ) {
						if ( ! $language = $polylang->links_model->get_language_from_url() ) {
							$language = pll_default_language();
						}
					}

					return $language;
				} );

			}

			//Compatibility with Cachify plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'cachify/cachify.php' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

			//Compatibility with Oxygen plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'oxygen/functions.php' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

			//Compatibility with WP Super Cache plugin
			global $wp_super_cache_late_init;
			if ( isset( $wp_super_cache_late_init ) && $wp_super_cache_late_init == 1 && ! did_action( 'init' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

			//Compatibility with Weglot Plugin
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'weglot/weglot.php' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

			//Compatibility with Swis Performance Plugin
			if ( defined( 'SWIS_PLUGIN_VERSION' ) ) {
				add_filter( 'sq_lateloading', '__return_true' );
			}

		}

		//if the lateloading sitemap param is not set in config
		if ( ! defined( 'SQ_LATELOADING_SITEMAP' ) ) {
			//check the sitemap for custom post types
			$stemaplist = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap' );
			if ( ( isset( $stemaplist['sitemap-custom-tax'][1] ) && $stemaplist['sitemap-custom-tax'][1] ) || isset( $stemaplist['sitemap-custom-post'][1] ) && $stemaplist['sitemap-custom-post'][1] || isset( $stemaplist['sitemap-archive'][1] ) && $stemaplist['sitemap-archive'][1] ) {
				//load the sitemap index on wp action and wait for all custom posts to load
				add_filter( 'sq_lateloading_sitemap', '__return_true' );
			}
		}

		//Compatibility with Ezoic
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'ezoic-integration/ezoic-integration.php' ) ) {
			remove_all_actions( 'shutdown' );
		}

		//Compatibility with BuddyPress plugin
		if ( defined( 'BP_REQUIRED_PHP_VERSION' ) ) {
			add_action( 'template_redirect', array(
				SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' ),
				'setPost'
			), 10 );
		}

		//Check if frontend css should load
		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_load_css' ) || ( defined( 'SQ_NOCSS' ) && SQ_NOCSS ) || SQ_Classes_Helpers_Tools::isAjax() ) {
			add_filter( 'sq_load_css', '__return_false' );
		}

		//Remove post_id query error from the plugin Schema & Structured Data for WP & AMP
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'schema-and-structured-data-for-wp/structured-data-for-wp.php' ) ) {
			add_action( 'init', function () {
				global $sd_data;
				if ( isset( $sd_data['saswp-squirrly-seo'] ) ) {
					$sd_data['saswp-squirrly-seo'] = 0;
				}
			}, 20 );
		}

		//For SEO Generator compatibility
		add_filter( 'sq_post', function ( $post ) {
			if ( function_exists( 'nsg_get_seo_pages_replace_search_terms_and_locations' ) && function_exists( 'nsg_get_search_terms_and_locations_lookup_table' ) ) {

				$lookup_table = nsg_get_search_terms_and_locations_lookup_table( $post->ID );
				$slug         = get_query_var( 'nsg_seo_page' );

				if ( $lookup_table !== false && isset( $lookup_table[ $slug ] ) ) {
					$search_term = $lookup_table[ $slug ][0];
					$location    = $lookup_table[ $slug ][1];

					$post->sq->title       = nsg_get_seo_pages_replace_search_terms_and_locations( $post->sq->title );
					$post->sq->description = nsg_get_seo_pages_replace_search_terms_and_locations( $post->sq->description );
					$post->sq->keywords    = "$search_term, $location";
					$post->url             .= $slug;
				}
			}

			return $post;
		}, 13, 1 );

	}

	/**
	 * Add support for multilingual plugins
	 *
	 * @return void
	 */
	public function checkMultilingual() {
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'sitepress-multilingual-cms/sitepress.php' ) || SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang/polylang.php' ) || SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang-pro/polylang.php' ) ) {

            //for WPML language to load in sitemap
			add_filter( 'sq_lateloading_sitemap', '__return_true' );

			add_filter( 'sq_option_patterns', function ( $patterns ) {

                //get the patterns for multilingual
				$language = strtolower( get_locale() );
				$sq_ml_patterns = get_option( SQ_ML_PATTERNS );

				if ( function_exists( 'pll_current_language' ) ) {
					$language = strtolower( pll_current_language() );
				} elseif ( $wpml = apply_filters( 'wpml_current_language', NULL ) ) {
                    if($wpml <> 'all'){
	                    $language = strtolower( $wpml );
                    }
				}

				if ( ! empty( $patterns ) && ! empty( $sq_ml_patterns ) ) {
					foreach ( $patterns as $pattern => $type ) {
						if ( isset( $sq_ml_patterns[ $pattern . '_' . $language ] ) ) {
							$patterns[ $pattern ] = $sq_ml_patterns[ $pattern . '_' . $language ];
						}
					}
				}

				return $patterns;
			} );

			add_action( 'sq_save_settings_after', function ( $params ) {

                //Only save patterns in Automation
                if( SQ_Classes_Helpers_Tools::getValue( 'action' ) <> 'sq_seosettings_automation' ||
                    ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ){
                    return;
                }

				if ( isset( $params['patterns'] ) ) {

					$language = strtolower( get_locale() );
					$sq_ml_patterns = get_option( SQ_ML_PATTERNS );

					if ( function_exists( 'pll_current_language' ) ) {
						$language = strtolower( pll_current_language() );
					} elseif ( $wpml = apply_filters( 'wpml_current_language', NULL ) ) {
						if($wpml == 'all'){
							delete_option( SQ_ML_PATTERNS);
                            return;
						}else{
							$language = strtolower($wpml);
						}
					}

					foreach ( $params['patterns'] as $pattern => $values ) {
						$sq_ml_patterns[ $pattern . '_' . $language ] = $values;
					}
					update_option( SQ_ML_PATTERNS, $sq_ml_patterns );
				}
			});


			//Check for multilingual plugins
			add_filter( 'sq_canonical_url', function ( $url ) {

				if ( function_exists( 'pll_home_url' ) ) {
					//if is home page, get the correct canonical
					if ( ! parse_url( $url, PHP_URL_PATH ) ) {
						$url = trailingslashit( pll_home_url() );
					}
				}

				return $url;
			}, 11 );


		}
	}


	/**
	 * Check if there is an editor loading in frontend
	 * Don't load Squirrly METAs while in frontend editors
	 *
	 * @return bool
	 */
	public function checkBuilderPreview() {

		$builder_paramas = array(
			'fl_builder', //Beaver Builder
			'fb-edit', //Fusion Builder
			'builder', //Fusion Builder
			'vc_action', //WP Bakery
			'vc_editable', //WP Bakery
			'vcv-action', //WP Bakery
			'et_fb', //Divi
			'ct_builder', //Oxygen
			'ct_inner', //Oxygen
			'tve', //Thrive
			'tb-preview', //Themify
			//'preview', //Blockeditor & Gutenberg
			'elementor-preview', //Elementor
			'uxb_iframe',
			'wyp_page_type', //Yellowpencil plugin
			'wyp_mode',//Yellowpencil plugin
			'brizy-edit-iframe',//Brizy plugin
			'bricks',//Bricks plugin
			'zionbuilder-preview',//Zion Builder plugin
		);

		foreach ( $builder_paramas as $param ) {
			if ( SQ_Classes_Helpers_Tools::getIsset( $param ) ) {
				add_filter( 'sq_load_buffer', '__return_false' );
				add_filter( 'sq_load_css', '__return_false' );

				return true;
			}
		}

		return false;
	}


	/**
	 * Hook the Builders and load SLA
	 */
	public function hookBuildersBackend() {

		//Check if SLA frontend is enabled
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ) ) {

			//Load SLA in Elementor Backend
			if ( SQ_Classes_Helpers_Tools::getValue( 'action' ) == 'elementor' ) {
				//activate frontend SLA
				add_filter( 'sq_load_frontend_sla', '__return_true' );

				if ( (int) SQ_Classes_Helpers_Tools::getValue( 'post' ) > 0 ) {
					/** @var SQ_Models_LiveAssistant $liveAssistantModel */
					$liveAssistantModel = SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' );
					$liveAssistantModel->setPostId( (int) SQ_Classes_Helpers_Tools::getValue( 'post' ) );
				}

				//activate SLA for elementor on frontend
				add_action( 'elementor/editor/footer', array(
					SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' ),
					'loadFrontent'
				), 99 );
			}

			//Load SLA in WPBakery Frontend
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'js_composer/js_composer.php' ) ) {
				if ( SQ_Classes_Helpers_Tools::getValue( 'vc_action' ) == 'vc_inline' ) {
					//activate frontend SLA
					add_filter( 'sq_load_frontend_sla', '__return_true' );

					//hook the WPBakery editor
					add_action( 'vc_frontend_editor_render_template', array(
						SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' ),
						'loadFrontent'
					), 99 );
				}
			}

			//Load SLA in Thrive Backend
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'thrive-visual-editor/thrive-visual-editor.php' ) ) {
				if ( SQ_Classes_Helpers_Tools::getValue( 'action' ) == 'architect' ) {
					//activate frontend SLA
					add_filter( 'sq_load_frontend_sla', '__return_true' );

					//activate SLA for Thrive on frontend
					add_action( 'tcb_editor_iframe_after', array(
						SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' ),
						'loadFrontent'
					), 99 );

				}
			}

			//Load SLA in Zion Backend
			if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'zionbuilder/zionbuilder.php' ) ) {
				if ( SQ_Classes_Helpers_Tools::getValue( 'action' ) == 'zion_builder_active' ) {
					//activate frontend SLA
					add_filter( 'sq_load_frontend_sla', '__return_true' );

					//activate SLA for Zion on frontend
					add_action( 'zionbuilder/editor/after_scripts', array(
						SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' ),
						'loadFrontent'
					), 99 );
				}
			}

		}
	}

	/**
	 * Hook the Builders and load SLA
	 */
	public function hookBuildersFrontend() {

		//If SLA is active in fronend and is not ajax call
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ) && ! SQ_Classes_Helpers_Tools::isAjax() ) {

			//Load the SLA for Fusion Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'fb-edit' ) || SQ_Classes_Helpers_Tools::getValue( 'builder' ) ) {
				//activate frontend SLA
				add_filter( 'sq_load_frontend_sla', '__return_true' );

				//activate SLA for beaver on frontend
				if ( SQ_Classes_Helpers_Tools::getValue( 'fb-edit' ) ) {
					add_action( 'wp_enqueue_scripts', function () {
						SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' )->loadFrontent();
					}, PHP_INT_MAX );
				}

				//Load the style for builders
				if ( SQ_Classes_Helpers_Tools::getValue( 'builder' ) ) {
					add_action( 'wp_enqueue_scripts', function () {
						SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
					} );
				}
			}

			//Load SLA in Beaver
			if ( SQ_Classes_Helpers_Tools::getIsset( 'fl_builder' ) ) {

				//activate frontend SLA
				add_filter( 'sq_load_frontend_sla', '__return_true' );

				add_action( 'wp_enqueue_scripts', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
				} );

				//activate SLA for beaver on frontend
				add_action( 'fl_builder_init_ui', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' )->loadFrontent();
				}, PHP_INT_MAX );

				//Load the style for builders

			}

			//Load the SLA for Oxygen Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'ct_builder' ) || SQ_Classes_Helpers_Tools::getValue( 'ct_template' ) ) {

				//activate frontend SLA
				add_filter( 'sq_load_frontend_sla', '__return_true' );

				//load SLA in frontend for the page builder
				add_action( 'ct_before_builder', array(
					SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' ),
					'loadFrontent'
				), PHP_INT_MAX );

				if ( SQ_Classes_Helpers_Tools::getValue( 'oxygen_iframe' ) ) {
					add_action( 'wp_enqueue_scripts', function () {
						SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
					} );
				}

				//Load the style for builders
				add_action( 'fl_builder_init_ui', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' )->loadFrontent();
				}, PHP_INT_MAX );

			}

			//Load the SLA for Elementor Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'elementor-preview' ) ) {

				//Load the style for builders
				add_action( 'wp_enqueue_scripts', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
				} );

			}

			//Load the SLA for JS Composer / WPBakery
			if ( SQ_Classes_Helpers_Tools::getValue( 'vc_editable' ) ) {

				//Load the style for builders
				add_action( 'wp_enqueue_scripts', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
				} );
			}

			//Load the SLA for Zion Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'zionbuilder-preview' ) ) {

				//Load the style for builders
				add_action( 'wp_enqueue_scripts', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
				} );

			}

			//Load the SLA for Thrive Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'tve' ) ) {

				//Load the style for builders
				add_action( 'wp_enqueue_scripts', function () {
					SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
				} );
			}

			//Load the SLA for Divi Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'et_fb' ) ) {
				//activate frontend SLA
				add_filter( 'sq_load_frontend_sla', '__return_true' );
				add_filter( 'sq_option_sq_use_frontend', '__return_false' );

				//load SLA in frontend for the page builder
				add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
					ob_start();

					$handles   = SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' )->loadFrontent();
					$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );

					//print the styles and scripts on admin header for Divi Plugin
					add_action( 'shutdown', function () use ( $handles ) {
						wp_print_styles( $handles );
						wp_print_scripts( $handles );
					} );

					$liveassistant = ob_get_clean();

					$wp_admin_bar->add_menu( array(
						'id'     => 'sq_postsquirrly',
						'parent' => false,
						'meta'   => array(
							'html'     => $liveassistant,
							'tabindex' => PHP_INT_MAX,
						),
					) );
				} );

			}

			//Load the SLA for Bricks Editor
			if ( SQ_Classes_Helpers_Tools::getValue( 'bricks' ) == 'run' ) {
				//activate frontend SLA
				add_filter( 'sq_load_frontend_sla', '__return_true' );

				//activate SLA on frontend
				add_action( 'bricks_body', function () {
					if ( function_exists( 'bricks_is_builder_main' ) && bricks_is_builder_main() ) {
						SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' )->loadFrontent();
					} else {
						SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'builders' );
					}
				} );

			}
		}
	}

	/**
	 * Remove the action for WP Bakery shortcodes for Sitemap XML
	 */
	public function hookDeepPRO() {
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			if ( ( isset( $_SERVER['QUERY_STRING'] ) && strpos( $_SERVER['QUERY_STRING'], 'sq_feed' ) !== false ) || ( strpos( $_SERVER['REQUEST_URI'], '.xml' ) !== false ) ) {
				remove_action( 'init', 'shortcodes_init' );
			}
		}
	}

	/**
	 * Check if there are builders loaded in backend and add compatibility for them
	 */
	public function hookPostEditorBackend() {
		add_action( 'admin_footer', array( $this, 'checkBackendBuilder' ), PHP_INT_MAX );
	}

	/**
	 * Check the compatibility with Oxygen Builder, Beaver Builder
	 */
	public function checkBackendBuilder() {

		// if Oxygen is not active, abort.
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'oxygen/functions.php' ) && function_exists( 'get_current_screen' ) ) {
			//Only if in Post Editor
			if ( get_current_screen()->post_type ) {

				//check the current post type
				$post_type = get_current_screen()->post_type;

				//Excluded types for SLA and do not load for the Oxygen templates
				if ( SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSLAEnable( $post_type ) ) {

					global $post;

					if ( isset( $post->ID ) && (int) $post->ID > 0 ) {

						//If Oxygen Gutenberg plugin is installed and it's set to work with Gutenberg Blocks
						if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'oxygen-gutenberg/oxygen-gutenberg.php' ) ) {
							if ( $oxygenberg = get_post_meta( $post->ID, 'ct_oxygenberg_full_page_block', true ) ) {
								if ( $oxygenberg == 1 ) {
									return;
								}
							}
						}

						if ( $content = get_post_meta( $post->ID, 'ct_builder_shortcodes', true ) ) {

							wp_enqueue_script( 'sq-builder-integration', _SQ_ASSETS_URL_ . 'js/assistant/sq_backend' . ( SQ_DEBUG ? '' : '.min' ) . '.js' );

							wp_localize_script( 'sq-builder-integration', 'sq_builder', array(
									'content' => do_shortcode( $content )
								) );
						}

					}

				}
			}
		}
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'bb-plugin/fl-builder.php' ) && function_exists( 'get_current_screen' ) ) {
			//Only if in Post Editor
			if ( get_current_screen()->post_type ) {

				//check the current post type
				$post_type = get_current_screen()->post_type;

				//Excluded types for SLA and do not load for the Oxygen templates
				if ( SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSLAEnable( $post_type ) ) {

					global $post;

					if ( isset( $post->ID ) && (int) $post->ID > 0 ) {

						if ( $content = $post->post_content ) {

							wp_enqueue_script( 'sq-builder-integration', _SQ_ASSETS_URL_ . 'js/assistant/sq_backend' . ( SQ_DEBUG ? '' : '.min' ) . '.js' );

							wp_localize_script( 'sq-builder-integration', 'sq_builder', array(
									'content' => do_shortcode( $content )
								) );
						}

					}

				}
			}
		}
	}

	/**
	 * Check the compatibility with Zion Buider
	 */
	public function checkZionBuilder() {

		// if Zion is not active, abort.
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'zionbuilder/zionbuilder.php' ) && function_exists( 'get_current_screen' ) ) {
			//Only if in Post Editor
			if ( get_current_screen()->post_type ) {

				//check the current post type
				$post_type = get_current_screen()->post_type;

				//Excluded types for SLA and do not load for the Zion templates
				if ( SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSLAEnable( $post_type ) ) {

					global $post;

					if ( isset( $post->ID ) && (int) $post->ID > 0 ) {
						if ( class_exists( '\ZionBuilder\Post\BasePostType' ) ) {
							/**
							 * @var BasePostType $content
							 */
							$zion    = new \ZionBuilder\Post\BasePostType( (int) $post->ID );
							$content = $zion->get_template_data();

							wp_enqueue_script( 'sq-zion-integration', _SQ_ASSETS_URL_ . 'js/zion' . ( SQ_DEBUG ? '' : '.min' ) . '.js' );

							wp_localize_script( 'sq-zion-integration', 'sq_zion', array(
									'content' => $content
								) );
						}

					}

				}
			}
		}
	}

	public function checkWooCommerce() {
		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'woocommerce/woocommerce.php' ) ) {
			$this->wc_inventory_fields = array(
				'mpn'  => array(
					'label'       => __( 'MPN', 'squirrly-seo' ),
					'description' => __( 'Add Manufacturer Part Number (MPN)', 'squirrly-seo' ),
				),
				'gtin' => array(
					'label'       => __( 'GTIN', 'squirrly-seo' ),
					'description' => __( 'Add Global Trade Item Number (GTIN)', 'squirrly-seo' ),
				),
				'ean'  => array(
					'label'       => __( 'EAN (GTIN-13)', 'squirrly-seo' ),
					'description' => __( 'Add Global Trade Item Number (GTIN) for the major GTIN used outside of North America', 'squirrly-seo' ),
				),
				'upc'  => array(
					'label'       => __( 'UPC (GTIN-12)', 'squirrly-seo' ),
					'description' => __( 'Add Global Trade Item Number (GTIN) for North America', 'squirrly-seo' ),
				),
				'isbn' => array(
					'label'       => __( 'ISBN', 'squirrly-seo' ),
					'description' => __( 'Add Global Trade Item Number (GTIN) for books', 'squirrly-seo' ),
				),
			);
			$this->wc_advanced_fields  = array(
				'brand' => array(
					'label'       => __( 'Brand Name', 'squirrly-seo' ),
					'description' => __( 'Add Product Brand Name', 'squirrly-seo' ),
				),
			);
			add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'addWCInventoryFields' ) );

			if ( ! SQ_Classes_Helpers_Tools::isPluginInstalled( 'perfect-woocommerce-brands/perfect-woocommerce-brands.php' ) && ! SQ_Classes_Helpers_Tools::isPluginInstalled( 'yith-woocommerce-brands-add-on/init.php' ) ) {
				add_action( 'woocommerce_product_options_advanced', array( $this, 'addWCAdvancedFields' ) );
			}

			add_filter( 'sq_seo_before_save', array( $this, 'saveWCCustomFields' ), 11, 2 );

		}
	}

	public function saveWCCustomFields( $sq, $post_id ) {

		if ( $post_id ) {
			$sq_woocommerce = array();
			foreach ( $this->wc_inventory_fields as $field => $details ) {
				if ( SQ_Classes_Helpers_Tools::getIsset( '_sq_wc_' . $field ) ) {
					$sq_woocommerce[ $field ] = SQ_Classes_Helpers_Tools::getValue( '_sq_wc_' . $field, '' );
				}
			}
			foreach ( $this->wc_advanced_fields as $field => $details ) {
				if ( SQ_Classes_Helpers_Tools::getIsset( '_sq_wc_' . $field ) ) {
					$sq_woocommerce[ $field ] = SQ_Classes_Helpers_Tools::getValue( '_sq_wc_' . $field, '' );
				}
			}
			if ( ! empty( $sq_woocommerce ) ) {
				update_post_meta( $post_id, '_sq_woocommerce', $sq_woocommerce );
			}
		}

		return $sq;
	}

	/**
	 * Add the custom fields in WooCommerce Inventory section
	 */
	public function addWCInventoryFields() {
		global $post;

		if ( ! isset( $post->ID ) ) {
			return;
		}

		//Get the meta values
		$sq_woocommerce = get_post_meta( $post->ID, '_sq_woocommerce', true );

		if ( function_exists( 'woocommerce_wp_text_input' ) ) {
			foreach ( $this->wc_inventory_fields as $field => $details ) {
				?>
                <div class="options_group">
					<?php woocommerce_wp_text_input( array(
							'id'          => '_sq_wc_' . $field,
							'value'       => ( isset( $sq_woocommerce[ $field ] ) ? $sq_woocommerce[ $field ] : '' ),
							'label'       => $details['label'],
							'desc_tip'    => true,
							'description' => $details['description'],
							'type'        => 'text',
						) ); ?>
                </div>
				<?php
			}
		}
	}

	/**
	 * Add the custom fields in WooCommerce Advanced section
	 */
	public function addWCAdvancedFields() {
		global $post;

		if ( ! isset( $post->ID ) ) {
			return;
		}

		//Get the meta values
		$sq_woocommerce = get_post_meta( $post->ID, '_sq_woocommerce', true );

		if ( function_exists( 'woocommerce_wp_text_input' ) ) {
			foreach ( $this->wc_advanced_fields as $field => $details ) {
				?>
                <div class="options_group">
					<?php woocommerce_wp_text_input( array(
							'id'          => '_sq_wc_' . $field,
							'value'       => ( isset( $sq_woocommerce[ $field ] ) ? $sq_woocommerce[ $field ] : '' ),
							'label'       => $details['label'],
							'desc_tip'    => true,
							'description' => $details['description'],
							'type'        => 'text',
						) ); ?>
                </div>
				<?php
			}
		}
	}

	/**
	 * Set compatibility with BuddyPress
	 * Set the page according to BuddyPress slug
	 */
	public function setBuddyPressPage() {
		if ( function_exists( 'bp_get_root_slug' ) ) {
			if ( $slug = bp_get_root_slug() ) {
				if ( $page = get_page_by_path( $slug ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->setPost( $page );
				}
			}
		}
	}

	/**
	 * Prevent other plugins from loading styles in Squirrly Technical SEO
	 * > Only called on Squirrly Settings pages
	 */
	public function fixEnqueueErrors() {
		global $sq_fullscreen, $wp_styles, $wp_scripts;

		//deregister other plugins styles to prevent layout issues in Squirrly Technical SEO pages
		if ( $sq_fullscreen ) {
			if ( isset( $wp_styles->queue ) && ! empty( $wp_styles->queue ) ) {
				foreach ( $wp_styles->queue as $name => $style ) {
					if ( isset( $style->src ) ) {
						if ( $this->isPluginThemeGlobalStyle( $style->src ) ) {
							wp_dequeue_style( $name );
						}
					}
				}
			}

			if ( isset( $wp_styles->registered ) && ! empty( $wp_styles->registered ) ) {
				foreach ( $wp_styles->registered as $name => $style ) {
					if ( isset( $style->src ) ) {
						if ( $this->isPluginThemeGlobalStyle( $style->src ) ) {
							wp_deregister_style( $name );
						}
					}
				}
			}

			if ( isset( $wp_scripts->registered ) && ! empty( $wp_scripts->registered ) ) {
				foreach ( $wp_scripts->registered as $name => $script ) {
					if ( isset( $script->src ) ) {
						if ( $this->isPluginThemeGlobalStyle( $script->src ) ) {
							wp_deregister_script( $name );
						}
					}
				}
			}
		} else {

			//exclude known plugins that affect the layout in Squirrly SEO
			$exclude = array(
				'boostrap',
				'wpcd-admin-js',
				'ampforwp_admin_js',
				'__ytprefs_admin__',
				'wpf-graphics-admin-style',
				'wwp-bootstrap',
				'wwp-bootstrap-select',
				'wwp-popper',
				'wwp-script',
				'wpf_admin_style',
				'wpf_bootstrap_script',
				'wpf_wpfb-front_script',
				'auxin-admin-style',
				'wdc-styles-extras',
				'wdc-styles-main',
				'wp-color-picker-alpha',  //collor picker compatibility
				'td_wp_admin',
				'td_wp_admin_color_picker',
				'td_wp_admin_panel',
				'td_edit_page',
				'td_page_options',
				'td_tooltip',
				'td_confirm',
				'thickbox',
				'font-awesome',
				'bootstrap-iconpicker-iconset',
				'bootstrap-iconpicker',
				'cs_admin_styles_css',
				'jobcareer_admin_styles_css',
				'jobcareer_editor_style',
				'jobcareer_bootstrap_min_js',
				'cs_fonticonpicker_bootstrap_css',
				'cs_bootstrap_slider_css',
				'cs_bootstrap_css',
				'cs_bootstrap_slider',
				'cs_bootstrap_min_js',
				'cs_bootstrap_slider_js',
				'bootstrap',
				'wp-reset',
				'buy-me-a-coffee'
			);

			//dequeue styles and scripts that affect the layout in Squirrly SEO pages
			foreach ( $exclude as $name ) {
				wp_dequeue_style( $name );
			}
		}


	}

	public function isPluginThemeGlobalStyle( $name ) {
		if ( isset( $name ) && ( strpos( $name, 'wp-content/plugins' ) !== false || strpos( $name, 'wp-content/themes' ) !== false ) && strpos( $name, 'gutenberg' ) === false && strpos( $name, 'seo' ) === false && strpos( $name, 'monitor' ) === false && strpos( $name, 'debug' ) === false && strpos( $name, 'wc-admin' ) === false && strpos( $name, 'woocommerce' ) === false && strpos( $name, 'admin2020' ) === false && strpos( $name, 'a2020' ) === false && strpos( $name, 'admin-theme-js' ) === false && strpos( $name, 'admin-bar-app' ) === false && strpos( $name, 'uikit' ) === false && strpos( $name, 'ma-admin' ) === false && strpos( $name, 'uip' ) === false && strpos( $name, 'uipress' ) === false ) {
			return true;
		}

		return false;
	}
}
