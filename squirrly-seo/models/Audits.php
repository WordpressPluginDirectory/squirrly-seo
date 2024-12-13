<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Audits {

	/**
	 * @var array todos
	 */
	protected $_todo = array();

	/**
	 * @var SQ_Models_Domain_AuditPage
	 */
	protected $_auditpage;

	public function getTasks() {
		return array(
			'blogging'  => array(
				'Optimization' => array(
					'complete'     => false,
					'title'        => esc_html__( "Average Content Optimization", 'squirrly-seo' ),
					'success'      => '%s%%. ' . esc_html__( "Great!", 'squirrly-seo' ),
					'fail'         => '%s%%. ' . esc_html__( "hmm...", 'squirrly-seo' ),
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the SEO optimization of a page on our website? %s Find an amazing keyword set to use for your page. %s If you have a page about a Jazz Concert that John Dane (fictional name used for this example) will do on 9th of August 2025 in Phoenix, AZ, then you can try and find the best keywords you can use, that are related to: 'jazz concert', 'john dane', 'jazz 2025' and 'jazz in phoenix'. Find out what others search for. If you'll optimize the page for those keywords, you'll be certain that jazz fans will find it. The Keyword Research tool available in Squirrly SEO helps you figure out exactly what keywords to use. %s Start optimizing your content.  Use the Live Assistant from Squirrly SEO to do this, as it guides you towards the best practices of optimizing a page for SEO and helps you avoid keyword stuffing.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Optimization is NOT about stuffing in keywords. It's about writing the page in such a way that Search Engine bots and Humans alike will easily understand that the page is exactly about the topic they were searching for. Use the Live Assistant from Squirrly SEO to get the job done with ease.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Use tools like Squirrly Keyword Research and Squirrly Live Assistant to optimize your content", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistants' ),
				),
				'DcPublisher'  => array(
					'complete'     => false,
					'title'        => esc_html__( "DcPublisher Meta", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without DcPublisher meta", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => esc_html__( "Dublin Core is a set of standard metadata elements used to describe the contents of a website. It can help with some internal search engines and it does not bloat your code.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add the meta DcPublisher tag in the page's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
			),
			'traffic'   => array(
				'TopTen'    => array(
					'complete'     => false,
					'title'        => esc_html__( "Top Ten Pages This Week", 'squirrly-seo' ),
					'success'      => '',
					'fail'         => '',
					'success_list' => '<div class="sq_list_success">%s</div>',
					'fail_list'    => '<div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "If there is enough data in Google Analytics, you should see the list of pages with the most visitors in the last week in the Traffic section of your SEO Audit. %s Having at least 100 visitors per page every week is crucial. %s Search Engines like Google and Bing will push down a page which doesn't attract visitors.", 'squirrly-seo' ), '<br/><br/>', '<br/>' ),
				),
				'PageViews' => array(
					'complete'     => false,
					'title'        => esc_html__( "Page Traffic", 'squirrly-seo' ),
					'success'      => '{total} ' . esc_html__( " total visits / mo.", 'squirrly-seo' ),
					'fail'         => '',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with low traffic", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Overall Traffic of the website? %s Make sure you have active listings which can be easily found on various marketplaces / platforms. eg: you have a Shopify app, a Chrome Extension, a Chrome App, a Udemy Course, Slides on SlideShare.com, videos on Youtube, an infographic on Pinterest, etc. These will always bring you constant traffic to the website and once you set it (and make it visible) you can forget it. It will keep bringing you traffic. Of course, the key is to first make these items visible in the places where you publish them. %s You need an email list. Make sure that people who come to your store, do business with you, visit your website, or read your blog give you their email address so you can communicate with them further on. An alternative to this is to make a Chatbot for Facebook Messenger and get them hooked to the bot. By doing any of these, you'll be able to bring those people back to your website. %s Use the Keyword Research tool included in Squirrly SEO, to spot keywords that are easy to rank for: [link]https://plugin.squirrly.co/best-keyword-research-tool-for-seo/[/link] %sRank for more keywords with low competition. This will start building up traffic for your site. %sTo Easily rank new pages, use the SEO Goals: [link]https://plugin.squirrly.co/best-seo-goals/[/link] %sStudy website rankings to learn how to bring more traffic, by using our Special Cloud Services for Rank Checking, available only on: Business Plans [link]https://plugin.squirrly.co/squirrly-seo-pricing/[/link]", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Get each person who arrives on your site once to leave something that you can use later on to bring them to your site again. You can use Facebook Pixel and then retarget them, you can make them subscribe to Desktop Notifications to receive push notifications, you can have them download an app, subscribe to a newsletter, etc. Sometimes it's best if you can create clever funnels that will ensure that any person may start following you on multiple such channels.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Try to gain organic traffic to your site's pages", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
			),
			'seo'       => array(
				'NoIndex'                   => array(
					'complete'     => false,
					'title'        => esc_html__( "Visible for search engines?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with noindex", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the noindex for our pages? %s If you DON'T have a check mark for this task, it means you're currently telling Google not to index some of your pages through a robots tag inside your code. %s On WordPress, it's super easy to control on which pages to place no-index and which pages should never get tagged with no-index if you use the Squirrly SEO Plugin. %s If you decided you 100%% want these pages to be No-Index (you don’t want Google to index them) - then remove these pages from the SEO Audit. Use the SEO Audit for the pages you want to be seen on search engines.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Some pages are better off if they have an associated no-index tag. Every website has a couple of pages that would be completely pointless to appear in search results, because they wouldn't ever make any sense for potential searchers.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add the correct meta robots tag in the pages", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'NoFollow'                  => array(
					'complete'     => false,
					'title'        => esc_html__( "Followed by search engines?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with nofollow", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the nofollow for our pages? %s If you DON'T have a check mark for this task, it means you're currently telling Google not to follow some of your pages through a robots tag inside your code. %s On WordPress, it's super easy to control on which pages to place nofollow and which pages should never get tagged with nofollow if you use the Squirrly SEO Plugin. %s If you're using something else, make sure you remove <META NAME=“ROBOTS” CONTENT=“NOFOLLOW”> from the <head> of your HTML.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Some pages are better off if they have an associated nofollow tag. Every website has a couple of pages that would be completely pointless to be followed by search results like: Contact Us, Terms and Policy.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add the correct meta robots tag in the pages", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'SafeBrowsing'              => array(
					'complete'     => false,
					'title'        => esc_html__( "Is your site Safe Browsing?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we get our website to be Safe Browsing compliant? %s Make sure you find and delete all malware from your website. %s Watch this video to learn more. [link]https://www.youtube.com/embed/7GStGcTeo20[/link] %s Once you feel like you've fixed your problems you can check using this tool from Google: [link]https://transparencyreport.google.com/safe-browsing/search[/link]%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "This is a TOP priority if you're having a Safe Browsing problem at the moment. Browsers will NOT allow web visitors to actually access your pages. It will also cause you other problems like lower search rankings.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Speed'                     => array(
					'complete'     => false,
					'title'        => esc_html__( "Page load time", 'squirrly-seo' ),
					'success'      => '{total}' . 's ' . esc_html__( "average is a good time" ),
					'fail'         => '{total}' . 's ' . esc_html__( "average is slow" ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The slow pages are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the loading speed of the website? %s Use smaller images, or compress them with tools like ShortPixel.com %s Minify Javascripts, use CDNs, use gZip. %s Use a professional service if your site is based on WordPress. Our parent company, Squirrly Limited, offers such a service for WordPress.org based websites [link]https://www.squirrly.co/agency/[/link] %s After you optimize the page, test the loading Speed Index with Google Speed Test here [link]https://developers.google.com/speed/pagespeed/insights/[/link] %s", 'squirrly-seo' ), '<ul><li>', '</li><li class="sq-reference">Squirrly negotiated a special Free Plan for you that gives you more credits for images, then they do on their own sites: <a href="https://www.squirrly.co/wordpress/plugins/short-pixel/" title="shortpixel" target="_blank">https://www.squirrly.co/wordpress/plugins/short-pixel/</a><br /> ShortPixel reduced the size of our images by 84% and kept the same quality” - Andreea, Communications Expert at Squirrly </li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Increasing loading speed will bring you more engagement, lower bounce rates AND more search engine results.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Optimize your site's speed", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DuplicateTitles'           => array(
					'complete'     => false,
					'title'        => esc_html__( "Duplicate Titles", 'squirrly-seo' ),
					'success'      => esc_html__( "No duplicate titles.", 'squirrly-seo' ),
					'fail'         => esc_html__( "We found duplicates.", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success"><span class="text-primary">' . esc_html__( "Great!", 'squirrly-seo' ) . '</span> ' . esc_html__( "The pages on your site have unique title tags.", 'squirrly-seo' ) . '</div>',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The Pages with Duplicate Titles are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Duplicate Titles on our pages? %s Features like SEO Automation or SEO Snippet from Squirrly SEO will generate your META title automatically from the content of your page (in case you didn't already place a custom title). Make every single META Title of every page unique (you never repeat it on any other URL from the website). You will write what you want Google to display in the search results as a title for your listing. Make this text awesome and you'll get people clicking on it. %s See if you can assign rules to WordPress to have it change the Title of each URL according to different patterns. Normally the platform will take the Title of the latest product inside the category and add it to the Title of that particular category. In this case you can end up with something like: example.com/shooter-games will have title: 'Counter Strike GO. Buy it Now' and also: example.com/shooter-games/cs-go will also have title: 'Counter Strike GO. Buy it Now'. %s All these problematic cases can be forgotten once you start using Squirrly SEO . With its Patterns feature, it will create rules for WordPress that ensure each title for each page on your site is unique. This feature is available in the Free version of Squirry.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "On WordPress you can use Squirrly SEO to control everything about your page Titles and make them stand out on search engines.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add different titles to each page. You can do it manually or use SEO tools (like Squirrly) for that.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DuplicateDescription'      => array(
					'complete'     => false,
					'title'        => esc_html__( "Duplicate Descriptions", 'squirrly-seo' ),
					'success'      => esc_html__( "No duplicate descriptions.", 'squirrly-seo' ),
					'fail'         => esc_html__( "We found duplicates.", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success"><span class="text-primary">' . esc_html__( "Great!", 'squirrly-seo' ) . '</span> ' . esc_html__( "The pages on your site have unique meta descriptions.", 'squirrly-seo' ) . '</div>',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The Pages on which we found duplicates are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Duplicate Descriptions on our website? %s Use the SEO Automation feature from Squirrly SEO, because it will generate your META description automatically from the content of your page (in case you didn't already place a custom description). Make every single META description of every page unique (you never repeat it on any other URL from the website). Make this text awesome and you'll get people clicking on it. %s Use the Patterns feature from Squirrly SEO. It will help you create rules for WordPress that ensure each description for each page on your site is unique. This feature is available on all plans. %s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Use Squirrly SEO’s BULK SEO section to control everything about your META descriptions and make them stand out on search engines.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add different description to each page. You can do it manually or use SEO tools (like Squirrly) for that.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'EmptyTitles'               => array(
					'complete'     => false,
					'title'        => esc_html__( "Empty Titles", 'squirrly-seo' ),
					'success'      => esc_html__( "All pages have titles.", 'squirrly-seo' ),
					'fail'         => esc_html__( "There are some pages without title.", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success"><span class="text-primary">' . esc_html__( "Great!", 'squirrly-seo' ) . '</span> ' . esc_html__( "all the pages on your site have the title tag defined :-)", 'squirrly-seo' ) . '</div>',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with empty Title tags are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Empty Titles on our pages? %s Use Squirrly’s SEO Automation features or the SEO Snippet to generate your META title automatically from the content of your page. Write what you want Google to display in the search results as a title for your listing. Make this text awesome and you'll get people clicking on it. %s Use the Patterns feature from Squirrly. It will create rules for WordPress that ensure each title for each page on your site is unique. This feature is available on all plans.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Use Squirrly SEO to create and control everything about your META titles and make them stand out on search engines.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add a Title tag to each page in your site.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'EmptyDescription'          => array(
					'complete'     => false,
					'title'        => esc_html__( "Empty Descriptions", 'squirrly-seo' ),
					'success'      => esc_html__( "All articles have description.", 'squirrly-seo' ),
					'fail'         => esc_html__( "There are some pages without description.", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success"><span class="text-primary">' . esc_html__( "Great!", 'squirrly-seo' ) . '</span> ' . esc_html__( "all the pages on your site have meta description", 'squirrly-seo' ) . '</div>',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with empty description are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Empty Descriptions on our website? %s Use Squirrly’s SEO Automation features or the SEO Snippet which will generate your META description automatically from the content of your page.  Make this text awesome and you'll get people clicking on it. %s See if you can assign rules to WordPress to have it create META descriptions for each URL according to different patterns. By having clear rules for all URLs you'll ensure that Empty Descriptions will no longer be a problem in the future. %s All these problematic cases can be forgotten once you start using Squirrly SEO . With its Patterns feature, it will create rules for WordPress that ensure each description for each page on your site is unique. This feature is available on all plans.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Use Squirrly SEO to create and control everything about your META descriptions and make them stand out on search engines.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add meta description to each page in your site.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Title'                     => array(
					'complete'     => false,
					'title'        => esc_html__( "Do you have a title tag?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ),
					'fail'         => esc_html__( "No" ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without title tag are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the title tags of our pages? %s On WordPress, using Squirrly SEO will ensure your pages have title tags. It will create titles for every page. It will help you customize titles for every page, all while making you write ZERO code. No coding required when you use Squirrly SEO.%s", 'squirrly-seo' ), '<ul><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this aspect with their default engine.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add a Title tag to this page of your site", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Description'               => array(
					'complete'     => false,
					'title'        => esc_html__( "Do you have a meta description?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ),
					'fail'         => esc_html__( "No" ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without description meta are", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the META Descriptions of our pages? %s First of all, make sure that you understand the following: a poorly written META description will make for a horrible listing inside the Google search page. If people find your listing, they will not click on your listing in case your META Description is horrible to look at, is poorly written, or it doesn't seem to make sense. %s On WordPress, you can use Squirrly SEO for this. It will automatically create META Descriptions for every page. It will help you customize these descriptions for every page, all while making you write ZERO, nada, rien, code. No coding required when you use Squirrly SEO. You can even customize the way it automates your descriptions.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engines.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add meta description to this page of your site", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Keywords'                  => array(
					'complete'     => false,
					'title'        => esc_html__( "Meta Keyword", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ),
					'fail'         => esc_html__( "No keywords.", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success_title">' . esc_html__( "Your keywords are", 'squirrly-seo' ) . ':</div><div class="sq_list_success">%s</div>',
					'fail_list'    => '',
					'description'  => esc_html__( "It is important for search engines to know which keywords you are trying to rank for with your website. This also helps bring targeted visitors to your site.", 'squirrly-seo' ),
					'protip'       => esc_html__( "Make sure that the search for your keywords is on a rising trend", 'squirrly-seo' ),
					'solution'     => '',
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Canonical'                 => array(
					'complete'     => false,
					'title'        => esc_html__( "Canonical Link", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without canonical meta", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Canonical Links problems of our pages? %s Add this code to the <head> section of your HTML page: <link rel=\"canonical\" href=\"your site URL\" /> %s Think of a canonical link as the \"preferred version\" of the page. %s Make sure you have this definition on your URL especially if you've copied the content from another LINK on the web. Example: You published a blog post on Medium and then also added it to your own blog on your own domain. If you add the canonical link definition, then you won't be penalized for duplicate content. Medium also allows you to re-publish content from your own site to Medium and helps you get the rel=\"canonical\" inside the medium post to show that the original is hosted on your own site.%s Use Squirrly SEO's Bulk SEO to define canonical links and indexing options for your pages. %s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO to control canonical links and make sure you avoid having duplicate content.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add canonical meta link in the page header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Jsonld'                    => array(
					'complete'     => false,
					'title'        => esc_html__( "Meta Json-LD?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without Json-LD meta", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the meta Json_LD of the website? %s You need to make sure you have this tag inside your page's code: <script type=\"application/ld+json\"> . Or something similar. %s JSON-LD annotates elements on a page, structuring the data, which can then be used by search engines to disambiguate elements and establish facts surrounding entities, which is then associated with creating a more organized, better web overall.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "On WordPress you can use Squirrly SEO to add the Json-LD Structured data. Squirrly will automatically structure the information from all your products if you use Woocommerce plugin for eCommerce.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Make sure you activated JSON-LD Structured Data in All Features", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Encoding'                  => array(
					'complete'     => false,
					'title'        => esc_html__( "Page Encoding", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without encoding meta", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the character encoding specifications of the website? %s You'll have to specify this according to the encoding you use for your website. %s Adding your encoding tag to the <head> of the site will fix it. Below, you'll find what you can place, in case your encoding is UTF-8 (the majority of web pages use this) %s <meta http-equiv=“Content-Type” content=“text/html;charset=utf-8” />%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO  to get encoding specified for all your pages. Without specifying the encoding, search engines such as Google will be more likely to suggest other pages and rank other pages that DO have the specification made.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add the meta encoding tag in the page's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Sitemap'                   => array(
					'complete'     => false,
					'title'        => esc_html__( "Does your site have a feed or sitemap?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the Feed and Sitemap of the website? %s Make sure that you feed and Sitemap exists and that it is accessible. Your visitors should be able to access it using /feed, or /sitemap.xml %s Make sure your visitors can access it using domainname.com/feed (where the text \"domainname\" is actually your domain. eg. bloggingwithjane.com ) %s On WordPress, you can use Squirrly SEO to generate your FEED and the Sitemap for your whole site. It has some pretty advanced options, so that you feeds will be perfect. This feature is free to use.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Your feeds and sitemaps should contain the date when your content was published and last updated. This is super important for Google to know, as it's always looking to surface fresh content to people who search on search engines. PLUS, having this gives you the opportunity to show up when users of Google say they want to see only results from the last week. If you had anything published during the last week, these people will see it and you will gain traffic.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add a RSS feed and Sitemap to your site", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Robots'                    => array(
					'complete'     => false,
					'title'        => esc_html__( "Does your site have a robots.txt file?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the robots.txt of the website? %s You'll need to have a http://domain.com/robots.txt link on your site that crawlers can access to know which pages they are allowed to crawl. (gather info from) %s Create or Edit a robots.txt file using Squirrly SEO %s Once you have the file, upload it to your ftp (if you don’t want to let Squirrly operate it for you) and make sure it can be accessed. %s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO  to create and customize your robots.txt", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add robots.txt file in your site", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Viewport'                  => array(
					'complete'     => false,
					'title'        => esc_html__( "Meta Viewport", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without viewport meta", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the meta viewport of the website? %s You need to make sure you have this tag inside your page's code: <meta name=“viewport” content=“width=device-width, initial-scale=1”> . Or something similar. %s In case you know that the minimum resolution required to deliver a good user experience to your viewers is 500 px, then write the following: %s <meta name=“viewport” content=“width=500, initial-scale=1”>%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engine. On WordPress, you need to make sure the WordPress theme you buy is responsive and has this definition.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add the meta viewport tag in the page's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Gzip'                      => array(
					'complete'     => false,
					'title'        => esc_html__( "Site optimized for speed?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without gzip", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the gzip compression for our website? %s GZIP compression must be installed on the web server, such as in Apache, IIS and nginx. When retrieving the website the web browser will prompt the visitor he/she can receive the GZIP. %s Squirrly’s teams of experts can help you get this done. [link]https://www.squirrly.co/agency/[/link] - Premium Paid Services, separate from any software license you may have from the Squirrly Company. %s Ask your webmaster / developer / host to help you with this. Or try to find plugins to help you with this.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Setting this up saves 50% to 80% bandwidth, which will make all your pages load a lot faster.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Use gzip to increase your site's speed", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DuplicateOGMetas'          => array(
					'complete'     => false,
					'title'        => esc_html__( "Duplicate Open Graph Tags?", 'squirrly-seo' ),
					'success'      => esc_html__( "No duplicates", 'squirrly-seo' ),
					'fail'         => esc_html__( "We found some ...", 'squirrly-seo' ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with duplicate Open Graph metas", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Make sure you don't have duplicate meta tags in your site's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DuplicateTCMetas'          => array(
					'complete'     => false,
					'title'        => esc_html__( "Duplicate Twitter Card Tags?", 'squirrly-seo' ),
					'success'      => esc_html__( "No duplicates", 'squirrly-seo' ),
					'fail'         => esc_html__( "We found some ...", 'squirrly-seo' ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with duplicate Twitter Card metas", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Make sure you don't have duplicate meta tags in your site's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DuplicateTitleMetas'       => array(
					'complete'     => false,
					'title'        => esc_html__( "Duplicate Title Tags?", 'squirrly-seo' ),
					'success'      => esc_html__( "No duplicates", 'squirrly-seo' ),
					'fail'         => esc_html__( "We found some ...", 'squirrly-seo' ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with duplicate Title metas", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Make sure you don't have duplicate meta tags in your site's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DuplicateDescriptionMetas' => array(
					'complete'     => false,
					'title'        => esc_html__( "Duplicate Description Tags?", 'squirrly-seo' ),
					'success'      => esc_html__( "No duplicates", 'squirrly-seo' ),
					'fail'         => esc_html__( "We found some ...", 'squirrly-seo' ),
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages with duplicate Description metas", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Make sure you don't have duplicate meta tags in your site's header", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),

			),
			'social'    => array(
				'TopTenSocials' => array(
					'complete'     => false,
					'title'        => esc_html__( "Top Shared Pages", 'squirrly-seo' ),
					'success'      => '',
					'fail'         => '',
					'success_list' => '<div class="sq_list_success">%s</div>',
					'fail_list'    => '<div class="sq_list_success">%s</div>',
					'description'  => sprintf( esc_html__( "You can see the list of pages that got the most shares in the Social section of your SEO Audit. %s It’s very important to get more eyes on your content via social media. You need external signals and Authority for your site and pages if you want to get really good rankings. There’s really no skipping this if you want performance. %s The logic behind this is: if nobody shares your site on social media, then your site is not important. That’s how Google’s algorithm “sees” this. %s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li></ul>' ),
					'protip'       => sprintf( esc_html__( "Find proven methods for sharing on social media inside our free 10,000 Visits from Social Media training. More courses on social media are available within %s Education Cloud PLUS %s: the Premiere education platform of Squirrly.", 'squirrly-seo' ), '<a href="https://www.squirrly.co/learning/education-cloud/" target="_blank" >', '</a>' ),
				),
				'Shares'        => array(
					'complete'     => false,
					'title'        => esc_html__( "Shares", 'squirrly-seo' ),
					'success'      => '',
					'fail'         => '',
					'success_list' => '<div class="sq_list_success">%s</div>',
					'fail_list'    => '<div class="sq_list_success">%s</div>',
					'description'  => sprintf( htmlentities( esc_html__( "How can we raise the Social Media Shares (or signals) for our pages on Social Media? %s Use a tool like SalesFlare or FullContact (both paid) to extract the social media profiles of your customers, users, email subscribers and even LinkedIN Connections. Then make sure they follow you on Social Media. An easy way to do this is to follow them yourself. They already care about you and your company. They will gladly interact with your profiles. Using tools like these will also give you a clear picture of what Social Media platforms your desired audience uses most, so that you can create profiles only for those social media platforms. %s You should create social media Giveaways, or even viral communities like: [link]https://www.squirrly.co/dmsuperstars/[/link] %s Use a service like [link]https://techfork.xyz/about/[/link] (warning: other social media providers will most likely cause problems, because they use bots. - TechFork has been verified by our community and it has been a partner for over 4 years) %s Learn from our Episode on the Marketing Education Cloud Podcast how to share your pages so that you get better social signals and also 10,000 visits from social media: [link]https://www.squirrly.co/podcast/[/link] %s", 'squirrly-seo' ) ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "All the shares and likes that your fans will give your pages will contribute to the total number of shares from social media (social signals). When Google’s algorithm starts “seeing” that people share your pages on social media, it will consider that your site is becoming popular and will increase its rankings.", 'squirrly-seo' ),
					'solution'     => esc_html__( "You have to share your articles with your fans", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'ShareButtons'  => array(
					'complete'     => false,
					'title'        => esc_html__( "Share Buttons in your articles?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without share buttons", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we get social media share buttons on our website? %s There are many options to help you get social sharing buttons inside your website. However, you should be careful not to let them ruin your loading times. Most plugins and apps will do that. %s Sumo.com is an Okay option. I'm not really happy with them, because I find it slows my pages. %s My current favorites are [link]http://info.zotabox.com/[/link] . I'm using them on Shopify and WordPress. It works with any CMS platform. The loading speed is great and their social media counters work perfectly.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "All there is to it is: make the buttons obvious, so people can easily find them. Make sure they don't slow your site down. Make sure they look great on mobile.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add Social Share buttons in your articles", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'FollowButtons' => array(
					'complete'     => false,
					'title'        => esc_html__( "Social 'Follow me' Buttons?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without social buttons", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Social Follow Me buttons of the website? %s Add buttons to your website, that allow your visitors to check your social media profiles and follow you on social media. %s This is one of the most important aspects nowadays, if you want to build trust with your website. %s Learn more with Expectation Marketing. Expectation Marketing is all about teaching you how to implement such buttons and other trust elements for your digital brand. [link]http://expectationmarketing.com/[/link] %s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Place the buttons in your site's footer, to make sure they're always accessible. Web users are used to finding them there when they wish to connect to brands on social media.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add links to your Social Media profiles to strengthen social signals and keep readers engaged.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'OpenGraph'     => array(
					'complete'     => false,
					'title'        => esc_html__( "Open Graph protocol?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without Open Graph metas", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Open Graph of the website? %s You need to make sure you're going to fix the Open Graph image AS WELL AS all the other open graph elements. %s If you're on WordPress, you're easily getting all the settings you need from Squirrly SEO. Make sure you use it. %s Below, you can see the examples of open graph elements you need to implement in the <head> section of your page's code. Make sure you replace the elements inside content=\" \" with your own data: your own titles, own image URLs, etc. %s <meta property=“og:url” content=“{site}/product/expectation-marketing-ebook/“ /> %s <meta property=“og:title” content=“Expectation Marketing [Book]” /> %s <meta property=“og:description” content=“If you`re wondering why your marketing strategy isn`t bringing the results you expected this is the right ebook for you. Expectation Marketing is about giving you an acti” /> %s <meta property=“og:type” content=“product” /> %s <meta property=“og:image” content=“{site}/image.jpg” /> %s <meta property=“og:image:width” content=“700” /> %s <meta property=“og:image:height” content=“536” /> %s <meta property=“og:image:type” content=“image/jpeg” /> %s <meta property=“og:site_name” content=“Expectation Marketing” /> %s <meta property=“og:locale” content=“en” />%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul><pre style="white-space: initial !important;">', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '</pre>' ),
					'protip'       => esc_html__( "Fixing this will improve Click Through Rates on Facebook, LinkedIN. Guaranteed. Make sure you use this to control how your pages look on social media when people share them.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add the meta Open Graph tag in your page's header.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'TwitterCard'   => array(
					'complete'     => false,
					'title'        => esc_html__( "Twitter Card?", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "The pages without Twitter Card metas", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Twitter Cards of the website? %s You need to make sure you're going to fix the Twitter Card image AS WELL AS all the other twitter card elements. %s If you're on WordPress, you're easily getting all the settings you need from Squirrly SEO. Make sure you use it. %s Below, you can see examples of twitter card elements you need to implement in the <head> section of your page's code. Make sure you replace the elements inside content=\" \" with your own data: your own titles, own image URLs, etc. %s <meta property=“twitter:url” content=“{site}/product/expectation-marketing-ebook/“ /> %s <meta property=“twitter:title” content=“Expectation Marketing [Book]” /> %s <meta property=“twitter:description” content=“If you`re wondering why your marketing strategy isn`t bringing the results you expected this is the right ebook for you. Expectation Marketing is about giving you an acti” /> %s <meta property=“twitter:image” content=“{site}/image.jpg” /> %s <meta property=“twitter:domain” content=“Expectation Marketing” /> %s <meta property=“twitter:card” content=“summary” />%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul><pre style="white-space: initial!important;">', '<br />', '<br />', '<br />', '<br />', '<br />', '</pre>' ),
					'protip'       => esc_html__( "Fixing this will improve Click Through Rates on Twitter. Guaranteed. Make sure you use this to control how your pages look on social media when people share them.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add Twitter Card to make your articles look better on Twitter.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),

			),
			'inbound'   => array(

				'MozLinks'      => array(
					'complete'     => false,
					'title'        => esc_html__( "Moz Backlinks", 'squirrly-seo' ),
					'success'      => '{total} ' . esc_html__( "link(s)", 'squirrly-seo' ),
					'fail'         => '{total} ' . esc_html__( "link(s)", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success_title">' . esc_html__( "Moz Backlinks Count", 'squirrly-seo' ) . ':</div><div class="sq_list_success">%s</div>',
					'fail_list'    => '<div class="sq_list_error_title">' . esc_html__( "Moz Backlinks Count", 'squirrly-seo' ) . ':</div><div class="sq_list_error">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Inbound Links Number to the latest 10 Pages? %s Many are tempted to go to fiverr.com for something like this. Avoid shady SEO. What you can try, and ONLY if it makes sense, is to get bloggers who sell on fiverr to place your article (with links to your own site) on their site. %s You can easily get backlinks from multiple domains by showing that your business: %s - is an alternative to some other existing business (there are many websites on which people look for alternatives and they'll be happy to include your site as well, because it supports their purpose) %s - has discounts and coupons (there are many websites for coupon and discounts. Just search on Google and you'll find many. They'll happily include your coupon codes and links to your site) %s - hosts giveaways and contests (many websites that will happily link to the contest page on your website) %s Broken Link Building, using tools like Screaming Frog to help you find broken links.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '<br />', '<br />', '<br />', '</li><li>', '</li></ul>' ),
					'protip'       => '',
					'solution'     => esc_html__( "Find more blogs, forums, directories to add links there. Contribute to the respective community and they will appreciate it.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'NoFollowLinks' => array(
					'complete'     => false,
					'title'        => esc_html__( "Links with noFollow?", 'squirrly-seo' ),
					'success'      => '',
					'fail'         => esc_html__( "No" ),
					'success_list' => '<div class="sq_list_success">%s</div>',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the No-Follow links of the website? %s You can find an extremely easy way to do this in the SEO Kit of Squirrly: [link]https://www.squirrly.co/seo/kit/[/link] %s You can start doing this even if you don't have an advanced or complex SEO strategy for all your site's inner links. If you have pages in your SEO strategy that are super important (you NEED those pages to be found via search) make sure you add:  <meta name=\"robots\" content=\"index, nofollow\" /> This ensures that Google considers this a final page. If many other pages link on to this page and this is the final one, it means that it is the most valuable resource. %s Identify links on your pages that are not important for you or for the purpose of the site itself. Maybe you're sending a link to chef Jamie Oliver's recipe for hot sauce. You should make sure that you add the No Follow tag to that link going out of your site, because you don't want Google to pass on link juice to Jaime Oliver. You'd give him a part of your SEO Authority and you don't want that. You should also add No-Follow tags to internal links from your very own site. Add no-follow to pages like \"/login\", \"/register\" \"/terms-of-use\", which are not important to be found via search engines. %s  Add rel=\"nofollow\" to links inside your pages to fix this task. If you'd want to NoFollow your Sign In page you could do it like this: <a href=\"signin.php\" rel=\"nofollow\">sign in</a>%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "You could add no-follow to most of the links from your site that go towards external, third-party websites. The only external sites you should leave without No-Follow are sites that you'd like to be associated with by Google. This is to say that in some cases you may want to send do-follow links to other people's sites if they are super high authority and would help Google better understand what your site's content is all about.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add nofollow links to pages like Terms and Conditions.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),

			),
			'authority' => array(

				'Authority'   => array(
					'complete'     => false,
					'title'        => esc_html__( "Page Authority", 'squirrly-seo' ),
					'success'      => '{total} ' . esc_html__( "average authority", 'squirrly-seo' ),
					'fail'         => '{total} ' . esc_html__( "average authority", 'squirrly-seo' ),
					'success_list' => '<div class="sq_list_success">%s</div>',
					'fail_list'    => '<div class="sq_list_success">%s</div>',
					'description'  => sprintf( esc_html__( "How can we fix the Authority of the website? %s You must start by understanding this: Authority is Squirrly's calculated metric for how well a given webpage is likely to rank in Google's search results. It collects data from social media, google analytics and inbound links (backlinks to your own site) %s You can follow the PRO Tips sections from Audit. %s Get more Buzz on Social Media. Get More Traffic. Get More Sites to link back to your own site. That's how you increase your Authority.%s Read the Traffic section of the Audit for more fixes and ideas. Bringing more Traffic increases Authority. %s Read the Social Media ideas for getting your pages shared on social networks. In the SEO Audit from Squirrly. Get more shares and traffic from social media. That will help boost your overall Web Authority %s Use Focus Pages from Squirrly: everything we tell you there helps boost your authority: [link]https://plugin.squirrly.co/focus-pages/[/link] %s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "You can build up a solid Content Strategy using the SEO Goals and our brand new Private SEO Consultant. In a Plugin. Powered by Machine Learning and Cloud Services: [link]https://plugin.squirrly.co/best-seo-goals/[/link] or you can start getting more BackLinks using the BackLinks Assistant [link]https://www.producthunt.com/upcoming/backlinks-assistant-by-squirrly[/link].", 'squirrly-seo' ),
					'solution'     => esc_html__( "Get links to your page from domains with authority.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'SemrushRank' => array(
					'complete'     => false,
					'title'        => esc_html__( "Semrush Rank", 'squirrly-seo' ),
					'success'      => '%s ',
					'fail'         => '%s ',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the Semrush Rank of the website? %s Get more traffic to your website. %s Increase your SEO rankings, get more shares on social media. You can use tools like Social Squirrly to make sure you constantly promote your pages, without doing any manual work. And without forgetting to keep posting them. [link]https://www.squirrly.co/social-media/tools-for-digital-marketing/[/link]%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "A certain and tested way of increasing Semrush rank is creating and promoting many pieces of fresh content. An agency like Squirrly's Content Agency can help you with this. [link]http://www.squirrly.co/agency[/link]", 'squirrly-seo' ),
					'solution'     => esc_html__( "Try to gain organic traffic to your site.", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'DomainAge'   => array(
					'complete'     => false,
					'title'        => esc_html__( "Domain Age", 'squirrly-seo' ),
					'success'      => '%s ',
					'fail'         => '%s ',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the Domain Age of the website? %s While you certainly can't go back and forth in time like the Flash, there are things you can do, like: make sure your domain can be crawled by search engines. %s Ping your domain name as soon as possible using Google Search Console. Ask GSC asap to index your pages. Both by manual URL index and by placing the sitemaps generated by Squirrly. %s Get your website on Way Back Machine. [link]https://archive.org/web/[/link] Archive.org even has a tool called Save Page Now which will guarantee your entry into Way Back Machine.%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "If Squirrly could crawl your website and find your pages + show you the Audit, it means your domain and pages can be crawled. Just make sure you're not stopping the Google crawlers in your code via \"no-index\" or via robots.txt", 'squirrly-seo' ),
					'solution'     => esc_html__( "Your domain is new. I know it will get older, but still, it's good to know what to expect if it's new :)", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'Favicon'     => array(
					'complete'     => false,
					'title'        => esc_html__( "Site Icon", 'squirrly-seo' ),
					'success'      => '%s ',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the favicon of the website? %s If you don't already have a favicon, you'll need to create one. The dimensions are 16 x 16 pixels %s You can easily create one using this [link]http://www.favicon.cc/[/link] . Upload it to your own server after creating it. %s Once you have the favicon, use this in the code of your pages: <link rel=“shortcut icon” href=“/images/specialicon.ico” type=“image/x-icon” />%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO to upload and control the favicon displayed on your pages.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add an icon for your site", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
				'AppleIcon'   => array(
					'complete'     => false,
					'title'        => esc_html__( "IPad and IPhone Icons", 'squirrly-seo' ),
					'success'      => esc_html__( "Yes" ) . '!',
					'fail'         => esc_html__( "No" ) . '!',
					'success_list' => '',
					'fail_list'    => '',
					'description'  => sprintf( esc_html__( "How can we fix the Apple Icon of the website? %s If you don't already have an Apple Icon, you'll need to create one. The dimensions are 129 x 129 pixels. It will need to be a .png file %s You can easily create one using this [link]https://www.canva.com/[/link] . Upload it to your own server after creating it. %s Once you have the Apple Icon, use this in the code (in the <head> section) of your pages: %s <link rel=“apple-touch-icon” href=“/apple-touch-icon.png” />%s", 'squirrly-seo' ), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>' ),
					'protip'       => esc_html__( "Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO to upload and control the Apple Icon displayed on user's home screens when they bookmark your pages.", 'squirrly-seo' ),
					'solution'     => esc_html__( "Add an icon for your site", 'squirrly-seo' ),
					'link'         => SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo' ),
				),
			)
		);
	}

	public function prepareAudit( $audit ) {
		$groups = $todo = array();

		$tasks = $this->getTasks();

		if ( ! empty( $audit->audit ) ) {
			foreach ( $audit->audit as $group => $rows ) {
				$audittasks = array();

				//initialize group
				$groups[ $group ]['complete'] = 0;
				$groups[ $group ]['total']    = 0;

				foreach ( $rows as $row ) {

					if ( ! isset( $tasks[ $group ][ $row->audit_task ] ) ) {
						continue;
					}

					$audittask = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_AuditTask', array_merge( $tasks[ $group ][ $row->audit_task ], (array) $row ) );

					if ( $audittask->audit_task == 'AlexaRank' && $audittask->value == 0 ) {
						continue;
					}

					if ( $audittask->audit_task == 'SemrushRank' && $audittask->value == 0 ) {
						continue;
					}

					$replace = '';
					switch ( $audittask->audit_task ) {
						case 'TopTen':
							if ( ( is_object( $audittask->value ) || is_array( $audittask->value ) ) && ! empty( $audittask->value ) ) {
								$replace .= '
                                      <table class="table_vals table table-striped my-3">
                                       <thead>
                                        <tr>
                                          <th>' . esc_html__( "URL", 'squirrly-seo' ) . '</th>
                                          <th>' . esc_html__( "Visitors", 'squirrly-seo' ) . '</th>
                                          <th>' . esc_html__( "Bounce", 'squirrly-seo' ) . '</th>
                                        </tr>
                                       </thead>
                                       <tbody>';

								foreach ( $audittask->value as $value ) {
									$value   = (array) $value;
									$replace .= '<tr>';
									if ( $value['permalink'] <> '' ) {
										$replace .= '';
										$replace .= '<td><a href="' . $value['permalink'] . '" target="_blank">' . $value['permalink'] . '</a></td>';
										$replace .= '<td>' . number_format( (float) $value['visitors'], 0, '.', ',' ) . '</td>';
										$replace .= '<td>' . $value['bounces'] . '%</td>';
									}
									$replace .= '</tr>';
								}
								$replace .= '</tbody></table>';
							} else {
								$replace = '<div class="my-2 small">' . esc_html__( "No traffic data found", 'squirrly-seo' ) . '</div>';
							}
							break;

						case 'TopTenSocials':
						case 'MajesticInboundLinks':
						case 'MajesticUniqueDomains':
						case 'MozLinks':
						case 'NoFollowLinks':
						case 'TopTenAuthority':
						case 'Authority':
							if ( ( is_object( $audittask->value ) || is_array( $audittask->value ) ) && ! empty( $audittask->value ) ) {
								$replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <thead>
                                            <tr>
                                              <th>' . esc_html__( "URL", 'squirrly-seo' ) . '</th>
                                              <th>' . esc_html__( "Total", 'squirrly-seo' ) . '</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

								foreach ( $audittask->value as $post_id => $value ) {
									$replace .= '<tr>';
									$replace .= '<td><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></td>';
									$replace .= '<td>' . number_format( (float) $value, 0, '.', ',' ) . '</td>';
									$replace .= '</tr>';
								}
								$replace .= '</tbody></table>';

							}
							break;
						case 'Speed':
							if ( ( is_object( $audittask->urls ) || is_array( $audittask->urls ) ) && ! empty( $audittask->urls ) ) {
								$replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <thead>
                                            <tr>
                                              <th>' . esc_html__( "URL", 'squirrly-seo' ) . '</th>
                                              <th>' . esc_html__( "Total", 'squirrly-seo' ) . '</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

								foreach ( $audittask->urls as $post_id ) {
									if ( ! isset( $audittask->value->$post_id ) ) {
										continue;
									}

									$replace .= '<tr>';
									$replace .= '<td><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></td>';
									$replace .= '<td>' . number_format( (float) $audittask->value->$post_id, 1, '.', ',' ) . ' s</td>';
									$replace .= '</tr>';

								}
								$replace .= '</tbody></table>';

							}
							break;
						case 'Shares':
							if ( ( is_object( $audittask->value ) || is_array( $audittask->value ) ) && ! empty( $audittask->value ) ) {
								foreach ( $audittask->value as $post_id => $value ) {
									if ( ! $audit->urls->$post_id ) {
										continue;
									}

									$replace .= '<div class="sq_list_success_title my-2"><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></div>';

									$replace .= '<table class="table_vals table table-striped my-3"><tbody>';

									$tableOfContents = array(
										'facebookShareCount'  => array(
											'icon'  => 'fasq-brands fa-facebook',
											'title' => esc_html__( "Facebook reactions", 'squirrly-seo' )
										),
										'facebookLikeCount'   => array(
											'icon'  => 'fasq-brands fa-facebook',
											'title' => esc_html__( "Facebook shares", 'squirrly-seo' )
										),
										'reditShareCount'     => array(
											'icon'  => 'fasq-brands fa-reddit',
											'title' => esc_html__( "Reddit shares", 'squirrly-seo' )
										),
										'pinterestShareCount' => array(
											'icon'  => 'fasq-brands fa-pinterest',
											'title' => esc_html__( "Pinterest shares", 'squirrly-seo' )
										),
									);
									foreach ( $value as $name => $shares ) {
										$replace .= '<tr>';
										$replace .= '<td><i class="sq-brands ' . $tableOfContents[ $name ]['icon'] . '"></i>' . $tableOfContents[ $name ]['title'] . '</td>';
										$replace .= '<td>' . number_format( (float) $shares, 0, '.', ',' ) . '</td>';
										$replace .= '</tr>';
									}
									$replace .= '</tbody></table>';


								}
							}
							break;

						case 'DcPublisher':
						case 'SafeBrowsing':
						case 'DuplicateTitles':
						case 'DuplicateDescription':
						case 'EmptyTitles':
						case 'EmptyDescription':
						case 'Title':
						case 'Description':
						case 'Canonical':
						case 'Encoding':
						case 'Viewport':
						case 'Gzip':
						case 'DuplicateOGMetas':
						case 'DuplicateTCMetas':
						case 'DuplicateTitleMetas':
						case 'DuplicateDescriptionMetas':
						case 'Jsonld':
						case 'FollowButtons':
						case 'ShareButtons':
						case 'OpenGraph':
						case 'TwitterCard':
							if ( ! empty( $audittask->urls ) ) {
								$replace .= '<ul>';
								foreach ( $audittask->urls as $post_id ) {
									if ( ! $audit->urls->$post_id ) {
										continue;
									}

									$replace .= '<li class="my-1 mx-4" style="list-style: initial"><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></li>';

								}
								$replace .= '</ul>';


							}
							break;

						case 'NoIndex':
						case 'NoFollow':
						case 'ExternalLinks':
						case 'PageViews':
							if ( ! empty( $audittask->urls ) ) {

								$replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <thead>
                                            <tr>
                                              <th>' . esc_html__( "URL", 'squirrly-seo' ) . '</th>
                                              <th>' . esc_html__( "Value", 'squirrly-seo' ) . '</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

								foreach ( $audittask->urls as $post_id ) {
									if ( ! isset( $audittask->value->$post_id ) ) {
										continue;
									}

									$value = $audittask->value->$post_id;

									$replace .= '<tr>';
									$replace .= '<td><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></td>';
									$replace .= '<td>' . $value . '</td>';
									$replace .= '</tr>';
								}
								$replace .= '</tbody></table>';
							}
							break;

						case 'Keywords':
							if ( ( is_object( $audittask->value ) || is_array( $audittask->value ) ) && ! empty( $audittask->value ) ) {
								$replace .= '<ul>';
								foreach ( $audittask->value as $value ) {
									$replace .= '<li class="my-1 mx-4" style="list-style: initial">' . $value . '</li>';
								}
								$replace .= '</ul>';
							}
							break;
						default:
							if ( ! is_array( $audittask->value ) && ! is_object( $audittask->value ) ) {
								if ( is_numeric( $audittask->value ) ) {
									$replace = '<strong>' . number_format( (float) $audittask->value, 0, '.', ',' ) . '</strong>';
								} else {
									$replace = '<strong>' . $audittask->value . '</strong>';
								}
							}
					}

					//update the value message
					$audittask->value = urldecode( $replace );

					if ( in_array( $audittask->audit_task, array( 'Speed', 'Authority' ) ) ) {
						$audittask->total = number_format( (float) $audittask->total, 1, '.', ',' );
					} else {
						$audittask->total = (int) $audittask->total;

					}

					//correct the success message
					$audittask->success      = str_replace( array( '{site}', '{total}' ), array(
						home_url(),
						$audittask->total
					), $audittask->success );
					$audittask->success      = sprintf( $audittask->success, $audittask->value );
					$audittask->success_list = sprintf( $audittask->success_list, $audittask->value );

					//correct the fail message
					$audittask->fail      = str_replace( array( '{site}', '{total}' ), array(
						home_url(),
						$audittask->total
					), $audittask->fail );
					$audittask->fail      = sprintf( $audittask->fail, $audittask->value );
					$audittask->fail_list = sprintf( $audittask->fail_list, $audittask->value );

					if ( $audittask->description <> '' ) {
						$audittask->description = str_replace( array( '{site}', '{total}' ), array(
							home_url(),
							$audittask->total
						), $audittask->description );
						$audittask->description = preg_replace( '/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $audittask->description );
					}
					if ( $audittask->protip <> '' ) {
						$audittask->protip = preg_replace( '/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $audittask->protip );
					}

					if ( ! $audittask->complete && $audittask->solution <> '' ) {
						$this->_todo[ $audittask->audit_task ] = array(
							'title'       => $audittask->title,
							'description' => $audittask->description,
							'todo'        => $audittask->solution,
						);
						if ( $audittask->protip <> '' ) {
							$this->_todo[ $audittask->audit_task ]['description'] .= '<div class="my-3 p-0"><strong class="text-info">' . esc_html__( "PRO TIP", 'squirrly-seo' ) . ':</strong> ' . $audittask->protip . '</div>';
						}

					} elseif ( $audittask->complete ) {
						$groups[ $group ]['complete'] ++;
					}

					$groups[ $group ]['total'] ++;
					$audittasks[] = $audittask;
				}

				//update the audit group with the valid tasks
				$audit->audit->$group = $audittasks;


				if ( $groups[ $group ]['total'] > 0 ) {
					$color     = 'sq_audit_task_completed_green';
					$colorname = '';
					if ( $groups[ $group ]['complete'] < ( $groups[ $group ]['total'] / 2 ) ) {
						$color     = 'sq_audit_task_completed_red';
						$colorname = esc_html__( "Requires Attention!", 'squirrly-seo' );
					}
					if ( $groups[ $group ]['complete'] >= ( $groups[ $group ]['total'] / 2 ) ) {
						$color     = 'sq_audit_task_completed_yellow';
						$colorname = esc_html__( "Can be improved.", 'squirrly-seo' );
					}
					if ( $groups[ $group ]['complete'] == $groups[ $group ]['total'] ) {
						$color     = 'sq_audit_task_completed_green';
						$colorname = esc_html__( "Great!", 'squirrly-seo' );
					}

					$groups[ $group ]['color']     = $color;
					$groups[ $group ]['colorname'] = $colorname;
				} else {
					unset( $groups[ $group ] );
				}
			}

			if ( ! empty( $this->_todo ) ) {
				krsort( $this->_todo );
				add_filter( 'sq_assistant_tasks', array( $this, 'setAssistantTasks' ) );
			}

			$audit->groups              = json_decode( wp_json_encode( $groups ) );
			$audit->next_audit_datetime = date_i18n( 'd M Y', strtotime( $audit->audit_datetime ) + ( 3600 * 24 * 8 ) );
		}

		return $audit;
	}

	/**
	 * Se the assistant tasks for the Squirrly Assistant
	 *
	 * @param  $tasks
	 *
	 * @return mixed
	 */
	public function setAssistantTasks( $tasks ) {

		foreach ( $this->_todo as $audit_task => $todo ) {
			$this->_todo[ $audit_task ] = array(
				'title'       => $todo['title'],
				'description' => $todo['description'],
				'function'    => false,
			);
		}

		return $this->_todo;

	}

	/**
	 * Parse all categories for a single page
	 *
	 * @param SQ_Models_Domain_AuditPage $auditpage
	 *
	 * @return $this
	 */
	public function parseAuditPage( SQ_Models_Domain_AuditPage $auditpage ) {
		//set focus pages from API
		$this->_auditpage = $auditpage;

		//Set the focus page audit as success
		if ( isset( $this->_auditpage->audit_datetime ) ) {
			$this->_auditpage->audit_datetime = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $this->_auditpage->audit_datetime ) );
		} else {
			$this->_auditpage->audit_datetime = esc_html__( "not yet", 'squirrly-seo' );
		}

		if ( $post = $this->_auditpage->getWppost() ) {
			if ( $post->post_status <> '' && $post->post_status <> 'publish' ) { //just if the  Page is public
				$this->_auditpage->audit_error = 404;
			}
		}


		return $this;
	}

	/**
	 * Return the audit page
	 *
	 * @return SQ_Models_Domain_AuditPage
	 */
	public function getAuditPage() {
		return $this->_auditpage;
	}


}
