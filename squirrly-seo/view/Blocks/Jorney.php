<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Inner Links Block view
 *
 * Called through ajax from Focus Pages Controller
 */
?>
<div id="sq_journey">
	<?php if ( $view->days ) { ?>
        <div class="col-12 m-0 p-0 my-3">

            <h3 class="mt-4 card-title">
				<?php echo esc_html__( "14 Days Journey", "squirrly-seo" ); ?>
                <div class="sq_help_question d-inline">
                    <a href="https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#journey" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                </div>
            </h3>
            <div class="col-7 small m-0 p-0">
				<?php echo sprintf( esc_html__( "Join the rest of the %s JourneyTeam on the Facebook Group %s and if you want you can share with the members that you have started your Journey.", "squirrly-seo" ), '<a href="' . esc_url( _SQ_SUPPORT_FACEBOOK_URL_ ) . '" target="_blank" >', '</a>' ) ?>
            </div>


            <div class="col-12 m-0 p-0 border-0">

                <div class="col-12 m-0 p-3 px-5 my-5 bg-white text-center">

					<?php if ( $view->days > 14 ) { ?>
                        <h5 class="col-12 card-title py-3 font-weight-bold"><?php echo esc_html__( "Congratulations! You've completed the 14 Days Journey To Better Ranking", "squirrly-seo" ); ?></h5>
					<?php } else { ?>
                        <h5 class="col-12 card-title py-3 font-weight-bold"><?php echo esc_html__( "Your 14 Days Journey To Better Ranking", "squirrly-seo" ); ?></h5>
					<?php } ?>

                    <ul class="stepper horizontal horizontal-fix focused" id="horizontal-stepper-fix">
						<?php for ( $i = 1; $i <= 14; $i ++ ) { ?>
                            <li class="step <?php echo( ( (int) $view->days >= $i ) ? 'completed' : '' ) ?>">
                                <div class="step-title waves-effect waves-dark">
                                    <a href="https://howto12.squirrly.co/wordpress-seo/journey-to-better-ranking-day-<?php echo esc_attr( $i ) ?>/" target="_blank">
										<?php echo( ( (int) $view->days >= $i ) ? '<i class="fa-solid fa-check-circle" style="font-size: 1.5rem"></i>' : '<i class="fa-solid fa-circle-o"  style="color: darkgrey;"></i>' ) ?>
                                    </a>
                                    <div>
                                        <a href="https://howto12.squirrly.co/wordpress-seo/journey-to-better-ranking-day-<?php echo esc_attr( $i ) ?>/" target="_blank">
											<?php echo esc_html( __( "Day", "squirrly-seo" ) . ' ' . $i ) ?>
                                        </a>
                                    </div>
                                </div>
                            </li>
						<?php } ?>
                    </ul>

					<?php if ( (int) $view->days > 14 ) { ?>
						<?php if ( SQ_Classes_Helpers_Tools::getValue( 'page' ) == 'sq_dashboard' ) { //show only in overview ?>
                            <em class="text-black-50"><?php echo esc_html__( "If you missed a day, click on it and read the SEO recipe for it.", "squirrly-seo" ); ?></em>
                            <div class="small text-center my-2">
                                <form method="post" class="p-0 m-0">
									<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_journey_close', 'sq_nonce' ); ?>
                                    <input type="hidden" name="action" value="sq_journey_close"/>
                                    <button type="submit" class="btn btn-sm text-primary btn-link bg-transparent p-0 m-0">
										<?php echo esc_html__( "I'm all done. Hide this block.", "squirrly-seo" ) ?>
                                    </button>
                                </form>
                            </div>
						<?php } ?>

					<?php } else { ?>
                        <a href="https://howto12.squirrly.co/wordpress-seo/journey-to-better-ranking-day-<?php echo (int) $view->days ?>/" target="_blank" class="btn btn-primary m-2 py-2 px-4" style="font-size: 20px;"><?php echo esc_html__( "Day", "squirrly-seo" ) . ' ' . (int) $view->days . ': ' . esc_html__( "Open the SEO recipe for today", "squirrly-seo" ); ?></a>
						<?php
						switch ( (int) $view->days ) {
							case 1:
								?>
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'addpage' ) ) ?>" target="_blank" class="btn btn-primary m-2 py-2 px-4" style="font-size: 20px;"><?php echo esc_html__( "Add a page in Focus Pages", "squirrly-seo" ); ?></a><?php
								break;
							case 2:
								?>
                                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) ) ?>" target="_blank" class="btn btn-primary m-2 py-2 px-4" style="font-size: 20px;"><?php echo esc_html__( "Do Keyword Research", "squirrly-seo" ); ?></a><?php
								break;
						}
						?>
					<?php } ?>

                </div>

            </div>

        </div>
	<?php } else { ?>
        <div class="col-12 m-0 p-0 my-3">
            <div class="row text-left m-0 p-0 bg-white">
                <div class="px-2 py-3" style="max-width: 450px;width: 40%;">
                    <img src="<?php echo esc_url( _SQ_ASSETS_URL_ . 'img/settings/14days.png' ) ?>" alt="" style="width: 100%">
                </div>
                <div class="col px-2 py-3">
                    <div class="col-12 m-0 p-0">
                        <h3 class="card-title"><?php echo esc_html__( "14 Days Journey Course", "squirrly-seo" ); ?></h3>
                    </div>

                    <div class="sq_separator"></div>
                    <div class="col-12 m-2 p-0">
                        <div class="m-2 text-black-50"><?php echo esc_html__( "All you need now is to start driving One of your most valuable pages to Better Rankings.", "squirrly-seo" ); ?></div>
                    </div>
                    <div class="col-12 m-0 p-4 text-right">
                        <form action="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'journey' ) ) ?>" method="post" class="p-0 m-0">
							<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_onboarding_commitment', 'sq_nonce' ); ?>
                            <input type="hidden" name="action" value="sq_onboarding_commitment"/>
                            <button type="submit" class="btn btn-sm btn-primary m-0 py-2 px-4">
								<?php echo esc_html__( "I'm ready to start the Journey To Better Ranking", "squirrly-seo" ); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
	<?php } ?>
</div>
