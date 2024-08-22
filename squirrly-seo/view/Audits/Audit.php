<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Audit Details Page view
 *
 * Called from Audits Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php $view->loadScripts(); ?>
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

                <div class="col-12 m-0 p-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>
                        <i class="text-black-50 mx-1">/</i> <?php echo esc_html__( "Audit - Details", "squirrly-seo" ); ?>
                    </div>
                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Audit - Details", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/seo-audit/#audit_blogging" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 px-0 py-2">
						<?php echo esc_html__( "Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic", "squirrly-seo" ); ?>
                    </div>

					<?php if ( $view->audit ) { ?>

                        <div id="sq_audit" class="col-12 m-0 p-0 border-0">
                            <div style="min-height: 150px">
								<?php if ( SQ_Classes_Helpers_Tools::getValue( 'sid' ) ) { ?>
                                    <div class="sq_back_button">
                                        <button type="button" class="btn btn-sm btn-primary py-1 px-5" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", "squirrly-seo" ) ?></button>
                                    </div>
								<?php } ?>

								<?php $view->show_view( 'Audits/AuditStats' ); ?>

                                <h4><?php echo esc_html__( "Audit Pages", "squirrly-seo" ) ?></h4>
                                <ul class="m-0 p-0 sq_audit_pages" style="max-height: 200px; overflow-y: auto;">
									<?php
									$cnt = 0;
									foreach ( $view->audit->urls as $index => $url ) {
										$cnt ++;
										if ( strpos( $url, '%' ) !== false ) {
											$url = urldecode( $url );
										}
										?>
                                        <li>
                                            <a href="<?php echo esc_url( $url ) ?>" class="text-black-50" target="_blank"><?php echo esc_html( $cnt . '. ' . urldecode( $url ) ) ?></a>
                                        </li>
									<?php } ?>
                                </ul>

                                <div class="col-12 m-0 p-0 my-5 border-0 shadow-none">
                                    <div class="col-12 text-center row p-0 m-0">
                                        <div class="col-6 m-0 p-2 text-right">
                                            <button class="sq_audit_completed_tasks btn btn-sm btn-primary px-3">
                                                <i class="fa-solid fa-check-circle mr-2 py-2"></i><?php echo esc_html__( "Show Only Completed Tasks", "squirrly-seo" ) ?>
                                            </button>
                                        </div>
                                        <div class="col-6 m-0 p-2 text-left">
                                            <button class="sq_audit_incompleted_tasks btn btn-sm btn-danger px-3">
                                                <i class="fa-solid fa-circle-o mr-2 py-2"></i><?php echo esc_html__( "Show Only Incompleted Tasks", "squirrly-seo" ) ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>

								<?php foreach ( $view->audit->audit as $group => $audit ) {
									if ( ! isset( $view->audit->groups->$group ) ) {
										continue;
									}
									$current_group = $view->audit->groups->$group; ?>
									<?php if ( $current_group->total > 0 ) { ?>
                                        <div class="persist-area">

                                            <ul class="sq_audit_task p-0 m-0">
                                                <li class="m-0 p-0 mt-5">
                                                    <div id="sq_audit_tasks_header_<?php echo esc_attr( $group === 'inbound' ? 'links' : $group ) ?>" class="sq_audit_tasks_header m-0 p-0 p-3">
                                                        <span class="persist-header sq_audit_tasks_header_title <?php echo esc_attr( $current_group->color ) . '_text' ?>" data-id="<?php echo esc_attr( $group === 'inbound' ? 'links' : $group ) ?>"><?php echo esc_html( ucfirst( $group === 'inbound' ? 'links' : $group ) ) ?></span>
                                                        <span class="sq_audit_task_completed <?php echo esc_attr( $current_group->color ) ?>"><?php echo (int) $current_group->complete ?>/<?php echo (int) $current_group->total ?></span>
                                                    </div>
                                                </li>

												<?php if ( ! empty( $audit ) ) {
													foreach ( $audit as $key => $task ) {

														//hook the task object for both success and fail tasks
														if ( (int) $task->complete ) {
															$task = apply_filters( 'sq_audit_success_task', $task );
														} else {
															$task = apply_filters( 'sq_audit_fail_task', $task );
														}

														?>
                                                        <li class="sq_audit_task_row m-0 p-4 bg-white sq_audit_task_complete_<?php echo (int) $task->complete ?>">
                                                            <div class="row m-0 p-0 my-2">
                                                                <div class="m-0 p-0 mx-2 py-1">
                                                                    <i class="m-0 p-0 <?php echo ( (int) $task->complete == 1 ) ? 'fa-solid fa-thumbs-up text-success' : 'fa-solid fa-thumbs-down text-danger' ?>" style="font-size: 1.8rem;"></i>
                                                                </div>
                                                                <div class="m-0 p-0 mx-2 py-1">
                                                                    <h5 class="m-0 p-0 font-weight-bold"><?php echo wp_kses_post( $task->title ) . ( strpos( $task->title, '?' ) === false ? ': ' : '' ) ?>
                                                                        <span class="m-0 p-0 px-2 font-weight-bold <?php echo ( (int) $task->complete == 1 ) ? 'text-primary' : 'text-danger' ?>"> <?php echo wp_kses_post( $task->complete ? $task->success : $task->fail ) ?> </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 m-0 p-0 py-1 pl-6">
                                                                <div class="m-0 p-0 font-weight-bold <?php echo ( (int) $task->complete == 1 ) ? 'text-primary' : 'text-danger' ?>"> <?php echo wp_kses_post( $task->complete ? $task->success_list : $task->fail_list ) ?> </div>
                                                            </div>
															<?php if ( $task->description ) { ?>
                                                                <div class="row m-0 p-0 my-2 pl-6 text-black-50">
																	<?php echo wp_kses_post( $task->description ); ?>
																	<?php if ( $task->protip <> '' ) { ?>
                                                                        <div class="my-3 p-0">
                                                                            <strong class="text-primary"><?php echo esc_html__( "PRO TIP", "squirrly-seo" ) ?>
                                                                                :</strong> <?php echo wp_kses_post( $task->protip ) ?>
                                                                        </div>
																	<?php } ?>
                                                                </div>
															<?php } ?>
                                                        </li>
													<?php }
												} ?>
                                            </ul>

                                        </div>
									<?php } ?>
								<?php } ?>
                            </div>
                        </div>
					<?php } ?>

                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
                        <li class="text-left"><?php echo esc_html__( "Sites with scores over 80 have good chances of ranking high on Google.", "squirrly-seo" ); ?></li>
                        <li class="text-left"><?php echo esc_html__( "Read about the aspects you can work on improving (they are marked with a thumbs down element) and work on them to improve your score.", "squirrly-seo" ); ?></li>
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
