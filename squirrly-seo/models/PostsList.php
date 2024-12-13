<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_PostsList {

	/**
	 * Process the API data and return the optimization
	 *
	 * @param  $response
	 *
	 * @return mixed
	 */
	public function processPost( $json, $post_type ) {
		$response = array();
		if ( isset( $json->posts ) ) {
			foreach ( $json->posts as $post_id => $row ) {

				if ( isset( $row->error_message ) && $row->error_message <> '' ) {
					$response[ $post_id ] = '<span class="sq_no_rank" ref="' . $post_id . '"><a href="' . SQ_Classes_RemoteController::getMySquirrlyLink( 'plans' ) . '" target="_blank">' . $row->error_message . '</a></span>';
					continue;
				}

				/** @var SQ_Models_LiveAssistant $liveAssistantModel */
				$liveAssistantModel = SQ_Classes_ObjController::getClass( 'SQ_Models_LiveAssistant' );
				$liveAssistantModel->setPostId( $post_id );

				//if it has keywords
				if ( empty( $row->keyword ) ) {
					$row->keyword = $liveAssistantModel->loadOtherKeywords( false );
				}

				$html = '';
				if ( isset( $row->optimized ) && (int) $row->optimized > 0 ) {
					$html .= '<progress class="sq_post_progress" max="100" value="' . esc_attr( $row->optimized ) . '" title="' . esc_attr__( "Optimized", 'squirrly-seo' ) . ': ' . esc_attr( $row->optimized ) . '% ' . '" ></progress>';
					$html .= '<div class="sq_post_keyword" >' . $row->keyword . '</div>';
				} elseif ( ! empty( $row->keyword ) ) {
					$html .= '<div class="sq_post_keyword" >' . $row->keyword . '</div>';
				} else {
					$html .= '<a class="sq_optimize" href="' . admin_url( 'post.php?action=edit&post_type=' . esc_attr( $post_type ) . '&post=' . esc_attr( $post_id ) ) . '" title="' . esc_attr__( "Optimize it with Squirrly Live Assistant", 'squirrly-seo' ) . '">' . esc_html__( "Optimize it with SLA", 'squirrly-seo' ) . '</span>';
				}

				$response[ $post_id ] = $html;
			}

		}

		return $response;
	}

	/**
	 * Show SEO Button
	 *
	 * @param int $post_id
	 * @param string $post_type
	 *
	 * @return string
	 */
	public function getPostButton( $post_id = 0, $post_type = 'post' ) {
		$button = '';
		if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $post_id, 0, '', $post_type ) ) {
			$post                  = SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->parsePage( $post )->getPage();
			$post->tasks_completed = ( $post->tasks_completed ? $post->tasks_completed : 1 );
			$completed             = number_format( ( $post->tasks_completed * 100 ) / $post->tasks, 0 );
			$title                 = esc_html__( "Snippet optimized", 'squirrly-seo' ) . ': ' . $completed . '%. ' . ( $post->tasks - $post->tasks_completed ) . ' ' . esc_html__( "task(s) remained.", 'squirrly-seo' );

			$button .= '<progress class="sq_post_progress" max="' . $post->tasks . '" value="' . $post->tasks_completed . '" title="' . $title . '"></progress>';
		} else {
			$button .= '<progress class="sq_post_progress" max="10" value="1" title="' . esc_attr__( "Can't get snippet data", 'squirrly-seo' ) . '"></progress>';
		}

		$button .= '<a class="sq_column_button" href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo', array(
				'sid=' . $post_id,
				'stype=' . $post_type
			) ) . '"  target="_blank">' . esc_html__( "Edit Snippet", 'squirrly-seo' ) . '</a>';


		return $button;
	}

	/**
	 * Show SEO Button
	 *
	 * @param int $term_id
	 * @param string $taxonomy
	 *
	 * @return string
	 */
	public function getTaxButton( $term_id = 0, $taxonomy = 'post' ) {
		$button = '';
		if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( 0, $term_id, str_replace( 'tax-', '', $taxonomy ), '' ) ) {
			$post                  = SQ_Classes_ObjController::getClass( 'SQ_Models_BulkSeo' )->parsePage( $post )->getPage();
			$post->tasks_completed = ( $post->tasks_completed ? $post->tasks_completed : 1 );
			$completed             = number_format( ( $post->tasks_completed * 100 ) / $post->tasks, 0 );
			$title                 = esc_html__( "Snippet optimized", 'squirrly-seo' ) . ': ' . $completed . '%. ' . ( $post->tasks - $post->tasks_completed ) . ' ' . esc_html__( "task(s) remained.", 'squirrly-seo' );

			$button .= '<progress class="sq_post_progress" max="' . $post->tasks . '" value="' . $post->tasks_completed . '" title="' . $title . '"></progress>';
		} else {
			$button .= '<progress class="sq_post_progress" max="10" value="1" title="' . esc_attr__( "Can't get snippet data", 'squirrly-seo' ) . '"></progress>';
		}
		$button .= '<a class="sq_column_button" href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_assistant', 'bulkseo', array(
				'sid=' . $term_id,
				'stype=' . $taxonomy
			) ) . '"  target="_blank">' . esc_html__( "Edit Snippet", 'squirrly-seo' ) . '</a>';


		return $button;
	}

	public function getPostSnippetInfo( $post_id, $term_id = 0, $taxonomy = '', $post_type = 'post' ) {

		$str = '';
		if ( $post = SQ_Classes_ObjController::getClass( 'SQ_Models_Snippet' )->getCurrentSnippet( $post_id, $term_id, $taxonomy, $post_type ) ) {
			if( $post->sq->doseo ){
				$str .= '<div>';
				if( ! $post->sq->noindex ){
					$str .= '<span style="color: green;">Index</span>';
				}else{
					$str .= '<span style="color: red;">NoIndex</span>';
				}
				$str .= '</div><div>';
				if( ! $post->sq->nofollow ){
					$str .= '<span style="color: green;">Follow</span>';
				}else{
					$str .= '<span style="color: red;">NoFollow</span>';
				}

				$str .= '<div>';
			}else{
				$str .= '<div><span style="color: gray;">N/A</span><div>';
			}

		}


		return $str;
	}

	public function hookUpdateStatus( $post_id ) {
		if ( $post_id > 0 ) {
			$status = get_post_status( $post_id );

			$args            = array();
			$args['status']  = ( $status ? $status : 'deleted' );
			$args['post_id'] = $post_id;
			$args['referer'] = 'posts';

			SQ_Classes_RemoteController::savePost( $args );
		}
	}

}
