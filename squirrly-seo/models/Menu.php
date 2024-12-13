<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Menu {

	/**
	 *
	 * @var array with the menu content
	 *
	 * $page_title (string) (required) The text to be displayed in the title tags of the page when the menu is selected
	 * $menu_title (string) (required) The on-screen name text for the menu
	 * $capability (string) (required) The capability required for this menu to be displayed to the user. User levels are deprecated and should not be used here!
	 * $menu_slug (string) (required) The slug name to refer to this menu by (should be unique for this menu). Prior to Version 3.0 this was called the file (or handle) parameter. If the function parameter is omitted, the menu_slug should be the PHP file that handles the display of the menu page content.
	 * $function The function that displays the page content for the menu page. Technically, the function parameter is optional, but if it is not supplied, then WordPress will basically assume that including the PHP file will generate the administration screen, without calling a function. Most plugin authors choose to put the page-generating code in a function within their main plugin file.:In the event that the function parameter is specified, it is possible to use any string for the file parameter. This allows usage of pages such as ?page=my_super_plugin_page instead of ?page=my-super-plugin/admin-options.php.
	 * $icon_url (string) (optional) The url to the icon to be used for this menu. This parameter is optional. Icons should be fairly small, around 16 x 16 pixels for best results. You can use the plugin_dir_url( __FILE__ ) function to get the URL of your plugin directory and then add the image filename to it. You can set $icon_url to "div" to have wordpress generate <br> tag instead of <img>. This can be used for more advanced formating via CSS, such as changing icon on hover.
	 * $position (integer) (optional) The position in the menu order this menu should appear. By default, if this parameter is omitted, the menu will appear at the bottom of the menu structure. The higher the number, the lower its position in the menu. WARNING: if 2 menu items use the same position attribute, one of the items may be overwritten so that only one item displays!
	 * */
	public $menu = array();

	/**
	 *
	 *
	 * @var array with the menu content
	 * $id (string) (required) HTML 'id' attribute of the edit screen section
	 * $title (string) (required) Title of the edit screen section, visible to user
	 * $callback (callback) (required) Function that prints out the HTML for the edit screen section. Pass function name as a string. Within a class, you can instead pass an array to call one of the class's methods. See the second example under Example below.
	 * $post_type (string) (required) The type of Write screen on which to show the edit screen section ('post', 'page', 'link', or 'custom_post_type' where custom_post_type is the custom post type slug)
	 * $context (string) (optional) The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). (Note that 'side' doesn't exist before 2.7)
	 * $priority (string) (optional) The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
	 * $callback_args (array) (optional) Arguments to pass into your callback function. The callback will receive the $post object and whatever parameters are passed through this variable.
	 * */
	public $meta = array();

	public function __construct() {

	}

	/**
	 * Add a menu in WP admin page
	 *
	 * @param array $param
	 *
	 * @return void
	 */
	public function addMenu( $param = null ) {
		if ( $param ) {
			$this->menu = $param;
		}

		if ( is_array( $this->menu ) ) {
			if ( $this->menu[0] <> '' && $this->menu[1] <> '' ) {
				/* add the translation */
				if ( ! isset( $this->menu[5] ) ) {
					$this->menu[5] = null;
				}
				if ( ! isset( $this->menu[6] ) ) {
					$this->menu[6] = null;
				}

				/* add the menu with WP */
				add_menu_page( $this->menu[0], $this->menu[1], $this->menu[2], $this->menu[3], $this->menu[4], $this->menu[5], $this->menu[6] );
			}
		}
	}

	/**
	 * Add a submenumenu in WP admin page
	 *
	 * @param array $param
	 *
	 * @return void
	 */
	public function addSubmenu( $param = null ) {
		if ( $param ) {
			$this->menu = $param;
		}

		if ( is_array( $this->menu ) ) {

			if ( $this->menu[0] <> '' && $this->menu[1] <> '' ) {
				if ( ! isset( $this->menu[5] ) ) {
					$this->menu[5] = null;
				}

				/* add the menu with WP */
				add_submenu_page( $this->menu[0], $this->menu[1], $this->menu[2], $this->menu[3], $this->menu[4], $this->menu[5] );
			}
		}
	}

	/**
	 * Add a box Meta in WP
	 *
	 * @param array $param
	 *
	 * @return void
	 */
	public function addMeta( $param = null ) {
		if ( $param ) {
			$this->meta = $param;
		}


		if ( is_array( $this->meta ) ) {

			if ( $this->meta[0] <> '' && $this->meta[1] <> '' ) {
				if ( ! isset( $this->meta[5] ) ) {
					$this->meta[5] = null;
				}
				if ( ! isset( $this->meta[6] ) ) {
					$this->meta[6] = null;
				}
				/* add the box content with WP */
				add_meta_box( $this->meta[0], $this->meta[1], $this->meta[2], $this->meta[3], $this->meta[4], $this->meta[5] );
			}
		}
	}

	public function getMainMenu() {
		$menu = array(
			'sq_dashboard'   => array(
				'title'      => ( ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) ? esc_html__( "First Step", 'squirrly-seo' ) : esc_html__( "Home", 'squirrly-seo' ) ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Overview' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-house',
				'topmenu'    => true,
				'leftmenu'   => true,
				'fullscreen' => false
			),
			'sq_checkseo'    => array(
				'title'      => esc_html__( "AI Consultant", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_CheckSeo' ), 'init' ),
				'href'       => false,
				'icon'       => false,
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seogoals' ),
				'leftmenu'   => false,
				'fullscreen' => false
			),
			'sq_features'    => array(
				'title'      => esc_html__( "All Features", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Features' ), 'init' ),
				'href'       => false,
				'icon'       => 'dashicons-before dashicons-screenoptions',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_features' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_features' ),
				'fullscreen' => false
			),

			'sq_onpagesetup' => array(
				'title'      => esc_html__( "One Page Setup", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Onboarding' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-list-check',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => true
			),
			'sq_research'    => array(
				'title'      => esc_html__( "AI Research", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Research' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-microchip-ai',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_research' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_research' ),
				'fullscreen' => true
			),
			'sq_briefcase'   => array(
				'title'      => esc_html__( "Briefcase", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Research' ), 'init' ),
				'href'       => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'icon'       => 'fa-solid fa-briefcase',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => true
			),
			'sq_assistant'   => array(
				'title'      => esc_html__( "Optimize", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Assistant' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-bolt',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
				'fullscreen' => true
			),
			'sq_bulkseo'     => array(
				'title'      => esc_html__( "Bulk SEO", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_BulkSeo' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-block-brick',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => true
			),
			'sq_automation'  => array(
				'title'      => esc_html__( "Automation", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Assistant' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-bolt',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => true
			),
			'sq_focuspages'  => array(
				'title'      => esc_html__( "Focus Pages", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_FocusPages' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-bullseye-arrow',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_focuspages' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_focuspages' ),
				'fullscreen' => true
			),
			'sq_indexnow'    => array(
				'title'      => esc_html__( "Auto-Indexing", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Indexnow' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-upload',
				'topmenu'    => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_indexnow' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_indexnow' ) ),
				'leftmenu'   => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_indexnow' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_indexnow' ) ),
				'fullscreen' => true
			),
			'sq_seosettings' => array(
				'title'      => esc_html__( "Technical SEO", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_SeoSettings' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-gears',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seo' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seo' ),
				'fullscreen' => true
			),

			'sq_innerlinks'  => array(
				'title'      => esc_html__( "Inner Links", 'squirrly-seo' ) ,
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_FocusPages' ), 'init' ),
				'href'       => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'innerlinks' ),
				'icon'       => 'fa-solid fa-link',
				'topmenu'    => false,
				'leftmenu'   => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_innelinks' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_innerlinks' ) ),
				'fullscreen' => false
			),
			'sq_audits'      => array(
				'title'      => esc_html__( "SEO Audit", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Audits' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-chart-column',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
				'fullscreen' => true
			),
			'sq_rankings'    => array(
				'title'      => esc_html__( "Google Rankings", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Ranking' ), 'init' ),
				'href'       => false,
				'icon'       => 'fa-solid fa-chart-line',
				'topmenu'    => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ),
				'leftmenu'   => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ),
				'fullscreen' => true
			),
			'sq_redirects'   => array(
				'title'      => esc_html__( "Redirects", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_SeoSettings' ), 'init' ),
				'href'       => false,
				'icon'       => 'dashicons-before dashicons-leftright',
				'topmenu'    => ( SQ_Classes_Helpers_Tools::getOption( 'sq_redirects' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_redirects' ) ),
				'leftmenu'   => ( SQ_Classes_Helpers_Tools::getOption( 'sq_redirects' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_redirects' ) ),
				'fullscreen' => true
			),
			'sq_onboarding'  => array(
				'title'      => esc_html__( "Onboarding", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'read',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Onboarding' ), 'init' ),
				'href'       => false,
				'icon'       => '',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => true
			),

			'sq_import'  => array(
				'title'      => esc_html__( "Import & Data", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_SeoSettings' ), 'init' ),
				'href'       => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'backup' ),
				'icon'       => 'fa-solid fa-arrow-up-from-bracket',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => false
			),
			'sq_account' => array(
				'title'      => esc_html__( "Account Info", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'manage_options',
				'function'   => false,
				'href'       => SQ_Classes_RemoteController::getMySquirrlyLink( 'account' ),
				'icon'       => 'fa-solid fa-user',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => false
			),
			'sq_help'    => array(
				'title'      => esc_html__( "How To & Support", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => false,
				'href'       => _SQ_HOWTO_URL_,
				'icon'       => 'fa-solid fa-comment-question',
				'topmenu'    => false,
				'leftmenu'   => true,
				'fullscreen' => false
			),
			'sq_audit'   => array(
				'title'      => esc_html__( "Audit", 'squirrly-seo' ),
				'parent'     => 'sq_dashboard',
				'capability' => 'edit_posts',
				'function'   => false,
				'href'       => _SQ_HOWTO_URL_,
				'icon'       => 'fa-solid fa-chart-column',
				'topmenu'    => false,
				'leftmenu'   => false,
				'fullscreen' => false
			),


		);

		//for PHP 7.3.1 version
		$menu = array_filter( $menu );

		return apply_filters( 'sq_menu', $menu );
	}

	/**
	 * Get the admin Menu Tabs
	 *
	 * @param string $category
	 *
	 * @return array
	 */
	public function getTabs( $category ) {
		$tabs = array();

		$tabs['sq_dashboard']   = array(

			'sq_dashboard/sq_progress'     => array(
				'title'      => esc_html__( "Progress & Achivements", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seogoals' ) && !empty(SQ_Classes_ObjController::getClass( 'SQ_Controllers_Progress' )->getCongratulations()),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Controllers_Progress' ), 'init' ),
				'icon'       => ''
			),
			'sq_dashboard/sq_mainfeatures' => array(
				'title'      => esc_html__( "Main Features", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_features' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockFeatures' ), 'init' ),
				'icon'       => ''
			),
			'sq_dashboard/sq_journey'      => array(
				'title'      => esc_html__( "14 Days Journey", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippets',
				'show'       => ( SQ_Classes_Helpers_Tools::getMenuVisible( 'show_journey' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_seojourney_congrats' ) ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockJorney' ), 'init' ),
				'icon'       => ''
			),

		);
		$tabs['sq_help']        = array(
			'sq_dashboard/sq_dashboardhelp'     => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_journey/sq_journeyhelp'         => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_onpagesetup/sq_onpagesetuphelp' => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_research/sq_researchhelp'       => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_research/sq_briefcasehelp'      => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_assistant/sq_assistanthelp'     => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_seosettings/sq_settingshelp'    => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_bulkseo/sq_bulkseohelp'         => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_focuspages/sq_focuspageshelp'   => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_audits/sq_auditshelp'           => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_rankings/sq_rankingshelp'       => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_automation/sq_automationhelp'   => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
			'sq_onboarding/sq_onboardinghelp'   => array(
				'title'      => esc_html__( "Free Learning Materials", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_tutorial' ),
				'function'   => array( SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' ), 'init' ),
				'icon'       => ''
			),
		);
		$tabs['sq_research']    = array(
			'sq_research/research'  => array(
				'title'      => esc_html__( "Find Keywords", 'squirrly-seo' ) ,
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-post-status',
			),
			'sq_research/briefcase' => array(
				'title'      => esc_html__( "Briefcase", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'fa-solid fa-briefcase',
			),
			'sq_research/labels'    => array(
				'title'      => esc_html__( "Labels", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'fa-solid fa-tag'
			),
			'sq_research/suggested' => array(
				'title'      => esc_html__( "Suggested", 'squirrly-seo' ) ,
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-lightbulb'
			),
			'sq_research/history'   => array(
				'title'      => esc_html__( "History", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-backup'
			),

		);
		$tabs['sq_assistant']   = array(
			'sq_assistant/assistant' => array(
				'title'      => esc_html__( "Optimize Posts", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-edit',
			),
			'sq_assistant/bulkseo' => array(
				'title'      => esc_html__( "Bulk SEO", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'fa-solid fa-block-brick',
			),

			'sq_assistant/automation' => array(
				'title'      => esc_html__( "Automation", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-bolt',
			),
			'sq_assistant/settings'  => array(
				'title'      => esc_html__( "Settings", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-admin-settings',
			),
		);
		$tabs['sq_focuspages']  = array(
			'sq_focuspages/pagelist'   => array(
				'title'      => esc_html__( "Focus Pages", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'fa-solid fa-bullseye-arrow'
			),
			'sq_focuspages/addpage'    => array(
				'title'      => esc_html__( "Add New Page", 'squirrly-seo' ),
				'capability' => 'sq_manage_focuspages',
				'icon'       => 'dashicons-before dashicons-plus'
			),
			'sq_focuspages/innerlinks' => array(
				'title'      => esc_html__( "Inner Links", 'squirrly-seo' ) ,
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-admin-links',
				'show'       => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_innelinks' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_innerlinks' ) )
			),
			'sq_focuspages/settings'   => array(
				'title'      => esc_html__( "Settings", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-admin-settings'
			),
		);
		$tabs['sq_audits']      = array(
			'sq_audits/audits'   => array(
				'title'      => esc_html__( "Overview", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-chart-bar',
			),
			'sq_audits/addpage'  => array(
				'title'      => esc_html__( "Add New Page", 'squirrly-seo' ),
				'capability' => 'sq_manage_focuspages',
				'icon'       => 'dashicons-before dashicons-plus'
			),
			'sq_audits/settings' => array(
				'title'      => esc_html__( "Settings", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-admin-settings'
			),
		);
		$tabs['sq_rankings']    = array(
			'sq_rankings/rankings'   => array(
				'title'      => esc_html__( "Rankings", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-chart-line',
			),
			'sq_research/addkeyword' => array(
				'title'      => esc_html__( "Add Keywords", 'squirrly-seo' ),
				'capability' => 'sq_manage_focuspages',
				'icon'       => 'dashicons-before dashicons-plus'
			),
			'sq_rankings/gscsync'    => array(
				'title'      => esc_html__( "Sync Keywords", 'squirrly-seo' ),
				'capability' => 'sq_manage_focuspages',
				'icon'       => 'dashicons-before dashicons-admin-links'
			),
			'sq_rankings/settings'   => array(
				'title'      => esc_html__( "Settings", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-admin-settings'
			),

		);
		$tabs['sq_bulkseo']     = array(
			'sq_assistant/bulkseo' => array(
				'title'      => esc_html__( "Bulk SEO", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'fa-solid fa-block-brick',
			),
		);
		$tabs['sq_automation']  = array(
			'sq_automation/types'      => array(
				'title'      => esc_html__( "Automation", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-plus',
			),
			'sq_automation/automation' => array(
				'title'      => esc_html__( "Configuration", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-bolt',
			),
			'sq_automation/settings'   => array(
				'title'      => esc_html__( "Advanced", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-admin-settings',
				'show'       => SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ),
			),
		);
		$tabs['sq_indexnow']    = array(
			'sq_indexnow/submit'   => array(
				'title'      => esc_html__( "Submit URLs", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'fa-solid fa-upload',
			),
			'sq_indexnow/settings' => array(
				'title'      => esc_html__( "Settings", 'squirrly-seo' ),
				'capability' => 'sq_manage_snippet',
				'icon'       => 'dashicons-before dashicons-admin-settings',
			),
		);
		$tabs['sq_seosettings'] = array(
			'sq_seosettings/tweaks'    => array(
				'title'      => esc_html__( "Tweaks & Sitemaps", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-map',
				'show'       => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_links' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ) ),
				'tabs'       => array(
					array(
						'title' => esc_html__( "Sitemap XML", 'hide-my-wp' ),
						'tab'   => 'sitemap',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ),
					),
					array(
						'title' => esc_html__( "SEO Links and Redirects", 'hide-my-wp' ),
						'tab'   => 'links',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_links' ),
					),
					array(
						'title' => esc_html__( "Robots File", 'hide-my-wp' ),
						'tab'   => 'robots',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ),
					),
					array(
						'title' => esc_html__( "Website Icon", 'hide-my-wp' ),
						'tab'   => 'favicon',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ),
					),
					array(
						'title' => esc_html__( "Advanced Settings", 'hide-my-wp' ),
						'tab'   => 'advanced',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' ),
					),
				)
			),
			'sq_seosettings/metas'     => array(
				'title'      => esc_html__( "SEO Metas", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-editor-code',
				'show'       => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ),
				'tabs'       => array(
					array(
						'title' => esc_html__( "Manage On-Page SEO Metas", 'hide-my-wp' ),
						'tab'   => 'onpage',
					),
					array(
						'title' => esc_html__( "More SEO Settings", 'hide-my-wp' ),
						'tab'   => 'settings',
					),
					array(
						'title' => esc_html__( "Advanced Settings", 'hide-my-wp' ),
						'tab'   => 'advanced',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' )
					),
				)
			),
			'sq_seosettings/social'    => array(
				'title'      => esc_html__( "Social Media", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'dashicons-before dashicons-share',
				'show'       => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ) ),
				'tabs'       => array(
					array(
						'title' => esc_html__( "Open Graph Settings", 'hide-my-wp' ),
						'tab'   => 'opengraph',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ),
					),
					array(
						'title' => esc_html__( "Twitter Card Settings", 'hide-my-wp' ),
						'tab'   => 'twittercard',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ),
					),
					array(
						'title' => esc_html__( "Social Media Accounts", 'hide-my-wp' ),
						'tab'   => 'accounts',
					),
					array(
						'title' => esc_html__( "Advanced", 'hide-my-wp' ),
						'tab'   => 'advanced',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' )
					),
				)
			),
			'sq_seosettings/jsonld'    => array(
				'title'      => esc_html__( "Rich Snippets", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-barcode-read',
				'show'       => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ),
				'tabs'       => array(
					array(
						'title' => esc_html__( "Company", 'hide-my-wp' ),
						'tab'   => 'company',
					),
					array(
						'title' => esc_html__( "Personal Brand / Author", 'hide-my-wp' ),
						'tab'   => 'personal',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_personal' ),
					),
					array(
						'title' => esc_html__( "WooCommerce", 'hide-my-wp' ),
						'tab'   => 'woocommerce',
						'show'  => SQ_Classes_Helpers_Tools::isEcommerce(),
					),
					array(
						'title' => esc_html__( "Local SEO", 'hide-my-wp' ),
						'tab'   => 'localseo',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ),
					),
					array(
						'title' => esc_html__( "GEO Location", 'hide-my-wp' ),
						'tab'   => 'location',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ),
					),
					array(
						'title' => esc_html__( "Opening Hours ", 'hide-my-wp' ),
						'tab'   => 'hours',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ),
					),
					array(
						'title' => esc_html__( "Local Restaurant", 'hide-my-wp' ),
						'tab'   => 'restaurant',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ),
					),
					array(
						'title' => esc_html__( "More Json-LD Settings", 'hide-my-wp' ),
						'tab'   => 'settings',
					),
					array(
						'title' => esc_html__( "Advanced", 'hide-my-wp' ),
						'tab'   => 'advanced',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_seoexpert' )
					),
				)
			),
			'sq_seosettings/webmaster' => array(
				'title'      => esc_html__( "Connect Tools", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-chart-line',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seo' ),
				'tabs'       => array(
					array(
						'title' => esc_html__( "Connect Tools", 'hide-my-wp' ),
						'tab'   => 'connect',
					),
					array(
						'title' => esc_html__( "Place Trackers", 'hide-my-wp' ),
						'tab'   => 'trackers',
						'show'  => ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pixels' ) || SQ_Classes_Helpers_Tools::getOption( 'sq_auto_webmasters' ) ),
					),
					array(
						'title' => esc_html__( "AMP", 'hide-my-wp' ),
						'tab'   => 'amp',
					),
					array(
						'title' => esc_html__( "Webmaster Extras", 'hide-my-wp' ),
						'tab'   => 'webmasters',
						'show'  => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_webmasters' ),
					),
				)
			),
			'sq_seosettings/category'  => array(
				'title'      => esc_html__( "No Categories", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_categories' ),
				'icon'       => 'fa-solid fa-folder'
			),
			'sq_seosettings/backup'    => array(
				'title'      => esc_html__( "Import & Data", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'icon'       => 'fa-solid fa-arrow-up-from-bracket',
				'show'       => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seo' ),
				'tabs'       => array(
					array(
						'title' => esc_html__( "Import Settings & SEO", 'hide-my-wp' ),
						'tab'   => 'import',
					),
					array(
						'title' => esc_html__( "Backup Settings & SEO", 'hide-my-wp' ),
						'tab'   => 'backup',
					),
					array(
						'title' => esc_html__( "Restore Settings & SEO", 'hide-my-wp' ),
						'tab'   => 'restore',
					),
					array(
						'title' => esc_html__( "Rollback Plugin", 'hide-my-wp' ),
						'tab'   => 'rollback',
					),
				)
			),

		);
		$tabs['sq_audit']       = array(
			'blogging'  => array(
				'title'       => esc_html__( "Blogging", 'squirrly-seo' ),
				'description' => esc_html__( "Blogging overwiew", 'squirrly-seo' ),
				'capability'  => 'edit_posts',
				'icon'        => 'fa-solid fa-pen-to-square'
			),
			'traffic'   => array(
				'title'       => esc_html__( "Traffic", 'squirrly-seo' ),
				'description' => esc_html__( "Weekly website traffic", 'squirrly-seo' ),
				'capability'  => 'edit_posts',
				'icon'        => 'fa-solid fa-chart-line'
			),
			'seo'       => array(
				'title'       => esc_html__( "SEO", 'squirrly-seo' ),
				'description' => esc_html__( "On-Page optimization", 'squirrly-seo' ),
				'capability'  => 'edit_posts',
				'icon'        => 'fa-solid fa-magnifying-glass'
			),
			'social'    => array(
				'title'       => esc_html__( "Social", 'squirrly-seo' ),
				'description' => esc_html__( "Social signals and shares", 'squirrly-seo' ),
				'capability'  => 'edit_posts',
				'icon'        => 'fa-solid fa-share-nodes'
			),
			'links'     => array(
				'title'       => esc_html__( "Links", 'squirrly-seo' ),
				'description' => esc_html__( "Backlinks and Innerlinks", 'squirrly-seo' ),
				'capability'  => 'edit_posts',
				'icon'        => 'fa-solid fa-link'
			),
			'authority' => array(
				'title'       => esc_html__( "Authority", 'squirrly-seo' ),
				'description' => esc_html__( "Website Off-Page score", 'squirrly-seo' ),
				'capability'  => 'edit_posts',
				'icon'        => 'fa-solid fa-crown'
			),
		);
		$tabs['sq_redirects']   = array(
			'sq_redirects/rules' => array(
				'title'      => esc_html__( "Rules", 'squirrly-seo' ),
				'capability' => 'sq_manage_settings',
				'show'       => true,
				'icon'       => 'dashicons-before dashicons-leftright'
			)
		);

		$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );
		$patterns = apply_filters( 'sq_automation_patterns', $patterns );

		if ( ! empty( $patterns ) ) {
			foreach ( $patterns as $pattern => $type ) {

				$tabs['sq_assistant']['sq_assistant/automation']['tabs'][] = array(
					'title' => apply_filters( 'sq_pattern_item', $pattern ),
					'tab'   => 'sq_' . $pattern,
				);

			}
		}

		//for PHP 7.3.1 version
		$tabs = array_filter( $tabs );

		return apply_filters( 'sq_menu_' . $category, ( isset( $tabs[ $category ] ) ? $tabs[ $category ] : array() ), $category );

	}

	/**
	 * Get the Breadcrumbs for a tab
	 *
	 * @param $name
	 *
	 * @return string
	 */
	public function getBreadcrumbs( $name ) {
		$breadcrumbs = '';
		$separator   = '<i class="text-black-50 mx-1">/</i>';
		$mainmenu    = $this->getMainMenu();
		$name        = sanitize_text_field( $name );

		if ( ! empty( $mainmenu ) ) {
			foreach ( $mainmenu as $menuid => $item ) {

				if ( $menuid == $name ) {
					$breadcrumbs .= '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard' )) . '">' . '<i class="fa-solid fa-house text-black-50"></i></a>' . $separator;
					$breadcrumbs .= '<a href="' . esc_url(SQ_Classes_Helpers_Tools::getAdminUrl( $menuid )) . '">' . $item['title'] . '</a>';
				} elseif ( strpos( $breadcrumbs, 'fa-house' ) === false ) {

					$tabs = $this->getTabs( $menuid );
					if ( ! empty( $tabs ) ) {
						foreach ( $tabs as $id => $tab ) {
							$array_id = explode( '/', $id );

							if ( strpos( $name, '/' ) !== false ) {
								$array_name = explode( '/', $name );
								if ( isset( $array_id[1] ) && $array_id[0] == $array_name[0] && $array_id[1] == $array_name[1] ) {
									$breadcrumbs .= $this->getBreadcrumbs( $array_id[0] );
									$breadcrumbs .= $separator;
									$breadcrumbs .= $tab['title'];
								}
							} else {
								if ( isset( $array_id[1] ) && $array_id[1] == $name ) {
									$breadcrumbs .= $this->getBreadcrumbs( $array_id[0] );
									$breadcrumbs .= $separator;
									$breadcrumbs .= $tab['title'];
								}
							}
						}
					}

				}
			}
		}

		return $breadcrumbs;

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
	 * Get the Squirrly admin menu based on selected category
	 *
	 * @param null $current
	 * @param string $category
	 *
	 * @return string
	 */
	public function getAdminTabs( $current = null, $category = 'sq_research' ) {
		return SQ_Classes_ObjController::getClass( 'SQ_Classes_FrontController' )->get_view( 'Blocks/Menu' );
	}


}
