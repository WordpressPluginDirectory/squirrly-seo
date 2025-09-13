<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Innerlinks_Regex {

	/**
	 *
	 * @param string &$content The content buffer
	 *
	 * @return SQ_Models_Innerlinks_Ruleset
	 */
	public function mask( &$content ) {
		/** @var SQ_Models_Innerlinks_Ruleset $replace_ruleset */
		$replace_ruleset = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Innerlinks_Ruleset' );

		$search_parts = array(
			// exclude all sensible html parts:
			'/(?<parts><head.*>.*<\/head>)/sU',
			'/(?<parts><header.*>.*<\/header>)/sU',
			'/(?<parts><footer.*>.*<\/footer>)/sU',
			'/(?<parts><video.*>.*<\/video>)/sU',
			'/(?<parts><iframe.*>.*<\/iframe>)/sU',
			'/(?<parts><a\s.*>.*<\/a>)/sU',
			'/(?<parts><a>.*<\/a>)/sU',
			'/(?<parts><script.*>.*<\/script>)/sU',
			'/(?<parts><style.*>.*<\/style>)/sU',
			'/(?<parts><figcaption.*>.*<\/figcaption>)/sU',
		);

		$tag_exclusions = SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_exclude_tags' );

		if ( is_array( $tag_exclusions ) && count( $tag_exclusions ) ) {
			foreach ( $tag_exclusions as $tag_exclusion ) {
				$regex = $this->getRegex( $tag_exclusion );

				if ( $regex ) {
					if ( is_array( $regex ) ) {
						$search_parts = array_merge( $search_parts, $regex );
					} else {
						$search_parts[] = $regex;

					}
				}
			}
		}

		/**
		 * Filters all parts of content that don't get used for applying link index
		 *
		 * @param array $search_parts All parts as regex that get excluded
		 */
		$search_parts = apply_filters( 'sq_innerlinks_exclude_tags', $search_parts );

		if ( ! is_array( $search_parts ) ) {
			$search_parts = [];
		}


		$search_parts[] = '/(?<parts><.*>)/sU';
		foreach ( $search_parts as $search_part ) {
			preg_match_all( $search_part, $content, $matches );
			if ( isset( $matches['parts'] ) ) {
				foreach ( $matches['parts'] as $part ) {
					$link_id = " " . 'sqil_' . uniqid( '', true ) . " ";
					$content = str_replace( $part, $link_id, $content );
					$replace_ruleset->addRule( $link_id, $part );
				}
			}
			unset( $matches );
		}

		return $replace_ruleset;
	}

	/**
	 * Get the regex for the exceptions
	 *
	 * @param $name
	 *
	 * @return false|string
	 */
	public function getRegex( $name ) {
		switch ( $name ) {
			case 'headline':
				return '/(?<parts><h[1-6].*>.*<\/h[1-6]>)/sU';
			case 'strong':
				return array(
					'/(?<parts><strong.*>.*<\/strong>)/sU',
					'/(?<parts><b .*>.*<\/b>)/sU',
					'/(?<parts><b>.*<\/b>)/sU'
				);
			case 'tables':
				return '/(?<parts><table.*>.*<\/table>)/sU';
			case 'caption':
				return '/(?<parts><figcaption.*>.*<\/figcaption>)/sU';
			case 'order_list':
				return '/(?<parts><ol.*>.*<\/ol>)/sU';
			case 'unordered_list':
				return '/(?<parts><ul.*>.*<\/ul>)/sU';
			case 'blockquotes':
				return '/(?<parts><blockquote.*>.*<\/blockquote>)/sU';
			case 'italic':
				return array(
					'/(?<parts><em.*>.*<\/em>)/sU',
					'/(?<parts><i .*>.*<\/i>)/sU',
					'/(?<parts><i>.*<\/i>)/sU'
				);
			case 'quotes':
				return '/(?<parts><cite.*>.*<\/cite>)/sU';
			case 'sourcecode':
				return '/(?<parts><code.*>.*<\/code>)/sU';
		}

		return false;
	}

}
