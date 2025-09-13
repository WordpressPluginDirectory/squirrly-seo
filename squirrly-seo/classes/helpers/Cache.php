<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Classes_Helpers_Cache {
	/** @var string cache type */
	private $mode = 'db';

	/** @var WP_Filesystem_Base */
	private $filesystem;

	/** @var string Prefix of the filename for cache. */
	const CACHE_KEY_PREFIX = 'sq_';

	/** @var string cache name */
	const CACHE_NAME = 'squirrly';

	public function __construct() {
		//check if sitemap cache is activated
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_do_cache' ) ) {
			//listen Squirrly
			add_action( 'sq_save_settings_after', array( $this, 'listenSQHooks' ) );
			//listen WP
			add_action( 'save_post', array( $this, 'listenWPHooks' ), 10, 1 );
			add_action( 'delete_post', array( $this, 'listenWPHooks' ), 10, 1 );
			add_action( 'created_term', array( $this, 'listenWPHooks' ), 10, 1 );
			add_action( 'edited_terms', array( $this, 'listenWPHooks' ), 10, 1 );
			add_action( 'delete_term', array( $this, 'listenWPHooks' ), 10, 1 );
		}
	}

	/**
	 * Empty the cache on Squirrly Settings Save
	 *
	 * @param array $params
	 *
	 * @return void
	 */
	public function listenSQHooks( $params ) {

		$this->invalidateCache();
	}

	/**
	 * Empty the cache on WordPress hooks
	 *
	 * @param string $param
	 *
	 * @return void
	 */
	public function listenWPHooks( $param ) {
		$this->invalidateCache();
	}

	/**
	 * Load cache mode and filesystem
	 *
	 * @return $this
	 */
	public function initCache() {
		$this->filesystem = SQ_Classes_Helpers_Tools::initFilesystem();
		$this->mode       = $this->isWritable() ? 'file' : 'db';

		//Change sitemap caching mode (can be "file" or "db").
		$this->mode = apply_filters( 'sq_cache_mode', $this->mode );

		return $this;
	}

	/**
	 * Check if the cache directory is writable
	 *
	 * @return bool
	 */
	public function isWritable() {
		if ( is_null( $this->filesystem ) ) {
			return false;
		}

		$folder_path = $this->getCacheDirectory();
		$test_file   = $folder_path . $this->getKey();

		// If folder doesn't exist?
		if ( ! $this->filesystem->exists( $folder_path ) ) {
			// Can we create the folder?
			// returns true if yes and false if not.
			$permissions = ( defined( 'FS_CHMOD_DIR' ) ) ? FS_CHMOD_DIR : 0755;

			return $this->filesystem->mkdir( $folder_path, $permissions );
		}

		// Does the file exist?
		// File exists. Is it writable?
		if ( $this->filesystem->exists( $test_file ) && ! $this->filesystem->is_writable( $test_file ) ) {
			// Nope, it's not writable.
			return false;
		}

		// Folder exists, but is it actually writable?
		return $this->filesystem->is_writable( $folder_path );
	}

	/**
	 * Get the cached sitemap.
	 *
	 * @param string $type Sitemap type.
	 * @param int $page Page number to retrieve.
	 * @param bool $html Is HTML sitemap.
	 *
	 * @return false|string false on no cache found otherwise sitemap file.
	 */
	public function getSitemap( $type, $page, $html = false ) {

		//load cache mode
		$this->initCache();

		$filename = $this->getKey( $type, $page, $html );

		if ( false === $filename || is_null( $this->filesystem ) ) {
			return false;
		}

		$path = $this->getCacheDirectory() . $filename;
		if ( 'file' === $this->mode && $this->filesystem->exists( $path ) ) {
			return $this->filesystem->get_contents( $path );
		}

		$filename = "sitemap_{$type}_$filename";
		$sitemap  = get_transient( $filename );

		return maybe_unserialize( $sitemap );
	}

	/**
	 * save the sitemap to cache.
	 *
	 * @param string $type Sitemap type.
	 * @param int $page Page number to store.
	 * @param string $sitemap Sitemap body to store.
	 * @param bool $html Is HTML sitemap.
	 *
	 * @return boolean
	 */
	public function saveSitemap( $type, $page, $sitemap, $html = false ) {

		//load cache mode
		$this->initCache();

		$filename = $this->getKey( $type, $page, $html );

		if ( false === $filename || is_null( $this->filesystem ) ) {
			return false;
		}

		if ( 'file' === $this->mode ) {

			$stored = $this->filesystem->put_contents( $this->getCacheDirectory() . $filename, $sitemap, FS_CHMOD_FILE );

			if ( true === $stored ) {
				$this->cachedFiles( $filename, $type );

				return $stored;
			}
		}

		$filename = "sitemap_{$type}_$filename";

		return set_transient( $filename, maybe_serialize( $sitemap ), DAY_IN_SECONDS * 30 );
	}

	/**
	 * Get filename for sitemap.
	 *
	 * @param null|string $type The type to get the key for. Null or '1' for index cache.
	 * @param int $page The page of cache to get the key for.
	 *
	 * @return boolean|string The key where the cache is stored on. False if the key could not be generated.
	 */
	private function getKey( $type = null, $page = 1, $html = false ) {
		$type = is_null( $type ) ? '1' : $type;

		return self::CACHE_KEY_PREFIX . md5( "{$type}_{$page}_" . home_url() ) . '.' . ( $html ? 'html' : 'xml' );

	}

	/**
	 * Get cache directory.
	 *
	 * @return string
	 */
	public function getCacheDirectory() {
		//set default cache directory
		$default = WP_CONTENT_DIR . '/cache/' . self::CACHE_NAME;

		if ( ! $this->filesystem->is_dir( $default ) ) {
			@wp_mkdir_p( $default );
		}

		$default = rtrim( $default, '/' ) . '/sitemap';

		/**
		 * Filter XML sitemap cache directory.
		 *
		 * @param string $unsigned Default cache directory
		 */
		$filtered = apply_filters( 'sq_cache_directory', $default );

		if ( ! is_string( $filtered ) || '' === $filtered ) {
			$filtered = $default;
		}

		return trailingslashit( $filtered );
	}

	/**
	 * Read/Write cached files.
	 *
	 * @param mixed $value Pass null to get option,
	 *                       Pass false to delete option,
	 *                       Pass value to update option.
	 * @param string $type Sitemap type.
	 *
	 * @return mixed
	 */
	public function cachedFiles( $value = null, $type = '' ) {

		if ( $type <> '' && $value ) {
			$options           = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_cache' );
			$options[ $value ] = $type;
			SQ_Classes_Helpers_Tools::saveOptions( 'sq_sitemap_cache', $options );
		} elseif ( $value === false ) {
			SQ_Classes_Helpers_Tools::saveOptions( 'sq_sitemap_cache', array() );
		} elseif ( $value ) {
			SQ_Classes_Helpers_Tools::saveOptions( 'sq_sitemap_cache', $value );
		}

		return SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_cache' );

	}

	/**
	 * Invalidate sitemap cache.
	 *
	 * @param null|string $type The type to get the key for. Null for all caches.
	 */
	public function invalidateCache( $type = null ) {

		if ( ! apply_filters( 'sq_invalidate_cache_before', true, $type ) ) {
			return;
		}

		//load cache mode
		$this->initCache();

		if ( is_null( $this->filesystem ) ) {
			return;
		}

		$directory = $this->getCacheDirectory();

		if ( ! $type ) {

			$this->filesystem->delete( $directory, true );
			wp_mkdir_p( $directory );

			$this->clearTransients();
			$this->cachedFiles( false );

			SQ_Classes_Helpers_Tools::emptyCache();

			return;
		}

		$data  = [];
		$files = $this->cachedFiles();

		foreach ( $files as $file => $sitemap_type ) {
			if ( $type !== $sitemap_type ) {
				$data[ $file ] = $sitemap_type;
				continue;
			}

			$this->filesystem->delete( $directory . $file );
		}

		$this->clearTransients( $type );
		$this->cachedFiles( $data );
		SQ_Classes_Helpers_Tools::emptyCache();

		do_action( 'sq_invalidate_cache_after', $type );
	}

	/**
	 * Reset ALL transient caches.
	 *
	 * @param null|string $type The type to get the key for. Null for all caches.
	 */
	private function clearTransients( $type = null ) {
		global $wpdb;

		if ( is_string( $type ) ) {
			$transient = esc_attr( '_transient_sitemap_' . ( is_null( $type ) ? '' : $type ) . '%' );
			$sql       = "DELETE FROM $wpdb->options WHERE `option_name` LIKE '%s'";
			$wpdb->query( $wpdb->prepare( $sql, $transient ) );

			$transient = esc_attr( '_transient_timeout_sitemap_' . ( is_null( $type ) ? '' : $type ) . '%' );
			$sql       = "DELETE FROM $wpdb->options WHERE `option_name` LIKE '%s'";
			$wpdb->query( $wpdb->prepare( $sql, $transient ) );
		}

	}
}
