<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Audit Overview Pages view
 *
 * Called from Audits View
 */
?>
<div class="col-12 m-0 p-0">

	<?php if ( ! empty( $view->auditpages ) ) { ?>

        <h4 class="card-title"><?php echo esc_html__( "Audited pages", "squirrly-seo" ) ?>
            (<?php echo count( (array) $view->auditpages ) ?> <?php echo esc_html__( 'pages', "squirrly-seo" ) ?>)</h4>
        <div class="col-12 m-0 p-0 position-relative">
            <div class=" col-12 m-0 p-0 my-2 py-2 py-0">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th><?php echo esc_html__( "Permalink", "squirrly-seo" ) ?></th>
                        <th></th>
                        <th style="width: 10px"></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					foreach ( $view->auditpages as $index => $auditpage ) {

						if ( $auditpage->permalink <> '' ) {
							if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
								continue;
							}

							?>
                            <tr id="sq_row_<?php echo (int) $auditpage->id ?>" class="<?php echo( (int) $index % 2 ? 'even' : 'odd' ) ?>">
								<?php
								$view->auditpage = $auditpage;
								$view->show_view( 'Audits/AuditPageRow' );
								?>
                            </tr>
							<?php
						}
					}
					?>
                    </tbody>
                </table>
            </div>
        </div>


	<?php } elseif ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>

        <div class="col-12 m-0 p-0 ">
            <h4 class="text-center"><?php echo sprintf( esc_html__( "No data for this filter. %sShow All%s Audit Pages.", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) ) . '" >', '</a>' ) ?></h4>
        </div>

	<?php } elseif ( ! SQ_Classes_Error::isError() ) { ?>

        <div class="col-12 m-0 p-0 ">
            <h4 class="text-center"><?php echo esc_html__( "Welcome to SEO Audits", "squirrly-seo" ); ?></h4>
            <div class="col-12 m-2 text-center">
                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'addpage' ) ) ?>" class="btn btn-lg btn-primary"><i class="fa-solid fa-plus-square-o"></i> <?php echo esc_html__( "Add a new page for Audit to get started", "squirrly-seo" ); ?>
                </a>
            </div>
        </div>

	<?php } else { ?>

        <div class="col-12 m-0 p-0 ">
            <div class="col-12 px-2 py-3 text-center">
                <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/noconnection.png' ) ?>" alt="" style="width: 300px">
            </div>
            <div class="col-12 m-2 text-center">
                <div class="col-12 alert alert-success text-center m-0 p-3">
                    <i class="fa-solid fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf( esc_html__( "There is a connection error with Squirrly Cloud. Please check the connection and %srefresh the page%s.", "squirrly-seo" ), '<a href="javascript:void(0);" onclick="location.reload();" >', '</a>' ) ?>
                </div>
            </div>
        </div>

	<?php } ?>
</div>

