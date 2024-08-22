<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Onboarding extends SQ_Classes_FrontController {

	public $metas;
	public $pages;
	public $focuspages;
	public $platforms;
	public $active_plugins;

	/**
	 * Call for Onboarding
	 *
	 * @return mixed|void
	 */
	public function init() {

		$tab = preg_replace( "/[^a-zA-Z0-9]/", "", SQ_Classes_Helpers_Tools::getValue( 'tab', 'step1' ) );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap-reboot' );
		if ( is_rtl() ) {
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'popper' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap.rtl' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'rtl' );
		} else {
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'bootstrap' );
		}
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'switchery' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'fontawesome' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'global' );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'assistant' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'navbar' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'onboarding' );

		if ( method_exists( $this, $tab ) ) {
			call_user_func( array( $this, $tab ) );
		}

		//Load the Themes and Plugins
		add_filter( 'sq_themes', array(
			SQ_Classes_ObjController::getClass( 'SQ_Models_ImportExport' ),
			'getAvailableThemes'
		) );
		add_filter( 'sq_plugins', array(
			SQ_Classes_ObjController::getClass( 'SQ_Models_ImportExport' ),
			'getAvailablePlugins'
		) );
		$this->platforms = apply_filters( 'sq_importList', false );

		$this->show_view( 'Onboarding/' . esc_attr( ucfirst( $tab ) ) );
	}

	public function step1() {
		//Set the onboarding version
		SQ_Classes_Helpers_Tools::saveOptions( 'sq_onboarding', SQ_VERSION );
	}

	public function step3() {
		$search      = (string) SQ_Classes_Helpers_Tools::getValue( 'skeyword', '' );
		$this->pages = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getPages( $search );

		//get also the focus pages
		$this->focuspages = SQ_Classes_RemoteController::getFocusPages();

		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as &$focuspage ) {
				$focuspage = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_FocusPage', $focuspage );
			}
		}
	}

	public function step4() {
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'seosettings' );

		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
			wp_enqueue_style( 'media-views' );
		}
	}

	/**
	 * Get all the assistant tasks in list
	 *
	 * @param string $current
	 *
	 * @return string
	 */
	public function getBreadcrumbs( $current = 'step1' ) {
		$content = '';

		$tasks = array(
			'step1' => array(
				'title' => esc_html__( 'SEO Expert Mode', 'squirrly-seo' )
			),
			'step2' => array(
				'title' => esc_html__( 'SEO Automation', 'squirrly-seo' )
			),
			'step3' => array(
				'title' => esc_html__( 'Add a Page', 'squirrly-seo' )
			),
			'step4' => array(
				'title' => esc_html__( 'Complete SEO Info', 'squirrly-seo' )
			),
			'step5' => array(
				'title' => esc_html__( 'Your Site’s Topic', 'squirrly-seo' )
			),
			'step6' => array(
				'title' => esc_html__( 'Ready!', 'squirrly-seo' )
			),
		);


		//Create the list of tasks
		$completed = true;
		$content   .= '<ul class="col-12 row p-0 m-0 my-3" >';
		foreach ( $tasks as $name => $task ) {


			$content .= '<li class="sq_task col row p-0 mx-0 ' . ( $completed ? 'completed' : '' ) . '" >
                            <a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', $name ) . '" style="white-space: nowrap;"><i class="fa-solid fa-check"></i> <span class="sq_task_text p-1 m-0 text-dark">' . $task['title'] . '</span></a>
                         </li>';

			if ( $current == $name ) {
				$completed = false;
			}

		}
		$content .= '</ul>';

		return $content;
	}

	/**
	 * Show the breadcrumbs in view
	 *
	 * @param $name
	 *
	 * @return void
	 */
	public function showBreadcrumbs( $name ) {
		$name = esc_attr( $name );
		echo $this->getBreadcrumbs( $name );
	}

	/**
	 * Check SEO Actions
	 */
	public function action() {
		parent::action();

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_onboarding_save':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_settings' ) ) {
					return;
				}

				//Save the settings
				if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
					SQ_Classes_ObjController::getClass( 'SQ_Models_Settings' )->saveSettings();

					if ( SQ_Classes_Helpers_Tools::getIsset( 'sq_mode' ) ) {
						switch ( SQ_Classes_Helpers_Tools::getValue( 'sq_mode' ) ) {
							case 0:
								SQ_Classes_Helpers_Tools::$options = SQ_Classes_Helpers_Tools::getOptions( 'reset' );
								SQ_Classes_Helpers_Tools::saveOptions();
								SQ_Classes_Helpers_Tools::saveOptions( 'sq_mode', 0 );
								SQ_Classes_Helpers_Tools::saveOptions( 'sq_seoexpert', 0 );
								//wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
								wp_redirect( SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'step5' ) );
								break;
							case 1:
								SQ_Classes_Helpers_Tools::$options = SQ_Classes_Helpers_Tools::getOptions( 'recommended' );
								SQ_Classes_Helpers_Tools::saveOptions();
								SQ_Classes_Helpers_Tools::saveOptions( 'sq_mode', 1 );
								SQ_Classes_Helpers_Tools::saveOptions( 'sq_seoexpert', 0 );
								break;
							case 2:
								SQ_Classes_Helpers_Tools::$options = SQ_Classes_Helpers_Tools::getOptions( 'expert' );
								SQ_Classes_Helpers_Tools::saveOptions();
								SQ_Classes_Helpers_Tools::saveOptions( 'sq_mode', 2 );
								SQ_Classes_Helpers_Tools::saveOptions( 'sq_seoexpert', 1 );
								break;
						}

						SQ_Classes_Helpers_Tools::saveOptions( 'sq_onboarding', 1 );
					}
				}

				//Save custom links
				if ( SQ_Classes_Helpers_Tools::getIsset( 'keyword' ) ) {
					$keyword = (string) SQ_Classes_Helpers_Tools::getValue( 'keyword', '' );

					if ( $keyword <> '' ) {
						//set ignore on API
						$args              = array();
						$args['keyword']   = $keyword;
						$args['do_serp']   = 1;
						$args['is_hidden'] = 0;
						SQ_Classes_RemoteController::addBriefcaseKeyword( $args );
					}
				}

				//save the options in database
				SQ_Classes_Helpers_Tools::saveOptions();

				//show the saved message
				if ( ! SQ_Classes_Error::isError() ) {
					//reset the report time
					SQ_Classes_Helpers_Tools::saveOptions( 'seoreport_time', false );

					SQ_Classes_Error::setMessage( esc_html__( "Saved", 'squirrly-seo' ) );
				}

				break;
			case 'sq_onboarding_commitment':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					return;
				}

				SQ_Classes_Helpers_Tools::saveOptions( 'sq_seojourney', date( 'Y-m-d' ) );

				break;

		}
	}

}
