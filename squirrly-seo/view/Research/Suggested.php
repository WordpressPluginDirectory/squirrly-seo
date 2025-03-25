<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Keywords Suggestion view
 *
 * Called from Research View
 */
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
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                <h3 class="mt-4 card-title">
					<?php echo esc_html__( "Suggested Keywords", 'squirrly-seo' ); ?>
                    <div class="sq_help_question d-inline">
                        <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#suggestions" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                    </div>
                </h3>
                <div class="col-7 small m-0 p-0">
					<?php echo esc_html__( "See the trending keywords suitable for your website's future topics. We check for new keywords weekly based on your latest researches.", 'squirrly-seo' ); ?>
                </div>

                <div id="sq_suggested" class="col-12 p-0 m-0 my-5">
					<?php do_action( 'sq_subscription_notices' ); ?>

                    <div class="col-12 m-0 p-0">

						<?php if ( is_array( $view->suggested ) && ! empty( $view->suggested ) ) { ?>

                            <div class="row col-12 m-0 p-0 my-2">
                                <div class="col-5 p-0 m-0"></div>
                                <div class="col-7 p-0 m-0">
                                    <form method="get" class="d-flex flex-row justify-content-end p-0 m-0">
	                                    <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_research_search', 'sq_nonce', false ); ?>
                                        <input type="hidden" name="action" value="sq_research_search"/>

                                        <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                        <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                        <input type="search" class="d-inline-block align-middle col-7 py-0 px-2 mr-0 rounded-0" id="post-search-input" name="skeyword" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the keyword you want to search for", 'squirrly-seo' ) ?>"/>
                                        <input type="submit" class="btn btn-primary" value="<?php echo esc_attr__( "Search", 'squirrly-seo' ) ?> >"/>
										<?php if ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) ) { ?>
                                            <button type="button" class="btn btn-link text-primary ml-1" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page' ), SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", 'squirrly-seo' ) ?></button>
										<?php } ?>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 30%;"><?php echo esc_html__( "Keyword", 'squirrly-seo' ) ?></th>
                                    <th scope="col" title="<?php echo esc_attr__( "Country", 'squirrly-seo' ) ?>"><?php echo esc_html__( "Co", 'squirrly-seo' ) ?></th>
                                    <th style="width: 150px;">
                                        <i class="fa-solid fa-users" title="<?php echo esc_attr__( "Competition", 'squirrly-seo' ) ?>"></i>
										<?php echo esc_html__( "Competition", 'squirrly-seo' ) ?>
                                    </th>
                                    <th style="width: 80px;">
                                        <i class="fa-solid fa-search" title="<?php echo esc_attr__( "SEO Search Volume", 'squirrly-seo' ) ?>"></i>
										<?php echo esc_html__( "SV", 'squirrly-seo' ) ?>
                                    </th>
                                    <th style="width: 135px;">
                                        <i class="fa-solid fa-comments-o" title="<?php echo esc_attr__( "Recent discussions", 'squirrly-seo' ) ?>"></i>
										<?php echo esc_html__( "Discussion", 'squirrly-seo' ) ?>
                                    </th>
                                    <th style="width: 20px;"></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								foreach ( $view->suggested as $key => $row ) {
									$research       = '';
									$keyword_labels = array();

									if ( $row->data <> '' ) {
										$research = json_decode( $row->data );

										if ( isset( $research->sv->absolute ) && is_numeric( $research->sv->absolute ) ) {
											$research->sv->absolute = number_format( (int) $research->sv->absolute );
										}
									}

									//Check if the keyword is already in briefcase
									$in_briefcase  = ( isset( $row->in_briefcase ) ? $row->in_briefcase : false );
									$in_innerlinks = ( isset( $row->in_innerlinks ) ? $row->in_innerlinks : false );
									$questions     = ( isset( $row->questions ) && $row->questions <> '' ? json_decode( $row->questions ) : false );

									?>
                                    <tr id="sq_row_<?php echo (int) $row->id ?>" class="<?php echo( $in_briefcase ? 'bg-briefcase' : '' ) ?>">
                                        <td style="width: 40%;">
                                            <span style="display: block; clear: left; float: left;"><?php echo esc_html( $row->keyword ) ?></span>
                                        </td>
                                        <td style="width: 10%; white-space: nowrap;">
                                            <span style="display: block; clear: left; float: left;"><?php echo esc_html( $row->country ) ?></span>
                                        </td>
                                        <td style="width: 20%; white-space: nowrap; color: <?php echo esc_attr( $research->sc->color ) ?>"><?php echo( isset( $research->sc->text ) ? '<span data-value="' . esc_attr( $research->sc->value ) . '">' . esc_html( $view->getReasearchStatsText( 'sc', $research->sc->value ) ) . '</span>' : '' ) ?></td>
                                        <td style="width: 15%; white-space: nowrap;"><?php echo( isset( $research->sv ) ? '<span data-value="' . (int) $research->sv->absolute . '">' . ( is_numeric( $research->sv->absolute ) ? number_format( $research->sv->absolute ) . '</span>' : esc_html( $research->sv->absolute ) ) : '' ) ?></td>
                                        <td style="width: 15%; white-space: nowrap;"><?php echo( isset( $research->tw ) ? '<span data-value="' . esc_attr( $research->tw->value ) . '">' . esc_html( $view->getReasearchStatsText( 'tw', $research->tw->value ) ) . '</span>' : '' ) ?></td>
                                        <td class="px-0 py-2" style="width: 20px">
                                            <div class="sq_sm_menu">
                                                <div class="sm_icon_button sm_icon_options">
                                                    <i class="fa-solid fa-ellipsis-v"></i>
                                                </div>
                                                <div class="sq_sm_dropdown">
                                                    <ul class="text-left p-2 m-0 ">
                                                        <li class="sq_research_selectit m-0 p-1 py-2 noloading">
															<?php $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php?keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $row->keyword, 'url' ) ); ?>
                                                            <a href="<?php echo esc_url( $edit_link ) ?>" target="_blank" class="sq-nav-link">
                                                                <i class="sq_icons_small fa-solid fa-message"></i>
																<?php echo esc_html__( "Optimize for this", 'squirrly-seo' ) ?>
                                                            </a>
                                                        </li>
														<?php if ( $in_briefcase ) { ?>
                                                            <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                                <i class="sq_icons_small fa-solid fa-briefcase"></i>
																<?php echo esc_html__( "Already in briefcase", 'squirrly-seo' ); ?>
                                                            </li>
														<?php } else { ?>
                                                            <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo esc_attr( $row->keyword ) ?>">
                                                                <i class="sq_icons_small fa-solid fa-briefcase"></i>
																<?php echo esc_html__( "Add to briefcase", 'squirrly-seo' ); ?>
                                                            </li>
														<?php } ?>
														<?php if ( $in_innerlinks ) { ?>
                                                            <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                                <i class="sq_icons_small dashicons-before dashicons-admin-links"></i>
																<?php echo esc_html__( "Already in innerlinks", 'squirrly-seo' ); ?>
                                                            </li>
														<?php } elseif ( (int) $row->from_post_id > 0 && (int) $row->to_post_id > 0 ) { ?>
															<?php
															$valid = false;
															if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $row->from_post_id ) ) {
																$valid = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $post->post_content, $row->keyword, $row->to_post_id );
															}
															if ( $valid ) {
																?>
                                                                <li class="sq_research_add_innerlinks m-0 p-1 py-2" data-nofollow="<?php echo (int) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' ) ?>" data-blank="<?php echo (int) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_blank' ) ?>" data-from_post_id="<?php echo (int) $row->from_post_id ?>" data-to_post_id="<?php echo (int) $row->to_post_id ?>" data-keyword="<?php echo esc_attr( $row->keyword ) ?>">
                                                                    <i class="sq_icons_small dashicons-before dashicons-admin-links"></i>
																	<?php echo esc_html__( "Add to Inner Links", 'squirrly-seo' ); ?>
                                                                </li>
															<?php }
														} ?>
														<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                                            <li class="sq_delete_found m-0 p-1 py-2" data-id="<?php echo (int) $row->id ?>" data-keyword="<?php echo esc_attr( $row->keyword ) ?>">
                                                                <i class="sq_icons_small fa-solid fa-trash"></i>
																<?php echo esc_html__( "Delete Keyword", 'squirrly-seo' ) ?>
                                                            </li>
														<?php } ?>
                                                        <li class="m-0 p-1 py-2">
                                                            <i class="sq_icons_small fa-solid fa-tag"></i>
                                                            <span onclick="jQuery('#sq_label_manage_popup<?php echo (int) $key ?>').modal('show')"><?php echo esc_html__( "Assign Label", 'squirrly-seo' ); ?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="sq_label_manage_popup<?php echo (int) $key ?>" tabindex="-1" class="sq_label_manage_popup modal" role="dialog">
                                                <div class="modal-dialog modal-lg" style="width: 600px;">
                                                    <div class="modal-content bg-white rounded-0">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo sprintf( esc_html__( "Select Labels for: %s", 'squirrly-seo' ), '<strong style="font-size: 115%">' . esc_html( $row->keyword ) . '</strong>' ); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
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
                                        </td>
                                    </tr>
									<?php if ( $questions && $row->user_post_id ) { ?>
                                        <tr class="bg-white">
                                            <td colspan="6" class="bg-white px-5">

                                                <div class="col-12 row m-0 p-0 my-3">
                                                    <div class="col-lg m-0 p-0">
														<?php echo esc_html__( "Questions for which you can create insightful articles, along with a link to the focus page:", 'squirrly-seo' ) ?>
                                                    </div>
                                                    <div class="m-0 p-0 mx-2">
                                                        <a class="btn btn-sm btn-primary" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'innerlinks' ) ) ?>" target="_blank"><?php echo esc_html__( "Inner Links Assistant", 'squirrly-seo' ) ?></a>
                                                    </div>
                                                    <div class="m-0 p-0 mx-2">
                                                        <a class="btn btn-sm btn-primary" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'sid=' . $row->user_post_id ) ) ) ?>" target="_blank"><?php echo esc_html__( "See Focus Page Details", 'squirrly-seo' ) ?></a>
                                                    </div>
                                                </div>

                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="3"><?php echo esc_html__( "Related Questions Found", 'squirrly-seo' ) ?>
                                                            :
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													<?php foreach ( $questions as $subkey => $question ) {
														if ( isset( $question->keyword ) && isset( $question->in_briefcase ) ) { ?>
                                                            <tr class="<?php echo( $question->in_briefcase ? 'bg-briefcase' : '' ) ?>">
                                                                <td>
																	<?php echo esc_html( $question->keyword ) ?>
                                                                </td>
                                                                <td>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    <div class="sq_sm_menu">
                                                                        <div class="sm_icon_button sm_icon_options">
                                                                            <i class="fa-solid fa-ellipsis-v"></i>
                                                                        </div>
                                                                        <div class="sq_sm_dropdown">
                                                                            <ul class="text-left p-2 m-0 ">
                                                                                <li class="sq_research_selectit m-0 p-1 py-2 noloading">
																					<?php $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( '/post-new.php?keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $question->keyword, 'url' ) ); ?>
                                                                                    <a href="<?php echo esc_url( $edit_link ) ?>" target="_blank" class="sq-nav-link">
                                                                                        <i class="sq_icons_small fa-solid fa-message"></i>
																						<?php echo esc_html__( "Optimize for this", 'squirrly-seo' ) ?>
                                                                                    </a>
                                                                                </li>

																				<?php if ( $question->in_briefcase ) { ?>
                                                                                    <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                                                        <i class="sq_icons_small fa-solid fa-briefcase"></i>
																						<?php echo esc_html__( "Already in briefcase", 'squirrly-seo' ); ?>
                                                                                    </li>
																				<?php } else { ?>
                                                                                    <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo esc_attr( $question->keyword ) ?>">
                                                                                        <i class="sq_icons_small fa-solid fa-briefcase"></i>
																						<?php echo esc_html__( "Add to briefcase", 'squirrly-seo' ); ?>
                                                                                    </li>
																				<?php } ?>

																				<?php if ( isset( $question->in_innerlinks ) && $question->in_innerlinks ) { ?>
                                                                                    <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                                                        <i class="sq_icons_small dashicons-before dashicons-admin-links"></i>
																						<?php echo esc_html__( "Already in innerlinks", 'squirrly-seo' ); ?>
                                                                                    </li>
																				<?php } elseif ( (int) $question->from_post_id > 0 && (int) $question->to_post_id > 0 ) { ?>
																					<?php
																					$valid = false;
																					if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $question->from_post_id ) ) {
																						$valid = SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->checkInnerLink( $post->post_content, $question->keyword, $question->to_post_id );
																					}
																					if ( $valid ) {
																						?>
                                                                                        <li class="sq_research_add_innerlinks m-0 p-1 py-2" data-nofollow="<?php echo (int) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' ) ?>" data-blank="<?php echo (int) SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_blank' ) ?>" data-from_post_id="<?php echo (int) $question->from_post_id ?>" data-to_post_id="<?php echo (int) $question->to_post_id ?>" data-keyword="<?php echo esc_attr( $question->keyword ) ?>">
                                                                                            <i class="sq_icons_small dashicons-before dashicons-admin-links"></i>
																							<?php echo esc_html__( "Add to Inner Links", 'squirrly-seo' ); ?>
                                                                                        </li>
																					<?php }
																				} ?>
                                                                                <li class="m-0 p-1 py-2">
                                                                                    <i class="sq_icons_small fa-solid fa-tag"></i>
                                                                                    <span onclick="jQuery('#sq_label_manage_popup<?php echo md5( $question->keyword ) ?>').modal('show')"><?php echo esc_html__( "Assign Label", 'squirrly-seo' ); ?></span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div id="sq_label_manage_popup<?php echo md5( $question->keyword ) ?>" tabindex="-1" class="sq_label_manage_popup modal" role="dialog">
                                                                        <div class="modal-dialog modal-lg" style="width: 600px;">
                                                                            <div class="modal-content bg-white rounded-0">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title"><?php echo sprintf( esc_html__( "Select Labels for: %s", 'squirrly-seo' ), '<strong style="font-size: 115%">' . esc_html( $question->keyword ) . '</strong>' ); ?></h4>
                                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                                        &times;
                                                                                    </button>
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
                                                                                            <input type="checkbox" name="sq_labels" id="popup_checkbox_<?php echo md5( $question->keyword ) ?>_<?php echo (int) $label->id ?>" style="display: none;" value="<?php echo (int) $label->id ?>" <?php echo( in_array( (int) $label->id, $keyword_labels ) ? 'checked' : '' ) ?> />
                                                                                            <label for="popup_checkbox_<?php echo md5( $question->keyword ) ?>_<?php echo (int) $label->id ?>" class="sq_checkbox_label fa-solid <?php echo( in_array( (int) $label->id, $keyword_labels ) ? 'sq_active' : '' ) ?>" style="background-color: <?php echo esc_attr( $label->color ) ?>" title="<?php echo esc_attr( $label->name ) ?>"><span><?php echo esc_html( $label->name ) ?></span></label>
																							<?php
																						}

																					} else { ?>

                                                                                        <a class="btn btn-warning" href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'labels' ) ) ?>"><?php echo esc_html__( "Add new Label", 'squirrly-seo' ); ?></a>

																					<?php } ?>
                                                                                </div>
																				<?php if ( isset( $view->labels ) && ! empty( $view->labels ) ) { ?>
                                                                                    <div class="modal-footer">
                                                                                        <button data-keyword="<?php echo esc_attr( $question->keyword ) ?>" class="sq_save_keyword_labels btn btn-primary"><?php echo esc_html__( "Save Labels", 'squirrly-seo' ); ?></button>
                                                                                    </div>
																				<?php } ?>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </td>
                                                            </tr>
														<?php } ?>
													<?php } ?>

                                                    </tbody>
                                                </table>


                                            </td>
                                        </tr>
									<?php } ?>
									<?php
								}
								?>
                                </tbody>
                            </table>

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
                            <div class="my-5">
                                <h4 class="text-center"><?php echo esc_html__( "Welcome to Suggested Keywords", 'squirrly-seo' ); ?></h4>
                                <h5 class="text-center mt-4"><?php echo esc_html__( "Once a week, Squirrly checks all the keywords from your briefcase.", 'squirrly-seo' ); ?></h5>
                                <h5 class="text-center"><?php echo esc_html__( "If it finds better keywords, they will be listed here", 'squirrly-seo' ); ?></h5>
                                <h6 class="text-center text-black-50 mt-3"><?php echo esc_html__( "Until then, add keywords in Briefcase", 'squirrly-seo' ); ?>
                                    :</h6>
                                <div class="col-12 my-4 text-center">
                                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) ) ?>" class="btn btn-lg btn-primary">
                                        <i class="fa-solid fa-plus-square-o"></i> <?php echo esc_html__( "Go Find New Keywords", 'squirrly-seo' ); ?>
                                    </a>
                                </div>
                            </div>
						<?php } ?>
                    </div>

					<?php do_action( 'sq_suggested_after' ); ?>

                </div>

                <div class="sq_tips col-12 m-0 p-0">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "The Keyword Research Assistant performs Keyword Researches on your behalf WITHOUT using any keyword research credits from your total of available keyword research credits.", 'squirrly-seo' ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Consider using relevant keywords that have a high ranking chance and over 1,000 monthly searches in your SEO strategy. Save them to your Briefcase.", 'squirrly-seo' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_suggested_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
