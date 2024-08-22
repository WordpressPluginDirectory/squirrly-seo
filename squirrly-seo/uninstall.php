<?php defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Called on plugin uninstall
 */
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

try {

	/* Call config files */
	include dirname( __FILE__ ) . '/config/config.php';
	include dirname( __FILE__ ) . '/config/paths.php';
	include_once _SQ_CLASSES_DIR_ . 'ObjController.php';

	/* Delete the record from database */
	SQ_Classes_ObjController::getClass( 'SQ_Classes_Helpers_Tools' );
	if ( SQ_Classes_Helpers_Tools::getOption( 'sq_complete_uninstall' ) ) {
		delete_option( SQ_OPTION );
		delete_option( SQ_ML_PATTERNS );
		delete_option( SQ_TASKS );

		global $wpdb;
		$wpdb->query( "DROP TABLE IF EXISTS `" . $wpdb->prefix . _SQ_DB_ . "`" );
	}

} catch ( Exception $e ) {
}
