<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Rankings view
 *
 * Called from Rankings Controller
 */
?>
<?php
$date_format = get_option( 'date_format' );
$time_format = get_option( 'time_format' );
$timezone    = (int) get_option( 'gmt_offset' );
$connect     = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'connect' ) ) );

$view->checkin->subscription_serpcheck = ( isset( $view->checkin->subscription_serpcheck ) ? $view->checkin->subscription_serpcheck : 0 );
$days_back                             = (int) SQ_Classes_Helpers_Tools::getValue( 'days_back', 30 );

//Load required chart scripts
$view->loadScripts();
?>
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

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?></div>
                    <h3 class="mt-4">
						<?php echo esc_html__( "Google Rankings", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 px-0 py-2">
						<?php echo esc_html__( "It's a fully functional SEO Ranking Tool that helps you find the true position of your website in Google for any keyword and any country you want", "squirrly-seo" ); ?>
						<?php if ( $connect->google_search_console ) { ?><?php echo sprintf( esc_html__( "%s See and add the exact keywords that drive people to your site. %s", "squirrly-seo" ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'gscsync' ) ) . '" target="_blank">', '</a>' ); ?><?php } ?>
                    </div>

                    <div id="sq_ranks" class="col-12 m-0 p-0 border-0">
						<?php do_action( 'sq_subscription_notices' ); ?>

						<?php if ( isset( $view->ranks ) && ! empty( $view->ranks ) ) { ?>

							<?php if ( $view->checkin->subscription_serpcheck ) { ?>
								<?php if ( isset( $view->info ) && ! empty( $view->info ) ) { ?>
									<?php if ( ! SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) { ?>
                                        <div class="sq_stats row p-0 m-0 my-2">
                                            <div class="card col-6 p-0 m-0 bg-white shadow-sm">
												<?php
												if ( isset( $view->info->average ) && ! empty( $view->info->average ) ) {
													$today_average = end( $view->info->average );
													$today_average = number_format( (int) $today_average[1], 2 );
													reset( $view->info->average );
												} else {
													$today_average = '0';
												}

												if ( isset( $view->info->average ) && count( (array) $view->info->average ) > 1 ) {
													foreach ( $view->info->average as $key => $average ) {
														if ( $key > 0 && ! empty( $view->info->average[ $key ] ) ) {
															$view->info->average[ $key ][0] = gmdate( 'm/d/Y', strtotime( $view->info->average[ $key ][0] ) );
															$view->info->average[ $key ][1] = (float) $view->info->average[ $key ][1];
															if ( $view->info->average[ $key ][1] == 0 ) {
																$view->info->average[ $key ][1] = 100;
															}
														}
														$average[1] = (int) $average[1];
													}

												}
												?>
                                                <div class="card-content overflow-hidden m-0">
                                                    <div class="media align-items-stretch">
                                                        <div class="media-body p-3">
                                                            <div class="col-12 row">
                                                                <div class="col-6 border-right">
                                                                    <h5>
                                                                        <a href="<?php echo esc_url( add_query_arg( array( 'ranked' => 1 ), SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings' ) ) ) ?>" data-toggle="tooltip" title="<?php echo esc_attr__( "Only show ranked articles", "squirrly-seo" ) ?>">
                                                                            <i class="fa-solid fa-line-chart pull-left mt-1" aria-hidden="true"></i>
																			<?php echo( (int) $today_average == 0 ? 100 : number_format( $today_average, 2 ) ) ?>
                                                                        </a></h5>
                                                                    <span class="small"><?php echo esc_html__( "Today Avg. Ranking", "squirrly-seo" ); ?></span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <h5>
                                                                        <a href="<?php echo esc_url( add_query_arg( array( 'schanges' => 1 ), SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings' ) ) ) ?>" data-toggle="tooltip" title="<?php echo esc_attr__( "Only show SERP changes", "squirrly-seo" ) ?>">
                                                                            <i class="fa-solid fa-arrows-v pull-left mt-1" aria-hidden="true"></i>
                                                                        </a>
                                                                    </h5>
                                                                    <span class="small"><?php echo esc_html__( "Today SERP Changes", "squirrly-seo" ); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="media-right py-3 media-middle ">
                                                                <div class="col-12 px-0">
																	<?php if ( isset( $view->info->average ) && count( (array) $view->info->average ) > 1 ) { ?>
                                                                        <div id="sq_chart" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                                                        <script>
                                                                            if (typeof google !== 'undefined') {
                                                                                google.setOnLoadCallback(function () {
                                                                                    drawChart("sq_chart", <?php echo wp_json_encode( $view->info->average )?> , true);
                                                                                });
                                                                            }
                                                                        </script>

																	<?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card col-3 p-0 m-0 bg-white shadow-sm">
                                                <div class="card-content  overflow-hidden m-0">
                                                    <div class="media align-items-stretch">
                                                        <div class="media-body p-2 py-3">
                                                            <h5><?php echo esc_html__( "Progress & Achievements", 'squirrly-seo' ) ?></h5>
                                                            <span class="small"><?php echo sprintf( esc_html__( "the latest %s days Google Rankings evolution", 'squirrly-seo' ), esc_attr( $days_back ) ); ?></span>


                                                            <div class="media-right py-3 media-middle ">
                                                                <?php if ( isset( $view->info->topten ) && (int) $view->info->topten > 0 ) { ?>
                                                                    <h6 class="col-12 px-0 text-success small">
                                                                        <i class="fa-solid fa-arrow-up" style="font-size: 9px !important;margin: 0 5px;vertical-align: middle;"></i><?php echo sprintf( esc_html__( "%s keyword ranked in TOP 10", 'squirrly-seo' ), '<strong>' . esc_html( $view->info->topten ) . '</strong>' ); ?>
                                                                    </h6>
																<?php } ?>
																<?php if ( isset ( $view->info->positive_changes ) && (int) $view->info->positive_changes > 0 ) { ?>
                                                                    <h6 class="col-12 px-0 text-success small">
                                                                        <i class="fa-solid fa-arrow-up" style="font-size: 9px !important;margin: 0 5px;vertical-align: middle;"></i><?php echo sprintf( esc_html__( "%s keyword ranked better today", 'squirrly-seo' ), '<strong>' . esc_html( $view->info->positive_changes ) . '</strong>' ); ?>
                                                                    </h6>
																<?php } ?>
																<?php
																$average_changes = 0;
																if ( isset( $view->info->average ) && ! empty( $view->info->average ) ) {
																	//if there is a history in ranking for this keyword
																	//get first date minus last date to see the average improvment
																	if ( isset( $view->info->average[1][1] ) && isset( $view->info->average[ ( count( $view->info->average ) - 1 ) ][1] ) ) {
																		$average_changes = $view->info->average[1][1] - $view->info->average[ ( count( $view->info->average ) - 1 ) ][1];
																	}
																	if ( $average_changes > 0 ) { ?>
                                                                        <h6 class="col-12 px-0 text-success small">
                                                                            <i class="fa-solid fa-arrow-up" style="font-size: 9px !important;margin: 0 5px;vertical-align: middle;"></i><?php echo sprintf( esc_html__( "Ranks improved with an average of %s in the last 7 days.", 'squirrly-seo' ), '<strong>' . esc_html( $average_changes ) . '</strong>' ); ?>
                                                                        </h6>
																	<?php }
																} ?>
																<?php if ( isset( $view->info->topten ) && (int) $view->info->topten == 0 &&  isset( $view->info->positive_changes ) && (int) $view->info->positive_changes == 0 && $average_changes == 0 ) { ?>
                                                                    <h4 class="col-12 px-0 text-primary"><?php echo esc_html__( "No progress found yet", 'squirrly-seo' ) ?></h4>
																<?php } ?>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

										<?php if ( $topten > 0 || $positive_changes > 0 || $average_changes > 0 ) { ?>
                                            <div class="col-12 p-0 m-0 py-2 text-right">
                                                <a class="btn btn-sm btn-link text-dark" href="https://twitter.com/intent/tweet?text=<?php echo urlencode( 'I love the ranking results I get for my Pages with Squirrly SEO plugin for #WordPress. @SquirrlyHQ #SEO' ) ?>"><?php echo esc_html__( 'Share Your Success', 'squirrly-seo' ) ?></a>
                                            </div>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							<?php } ?>

                            <div class="col-12 p-0 m-0 my-4 border-0">

                                <div class="row col-12 m-0 p-0 my-2">
                                    <div class="col-6 row m-0 p-0">
                                        <select name="sq_bulk_action" class="sq_bulk_action " style="min-width: 200px">
                                            <option value=""><?php echo esc_html__( "Bulk Actions", 'squirrly-seo' ) ?></option>
                                            <option value="sq_ajax_rank_bulk_delete" data-confirm="<?php echo esc_attr__( "Are you sure you want to delete the keyword?", 'squirrly-seo' ) ?>"><?php echo esc_html__( "Delete" ) ?></option>
											<?php if ( $view->checkin->subscription_serpcheck ) { ?>
                                                <option value="sq_ajax_rank_bulk_refresh"><?php echo esc_html__( "Refresh Serp", 'squirrly-seo' ) ?></option>
											<?php } ?>
                                        </select>
                                        <button class="sq_bulk_submit btn btn-primary"><?php echo esc_html__( "Apply" ); ?></button>
                                    </div>
                                    <div class="col-6 p-0 m-0">
                                        <form method="get" class="d-flex flex-row justify-content-end p-0 m-0">
	                                        <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_rankings_search', 'sq_nonce', false ); ?>
                                            <input type="hidden" name="action" value="sq_rankings_search"/>

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

                                <table class="table table-striped table-hover table-ranks">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px;"><input type="checkbox" class="sq_bulk_select_input"/>
                                        </th>
                                        <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Keyword", 'squirrly-seo' ), "keyword" ) ?></th>
                                        <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Path", 'squirrly-seo' ), "url" ) ?></th>
										<?php if ( $view->checkin->subscription_serpcheck ) { ?>
                                            <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Rank", 'squirrly-seo' ), "rank" ) ?></th>
                                            <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Best", 'squirrly-seo' ), "best" ) ?></th>
										<?php } else { ?>
                                            <th><?php SQ_Classes_Helpers_Tools::sort( esc_html__( "Avg Rank", 'squirrly-seo' ), "rank" ) ?></th>
										<?php } ?>
                                        <th><?php echo esc_html__( "Details", 'squirrly-seo' ) ?></th>

                                        <th class="no-sort" style="width: 2%;"></th>

                                    </tr>
                                    </thead>
                                    <tbody>
									<?php
									foreach ( $view->ranks as $key => $row ) {
										if ( SQ_Classes_Helpers_Tools::getIsset( 'schanges' ) && ( ! isset( $row->change ) || ! $row->change ) ) {
											continue;
										}
										if ( SQ_Classes_Helpers_Tools::getIsset( 'ranked' ) && ( ! isset( $row->rank ) || ! $row->rank ) ) {
											continue;
										}
										if ( SQ_Classes_Helpers_Tools::getIsset( 'strict' ) ) {
											if ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) && ( strtolower( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) <> strtolower( $row->keyword ) ) ) {
												continue;
											}
										}
										?>

                                        <tr>
                                            <td style="width: 10px;">
                                                <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo esc_attr( $row->keyword ) ?>"/>
                                            </td>
                                            <td>
                                                <span><?php echo esc_html( $row->keyword ) ?></span>
                                            </td>
											<?php if ( ! $row->permalink && ! $view->checkin->subscription_serpcheck ) { ?>
                                                <td class="small">
													<?php echo esc_html__( "Google Search Console has no data for this keyword", 'squirrly-seo' ) ?>
                                                </td>
                                                <td></td>
                                                <td>
													<?php if ( $connect->google_search_console ) { ?>
                                                        <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'gscsync' ) ) ?>" class="btn btn-link text-primary font-weight-bold"><?php echo esc_html__( "Sync Keywords", 'squirrly-seo' ); ?></a>
													<?php } ?>
                                                </td>
											<?php } else { ?>
                                                <td>
													<?php $path = str_replace( parse_url( $row->permalink, PHP_URL_SCHEME ) . '://' . parse_url( $row->permalink, PHP_URL_HOST ), '', $row->permalink ); ?>
                                                    <a href="<?php echo esc_url( $row->permalink ) ?>" target="_blank"><?php echo( $path <> '' ? urldecode( $path ) : urldecode( $row->permalink ) ) ?></a>
                                                </td>
												<?php if ( $view->checkin->subscription_serpcheck ) { ?>
                                                    <td style="white-space: nowrap;">
														<?php
														echo( ! $row->rank ? '<span style="font-size: 13px">' . esc_html__( "Not indexed", 'squirrly-seo' ) . '</span>' : (int) $row->rank );
														if ( isset( $row->change ) ) {
															echo( ( $row->change ) ? sprintf( '<span class="badge badge-' . ( $row->change < 0 ? 'success' : 'danger' ) . ' mx-2 p-1"><i class="fa-solid fa-sort-%s"></i><span> </span><span>%s</span></span>', ( $row->change < 0 ? 'up' : 'down' ), (int) $row->change ) : '' );
														}
														?>
                                                    </td>
                                                    <td style="white-space: nowrap;">
														<?php echo( (int) $row->best > 0 ? (int) $row->best : "-" ); ?>
                                                    </td>
												<?php } else { ?>
                                                    <td style="white-space: nowrap;" title="<?php echo esc_html__( "Google Search Console has no data for this keyword", 'squirrly-seo' ) ?>">
														<?php echo( (int) $row->average_position <= 0 ? esc_html__( "GSC", 'squirrly-seo' ) : number_format( $row->average_position, 1 ) ); ?>
                                                    </td>
												<?php } ?>
                                                <td>
                                                    <button onclick="jQuery('#sq_ranking_modal<?php echo (int) $key ?>').modal('show');" class="small btn btn-primary btn-sm" style="cursor: pointer; width: 120px"><?php echo esc_html__( "rank details", 'squirrly-seo' ) ?></button>
                                                </td>
											<?php } ?>

                                            <td>
                                                <div class="sq_sm_menu">
                                                    <div class="sm_icon_button sm_icon_options">
                                                        <i class="fa-solid fa-ellipsis-v"></i>
                                                    </div>
                                                    <div class="sq_sm_dropdown">
                                                        <ul class="p-2 m-0 text-left">
                                                            <li class="m-0 p-1 py-2">
                                                                <form method="post" class="row p-0 m-0">
                                                                    <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_serp_refresh_post' ); ?>
                                                                    <input type="hidden" name="action" value="sq_serp_refresh_post"/>
                                                                    <input type="hidden" name="keyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword( $row->keyword ) ?>"/>
                                                                    <i class="sq_icons_small fa-solid fa-refresh py-2"></i>
                                                                    <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
                                                                        <?php echo esc_html__( "Check Ranking again", 'squirrly-seo' ) ?>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li class="m-0 p-1 py-2">
                                                                <form method="post" class="row p-0 m-0">
																	<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_serp_delete_keyword' ); ?>
                                                                    <input type="hidden" name="action" value="sq_serp_delete_keyword"/>
                                                                    <input type="hidden" name="keyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword( $row->keyword ) ?>"/>
                                                                    <i class="sq_icons_small fa-solid fa-trash py-2"></i>
                                                                    <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
																		<?php echo esc_html__( "Remove Keyword", 'squirrly-seo' ) ?>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </td>

                                        </tr>
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
                                                        <option value="<?php echo $num ?>" <?php selected( $num, SQ_Classes_Helpers_Tools::getValue( 'snum' ) ) ?> ><?php echo $num . ' ' . esc_html__( 'records', 'squirrly-seo' ) ?></option><?php
													}
													?>
                                                </select>
                                            </label>
                                            <span class="mx-3"><?php echo esc_html__( "Total", 'squirrly-seo' ); ?>: <?php echo $view->total ?> <?php echo esc_html__( "records", 'squirrly-seo' ); ?></span>
                                        </div>

                                        <div class="nav-previous alignright">
											<?php SQ_Classes_Helpers_Tools::pagination( $view->max_num_pages ); ?>
                                        </div>
                                    </div>
								<?php } ?>

								<?php foreach ( $view->ranks as $key => $row ) {
									if ( SQ_Classes_Helpers_Tools::getIsset( 'schanges' ) && ( ! isset( $row->change ) || ! $row->change ) ) {
										continue;
									}
									if ( SQ_Classes_Helpers_Tools::getIsset( 'ranked' ) && ( ! isset( $row->rank ) || ! $row->rank ) ) {
										continue;
									}
									?>
                                    <div id="sq_ranking_modal<?php echo (int) $key; ?>" tabindex="-1" class="sq_ranking_modal modal" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content bg-white rounded-0">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><?php echo esc_html__( "Keyword", 'squirrly-seo' ); ?>
                                                        : <?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword( $row->keyword ) ?>
                                                        <span style="font-weight: bold; font-size: 110%"></span>
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body pt-0" style="min-height: 90px;">
                                                    <ul class="col-12">
                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-12">
                                                                <strong><a href="<?php echo esc_url( $row->permalink ) ?>" target="_blank"><?php echo urldecode( $row->permalink ) ?></a></strong>
                                                            </div>
                                                        </li>

                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-6"><?php echo esc_html__( "Impressions", 'squirrly-seo' ) ?>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                <strong><?php echo (int)$row->impressions ?></strong>
                                                            </div>
                                                        </li>
                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-6"><?php echo esc_html__( "Clicks", 'squirrly-seo' ) ?>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                <strong><?php echo (int)$row->clicks ?></strong>
                                                            </div>
                                                        </li>

                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-6"><?php echo esc_html__( "Optimized with SLA", 'squirrly-seo' ) ?>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                <strong><?php echo( (int) $row->optimized > 0 ? (int) $row->optimized . '%' : 'N/A' ) ?></strong>
                                                            </div>
                                                        </li>

														<?php if ( $view->checkin->subscription_serpcheck ) { ?>
                                                            <li class="row py-3 border-bottom">
                                                                <div class="col-6"><?php echo esc_html__( "Social Shares", 'squirrly-seo' ) ?>
                                                                    :
                                                                </div>
                                                                <div class="col-6">
																	<?php
																	echo "<strong>" . number_format( (int) $row->facebook ) . "</strong>" . ' ' . esc_html__( "Facebook Shares", 'squirrly-seo' ) . "<br />";
																	echo "<strong>" . number_format( (int) $row->reddit ) . "</strong>" . ' ' . esc_html__( "Reddit Shares", 'squirrly-seo' ) . "<br />";
																	echo "<strong>" . number_format( (int) $row->pinterest ) . "</strong>" . ' ' . esc_html__( "Pinterest Pins", 'squirrly-seo' ) . "<br />";
																	?>
                                                                </div>
                                                            </li>
														<?php } ?>

                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-6"><?php echo esc_html__( "Country", 'squirrly-seo' ) ?>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                <strong><?php echo esc_html( $row->country ) ?></strong>
                                                            </div>
                                                        </li>

														<?php if ( isset( $row->datetime ) ) { ?>
                                                            <li class="row py-2 border-bottom-0">
                                                                <div class="col-6"><?php echo esc_html__( "Date", 'squirrly-seo' ) ?>
                                                                    :
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong><?php echo wp_date( get_option( 'date_format' ), strtotime( $row->datetime ) ) ?></strong>
                                                                </div>
                                                            </li>
														<?php } ?>

                                                        <li class="small text-center"><?php echo esc_html__( "Note! The clicks and impressions data is taken from Google Search Console for the last 90 days for the current URL.", 'squirrly-seo' ) ?></li>

                                                    </ul>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

								<?php } ?>

                            </div>
						<?php } elseif ( SQ_Classes_Helpers_Tools::getIsset( 'skeyword' ) || SQ_Classes_Helpers_Tools::getIsset( 'slabel' ) || SQ_Classes_Helpers_Tools::getIsset( 'spage' ) ) { ?>
                            <div class="row col-12 m-0 p-0 my-2">
                                <div class="col-5 row m-0 p-0"></div>
                                <div class="col-7 p-0 m-0">
                                    <form method="get" class="d-flex flex-row justify-content-end p-0 m-0">
	                                    <?php SQ_Classes_Helpers_Tools::setNonce( 'sq_rankings_search', 'sq_nonce', false ); ?>
                                        <input type="hidden" name="action" value="sq_rankings_search"/>

                                        <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                        <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                        <input type="search" class="d-inline-block align-middle col-7 py-0 px-2 mr-0 rounded-0" id="post-search-input" name="skeyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword( SQ_Classes_Helpers_Tools::getValue( 'skeyword' ) ) ?>" placeholder="<?php echo esc_html__( "Write the keyword you want to search for", 'squirrly-seo' ) ?>"/>
                                        <input type="submit" class="btn btn-primary" value="<?php echo esc_html__( "Search", 'squirrly-seo' ) ?> >"/>
                                        <button type="button" class="btn btn-link text-primary ml-1" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page' ), SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", 'squirrly-seo' ) ?></button>
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
						<?php } elseif ( ! SQ_Classes_Error::isError() ) { ?>
                            <div class="card-body">
                                <h4 class="text-center"><?php echo esc_html__( "Welcome to Squirrly Rankings", 'squirrly-seo' ); ?></h4>
                                <div class="col-12 m-2 text-center">
                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) ?>" class="btn btn-lg btn-primary">
                                        <i class="fa-solid fa-plus-square-o"></i> <?php echo esc_html__( "Add keywords in Briefcase", 'squirrly-seo' ); ?>
                                    </a>

                                    <div class="col-12 mt-5 mx-2">
                                        <h5 class="text-left my-3 text-primary"><?php echo esc_html__( "Tips: How to add Keywords in Rankings?", 'squirrly-seo' ); ?></h5>
                                        <ul>
                                            <li class="text-left"><?php echo sprintf( esc_html__( "From %sSquirrly Briefcase%s you can send keywords to Rank Checker to track the SERP evolution.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) . '" >', '</a>' ); ?></li>
                                            <li class="text-left"><?php echo sprintf( esc_html__( "Connect with %sGoogle Search Console%s to synchronize the keywords for which your website is ranking.", 'squirrly-seo' ), '<strong>', '</strong>' ); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
						<?php } else { ?>
                            <div class="card-body">
                                <div class="col-12 px-2 py-3 text-center">
                                    <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/noconnection.png' ) ?>" alt="" style="width: 300px">
                                </div>
                                <div class="col-12 m-2 text-center">
                                    <div class="col-12 alert alert-success text-center m-0 p-3">
                                        <i class="fa-solid fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf( esc_html__( "There is a connection error with Squirrly Cloud. Please check the connection and %srefresh the page%s.", 'squirrly-seo' ), '<a href="javascript:void(0);" onclick="location.reload();" >', '</a>' ) ?>
                                    </div>
                                </div>
                            </div>
						<?php } ?>

						<?php do_action( 'sq_rankings_after' ); ?>

                    </div>

                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
						<?php if ( $view->checkin->subscription_serpcheck ) { ?>
                            <li class="text-left small"><?php echo esc_html__( "SERP Checker Business: We update the best ranks for each keyword, daily. 100% accurate and objective.", 'squirrly-seo' ); ?></li>
						<?php } ?>
                        <li class="text-left small"><?php echo esc_html__( "Click on Rank Details to see key insights (such as: clicks, impressions,and social shares).", 'squirrly-seo' ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "Take screenshots of the Progress and Achievements data or integrate them inside reports you create to show evidence of progress.", 'squirrly-seo' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php echo SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>
					<?php
					if ( ! empty( $view->pages ) ) {
						foreach ( $view->pages as $page ) { ?>
							<?php
							if ( ! empty( $page->categories ) ) {
								foreach ( $page->categories as $index => $category ) {
									if ( isset( $category->assistant ) ) {
										//show /view/Assistant/Asistant.php for the current Ranking Page
										echo $category->assistant;
									}
								}
							}
							?>
						<?php }
					} ?>

					<?php do_action( 'sq_rankings_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
