<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Bulk SEO view
 *
 * Called from Bulk SEO View for each line
 */
?>
<?php
$edit_link = false;

if ( isset( $view->post->ID ) ) {
	if ( $view->post->post_type <> 'profile' ) {
		$edit_link = get_edit_post_link( $view->post->ID, false );
	}

} elseif ( $view->post->term_id ) {
	$term = get_term_by( 'term_id', $view->post->term_id, $view->post->taxonomy );
	if ( ! is_wp_error( $term ) ) {
		$edit_link = get_edit_term_link( $term->term_id, $view->post->taxonomy );
	}
}

if ( $view->post instanceof SQ_Models_Domain_Post ) { ?>
    <td style="max-width: 380px;">
        <div class="col-12 px-0 mx-0 font-weight-bold"><?php echo esc_html( $view->post->sq->title ) ?><?php echo( ( $view->post->post_status <> 'publish' && $view->post->post_status <> 'inherit' && $view->post->post_status <> '' ) ? ' <spam style="font-weight: normal">(' . esc_html( $view->post->post_status ) . ')</spam>' : '' ) ?>
			<?php if ( $edit_link ) { ?>
                <a href="<?php echo esc_url( $edit_link ) ?>" target="_blank">
                    <i class="fa-solid fa-edit" style="font-size: 11px"></i>
                </a>
			<?php } ?>
			<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_indexnow' ) && $view->post->post_status == 'publish' ) { ?>
                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( [ 'action'           => 'sq_seosettings_indexnow_submit',
				                                                            'indexnow_post_id' => $view->post->ID,
				                                                            'urls'             => $view->post->url
				] ), 'sq_seosettings_indexnow_submit', 'sq_nonce' ) ) ?>"><i class="fa-solid fa-upload" title="<?php echo esc_attr__( 'Submit to IndexNow', "squirrly-seo" ) ?>" style="font-size: 11px"></i></a>
			<?php } ?>
        </div>
        <div class="small "><?php echo '<a href="' . esc_url( $view->post->url ) . '" title="' . sprintf( esc_attr__( "View: %s" ), esc_attr( $view->post->post_title ) ) . '" class="text-link" rel="permalink" target="_blank">' . esc_url( urldecode( $view->post->url ) ) . '</a>' ?></div>
    </td>
	<?php
	$categories = apply_filters( 'sq_assistant_categories_page', $view->post->hash );
	if ( ! empty( $categories ) ) {
		foreach ( $categories as $name => $category ) {
			?>
            <td style="min-width: 110px; ">
                <div class="sq_show_snippet <?php echo( ( $category->value === false ) ? 'sq_circle_label' : '' ) ?>" data-id="<?php echo esc_attr( $view->post->hash ) ?>" data-category="<?php echo esc_attr( $name ) ?>" style="cursor: pointer; <?php echo( ( $category->value === false ) ? 'background-color' : 'color' ) ?>: <?php echo esc_attr( $category->color ) ?>;" title="<?php echo esc_attr( $category->title ) ?>"><?php echo( ( $category->value !== false ) ? esc_html( $category->value ) : '' ) ?></div>
            </td>
			<?php
		}
	} ?>
<?php } ?>
