<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class SQ_Controllers_Progress extends SQ_Classes_FrontController {

	public $report;
	public $score = 100;
	public $congratulations;


	/**
	 * Call the init on Dashboard
	 *
	 * @return mixed|void
	 */
	public function init() {

		if ( ! isset( $this->congratulations ) ) {
			$this->congratulations = $this->getCongratulations();
		}

		if ( ! empty( $this->congratulations ) ) {
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'checkseo' );
			SQ_Classes_ObjController::getClass( 'SQ_Classes_DisplayController' )->loadMedia( 'knob' );

			$this->show_view( 'Goals/Congrats' );
		}
	}

	/**
	 * Get the notifications from database
	 *
	 * @return mixed
	 */
	public function getCongratulations() {

		$report = SQ_Classes_ObjController::getClass( 'SQ_Models_CheckSeo' )->getDbTasks();
		$tasks  = SQ_Classes_ObjController::getClass( 'SQ_Models_CheckSeo' )->getTasks();

		if ( ! empty( $report ) ) {
			foreach ( $report as $function => &$row ) {

				if ( is_array( $row ) && isset( $tasks[ $function ] ) ) {

					if ( ! isset( $tasks[ $function ]['positive'] ) ) {
						$tasks[ $function ]['positive'] = false;
					}

					$row           = array_merge( array(
						'completed' => false,
						'active'    => true,
						'done'      => false,
						'positive'  => false
					), $row );
					$row['status'] = $row['active'] ? ( ( $row['completed'] || $row['done'] ) ? 'completed' : '' ) : 'ignore';

					if ( $tasks[ $function ]['positive'] && in_array( $row['status'], array( 'completed', 'ignore' ) ) ) {
						$row = array_merge( $tasks[ $function ], $row );
					} else {
						unset( $report[ $function ] );
					}

				} else {
					unset( $report[ $function ] );
				}
			}
		}

		//return the report
		return $report;
	}


}
