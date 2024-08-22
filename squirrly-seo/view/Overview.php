<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Top Notice view
 *
 */
?>
    <div id="sq_wrap" class="sq_overview">
		<?php $view->show_view( 'Blocks/Toolbar' ); ?>

		<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_onboarding' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_notification' ) ) {

			if ( isset( $view->checkin->notification ) && $view->checkin->notification <> '' ) {
				echo $view->checkin->notification;
			}
		} ?>

        <div class="d-flex flex-row bg-white my-0 p-0 m-0">

			<?php $view->show_view( 'Blocks/Menu' ); ?>

            <div class="sq_flex flex-grow-1 bg-light m-0 p-0 px-4">
				<?php
				$page = SQ_Classes_Helpers_Tools::getValue( 'page' );
				$tabs = SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getTabs( $page );

				foreach ( $tabs as $id => $tab ) {
					if ( $tab['show'] ) {
						if ( isset( $tab['function'] ) && $tab['function'] ) {
							$name = explode( '/', $id );
							if ( isset( $name[1] ) ) {
								echo '<div class="sq_breadcrumbs mt-5">' . SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getBreadcrumbs( $name[1] ) . '</div>';
							}
							call_user_func( $tab['function'] );
						}
					}
				}
				?>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

        </div>
    </div>

<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_mode' ) && ! SQ_Classes_Helpers_Tools::getOption( 'sq_onboarding' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ) ) { ?>

    <div id="sq_onboarding_modal" tabindex="-1" class="modal" role="dialog">
        <div class="modal-dialog" style="max-width: 100%; margin: 115px 46px;">
            <div class="modal-content bg-white rounded-0" style="width: 830px; margin: 0 0 auto auto;">
                <div class="modal-header">
                    <div class="row col-12 m-0 p-0">
                        <div class="m-0 p-0 align-middle"><i class="sq_logo sq_logo_30"></i></div>
                        <div class="col-11 m-0 px-3 align-middle text-left">
                            <h5 class="modal-title"><?php echo sprintf( esc_html__( "First, you need to activate the %s recommended mode %s or the %s expert mode %s!", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding' ) ) . '">', '</a>', '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding' ) ) . '">', '</a>' ); ?>
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding' ) ) ?>" class="btn btn-sm btn-primary ml-3"><?php echo esc_html__( "Let's do this", "squirrly-seo" ); ?>
                                    ></a></h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
	$refresh     = false;
	$report_time = SQ_Classes_Helpers_Tools::getOption( 'seoreport_time' );
	if ( ! $report_time || ( time() - (int) $report_time ) > ( 3600 * 12 ) ) {
		$refresh = true;
	}

	if ( ! $refresh ) { ?>
        <script>
            (function ($) {
                $(document).ready(function () {
                    $("#sq_onboarding_modal").modal({backdrop: 'static', keyboard: false});
                });
            })(jQuery);
        </script>
	<?php }
} ?>