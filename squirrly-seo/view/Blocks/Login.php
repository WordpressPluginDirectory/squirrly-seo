<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Login Block view
 *
 * Called from BlockLogin Core
 */
?>
<?php $tab = SQ_Classes_Helpers_Tools::getValue( 'tab', 'register' ); ?>
<div class="card col-12 bg-transparent p-0 border-0">
    <div class="card-body">
		<?php if ( $tab == 'login' ) { ?>
            <form method="post">
				<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_login', 'sq_nonce' ); ?>
                <input type="hidden" name="action" value="sq_login"/>
                <div class="form-group">
                    <label for="sq_email"><?php echo esc_html__( "Email", "squirrly-seo" ) . ': '; ?></label>
                    <input id="sq_email" type="email" class="form-control" autofocus name="email">
                </div>
                <div class="form-group">
                    <label for="sq_pwd"><?php echo esc_html__( "Password", "squirrly-seo" ) . ': '; ?></label>
                    <input id="sq_pwd" type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page', 'sq_dashboard' ), 'register' ) ) ?>"><?php echo esc_html__( "Register to Squirrly.co", "squirrly-seo" ); ?></a>
                    |
                    <a href="<?php echo esc_url( _SQ_DASH_URL_ . '/login?action=lostpassword' ) ?>" target="_blank" title="<?php echo esc_attr__( "Lost password?", "squirrly-seo" ); ?>"><?php echo esc_html__( "Lost password", "squirrly-seo" ); ?></a>
                </div>
                <button type="submit" class="btn btn-lg btn-primary"><?php echo esc_html__( "Login", "squirrly-seo" ); ?></button>

				<?php do_action( 'sq_login_form_after' ); ?>

            </form>
		<?php } else { ?>
            <form id="sq_register" method="post">
				<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_register', 'sq_nonce' ); ?>
                <input type="hidden" name="action" value="sq_register"/>
                <div class="form-group">
                    <label for="sq_email"><?php echo esc_html__( "Email", "squirrly-seo" ) . ': '; ?></label>
                    <input id="sq_email" type="email" class="form-control" name="email" autofocus value="<?php
					$user = wp_get_current_user();
					echo esc_attr( sanitize_email( $user->user_email ) );
					?>">
                </div>
                <div class="form-group">
                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page', 'sq_dashboard' ), 'login' ) ) ?>"><?php echo esc_html__( "I already have an account", "squirrly-seo" ); ?></a>
                </div>
                <div class="form-group">
                    <label for="sq_terms"></label><input type="checkbox" required id="sq_terms" style="height: 18px;width: 18px; margin: 0 10px;"/><?php echo sprintf( esc_html__( "I Agree with the Squirrly %sTerms of Use%s and %sPrivacy Policy%s", "squirrly-seo" ), '<a href="https://www.squirrly.co/terms-of-use" target="_blank" >', '</a>', '<a href="https://www.squirrly.co/privacy-policy" target="_blank" >', '</a>' ); ?>
                </div>
                <button type="submit" class="btn btn-lg btn-primary noloading"><?php echo esc_html__( "Sign Up", "squirrly-seo" ); ?></button>

				<?php do_action( 'sq_register_form_after' ); ?>

            </form>
		<?php } ?>

		<?php do_action( 'sq_login_after' ); ?>

    </div>

</div>
