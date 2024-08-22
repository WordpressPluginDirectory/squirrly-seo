<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

abstract class SQ_Models_Abstract_Seo {

	protected $_post;
	protected $_author;
	protected $_patterns;
	protected $_sq_use;

	public function __construct() {
		$this->_post   = SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->getPost();
		$this->_sq_use = true;
	}

	/**
	 * Set the Post in SEO Class
	 *
	 * @param SQ_Models_Domain_Post $post
	 */
	public function setPost( $post ) {
		$this->_post = $post;
	}

	/****************************
	 *
	 * CLEAR THE VALUES
	 *************************************/
	/***********************************************************************************/
	/**
	 * Clear and format the title for all languages
	 * Called from services hooks
	 *
	 * @param  $title
	 *
	 * @return string
	 */
	public function clearTitle( $title ) {
		return SQ_Classes_Helpers_Sanitize::clearTitle( $title );
	}

	/**
	 * Clear and format the description for all languages
	 * Called from services hooks
	 *
	 * @param  $description
	 *
	 * @return mixed|string
	 */
	public function clearDescription( $description ) {
		return SQ_Classes_Helpers_Sanitize::clearDescription( $description );
	}

	/**
	 * Clear the Keywords
	 * Called from services hooks
	 *
	 * @param  $keywords
	 *
	 * @return mixed|null|string|string[]
	 */
	public function clearKeywords( $keywords ) {
		if ( $keywords <> '' ) {
			return SQ_Classes_Helpers_Sanitize::clearTitle( $keywords );
		}

		return $keywords;
	}

	/**
	 * Get the author
	 *
	 * @param string $what
	 *
	 * @return bool|mixed|string
	 */
	protected function getAuthor( $what = 'user_nicename' ) {

		if ( ! isset( $this->_author ) ) {
			if ( is_author() ) {
				$this->_author = get_userdata( get_query_var( 'author' ) );
			} elseif ( isset( $this->_post->post_author ) ) {
				if ( $author = get_userdata( (int) $this->_post->post_author ) ) {
					$this->_author = $author->data;
				}
			}
		}


		if ( isset( $this->_author ) && isset( $this->_author->$what ) ) {

			if ( $what == 'user_url' && $this->_author->$what == '' ) {
				return get_author_posts_url( $this->_author->ID, $this->_author->user_nicename );
			}

			return $this->_author->$what;
		}

		return false;
	}

	/**
	 * Get the image from post
	 *
	 * @param boolean $all take all the images or stop at the first one
	 *
	 * @return array
	 * @return array
	 */
	public function getPostImages( $all = false ) {
		$images = array();
		$title  = $excerpt = '';

		if ( ! isset( $this->_post->ID ) || (int) $this->_post->ID == 0 ) {
			return $images;
		}

		if ( wp_attachment_is_image( $this->_post->ID ) ) {
			$attachment = get_post( $this->_post->ID );
			$title      = ( ( isset( $attachment->post_title ) && strlen( $attachment->post_title ) > 10 ) ? $attachment->post_title : '' );
			$excerpt    = ( ( isset( $attachment->post_excerpt ) ? $attachment->post_excerpt : ( isset( $attachment->post_content ) ) ) ? $attachment->post_content : '' );
		} elseif ( has_post_thumbnail( $this->_post->ID ) ) {
			$attachment = get_post( get_post_thumbnail_id( $this->_post->ID ) );
			$title      = ( ( isset( $attachment->post_title ) && strlen( $attachment->post_title ) > 10 ) ? $attachment->post_title : '' );
			$excerpt    = ( ( isset( $attachment->post_excerpt ) ? $attachment->post_excerpt : ( isset( $attachment->post_content ) ) ) ? $attachment->post_content : '' );
		}

		if ( isset( $attachment->ID ) ) {
			$url = wp_get_attachment_image_src( $attachment->ID, 'full' );

			if ( isset( $url[0] ) ) {
				$images[] = array(
					'src'         => esc_url( $url[0] ),
					'title'       => SQ_Classes_Helpers_Sanitize::clearTitle( $title ),
					'description' => SQ_Classes_Helpers_Sanitize::clearDescription( $excerpt ),
					'width'       => $url[1],
					'height'      => $url[2],
				);
			}
		}

		if ( $all || empty( $images ) ) {
			if ( isset( $this->_post->post_content ) ) {
				preg_match( '/<img[^>]*src="([^"]*)"[^>]*>/i', $this->_post->post_content, $match );

				if ( ! empty( $match ) ) {
					preg_match( '/alt="([^"]*)"/i', $match[0], $alt );

					if ( strpos( $match[1], '//' ) === false && strpos( $match[1], 'data:image' ) === false ) {
						$match[1] = get_bloginfo( 'url' ) . $match[1];
					} elseif ( strpos( $match[1], '//' ) === 0 ) {
						$match[1] = ( SQ_SSL ? 'https:' : 'http:' ) . $match[1];
					}

					$images[] = array(
						'src'         => esc_url( $match[1] ),
						'title'       => SQ_Classes_Helpers_Sanitize::clearTitle( ! empty( $alt[1] ) ? $alt[1] : '' ),
						'description' => '',
						'width'       => '500',
						'height'      => null,
					);
				}
			}
		}


		return apply_filters( 'sq_post_images', $images );
	}

