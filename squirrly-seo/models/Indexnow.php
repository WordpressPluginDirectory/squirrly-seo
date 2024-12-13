<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Auto-Indexing class.
 *
 */
class SQ_Models_Indexnow {

	/**
	 * IndexNow key.
	 *
	 * @var string
	 */
	protected $_apiKey = '';

	protected $_success;

	public function submitUrl( $urls, $manual = 0 ) {

		$data = $this->getLinks( $urls );

		//Send the ULRs to Google API Indexing
		//Requires GSC Connection
		$args['urls'] = $urls;
		SQ_Classes_RemoteController::sendGSCIndex( $args );

		//get the urls from options
		$this->_apiUrls = SQ_Classes_Helpers_Tools::getOption('indexnow_endpoints');

		if(empty($this->_apiUrls)){
			$this->_apiUrls = array(
				'https://api.indexnow.org',
				'https://www.bing.com/indexnow',
			);
		}

		//Send to all IndexNow APIs
		foreach ( $this->_apiUrls as $apiurl ) {
			//fix 404 error on IndexNow when the endpoint is not working
			if($apiurl == 'https://indexnow.yep.com') {
				continue;
			}

			$response = wp_remote_post( $apiurl, [
					'body'    => $data,
					'headers' => [
						'Content-Type'  => 'application/json',
						'User-Agent'    => 'Squirrly/' . md5( esc_url( home_url( '/' ) ) ),
						'X-Source-Info' => 'https://squirrly.co/' . SQ_VERSION . '/' . $manual
					],
				] );

			if ( is_wp_error( $response ) ) {
				$this->addLog( (array) $urls, 0, $manual, 'Error: ' . $response->get_error_message() );

				return false;
			}
		}

		$http_code = wp_remote_retrieve_response_code( $response );
		if ( in_array( $http_code, [ 200, 202, 204 ], true ) ) {
			$this->_success = true;
			$this->addLog( (array) $urls, $http_code, $manual, 'Success' );

			return true;
		}

		if ( ! $message = wp_remote_retrieve_response_message( $response ) ) {
			$message = $this->getErrorMessage( $http_code );
		}

		$this->addLog( (array) $urls, $http_code, $manual, $message );

		return false;
	}

	/**
	 * Get the current domain host or localhost
	 *
	 * @return array|bool|mixed|string|null
	 */
	public function getHost() {
		$host = wp_parse_url( home_url(), PHP_URL_HOST );
		if ( empty( $host ) ) {
			$host = 'localhost';
		}

		return $host;
	}

	/**
	 * Get the API key.
	 *
	 * @return string
	 */
	public function getKey() {
		if ( ! empty( $this->_apiKey ) ) {
			return $this->_apiKey;
		}

		if ( ! $this->_apiKey = SQ_Classes_Helpers_Tools::getOption( 'indexnow_key' ) ) {
			$this->resetIndexnowKey();
		}

		return apply_filters( 'sq_indexnow_key', $this->_apiKey );
	}

	/**
	 * Get the API key location.
	 *
	 * @return string
	 */
	public function getKeyUrl() {
		return apply_filters( 'sq_indexnow_key_url', trailingslashit( home_url() ) . $this->getKey() . '.txt' );
	}

	/**
	 * Get the additional data to send to the API.
	 *
	 * @param array $urls URLs to submit.
	 *
	 * @return mixed
	 */
	private function getLinks( $urls ) {
		return wp_json_encode( [
				'host'        => $this->getHost(),
				'key'         => $this->getKey(),
				'keyLocation' => $this->getKeyUrl(),
				'urlList'     => (array) $urls,
			] );
	}

	/**
	 * Get the error message from list
	 *
	 * @param $http_code
	 *
	 * @return mixed|string|void
	 */
	private function getErrorMessage( $http_code ) {

		$message     = __( 'Unknown error.', 'squirrly-seo' );
		$message_map = [
			400 => __( 'Invalid request.', 'squirrly-seo' ),
			403 => __( 'Invalid API key.', 'squirrly-seo' ),
			422 => __( 'Invalid URL.', 'squirrly-seo' ),
			429 => __( 'Too many requests.', 'squirrly-seo' ),
			500 => __( 'Internal server error.', 'squirrly-seo' ),
		];

		if ( isset( $message_map[ $http_code ] ) ) {
			$message = $message_map[ $http_code ];
		}

		return $message;
	}


	/**
	 * Generate and save a new API key.
	 */
	public function resetIndexnowKey() {

		$this->_apiKey = $this->generateApiKey();
		SQ_Classes_Helpers_Tools::saveOptions( 'indexnow_key', $this->_apiKey );

	}

	/**
	 * Generate new random API key.
	 */
	private function generateApiKey() {
		$api_key = wp_generate_uuid4();
		$api_key = preg_replace( '[-]', '', $api_key );

		return $api_key;
	}

	/**
	 * Log the request.
	 *
	 * @param $urls
	 * @param $status
	 * @param $manual
	 * @param $message
	 *
	 * @return void
	 */
	public function addLog( $urls, $status, $manual, $message = '' ) {
		$log = $this->getLog();
		$url = $this->getUrlLog( $urls );

		if ( ! $url ) {
			return;
		}

		$log[] = [
			'url'     => $url,
			'status'  => (int) $status,
			'manual'  => (int) $manual,
			'message' => $message,
			'time'    => time(),
		];

		// Only keep the last 100 records.
		$log = array_slice( $log, - 100 );

		$this->setLog( $log );
	}

	/**
	 * Generate the History Log
	 *
	 * @param $urls
	 *
	 * @return mixed|string
	 */
	public function getUrlLog( $urls ) {
		$urls       = array_values( (array) $urls );
		$count_urls = count( $urls );
		if ( ! $count_urls ) {
			return '';
		}

		$url = $urls[0];
		if ( $count_urls > 1 ) {
			$url .= ' [+' . ( $count_urls - 1 ) . ']';
		}

		return $url;
	}

	/**
	 * Get the IndexNow log.
	 *
	 * @return array
	 */
	public function getLog() {
		return get_option( 'sq_indexnow_log', [] );
	}

	/**
	 * Save the log in database
	 *
	 * @param $log
	 *
	 * @return void
	 */
	public function setLog( $log ) {
		update_option( 'sq_indexnow_log', $log, false );
	}

	/**
	 * Delete the IndexNow log.
	 */
	public function deleteLog() {
		delete_option( 'sq_indexnow_log' );
	}

}
