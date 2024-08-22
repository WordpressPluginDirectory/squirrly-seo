<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Focus Pages Add view
 *
 * Called from Focus Pages Controller
 *
 */
?>
<?php $patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' ); ?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4 pb-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab', 'addpage' ) ) ?></div>

                    <h3 class="mt-4">
						<?php echo esc_html__( "Add a page in Focus Pages", 'squirrly-seo' ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#add_new_focus_page" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small p-0 m-0">
						<?php echo esc_html__( "Focus Pages bring you clear methods to take your pages from never found to always found on Google. Rank your pages by influencing the right ranking factors. Turn everything that you see here to Green and you will win.", 'squirrly-seo' ); ?>
                    </div>


                    <div id="sq_focuspages" class="col-12 m-0 p-0 my-4">
                        <div class="row m-0 p-0">
                            <form id="sq_auditpage_form" method="get" class="form-inline col-12 m-0 p-0 ignore">
                                <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">

                                <div class="col-12 row p-0 m-0 my-2">

                                    <div class="col-5 row m-0 p-0">
                                        <div class="col-6 row p-0 m-0">
                                            <label>
                                                <select name="stype" class="w-100 m-0 p-1" onchange="jQuery('form#sq_auditpage_form').submit();">
													<?php
													if ( ! empty( $patterns ) ) {
														foreach ( $patterns as $pattern => $type ) {
															if ( in_array( $pattern, array(
																'elementor_library',
																'ct_template',
																'oxy_user_library',
																'fusion_template'
															) ) ) {
																continue;
															}
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
                                        <div class="col-6 row p-0 m-0">
											<?php if ( ! SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) && ! empty( $view->pages ) ) {
												foreach ( $view->pages as $index => $post ) {
													if ( isset( $post->ID ) ) {
														?>
                                                        <label>
                                                            <select name="sstatus" class="w-100 m-0 p-1" onchange="jQuery('form#sq_auditpage_form').submit();">
                                                                <option <?php echo( ( ! SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) || SQ_Classes_Helpers_Tools::getValue( 'sstatus' ) == '' ) ? 'selected="selected"' : 'all' ) ?> value=""><?php echo esc_html__( "Any status", 'squirrly-seo' ); ?></option>
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
                                            <label for="post-search-input"></label><input type="search" class="d-inline-block align-middle col-6 m-0 p-0 px-1 rounded-0" id="post-search-input" autofocus name="skeyword" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the page you want to search for", 'squirrly-seo' ) ?>"/>
                                            <input type="submit" class="btn btn-primary " value="<?php echo esc_attr__( "Search Post", 'squirrly-seo' ) ?> >"/>
											<?php if ( ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) && SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) <> '#all' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) || SQ_Classes_Helpers_Tools::getIsset( 'sid' ) || SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) ) { ?>
                                                <button type="button" class="btn btn-link m-0 ml-1" onclick="location.href = '<?php echo esc_url( add_query_arg( array( 'stype=' => SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", 'squirrly-seo' ) ?></button>
											<?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>


						<?php if ( ! empty( $view->pages ) ) { ?>
                            <div class="col-12 m-0 p-0 position-relative">
                                <div class="col-12 m-0 p-0" style="display: inline-block;">

                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th><?php echo esc_html__( "Title", 'squirrly-seo' ) ?></th>
                                            <th><?php echo esc_html__( "Option", 'squirrly-seo' ) ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php
										foreach ( $view->pages as $index => $post ) {
											if ( ! $post instanceof SQ_Models_Domain_Post ) {
												continue;
											}

											$active = false;
											if ( ! empty( $view->focuspages ) ) {
												foreach ( $view->focuspages as $focuspage ) {
													if ( $focuspage->hash == $post->hash ) {
														$active = true;
														break;
													}
												}
											}
											?>
                                            <tr>
                                                <td>
                                                    <div class="col-12 px-0 mx-0 font-weight-bold" style="font-size: 15px"><?php echo esc_html( $post->post_title ) ?></div>
                                                    <div class="small " style="font-size: 11px"><?php echo '<a href="' . esc_url( $post->url ) . '" class="text-link" rel="permalink" target="_blank">' . esc_url( urldecode( $post->url ) ) . '</a>' ?></div>

                                                </td>
                                                <td style="width: 150px; text-align: center; vertical-align: middle">
													<?php if ( ! $active ) {
														if ( isset( $post->ID ) && $post->ID > 0 ) {
															?>
                                                            <form method="post" class="p-0 m-0">
																<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_addnew', 'sq_nonce' ); ?>
                                                                <input type="hidden" name="action" value="sq_focuspages_addnew"/>

                                                                <input type="hidden" name="url" value="<?php echo esc_url( $post->url ); ?>">
                                                                <input type="hidden" name="post_id" value="<?php echo (int) $post->ID; ?>">
                                                                <input type="hidden" name="type" value="<?php echo esc_attr( $post->post_type ); ?>">
                                                                <input type="hidden" name="term_id" value="<?php echo (int) $post->term_id; ?>">
                                                                <input type="hidden" name="taxonomy" value="<?php echo esc_attr( $post->taxonomy ); ?>">

                                                                <button type="submit" class="btn btn-sm text-white btn-primary" style="width: 150px;">
																	<?php echo esc_html__( "Set Focus Page", 'squirrly-seo' ) ?>
                                                                </button>
                                                            </form>
														<?php } else { ?>
                                                            <span class="text-danger font-weight-bold text-center" title="<?php echo esc_attr__( "Only pages with IDs can be added as Focus Page", 'squirrly-seo' ) ?>"><?php echo esc_html__( "Can't be added", 'squirrly-seo' ) ?> <a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#add_new_focus_page" target="_blank"><i class="fa-solid fa-question-circle"></i></a></span>
														<?php } ?>
													<?php } else { ?>
                                                        <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ) ) ?>" class="btn btn-sm bg-link text-primary font-weight-bold text-center" style="width: 150px;"><?php echo esc_html__( "See Tasks", 'squirrly-seo' ) ?></a>
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
												'prev_text' => esc_html__( "Previous", 'squirrly-seo' ),
												'next_text' => esc_html__( "Next", 'squirrly-seo' ),
											) ); ?></div>
                                </div>

                            </div>
						<?php } else { ?>
                            <div class="col-12 m-0 p-0">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
											<?php echo esc_html__( "No records found", 'squirrly-seo' ); ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
						<?php } ?>

						<?php do_action( 'sq_focuspages_addpage_after' ); ?>

                    </div>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
                        <li class="text-left"><?php echo esc_html__( "Select the page you want to add to focus pages and start working on it.", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "The Focus Pages strategy can successfully be applied to any website, in any niche, big or small.", 'squirrly-seo' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>

        </div>
    </div>
</div>
