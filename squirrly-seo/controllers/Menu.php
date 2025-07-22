<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Squirrly Menu Controller
 */
class SQ_Controllers_Menu extends SQ_Classes_FrontController {

	/** @var SQ_Models_Menu */
	public $model;

	/** @var string Post type from WP_Post */
	public $post_type;

	/**
	 * Menu Construct
	 */
	public function initMenu() {

		global $sq_fullscreen, $sq_setting_page;

		//Only on subsites
		if ( ! is_network_admin() ) {
			$sq_fullscreen = $sq_setting_page = false;

			add_action( 'admin_bar_menu', array( $this, 'hookTopmenuDashboard' ) );

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_use_backend' ) ) {
				add_action( 'admin_bar_menu', array( $this, 'hookTopmenuSquirrly' ), 91 );
			}

			add_action( 'do_meta_boxes', array( $this, 'addMetabox' ) );
			add_filter( 'sq_cloudmenu', array( $this, 'getCloudMenu' ), 10, 2 );

			//run compatibility check on Squirrly settings
			if ( SQ_Classes_Helpers_Tools::getIsset( 'page' ) ) {

				//Get all the Squirrly SEO menus
				$menus = $this->model->getMainMenu();
				//Get current accessed page
				$page = apply_filters( 'sq_page', SQ_Classes_Helpers_Tools::getValue( 'page' ) );

				if ( in_array( $page, array_keys( $menus ) ) ) {
					//Set if it's a Squirrly SEO Page
					$sq_setting_page = true;

					//Check if the menu requires full screen window
					if ( isset( $menus[ $page ]['fullscreen'] ) && $menus[ $page ]['fullscreen'] ) {
						$sq_fullscreen = true;
					}

					//dequeue other CSS when on the Squirrly Settings page
					add_action( 'admin_enqueue_scripts', array(
						SQ_Classes_ObjController::getClass( 'SQ_Models_Compatibility' ),
						'fixEnqueueErrors'
					), PHP_INT_MAX );
					add_action( 'admin_head', array( $this, 'setViewport' ), PHP_INT_MAX );
				}
			}

		}

		add_action( 'current_screen', function () {
			if ( in_array( get_current_screen()->id, array( 'plugins', 'plugins-network' ) ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Controllers_Uninstall' );
			}
		} );
	}

