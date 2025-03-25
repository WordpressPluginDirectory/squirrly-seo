<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Briefcase Labels view
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

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                <h3 class="mt-4 card-title">
					<?php echo esc_html__( "Briefcase Labels", 'squirrly-seo' ); ?>
                    <div class="sq_help_question d-inline">
                        <a href="https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#labels" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                    </div>
                </h3>
                <div class="col-7 small m-0 p-0">
					<?php echo esc_html__( "Briefcase Labels will help you sort your keywords based on your SEO strategy. Labels are like categories and you can quickly filter your keywords by one or more labels.", 'squirrly-seo' ); ?>
                </div>

                <div id="sq_briefcaselabels" class="col-12 m-0 p-0 border-0">
					<?php do_action( 'sq_subscription_notices' ); ?>

                    <div class="row col-12 p-0 m-0 my-3">
                        <button class="btn btn-lg btn-primary text-white" onclick="jQuery('.sq_add_labels_dialog').modal('show');jQuery('.sq_add_labels_dialog').find('[autofocus]').focus();" data-dismiss="modal">
							<?php echo esc_html__( "Add new Label", 'squirrly-seo' ); ?>
                            <i class="fa-solid fa-plus-square"></i>
                        </button>
                    </div>

					<?php if ( is_array( $view->labels ) && ! empty( $view->labels ) ) { ?>
                        <div class="row col-12 m-0 p-0 py-2">
                            <div class="col-6 p-0">
                                <select name="sq_bulk_action" class="sq_bulk_action">
                                    <option value=""><?php echo esc_html__( "Bulk Actions", 'squirrly-seo' ) ?></option>
                                    <option value="sq_ajax_labels_bulk_delete" data-confirm="<?php echo esc_attr__( "Are you sure you want to delete the labels?", 'squirrly-seo' ) ?>"><?php echo esc_html__( "Delete" ) ?></option>
                                </select>
                                <button class="sq_bulk_submit btn btn-primary"><?php echo esc_html__( "Apply" ); ?></button>
                            </div>

                            <div class="col-6 p-0 m-0">
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
                                <th style="width: 10px;"><input type="checkbox" class="sq_bulk_select_input"/></th>
                                <th style="width: 50%;"><?php echo esc_html__( "Name", 'squirrly-seo' ) ?></th>
                                <th style="width: 25%;"><?php echo esc_html__( "Color", 'squirrly-seo' ) ?></th>
                                <th style="width: 25%;"><?php echo esc_html__( "Used", 'squirrly-seo' ) ?></th>
                                <th style="width: 20px;"></th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							foreach ( $view->labels as $key => $row ) {
								if ( ! $row->id ) {
									continue;
								}
								?>
                                <tr id="sq_row_<?php echo (int) $row->id ?>">
                                    <td style="width: 10px;">
										<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                            <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo (int) $row->id ?>"/>
										<?php } ?>
                                    </td>

                                    <td style="width: 50%;" class="text-left">
										<?php echo esc_html( $row->name ) ?>
                                    </td>
                                    <td style="width: 25%;">
                                        <span style="display: inline-block; background-color:<?php echo esc_attr( $row->color ) ?>; width: 100px;height: 20px; margin-right: 10px;"></span>
                                    </td>
                                    <td style="width: 25%;" class="text-left">
                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase', array( 'slabel[0]=' . (int) $row->id ) ) ?>"><strong><?php echo esc_html( $row->keywords ) ?></strong></a>
                                    </td>

                                    <td class="px-0 py-2" style="width: 20px">
                                        <div class="sq_sm_menu">
                                            <div class="sm_icon_button sm_icon_options">
                                                <i class="fa-solid fa-ellipsis-v"></i>
                                            </div>
                                            <div class="sq_sm_dropdown">
                                                <ul class="text-left p-2 m-0">
                                                    <li class="sq_edit_label m-0 p-1 py-2" data-id="<?php echo (int) $row->id ?>" data-name="<?php echo esc_attr( $row->name ) ?>" data-color="<?php echo esc_attr( $row->color ) ?>">
                                                        <i class="sq_icons_small fa-solid fa-tag"></i>
														<?php echo esc_html__( "Edit Label", 'squirrly-seo' ) ?>
                                                    </li>
													<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                                        <li class="sq_delete_label m-0 p-1 py-2" data-id="<?php echo (int) $row->id ?>">
                                                            <i class="sq_icons_small fa-solid fa-trash"></i>
															<?php echo esc_html__( "Delete Label", 'squirrly-seo' ) ?>
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
                            <h4 class="text-center"><?php echo esc_html__( "Welcome to Briefcase Labels", 'squirrly-seo' ); ?></h4>
                            <div class="col-12 m-2 text-center">
                                <button class="btn btn-lg btn-primary" onclick="jQuery('.sq_add_labels_dialog').modal('show');jQuery('.sq_add_labels_dialog').find('[autofocus]').focus();" data-dismiss="modal">
                                    <i class="fa-solid fa-plus-square-o"></i> <?php echo esc_html__( "Add label to organize the keywords in Briefcase", 'squirrly-seo' ); ?>
                                </button>
                            </div>
                        </div>
					<?php } ?>

                    <div class="sq_add_labels_dialog modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content bg-white rounded-0">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo esc_html__( "Add New Label", 'squirrly-seo' ); ?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="sq_labelname"><?php echo esc_html__( "Label Name", 'squirrly-seo' ); ?></label>
                                        <input type="text" class="form-control" id="sq_labelname" maxlength="35" autofocus/>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="sq_labelcolor" style="display: block"><?php echo esc_html__( "Label Color", 'squirrly-seo' ); ?></label>
                                        </div>
                                        <input type="text" id="sq_labelcolor" value="<?php echo esc_attr( sprintf( '#%06X', mt_rand( 0, 0xFFFFFF ) ) ); ?>"/>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-bottom: 1px solid #ddd;">
                                    <button type="button" id="sq_save_label" class="btn btn-primary"><?php echo esc_html__( "Add Label", 'squirrly-seo' ); ?></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="sq_edit_label_dialog modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content bg-white rounded-0">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo esc_html__( "Edit Label", 'squirrly-seo' ); ?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="sq_labelname"><?php echo esc_html__( "Label Name", 'squirrly-seo' ); ?></label>
                                        <input type="text" class="form-control" id="sq_labelname" maxlength="35"/>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="sq_labelcolor"><?php echo esc_html__( "Label Color", 'squirrly-seo' ); ?></label>
                                        </div>
                                        <input type="text" id="sq_labelcolor"/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" id="sq_labelid"/>
                                    <button type="button" id="sq_save_label" class="btn btn-primary"><?php echo esc_html__( "Save Label", 'squirrly-seo' ); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>

					<?php do_action( 'sq_labels_after' ); ?>

                </div>

                <div class="sq_tips col-12 m-0 p-0">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left">
							<?php echo esc_html__( "To delete Labels in bulk: select the labels you want to delete, go to Bulk Actions, select Delete, and then click on Apply.", 'squirrly-seo' ); ?>
                        </li>
                        <li class="text-left">
							<?php echo esc_html__( "NOTE! Deleting a Label will NOT delete the keywords assigned to it from Briefcase.", 'squirrly-seo' ); ?>
                        </li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php echo SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_labels_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
