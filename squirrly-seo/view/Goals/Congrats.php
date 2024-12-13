<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

$category_name = apply_filters( 'sq_page', 'sq_dashboard' );

/**
 * Congratulations view
 */
?>
<a name="progress"></a>
<div id="sq_seocheck_success" class="col-12 m-0 p-0 pt-4    ">
    <table class="table my-0 border-0 shadow-none">
        <tbody>
		<?php
		$ignored_success_count = 0;

		foreach ( $view->congratulations as $function => $row ) {
			if ( $row['status'] == 'ignore' ) {
				$ignored_success_count ++;
				continue;
			}
			?>
            <tr>
                <td class="p-3 bg-white text-left" style="width: 100px">
					<?php if ( isset( $row['image'] ) && $row['image'] ) { ?>
                        <div class="col-12 text-center p-0 m-0">
                            <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/seocheck/' . $row['image'] ) ?>" alt="" style="max-width: 50px;"/>
                        </div>
					<?php } ?>
                </td>
                <td class="p-3 bg-white text-left">
					<?php echo( isset( $row['message'] ) ? wp_kses_post( $row['message'] ) : '' ) ?>
                </td>
				<?php if ( isset( $row['link'] ) ) { ?>
                    <td class="p-3 bg-white text-center" style="width: 150px; vertical-align: middle;">
                        <a href="<?php echo esc_url( $row['link'] ) ?>" class="btn btn-sm btn-link text-primary font-weight-bold p-2 px-3 m-0" target="_blank">
							<?php echo esc_html__( "See results", "squirrly-seo" ) ?>
                        </a>
                    </td>
				<?php } ?>
                <td class="p-3 bg-white sq_save_ajax" style="width: 10px; vertical-align: middle;">
					<?php if ( isset( $row['ignorable'] ) && $row['ignorable'] ) { ?>
                        <button type="button" class="float-right btn btn-sm btn-link text-black-50 p-2 px-3 m-0" id="sq_ignore" data-input="sq_ignore_<?php echo esc_attr( $function ) ?>" data-name="sq_dashboard|<?php echo esc_attr( $function ) ?>" data-action="sq_ajax_assistant" value="1">
                            <i class="fa-solid fa-close"></i>
                        </button>
					<?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="<?php if ( isset( $row['link'] ) ) {
					echo 4;
				} else {
					echo 3;
				} ?>" class="p-2 m-0"></td>
            </tr>
		<?php } ?>
        </tbody>
    </table>

    <div class="col-12 p-0 m-0 text-left">
		<?php if ( $ignored_success_count > 0 ) { ?>
            <form method="post" class="p-0 m-0">
				<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_resetignored', 'sq_nonce' ); ?>
                <input type="hidden" name="category" value="<?php echo esc_attr($category_name) ?>"/>
                <input type="hidden" name="action" value="sq_resetignored"/>
                <button type="submit" class="btn btn-link small text-black-50 small p-2 m-0">
					<?php echo esc_html__( "Show hidden success", "squirrly-seo" ) ?>
                    <span class="rounded-circle p-1 px-2 text-white bg-danger small"><?php echo esc_html( $ignored_success_count ) ?></span>
                </button>
            </form>
		<?php } ?>

    </div>
</div>
