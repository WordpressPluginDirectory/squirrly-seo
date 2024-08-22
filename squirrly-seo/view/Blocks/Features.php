<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Features Block view
 *
 * Called from All Features
 */
?>
<?php $features = $view->getFeatures(); ?>
<div id="features" class="sq_features my-2 py-2">
	<?php if ( SQ_Classes_Helpers_Tools::getValue( 'page' ) == 'sq_dashboard' ){ ?>
    <div class="row row-cols-1 row-cols-md-3 p-0 m-0" style="max-width: 1200px;">
		<?php
		foreach ( $features as $index => $feature ) {
			if ( ! $feature['mainfeature'] ) {
				continue;
			}
			?>
            <div class="col-3 p-0 pr-2 mb-3">
                <div class="sq_feature card h-100 p-0 bg-white shadow-0 rounded-0">
                    <div class="m-0 p-0">
                        <div class="mx-3 mt-4 p-0">

                            <div class="col-12 d-flex align-items-center m-0 p-0">
                                <div class="p-0 m-0">
                                    <a href="<?php echo esc_url( $feature['link'] ) ?>" style="text-decoration: none"><?php echo wp_kses_post( $feature['mainfeature'] ) ?></a>
                                </div>
                            </div>

                            <div class="col-12 d-flex align-items-center m-0 p-0 mt-2">
                                <h5 class="p-0 m-0 font-weight-bold">
									<?php echo wp_kses_post( $feature['title'] ) ?>
                                </h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

		<?php } ?>
		<?php } else { ?>

			<?php do_action( 'sq_features_before' ); ?>

            <div class="row text-left m-0 p-0" style="max-width: 550px;">
                <div class="col px-2 py-3">
                    <div class="col-12 m-0 p-0">
                        <h3><?php echo esc_html__( "Squirrly SEO Main Features", "squirrly-seo" ) ?></h3>
                        <div class="small text-dark"><?php echo esc_html__( "Manage the features & access them directly from here.", "squirrly-seo" ); ?></div>
                        <a href="https://www.squirrly.co/wordpress/plugins/seo/" class="small" target="_blank">
							<?php if ( SQ_Classes_Helpers_Tools::getIsset( 'sfeature' ) ) { ?>
								<?php echo esc_html__( "Do you want to search in the 650 features list?", "squirrly-seo" ) ?>
							<?php } else { ?>
								<?php echo esc_html__( "Do you want to see all 650 features list?", "squirrly-seo" ) ?>
							<?php } ?>
                        </a>
                    </div>
                    <div class="col-12 m-2 p-0">
                        <div class="row py-2">
                            <form method="get" class="d-flex flex-row flex-grow-1 justify-content-end m-0 p-0">
                                <input type="hidden" name="page" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'page', 'sq_features' ) ) ?>">
                                <label for="sfeature"></label>
                                <input id="sfeature" type="search" class="d-inline-block align-middle col m-0 p-3 rounded-0" autofocus name="sfeature" placeholder="<?php echo esc_attr__( "Enter a feature you want to search for", "squirrly-seo" ) ?>" value="<?php echo esc_attr( SQ_Classes_Helpers_Tools::getValue( 'sfeature' ) ) ?>"/>
								<?php if ( SQ_Classes_Helpers_Tools::getIsset( 'sfeature' ) ) { ?>
                                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( SQ_Classes_Helpers_Tools::getValue( 'page', 'sq_features' ) ) ) ?>" class="sq_search_close">X</a>
								<?php } ?>
                                <input type="submit" class="btn btn-primary m-0 px-4" value="<?php echo esc_attr__( "Search Feature", "squirrly-seo" ) ?> >"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 p-0 m-0" style="max-width: 1200px;">
				<?php
				$current_category = '';

				//Search in the features
				if ( SQ_Classes_Helpers_Tools::getIsset( 'sfeature' ) ) {
					foreach ( $features as $index => $feature ) {

						if ( isset( $feature['show'] ) && ! $feature['show'] ) {
							unset( $features[ $index ] );
							continue;
						}

						$features[ $index ]['relevant'] = 0;

						$sfeatures = SQ_Classes_Helpers_Tools::getValue( 'sfeature' );
						$sfeatures = explode( ' ', $sfeatures );
						if ( ! empty( $sfeatures ) ) {
							$found = 0;

							foreach ( $sfeatures as $sfeature ) {
								if ( $sfeature <> '' ) {
									if ( stripos( $feature['title'], $sfeature ) !== false ) {
										$found ++;
									}
									if ( stripos( $feature['description'], $sfeature ) !== false ) {
										$found ++;
									}
									if ( isset( $feature['keywords'] ) && $feature['keywords'] <> '' ) {
										if ( SQ_Classes_Helpers_Tools::findStr( $feature['keywords'], $sfeature ) !== false ) {
											$found ++;
										}
									}
								}
							}

							if ( ! $found ) {
								$features[ $index ]['show'] = false;
							} else {
								$features[ $index ]['relevant'] = $found;
							}

						}
					}

					usort( $features, function ( $a, $b ) {
						return ( $a['relevant'] > $b['relevant'] ) ? - 1 : 1;
					} );

				}

				foreach ( $features as $index => $feature ) {

					if ( isset( $feature['show'] ) && ! $feature['show'] ) {
						continue;
					}

					$class = 'auto';
					if ( $feature['active'] ) {
						$class = 'active';
					} else {
						$class = '';
					}
					?>

					<?php if ( $feature['category'] <> $current_category ) {
						if ( ! SQ_Classes_Helpers_Tools::getIsset( 'sfeature' ) ) {
							$current_category = $feature['category']; ?>
                            <div class="col-12 p-0 m-0 pt-5" data-id="<?php echo esc_attr( md5( $feature['category'] ) ) ?>">
                                <h5 class="font-weight-bold"><?php echo esc_html( $feature['category'] ) ?></h5></div>
						<?php } ?>
					<?php } ?>

                    <div class="col-3 p-0 pr-1 mb-3">
                        <div id="sq_feature_<?php echo (int) $index ?>" class="sq_feature card h-100 p-0 shadow-0 rounded-0 <?php echo esc_attr( $class ) ?>">
                            <div class="card-body m-0 p-0">
                                <div class="mx-3 mt-4 p-0">
                                    <div class="col p-0 mb-3 d-flex align-items-center">
                                        <i class="<?php echo esc_attr( $feature['logo'] ) ?>" style="line-height: 14px;"></i>
                                    </div>
                                    <div class="col-12 d-flex align-items-center m-0 p-0">
                                        <h5 class="p-0 m-0 font-weight-bold">
                                            <a href="<?php echo esc_url( $feature['link'] ) ?>" class="text-dark" style="text-decoration: none"><?php echo wp_kses_post( $feature['title'] ) ?></a>
											<?php if ( $feature['details'] ) { ?>
                                                <a href="<?php echo esc_url( $feature['details'] ) ?>" target="_blank">
                                                    <i class="fa-solid fa-question-circle m-0 pl-1" style="display: inline; font-size: 16px !important;"></i>
                                                </a>
											<?php } ?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="m-3 p-0 text-black" style="min-height: 80px; font-size: 16px;">
                                    <div class="pt-3 pb-1 small" style="color: #696868">
										<?php echo wp_kses_post( $feature['description'] ) ?>
										<?php if ( $feature['link'] ) { ?>
                                            <div class="col-12 p-0 pt-2">
												<?php if ( $feature['optional'] ) { ?>
                                                    <a href="<?php echo esc_url( $feature['link'] ) ?>" class="small see_feature" <?php echo( $feature['active'] ? '' : 'style="display:none;"' ) ?>>
														<?php echo esc_html__( "start feature setup", "squirrly-seo" ) ?>
                                                        >>
                                                    </a>
												<?php } else { ?>
                                                    <a href="<?php echo esc_url( $feature['link'] ) ?>" class="small see_feature">
														<?php echo esc_html__( "see feature", "squirrly-seo" ) ?> >>
                                                    </a>
												<?php } ?>
                                            </div>
										<?php } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-0 m-0 bg-white border-0">
                                <div class="row m-0 p-0">
                                    <div class="col-12 px-3 py-1 m-0 align-middle text-left" style="line-height: 30px">
										<?php if ( $feature['optional'] ) { ?>
                                            <div class="checker row m-0 p-0 px-1 sq_save_ajax">
                                                <div class="col-12 p-0 sq-switch sq-switch-xxs">
                                                    <input type="checkbox" id="activate_<?php echo (int) $index ?>" <?php echo( $feature['active'] ? 'checked="checked"' : '' ) ?> data-name="<?php echo esc_attr( $feature['option'] ) ?>" data-action="sq_ajax_seosettings_save" data-javascript="if($value){$this.closest('div.sq_feature').addClass('active');$('#sq_feature_<?php echo (int) $index ?>').find('.sq_feature_deactive').hide();$('#sq_feature_<?php echo (int) $index ?>').find('.sq_feature_active').show();$('#sq_feature_<?php echo (int) $index ?>').find('a.see_feature').show();}else{ $this.closest('div.sq_feature').removeClass('active');$('#sq_feature_<?php echo (int) $index ?>').find('.sq_feature_deactive').show();$('#sq_feature_<?php echo (int) $index ?>').find('.sq_feature_active').hide();$('#sq_feature_<?php echo (int) $index ?>').find('a.see_feature').hide();}" class="switch" value="1"/>
                                                    <label for="activate_<?php echo (int) $index ?>" class="m-0 font-weight-light"><span class="sq_feature_active" <?php echo( $feature['active'] ? '' : 'style="display:none"' ) ?>><?php echo esc_html__( "click to deactivate", "squirrly-seo" ) ?></span><span class="sq_feature_deactive" <?php echo( $feature['active'] ? 'style="display:none"' : '' ) ?>><?php echo esc_html__( "click to activate", "squirrly-seo" ) ?></span></label>
                                                </div>
                                            </div>
										<?php } else {
											if ( $feature['connection'] && ! SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) ) { ?>
                                                <div class="pt-1 m-0 align-middle text-left">
                                                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ) ) ?>" class="small text-black-50"><?php echo esc_html__( "connect to cloud", "squirrly-seo" ) ?></a>
                                                </div>
											<?php } elseif ( $feature['active'] ) { ?>
                                                <div class="pt-1 m-0 align-middle text-left">
                                                    <a href="<?php echo esc_url( $feature['link'] ) ?>" class="small text-primary"><?php echo esc_html__( "already active", "squirrly-seo" ) ?></a>
                                                </div>
											<?php } else { ?>
                                                <div class="pt-1 m-0 align-middle text-left">
                                                    <a href="<?php echo esc_url( $feature['link'] ) ?>" class="small"><?php echo esc_html__( "activate feature", "squirrly-seo" ) ?></a>
                                                </div>
											<?php } ?>
										<?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
				<?php } ?>
            </div>

			<?php do_action( 'sq_features_after' ); ?>

            <div class="col-12 p-0 m-0 pt-5 align-middle text-center">
                <h5>
                    <a href="https://www.squirrly.co/wordpress/plugins/seo/" target="_blank">
						<?php if ( SQ_Classes_Helpers_Tools::getIsset( 'sfeature' ) ) { ?>
							<?php echo esc_html__( "Do you want to search in the 650 features list?", "squirrly-seo" ) ?>
						<?php } else { ?>
							<?php echo esc_html__( "Do you want to see all 650 features list?", "squirrly-seo" ) ?>
						<?php } ?>
                    </a>
                </h5>
            </div>
		<?php } ?>
    </div>
