<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_CheckSeo extends SQ_Classes_FrontController {

	public $report;
	public $score = 100;
	public $congratulations;
	public $report_time;

	/**
	 * Set a custom category name
	 *
	 * @param  $category_name
	 *
	 * @return $this
	 */
	public function setCategory( $category_name ) {
		$this->model->category_name = $category_name;

		return $this;
	}

	/**
	 * Call the init on Dashboard
	 *
	 * @return mixed|void
	 */
	public function init() {


		if ( SQ_Classes_Helpers_Tools::getOption( 'sq_api' ) == '' ) {
			$this->show_view( 'Errors/Connect' );

			return;
		}

		//Checkin to API V2
		$this->checkin = SQ_Classes_RemoteController::checkin();

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'assistant' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'typewriter' );

		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'checkseo' );
		SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'knob' );

		//get the modal window for the assistant popup
		echo SQ_Classes_ObjController::getClass( 'SQ_Models_Assistant' )->getModal();

		$this->show_view( 'Goals/CheckSeo' );
	}

	/**
	 * Get the notifications from database
	 *
	 * @return mixed
	 */
	public function getNotifications() {

		//Load the report
		$report = $this->model->getDbTasks();
		//Load the tasks from database and filter them
		$tasks = $this->model->getTasks();

		if ( ! empty( $report ) ) {

			if ( ! isset( $this->model->dbtasks['count_tasks_for_today'] ) ) {
				$this->model->dbtasks['count_tasks_for_today'] = 3; //Show 3 goals per day
			}

			$urgent_tasks    = array();
			$tasks_for_today = isset( $this->model->dbtasks['tasks_for_today'] ) ? $this->model->dbtasks['tasks_for_today'] : array();
			if ( ! isset( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ) || count( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ) < $this->model->dbtasks['count_tasks_for_today'] ) {
				//If the tasks for today are not yet set
				$tasks_for_today = array( gmdate( 'Y-m-d' ) => array() );
			} else {
				//update the report to todays tasks
				foreach ( $report as $function => $row ) {
					//Limit today tasks
					if ( isset( $tasks[ $function ]['priority'] ) && $tasks[ $function ]['priority'] == 1 ) {
						if ( ! isset( $tasks[ $function ]['positive'] ) ) {
							$tasks[ $function ]['positive'] = false;
						}

						if ( ! $tasks[ $function ]['positive'] && isset( $row['completed'] ) && ! $row['completed'] ) {
							$urgent_tasks[ $function ] = $row;
						}
					}

					if ( isset( $tasks_for_today[ gmdate( 'Y-m-d' ) ][ $function ] ) ) {
						$tasks_for_today[ gmdate( 'Y-m-d' ) ][ $function ] = $row;
					}
				}

				//add the urgent tasks first in the todays tasks
				if ( ! empty( $urgent_tasks ) ) {
					$tasks_for_today[ gmdate( 'Y-m-d' ) ] = array_merge( $urgent_tasks, $tasks_for_today[ gmdate( 'Y-m-d' ) ] );
				}

				//get the report from todays tasks
				$report = $tasks_for_today[ gmdate( 'Y-m-d' ) ];
			}

			foreach ( $report as $function => &$row ) {

				//Make sure the function is set in the task
				if ( is_array( $row ) && isset( $tasks[ $function ] ) ) {
					if ( ! isset( $tasks[ $function ]['positive'] ) ) {
						$tasks[ $function ]['positive'] = false;
					}

					$row           = array_merge( array(
						'completed' => false,
						'active'    => true,
						'done'      => false
					), $row );
					$row['status'] = $row['active'] ? ( $row['done'] ? 'done' : ( ( $row['completed'] ) ? 'completed' : '' ) ) : 'ignore';

					//if isn't a success task and is not completes
					if ( ! $tasks[ $function ]['positive'] && ( $row['status'] == '' || ! empty( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ) ) ) {
						$row = array_merge( $tasks[ $function ], $row );

						//set defaults for each task
						$default = array(
							'completed' => false,
							'warning'   => '',
							'message'   => '',
							'solution'  => '',
							'link'      => '',
							'color'     => '#4f1440',
							'bullet'    => false,
							'priority'  => 0,
							'ignore'    => false
						);
						$row     = array_merge( $default, $row );

						//replace links
						$row['warning']  = preg_replace( '/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $row['warning'] );
						$row['message']  = preg_replace( '/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $row['message'] );
						$row['solution'] = preg_replace( '/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $row['solution'] );

						//add links to all tools
						if ( ! empty( $row['tools'] ) ) {
							foreach ( $row['tools'] as &$tool ) {
								switch ( $tool ) {
									case 'On-Page SEO':
										$tool = '<a href="https://plugin.squirrly.co/bulk-seo-settings/" target="_blank">' . $tool . '</a>';
										break;
									case 'SEO Automation':
										$tool = '<a href="https://howto12.squirrly.co/kb/seo-automation/" target="_blank">' . $tool . '</a>';
										break;
									case 'SEO Snippet':
										$tool = '<a href="https://plugin.squirrly.co/seo-snippet-tool/" target="_blank">' . $tool . '</a>';
										break;
									case 'Focus Pages':
										$tool = '<a href="https://plugin.squirrly.co/focus-pages/" target="_blank">' . $tool . '</a>';
										break;
									case 'Live Assistant':
										$tool = '<a href="https://plugin.squirrly.co/seo-virtual-assistant/" target="_blank">' . $tool . '</a>';
										break;
									case 'Multiple Keyword Optimization':
										$tool = '<a href="https://plugin.squirrly.co/seo-virtual-assistant/" target="_blank">' . $tool . '</a>';
										break;
									case 'Keyword Research':
										$tool = '<a href="https://plugin.squirrly.co/best-keyword-research-tool-for-seo/" target="_blank">' . $tool . '</a>';
										break;
									case 'Briefcase':
										$tool = '<a href="https://plugin.squirrly.co/briefcase-keyword-management-tool/" target="_blank">' . $tool . '</a>';
										break;
									case 'Rankings':
										$tool = '<a href="https://plugin.squirrly.co/google-serp-checker/" target="_blank">' . $tool . '</a>';
										break;
									case 'Audits':
										$tool = '<a href="https://plugin.squirrly.co/site-seo-audit-tool/" target="_blank">' . $tool . '</a>';
										break;
								}
							}
						}


					} else {
						//if task is complete, remove it
						unset( $report[ $function ] );
					}
				} else {
					//if function doesn't exists, remove the task
					unset( $report[ $function ] );
				}
			}


			//Set the todays tasks if empty
			if ( empty( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ) ) {
				$count = 1;
				foreach ( $report as $function => $task ) {
					//Limit today tasks
					if ( $count > $this->model->dbtasks['count_tasks_for_today'] && $task['priority'] > 1 ) {
						unset( $report[ $function ] );
					} else {
						$tasks_for_today[ gmdate( 'Y-m-d' ) ][ $function ] = $task;
					}

					$count ++;
				}
			}

			//Verify the goals gor today completion and progress
			if ( ! empty( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ) ) {

				$countdone = 0;
				foreach ( $tasks_for_today[ gmdate( 'Y-m-d' ) ] as $function => $task ) {

					if ( ! isset( $report[ $function ] ) ) { //in case the goal was removed from API
						//remove the daily goal and move on
						unset( $tasks_for_today[ gmdate( 'Y-m-d' ) ][ $function ] );
						continue;
					}

					//count the completed goals for today's progress
					if ( in_array( $report[ $function ]['status'], array( 'completed', 'done', 'ignore' ) ) ) {
						$countdone ++;
					}
				}

				//Calculate today's progress
				if ( count( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ) > 0 ) {
					$this->score = number_format( ( 100 * $countdone ) / count( $tasks_for_today[ gmdate( 'Y-m-d' ) ] ), 0 );
				}

			}

			$this->model->dbtasks['tasks_for_today'] = $tasks_for_today;
			$this->model->saveDbTasks();

		}

		//return the report
		return $report;
	}

	/**
	 * Check SEO Actions
	 */
	public function action() {
		parent::action();

		switch ( SQ_Classes_Helpers_Tools::getValue( 'action' ) ) {
			case 'sq_checkseo':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					return;
				}

				SQ_Classes_Error::setMessage( esc_html__( "Done!", 'squirrly-seo' ) );
				//Check all the SEO
				//Process all the tasks and save the report
				$this->model->checkSEO();

				break;
			case 'sq_moretasks':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					return;
				}

				$this->model->dbtasks['tasks_for_today'] = array();
				$this->model->saveDbTasks();

				SQ_Classes_Error::setMessage( esc_html__( "Done!", 'squirrly-seo' ) );
				//Check all the SEO
				//Process all the tasks and save the report
				$this->model->checkSEO();

				break;
			case 'sq_fixsettings':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					return;
				}

				$name  = SQ_Classes_Helpers_Tools::getValue( 'name' );
				$value = SQ_Classes_Helpers_Tools::getValue( 'value' );

				if ( $name ) {
					if ( in_array( $name, array_keys( SQ_Classes_Helpers_Tools::$options ) ) ) {
						SQ_Classes_Helpers_Tools::saveOptions( $name, (bool) $value );

						//Process all the tasks and save the report
						$this->model->checkSEO();

						SQ_Classes_Error::setMessage( esc_html__( "Fixed!", 'squirrly-seo' ) );

						return;
					}
				}

				SQ_Classes_Error::setError( esc_html__( "Could not fix it. You need to change it manually.", 'squirrly-seo' ) );
				break;
			case 'sq_donetask':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					return;
				}

				$name = SQ_Classes_Helpers_Tools::getValue( 'name' );

				$this->model->doneTask( $name );

				SQ_Classes_Error::setMessage( esc_html__( "Saved! Task marked as done.", 'squirrly-seo' ) );
				break;
			case 'sq_resetignored':

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					return;
				}


				//Set task category
				if(SQ_Classes_Helpers_Tools::getValue( 'category' )){
					$this->setCategory(SQ_Classes_Helpers_Tools::getValue( 'category' ) );
				}

				//Remove ignored tasks
				$this->model->clearIgnoredTasks();

				SQ_Classes_Error::setMessage( esc_html__( "Saved!", 'squirrly-seo' ) );

				break;
			case 'sq_ajax_checkseo':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$json = array();

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				//Check all the SEO
				//Process all the tasks and save the report
				$this->model->checkSEO();

				if ( SQ_Classes_Error::isError() ) {
					$json['error'] = SQ_Classes_Error::getError();
				}

				echo wp_json_encode( $json );
				exit();
			case 'sq_ajax_getgoals':

				SQ_Classes_Helpers_Tools::setHeader( 'json' );
				$json = array();

				if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_snippets' ) ) {
					$response['error'] = SQ_Classes_Error::showNotices( esc_html__( "You do not have permission to perform this action", 'squirrly-seo' ), 'error' );
					echo wp_json_encode( $response );
					exit();
				}

				if ( ! isset( $this->report ) ) {
					$this->report = $this->getNotifications();
				}

				$json['html'] = $this->get_view( 'Goals/Goals' );

				//Support for international languages
				if ( function_exists( 'iconv' ) && SQ_Classes_Helpers_Tools::getOption( 'sq_non_utf8_support' ) ) {
					if ( strpos( get_bloginfo( "language" ), 'en' ) === false ) {
						$json['html'] = iconv( 'UTF-8', 'UTF-8//IGNORE', $json['html'] );
					}
				}

				if ( SQ_Classes_Error::isError() ) {
					$json['error'] = SQ_Classes_Error::getError();
				}

				echo wp_json_encode( $json );
				exit();
		}


	}

}
