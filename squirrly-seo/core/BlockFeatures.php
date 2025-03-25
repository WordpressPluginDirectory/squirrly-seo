<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Core_BlockFeatures extends SQ_Classes_BlockController {

	/** @var false|array The feature list  */
	public $features = false;

	public function init() {

		if ( SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			if ($this->features === false ) {
				$this->features = SQ_Classes_ObjController::getClass( 'SQ_Core_BlockFeatures' )->getFeatures();
			}
		}

		$this->show_view( 'Blocks/Features' );
	}

	public function getCategories() {
		return array(
			"Social Media Features"   => "fa-solid fa-share-nodes",
			"Unique SEO Features"     => "fa-solid fa-bullseye-arrow",
			"Keywords Features"       => "fa-solid fa-key",
			"Optimize Your Content"   => "fa-solid fa-social",
			"Assistants"              => "fa-solid fa-message",
			"METAs Features"          => "fa-solid fa-code-simple",
			"Optimize Multiple Pages" => "fa-solid fa-social",
			"Import Features"         => "fa-solid fa-arrow-up-from-bracket",
			"Links Features"          => "fa-solid fa-link",
			"Integration Features"    => "fa-solid fa-chart-line-up",
			"Miscellaneous Features"  => "fa-solid fa-barcode-read",
		);
	}

	public function getFeatures() {
		$connect = SQ_Classes_Helpers_Tools::getOption( 'connect' );
		$sitemap = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap' );

		$features = array(
			array(
				'title'       => "Squirrly Cloud App",
				'description' => "Many Squirrly features work from <bold>cloud.squirrly.co</bold> and helps you optimize the content and manage the keywords, audits and rankings.",
				'category'    => "",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-cloud',
				'link'        => SQ_Classes_RemoteController::getMySquirrlyLink( 'dashboard' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-cloud-app/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_account_info' ),
			), //Squirrly Cloud
			array(
				'title'       => "14 Days Journey Course",
				'description' => "<strong>Improve your Online Presence</strong> by knowing how your website is performing. All you need now is to start driving One of your most valuable pages to <strong>Better Rankings</strong>.",
				'category'    => "Unique SEO Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_seojourney' ),
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-car',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_onboarding', 'journey' ),
				'details'     => 'https://howto12.squirrly.co/kb/install-squirrly-seo-plugin/#journey',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_journey' ),
			), //14 Days Journey Course
			array(
				'title'       => "Next SEO Goals",
				'description' => "The AI SEO Consultant with <strong>over 100+ signals</strong> that prepares your goals to take you closer to the first page of Google.",
				'category'    => "Unique SEO Features",
				'mainfeature' => "Get AI Assistants",
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-forward-step',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_checkseo' ),
				'details'     => 'https://howto12.squirrly.co/kb/next-seo-goals/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_seogoals' ),
			),//Next SEO Goals
			array(
				'title'       => "Progress & Achievements",
				'description' => "Displays <strong>Success Messages</strong> and <strong>Progress & Achievements</strong> for SEO Goals, Focus Pages, Audits, and Rankings",
				'category'    => "Unique SEO Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-dumbbell',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_dashboard', '', array( '#progress' ) ),
				'details'     => 'https://howto12.squirrly.co/kb/next-seo-goals/',
				'show'        => true,
			),//Progress
			array(
				'title'       => "Focus Pages",
				'description' => "Brings you clear methods to take your pages <strong>from never found to always found on Google</strong>. Rank your pages by influencing the right ranking factors.",
				'category'    => "Unique SEO Features",
				'mainfeature' => "Optimize the Best Pages",
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-bullseye-arrow',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'details'     => 'https://howto12.squirrly.co/kb/focus-pages-page-audits/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_focuspages' ),
			), //Focus Pages
			array(
				'title'       => "Copyright Free Images",
				'description' => "Search <strong>Copyright Free Images</strong> in Squirrly Live Assistant and import them directly on your content.",
				'category'    => "Unique SEO Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-image',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#copyright_free_images',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			), //Blogging Assistant
			array(
				'title'       => "SEO Images",
				'description' => "Automatically <strong>downloads image and adds image alt tag</strong> for you, if you searched for images using your focus keyword <strong>inside the Blogging Assistant</strong>.",
				'category'    => "Unique SEO Features",
				'mainfeature' => false,
				'option'      => 'sq_local_images',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_local_images' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message-image',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#seo_image',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			), //
			array(
				'title'       => "Redirects",
				'description' => "Take control of your website's redirects by managing all of your 301, 302, and 307 redirects for both posts and pages. Keep track of the hits on your redirects with monitoring capabilities.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_redirects',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_redirects' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'dashicons-before dashicons-leftright',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_redirects', 'rules' ),
				'details'     => '',
				'show'        => true,
				'keywords'    => 'redirect,301,404,broken links,links,path'
			),
			array(
				'title'       => "Open Graph Optimization",
				'description' => "Add Social Open Graph protocol so that <strong>your Facebook Shares look awesome</strong>.",
				'category'    => "Social Media Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_facebook',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_facebook' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fasq-brands fa-facebook-f',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' ),
				'details'     => 'https://howto12.squirrly.co/kb/social-media-settings/#opengraph',
				'show'        => true,
			),//Open Graph Optimization
			array(
				'title'       => "Twitter Card Optimization",
				'description' => "Add Twitter Card in your tweets so that your <strong>Twitter Shares look awesome</strong>.",
				'category'    => "Social Media Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_twitter',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_twitter' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fasq-brands fa-x-twitter',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' ),
				'details'     => 'https://howto12.squirrly.co/kb/social-media-settings/#twittercard',
				'show'        => true,
			),//Twitter Card Optimization
			array(
				'title'       => "Facebook Pixel Tracking",
				'description' => "Track visitors with <strong>website and e-commerce events</strong> for better Retargeting Campaigns. <strong>Integrated with Woocommerce</strong> plugin with events like Add to Cart, Initiate Checkout, Payment, and more.",
				'category'    => "Social Media Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_pixels',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pixels' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fasq-brands fa-facebook-f',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster#tab=trackers' ),
				'details'     => 'https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#facebook_pixel',
				'show'        => true,
			), //Facebook Pixel Tracking

			array(
				'title'       => "Keyword Research",
				'description' => "Find the <strong>Best Keywords</strong> that your own website can rank for and get <strong>personalized competition data</strong> for each keyword. Provides info on Region that was used for Keyword Research.",
				'category'    => "Keywords Features",
				'mainfeature' => "Find Keywords",
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-key',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ),
				'details'     => 'https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_research' ),
			), //AI Research
			array(
				'title'       => "Briefcase",
				'description' => "Add keywords in your portfolio based on your current Campaigns, Trends, Performance <strong>for a successful SEO strategy</strong>.",
				'category'    => "Keywords Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-briefcase',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'details'     => 'https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_research' ),
			),//SEO Briefcase
			array(
				'title'       => "Chances of Ranking",
				'description' => "Get information about <strong>Chances of Ranking for each Focus Page</strong> based on our <strong>Machine Learning Algorithms and Ranking Vision A.I.</strong>",
				'category'    => "Keywords Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-arrow-trend-up',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'details'     => 'https://howto12.squirrly.co/kb/focus-pages-page-audits/#chance_to_rank',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_focuspages' ),
			), //Chances of Ranking
			array(
				'title'       => "Google Search & Competition",
				'description' => "Keyword Research uses third-party services like <strong>Google Search API</strong> to get live research data for each keyword. The research algorithm processes <strong>more than 100 processes</strong> for each keyword you selected.",
				'category'    => "Keywords Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-chart-waterfall',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ),
				'details'     => 'https://howto12.squirrly.co/kb/keyword-research-and-seo-strategy/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_research' ),
			), //AI Research
			array(
				'title'       => "Google Rankings with GSC",
				'description' => "Get <strong>Google Search Console (GSC)</strong> average <strong>positions, clicks and impressions</strong> for organic keywords.",
				'category'    => "Keywords Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-chart-line',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings' ),
				'details'     => 'https://howto12.squirrly.co/kb/ranking-serp-checker/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ),
			),//Google SERP with GSC
			array(
				'title'       => "Keywords Optimization",
				'description' => "Optimize for <strong>Multiple Keywords at once in a Single Page</strong>. Automatically Calculates Optimization Scores for all secondary keywords and displays them to you as you’re typing your page.",
				'category'    => "Keywords Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-key',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#add_keyword',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			),//Keywords Optimization
			array(
				'title'       => "No Category Base",
				'description' => "Make your category URLs more aesthetically appealing, more intuitive, as well as easier to understand and remember by site visitors.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_nocategory',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_nocategory' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-bolt',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'category' ),
				'details'     => 'https://howto12.squirrly.co/ht_kb/how-to-remove-the-category-base-from-wordpress/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_categories' ),
				'keywords'    => 'categories,category,path'
			),
			array(
				'title'       => "Live Assistant",
				'description' => "Publish <strong>content that is fully optimized</strong> for BOTH Search Engines and Humans – every single time!",
				'category'    => "Assistants",
				'mainfeature' => "Optimize Your Content",
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/',
				'keywords'    => 'live,assistant',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			),//Live Assistant
			array(
				'title'       => "Elementor Website Builder",
				'description' => "The SEO Live Assistant <strong>works on the front-end of Elementor</strong>, just as you're creating or editing your Elementor page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#elementor',
				'show'        => ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'elementor/elementor.php' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ) ),
			),//Live Assistant Elementor
			array(
				'title'       => "Oxygen Website Builder",
				'description' => "The SEO Live Assistant <strong>works on the front-end of Oxygen</strong>, just as you're creating or editing your Oxygen page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#oxygen',
				'show'        => ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'oxygen/functions.php' ) && SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ) ),
			),//Live Assistant Oxygen
			array(
				'title'       => "Divi Builder",
				'description' => "The SEO Live Assistant <strong>works on the front-end of Divi</strong>, just as you're creating or editing your Divi page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#divi',
				'show'        => ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'divi-builder/divi-builder.php' ) || SQ_Classes_Helpers_Tools::isThemeActive( 'Divi' ) ),
			),//Live Assistant Divi
			array(
				'title'       => "Thrive Architect",
				'description' => "The SEO Live Assistant <strong>works on the front-end of Thrive Architect</strong>, just as you're creating or editing your Thrive Architect page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#thrive',
				'show'        => SQ_Classes_Helpers_Tools::isPluginInstalled( 'thrive-visual-editor/thrive-visual-editor.php' ),
			),//Live Assistant Thrive Architect
			array(
				'title'       => "Bricks Website Builder",
				'description' => "The SEO Live Assistant <strong>works on the front-end of Bricks Website Builder</strong>, just as you're creating or editing your Bricks page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#bricks',
				'show'        => SQ_Classes_Helpers_Tools::isThemeActive( 'bricks' ),
			),//Live Assistant Bricks Website Builder
			array(
				'title'       => "WPBakery Page Builder",
				'description' => "The SEO Live Assistant <strong>works on the front-end of WPBakery Page Builder</strong>, just as you're creating or editing your WPBakery page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#wpbakery',
				'show'        => SQ_Classes_Helpers_Tools::isPluginInstalled( 'js_composer/js_composer.php' ),
			),//Live Assistant WPBakery Builder
			array(
				'title'       => "Zion Editor",
				'description' => "The SEO Live Assistant <strong>works on the front-end of Zion Editor</strong>, just as you're creating or editing your Zion page.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => 'sq_sla_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-message',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#zion',
				'show'        => SQ_Classes_Helpers_Tools::isPluginInstalled( 'zionbuilder/zionbuilder.php' ),
			),//Live Assistant Zion Editor
			array(
				'title'       => "Blogging Assistant",
				'description' => "Add relevant <strong>Copyright-Free images, Wikis, Blog Excerpts</strong> in your posts.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-messages',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#live_assistant_box',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			), //Blogging Assistant
			array(
				'title'       => "Settings Assistant",
				'description' => "With many of the Assistant panels in all Squirrly Settings pages, all a user needs to do is to complete tasks and turn Red dots into Green dots.",
				'category'    => "Assistants",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-sliders-up',
				'link'        => false,
				'details'     => false,
				'show'        => true,
			),//Live Assistant Elementor
			array(
				'title'       => "On-Page SEO METAs",
				'description' => "Add all the required Search Engine METAs like <strong>Title Meta, Description, Canonical Link, Dublin Core, Robots Meta</strong> and more.",
				'category'    => "METAs Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_metas',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_metas' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-code-simple',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-metas/',
				'show'        => true,
			), //On-Page SEO METAs
			array(
				'title'       => "Bulk SEO & Snippets",
				'description' => "Simplify the SEO process to <strong>Optimize all the SEO Snippets</strong> in just minutes. Edit Snippets in BULK for all post types directly from All Snippets",
				'category'    => "METAs Features",
				'mainfeature' => "Optimize Multiple Pages",
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-block-brick',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				'details'     => 'https://howto12.squirrly.co/kb/bulk-seo/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_bulkseo' ),
			),//Bulk SEO
			array(
				'title'       => "Frontend SEO Snippet",
				'description' => "Optimize each page by loading the <strong>SEO Snippet directly on the front-end</strong> of your site. You have <strong>Custom SEO</strong> directly in the WP Admin Toolbar.",
				'category'    => "METAs Features",
				'mainfeature' => false,
				'option'      => 'sq_use_frontend',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_use_frontend' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-align-justify',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-metas/#Add-Snippet-in-Frontend',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			),//Frontend SEO Snippet
			array(
				'title'       => "Fetch SEO Snippet",
				'description' => sprintf( "Automatically <strong>fetch the Squirrly Snippet</strong> on %sFacebook Sharing Debugger%s every time you update the content on a page.", '<a href="https://developers.facebook.com/tools/debug/" target="_blank">', '</a>' ),
				'category'    => "METAs Features",
				'mainfeature' => false,
				'option'      => 'sq_sla_social_fetch',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_sla_social_fetch' ),
				'optional'    => true,
				'connection'  => true,
				'logo'        => 'fa-solid fa-arrows-repeat',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/squirrly-live-assistant/#fetch_social',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_assistant' ),
			), //
			array(
				'title'       => "Remove META Duplicate",
				'description' => "Fix Duplicate Title, Description, Canonical, Dublin Core, Robots and more without writing a line of code.",
				'category'    => "METAs Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-copy',
				'link'        => false,
				'details'     => 'https://howto12.squirrly.co/kb/seo-metas/#remove_duplicates',
				'show'        => true,
			), //Remove META Duplicate
			array(
				'title'       => "Import SEO & Settings",
				'description' => "Import the settings and SEO from other plugins so you can use only Squirrly SEO for on-page SEO.",
				'category'    => "Import Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-arrow-up-from-bracket',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'backup' ),
				'details'     => 'https://howto12.squirrly.co/kb/import-export-seo-settings/',
				'show'        => true,
			), //Import SEO & Settings
			array(
				'title'       => "SEO Links",
				'description' => "Increase the <strong>website authority</strong> by correctly managing all the external links on your website. Instantly add <strong>nofollow</strong> to all external links.",
				'category'    => "Links Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_links',
				'active'      => (bool) SQ_Classes_Helpers_Tools::getOption( 'sq_auto_links' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-link',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=links' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-links/',
				'show'        => true,
			), //SEO Links
			array(
				'title'       => "Inner Links",
				'description' => "Increase the <strong>website authority</strong> by correctly managing all the inner links to the Focus Pages.",
				'category'    => "Links Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_innelinks',
				'active'      => (bool) SQ_Classes_Helpers_Tools::getOption( 'sq_auto_innelinks' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-link',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'innerlinks' ),
				'details'     => 'https://howto12.squirrly.co/kb/focus-pages-innerlinks',
				'keywords'    => 'innerlink,innerlinks,backlink,backlinks',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_innerlinks' ),
			), //SEO Links
			array(
				'title'       => "404 URLs Redirects",
				'description' => "Automatically <strong>redirect 404 URLs</strong> to the new URLs and keep the post authority. You can manage the <strong>Redirect Broken URLs</strong> for each post type.",
				'category'    => "Links Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-angles-right',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation', array( '#tab=sq_post' ) ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-automation/#redirect_broken_urls',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_redirects' ),
			), //404 Redirects
			array(
				'title'       => "Auto-Indexing",
				'description' => "Add the <strong>Auto-Indexing</strong> option to automatically send links to search engines like Bing and Yandex.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_indexnow',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_indexnow' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-upload',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_indexnow', 'submit' ),
				'details'     => '',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_indexnow' ),
			), //Auto-Indexing
			array(
				'title'       => "Google Analytics Tracking",
				'description' => "Add the <strong>Google Analytics</strong> and <strong>Google Tag Manager</strong> tracking on your website.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_tracking',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_tracking' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-chart-line-up',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster#tab=trackers' ),
				'details'     => 'https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#google_analytics',
				'show'        => true,
			), //Google Analytics Tracking
			array(
				'title'       => "Google Search Console (GSC)",
				'description' => "Connect your website with <strong>Google Search Console</strong> and get insights based on <strong>organic searched keywords</strong>.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_webmasters',
				'active'      => ( isset( $connect['google_search_console'] ) ? $connect['google_search_console'] : true ),
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fasq-brands fa-google',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'settings' ),
				'details'     => 'https://howto12.squirrly.co/kb/ranking-serp-checker/#google_search_console',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ),
			), //Google Search Console
			array(
				'title'       => "Webmaster Tools",
				'description' => "Connect your website with the popular webmasters like <strong>Google Search Console (GSC), Bing, Baidu, Yandex</strong>.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_webmasters',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_webmasters' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-wrench',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster#tab=connect' ),
				'details'     => 'https://howto12.squirrly.co/kb/webmaster-tools-settings/',
				'show'        => true,
			), //Webmaster Tools
			array(
				'title'       => "Plugins Integration",
				'description' => "Squirrly SEO works with all websites types and popular plugins like <strong>E-commerce plugins, Page Builder plugins, Cache plugins, SEO plugins, Multilingual plugins, and more</strong>.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => false,
				'details'     => 'https://howto12.squirrly.co/',
				'show'        => true,
			), //
			array(
				'title'       => "Moz",
				'description' => "Receive information about <strong>Backlinks and Authority from Moz.com</strong> directly in your SEO Audit report.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-audit/#moz',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
			), //SEO Audit Moz
			array(
				'title'       => "Majestic",
				'description' => "Receive information about <strong>Backlinks from Majestic.com</strong> directly in your Focus Pages report.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'details'     => 'https://howto12.squirrly.co/kb/focus-pages-page-audits/#page_authority',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
			), //SEO Focus Pages Majestic
			array(
				'title'       => "Semrush",
				'description' => "Receive <strong>Semrush Rank and Backlinks</strong> information directly in your Audit report.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-audit/#semrush',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
			), //SEO Audit Semrush
			array(
				'title'       => "Polylang",
				'description' => "<strong>Multilingual Support</strong> with Polylang plugin for fast multilingual optimization. Load Squirrly Live Assistant, SEO Snippets and Sitemap XML based on Polylang language.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				'details'     => 'https://howto12.squirrly.co/wordpress-seo/compatibility-with-polylang-plugin/',
				'show'        => ( SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang/polylang.php' ) || SQ_Classes_Helpers_Tools::isPluginInstalled( 'polylang-pro/polylang.php' ) ),
			), //
			array(
				'title'       => "WooCommerce SEO",
				'description' => "<strong>Optimize all WooCommerce Products</strong> with Squirrly Live Assistant for better ranking. Add the required Metas, Google Tracking, Facebook Pixel Events and JSON-LD Schema. Useful for loading Rich Snippets on Google search results.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo', array( 'stype=product' ) ),
				'details'     => 'https://howto12.squirrly.co/kb/json-ld-structured-data/#woocommerce',
				'show'        => SQ_Classes_Helpers_Tools::isEcommerce(),
			), //
			array(
				'title'       => "ACF Integration",
				'description' => "Use <strong>Advanced Custom Fields (ACF)</strong> plugin to add advanced and custom JSON-LD Schema code on your pages.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fa-solid fa-puzzle-piece',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'jsonld' ),
				'details'     => 'https://howto12.squirrly.co/kb/json-ld-structured-data/#ACF',
				'keywords'    => 'rich,snippets,jsonld,advanced,custom,fields,acf,video',
				'show'        => SQ_Classes_Helpers_Tools::isPluginInstalled( 'advanced-custom-fields/acf.php' ),
			), //Advanced Custom Fields
			array(
				'title'       => "Google News",
				'description' => "For a news website it's really important to have a Google News Sitemap. This way you will have <strong>all your News Posts instantly on Google News</strong>.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => ( $sitemap['sitemap-news'][1] == 1 ),
				'optional'    => false,
				'connection'  => false,
				'logo'        => 'fasq-brands fa-google',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks' ),
				'details'     => 'https://howto12.squirrly.co/kb/sitemap-xml-settings/#news_sitemap',
				'show'        => true,
			), //Sitemap Instant Indexing
			array(
				'title'       => "AMP Support",
				'description' => sprintf( "Automatically load the <strong>Accelerate Mobile Pages (AMP)</strong> support for plugins like %sAMP for WP%s or %sAMP%s.", '<a href="https://wordpress.org/plugins/accelerated-mobile-pages/" target="_blank">', '</a>', '<a href="https://wordpress.org/plugins/amp/" target="_blank">', '</a>' ),
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_amp',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_amp' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-bolt',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster#tab=amp' ),
				'details'     => 'https://howto12.squirrly.co/kb/google-analytics-tracking-tool/#amp_support',
				'keywords'    => 'mobile,pad,speed',
				'show'        => true,
			), //
			array(
				'title'       => "Google PageSpeed Insights",
				'description' => "Get precise information about the <strong>Average Loading Time</strong> of your website using Google PageSpeed Insights in your SEO Audit report.",
				'category'    => "Integration Features",
				'mainfeature' => false,
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-gauge-high',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-audit/#google_pagespeed',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
			), //SEO Audit Google PageSpeed
			array(
				'title'       => "Google SERP Checker",
				'description' => "Accurately track your <strong>Google Rankings every day</strong> with Squirrly's user-friendly Google SERP Checker.",
				'category'    => "Integration Features",
				'mainfeature' => 'See Your Keywords Positions',
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-chart-line',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_rankings', 'rankings' ),
				'details'     => 'https://howto12.squirrly.co/kb/ranking-serp-checker/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ),
			), //Google SERP Checker
			array(
				'title'       => "SEO Audit",
				'description' => "Improve your Online Presence by knowing how your website is performing online. <strong>Generate and Compare SEO Audits</strong> and follow the Assistant to optimize the website.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => "Learn More About Your Site",
				'option'      => false,
				'active'      => true,
				'optional'    => false,
				'connection'  => true,
				'logo'        => 'fa-solid fa-chart-column',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-audit/',
				'show'        => SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ),
			), //SEO Audit
			array(
				'title'       => "Sitemap XML",
				'description' => "Use Sitemap Generator to <strong>help your website get crawled</strong> and indexed by Search Engines. Add Sitemap Support for News, Posts, Pages, Products, Tags, Categories, Taxonomies, Images, Videos, etc.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_sitemap',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-map',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks' ),
				'details'     => 'https://howto12.squirrly.co/kb/sitemap-xml-settings/',
				'show'        => true,
			), //XML Sitemap
			array(
				'title'       => "JSON-LD Structured Data",
				'description' => "Edit your website's JSON-LD Schema with Squirrly's powerful <strong>semantic SEO Markup Solution</strong>. Use the built-in Structured Data or add your custom Schema code.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_jsonld',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-barcode-read',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'jsonld' ),
				'details'     => 'https://howto12.squirrly.co/kb/json-ld-structured-data/',
				'keywords'    => 'rich,snippets,jsonld,video',
				'show'        => true,
			), //JSON-LD Optimizaition
			array(
				'title'       => "Personal Brand Rich Snippets",
				'description' => "Edit your website's personal brand Schema with Squirrly's powerful <strong>semantic SEO Markup Solution</strong>. If your website is a personal website, you need to add the author data to build a valid JSON-LD.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_jsonld_personal',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_jsonld_personal' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-barcode-read',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'jsonld#tab=personal' ),
				'details'     => 'https://howto12.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Profile',
				'keywords'    => 'rich,snippets,jsonld,personal,video',
				'show'        => true,
			), //JSON-LD Optimizaition
			array(
				'title'       => "Robots.txt File",
				'description' => "Tell search engine crawlers which pages or files the crawler can or can't request from your site.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_robots',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fasq-brands fa-android',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=robots' ),
				'details'     => false,
				'show'        => true,
			), //Robots.txt File
			array(
				'title'       => "Favicon Site Icon",
				'description' => "Add your <strong>website icon</strong> in the browser tabs and on other devices like <strong>iPhone, iPad and Android phones</strong>.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_favicon',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_favicon' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-image',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=favicon' ),
				'details'     => 'https://howto12.squirrly.co/kb/website-favicon-settings/',
				'show'        => true,
			), //Favicon Site Icon
			array(
				'title'       => "Local SEO",
				'description' => "Optimize the website for <strong>local audience</strong> to have a huge advantage in front of your competitors.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => false,
				'option'      => 'sq_auto_jsonld_local',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_jsonld_local' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-location-dot',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'jsonld', array( '#localseo' ) ),
				'details'     => 'https://howto12.squirrly.co/kb/json-ld-structured-data/#local_seo',
				'show'        => true,
			), //
			array(
				'title'       => "SEO Automation",
				'description' => "Configure the <strong>SEO in 2 minutes</strong> for the entire website without writing a line of code.",
				'category'    => "Miscellaneous Features",
				'mainfeature' => "Make Your Site SEO Ready",
				'option'      => 'sq_auto_pattern',
				'active'      => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ),
				'optional'    => true,
				'connection'  => false,
				'logo'        => 'fa-solid fa-bolt',
				'link'        => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'automation' ),
				'details'     => 'https://howto12.squirrly.co/kb/seo-automation/',
				'show'        => true,
				'keywords'    => 'pattern,patterns,automation,seo'
			),//SEO Automation


		);

		//for PHP 7.3.1 version
		$features = array_filter( $features );

		$features = apply_filters( 'sq_features', $features );

		usort( $features, function ( $a, $b ) {
			return $a['category'] <=> $b['category'];
		} );

		return $features;
	}


	/**
	 * Called when action is triggered
	 *
	 * @return void
	 */
	public function action() {
		parent::action();

		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippet' ) ) {
			if ( SQ_Classes_Helpers_Tools::isAjax() ) {
				wp_send_json_error( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );
			} else {
				SQ_Classes_Error::setError( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ) );
			}
		}

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_features_search':

				$search      = (string) SQ_Classes_Helpers_Tools::getValue( 'sfeature', '' );
				$this->features = SQ_Classes_ObjController::getClass( 'SQ_Core_BlockFeatures' )->getFeatures();

				//Search in the features
				if ( $search <> '' ) {
					foreach ( $this->features as $index => $feature ) {

						if ( isset( $feature['show'] ) && ! $feature['show'] ) {
							unset( $this->features[ $index ] );
							continue;
						}

						$this->features[ $index ]['relevant'] = 0;

						$sfeatures = SQ_Classes_Helpers_Tools::getValue( 'sfeature' );
						$sfeatures = explode( ' ', $sfeatures );
						if ( ! empty( $sfeatures ) ) {
							$found = 0;

							foreach ( $sfeatures as $sfeature ) {
								if ( $sfeature <> '' ) {
									if ( stripos( $feature['title'], $sfeature ) !== false ) {
										$found ++;
									}
									if ( stripos( $feature['description'], $sfeature ) !== false ) {
										$found ++;
									}
									if ( isset( $feature['keywords'] ) && $feature['keywords'] <> '' ) {
										if ( SQ_Classes_Helpers_Tools::findStr( $feature['keywords'], $sfeature ) !== false ) {
											$found ++;
										}
									}
								}
							}

							if ( ! $found ) {
								$this->features[ $index ]['show'] = false;
							} else {
								$this->features[ $index ]['relevant'] = $found;
							}

						}
					}

					usort( $this->features, function ( $a, $b ) {
						return ( $a['relevant'] > $b['relevant'] ) ? - 1 : 1;
					} );

				}

				break;
		}

	}
}
