<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_PostsList extends SQ_Classes_FrontController {

	/**
	 * @var array Post Type in
	 */
	private $_types = array();
	private $_taxonomies = array();

	/**
	 *
	 *
	 * @var integer Set the column index for Squirrly
	 */
	private $_pos = 5;

	/**
	 *
	 *
	 * @var string Set the column name for Squirrly
	 */
	private $_slacolumn_id = 'sq_slacolumn';
	private $_column_id = 'sq_column';

	/**
	 *
	 *
	 * @var array list of the posts to load the optimization for
	 */
	public $posts = array();


	/**
	 * Create the column and filter for the Posts List
	 */
	public function __construct() {

		parent::__construct();

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) {
			return;
		}

		if ( ! apply_filters( 'sq_load_sla', true ) || ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			return;
		}

		$this->_types      = get_post_types( array( 'public' => true ) );
		$this->_taxonomies = get_taxonomies( array( 'public' => true ) );

		SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->init();

		$this->_types[] = 'posts';
		$this->_types[] = 'pages';
		$this->_types[] = 'media';


		foreach ( $this->_types as $type ) {
			if ( SQ_Classes_ObjController::getClass( 'SQ_Models_Post' )->isSLAEnable( $type ) ) {
				add_filter( 'manage_' . $type . '_columns', array( $this, 'add_optimized_column' ), 10, 1 );
			}
			add_filter( 'manage_' . $type . '_columns', array( $this, 'add_visibility_column' ), 10, 1 );
			add_action( 'manage_' . $type . '_custom_column', array( $this, 'add_post_row' ), 10, 2 );
		}

		foreach ( $this->_taxonomies as $taxonomy ) {
			add_filter( 'manage_edit-' . $taxonomy . '_columns', array( $this, 'add_tax_visibility_column' ), 10, 1 );
			add_action( 'manage_' . $taxonomy . '_custom_column', array( $this, 'add_tax_row' ), 10, 3 );
		}

		//Update post status on API
		add_action( 'before_delete_post', array( $this->model, 'hookUpdateStatus' ), 10, 1 );

	}

	/**
	 * Hook the WordPress header only on postslist header table
	 */
	public function loadHead() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'postslist' );
	}

	/**
	 * Add the Squirrly Optimized column in the Post List
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_optimized_column( $columns ) {
		$this->loadHead(); //load the js only for post list

		$columns = $this->insert( $columns, array( $this->_slacolumn_id => esc_html__( "Optimized", 'squirrly-seo' ) ), $this->_pos );

		return $columns;
	}

	/**
	 * Add the Squirrly Visibility column in the Post List
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_visibility_column( $columns ) {
		$this->loadHead(); //load the js only for post list

		$columns = $this->insert( $columns, array( $this->_column_id => esc_html__( "Visibility", 'squirrly-seo' ) ), $this->_pos );

		return $columns;
	}

	/**
	 * Add row in Post list
	 *
	 * @param object $column
	 * @param integer $post_id
	 */
	public function add_post_row( $column, $post_id ) {
		if ( ! $post_type = get_post_type( $post_id ) ) {
			$post_type = 'post';
		}

		if ( ! SQ_Classes_Helpers_Tools::userCan( 'edit_post', $post_id ) ) {
			return;
		}

		if ( $column == $this->_slacolumn_id ) {
			$html = false;
			if ( SQ_Classes_Helpers_Tools::isAjax() ) {
				$args          = array();
				$args['posts'] = $post_id;

				if ( $json = SQ_Classes_RemoteController::getPostOptimization( $args ) ) {
					if ( ! is_wp_error( $json ) ) {
						$posts = $this->model->processPost( $json, $post_type );
						$html  = $posts[ $post_id ];
					}
				}
			} else {
				if ( get_post_status( $post_id ) == 'publish' ) {
					$this->posts[] = $post_id;
				}
			}

			echo '<div class="' . esc_attr( $this->_slacolumn_id ) . '_row" ref="' . esc_attr( $post_id ) . '">' . ( ( $html ) ? wp_kses_post( $html ) : 'loading ...' ) . '</div>';
		}

		if ( $column == $this->_column_id ) {
			echo '<div class="' . $this->_column_id . '_row" >' . $this->model->getPostSnippetInfo( $post_id, 0, '', $post_type ) . '</div>';
		}

	}

	/**
	 * Add the Squirrly column in the Post List
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_tax_visibility_column( $columns ) {
		$this->loadHead(); //load the js only for post list

		$columns = $this->insert( $columns, array( $this->_column_id => esc_html__( "Visibility", 'squirrly-seo' ) ), $this->_pos );

		return $columns;
	}

	/**
	 * Add row in Categories and Tags
	 *
	 * @param string $html
	 * @param string $column
	 * @param integer $post_id
	 */
	public function add_tax_row( $html = '', $column = '', $tax_id = 0 ) {
		if ( (int) $tax_id > 0 && $column <> '' ) {
			$term = get_term( $tax_id );

			if ( ! is_wp_error( $term ) && $column == $this->_column_id ) {
				echo '<div class="' . $this->_column_id . '_row">' . $this->model->getPostSnippetInfo( 0, $term->term_id, $term->taxonomy, '' ) . '</div>';
			}
		}

		return $html;
	}

	/**
	 * Push the array to a specific index
	 *
	 * @param array $src
	 * @param array $in
	 * @param integer $pos
	 *
	 * @return array
	 */
	public function insert( $src, $in, $pos ) {
		$array = array();
		if ( is_array( $src ) && ! empty( $src ) ) {
			if ( is_int( $pos ) ) {
				$array = array_merge( array_slice( $src, 0, $pos ), $in, array_slice( $src, $pos ) );
			} else {
				foreach ( $src as $k => $v ) {
					if ( $k == $pos ) {
						$array = array_merge( $array, $in );
					}
					$array[ $k ] = $v;
				}
			}
		}

		return $array;
	}

	/**
	 * Hook Get/Post action
	 *
	 * @return void
	 */
	public function action() {
		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {

			case 'inline-save':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					return;
				}

				if ( isset( $_POST['post_ID'] ) && ( $post_id = (int) $_POST['post_ID'] ) && isset( $_POST['_status'] ) && $_POST['_status'] == 'publish' ) {

					// Don't bother if it hasn't changed.
					$sq_hash  = md5( $post_id );
					$post     = SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->getSqPost( $sq_hash );
					$patterns = (array) SQ_Classes_Helpers_Tools::getOption( 'patterns' );
					if ( ! empty( $patterns ) && $permalink = get_permalink( $post->ID ) ) {

						if ( $post->ID > 0 && $permalink <> $post->url ) {

							//Get the Squirrly SEO Patterns
							foreach ( $patterns as $pattern => $type ) {
								if ( get_post_type( $post->ID ) == $pattern ) {
									if ( isset( $type['do_redirects'] ) && $type['do_redirects'] ) {

										//do_redirects
										$post_name = basename( $post->url );
										$old_slugs = (array) get_post_meta( $post->ID, '_sq_old_slug' );

										// If we haven't added this old slug before, add it now.
										if ( ! empty( $post_name ) && ! in_array( $post_name, $old_slugs ) ) {
											add_post_meta( $post->ID, '_sq_old_slug', $post_name );
										}

										// If the new slug was used previously, delete it from the list.
										if ( in_array( $post->post_name, $old_slugs ) ) {
											delete_post_meta( $post->ID, '_sq_old_slug', $post->post_name );
										}

										//Update the permalink in QSS
										SQ_Classes_ObjController::getClass( 'SQ_Models_Qss' )->savePermalink( $permalink, $sq_hash );

									}
								}
							}

						}
					}

				}

				return;

			case 'sq_ajax_postslist':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				$posts = SQ_Classes_Helpers_Tools::getValue( 'posts' );
				if ( is_array( $posts ) && ! empty( $posts ) ) {

					$post_type = SQ_Classes_Helpers_Tools::getValue( 'post_type', 'post' );

					$args          = array();
					$args['posts'] = join( ',', SQ_Classes_Helpers_Tools::getValue( 'posts', array() ) );

					if ( $json = SQ_Classes_RemoteController::getPostOptimization( $args ) ) {
						if ( is_wp_error( $json ) ) {
							$array = array();
							if ( $json->get_error_message() == 'no_data' ) {
								foreach ( $posts as $post_id ) {
									$array[ $post_id ] = esc_html__( "Network Error. Please Refresh.", 'squirrly-seo' );
								}
							} elseif ( $json->get_error_message() == 'maintenance' ) {
								foreach ( $posts as $post_id ) {
									$array[ $post_id ] = sprintf( esc_html__( "Maintenance. %sWe'll be back in a minute.", 'squirrly-seo' ), '<br />' );
								}
							}

							echo wp_json_encode( array( 'posts' => $array ) );
						} else {
							$posts = $this->model->processPost( $json, $post_type );
							echo wp_json_encode( array( 'posts' => $posts ) );
						}

						exit();
					}
				}

				echo wp_json_encode( array( 'posts' => array() ) );
				exit();
		}
	}

	/**
	 * Hook the Footer
	 */
	public function hookFooter() {
		$posts = '';
		foreach ( $this->posts as $post ) {
			$posts .= '"' . $post . '",';
		}

		if ( strlen( $posts ) > 0 ) {
			$posts = substr( $posts, 0, strlen( $posts ) - 1 );
		}

		echo '<script>
                var __sq_ranknotpublic_text = "' . esc_html__( "Not Public", 'squirrly-seo' ) . '";
                var __sq_couldnotprocess_text = "' . esc_html__( "Could not process", 'squirrly-seo' ) . '";
                var __sq_subscriptionexpired_text = "' . esc_html__( "The Squirrly subscription has expired!", 'squirrly-seo' ) . '";
                var sq_posts = new Array(' . $posts . ')
                </script>';

	}

}
