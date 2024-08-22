<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Rollback {

	/**
	 * @var string Package URL.
	 */
	protected $package_url;

	/**
	 * @var string Package URL.
	 */
	protected $version;

	/**
	 * @var string Plugin name.
	 */
	protected $plugin_name;

	/**
	 * @var string Plugin slug.
	 */
	protected $plugin_slug;

	public function set_plugin( $args = array() ) {
		foreach ( $args as $key => $value ) {
			$this->{$key} = $value;
		}

		return $this;
	}

	/**
	 * Print inline style.
	 *
	 * @access private
	 */
	private function print_inline_style() {
		?>
        <style>
            .wrap {
                overflow: hidden;
            }

            h1 {
                background: #0a9b8f;
                text-align: center;
                color: #fff !important;
                padding: 50px !important;
                text-transform: uppercase;
                letter-spacing: 1px;
                line-height: 30px;
            }

            h1 img {
                max-width: 300px;
                display: block;
                margin: auto auto 50px;
            }
        </style>
		<?php
	}

	/**
	 * Apply package.
	 *
	 * Change the plugin data when WordPress checks for updates. This method
	 * modifies package data to update the plugin from a specific URL containing
	 * the version package.
	 */
	protected function apply_package() {
		$update_plugins = get_site_transient( 'update_plugins' );
		if ( ! is_object( $update_plugins ) ) {
			$update_plugins = new \stdClass();
		}

		$plugin_info              = new \stdClass();
		$plugin_info->new_version = $this->version;
		$plugin_info->slug        = $this->plugin_slug;
		$plugin_info->package     = $this->package_url;
		$plugin_info->url         = 'https://squirrly.co/';

		$update_plugins->response[ $this->plugin_name ] = $plugin_info;

		set_site_transient( 'update_plugins', $update_plugins );
	}

	/**
	 * Upgrade.
	 *
	 * @access protected
	 */
	protected function upgrade() {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

		$this->print_inline_style();
		$upgrader = new \Plugin_Upgrader( new \WP_Ajax_Upgrader_Skin() );
		$upgrader->upgrade( $this->plugin_name );
	}

	/**
	 * Run.
	 *
	 * Rollback to previous versions.
	 */
	public function run() {
		$this->apply_package();
		$this->upgrade();
	}

	/**
	 * Install a plugin
	 *
	 * @param array $args
	 *
	 * @return bool|WP_Error
	 */
	public function install( $args ) {

		//includes necessary for Plugin_Upgrader and Plugin_Installer_Skin
		include_once( ABSPATH . 'wp-admin/includes/file.php' );
		include_once( ABSPATH . 'wp-admin/includes/misc.php' );
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

		$this->set_plugin( $args )->apply_package();

		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		return $upgrader->install( $this->package_url, array( 'overwrite_package' => true ) );

	}

	/**
	 * Activate the installed plugin
	 *
	 * @param $plugin
	 *
	 * @return null
	 */
	public function activate( $plugin ) {

		$plugin  = trim( $plugin );
		$current = get_option( 'active_plugins' );
		$plugin  = plugin_basename( $plugin );

		if ( $plugin <> '' && ! in_array( $plugin, $current ) ) {

			$current[] = $plugin;
			sort( $current );

			try {
				do_action( 'activate_plugin', $plugin, false );
				update_option( 'active_plugins', $current );
				do_action( 'activate_' . $plugin );
				do_action( 'activated_plugin', $plugin, false );
			} catch ( Exception $e ) {
			}
		}

		return null;
	}

}
