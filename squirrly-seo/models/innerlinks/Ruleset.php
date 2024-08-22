<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Innerlinks_Ruleset {
	/**
	 * @var   int $ruleset
	 */
	public $ruleset = array();

	/**
	 * @var   int $rule_pointer
	 */
	private $ruleset_pointer = 0;

	/**
	 *
	 * @param string $pattern The condition for applying the rule
	 * @param string $target The target that gets applied
	 * @param string $nofollow The option DoFollow/Nofollow link
	 * @param string $blank The option to open the link in a new tab
	 *
	 * @return bool
	 */
	public function addRule( $pattern, $target, $nofollow = false, $blank = false ) {
		if ( $pattern != '' && $target != '' ) {
			$rule            = new \stdClass();
			$rule->pattern   = $pattern;
			$rule->target    = $target;
			$rule->nofollow  = $nofollow;
			$rule->blank     = $blank;
			$this->ruleset[] = $rule;

			return true;
		}

		return false;
	}

	/**
	 *
	 * @return bool
	 */
	public function hasRule() {
		return isset( $this->ruleset[ $this->ruleset_pointer ] );
	}

	/**
	 *
	 * @param int $index (optional)
	 *
	 * @return null|object
	 */
	public function getRule( $index = - 1 ) {
		if ( ! is_numeric( $index ) ) {
			return null;
		}
		$index = ( $index >= 0 ) ? $index : $this->ruleset_pointer;
		if ( isset( $this->ruleset[ $index ] ) ) {
			return $this->ruleset[ $index ];
		}

		return null;
	}

	/**
	 *
	 * @return void
	 */
	public function nextRule() {
		$this->ruleset_pointer ++;
	}

	/**
	 *
	 * @return int
	 */
	public function getRuleCount() {
		return count( $this->ruleset );
	}

	/**
	 *
	 * @return void
	 */
	public function reset() {
		$this->ruleset_pointer = 0;
	}
}