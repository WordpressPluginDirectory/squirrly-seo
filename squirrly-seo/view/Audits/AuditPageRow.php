<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Audit Overview Pages Row view
 *
 * Called from Audits Pages View
 */
$edit_link = false;

$post = $view->auditpage->wppost;

if ( isset( $post->ID ) ) {
	if ( $post->post_type <> 'profile' ) {
		$edit_link = get_edit_post_link( $post->ID, false );
	}

} elseif ( isset( $post->term_id ) && $post->term_id ) {
	$term = get_term_by( 'term_id', $post->term_id, $post->taxonomy );
	if ( ! is_wp_error( $term ) ) {
		$edit_link = get_edit_term_link( $term->term_id, $post->taxonomy );
	}
}

if ( strtotime( $view->auditpage->audit_datetime ) ) {
	$audit_timestamp = strtotime( $view->auditpage->audit_datetime ) + ( (int) get_option( 'gmt_offset' ) * 3600 );
	$audit_timestamp = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $audit_timestamp );
} else {
	$audit_timestamp = $view->auditpage->audit_datetime;
}
?>

<td style="min-width: 380px;">

	<?php if ( $post instanceof SQ_Models_Domain_Post ) { ?>
        <div class="sq_auditpages_title col-12 px-0 mx-0 font-weight-bold">
			<?php echo( isset( $post->post_title ) ? esc_html( $post->post_title ) : '' ) ?> <?php echo( ( $post->post_status <> 'publish' && $post->post_status <> 'inherit' && $post->post_status <> '' ) ? ' <spam style="font-weight: normal">(' . esc_html( $post->post_status ) . ')</spam>' : '' ) ?>
			<?php if ( isset( $edit_link ) && $edit_link <> '' ) { ?>
                <a href="<?php echo esc_url( $edit_link ) ?>" target="_blank">
                    <i class="fa-solid fa-edit text-gray"></i>
                </a>
			<?php } ?>
        </div>
	<?php } ?>

    <div class="sq_auditpages_url small">
        <a href="<?php echo esc_url( $view->auditpage->permalink ) ?>" class="text-link" rel="permalink" target="_blank"><?php echo esc_url( urldecode( $view->auditpage->permalink ) ) ?></a>
    </div>
</td>
<?php if ( $view->auditpage->audit_error ) { ?>
    <td>
        <div class="text-danger my-2"><?php echo esc_html__( "Could not create the audit for this URL", "squirrly-seo" ) . ' (' . esc_html__( "error code", "squirrly-seo" ) . ': ' . esc_html( $view->auditpage->audit_error ) . ')' ?></div>
        <div class="text-black-50">
            <em><?php echo sprintf( esc_html__( "In case this is happening for ALL pages, please whitelist our crawler IPs from your hosting, even if they are not blocked. If you can't find where to whitelist the IPs, the easiest solution would be to contact your hosting and ask them to do it for you. %s 65.108.154.199 %s 5.161.83.61 %s In case this is NOT happening for all your pages, click on the 3 dots for those pages that get the error, stop monitoring, and add it again. %s After which, make another audit.", "squirrly-seo" ), '<br /><br />', '<br />', '<br /><br />', '<br /><br />' ) ?></em>
        </div>
    </td>
<?php } else { ?>
    <td></td>
<?php } ?>

<td class="px-0" style="width: 20px">
    <div class="sq_sm_menu">
        <div class="sm_icon_button sm_icon_options">
            <i class="fa-solid fa-ellipsis-v"></i>
        </div>
        <div class="sq_sm_dropdown">
            <ul class="p-2 m-0 text-left">
                <li class="m-0 p-1 py-2">
                    <form method="post" class="row p-0 m-0">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_audits_page_update', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_audits_page_update"/>
                        <input type="hidden" name="post_id" value="<?php echo (int) $view->auditpage->user_post_id ?>"/>
                        <i class="sq_icons_small fa-solid fa-refresh py-2"></i>
                        <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
							<?php echo esc_html__( "Request New Audit", "squirrly-seo" ) ?>
                        </button>
                    </form>
                </li>
                <li class="m-0 p-1 py-2">
                    <i class="sq_icons_small fa-solid fa-info-circle" style="padding: 2px"></i>
                    <button class="btn btn-sm bg-transparent p-0 m-0" onclick="jQuery('#sq_previewurl_modal').attr('data-post_id', '<?php echo (int) $view->auditpage->user_post_id ?>').sq_inspectURL()" data-dismiss="modal"><?php echo esc_html__( "Inspect URL", "squirrly-seo" ); ?></button>
                </li>
                <li class="m-0 p-1 py-2">
                    <form method="post" class="row p-0 m-0" onSubmit="return confirm('<?php echo esc_html__( "Are you sure? You can always monitor it again in the future.", "squirrly-seo" ) ?>') ">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_audits_delete', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_audits_delete"/>
                        <input type="hidden" name="id" value="<?php echo (int) $view->auditpage->user_post_id ?>"/>
                        <i class="sq_icons_small fa-solid fa-trash py-2"></i>
                        <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
							<?php echo esc_html__( "Stop Monitoring", "squirrly-seo" ) ?>
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>


</td>