	/**
	 * @return mixed
	 */
	public function getImageType( $url = '' ) {

		if ( $url == '' || strpos( $url, '.' ) === false ) {
			return false;
		}

		$array     = explode( '.', $url );
		$extension = end( $array );

		$types = array(
			'gif'  => 'image/gif',
			'jpg'  => 'image/jpeg',
			'png'  => 'image/png',
			'bmp'  => 'image/bmp',
			'tiff' => 'image/tiff'
		);

		if ( array_key_exists( $extension, $types ) ) {
			return $types[ $extension ];
		}

		return false;
	}

	/**
	 * Get the video from content
	 *
	 * @param boolean $all take all the videos or stop at the first one
	 *
	 * @return array|false
	 */
	public function getPostVideos( $all = false ) {
		$videos    = array();
		$thumbnail = '';
		if ( ! isset( $this->_post->ID ) || (int) $this->_post->ID == 0 ) {
			return $videos;
		}

		$images = $this->getPostImages( true );
		if ( ! empty( $images ) ) {
			$image = current( $images );
			if ( isset( $image['src'] ) ) {
				$thumbnail = $image['src'];
			}
		}

		if ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'advanced-custom-fields/acf.php' ) ) {
			if ( isset( $this->_post->ID ) && $this->_post->ID ) {
				if ( $_sq_video = get_post_meta( $this->_post->ID, '_sq_video', true ) ) {

					//get the image from the YouTube video
					preg_match( '/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=))([^&\"\'<>\s]+)/i', $_sq_video, $match );
					if ( isset( $match[1] ) && $match[1] <> '' ) {
						$thumbnail = 'https://img.youtube.com/vi/' . $match[1] . '/hqdefault.jpg';
					}

					$videos[] = array(
						'thumbnail' => $thumbnail,
						'src'       => esc_url( $_sq_video ),
					);
				}
			}
		}

		//return first video found
		if ( ! $all && ! empty( $videos ) ) {
			return $videos;
		}

		if ( isset( $this->_post->post_content ) ) {

			preg_match( '/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed)\/)([^\?&\"\'<>\s]+)/i', $this->_post->post_content, $match );

			if ( isset( $match[0] ) ) {
				if ( strpos( $match[0], '//' ) !== false && strpos( $match[0], 'http' ) === false ) {
					$match[0] = 'https:' . $match[0];
				}
				$videos[] = array(
					'thumbnail' => $thumbnail,
					'src'       => esc_url( $match[0] ),
				);
			}

			//return first video found
			if ( ! $all && ! empty( $videos ) ) {
				return $videos;
			}

			preg_match_all( '/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=))([^&\"\'\<>\s]+)/i', $this->_post->post_content, $matches, PREG_SET_ORDER );

			if ( ! empty( $matches ) ) {
				foreach ( $matches as $match ) {
					if ( isset( $match[0] ) ) {

						if ( isset( $match[1] ) && $match[1] <> '' ) {
							$thumbnail = 'https://img.youtube.com/vi/' . $match[1] . '/hqdefault.jpg';

							$videos[ md5( $match[1] ) ] = array(
								'thumbnail' => $thumbnail,
								'src'       => 'https://www.youtube.com/embed/' . $match[1],
							);
						}
					}
				}

				//reset videos array keys
				if ( ! empty( $videos ) ) {
					$videos = array_values( $videos );
				}
			}

			//return first video found
			if ( ! $all && ! empty( $videos ) ) {
				return $videos;
			}

			preg_match( '/(?:http(?:s)?:\/\/)?(?:fwd4\.wistia\.com\/(?:medias)\/)([^\?&\"\'<>\s]+)/i', $this->_post->post_content, $match );

			if ( isset( $match[0] ) ) {
				$videos[] = array(
					'thumbnail' => $thumbnail,
					'src'       => esc_url( 'https://fast.wistia.net/embed/iframe/' . $match[1] ),
				);
			}

			//return first video found
			if ( ! $all && ! empty( $videos ) ) {
				return $videos;
			}

			preg_match( '/class=["|\']([^"\']*wistia_async_([^\?&\"\'<>\s]+)[^"\']*["|\'])/i', $this->_post->post_content, $match );

			if ( isset( $match[0] ) ) {
				$videos[] = array(
					'thumbnail' => $thumbnail,
					'src'       => esc_url( 'https://fast.wistia.net/embed/iframe/' . $match[2] ),
				);
			}

			//return first video found
			if ( ! $all && ! empty( $videos ) ) {
				return $videos;
			}

			preg_match( '/src=["|\']([^"\']*(.mpg|.mpeg|.mp4|.mov|.wmv|.asf|.avi|.ra|.ram|.rm|.flv)["|\'])/i', $this->_post->post_content, $match );

			if ( isset( $match[1] ) ) {
				$videos[] = array(
					'thumbnail' => $thumbnail,
					'src'       => esc_url( $match[1] ),
				);
			}

		}

		return apply_filters( 'sq_post_videos', $videos );
	}

	/**
	 * Check if is the homepage
	 *
	 * @return bool
	 */
	public function isHomePage() {
		return SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->isHomePage();
	}

	/**
	 * Get the current post from Frontend
	 *
	 * @return SQ_Models_Domain_Post
	 */
	public function getPost() {
		return SQ_Classes_ObjController::getClass( 'SQ_Models_Frontend' )->getPost();
	}

	public function returnFalse() {
		return false;
	}

	public function truncate( $text, $min = 100, $max = 110 ) {
		return SQ_Classes_Helpers_Sanitize::truncate( $text, $min, $max );
	}
}