	/**
	 * Hook the Admin load
	 * Called from HookController on admin_init action
	 */
	public function hookInit() {

		// Initialize the plugin menu
		$this->initMenu();

		/* add the plugin menu in admin */
		if ( SQ_Classes_Helpers_Tools::userCan( 'manage_options' ) ) {
			try {
				//check if activated
				if ( get_transient( 'sq_activate' ) == 1 ) {
					// Delete the redirect transient
					delete_transient( 'sq_activate' );

					if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) {
						wp_redirect( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ) );
						die();
					}
				}


			} catch ( Exception $e ) {
				SQ_Classes_Error::setMessage( sprintf( esc_html__( "An error occurred during activation. If this error persists, please contact us at: %s", 'squirrly-seo' ), _SQ_SUPPORT_URL_ ) );
			}

		}

		//Add Squirrly SEO in  Posts list
		SQ_Classes_ObjController::getClass( 'SQ_Controllers_PostsList' );

		//Load the Auto-Indexing feature
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_indexnow' ) ) {
			SQ_Classes_ObjController::getClass( 'SQ_Controllers_Indexnow' );
		}

		//Hook the post save action
		SQ_Classes_ObjController::getClass( 'SQ_Controllers_Post' )->hookPost();

		//Show Squirrly SEO in Dashboard if connected to Squirrly Cloud
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) <> '' ) {
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_use_dashboard' ) ) {
				add_action( 'wp_dashboard_setup', array( $this, 'hookDashboardSetup' ) );
			}
		}

		//Add the Squirrly Class in all Squirrly SEO Pages
		add_filter( 'admin_body_class', array( $this, 'addSquirrlySettingsClass' ) );
		add_filter( 'sq_badge_new', array( $this, 'getNewFeatureBadge' ) );
		add_filter( 'sq_features', function ( $features ) {

			/*foreach ( $features as &$feature ) {
				if ( in_array( $feature['title'], array( 'Redirects', 'Keyword Research', 'Inner Links' ) ) ) {
					$feature['title'] .= ' ' . apply_filters( 'sq_badge_new', false );
				}
			}*/

			return $features;
		}, 11 );

	}

	/**
	 * Show the Dashboard link when Full Screen
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 *
	 * @return WP_Admin_Bar
	 */
	public function hookTopmenuDashboard( $wp_admin_bar ) {
		global $sq_fullscreen;

		if ( function_exists( 'is_user_logged_in' ) && is_user_logged_in() ) {
			if ( isset( $sq_fullscreen ) && $sq_fullscreen ) {
				$wp_admin_bar->add_node( array(
						'parent' => 'site-name',
						'id'     => 'dashboard',
						'title'  => esc_html__( "Dashboard" ),
						'href'   => admin_url(),
					) );
			}
		}

		return $wp_admin_bar;
	}

	/**
	 * Show the Squirrly Menu in toolbar
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 *
	 * @return WP_Admin_Bar
	 */
	public function hookTopmenuSquirrly( $wp_admin_bar ) {
		global $tag;

		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			return $wp_admin_bar;
		}

		if ( is_admin() ) {

			//Load the admin bar Squirrly SEO Menu
			if ( SQ_Classes_Helpers_Tools::userCan( 'edit_posts' ) ) {
				//Get count local SEO errors
				$errors = apply_filters( 'sq_seo_errors', 0 );

				$wp_admin_bar->add_node( array(
						'id'     => 'sq_toolbar',
						'title'  => '<span class="sq_logo" style="margin-right: 4px;margin-bottom: 4px;"></span>' . esc_html( apply_filters( 'sq_menu_name', _SQ_MENU_NAME_ ) ) . ( ( $errors ) ? '<span class="sq_errorcount">' . esc_html( $errors ) . '</span>' : '' ),
						'href'   => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ),
						'parent' => false
					) );

				$mainmenu = $this->model->getMainMenu();
				if ( ! empty( $mainmenu ) ) {
					foreach ( $mainmenu as $menuid => $item ) {

						//Check if the menu item is visible on the top
						if ( isset( $item['topmenu'] ) && ! $item['topmenu'] ) {
							continue;
						}

						if ( $menuid == 'sq_dashboard' && $errors ) {
							if ( is_rtl() ) {
								$item['title'] = '<span class="sq_errorcount" style="margin: 6px 0 0 0 !important; float: left !important;">' . $errors . '</span>' . $item['title'];
							} else {
								$item['title'] = $item['title'] . '<span class="sq_errorcount" style="margin: 6px 35px 0 0 !important;">' . $errors . '</span>';
							}
						}

						//make sure the user has the capabilities
						if ( SQ_Classes_Helpers_Tools::userCan( $item['capability'] ) ) {
							$wp_admin_bar->add_node( array(
									'id'     => $menuid,
									'title'  => $item['title'],
									'href'   => SQ_Classes_Helpers_Tools::getAdminUrl( $menuid ),
									'parent' => 'sq_toolbar'
								) );
							$tabs = $this->model->getTabs( $menuid );
							if ( ! empty( $tabs ) ) {
								foreach ( $tabs as $id => $tab ) {
									if ( isset( $tab['show'] ) && ! $tab['show'] ) {
										continue;
									}

									$array_id = explode( '/', $id );
									if ( count( (array) $array_id ) == 2 ) {
										$wp_admin_bar->add_node( array(
												'id'     => $menuid . str_replace( '/', '_', $id ),
												'title'  => $tab['title'],
												'href'   => SQ_Classes_Helpers_Tools::getAdminUrl( $array_id[0], $array_id[1] ),
												'parent' => $menuid
											) );
									}
								}
							}
						}
					}
				}

			}

			//Load the SEO Snippet
			$post           = get_post();
			$current_screen = get_current_screen();

			if ( ! $current_screen ) {
				return $wp_admin_bar;
			}

			if ( $post && ! SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSnippetEnable( $post ) ) {
				return $wp_admin_bar;
			}

			if ( $tag && ! SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSnippetEnable( $tag ) ) {
				return $wp_admin_bar;
			}

			if ( 'post' == $current_screen->base && ( $post_type_object = get_post_type_object( $post->post_type ) ) && ( SQ_Classes_Helpers_Tools::userCan( 'edit_post', $post->ID ) ) && ( $post_type_object->public ) ) {
				//ignore
			} elseif ( 'edit' == $current_screen->base && ( $post_type_object = get_post_type_object( $current_screen->post_type ) ) && ( $post_type_object->show_in_admin_bar ) && ! ( 'edit-' . $current_screen->post_type === $current_screen->id ) ) {
				//ignore
			} elseif ( 'term' == $current_screen->base && isset( $tag ) && is_object( $tag ) && ! is_wp_error( $tag ) && ( $tax = get_taxonomy( $tag->taxonomy ) ) && $tax->public ) {
			} else {
				return $wp_admin_bar;
			}

			//Add Squirrly Snippet block at the end of the article
			$this->model->addMeta( array(
					'sq_blocksnippet',
					esc_html__( "SEO Snippet", 'squirrly-seo' ),
					array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' ), 'init' ),
					null,
					'normal',
					'high'
				) );

			//Add
			$wp_admin_bar->add_node( array(
					'id'     => 'sq_bar_menu',
					'title'  => '<span class="sq_logo"></span> ' . esc_html__( "Custom SEO", 'squirrly-seo' ),
					'parent' => 'top-secondary',
				) );


			//Add snippet body
			$wp_admin_bar->add_menu( array(
					'id'     => 'sq_bar_submenu',
					'parent' => 'sq_bar_menu',
					'meta'   => array(
						'html'     => SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' )->init(),
						'tabindex' => PHP_INT_MAX,
					),
				) );
		}

		return $wp_admin_bar;
	}

	public function hookDashboardSetup() {
		wp_add_dashboard_widget( 'sq_dashboard_widget', esc_html__( "Squirrly SEO", 'squirrly-seo' ), array(
				SQ_Classes_ObjController::getClass( 'SQ_Controllers_Dashboard' ),
				'dashboard'
			) );

		// Move our widget to top.
		global $wp_meta_boxes;

		$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		if ( ! empty( $dashboard ) && isset( $wp_meta_boxes['dashboard']['normal']['core'] ) ) {
			$ours                                         = array( 'sq_dashboard_widget' => $dashboard['sq_dashboard_widget'] );
			$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $ours, $dashboard );
		}

	}

	/**
	 * Load Squirrly Menu on WP Multisite
	 * Called from HookController on network_admin_menu action
	 *
	 * @return void
	 */
	public function hookNetworkMenu() {
		//Check the Dev Kit settings
		SQ_Classes_ObjController::getClass( 'SQ_Classes_Helpers_DevKit' );
	}

	/**
	 * Creates the Setting menu in WordPress
	 * Called from HookController on admin_menu action
	 *
	 * @return void
	 */
	public function hookMenu() {
		//Hook the SEO Errors from Squirrly SEO Check
		//add_action('sq_seo_errors', array($this, 'getSEOErrors'));

		//Check the Dev Kit settings
		SQ_Classes_ObjController::getClass( 'SQ_Classes_Helpers_DevKit' );

		//Get all the post types
		$this->post_type = SQ_Classes_Helpers_Tools::getOption( 'sq_post_types' );
		//Get count local SEO errors
		$errors = apply_filters( 'sq_seo_errors', 0 );

		///////////////
		$this->model->addMenu( array(
				apply_filters( 'sq_menu_name', _SQ_MENU_NAME_ ),
				apply_filters( 'sq_menu_name', _SQ_MENU_NAME_ ) . ( ( $errors ) ? '<span class="sq_errorcount">' . $errors . '</span>' : '' ),
				'edit_posts',
				'sq_dashboard',
				null,
				apply_filters( 'sq_logo', _SQ_ASSETS_URL_ . 'img/logo_24.png' )
			) );

		//Load the Squirrly Menu
		$mainmenu = $this->model->getMainMenu();
		if ( ! empty( $mainmenu ) ) {
			foreach ( $mainmenu as $name => $item ) {

				//Check if the menu is set to show on the left side
				if ( isset( $item['leftmenu'] ) && ! $item['leftmenu'] && SQ_Classes_Helpers_Tools::getValue( 'page', '' ) <> $name ) {
					continue;
				}

				//Add the page
				$this->model->addSubmenu( array(
						$item['parent'],
						$item['title'],
						$item['title'],
						$item['capability'],
						$name,
						$item['function'],
					) );

			}

			//Update the external links in the menu
			global $submenu;
			if ( ! empty( $submenu['sq_dashboard'] ) ) {
				foreach ( $submenu['sq_dashboard'] as &$item ) {
					if ( isset( $mainmenu[ $item[2] ]['href'] ) && $mainmenu[ $item[2] ]['href'] ) {
						if ( parse_url( $mainmenu[ $item[2] ]['href'], PHP_URL_HOST ) !== parse_url( home_url(), PHP_URL_HOST ) ) {
							$item[0] .= '<i class="dashicons dashicons-external" style="font-size:12px;vertical-align:-2px;height:10px;"></i>';
						}
						$item[2] = $mainmenu[ $item[2] ]['href'];
					}
				}
			}
		}
	}

	/**
	 * Add Post Editor Meta Box
	 * Load Squirrly Live Assistant
	 */
	public function addMetabox() {

		if ( ! apply_filters( 'sq_load_sla', true ) || ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			return;
		}

		//Add Live Assistant For Selected Post Types
		$types = get_post_types( array( 'public' => true ) );
		if ( ! empty( $types ) ) {
			foreach ( $types as $type ) {
				if ( SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSLAEnable( $type ) ) {
					//Load the SLA in Post
					$this->model->addMeta( array(
							'postsquirrly',
							esc_html__( 'Squirrly Live Assistant', 'squirrly-seo' ),
							array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Post' ), 'init' ),
							$type,
							'side',
							'high'
						) );
				}
			}

		}
	}

	/**
	 * Add the Squirrly Setttings Class in all Squirrly SEO Pages
	 * Used for personal layout
	 *
	 * @param  $classes
	 *
	 * @return string
	 */
	public function addSquirrlySettingsClass( $classes ) {
		global $sq_setting_page;

		if ( isset( $sq_setting_page ) && $sq_setting_page ) {
			$classes = "$classes squirrly-seo-settings";
		}

		return $classes;
	}

	/**
	 * Hook the Head
	 */
	public function hookHead() {
		global $sq_fullscreen, $sq_setting_page;

		//Load settings only in the Squirrly Menu
		if ( isset( $sq_setting_page ) && $sq_setting_page ) {
			echo '<script type="text/javascript" src="//www.google.com/jsapi"></script>';
			echo '<script>google.load("visualization", "1.0", {packages: ["corechart"]});</script>';

			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-reboot' );

			if ( is_rtl() ) {
				SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'popper' );
				SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap.rtl' );
				SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'rtl' );
			} else {
				SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap' );
			}

			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'popper' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-select' );

			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'switchery' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );

			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'assistant' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );

			if ( isset( $sq_fullscreen ) && $sq_fullscreen ) {
				SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fullwidth' );
			}
		}

		//Load the Squirrly Logo on all Dashboard
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'logo' );

	}

	/**
	 * Set the viewport for a google Squirrly Settings layout
	 */
	function setViewport() {
		global $sq_setting_page;

		if ( isset( $sq_setting_page ) && $sq_setting_page ) {
			echo '<meta name="viewport" content="width=780">';
		}
	}


	/**
	 * Count the SEO Errors from SEO Goals
	 *
	 * @return mixed
	 */
	public function getSEOErrors() {
		return SQ_Classes_ObjController::getClass( 'SQ_Controllers_CheckSeo' )->setCategory( 'sq_dashboard' )->getErrorsCount();
	}

	/**
	 * Add the new badge for new features
	 *
	 * @return string
	 */
	public function getNewFeatureBadge() {
		return '<span class="sq_new_feature_badge" style="color: #c094ff;  font-size: 10px; font-weight: normal; padding: 0 5px;">' . esc_html__( 'NEW' ) . '</span>';
	}


	/**
	 * Set the cloud.squirrly.co menu based on the client rights
	 *
	 * @param  $url
	 * @param  $path
	 *
	 * @return string
	 */
	public function getCloudMenu( $url, $path ) {
		if ( function_exists( 'wp_get_current_user' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) ) {
			if ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_account_info' ) && SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
				$url .= 'login/?token=' . SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) . '&user_url=' . apply_filters( 'sq_homeurl', get_bloginfo( 'url' ) ) . '&redirect_to=' . _SQ_DASH_URL_ . 'user/' . $path;
			}
		}

		return esc_url( $url );
	}

}
