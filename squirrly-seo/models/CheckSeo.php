<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_CheckSeo {

	/**
	 *
	 *
	 * @var object Checkin process with Squirrly Cloud
	 */
	public $checkin;

	public $html = false;
	public $focuspages = false;
	public $ranks = false;
	public $dbtasks = false;
	public $siteaudit = false;
	public $category_name;

	public function __construct() {
		$this->category_name = apply_filters( 'sq_page', SQ_Classes_Helpers_Tools::getValue( 'page', 'sq_dashboard' ) );

		//load the tasks options
		$this->dbtasks = json_decode( get_option( SQ_TASKS ), true );
		if ( ! isset( $this->dbtasks[ $this->category_name ] ) ) {
			$this->dbtasks[ $this->category_name ] = array();
		}
	}

	public function getWiki() {
		return array(
			'Rank'      => 'https://www.squirrly.co/seo/wiki/search-engine/rank/',
			'Public'    => 'https://www.squirrly.co/seo/wiki/website/public/',
			'Indexable' => 'https://www.squirrly.co/seo/wiki/search-engine/indexable/',
			'Display'   => 'https://www.squirrly.co/seo/wiki/search-engine/display/',
		);
	}

	public function getTasks() {
		return array(
			'getPrivateBlog'      => array(
				'completed' => false,
				'warning'   => esc_html__( "Make your site Visible asap", 'squirrly-seo' ),
				'message'   => sprintf( esc_html__( "If you want Google (or any other search engine) to Display your pages and then Rank them higher in search results, your website needs to be Public and the pages indexable. Currently, a setting in your WordPress makes this impossible. You selected '%s' in %sSettings > Reading%s. You need to UNCHECK that option.", 'squirrly-seo' ), esc_html__( "Discourage search engines from indexing this site", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'options-reading.php' ) . '" >', '</a>' ),
				'solution'  => sprintf( esc_html__( "Uncheck the option: %s in %sSettings > Reading%s.", 'squirrly-seo' ), '<strong>' . esc_html__( "Discourage search engines from indexing this site", 'squirrly-seo' ) . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'options-reading.php' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Google can't show your site to anybody, because you haven't made your site public and indexable. You must fix this today.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'options-reading.php' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => false,
				'tools'     => array(),
				'time'      => 10
			),
			'getNoTitle'          => array(
				'completed' => false,
				'warning'   => esc_html__( "Get the meta title tag in the front-end", 'squirrly-seo' ),
				'message'   => esc_html__( "Without the title tag in the front-end, search engines will 'think' that your website is broken. Currently the title tag is missing in front-end.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %s Squirrly > Technical SEO > SEO Metas %s and switch on 'Optimize the Titles'. If it's already switched on, check if another plugin is stopping Squirrly from showing the Title.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You have to make the Title tag of the page visible in the front-end of the website. As soon as possible. Otherwise, you will have difficulty ranking.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 10
			),
			'getAMPWebsite'       => array(
				'completed' => false,
				'warning'   => esc_html__( "Turn Squirrly's AMP Support to ON", 'squirrly-seo' ),
				'message'   => esc_html__( "AMP site detected and Squirrly's AMP Support is OFF - If this website is an AMP website you need to make sure that you activate Squirrly AMP Tracking for it. Squirrly will load Google Analytics and Facebook Pixel for AMP and avoid AMP script errors.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Activate AMP tracking in %s Squirrly > Technical SEO > Connect Tools > AMP %s ", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster#tab=amp' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You must activate the AMP settings for Squirrly SEO, right now. Otherwise, the AMP version of the site will have missing pieces.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster#tab=trackers' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 10
			),
			'getSeoSquirrlyTitle' => array(
				'completed' => false,
				'warning'   => esc_html__( "Activate Squirrly SEO Title Now", 'squirrly-seo' ),
				'message'   => esc_html__( "Squirrly SEO title is NOT active for your website. If you DON'T use other SEO plugins, you should activate this option, and Squirrly SEO will add the Title tag on each page of your website and remove any duplicates. Your title tag determines your display title in SERPs, and it’s meant to help Google and human readers understand what your pages are all about", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %s  Squirrly > Technical SEO > SEO Metas%s and switch on: 'Optimize the Titles'", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You should activate the Squirrly SEO title to help Search Engines understand what your pages are about and ensure all of your pages have titles.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 10
			),
			'getBadLinkStructure' => array(
				'completed' => false,
				'warning'   => esc_html__( "Make your LINKS SEO-Friendly", 'squirrly-seo' ),
				'message'   => esc_html__( "Google considers the URLs you use on your website to be a ranking factor. The permalinks you use and the structure you decide on adopting is ultimately an SEO signal. Having a good permalink structure also helps make your site Human-friendly. ", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Your URLs should be super easy to read. Go to your  %s WordPress dashboard > Settings > Permalinks %s .There,  you can create a custom URL structure for your permalinks.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'options-permalink.php' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Make your LINKS SEO-Friendly. You're losing potential rankings at the moment.", 'squirrly-seo' ),
				'link'      => admin_url( 'options-permalink.php' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => true,
				'time'      => 10
			),
			'getSitemap'          => array(
				'completed' => false,
				'warning'   => esc_html__( "Activate the Sitemap from Squirrly", 'squirrly-seo' ),
				'message'   => esc_html__( "XML sitemaps help search engines and spiders discover new pages on your website. It also helps them better understand the structure of your website. Activate your Sitemap XML setting. Squirrly SEO will then generate your sitemap, according to different items you can set up.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %s Squirrly > Technical SEO > Tweaks And Sitemap %s to setup the sitemap. Choose for which types of URLs you'll want to have sitemaps. It depends on your strategy. Leave the defaults if you're uncertain.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks', array( '#tab=sitemap' ) ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Lead Search Engines to your most important pages using XML sitemaps. Do this and you can rank better. ", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 30
			),
			'getRobots'           => array(
				'completed' => false,
				'warning'   => esc_html__( "Get a robots txt file", 'squirrly-seo' ),
				'message'   => esc_html__( "Robots.txt is a text file webmasters create to instruct how to crawl & index pages on their website. You can use this file to tell search engine robots what to crawl and what not to crawl on your site. Search bots usually look for this file in a website as soon as they enter one. Therefore, it's very important to have a robots.txt file in the first place.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %s Squirrly > Technical SEO > Tweaks And Sitemap > Robots File %s and switch on Activate Robots. If it's already switched on, check if another plugin is stopping Squirrly from adding the Robots.txt URL.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=robots' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You should help Search Engine bots find what they need. Create a Robots.txt file as soon as possible if you want your site to be seen in Search Results.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=robots' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 1,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 10
			),

			'ErrorFocusPages'              => array( //MISSING FOCUS PAGES
				'completed' => false,
				'warning'   => esc_html__( "Error detected for your Focus Page", 'squirrly-seo' ),
				'message'   => sprintf( esc_html__( "An error is preventing Squirrly from accessing and retrieving critical data about your Focus Page. You should fix this so that Squirrly can generate a complete audit of your page and show you what you need to do to improve its chances of ranking. %sThe error can also prevent human visitors from accessing your page, which is a critical issue. ", 'squirrly-seo' ), '<br />' ),
				'solution'  => esc_html__( "Use a different browser to make sure your Focus Page is visible. Whitelist our crawler IP address (5.161.83.61) to allow our server to verify your page so that you’ll receive a full audit.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Make sure that your Focus Page is published and can be accessed by all users and crawlers.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 2,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 50
			),
			'NoFocusPages'                 => array( //MISSING FOCUS PAGES
				'completed' => false,
				'warning'   => esc_html__( "Add Focus Page. It's the first step to reaching TOP positions", 'squirrly-seo' ),
				'message'   => esc_html__( "Adding a Focus Page, and then using the SEO Goals related to it, is a sure way for all aspiring SEO Stars to begin reaching top positions in Google. SEO is very complicated, and Focus Pages is the only method that helps you un-complicate it. By following this method you will build a repeatable, smart strategy, powered by Machine Learning.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly SEO > Focus Pages > Add New Page%s to add a page in Focus Pages.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'addpage' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You don't currently have a clearly defined strategy. If you're a Non-SEO Expert you won't be able to reach TOP 10 rankings without Focus Pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'addpage' ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 2,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => false
			),
			'getDefaultTagline'            => array(
				'completed' => false,
				'warning'   => esc_html__( "Change WordPress' default tagline", 'squirrly-seo' ),
				'message'   => esc_html__( "The default WordPress tagline is “Just another WordPress site” - which is like saying your site is nothing special. It's important to customize it so that you clearly communicate what your site is about to first-time visitors. Search Engines also pay close attention to taglines.", 'squirrly-seo' ),
				'solution'  => esc_html__( "How you optimize your tagline can depend on the theme you are using (some themes don't display the tagline automatically). Your best bet is to go to Appearance > Customize from your WP dashboard to access the Customizer. There, you can customize your tagline. Best Practices: Make sure your tagline is catchy and reflects your site as a whole (its niche, purpose, the content that can be found on your site. Include strong keywords in your tagline, and ensure the tagline fits with your overall branding strategy.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Optimize your tagline so that your site is NOT 'Just another WordPress site' (or: Optimize your tagline to put your site’s best foot forward and encourage visitors to stick around.)", 'squirrly-seo' ),
				'link'      => admin_url( 'options-general.php' ),
				'color'     => 'red',
				'bullet'    => false,
				'priority'  => 3,
				'ignorable' => true,
				'time'      => 30
			),
			'FocusPagesNoindex'            => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Remove all no-index tags from all Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "No-index tags suggest to search engines (most notably Google) NOT to index a specific webpage. By using these tags for your Focus Pages, you're preventing them from appearing in Google Search. This is bad, because it means Search Engines won't show your most important pages (which should be your Focus Pages). Removing all no-index tags for your Focus Pages will fix it.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Look at all the places where you could have added instructions for Google not to index this page from your site. Make sure that there is no such instruction added to %sWordPress > Settings%s, or in a theme, or in a plugin, or in %sSquirrly SEO's Snippet%s for this page. Also, make sure you don't block this page in your %sRobots.txt%s file.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'options-reading.php' ) . '" >', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" >', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=robots' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You must remove all no-index tags for your Focus Pages so that they will appear in Google Search.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=indexability' ) ),
				'color'     => 'red',
				'bullet'    => false,
				'priority'  => 3,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'SEO Snippet', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'FocusPagesVisibility'         => array(
				'completed' => false,
				'warning'   => esc_html__( "Fix all Visibility issues for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Having visibility issues for your Focus Pages means that your Focus Pages may not appear in search results. This is bad, because you'll want as many people to see your most important pages (your Focus Pages)", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %s Squirrly > Focus Pages %s and make sure all elements you see when you click on the Visibility category are completed. If you see a task that is NOT done, follow the indications to complete it. If you see a red element, follow the indications to turn it Green. That's how you make sure your Focus Pages are protected against Visibility Issues.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=indexability' ) ) . '" target="_blank">', '</a>' ),
				'goal'      => esc_html__( "Fix ALL Visibility issues for your Focus Pages so that they will appear on Google Search.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=indexability' ) ),
				'color'     => 'red',
				'bullet'    => false,
				'priority'  => 3,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 300
			),
			'getSafeBrowsing'              => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Make Your Site Safe for Browsing Again", 'squirrly-seo' ),
				'message'   => esc_html__( "Safe Browsing notifies webmasters when their websites are compromised by malicious actors and helps them diagnose and resolve the problem so that their visitors stay safe.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %shttps://safebrowsing.google.com/%s and follow the instructions to clean your website.", 'squirrly-seo' ), '<a href="https://safebrowsing.google.com/" target="_blank">', '</a>' ),
				'goal'      => esc_html__( "Make Your Site Safe for Browsing Again", 'squirrly-seo' ),
				'link'      => 'https://safebrowsing.google.com/',
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 3,
				'ignorable' => true,
				'time'      => 300
			),
			'getDuplicateOG'               => array(
				'completed' => false,
				'warning'   => esc_html__( "Remove Duplicate Open Graph meta tags", 'squirrly-seo' ),
				'message'   => esc_html__( "Some WordPress themes and plugins add Open Graph meta tags which lead to duplicate Open Graph meta tags issues. It's important to check for this to determine which plugin or if your theme is generating the duplicate open graph meta tag. In this case, the plugin or theme causing this manages to bypass Squirrly's Duplicate Remover features.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Start deactivating plugins (other than Squirrly SEO) from your WordPress site. Run New Scans for Next SEO Goals to see if you managed to get this done! Then reactivate everything.", 'squirrly-seo' ),
				'goal'      => esc_html__( "You need to remove Duplicate Open Graph meta tags as soon as possible. Otherwise, you will miss good chances of ranking higher with your pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social' ),
				'color'     => 'red',
				'bullet'    => false,
				'priority'  => 4,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 300
			),
			'getDuplicateTC'               => array(
				'completed' => false,
				'warning'   => esc_html__( "Remove Duplicate Twitter cards tags", 'squirrly-seo' ),
				'message'   => esc_html__( "Some WordPress themes and plugins add Twitter Card meta tags which lead to duplicate Twitter card meta tags issues. It's important to check for this and determine which plugin or if your theme is generating the duplicate open graph meta tag. In this case, the plugin or theme causing this, manages to bypass Squirrly's Duplicate Remover features.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Start deactivating plugins (other than Squirrly SEO) from your WordPress site. Run New SEO Tests for Next SEO Goals to see if you manage to get this done! Then reactivate everything.", 'squirrly-seo' ),
				'goal'      => esc_html__( "You need to remove Duplicate Twitter Card meta tags as soon as possible; Otherwise you will miss good chances of ranking higher with your pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'social#tab=twittercard' ),
				'color'     => 'red',
				'bullet'    => false,
				'priority'  => 4,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 300
			),
			'BriefcaseKeywords'            => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Use Squirrly's Expert-Grade Research Tool and Add Keywords to Briefcase", 'squirrly-seo' ),
				'message'   => esc_html__( "With a few clicks, you'll do the work that SEO experts charge thousands of dollars for (because they do this manually and it takes too much time that way).", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > AI Research%s. Complete all steps until you get to the final table with all of the data for each keyword. Add at least one keyword to Briefcase from that interface.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You should perform a keyword research using Squirrly's Expert-Grade tool and store at least one of the results in Briefcase.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 5,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Briefcase', 'squirrly-seo' )
				),
				'time'      => 600
			),
			'FocusPagesKeywordOptimized30' => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Optimize your Focus Page with the great keyword you found during Keyword research", 'squirrly-seo' ),
				'message'   => esc_html__( "So far, only experts knew how to improve search relevance, which is one of the biggest reasons why Google will choose your page to show up first. You're well on your way to becoming a SEO Star. Now you can do all this on your own by using the SEO Live Assistant and the keywords you stored to briefcase.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Optimize up to 30% for a keyword you already stored to briefcase. Using the SEO Live Assistant which you find in Edit Post interfaces in WP. Reindex page with Google Search Console when you are done.", 'squirrly-seo' ),
				'goal'      => esc_html__( "You must optimize all Focus Pages using a main keyword. This will improve search relevance and you'll improve your site with something that only experts were able to do before Squirrly.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=content' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 5,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			'FocusPagesKeyword'            => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Optimize your text to get a good Search Relevance score", 'squirrly-seo' ),
				'message'   => esc_html__( "There is no point in ranking your  content for a query that doesn’t match what the user is looking for. Keywords help visitors find what they want, which is why you should optimize your Focus Page using keywords. This way, your page will be displayed to search users who are actually interested in seeing the content provided in it.  Choose different keywords for each of your Focus pages. That way, instead of competing with each other, your pages can compete with other sites within your industry.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "To get this done, the text itself (the written words of the page) needs to be optimized using Squirrly's SEO Live Assistant. Go to Edit Post and start using the %sSEO Live Assistant%s", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'assistant' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Ensure your Focus Page has Search relevancy by optimizing  it using a keyword. Otherwise, that Focus Page will not be displayed in Search Results.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=keyword' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 6,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			'FocusPagesKeywordResearched'  => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Research your Focus Page's keyword", 'squirrly-seo' ),
				'message'   => esc_html__( "For at least one of your Focus Pages, I see that you optimized for search relevance using the SEO Live Assistant.  However, you need to be able to read the Search Volume, Competition and the Recent Discussions for the keyword. Otherwise, you might be going with a keyword that can't be ranked, or can't bring traffic. Your SEO Star skills depend on this goal.", 'squirrly-seo' ),
				'solution'  => esc_html__( "See the keyword. Place it in the research feature and perform a full keyword research on it. Then add it to briefcase.", 'squirrly-seo' ),
				'goal'      => esc_html__( "You must obtain keyword data for all main keywords used for your Focus Pages. This will improve your skills and your understanding.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=keyword' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 6,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 600
			),
			'FocusPagesKeywordCompetition' => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Choose less competitive keywords", 'squirrly-seo' ),
				'message'   => esc_html__( "As a future SEO Star you need to understand that you will never be able to rank for any keyword you think about. Not even huge sites who have spent a thousand times more money on their SEO can do that. Just switch to a different keyword and you will get to the desired results (ranking and traffic). This is real SEO you are doing right now. You're acting like an expert.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Go and edit the page using the SEO Live Assistant. Select a different keyword as the main keyword. Make sure it has a Green light at 'competition'.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Replace the main keyword you chose for your Focus Page to get top rankings. Your page can't compete and reach the top 10 positions in Google for the current keyword. ", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=keyword' ) ),
				'bullet'    => true,
				'priority'  => 7,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 600
			),
			'FocusPagesKeywordOptimized60' => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Try to boost traffic by over +285&#37; by optimizing with SEO Live Assistant", 'squirrly-seo' ),
				'message'   => esc_html__( "Our data shows that users who optimize their content over 60% using the Live Assistant get up to +285% increase in traffic compared to those who optimize below this percentage. As a future SEO Star, you need to practice optimizing your content as much as you can.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Your text needs to be optimized to over 60% using the SEO Live Assistant. Re-index your pages with Google Search Console after you finish optimizing.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Optimize Your Focus Pages over 60% to get up to 285% increase in traffic.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=content' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 8,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			//////
			'FocusPagesIndexed'            => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Make a Manual Index Request for your Focus Pages With GSC", 'squirrly-seo' ),
				'message'   => esc_html__( "Whenever you've added or made changes to a page on your site, you should ask for Google to re-index your page. This will help getting the new content in Google's index. Don't expect Google to index the latest version of your page if you skip doing this. As a SEO Star you need to start building a strong muscle for doing this. Requesting re-index will need to become a habit to you.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > Focus Pages%s - identify the page that hasn't had a new index request and use the button to go to GSC and request re-index. %sLearn how to manually index the URL on Google Search Console%s", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=indexability' ) ) . '" >', '</a>', '<br /><br /><a href="https://howto12.squirrly.co/kb/focus-pages-page-audits/#visibility" target="_blank">', '</a>' ),
				'goal'      => esc_html__( "Let Google know you've made changes to your Focus Pages. Otherwise, nothing will change in search results. This is mandatory.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=indexability' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 10,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 60
			),
			'UsedBriefcaseInSerpCheck'     => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Add your keywords to the Rankings section of Squirrly SEO", 'squirrly-seo' ),
				'message'   => esc_html__( "SEO pros are always diligent about monitoring their rankings. If you want to be an SEO star, you need to track your success and make data-driven decisions. By adding your Focus Page's keyword to the Rankings section, you'll know the true position of your website in Google for that keyword. Checking the keyword yourself, manually, will give you fake information. You can ask us why on our Facebook Group.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > Research > Briefcase%s. Find your Focus Page's keyword from the list, and click on the three dots you see on the far right. Then click on Send to Rank Checker.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "See how your SEO efforts translate into results by adding your Focus Page's keyword to the Rankings section.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 11,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Briefcase', 'squirrly-seo' ),
					esc_html__( 'Rankings', 'squirrly-seo' )
				),
				'time'      => 300
			),

			'HistoryRanking20'                => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Change the main keyword for a Focus Page that didn't reach TOP 20 rankings during the last 2 months", 'squirrly-seo' ),
				'message'   => esc_html__( "As a future SEO star, you need to be able to adapt and pivot. If you see something is not working, change it. Adapt. The current keyword you have for this page isn't bringing you top results. In the past 2 months, this keyword did NOT rank higher than the 21st position in Google. You can achieve better results by switching to a new keyword.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > Research%s and research new keyword ideas. Then get back to this page and use SEO Live Assistant to optimize it for a different main keyword.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'research' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Switch your target keyword to reach better results. Don't settle for the second page of Google.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 11,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'FocusPagesKeywordOptimized90'    => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Get to 90% Optimization Levels for all Focus Pages (using SEO Live Assistant)", 'squirrly-seo' ),
				'message'   => esc_html__( "Our data shows that users who achieve 90% Optimization Levels using the Live Assistant have a much better chance of achieving top Google Rankings for their pages. If you want to be an SEO star, you need to push yourself and get it all the way up to 90 (try 100). The more you practice, the easier it will be.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Go and edit your Focus Pages using the SEO live Assistant. Follow the guidance it provides to 100% optimize your page. Re-index your page with Google Search Console when you are done.", 'squirrly-seo' ),
				'goal'      => esc_html__( "You must Optimize to 90% to give your Focus Pages the best chances of achieving top Google Rankings.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=content' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 12,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			'FocusPagesDoFollowLinks'         => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Stop losing SEO Authority", 'squirrly-seo' ),
				'message'   => esc_html__( "You need to place rel='nofollow' to all Outbound links. Outbound links are URLs from 3rd party sites to which you are linking to. If you send links to Wikipedia, Facebook, Jamie Oliver, etc. without mentioning 'nofollow', then you are also sending them the authority you are trying to build up for your own site. That's really bad, and makes your pages unable to rank high enough. Because some links are hard for Non-SEO Experts to turn to 'nofollow' we recommend a plugin that does this for you. You can find it on [link]https://squirrly.co/seo/kit[/link]", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Place rel='nofollow' on outbound links yourself, use the plugin recommended by Squirrly that does this for you, or use %s Squirrly's SEO Links & Redirects option %s (%s Technical SEO > Tweaks & Sitemaps > SEO Links & Redirects > Add Nofollow to External Links %s)", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/kb/seo-links/#nofollow_external" target="_blank">', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks#tab=links' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Fix your outbound links. Otherwise, you will lose SEO authority.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=nofollow' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 13,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 300
			),
			'FocusPagesPlatformSEO'           => array(
				'completed' => false,
				'warning'   => esc_html__( "Reach Platform SEO green lights for all Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "You will be missing out on many ranking opportunities if you do not go and fix Platform SEO right now. If you do fix it, make sure you start requesting re-indexes for your pages, using Google Search Console. Your theme might be generating many types of pages, which are different from ordinary pages in WP. Reaching 'Platform SEO' Green lights is a very important objective.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > Focus Pages%s and look at the COLUMN with Platform SEO. Click on a dot to see all sub-tasks in the right sidebar of the plugin. Click on each item. Read the pop-up instructions and complete all tasks. Then re-index in Google Search Console. After that, request a new Focus Pages audit for the page you fixed.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=onpage' ) ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Reach Platform SEO green lights for all Focus Pages. Otherwise, you will keep giving Google faulty data, which can result in low rankings.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=onpage' ) ),
				'color'     => 'red',
				'bullet'    => true,
				'priority'  => 14,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'FocusPagesKeywordsFromBriefcase' => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Add SEO Context Keywords to your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Squirrly SEO's Live Assistant lets you optimize your pages for multiple keywords that you've placed in Briefcase. By optimizing your Focus Page for a secondary keyword that is related to your primary keywords, you're sending additional signals to search engines to help them understand and rank the page. Example: if you have page about 'dog food', you should optimize the page for one or two dog breeds as well, so that you make it clear to Google that it is about the animal 'dog', and NOT about a friend 'like in Yo, dog!'. On [link]https://squirrly.co/seo/kit/[/link] you can see a video that shows how to add SEO context to a page.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Optimize your Focus Page for a secondary keyword using the Live Assistant. Optimize it to at least 30% and re-index the page with Google Search Console when you're done.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Help Google understand the exact topic and context of your page so that it will rank it higher.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=strategy' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 15,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' ),
					esc_html__( 'Multiple Keyword Optimization', 'squirrly-seo' )
				),
				'time'      => 2400
			),
			'ExtraUsedBriefcaseInSerpCheck'   => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Add all secondary Keywords you've used to the Rankings Section of Squirrly", 'squirrly-seo' ),
				'message'   => esc_html__( "Most people expect only the main keyword to be ranked in TOP 10 in Google. However, according to the secondary keywords you've used to build up SEO Context for your Focus Page, you may find out that your secondary keywords also got great rankings on Google.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Add your secondary keywords (the secondary keywords you used for your Focus Pages) inside the Rankings Section.", 'squirrly-seo' ),
				'goal'      => esc_html__( "As an SEO Star who worked hard on the pages and managed to optimize for secondary keywords, you need to check if you get more results than you expected.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 15,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Briefcase', 'squirrly-seo' ),
					esc_html__( 'Rankings', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'FocusPagesKeywordsInImage'       => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Fix SEO Images for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "When it comes to image SEO, it's important to use relevant keywords to help your page rank on search engines. So, make sure that your filename for one of the images in your Focus Pages is: keyword.jpg. Takes less than 5 minutes to fix, and you'll get to practice an optimization tip worthy of an SEO star.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Download a relevant image from your page. Change the filename. Then re-upload with the SEO filename and add it your page's content again.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Improve your Focus Page's chances of ranking with this quick trick that SEO professionals use.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=image' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 16,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'BriefcaseKeywordsLabel'          => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Add Labels to Keywords in Briefcase", 'squirrly-seo' ),
				'message'   => esc_html__( "Users who use the Labels system in Briefcase have 60% more keywords ranked in top 10 on Google than those who don't work with keywords in an organized way. As a future SEO star, it's important to understand the significance of keyword organization and how big a role it plays in achieving a high-performing search campaign. On [link]https://squirrly.co/seo/kit/[/link] you can see the Direct 1, Direct 2, Direct 3, Direct 4 and Indirect keywords approach. It will help you with this.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly SEO > Research > Briefcase%s, and add Labels to your keywords to organize them into tighter, more relevant groups based on your current campaigns and strategy. ", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Improve your chances of getting more keywords ranked in top 10 of Google.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 16,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Briefcase', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'FocusPagesInnerLinks'            => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Add more Ranking Power to your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Links on the web are like votes, and the pages that receive more votes rank higher. Since Focus Pages are the most important pages in your site, you should give them more votes (link to them from many pages in your site; these are called inner-links). Even if you need to create new pages to link from, it will still be worth it. Some of our users wrote just one article to get an inner link for their Focus Page, and the next day they were on the 1st page of Google with 4 keywords. [link]https://chiefcontent.com/s1-e4-focus-pages-by-squirrly-success-with-focus-pages/[/link]", 'squirrly-seo' ),
				'solution'  => esc_html__( "Link to your Focus Page from another page in your site. If you don't have a page where you can link from, spend some time creating one. Re-index with Google Search Console. ", 'squirrly-seo' ),
				'goal'      => esc_html__( "Create 1 Inner Link to one of your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=innerlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 16,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'UsedBriefcaseInSerpCheck3'       => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Start tracking rankings for 3 keywords", 'squirrly-seo' ),
				'message'   => esc_html__( "Professional SEOs recognize the importance of tracking rankings as a way to measure SEO success. As a future SEO star, it's important to measure the impact of your work and pivot your priorities when you see that a current strategy is not working.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Get in the habit of tracking your rankings by adding three keywords to Squirrly's Rankings section. Go to %sResearch > Briefcase%s, choose a keyword you want to track and click on Send to Rank Checker. Squirrly will start showing you the true position of your site for that kewyord. Repeat the process for two more keywords.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Start tracking rankings for 3 keywords.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 16,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Briefcase', 'squirrly-seo' ),
					esc_html__( 'Rankings', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'BriefcaseKeywords10'             => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Increase your SEO skill set by building your keyword portfolio", 'squirrly-seo' ),
				'message'   => esc_html__( "Keyword research, both as a skill and as a practice, are critical to your SEO success. You can't be an SEO master without it. Plus, according to new research, the more a blogger researches keywords, the more likely they are to report success. Bloggers who are also SEOs report “strong results” at much higher than average rates. Get at least 10 keywords inside the Briefcase section to get started. With powerful keyword research and the SEO Live Assistant, we managed to outrank Amazon, Stack Overflow, Moz and a few others. Read more on [link]https://squirrly.co/seo/kit/[/link] in the section about Google and how much they care about keywords.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly SEO > Research%s, and begin doing research based on the topics you want to rank on Search Engines, and that are important for your research. If you need help coming up with ideas, %syou can use these keyword research formulas%s. When you find a good keyword opportunity, save it to Briefcase. Do this until you have at least 10 keywords inside Briefcase.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research' ) . '" >', '</a>', '<a href="https://www.squirrly.co/keyword-research-ninja-with-the-keyword-formula/" target="_blank">', '</a>' ),
				'goal'      => esc_html__( "Create your keyword portfolio. Get at least 10 keywords inside the Briefcase Section.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_research', 'briefcase' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 17,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'AI Research', 'squirrly-seo' ),
					esc_html__( 'Briefcase', 'squirrly-seo' )
				),
				'time'      => 600
			),
			'getSeoPatterns'                  => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Avoid losing positions in search results", 'squirrly-seo' ),
				'message'   => esc_html__( "Make sure your Rankings won't drop because of duplicate content, duplicate titles, empty titles, empty descriptions and more. SEO Experts and Non-SEO Experts love this feature, because it simply handles everything important. (especially if you already turned Platform SEO to Green inside Focus Pages section)", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %s Squirrly > All Features %s and make sure that SEO Automation is activated.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_features', false, array( 'sfeature=seo+automation' ) ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Activate SEO Patterns, with Squirrly's site-wide SEO Automation.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'automation' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 18,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'On-Page SEO', 'squirrly-seo' ),
					esc_html__( 'SEO Automation', 'squirrly-seo' )
				),
				'time'      => 10
			),
			'FocusPagesHistoryPostUpdate'     => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Update Your Focus Pages Content Regularly", 'squirrly-seo' ),
				'message'   => esc_html__( "Google prefers to rank pages that have relevant, fresh content that is up-to-date. Updating your content can also improve your click-through-rate, because people are more likely to click on articles that were published recently. And your CTR improving  tells Google that your page is the better resource, which will result in your page getting higher rankings.", 'squirrly-seo' ),
				'solution'  => esc_html__( "The most recent update date for your Focus Page Content needs to be in the last 3 months. If it's not, then go and edit your page. Re-index with Google Search Console when you are done.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Make Google love your Focus Pages by regularly updating content.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=content' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 19,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			'FocusPagesKeywordSEOMetas'       => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Define Title and Description for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Titles and descriptions provide necessary information about the content of the page, and help indicate the value a Google user will get by clicking on that page. Not having these elements defined for your pages will make you lose precious points with both Search Engines and Humans. 36% of SEO experts think the headline/title tag is the most important SEO element. Each one of your Focus Pages should have a defined title and meta description.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Easily define titles and meta descriptions using the %s Snippet editor from Squirrly SEO %s.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Customize Title and Description for your Focus Pages to get more people to click on your pages in SERPs.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=snippet' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 19,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'SEO Snippet', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'FocusPagesTwitterCard'           => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Optimize Twitter Cards for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Twitter Cards are a great partner to your SEO strategy, as it helps you stand out to Twitter users and thus increase engagement and CTR. Grab that opportunity by making sure that all the Twitter tags are in place for your Focus Pages.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Use the %s Snippet editor from Squirrly SEO %s to get all the Twitter Card definition elements in place.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Optimize Twitter Cards for your Focus Pages to boost engagement and traffic.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=snippet' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 19,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'SEO Snippet', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'FocusPagesOpenGraph'             => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Optimize Open Graph for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Open Graph lets you control what content is displayed when your pages are linked on social media, thus influencing your link's performance. If you lack these tags, then you're risking that an unrelated image or inaccurate description will be shown. On the flip side, having these tags helps you harness the power of social media and boost your social media CTR. Using your keywords inside the OG definitions has been proven to also boost SEO.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Use the %s Snippet editor from Squirrly SEO %s to get all the Open Graph definition elements in place for your Focus Pages.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Optimize Open Graph. Unless you do so, you're leaving how your Focus Pages are shown on Facebook up to chance. (it's also bad for SEO)", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=snippet' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 19,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'SEO Snippet', 'squirrly-seo' )
				),
				'time'      => 300
			),
			'FocusPagesSnippet'               => array(
				'completed' => false,
				'warning'   => esc_html__( "Optimize Rich Snippets for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "JSON-LD, Rich Snippets, Schema implementation: this thing goes by many different names, because nothing has been standardized. However, as an SEO Star, you need to make sure your site has this JSON-LD properly defined. You can let Squirrly SEO Automatically handle JSON-LD definitions, or you can switch to Custom and use the tool that we link to in order to create your very own definition. Once you're done there, you can come back and paste the code into the custom section of your page's snippet for JSON-LD. For most pages, you should let this setting to Auto, though. Also, make sure you've completed everything about your organization or personal brand in Squirrly > Technical SEO > Rich Snippets.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Use the %s Snippet Editor from Squirrly SEO %s to get this done.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You need to have good definitions for JSON-LD.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=snippet' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 20,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'SEO Snippet', 'squirrly-seo' )
				),
				'time'      => 600
			),
			'FocusPagesArticleLength'         => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Make your Focus Pages at least 1,500 words long", 'squirrly-seo' ),
				'message'   => esc_html__( "Research shows that the average Google first page result contains 1,890 words. Plus, long-form content gets an average of 77.2% more links than short articles, making it ideal for backlink acquisition. The Journey to Better Ranking from Squirrly SEO gives you many ideas on how to easily make your pages longer. It might seem daunting at first, but after making a few pages it will become easy to do. Plus, Squirrly SML showed that in ALL industries where there is a bit of competition (meaning, other site owners who have decent sites), the 1,500 words is a powerful differentiator which can score you easy wins.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Edit the content on your Focus Pages to make it over 1,500 words long. Some tips you can use here: [link]https://howto12.squirrly.co/wordpress-seo/journey-to-better-ranking-day-12/[/link] . Re-index with Google Search Console when you're done.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Make Google want to rank your Focus Pages on the 1st Page by making them at least 1,500 words long.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=length' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 21,
				'ignorable' => false,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			'FocusPagesContent'               => array(
				'completed' => false,
				'warning'   => esc_html__( "Reach Perfect SEO Content optimizations for all Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Expert SEOs don't settle for reaching 30%, 50% or 60% optimization level when trying to get a page on the 1st page of Google. As a future SEO star, reaching perfect SEO optimization is a skill you must master as well, as it gives you the best chances of rankings.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > Focus Pages%s and look at the SEO Content column. Click on a red or green light, then look at the right sidebar. There you will see all elements that compose the final SEO Content scoring to achieve RED or Green. Click on each element and read the instructions that show you how to complete each task (the ones from the sidebar).", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=content' ) ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Reach Perfect SEO optimization level for your Focus Pages to master content optimization.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=content' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 22,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'Live Assistant', 'squirrly-seo' )
				),
				'time'      => 1200
			),
			'SeoSettingsGreen'                => array(
				'completed' => false,
				'warning'   => esc_html__( "Complete all marketing settings tasks", 'squirrly-seo' ),
				'message'   => esc_html__( "If you want to unleash the full marketing power of your WordPress site, then you need to activate all the important marketing settings there are. This is vital to marketing mastery and to maximizing your site's marketing opportunities.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Go to the Technical SEO section of Squirrly SEO. Click on the METAs section. You'll see tasks appearing at the right of the screen. Look to the right of the screen and complete all the tasks that appear there. Click on each element and you'll find out what you need to do to complete the task. Completed tasks are the ones that have a check mark.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Complete all sidebar (right sidebar) tasks for all Technical SEO Sections.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 22,
				'ignorable' => true,
				'tools'     => array(
					esc_html__( 'Focus Pages', 'squirrly-seo' ),
					esc_html__( 'SEO Snippet', 'squirrly-seo' )
				),
				'time'      => 600
			),
			'GoogleSearchConsole'             => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Prepare Full Google Search Console Connection", 'squirrly-seo' ),
				'message'   => esc_html__( "Get access to data about impressions, clicks and CTR without leaving WordPress by connecting Google Search Console to Squirrly. This is an API-level connection and goes beyond just allowing GSC to track your site. Enhance your Squirrly SEO with powerful data that comes directly from Google.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Need Help Connecting Google Search Console? %sClick Here%s", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/faq/need-help-connecting-google-search-console-both-tracking-code-and-api-connection/" target="_blank">', '</a>' ),
				'goal'      => esc_html__( "You must connect Google Search Console to your Squirrly SEO. As soon as possible. It's quick to do and helps you see impressions, clicks, and CTR, so you can become an SEO Star.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 22,
				'ignorable' => false,
				'time'      => 30
			),
			'GoogleAnalytics'                 => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Connect Google Analytics Data to Squirrly", 'squirrly-seo' ),
				'message'   => esc_html__( "As a future SEO star, you need to be able to make decisions based on what the data tells you. By connecting Google Analytics to Squirrly, you can monitor the traffic that your Focus Pages are getting, and figure your next steps based on that. Also, much of SEO these days is based on how much time people spend on your site, so to give you accurate Chances of Ranking, Squirrly's SML needs to see this data. To ensure Google gets 100% accuracy on how people spend time on your site, use the plugin we recommend in [link]https://squirrly.co/seo/kit[/link]", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Need Help Connecting Google Analytics? %sClick Here%s", 'squirrly-seo' ), '<a href="https://howto12.squirrly.co/faq/how-do-i-connect-google-analytics-both-tracking-code-and-the-api-connection/" target="_blank">', '</a>' ),
				'goal'      => esc_html__( "Connect Google Analytics to Squirrly so that you see how much traffic your Focus Pages are getting.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'webmaster' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 23,
				'ignorable' => false,
				'time'      => 30
			),
			'SeoAuditScore'                   => array(
				'completed' => false,
				'warning'   => esc_html__( "Raise Audit Score to Over 30%", 'squirrly-seo' ),
				'message'   => esc_html__( "Sites with Audit scores under 30% will have a very hard time ranking for anything. Scores under 30 means the site doesn't have enough quality to be deemed worthy of being found on the first page of Google.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sSquirrly > Audits%s section and read all the Audit tasks where you currently have problems. It tells you how to fix those problems.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "You need to get an Audit Score of over 30% as soon as possible, if you want to avoid Google penalties.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 22,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Audits', 'squirrly-seo' ) ),
			),
			'FocusPagesInnerLinks3'           => array(
				'completed' => false,
				'warning'   => esc_html__( "Reach 3 Inner Links for all your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Studies show that a strong internal linking structure yields higher rankings and is an extremely effective SEO tactic. Wikipedia and StackOverflow are some of the best sites in the world when it comes to SEO. Most of their SEO power comes from strong internal linking. Since Focus Pages are the most important pages in your site, you should give them more votes (link to them from many pages in your site). Even if you need to create new pages to link from, it will stil be worth it. Make sure that you place the links inside the content of the page, not in menus, footers, etc. (those don't bring the same power when it comes to SEO signals). On https://squirrly.co/seo/kit/ you can see an advanced content marketing strategy related to Long-Form content and Complementary Content. That will help you think more creatively about inner links. Also, in the Rank Show series you can see how one website managed to get its most important ranking increases from great inner links.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Get at least three inner links to your Focus Pages from other pages in your site. If you don't have enough pages where you can link from, spend some time creating new content. Then, re-index with Google Search Console (each page from which you sent the links)", 'squirrly-seo' ),
				'goal'      => esc_html__( "Add more ranking power to your Focus Pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=innerlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 23,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
				'time'      => 1200
			),
			'FocusPagesTraffic10'             => array(
				'completed' => false,
				'warning'   => esc_html__( "Get Minimum 10 Visitors / Day to Your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "You need to make sure that your Focus Pages become more popular and take action so that more people start seeing it. Google measures many aspects. If you don't give it enough traffic, it will not have enough data to figure out if your page is actually any good.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Start promoting your Focus Pages on your social media channels, send it to your email subscribers, answer relevant questions on Quora and include a link to your Page. Get detailed information and more ideas on how you can start bringing some traffic to your Focus pages on [link]https://squirrly.co/seo/kit[/link]", 'squirrly-seo' ),
				'goal'      => esc_html__( "Improve visibility for your Focus Pages. Bring in more traffic. Otherwise, it will be hard to keep ranking higher.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 23,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'getDuplicateTitle'               => array(
				'completed' => false,
				'warning'   => esc_html__( "No Duplicate Titles", 'squirrly-seo' ),
				'message'   => esc_html__( "Currently, the theme or a 3rd party plugin inside your WordPress site manages to bypass Squirrly's duplicate remover feature. It keeps duplicating the title tag inside the source code. You need to start deactivating all plugins, except Squirrly SEO, until you find the one causing this problem. You can use the Run SEO Test button here in Next SEO Goals to see if the problem persists.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Track down the plugin or theme setting which causes the duplication. Make it unable to place title tags.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Make sure you don't have any more duplicate titles in your pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 24,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'getDuplicateDescription'         => array(
				'completed' => false,
				'warning'   => esc_html__( "No Duplicate Descriptions", 'squirrly-seo' ),
				'message'   => esc_html__( "Currently, the theme or a 3rd party plugin inside your WordPress site manages to bypass Squirrly's duplicate remover feature. It keeps duplicating the meta description tag inside the source code. You need to start deactivating all plugins, except Squirrly SEO, until you find the one causing this problem. You can use the Run SEO Test button here in Next SEO Goals to see if the problem persists.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Track down the plugin or theme setting which causes the duplication. Make it unable to place meta description tags.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Make sure you don't have any more duplicate descriptions in your pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 24,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'getEmptyTitle'                   => array(
				'completed' => false,
				'warning'   => esc_html__( "No Empty Titles", 'squirrly-seo' ),
				'message'   => esc_html__( "Google doesn't want to place sites with coding problems up in the first positions. Sure, the search engine is smart enough to generate the title on its own, based on the content inside the URL, but it's still a bad practice.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Fix this using Squirrly SEO. Find more help in the %s Squirrly > Technical SEO %s section.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Make sure you avoid having pages with Empty Titles and Empty Descriptions. Otherwise, your rankings will suffer.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 24,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'getEmptyDescription'             => array(
				'completed' => false,
				'warning'   => esc_html__( "No Empty Descriptions", 'squirrly-seo' ),
				'message'   => esc_html__( "Google doesn't want to place sites with coding problems up in the first positions. Sure, the search engine is smart enough to generate the description on its own, based on the content inside the URL, but it's still a bad practice.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Fix this using Squirrly SEO. Find more help in the %s Squirrly > Technical SEO %s section.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Make sure you avoid having pages with Empty Titles and Empty Descriptions. Otherwise, your rankings will suffer.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'metas' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 24,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'CheckForDuplicates'              => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Fix Duplicate Content Issues on your site (across multiple pages)", 'squirrly-seo' ),
				'message'   => sprintf( esc_html__( "Having duplicate content in your site will negatively impact your Search Engine Rankings and traffic. Therefore, you need to make sure you don't have duplicate titles and descriptions (and even duplicate written text inside pages). %s If you copy the same thing over and over again, search engines will penalize you. Go to [link]https://squirrly.co/seo/kit/[/link] to see the 4 types of duplicate content.", 'squirrly-seo' ), '<br /><br />' ),
				'solution'  => esc_html__( "Check your most recent Squirrly Audit to see which of your pages have duplicate content.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Fix Duplicate Content. You're at risk of suffering rankings and traffic losses due to duplicate content on your site.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 24,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
				'time'      => 600
			),
			'FocusPagesSpeed'                 => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Improve SEO Speed", 'squirrly-seo' ),
				'message'   => esc_html__( "Pages that rank at the top of Google’s first page tend to load significantly faster compared to pages that rank on the bottom of page 1. If you want to rank high on Google, your pages need to load fast. On [link]https://squirrly.co/seo/kit/[/link] you can find an Upgraded Version of ShortPixel, which they offer for free to Squirrly users.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Using a tool like ShortPixel to reduce your image sizes will help improve SEO speed.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Make sure your Focus Pages load fast to improve your rankings.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=audit' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 24,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'On-Page SEO', 'squirrly-seo' ) ),
			),
			'FocusPagesBounceRate'            => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Reduce Bounce Rate for your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "A high bounce rate generally indicates that your pages aren't relevant to your visitors. And since Google is all about serving its users results that are most relevant for them, Google doesn't want to show pages that have a high bounce rate. A high bounce rate is common for landing pages, but if you have a page that has long-form content that aims to educate or inform visitors, then a high bounce rate is a symptom that something is wrong in your strategy. Either you’re not attracting the right site visitor or the visitors coming don’t have a good user experience.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Try reducing your bounce rate by: formatting your content better to improve readability, including a video, removing pop-ups that disrupt visitors' experience on your site, and making sure your page loads fast. More strategies (and a quick-fix plugin) here: [link]https://squirrly.co/seo/kit/[/link]", 'squirrly-seo' ),
				'goal'      => esc_html__( "Reduce bounce rate for your Focus Pages to improve search performance.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 26,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesAverageTime60'         => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Time on Page for All Focus Pages: 1 minute average", 'squirrly-seo' ),
				'message'   => esc_html__( "If your pages consistently keep people on them for longer than average, the Google algorithm will adjust the search results to favor your site, because this interaction tells Google that content on your page is interesting and relevant. The longer people stay on your Focus Pages, the higher they will appear in the search engine rankings. Right now, the average time on page for your Focus Pages is under 1 minute, which is not good. Sometimes Google takes you down from the first Page of Google if it 'sees' people don't spend enough time on the page.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Try these tactics to keep visitors on your page for longer: Embed a video or two, add more visuals to make your page more attractive, format your content better to make your page easy to scan, ensure your page is laser-focused on what visitors expect to get from it, experiment with interactive content such as polls or quizzes.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Keep visitors on your Focus Pages for longer to boost rankings.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 26,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesSocialSignals20'       => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Reach 20 Social Media Shares for Each of Your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Studies have shown there is a high correlation between social signals and ranking position. In one case study, a company achieved over 130,000 Facebook shares to a web page and shot up the rankings for keyword phrases that were competitive. Our own SML (Squirrly Machine Learning) discovered ranking increases on tens of thousands of pages after they started getting shared to social media platforms. The biggest SEO experts agree that social media helps your SEO efforts. Strive to get as many social media shares as you can for your Focus Pages from trackable sources.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Try these tactics to reach at least 20 social media shares for each one of your Focus Pages: Share your content multiple times using different captions and images, make social media share buttons super easy to find, include calls-to-action that encourage site visitors to share. More proven methods you can use here: [link]https://howto12.squirrly.co/wordpress-seo/journey-to-better-ranking-day-6/[/link]. For a complete framework, get access to our 10,000 Visits from Social Media course on Education Cloud.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Get at least 20 social media shares for each one of your Focus Pages. It's hard to rank a page that doesn't get shared to social media sites.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=social' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 27,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesAuthority'             => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Raise Authority Level Over 12 for all Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Page authority is a metric that Squirrly's servers calculates according to data from different API, our own crawling and also SML (Squirrly Machine Learning fine tunes the data, according to the data sets we've been studying). Google has such a system as well, and we are basically replicating what they're doing. To improve this you need: traffic to the page, good traffic metrics (time on page, low bounce rate), inner links, outbound links set to 'nofollow', backlinks (links from 3rd party sites to your own site) and social media information.", 'squirrly-seo' ),
				'solution'  => '',
				'goal'      => esc_html__( "Raise your Page Authority to over 12 for all Focus Pages. Otherwise, it will be nearly impossible for those pages to reach top positions on Google.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=authority' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 27,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'GSCKeywordClicks'                => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Try a different Title and Description for the Focus Pages with low CTR", 'squirrly-seo' ),
				'message'   => esc_html__( "Google keeps track of which links get clicked the most in their search results. Links that get clicked more often are moved up higher in the search results, because this shows Google that a certain link is the result that best matches the user’s search intent. Right now, NOT enough people click on your listing, but writing a more enticing title and description can help change that; and get more people clicking.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Tips to improve your CTR: include your keyword in your description, use How-To and numbers in your titles as many people are drawn to them, make sure the description clearly states what your page is about, and add a CTA that gives people an extra incentive to click on your link.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Change the title and description to get more SERP clicks for your Focus Pages (the ones where you see low CTR)", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=ctr' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 28,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'SeoAuditScore50'                 => array(
				'completed' => false,
				'warning'   => esc_html__( "Audit Score is Over 50%", 'squirrly-seo' ),
				'message'   => esc_html__( "The Squirrly Audit covers the main aspects that influence a site's performance. Plus, your SEO and digital marketing expertise will increase as you keep working on solving issues unveiled by the weekly Audit. You need a score over 50 to have good chances of ranking high on Google.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Open up your Audit from %sSquirrly > Audits%s. Open one of the audits, or use the Compare Audit button to compare multiple audits and see how far you've come along. Read about the aspects you can work on to improve your score (find them on the right sidebar).", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Improve the score of your Audit to have a good chance of ranking high on Google.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 28,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Audits', 'squirrly-seo' ) ),
			),
			'FocusPagesInnerLinks5'           => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Reach 5 Inner Links for all your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Studies show that a strong internal linking structure yields higher rankings and is an extremely effective SEO tactic. Wikipedia and StackOverflow are some of the best sites in the world when it comes to SEO. Most of their SEO power comes from strong internal linking. Since Focus Pages are the most important pages in your site, you should give them more votes (link to them from many pages in your site). Even if you need to create new pages to link from, it will stil be worth it. Make sure that you place the links inside the content of the page, not in menus, footers, etc. (those don't bring the same power when it comes to SEO signals). On https://squirrly.co/seo/kit/ you can see an advanced content marketing strategy related to Long-Form content and Complementary Content. That will help you think more creatively about inner links. Also, in the Rank Show series you can see how one website managed to get its most important ranking increases from great inner links.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Get at least five inner links to your Focus Pages from other pages in your site. If you don't have enough pages where you can link from, spend some time creating new content. Then, re-index with Google Search Console (each page from which you sent the links)", 'squirrly-seo' ),
				'goal'      => esc_html__( "Add more ranking power to your Focus Pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=innerlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 29,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesAverageTime90'         => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Time on Page for All Focus Pages: 1.5 minute average", 'squirrly-seo' ),
				'message'   => esc_html__( "If your pages consistently keep people on them for longer than average, the Google algorithm will adjust the search results to favor your site, because this interaction tells Google that content on your page is interesting and relevant. The longer people stay on your Focus Pages, the higher they will appear in the search engine rankings. Right now, the average time on page for your Focus Pages is under 1.5 minutes, which is not ideal. One thing you can do is check if all traffic sources send you people who spend very little time on your pages. If that's the case, make sure those sources stop sending you traffic. Yes, there is such a thing as 'bad traffic' and it can hurt your positions in Google. Also, you need to use [link]https://squirrly.co/seo/kit/[/link] and make sure Google reads the correct time on page. Most of the time, it doesn't, because its tracker gets a 'timeout'. In the kit, you'll find a plugin that doesn't allow google to time out. And it will improve the accuracy of the Time on Page readings.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Try these tactics to keep visitors on your page for longer: Embed a video or two, add more visuals to make your page more attractive, format your content better to make your page easy to scan, ensure your page is laser-focused on what visitors expect to get from it.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Keep visitors on your Focus Pages for longer to boost rankings.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 30,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesReferringDomains10'    => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Get At Least 10 referring domains", 'squirrly-seo' ),
				'message'   => esc_html__( "If you want more organic traffic, backlinks and referring domains are critical. Research has shown that the vast majority of pages (of analyzed ~ 1 billion pages) without any referring domains get NO traffic from Google. There is also a positive correlation between the number of unique referring domains and the amount of search traffic the target web page receives.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Find more websites that can send links to your own site. You need to get links to our site from at least 10 other domains from the web. You can run Squirrly SPY reports on your competitors to find websites which link to your kind of website.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Get at least 10 referring domains to get more traffic.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=backlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 31,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesSocialSignals40'       => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Reach 40 Social Media Shares for Each of Your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Try these tactics to reach at least 40 social media shares for each one of your Focus Pages: Share your content multiple times using different captions and images, make social media share buttons super easy to find, include calls-to-action that encourage site visitors to share. More proven methods you can use here:  https://howto12.squirrly.co/wordpress-seo/journey-to-better-ranking-day-6/. For a complete framework, get access to our 10,000 Visits from Social Media course on Education Cloud.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Studies have shown there is a high correlation between social signals and ranking position. In one case study, a company achieved over 130,000 Facebook shares to a web page and shot up the rankings for keyword phrases that were very competitive. Our own SML (Squirrly Machine Learning) discovered ranking increases on tens of thousands of pages after they started getting shared to social media platforms. The biggest SEO experts agree that social media helps your SEO efforts. Strive to get as many social media shares as you can for your Focus Pages from trackable sources.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Get at least 40 social media shares for each one of your Focus Pages. It's hard to rank a page that doesn't get shared to social media sites.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=social' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 29,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesAuthority20'           => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Raise Authority Level to Over 20 for all Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Page authority is a metric that Squirrly's servers calculates according to data from different API, our own crawling and also SML (Squirrly Machine Learning fine tunes the data, according to the data sets we've been studying). Google has such a system as well, and we are basically replicating what they're doing. To improve this you need: traffic to the page, good traffic metrics (time on page, low bounce rate), inner links, outbound links set to 'nofollow', backlinks (links from 3rd party sites to your own site) and social media information.", 'squirrly-seo' ),
				'solution'  => '',
				'goal'      => esc_html__( "Raise your Page Authority to over 20 for all Focus Pages. Otherwise, it will be nearly impossible for those pages to reach top positions on Google.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=authority' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 32,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'SeoAuditScore70'                 => array(
				'completed' => false,
				'warning'   => esc_html__( "Audit Score is Over 70%", 'squirrly-seo' ),
				'message'   => esc_html__( "The Squirrly Audit covers the main aspects that influence a site's performance. Plus, your SEO and digital marketing expertise will increase as you keep working on solving issues unveiled by the weekly Audit. You need a score over 70 to have good chances of ranking high on Google.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Open up your Audit from %sSquirrly > SEO Audit%s. Open one of the audits, or use the Compare Audit button to compare multiple audits and see how far you've come along. Read about the aspects you can work on to improve your score (find them on the right sidebar).", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ) . '" >', '</a>' ),
				'goal'      => esc_html__( "Improve the score of your Audit to have a good chance of ranking high on Google.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_audits', 'audits' ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 32,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Audits', 'squirrly-seo' ) ),
			),
			'FocusPagesTraffic30'             => array(
				'completed' => false,
				'warning'   => esc_html__( "Get Minimum 30 Visitors / Day to Your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "You need to make sure that your Focus Pages become more popular and take action so that more people start seeing it. Google measures many aspects. If you don't give it enough traffic, it will not have enough data to figure out if your page is actually any good.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Start promoting your Focus Pages on your social media channels, send it to your email subscribers, answer relevant questions on Quora and include a link to your Page. Get detailed information and more ideas on how you can start bringing some traffic to your Focus pages on [link]https://squirrly.co/seo/kit[/link]", 'squirrly-seo' ),
				'goal'      => esc_html__( "Improve visibility for your Focus Pages. Bring in more traffic. Otherwise, it will be hard to keep ranking higher.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 34,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesAverageTime120'        => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Reach Time on Page for All Focus Pages: 2 minute average", 'squirrly-seo' ),
				'message'   => esc_html__( "If your pages consistently keep people on them for longer than average, the Google algorithm will adjust the search results to favor your site, because this interaction tells Google that content on your page is interesting and relevant. The longer people stay on your Focus Pages, the higher they will appear in the search engine rankings. Right now, the average time on page for your Focus Pages is under 2  minutes. You can make changes to improve that. Average time on page is one of the most important signals for Google.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Experiment with interactive content such as polls or quizzes to keep visitors on your site for longer, or make your content longer, if the topic is right. It's also worth checking what are your traffic sources, as some traffic sources can contribute to low time on page. ", 'squirrly-seo' ),
				'goal'      => esc_html__( "Keep visitors on your Focus Pages for at least 2 minutes (on average) to boost rankings. Keeping people over 2 minutes sends clear signals to Google that people love your pages.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 30,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesReferringDomains20'    => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Get at least 20 referring domains", 'squirrly-seo' ),
				'message'   => esc_html__( "If you want more organic traffic, backlinks and referring domains are critical. Research has shown that the vast majority of pages (of analyzed ~ 1 billion pages) without any referring domains get NO traffic from Google. There is also a positive correlation between the number of unique referring domains and the amount of search traffic the target web page receives. ", 'squirrly-seo' ),
				'solution'  => esc_html__( "Find more websites that can send links to your own site. You need to get links to our site from at least 20 other domains from the web. You can run Squirrly SPY reports on your competitors to find websites which link to your kind of website.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Get at least 20 referring domains to get more traffic.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=backlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 35,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesReferringDomains30'    => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Get at least 30 referring domains", 'squirrly-seo' ),
				'message'   => esc_html__( "If you want more organic traffic, backlinks and referring domains are critical. Research has shown that the vast majority of pages (of analyzed ~ 1 billion pages) without any referring domains get NO traffic from Google. There is also a positive correlation between the number of unique referring domains and the amount of search traffic the target web page receives.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Find more websites that can send links to your own site. You need to get links to our site from at least 30 other domains from the web. You can run Squirrly SPY reports on your competitors to find websites which link to your kind of website.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Get at least 30 reffering domains to get more traffic", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=backlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 36,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesTraffic70'             => array(
				'completed' => false,
				'warning'   => esc_html__( "Get Minimum 70 Visitors / Day to Your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "You need to make sure that your Focus Pages become more popular and take action so that more people start seeing it. Google measures many aspects. If you don't give it enough traffic, it will not have enough data to figure out if your page is actually any good.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Start promoting your Focus Pages on your social media channels, send it to your email subscribers, answer relevant questions on Quora and include a link to your Page. Get detailed information and more ideas on how you can start bringing some traffic to your Focus pages on [link]https://squirrly.co/seo/kit[/link]", 'squirrly-seo' ),
				'goal'      => esc_html__( "Improve visibility for your Focus Pages. Bring in more traffic. Otherwise, it will be hard to keep ranking higher.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=traffic' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 37,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesAuthority35'           => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Raise Authority Level to Over 35 for all Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "Page authority is a metric that Squirrly's servers calculate according to data from different API, our own crawling and also SML (Squirrly Machine Learning fine tunes the data, according to the data sets we've been studying). Google has such a system as well, and we are basically replicating what they're doing. To improve this, you need: traffic to the page, good traffic metrics (time on page, low bounce rate), inner links, outbound links set to \"nofollow\", backlinks (links from 3rd party sites to your own site) and social media information.", 'squirrly-seo' ),
				'solution'  => '',
				'goal'      => esc_html__( "Raise your Page Authority to over 35 for all Focus Pages. Do this and Google will start rewarding you with much better visibility on the search engine.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=authority' ) ),
				'color'     => '#4f1440',
				'bullet'    => true,
				'priority'  => 38,
				'ignorable' => true,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesBacklinks'             => array(
				'completed' => false,
				'warning'   => esc_html__( "Get at least 1 Backlink for every Focus Page", 'squirrly-seo' ),
				'message'   => esc_html__( "A very easy way to reach this goal is to get a Squirrly SPY report [link]https://squirrly.co/seo/spy/[/link] or something similar for your competitors (just see who is currently listed top 10 in Google for your main keyword for each Focus Page). You will see which sites link to them. Then you can talk to those site owners and ask them how they can include you as well, and also link to YOUR site.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Get 1 Backlink for each Focus Page. The 'PRO Ranking Tournament' course inside Education Cloud by Squirrly has many ideas in lesson 8. These ideas will help you get backlinks.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Get 1 Backlink (minimum) for each of your Focus Pages. Otherwise, it's pretty improbable that you will manage to reach top positions.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=backlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 38,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'FocusPagesBacklinks10'           => array(
				'completed' => false,
				'warning'   => esc_html__( "Get 10 Backlinks to your Focus Pages", 'squirrly-seo' ),
				'message'   => esc_html__( "A very easy way to reach this goal is to get a Squirrly SPY report [link]https://squirrly.co/seo/spy/[/link] or something similar for your competitors (just see who is currently listed top 10 in Google for your main keyword for each Focus Page). You will see which sites link to them. Then you can talk to those site owners and ask them how they can include you as well, and also link to YOUR site.", 'squirrly-seo' ),
				'solution'  => esc_html__( "Get 10 Backlinks for each Focus Page. The 'PRO Ranking Tournament' course inside Education Cloud by Squirrly has many ideas in lesson 8. These ideas will help you get backlinks.", 'squirrly-seo' ),
				'goal'      => esc_html__( "Reach over 10 Backlinks for each of your Focus Pages. Otherwise, it's pretty improbable that you will manage to reach top positions.", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist', array( 'slabel=backlinks' ) ),
				'color'     => '#4f1440',
				'bullet'    => false,
				'priority'  => 38,
				'ignorable' => false,
				'tools'     => array( esc_html__( 'Focus Pages', 'squirrly-seo' ) ),
			),
			'pluginReview'                    => array( //remote
				'completed' => false,
				'warning'   => esc_html__( "Help us with a positive review on WordPress", 'squirrly-seo' ),
				'message'   => esc_html__( "Help us keep the Squirrly SEO plugin free with so many free features.", 'squirrly-seo' ),
				'solution'  => sprintf( esc_html__( "Go to %sWordPress Directory%s and write a short positive review for us if you like the plugin.", 'squirrly-seo' ), '<a href="https://wordpress.org/plugins/squirrly-seo/#reviews" target="_blank">', '</a>' ),
				'goal'      => '',
				'link'      => 'https://wordpress.org/plugins/squirrly-seo/#reviews',
				'color'     => 'green',
				'bullet'    => false,
				'priority'  => 39,
				'ignorable' => true,
				'time'      => 60
			),

			////////////////////////////////////////////////////////////////// POSITIVE TASKS
			'FocusPagesTraffic'               => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Traffic to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesRanking'               => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Ranking to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesProgressRanking'       => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Ranking to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesProgressTimeOnPage'    => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Time On Page to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesProgressTraffic'       => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Traffic to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesProgressAuthority'     => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Authority to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesProgressSocial'        => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Social Signals to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'FocusPagesProgressSpeed'         => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Loading Speed to your Focus Pages", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'RankingProgressTop10'            => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Ranking for your Keywords", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'RankingProgressEvolution'        => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Ranking for your Keywords", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'RankingProgressAverage'          => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Ranking for your Keywords", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),
			'AuditProgressEvolution'          => array( //remote
				'completed' => false,
				'message'   => esc_html__( "You got better Score for your Audit", 'squirrly-seo' ),
				'link'      => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_focuspages', 'pagelist' ),
				'color'     => 'green',
				'positive'  => true,
				'ignorable' => true,
			),

		);
	}

	/**
	 * Get the crawled HTML
	 *
	 * @return bool
	 */
	public function getHtml() {
		return $this->html;
	}

	////////////////////////////////////////////// TASKS

	/**
	 * Get the DB Tasks
	 *
	 * @return mixed $task
	 */
	public function getDbTasks() {

		if ( isset( $this->dbtasks[ $this->category_name ] ) ) {
			return $this->dbtasks[ $this->category_name ];
		}

		return array();
	}

	/**
	 * Get the DB Task
	 *
	 * @param  $task
	 *
	 * @return array
	 */
	public function getDbTask( $task ) {

		if ( isset( $this->dbtasks[ $this->category_name ][ $task ] ) ) {
			return $this->dbtasks[ $this->category_name ][ $task ];
		}

		return array();
	}

	/**
	 * Ignore a task by name
	 *
	 * @param $name
	 */
	public function ignoreTask( $name ) {
		if ( $name ) {

			if ( isset( $this->dbtasks[ $this->category_name ][ $name ] ) ) {
				$this->dbtasks[ $this->category_name ][ $name ]['active'] = false;
			} else {
				$this->dbtasks[ $this->category_name ][ $name ] = array( 'active' => false );
			}

			$this->saveDbTasks();
		}
	}

	public function clearIgnoredTasks() {

		if ( isset( $this->dbtasks[ $this->category_name ] ) ) {
			foreach ( $this->dbtasks[ $this->category_name ] as $function => &$task ) {
				if ( is_array( $task ) && ! empty( $task ) ) {
					$task['active'] = true;
				}
			}
		}

		$this->saveDbTasks();
	}

	public function doneTask( $name ) {
		if ( $name ) {
			if ( isset( $this->dbtasks[ $this->category_name ][ $name ] ) ) {
				$this->dbtasks[ $this->category_name ][ $name ]['done'] = true;
			} else {
				$this->dbtasks[ $this->category_name ][ $name ] = array( 'done' => true );
			}

			$this->saveDbTasks();
		}
	}

	public function clearDoneTasks() {

		if ( isset( $this->dbtasks[ $this->category_name ] ) ) {
			foreach ( $this->dbtasks[ $this->category_name ] as &$task ) {
				if ( is_array( $task ) && ! empty( $task ) ) {
					if ( isset( $task['done'] ) && $task['done'] ) {
						$task['reopened'] = true;
						$task['done']     = false;
					}
				}
			}
		}

		$this->saveDbTasks();
	}


	/**
	 * Save the DB Tasks
	 *
	 * @param string $task
	 * @param mixed $value
	 */
	public function saveDbTasks( $task = null, $value = null ) {
		if ( isset( $task ) && isset( $value ) ) {
			$this->dbtasks[ $this->category_name ][ $task ] = $value;
		}

		update_option( SQ_TASKS, wp_json_encode( $this->dbtasks ) );
	}

	/**
	 * Process all the tasks and save the report
	 * @return void
	 */
	public function checkSEO() {

		if ( ! function_exists( 'preg_match_all' ) ) {
			return;
		}

		SQ_Classes_Helpers_Tools::saveOptions( 'seoreport_time', time() );

		$this->checkin = SQ_Classes_RemoteController::checkin();
		//Get the source Code and Focus Pages
		$this->getSourceCode();
		$this->processFocusPages();

		//Get DB tasks saved
		$this->clearDoneTasks();

		$remote_tasks = SQ_Classes_ObjController::getClass( 'SQ_Classes_RemoteController' )->getNotifications();
		$remote_tasks = json_decode( wp_json_encode( $remote_tasks ), true );

		///////////////////////////// to do tasks
		$tasks = $this->getTasks();

		foreach ( $tasks as $function => $task ) {

			///////////////////DEV ONLY
			//            if (SQ_DEBUG) {
			//                $this->dbtasks['count_tasks_for_today'] = 200;
			//                if(isset($task['positive']) && $task['positive']) $task['completed'] = true;
			//                if(isset($task['positive']) && !$task['positive']) $task['completed'] = false;
			//                $this->dbtasks[$this->category_name][$function] = $task;
			//                continue;
			//            }

			//For Dev Kit
			if ( isset( $task['tools'] ) && is_array( $task['tools'] ) && ! empty( $task['tools'] ) ) {
				if ( in_array( 'Audits', $task['tools'] ) && ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_audit' ) ) {
					continue;
				} elseif ( in_array( 'Rankings', $task['tools'] ) && ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_rankings' ) ) {
					continue;
				} elseif ( in_array( 'Focus Pages', $task['tools'] ) && ! SQ_Classes_Helpers_Tools::getMenuVisible( 'show_focuspages' ) ) {
					continue;
				}
			}


			if ( isset( $remote_tasks[ $function ] ) ) {
				//filter the array
				$remote_tasks[ $function ] = array_filter( $remote_tasks[ $function ] );
				//make sure the complete param remains
				if ( ! isset( $remote_tasks[ $function ]['completed'] ) ) {
					$remote_tasks[ $function ]['completed'] = false;

					if ( method_exists( $this, $function ) ) {
						if ( $result = call_user_func( array( $this, $function ) ) ) {
							$remote_tasks[ $function ]['completed'] = $result['completed'];
						}
					}
				}

				//create the db taks if doesn't exist
				if ( ! isset( $this->dbtasks[ $this->category_name ][ $function ] ) || ! is_array( $this->dbtasks[ $this->category_name ][ $function ] ) ) {
					$this->dbtasks[ $this->category_name ][ $function ] = array();
				}
				//merge the local and remote task
				if ( is_array( $remote_tasks[ $function ] ) && ! empty( $remote_tasks[ $function ] ) ) {
					$this->dbtasks[ $this->category_name ][ $function ] = array_merge( $this->dbtasks[ $this->category_name ][ $function ], $remote_tasks[ $function ] );
				}

			} elseif ( method_exists( $this, $function ) ) {
				//Call the local function if exists
				if ( $result = call_user_func( array( $this, $function ) ) ) {
					if ( ! isset( $this->dbtasks[ $this->category_name ][ $function ] ) || ! is_array( $this->dbtasks[ $this->category_name ][ $function ] ) ) {
						$this->dbtasks[ $this->category_name ][ $function ] = array();
					}
					if ( is_array( $result ) && ! empty( $result ) ) {
						$this->dbtasks[ $this->category_name ][ $function ] = array_merge( $this->dbtasks[ $this->category_name ][ $function ], $result );
					}
				}
			} elseif ( isset( $this->dbtasks[ $this->category_name ][ $function ] ) ) {
				//remove the task if is not linked to anything
				unset( $this->dbtasks[ $this->category_name ][ $function ] );
			}
		}

		//sort the tasks
		$this->dbtasks[ $this->category_name ] = array_merge( array_flip( array_keys( $tasks ) ), $this->dbtasks[ $this->category_name ] );

		//Save the tasks in database
		$this->saveDbTasks();

		//Save the stats for Overview
		$this->saveStats();

		//Don't show error messages on each SEO Check
		SQ_Classes_Error::clearErrors();

	}

	public function saveStats() {
		global $wpdb;
		$stats = array();

		$stats['post_count'] = 0;
		if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT COUNT(`ID`) as count FROM `$wpdb->posts` WHERE `post_status` = %s", 'publish' ) ) ) {
			$stats['post_count']     = $row->count;
			$stats['all_post_count'] = $row->count;
		}

		$removed_posts = 0;
		$table = $wpdb->prefix . _SQ_DB_;
		if ( $rows = $wpdb->get_results( "SELECT `seo` FROM `$table`" ) ) {
			foreach ( $rows as $row ) {
				$metas = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Sq', maybe_unserialize( $row->seo ) );

				if ( ! $metas->doseo ) {
					$removed_posts += 1;
				}

			}
		}
		//Remove the not-optimized posts
		$stats['post_count'] -= $removed_posts;
		$stats['post_count'] = max( 0, $stats['post_count'] );

		//Check if Squirrly is loaded for this post type
		$patterns = (array) SQ_Classes_Helpers_Tools::getOption( 'patterns' );
		if ( ! empty( $patterns ) ) {
			foreach ( $patterns as $pattern => $type ) {
				if ( strpos( $pattern, 'product' ) !== false || strpos( $pattern, 'shop' ) !== false ) {
					if ( ! SQ_Classes_Helpers_Tools::isEcommerce() ) {
						unset( $patterns[ $pattern ] );
					}
				}
			}
		}

		$filter     = array( 'public' => true, '_builtin' => false );
		$post_types = get_post_types( $filter );

		foreach ( $post_types as $pattern => $type ) {
			if ( in_array( $pattern, array_keys( $patterns ) ) ) {
				unset( $post_types[ $pattern ] );
			}
		}

		////////////////////////////////////////
		$post_types = array_merge( (array) $post_types, (array) $patterns );

		//get all public post types
		$stats['all_post_types_count'] = count( $post_types );

		//Get the Squirrly SEO Patterns
		$patterns = (array) SQ_Classes_Helpers_Tools::getOption( 'patterns' );
		if ( ! empty( $patterns ) ) {
			foreach ( $post_types as $index => $posttype ) {
				foreach ( $patterns as $pattern => $type ) {
					if ( $posttype == $pattern ) {
						if ( ! $type['do_metas'] && ! $type['do_jsonld'] && ! $type['do_og'] && ! $type['do_twc'] && ! $type['do_fpixel'] ) {
							unset( $post_types[ $index ] );
						}
					}
				}
			}
		}


		//Count the post types
		$stats['post_types_count'] = count( $post_types );


		$this->dbtasks['sq_stats'] = $stats;
		//Save the tasks in database
		$this->saveDbTasks();
	}

	/**
	 * Get the homepage source code
	 *
	 * @return array
	 */
	public function getSourceCode() {
		$url      = home_url( '?rnd=' . rand() );
		$response = wp_remote_get( $url, array( 'redirection' => 0 ) );

		if ( ! is_wp_error( $response ) ) {
			if ( wp_remote_retrieve_response_code( $response ) == 200 ) {
				$this->html = wp_remote_retrieve_body( $response );
			} else {
				$this->html = false;
			}
		}

		return array(
			'warning'   => esc_html__( "Could not verify the frontend.", 'squirrly-seo' ),
			'completed' => true
		);
	}

	/**
	 * Check the common metas
	 *
	 * @return array|bool
	 */
	public function checkMetas() {
		$metas = array(
			'title'       => false,
			'description' => false,
			'og'          => false,
			'tc'          => false,
			'viewport'    => false,
			'canonical'   => false
		);
		//check if the crawl was made with success
		if ( ! $this->html ) {
			return false;
		}

		//check open graph
		preg_match_all( "/<meta[\s+]property=[\"|\']og:url[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['og'] = true;
			}
		}

		//check twitter card
		preg_match_all( "/<meta[\s+]property=[\"|\']twitter:url[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['tc'] = true;
			}
		}

		//check title
		preg_match_all( "/<title[^>]*>(.*)?<\/title>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['title'] = true;
			}
		}

		preg_match_all( "/<meta[^>]*name=[\"|\']title[\"|\'][^>]*content=[\"|\']([^>\"]*)[\"|\'][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['title'] = true;
			}
		}

		//check description
		preg_match_all( "/<meta[^>]*name=[\"|\']description[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['description'] = true;
			}
		}

		preg_match_all( "/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']description[\"|\'][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['description'] = true;
			}
		}

		//check viewport
		preg_match_all( "/<meta[^>]*name=[\"|\']viewport[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['viewport'] = true;
			}
		}

		preg_match_all( "/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']viewport[\"|\'][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['viewport'] = true;
			}
		}

		//check canonical
		preg_match_all( "/<link[^>]*rel=[\"|\']canonical[\"|\'][^>]*href=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['canonical'] = true;
			}
		}

		preg_match_all( "/<link[^>]*href=[\"]([^\"]*)[\"][^>]*rel=[\"|\']canonical[\"|\'][^>]*>/i", $this->html, $out );
		if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
			if ( ( sizeof( $out[0] ) >= 1 ) ) {
				$metas['canonical'] = true;
			}
		}

		return $metas;

	}

	/**
	 * Check if the automatically seo si active
	 *
	 * @return array
	 */
	public function getSeoSquirrlyTitle() {
		return array(
			'name'      => 'sq_auto_title',
			'value'     => 1,
			'completed' => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_title' ),
		);
	}

	/**
	 * Check for META duplicates
	 *
	 * @return array
	 */
	public function getDuplicateOG() {
		$valid = true;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<meta[\s+]property=[\"|\']og:url[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				if ( ( sizeof( $out[0] ) > 1 ) ) {
					$valid = false;
				}

			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check for META duplicates
	 *
	 * @return array
	 */
	public function getDuplicateTC() {
		$valid = true;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<meta[\s+]name=[\"|\']twitter:card[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				if ( ( sizeof( $out[0] ) > 1 ) ) {
					$valid = false;
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check for META duplicates
	 *
	 * @return array
	 */
	public function getDuplicateTitle() {
		$valid = true;
		$total = 0;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<title[^>]*>(.*)?<\/title>/i", $this->html, $out );

			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}

			preg_match_all( "/<meta[^>]*name=[\"|\']title[\"|\'][^>]*content=[\"|\']([^>\"]*)[\"|\'][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}
		}

		if ( $total > 1 ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check if there isn't a META Title
	 *
	 * @return array
	 */
	public function getNoTitle() {
		$valid = true;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<title[^>]*>(.*)?<\/title>/i", $this->html, $out );

			if ( empty( $out ) ) {
				$valid = false;
			}
		}


		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check if there isn't a META description
	 *
	 * @return array
	 */
	public function getEmptyDescription() {
		$valid = true;
		$total = 0;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<meta[^>]*name=[\"|\']description[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}

			preg_match_all( "/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']description[\"|\'][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}
		}

		if ( $total == 0 ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check if the title is empty
	 *
	 * @return array
	 */
	public function getEmptyTitle() {
		$valid = true;
		$total = 0;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<title[^>]*>(.*)?<\/title>/i", $this->html, $out );

			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}

			preg_match_all( "/<meta[^>]*name=[\"|\']title[\"|\'][^>]*content=[\"|\']([^>\"]*)[\"|\'][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}
		}

		if ( $total == 0 ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check for META duplicates
	 *
	 * @return array
	 */
	public function getDuplicateDescription() {
		$valid = true;
		$total = 0;

		//check if the crawl was made with success
		if ( ! $this->html ) {
			return array(
				'completed' => true
			);
		}

		if ( $this->html <> '' ) {
			preg_match_all( "/<meta[^>]*name=[\"|\']description[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}

			preg_match_all( "/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']description[\"|\'][^>]*>/i", $this->html, $out );
			if ( ! empty( $out ) && isset( $out[0] ) && is_array( $out[0] ) ) {
				$total += sizeof( $out[0] );
			}
		}

		if ( $total > 1 ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check if the blog is in private mode
	 *
	 * @return array
	 */
	public static function getPrivateBlog() {
		return array(
			'completed' => ( (int) get_option( 'blog_public' ) == 1 )
		);
	}

	/**
	 * Check if the blog has a bad link structure
	 *
	 * @return array
	 */
	public function getBadLinkStructure() {
		$structure = get_option( 'permalink_structure' );

		return array(
			'completed' => ( $structure ? ( strpos( $structure, 'postname' ) !== false ) : false )
		);
	}

	public function getDefaultTagline() {
		$blog_description            = get_bloginfo( 'description' );
		$default_blog_description    = esc_html__( "'Just another WordPress site'" );
		$translated_blog_description = esc_html__( "Just another WordPress site" );

		return array(
			'completed' => ! ( $translated_blog_description === $blog_description && $default_blog_description === $blog_description )
		);
	}

	/**
	 * Check Local Robots
	 *
	 * @return array
	 */
	public function getRobots() {
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ) ) {
			return array(
				'completed' => 1
			);
		}

		return array();
	}

	/**
	 * Check Local Sitemap
	 *
	 * @return array
	 */
	public function getSitemap() {
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ) {
			return array(
				'completed' => 1
			);
		}

		return array();
	}


	/**
	 * Check AMP Website
	 *
	 * @return array
	 */
	public function getAMPWebsite() {
		$valid = true;
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_amp' ) ) {
				$valid = false;
			}
		}

		if ( function_exists( 'is_amp' ) && is_amp() ) {
			if ( ! SQ_Classes_Helpers_Tools::getOption( 'sq_auto_amp' ) ) {
				$valid = false;
			}
		}

		return array(
			'name'      => 'sq_auto_amp',
			'value'     => 1,
			'completed' => $valid
		);
	}

	public function getMobileFriendly() {
		//check if mobile friends meta
	}

	public function processFocusPages() {
		if ( ! $this->focuspages ) {
			//initiate the focus pages
			$this->focuspages = array();

			SQ_Classes_ObjController::getClass( 'SQ_Models_FocusPages' )->init();
			$focuspages = SQ_Classes_RemoteController::getFocusPages();

			if ( $focuspages && ! empty( $focuspages ) ) {
				//Get the audits for the focus pages
				$audits = SQ_Classes_RemoteController::getFocusAudits();

				foreach ( $focuspages as $focuspage ) {
					//Add the audit data if exists
					if ( isset( $focuspage->user_post_id ) && ! empty( $audits ) ) {
						foreach ( $audits as $audit ) {
							if ( $focuspage->user_post_id == $audit->user_post_id ) {
								if ( isset( $audit->visibility ) && $audit->visibility >= 0 ) {
									$focuspage->visibility = $audit->visibility; //set the visibility score (chances of ranking)
								}
								if ( isset( $audit->audit ) ) {
									$focuspage->audit = json_decode( $audit->audit ); //set the audit data
								}
								if ( isset( $audit->stats ) ) {
									$focuspage->stats = json_decode( $audit->stats ); //set the stats data
								}
							}
						}
					}

					/** @var SQ_Models_Domain_FocusPage $focuspage */
					$focuspage = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_FocusPage', $focuspage );

					//set the connection info with GSC and GA
					$focuspage->audit->sq_analytics_gsc_connected    = ( isset( $this->checkin->connection_gsc ) ? $this->checkin->connection_gsc : 0 );
					$focuspage->audit->sq_analytics_google_connected = ( isset( $this->checkin->connection_ga ) ? $this->checkin->connection_ga : 0 );
					$focuspage->audit->sq_subscription_serpcheck     = ( isset( $this->checkin->subscription_serpcheck ) ? $this->checkin->subscription_serpcheck : 0 );

					//If there is a local page, then show focus
					if ( $focuspage->getWppost() ) {
						$this->focuspages[] = SQ_Classes_ObjController::getClass( 'SQ_Models_FocusPages' )->parseFocusPage( $focuspage )->getFocusPage();
					}
				}
			}
		}
	}

	/**
	 * Check the Focus Pages for this website
	 *
	 * @return array
	 */
	public function NoFocusPages() {
		$valid = true;

		if ( is_wp_error( $this->focuspages ) ) {
			$valid = false;
		} elseif ( empty( $this->focuspages ) ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	public function ErrorFocusPages() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = true;
		/**  @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( $focuspage->audit_error ) {
					$array = $this->getErrorMessage( $focuspage->audit_error );
					$valid = false;
					break;
				}
			}
		}
		$array['completed'] = $valid;

		return $array;
	}

	public function getErrorMessage( $error_code ) {
		switch ( $error_code ) {
			case 404:
			case 400:
				return array(
					'warning'  => sprintf( esc_html__( "Focus Page was not found (error %s)", 'squirrly-seo' ), $error_code ),
					'message'  => sprintf( esc_html__( "In case this is happening for ALL pages, please whitelist our crawler IPs from your hosting, even if they are not blocked. If you can't find where to whitelist the IPs, the easiest solution would be to contact your hosting and ask them to do it for you. %s 65.108.154.199 %s 5.161.83.61 %s In case this is NOT happening for all your pages, click on the 3 dots for those pages that get the error, stop monitoring, and add it again. %s After which, make another audit.", "squirrly-seo" ), '<br /><br />', '<br />', '<br /><br />', '<br /><br />' ),
					'solution' => '',
					'goal'     => esc_html__( "An error is preventing Squirrly from processing your Focus Page audits.", 'squirrly-seo' ),
				);
			case 301:
			case 302:
			case 'external_redirect':
				return array(
					'warning'  => sprintf( esc_html__( "Your Focus Page is redirected to another page (error %s)", 'squirrly-seo' ), $error_code ),
					'message'  => sprintf( esc_html__( "Right now, your Focus Page sends users and search engines to a different URL from the one they originally requested. That’s because you set up a 301 or a 302 redirect for this page. %s A redirect indicates that your Focus Page has moved to a different location. If the wrong type of redirect has been set up, search engines can be become confused as to which page they should rank. %s A redirect also interferes with how Squirrly’s Focus Pages system operates.", 'squirrly-seo' ), '<br />', '<br />' ),
					'solution' => esc_html__( "Choose a page that does NOT redirect to a different page as your Focus Page. Your Focus Page should have a single URL associated to it so that Squirrly can serve you the best data.", 'squirrly-seo' ),
					'goal'     => esc_html__( "Make sure that your Focus Page is NOT redirected to a different page.", 'squirrly-seo' ),
				);
			case 500:
			case 503:
				return array(
					'warning'  => sprintf( esc_html__( "Ensure your Focus Pages can be accessed (error %s)", 'squirrly-seo' ), $error_code ),
					'message'  => sprintf( esc_html__( "A server-side error is preventing Squirrly from being able to access and audit your Focus Page. You need to fix this so that Squirrly SEO can analyze your page and serve you complete data on how to improve its chances of ranking. %sThe error can also prevent human visitors from accessing your page, which is a critical issue.", 'squirrly-seo' ), '<br />', '<br />' ),
					'solution' => esc_html__( "Use a different browser to check if your Focus Page is visible. Whitelist our crawler IP address (5.161.83.61) to allow our server to verify your page so that you’ll receive a full audit.", 'squirrly-seo' ),
					'goal'     => esc_html__( "A server-side error is preventing your Focus Pages from being accessed.", 'squirrly-seo' ),
				);
			case 521:
				return array(
					'warning'  => sprintf( esc_html__( "Make sure your Focus Pages can be audited (error %s)", 'squirrly-seo' ), $error_code ),
					'message'  => esc_html__( "Squirrly is unable to generate the audit for your Focus Page because it can’t connect to your WordPress site’s server. Why? Your WordPress site’s server may be down, or maybe your server is inadvertently blocking Squirrly’s IP address.", 'squirrly-seo' ),
					'solution' => esc_html__( "Check to see if your WordPress site’s server is offline. Whitelist our crawler IP address (5.161.83.61) to allow our server to verify your page so that you’ll receive a full audit.", 'squirrly-seo' ),
					'goal'     => esc_html__( "An error prevents Squirrly from gathering critical data about your Focus Page.", 'squirrly-seo' ),
				);
			case 'firewall':
				return array(
					'warning'  => esc_html__( "Make sure your Focus Pages can be audited (firewall protection)", 'squirrly-seo' ),
					'message'  => esc_html__( "Squirrly is unable to generate the audit for your Focus Page because it can’t connect to your WordPress site’s server. Why? Your WordPress site’s server has a firewall protection and is blocking Squirrly’s IP address.", 'squirrly-seo' ),
					'solution' => esc_html__( "Whitelist our crawler IP address (5.161.83.61) to allow our server to verify your page so that you’ll receive a full audit.", 'squirrly-seo' ),
					'goal'     => esc_html__( "An error prevents Squirrly from gathering critical data about your Focus Page.", 'squirrly-seo' ),
				);
			case 'limit_exceeded':
				return array(
					'warning'  => esc_html__( "Focus Pages - Limit Exceeded", 'squirrly-seo' ),
					'message'  => esc_html__( "Squirrly is unable to generate the audit for your Focus Page because you exceeded the maximum number of Focus Pages for your account.", 'squirrly-seo' ),
					'solution' => esc_html__( "Upgrade your account to be able to see all the Focus Pages you added.", 'squirrly-seo' ),
					'goal'     => '',
				);
		}

		return array(
			'warning'  => sprintf( esc_html__( "Focus Page could not be verified (error: %s)", 'squirrly-seo' ), $error_code ),
			'message'  => sprintf( esc_html__( "In case this is happening for ALL pages, please whitelist our crawler IPs from your hosting, even if they are not blocked. If you can't find where to whitelist the IPs, the easiest solution would be to contact your hosting and ask them to do it for you. %s 65.108.154.199 %s 5.161.83.61 %s In case this is NOT happening for all your pages, click on the 3 dots for those pages that get the error, stop monitoring, and add it again. %s After which, make another audit.", "squirrly-seo" ), '<br /><br />', '<br />', '<br /><br />', '<br /><br />' ),
			'solution' => '',
			'goal'     => esc_html__( "An error is preventing Squirrly from processing your Focus Page audits.", 'squirrly-seo' ),
		);
	}

	public function FocusPagesDoFollowLinks() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = true;

		/** @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {

					/** @var SQ_Models_Focuspages_Onpage $assistant */
					$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Nofollow' );
					$assistant->setAudit( $focuspage->getAudit() );
					$assistant->setPost( $focuspage->getWppost() );
					$assistant->init();

					$assistant->setTasks( array() );
					$tasks = $assistant->parseTasks( $assistant->getTasks() );

					if ( isset( $tasks['nofollow'] ) && ! empty( $tasks['nofollow'] ) ) {
						foreach ( $tasks['nofollow'] as $task ) {

							if ( ! $task['completed'] && $task['active'] ) {
								$valid = false;
							}
						}
					}
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the Focus Pages for Platform SEO category
	 *
	 * @return false|array
	 */
	public function FocusPagesPlatformSEO() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = true;

		/** @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {

					/** @var SQ_Models_Focuspages_Onpage $assistant */
					$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Onpage' );
					$assistant->setAudit( $focuspage->getAudit() );
					$assistant->setPost( $focuspage->getWppost() );
					$assistant->init();

					$assistant->setTasks( array() );
					$tasks = $assistant->parseTasks( $assistant->getTasks() );

					if ( isset( $tasks['onpage'] ) && ! empty( $tasks['onpage'] ) ) {
						foreach ( $tasks['onpage'] as $task ) {

							if ( ! $task['completed'] && $task['active'] ) {
								$valid = false;
							}
						}
					}
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}


	public function GoogleSearchConsole() {
		$valid = true;

		if ( isset( $this->checkin->connection_gsc ) && ! $this->checkin->connection_gsc ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	public function GoogleAnalytics() {
		$valid = true;

		if ( isset( $this->checkin->connection_ga ) && ! $this->checkin->connection_ga ) {
			$valid = false;
		}

		return array(
			'completed' => $valid
		);
	}

	public function FocusPagesVisibility() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = true;

		/**  @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) && ( isset( $this->checkin->connection_gsc ) && $this->checkin->connection_gsc ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {
					/** @var SQ_Models_Focuspages_Indexability $assistant */
					$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Indexability' );
					$assistant->setAudit( $focuspage->getAudit() );
					$assistant->setPost( $focuspage->getWppost() );
					$assistant->init();

					$assistant->setTasks( array() );
					$tasks = $assistant->parseTasks( $assistant->getTasks() );

					if ( isset( $tasks['indexability'] ) && ! empty( $tasks['indexability'] ) ) {

						foreach ( $tasks['indexability'] as $task ) {
							if ( ! $task['completed'] && $task['active'] ) {
								$valid = false;
							}
						}

					}
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}


	/**
	 * Check if Focus Pages are all Indexed in Google Search Console
	 */
	public function FocusPagesIndexed() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = false;

		/**  @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) && ( isset( $this->checkin->connection_gsc ) && $this->checkin->connection_gsc ) ) {
			$valid = true;
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check if SEO Patterns are activated
	 */
	public function getSeoPatterns() {
		return array(
			'name'      => 'sq_auto_pattern',
			'value'     => 1,
			'completed' => SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ),
		);
	}

	/**
	 * Check the Focus Pages for Snippet SEO category
	 *
	 * @return array | false
	 */
	public function FocusPagesSnippet() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = true;

		/** @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {

					/**  @var SQ_Models_Focuspages_Snippet $assistant */
					$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Snippet' );
					$assistant->setAudit( $focuspage->getAudit() );
					$assistant->setPost( $focuspage->getWppost() );
					$assistant->init();

					$assistant->setTasks( array() );
					$tasks = $assistant->parseTasks( $assistant->getTasks() );

					if ( isset( $tasks['snippet'] ) && ! empty( $tasks['snippet'] ) ) {

						foreach ( $tasks['snippet'] as $name => $task ) {
							if ( $name == 'jsondetails' && ! $task['completed'] && $task['active'] ) {
								$valid = false;
							}
						}

					}
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the Focus Pages for SEO Content category
	 *
	 * @return array | false
	 */
	public function FocusPagesContent() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = true;

		/**  @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {

					/** @var SQ_Models_Focuspages_Content $assistant */
					$assistant = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Focuspages_Content' );
					$assistant->setAudit( $focuspage->getAudit() );
					$assistant->setPost( $focuspage->getWppost() );
					$assistant->init();

					$assistant->setTasks( array() );
					$tasks = $assistant->parseTasks( $assistant->getTasks() );

					if ( isset( $tasks['content'] ) && ! empty( $tasks['content'] ) ) {

						foreach ( $tasks['content'] as $name => $task ) {
							if ( $name == 'optimization' && (int) $task['value'] < 90 ) {
								$valid = true;
								break;
							} elseif ( ! $task['completed'] && $task['active'] ) {
								$valid = false;
							}
						}

					}
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the Assistant Tasks for SEO settings completed
	 *
	 * @return array | false
	 */
	public function SeoSettingsGreen() {
		$valid = true;

		remove_all_filters( 'sq_assistant_tasks' );
		$tasks = SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->parseAllTasks( 'sq_seosettings' );

		foreach ( $tasks as $name => $task ) {
			if ( ! $task['completed'] && $task['active'] ) {
				$valid = false;
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the SEO Audit score for the website
	 *
	 * @return array | false
	 */
	public function SeoAuditScore() {
		$valid = true;
		if ( ! isset( $this->siteaudit ) ) {
			$this->siteaudit = SQ_Classes_RemoteController::getAudit();
		}

		if ( ! is_wp_error( $this->siteaudit ) ) {
			if ( isset( $this->siteaudit->score ) ) {
				if ( $this->siteaudit->score < 30 ) {
					$valid = false;
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the SEO Audit score for the website
	 *
	 * @return array | false
	 */
	public function SeoAuditScore50() {
		$valid = true;
		if ( ! isset( $this->siteaudit ) ) {
			$this->siteaudit = SQ_Classes_RemoteController::getAudit();
		}

		if ( ! is_wp_error( $this->siteaudit ) ) {
			if ( isset( $this->siteaudit->score ) ) {
				if ( $this->siteaudit->score < 50 ) {
					$valid = false;
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the Inner links for the focus page
	 * See if there is a list one inner link to a focus page
	 *
	 * @return array | false
	 */
	public function FocusPagesInnerLinks() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = false;

		/** @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {
					$audit = $focuspage->getAudit();
					if ( $audit->permalink <> '' ) {
						$path = parse_url( $audit->permalink, PHP_URL_PATH );
						if ( $path == '' ) {
							$path = $audit->permalink;
						}

						if ( ! isset( $audit->data->sq_seo_innerlinks->inner_links ) ) {
							global $wpdb;

							if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT COUNT(`ID`) as count FROM `$wpdb->posts` WHERE `post_content` LIKE '%%%s%' AND `post_status` = %s", $path, 'publish' ) ) ) {
								$valid = ( $row->count >= 1 );
							}

						} else {
							$valid = ( (int) $audit->data->sq_seo_innerlinks->inner_links >= 1 );
						}
					}
				}

				if ( $valid ) {
					break;
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the Inner links for the focus page
	 * See if there are 3 inner links to a focus page
	 *
	 * @return array | false
	 */
	public function FocusPagesInnerLinks3() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = false;

		if ( ! $this->dbtasks[ $this->category_name ]['FocusPagesInnerLinks']['completed'] ) {
			return false;
		}

		/** @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {
					$audit = $focuspage->getAudit();
					if ( $audit->permalink <> '' ) {
						$path = parse_url( $audit->permalink, PHP_URL_PATH );
						if ( $path == '' ) {
							$path = $audit->permalink;
						}

						if ( ! isset( $audit->data->sq_seo_innerlinks->inner_links ) ) {
							global $wpdb;

							if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT COUNT(`ID`) as count FROM `$wpdb->posts` WHERE `post_content` LIKE '%%%s%' AND `post_status` = %s", $path, 'publish' ) ) ) {
								$valid = ( $row->count >= 3 );
							}

						} else {
							$valid = ( (int) $audit->data->sq_seo_innerlinks->inner_links >= 3 );
						}
					}
				}

				if ( $valid ) {
					break;
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

	/**
	 * Check the Inner links for the focus page
	 * See if there are 5 inner link to a focus page
	 *
	 * @return array | false
	 */
	public function FocusPagesInnerLinks5() {
		if ( ! $this->focuspages ) {
			return false;
		}
		$valid = false;

		if ( isset( $this->dbtasks[ $this->category_name ]['FocusPagesInnerLinks3']['completed'] ) && ! $this->dbtasks[ $this->category_name ]['FocusPagesInnerLinks3']['completed'] ) {
			return false;
		}

		/** @var $focuspage SQ_Models_Domain_FocusPage */
		if ( ! empty( $this->focuspages ) ) {
			foreach ( $this->focuspages as $focuspage ) {
				if ( ! $focuspage->audit_error ) {
					$audit = $focuspage->getAudit();
					if ( $audit->permalink <> '' ) {
						$path = parse_url( $audit->permalink, PHP_URL_PATH );
						if ( $path == '' ) {
							$path = $audit->permalink;
						}

						if ( ! isset( $audit->data->sq_seo_innerlinks->inner_links ) ) {
							global $wpdb;

							if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT COUNT(`ID`) as count FROM `$wpdb->posts` WHERE `post_content` LIKE '%%%s%' AND `post_status` = %s", $path, 'publish' ) ) ) {
								$valid = ( $row->count >= 5 );
							}

						} else {
							$valid = ( (int) $audit->data->sq_seo_innerlinks->inner_links >= 5 );
						}
					}
				}

				if ( $valid ) {
					break;
				}
			}
		}

		return array(
			'completed' => $valid
		);
	}

}
