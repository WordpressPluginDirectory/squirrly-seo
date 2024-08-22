<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Services_Innerlinks extends SQ_Models_Abstract_Seo {

	public function __construct() {
		parent::__construct();

		add_filter( 'sq_buffer', array( $this, 'generateLinks' ), 11 );

	}

	/**
	 *
	 * @return SQ_Models_Innerlinks_Ruleset
	 */
	private function getLinksRuleset() {
		$link_ruleset = SQ_Classes_ObjController::getNewClass( 'SQ_Models_Innerlinks_Ruleset' );

		foreach ( $this->_post->sq->innerlinks as $innerlink ) {
			$innerlink = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Innerlink', $innerlink );

			if ( ! isset( $innerlink->nofollow ) ) {
				$innerlink->nofollow = SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_nofollow' );
			}
			if ( ! isset( $innerlink->blank ) ) {
				$innerlink->blank = SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_link_blank' );
			}
			$link_ruleset->addRule( $innerlink->keyword, $innerlink->to_post_id, $innerlink->nofollow, $innerlink->blank );
		}

		return $link_ruleset;

	}

	public function generateLinks( $content ) {

		if ( isset( $this->_post->sq->innerlinks ) && ! empty( $this->_post->sq->innerlinks ) ) {

			$link_ruleset = $this->getLinksRuleset();

			/** @var SQ_Models_Innerlinks_Replacement $replacement */
			$replacement = SQ_Classes_ObjController::getClass( 'SQ_Models_Innerlinks_Replacement' );

			$replacement->setContent( $content );
			$replacement->setRuleset( $link_ruleset );
			$replacement->setLinksPerKeyword( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_links_per_keyword' ) );
			$replacement->setLinksPerTarget( SQ_Classes_Helpers_Tools::getOption( 'sq_innelinks_links_per_target' ) );

			$content = $replacement->generateLinks();

		}

		return $content;
	}


}
