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
	'{{sep}}'                    => esc_html__( "Places a separator between the elements of the post description", 'squirrly-seo' ),
	'{{title}}'                  => esc_html__( "Adds the title of the post/page/term once it’s published", 'squirrly-seo' ),
	'{{excerpt}}'                => esc_html__( "Will display an excerpt from the post/page/term (if not customized, the excerpt will be auto-generated)", 'squirrly-seo' ),
	'{{excerpt_only}}'           => esc_html__( "Will display an excerpt from the post/page (no auto-generation)", 'squirrly-seo' ),
	'{{keyword}}'                => esc_html__( "Adds the post's keyword to the post description", 'squirrly-seo' ),
	'{{url}}'                    => esc_html__( "Displays current post/page/term URL", 'squirrly-seo' ),
	'{{page}}'                   => esc_html__( "Displays the number of the current page (i.e. 1 of 6)", 'squirrly-seo' ),
	'{{sitename}}'               => esc_html__( "Adds the site's name to the post description", 'squirrly-seo' ),
	'{{sitedesc}}'               => esc_html__( "Adds the tagline/description of your site", 'squirrly-seo' ),
	'{{category}}'               => esc_html__( "Adds the post category (several categories will be comma-separated)", 'squirrly-seo' ),
	'{{primary_category}}'       => esc_html__( "Adds the primary category of the post/page", 'squirrly-seo' ),
	'{{category_description}}'   => esc_html__( "Adds the category description to the post description", 'squirrly-seo' ),
	'{{tag}}'                    => esc_html__( "Adds the current tag(s) (several tags will be comma-separated)", 'squirrly-seo' ),
	'{{tag_description}}'        => esc_html__( "Adds the tag description", 'squirrly-seo' ),
	'{{term_title}}'             => esc_html__( "Adds the term name", 'squirrly-seo' ),
	'{{term_description}}'       => esc_html__( "Adds the term description", 'squirrly-seo' ),
	'{{searchphrase}}'           => esc_html__( "Displays the search phrase (if it appears in the post)", 'squirrly-seo' ),
	'{{date}}'                   => esc_html__( "Displays the date of the post/page once it's published", 'squirrly-seo' ),
	'{{modified}}'               => esc_html__( "Replaces the publication date of a post/page with the modified one", 'squirrly-seo' ),
	'{{name}}'                   => esc_html__( "Displays the author's nicename", 'squirrly-seo' ),
	'{{single}}'                 => esc_html__( "Displays the post type singular label", 'squirrly-seo' ),
	'{{plural}}'                 => esc_html__( "Displays the post type plural label", 'squirrly-seo' ),
	'{{user_description}}'       => esc_html__( "Adds the author's biographical info to the post description", 'squirrly-seo' ),
	'{{currentdate}}'            => esc_html__( "Displays the current date", 'squirrly-seo' ),
	'{{currentday}}'             => esc_html__( "Adds the current day", 'squirrly-seo' ),
	'{{currentmonth}}'           => esc_html__( "Adds the current month", 'squirrly-seo' ),
	'{{currentyear}}'            => esc_html__( "Adds the current year", 'squirrly-seo' ),
	'{{org_name}}'               => esc_html__( "Your Organization name set in Rich Snippets.", 'squirrly-seo' ),
	'{{org_description}}'        => esc_html__( "Your Organization description set in Rich Snippets.", 'squirrly-seo' ),
	'{{org_logo}}'               => esc_html__( "Your Organization logo set in Rich Snippets.", 'squirrly-seo' ),
	'{{org_url}}'                => esc_html__( "Your Organization URL set in Rich Snippets.", 'squirrly-seo' ),
	'{{org_phone}}'              => esc_html__( "Your Organization telephone set in Rich Snippets.", 'squirrly-seo' ),
	'{{parent_title}}'           => esc_html__( "Adds the title of a page's parent page", 'squirrly-seo' ),
	'{{product_name}}'           => esc_html__( "Adds the product name from Woocommerce for the current product", 'squirrly-seo' ),
	'{{product_description}}'    => esc_html__( "Adds the product excerpt from Woocommerce for the current product", 'squirrly-seo' ),
	'{{product_price}}'          => esc_html__( "Adds the product price from Woocommerce for the current product", 'squirrly-seo' ),
	'{{product_price_with_tax}}' => esc_html__( "Adds the product price with Tax from Woocommerce for the current product", 'squirrly-seo' ),
	'{{product_sale}}'           => esc_html__( "Adds the product sale price from Woocommerce for the current product", 'squirrly-seo' ),
	'{{product_currency}}'       => esc_html__( "Adds the product price currency from Woocommerce for the current product", 'squirrly-seo' ),
	'{{product_brand}}'          => esc_html__( "Adds the product brand from Woocommerce for the current product", 'squirrly-seo' ),
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
