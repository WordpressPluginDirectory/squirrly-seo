<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Services_DublinCore extends SQ_Models_Abstract_Seo {

	public function __construct() {
		parent::__construct();

		if ( isset( $this->_post->sq->doseo ) && $this->_post->sq->doseo ) {
			if ( ! $this->_post->sq->do_metas ) {
				add_filter( 'sq_dublin_core', array( $this, 'returnFalse' ) );

				return;
			}

			add_filter( 'sq_locale', array( $this, 'setLocale' ) );
			add_filter( 'sq_dublin_core', array( $this, 'generateMeta' ) );
			add_filter( 'sq_dublin_core', array( $this, 'packMeta' ), 99 );
		} else {
			add_filter( 'sq_dublin_core', array( $this, 'returnFalse' ) );
		}

	}

	/**
	 * Get all metas for Dublin Core
	 *
	 * @param string $metas
	 *
	 * @return string
	 */
	public function generateMeta( $metas ) {
		if ( ! $metas ) {
			$metas = array();
		}

		$locale = apply_filters( 'sq_locale', get_locale() );
		if ( $locale <> '' ) {
			$metas['dc.language']     = ( strpos( $locale, '_' ) !== false ? substr( $locale, 0, strpos( $locale, '_' ) ) : $locale );
			$metas['dc.language.iso'] = $locale;
		}

		$name = '';
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_global_person' ) ) {
			$jsonld = SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld' );
			if ( isset( $jsonld['Person']['name'] ) && $jsonld['Person']['name'] <> '' ) {
				$name = $jsonld['Person']['name'];
			}
		} elseif ( ! $name = $this->getAuthor( 'display_name' ) ) {
			$name = get_bloginfo( 'name' );
		}

		if ( $name <> '' ) {
			$metas['dc.publisher'] = $name;
		}
		if ( $this->_post->sq->title <> '' ) {
			$metas['dc.title'] = SQ_Classes_Helpers_Sanitize::clearTitle( $this->_post->sq->title );
		}
		if ( $this->_post->sq->description <> '' ) {
			$metas['dc.description'] = SQ_Classes_Helpers_Sanitize::clearDescription( $this->_post->sq->description );
		}

		if ( $this->_post->post_type == 'home' ) {
			$metas['dc.date.issued'] = date( 'Y-m-d', strtotime( get_lastpostmodified( 'gmt' ) ) );
		} elseif ( $this->_post->post_date <> '' ) {
			$metas['dc.date.issued'] = date( 'Y-m-d', strtotime( $this->_post->post_date ) );
		}

		if ( isset( $this->_post->post_modified ) && $this->_post->post_modified <> '' ) {
			$metas['dc.date.updated'] = $this->_post->post_modified;
		}

		return $metas;
	}

	/**
	 * Pack the Dublin Core
	 *
	 * @param array $metas
	 *
	 * @return bool|string
	 */
	public function packMeta( $metas = array() ) {
		if ( ! empty( $metas ) ) {
			foreach ( $metas as $key => &$meta ) {
				$meta = sprintf( '<meta name="%s" content="%s" />', $key, $meta );
			}

			return "\n" . join( "\n", array_values( $metas ) );
		}

		return false;
	}

	/**
	 * Set local meta for FB
	 *
	 * @param $locale
	 *
	 * @return string
	 */
	public function setLocale( $locale ) {
		//if WPML is installed, get the local language
		if ( function_exists( 'wpml_get_language_information' ) && (int) $this->_post->ID > 0 ) {
			if ( $language = wpml_get_language_information( (int) $this->_post->ID ) ) {
				if ( ! is_wp_error( $language ) && isset( $language['locale'] ) ) {
					if ( $locale <> 'en' ) {
						$locale = $language['locale'];
					}
				}
			}
		}

		if ( function_exists( 'weglot_get_current_language' ) ) {
			$locale = weglot_get_current_language();
		}

		return $locale;
	}

}
