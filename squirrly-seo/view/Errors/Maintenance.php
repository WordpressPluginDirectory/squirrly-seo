<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Maintenance view
 *
 */
?>
<?php
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-reboot' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">

                <div class="col-12 m-0 p-0">
                    <div class="col-12 px-2 py-3 text-center">
                        <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/maintenance.jpg' ) ?>" alt="" style="width: 500px">
                    </div>
                    <div id="sq_error" class="card col-12 p-0 tab-panel border-0">
                        <div class="col-12 alert alert-success text-center m-0 p-3">
                            <i class="fa-solid fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf( esc_html__( "Unfortunately Squirrly Cloud is down for a bit of maintenance right now. But we'll be back in a minute. %srefresh the page%s.", "squirrly-seo" ), '<a href="javascript:void(0);" onclick="location.reload();" >', '</a>' ) ?>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
