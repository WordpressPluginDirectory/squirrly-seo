<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Find New Keywords view
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
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Editor role.", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>

				<?php if ( isset( $view->error ) && $view->error == 'limit_exceeded' ) { ?>
                    <div class="sq_breadcrumbs mt-5"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                    <h3 class="card-title">
						<?php echo esc_html__( "Keyword Research", 'squirrly-seo' ); ?>
                    </h3>
                    <div class="sq_step sq_step1 my-5">
                        <h4 class="sq_limit_exceeded text-left">
							<?php echo esc_html__( "You've reached your Keyword Research Limit", 'squirrly-seo' ) ?>
                            <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) ) ?>" class="btn btn-primary btn-small ml-2" target="_blank"><?php echo esc_html__( "Check Your Account", 'squirrly-seo' ) ?></a>
                        </h4>
                    </div>
					<?php return;
				} ?>

                <div class="sq_step sq_step1 my-2">
                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Keyword Research", 'squirrly-seo' )  . ' 1/3'; ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#keyword_research" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small m-0 p-0">
						<?php echo esc_html__( "You can now find long-tail keywords that are easy to rank for. Get personalized competition data for each keyword you research, thanks to Squirrly's Market Intelligence Features.", 'squirrly-seo' ) ?>
                    </div>

                    <div class="input-group col-12 m-0 px-0 py-5">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'post_id' ) ) ?>">
                        <input type="text" class="form-control sq_input_keyword" name="sq_input_keyword" autofocus value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'keyword', '' ) ) ?>" placeholder="<?php echo esc_attr__( "Enter a keyword that matches your business", 'squirrly-seo' ) ?>">
                        <div class="input-group-append">
                            <select class="form-control sq_select_country" name="sq_select_country">
                                <option value="com"><?php echo esc_html__( "Select country", 'squirrly-seo' ) ?></option>
								<?php
								if ( isset( $view->countries ) && ! empty( $view->countries ) ) {
									foreach ( $view->countries as $key => $country ) {
										echo '<option value="' . esc_attr( $key ) . '" ' . ( isset( $_COOKIE['sq_country'] ) && sanitize_text_field( $_COOKIE['sq_country'] ) == $key ? 'selected="selected"' : '' ) . '>' . esc_html( $country ) . '</option>';
									}
								}
								?>
                            </select>
                        </div>
                        <div class="input-group-append">
                            <select class="form-control sq_select_language" name="sq_select_language">
                                <option value="en"><?php echo esc_html__( "Select language", 'squirrly-seo' ) ?></option>
								<?php
								if ( isset( $view->languages ) && ! empty( $view->languages ) ) {
									foreach ( $view->languages as $key => $language ) {
										if ( ! isset( $_COOKIE['sq_language'] ) ) {
											$_COOKIE['sq_language'] = get_locale();
										}
										echo '<option value="' . esc_attr( $key ) . '" ' . ( isset( $_COOKIE['sq_language'] ) && sanitize_text_field( $_COOKIE['sq_language'] ) == $key ? 'selected="selected"' : '' ) . '>' . esc_html( $language ) . '</option>';
									}
								}
								?>
                            </select>
                        </div>

                        <div class="input-group-append">
                            <button type="button" class="sqd-submit btn btn-primary btn-lg px-5" onclick="jQuery('.sq_step2').sq_getSuggested();"><?php echo esc_html__( "Next", 'squirrly-seo' ) ?>
                                >>
                            </button>
                        </div>

						<?php if ( isset( $view->checkin->subscription_kr ) ) { ?>
                            <div class="col-12 mt-3 text-right text-primary font-weight-bold"><?php echo esc_html( number_format($view->checkin->subscription_kr) ) ?> <?php echo esc_html__( "researches left", 'squirrly-seo' ); ?> <?php echo( ( isset( $view->checkin->subscription_limits_reset ) && $view->checkin->subscription_limits_reset <> '' ) ? esc_html__( "until", 'squirrly-seo' ) . ' ' . esc_attr( wp_date( get_option( 'date_format' ), strtotime( $view->checkin->subscription_limits_reset ) ) ) : '' ) ?></div>
						<?php } ?>
                    </div>

                    <div class="row col-12 mt-3">
                        <div class="col-6 text-left">
                        </div>
                        <div class="col-6 text-right">
                        </div>
                    </div>

                    <div class="sq_tips col-12 m-0 p-0">
                        <h5 class="text-left my-3 font-weight-bold">
                            <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                        </h5>
                        <ul class="mx-4">
                            <li class="text-left">
								<?php echo esc_html__( "Focus on Long- Tail keywords (3 to 5 words) as they tend to be more specific and have less competition.", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo sprintf( esc_html__( "Think of a keyword/ topic you want to rank for. Use the %s Keyword research formula %s to generate more keyword ideas.", 'squirrly-seo' ), '<a href="https://www.squirrly.co/marketingtools/keyword-research-ninja-with-the-keyword-formula/" target="_blank">', '</a>' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo esc_html__( "Did you know that you can use Squirrly SEO and perform keyword research in over 100 countries?", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo sprintf( esc_html__( "Already have keywords? %s Import keywords from CSV %s.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'backup' ) ) . '">', '</a>' ) ?>
                            </li>
                        </ul>
                    </div>

					<?php do_action( 'sq_research_step1_after' ); ?>

                </div>
                <div class="sq_step sq_step2 my-2" style="display: none;">
                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) . '<i class="text-black-50 mx-1">/</i>' . esc_html__( 'Keyword Research Suggestions', 'squirrly-seo' ) ?></div>
                    <h3 class="card-title">
						<?php echo esc_html__( "Keyword Research - Suggestions", 'squirrly-seo' ) . ' 2/3'; ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#keyword_research" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small m-0 p-0"><?php echo esc_html__( "(optional) Select similar keywords from below. Each keyword is worth a credit; meaning each keyword you choose will consume one research from your quota.", 'squirrly-seo' ) ?></div>
                    <div class="text-danger text-center my-4" style="display: none"><?php echo esc_html__( "Select up to 3 similar keywords and start the research", 'squirrly-seo' ) ?></div>
                    <div class="sq_suggestions col-12 my-4 p-3 bg-white" style="min-height: 100px">
                        <div class="custom-control custom-checkbox">
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                            <div class="row">
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                <div class="sq_suggested col-5 offset-1 mt-2"></div>
                            </div>
                        </div>
                        <h4 class="sq_limit_exceeded py-3 text-danger text-center" style="display: none">
							<?php echo esc_html__( "You've reached your Keyword Research Limit", 'squirrly-seo' ) ?>
                            <a href="<?php echo esc_url( SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ) ) ?>" target="_blank"><?php echo esc_html__( "Check Your Account", 'squirrly-seo' ) ?></a>
                        </h4>
                        <h4 class="sq_research_error py-3 text-primary text-center" style="display: none"><?php echo sprintf( esc_html__( "We could not find similar keywords. %sClick on 'Do research'", 'squirrly-seo' ), ' ' ) ?></h4>
                    </div>
                    <div class="row col-12">
                        <div class="col-4 p-2 text-left">
                            <button type="button" class="btn btn-link btn-lg text-primary" onclick="location.reload();"><?php echo esc_html__( "Start Over", 'squirrly-seo' ) ?></button>
                        </div>
						<?php if ( $view->checkin->subscription_research == 'deep' ) { ?>
                            <div class="col-8 mx-0 my-2 p-0 text-right">
                                <div class="dropdown ">
                                    <button class="btn btn-primary btn-lg dropdown-toggle" style="min-width: 280px" type="button" id="add_new_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php echo esc_html__( "Do research", 'squirrly-seo' ); ?>
                                    </button>
                                    <div class="dropdown-menu mt-1" style="min-width: 200px" aria-labelledby="add_new_dropdown">
                                        <a href="javascript:void(0);" onclick="jQuery('.sq_step3').sq_getResearch(20);" class="dropdown-item py-2"><?php echo esc_html__( "Do research (up to 20 results)", 'squirrly-seo' ) ?></a>
                                        <a href="javascript:void(0);" onclick="jQuery('.sq_step3').sq_getResearch(50);" class="dropdown-item py-2"><?php echo esc_html__( "Do a deep research (up to 50 results)", 'squirrly-seo' ) ?></a>
                                    </div>
                                </div>
                            </div>
						<?php } else { ?>
                            <div class="col-8  mx-0 my-2 p-0 text-right">
                                <button type="button" class="sqd-submit btn btn-lg btn-primary px-5" onclick="jQuery('.sq_step3').sq_getResearch(20);"><?php echo esc_html__( "Do research", 'squirrly-seo' ) ?>
                                    >>
                                </button>
                            </div>
						<?php } ?>

                    </div>

                    <div class="sq_tips col-12 m-0 p-0">
                        <h5 class="text-left my-3 font-weight-bold">
                            <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                        </h5>
                        <ul class="mx-4">
                            <li class="text-left">
								<?php echo esc_html__( "You can do Deep Keyword Research and get up to 50 results on each research.", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo esc_html__( "The default option of Keyword Research will reveal insights about around 10-20 results to cut down the processing time. To perform a more complex research, use the option to Do a Deep Research and get insights for up to 50 keywords.", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo esc_html__( "Remember: each keyword is a credit.", 'squirrly-seo' ) ?>
                            </li>
                        </ul>
                    </div>

					<?php do_action( 'sq_research_step2_after' ); ?>

                </div>
                <div class="sq_step sq_step3 col-12 my-2 px-0" style="display: none; min-height: 250px !important;">
                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) . '<i class="text-black-50 mx-1">/</i>' . esc_html__( 'Keyword Research Results', 'squirrly-seo' ) ?></div>

                    <div class="sq_loading_steps" style="display: none; ">
                        <div class="sq_loading_step1 sq_loading_step"><?php echo esc_html__( "Keyword Research in progress. We're doing all of this in real-time. Data is fresh.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step2 sq_loading_step"><?php echo esc_html__( "We're now finding 10 alternatives for each keyword you selected.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step3 sq_loading_step"><?php echo esc_html__( "For each alternative, we are looking at the top 10 pages ranked on Google for that keyword.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step4 sq_loading_step"><?php echo esc_html__( "We are now measuring the web authority of each competing page and comparing it to yours.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step5 sq_loading_step"><?php echo esc_html__( "Looking at the monthly search volume for each keyword.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step6 sq_loading_step"><?php echo esc_html__( "Analyzing the last 30 days of Google trends for each keyword.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step7 sq_loading_step"><?php echo esc_html__( "Seeing how many discussions there are on forums and Twitter for each keyword.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step8 sq_loading_step"><?php echo esc_html__( "Piecing all the keywords together now after analyzing each individual keyword.", 'squirrly-seo' ) ?></div>
                        <div class="sq_loading_step9 sq_loading_step"><?php echo esc_html__( "Preparing the results.", 'squirrly-seo' ) ?></div>
                    </div>

                    <h3 class="sq_research_success card-title" style="display: none">
						<?php echo esc_html__( "Keyword Research - Results", 'squirrly-seo' ) . ' 3/3'; ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#keyword_research" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                        </div>
                    </h3>
                    <div class="sq_research_success col-7 small m-0 p-0" style="display: none">
						<?php echo esc_html__( "We found some relevant keywords for you. Click on the corresponding three dots to save the ones you like to Briefcase or start using them right away to optimize content.", 'squirrly-seo' ) ?>
                    </div>
                    <h4 class="sq_research_timeout_error text-black-50 text-center" style="display: none"><?php echo sprintf( esc_html__( "Still processing. give it a bit more time, then go to %sResearch History%s. Results will appear there.", 'squirrly-seo' ), '<a href="' . esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'history' ) ) . '" >', '</a>' ) ?></h4>
                    <h4 class="sq_research_error text-black-50 text-center" style="display: none"><?php echo esc_html__( "Step 4/4: We could not find relevant keywords for you", 'squirrly-seo' ) ?></h4>

                    <div class="col-12 p-0 m-0 py-1">
                        <table class="table table-striped table-hover" style="display: none">
                            <thead>
                            <tr>
                                <th><?php echo esc_html__( "Keyword", 'squirrly-seo' ) ?></th>
                                <th title="<?php echo esc_attr__( "Country", 'squirrly-seo' ) ?>"><?php echo esc_html__( "Co", 'squirrly-seo' ) ?></th>
                                <th>
                                    <i class="fa-solid fa-users" title="<?php echo esc_attr__( "Competition", 'squirrly-seo' ) ?>"></i>
									<?php echo esc_html__( "Competition", 'squirrly-seo' ) ?>
                                </th>
                                <th>
                                    <i class="fa-solid fa-search" title="<?php echo esc_attr__( "SEO Search Volume", 'squirrly-seo' ) ?>"></i>
									<?php echo esc_html__( "Search", 'squirrly-seo' ) ?>
                                </th>
                                <th>
                                    <i class="fa-solid fa-comments-o" title="<?php echo esc_attr__( "Recent discussions", 'squirrly-seo' ) ?>"></i>
									<?php echo esc_html__( "Discussion", 'squirrly-seo' ) ?>
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6 p-2 text-left">
                            <button type="button" class="btn btn-link btn-lg text-primary" onclick="location.reload();"><?php echo esc_html__( "Start Over", 'squirrly-seo' ) ?></button>
                        </div>
                        <div class="col-6 text-right">

                        </div>
                    </div>

                    <div class="sq_tips col-12 m-0 p-0 pt-2" style="display: none">
                        <h5 class="text-left my-3 font-weight-bold">
                            <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                        </h5>
                        <ul class="mx-4">
                            <li class="text-left">
								<?php echo esc_html__( "💡 The default order in which keywords appear in the list is generated by our system based on the ranking potential of each keyword. However, note that even if a keyword has a high ranking chance, if people are NOT searching for it (has very low search volume), you probably shouldn’t use it for your SEO Strategy.", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo esc_html__( "To determine if a keyword has a high ranking chance, we look at the TOP 10 positions in Google for that keyword and compare your web authority against theirs.", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo sprintf( esc_html__( "We use our Market Intelligence for this. %s Learn more %s .", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/faq/how-does-squirrly-determine-if-a-keyword-is-easy-to-rank-for/" target="_blank" >', '</a>' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo esc_html__( "You have the option to add keywords to Briefcase individually for more controlled organization.", 'squirrly-seo' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo sprintf( esc_html__( "The Keyword Research Tool can be used to identify keywords for Social Media as well. %s Learn more %s .", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/ht_kb/gives-you-keywords-according-to-how-much-people-talk-about-them-on-social-media-and-forums/" target="_blank" >', '</a>' ) ?>
                            </li>
                            <li class="text-left">
								<?php echo esc_html__( "Did not find what you wanted this time? Try doing a different keyword research. ", 'squirrly-seo' ) ?>
                            </li>
                        </ul>
                    </div>

					<?php do_action( 'sq_research_step3_after' ); ?>

                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_research_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
