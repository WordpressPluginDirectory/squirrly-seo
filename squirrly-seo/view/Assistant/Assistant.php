<?php defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Live Assistant view
 *
 * Called from Assistant Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! apply_filters( 'sq_load_snippet', true ) || ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Editor role.", "squirrly-seo" ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 p-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( 'sq_assistant/assistant' ) ?></div>
                <h3 class="mt-4 card-title">
					<?php echo esc_html__( "Optimize with Squirrly Live Assistant", "squirrly-seo" ); ?>
                    <div class="sq_help_question d-inline">
                        <a href="https://howto12.squirrly.co/kb/squirrly-live-assistant/" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                    </div>
                </h3>
                <div class="col-7 small m-0 p-0">
					<?php echo esc_html__( "Use Squirrly to optimize the content for your Posts, Pages, Products, Custom Posts, etc.", "squirrly-seo" ); ?>
                </div>


                <div id="sq_assistant" class="col-12 p-0 m-0">
					<?php do_action( 'sq_subscription_notices' ); ?>

                    <div class="col-12 m-0 p-0 py-5">
                        <div class="col-12 my-3 p-0 text-left">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-lg dropdown-toggle" style="min-width: 200px" type="button" id="add_new_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?php echo esc_html__( "Add New", "squirrly-seo" ); ?>
                                </button>
                                <div class="dropdown-menu mt-1" style="min-width: 200px" aria-labelledby="add_new_dropdown">
									<?php
									$types = get_post_types( array( 'public' => true ) );

									if ( ! empty( $types ) ) {
										foreach ( $types as $value => $name ) { ?>
                                            <a class="dropdown-item" href="<?php echo esc_url( add_query_arg( array( 'post_type' => $value ), admin_url( 'post-new.php' ) ) ) ?>"><?php echo esc_html( ucfirst( $name ) ) ?></a>
											<?php
										}
									}
									?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="sq_tips col-12 m-0 p-0">
                        <h5 class="text-left my-3 font-weight-bold">
                            <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                        </h5>
                        <ul class="mx-4">
                            <li class="text-left"><?php echo esc_html__( "You can use the SEO Live Assistant to optimize new content, as well as previously-created/published content to improve your Google rankings.", "squirrly-seo" ); ?></li>
                            <li class="text-left"><?php echo esc_html__( "The SEO Live Assistant and the Blogging Assistant work hand in hand to help you create content that’s optimized for both search engines and human visitors.", "squirrly-seo" ); ?></li>
                            <li class="text-left"><?php echo esc_html__( "Optimize your pages for one or more keywords using the Live Assistant. Add them as Focus Pages for deeper analysis of your content.", "squirrly-seo" ); ?></li>
                        </ul>
                    </div>

					<?php do_action( 'sq_assistant_after' ); ?>

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
