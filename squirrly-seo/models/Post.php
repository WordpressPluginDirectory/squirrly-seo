<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Shown in the Post page (called from SQ_Controllers_Menu)
 */
class SQ_Models_Post {

	/**
	 * Check if current post is indexable
	 *
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function isIndexable( $post_id ) {

		if ( (int) $post_id > 0 ) {
			if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $post_id ) ) {
				if ( $post->sq->noindex ) {
					return false;
				}
			}
		}

		return true;

	}

	/**
	 * Check if the SEO Snippet and Squirrly SEO is activated for this post
	 *
	 * @param $post
	 *
	 * @return mixed|void
	 */
	public function isSnippetEnable( $post ) {

		$active    = true;
		$post_type = false;
		$pattern   = SQ_Classes_Helpers_Tools::getOption( 'patterns' );

		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
			$active = false;
		}

		if ( isset( $post->post_type ) ) {
			$post_type = $post->post_type;
		} elseif ( isset( $post->taxonomy ) ) {
			$post_type = $post->taxonomy;
			if ( $post_type == 'post_tag' ) {
				$post_type = 'tag';
			}
		}

		if ( $post_type && isset( $pattern[ $post_type ] ) ) {
			if ( isset( $pattern[ $post_type ]['doseo'] ) && ! $pattern[ $post_type ]['doseo'] ) {
				$active = false;
			}
		}

