<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Dashboard Block view
 *
 * Called from Dashboard Model
 */
?>
<?php
$tasks_completed   = SQ_Classes_ObjController::getClass( 'SQ_Controllers_Progress' )->getCongratulations();
$tasks_incompleted = SQ_Classes_ObjController::getClass( 'SQ_Controllers_CheckSeo' )->getNotifications();
?>
<div id="sq_dashboard_content" style="position: relative;">
	<?php do_action( 'sq_form_notices' ); ?>

    <div id="sq_dashboard_content_inner">

		<?php do_action( 'sq_dashboard_before' ); ?>

		<?php if ( ! empty( $tasks_completed ) ) {
			$tasks_completed = array_values( $tasks_completed );

			?>
            <div class="sq_dashboard_title">
                <strong><?php echo esc_html__( "Congratulations! you have success messages", "squirrly-seo" ) ?>:
            </div>
            <div class="sq_dashboard_description">
                <ul>
					<?php
					foreach ( $tasks_completed as $index => $row ) { ?>
                        <li>
                            <div class="sq_task_title" style="margin-left: 50px;">
                                <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/seocheck/' . esc_attr( $row['image'] ) ) ?>" alt="" style="max-width: 40px; margin-left: -45px;"/><?php echo( isset( $row['message'] ) ? wp_kses_post( $row['message'] ) : '' ) ?>
                            </div>
                        </li>
						<?php
						if ( $index > 0 ) {
							break;
						}
					}
					?>
                </ul>
            </div>
		<?php } ?>

		<?php if ( ! empty( $tasks_incompleted ) ) {
			$tasks_incompleted = array_values( $tasks_incompleted );
			?>
            <div class="sq_dashboard_title">
                <strong><?php echo esc_html__( "You got new goals", "squirrly-seo" ) ?>:</strong>
            </div>
            <div class="sq_dashboard_description">
                <ul>
					<?php
					foreach ( $tasks_incompleted as $index => $row ) { ?>
                        <li>
                            <div class="sq_task_title"><?php echo( isset( $row['warning'] ) ? wp_kses_post( $row['warning'] ) : '' ) ?></div>
                            <div class="sq_task_description"><?php echo( isset( $row['message'] ) ? wp_kses_post( $row['message'] ) : '' ) ?></div>
                        </li>
						<?php
						if ( $index > 0 ) {
							break;
						}
					} ?>

					<?php if ( count( $tasks_incompleted ) > 2 ) { ?>
                        <li>
							<?php echo '+' . ( count( $tasks_incompleted ) - 2 ) . ' ' . esc_html__( "others", "squirrly-seo" ) ?>
                        </li>
					<?php } ?>
                </ul>
            </div>
            <div class="sq_dashboard_buttons">
                <a class="sq_button" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_checkseo' ) ) ?>"><?php echo esc_html__( "See Today’s Goals", "squirrly-seo" ) ?> >></a>
            </div>
		<?php } else { ?>
            <div class="sq_dashboard_nogoals">
                <h4><?php echo sprintf( esc_html__( "No other goals for today. %sGood job!", "squirrly-seo" ), '<br />' ); ?></h4>
                <div>
                    <a class="wp_button" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ) ) ?>" class="btn btn-sm btn-primary" style="font-size: 14px"><?php echo esc_html__( "Rank your best pages with Focus Pages", "squirrly-seo" ); ?></a>
                </div>
                <div>
                    <a class="wp_button" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) ) ?>" class="btn btn-sm btn-primary" style="font-size: 14px"><?php echo esc_html__( "Boost your SEO with Bulk SEO", "squirrly-seo" ); ?></a>
                </div>
            </div>
		<?php } ?>

		<?php do_action( 'sq_dashboard_after' ); ?>

    </div>
</div>

<script>
    var sq_profilelevel = function (level) {
        jQuery('.sq_level-separator').animate({height: level}, 500);
        jQuery('.sq_fill-marker').animate({top: level}, 500);
        jQuery('.sq_current-level-description').animate({top: level}, 500);
    };

    setTimeout(function () {
        sq_profilelevel(0);
    }, 1000);

	<?php if (SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' )) {?>
    (function ($) {
        $.fn.sq_widget_recheck = function () {
            var $this = this;
            var $div = $this.find('.inside');

            $div.find('#sq_dashboard_content').html('<div style="font-size: 18px; text-align: center; font-weight: bold; margin: 30px 0;"><?php echo esc_html__( "Checking the website ...", "squirrly-seo" ) ?></div><div class="sq_loading"></div>');
            $.post(
                sqQuery.ajaxurl,
                {
                    action: 'sq_ajaxcheckseo',
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.data !== 'undefined') {
                    $div.html(response.data);
                }
            }).error(function () {
                $div.html('');
            });
        };

        $(document).ready(function () {
			<?php
			$report_time = SQ_Classes_Helpers_Tools::getOption( 'seoreport_time' );
			if (empty( $report_time ) || ( time() - (int) $report_time ) > ( 3600 * 12 )) { ?>
            $('#sq_dashboard_widget').sq_widget_recheck();
			<?php }?>
        });
    })(jQuery);
	<?php }?>

</script>
