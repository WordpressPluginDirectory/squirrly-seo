<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Focus Page view
 *
 * Called from Focus Pages view
 */
?>
<?php
$edit_link  = false;
$audit_done = true;

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

if ( $view->focuspage->audit_datetime <> '' && strtotime( $view->focuspage->audit_datetime ) ) {
	$audit_timestamp = strtotime( $view->focuspage->audit_datetime ) + ( (int) get_option( 'gmt_offset' ) * 3600 );
	$audit_timestamp = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $audit_timestamp );
} else {
	$audit_done      = false;
	$audit_timestamp = $view->focuspage->audit_datetime;
}

$call_timestamp = 0;
if ( get_transient( 'sq_auditpage_' . $view->focuspage->id ) ) {
	$call_timestamp = (int) get_transient( 'sq_auditpage_' . $view->focuspage->id );
}

$categories = apply_filters( 'sq_assistant_categories_page', $view->focuspage->id );

$color = false;
if ( (int) $view->focuspage->visibility > 0 ) {
	$color = '#D32F2F';
	if ( ( (int) $view->focuspage->visibility >= 50 ) ) {
		$color = 'orange';
	}
	if ( ( (int) $view->focuspage->visibility >= 90 ) ) {
		$color = '#4CAF50';
	}
}

$rank    = false;
$keyword = false;
if ( $view->focuspage->indexed ) {
	$audit = $view->focuspage->getAudit();
	if ( isset( $audit->data->sq_seo_keywords->value ) && $audit->data->sq_seo_keywords->value <> '' ) {
		$keyword = $audit->data->sq_seo_keywords->value;
		if ( isset( $audit->data->serp_checker->position ) && $audit->data->serp_checker->position > 0 && $audit->data->serp_checker->position <= 10 ) {
			$rank = $audit->data->serp_checker->position;
		} elseif ( isset( $audit->data->sq_analytics_gsc->position ) && $audit->data->sq_analytics_gsc->position > 0 && $audit->data->sq_analytics_gsc->position <= 10 ) {
			$rank = $audit->data->sq_analytics_gsc->position;
		}
	}
}
if ( $view->focuspage->id <> '' ) {
	?>
    <td class="m-0" style="min-width: 360px;word-break: break-word;">
        <div class="col-12 m-0 <?php if ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>p-3 mb-4 bg-white<?php } else { ?>px-2<?php } ?>">

			<?php if ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>
                <div class="sq_focus_visibility">
					<?php if ( $view->focuspage->indexed ) { ?>
                    <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/seocheck/top10.png' ) ?>" class="sq_show_tooltip" style="width: 80px !important;" alt="Top 10" data-original-title="<?php echo( (int) $rank ? sprintf( esc_html__( "Congratulations! You ranked on %s on Google with the keyword: %s", 'squirrly-seo' ), (int) $rank, esc_attr( SQ_Classes_Helpers_Sanitize::clearKeywords( $keyword ) ) ) : '' ) ?>"/>
					<?php }elseif ( (int) $view->focuspage->visibility > 0 ) { ?>
                    <input id="knob_<?php echo esc_attr( $view->focuspage->id ) ?>" type="text" value="<?php echo esc_attr( $view->focuspage->visibility ) ?>" class="sq_chances_ranking sq_show_tooltip" title="<?php echo sprintf( esc_html__( "The Chances of Ranking is dynamically calculated by the Squirrly Machine Learning based on the main keyword you selected for this Focus Page. %sThe algorithm behind the Chances of Ranking is complex but the fastest way to increase your chances is to complete the main tasks like Visibility, Keyword Competition, Content Optimization, Content Length, Social Signals, Daily Traffic, Inner Links, and External Nofollow Links. %sIn time you need to complete all the Focus Pages tasks to rank higher and higher and to maintain your rank especially if your keyword is a competitive one.", 'squirrly-seo' ), "<br /><br />", "<br /><br />" ) ?>"/>
                        <script>
                            (function ($) {
                                $(document).ready(function () {
                                    $("#knob_<?php echo esc_attr( $view->focuspage->id ) ?>").knob({
                                        'min': 0,
                                        'max': 100,
                                        'readOnly': true,
                                        'width': 80,
                                        'height': 80,
                                        'skin': "tron",
                                        'fgColor': '<?php echo esc_attr( $color )  ?>'
                                    });
                                });
                            })(jQuery);
                        </script>
					<?php } else {
						echo esc_html( $view->focuspage->visibility );
					} ?>
                </div>
			<?php } ?>

			<?php if ( $view->post ) { ?>
                <div class="sq_focuspages_title col-12 m-0 p-0 pb-2 font-weight-bold text-dark text-left">
					<?php echo( isset( $view->post->post_title ) ? esc_html( $view->post->post_title ) : '' ) ?> <?php echo( ( $view->post->post_status <> 'publish' && $view->post->post_status <> 'inherit' && $view->post->post_status <> '' ) ? ' <spam style="font-weight: normal">(' . esc_html( $view->post->post_status ) . ')</spam>' : '' ) ?>
					<?php if ( $edit_link ) { ?>
                        <a href="<?php echo esc_url( $edit_link ) ?>" target="_blank">
                            <i class="fa-solid fa-edit small" style="color: rgb(128,128,128);"></i>
                        </a>
					<?php } ?>
                </div>
			<?php } ?>

            <div class="sq_focuspages_url small text-left"><?php echo '<a href="' . esc_url( $view->post->url ) . '"  class="text-link" rel="permalink" target="_blank">' . esc_url( urldecode( $view->post->url ) ) . '</a>' ?></div>
            <div class="sq_focuspages_lastaudited small text-dark my-1"><?php echo esc_html__( "Audited", 'squirrly-seo' ) ?>
                : <span class="font-weight-bold"><?php echo esc_html( $audit_timestamp ) ?></span></div>
            <form method="post" class="sq_focuspages_request p-0 m-0">
				<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_update', 'sq_nonce' ); ?>
                <input type="hidden" name="action" value="sq_focuspages_update"/>

                <input type="hidden" name="post_id" value="<?php echo (int) $view->post->ID; ?>">
                <input type="hidden" name="type" value="<?php echo esc_attr( $view->post->post_type ); ?>">
                <input type="hidden" name="term_id" value="<?php echo (int) $view->post->term_id; ?>">
                <input type="hidden" name="taxonomy" value="<?php echo esc_attr( $view->post->taxonomy ); ?>">

                <input type="hidden" name="id" value="<?php echo (int) $view->focuspage->user_post_id ?>"/>

				<?php if ( ! SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>
                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'sid=' . (int) $view->focuspage->id ) ) ) ?>" class="btn btn-sm btn-primary text-white inline py-1 px-3 m-0">
						<?php echo esc_html__( "Details", 'squirrly-seo' ) ?>
                    </a>
				<?php } ?>
				<?php if ( $call_timestamp > ( time() - 300 ) ) { ?>
                    <span class="small ml-2"><?php echo sprintf( esc_html__( "Wait %s minutes", 'squirrly-seo' ), number_format( ( $call_timestamp - ( time() - 300 ) ) / 60 ) ) ?></span>
				<?php } else { ?>
                    <button type="submit" class="btn btn-sm btn-link font-weight-bold text-primary inline ml-2">
						<?php echo esc_html__( "Request New Audit", 'squirrly-seo' ) ?>
                    </button>
				<?php } ?>

            </form>

        </div>

    </td>

	<?php $view->show_view( 'FocusPages/FocusPageStats' ); ?>

	<?php if ( $view->focuspage->audit_error ) {
		$audit_error = SQ_Classes_ObjController::getClass( 'SQ_Models_CheckSeo' )->getErrorMessage( $view->focuspage->audit_error );
		?>
        <td class="p-1 m-0" colspan="<?php echo( count( (array) $categories ) + 1 ) ?>">
            <div class="text-danger my-2"><?php echo wp_kses_post( $audit_error['warning'] ) ?>
				<?php if ( $view->focuspage->audit_error == 'limit_exceeded' ) { ?>
                    <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'plans' ) ) ?>" class="text-danger sq_previewurl font-weight-bold small px-3" target="_blank"><?php echo esc_html__( "Upgrade Plan", 'squirrly-seo' ); ?></a>
				<?php } else { ?>
                    <button class="btn btn-link text-primary sq_previewurl font-weight-bold py-0  px-3" style="cursor: pointer" onclick="jQuery('#sq_previewurl_modal').attr('data-post_id', '<?php echo (int) $view->focuspage->user_post_id ?>').sq_inspectURL()" data-dismiss="modal"><?php echo esc_html__( "Inspect URL", 'squirrly-seo' ); ?></button>
				<?php } ?>
            </div>
            <div class="text-black-50 my-1"><?php echo wp_kses_post( $audit_error['message'] ) ?></div>
            <div class="text-black-50 my-1"><?php echo wp_kses_post( $audit_error['solution'] ) ?></div>

        </td>
	<?php } elseif ( ! $edit_link ) { ?>
        <td class="p-0 m-0 my-5" colspan="<?php echo( count( (array) $categories ) + 1 ) ?>">
            <div class="text-danger my-2"><?php echo esc_html__( "Focus Page could not be found on your website. Delete the Focus Page and add it again.", 'squirrly-seo' ) ?></div>
        </td>
	<?php } elseif ( ! $audit_done ) { ?>
        <td class="p-0 m-0 my-5" colspan="<?php echo( count( (array) $categories ) + 1 ) ?>">
            <div class="text-danger my-2"><?php echo esc_html__( "Currently processing data. Please refresh in a few minutes.", 'squirrly-seo' ) ?></div>
        </td>
	<?php } else { ?>
		<?php if ( ! SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>

            <td class="p-0 m-0" style="min-width: 100px; width: 100px; text-align: center;">
                <div class="tab_header"><?php echo esc_html__( "Chance to Rank", 'squirrly-seo' ) ?></div>
				<?php if ( $view->focuspage->indexed ) { ?>
                <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/seocheck/top10.png' ) ?>" class="m-1 p-0 sq_show_tooltip" alt="Top 10" data-original-title="<?php echo( (int) $rank ? sprintf( esc_html__( "Congratulations! You ranked on %s on Google with the keyword: %s", 'squirrly-seo' ), (int) $rank, esc_attr( SQ_Classes_Helpers_Sanitize::clearKeywords( $keyword ) ) ) : '' ) ?>" style="max-width: 80px;"/>
				<?php } elseif ( (int) $view->focuspage->visibility > 0 ) { ?>
                <input id="knob_<?php echo esc_attr( $view->focuspage->id ) ?>" type="text" value="<?php echo esc_attr( $view->focuspage->visibility ) ?>" class="sq_chances_ranking sq_show_tooltip" title="<?php echo sprintf( esc_html__( "The Chances of Ranking is dynamically calculated by the Squirrly Machine Learning based on the main keyword you selected for this Focus Page. %sThe algorithm behind the Chances of Ranking is complex but the fastest way to increase your chances is to complete the main tasks like Visibility, Keyword Competition, Content Optimization, Content Length, Social Signals, Daily Traffic, Inner Links, and External Nofollow Links. %sIn time you need to complete all the Focus Pages tasks to rank higher and higher and to maintain your rank especially if your keyword is a competitive one.", 'squirrly-seo' ), "<br /><br />", "<br /><br />" ) ?>"/>
                    <script>
                        (function ($) {
                            $(document).ready(function () {
                                $("#knob_<?php echo esc_attr( $view->focuspage->id ) ?>").knob({
                                    'min': 0,
                                    'max': 100,
                                    'readOnly': true,
                                    'width': 80,
                                    'height': 80,
                                    'skin': "tron",
                                    'fgColor': '<?php echo esc_attr( $color )  ?>'
                                });
                            });
                        })(jQuery);
                    </script>
				<?php } else {
					echo esc_html( $view->focuspage->visibility );
				} ?>
            </td>
		<?php } elseif ( ! $view->focuspage->indexed ) { ?>
            <td>
                <div class="tab_header"><?php echo esc_html__( "Chance to Rank", 'squirrly-seo' ) ?></div>
                <strong style="color:<?php echo esc_attr( $color ) ?>;" class="sq_chances_ranking_text sq_show_tooltip" title="<?php echo sprintf( esc_attr__( "The Chances of Ranking is dynamically calculated by the Squirrly Machine Learning based on the main keyword you selected for this Focus Page. %sThe algorithm behind the Chances of Ranking is complex but the fastest way to increase your chances is to complete the main tasks like Visibility, Keyword Competition, Content Optimization, Content Length, Social Signals, Daily Traffic, Inner Links, and External Nofollow Links. %sIn time you need to complete all the Focus Pages tasks to rank higher and higher and to maintain your rank especially if your keyword is a competitive one. ", 'squirrly-seo' ), "<br /><br />", "<br /><br />" ) ?>"><?php echo( (int) $view->focuspage->visibility > 0 ? (int) $view->focuspage->visibility . '%' : esc_attr( $view->focuspage->visibility ) ); ?></strong>
            </td>
		<?php } ?>

		<?php if ( ! empty( $categories ) ) {
			$all_categories = SQ_Classes_ObjController::getClass( 'SQ_Models_FocusPages' )->getCategories();
			$keyword_labels = SQ_Classes_Helpers_Tools::getValue( 'slabel', array() );
			foreach ( $categories as $name => $category ) {

				$class = '';
				if ( ! empty( $keyword_labels ) && ! in_array( $name, (array) $keyword_labels ) ) {
					$class = 'hidden';
				}

				if ( isset( $all_categories->$name ) ) {
					?>
                    <td class="p-0 m-2 <?php echo esc_attr( $class ) ?>" style="min-width: 100px; width: 180px;  text-align: center;">
                        <div class="tab_header"><?php echo esc_html( $all_categories->$name ) ?></div>
                        <div class="sq_show_assistant <?php echo( ( $category->value === false ) ? 'sq_circle_label' : '' ) ?>" data-id="<?php echo esc_attr( $view->focuspage->id ) ?>" data-category="<?php echo esc_attr( $name ) ?>" style="cursor: pointer; <?php echo( ( $category->value === false ) ? 'background-color' : 'color' ) ?>: <?php echo esc_attr( $category->color ) ?>;" title="<?php echo esc_attr( $category->title ) ?>" <?php echo( ( $category->value === false ) ? 'class="sq_circle_label"' : '' ) ?>><?php echo( ( $category->value !== false ) ? esc_html( $category->value ) : '' ) ?></div>
                    </td>
					<?php
				}
			}
		}
	} ?>

    <td class="px-0" style="width: 20px">
        <div class="sq_sm_menu">
            <div class="sm_icon_button sm_icon_options">
                <i class="fa-solid fa-ellipsis-v"></i>
            </div>
            <div class="sq_sm_dropdown <?php if ( ! SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>sq_sm_dropdown_center<?php } ?>">
                <ul class="p-2 m-0 text-left">
                    <li class="m-0 p-1 py-2">
                        <form method="post" class="p-0 m-0">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_update', 'sq_nonce' ); ?>
                            <input type="hidden" name="action" value="sq_focuspages_update"/>

                            <input type="hidden" name="post_id" value="<?php echo (int) $view->post->ID; ?>">
                            <input type="hidden" name="type" value="<?php echo esc_attr( $view->post->post_type ); ?>">
                            <input type="hidden" name="term_id" value="<?php echo (int) $view->post->term_id; ?>">
                            <input type="hidden" name="taxonomy" value="<?php echo esc_attr( $view->post->taxonomy ); ?>">

                            <input type="hidden" name="id" value="<?php echo (int) $view->focuspage->user_post_id ?>"/>
                            <i class="sq_icons_small fa-solid fa-refresh" style="padding: 2px"></i>
                            <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
								<?php echo esc_html__( "Request New Audit", 'squirrly-seo' ) ?>
                            </button>
                        </form>
                    </li>
                    <li class="m-0 p-1 py-2">
                        <i class="sq_icons_small fa-solid fa-info-circle" style="padding: 2px"></i>
                        <button class="btn btn-sm bg-transparent p-0 m-0" onclick="jQuery('#sq_previewurl_modal').attr('data-post_id', '<?php echo (int) $view->focuspage->user_post_id ?>').sq_inspectURL()" data-dismiss="modal"><?php echo esc_html__( "Inspect URL", 'squirrly-seo' ); ?></button>
                    </li>
                    <li class="m-0 p-1 py-2">
                        <form method="post" class="p-0 m-0" onSubmit="return confirm('<?php echo esc_html__( "Are you sure? You can always monitor it again in the future.", 'squirrly-seo' ) ?>') ">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_delete', 'sq_nonce' ); ?>
                            <input type="hidden" name="action" value="sq_focuspages_delete"/>
                            <input type="hidden" name="id" value="<?php echo (int) $view->focuspage->user_post_id ?>"/>
                            <i class="sq_icons_small fa-solid fa-trash" style="padding: 2px"></i>
                            <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
								<?php echo esc_html__( "Stop Monitoring", 'squirrly-seo' ) ?>
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>


    </td>
<?php } ?>