		return apply_filters( 'sq_load_snippet', $active );

	}

	/**
	 * Check if Squirrly Live Assistant is activated for this post type
	 *
	 * @param $post_type
	 *
	 * @return bool
	 */
	public function isSLAEnable( $post_type ) {
		//get the post types for which SLA is active
		$post_types = SQ_Classes_Helpers_Tools::getOption( 'sq_sla_exclude_post_types' );

		if ( ! empty( $post_types ) ) {
			$post_types[] = 'ct_template';
		}

		//Add the post type for post list
		if ( in_array( 'post', $post_types ) ) {
			$post_types[] = 'posts';
		}

		//Add the post type for post list
		if ( in_array( 'page', $post_types ) ) {
			$post_types[] = 'pages';
		}

		return ! in_array( $post_type, $post_types );
	}

	/**
	 * Check if current post is in sitemap
	 *
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function isInSitemap( $post_id ) {

		if ( (int) $post_id > 0 ) {
			if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $post_id ) ) {
				if ( $post->sq->nositemap || ! $post->sq->do_sitemap ) {
					return false;
				}
			}
		}

		return true;

	}

	/**
	 * @return array|string[]|WP_Post_Type[]
	 */
	public function getSnippetPostTypes() {
		$types = get_post_types( array( 'public' => true ) );

		//Exclude types for SLA
		$excludes = SQ_Classes_Helpers_Tools::getOption( 'sq_sla_exclude_post_types' );
		if ( ! empty( $types ) && ! empty( $excludes ) ) {
			foreach ( $excludes as $exclude ) {
				if ( $exclude ) {
					if ( in_array( $exclude, $types ) ) {
						unset( $types[ $exclude ] );
					}
				}
			}
		}

		return $types;
	}

	/**
	 * Get the post types for who SLA should load
	 *
	 * @return array|string[]|WP_Post_Type[]
	 */
	public function getSLAPostTypes() {
		$types = get_post_types( array( 'public' => true ) );

		//Exclude types for SLA
		$excludes = SQ_Classes_Helpers_Tools::getOption( 'sq_sla_exclude_post_types' );
		if ( ! empty( $types ) && ! empty( $excludes ) ) {
			foreach ( $excludes as $exclude ) {
				if ( $exclude ) {
					if ( in_array( $exclude, $types ) ) {
						unset( $types[ $exclude ] );
					}
				}
			}
		}

		return $types;
	}

	/**
	 * Search for posts in the local blog
	 *
	 * @param array $args
	 *
	 * @return array|WP_Error
	 */
	public function searchPost( $args ) {
		wp_reset_query();
		$wp_query = new WP_Query( $args );

		return $wp_query->get_posts();
	}

	/**
	 * Check if innerlink exist in content for the current keyword
	 *
	 * @param string $content
	 * @param string $keyword
	 * @param int $to_post_id
	 *
	 * @return bool
	 */
	public function checkInnerLink( $content, $keyword, $to_post_id ) {

		$found = 0;

		$link_ruleset = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Innerlinks_Ruleset' );
		$link_ruleset->addRule( $keyword, $to_post_id, 0, 0 );

		/** @var SQ_Models_Innerlinks_Replacement $replacement */
		$replacement = SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Replacement' );

		$replacement->setContent( $content );
		$replacement->setRuleset( $link_ruleset );
		if ( $count = $replacement->getCountByRulset() ) {
			if ( isset( $count['link_keyword'] ) && ! empty( $count['link_keyword'] ) ) {
				if ( isset( $count['link_keyword'][ $keyword ] ) ) {
					$found = (int) $count['link_keyword'][ $keyword ];
				} else {
					$found = 1;
				}
			}
		}

		return $found;
	}

	/**
	 * Upload the image on server from version 2.0.4
	 *
	 * @param  $url
	 * @param bool $basename
	 *
	 * @return array|bool
	 */
	public function upload_image( $url, $basename ) {
		if ( strpos( $url, 'http' ) === false && strpos( $url, '//' ) !== false ) {
			$url = 'http:' . $url;
		}

		$filename = false;
		$response = wp_remote_get( $url, array( 'timeout' => 15 ) );
		$body     = wp_remote_retrieve_body( $response );
		$type     = wp_remote_retrieve_header( $response, 'content-type' );

		$extension = pathinfo( $url, PATHINFO_EXTENSION );
		$mimes     = get_allowed_mime_types();
		foreach ( $mimes as $extensions => $mime ) {
			if ( in_array( $extension, explode( '|', $extensions ) ) ) {
				$filename = $basename . '.' . $extension;
				break;
			}
		}
		if ( ! $filename ) {
			foreach ( $mimes as $extensions => $mime ) {
				if ( $mime == $type ) {
					$filename = $basename . '.' . current( explode( '|', $extensions ) );
					break;
				}
			}
		}

		if ( ! $filename ) {
			return false;
		}

		$file = wp_upload_bits( $filename, null, $body, null );

		if ( ! isset( $file['error'] ) || $file['error'] == '' ) {
			if ( isset( $file['url'] ) && $file['url'] <> '' ) {
				$file['filename'] = $filename;
				$file['type']     = $type;

				return $file;
			}
		}

		return false;
	}

	public function getTasks() {
		$sla_tasks = array(
			""                                               => array(
				'longtail_keyword' => array(
					'title' => esc_html__( "Keyword with 2 or more words", 'squirrly-seo' ),
					'help'  => esc_html__( "Even if a long tail keyword won't bring as many visitors as one keyword would, the traffic those keywords will bring will be better, and more focused towards what you're selling.", 'squirrly-seo' ),
				)
			),
			esc_html__( "Domain", 'squirrly-seo' )           => array(
				'pinguin_url' => array(
					'title' => esc_html__( "Keyword is present in the URL", 'squirrly-seo' ),
					'help'  => esc_html__( "The keywords must be present in the URL for a better ranking. You should  consider not to add a keyword more than once.", 'squirrly-seo' ),
				),
			),
			esc_html__( "Clean & Friendly", 'squirrly-seo' ) => array(
				'density_title'  => array(
					'title' => sprintf( esc_html__( "Title is Google Friendly %s: more keywords %s: over-optimized! %s", 'squirrly-seo' ), "<span id='sq_density_title_val'></span><span id='sq_density_title_low' style='display: none'>", "</span><span id='sq_density_title_high' style='display: none'>", "</span><span id='sq_density_title_longtail' style='display: none'></span><span id='sq_density_title_done' style='display: none'></span>" ),
					'help'  => esc_html__( "It calculates the right number of times your keyword should appear mentioned in the text and makes sure you do not over-optimize.", 'squirrly-seo' ),
				),
				'density'        => array(
					'title' => sprintf( esc_html__( "Content is Google Friendly %s: more keywords %s: over-optimized! %s", 'squirrly-seo' ), "<span id='sq_density_val'></span><span id='sq_density_low' style='display: none'>", "</span><span id='sq_density_high' style='display: none'>", "</span><span id='sq_density_done' style='display: none'></span>" ),
					'help'  => esc_html__( "It calculates the right number of times your keyword should appear mentioned in the text and makes sure you do not over-optimize", 'squirrly-seo' ),
				),
				'over_density'   => array(
					'title' => sprintf( esc_html__( "Over Optimization %s", 'squirrly-seo' ), "<span id='sq_over_density_val'></span><span id='sq_over_density_done' style='display: none'></span>" ),
					'help'  => esc_html__( "Checks if there are words in the whole text that appear way too many times", 'squirrly-seo' ),
				),
				'human_friendly' => array(
					'title' => sprintf( esc_html__( "Human Friendly %s", 'squirrly-seo' ), "<span id='sq_human_friendly_val'></span><span id='sq_human_friendly_done' style='display: none'></span>" ),
					'help'  => esc_html__( "Your readers (who are not search engine bots) should find a clear text, with a rich vocabulary, that takes into account some basic rules of writing: such as having an introduction, a conclusion (in which you state the topic you're writing about). Also, you can improve their reading experience by avoiding repetitions.", 'squirrly-seo' ),
				),
			),
			esc_html__( "Title", 'squirrly-seo' )            => array(
				'title'         => array(
					'title' => esc_html__( "Keywords are used in Title", 'squirrly-seo' ),
					'help'  => esc_html__( "The keywords need to appear in the title of the article", 'squirrly-seo' ),
				),
				'title_length'  => array(
					'title' => esc_html__( "Title length is between 10-75 chars", 'squirrly-seo' ),
					'help'  => esc_html__( "The optimum length for Title is between 10-75 chars on major search engines.", 'squirrly-seo' ),
				),
				'pinguin_title' => array(
					'title' => esc_html__( "Title is different from domain name", 'squirrly-seo' ),
					'help'  => esc_html__( "Since the Google Penguin Update, the title must be different from the domain name, or you might get banned soon.", 'squirrly-seo' ),
				),
			),
			esc_html__( "Content", 'squirrly-seo' )          => array(
				'body'   => array(
					'title' => esc_html__( "Keywords are used in Content", 'squirrly-seo' ),
					'help'  => esc_html__( "The keyword must appear in the body of the article, at least once", 'squirrly-seo' ),
				),
				'strong' => array(
					'title' => sprintf( esc_html__( "Bold one of the keywords %s", 'squirrly-seo' ), '<strong><span class="sq_request_highlight_key" style="color:lightcoral; text-decoration:underline; cursor: pointer;"></span></strong>' ),
					'help'  => esc_html__( "Bolding your keywords will help search engines figure out what your content is about and what topic you cover. It's also useful for your Human readers to bold some of the most important ideas.", 'squirrly-seo' ),
				),
				'h2_6'   => array(
					'title' => esc_html__( "Keywords used in headline", 'squirrly-seo' ),
					'help'  => esc_html__( "The keywords should be used in headings like H2, H3, H4. Try NOT to use them all, for it will seem to be a SEO abuse. You can use your H2 button from the editor to do this. It works like the Bold, Italic or Underline buttons.", 'squirrly-seo' ),
				),
				'img'    => array(
					'title' => esc_html__( "Use image(s) in content or featured image", 'squirrly-seo' ),
					'help'  => esc_html__( "Articles need to be optimized for human beings as well, so you should place an image at the begining of your article.", 'squirrly-seo' ),
				),
				'alt'    => array(
					'title' => esc_html__( "Use keywords in the Alternative Text field of the image", 'squirrly-seo' ),
					'help'  => esc_html__( "Add at least one image in your article. Now use your keyword in the description of the image.  The Alternative Text field of the image.", 'squirrly-seo' ),
				),
			),
		);

		//for PHP 7.3.1 version
		$sla_tasks = array_filter( $sla_tasks );

		return $sla_tasks;
	}
}
