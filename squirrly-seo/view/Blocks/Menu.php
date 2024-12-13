<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Left Menu Block view
 *
 */
?>
<?php
$menu_opened = ! isset( $_COOKIE['sq_menu'] ) || $_COOKIE['sq_menu'] == 'open';
if ( SQ_Classes_Helpers_Tools::getValue( 'page' ) == 'sq_dashboard' ) { ?>
    <div class="sq_col_menu bg-primary <?php echo esc_attr( $menu_opened ? 'sq_col_menu_big' : '' ) ?>">
        <div class="sq_nav d-flex flex-column bd-highlight mb-3 sq_sticky">
			<?php
			$mainmenu = SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getMainMenu();

			if ( ! empty( $mainmenu ) ) {
				foreach ( $mainmenu as $menuid => $item ) {

					//Check if the menu item is visible on the top
					if ( isset( $item['leftmenu'] ) && ! $item['leftmenu'] ) {
						continue;
					}

					$url = ( $item['href'] ?: SQ_Classes_Helpers_Tools::getAdminUrl( $menuid ) );

					$bgclass   = 'bg-primary';
					$fontclass = 'text-white';
					if ( $menuid == SQ_Classes_Helpers_Tools::getValue( 'page' ) ) {
						$bgclass   = 'bg-white';
						$fontclass = 'text-dark';
					}

					?>
                    <a href="<?php echo esc_url( $url ); ?>" class="m-0 p-3 font-dark align-middle <?php echo esc_attr( $bgclass ) ?> sq_nav_item" data-tab="level"><i class="<?php echo esc_attr( $item['icon'] ) ?> <?php echo esc_attr( $fontclass ) ?> m-0 p-0 text-center"></i><span class="sq_nav_item_text <?php echo esc_attr( $bgclass ) ?> <?php echo esc_attr( $fontclass ) ?> ml-2"><?php echo wp_kses_post( $item['title'] ) ?></span></a>
					<?php
				}
			}
			?>
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_open">
                <i class="dashicons-before dashicons-arrow-right-alt text-white"></i>
            </div>
            <div class="m-0 p-3 font-dark sq_nav_item sq_nav_item_collapse">
                <i class="dashicons-before dashicons-arrow-left-alt text-white"></i><span class="sq_nav_item_text text-white ml-2"><?php echo esc_html__( 'Collapse', "squirrly-seo" ) ?></span>
            </div>

        </div>
        <script>
            (function ($) {
                $('.sq_nav_item_open').on('click', function () {
                    $('.sq_col_menu').addClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'open');
                });
                $('.sq_nav_item_collapse').on('click', function () {
                    $('.sq_col_menu').removeClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'collapse');
                });
            })(jQuery);
        </script>
    </div>
<?php } elseif ( SQ_Classes_Helpers_Tools::getValue( 'tab' ) == 'audit' || SQ_Classes_Helpers_Tools::getValue( 'tab' ) == 'compare' ) { ?>
    <div class="sq_col_menu sq_sticky pt-3 <?php echo esc_attr( $menu_opened ? 'sq_col_menu_big' : '' ) ?>">
        <div class="sq_nav d-flex flex-column bd-highlight mb-3 sq_sticky">
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_home">
                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits' ) ); ?>" class="text-dark"><i class="dashicons-before dashicons-chart-bar text-dark"></i><span class="sq_nav_item_text text-dark bg-white  ml-2"><?php echo esc_html__( 'Back To Audit', "squirrly-seo" ) ?></span></a>
            </div>
			<?php
			$tabs = SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getTabs( 'sq_audit' );

			if ( ! empty( $tabs ) ) {
				$current = SQ_Classes_Helpers_Tools::getValue( 'tab', SQ_Classes_Helpers_Tools::arrayKeyFirst( $tabs ) );

				foreach ( $tabs as $menuid => $item ) {
					if ( ! SQ_Classes_Helpers_Tools::userCan( $item['capability'] ) ) {
						continue;
					}

					$class = 'bg-white';
					if ( $current == $menuid || $current == substr( $menuid, strpos( $menuid, '/' ) + 1 ) ) {
						$class = 'bg-light';
					}

					?>
                    <a href="javascript:void(0);" class="m-0 p-3 text-dark align-middle sq_nav_item <?php echo esc_attr( $menuid ) ?> <?php echo esc_attr( $class ) ?>" data-id="<?php echo esc_attr( $menuid ) ?>"><i class="<?php echo esc_attr( $item['icon'] ) ?> text-dark"></i><span class="sq_nav_item_text text-dark bg-white ml-2 <?php echo esc_attr( $menuid ) ?>"><?php echo wp_kses_post( $item['title'] ) ?></span></a>
					<?php
				}
			}
			?>
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_open">
                <i class="dashicons-before dashicons-arrow-right-alt text-dark"></i>
            </div>
            <div class="m-0 p-3 font-dark sq_nav_item sq_nav_item_collapse">
                <i class="dashicons-before dashicons-arrow-left-alt text-dark"></i><span class="sq_nav_item_text text-dark ml-2"><?php echo esc_html__( 'Collapse', "squirrly-seo" ) ?></span>
            </div>

        </div>
        <script>
            (function ($) {
                $('.sq_nav_item_open').on('click', function () {
                    $('.sq_col_menu').addClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'open');
                });
                $('.sq_nav_item_collapse').on('click', function () {
                    $('.sq_col_menu').removeClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'collapse');
                });
            })(jQuery);
        </script>
    </div>
