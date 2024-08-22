<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Classes_Error extends SQ_Classes_FrontController {

	/**
	 *
	 *
	 * @var array
	 */
	private static $errors = array();

	public function __construct() {
		parent::__construct();

		if ( $error = SQ_Classes_Helpers_Tools::getOption( 'sq_message' ) ) {
			self::$errors[] = $error;
			SQ_Classes_Helpers_Tools::saveOptions( 'sq_message', false );
		}

		add_action( 'sq_notices', array( 'SQ_Classes_Error', 'hookNotices' ) );
	}

	/**
	 * Get the error message
	 *
	 * @return int
	 */
	public static function getError() {
		if ( count( self::$errors ) > 0 ) {
			return self::$errors[0]['text'];
		}

		return false;
	}

	/**
	 * Clear all the Errors from Squirrly SEO
	 */
	public static function clearErrors() {
		self::$errors = array();
	}

	/**
	 * Show the error in wrodpress
	 *
	 * @param string $error
	 * @param string $type
	 */
	public static function setError( $error = '', $type = 'error' ) {
		self::$errors[] = array(
			'type' => $type,
			'text' => $error
		);
	}

	/**
	 * Set a success message
	 *
	 * @param string $message
	 */
	public static function setMessage( $message = '' ) {
		self::$errors[] = array(
			'type' => 'success',
			'text' => $message
		);
	}

	/**
	 * Save the message and show it when page loads
	 *
	 * @param $error
	 * @param $type
	 *
	 * @return void
	 */
	public static function saveMessage( $error = '', $type = 'notice' ) {
		SQ_Classes_Helpers_Tools::saveOptions( 'sq_message', array(
			'type' => $type,
			'text' => $error
		) );
	}

	/**
	 * Check if there is a Squirrly Error triggered
	 *
	 * @return bool
	 */
	public static function isError() {
		if ( ! empty( self::$errors ) ) {
			foreach ( self::$errors as $error ) {
				if ( $error['type'] <> 'success' ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * This hook will show the error in WP header
	 */
	public static function hookNotices() {
		if ( is_array( self::$errors ) && ! empty( self::$errors ) ) {
			foreach ( self::$errors as $error ) {

				switch ( $error['type'] ) {
					case 'notice':
						self::showNotices( $error['text'] );
						break;

					default:
						self::showError( $error['text'], $error['type'] );
				}
			}
		}
	}

	/**
	 * Show the notices to WP
	 *
	 * @param  $message
	 * @param string $type
	 *
	 * @return string
	 */
	public static function showNotices( $message, $type = 'notices' ) {
		if ( file_exists( _SQ_THEME_DIR_ . 'Notices.php' ) ) {
			ob_start();
			include _SQ_THEME_DIR_ . 'Notices.php';
			$message = ob_get_contents();
			ob_end_clean();
		}

		return (string) $message;
	}

	/**
	 * Show the notices to WP
	 *
	 * @param string $message
	 * @param string $type
	 *
	 * return void
	 */
	public static function showError( $message, $type ) {
		if ( file_exists( _SQ_THEME_DIR_ . 'Notices.php' ) ) {
			include _SQ_THEME_DIR_ . 'Notices.php';
		}
	}


}
