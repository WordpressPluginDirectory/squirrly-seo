<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Services_CustomMetas extends SQ_Models_Abstract_Seo {


	public function __construct() {
		parent::__construct();

		if ( isset( $this->_post->sq->doseo ) && $this->_post->sq->doseo ) {
			if ( ! $this->_post->sq->do_metas ) {
				return;
			}

			add_filter( 'sq_beforemeta', array( $this, 'beforeMetas' ) );
			add_filter( 'sq_beforemeta', array( $this, 'packMetas' ), 99 );
			add_filter( 'sq_aftermeta', array( $this, 'afterMetas' ) );
			add_filter( 'sq_aftermeta', array( $this, 'packMetas' ), 99 );

		} else {
			add_filter( 'sq_title', array( $this, 'returnFalse' ) );
		}

	}

	public function beforeMetas( $meta = '' ) {
		return SQ_Classes_Helpers_Tools::getOption( 'sq_beforemeta' );
	}

	public function afterMetas( $meta = '' ) {
		return SQ_Classes_Helpers_Tools::getOption( 'sq_aftermeta' );
	}

	public function packMetas( $meta = '' ) {
		if ( $meta <> '' ) {
			return html_entity_decode( $meta );
		}

		return false;
	}

}
