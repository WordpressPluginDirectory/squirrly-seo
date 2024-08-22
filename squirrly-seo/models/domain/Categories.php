<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Domain_Categories extends SQ_Models_Abstract_Domain {

	protected $_id;
	protected $_labels;
	protected $_categories;

	public function getAllCategories( $post_id = 0 ) {
		$allcategories = array();
		if ( (int) $post_id > 0 ) {
			//change category title if article
			$categories = get_the_category( $post_id );
			if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					$allcategories[ $category->term_id ] = $category->name;
				}
			} else {
				//change category title if article
				$all_terms = wp_get_object_terms( $post_id, get_taxonomies( array( 'public' => true ) ) );
				if ( ! is_wp_error( $all_terms ) && ! empty( $all_terms ) ) {
					foreach ( $all_terms as $term ) {
						if ( strpos( $term->taxonomy, 'cat' ) !== false ) {
							$allcategories[ $term->term_id ] = $term->name;
						}
					}
				}
			}
		}

		return $allcategories;
	}
}
