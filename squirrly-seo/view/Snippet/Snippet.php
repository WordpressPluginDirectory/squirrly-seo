<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Snippet Main view
 *
 * Called from Snippet Controller
 */
?>
<?php
if ( SQ_Classes_Helpers_Tools::getOption( 'sq_use' ) ) {
	if ( ! empty( $view->post ) && isset( $view->post->hash ) && $view->post->hash <> '' ) {

		//Clear the Title and Description for admin use only
		$view->post->sq->title = $view->post->sq->getClearedTitle();
		$view->post->sq->description = $view->post->sq->getClearedDescription();

		if ( $view->post->sq->og_media == '' ) {
			if ( $og = SQ_Classes_ObjController::getClass( 'SQ_Models_Services_OpenGraph' ) ) {
				$images = $og->getPostImages();

				if ( ! empty( $images ) ) {
					$image = current( $images );
					if ( isset( $image['src'] ) ) {
						if ( $view->post->sq->og_media == '' ) {
							$view->post->sq->og_media = $image['src'];
						}
					}
				} elseif ( SQ_Classes_Helpers_Tools::getOption( 'sq_og_image' ) ) {
					$view->post->sq->og_media = SQ_Classes_Helpers_Tools::getOption( 'sq_og_image' );
				}
			}
		}

		if ( $view->post->sq->tw_media == '' ) {
			if ( $tc = SQ_Classes_ObjController::getClass( 'SQ_Models_Services_TwitterCard' ) ) {
				$images = $tc->getPostImages();

				if ( ! empty( $images ) ) {
					$image = current( $images );
					if ( isset( $image['src'] ) ) {
						if ( $view->post->sq->tw_media == '' ) {
							$view->post->sq->tw_media = $image['src'];
						}
					}
				} elseif ( SQ_Classes_Helpers_Tools::getOption( 'sq_tc_image' ) ) {
					$view->post->sq->tw_media = SQ_Classes_Helpers_Tools::getOption( 'sq_tc_image' );
				}
			}
		}

		if ( $view->post->ID > 0 && function_exists( 'get_sample_permalink' ) ) {
			list( $permalink, $post_name ) = get_sample_permalink( $view->post->ID );
			if ( strpos( $permalink, '%postname%' ) !== false || strpos( $permalink, '%pagename%' ) !== false ) {
				$view->post->url = str_replace( array(
					'%pagename%',
					'%postname%'
				), esc_html( $post_name ), esc_html( urldecode( $permalink ) ) );
			}
		}

		?>
        <input type="hidden" name="sq_url" value="<?php echo esc_attr( $view->post->url ); ?>">
        <input type="hidden" name="sq_post_id" value="<?php echo (int) $view->post->ID; ?>">
        <input type="hidden" name="sq_post_type" value="<?php echo esc_attr( $view->post->post_type ); ?>">
        <input type="hidden" name="sq_term_id" value="<?php echo (int) $view->post->term_id; ?>">
        <input type="hidden" name="sq_taxonomy" value="<?php echo esc_attr( $view->post->taxonomy ); ?>">
        <input type="hidden" name="sq_hash" id="sq_hash" value="<?php echo esc_attr( $view->post->hash ); ?>">
        <input type="hidden" name="sq_keyword" id="sq_keyword" value="">

		<?php if ( SQ_Classes_Helpers_Tools::isAjax() ) {  //Run only is frontend admin and ajax call ?>
            <div id="snippet_<?php echo esc_attr( $view->post->hash ) ?>" class="sq_snippet_wrap sq-card sq-col-12 sq-p-0 sq-m-0 sq-border-0">

                <div class="sq-card-body sq-p-0">
                    <div class="sq-close sq-close-absolute sq-p-4">x</div>

                    <div class="sq-d-flex sq-flex-row sq-m-0">

                        <!-- ================= Tabs ==================== -->
                        <div class="sq_snippet_menu sq-d-flex sq-flex-column sq-bg-nav sq-mb-0 sq-border-right">
                            <ul class="sq-nav sq-nav-tabs sq-nav-tabs--vertical sq-nav-tabs--left">
                                <li class="sq-nav-item">
                                    <a href="#sqtab<?php echo esc_attr( $view->post->hash ) ?>1" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold" id="sq-nav-item_metas" data-category="metas" data-toggle="sqtab"><?php echo esc_html__( "Meta Tags", "squirrly-seo" ) ?></a>
                                </li>
                                <li class="sq-nav-item">
                                    <a href="#sqtab<?php echo esc_attr( $view->post->hash ) ?>2" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold" id="sq-nav-item_jsonld" data-category="jsonld" data-toggle="sqtab"><?php echo esc_html__( "Rich Snippets", "squirrly-seo" ) ?></a>
                                </li>
                                <li class="sq-nav-item">
                                    <a href="#sqtab<?php echo esc_attr( $view->post->hash ) ?>3" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold" id="sq-nav-item_opengraph" data-category="opengraph" data-toggle="sqtab"><?php echo esc_html__( "Open Graph", "squirrly-seo" ) ?></a>
                                </li>
                                <li class="sq-nav-item">
                                    <a href="#sqtab<?php echo esc_attr( $view->post->hash ) ?>4" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold" id="sq-nav-item_twittercard" data-category="twittercard" data-toggle="sqtab"><?php echo esc_html__( "Twitter Card", "squirrly-seo" ) ?></a>
                                </li>
                                <li class="sq-nav-item">
                                    <a href="#sqtab<?php echo esc_attr( $view->post->hash ) ?>6" class="sq-nav-item sq-nav-link sq-py-3 sq-text-dark sq-font-weight-bold" id="sq-nav-item_visibility" data-category="visibility" data-toggle="sqtab"><?php echo esc_html__( "Visibility", "squirrly-seo" ) ?></a>
                                </li>

								<?php do_action( 'sq_snippet_menu_after' ); ?>

                            </ul>
                        </div>
                        <!-- =================== Optimize ==================== -->

                        <div class="sq-tab-content sq-d-flex sq-flex-column sq-flex-grow-1 sq-bg-white sq-px-3">
                            <div id="sqtab<?php echo esc_attr( $view->post->hash ) ?>1" class="sq-tab-panel" role="tabpanel">
								<?php echo apply_filters( 'sq_snippet_metas', $view->get_view( 'Snippet/Metas' ), $view ); ?>
                            </div>
                            <div id="sqtab<?php echo esc_attr( $view->post->hash ) ?>2" class="sq-tab-panel" role="tabpanel">
								<?php echo apply_filters( 'sq_snippet_jsonld', $view->get_view( 'Snippet/Jsonld' ), $view ); ?>
                            </div>
                            <div id="sqtab<?php echo esc_attr( $view->post->hash ) ?>3" class="sq-tab-panel" role="tabpanel">
								<?php echo apply_filters( 'sq_snippet_facebook', $view->get_view( 'Snippet/Facebook' ), $view ); ?>
                            </div>
                            <div id="sqtab<?php echo esc_attr( $view->post->hash ) ?>4" class="sq-tab-panel" role="tabpanel">
								<?php echo apply_filters( 'sq_snippet_twitter', $view->get_view( 'Snippet/Twitter' ), $view ); ?>
                            </div>
                            <div id="sqtab<?php echo esc_attr( $view->post->hash ) ?>6" class="sq-tab-panel" role="tabpanel">
								<?php echo apply_filters( 'sq_snippet_visibility', $view->get_view( 'Snippet/Visibility' ), $view ); ?>
                            </div>

							<?php do_action( 'sq_snippet_content_after' ); ?>

                            <!-- ================ End Tabs ================= -->
                        </div>


                    </div>

                </div>
            </div>
			<?php
		} else { ?>

            <div class="sq_snippet_wrap sq-card sq-col-12 sq-p-0 sq-m-0 sq-border-0">
                <div class="sq-card-body sq-p-0">
                    <div class="sq-close sq-close-absolute sq-p-4">x</div>
                    <div class="sq-col-12 sq-m-4 sq-text-center sq-text-black-50">
						<?php echo esc_html__( "Loading Squirrly Snippet ...", "squirrly-seo" ) ?>
                    </div>
                </div>
            </div>

			<?php
		}
	} else { ?>

        <div class="sq_snippet_wrap sq-card sq-col-12 sq-p-0 sq-m-0 sq-border-0">
            <div class="sq-card-body sq-p-0">
                <div class="sq-close sq-close-absolute sq-p-4">x</div>
                <div class="sq-col-12 sq-m-4 sq-text-center sq-text-black-50">

                </div>
            </div>
        </div>

		<?php
	}
} else {
	?>
    <div class="sq_snippet_wrap sq-card sq-col-12 sq-p-0 sq-m-0 sq-border-0">
        <div class="sq-card-body sq-p-0">
            <div class="sq-close sq-close-absolute sq-p-4">x</div>
            <div class="sq-col-12 sq-m-4 sq-text-center sq-text-danger">
				<?php echo esc_html__( "Enable Squirrly SEO to load Squirrly Snippet", "squirrly-seo" ) ?>
            </div>
        </div>
    </div>
	<?php
}
?>
