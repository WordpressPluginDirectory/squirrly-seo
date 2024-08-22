<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * ToolBar Block view
 *
 * Called on all Squirrly Settings pages
 */
?>
<div id="sq_toolbarblog" class="col-12 m-0 p-0">
    <nav class="navbar navbar-expand-sm bg-primary p-0 m-0 py-1">
        <div class="container-fluid p-0 m-0">
            <div class="justify-content-start col p-0 m-0 px-3" id="navigation">
                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ) ) ?>"><span class="sq_logo sq_logo_30 float-left"></span></a>
                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ) ) ?>"><span class="sq_logo_toolbar_text ml-2 text-white float-left"><?php echo esc_html( _SQ_MENU_NAME_ ) ?></span></a>

				<?php do_action( 'sq_toolbar_start' ); ?>
            </div>
			<?php if ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seo' ) ) { ?>
                <div class="justify-content-end col p-0 m-0">
                    <div class="row text-right p-0 m-0">
                        <div class="col p-0 m-0 sq_save_ajax">
                            <button id="sq_seoexpert" name="sq_seoexpert" class="btn btn-link text-white" data-action="sq_ajax_seosettings_save" data-name="sq_seoexpert" data-value="0" <?php echo( ! SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ? 'style="text-decoration: underline; font-weight: 700;"' : '' ) ?> ><?php echo esc_html__( "SEO Beginner", "squirrly-seo" ); ?></button>
                            <button id="sq_seoexpert" name="sq_seoexpert" class="btn btn-link text-white" data-action="sq_ajax_seosettings_save" data-name="sq_seoexpert" data-value="1" <?php echo( SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ? 'style="text-decoration: underline; font-weight: 700;"' : '' ) ?> ><?php echo esc_html__( "SEO Expert", "squirrly-seo" ); ?></button>
                        </div>
                        <div class="p-2 m-0 mt-1 pb-0 sq_account_info" style="display: inline-block"></div>

						<?php do_action( 'sq_toolbar_end' ); ?>
                    </div>
                </div>
			<?php } ?>
        </div>
    </nav>
</div>
