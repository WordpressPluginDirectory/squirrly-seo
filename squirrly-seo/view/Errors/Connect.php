<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Login/Register view
 *
 */
?>
<?php
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-reboot' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );
SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );

$page = apply_filters( 'sq_page', SQ_Classes_Helpers_Tools::getValue( 'page', '' ) );
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div class="d-flex flex-row my-0 p-0 m-0">
        <div class="sq_flex flex-grow-1 mx-0 px-2">
            <div class="mx-auto">
                <div class="col-8 mx-auto my-2 p-2 offset-2 bg-white rounded-top" style="min-width: 600px;">
                    <div class="col-12 text-center m-2 p-0 e-connect">
                        <div class="mt-3 mb-4 mx-auto e-connect-link">
                            <div class="p-0 mx-2 float-left" style="width:48px;">
                                <div class="sq_wordpress_icon m-0 p-0" style="width: 48px; height: 48px;">
                                </div>
                            </div>
                            <div class="p-0 mx-2 float-right" style="width:48px;">
                                <div class="sq_logo sq_logo_50 m-0 p-0"></div>
                            </div>
                        </div>
                        <h4><?php echo esc_html__( "Connect Your Site to Squirrly Cloud", "squirrly-seo" ); ?></h4>
                        <div class="small"><?php echo sprintf( esc_html__( "Get Access to the Non-Human SEO Consultant, Focus Pages, SEO Audits and all our features %s by creating a free account", "squirrly-seo" ), '<br/>' ) ?></div>
                    </div>

					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_Blocklogin' )->init(); ?>
                </div>
            </div>

        </div>

    </div>
</div>
