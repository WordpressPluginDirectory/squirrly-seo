<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Best Practice view
 *
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="flex-grow-1 px-1 sq_flex">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="card col-12 p-0">
                    <div class="p-2 rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_boostpages_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__( "Best Practices", 'squirrly-seo' ); ?></h3>
                    </div>
                    <div id="sq_focuspages" class="card col-12 p-0 tab-panel border-0">
                        <div class="p-0">
                            <div class="col-12 m-0 p-0">
                                <div class="card col-12 my-4 p-0 border-0 ">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col sq_col_side ">
                <div class="col-12 p-0">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
