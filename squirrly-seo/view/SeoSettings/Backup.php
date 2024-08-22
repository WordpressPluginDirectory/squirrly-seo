<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Backup view
 *
 * Called from Settings Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>

    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role", 'squirrly-seo' ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
				<?php do_action( 'sq_form_notices' ); ?>


                <div class="col-12 p-0 m-0">

                    <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                    <h3 class="mt-4 card-title">
						<?php echo esc_html__( "Import & Data", 'squirrly-seo' ); ?>
                        <div class="sq_help_question d-inline">
                            <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                        </div>
                    </h3>
                    <div class="col-7 small m-0 p-0">
						<?php echo esc_html__( "Import the settings and SEO from other plugins so you can use only Squirrly SEO for on-page SEO.", 'squirrly-seo' ); ?>
                    </div>
                    <div class="col-7 small m-0 p-0 py-2">
						<?php echo esc_html__( "Use the Backup, Restore, and Rollback settings to control plugin data.", 'squirrly-seo' ); ?>
                    </div>
                    <div class="col-7 small m-0 p-0 py-2">
						<?php echo esc_html__( "Note! If you import the SEO settings from other plugins or themes, you will lose all the settings that you had in Squirrly SEO. Make sure you backup your settings from the panel below before you do this.", 'squirrly-seo' ); ?>
                    </div>

					<?php $view->show_view( 'Blocks/SubMenuHeader' ); ?>
                    <div class="d-flex flex-row p-0 m-0 bg-white">
						<?php $view->show_view( 'Blocks/SubMenu' ); ?>

                        <div class="d-flex flex-column flex-grow-1 m-0 p-0">
							<?php $platforms = apply_filters( 'sq_importList', false ); ?>

                            <div id="import" class="col-12 py-0 px-4 m-0 tab-panel tab-panel-first active">

                                <div class="col-12 m-0 p-0 my-2">
                                    <h3 class="card-title"><?php echo esc_html__( "Import Settings & SEO", 'squirrly-seo' ); ?>
                                        <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#import_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                    </h3>
                                    <div class="col-12 small m-0 p-0">
										<?php echo esc_html__( "Import the settings and SEO from other plugins so you can use only Squirrly SEO for on-page SEO.", 'squirrly-seo' ); ?>
                                    </div>
                                    <div class="col-12 small m-0 p-0 py-2">
										<?php echo esc_html__( "Note! If you import the SEO settings from other plugins or themes, you will lose all the settings that you had in Squirrly SEO. Make sure you back up your settings from the panel below before you do this.", 'squirrly-seo' ); ?>
                                    </div>

                                </div>

                                <div class="col-12 m-0 p-0 my-5">

                                    <form name="import" action="" method="post" enctype="multipart/form-data">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                <div class="font-weight-bold"><?php echo esc_html__( "Import Settings From", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select the plugin or theme you want to import the Settings from.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-7 m-0 p-0 input-group">
												<?php
												if ( $platforms && count( (array) $platforms ) > 0 ) {
													?>
                                                    <select name="sq_import_platform" class="form-control bg-input mb-1 border">
														<?php
														foreach ( $platforms as $path => $settings ) {
															?>
                                                            <option value="<?php echo esc_attr( $path ) ?>"><?php echo esc_html( ucfirst( SQ_Classes_ObjController::getClass( 'SQ_Models_ImportExport' )->getName( $path ) ) ); ?></option>
														<?php } ?>
                                                    </select>

													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_importsettings', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_importsettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-2 m-0" style="min-width: 140px"><?php echo esc_html__( "Import Settings", 'squirrly-seo' ); ?></button>
                                                    <div class="col-12 p-0 m-0">
                                                        <div class="small text-danger"><?php echo esc_html__( "Note! It will overwrite the settings you set in Squirrly SEO.", 'squirrly-seo' ); ?></div>
                                                    </div>
												<?php } else { ?>
                                                    <div class="col-12 my-2"><?php echo esc_html__( "We couldn't find any SEO plugin or theme to import from.", 'squirrly-seo' ); ?></div>
												<?php } ?>
                                            </div>
                                        </div>
                                    </form>

                                    <form name="import" action="" method="post" enctype="multipart/form-data">

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                <div class="font-weight-bold"><?php echo esc_html__( "Import SEO From", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select the plugin or theme you want to import the SEO & Patterns from.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-7 p-0 input-group">
												<?php
												if ( $platforms && count( (array) $platforms ) > 0 ) {
													?>
                                                    <select name="sq_import_platform" class="form-control bg-input mb-1 border">
														<?php
														foreach ( $platforms as $path => $settings ) {
															?>
                                                            <option value="<?php echo esc_attr( $path ) ?>"><?php echo esc_html( ucfirst( SQ_Classes_ObjController::getClass( 'SQ_Models_ImportExport' )->getName( $path ) ) ); ?></option>
														<?php } ?>
                                                    </select>

													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_importseo', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_importseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-2 m-0" style="min-width: 140px"><?php echo esc_html__( "Import SEO", 'squirrly-seo' ); ?></button>

                                                    <div class="col-12 p-0 m-0">
                                                        <div class="checker m-0 py-2 px-0">
                                                            <div class="sq-switch sq-switch-sm ">
                                                                <label for="sq_import_overwrite" class="mr-2"><?php echo esc_html__( "Overwrite all existing SEO Snippets optimizations", 'squirrly-seo' ); ?></label for="sq_import_overwrite" >
                                                                <input type="checkbox" id="sq_import_overwrite" name="sq_import_overwrite" class="sq-switch" value="1"/>
                                                                <label for="sq_import_overwrite"></label>
                                                            </div>
                                                        </div>
                                                    </div>

												<?php } else { ?>
                                                    <div class="col-12 my-2"><?php echo esc_html__( "We couldn't find any SEO plugin or theme to import from.", 'squirrly-seo' ); ?></div>
												<?php } ?>
                                            </div>
                                        </div>
                                    </form>

                                </div>

								<?php do_action( 'sq_backup_import_after' ); ?>

                            </div>
                            <div id="backup" class="col-12 py-0 px-4 m-0 tab-panel">

                                <div class="col-12 m-0 p-0 my-2">
                                    <h3 class="card-title"><?php echo esc_html__( "Backup Settings & SEO", 'squirrly-seo' ); ?>
                                        <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#backup_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                    </h3>
                                    <div class="col-12 text-left m-0 p-0">
                                        <div class="col-12 small m-0 p-0"><?php echo esc_html__( "Download your Squirrly settings in an SQL file before importing the SEO settings from another plugin. This way, you can always go back to your Squirrly settings.", 'squirrly-seo' ); ?></div>
                                    </div>
                                </div>

                                <div class="col-12 m-0 p-0 my-5">

                                    <div class="col-12 pt-0 pb-4 border-bottom">
                                        <form name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Backup Settings", 'squirrly-seo' ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Download all the settings from Squirrly SEO.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_backupsettings', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_backupsettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-2 m-0 noloading" style="min-width: 175px"><?php echo esc_html__( "Download  Backup", 'squirrly-seo' ); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                <div class="font-weight-bold"><?php echo esc_html__( "Backup SEO", 'squirrly-seo' ); ?>
                                                    :
                                                </div>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Download all the Squirrly SEO Snippet optimizations.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-7 p-0 input-group">
                                                <form name="import" action="" method="post" enctype="multipart/form-data">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_backupseo', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_backupseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-2 m-0 mr-1 mb-1 noloading" style="min-width: 175px"><?php echo esc_html__( "Download Backup", 'squirrly-seo' ); ?></button>
                                                </form>
                                                <form name="export" action="" method="post" class="sq_advanced" enctype="multipart/form-data">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_exportseo', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_exportseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-light px-2 m-0 noloading border" style="min-width: 175px"><?php echo esc_html__( "Export as Json", 'squirrly-seo' ); ?></button>
                                                </form>
                                            </div>
                                        </div>

                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Backup Briefcase", 'squirrly-seo' ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Download all Briefcase Keywords.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_briefcase_backup', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_briefcase_backup"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-2 m-0 noloading" style="min-width: 175px"><?php echo esc_html__( "Download Backup", 'squirrly-seo' ); ?></button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>

								<?php do_action( 'sq_backup_backup_after' ); ?>

                            </div>
                            <div id="restore" class="col-12 py-0 px-4 m-0 tab-panel">

                                <div class="col-12 m-0 p-0 my-2">
                                    <h3 class="card-title"><?php echo esc_html__( "Restore Settings & SEO", 'squirrly-seo' ); ?>
                                        <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#restore_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                    </h3>
                                    <div class="col-12 small m-0 p-0">
										<?php echo esc_html__( "Restore the settings and all the pages optimized with Squirrly SEO.", 'squirrly-seo' ); ?>
                                    </div>
                                </div>

                                <div class="col-12 m-0 p-0 my-5">

                                    <div class="col-12 pt-0 pb-4 border-bottom">
                                        <form name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Restore Settings", 'squirrly-seo' ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Upload the file with the saved Squirrly Settings.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
                                                    <div class="form-group m-0 p-0">
                                                        <input type="file" class="form-control-file border" style="height: 48px; line-height: 35px;" name="sq_options">
                                                    </div>
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_restoresettings', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_restoresettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-3 m-0" style="min-width: 160px"><?php echo esc_html__( "Restore Settings", 'squirrly-seo' ); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Restore SEO", 'squirrly-seo' ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Upload the SQL file with the saved Squirrly SEO snippet optimizations.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
                                                    <div class="form-group m-0 p-0">
                                                        <input type="file" class="form-control-file border" style="height: 48px; line-height: 35px;" name="sq_sql">
                                                    </div>
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_seosettings_restoreseo', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_restoreseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-3 m-0" style="min-width: 160px"><?php echo esc_html__( "Restore SEO", 'squirrly-seo' ); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Restore Keywords", 'squirrly-seo' ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Upload the file with the saved Squirrly Briefcase Keywords.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
                                                    <div class="form-group m-0 p-0">
                                                        <input type="file" class="form-control-file border" style="height: 48px; line-height: 35px;" name="sq_upload_file">
                                                    </div>
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_briefcase_restore', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_briefcase_restore"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-3 m-0" style="min-width: 160px"><?php echo esc_html__( "Restore Keywords", 'squirrly-seo' ); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

								<?php do_action( 'sq_backup_restore_after' ); ?>

                            </div>
                            <div id="rollback" class="col-12 py-0 px-4 m-0 tab-panel">

                                <div class="col-12 m-0 p-0 my-2">
                                    <h3 class="card-title"><?php echo esc_html__( "Rollback Plugin", 'squirrly-seo' ); ?>
                                        <a href="https://howto12.squirrly.co/kb/import-export-seo-settings/#rollback_squirrly_seo" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                                    </h3>
                                    <div class="col-12 small m-0 p-0">
										<?php echo esc_html__( "You can rollback Squirrly SEO plugin to the last stable version.", 'squirrly-seo' ); ?>
                                    </div>
                                </div>

                                <div class="col-12 m-0 p-0 my-5">

                                    <form id="sq_rollback_form" name="import" action="" method="post" enctype="multipart/form-data">
                                        <div class="col-12 row m-0 p-0 my-5">
                                            <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                <div class="font-weight-bold"><?php echo esc_html__( "Rollback to version", 'squirrly-seo' ) . ' ' . esc_html( SQ_STABLE_VERSION ); ?>
                                                    :
                                                </div>
                                                <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Install the last stable version of the plugin.", 'squirrly-seo' ); ?></div>
                                            </div>
                                            <div class="col-7 p-0 input-group">
												<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_rollback', 'sq_nonce' ); ?>
                                                <input type="hidden" name="action" value="sq_rollback"/>
                                                <button type="submit" class="btn rounded-0 btn-primary px-2 m-0" style="min-width: 250px"><?php echo esc_html__( "Install Squirrly SEO", 'squirrly-seo' ) . ' ' . esc_html( SQ_STABLE_VERSION ); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12 m-0 p-0 my-5">
                                        <form id="sq_reinstall_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row m-0 p-0 my-5">
                                                <div class="col-5 m-0 p-0 pr-2 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__( "Reinstall version", 'squirrly-seo' ) . ' ' . esc_attr( SQ_VERSION ); ?>
                                                        :
                                                    </div>
                                                    <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Reinstall the current version of the plugin.", 'squirrly-seo' ); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
													<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_reinstall', 'sq_nonce' ); ?>
                                                    <input type="hidden" name="action" value="sq_reinstall"/>
                                                    <button type="submit" class="btn rounded-0 btn-primary px-2 m-0" style="min-width: 250px"><?php echo esc_html__( "Reinstall Current Version", 'squirrly-seo' ); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

								<?php do_action( 'sq_backup_rollback_after' ); ?>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", 'squirrly-seo' ); ?>
                    </h5>
                    <ul class="mx-4">
                        <li class="text-left"><?php echo esc_html__( "Squirrly’s advanced import capabilities allows you to quickly and safely import SEO and Settings from a wide array of SEO plugins.", 'squirrly-seo' ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_backup_side_after' ); ?>

                </div>
            </div>
        </div>
    </div>
</div>
