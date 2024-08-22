<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Innerlinks_Match {

	/**
	 * Used to escaped special characters that are ascii
	 *
	 * @param string $pattern
	 *
	 * @return string
	 */
	public function escapeAscii( $pattern ) {
		//Escape special Characters if not non ASCII
		if ( ! preg_match( '/[[:^print:]]/', strtolower( $pattern ) ) ) {
			$pattern = preg_replace( '/([^A-Za-z0-9-{}+.\s])/', '\\\\$1', $pattern );
		}

		return $pattern;
	}

	/**
	 * Decorates and manipulates a given pattern for matching optimization
	 *
	 * @param  $pattern
	 *
	 * @return string
	 */
	public function maskPattern( $pattern ) {
		$phrase = '(?<phrase>%2$s%1$s%3$s)';

		$boundary_start = '(?<=^|\s|\"|\'|\{|\[|\<|\(|\,)';
		$boundary_end   = '(?=$|\s|\"|\.|\?|\!|\,|\)|\}|\]|\>|\;|\:)';

		// For non ascii char:
		if ( preg_match( '/[[:^print:]]/', strtolower( $pattern ) ) ) {
			$boundary_start = $boundary_end = '\b';
		}

		//starting/ending with special char:
		if ( $boundary_start != '' && ! preg_match( '/^[a-z0-9àâçéèêëîïôûùüÿñæœ]/', strtolower( $pattern ) ) ) {
			$boundary_start = '(?<=^|\s|\"|\'|\{|\[|\<|\(|\,)';
		}
		if ( $boundary_end != '' && ! preg_match( '/[a-z0-9àâçéèêëîïôûùüÿñæœ]$/', strtolower( $pattern ) ) ) {
			$boundary_end = '(?=$|\s|\"|\.|\?|\!|\,|\)|\}|\]|\>|\;|\:)';
		}

		// For specific for Devanagari characters:
		if ( preg_match( '/^\p{Devanagari}+$/u', $pattern ) ) {
			$boundary_start = '(?<=^|\s)';
			$boundary_end   = '(?=$|\s)';
		}

		$masked_pattern = sprintf( $phrase, $pattern, $boundary_start, $boundary_end );

		return $masked_pattern;
	}
}
