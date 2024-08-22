<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Domain_Innerlink extends SQ_Models_Abstract_Domain {

	protected $_id;
	protected $_from_post_id;
	protected $_to_post_id;
	protected $_keyword;
	protected $_nofollow;
	protected $_blank;
	protected $_found;
	protected $_valid;

	public function getValid() {
		if ( ! isset( $this->_valid ) ) {
			$this->_valid = false;
		}

		return $this->_valid;
	}

	public function toArray() {
		return array(
			'id'           => $this->id,
			//
			'from_post_id' => $this->from_post_id,
			'to_post_id'   => $this->to_post_id,
			'keyword'      => $this->keyword,
			'nofollow'     => $this->nofollow,
			'found'        => $this->found,
			'valid'        => $this->valid,
			//
		);
	}
}
