<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Inner Links Block view
 *
 * Called through ajax from Focus Pages Controller
 */
?>
<div id="sq_innerlinks" class="col-12 m-0 p-0">
	<?php do_action( 'sq_innerlinks_before' ); ?>

	<?php if ( ! empty( $view->innerlinks ) ) { ?>
        <div class="col-12 m-0 p-0 position-relative">
            <p class="my-3"><?php echo esc_html__( "The following pages have the Focus Pages keywords used in their content.", "squirrly-seo" ) ?></p>
            <div class="col-12 m-0 p-0" style="display: inline-block;">

                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th><?php echo esc_html__( "Keyword", "squirrly-seo" ) ?></th>
                        <th><?php echo esc_html__( "From", "squirrly-seo" ) ?></th>
                        <th><?php echo esc_html__( "To", "squirrly-seo" ) ?></th>
                        <th><?php echo esc_html__( "Option", "squirrly-seo" ) ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					foreach ( $view->innerlinks as $innerlink ) {

						//build the inner link domain
						$innerlink = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Innerlink', $innerlink );
						if ( $from_post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $innerlink->from_post_id ) ) {
							if ( $to_post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $innerlink->to_post_id ) ) { ?>
                                <tr>
                                    <td style="width: 20%; vertical-align: middle; white-space:nowrap;">
                                        <div class="small"><?php echo esc_html( $innerlink->keyword ); ?></div>
                                    </td>
                                    <td style="width: 40%; vertical-align: middle">
										<?php echo esc_html( $from_post->sq->title ) ?>
                                        <div class="small"><?php echo '<a href="' . esc_url( $from_post->url ) . '" class="text-link" rel="permalink" target="_blank">' . esc_url( urldecode( $from_post->url ) ) . '</a>' ?></div>
                                    </td>
                                    <td style="width: 40%; vertical-align: middle">
										<?php echo esc_html( $to_post->sq->title ) ?>
                                        <div class="small"><?php echo '<a href="' . esc_url( $to_post->url ) . '" class="text-link" rel="permalink" target="_blank">' . esc_url( urldecode( $to_post->url ) ) . '</a>' ?></div>
                                    </td>

                                    <td style="width: 150px; text-align: center; vertical-align: middle">
										<?php if ( ! $innerlink->found ) { ?>
                                            <form method="post" class="p-0 m-0">
												<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_addinnerlink', 'sq_nonce' ); ?>
                                                <input type="hidden" name="action" value="sq_focuspages_addinnerlink"/>

                                                <input type="hidden" name="from_post_id" value="<?php echo (int) $innerlink->from_post_id; ?>">
                                                <input type="hidden" name="to_post_id" value="<?php echo (int) $innerlink->to_post_id; ?>">
                                                <input type="hidden" name="keyword" value="<?php echo esc_attr( $innerlink->keyword ); ?>">

                                                <button type="button" class="sq_innerlink_add btn btn-sm text-white btn-primary" style="width: 50px;">
													<?php echo esc_html__( "Add", "squirrly-seo" ) ?>
                                                </button>

                                                <a href="<?php echo esc_url( $from_post->url ) ?>" target="_blank" class="sq_innerlink_done btn btn-sm btn-link text-primary font-weight-bold text-center" style="width: 150px; display: none"><?php echo esc_html__( "Link Found", "squirrly-seo" ) ?></a>

                                            </form>
										<?php } else { ?>
                                            <a href="<?php echo esc_url( $from_post->url ) ?>" target="_blank" class="btn btn-sm btn-link text-primary font-weight-bold text-center" style="width: 150px;"><?php echo esc_html__( "Link Found", "squirrly-seo" ) ?></a>
										<?php } ?>
                                    </td>

                                </tr>
							<?php }
						} ?>
					<?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
	<?php } else { ?>
        <div class="col-12 m-0 p-0">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th><?php echo esc_html__( "Title", "squirrly-seo" ) ?></th>
                    <th><?php echo esc_html__( "Keyword Found", "squirrly-seo" ) ?></th>
                    <th><?php echo esc_html__( "Option", "squirrly-seo" ) ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="3">
                        <p class="text-center"><?php echo esc_html__( "No other pages using the same keywords found yet.", "squirrly-seo" ); ?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
	<?php } ?>

	<?php do_action( 'sq_innerlinks_after' ); ?>

</div>
