<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * GSC Keyword Sync view
 *
 * Called from Rankings Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>

    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">

		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                    <h3 class="mt-4">
						<?php echo esc_html__( "Google Search Console Keywords Sync", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#sync_keyword_ranking" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 px-0 py-2">
						<?php echo esc_html__( "See the trending keywords suitable for your website's future topics. We check for new keywords weekly based on your latest researches.", "squirrly-seo" ); ?>
                        (<?php echo esc_html__( "see the keywords that are already bringing you traffic, how people are finding you on google", "squirrly-seo" ); ?>
                        )
                    </div>

                    <div id="sq_keywords" class="col-12 m-0 p-0 border-0">

                        <div class="col-12 m-0 p-0">
                            <div class="col-12 m-0 p-0 my-5">
								<?php if ( is_array( $view->suggested ) && ! empty( $view->suggested ) ) { ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 30%;"><?php echo esc_html__( "Keyword", "squirrly-seo" ) ?></th>
                                            <th scope="col" title="<?php echo esc_attr__( "Clicks", "squirrly-seo" ) ?>"><?php echo esc_html__( "Clicks", "squirrly-seo" ) ?></th>
                                            <th scope="col" title="<?php echo esc_attr__( "Impressions", "squirrly-seo" ) ?>"><?php echo esc_html__( "Impressions", "squirrly-seo" ) ?></th>
                                            <th scope="col" title="<?php echo esc_attr__( "Click-Through Rate", "squirrly-seo" ) ?>"><?php echo esc_html__( "CTR", "squirrly-seo" ) ?></th>
                                            <th scope="col" title="<?php echo esc_attr__( "Average Position", "squirrly-seo" ) ?>"><?php echo esc_html__( "AVG Position", "squirrly-seo" ) ?></th>
                                            <th style="width: 20px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php
										foreach ( $view->suggested as $key => $row ) {
											?>
                                            <tr class="<?php echo( $row->do_serp ? 'bg-briefcase' : '' ) ?>">
                                                <td style="width: 280px;">
                                                    <span style="display: block; clear: left; float: left;"><?php echo esc_html( $row->keywords ) ?></span>
                                                </td>
                                                <td>
                                                    <span style="display: block; clear: left; float: left;"><?php echo number_format( $row->clicks ) ?></span>
                                                </td>
                                                <td>
                                                    <span style="display: block; clear: left; float: left;"><?php echo number_format( $row->impressions ) ?></span>
                                                </td>
                                                <td>
                                                    <span style="display: block; clear: left; float: left;"><?php echo number_format( $row->ctr, 2 ) ?></span>
                                                </td>
                                                <td>
                                                    <span style="display: block; clear: left; float: left;"><?php echo number_format( $row->position, 1 ) ?></span>
                                                </td>
                                                <td class="px-0 py-2" style="width: 20px">
                                                    <div class="sq_sm_menu">
                                                        <div class="sm_icon_button sm_icon_options">
                                                            <i class="fa-solid fa-ellipsis-v"></i>
                                                        </div>
                                                        <div class="sq_sm_dropdown">
                                                            <ul class="text-left p-2 m-0 ">
																<?php if ( $row->do_serp ) { ?>
                                                                    <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                                        <i class="sq_icons_small fa-solid fa-briefcase"></i>
																		<?php echo esc_html__( "Already in Rank Checker", "squirrly-seo" ); ?>
                                                                    </li>
																<?php } else { ?>
                                                                    <li class="sq_research_add_briefcase m-0 p-1 py-2" data-hidden="0" data-doserp="1" data-keyword="<?php echo esc_attr( $row->keywords ) ?>">
                                                                        <i class="sq_icons_small fa-solid fa-briefcase"></i>
																		<?php echo esc_html__( "Add to Rank Checker", "squirrly-seo" ); ?>
                                                                    </li>
																<?php } ?>
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
								<?php } else { ?>
                                    <h4 class="text-center"><?php echo esc_html__( "Welcome to Google Search Console Keywords Sync", "squirrly-seo" ); ?></h4>

                                    <div class="col-12 m-0 p-3 my-4 bg-white small">
										<?php echo sprintf( esc_html__( "If you're new to SEO, you probably don't know yet how slow Google actually is with regard to crawling and gathering data about sites which are not as big as The New York Times, Amazon.com, etc. %s Here are some resources. %s We could not find any keywords from your GSC account, because Google doesn't have enough data about your site yet. %s Give Google more time to learn about your site. Until then, keep working on your SEO Goals from Squirrly SEO.", "squirrly-seo" ), '<br /><br /><a href="https://www.squirrly.co/seo/kit/" target="_blank">', '</a><br /><br />', '<br /><br />' ); ?>
                                    </div>

								<?php } ?>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
                        <li class="text-left small"><?php echo esc_html__( "In this section, you will see a list of keywords you have in Google Search Console (keywords for which your site already ranks for).", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "Look at the keywords for which you rank 5 and lower. Those are keywords your site‘s showing up for, but most likely aren’t generating lots of traffic (since positions 1-3 get most clicks).", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "Focus on further optimizing for those keywords to improve your rankings and generate more traffic.", "squirrly-seo" ); ?></li>
                    </ul>
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
