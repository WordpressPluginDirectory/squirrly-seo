<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Automation > Add new Types view
 *
 * Called from Automation Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", "squirrly-seo" ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">
                    <form method="POST">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_automation_addpostype', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_automation_addpostype"/>

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?></div>
                        <h3 class="mt-4 card-title">
							<?php echo esc_html__( "Automation", "squirrly-seo" ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/seo-automation/" target="_blank"><i class="fa-solid fa-question-circle" style="margin: 0;"></i></a>
                            </div>
                        </h3>
                        <div class="col-7 small m-0 p-0">
							<?php echo esc_html__( "Add ALL Your Post Types to the Automation section and ensure all your site is covered with excellent SEO.", "squirrly-seo" ); ?>
                        </div>

                        <div class="col-12 p-0 m-0 my-5">

							<?php
							$filter = array( 'public' => true, '_builtin' => false );
							$types  = get_post_types( $filter );

							$new_types = array();
							if ( ! empty( $types ) ) {
								foreach ( $types as $pattern => $name ) {
									if ( apply_filters( 'sq_automation_validate_pattern', $pattern ) ) {
										$new_types[ $pattern ] = $name;
									}
								}
							}

							if ( ! empty( $types ) ) {
								foreach ( $types as $pattern => $name ) {
									if ( ! apply_filters( 'sq_automation_validate_pattern', $pattern ) ) {
										continue;
									}

									if ( $post_type_obj = get_post_type_object( $pattern ) ) {
										if ( ! $post_type_obj->has_archive ) {
											continue;
										}
									}

									if ( in_array( 'archive-' . $pattern, array_keys( SQ_Classes_Helpers_Tools::getOption( 'patterns' ) ) ) ) {
										continue;
									}

									$new_types[ 'archive-' . $pattern ] = $name;
								}
							}

							$filter = array( 'public' => true, );
							$taxonomies = get_taxonomies( $filter );
							if ( ! empty( $taxonomies ) ) {
								foreach ( $taxonomies as $pattern => $name ) {
									if ( in_array( $pattern, array(
										'post_tag',
										'post_format',
										'product_cat',
										'product_tag',
										'product_shipping_class'
									) ) ) {
										continue;
									}

									if ( in_array( 'tax-' . $pattern, array_keys( SQ_Classes_Helpers_Tools::getOption( 'patterns' ) ) ) ) {
										continue;
									}
									$new_types[ 'tax-' . $pattern ] = $name;
								}
							}

							if ( ! empty( $new_types ) ) { ?>
                                <div class="col-12 row m-0 p-0">
                                    <div class="col-12 row py-2 mx-0 my-3">
                                        <div class="col-4 p-1">
                                            <div class="font-weight-bold">
												<?php echo esc_html__( "Add Post Type", "squirrly-seo" ); ?>
                                                :<a href="https://howto12.squirrly.co/kb/seo-automation/#add_post_type" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </div>
                                            <div class="small text-black-50"><?php echo esc_html__( "Add new post types in the list and customize the automation for it.", "squirrly-seo" ); ?></div>
                                        </div>
                                        <div class="col-8 m-0 p-0 input-group">
                                            <label for="sq_select_post_types"></label><select id="sq_select_post_types" name="posttype" class="form-control bg-input m-0">
												<?php
												foreach ( $new_types as $pattern => $name ) {
													?>
                                                    <option value="<?php echo esc_attr( $pattern ) ?>"><?php echo esc_html( ucwords( str_replace( array(
															'-',
															'_'
														), ' ', $pattern ) ) ); ?> (<?php echo esc_html( $pattern ) ?>)
                                                    </option>
												<?php } ?>
                                            </select>

                                            <button type="submit" class="btn btn-primary rounded-0"><?php echo esc_html__( "Add Post Type", "squirrly-seo" ); ?></button>

                                        </div>
                                    </div>
                                </div>

							<?php } else {
								?>
                                <div class="col-12 p-0 m-0 my-3">
                                    <h4 class="my-3"><?php echo esc_html__( "All the post types are sent for Automation", "squirrly-seo" ); ?></h4>
                                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) ) ?>" class="btn btn-primary btn-lg m-0 p-0 py-2 px-4 rounded-0"><?php echo esc_html__( "Start Automation Setup", "squirrly-seo" ); ?></a>
                                </div>

							<?php } ?>

							<?php do_action( 'sq_automation_types_after' ); ?>

                        </div>
                    </form>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "Add ALL Your Post Types to our Automation section, to ensure all your site is covered with excellent SEO.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_automation_types_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
