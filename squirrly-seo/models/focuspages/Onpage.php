<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Models_Focuspages_Onpage extends SQ_Models_Abstract_Assistant {

	protected $_category = 'onpage';

	protected $_robots = false;
	protected $_doseo = false;
	protected $_posttype = false;
	protected $_patterns = false;
	protected $_sitemap = false;

	public function init() {
		parent::init();

		if ( ! isset( $this->_audit->data ) ) {
			$this->_error = true;

			return;
		}

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_robots' ) ) {
			$this->_robots = home_url( 'robots.txt' );
		} elseif ( isset( $this->_audit->data->sq_seo_file_robots->value ) ) {
			$this->_robots = $this->_audit->data->sq_seo_file_robots->value;
		}

		if ( isset( $this->_post->sq_adm->doseo ) ) {
			if ( isset( $this->_post->post_type ) ) {
				if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) ) {
					$patterns = SQ_Classes_Helpers_Tools::getOption( 'patterns' );

					if ( isset( $patterns[ $this->_post->post_type ] ) ) {
						$this->_posttype = true;
					}
				}
			}
		}

		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_pattern' ) ) {
			$this->_patterns = $this->_post->sq->do_pattern;
		}
		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_auto_sitemap' ) ) {
			$this->_sitemap = ! $this->_post->sq_adm->nositemap;

		}
	}

	public function setTasks( $tasks ) {
		parent::setTasks( $tasks );

		$this->_tasks[ $this->_category ] = array(
			'sitemap'  => array(
				'title'       => esc_html__( "Enhance your sitemap", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Add images / videos to your sitemap. It's important to have images / videos enabled. %s Squirrly SEO makes it super easy for you to enhance your XML sitemap. %s Just use the settings from %s Squirrly > Technical SEO > Tweaks And Sitemap %s. Find the XML sitemap section and use the settings from that panel. %s Note! If the image/video options are not visible, enable the SEO Expert mode from top-right corner.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings', 'tweaks', array( '#tab=sitemap' ) ) . '" target="_blank" >', '</a>', '<br /><br />' ),
			),
			'posttype' => array(
				'title'       => esc_html__( "Post Type settings activated", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "Are the SEO Settings from Squirrly SEO activated for the post type of this particular Focus Page? %s This is what we're checking with this task. %s Why? %s Some of the times, we're seeing that people don't get good enough results with Google rankings simply because they do not have the SEO settings activated for their current post type. %s Many WordPress sites employ the use of custom post types. Your \"Events\" page or \"Real Estate\" page could be a different post type from general \"Pages\" or \"Posts\" in WordPress. %s To complete this task, go and add this post type (%s) in %sSquirrly SEO Automation%s.", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<strong>' . $this->_post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_automation', 'types' ) . '" target="_blank" >', '</a>' ),
			),
			'patterns' => array(
				'title'       => esc_html__( "SEO Automation activated", 'squirrly-seo' ),
				'description' => sprintf( esc_html__( "To complete this task, go and activate the %s SEO Automation %s from All Features. %s With this task, we're looking to see if the SEO Patterns from Squirrly are activated for the post type of this Focus Page. %s Similar to the previous task with \"Post Type Settings Activated\". There are some cases in which this double check is necessary. %s It's for your ranking safety.", 'squirrly-seo' ), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_features', false, array( 'sfeature=seo+automation' ) ) . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
			'robots'   => array(
				'title'       => esc_html__( "Robots File", 'squirrly-seo' ),
				'value'       => $this->_robots,
				'description' => sprintf( esc_html__( "You have a certain definition for your Robots.txt file made in Squirrly SEO or in another plugin. %s Make sure that the final version of robots.txt that gets rendered when the file is loaded is the one you had intended. %s Sometimes, other plugins or themes can interfere and ruin the output of the robots file. Sometimes it can even be that you have a robots.txt file placed on your root directory (in such case: remove that file. hard-coding things like that is bad practice!). %s To do this: look at the definition you've made inside your plugin. Then, look at the robots.txt from your site. See if the text inside these two places is identical. If it is identical, everything is Perfect!", 'squirrly-seo' ), '<br /><br />', '<br /><br />', '<br /><br />' ),
			),
		);
	}

	/*********************************************/
	/**
	 * @param  $content
	 * @param  $task
	 *
	 * @return string
	 */
	public function getHeader() {
		$header = '<li class="completed">';
		$header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__( "Current URL", 'squirrly-seo' ) . ': </div>';
		$header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode( $this->_post->url ) . '</a>';
		$header .= '</li>';

		$header .= '<li class="completed">
                    <a href="' . SQ_Classes_Helpers_Tools::getAdminUrl( 'sq_seosettings' ) . '" target="_blank" class="btn btn-primary text-white col-10 offset-1 mt-3">' . esc_html__( "Go to Technical SEO", 'squirrly-seo' ) . '</a>
                </li>';

		return $header;
	}

	public function getTitle( $title ) {

		if ( ! $this->_completed && ! $this->_indexed ) {
			foreach ( $this->_tasks[ $this->_category ] as $task ) {
				if ( $task['completed'] === false ) {
					return '<img src="' . esc_url( _SQ_ASSETS_URL_ . 'img/assistant/tooltip.gif' ) . '" width="100">';
				}
			}
		}

		return parent::getTitle( $title );
	}

	/**
	 * Check the video and images option from Squirrly Sitemap XML
	 *
	 * @return bool
	 */
	public function checkSitemap( $task ) {
		if ( $this->_sitemap ) {
			$sitemap_options = SQ_Classes_Helpers_Tools::getOption( 'sq_sitemap_show' );
			if ( $sitemap_options['images'] && $sitemap_options['videos'] ) {
				$task['completed'] = true;

				return $task;
			}
		}

		$task['completed'] = false;

		return $task;
	}

	/**
	 * Check if Squirrly SEO metas is activated for this page
	 *
	 * @return bool
	 */
	public function checkPosttype( $task ) {
		$task['completed'] = $this->_posttype;

		return $task;
	}

	/**
	 * Check if Squirrly SEO patterns is activated for this page
	 *
	 * @return bool
	 */
	public function checkPatterns( $task ) {
		$task['completed'] = $this->_patterns;

		return $task;
	}


	/**
	 * Check the robots.txt integrity
	 * Call robots and check the content = with Squirrly Robots.tx
	 * | API robots exists if robots is not activated
	 *
	 * @return bool|WP_Error
	 */
	public function checkRobots( $task ) {
		if ( $this->_robots !== false ) {
			$task['completed'] = ( $this->_robots <> '' );

			return $task;
		}

		$task['error'] = true;

		return $task;
	}
}
