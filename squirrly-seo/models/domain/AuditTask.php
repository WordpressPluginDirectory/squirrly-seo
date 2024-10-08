<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Domain_AuditTask extends SQ_Models_Abstract_Domain {

	protected $_audit_group;
	protected $_audit_task;
	protected $_urls;
	protected $_value;
	protected $_total;
	protected $_complete;

	protected $_title;
	protected $_description;
	protected $_success;
	protected $_success_list;
	protected $_fail;
	protected $_fail_list;
	protected $_protip;
	protected $_solution;
	protected $_link;
}
