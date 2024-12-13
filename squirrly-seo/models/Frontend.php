<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Frontend {

	/** @var SQ_Models_Domain_Post  Set the current post domain */
	private $_post;

	/** @var array Set the headers by services */
	private $_header = array();

	public function __construct() {
		//Get post from WordPress
		add_filter( 'sq_post', array( $this, 'getWpPost' ), 11, 1 );
		//Get post details
		add_filter( 'sq_post', array( $this, 'getPostDetails' ), 12, 1 );
		//add page in URL if post is pages
		add_filter( 'sq_post', array( $this, 'addPaged' ), 12, 1 );
		add_filter( 'sq_post', array( $this, 'addSearch' ), 12, 1 );

		//Call the pattern class to replace the patterns for current post
		add_filter( 'sq_post', array(
			SQ_Classes_ObjController::getClass( 'SQ_Controllers_Patterns' ),
			'replacePatterns'
		), 13, 1 );

		//change the buffer
		add_filter( 'sq_buffer', array( $this, 'setMetaInBuffer' ), 10, 1 );
		//pack html prefix if needed
		add_filter( 'sq_html_prefix', array( $this, 'packPrefix' ), 99 );
	}

	public function setStart() {
		return "\n\n<!-- SEO by Squirrly SEO " . esc_attr( SQ_VERSION ) . " - https://plugin.squirrly.co/ -->\n";

	}

	/**
	 * End the signature
	 *
	 * @return string
	 */
	public function setEnd() {
		return "<!-- /SEO by Squirrly SEO - WordPress SEO Plugin -->\n\n";

	}

	/**
	 * Start the buffer record
	 *
	 * @return void
	 */
	public function startBuffer() {
		ob_start( array( $this, 'getBuffer' ) );
	}

	/**
	 * Get the loaded buffer and change it
	 *
	 * @param string $buffer
	 *
	 * @return string
	 */
	public function getBuffer( $buffer ) {
		if ( $this->runSEOForThisPage() ) {
			if ( ! $buffer && ob_get_contents() ) {
				$buffer = ob_get_contents();
			}

			$buffer = apply_filters( 'sq_buffer', $buffer );
		}

		return $buffer;
	}


	/**
	 * Change the title, description and keywords in site's buffer
	 *
	 * @param string $buffer
	 *
	 * @return string
	 */
	public function setMetaInBuffer( $buffer ) {

		//if is enabled sq for this page
		if ( $header = $this->getHeader() ) {

			try {
				//clear the existing tags to avoid duplicates
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ) {
					if ( isset( $header['sq_title'] ) && $header['sq_title'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ) {
						$buffer = preg_replace( '/<title[^<>]*>([^<>]*)<\/title>/si', '', $buffer, - 1 );
					}
					if ( isset( $header['sq_description'] ) && $header['sq_description'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ) {
						$buffer = preg_replace( '/<meta[^>]*(name|property)=["\']description["\'][^>]*content=["\'][^"\'>]*["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
					}
					if ( isset( $header['sq_keywords'] ) && $header['sq_keywords'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_keywords' ) ) {
						$buffer = preg_replace( '/<meta[^>]*(name|property)=["\']keywords["\'][^>]*content=["\'][^"\'>]*["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
					}
					if ( isset( $header['sq_canonical'] ) && $header['sq_canonical'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_canonical' ) ) {
						$buffer = preg_replace( '/<link[^>]*rel=["\']canonical["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
						$buffer = preg_replace( '/<link[^>]*rel=["\'](prev|next)["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
					}
					if ( isset( $header['sq_noindex'] ) && $header['sq_noindex'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) {
						$buffer = preg_replace( '/<meta[^>]*name=["\']robots["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
					}
				}

				if ( isset( $header['sq_sitemap'] ) && $header['sq_sitemap'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ) {
					$buffer = preg_replace( '/<link[^>]*rel=["\']alternate["\'][^>]*type="application\/rss+xml"[^>]*>[\n\r]*/si', '', $buffer, - 1 );
				}

				if ( isset( $header['sq_open_graph'] ) && $header['sq_open_graph'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) ) {
					$buffer = preg_replace( '/<meta[^>]*(name|property)=["\'](og:|article:)[^"\'>]+["\'][^>]*content=["\'][^"\'>]+["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
				}
				if ( isset( $header['sq_twitter_card'] ) && $header['sq_twitter_card'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
					$buffer = preg_replace( '/<meta[^>]*(name|property)=["\'](twitter:)[^"\'>]+["\'][^>]*content=["\'][^"\'>]+["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
				}
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_clearcode' ) ) {
					if ( isset( $header['sq_json_ld'] ) && $header['sq_json_ld'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ) ) {
						$buffer = preg_replace( '/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>[^>]*<\/script>[\n\r]*/si', '', $buffer, - 1 );
					}
				}
				if ( isset( $header['sq_favicon'] ) && $header['sq_favicon'] <> '' && SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ) ) {
					$buffer = preg_replace( '/<link[^>]*rel=["\']shortcut icon["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
					$buffer = preg_replace( '/<link[^>]*rel=["\']icon["\'][^>]*>[\n\r]*/si', '', $buffer, - 1 );
				}
				$buffer = preg_replace( '/(<html(\s[^>]*|))/si', sprintf( "$1%s", apply_filters( 'sq_html_prefix', false ) ), $buffer, 1 );

				$header_str = implode( "\n", $header );
				$header_str = str_replace( '$', '\$', (string) $header_str );

				if ( ! SQ_DEBUG && SQ_Classes_Helpers_Tools::getOption( 'sq_minify' ) ) { //minify on cache
					$header_str = str_replace( "\n", "", $header_str );
					$header_str = preg_replace( '/<!--(.*)-->/Uis', '', $header_str );
				}

				//load squirrly metas last or first
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_laterload' ) || SQ_Classes_Helpers_Tools::isAMPEndpoint() ) {
					$buffer = preg_replace( '/(<\/head>)/si', $header_str . "\n" . "$1", $buffer, 1 );
				} else {

					//////////////////set the charset first
					preg_match( '/<meta [^>]*charset=["\'][^"\']+["\'][^>]*>/si', $buffer, $matches );
					if ( ! empty( $matches ) && isset( $matches[0] ) ) {
						$buffer     = preg_replace( '/<meta [^>]*charset=["\'][^"\']+["\'][^>]*>/si', '', $buffer, - 1 );
						$header_str = $matches[0] . "\n" . $header_str;
					}
					///////////////////////////

					$buffer = preg_replace( '/(<head(\s[^>]*|)>)/si', "$1" . "\n" . $header_str . "\n", $buffer, 1 );

				}

				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_links' ) ) {
					if ( SQ_Classes_Helpers_Tools::getOption( 'sq_external_nofollow' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_external_blank' ) ) {
						$buffer = $this->fixSEOLinks( $buffer );
					}
				}

				unset( $header );
				unset( $header_str );
			} catch ( Exception $e ) {
			}
		}

		return $buffer;
	}

	/**
	 * Overwrite the header with the correct parameters
	 *
	 * @return array | false
	 */
	public function getHeader() {
		if ( empty( $this->_header ) ) {

			$this->_header['sq_beforemeta'] = apply_filters( 'sq_beforemeta', false ); //

			$this->_header['sq_title'] = apply_filters( 'sq_title', false );

			//Get all header in array
			$this->_header['sq_start'] = $this->setStart();

			$this->_header['sq_noindex'] = apply_filters( 'sq_noindex', false ); //
			//Add description in homepage if is set or add description in other pages if is not home page
			$this->_header['sq_description'] = apply_filters( 'sq_description', false ); //
			$this->_header['sq_keywords']    = apply_filters( 'sq_keywords', false ); //

			$this->_header['sq_canonical'] = apply_filters( 'sq_canonical', false ); //
			$this->_header['sq_prevnext']  = apply_filters( 'sq_prevnext', false ); //

			$this->_header['sq_sitemap']     = apply_filters( 'sq_sitemap', false );
			$this->_header['sq_favicon']     = apply_filters( 'sq_favicon', false );
			$this->_header['sq_language']    = apply_filters( 'sq_language', false );
			$this->_header['sq_dublin_core'] = apply_filters( 'sq_dublin_core', false );

			$this->_header['sq_open_graph']   = apply_filters( 'sq_open_graph', false ); //
			$this->_header['sq_publisher']    = apply_filters( 'sq_publisher', false ); //
			$this->_header['sq_twitter_card'] = apply_filters( 'sq_twitter_card', false ); //

			/* SEO optimizer tool */
			$this->_header['sq_verify']           = apply_filters( 'sq_verify', false ); //
			$this->_header['sq_google_analytics'] = apply_filters( 'sq_google_analytics', false ); //
			$this->_header['sq_facebook_pixel']   = apply_filters( 'sq_facebook_pixel', false ); //

			/* Structured Data */

			$this->_header['sq_json_ld'] = apply_filters( 'sq_json_ld', false );
			$this->_header['sq_end']     = $this->setEnd();

			$this->_header['sq_aftermeta'] = apply_filters( 'sq_aftermeta', false );

			//flush the header
			if ( count( $this->_header ) ) {
				$this->_header = array_filter( $this->_header );
			}

			if ( count( $this->_header ) == 2 ) {
				return false;
			}
		}

		return $this->_header;
	}

	/**
	 * Show analytics in footer
	 */
	public function getFooter() {

		$footer = array();

		if ( $this->_post && isset( $this->_post->sq->doseo ) && $this->_post->sq->doseo ) {
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Analytics' );
				$footer['sq_google_analytics'] = apply_filters( 'sq_google_analytics_amp', false );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pixels' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Pixel' );
				$footer['sq_facebook_pixel'] = apply_filters( 'sq_facebook_pixel_amp', false );
			}
		}

		if ( count( $footer ) > 0 ) {
			$footer = array_filter( $footer );
		}

		if ( count( $footer ) > 0 ) {
			return join( "\n", $footer );
		}

		return false;
	}
	/**************************************************************************************************/

	/**
	 * Load all SEO classes
	 */
	public function loadSeoLibrary() {

		if ( $this->_post && isset( $this->_post->sq->doseo ) && $this->_post->sq->doseo ) {

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_redirects' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Redirects' );
			}

			//load all services
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_CustomMetas' );

				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Title' );
				}
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_description' ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Description' );
				}
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_keywords' ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Keywords' );
				}
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_canonical' ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Canonical' );
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_PrevNext' );
				}
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_noindex' ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Noindex' );
				}
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_dublincore' ) ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Services_DublinCore' );
				}
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Favicon' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Sitemap' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_OpenGraph' );
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Publisher' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_TwitterCard' );
			}

			//SQ_Models_Services_Favicon
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_webmasters' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Verify' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Analytics' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pixels' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Pixel' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_JsonLD' );
			}

			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_innelinks' ) ) {
				SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Innerlinks' );
			}

		}
	}

	/**
	 * Set the post for the frontend
	 *
	 * @param WP_Post $curpost
	 *
	 * @return SQ_Models_Frontend
	 */
	public function setPost( $curpost = null ) {
		//Load the post with all the filters applied
		$this->_post = apply_filters( 'sq_post', $curpost );

		//Load the SEO Library before calling the filters
		if ( $this->runSEOForThisPage() ) {
			$this->loadSeoLibrary();
		}

		return $this;
	}

	/**
	 * Return the post
	 *
	 * @return SQ_Models_Domain_Post|false
	 */
	public function getPost() {
		return $this->_post;
	}

	/**
	 * Get the current post from WordPress
	 *
	 * @param integer $current_post
	 *
	 * @return WP_Post
	 */
	public function getWpPost( $current_post ) {
		global $post, $wp;

		//If the post is not a WP Post instance and not a SQ Post instance
		//Get the current instace from frontend data
		if ( ! $current_post instanceof WP_Post && ! $current_post instanceof SQ_Models_Domain_Post ) {
			if ( function_exists( 'is_shop' ) && is_shop() && function_exists( 'wc_get_page_id' ) ) {
				$current_post = get_post( wc_get_page_id( 'shop' ) );
			} elseif ( ( is_single() || is_singular() ) && isset( $post->ID ) ) {
				$current_post = get_post( $post->ID );
			}
		}

		$current_post = apply_filters( 'sq_current_post', $current_post );
		//If the current post is not set but there is a request in database
		//Set the current post as home page
		if ( empty( $current_post ) && isset( $wp->request ) ) {
			$current_url = home_url( $wp->request );

			if ( get_option( 'page_for_posts' ) > 0 ) {
				$posts_url = get_permalink( get_option( 'page_for_posts' ) );

				if ( is_paged() && $posts_url <> '' ) {
					$page = (int) get_query_var( 'paged' );
					if ( $page && $page > 1 ) {
						$posts_url = trailingslashit( $posts_url ) . "page/" . "$page/";
					}
				}

				if ( rtrim( $posts_url, '/' ) == rtrim( $current_url, '/' ) ) {
					$current_post = get_post( get_option( 'page_for_posts' ) );
				}

			} elseif ( get_option( 'page_on_front' ) > 0 ) {

				$posts_url = get_permalink( get_option( 'page_on_front' ) );
				if ( rtrim( $posts_url, '/' ) == rtrim( $current_url, '/' ) ) {
					$current_post = get_post( get_option( 'page_on_front' ) );
				}
			}

		}

		return $current_post;
	}

	/**
	 * Build the current post with all the data required
	 *
	 * @param WP_Post $post
	 *
	 * @return SQ_Models_Domain_Post | false
	 */
	public function getPostDetails( $post ) {
		if ( $post instanceof WP_Post ) {

			/** @var SQ_Models_Domain_Post $post */
			$post = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Post', $post );

			if ( $post->ID > 0 && $post->post_type <> '' ) {
				//If it's front page
				if ( $post->ID == get_option( 'page_on_front' ) ) {
					$post->post_type = 'home';
					$post->hash      = md5( $post->ID );
					$post->url       = home_url();

					return $post;
				} elseif ( $post->ID == get_option( 'page_for_posts' ) ) { //If it's front post
					$post->hash = md5( $post->ID );
					$post->url  = get_permalink( $post->ID ); //get the blog post permalink

					return $post;
				}

				//If it's a product
				if ( $post->post_type == 'product' ) {
					$post->hash = md5( $post->ID );
					$post->url  = get_permalink( $post->ID );
					$cat        = get_the_terms( $post->ID, 'product_cat' );
					if ( ! empty( $cat ) && ! is_wp_error( $cat ) && count( (array) $cat ) > 0 ) {
						$post->category = $cat[0]->name;
						if ( isset( $cat[0]->description ) ) {
							$post->category_description = $cat[0]->description;
						}
					}

					return $post;
				}

				//If it's a shop
				if ( $post->post_type == 'page' && function_exists( 'wc_get_page_id' ) && $post->ID == wc_get_page_id( 'shop' ) ) {
					$post->post_type = 'shop';
					$post->hash      = md5( $post->ID );
					$post->url       = get_permalink( $post->ID );

					return $post;
				}

				if ( in_array( $post->post_type, array( 'post', 'page', 'product', 'cartflows_step' ), true ) ) {
					$post->hash = md5( $post->ID );
					$post->url  = get_permalink( $post->ID );

					return $post;
				}

				if ( $post->post_type == 'attachment' ) {
					$post->hash = md5( $post->ID );
					$post->url  = get_permalink( $post->ID );

					return $post;
				}

				if ( $this->checkCutomPostType( $post->post_type ) ) {
					$post->hash = md5( $post->post_type . $post->ID );
					$post->url  = get_permalink( $post->ID );

					return $post;
				}

			}

			if ( $this->checkCutomPostType( $post->post_type ) ) {
				if ( $post->post_name <> '' ) {
					$post->hash = md5( $post->post_type . $post->post_name );
				} else {
					$post->hash = md5( $post->post_type );
				}

				$post->url = get_post_type_archive_link( $post->post_type );

				return $post;
			}
		} else {
			if ( $post instanceof SQ_Models_Domain_Post ) {
				return $post;
			}

			/**
			 * @var SQ_Models_Domain_Post $post
			 */
			$post = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Post', $post );
		}

		//Check if Home Page
		if ( $this->isHomePage() ) {
			$post->post_type    = 'home';
			$post->hash         = md5( 'wp_homepage' );
			$post->post_title   = get_bloginfo( 'name' );
			$post->post_excerpt = get_bloginfo( 'description' );
			$post->url          = home_url();

			return $post;
		}


		//Check if Tag
		if ( is_tag() ) {
			$tag = $this->getTagDetails( $post );

			$post->post_type = 'tag';
			if ( isset( $tag->term_id ) ) {
				$post->post_title = $tag->name;
				$post->url        = get_tag_link( $tag->term_id );
				$post->hash       = md5( $post->post_type . $tag->term_id );
				//
				$post->term_id          = $tag->term_id;
				$post->term_taxonomy_id = $tag->term_taxonomy_id;
				$post->taxonomy         = $tag->taxonomy;
			}

			return $post;
		}

		//Check if Category
		if ( is_category() ) {
			$category        = $this->getCategoryDetails( $post );
			$post->post_type = 'category';
			if ( isset( $category->term_id ) ) {

				$post->hash = md5( $post->post_type . $category->term_id );
				$post->guid = $category->slug;
				if ( ! is_wp_error( get_term_link( $category->term_id ) ) ) {
					$post->url = get_term_link( $category->term_id );
				}
				$post->post_title           = $category->cat_name;
				$post->category             = $category->cat_name;
				$post->post_excerpt         = $category->description;
				$post->category_description = $category->description;
				//
				$post->term_id          = $category->term_id;
				$post->term_taxonomy_id = $category->term_taxonomy_id;
				$post->taxonomy         = 'category';
			}

			return $post;
		}

		//Check if Tax
		if ( is_tax() ) {
			if ( $tax = $this->getTaxonomyDetails( $post ) ) {
				if ( isset( $tax->taxonomy ) && $tax->taxonomy <> '' ) {
					$post->post_type = 'tax-' . $tax->taxonomy;
					if ( isset( $tax->term_id ) ) {
						$post->hash = md5( $post->post_type . $tax->term_id );
						if ( ! is_wp_error( get_term_link( $tax->term_id, $tax->taxonomy ) ) ) {
							$post->url = get_term_link( $tax->term_id, $tax->taxonomy );
						}
						$post->post_title   = ( ( isset( $tax->name ) ) ? $tax->name : '' );
						$post->post_excerpt = ( ( isset( $tax->description ) ) ? $tax->description : '' );
						//
						$post->term_id          = $tax->term_id;
						$post->term_taxonomy_id = $tax->term_taxonomy_id;
						$post->taxonomy         = $tax->taxonomy;
					}

					return $post;
				}
			}

		}

		//Check if author
		if ( is_author() ) {
			if ( $author = $this->getAuthorDetails() ) {
				$post->post_type = 'profile';
				if ( isset( $author->ID ) ) {

					$post->hash         = md5( $post->post_type . $author->ID );
					$post->post_author  = $author->display_name;
					$post->post_title   = $author->display_name;
					$post->post_excerpt = $author->description;
					$post->ID           = $author->ID;
					//If buddypress installed
					if ( function_exists( 'bp_core_get_user_domain' ) ) {
						$post->url = bp_core_get_user_domain( $author->ID );
					} else {
						$post->url = get_author_posts_url( $author->ID );
					}

				}

				return $post;
			}

		}

		//Check if archive
		if ( is_archive() ) {
			if ( $archive = $this->getArchiveDetails() ) {
				return $this->addArchive( $post, $archive );
			}
		}

		//In case of post type in archieve like gurutheme
		if ( $this->checkCutomPostType( $post->post_type ) ) {
			return $this->addCustomPostType( $post );
		}

		//Check if Not Found
		if ( is_404() ) {
			$post->post_type = '404';
			$post->hash      = md5( $post->post_type );
			if ( $post->post_name <> '' ) {
				$post->hash = md5( $post->post_type . $post->post_name );
			}

			return $post;
		}

		return false;
	}

	/**
	 * Add page if needed
	 *
	 * @param  $url
	 *
	 * @return string
	 */
	public function addPaged( $post ) {
		if ( ! is_admin() && is_paged() && isset( $post->url ) && $post->url <> '' ) {
			$page = (int) get_query_var( 'paged' );
			if ( $page && $page > 1 ) {
				$post->url = trailingslashit( $post->url ) . "page/" . "$page/";
			}
		}

		return $post;
	}

	/**
	 * Check if Search in URL
	 *
	 * @param $post
	 *
	 * @return mixed
	 */
	public function addSearch( $post ) {

		//Check if search
		if ( ! is_admin() && function_exists( 'is_search' ) && is_search() ) {

			if ( ! $post instanceof SQ_Models_Domain_Post ) {
				$post = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Post', $post );
			}

			$post->post_type = 'search';
			$post->hash      = md5( $post->post_type );

			//Set the search guid
			$post->url = home_url() . '/' . $post->post_type . '/';
			$search    = get_query_var( 's' );
			if ( $search !== '' ) {
				$post->url  .= $search;
				$post->hash = md5( $post->post_type . $search );
			}

			if ( $post->post_name <> '' ) {
				$post->hash = md5( $post->guid );
			}

		}

		return $post;
	}

	/**
	 * Add the archive details to the current post
	 *
	 * @param $post
	 *
	 * @return mixed
	 */
	public function addArchive( $post, $archive ) {

		$post->url = $archive->url;

		if ( $archive->path <> '' ) {
			$post->post_type = 'archive';
			$post->hash      = md5( 'archive' . $archive->path );
			$post->post_date = wp_date( get_option( 'date_format' ), strtotime( $archive->path ) );
		} else {
			$post->post_type = 'archive' . '-' . $archive->post_type;
			$post->hash      = md5( $post->post_type );
		}

		return $post;
	}

	/**
	 * Get information about the Archive
	 *
	 * @return array|bool|mixed|object
	 */
	public function getArchiveDetails() {
		$archive = false;

		if ( is_date() ) {
			if ( is_day() ) {
				$archive = array(
					'path' => get_query_var( 'year' ) . '-' . get_query_var( 'monthnum' ) . '-' . get_query_var( 'day' ),
					'url'  => get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) ),
				);
			} elseif ( is_month() ) {
				$archive = array(
					'path' => get_query_var( 'year' ) . '-' . get_query_var( 'monthnum' ),
					'url'  => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
				);
			} elseif ( is_year() ) {
				$archive = array(
					'path' => get_query_var( 'year' ),
					'url'  => get_year_link( get_query_var( 'year' ) ),
				);
			}

			if ( ! empty( $archive ) ) {
				return json_decode( wp_json_encode( $archive ) );
			}
		}

		if ( is_post_type_archive() ) {
			$post_type = get_query_var( 'post_type' );
			if ( is_array( $post_type ) ) {
				$post_type = current( $post_type );
			}

			$archive = array(
				'post_type' => $post_type,
				'path'      => '',
				'url'       => get_post_type_archive_link( $post_type ),
			);

		}

		if ( ! empty( $archive ) ) {
			return json_decode( wp_json_encode( $archive ) );
		}

		return false;
	}

	/**
	 * Get the keyword fof this URL
	 *
	 * @param $post
	 *
	 * @return array|false|WP_Error|WP_Term
	 */
	private function getTagDetails( $post ) {
		$temp = str_replace( '&#8230;', '...', single_tag_title( '', false ) );

		foreach ( get_taxonomies() as $tax ) {
			if ( $tax <> 'category' ) {

				if ( $tag = get_term_by( 'name', $temp, $tax ) ) {
					if ( ! is_wp_error( $tag ) ) {
						return $tag;
					}
				}
			}
		}

		if ( $tag = get_term_by( 'id', $post->term_id, $post->taxonomy ) ) {
			if ( ! is_wp_error( $tag ) ) {
				return $tag;
			}
		}

		return false;
	}

	/**
	 * Get the taxonomies details for this URL
	 *
	 * @param $post
	 *
	 * @return array|bool|false|mixed|null|object|string|WP_Error|WP_Term
	 */
	private function getTaxonomyDetails( $post ) {
		if ( $id = get_queried_object_id() ) {
			$term = get_term( $id, '' );
			if ( ! is_wp_error( $term ) ) {
				return $term;
			}
		}

		if ( $term = get_term_by( 'id', $post->term_id, $post->taxonomy ) ) {
			if ( ! is_wp_error( $term ) ) {
				return $term;
			}
		}

		return false;
	}

	/**
	 * Get the category details for this URL
	 *
	 * @param $post
	 *
	 * @return array|false|object|WP_Error|null
	 */
	private function getCategoryDetails( $post ) {

		if ( $term = get_category( get_query_var( 'cat' ), false ) ) {
			if ( ! is_wp_error( $term ) ) {
				return $term;
			}
		}

		if ( $tag = get_term_by( 'id', $post->term_id, $post->taxonomy ) ) {
			if ( ! is_wp_error( $tag ) ) {
				return $term;
			}
		}

		return false;
	}

	/**
	 * Get the profile details for this URL
	 *
	 * @return object
	 */
	public function getAuthorDetails() {
		$author = false;
		global $authordata;
		if ( isset( $authordata->data ) ) {
			$author              = $authordata->data;
			$author->description = get_the_author_meta( 'description' );
		}

		return $author;
	}

	/**
	 * Add the custom post type details to the current post
	 *
	 * @param $post
	 *
	 * @return mixed
	 */
	public function addCustomPostType( $post ) {

		$post->hash = md5( $post->post_type );

		if ( (int) $post->term_id > 0 ) {
			if ( ! is_wp_error( get_term_link( $post->term_id ) ) ) {
				$post->url = get_term_link( $post->term_id );
			}
		} else {
			$post->url = get_post_type_archive_link( $post->post_type );
		}

		return $post;

	}

	/**
	 * Get the custom post types
	 *
	 * @param $post_type
	 *
	 * @return bool
	 */
	public function checkCutomPostType( $post_type ) {
		//If the post type is set
		if ( $post_type <> '' ) {
			//Check if is in the current custom post type list
			if ( $post_types = get_query_var( 'post_type' ) ) {
				if ( is_array( $post_types ) && ! empty( $post_types ) ) {
					return in_array( $post_type, $post_types, true );
				} elseif ( is_object( $post_types ) && ! empty( (array) $post_types ) ) {
					return in_array( $post_type, (array) $post_types, true );
				} elseif ( is_string( $post_types ) && $post_types <> '' ) {
					return in_array( $post_type, array( $post_types ), true );
				}
			}

		}

		return false;
	}

	/**
	 * Get the custom post type
	 *
	 * @depreacted since 12.1.20
	 * @return string|bool
	 */
	public function getCutomPostType() {
		if ( $post_type = get_query_var( 'post_type' ) ) {
			if ( is_array( $post_type ) && ! empty( $post_type ) ) {
				$post_type = current( $post_type );
			}
		}

		if ( $post_type <> '' ) {
			return $post_type;
		}

		return false;
	}

	/**
	 * Check if is the homepage
	 *
	 * @return bool
	 */
	public function isHomePage() {
		global $wp_query;

		return ( is_home() || ( isset( $wp_query->query ) && empty( $wp_query->query ) && ! is_preview() ) );
	}

	/**
	 * Check if the header is an HTML Header
	 *
	 * @return bool
	 */
	public function isHtmlHeader() {
		$headers = headers_list();

		foreach ( $headers as $index => $value ) {
			if ( strpos( $value, ':' ) !== false ) {
				$exploded = explode( ': ', $value );
				if ( count( (array) $exploded ) > 1 ) {
					$headers[ $exploded[0] ] = $exploded[1];
				}
			}
		}
		if ( isset( $headers['Content-Type'] ) ) {
			if ( strpos( $headers['Content-Type'], 'text/html' ) !== false ) {
				return true;
			}
		} else {
			return false;
		}

		return false;
	}

	/**
	 * Is Quick SEO enabled for this page?
	 *
	 * @return bool
	 */
	public function runSEOForThisPage() {
		if ( SQ_Classes_Helpers_Tools::getValue( 'sq_seo' ) == 'off' ) {
			return false;
		}

		if ( ! $this->isHtmlHeader() ) {
			return false;
		}

		if ( $this->_post && isset( $this->_post->hash ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Pack HTML prefix if exists
	 *
	 * @param  $prefix
	 *
	 * @return string
	 */
	public function packPrefix( $prefix ) {
		if ( $prefix <> '' ) {
			return ' prefix="' . $prefix . '"';
		}

		return '';
	}

	/**
	 * Redirect the attachments to the new URL
	 */
	public function redirectAttachments() {

		if ( is_attachment() ) {

			$url = wp_get_attachment_url( get_queried_object_id() );

			if ( ! empty( $url ) ) {
				wp_redirect( $url, 301 );
				exit;
			}

		}
	}

	/**
	 * Fix the SEO Links in the source code
	 *
	 * @param  $buffer
	 *
	 * @return mixed
	 */
	public function fixSEOLinks( $buffer ) {

		preg_match_all( '/<a[^>]*href=[\'"]([^\'"]+)[\'"][^>]*>/i', $buffer, $out );

		if ( empty( $out ) || empty( $out[0] ) ) {
			return $buffer;
		}

		if ( $domain = parse_url( home_url(), PHP_URL_HOST ) ) {
			foreach ( $out[0] as $index => $link ) {
				$newlink = $link;

				//only for external links
				if ( isset( $out[1][ $index ] ) ) {
					//If it's not a valid link
					if ( ! $linkdomain = parse_url( $out[1][ $index ], PHP_URL_HOST ) ) {
						continue;
					}

					//If it's not an external link
					if ( stripos( $linkdomain, $domain ) !== false ) {
						continue;
					}

					//If it's not an exception link
					$exceptions = SQ_Classes_Helpers_Tools::getOption( 'sq_external_exception' );
					if ( ! empty( $exceptions ) ) {
						foreach ( $exceptions as $exception ) {
							if ( $exception <> '' ) {
								if ( stripos( $exception, $linkdomain ) !== false || stripos( $linkdomain, $exception ) !== false ) {
									continue 2;
								}
							}
						}
					}
				}

				//If nofollow rel is set
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_external_nofollow' ) ) {

					if ( strpos( $newlink, 'rel=' ) === false ) {
						$newlink = str_replace( '<a', '<a rel="nofollow" ', $newlink );
					} elseif ( strpos( $newlink, 'nofollow' ) === false ) {
						$newlink = preg_replace( '/(rel=[\'"])([^\'"]+)([\'"])/i', '$1nofollow $2$3', $newlink );
					}

				}

				//if force external open
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_external_blank' ) ) {

					if ( strpos( $newlink, 'target=' ) === false ) {
						$newlink = str_replace( '<a', '<a target="_blank" ', $newlink );
					} elseif ( strpos( $link, '_blank' ) === false ) {
						$newlink = preg_replace( '/(target=[\'"])([^\'"]+)([\'"])/i', '$1_blank$3', $newlink );
					}

				}

				//Check the link and replace it
				if ( $newlink <> $link ) {
					$buffer = str_replace( $link, $newlink, $buffer );
				}
			}
		}

		return $buffer;
	}

}
