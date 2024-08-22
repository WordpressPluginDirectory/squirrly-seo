<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * The main class for core blocks
 */
class SQ_Classes_BlockController {

	/**
	 *
	 *
	 * @var object of the model class
	 */
	protected $model;

	/**
	 *
	 *
	 * @var boolean
	 */
	public $flush = true;

	/**
	 *
	 *
	 * @var object of the view class
	 */
	protected $view;

	/**
	 *
	 *
	 * @var string name of the  class
	 */
	private $name;

	public function __construct() {
		/* get the name of the current class */
		$this->name = get_class( $this );

		/* create the model and view instances */
		$model_classname = str_replace( 'Core', 'Models', $this->name );
		if ( SQ_Classes_ObjController::getClassPath( $model_classname ) ) {
			$this->model = SQ_Classes_ObjController::getClass( $model_classname );
		}
	}

	/**
	 * load sequence of classes
	 * Function called usualy when the controller is loaded in WP
	 *
	 * @return mixed
	 */
	public function init() {
		/* check if there is a hook defined in the block class */
		SQ_Classes_ObjController::getClass( 'SQ_Classes_HookController' )->setBlockHooks( $this );
		//get the class path
		$class = SQ_Classes_ObjController::getClassPath( $this->name );

		if ( ! $this->flush ) {
			return $this->get_view( $class['name'] );
		}

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( $class['name'] );
		$this->show_view( $class['name'] );

		return false;
	}

	/**
	 * Get the block view
	 *
	 * @param string $view Class name
	 *
	 * @return string The file from /view directory
	 */
	public function get_view( $view ) {
		return SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->get_view( $view, $this );
	}

	/**
	 * Deprecated since version 11.1.11
	 *
	 * @param $view
	 *
	 * @return mixed
	 */
	public function getView( $view ) {
		return $this->get_view( $view );
	}

	/**
	 * Show the view block
	 *
	 * @param string $view Class name
	 *
	 * @return void
	 */
	public function show_view( $view ) {
		$content = SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->get_view( $view, $this );

		//Support for international languages
		if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
			if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
				$content = iconv( 'UTF-8', 'UTF-8//IGNORE', $content );
			}
		}

		//echo the file from /view directory
		//already escaped in the view
		//Contains HTML output
		echo $content;
	}

	/**
	 * Called as menu callback to show the block
	 */
	public function show() {
		$this->flush = true;

		echo $this->init();
	}

	/**
	 * This function is called from Ajax class as a wp_ajax_action
	 */
	protected function action() {
	}

	/**
	 * This function will load the media in the header for each class
	 *
	 * @return void
	 */
	protected function hookHead() {
	}

}
