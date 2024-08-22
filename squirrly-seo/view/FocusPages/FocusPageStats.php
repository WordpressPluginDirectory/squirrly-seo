<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Focus Page Stats view
 *
 * Called from Focus Page List view
 */
?>
<?php if ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) {
	$days_back = (int) SQ_Classes_Helpers_Tools::getValue( 'days_back', 90 );
	if ( ! empty( $view->focuspages ) ) {
		foreach ( $view->focuspages as $index => $focuspage ) {
			$scores[] = array( 'date', 'score' );
			$progress = array();

			if ( $stats = $focuspage->stats ) {
				$stats_progress = $stats->progress;

				if ( ! empty( $stats ) ) {
					foreach ( $stats as $name => $values ) {
						switch ( $name ) {
							case 'score':
								if ( ! empty( $values ) ) {
									foreach ( $values as $date => $value ) {
										$scores[] = array( gmdate( 'm/d/Y', strtotime( $date ) ), $value );
									}
								} else {
									$scores[] = array( gmdate( 'm/d/Y' ), 0 );
								}
								break;
							case 'serp':
								if ( ! empty( $values ) ) {
									foreach ( $values as $keyword => $rankings ) {
										$focus_keyword = $keyword;
										$serp[]        = array( 'date', 'rank' );
										foreach ( $rankings as $date => $value ) {
											$serp[] = array( gmdate( 'm/d/Y', strtotime( $date ) ), $value );
										}
										break;
									}
								}
								break;
							case 'page_views':
								if ( ! empty( $values ) ) {
									$views[] = array( 'date', 'views' );
									foreach ( $values as $date => $value ) {
										$views[] = array(
											sprintf( esc_html__( "Week %s of %s", 'squirrly-seo' ), gmdate( 'W', strtotime( $date ) ), gmdate( 'Y', strtotime( $date ) ) ),
											$value
										);
									}
								}
								break;
						}
					}
				}

				if ( ! empty( $stats_progress ) ) {
					foreach ( $stats_progress as $name => $value ) {
						switch ( $name ) {
							case 'ranking':
								if ( ! empty( $value ) ) {
									foreach ( $value as $keyword => $increase ) {
										$progress[] = sprintf( esc_html__( "Rank increased %s positions for the keyword: %s", 'squirrly-seo' ), '<strong>' . $increase . '</strong>', '<strong>' . $keyword . '</strong>' );
									}
								}
								break;
							case 'time':
								if ( $value && $value > 60 ) {
									$progress[] = sprintf( esc_html__( "Time on Page increased with %s minutes", 'squirrly-seo' ), '<strong>' . number_format( ( $value / 60 ) ) . '</strong>' );
								}
								break;
							case 'traffic':
								if ( $value ) {
									$progress[] = sprintf( esc_html__( "Page Traffic increased with %s visits", 'squirrly-seo' ), '<strong>' . $value . '</strong>' );
								}
								break;
							case 'clicks':
								if ( $value ) {
									foreach ( $value as $keyword => $increase ) {
										$progress[] = sprintf( esc_html__( "Organic Clicks increased with %s for the keyword: %s", 'squirrly-seo' ), '<strong>' . $increase . '</strong>', '<br /><strong>' . $keyword . '</strong>' );
									}
								}
								break;
							case 'authority':
								if ( $value ) {
									$progress[] = sprintf( esc_html__( "Page Authority increased with %s", 'squirrly-seo' ), '<strong>' . $value . '</strong>' );
								}
								break;
							case 'social':
								if ( $value ) {
									$progress[] = sprintf( esc_html__( "You got %s Social Shares", 'squirrly-seo' ), '<strong>' . $value . '</strong>' );
								}
								break;
							case 'seo':
								if ( $value ) {
									foreach ( $value as $seo => $time ) {
										if ( $seo == 'loading_time' && $time ) {
											$progress[] = sprintf( esc_html__( "Page loads with %ss faster", 'squirrly-seo' ), '<strong>' . $time . '</strong>' );
										}
									}
								}
								break;
						}
					}
				}
			}

			//prevent chart error
			if ( count( $scores ) == 1 ) {
				$scores[] = array( gmdate( 'm/d/Y' ), 0 );
			}
		}
	}
	?>
    <td style="width: 100%; padding: 0; margin: 0;">
        <div class="sq_stats row p-0 m-0 ">
            <div class="card col-3 p-0 m-0 bg-white shadow-sm">
                <div class="card-content overflow-hidden m-0">
                    <div class="media align-items-stretch">
                        <div class="media-body p-2 py-3">
                            <div class="font-weight-bold m-0 p-0"><?php echo esc_html__( "Chances of Ranking", 'squirrly-seo' ) ?></div>
                            <span class="small"><?php echo sprintf( esc_html__( "the latest %s days evolution for this Focus Page", 'squirrly-seo' ), esc_attr( $days_back ) ) ?></span>
                            <div class="media-right py-3 media-middle ">
                                <div class="col-12 px-0">
                                    <div id="sq_chart_score" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                    <script>
                                        if (typeof google !== 'undefined') {
                                            google.setOnLoadCallback(function () {
                                                drawScoreChart("sq_chart_score", <?php echo wp_json_encode( $scores ) ?> , false);
                                            });
                                        }
                                    </script>
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
                            <div class="font-weight-bold m-0 p-0"><?php echo esc_html__( "Progress & Achievements", 'squirrly-seo' ) ?></div>
                            <span class="small"><?php echo sprintf( esc_html__( "the latest %s days evolution for this Focus Page", 'squirrly-seo' ), (int) $days_back ); ?></span>

                            <div class="media-right py-3 media-middle ">
								<?php if ( ! empty( $progress ) ) {
									foreach ( $progress as $value ) {
										echo '<h6 class="col-12 px-0 text-success small"><i class="fa-solid fa-arrow-up" style="font-size: 9px !important;margin: 0 5px;vertical-align: middle;"></i> ' . wp_kses_post( $value ) . '</h6>';
									}

								} else {
									echo '<h4 class="col-12 px-0 text-primary">' . esc_html__( "No progress found yet", 'squirrly-seo' ) . '</h4>';
								} ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

			<?php if ( ! empty( $serp ) && count( $serp ) > 2 && $focus_keyword <> '' && ! empty( $views ) && count( $views ) > 2 ) { ?>
                <div class="card col-3 p-0 m-0 bg-white shadow-sm">
                    <div class="card-content  overflow-hidden m-0">
                        <div class="media align-items-stretch">
                            <div class="media-body p-2 py-3">
                                <div class="font-weight-bold m-0 p-0"><?php echo esc_html__( "Keyword Ranking", 'squirrly-seo' ) ?></div>
                                <span class="small"><?php echo sprintf( esc_html__( "the latest %s days ranking for %s", 'squirrly-seo' ), (int) $days_back, '<strong>' . esc_html( $focus_keyword ) . '</strong>' ) ?></span>
                                <div class="media-right py-3 media-middle ">
                                    <div class="col-12 px-0">
                                        <div id="sq_chart_serp" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                        <script>
                                            if (typeof google !== 'undefined') {
                                                google.setOnLoadCallback(function () {
                                                    drawRankingChart("sq_chart_serp", <?php echo wp_json_encode( $serp ) ?> , true);
                                                });
                                            }
                                        </script>
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
                                <div class="font-weight-bold m-0 p-0"><?php echo esc_html__( "Page Traffic", 'squirrly-seo' ) ?></div>
                                <span class="small"><?php echo sprintf( esc_html__( "the latest %s days page views", 'squirrly-seo' ), (int) $days_back ) ?></span>
                                <div class="media-right py-3 media-middle ">
                                    <div class="col-12 px-0">
                                        <div id="sq_chart_views" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                        <script>
                                            if (typeof google !== 'undefined') {
                                                google.setOnLoadCallback(function () {
                                                    drawTrafficChart("sq_chart_views", <?php echo wp_json_encode( $views ) ?> , false);
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
			<?php } ?>
        </div>

		<?php if ( ! empty( $progress ) ) { ?>
            <div class="col-12 p-0 m-0 py-2 text-right">
                <a class="btn btn-sm btn-link text-dark" href="https://twitter.com/intent/tweet?text=<?php echo urlencode( 'I love the results I get for my Focus Page with Squirrly SEO plugin for #WordPress. @SquirrlyHQ #SEO' ) ?>">Share
                    Your Success</a>
            </div>
		<?php } ?>
    </td>
<?php } ?>
