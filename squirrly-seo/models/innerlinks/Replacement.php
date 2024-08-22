<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Innerlinks_Replacement {

	/** @var string The content that will be replaced */
	private $content = '';

	/** @var SQ_Models_Innerlinks_Ruleset */
	private $replace_ruleset;

	/** @var SQ_Models_Innerlinks_Ruleset */
	private $link_ruleset;

	/** @var int */
	private $links_per_keyword;

	/** @var int */
	private $links_per_target;

	/**
	 * Set the content that will be replaced
	 *
	 * @param $content
	 *
	 * @return void
	 */
	public function setContent( $content ) {

		$this->content = $content;

	}

	/**
	 * Set the ruleset for replacement
	 *
	 * @param $link_ruleset
	 *
	 * @return void
	 */
	public function setRuleset( $link_ruleset ) {

		$this->link_ruleset = $link_ruleset;

	}

	/**
	 * Set how many links to add for a keyword
	 * Set 0 for unlimited
	 *
	 * @param int $links_per_keyword
	 *
	 * @return void
	 */
	public function setLinksPerKeyword( $links_per_keyword = 0 ) {

		$this->links_per_keyword = $links_per_keyword;

	}

	/**
	 * Set how many links to add for a target
	 * Set 0 for unlimited
	 *
	 * @param int $links_per_target
	 *
	 * @return void
	 */
	public function setLinksPerTarget( $links_per_target = 0 ) {

		$this->links_per_target = $links_per_target;

	}

	/**
	 * Generate the Links based on the Link Ruleset
	 *
	 * @return string
	 */
	public function generateLinks() {

		if ( $this->content <> '' ) {
			$this->replace_ruleset = SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Regex' )->mask( $this->content );
		}

		if ( $this->content <> "" ) {
			//create the index for each ruleset
			$this->createLinkIndex();
			//replace the content and add the links
			$this->applyReplaceRules();

		}

		return $this->content;

	}

	/**
	 * Simulate the Index
	 *
	 * @return array|array[]|false
	 */
	public function getCountByRulset() {
		if ( $this->content <> '' ) {
			$this->replace_ruleset = SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Regex' )->mask( $this->content );
		}

		if ( $this->content <> '' ) {
			//create the index for each ruleset
			return $this->createLinkIndex();
		}

		return false;
	}


	/**
	 * Runs rules and settings and create the index logic
	 *
	 * @return array
	 */
	protected function createLinkIndex() {
		$count = array(
			'link_target'  => array(),
			'link_keyword' => array(),
		);

		while ( $this->link_ruleset->hasRule() ) {
			$link_rule = $this->link_ruleset->getRule();

			if ( $this->links_per_target > 0 && array_key_exists( $link_rule->target, $count['link_target'] ) && $count['link_target'][ $link_rule->target ] >= $this->links_per_target ) {
				$this->link_ruleset->nextRule();
				continue;
			}

			if ( $this->links_per_keyword > 0 && array_key_exists( $link_rule->pattern, $count['link_keyword'] ) && $count['link_keyword'][ $link_rule->pattern ] >= $this->links_per_keyword ) {
				$this->link_ruleset->nextRule();
				continue;
			}

			$pattern = wptexturize( $link_rule->pattern );
			$pattern = SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Match' )->escapeAscii( $pattern );
			preg_match_all( '/' . SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Match' )->maskPattern( $pattern ) . '/ui', $this->content, $rule_match );

			if ( ! isset( $rule_match['phrase'] ) || ! count( $rule_match['phrase'] ) ) {
				$this->link_ruleset->nextRule();
				continue;
			}

			$phrases = $rule_match['phrase'];
			foreach ( $phrases as $rule ) {

				if ( $this->links_per_target > 0 && array_key_exists( $link_rule->target, $count['link_target'] ) && $count['link_target'][ $link_rule->target ] == $this->links_per_target ) {
					$this->link_ruleset->nextRule();
					continue 2;
				}

				if ( $this->links_per_keyword > 0 && array_key_exists( $link_rule->pattern, $count['link_keyword'] ) && $count['link_keyword'][ $link_rule->pattern ] >= $this->links_per_keyword ) {
					$this->link_ruleset->nextRule();
					continue 2;
				}

				$rule_id = 'sqil_' . uniqid( '', true );

				if ( ! $link = $this->generateLink( $link_rule, esc_html( $rule ) ) ) {
					$this->link_ruleset->nextRule();
					continue;
				}

				$rule          = SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Match' )->escapeAscii( $rule );
				$this->content = preg_replace( '/' . SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Match' )->maskPattern( $rule ) . '/ui', $rule_id, $this->content, 1 );

				$this->replace_ruleset->addRule( $rule_id, $link );
				if ( ! array_key_exists( $link_rule->target, $count['link_target'] ) ) {
					$count['link_target'][ $link_rule->target ] = 0;
				}
				if ( ! array_key_exists( $link_rule->pattern, $count['link_keyword'] ) ) {
					$count['link_keyword'][ $link_rule->pattern ] = 0;
				}
				$count['link_target'][ $link_rule->target ] ++;
				$count['link_keyword'][ $link_rule->pattern ] ++;
			}

			$this->link_ruleset->nextRule();
		}

		$this->link_ruleset->reset();

		return $count;
	}

	/**
	 * Apply the rules
	 *
	 * @return void
	 */
	private function applyReplaceRules() {
		while ( $this->replace_ruleset->hasRule() ) {
			$replace_rule  = $this->replace_ruleset->getRule();
			$this->content = str_replace( $replace_rule->pattern, $replace_rule->target, $this->content );
			$this->replace_ruleset->nextRule();
		}

		if ( preg_match( "/sqil\\_[a-z0-9]{14}\\.[0-9]{8}/", $this->content ) ) {
			$this->replace_ruleset->reset();
			$this->applyReplaceRules();
		}

	}

	/**
	 * Generates the link based in settings
	 *
	 * @param string $post_id
	 * @param string $anchor
	 *
	 * @return bool|string
	 */
	private function generateLink( $link_rule, $anchor ) {
		$template = $this->getLinkTemplate();
		$nofollow = $link_rule->nofollow;
		$blank    = $link_rule->blank;

		$url = get_the_permalink( $link_rule->target );

		$link = str_replace( '{{url}}', ( isset( $url ) ? $url : '#' ), $template );
		$link = str_replace( '{{keyword}}', $anchor, $link );

		if ( $nofollow && strpos( $link, 'rel=' ) == false ) {
			$link = str_replace( '<a ', '<a rel="nofollow" ', $link );
		}

		if ( $blank && strpos( $link, 'target=' ) == false ) {
			$link = str_replace( '<a ', '<a target="_blank" ', $link );
		}

		return $link;
	}

	/**
	 * Returns the template for link output
	 *
	 * @return string
	 */
	private function getLinkTemplate() {
		$default_template = $this->getDefaultLinkTemplate();
		$template         = SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_template' );
		if ( $template == "" ) {
			return $default_template;
		}

		return wp_specialchars_decode( $template, \ENT_QUOTES );
	}

	/**
	 * Get the default link template
	 *
	 * @return string
	 */
	public function getDefaultLinkTemplate() {
		return '<a href="{{url}}">{{keyword}}</a>';
	}

}
