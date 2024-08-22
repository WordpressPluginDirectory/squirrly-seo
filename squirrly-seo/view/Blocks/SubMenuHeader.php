<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Menu Header Block view
 *
 * Called together with SubMenu Block
 */
?>
<?php
$cnt  = 0;
$page = SQ_Classes_Helpers_Tools::getValue( 'page' );
$tabs = SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getTabs( $page );
if ( ! empty( $tabs ) ) {
	$current = ( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ? $page . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) : SQ_Classes_Helpers_Tools::arrayKeyFirst( $tabs ) );

	if ( isset( $tabs[ $current ]['tabs'] ) && ! empty( $tabs[ $current ]['tabs'] ) ) {
		foreach ( $tabs[ $current ]['tabs'] as $menuid => $tab ) {
			?>
            <div class="bg-primary mt-5 p-3 tab-panel <?php echo( $cnt == 0 ? 'tab-panel-first' : '' ) ?> <?php echo esc_attr( $tab['tab'] ) ?>"><?php echo wp_kses_post( $tab['title'] ) ?></div>
			<?php
			$cnt ++;
		}
	}
}
?>
