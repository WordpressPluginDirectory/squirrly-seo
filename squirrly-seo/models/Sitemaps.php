<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Squirrly SEO - Sitemap Model
 *
 * Used to get the sitemap format for each type
 *
 * @class SQ_Models_Sitemaps
 */
class SQ_Models_Sitemaps extends SQ_Models_Abstract_Seo {

	public $args = array();
	public $frequency;

	private $sitemap = false;

	public $language; //plugins language
	protected $postmodified;

	public function __construct() {

		//For sitemap ping
		$this->args['timeout'] = 5;

		$this->frequency            = array();
		$this->frequency['hourly']  = array(
			'sitemap-home'        => array( 1, 'hourly' ),
			'sitemap-product'     => array( 1, 'hourly' ),
			'sitemap-post'        => array( 1, 'hourly' ),
			'sitemap-page'        => array( 0.6, 'hourly' ),
			'sitemap-category'    => array( 0.5, 'daily' ),
			'sitemap-post_tag'    => array( 0.5, 'daily' ),
			'sitemap-archive'     => array( 0.3, 'monthly' ),
			'sitemap-author'      => array( 0.3, 'daily' ),
			'sitemap-custom-tax'  => array( 0.3, 'hourly' ),
			'sitemap-custom-post' => array( 1, 'hourly' ),
			'sitemap-attachment'  => array( 0.3, 'hourly' )
		);
		$this->frequency['daily']   = array(
			'sitemap-home'        => array( 1, 'daily' ),
			'sitemap-product'     => array( 0.8, 'daily' ),
			'sitemap-post'        => array( 0.8, 'daily' ),
			'sitemap-page'        => array( 0.6, 'weekly' ),
			'sitemap-category'    => array( 0.5, 'weekly' ),
			'sitemap-post_tag'    => array( 0.5, 'daily' ),
			'sitemap-archive'     => array( 0.3, 'monthly' ),
			'sitemap-author'      => array( 0.3, 'weekly' ),
			'sitemap-custom-tax'  => array( 0.3, 'weekly' ),
			'sitemap-custom-post' => array( 0.8, 'daily' ),
			'sitemap-attachment'  => array( 0.3, 'weekly' )
		);
		$this->frequency['weekly']  = array(
			'sitemap-home'        => array( 1, 'weekly' ),
			'sitemap-product'     => array( 0.8, 'weekly' ),
			'sitemap-post'        => array( 0.8, 'weekly' ),
			'sitemap-page'        => array( 0.6, 'monthly' ),
			'sitemap-category'    => array( 0.3, 'monthly' ),
			'sitemap-post_tag'    => array( 0.5, 'weekly' ),
			'sitemap-archive'     => array( 0.3, 'monthly' ),
			'sitemap-author'      => array( 0.3, 'weekly' ),
			'sitemap-custom-tax'  => array( 0.3, 'weekly' ),
			'sitemap-custom-post' => array( 0.8, 'weekly' ),
			'sitemap-attachment'  => array( 0.3, 'monthly' )
		);
		$this->frequency['monthly'] = array( 'sitemap-home'        => array( 1, 'monthly' ),
		                                     'sitemap-product'     => array( 0.8, 'weekly' ),
		                                     'sitemap-post'        => array( 0.8, 'monthly' ),
		                                     'sitemap-page'        => array( 0.6, 'monthly' ),
		                                     'sitemap-category'    => array( 0.3, 'monthly' ),
		                                     'sitemap-post_tag'    => array( 0.5, 'monthly' ),
		                                     'sitemap-archive'     => array( 0.3, 'monthly' ),
		                                     'sitemap-author'      => array( 0.3, 'monthly' ),
		                                     'sitemap-custom-tax'  => array( 0.3, 'monthly' ),
		                                     'sitemap-custom-post' => array( 0.8, 'monthly' ),
		                                     'sitemap-attachment'  => array( 0.3, 'monthly' )
		);
		$this->frequency['yearly']  = array( 'sitemap-home'        => array( 1, 'monthly' ),
		                                     'sitemap-product'     => array( 0.8, 'weekly' ),
		                                     'sitemap-post'        => array( 0.8, 'monthly' ),
		                                     'sitemap-page'        => array( 0.6, 'yearly' ),
		                                     'sitemap-category'    => array( 0.3, 'yearly' ),
		                                     'sitemap-post_tag'    => array( 0.5, 'monthly' ),
		                                     'sitemap-archive'     => array( 0.3, 'yearly' ),
		                                     'sitemap-author'      => array( 0.3, 'yearly' ),
		                                     'sitemap-custom-tax'  => array( 0.3, 'yearly' ),
		                                     'sitemap-custom-post' => array( 0.8, 'monthly' ),
		                                     'sitemap-attachment'  => array( 0.3, 'monthly' )
		);


	}

