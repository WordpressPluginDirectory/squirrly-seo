<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Bulk SEO view
 *
 * Called from Bulk SEO Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' )->init(); ?>
	<?php SQ_Classes_ObjController::getClass( 'SQ_Controllers_Patterns' )->init(); ?>
	<?php $patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' ); ?>
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
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?></div>
                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Bulk SEO", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/bulk-seo/" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small m-0 p-0">
						<?php echo esc_html__( "Simplify the SEO process for all your post type and optimize them in just minutes.", "squirrly-seo" ); ?>
                    </div>

                    <div id="sq_seosettings_bulkseo" class="col-12 m-0 p-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

                        <div class="col-12 m-0 p-0 my-4">

                            <form id="sq_bulkseo_form" method="get" class="form-inline col-12 m-0 p-0 ignore">
	                            <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_bulkseo_search', 'sq_nonce', false ); ?>
                                <input type="hidden" name="action" value="sq_bulkseo_search"/>

                                <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">

								<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) { ?>
                                    <div class="col-12 row p-0 m-0">
                                        <div class="col-5 row m-0 p-0">
                                            <div class="col-6 p-0 m-0">
                                                <label>
                                                    <select name="slabel[]" class="w-100 m-0 p-1" onchange="jQuery('form#sq_bulkseo_form').submit();">
                                                        <option value=""><?php echo esc_html__( "Filter by Red Element", "squirrly-seo" ) ?></option>
                                                        <?php
                                                        $keyword_labels = SQ_Classes_Helpers_Tools::getValue( 'slabel', array() );
                                                        foreach ( $view->labels as $category => $label ) {
                                                            if ( $label->show ) { ?>
                                                                <option value="<?php echo esc_attr( $category ) ?>" <?php echo( in_array( (string) $category, (array) $keyword_labels ) ? 'selected="selected"' : '' ) ?> ><?php echo esc_html( $label->name ) ?></option>
                                                            <?php }
                                                        }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>

                                <div class="col-12 row p-0 m-0 my-2">
                                    <div class="col-5 row m-0 p-0">
                                        <div class="col-6 p-0 m-0">
                                            <label>
                                                <select name="stype" class="w-100 m-0 p-1" onchange="jQuery('form#sq_bulkseo_form').submit();">
													<?php
													if ( ! empty( $patterns ) ) {
														foreach ( $patterns as $pattern => $type ) {
															if ( in_array( $pattern, array(
																'custom',
																'tax-category',
																'search',
																'archive',
																'404'
															) ) ) {
																continue;
															}
															if ( strpos( $pattern, 'product' ) !== false || strpos( $pattern, 'shop' ) !== false ) {
																if ( ! SQ_Classes_Helpers_Tools::isEcommerce() ) {
																	continue;
																}
															}

															?>
                                                            <option <?php echo( ( $pattern == SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $pattern ) ?>"><?php echo esc_html( ucwords( str_replace( array(
																	'-',
																	'_'
																), ' ', $pattern ) ) ); ?></option>
															<?php
														}
													}

													$filter = array( 'public' => true, '_builtin' => false );
													$types  = get_post_types( $filter );
													if ( ! empty( $types ) ) {
														foreach ( $types as $pattern => $type ) {
															if ( in_array( $pattern, array_keys( $patterns ) ) ) {
																continue;
															}
															?>
                                                            <option <?php echo( ( $pattern == SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $pattern ) ?>"><?php echo esc_html( ucwords( str_replace( array(
																	'-',
																	'_'
																), ' ', $pattern ) ) ); ?></option>
															<?php
														}
													}

													$filter     = array( 'public' => true, );
													$taxonomies = get_taxonomies( $filter );
													if ( ! empty( $taxonomies ) ) {
														foreach ( $taxonomies as $pattern => $type ) {
															//remove tax that are already included in patterns
															if ( in_array( $pattern, array(
																'post_tag',
																'post_format',
																'product_cat',
																'product_tag',
																'product_shipping_class'
															) ) ) {
																continue;
															}
															if ( in_array( $pattern, array_keys( $patterns ) ) ) {
																continue;
															}
															?>
                                                            <option <?php echo( ( $pattern == SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $pattern ) ?>"><?php echo esc_html( ucwords( str_replace( array(
																	'-',
																	'_'
																), ' ', $pattern ) ) ); ?></option>
															<?php
														}
													}
													?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-6 p-0 m-0">
											<?php if ( ! SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) && ! empty( $view->pages ) ) {

                                                foreach ( $view->pages as $index => $post ) {
													if ( isset( $post->ID ) ) {
														?>
                                                        <label>
                                                            <select name="sstatus" class="w-100 m-0 p-1" onchange="jQuery('form#sq_bulkseo_form').submit();">
                                                                <option <?php echo( ( ! SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) || SQ_Classes_Helpers_Tools::getValue( 'sstatus' ) == '' ) ? 'selected="selected"' : 'all' ) ?> value=""><?php echo esc_html__( "Any status", "squirrly-seo" ); ?></option>
																<?php

																$statuses = array(
																	'draft',
																	'publish',
																	'pending',
																	'future',
																	'private'
																);
																foreach ( $statuses as $status ) { ?>
                                                                    <option <?php echo( ( $status == SQ_Classes_Helpers_Tools::getValue( 'sstatus' ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $status ) ?>"><?php echo esc_html( ucfirst( $status ) ); ?></option>
																	<?php
																}
																?>
                                                            </select>
                                                        </label>
														<?php
														break;
													}
												}
											} ?>
                                        </div>
                                    </div>
                                    <div class="col-7 row m-0 p-0">
                                        <div class="d-flex flex-row flex-grow-1 justify-content-end m-0 p-0">
                                            <label for="post-search-input"></label><input type="search" class="d-inline-block align-middle col-6 m-0 p-0 px-1 rounded-0" id="post-search-input" autofocus name="skeyword" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the post you want to search for", "squirrly-seo" ) ?>"/>
                                            <input type="submit" class="btn btn-primary " value="<?php echo esc_attr__( "Search Keyword", "squirrly-seo" ) ?> >"/>
											<?php if ( ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) && SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) <> '#all' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) || SQ_Classes_Helpers_Tools::getIsset( 'sid' ) || SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) ) { ?>
                                                <button type="button" class="btn btn-link m-0 ml-1" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo', array( 'stype=' . SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", "squirrly-seo" ) ?></button>
											<?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </form>

                            <div class="col-12 m-0 p-0 position-relative">
								<?php
								$post_type  = SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' );
								$categories = SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->getCategories();
								?>
                                <div class="sq_overflow col-12 m-0 p-0 flexcroll">
                                    <div class="col-12 m-0 p-0 border-0 " style="display: inline-block;">

                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th><?php echo esc_html__( "Title", "squirrly-seo" ) ?></th>
												<?php
												if ( ! empty( $categories ) ) {
													foreach ( $categories as $category_title ) {
														echo '<th>' . esc_html( $category_title ) . '</th>';
													}
												}
												?>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php
											$loaded_posts = array();
											if ( ! empty( $view->pages ) ) {
												foreach ( $view->pages as $index => $post ) {
													if ( ! $post ) {
														continue;
													} //don't load post if errors
													if ( in_array( $post->hash, $loaded_posts ) ) {
														continue;
													} //don't load post for multiple times

													$can_edit_post = ( $post->ID && SQ_Classes_Helpers_Tools::userCan( 'edit_post', $post->ID ) );
													$can_edit_tax  = ( $post->term_id && SQ_Classes_Helpers_Tools::userCan( 'edit_term', $post->term_id ) );
													if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) && ! $can_edit_tax && ! $can_edit_post ) {
														continue;
													}
													?>
                                                    <tr id="sq_row_<?php echo esc_attr( $post->hash ) ?>" class="<?php echo( (int) $index % 2 ? 'even' : 'odd' ) ?>">
														<?php
														$view->post = $post;
														$view->show_view( 'Assistant/BulkseoRow' );
														?>
                                                    </tr>

                                                    <div id="sq_blocksnippet_<?php echo esc_attr( $post->hash ) ?>" data-snippet="backend" class="sq_blocksnippet shadow-sm border-bottom" style="display: none"><?php
														SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' )->setPost( $post );
														SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' )->show_view( 'Snippet/Snippet' ); ?>
                                                    </div>
													<?php
													$loaded_posts[] = $post->hash;
												}
											} else { ?>
                                                <tr id="sq_row" class="even">
                                                    <td colspan="<?php echo( count( (array) $categories ) + 1 ) ?>" class="text-center">
														<?php if ( ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) && SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) <> '#all' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) || SQ_Classes_Helpers_Tools::getIsset( 'sid' ) || SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) ) { ?>
															<?php echo sprintf( esc_html__( "No data for this filter. %sShow All%s records for this post type.", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo', array( 'stype=' . SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ) ) . '" >', '</a>' ) ?>
														<?php } else { ?>
															<?php echo esc_html__( "No data found for this post type. Try other post types.", "squirrly-seo" ) ?>
														<?php } ?>
                                                    </td>
                                                </tr>

											<?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="nav-previous alignright"><?php the_posts_pagination( array(
													'mid_size'  => 3,
													'base'      => 'admin.php%_%',
													'format'    => '?spage=%#%',
													'current'   => (int) SQ_Classes_Helpers_Tools::getValue( 'spage', 1 ),
													'prev_text' => esc_html__( "Previous", "squirrly-seo" ),
													'next_text' => esc_html__( "Next", "squirrly-seo" ),
												) ); ?></div>
                                    </div>

                                </div>
                            </div>

							<?php do_action( 'sq_bulkseo_after' ); ?>

                        </div>
                    </div>
                </div>

                <h3><?php echo esc_html__( "Start Using This Section in 1,2,3", "squirrly-seo" ); ?></h3>
                <div class="row row-cols-1 row-cols-md-3 px-0 mx-0">

                    <div class="col px-2 py-0 mb-5">
                        <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                            <div class="m-0 p-0">
                                <div class="m-0 p-0 text-center">
                                    <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/checklist.png' ) ?>" alt="" style="width: 100%">
                                </div>
                                <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                    <div class="pt-3 pb-1" style="color: #696868">
										<?php echo esc_html__( "1. Click On A Section", "squirrly-seo" ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col px-2 py-0 mb-5">
                        <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                            <div class="m-0 p-0">
                                <div class="m-0 p-0 text-center">
                                    <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/checklist.png' ) ?>" alt="" style="width: 100%">
                                </div>
                                <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                    <div class="pt-3 pb-1" style="color: #696868">
										<?php echo esc_html__( "2. Click On A Task", "squirrly-seo" ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col px-2 py-0 mb-5">
                        <div class="sq_feature card h-100 p-0 shadow-0 rounded-0">
                            <div class="m-0 p-0">
                                <div class="m-0 p-0 text-center">
                                    <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/kb/checklist.png' ) ?>" alt="" style="width: 100%">
                                </div>
                                <div class="mx-3 my-3 p-0 text-black" style="min-height: 60px; font-size: 1.1rem;">
                                    <div class="pt-3 pb-1" style="color: #696868">
										<?php echo esc_html__( "3. Read Task Details", "squirrly-seo" ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col px-2 py-0 mb-5"></div>
                </div>


                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "Each Red, Gray, or Green dot from each section in BULK SEO is clickable.", "squirrly-seo" ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Correct the SEO for the entire website in just minutes. Simply turn Red Elements Green, and you’ll score massive SEO gains.", "squirrly-seo" ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Filter by Red Element to group pages together based on common issues they have to better organize and prioritize your work.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
                    <div class="sq_assistant">
                        <div class="card-title text-center text-black-50 mt-3"><?php echo esc_html__( 'Bulk SEO Mastery Tasks', "squirrly-seo" ) ?></div>
                    </div>
					<?php
					$loaded_posts = array();
					if ( ! empty( $view->pages ) ) {
						foreach ( $view->pages as $post ) {
							if ( in_array( $post->hash, $loaded_posts ) ) {
								continue;
							} //don't load post for multiple times
							?>
                            <div id="sq_assistant_<?php echo esc_attr( $post->hash ) ?>" class="sq_assistant">
								<?php
								$categories = apply_filters( 'sq_assistant_categories_page', $post->hash );

								if ( ! empty( $categories ) ) {
									foreach ( $categories as $index => $category ) {
										if ( isset( $category->assistant ) ) {
											//show /view/Assistant/Assistant.php for the current Bulk Page
											echo $category->assistant;
										}
									}
								}
								?>
                            </div>
							<?php
							$loaded_posts[] = $post->hash;

						}
					} ?>

					<?php do_action( 'sq_bulkseo_side_after' ); ?>

                </div>
            </div>

        </div>
    </div>
</div>
