<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Image extends SQ_Models_Abstract_Assistant {

	protected $_category = 'image';

	protected $_keyword = false;
	protected $_images = array();

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		if ( isset( $this->_audit->data->sq_seo_keywords->value ) && $this->_audit->data->sq_seo_keywords->value <> '' ) {
			$this->_keyword = $this->_audit->data->sq_seo_keywords->value;
		}

		if ( isset( $this->_audit->data->sq_seo_open_graph->value ) && $this->_audit->data->sq_seo_open_graph->value <> '' ) {
			$og = json_decode( $this->_audit->data->sq_seo_open_graph->value );
			if ( isset( $og->image ) ) {
				$this->_images[] = $og->image;
			}
		}

		if ( isset( $this->_audit->data->sq_seo_twittercard->value ) && $this->_audit->data->sq_seo_twittercard->value <> '' ) {
			$tc = json_decode( $this->_audit->data->sq_seo_twittercard->value );
			if ( isset( $tc->image ) ) {
				$this->_images[] = $tc->image;
			}
		}

		if ( isset( $this->_audit->data->sq_seo_body->images ) && $this->_audit->data->sq_seo_body->images <> '' ) {
			$images = json_decode( $this->_audit->data->sq_seo_body->images );

			if ( ! empty( $images ) ) {
				foreach ( $images as $row ) {
					$this->_images[] = $row;
				}
			}
		}

		if ( $this->_post->post_content <> '' ) {
			@preg_match_all( '/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', stripslashes( $this->_post->post_content ), $out );

			if ( ! empty( $out ) ) {
				if ( is_array( $out[1] ) && count( (array) $out[1] ) > 0 ) {
					foreach ( $out[1] as $row ) {
						$this->_images[] = $row;
					}
				}

			}
		}

		if ( ! empty( $this->_images ) ) {
			//remove duplicates
			$this->_images = array_unique( $this->_images );

			//limit the array
			if ( count( $this->_images ) > 20 ) {
				$this->_images = array_slice( $this->_images, 0, 20 );
			}
		}

	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'filename' => array(
				'title'       => esc_html__( "Keyword in filename", 'squirrly-seo' ),
				'value'       => ( ! empty( $this->_images ) ? join( '<br />', $this->_images ) : '' ),
				'penalty'     => 5,
				'description' => sprintf( esc_html__( "Your filename for one of the images in this Focus Page should be: %s keyword.jpg %s Download a relevant image from your page. Change the filename. Then re-upload with the SEO filename and add it your page's content again. %s It's best to keep this at only one filename which contains the main keyword of the page. %s Why? %s Because Google could consider over-optimization if you used it more than once.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
		);

	}

	/**
	 * @param  $content
	 * @param  $task
	 *
	 * @return string
	 */
	public function getHeader() {
		$edit_link = '';
		$header    = '<li class="completed">';
		$header    .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header    .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header    .= '</li>';

		$header .= '<li class="completed">';
		if ( $this->_keyword ) {
			$header .= $this->getUsedKeywords();

			if ( isset( $this->_post->ID ) ) {
				if ( isset( $this->_post->ID ) ) {
					$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'post.php?post=' . (int) $this->_post->ID . '&action=edit' );
				}
				$header .= '<a href="' . $edit_link . '&keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword( $this->_keyword, 'url' ) . '" target="_blank" class="sq_research_selectit btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Optimize for this", 'squirrly-seo' ) . '</a>';
			}
		} else {
			$header .= '<div class="font-weight-bold text-black-50 m-0 px-3 text-center">' . esc_html__( "No Keyword found in Squirrly Live Assistant", 'squirrly-seo' ) . '</div>';
			$header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Do a research", 'squirrly-seo' ) . '</a>';
			if ( isset( $this->_post->ID ) ) {
				$edit_link = SQ_Classes_Helpers_Tools::getAdminUrl( 'post.php?post=' . (int) $this->_post->ID . '&action=edit' );
				if ( $this->_post->post_type <> 'profile' ) {
					$edit_link = get_edit_post_link( $this->_post->ID, false );
				}
				$header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Optimize for a keyword", 'squirrly-seo' ) . '</a>';
			}
		}

		$header .= '</li>';

		return $header;
	}

	public function getTitle( $title ) {

		if ( ! $this->_completed && ! $this->_indexed ) {
			foreach ( $this->_tasks[ $this->_category ] as $task ) {
				if ( $task['completed'] === false ) {
					return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
				}
			}
		}

		return parent::getTitle( $title );
	}
	/*********************************************/

	/**
	 * Check if the keyword is in the file name | API keyword in filename
	 *
	 * @return bool
	 */
	public function checkFilename( $task ) {
		$task['completed'] = false;

		if ( ! $this->_keyword ) {
			$this->_tasks[ $this->_category ]['filename']['description'] = sprintf( esc_html__( "Optimize the post first using a Keyword from Squirrly Briefcase", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) . '" target="_blank">', '</a>' );
			$task['error_message']                                       = esc_html__( "No image found", 'squirrly-seo' );
			$task['completed']                                           = false;
		} elseif ( ! empty( $this->_images ) ) {
			$keyword = html_entity_decode( $this->_keyword, ENT_QUOTES, 'UTF-8' );
			$keyword = preg_replace( '~[^\p{L}\p{N}\n]+~u', ' ', $keyword );
			$keyword = preg_replace( '/\s{2,}/', ' ', $keyword );
			$words   = explode( ' ', $keyword );
			foreach ( $this->_images as $image ) {

				//get only the image filename
				if ( strrpos( $image, '/' ) !== false && substr( $image, strrpos( $image, '/' ) + 1 ) <> '' ) {
					$image = substr( $image, strrpos( $image, '/' ) + 1 );
				}

				//Check if all words are present in the image URL
				$allwords = true;
				foreach ( $words as $word ) {
					//Find the string with normalization
					if ( $word <> '' && SQ_Classes_Helpers_Tools::findStr( $image, $word, true ) === false ) {
						$allwords = false;
					}
				}
				//Complete task if all words are found
				if ( $allwords ) {
					$task['completed'] = true;
					break;
				}
			}
		}

		return $task;
	}

}