<?php } elseif ( SQ_Classes_Helpers_Tools::getValue( 'page' ) == 'sq_features' && ! SQ_Classes_Helpers_Tools::getIsset( 'sfeature' ) ) { ?>
    <div class="sq_col_menu sq_sticky pt-3 <?php echo esc_attr( $menu_opened ? 'sq_col_menu_big' : '' ) ?>">
        <div class="sq_nav d-flex flex-column bd-highlight mb-3 sq_sticky">
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_home">
                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ) ); ?>" class="text-dark"><i class="fa-solid fa-house text-dark"></i><span class="sq_nav_item_text text-dark bg-white ml-2"><?php echo esc_html__( 'Back To Home', "squirrly-seo" ) ?></span></a>
            </div>
			<?php
			$allcategories = SQ_Classes_ObjController::getClass( 'SQ_Core_BlockFeatures' )->getCategories();
			$features      = SQ_Classes_ObjController::getClass( 'SQ_Core_BlockFeatures' )->getFeatures();
			$categories    = array();

			if ( ! empty( $features ) ) {
				foreach ( $features as $feature ) {

					if ( isset( $feature['show'] ) && ! $feature['show'] ) {
						continue;
					}

					if ( $feature['category'] <> '' ) {
						$categories[] = $feature['category'];
					}
				}

				if ( ! empty( $categories ) ) {
					$categories = array_unique( $categories );
				}

				foreach ( $categories as $item ) {

					?>
                    <a href="javascript:void(0);" class="m-0 p-3 text-dark align-middle sq_nav_item" data-id="<?php echo esc_attr( md5( $item ) ) ?>"><i class="<?php echo( isset( $allcategories[ $item ] ) ? esc_attr( $allcategories[ $item ] ) : '' ) ?> text-dark"> </i><span class="sq_nav_item_text text-dark bg-white ml-2 <?php echo esc_attr( md5( $item ) ) ?>"><?php echo wp_kses_post( $item ) ?></span></a>
					<?php
				}
			}
			?>
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_open">
                <i class="dashicons-before dashicons-arrow-right-alt text-dark"></i>
            </div>
            <div class="m-0 p-3 font-dark sq_nav_item sq_nav_item_collapse">
                <i class="dashicons-before dashicons-arrow-left-alt text-dark"></i><span class="sq_nav_item_text text-dark ml-2"><?php echo esc_html__( 'Collapse', "squirrly-seo" ) ?></span>
            </div>

        </div>
        <script>
            (function ($) {
                $('.sq_nav_item_open').on('click', function () {
                    $('.sq_col_menu').addClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'open');
                });
                $('.sq_nav_item_collapse').on('click', function () {
                    $('.sq_col_menu').removeClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'collapse');
                });
                $('.sq_nav_item').on('click', function () {
                    $('html,body').animate({scrollTop: $('div[data-id=' + $(this).data('id') + ']').offset().top});
                });
            })(jQuery);
        </script>
    </div>
<?php } else { ?>
    <div class="sq_col_menu <?php echo esc_attr( $menu_opened ? 'sq_col_menu_big' : '' ) ?>">
        <div class="sq_nav d-flex flex-column bd-highlight mb-3 sq_sticky">
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_home">
                <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' ) ); ?>" class="text-dark"><i class="fa-solid fa-house text-dark"></i><span class="sq_nav_item_text text-dark bg-white ml-2"><?php echo esc_html__( 'Back To Home', "squirrly-seo" ) ?></span></a>
            </div>
			<?php
			$tabs = SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->getTabs( SQ_Classes_Helpers_Tools::getValue( 'page' ) );

			if ( ! empty( $tabs ) ) {
				$current = SQ_Classes_Helpers_Tools::getValue( 'tab', SQ_Classes_Helpers_Tools::arrayKeyFirst( $tabs ) );

				foreach ( $tabs as $menuid => $item ) {

					if ( isset( $item['show'] ) && ! $item['show'] ) {
						continue;
					}

					if ( ! SQ_Classes_Helpers_Tools::userCan( $item['capability'] ) ) {
						continue;
					}

					$class = 'bg-white';
					if ( $current == $menuid || $current == substr( $menuid, strpos( $menuid, '/' ) + 1 ) ) {
						$class = 'bg-light';
					}

					$tab = '';
					if ( '' === $menuid || false !== strpos( $menuid, '/' ) ) {
						list( $menuid, $tab ) = explode( '/', $menuid );
					}

					?>
                    <a href="<?php echo esc_url( SQ_Classes_Helpers_Tools::getAdminUrl( $menuid, $tab ) ); ?>" class="m-0 p-3 text-dark align-middle sq_nav_item <?php echo esc_attr( $class ) ?>" data-tab="level"><i class="<?php echo esc_attr( $item['icon'] ) ?> text-dark"></i><span class="sq_nav_item_text text-dark ml-2 <?php echo esc_attr( $class ) ?>"><?php echo wp_kses_post( $item['title'] ) ?></span></a>
					<?php
				}
			}
			?>
            <div class="m-0 p-3 font-dark sq_nav_item bg-default sq_nav_item_open">
                <i class="dashicons-before dashicons-arrow-right-alt text-dark"></i>
            </div>
            <div class="m-0 p-3 font-dark sq_nav_item sq_nav_item_collapse">
                <i class="dashicons-before dashicons-arrow-left-alt text-dark"></i><span class="sq_nav_item_text text-dark ml-2"><?php echo esc_html__( 'Collapse', "squirrly-seo" ) ?></span>
            </div>
        </div>
        <script>
            (function ($) {
                $('.sq_nav_item_open').on('click', function () {
                    $('.sq_col_menu').addClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'open');
                });
                $('.sq_nav_item_collapse').on('click', function () {
                    $('.sq_col_menu').removeClass('sq_col_menu_big');
                    $.sq_setCookie('sq_menu', 'collapse');
                });
            })(jQuery);
        </script>
    </div>
<?php } ?>
