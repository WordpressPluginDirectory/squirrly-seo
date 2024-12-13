<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Uninstall Block view
 *
 * Called on plugin uninstall as a popup for feedback
 */
?>
<?php
$deactivate_reasons = array(
	'no_longer_needed'               => array(
		'title'             => esc_html__( "I no longer need the plugin", "squirrly-seo" ),
		'input_placeholder' => '',
	),
	'found_a_better_plugin'          => array(
		'title'             => esc_html__( "I found a better plugin", "squirrly-seo" ),
		'input_placeholder' => esc_html__( "Please share which plugin", "squirrly-seo" ),
	),
	'couldnt_get_the_plugin_to_work' => array(
		'title'             => esc_html__( "I couldn't get the plugin to work", "squirrly-seo" ),
		'input_placeholder' => '',
	),
	'temporary_deactivation'         => array(
		'title'             => esc_html__( "It's a temporary deactivation", "squirrly-seo" ),
		'input_placeholder' => '',
	),
	'other'                          => array(
		'title'             => esc_html__( "Other", "squirrly-seo" ),
		'input_placeholder' => esc_html__( "Please share the reason", "squirrly-seo" ),
	),
);
?>
<div id="sq_uninstall" style="display: none;">
    <div id="sq_modal_overlay"></div>
    <div id="sq_modal">
        <div id="sq_uninstall_header">
            <span id="sq_uninstall_header_title"><?php echo esc_html__( "Deactivate", "squirrly-seo" ) . ' ' . esc_html( apply_filters( 'sq_name', _SQ_MENU_NAME_ ) ); ?></span>
        </div>
        <form id="sq_uninstall_form" method="post">
			<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_ajax_uninstall', 'sq_nonce' ); ?>
            <input type="hidden" name="action" value="sq_ajax_uninstall"/>

            <h4><?php echo esc_html__( "Please share why you are deactivating the plugin", "squirrly-seo" ); ?>:</h4>
            <div id="sq_uninstall_form_body">
				<?php foreach ( $deactivate_reasons as $reason_key => $reason ) { ?>
                    <div class="sq_uninstall_feedback_input_line">
                        <input id="sq_uninstall_feedback_<?php echo esc_attr( $reason_key ); ?>" class="sq_uninstall_feedback_input" type="radio" name="reason_key" value="<?php echo esc_attr( $reason_key ); ?>"/>
                        <label for="sq_uninstall_feedback_<?php echo esc_attr( $reason_key ); ?>" class="sq_uninstall_feedback_input_label"><?php echo esc_html( $reason['title'] ); ?></label>
						<?php if ( ! empty( $reason['input_placeholder'] ) ) { ?>
                            <label for="sq_uninstall_feedback_text"></label>
                            <input id="sq_uninstall_feedback_text" class="sq_uninstall_feedback_text" type="text" name="reason_<?php echo esc_attr( $reason_key ); ?>" placeholder="<?php echo esc_attr( $reason['input_placeholder'] ); ?>"/>
						<?php } ?>
						<?php if ( ! empty( $reason['alert'] ) ) { ?>
                            <div class="sq_uninstall_feedback_text"><?php echo esc_html( $reason['alert'] ); ?></div>
						<?php } ?>
                    </div>
				<?php } ?>


                <div class="sq_uninstall_form_buttons_wrapper">
                    <button type="button" class="sq_uninstall_form_submit sq_uninstall_form_button"><?php echo esc_html__( "Submit &amp; Deactivate", "squirrly-seo" ); ?></button>
                    <button type="button" class="sq_uninstall_form_skip sq_uninstall_form_button"><?php echo esc_html__( "Skip &amp; Deactivate", "squirrly-seo" ); ?></button>
                </div>

				<?php if ( SQ_Classes_Helpers_Tools::getOption( 'sq_complete_uninstall' ) ) { ?>
                    <div class="sq_uninstall_form_options_wrapper sq_uninstall_feedback_separator">
                        <div class="sq_uninstall_feedback_input_line" style="color:red; font-size: 14px;">
							<?php echo sprintf( esc_html__( "You set to remove all Squirrly SEO data on uninstall. You can change this option from %s Squirrly > Technical SEO > Advanced Settings %s", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=advanced' ) ) . '">', '</a>' ); ?>
                        </div>
                    </div>
				<?php } else { ?>
                    <div class="sq_uninstall_form_options_wrapper sq_uninstall_feedback_separator">
                        <div class="sq_uninstall_feedback_input_line">
                            <input id="sq_disconnect" class="sq_uninstall_feedback_input" type="checkbox" name="sq_disconnect" value="1"/>
                            <label for="sq_disconnect" class="sq_uninstall_feedback_input_label" style="color: #D32F2F"><?php echo esc_html__( "Disconnect from Squirrly Cloud", "squirrly-seo" ); ?></label>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </form>
    </div>
</div>
