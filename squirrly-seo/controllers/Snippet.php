<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Snippet extends SQ_Classes_FrontController {

	/** @var SQ_Models_Domain_Post $post */
	public $post;

	public function __construct() {
		parent::__construct();

		add_action( 'admin_bar_menu', array( $this, 'hookTopmenuFrontend' ), 11 );

		if ( is_admin() ) {
			add_action( 'category_add_form_fields', array( $this, 'hookTermsPage' ), 10 );

			$taxonomies = get_taxonomies( array( 'public' => true ) );
			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy ) {
					if ( is_string( $taxonomy ) && $taxonomy <> '' ) {
						add_filter( $taxonomy . '_edit_form', array( $this, 'hookTermsPage' ), 10 );
					}
				}
			}
		}
	}

	/**
	 * Init Snippet and return the view for Admin Bar
	 *
	 * @return mixed
	 */
	public function init() {

		$handles = array();

		if ( is_rtl() ) {
			$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'sqbootstrap.rtl' );
			$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'rtl' );
		} else {
			$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'sqbootstrap' );
		}
		$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
		$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'highlight' );
		$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'patterns' );
		$handles[] = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'snippet' );

		wp_print_styles( $handles );
		wp_print_scripts( $handles );

		if ( is_admin() ) {
			global $post;

			//Set the current post in admin panel
			if ( isset( $post->ID ) && $post->ID > 0 ) {
				$this->post = SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->setPost( $post )->getPost();
			}
		}

		add_filter( 'sq_jsonld_types', function ( $jsonld_types, $post_type ) {
			if ( in_array( $post_type, array(
				'search',
				'category',
				'tag',
				'archive',
				'attachment',
				'404',
				'tax-post_tag',
				'tax-post_cat',
				'tax-product_tag',
				'tax-product_cat'
			) ) ) {
				$jsonld_types = array( 'website' );
			}
			if ( in_array( $post_type, array( 'home', 'shop' ) ) ) {
				$jsonld_types = array( 'website', 'local store', 'local restaurant' );
			}
			if ( $post_type == 'profile' ) {
				$jsonld_types = array( 'profile' );
			}
			if ( $post_type == 'product' ) {
				$jsonld_types = array( 'product', 'video' );
			}

			return $jsonld_types;
		}, 11, 2 );

		return $this->get_view( 'Snippet/Snippet' );
	}

	/**
	 * Hook the Head sequence in frontend when user is logged in
	 */
	public function hookFronthead() {
		if ( ! function_exists( 'is_user_logged_in' ) || ! is_user_logged_in() ) {
			return;
		}

		if ( SQ_Classes_Helpers_Tools::isAMPEndpoint() ) {
			return;
		}

		//If user set not to load Squirrly in frontend
		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_use_frontend' ) ) {
			return;
		}

		if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			//prevent some compatibility errors with other plugins
			remove_all_actions( 'print_media_templates' );

			//load media library
			@wp_enqueue_media();

			//Set the current post domain with all the data
			$this->post = SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->getPost();
		}
	}


	/**
	 * Set the post in SEO Snippet for Bulk SEO
	 *
	 * @param  $post
	 *
	 * @return $this
	 */
	public function setPost( $post ) {
		$this->post = $post;

		return $this;
	}

	/**
	 * Hook pages like Terms and Categories
	 */
	public function hookTermsPage() {
		echo $this->getSnippetDiv( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' )->init() );
	}

	/**
	 * Get the Snippet div for different pages
	 *
	 * @param  $content
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function getSnippetDiv( $content, $attributes = '' ) {

		if ( ! $content || ! apply_filters( 'sq_load_snippet', true ) || ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			return false;
		}

		return '<div id="sq_blocksnippet" ' . $attributes . ' class="sq_blocksnippet sq-shadow-sm sq-border-bottom sq-mb-4"><h2 class="hndle"><span class="sq_logo" style="margin-right: 5px;width: 30px !important;height: 30px !important;"></span>' . esc_html__( "Squirrly SEO Snippet", 'squirrly-seo' ) . '</span></h2><div class="inside">' . $content . '</div></div>';

	}

	/**
	 * Add a menu in Frontend Admin Bar
	 *
	 * @param $wp_admin_bar
	 *
	 * @return void
	 */
	public function hookTopmenuFrontend( $wp_admin_bar ) {
		global $wp_the_query;

		if ( is_admin() || ! function_exists( 'is_user_logged_in' ) || ! is_user_logged_in() ) {
			return;
		}

		if ( SQ_Classes_Helpers_Tools::isAMPEndpoint() ) {
			return;
		}

		//If user set not to load Squirrly in frontend
		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_use_frontend' ) ) {
			return;
		}

		if ( ! $wp_the_query || ! method_exists( $wp_the_query, 'get_queried_object' ) || ! function_exists( 'current_user_can' ) ) {
			return;
		}

		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			return;
		}
		$current_object = $wp_the_query->get_queried_object();

		if ( empty( $current_object ) ) {
			return;
		}

		if ( ! SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSnippetEnable( $current_object ) ) {
			return;
		}

		if ( ! empty( $current_object->post_type ) && ( $post_type_object = get_post_type_object( $current_object->post_type ) ) && SQ_Classes_Helpers_Tools::userCan( 'edit_post', $current_object->ID ) && $post_type_object->show_in_admin_bar && get_edit_post_link( $current_object->ID ) ) {
		} elseif ( ! empty( $current_object->taxonomy ) && ( get_taxonomy( $current_object->taxonomy ) ) && SQ_Classes_Helpers_Tools::userCan( 'edit_term', $current_object->term_id ) && get_edit_term_link( $current_object->term_id, $current_object->taxonomy ) ) {
		} else {
			return;
		}

		try {

			//Dev Kit
			$style = '';
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_devkit_logo' ) ) {
				$style = '<style>.sq_logo{background-image:url("' . SQ_Classes_Helpers_Tools::getOption( 'sq_devkit_logo' ) . '") !important;background-size: 100%; background-repeat: no-repeat; background-position: center;}</style>';
			}

			$wp_admin_bar->add_node( array(
					'id'     => 'sq_bar_menu',
					'title'  => $style . '<span class="sq_logo"></span> ' . esc_html__( "Custom SEO", 'squirrly-seo' ),
					'parent' => 'top-secondary',
				) );

			$wp_admin_bar->add_menu( array(
					'id'     => 'sq_bar_submenu',
					'parent' => 'sq_bar_menu',
					'meta'   => array(
						'html'     => $this->getSnippetDiv( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Snippet' )->init(), 'data-snippet="topmenu"' ),
						'tabindex' => PHP_INT_MAX,
					),
				) );
		} catch ( Exception $e ) {

		}

	}

	/**
	 * Called when Post action is triggered
	 *
	 * @return void
	 */
	public function action() {
		parent::action();

		$response = array();
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
			SQ_Classes_Helpers_Tools::setHeader( 'json' );
			echo wp_json_encode( $response );
			exit();
		}

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_saveseo':
				$sq_hash   = SQ_Classes_Helpers_Tools::getValue( 'sq_hash' );
				$post_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );
				$term_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'term_id', 0 );
				$taxonomy  = SQ_Classes_Helpers_Tools::getValue( 'taxonomy', '' );
				$post_type = SQ_Classes_Helpers_Tools::getValue( 'post_type', '' );

				//Save the SEO settings
				if ( $this->model->saveSEO( $post_id, $term_id, $taxonomy, $post_type ) ) {
					$json['saved'] = $sq_hash;
				} else {
					global $wpdb;
					$json['error'] = sprintf( esc_html__( "Could not save the snippet. Please check the database table %s integrity.", 'squirrly-seo' ), '<strong>' . $wpdb->prefix . _SQ_DB_ . '</strong>' );
				}

				if ( $this->post = $this->model->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {
					$json['html'] = $this->get_view( 'Snippet/Snippet' );
				}

				if ( SQ_Classes_Helpers_Tools::isAjax() ) {
					SQ_Classes_Helpers_Tools::setHeader( 'json' );

					echo wp_json_encode( $json );
					exit();
				}
				break;
			case 'sq_getsnippet':
				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				$json      = array();
				$post_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'post_id', 0 );
				$term_id   = (int) SQ_Classes_Helpers_Tools::getValue( 'term_id', 0 );
				$taxonomy  = SQ_Classes_Helpers_Tools::getValue( 'taxonomy', 'category' );
				$post_type = SQ_Classes_Helpers_Tools::getValue( 'post_type', 'post' );

				if ( $this->post = $this->model->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {
					$json['html'] = $this->get_view( 'Snippet/Snippet' );

					//Support for international languages
					if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
						if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
							$json['html'] = iconv( 'UTF-8', 'UTF-8//IGNORE', $json['html'] );
						}
					}

					if ( SQ_Classes_Error::isError() ) {
						$json['error'] = SQ_Classes_Error::getError();
					}

				} else {
					$json['error'] = esc_html__( 'Not Page found!', 'squirrly-seo' );
				}

				echo wp_json_encode( $json );
				exit();

		}
	}


}
