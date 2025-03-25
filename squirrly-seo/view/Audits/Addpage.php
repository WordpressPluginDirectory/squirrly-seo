<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Audit Add Page view
 *
 * Called from Audits Controller
 */
?>
<?php $patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' ); ?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", "squirrly-seo" ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                    <h3 class="mt-4">
						<?php echo esc_html__( "Add a page in Audit", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/seo-audit/#add_new_audit_page" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small p-0 m-0">
						<?php echo esc_html__( "Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic", "squirrly-seo" ); ?>
                    </div>

                    <div id="sq_auditpage" class="col-12 m-0 p-0 my-4">
                        <div class="row m-0 p-0">
                            <form id="sq_auditpage_form" method="get" class="form-inline col-12 m-0 p-0 ignore">
	                            <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_audits_search', 'sq_nonce', false ); ?>
                                <input type="hidden" name="action" value="sq_audits_search"/>

                                <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">

                                <div class="col-12 row p-0 m-0 my-2">

                                    <div class="col-5 row m-0 p-0">
                                        <div class="col-6 p-0 m-0">
                                            <label>
                                                <select name="stype" class="w-100 m-0 p-1" onchange="jQuery('form#sq_auditpage_form').submit();">
													<?php
													if ( ! empty( $patterns ) ) {
														foreach ( $patterns as $pattern => $name ) {
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
														foreach ( $types as $pattern => $name ) {
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
														foreach ( $taxonomies as $pattern => $name ) {
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
                                                            <select name="sstatus" class="w-100 m-0 p-1" onchange="jQuery('form#sq_auditpage_form').submit();">
                                                                <option <?php echo( ( ! SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) || SQ_Classes_Helpers_Tools::getValue( 'sstatus', false ) == '' ) ? 'selected="selected"' : 'all' ) ?> value=""><?php echo esc_html__( "Any status", "squirrly-seo" ); ?></option>
																<?php

																$statuses = array(
																	'draft',
																	'publish',
																	'pending',
																	'future',
																	'private'
																);
																foreach ( $statuses as $status ) { ?>
                                                                    <option <?php echo( ( $status == SQ_Classes_Helpers_Tools::getValue( 'sstatus', false ) ) ? 'selected="selected"' : '' ) ?> value="<?php echo esc_attr( $status ) ?>"><?php echo esc_html( ucfirst( $status ) ); ?></option>
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
                                            <label for="post-search-input"></label><input type="search" class="d-inline-block align-middle col-6 m-0 p-0 px-1 rounded-0" id="post-search-input" autofocus name="skeyword" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the page you want to search for", "squirrly-seo" ) ?>"/>
                                            <input type="submit" class="btn btn-primary " value="<?php echo esc_attr__( "Search Post", "squirrly-seo" ) ?> >"/>
											<?php if ( ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) && SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) <> '#all' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) || SQ_Classes_Helpers_Tools::getIsset( 'sid' ) || SQ_Classes_Helpers_Tools::getIsset( 'sstatus' ) ) { ?>
                                                <button type="button" class="btn btn-link m-0 ml-1" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'addpage', array( 'stype=' . SQ_Classes_Helpers_Tools::getValue( 'stype', 'post' ) ) ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", "squirrly-seo" ) ?></button>
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
                                            <th><?php echo esc_html__( "Title", "squirrly-seo" ) ?></th>
                                            <th><?php echo esc_html__( "Option", "squirrly-seo" ) ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php
										foreach ( $view->pages as $index => $post ) {

											if ( ! $post instanceof SQ_Models_Domain_Post ) {
												continue;
											}

											$active = false;
											if ( ! empty( $view->auditpage ) ) {

												foreach ( $view->auditpage as $auditpage ) {
													if ( isset( $auditpage->hash ) && isset ( $post->hash ) ) {
														if ( $auditpage->hash == $post->hash ) {
															$active = true;
														}
													}elseif ( isset( $auditpage->permalink ) ) {
														if ( $auditpage->permalink == $post->url ) {
															$active = true;
														}
													}
												}
											}
											?>
                                            <tr>
                                                <td>
                                                    <div class="col-12 px-0 mx-0 font-weight-bold" style="font-size: 15px"><?php echo wp_kses_post( $post->post_title ) ?></div>
                                                    <div class="small">
                                                        <a href="<?php echo esc_url( $post->url ) ?>" class="text-link" rel="permalink" target="_blank"><?php echo esc_url( urldecode( $post->url ) ) ?></a>
                                                    </div>
                                                </td>
                                                <td style="width: 150px; text-align: center; vertical-align: middle">
													<?php if ( ! $active ) { ?>
                                                        <form method="post" class="p-0 m-0">
															<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_audits_addnew', 'sq_nonce' ); ?>
                                                            <input type="hidden" name="action" value="sq_audits_addnew"/>

                                                            <input type="hidden" name="url" value="<?php echo esc_url( $post->url ); ?>">
                                                            <input type="hidden" name="post_id" value="<?php echo (int) $post->ID; ?>">
                                                            <input type="hidden" name="type" value="<?php echo esc_attr( $post->post_type ); ?>">
                                                            <input type="hidden" name="term_id" value="<?php echo (int) $post->term_id; ?>">
                                                            <input type="hidden" name="taxonomy" value="<?php echo esc_attr( $post->taxonomy ); ?>">
                                                            <input type="hidden" name="hash" value="<?php echo esc_attr( $post->hash ); ?>">

                                                            <button type="submit" class="btn btn-sm text-white btn-primary">
																<?php echo esc_html__( "Add Page to Audit", "squirrly-seo" ) ?>
                                                            </button>
                                                        </form>
													<?php } else { ?>
                                                        <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) ) ?>" class="btn btn-sm text-primary bg-link font-weight-bold text-center" style="width: 150px;"><?php echo esc_html__( "See Audits", "squirrly-seo" ) ?></a>
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
											<?php echo esc_html__( "No records found", "squirrly-seo" ); ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
						<?php } ?>

						<?php do_action( 'sq_audits_addpage_after' ); ?>

                    </div>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
                        <li class="text-left small"><?php echo esc_html__( "Use the Search Bar to find a page from your website you want to add to the Audit faster.", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "YOU choose which pages get audited so that you’ll get relevant insights about the pages that you actually want to rank on Google.", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "This also allows you to monitor the pages that are most important to you right now.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
        </div>
    </div>
</div>
