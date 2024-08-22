<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! apply_filters( 'sq_load_snippet', true ) || ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Editor role.", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>

		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 p-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_journey' ) ?></div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockJorney' )->init(); ?>


                <div class="sq_tips col-12 m-0 p-0">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "You'll get", 'squirrly-seo' ); ?>
                        :</h5>
                    <ul class="mx-4">
                        <li class="text-left">
							<?php echo esc_html__( "the chance to fix in 14 days mistakes from years of ineffective SEO.", 'squirrly-seo' ); ?>
                        </li>
                        <li class="text-left">
							<?php echo esc_html__( "the skills you need to succeed in 14 days.", 'squirrly-seo' ); ?>
                        </li>
                        <li class="text-left">
							<?php echo esc_html__( "access to the private JourneyTeam community where you can share your experience and talk about it (good and bad, all is accepted).", 'squirrly-seo' ); ?>
                        </li>
                        <li class="text-left">
							<?php echo esc_html__( "receive help from the JourneyTeam and Private Feedback on your journey from Squirrly.", 'squirrly-seo' ); ?>
                        </li>
                        <li class="text-left">
							<?php echo esc_html__( "an exact recipe to follow for 14 Days to bring one of your pages up in rankings, for a hands-on experience.", 'squirrly-seo' ); ?>
                        </li>
                        <li class="text-left">
							<?php echo esc_html__( "all the costs (to third parties) involved with APIs, technology, cloud computing, etc. are fully sponsored by Squirrly. We sponsor every new member who wishes to become part of the winning JourneyTeam.", 'squirrly-seo' ); ?>
                        </li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
