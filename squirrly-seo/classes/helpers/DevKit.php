<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Classes_Helpers_DevKit {

	public static $plugin;
	public static $options;
	public static $package;

	public function __construct() {

		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_auto_devkit' ) ) {

			if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_name' ) <> '' ) {

				$request_uri = false;

				if ( isset( $_SERVER['REQUEST_URI'] ) ) {
					$request_uri = esc_url_raw( $_SERVER['REQUEST_URI'] );
				}

				if ( $request_uri && function_exists( 'get_plugin_data' ) ) {
					if ( strpos( $request_uri, '/plugins.php' ) !== false ) {
						$data = get_plugin_data( _SQ_ROOT_DIR_ . 'squirrly.php' );
						if ( isset( $data['Name'] ) ) {
							self::$plugin['name'] = $data['Name'];
							add_filter( 'pre_kses', array( $this, 'changeString' ), 1, 1 );
						}
					}
				}
			}

			//Hook DevKit options
			if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_api' ) ) {
				add_filter( 'admin_head', array( $this, 'hookHead' ) );
				add_filter( 'sq_menu', array( $this, 'manageMenu' ) );
				add_filter( 'sq_features', array( $this, 'manageFeatures' ) );
				add_filter( 'sq_logo', array( $this, 'getCustomLogo' ) );
				add_filter( 'sq_name', array( $this, 'getCustomName' ) );
				add_filter( 'sq_menu_name', array( $this, 'getCustomMenuName' ) );
				add_filter( 'sq_audit_success_task', array( $this, 'getCustomAuditSuccessTask' ) );
				add_filter( 'sq_audit_fail_task', array( $this, 'getCustomAuditFailTask' ) );
				add_filter( 'sq_seo_errors', array( $this, 'getSEOErrors' ) );
				add_filter( 'sq_menu_visible', array( $this, 'getDevKitMenuVisible' ), 11, 2 );
			}
		}
	}

	/**
	 * Show the devkit menu from the main website on wp multisite
	 *
	 * @param  $value
	 * @param  $key
	 *
	 * @return bool
	 */
	public function getDevKitMenuVisible( $value, $key ) {

		if ( isset( self::$options['menu'][ $key ] ) ) {
			return self::$options['menu'][ $key ];
		}

		return true;
	}

	//Check if Next SEO Goals are active
	public function getSEOErrors( $errors ) {
		if ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seogoals' ) ) {
			return $errors;
		}

		return 0;
	}

	public static function getOptions() {
		if ( is_multisite() ) {
			self::$options = json_decode( get_blog_option( get_main_site_id(), SQ_OPTION ), true );
		} else {
			self::$options = json_decode( get_option( SQ_OPTION ), true );
		}

		return self::$options;
	}

	/**
	 * Get the option from database
	 *
	 * @param  $key
	 *
	 * @return mixed
	 */
	public static function getOption( $key ) {
		if ( ! isset( self::$options[ $key ] ) ) {
			self::$options = self::getOptions();

			if ( ! isset( self::$options[ $key ] ) ) {
				self::$options[ $key ] = false;
			}
		}

		return self::$options[ $key ];
	}

	/**
	 * Customize the Audit task
	 *
	 * @param  $task
	 *
	 * @return mixed
	 */
	public function getCustomAuditSuccessTask( $task ) {

		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_audit_success' ) ) {
			if ( $customTask = SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_audit_success' ) ) {
				foreach ( $customTask as $key => $value ) {
					if ( $value <> '' || $value === false ) {
						$task->$key = stripslashes( $value );
					}
				}
			}
		}

		return $task;
	}

	/**
	 * Customize the Audit task
	 *
	 * @param  $task
	 *
	 * @return mixed
	 */
	public function getCustomAuditFailTask( $task ) {

		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_audit_fail' ) ) {
			if ( $customTask = SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_audit_fail' ) ) {
				foreach ( $customTask as $key => $value ) {
					if ( $value <> '' || $value === false ) {
						$task->$key = stripslashes( $value );
					}
				}
			}
		}

		return $task;
	}

	/**
	 * Hook the head and show the devkit solutions
	 *
	 * @return string
	 */
	public function hookHead() {
		//Dev Kit images
		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_logo' ) ) {
			echo '<style>.sq_logo{background-image:url("' . SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_logo' ) . '") !important;}#sq_blocksnippet .postbox-header h2:before,li.toplevel_page_sq_dashboard .wp-menu-image:before{background-image:url("' . SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_logo' ) . '") !important;}.components-squirrly-icon img{content:url("' . SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_logo' ) . '") !important;}.menu-top.toplevel_page_sq_dashboard .wp-menu-image:before {content: " ";width: 20px !important;height: 20px !important;display: inline-block;vertical-align: middle !important;line-height: inherit;background-repeat: no-repeat;background-position: center;background-size: 100%;}li.toplevel_page_sq_dashboard .wp-menu-image img{display: none !important;}</style>';
		}

		return '';
	}

	/**
	 * Change the Squirrly SEO logo in DevKit
	 *
	 * @param  $logo
	 *
	 * @return mixed
	 */
	public function getCustomLogo( $logo ) {

		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_logo' ) ) {
			$logo = SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_logo' );
		}

		return $logo;
	}

	/**
	 * Get Plugin Custom Name
	 *
	 * @param  $name
	 *
	 * @return string
	 */
	public function getCustomName( $name ) {

		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_name' ) ) {
			$name = SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_name' );
		}

		return $name;
	}

	/**
	 * Get Plugin Custom Menu Name
	 *
	 * @param  $name
	 *
	 * @return string
	 */
	public function getCustomMenuName( $name ) {

		if ( SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_menu_name' ) ) {
			$name = SQ_Classes_Helpers_DevKit::getOption( 'sq_devkit_menu_name' );
		}

		return $name;
	}

	//Change the features
	public function manageFeatures( $features ) {
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_account_info' ) ) {
			unset( $features[0] ); //remove the Cloud App features
		}

		return $features;
	}

	/**
	 * Manage the menu visibility
	 */
	public function manageMenu( $menu ) {
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ) ) {
			$menu['sq_onboarding']['leftmenu'] = false;
			$menu['sq_onboarding']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ) ) {
			$menu['sq_audits']['leftmenu'] = false;
			$menu['sq_audits']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ) ) {
			$menu['sq_rankings']['leftmenu'] = false;
			$menu['sq_rankings']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_focuspages' ) ) {
			$menu['sq_focuspages']['leftmenu'] = false;
			$menu['sq_focuspages']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_bulkseo' ) ) {
			$menu['sq_bulkseo']['leftmenu'] = false;
			$menu['sq_bulkseo']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ) ) {
			$menu['sq_assistant']['leftmenu'] = false;
			$menu['sq_assistant']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_research' ) ) {
			$menu['sq_research']['leftmenu'] = false;
			$menu['sq_research']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_account_info' ) ) {
			$menu['sq_account']['leftmenu'] = false;
			$menu['sq_account']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_indexnow' ) ) {
			$menu['sq_indexnow']['leftmenu'] = false;
			$menu['sq_indexnow']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_redirects' ) ) {
			$menu['sq_redirects']['leftmenu'] = false;
			$menu['sq_redirects']['topmenu']  = false;
		}
		if ( ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_reusables' ) ) {
			$menu['sq_jsonld']['leftmenu'] = false;
			$menu['sq_jsonld']['topmenu']  = false;
		}

		return $menu;
	}

	/**
	 * Check if Dev Kit is installed
	 *
	 * @return bool
	 */
	public function checkPluginData() {

		try {
			/** @var WP_Filesystem_Base $wp_filesystem */
			$wp_filesystem = SQ_Classes_Helpers_Tools::initFilesystem();

			$package_file = _SQ_ROOT_DIR_ . 'package.json';
			if ( ! $wp_filesystem->exists( $package_file ) ) {
				return false;
			}

			/* load configuration blocks data from core config files */
			$config = json_decode( $wp_filesystem->get_contents( $package_file ), 1 );
			if ( isset( $config['package'] ) ) {
				self::$package = $config['package'];

				if ( isset( self::$package['settings'] ) && ! empty( SQ_Classes_Helpers_Tools::$options ) && function_exists( 'array_replace_recursive' ) ) {
					SQ_Classes_Helpers_Tools::getOptions();
					SQ_Classes_Helpers_Tools::$options = array_replace_recursive( (array) SQ_Classes_Helpers_Tools::$options, (array) self::$package['settings'] );
					SQ_Classes_Helpers_Tools::saveOptions();
				}

				//remove the package after activation
				$wp_filesystem->delete( $package_file );
			}

		} catch ( Exception $e ) {
		}

		return true;
	}

	/**
	 * Change the plugin name
	 *
	 * @param  $string
	 *
	 * @return mixed
	 */
	public function changeString( $string ) {
		if ( isset( self::$plugin['name'] ) ) {
			return str_replace( self::$plugin['name'], apply_filters( 'sq_name', self::$plugin['name'] ), $string );
		}

		return $string;
	}

	//Get the package info in case of custom details
	public function getPackageInfo( $key ) {
		if ( isset( self::$package[ $key ] ) ) {
			return self::$package[ $key ];
		}

		return false;
	}

}
