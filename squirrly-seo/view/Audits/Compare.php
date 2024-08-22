<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Audit Compare view
 *
 * Called from Audits View
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

                <div class="col-12 m-0 p-0 my-4">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>
                        <i class="text-black-50 mx-1">/</i> <?php echo esc_html__( "Audit - Compare", "squirrly-seo" ); ?>
                    </div>
                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Audit - Compare", "squirrly-seo" ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/seo-audit/#audit_blogging" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 px-0 py-2">
						<?php echo esc_html__( "Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic", "squirrly-seo" ); ?>
                    </div>

                    <div id="sq_audit" class="col-12 m-0 p-0 border-0">
                        <div style="min-height: 150px">
							<?php if ( ! empty( $view->audits ) ) {
								//set the first audit as referrence
								$view->audit = current( $view->audits );

								//get the modal window for the assistant popup
								echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();
								?>
                                <div class="sq_back_button">
                                    <button type="button" class="btn btn-sm btn-primary py-1 px-5" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", "squirrly-seo" ) ?></button>
                                </div>

                                <ul class="p-0 m-0">
                                    <li class="sq_audit_tasks_row bg-white border-0 m-0 p-0 my-5 py-3">
                                        <table class="col-12 m-0 p-0">
                                            <tr>

                                                <td class="px-3 text-left align-middle">
                                                    <span class="font-weight-bold"><?php echo esc_html__( "Scores", "squirrly-seo" ) ?></span>
                                                </td>

												<?php foreach ( $view->audits as $all ) {
													$color = false;
													if ( (int) $all->score > 0 ) {
														$color = '#D32F2F';
														if ( ( (int) $all->score >= 50 ) ) {
															$color = 'orange';
														}
														if ( ( (int) $all->score >= 90 ) ) {
															$color = '#4CAF50';
														}
													}

													?>
                                                    <td rowspan="2" class="sq_first_header_column text-center px-3">


                                                        <div class="col-12">
                                                            <input id="knob_<?php echo (int) $all->id ?>" type="text" value="<?php echo (int) $all->score ?>" class="dial audit_score" title="<?php echo esc_attr__( "Audit Score", "squirrly-seo" ) ?>">
                                                            <script>
                                                                (function ($) {
                                                                    $(document).ready(function () {
                                                                        $("#knob_<?php echo (int) $all->id ?>").knob({
                                                                            'min': 0,
                                                                            'max': 100,
                                                                            'readOnly': true,
                                                                            'width': 100,
                                                                            'height': 100,
                                                                            'skin': "tron",
                                                                            'fgColor': '#6405e8'
                                                                        });
                                                                    });
                                                                })(jQuery);
                                                            </script>
                                                        </div>

                                                        <div class="col-12 mt-2">
															<?php echo esc_html( gmdate( 'd M Y', strtotime( $all->audit_datetime ) ) ) ?>
                                                        </div>
                                                    </td>
												<?php }
												?>
                                            </tr>


                                        </table>
                                    </li>
                                </ul>
								<?php foreach ( $view->audit->audit as $group => $audit ) {
									if ( ! isset( $view->audit->groups->$group ) ) {
										continue;
									}
									$current_group = $view->audit->groups->$group;
									?>
                                    <div class="persist-area">
                                        <ul class="sq_audit_task p-0 m-0">
                                            <li class="m-0 p-0 mt-5">
                                                <div id="sq_audit_tasks_header_<?php echo esc_attr( $group === 'inbound' ? 'links' : $group ) ?>" class="sq_audit_tasks_header m-0 p-0 p-3">
                                                    <span class="persist-header sq_audit_tasks_header_title <?php echo esc_attr( $current_group->color ) . '_text' ?>" data-id="<?php echo esc_attr( $group === 'inbound' ? 'links' : $group ) ?>"><?php echo esc_html( $group === 'inbound' ? ucfirst( 'links' ) : ucfirst( $group ) ) ?></span>
                                                    <span class="sq_audit_task_completed <?php echo esc_attr( $current_group->color ) ?>"><?php echo (int) $current_group->complete ?>/<?php echo (int) $current_group->total ?></span>
                                                </div>
                                            </li>
											<?php if ( ! empty( $audit ) ) {
												$category_name = apply_filters( 'sq_page', SQ_Classes_Helpers_Tools::getValue( 'page', 'sq_audits' ) );
												$dbtasks       = json_decode( get_option( SQ_TASKS ), true );

												foreach ( $audit as $task ) {
													?>
                                                    <li class="sq_audit_tasks_row m-0 p-0 py-4 bg-white border-bottom">
                                                        <table class="col-12 m-0 p-0">
                                                            <tr>
                                                                <td class="px-3 text-left align-middle">
                                                                    <span class="font-weight-bold"><?php echo wp_kses_post( $task->title ) ?></span>
                                                                </td>

																<?php foreach ( $view->audits as $all ) {
																	$audit_group = (array) $all->audit->$group;

																	foreach ( $audit_group as $audit_task ) {
																		if ( $task->audit_task == $audit_task->audit_task ) {

																			if ( isset( $dbtasks[ $category_name ][ ucfirst( $task->audit_task ) ] ) ) {
																				$dbtask = $dbtasks[ $category_name ][ ucfirst( $task->audit_task ) ];
																				//get the dbtask status
																				$dbtask['status'] = $dbtask['active'] ? ( ( (int) $audit_task->complete == 1 ) ? 'completed' : '' ) : 'ignore';
																			} else {
																				$dbtask['status'] = ( (int) $audit_task->complete == 1 ) ? 'completed' : '';
																			}
																			?>
                                                                            <td class="sq_first_header_column text-center px-3">

                                                                                <div class="col-12 sq_task <?php echo esc_attr( $dbtask['status'] ) ?>">
                                                                                    <i class="fa-solid <?php echo ( (int) $audit_task->complete == 1 ) ? 'fa-check-circle text-primary' : 'fa-circle text-danger' ?>" style="font-size: 30px !important;" data-category="<?php echo esc_attr( $category_name ) ?>" data-name="<?php echo esc_attr( ucfirst( $group ) ) ?>" data-completed="<?php echo (int) $audit_task->complete ?>" data-dismiss="modal"></i>
                                                                                    <h4 style="display: none"><?php echo wp_kses_post( $audit_task->title ) ?></h4>
                                                                                    <div class="description" style="display: none">
                                                                                        <div class="sq_audit_tasks_row">

                                                                                            <div class="row m-0 p-0 my-2">
                                                                                                <div class="m-0 p-0 mx-2 py-1">
                                                                                                    <i class="m-0 p-0 <?php echo ( (int) $audit_task->complete == 1 ) ? 'fa-solid fa-thumbs-up text-success' : 'fa-solid fa-thumbs-down text-danger' ?>" style="font-size: 1.8rem;"></i>
                                                                                                </div>
                                                                                                <div class="m-0 p-0 mx-2 py-1">
                                                                                                    <h5 class="m-0 p-0 font-weight-bold"><?php echo wp_kses_post( $audit_task->title ) . ( strpos( $audit_task->title, '?' ) === false ? ': ' : '' ) ?>
                                                                                                        <span class="m-0 p-0 px-2 font-weight-bold <?php echo ( (int) $audit_task->complete == 1 ) ? 'text-primary' : 'text-danger' ?>"> <?php echo wp_kses_post( $audit_task->complete ? $audit_task->success : $audit_task->fail ) ?> </span>
                                                                                                    </h5>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-12 m-0 p-0 py-1 px-1">
                                                                                                <div class="m-0 p-0 font-weight-bold <?php echo ( (int) $audit_task->complete == 1 ) ? 'text-primary' : 'text-danger' ?>"> <?php echo wp_kses_post( $audit_task->complete ? $audit_task->success_list : $audit_task->fail_list ) ?> </div>
                                                                                            </div>

                                                                                            <div class="my-4 p-0"></div>
                                                                                            <div class="sq_audit_tasks_description">
																								<?php echo wp_kses_post( $audit_task->description ) ?>
																								<?php if ( $audit_task->protip <> '' ) { ?>
                                                                                                    <div class="my-3 p-0">
                                                                                                        <strong class="text-primary"><?php echo esc_html__( "PRO TIP", "squirrly-seo" ) ?>
                                                                                                            :</strong> <?php echo wp_kses_post( $audit_task->protip ) ?>
                                                                                                    </div>
																								<?php } ?>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="message" style="display: none"></div>
                                                                                </div>
                                                                                <div class="col-12 mt-2">
																					<?php echo esc_html( gmdate( 'd M Y', strtotime( $all->audit_datetime ) ) ) ?>
                                                                                </div>
                                                                            </td>
																		<?php }
																	}
																} ?>
                                                            </tr>

                                                        </table>
                                                    </li>
												<?php }
											} ?>

                                        </ul>
                                    </div>
								<?php } ?>
							<?php } ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<style>#sq_assistant_modal .sq_save_ajax {
        display: none;
    }</style>