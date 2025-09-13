<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Frontend extends SQ_Classes_FrontController {

	/**
	 *
	 *
	 * @var SQ_Models_Frontend
	 */
	public $model;

	public function __construct() {

		//check again not to load in admin
		if ( is_admin() || is_network_admin() || SQ_Classes_Helpers_Tools::isAjax() ) {
			return;
		}

		//load the hooks
		parent::__construct();

		//For favicon and Robots
		$this->hookCheckFiles();

		/* Check if the sitemap is on and Load the Sitemap */
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ) {
			add_filter( 'wp_sitemaps_enabled', '__return_false' );
			SQ_Classes_ObjController::getClass( 'SQ_Controllers_Sitemaps' );
		}

		//Check cache plugin compatibility
		SQ_Classes_ObjController::getClass( 'SQ_Models_Compatibility' )->checkCompatibility();

		//Check if late loading is on
		if ( apply_filters( 'sq_lateloading', SQ_Classes_Helpers_Tools::getOption( 'sq_laterload' ) ) ) {
			//Hook the buffer on both actions in case one fails
			add_action( 'template_redirect', array( $this, 'hookBuffer' ) );
		} else {
			//Set the post so that Squirrly will know which one to process
			add_action( 'template_redirect', array( $this, 'hookBuffer' ), 9 );
		}

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_links' ) ) {

			//Check if attachment to image redirect is needed
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_attachment_redirect' ) ) {
				add_action( 'template_redirect', array( $this->model, 'redirectAttachments' ), 10 );
			}

		}
	}

	/**
	 * HOOK THE BUFFER
	 */
	public function hookBuffer() {
		//Set the current post
		$this->model->setPost();

		//If Squirrly Crawler, no cache in header
		add_filter( 'sq_buffer', function ( $buffer ) {

			if ( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] == 'https://www.squirrly.co' ) {
				header( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0" );
				header( "Cache-Control: post-check=0, pre-check=0", false );
				header( "Pragma: no-cache" );
			}

			return $buffer;
		} );

		//If load buffer is set, start the buffer
		if ( apply_filters( 'sq_load_buffer', true ) ) {
			$this->model->startBuffer();
		}

		//Load the frontend CSS from Squirrly SEO
		if ( apply_filters( 'sq_load_css', true ) ) {
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'frontend' );
		}

	}

	/**
	 * Called after plugins are loaded
	 */
	public function hookCheckFiles() {
		//Check for sitemap and robots
		if ( $basename = $this->getFileName( $_SERVER['REQUEST_URI'] ) ) {

			//show the robots rules
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ) == 1 ) {
				if ( $basename == "robots.txt" ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Robots' );
					apply_filters( 'sq_robots', false );
					exit();
				}
			}

			//show the robots rules
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_llms' ) == 1 ) {
				if ( $basename == "llms.txt" ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Llms' );
					apply_filters( 'sq_llms', false );
					exit();
				}
			}

			//Show the code for Auto-Indexing
			if ( SQ_Classes_Helpers_Tools::getOption( 'indexnow_key' ) <> '' ) {
				if ( $basename == SQ_Classes_Helpers_Tools::getOption( 'indexnow_key' ) . ".txt" ) {
					echo SQ_Classes_Helpers_Tools::getOption( 'indexnow_key' );
					exit();
				}
			}

			//Show the favicon icons
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ) && SQ_Classes_Helpers_Tools::getOption( 'favicon' ) <> '' ) {
				if ( $basename == "favicon.ico" ) {
					SQ_Classes_Helpers_Tools::setHeader( 'ico' );
					@readfile( _SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) );
					exit();
				} elseif ( $basename == "touch-icon.png" ) {
					SQ_Classes_Helpers_Tools::setHeader( 'png' );
					$appleSizes = preg_split( '/[,]+/', _SQ_MOBILE_ICON_SIZES );
					if ( file_exists( _SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) . end( $appleSizes ) ) ) {
						@readfile( _SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) . end( $appleSizes ) );
					} else {
						@readfile( _SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) );
					}
					exit();
				} else {
					$appleSizes = preg_split( '/[,]+/', _SQ_MOBILE_ICON_SIZES );
					foreach ( $appleSizes as $appleSize ) {
						if ( $basename == "touch-icon$appleSize.png" ) {
							SQ_Classes_Helpers_Tools::setHeader( 'png' );
							@readfile( _SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption( 'favicon' ) . $appleSize );
							exit();
						}
					}
				}
			}

		}

	}

	/**
	 * Hook the footer function
	 */
	public function hookFrontfooter() {
		//Show the analytics code in footer
		echo $this->model->getFooter();
	}

	/**
	 * Get the File Name if it's a file in URL
	 *
	 * @param null $url
	 *
	 * @return bool|string|null
	 */
	public function getFileName( $url = null ) {
		if ( isset( $url ) && $url <> '' ) {
			$url = basename( $url );
			if ( strpos( $url, '?' ) <> '' ) {
				$url = substr( $url, 0, strpos( $url, '?' ) );
			}

			$files = array(
				'ico',
				'icon',
				'txt',
				'jpg',
				'jpeg',
				'png',
				'bmp',
				'gif',
				'webp',
				'css',
				'scss',
				'js',
				'pdf',
				'doc',
				'docx',
				'csv',
				'xls',
				'xslx',
				'mp4',
				'mpeg',
				'zip',
				'rar'
			);

			if ( strrpos( $url, '.' ) !== false ) {
				$ext = substr( $url, strrpos( $url, '.' ) + 1 );
				if ( in_array( $ext, $files ) ) {
					return $url;
				}
			}
		}

		return false;

	}
}
