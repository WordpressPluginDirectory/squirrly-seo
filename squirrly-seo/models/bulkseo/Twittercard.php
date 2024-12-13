<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Bulkseo_Twittercard extends SQ_Models_Abstract_Assistant {

	protected $_category = 'twittercard';

	protected $_patterns;

	protected $_title_length;
	protected $_description_length;
	//
	protected $_tw_title;
	protected $_tw_description;
	protected $_tw_media;

	protected $_title_maxlength = 75;
	protected $_description_maxlength = 110;
	protected $_loadpatterns = true;

	const TITLE_MINLENGTH = 10;
	const DESCRIPTION_MINLENGTH = 10;
	const CHARS_ERROR = 5;

	public function init() {
		parent::init();

		$metas                        = json_decode( wp_json_encode( SQ_Classes_Helpers_Tools::getOption( 'sq_metas' ) ) );
		$this->_title_maxlength       = (int) $metas->tw_title_maxlength;
		$this->_description_maxlength = (int) $metas->tw_description_maxlength;

		//Get all the patterns
		$this->_patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );

		//For post types who are not in automation, add the custom patterns
		if ( ! isset( $this->_patterns[ $this->_post->post_type ] ) ) {
			$this->_patterns[ $this->_post->post_type ] = $this->_patterns['custom'];
		}

		if ( $this->_post->sq_adm->tw_title == '' || $this->_post->sq_adm->tw_description == '' ) {
			$this->_pattern = true;
		}

		$this->_tw_title       = ( $this->_post->sq->tw_title <> '' ? $this->_post->sq->tw_title : SQ_Classes_Helpers_Sanitize::truncate( $this->_post->sq->title, self::TITLE_MINLENGTH, $this->_post->sq->tw_title_maxlength ) );
		$this->_tw_description = ( $this->_post->sq->tw_description <> '' ? $this->_post->sq->tw_description : SQ_Classes_Helpers_Sanitize::truncate( $this->_post->sq->description, self::DESCRIPTION_MINLENGTH, $this->_post->sq->tw_description_maxlength ) );

		if ( function_exists( 'mb_strlen' ) ) {
			$this->_title_length       = SQ_Classes_Helpers_Sanitize::decodeEntity( $this->_tw_title );
			$this->_description_length = SQ_Classes_Helpers_Sanitize::decodeEntity( $this->_tw_description );
		} else {
			$this->_title_length       = SQ_Classes_Helpers_Sanitize::decodeEntity( $this->_tw_title );
			$this->_description_length = SQ_Classes_Helpers_Sanitize::decodeEntity( $this->_tw_description );
		}

		$this->_tw_media = $this->_post->sq->tw_media;
		if ( $this->_tw_media == '' ) {
			$images = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Services_OpenGraph' )->getPostImages();
			if ( ! empty( $images ) ) {
				$image = current( $images );
				if ( isset( $image['src'] ) ) {
					$this->_tw_media = $image['src'];
				}
			} elseif ( SQ_Classes_Helpers_Tools::getOption( 'sq_tc_image' ) ) {
				$this->_tw_media = SQ_Classes_Helpers_Tools::getOption( 'sq_tc_image' );
			}
		}
	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'title_empty'        => array(
				'title'       => esc_html__( "TC title not empty", 'squirrly-seo' ),
				'value'       => $this->_tw_title,
				'description' => sprintf( esc_html__( "You need to have a title for the Twitter Card of this post. %s It will help you control the way your post looks when it's shared on Twitter. %s It's also important for SEO purposes.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
			'title_length'       => array(
				'title'       => sprintf( esc_html__( "TC title up to %s chars", 'squirrly-seo' ), $this->_title_maxlength ),
				'value'       => $this->_title_length . ' ' . esc_html__( "chars", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Title has to be longer than %s chars and up to %s chars. %s You can change the title max length from %s Automation > META Lengths %s.", 'squirrly-seo' ), self::TITLE_MINLENGTH, $this->_title_maxlength, '<br /><br />', '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'settings' )) . '">', '</a>' ),
			),
			'description_empty'  => array(
				'title'       => esc_html__( "TC Description not empty", 'squirrly-seo' ),
				'value'       => $this->_tw_description,
				'description' => sprintf( esc_html__( "You need to have a Twitter Card description for this post. %s It will help you control the way your post looks when people share this URL on Twitter. Good copyrighting on your Twitter Card description will attract more clicks to your site. %s It's also important for SEO purposes.", 'squirrly-seo' ), '<br /><br />', '<br /><br />' ),
			),
			'description_length' => array(
				'title'       => sprintf( esc_html__( "TC description up to %s chars", 'squirrly-seo' ), $this->_description_maxlength ),
				'value'       => $this->_description_length . ' ' . esc_html__( "chars", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Description has to be longer than %s chars and up to %s chars. %s You can change the description max length from %s Automation > META Lengths %s.", 'squirrly-seo' ), self::DESCRIPTION_MINLENGTH, $this->_description_maxlength, '<br /><br />', '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'settings' )) . '">', '</a>' ),
			),
			'image'              => array(
				'title'       => esc_html__( "TC Image", 'squirrly-seo' ),
				'value'       => ( $this->_post->sq->tw_media <> '' ? $this->_post->sq->tw_media : ( $this->_post->post_attachment <> '' ? esc_html__( "(featured image)", 'squirrly-seo' ) . ' ' . $this->_post->post_attachment : '' ) ),
				'description' => sprintf( esc_html__( "Set a good looking image for your URL. It needs to look good in Twitter feeds when people will share this URL. %s A great image will attract more clicks to your site.", 'squirrly-seo' ), '<br /><br />' ),
			),
		);


	}

	/**
	 * Return the Category Tile
	 *
	 * @param  $title
	 *
	 * @return string
	 */
	public function getTitle( $title ) {
		if ( $this->_error ) {
			return esc_html__( "Twitter Card is deactivated.", 'squirrly-seo' );
		}

		foreach ( $this->_tasks[ $this->_category ] as $task ) {
			if ( $task['completed'] === false ) {
				return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
			}
		}

		if ( $this->_pattern ) {
			return esc_html__( "Twitter Card is generated automatically.", 'squirrly-seo' );
		}

		return esc_html__( "Twitter Card is customized and set correctly.", 'squirrly-seo' );

	}

	/**
	 * Show Current Post
	 *
	 * @return string
	 */
	public function getHeader() {
		$header = '<li class="completed">' . $this->getCurrentURL( $this->_post->url ) . '</li>';

		return $header;
	}

	/**
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkTitle_empty( $task ) {
		$errors = array();
		if ( ! $this->_post->sq->doseo ) {
			$errors[] = esc_html__( "Squirrly Snippet is deactivated from this post.", 'squirrly-seo' );
		}

		if ( ! $this->_post->sq->do_twc ) {
			$errors[] = sprintf( esc_html__( "Twitter Card for this post type is deactivated from %s Automation > Configuration %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . $this->_post->post_type) . '" >', '</a>' );
		}

		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
			$errors[] = sprintf( esc_html__( "Twitter Card is deactivated from %s Technical SEO > Social Media %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' )) . '" >', '</a>' );
		}

		if ( ! empty( $errors ) ) {
			$task['error_message'] = join( '<br />', $errors );
			$task['error']         = true;
		}

		if ( $this->_post->sq_adm->tw_title == '' ) {
			$task['error_message'] = esc_html__( "Title is generated automatically.", 'squirrly-seo' );
			$task['pattern']       = true;
		}

		$task['completed'] = ( $this->_tw_title <> '' );

		return $task;
	}

	/**
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkTitle_length( $task ) {
		if ( ! $this->_post->sq->doseo ) {
			$errors[] = esc_html__( "Squirrly Snippet is deactivated from this post.", 'squirrly-seo' );
		}

		if ( ! $this->_post->sq->do_twc ) {
			$errors[] = sprintf( esc_html__( "Twitter Card for this post type is deactivated from %s Automation > Configuration %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . $this->_post->post_type) . '" >', '</a>' );
		}

		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
			$errors[] = sprintf( esc_html__( "Twitter Card is deactivated from %s Technical SEO > Social Media %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' )) . '" >', '</a>' );
		}

		if ( ! empty( $errors ) ) {
			$task['error_message'] = join( '<br />', $errors );
			$task['error']         = true;
		}

		if ( $this->_post->sq_adm->tw_title == '' ) {
			$task['error_message'] = esc_html__( "Title is generated automatically.", 'squirrly-seo' );
			$task['pattern']       = true;
		}

		$task['completed'] = ( $this->_title_length > self::TITLE_MINLENGTH && $this->_title_length < ( (int) $this->_title_maxlength + self::CHARS_ERROR ) );

		return $task;
	}

	public function checkDescription_empty( $task ) {
		if ( ! $this->_post->sq->doseo ) {
			$errors[] = esc_html__( "Squirrly Snippet is deactivated from this post.", 'squirrly-seo' );
		}

		if ( ! $this->_post->sq->do_twc ) {
			$errors[] = sprintf( esc_html__( "Twitter Card for this post type is deactivated from %s Automation > Configuration %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . $this->_post->post_type) . '" >', '</a>' );
		}

		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
			$errors[] = sprintf( esc_html__( "Twitter Card is deactivated from %s Technical SEO > Social Media %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' )) . '" >', '</a>' );
		}

		if ( ! empty( $errors ) ) {
			$task['error_message'] = join( '<br />', $errors );
			$task['error']         = true;
		}

		if ( $this->_post->sq_adm->tw_description == '' ) {
			$task['error_message'] = esc_html__( "Description is generated automatically.", 'squirrly-seo' );
			$task['pattern']       = true;
		}

		$task['completed'] = ( $this->_tw_description <> '' );

		return $task;
	}

	/**
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkDescription_length( $task ) {
		if ( ! $this->_post->sq->doseo ) {
			$errors[] = esc_html__( "Squirrly Snippet is deactivated from this post.", 'squirrly-seo' );
		}

		if ( ! $this->_post->sq->do_twc ) {
			$errors[] = sprintf( esc_html__( "Twitter Card for this post type is deactivated from %s Automation > Configuration %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . $this->_post->post_type) . '" >', '</a>' );
		}

		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
			$errors[] = sprintf( esc_html__( "Twitter Card is deactivated from %s Technical SEO > Social Media %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' )) . '" >', '</a>' );
		}

		if ( ! empty( $errors ) ) {
			$task['error_message'] = join( '<br />', $errors );
			$task['error']         = true;
		}

		if ( $this->_post->sq_adm->tw_description == '' ) {
			$task['error_message'] = esc_html__( "Description is generated automatically.", 'squirrly-seo' );
			$task['pattern']       = true;
		}

		$task['completed'] = ( $this->_description_length > self::DESCRIPTION_MINLENGTH && $this->_description_length < ( (int) $this->_description_maxlength + self::CHARS_ERROR ) );

		return $task;
	}

	/**
	 * API Keyword Research
	 *
	 * @return bool|WP_Error
	 */
	public function checkImage( $task ) {
		if ( ! $this->_post->sq->doseo ) {
			$errors[] = esc_html__( "Squirrly Snippet is deactivated from this post.", 'squirrly-seo' );
		}

		if ( ! $this->_post->sq->do_twc ) {
			$errors[] = sprintf( esc_html__( "Twitter Card for this post type is deactivated from %s Automation > Configuration %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ) . '#tab=sq_' . $this->_post->post_type) . '" >', '</a>' );
		}

		if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ) {
			$errors[] = sprintf( esc_html__( "Twitter Card is deactivated from %s Technical SEO > Social Media %s.", 'squirrly-seo' ), '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' )) . '" >', '</a>' );
		}

		if ( ! empty( $errors ) ) {
			$task['error_message'] = join( '<br />', $errors );
			$task['error']         = true;
		}


		$task['completed'] = ( $this->_tw_media <> '' );

		return $task;

	}


}
