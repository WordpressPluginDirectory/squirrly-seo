<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Services_Redirects extends SQ_Models_Abstract_Seo {


	public function __construct() {
		parent::__construct();

		//Do not load for admin backend
		if ( is_admin() || is_network_admin() ) {
			return;
		}

		//Check for changed permalink in the Posts and redirect the article to the new URL
		$this->redirectPermalinks();

		//Check if snippet redirect for this post type
		$this->redirectSnippet();

		//check if not found permalink
		$this->redirectNotFound();

	}

	/**
	 * Check if is set redirect in snippet
	 *
	 * @return void
	 */
	private function redirectSnippet() {
		if ( isset( $this->_post->sq->doseo ) && $this->_post->sq->doseo ) {

			if ( isset( $this->_post->sq->redirect ) && isset( $this->_post->sq->redirect_type ) ) {
				$this->_post->sq->redirect_type = (int) $this->_post->sq->redirect_type;
				if ( $this->_post->sq->redirect <> '' && in_array( $this->_post->sq->redirect_type, array(
						301,
						302,
						307
					) ) ) {
					switch ( $this->_post->sq->redirect_type ) {
						case 301:
							header( 'HTTP/1.1 301 Moved Permanently' );
							break;
						case 302:
							header( 'HTTP/1.1 302 Moved Temporarily' );
							break;
						case 307:
							header( 'HTTP/1.1 307 Moved Temporarily' );
							break;
					}
					header( 'X-Redirect-By: Squirrly SEO' );
					header( 'Location: ' . $this->_post->sq->redirect, true, $this->_post->sq->redirect_type );
					exit();
				}
			}
		}
	}

	/**
	 * Check for changed permalink in the Posts and redirect the article to the new URL
	 */
	private function redirectPermalinks() {
		if ( is_404() && isset( $_SERVER['REQUEST_URI'] ) ) {
			$query_string = false;
			$url_request  = strtolower( urldecode( $_SERVER['REQUEST_URI'] ) );
			$patterns     = (array) SQ_Classes_Helpers_Tools::getOption( 'patterns' );

			if ( parse_url( $url_request, PHP_URL_PATH ) ) {
				if ( strpos( $url_request, '?' ) ) {
					$query_string = explode( '?', $url_request );
					$query_string = ( isset( $query_string[1] ) ) ? $query_string[1] : false;
				}

				$url_request = basename( trim( parse_url( $url_request, PHP_URL_PATH ), '/' ) );

				global $wpdb;
				if ( $url_request <> '' ) {
					if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT post_id FROM `$wpdb->postmeta` WHERE `meta_key` = %s AND `meta_value` = %s", '_sq_old_slug', $url_request ) ) ) {
						if ( $post = get_post( $row->post_id ) ) {
							if ( $post->post_status == 'publish' ) {
								if ( isset( $patterns[ $post->post_type ]['do_redirects'] ) && $patterns[ $post->post_type ]['do_redirects'] ) {
									if ( $permalink = get_permalink( $row->post_id ) ) {
										$permalink = ( $query_string ) ? $permalink . "?" . $query_string : $permalink;

										header( 'HTTP/1.1 301 Moved Permanently' );
										header( 'X-Redirect-By: Squirrly SEO' );
										header( 'Location: ' . $permalink, true, 301 );
										exit();
									}
								}
							}
						}
					} elseif ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM `$wpdb->posts` WHERE `post_status` = %s AND `post_name` = %s", 'trash', $url_request . '__trashed' ) ) ) {
						$this->_post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->setPostByID( $row->id );
					}
				}
			}

		}
	}

	/**
	 * Check for not found permalinks
	 */
	private function redirectNotFound() {

		if ( is_404() && isset( $_SERVER['REQUEST_URI'] ) ) {
			//If there is no post found but the redirects are set for 404
			if ( isset( $this->_post->sq->do_redirects ) && $this->_post->sq->do_redirects && SQ_Classes_Helpers_Tools::getOption( '404_url_redirect' ) ) {

				header( 'X-Redirect-By: Squirrly SEO' );

				//check the default redirect URL and prevent loop redirects
				if ( parse_url( SQ_Classes_Helpers_Tools::getOption( '404_url_redirect' ), PHP_URL_PATH ) <> $_SERVER['REQUEST_URI'] ) {
					header( 'Location: ' . SQ_Classes_Helpers_Tools::getOption( '404_url_redirect' ), true, 301 );
				} else {
					header( 'Location: ' . home_url(), true, 301 );
				}
				exit();
			}
		}

	}

}