	/**
	 * Set the sitemap language based on Multilingual plugins
	 *
	 * @return void
	 */
	public function setCurrentLanguage() {
		if ( function_exists( 'pll_current_language' ) ) {
			$this->language = apply_filters( 'sq_sitemap_language', pll_current_language() );
		} elseif ( function_exists( 'weglot_get_current_language' ) ) {
			$this->language = weglot_get_current_language();
		}  else {
			$this->language = apply_filters( 'sq_sitemap_language', get_locale() );
		}

	}

	/**
	 * Get sitemap language
	 *
	 * @return mixed
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * Set the current sitemap type
	 *
	 * @param $sitemap
	 *
	 * @return void
	 */
	public function setCurrentSitemap( $sitemap ) {
		$this->sitemap = $sitemap;
	}

	/**
	 * Add the Sitemap Index
	 *
	 * @return array
	 * @global $polylang
	 */
	public function getHomeLink() {
		$homes             = array();
		$homes['contains'] = array();

		if ( function_exists( 'pll_languages_list' ) && function_exists( 'pll_home_url' ) ) {
			if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_combinelangs' ) ) {

				foreach ( pll_languages_list() as $term ) {
					$xml               = array();
					$xml['loc']        = esc_url( pll_home_url( $term ) );
					$xml['lastmod']    = trim( mysql2date( 'Y-m-d\TH:i:s+00:00', date( 'Y-m-d', strtotime( get_lastpostmodified( 'gmt' ) ) ), false ) );
					$xml['changefreq'] = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ]['sitemap-home'][1];
					$xml['priority']   = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ]['sitemap-home'][0];
					$homes[]           = $xml;
				}
			} else {

				$xml               = array();
				$xml['loc']        = esc_url( pll_home_url( $this->language ) );
				$xml['lastmod']    = trim( mysql2date( 'Y-m-d\TH:i:s+00:00', date( 'Y-m-d', strtotime( get_lastpostmodified( 'gmt' ) ) ), false ) );
				$xml['changefreq'] = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ]['sitemap-home'][1];
				$xml['priority']   = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ]['sitemap-home'][0];
				$homes[]           = $xml;

			}
		} else {
			if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setHomePage() ) {
				if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
					return $homes;
				}

				$xml               = array();
				$xml['loc']        = $post->url;
				$xml['lastmod']    = $this->lastModified( $post );
				$xml['changefreq'] = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][1];
				$xml['priority']   = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][0];
			}
			$homes[] = $xml;
			unset( $xml );
		}

		return $homes;
	}

	/**
	 * Add posts/pages in sitemap
	 *
	 * @return array
	 */
	public function getListPosts() {
		global $wp_query, $sq_query;

		$wp_query           = new WP_Query( $sq_query );
		$wp_query->is_paged = false; //remove pagination

		$posts             = $post_ids = array();
		$posts['contains'] = array();
		if ( have_posts() ) {
			//get all the post ids
			//$post_ids = wp_list_pluck(get_posts(), 'ID');

			while ( have_posts() ) {
				the_post();
				$currentpost = get_post();

				//do not include password-protected pages in sitemap
				if ( post_password_required() ) {
					continue;
				}

				//Polylang compatibility
				if ( function_exists( 'pll_get_post_translations' ) ) {
					if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_combinelangs' ) ) {
						$translates = pll_get_post_translations( $currentpost->ID );
						if ( ! empty( $translates ) ) {
							foreach ( $translates as $post_id ) {
								if ( ! in_array( $post_id, $post_ids ) ) { //prevent from showing duplicates
									if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $post_id ) ) {
										if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
											continue;
										}
										$posts[]    = $this->_getXml( $post );
										$post_ids[] = $post_id;
									}
								}
								//always add the current post ID as processed
								$post_ids[] = $currentpost->ID;
							}
						}
					} elseif(function_exists('pll_get_post')) {
						if ( $post_id = pll_get_post( $currentpost->ID ) ) {
							if ( ! in_array( $post_id, $post_ids ) ) { //prevent from showing duplicates
								if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $post_id ) ) {
									if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
										continue;
									}
									$posts[] = $this->_getXml( $post );

									$post_ids[] = $post_id;

								}
							}
							//always add the current post ID as processed
							$post_ids[] = $currentpost->ID;
						}
					}
				}

				//WPML compatibility
				if ( function_exists( 'wpml_get_language_information' ) ) {

					$current_lang = apply_filters( 'wpml_current_language', null );

					if ( $current_lang && $info = wpml_get_language_information( $currentpost->ID ) ) {

						if ( isset( $info['language_code'] ) && $info['language_code'] == $current_lang ) {
							if ( ! in_array( $currentpost->ID, $post_ids ) ) { //prevent from showing duplicates

								if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $currentpost->ID ) ) {
									if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
										continue;
									}
									if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) && $post->sq->noindex ) {
										continue;
									}

									$posts[] = $this->_getXml( $post );
								}
							}

							//always add the current post ID as processed
							$post_ids[] = $currentpost->ID;
						}

					}
				}

				if ( ! in_array( $currentpost->ID, $post_ids ) ) { //prevent from showing duplicates
					if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $currentpost ) ) {
						if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
							continue;
						}
						if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) && $post->sq->noindex ) {
							continue;
						}
						$posts[]    = $this->_getXml( $post );
						$post_ids[] = $post->ID;
					}
				}
			}
		}

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				if ( array_key_exists( 'image:image', $post ) ) {
					$posts['contains'][] = 'image';
				}
				if ( array_key_exists( 'video:video', $post ) ) {
					$posts['contains'][] = 'video';
				}
			}
		}

		return $posts;
	}

	public function getListAttachments() {
		global $wp_query, $sq_query;

		$wp_query           = new WP_Query( $sq_query );
		$wp_query->is_paged = false; //remove pagination

		$posts             = $post_ids = array();
		$posts['contains'] = array();
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				//do not include password-protected pages in sitemap
				if ( post_password_required() ) {
					continue;
				}

				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( get_post() ) ) {
					if ( in_array( $post->ID, $post_ids ) ) { //prevent from showing duplicates
						continue;
					}
					if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
						continue;
					}
					if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) && $post->sq->noindex ) {
						continue;
					}

					$xml = $this->_getXml( $post );
					if ( strpos( $xml['loc'], '?' ) !== false ) {
						$xml['loc'] = wp_get_attachment_url( $post->ID );
					}
					$posts[]    = $xml;
					$post_ids[] = $post->ID;
				}


			}
		}

		foreach ( $posts as $post ) {
			if ( array_key_exists( 'image:image', $post ) ) {
				$posts['contains'][] = 'image';
			}
			if ( array_key_exists( 'video:video', $post ) ) {
				$posts['contains'][] = 'video';
			}
		}

		return $posts;
	}

	/**
	 * Add the post news in sitemap
	 * If the site is registers for Google News
	 *
	 * @return array
	 */
	public function getListNews() {
		global $wp_query, $sq_query;
		$wp_query           = new WP_Query( $sq_query );
		$wp_query->is_paged = false; //remove pagination

		$posts             = $post_ids = array();
		$posts['contains'] = array();

		if ( have_posts() ) {

			while ( have_posts() ) {
				the_post();

				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->setPost( get_post() )->getPost() ) {

					if ( in_array( $post->ID, $post_ids ) ) { //prevent from showing duplicates
						continue;
					}

					if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
						continue;
					}
					if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) && $post->sq->noindex ) {
						continue;
					}

					$this->setPost( $post ); //set current sitemap post
					$post_ids[] = $post->ID;

					$xml        = array();
					$xml['loc'] = esc_url( $post->url );

					$language = convert_chars( strip_tags( get_bloginfo( 'language' ) ) );
					if ( strpos( $language, '-' ) ) {
						$language = substr( $language, 0, strpos( $language, '-' ) );
					}
					if ( $language == '' ) {
						$language = 'en';
					}

					$xml['news:news'][ $post->ID ] = array(
						'news:publication' => array(
							'news:name'     => SQ_Classes_Helpers_Sanitize::clearTitle( get_bloginfo( 'name' ) ),
							'news:language' => $language
						)
					);

					$xml['news:news'][ $post->ID ]['news:publication_date'] = $this->lastModified( $post );
					$xml['news:news'][ $post->ID ]['news:title']            = SQ_Classes_Helpers_Sanitize::clearTitle( $post->sq->title );
					$xml['news:news'][ $post->ID ]['news:keywords']         = SQ_Classes_Helpers_Sanitize::clearKeywords( $post->sq->keywords );


					if ( SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['images'] == 1 ) {
						$this->setPost( $post ); //set current sitemap post
						if ( $images = $this->getPostImages( true ) ) {
							$posts['contains'][] = 'image';
							$xml['image:image']  = array();
							foreach ( $images as $image ) {
								if ( empty( $image['src'] ) ) {
									continue;
								}

								$xml['image:image'][] = array(
									'image:loc'     => esc_url( $image['src'] ),
									'image:title'   => SQ_Classes_Helpers_Sanitize::clearTitle( $image['title'] ),
									'image:caption' => SQ_Classes_Helpers_Sanitize::clearDescription( $image['description'] ),
								);
							}
						}
					}

					if ( SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['videos'] == 1 ) {

						$this->setPost( $post ); //set current sitemap post
						if ( $videos = $this->getPostVideos( true ) ) {
							$posts['contains'][] = 'video';
							$xml['video:video']  = array();
							foreach ( $videos as $index => $video ) {
								if ( $video['src'] <> '' && $video['thumbnail'] <> '' ) {
									$xml['video:video'][ $index ] = array(
										'video:player_loc'    => $video['src'],
										'video:thumbnail_loc' => $video['thumbnail'],
										'video:title'         => SQ_Classes_Helpers_Sanitize::clearTitle( $post->sq->title ),
										'video:description'   => SQ_Classes_Helpers_Sanitize::clearDescription( $post->sq->description ),
									);

									//set the first keyword for this video
									$keywords = $post->sq->keywords;
									$keywords = preg_split( '/,/', $keywords );
									if ( is_array( $keywords ) ) {
										$xml['video:video'][ $index ]['video:tag'] = SQ_Classes_Helpers_Sanitize::clearKeywords( $keywords[0] );
									}
								}
							}
						}
					}
					$posts[] = $xml;
					unset( $xml );
				}
			}
		}

		return $posts;
	}

	/**
	 * Add the Taxonomies in sitemap
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	public function getListTerms( $terms = false ) {

		$array = $term_ids = array();

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $term ) {

				//make sure it has a language
				if ( function_exists( 'pll_get_post_translations' ) && function_exists( 'pll_get_term' ) ) {
					$term->term_id = pll_get_term( $term->term_id, $this->language );
				}

				if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByTaxID( $term->term_id, $term->taxonomy ) ) {

					if ( in_array( $post->term_id, $term_ids ) ) { //prevent from showing duplicates
						continue;
					}

					if ( ! $post->url ) {
						$post->url = get_term_link( $term->term_id, $term->taxonomy );
					}

					if ( $post->sq->nositemap || ! $post->sq->do_sitemap || ! $post->url ) {
						continue;
					}

					if ( SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_exclude_noindex' ) && $post->sq->noindex ) {
						continue;
					}

					$array[]    = $this->_getXml( $post );
					$term_ids[] = $post->term_id;

				}

			}
		}

		return $array;
	}

	/**
	 * Add the authors in sitemap
	 *
	 * @return array
	 */
	public function getListAuthors() {
		$array   = array();
		$authors = apply_filters( 'sq-sitemap-authors', $this->sitemap );

		if ( ! empty( $authors ) ) {
			foreach ( $authors as $author ) {
				$xml = array();

				$xml['loc'] = get_author_posts_url( $author->ID, $author->user_nicename );
				if ( isset( $author->lastmod ) && $author->lastmod <> '' ) {
					$xml['lastmod'] = date( 'Y-m-d\TH:i:s+00:00', strtotime( $author->lastmod ) );
				}
				$xml['changefreq'] = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][1];
				$xml['priority']   = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][0];

				$array[] = $xml;
			}
		}

		return $array;
	}

	/**
	 * Add the archive in sitemap
	 *
	 * @return array
	 */
	public function getListArchive() {
		$array    = array();
		$archives = apply_filters( 'sq-sitemap-archive', $this->sitemap );
		if ( ! empty( $archives ) ) {
			foreach ( $archives as $post_type => $archive ) {
				$xml = array();

				if ( 'post' === $post_type && isset( $archive->year ) && isset( $archive->month ) ) {
					$xml['loc'] = get_month_link( $archive->year, $archive->month );
				} else {
					$xml['loc'] = get_post_type_archive_link( $post_type );
				}

				if ( isset( $archive->lastmod ) && $archive->lastmod <> '' ) {
					$xml['lastmod'] = date( 'Y-m-d\TH:i:s+00:00', strtotime( $archive->lastmod ) );
				}

				$xml['changefreq'] = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][1];
				$xml['priority']   = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][0];

				$array[] = $xml;
			}
		}

		return $array;
	}

	/**
	 * Generate the KML file contents.
	 *
	 * @return array $kml KML file content.
	 */
	public function getKmlXML() {
		$xml    = array();
		$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_type' ) == 'Organization' ) {
			if ( $jsonld['Organization']['place']['geo']['latitude'] <> '' && $jsonld['Organization']['place']['geo']['longitude'] <> '' ) {

				$xml['name']        = 'Locations for ' . $jsonld['Organization']['name'];
				$xml['description'] = $jsonld['Organization']['description'];
				$xml['open']        = 1;

				$xml['Folder']['Placemark']['name']        = $jsonld['Organization']['name'];
				$xml['Folder']['Placemark']['description'] = $jsonld['Organization']['description'];

				//Add business address
				$xml['Folder']['Placemark']['address'] = '';
				if ( $jsonld['Organization']['address']['streetAddress'] <> '' ) {
					$xml['Folder']['Placemark']['address'] .= $jsonld['Organization']['address']['streetAddress'];
				}
				if ( $jsonld['Organization']['address']['addressLocality'] <> '' ) {
					$xml['Folder']['Placemark']['address'] .= ',' . $jsonld['Organization']['address']['addressLocality'];
				}
				if ( $jsonld['Organization']['address']['postalCode'] <> '' ) {
					$xml['Folder']['Placemark']['address'] .= ',' . $jsonld['Organization']['address']['postalCode'];
				}
				if ( $jsonld['Organization']['address']['addressCountry'] <> '' ) {
					$xml['Folder']['Placemark']['address'] .= ',' . $jsonld['Organization']['address']['addressCountry'];
				}


				$xml['Folder']['Placemark']['phoneNumber'] = $jsonld['Organization']['contactPoint']['telephone'];
				//$xml['Folder']['Placemark']['atom:link href="' . get_bloginfo('url') . '"'] = false;
				$xml['Folder']['Placemark']['LookAt']['latitude']     = $jsonld['Organization']['place']['geo']['latitude'];
				$xml['Folder']['Placemark']['LookAt']['longitude']    = $jsonld['Organization']['place']['geo']['longitude'];
				$xml['Folder']['Placemark']['LookAt']['altitude']     = 0;
				$xml['Folder']['Placemark']['LookAt']['range']        = 0;
				$xml['Folder']['Placemark']['LookAt']['tilt']         = 0;
				$xml['Folder']['Placemark']['LookAt']['altitudeMode'] = 'relativeToGround';
				$xml['Folder']['Placemark']['Point']['altitudeMode']  = 'relativeToGround';
				$xml['Folder']['Placemark']['Point']['coordinates']   = $jsonld['Organization']['place']['geo']['longitude'];
				$xml['Folder']['Placemark']['Point']['coordinates']   .= ',' . $jsonld['Organization']['place']['geo']['latitude'];
				$xml['Folder']['Placemark']['Point']['coordinates']   .= ',0';
			}
		}

		return $xml;
	}

	/**
	 * Get the XML of the URL
	 *
	 * @param  $post
	 *
	 * @return array
	 */
	private function _getXml( $post ) {
		$xml = array();

		if ( ! isset( $post->url ) || ! $post->url || strpos( $post->url, home_url() ) === false ) {
			return $xml;
		}

		if ( ! isset( $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ] ) ) {
			return $xml;
		}

		//Prevent sitemap from braking due to & in URLs
		$xml['loc']        = esc_url( apply_filters( 'sq_sitemap_permalink', $post->url ) );
		$xml['lastmod']    = $this->lastModified( $post );
		$xml['changefreq'] = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][1];
		$xml['priority']   = $this->frequency[ SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_frequency' ) ][ $this->sitemap ][0];

		//Get Post Images
		if ( (int) $post->ID > 0 && SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['images'] == 1 ) {

			$this->setPost( $post ); //set current sitemap post
			if ( $images = $this->getPostImages( true ) ) {
				$xml['image:image'] = array();
				foreach ( $images as $image ) {
					if ( empty( $image['src'] ) || strpos( $image['src'], '//' ) === false ) {
						continue;
					}

					$xml['image:image'][] = array(
						'image:loc'     => esc_url( $image['src'] ),
						'image:title'   => SQ_Classes_Helpers_Sanitize::clearTitle( $image['title'] ),
						'image:caption' => SQ_Classes_Helpers_Sanitize::clearDescription( $image['description'] ),
					);
				}
			}
		}
		//Get Post Video
		if ( (int) $post->ID > 0 && SQ_Classes_Helpers_Tools::$options['sq_sitemap_show']['videos'] == 1 ) {

			$this->setPost( $post ); //set current sitemap post
			if ( $videos = $this->getPostVideos( true ) ) {

				$xml['video:video'] = array();
				foreach ( $videos as $index => $video ) {

					if ( $video['src'] <> '' && $video['thumbnail'] <> '' ) {
						$xml['video:video'][ $index ] = array(
							'video:player_loc'    => $video['src'],
							'video:thumbnail_loc' => $video['thumbnail'],
							'video:title'         => SQ_Classes_Helpers_Sanitize::clearTitle( $post->sq->title ),
							'video:description'   => SQ_Classes_Helpers_Sanitize::clearDescription( $post->sq->description ),
						);

						//set the first keyword for this video
						$keywords = $post->sq->keywords;
						$keywords = preg_split( '/,/', $keywords );
						if ( is_array( $keywords ) ) {
							$xml['video:video'][ $index ]['video:tag'] = SQ_Classes_Helpers_Sanitize::clearKeywords( $keywords[0] );
						}
					}
				}

			}
		}

		return $xml;
	}

	/**
	 * Get the last modified date for the specific post/page
	 *
	 * @return string
	 * @global SQ_Models_Domain_Post $post
	 */
	public function lastModified( $post ) {

		$datetime =  get_lastpostmodified( 'gmt' );

		if ( $post instanceof SQ_Models_Domain_Post ) {
			if ( isset( $post->ID ) && $post->ID > 0 ) {

				$datetime = get_post_modified_time( 'Y-m-d H:i:s', true, $post->ID );

			} elseif ( isset( $post->term_id ) && $post->term_id > 0 && $post->taxonomy <> '' ) {

				// get the latest post in this taxonomy item, to use its post_date as lastmod
				$posts = get_posts( array(
						'post_type'              => 'any',
						'numberposts'            => 1,
						'no_found_rows'          => true,
						'update_post_meta_cache' => false,
						'update_post_term_cache' => false,
						'update_cache'           => false,
						'tax_query'              => array(
							array(
								'taxonomy' => $post->taxonomy,
								'field'    => 'term_id',
								'terms'    => $post->term_id
							)
						)
					) );

				if ( isset( $posts[0]->post_date_gmt ) && $posts[0]->post_date_gmt <> '' ) {
					$datetime = $posts[0]->post_date_gmt;
				}
			}
		}

		$timezone = wp_timezone();
		$datetime = date_create( $datetime, $timezone );

		return trim( gmdate( 'Y-m-d\TH:i:s+00:00', ($datetime->getTimestamp() + $datetime->getOffset()) ) );
	}


}
