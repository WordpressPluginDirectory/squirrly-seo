<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Connection between Squirrly and Quick Squirrly SEO Table
 * Class SQ_Models_Qss
 */
class SQ_Models_Qss {


	/**
	 * Get the post data by hash
	 *
	 * @param null $hash
	 *
	 * @return SQ_Models_Domain_Post
	 */
	public function getSqPost( $hash = null ) {
		global $wpdb;

		/** @var SQ_Models_Domain_Post $post */
		$post = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Post' );

		if ( isset( $hash ) && $hash <> '' ) {
			$blog_id = get_current_blog_id();

			$table = $wpdb->prefix . _SQ_DB_;
			if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `$table` WHERE blog_id = %d AND url_hash = %s", (int) $blog_id, $hash ), OBJECT ) ) {
				$post      = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Post', maybe_unserialize( $row->post ) );
				$post->url = $row->URL; //set the URL for this post
			}
		}

		return $post;
	}

	/**
	 * Get Sq for a specific Post from database
	 *
	 * @param string $hash
	 *
	 * @return mixed|null
	 */
	public function getSqSeo( $hash = null ) {
		global $wpdb;

		$metas = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Sq' );

		if ( isset( $hash ) && $hash <> '' ) {
			$blog_id = get_current_blog_id();

			$table = $wpdb->prefix . _SQ_DB_;
			if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `$table` WHERE blog_id = %d AND url_hash = %s", (int) $blog_id, $hash ), OBJECT ) ) {
				$metas = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Sq', maybe_unserialize( $row->seo ) );
			}
		}

		return $metas;
	}

	/**
	 * Get the innerlinks from Qss table
	 *
	 * @param $where
	 *
	 * @return array
	 */
	public function getSqInnerlinks( $args ) {
		global $wpdb;

		extract( $args );
		$innerlinks = array();

		if ( isset( $search ) && trim( $search ) <> '' ) {
			$search        = sanitize_text_field( $search );
			$query_where[] = "(`URL` like '%$search%' OR `seo` like '%$search%')";
		}

		$query_where[] = "seo LIKE '%\"innerlinks\"%'";
		$query_where   = apply_filters( 'sq_innerlinks_query_where', $query_where );

		$table = $wpdb->prefix . _SQ_DB_;
		$rows = $wpdb->get_results( "SELECT * FROM `$table` WHERE " . join( ' AND ', $query_where ) . " ORDER BY `date_time` DESC" );

		if ( $rows ) {
			foreach ( $rows as $row ) {
				$metas = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Sq', maybe_unserialize( $row->seo ) );
				if ( ! empty( $metas->innerlinks ) ) {
					foreach ( $metas->innerlinks as $id => $innerlink ) {
						$innerlink['id']   = $id;
						$innerlinks[ $id ] = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Innerlink', $innerlink );
					}
				}
			}
		}

		return $innerlinks;

	}

	/**
	 * Save the SEO for a specific Post into database
	 *
	 * @param string $url
	 * @param string $url_hash
	 * @param array $post
	 * @param string $seo
	 * @param string $date_time
	 *
	 * @return false|int
	 */
	public function saveSqSEO( $url, $url_hash, $post, $seo, $date_time ) {
		global $wpdb;
		$wpdb->hide_errors();

		$blog_id = get_current_blog_id();

		$table = $wpdb->prefix . _SQ_DB_;
		$result = $wpdb->query( $wpdb->prepare( "INSERT INTO `$table` 
                (blog_id, URL, url_hash, post, seo, date_time)
                VALUES (%d,%s,%s,%s,%s,%s)  ON DUPLICATE KEY
                UPDATE blog_id = %d, URL = %s, url_hash = %s, post = %s, seo = %s, date_time = %s", $blog_id, $url, $url_hash, $post, $seo, $date_time, $blog_id, $url, $url_hash, $post, $seo, $date_time ) );

		$wpdb->show_errors();

		return $result;
	}

	/**
	 * @param SQ_Models_Domain_Post $post
	 * @param false|SQ_Models_Domain_Sq $sq
	 *
	 * @return false|int
	 */
	public function updateSqSeo( $post, $sq = false ) {

		if ( $post->hash ) {

			if ( ! $sq && ! $sq = $this->getSqSeo( $post->hash ) ) {
				$sq = SQ_Classes_ObjController::getDomain( 'SQ_Models_Domain_Sq' );
			}

			$sq = apply_filters( 'sq_seo_before_update', $sq, $post );

			if ( $sq instanceof SQ_Models_Domain_Sq ) {
				return $this->saveSqSEO( $post->url, $post->hash, maybe_serialize( array(
							'ID'        => $post->ID,
							'post_type' => $post->post_type,
							'term_id'   => $post->term_id,
							'taxonomy'  => $post->taxonomy,
						) ), maybe_serialize( $sq->toArray() ), gmdate( 'Y-m-d H:i:s' ) );
			}


		}

		return false;
	}


	/**
	 * Get the saved Permalink for a specific Post from database
	 *
	 * @param string $hash
	 *
	 * @return mixed|null
	 */
	public function getPermalink( $hash = null ) {
		global $wpdb;
		$url = false;

		if ( isset( $hash ) && $hash <> '' ) {
			$blog_id = get_current_blog_id();

			$table = $wpdb->prefix . _SQ_DB_;
			if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT URL FROM `$table` WHERE blog_id = %d AND url_hash = %s", (int) $blog_id, $hash ), OBJECT ) ) {
				$url = $row->URL;
			}

		}

		return $url;
	}

	/**
	 * Save the SEO for a specific Post into database
	 *
	 * @param  $url
	 * @param  $url_hash
	 * @param  $post
	 * @param  $seo
	 * @param  $date_time
	 *
	 * @return false|int
	 */
	public function savePermalink( $url, $url_hash ) {
		global $wpdb;
		$wpdb->hide_errors();

		$table = $wpdb->prefix . _SQ_DB_;
		$wpdb->update( $table, array( 'URL' => $url ), array( 'url_hash' => $url_hash ) );

		return $wpdb->rows_affected;
	}

	/**
	 * Check if the table exists
	 */
	public function checkTableExists() {
		global $wpdb;

		$wpdb->hide_errors();
		$table = $wpdb->prefix . _SQ_DB_;
		$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $table );

		if ( $wpdb->get_var( $query ) !== $table ) {
			$this->createTable();
		}
	}

	/**
	 * Create DB Table
	 */
	public static function createTable() {
		global $wpdb;
		$collate        = $wpdb->get_charset_collate();
		$table = $wpdb->prefix . _SQ_DB_;
		$sq_table_query = 'CREATE TABLE ' . $table . ' (
                      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `blog_id` INT(10) NOT NULL,
                      `post` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `URL` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `url_hash` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `seo` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `date_time` DATETIME NOT NULL,
                      PRIMARY KEY(id),
                      UNIQUE url_hash(url_hash) USING BTREE,
                      INDEX blog_id_url_hash(blog_id, url_hash) USING BTREE
                      )  ' . $collate;

		try {
			include_once ABSPATH . 'wp-admin/includes/upgrade.php';

			if ( function_exists( 'dbDelta' ) ) {
				dbDelta( $sq_table_query );
			}
		} catch ( Exception $e ) {
		}

	}

	public static function alterTable() {
		global $wpdb;
		$wpdb->hide_errors();

		if ( file_exists( ABSPATH . 'wp-admin/includes/upgrade.php' ) ) {
			include_once ABSPATH . 'wp-admin/includes/upgrade.php';

			$count = $wpdb->get_row( $wpdb->prepare( "SELECT count(*) as count
                              FROM information_schema.columns
                              WHERE table_name = '" . $wpdb->prefix . _SQ_DB_ . "'
                              AND column_name = %s", 'post' ) );

			if ( $count->count == 0 ) {
				$table = $wpdb->prefix . _SQ_DB_;
				$wpdb->query( "ALTER TABLE `$table` ADD COLUMN post VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''" );
			}

		}
		$wpdb->show_errors();

	}


}
