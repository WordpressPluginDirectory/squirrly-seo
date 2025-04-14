<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Briefcase view
 *
 * Called from Research Controller
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
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                <h3 class="mt-4 card-title">
					<?php echo esc_html__( "Briefcase", "squirrly-seo" ); ?>
                    <div class="sq_help_question d-inline">
                        <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                    </div>
                </h3>
                <div class="col-7 small m-0 p-0">
					<?php echo esc_html__( "Briefcase is essential to managing your SEO Strategy. With Briefcase you'll find the best opportunities for keywords you're using in the Awareness Stage, Decision Stage and other stages you may plan for your Customer's Journey.", "squirrly-seo" ); ?>
                </div>
                <div class="col-7 small m-0 p-0 py-2">
                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'gscsync' ) ) ?>"><?php echo esc_html__( 'See and add the exact keywords that drive people to your site.', "squirrly-seo" ) ?></a>
                </div>

                <div id="sq_briefcase" class="col-12 p-0 m-0">
					<?php do_action( 'sq_subscription_notices' ); ?>

					<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) { ?>
                        <div class="row m-0 p-0 py-3">
                            <form method="get" class="form-inline col-12 m-0 p-0">
	                            <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_research_search', 'sq_nonce', false ); ?>
                                <input type="hidden" name="action" value="sq_research_search"/>

                                <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                <input type="hidden" name="ssort" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'ssort' ) ) ?>">
                                <input type="hidden" name="sorder" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'sorder' ) ) ?>">
                                <div class="col-12 m-0 p-0">
                                    <h3 class="card-title text-dark m-0 p-0"><?php echo esc_html__( "Labels", "squirrly-seo" ); ?></h3>
                                </div>


                                <div class="sq_filter_label col-12 m-0 p-0 py-2">
									<?php
									$keyword_labels = SQ_Classes_Helpers_Tools::getValue( 'slabel', array() );
									foreach ( $view->labels as $label ) {
										?>
                                        <input type="checkbox" name="slabel[]" onclick="form.submit();" id="search_checkbox_<?php echo (int) $label->id ?>" style="display: none;" value="<?php echo (int) $label->id ?>" <?php echo( in_array( (int) $label->id, (array) $keyword_labels ) ? 'checked' : '' ) ?> />
                                        <label for="search_checkbox_<?php echo (int) $label->id ?>" class="sq_circle_label fa-solid <?php echo( in_array( (int) $label->id, (array) $keyword_labels ) ? 'sq_active' : '' ) ?>" data-id="<?php echo (int) $label->id ?>" style="background-color: <?php echo esc_attr( $label->color ) ?>" title="<?php echo esc_attr( $label->name ) ?>"><span><?php echo esc_html( $label->name ) ?></span></label>
										<?php

									}
									?>
                                </div>
                            </form>
                        </div>
					<?php } ?>

					<?php if ( isset( $view->keywords ) && ! empty( $view->keywords ) ) { ?>
                        <div class="row col-12 m-0 p-0 my-2">
                            <div class="col-5 p-0 m-0">
                                <select name="sq_bulk_action" class="sq_bulk_action">
                                    <option value=""><?php echo esc_html__( "Bulk Actions", "squirrly-seo" ) ?></option>
                                    <option value="sq_ajax_briefcase_bulk_doserp"><?php echo esc_html__( "Send to Rankings", "squirrly-seo" ); ?></option>
                                    <option value="sq_ajax_briefcase_bulk_label"><?php echo esc_html__( "Assign Label", "squirrly-seo" ); ?></option>
                                    <option value="sq_ajax_briefcase_bulk_delete" data-confirm="<?php echo esc_attr__( "Are you sure you want to delete the keywords?", "squirrly-seo" ) ?>"><?php echo esc_html__( "Delete" ) ?></option>
                                </select>
                                <button class="sq_bulk_submit btn btn-primary"><?php echo esc_html__( "Apply" ); ?></button>

                                <div id="sq_label_manage_popup_bulk" tabindex="-1" class="sq_label_manage_popup modal" role="dialog">
                                    <div class="modal-dialog modal-lg" style="width: 600px;">
                                        <div class="modal-content bg-white rounded-0">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?php echo sprintf( esc_html__( "Select Labels for: %s", "squirrly-seo" ), esc_html__( "selected keywords", "squirrly-seo" ) ); ?></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body" style="min-height: 50px; display: table; margin: 10px;">
                                                <div class="pb-2 mx-2 small text-black-50"><?php echo esc_html__( "By assigning these labels, you will reset the other labels you assigned for each keyword individually.", "squirrly-seo" ); ?></div>
												<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) {
													foreach ( $view->labels as $label ) {
														if ( (int) $label->id == 0 ) {
															continue;
														}
														?>
                                                        <input type="checkbox" name="sq_labels[]" class="sq_bulk_labels" id="popup_checkbox_bulk_<?php echo (int) $label->id ?>" style="display: none;" value="<?php echo (int) $label->id ?>"/>
                                                        <label for="popup_checkbox_bulk_<?php echo (int) $label->id ?>" class="sq_checkbox_label fa-solid" style="background-color: <?php echo esc_attr( $label->color ) ?>" title="<?php echo esc_attr( $label->name ) ?>"><span><?php echo esc_html( $label->name ) ?></span></label>
														<?php
													}
												} else { ?>
                                                    <a class="btn btn-warning" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'labels' ) ) ?>"><?php echo esc_html__( "Add new Label", "squirrly-seo" ); ?></a>
												<?php } ?>
                                            </div>
											<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) { ?>
                                                <div class="modal-footer">
                                                    <button class="sq_bulk_submit btn-modal btn btn-primary"><?php echo esc_html__( "Save Labels", "squirrly-seo" ); ?></button>
                                                </div>
											<?php } ?>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-7 p-0 m-0">
                                <form method="get" class="d-flex flex-row justify-content-end p-0 m-0">
	                                <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_research_search', 'sq_nonce', false ); ?>
                                    <input type="hidden" name="action" value="sq_research_search"/>

                                    <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                    <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                    <input type="hidden" name="ssort" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'ssort' ) ) ?>">
                                    <input type="hidden" name="sorder" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'sorder' ) ) ?>">
                                    <input type="search" class="d-inline-block align-middle col-7 py-0 px-2 mr-0 rounded-0" id="post-search-input" name="skeyword" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the keyword you want to search for", "squirrly-seo" ) ?>"/>
                                    <input type="submit" class="btn btn-primary" value="<?php echo esc_attr__( "Search", "squirrly-seo" ) ?> >"/>
									<?php if ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) ) { ?>
                                        <button type="button" class="btn btn-link text-primary ml-1" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", "squirrly-seo" ) ?></button>
									<?php } ?>
                                </form>
                            </div>
                        </div>
					<?php } ?>

					<?php if ( isset( $view->keywords ) && ! empty( $view->keywords ) ) { ?>

                        <table class="table table-striped table-hover mx-0 p-0 ">
                            <thead>
                            <tr>
                                <th style="width: 10px;"><input type="checkbox" class="sq_bulk_select_input"/></th>
                                <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Keyword", 'squirrly-seo' ), "keyword" ) ?></th>
                                <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Usage", 'squirrly-seo' ), "count" ) ?></th>
                                <th>
									<?php
									if ( $view->checkin->subscription_serpcheck ) {
										SQ_Classes_Helpers_Tools::sort( esc_html__( "Rank", 'squirrly-seo' ), "rank" );
									} else {
										SQ_Classes_Helpers_Tools::sort( esc_html__( "Avg Rank", 'squirrly-seo' ), "rank" );
									}
									?>
                                </th>
                                <th title="<?php echo esc_attr__( "Search Volume", 'squirrly-seo' ) ?>">
									<?php SQ_Classes_Helpers_Tools::sort( esc_html__( "SV", 'squirrly-seo' ), "search" ) ?>
                                </th>
                                <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Research", 'squirrly-seo' ), "score" ) ?></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ( $view->keywords as $key => $row ) { ?>
                                <tr id="sq_row_<?php echo (int) $row->id ?>">
                                    <td style="width: 10px;">
										<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                            <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo esc_attr( $row->keyword ) ?>"/>
										<?php } ?>
                                    </td>
                                    <td style="width: 35%;">
										<?php if ( ! empty( $row->labels ) ) {
											foreach ( $row->labels as $label ) {
												?>
                                                <span class="sq_circle_label fa-solid" style="background-color: <?php echo esc_attr( $label->color ) ?>" data-id="<?php echo (int) $label->lid ?>" title="<?php echo esc_attr( $label->name ) ?>"></span>
												<?php
											}
										} ?>

                                        <span style="display: block; clear: left; float: left;"><?php echo esc_html( $row->keyword ) ?></span>
                                    </td>
                                    <td style="width: 10%;white-space: nowrap;">
										<?php if ( $row->count > 0 ) { ?>
                                            <span data-value="<?php echo (int) $row->count ?>"><a href="javascript:void(0);" onclick="jQuery('#sq_kr_posts<?php echo (int) $key ?>').modal('show')"><?php echo sprintf( esc_html__( "in %s posts", 'squirrly-seo' ), (int) $row->count ) ?></a></span>
										<?php } else { ?>
                                            <span data-value="<?php echo (int) $row->count ?>"><?php echo sprintf( esc_html__( "in %s posts", 'squirrly-seo' ), (int) $row->count ) ?></span>
										<?php } ?>
                                    </td>
                                    <td style="width: 15%;white-space: nowrap;">
										<?php if ( ! $row->rank || $row->rank == 100 ) { ?>
											<?php if ( isset( $row->do_serp ) && ! $row->do_serp ) { ?>
                                                <button class="sq_research_doserp btn btn-sm btn-link text-black-50 p-0 m-0 text-nowrap" data-value="999" data-success="<?php echo esc_attr__( "Check Rankings", 'squirrly-seo' ) ?>" data-link="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings', array(
													'strict=1',
													'skeyword=' . esc_attr( $row->keyword )
												) ) ) ?>" data-keyword="<?php echo esc_attr( $row->keyword ) ?>">
													<?php echo esc_html__( "Send to Rankings", 'squirrly-seo' ) ?>
                                                </button>
											<?php } elseif ( $view->checkin->subscription_serpcheck ) { ?>
                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings', array(
													'strict=1',
													'skeyword=' . esc_attr( $row->keyword )
												) ) ) ?>" data-value="999" style="font-weight: bold;font-size: 15px;"><?php echo esc_html__( "Not indexed", 'squirrly-seo' ) ?></a>
											<?php } else { ?>
                                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings', array(
													'strict=1',
													'skeyword=' . esc_attr( $row->keyword )
												) ) ) ?>" data-value="999" style="font-weight: bold;font-size: 15px;"><?php echo esc_html__( "GSC", 'squirrly-seo' ) ?></a>
											<?php } ?>
										<?php } elseif ( $view->checkin->subscription_serpcheck ) { ?>
                                            <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings', array(
												'strict=1',
												'skeyword=' . esc_attr( $row->keyword )
											) ) ) ?>" data-value="<?php echo (int) $row->rank ?>" target="_blank" style="font-weight: bold;font-size: 15px;"><?php echo (int) $row->rank ?></a>
										<?php } else { ?>
                                            <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings', array(
												'strict=1',
												'skeyword=' . esc_attr( $row->keyword )
											) ) ) ?>" data-value="<?php echo number_format( $row->rank, 1 ); ?>" target="_blank" style="font-weight: bold;font-size: 15px;"><?php echo number_format( $row->rank, 1 ); ?></a>
										<?php } ?>
                                    </td>
                                    <td style="width: 15%;white-space: nowrap;">
										<?php if ( isset( $row->research->sv->absolute ) ) {
											echo '<span data-value="' . (int) $row->research->sv->absolute . '">' . ( ( isset( $row->research->sv->absolute ) && is_numeric( $row->research->sv->absolute ) ) ? number_format( $row->research->sv->absolute ) : $row->research->sv->absolute ) . '</span>';
										} else {
											echo '<span data-value="0">' . "-" . '</span>';
										} ?>
                                    </td>
                                    <td style="width: 20px;">
										<?php if ( isset( $row->research->rank->value ) ) { ?>
                                            <button data-value="<?php echo esc_attr( $row->research->rank->value ) ?>" onclick="jQuery('#sq_kr_research<?php echo (int) $key ?>').modal('show');" class="btn btn-primary btn-sm" style="cursor: pointer; width: 100px"><?php echo esc_html__( "keyword info", 'squirrly-seo' ) ?></button>
                                            <div class="progress" style="max-width: 100px; max-height: 3px">
												<?php
												$progress_color = 'danger';
												switch ( $row->research->rank->value ) {
													case ( $row->research->rank->value < 4 ):
														break;
													case ( $row->research->rank->value < 6 ):
														$progress_color = 'warning';
														break;
													case ( $row->research->rank->value < 8 ):
														$progress_color = 'info';
														break;
													case ( $row->research->rank->value <= 10 ):
														$progress_color = 'success';
														break;
												}
												?>
                                                <div class="progress-bar bg-<?php echo esc_attr( $progress_color ); ?>" role="progressbar" style="width: <?php echo( (int) $row->research->rank->value * 10 ) ?>%" aria-valuenow="<?php echo (int) $row->research->rank->value ?>" aria-valuemin="0" aria-valuemax="10"></div>
                                            </div>
										<?php } else { ?>
                                            <button data-value="0" style="cursor: pointer;" class="btn btn-sm btn-default bg-transparent"><?php echo esc_html__( "No research data", 'squirrly-seo' ) ?></button>
										<?php } ?>
                                    </td>

                                    <td class="px-0 py-2" style="width: 20px">
                                        <div class="sq_sm_menu">
                                            <div class="sm_icon_button sm_icon_options">
                                                <i class="fa-solid fa-ellipsis-v"></i>
                                            </div>
                                            <div class="sq_sm_dropdown">
                                                <ul class="p-2 m-0 text-left">
                                                    <li class="sq_research_selectit m-0 p-1 py-2 noloading">
														<?php $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php?keyword=' . urlencode( esc_attr( $row->keyword ) ) ); ?>
                                                        <a href="<?php echo esc_url( $edit_link ) ?>" target="_blank" class="sq-nav-link">
                                                            <i class="sq_icons_small fa-solid fa-message"></i>
															<?php echo esc_html__( "Optimize for this", 'squirrly-seo' ) ?>
                                                        </a>
                                                    </li>
													<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
														<?php if ( isset( $row->do_serp ) && ! $row->do_serp ) { ?>
                                                            <li class="sq_research_doserp m-0 p-1 py-2" data-success="<?php echo esc_attr__( "Check Rankings", 'squirrly-seo' ) ?>" data-link="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings', array(
																'strict=1',
																'skeyword=' . esc_attr( $row->keyword )
															) ) ) ?>" data-keyword="<?php echo esc_attr( $row->keyword ) ?>">
                                                                <i class="sq_icons_small fa-solid fa-chart-line"></i>
                                                                <span><?php echo esc_html__( "Send to Rank Checker", 'squirrly-seo' ) ?></span>
                                                            </li>
														<?php } ?>
													<?php } ?>
                                                    <li class="m-0 p-1 py-2">
                                                        <i class="sq_icons_small fa-solid fa-key"></i>
														<?php if ( $row->research == '' ) { ?>
                                                            <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research', array( 'keyword=' . esc_attr( $row->keyword ) ) ) ) ?>" class="sq-nav-link"><?php echo esc_html__( "Do a research", 'squirrly-seo' ) ?></a>
														<?php } else { ?>
                                                            <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research', array( 'keyword=' . esc_attr( $row->keyword ) ) ) ) ?>" class="sq-nav-link"><?php echo esc_html__( "Refresh Research", 'squirrly-seo' ) ?></a>
														<?php } ?>
                                                    </li>
                                                    <li class="m-0 p-1 py-2">
                                                        <i class="sq_icons_small fa-solid fa-tag"></i>
                                                        <span onclick="jQuery('#sq_label_manage_popup<?php echo (int) $key ?>').modal('show')"><?php echo esc_html__( "Assign Label", 'squirrly-seo' ); ?></span>
                                                    </li>
													<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                                        <li class="sq_delete m-0 p-1 py-2" data-id="<?php echo (int) $row->id ?>" data-keyword="<?php echo esc_attr( $row->keyword ) ?>">
                                                            <i class="sq_icons_small fa-solid fa-trash"></i>
															<?php echo esc_html__( "Delete Keyword", 'squirrly-seo' ) ?>
                                                        </li>
													<?php } ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
							<?php } ?>

                            </tbody>
                        </table>

						<?php foreach ( $view->keywords as $key => $row ) { ?>

							<?php if ( $row->count > 0 && isset( $row->posts ) && ! empty( $row->posts ) ) { ?>
                                <div id="sq_kr_posts<?php echo (int) $key; ?>" tabindex="-1" class="sq_kr_posts modal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-white rounded-0">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?php echo esc_html__( "Optimized with", 'squirrly-seo' ); ?>
                                                    :
                                                    <strong><?php echo esc_html( $row->keyword ) ?></strong>
                                                    <span style="font-weight: bold; font-size: 110%"></span>
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body" style="min-height: 90px;">
                                                <ul class="col-12" style="list-style: initial">
													<?php
													foreach ( $row->posts as $post_id => $permalink ) { ?>
                                                        <li class="row py-2 border-bottom">
                                                            <a href="<?php echo esc_url( $permalink ) ?>" target="_blank"><?php echo esc_url( $permalink ) ?></a>
                                                        </li>
													<?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php } ?>
                            <div id="sq_kr_research<?php echo (int) $key; ?>" tabindex="-1" class="sq_kr_research modal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content bg-white rounded-0">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?php echo esc_html__( "Keyword", 'squirrly-seo' ); ?>
                                                :
                                                <strong><?php echo esc_html( $row->keyword ) ?></strong>
                                                <span style="font-weight: bold; font-size: 110%"></span>
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body" style="min-height: 90px;">
                                            <ul class="col-12">
												<?php if ( ! isset( $row->country ) ) {
													$row->country = '';
												} ?>
                                                <li class="row py-3 border-bottom">
                                                    <div class="col-4"><?php echo esc_html__( "Country", 'squirrly-seo' ) ?>
                                                        :
                                                    </div>
                                                    <div class="col-6"><?php echo esc_html( $row->country ) ?></div>
                                                </li>
												<?php if ( isset( $row->research->sc ) ) { ?>
                                                    <li class="row py-3 border-bottom">
                                                        <div class="col-4"><?php echo esc_html__( "Competition", 'squirrly-seo' ) ?>
                                                            :
                                                        </div>
                                                        <div class="col-6" style="color: <?php echo esc_attr( $row->research->sc->color ) ?>"><?php echo( esc_attr( $row->research->sc->text ) <> '' ? esc_html( $view->getReasearchStatsText( 'sc', $row->research->sc->value ) ) : '-' ) ?></div>
                                                    </li>
												<?php } ?>
												<?php if ( isset( $row->research->sv ) ) { ?>
                                                    <li class="row py-3 border-bottom">
                                                        <div class="col-4"><?php echo esc_html__( "Search Volume", 'squirrly-seo' ) ?>
                                                            :
                                                        </div>
                                                        <div class="col-6"><?php echo( ( isset( $row->research->sv->absolute ) && is_numeric( $row->research->sv->absolute ) ) ? number_format( $row->research->sv->absolute ) : esc_attr( $row->research->sv->absolute ) ) ?></div>
                                                    </li>
												<?php } ?>
												<?php if ( isset( $row->research->tw ) ) { ?>
                                                    <li class="row py-3 border-bottom">
                                                        <div class="col-4"><?php echo esc_html__( "Recent discussions", 'squirrly-seo' ) ?>
                                                            :
                                                        </div>
                                                        <div class="col-6"><?php echo( esc_attr( $row->research->tw->text ) <> '' ? esc_html( $view->getReasearchStatsText( 'tw', $row->research->tw->value ) ) : '-' ) ?></div>
                                                    </li>
												<?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="sq_label_manage_popup<?php echo (int) $key ?>" tabindex="-1" class="sq_label_manage_popup modal" role="dialog">
                                <div class="modal-dialog modal-lg" style="width: 600px;">
                                    <div class="modal-content bg-white rounded-0">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?php echo sprintf( esc_html__( "Select Labels for: %s", 'squirrly-seo' ), '<strong style="font-size: 115%">' . esc_html( $row->keyword ) . '</strong>' ); ?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body" style="min-height: 50px; display: table; margin: 10px;">
											<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) {

												$keyword_labels = array();
												if ( ! empty( $row->labels ) ) {
													foreach ( $row->labels as $label ) {
														$keyword_labels[] = $label->lid;
													}
												}

												foreach ( $view->labels as $label ) {
													if ( (int) $label->id == 0 ) {
														continue;
													}

													?>
                                                    <input type="checkbox" name="sq_labels" id="popup_checkbox_<?php echo (int) $key ?>_<?php echo (int) $label->id ?>" style="display: none;" value="<?php echo (int) $label->id ?>" <?php echo( in_array( (int) $label->id, $keyword_labels ) ? 'checked' : '' ) ?> />
                                                    <label for="popup_checkbox_<?php echo (int) $key ?>_<?php echo (int) $label->id ?>" class="sq_checkbox_label fa-solid <?php echo( in_array( (int) $label->id, $keyword_labels ) ? 'sq_active' : '' ) ?>" style="background-color: <?php echo esc_attr( $label->color ) ?>" title="<?php echo esc_attr( $label->name ) ?>"><span><?php echo esc_html( $label->name ) ?></span></label>
													<?php
												}

											} else { ?>

                                                <a class="btn btn-warning" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'labels' ) ) ?>"><?php echo esc_html__( "Add new Label", 'squirrly-seo' ); ?></a>

											<?php } ?>
                                        </div>
										<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) { ?>
                                            <div class="modal-footer">
                                                <button data-keyword="<?php echo esc_attr( $row->keyword ) ?>" class="sq_save_keyword_labels btn btn-primary"><?php echo esc_html__( "Save Labels", 'squirrly-seo' ); ?></button>
                                            </div>
										<?php } ?>

                                    </div>
                                </div>

                            </div>
						<?php } ?>

						<?php if ( isset( $view->max_num_pages ) && $view->max_num_pages ) { ?>
                            <div class="row col-12 m-0 p-0 my-2">
                                <div class="col alignleft mr-3">
                                    <label>
                                        <select name="snum" onchange="location.href = '<?php echo esc_url( add_query_arg( array(
											'spage' => 1,
											'snum'  => "'+jQuery(this).find('option:selected').val()+'"
										) ) ); ?>'">
											<?php
											$post_on_page = array( 10, 20, 50, 100, 500 );
											foreach ( $post_on_page as $num ) {
												?>
                                                <option value="<?php echo esc_attr( $num ) ?>" <?php selected( $num, SQ_Classes_Helpers_Tools::getValue( 'snum' ) ) ?> ><?php echo esc_html( $num ) . ' ' . esc_html__( 'records', 'squirrly-seo' ) ?></option><?php
											}
											?>
                                        </select>
                                    </label>

                                    <span class="mx-3"><?php echo esc_html__( "Total", 'squirrly-seo' ); ?>: <?php echo esc_html( $view->total ) ?> <?php echo esc_html__( "records", 'squirrly-seo' ); ?></span>
                                </div>

                                <div class="nav-previous alignright">
									<?php SQ_Classes_Helpers_Tools::pagination( $view->max_num_pages ); ?>
                                </div>
                            </div>
						<?php } ?>

					<?php } elseif ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) || SQ_Classes_Helpers_Tools::getIsset( 'spage' ) ) { ?>
                        <div class="row col-12 m-0 p-0 my-2">
                            <div class="col-5 row m-0 p-0"></div>
                            <div class="col-7 p-0 m-0">
                                <form method="get" class="d-flex flex-row justify-content-end p-0 m-0">
	                                <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_research_search', 'sq_nonce', false ); ?>
                                    <input type="hidden" name="action" value="sq_research_search"/>

                                    <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                    <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                    <input type="hidden" name="ssort" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'ssort' ) ) ?>">
                                    <input type="hidden" name="sorder" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'sorder' ) ) ?>">
                                    <input type="search" class="d-inline-block align-middle col-7 py-0 px-2 mr-0 rounded-0" id="post-search-input" name="skeyword" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the keyword you want to search for", 'squirrly-seo' ) ?>"/>
                                    <input type="submit" class="btn btn-primary" value="<?php echo esc_attr__( "Search", 'squirrly-seo' ) ?> >"/>
                                    <button type="button" class="btn btn-link text-primary ml-1" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page' ), SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", 'squirrly-seo' ) ?></button>
                                </form>
                            </div>
                        </div>
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
					<?php } else { ?>
                        <div class="col-12 my-5 mx-0 p-0">
                            <h4 class="text-center"><?php echo esc_html__( "Welcome to Briefcase", 'squirrly-seo' ); ?></h4>
                            <div class="col-12 m-2 text-center">
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) ) ?>" class="btn btn-lg btn-primary">
                                    <i class="fa-solid fa-plus-square-o"></i> <?php echo esc_html__( "Go Find New Keywords", 'squirrly-seo' ); ?>
                                </a>
                            </div>
                        </div>
					<?php } ?>

					<?php do_action( 'sq_briefcase_after' ); ?>

                </div>

                <div class="sq_tips col-12 m-0 p-0">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo sprintf( esc_html__( "Add unlimited keywords in your Squirrly Briefcase to optimize your posts and pages. %s Learn More About Briefcase %s", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/wordpress-seo/briefcase/" target="_blank" >', '</a>' ); ?></li>
                        <li>
                            <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#labels" target="_blank"><?php echo esc_html__( "Read more details about Briefcase Labels", 'squirrly-seo' ); ?></a>
                        </li>
                    </ul>
                </div>


				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>
            </div>

            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_briefcase_side_after' ); ?>

                </div>
            </div>

        </div>
    </div>
</div>
