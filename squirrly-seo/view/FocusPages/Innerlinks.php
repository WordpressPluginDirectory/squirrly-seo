<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}
/**
 * Inner Links view
 *
 * Called from Focus Pages Controller on  Inner Links Tab
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Editor role.", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4 pb-5">
				<?php do_action( 'sq_form_notices' ); ?>

                <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab', 'innerlinks' ) ) ?></div>

                <h3 class="mt-4 card-title">
					<?php echo esc_html__( "Inner Links", "squirrly-seo" ); ?>
                    <div class="sq_help_question d-inline">
                        <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/" target="_blank"><i class="fa-solid fa-question-circle"></i></a>
                    </div>
                </h3>
                <div class="col-7 small m-0 p-0">
					<?php echo esc_html__( "The list of inner links set in Squirrly SEO.", "squirrly-seo" ); ?>
                </div>

                <div id="sq_innerlinks" class="col-12 m-0 p-0 border-0">

                    <div class="col-12 m-0 p-0 my-4">

                        <div class="row col-12 p-0 m-0 my-3">
                            <button class="btn btn-lg btn-primary text-white" onclick="jQuery('.sq_add_innerlink_dialog').modal('show')" data-dismiss="modal">
								<?php echo esc_html__( "Add Inner Link", "squirrly-seo" ); ?>
                                <i class="fa-solid fa-plus-square"></i>
                            </button>
                            <button class="sq_innerlinks_suggestion btn btn-lg btn-primary text-white mx-3" style="display: none">
								<?php echo esc_html__( "Suggested Inner Links", "squirrly-seo" ); ?>
                                <i class="fa-solid fa-plus-square"></i>
                            </button>
                        </div>

                        <div class="row col-12 m-0 p-0 py-3">

                            <div class="row col-6 p-0 m-0">
                                <div class="p-0 m-0 pr-3">
                                    <select name="sq_bulk_action" class="sq_bulk_action">
                                        <option value=""><?php echo esc_html__( "Bulk Actions", "squirrly-seo" ) ?></option>
                                        <option value="sq_ajax_innerlinks_bulk_check"><?php echo esc_html__( "Check" ) ?></option>
                                        <option value="sq_ajax_innerlinks_bulk_delete" data-confirm="<?php echo esc_attr__( "Are you sure you want to delete the inner link?", "squirrly-seo" ) ?>"><?php echo esc_html__( "Delete" ) ?></option>
                                    </select>

                                    <button class="sq_bulk_submit btn btn-primary"><?php echo esc_html__( "Apply" ); ?></button>
                                </div>

                                <form id="sq_type_form" method="get" class="form-inline col p-0 m-0">
                                    <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                    <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                    <input type="hidden" name="squery" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'squery' ) ) ?>">
                                    <input type="hidden" name="stype" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'stype' ) ) ?>">
                                    <input type="hidden" name="snum" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'snum' ) ) ?>">

                                    <div class="col-12 row p-0 m-0">
                                        <select name="stype" class="w-100 m-0 p-1" onchange="jQuery('form#sq_type_form').submit();">
                                            <option value=""><?php echo esc_html__( "All Inner links" ); ?></option>
                                            <option value="nofollow" <?php echo selected( SQ_Classes_Helpers_Tools::getValue( 'stype' ), 'nofollow' ) ?> ><?php echo esc_html__( "Nofollow" ); ?></option>
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <div class="col-6 p-0 m-0 text-right">
                                <form method="get" class="d-flex flex-row justify-content-end p-0 m-0">
                                    <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page' ) ) ?>">
                                    <input type="hidden" name="tab" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?>">
                                    <input type="hidden" name="stype" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'stype' ) ) ?>">
                                    <input type="search" class="d-inline-block align-middle col-7 py-0 px-2 mr-0 rounded-0" id="post-search-input" name="squery" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'squery' ) ) ?>" placeholder="<?php echo esc_attr__( "Write the keyword you want to search for", "squirrly-seo" ) ?>"/>
                                    <input type="submit" class="btn btn-primary" value="<?php echo esc_attr__( "Search", "squirrly-seo" ) ?> >"/>
									<?php if ( SQ_Classes_Helpers_Tools::getIsset( 'squery' ) ) { ?>
                                        <button type="button" class="btn btn-link text-primary ml-1" onclick="location.href = '<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page' ), SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ) ?>';" style="cursor: pointer"><?php echo esc_html__( "Show All", "squirrly-seo" ) ?></button>
									<?php } ?>
                                </form>
                            </div>
                        </div>

                        <div class="p-0">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 10px;"><input type="checkbox" class="sq_bulk_select_input"/></th>
                                    <th style="width: 30%;"><?php echo esc_html__( "Keyword", "squirrly-seo" ) ?></th>
                                    <th style="width: 30%;"><?php echo esc_html__( "From", "squirrly-seo" ) ?></th>
                                    <th style="width: 30%;"><?php echo esc_html__( "To", "squirrly-seo" ) ?></th>
                                    <th style="width: 30%;"><?php echo esc_html__( "Status", "squirrly-seo" ) ?></th>
                                    <th style="width: 20px;"></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								if ( ! empty( $view->innerlinks ) ) {
									foreach ( $view->innerlinks as $innerlink ) {
										$from_url = get_permalink( $innerlink->from_post_id );
										$to_url   = get_permalink( $innerlink->to_post_id );
										if ( ! isset( $innerlink->nofollow ) ) {
											$innerlink->nofollow = SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' );
										}
										if ( ! isset( $innerlink->blank ) ) {
											$innerlink->blank = SQ_Classes_Helpers_Tools::getOption( 'blank' );
										}

										$attributes = array();
										if ( $innerlink->nofollow ) {
											$attributes[] = esc_attr__( "Nofollow", "squirrly-seo" );
										}
										if ( $innerlink->blank ) {
											$attributes[] = esc_attr__( "Open New Tab", "squirrly-seo" );
										}

										?>
                                        <tr id="sq_row_<?php echo esc_attr( $innerlink->id ) ?>">
                                            <td style="width: 10px;">
												<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                                    <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo esc_attr( $innerlink->id ) ?>"/>
												<?php } ?>
                                            </td>
                                            <td class="text-left">
												<?php echo esc_html( $innerlink->keyword ); ?>
												<?php if ( ! empty( $attributes ) ) { ?>
                                                    <div class="text-black-50 small" style="font-size: x-small"><?php echo esc_html( join( ", ", $attributes ) ) ?></div>
												<?php } ?>
                                            </td>
                                            <td style="width: 40%;" class="text-left">
                                                <a href="<?php echo esc_url( $from_url ) ?>"><?php echo esc_url( wp_make_link_relative( urldecode( $from_url ) ) ) ?></a>

                                            </td>
                                            <td style="width: 40%;" class="text-left">
                                                <a href="<?php echo esc_url( $to_url ) ?>"><?php echo esc_url( wp_make_link_relative( urldecode( $to_url ) ) ) ?></a>
                                            </td>

                                            <td style="width: 20px" class="text-left py-3">

												<?php if ( ! $innerlink->valid ) { ?>
                                                    <i class="fa-solid fa-triangle-exclamation m-1" title="<?php echo esc_attr__( "No keyword found on page", "squirrly-seo" ) ?>"></i>
												<?php } else { ?>
                                                    <span class="text-nowrap small text-black-50" title="<?php echo (int) $innerlink->valid . ' ' . esc_html__( 'valid keywords found', "squirrly-seo" ); ?>"><?php echo (int) $innerlink->valid . ' ' . esc_html__( 'found', "squirrly-seo" ); ?></span>
												<?php } ?>
                                            </td>

                                            <td class="px-0 py-2" style="width: 20px">
                                                <div class="sq_sm_menu">
                                                    <div class="sm_icon_button sm_icon_options">
                                                        <i class="fa-solid fa-ellipsis-v"></i>
                                                    </div>
                                                    <div class="sq_sm_dropdown">
                                                        <ul class="text-left p-2 m-0">
															<?php if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) { ?>
                                                                <li class="sq_edit_rule m-0 p-1 py-2" onclick="jQuery('#sq_edit_innerlink_<?php echo esc_attr( $innerlink->id ) ?>').modal('show')" data-dismiss="modal">
                                                                    <i class="sq_icons_small fa-solid fa-tag"></i>
																	<?php echo esc_html__( "Edit Inner Link", "squirrly-seo" ) ?>
                                                                </li>
                                                                <li class="sq_delete_rule m-0 p-1 py-2">
                                                                    <form method="post" class="p-0 m-0">
																		<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_checkinnerlink', 'sq_nonce' ); ?>
                                                                        <input type="hidden" name="action" value="sq_focuspages_checkinnerlink"/>
                                                                        <input type="hidden" name="id" value="<?php echo esc_attr( $innerlink->id ) ?>"/>
                                                                        <input type="hidden" name="post_id" value="<?php echo (int) $innerlink->from_post_id ?>"/>
                                                                        <i class="sq_icons_small fa-solid fa-refresh" style="padding: 2px"></i>
                                                                        <button type="submit" class="btn btn-sm bg-transparent font-weight-normal p-0 m-0">
																			<?php echo esc_html__( "Check Inner Link", "squirrly-seo" ) ?>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li class="sq_delete_rule m-0 p-1 py-2">
                                                                    <form method="post" class="p-0 m-0" onSubmit="return confirm('<?php echo esc_html__( "Do you want to delete the Inner Link?", "squirrly-seo" ) ?>') ">
																		<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_deleteinnerlink', 'sq_nonce' ); ?>
                                                                        <input type="hidden" name="action" value="sq_focuspages_deleteinnerlink"/>
                                                                        <input type="hidden" name="id" value="<?php echo esc_attr( $innerlink->id ) ?>"/>
                                                                        <input type="hidden" name="post_id" value="<?php echo (int) $innerlink->from_post_id ?>"/>
                                                                        <i class="sq_icons_small fa-solid fa-trash" style="padding: 2px"></i>
                                                                        <button type="submit" class="btn btn-sm bg-transparent font-weight-normal p-0 m-0">
																			<?php echo esc_html__( "Delete Inner Link", "squirrly-seo" ) ?>
                                                                        </button>
                                                                    </form>
                                                                </li>
															<?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
										<?php
									}
								} else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
											<?php echo esc_html__( "No Inner Links found", "squirrly-seo" ); ?>
                                        </td>
                                    </tr>
								<?php } ?>

                                </tbody>
                            </table>
							<?php if ( isset( $view->max_num_pages ) && $view->max_num_pages ) { ?>
                                <div class="alignleft mr-3">
                                    <select name="snum" onchange="location.href = '<?php echo esc_url( add_query_arg( array(
										'spage' => 1,
										'snum'  => "'+jQuery(this).find('option:selected').val()+'"
									) ) ); ?>'">
										<?php
										$post_on_page = array( 10, 20, 50, 100, 500 );
										foreach ( $post_on_page as $num ) {
											?>
                                            <option value="<?php echo esc_attr( $num ) ?>" <?php selected( $num, SQ_Classes_Helpers_Tools::getValue( 'snum' ) ) ?> ><?php echo esc_html( $num ) . ' ' . esc_html__( 'records', "squirrly-seo" ) ?></option><?php
										}
										?>
                                    </select>
                                </div>

                                <div class="nav-previous alignright">
									<?php SQ_Classes_Helpers_Tools::pagination( (int) $view->max_num_pages ); ?>
                                </div>
							<?php } ?>
                        </div>

                    </div>

					<?php do_action( 'sq_innerlinks_after' ); ?>

                </div>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
                </div>
            </div>
        </div>
    </div>

    <div class="sq_add_innerlink_dialog modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-white rounded-0">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo esc_html__( "Add New Inner Link", "squirrly-seo" ); ?>
                        <a href="https://howto12.squirrly.co/kb/focus-pages-innerlinks/#add" target="_blank"><i class="fa-solid fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" class="p-0 m-0">
                    <div class="modal-body">
						<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_addinnerlink', 'sq_nonce' ); ?>
                        <input type="hidden" name="action" value="sq_focuspages_addinnerlink"/>

                        <div class="form-group">
                            <label for="keyword"><?php echo esc_html__( "Keyword", "squirrly-seo" ); ?></label>
                            <input id="keyword" type="text" class="form-control" name="keyword" maxlength="255" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="from_post_ids"><?php echo esc_html__( "From Page", "squirrly-seo" ); ?></label>
                            <select id="from_post_ids" multiple name="from_post_ids[]" class="sq_selectpicker form-control border" data-live-search="true" required="required"></select>
                        </div>
                        <div class="form-group">
                            <label for="to_post_id"><?php echo esc_html__( "To Page", "squirrly-seo" ); ?></label>
                            <select id="to_post_id" name="to_post_id" class="sq_selectpicker form-control border" data-live-search="true" required="required"></select>
                        </div>

						<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ) { ?>
                            <div class="col-12 row m-0 p-0">
                                <div class="checker col-12 row my-2 p-0 mx-0">
                                    <div class="col-12 p-0 m-0">
                                        <input type="checkbox" id="sq_advanced" class="sq-switch" value="1" style="display: none"/>
                                        <label for="sq_advanced" class="ml-1"><?php echo esc_html__( "More Options", "squirrly-seo" ); ?>
                                            ></label>
                                    </div>
                                </div>
                            </div>
						<?php } ?>

                        <div class="col-12 row m-0 p-0 my-4 sq_auto_innelinks sq_advanced">
                            <div class="checker col-12 row m-0 p-0">
                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                    <input type="hidden" name="nofollow" value="0"/>
                                    <input type="checkbox" id="nofollow" name="nofollow" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                    <label for="nofollow" class="ml-1"><?php echo esc_html__( "NoFollow Link", "squirrly-seo" ); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 row m-0 p-0 my-4 sq_auto_innelinks sq_advanced">
                            <div class="checker col-12 row m-0 p-0">
                                <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                    <input type="hidden" name="blank" value="0"/>
                                    <input type="checkbox" id="blank" name="blank" class="sq-switch" <?php echo( ( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_blank' ) ) ? 'checked="checked"' : '' ); ?> value="1"/>
                                    <label for="blank" class="ml-1"><?php echo esc_html__( "Open in New Tab", "squirrly-seo" ); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" style="border-bottom: 1px solid #ddd;">
                        <button type="submit" class="btn btn-primary noloading"><?php echo esc_html__( "Add Inner Link", "squirrly-seo" ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<?php
	if ( ! empty( $view->innerlinks ) ) {
		foreach ( $view->innerlinks as $innerlink ) {

			$from_url = get_permalink( $innerlink->from_post_id );
			$to_url   = get_permalink( $innerlink->to_post_id );

			if ( ! isset( $innerlink->nofollow ) ) {
				$innerlink->nofollow = SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' );
			}
			if ( ! isset( $innerlink->blank ) ) {
				$innerlink->blank = SQ_Classes_Helpers_Tools::getOption( 'blank' );
			}
			?>

            <div id="sq_edit_innerlink_<?php echo esc_attr( $innerlink->id ) ?>" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white rounded-0">
                        <div class="modal-header">
                            <h4 class="modal-title"><?php echo esc_html__( "Edit Inner Link", "squirrly-seo" ); ?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <form method="post" class="p-0 m-0">
                            <div class="modal-body">
								<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_focuspages_addinnerlink', 'sq_nonce' ); ?>
                                <input type="hidden" name="action" value="sq_focuspages_addinnerlink"/>
                                <input type="hidden" name="id" value="<?php echo esc_attr( $innerlink->id ) ?>"/>

                                <div class="form-group">
                                    <label for="keyword<?php echo esc_attr( $innerlink->id ) ?>"><?php echo esc_html__( "Keyword", "squirrly-seo" ); ?></label>
                                    <input id="keyword<?php echo esc_attr( $innerlink->id ) ?>" type="text" class="form-control" name="keyword" value="<?php echo esc_attr( $innerlink->keyword ) ?>" maxlength="255" required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="from_post_id<?php echo esc_attr( $innerlink->id ) ?>"><?php echo esc_html__( "From Page", "squirrly-seo" ); ?></label>
                                    <input type="text" disabled="disabled" class="form-control" value="<?php echo esc_url( urldecode( $from_url ) ) ?>">
                                    <input id="from_post_id<?php echo esc_attr( $innerlink->id ) ?>" type="hidden" class="form-control" name="from_post_id" value="<?php echo (int) $innerlink->from_post_id ?>" maxlength="10"/>
                                </div>
                                <div class="form-group">
                                    <label for="to_post_id<?php echo esc_attr( $innerlink->id ) ?>"><?php echo esc_html__( "To Page", "squirrly-seo" ); ?></label>
                                    <input type="text" disabled="disabled" class="form-control" value="<?php echo esc_url( urldecode( $to_url ) ) ?>">
                                    <input id="to_post_id<?php echo esc_attr( $innerlink->id ) ?>" type="hidden" class="form-control" name="to_post_id" value="<?php echo (int) $innerlink->to_post_id ?>" maxlength="10"/>
                                </div>

								<?php if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ) { ?>
                                    <div class="col-12 row m-0 p-0">
                                        <div class="checker col-12 row my-2 p-0 mx-0">
                                            <div class="col-12 p-0 m-0">
                                                <input type="checkbox" id="sq_advanced" class="sq-switch" value="1" style="display: none"/>
                                                <label for="sq_advanced" class="ml-1"><?php echo esc_html__( "More Options", "squirrly-seo" ); ?>
                                                    ></label>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>

                                <div class="col-12 row m-0 p-0 my-4 sq_auto_innelinks sq_advanced">
                                    <div class="checker col-12 row m-0 p-0">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="nofollow" value="0"/>
                                            <input type="checkbox" id="nofollow<?php echo esc_attr( $innerlink->id ) ?>" name="nofollow" class="sq-switch" <?php echo( (int) $innerlink->nofollow ? 'checked="checked"' : '' ); ?> value="1"/>
                                            <label for="nofollow<?php echo esc_attr( $innerlink->id ) ?>" class="ml-1"><?php echo esc_html__( "NoFollow Link", "squirrly-seo" ); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 row m-0 p-0 my-4 sq_auto_innelinks sq_advanced">
                                    <div class="checker col-12 row m-0 p-0">
                                        <div class="col-12 m-0 p-0 sq-switch sq-switch-sm">
                                            <input type="hidden" name="blank" value="0"/>
                                            <input type="checkbox" id="blank<?php echo esc_attr( $innerlink->id ) ?>" name="blank" class="sq-switch" <?php echo( (int) $innerlink->blank ? 'checked="checked"' : '' ); ?> value="1"/>
                                            <label for="blank<?php echo esc_attr( $innerlink->id ) ?>" class="ml-1"><?php echo esc_html__( "Open in New Tab", "squirrly-seo" ); ?></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer" style="border-bottom: 1px solid #ddd;">
                                <button type="submit" class="btn btn-primary noloading"><?php echo esc_html__( "Update Inner Link", "squirrly-seo" ); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

		<?php }
	} ?>
</div>

