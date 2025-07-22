<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * The configuration file
 */
if ( ! defined( '_SQ_NONCE_ID_' ) ) {
	if ( defined( 'NONCE_KEY' ) ) {
		define( '_SQ_NONCE_ID_', NONCE_KEY );
	} else {
		define( '_SQ_NONCE_ID_', md5( gmdate( 'Y-d' ) ) );
	}
}

define( '_SQ_MOBILE_ICON_SIZES', '76,120,152,180,192' );

define( 'SQ_ONBOARDING', '9.0.0' );
defined( 'SQ_DEBUG' ) || define( 'SQ_DEBUG', 0 );
define( 'SQ_REQUEST_TIME', microtime( true ) );

/* No path file? error ... */
require_once dirname( __FILE__ ) . '/paths.php';

/* Define the record name in the Option and UserMeta tables */
defined( 'SQ_OPTION' ) || define( 'SQ_OPTION', 'sq_options' );
defined( 'SQ_ML_PATTERNS' ) || define( 'SQ_ML_PATTERNS', 'sq_ml_patterns' );
defined( 'SQ_TASKS' ) || define( 'SQ_TASKS', 'sq_tasks' );
defined( '_SQ_DB_' ) || define( '_SQ_DB_', 'qss' );

$sq_all_patterns = array(
	'{{sep}}'                    => "Places a separator between the elements of the post description",
	'{{title}}'                  => "Adds the title of the post/page/term once it’s published",
	'{{excerpt}}'                => "Will display an excerpt from the post/page/term (if not customized, the excerpt will be auto-generated)",
	'{{excerpt_only}}'           => "Will display an excerpt from the post/page (no auto-generation)",
	'{{keyword}}'                => "Adds the post's keyword to the post description",
	'{{url}}'                    => "Displays current post/page/term URL",
	'{{page}}'                   => "Displays the number of the current page (i.e. 1 of 6)",
	'{{sitename}}'               => "Adds the site's name to the post description",
	'{{sitedesc}}'               => "Adds the tagline/description of your site",
	'{{category}}'               => "Adds the post category (several categories will be comma-separated)",
	'{{primary_category}}'       => "Adds the primary category of the post/page",
	'{{category_description}}'   => "Adds the category description to the post description",
	'{{tag}}'                    => "Adds the current tag(s) (several tags will be comma-separated)",
	'{{tag_description}}'        => "Adds the tag description",
	'{{term_title}}'             => "Adds the term name",
	'{{term_description}}'       => "Adds the term description",
	'{{searchphrase}}'           => "Displays the search phrase (if it appears in the post)",
	'{{date}}'                   => "Displays the date of the post/page once it's published",
	'{{modified}}'               => "Replaces the publication date of a post/page with the modified one",
	'{{name}}'                   => "Displays the author's nicename",
	'{{single}}'                 => "Displays the post type singular label",
	'{{plural}}'                 => "Displays the post type plural label",
	'{{user_description}}'       => "Adds the author's biographical info to the post description",
	'{{currentdate}}'            => "Displays the current date",
	'{{currentday}}'             => "Adds the current day",
	'{{currentmonth}}'           => "Adds the current month",
	'{{currentyear}}'            => "Adds the current year",
	'{{org_name}}'               => "Your Organization name set in Rich Snippets.",
	'{{org_description}}'        => "Your Organization description set in Rich Snippets.",
	'{{org_logo}}'               => "Your Organization logo set in Rich Snippets.",
	'{{org_url}}'                => "Your Organization URL set in Rich Snippets.",
	'{{org_phone}}'              => "Your Organization telephone set in Rich Snippets.",
	'{{parent_title}}'           => "Adds the title of a page's parent page",
	'{{product_name}}'           => "Adds the product name from Woocommerce for the current product",
	'{{product_description}}'    => "Adds the product excerpt from Woocommerce for the current product",
	'{{product_price}}'          => "Adds the product price from Woocommerce for the current product",
	'{{product_price_with_tax}}' => "Adds the product price with Tax from Woocommerce for the current product",
	'{{product_sale}}'           => "Adds the product sale price from Woocommerce for the current product",
	'{{product_currency}}'       => "Adds the product price currency from Woocommerce for the current product",
	'{{product_brand}}'          => "Adds the product brand from Woocommerce for the current product",
);

$sq_all_separators = array(
	'sc-dash'   => '-',
	'sc-ndash'  => '&ndash;',
	'sc-mdash'  => '&mdash;',
	'sc-middot' => '&middot;',
	'sc-bull'   => '&bull;',
	'sc-star'   => '*',
	'sc-smstar' => '&#8902;',
	'sc-pipe'   => '|',
	'sc-tilde'  => '~',
	'sc-laquo'  => '&laquo;',
	'sc-raquo'  => '&raquo;',
	'sc-lt'     => '&lt;',
	'sc-gt'     => '&gt;',
);

define( 'SQ_ALL_PATTERNS', wp_json_encode( apply_filters( 'sq_all_patterns', $sq_all_patterns ) ) );
define( 'SQ_ALL_OG_TYPES', wp_json_encode( apply_filters( 'sq_all_og_types', array(
	'website',
	'article',
	'profile',
	'book',
	'music',
	'video'
) ) ) );
define( 'SQ_ALL_JSONLD_TYPES', wp_json_encode( apply_filters( 'sq_all_jsonld_types', array(
	'website',
	'article',
	'newsarticle',
	'FAQ page',
	'question',
	'recipe',
	'review',
	'movie',
	'video',
	'local store',
	'local restaurant',
	'profile'
) ) ) );
define( 'SQ_ALL_SEP', wp_json_encode( apply_filters( 'sq_all_sep', $sq_all_separators ) ) );
