<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Domain_Sq extends SQ_Models_Abstract_Domain {

	/** @var int current post id */
	protected $_post_id;

	protected $_doseo;
	protected $_do_metas;
	protected $_do_sitemap;
	protected $_do_jsonld;
	protected $_do_pattern;
	protected $_do_og;
	protected $_do_twc;
	protected $_do_analytics;
	protected $_do_fpixel;
	protected $_do_redirects;

	protected $_noindex;
	protected $_nofollow;
	protected $_nositemap;
	//
	protected $_title;
	protected $_description;
	protected $_keywords;
	protected $_canonical;
	protected $_primary_category;

	protected $_robots;
	protected $_focuspage;
	//
	protected $_tw_media;
	protected $_tw_title;
	protected $_tw_description;
	protected $_tw_type;
	//
	protected $_og_title;
	protected $_og_description;
	protected $_og_author;
	protected $_og_type;
	protected $_og_media;

	protected $_jsonld;
	protected $_jsonld_type;
	protected $_jsonld_types;
	protected $_fpixel;

	protected $_redirect;
	protected $_redirect_type;

	// lengths
	protected $_title_maxlength;
	protected $_description_maxlength;
	protected $_og_title_maxlength;
	protected $_og_description_maxlength;
	protected $_tw_title_maxlength;
	protected $_tw_description_maxlength;
	protected $_jsonld_title_maxlength;
	protected $_jsonld_description_maxlength;

	// for sq_adm patterns
	protected $_patterns;
	//get custom post type separator
	protected $_sep;

	//Keywords, Optimizations and Innerlinks
	protected $_optimizations;
	protected $_innerlinks;

	/**
	 * Check the Title from postmeta if exists
	 *
	 * @return mixed
	 */
	public function getTitle() {
		//Check if there is import on custom values for Squirrly SEO
		if ( empty( $this->_title ) && ! empty( $this->post_id ) && (int) $this->post_id > 0 ) {
			if ( $title = get_post_meta( $this->post_id, '_sq_title', true ) ) {
				$this->_title = $title;
			}
		}

		return $this->_title;
	}

	/**
	 * Check the Description from postmeta if exists
	 *
	 * @return mixed
	 */
	public function getDescription() {
		//Check if there is import on custom values for Squirrly SEO
		if ( empty( $this->_description ) && ! empty( $this->post_id ) && (int) $this->post_id > 0 ) {
			if ( $description = get_post_meta( $this->post_id, '_sq_description', true ) ) {
				$this->_description = $description;
			}
		}

		return $this->_description;
	}

	public function getTitle_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['title_maxlength'];
	}

	public function getDescription_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['description_maxlength'];
	}

	public function getOg_title_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['og_title_maxlength'];
	}

	public function getOg_description_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['og_description_maxlength'];
	}

	public function getTw_title_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['tw_title_maxlength'];
	}

	public function getTw_description_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['tw_description_maxlength'];
	}

	public function getJsonld_title_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['jsonld_title_maxlength'];
	}

	public function getJsonld_description_maxlength() {
		$metas = SQ_Classes_Helpers_Tools::getOption( 'sq_metas' );

		return $metas['jsonld_description_maxlength'];
	}

	public function getDoseo() {
		if ( ! isset( $this->_doseo ) ) {
			$this->_doseo = 1;
		}

		return (int) $this->_doseo;
	}

	public function getNoindex() {
		if ( ! isset( $this->_noindex ) ) {
			$this->_noindex = 0;
		}

		if ( $this->_noindex === 'yes' ) {
			$this->_noindex = 1;
		}

		return (int) $this->_noindex;
	}


	public function getNositemap() {
		if ( ! isset( $this->_nositemap ) ) {
			$this->_nositemap = 0;
		}

		return (int) $this->_nositemap;
	}

	public function getNofollow() {
		if ( ! isset( $this->_nofollow ) ) {
			$this->_nofollow = 0;
		}

		if ( $this->_nofollow === 'yes' ) {
			$this->_nofollow = 1;
		}

		return (int) $this->_nofollow;
	}

	public function getClearedTitle() {
		if ( isset( $this->_title ) ) {
			$this->_title = SQ_Classes_Helpers_Sanitize::clearTitle( $this->_title );
		}

		return $this->_title;
	}

	public function getClearedDescription() {
		if ( isset( $this->_description ) ) {
			$this->_description = SQ_Classes_Helpers_Sanitize::clearDescription( $this->_description );
		}

		return $this->_description;
	}

	/**
	 * Clear and format the title for all languages
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
	 *
	 * @param  $description
	 *
	 * @return mixed|string
	 */
	public function clearDescription( $description ) {
		return SQ_Classes_Helpers_Sanitize::clearDescription( $description );
	}

	public function getKeywords() {
		if ( $this->_keywords == '' ) {
			if ( ! empty( $this->_optimizations ) ) {
				$keywords        = array_column( (array) $this->_optimizations, 'keyword' );
				$keywords        = array_filter( $keywords );
				$keywords        = array_unique( $keywords );
				$this->_keywords = join( ',', $keywords );
			} elseif ( ! empty( $this->post_id ) && (int) $this->post_id > 0 ) {
				if ( $keywords = get_post_meta( $this->post_id, '_sq_keywords', true ) ) {
					if(is_array($keywords)){
						$keywords = join( ',', $keywords );
					}
					$this->_keywords = $keywords;
				}
			}
		}

		if ( $this->_keywords <> '' && strpos( $this->_keywords, ',' ) !== false ) {
			$keywords        = explode( ',', $this->_keywords );
			$keywords        = array_unique( $keywords );
			$this->_keywords = join( ',', $keywords );
		}

		return $this->_keywords;
	}

	public function getAutomation() {
		return array(
			'doseo'        => $this->doseo,
			'do_metas'     => $this->do_metas,
			'do_sitemap'   => $this->do_sitemap,
			'do_jsonld'    => $this->do_jsonld,
			'do_pattern'   => $this->do_pattern,
			'do_og'        => $this->do_og,
			'do_twc'       => $this->do_twc,
			'do_analytics' => $this->do_analytics,
			'do_fpixel'    => $this->do_fpixel,
			'do_redirects' => $this->do_redirects,
		);
	}

	/**
	 * Set the redirect code
	 * Default 301 redirects
	 *
	 * @return int
	 */
	public function getRedirect_type() {
		if ( ! isset( $this->_redirect_type ) ) {
			$this->_redirect_type = 301;
		}

		return (int) $this->_redirect_type;
	}

	public function toArray() {
		return array(
			'doseo'     => $this->doseo,
			//
			'noindex'   => $this->noindex,
			'nofollow'  => $this->nofollow,
			'nositemap' => $this->nositemap,
			//

			'title'            => $this->title,
			'description'      => $this->description,
			'keywords'         => $this->keywords,
			'canonical'        => $this->canonical,
			'primary_category' => $this->primary_category,
			'redirect'         => $this->redirect,
			'redirect_type'    => $this->redirect_type,
			'robots'           => $this->robots,
			'focuspage'        => $this->focuspage,
			//
			'tw_media'         => $this->tw_media,
			'tw_title'         => $this->tw_title,
			'tw_description'   => $this->tw_description,
			'tw_type'          => $this->tw_type,
			//
			'og_title'         => $this->og_title,
			'og_description'   => $this->og_description,
			'og_author'        => $this->og_author,
			'og_type'          => $this->og_type,
			'og_media'         => $this->og_media,

			'jsonld'       => $this->_jsonld,
			'jsonld_types' => $this->jsonld_types,
			'fpixel'       => $this->_fpixel,

			'patterns'      => $this->patterns,
			'sep'           => $this->sep,
			'optimizations' => $this->optimizations,
			'innerlinks'    => $this->innerlinks,
		);
	}
}
