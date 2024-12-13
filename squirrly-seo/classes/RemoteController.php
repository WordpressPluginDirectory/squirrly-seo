<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Classes_RemoteController
{

    public static $apimethod = 'get';

    /**
     * Call the Squirrly Cloud Server
     *
     * @param  string $module
     * @param  array  $args
     * @param  array  $options
     * @return string
     */
    public static function apiCall($module, $args = array(), $options = array())
    {
        $parameters = "";

        //Don't make API calls without the token unless it's login or register
        if (!SQ_Classes_Helpers_Tools::getOption('sq_api')) {
            if (!in_array($module, array('api/user/login', 'api/user/register', 'api/user/checkin'))) {
                return '';
            }
        }

        //predefined options
        $options = array_merge(
            array(
                'method' => self::$apimethod,
                'sslverify' => SQ_CHECK_SSL,
                'timeout' => 20,
                'headers' => array(
                    'USER-TOKEN' => SQ_Classes_Helpers_Tools::getOption('sq_api'),
                    'URL-TOKEN' => (SQ_Classes_Helpers_Tools::getOption('sq_cloud_connect') ? SQ_Classes_Helpers_Tools::getOption('sq_cloud_token') : false),
                    'USER-URL' => apply_filters('sq_homeurl', get_bloginfo( 'url' )),
                    'LANG' => apply_filters('sq_language', get_bloginfo('language')),
                    'VERSQ' => (int)str_replace('.', '', SQ_VERSION)
                )
            ),
            $options
        );

        try {
            if ($options['method'] == 'get' && !empty($args)) {
                $parameters = "?" . http_build_query($args);
            }

            //call it with http to prevent curl issues with ssls
            $url = self::cleanUrl(_SQ_APIV2_URL_ . $module . $parameters);

            if ($options['method'] == 'post') {
                $options['body'] = $args;
            }

	        return self::sq_wpcall($url, $options);

        } catch (Exception $e) {
            return '';
        }

    }

    /**
     * Clear the url before the call
     *
     * @param  string $url
     * @return string
     */
    private static function cleanUrl($url)
    {
        return str_replace(array(' '), array('+'), $url);
    }

    public static function generatePassword($length = 12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $password;
    }

    /**
     * Get My Squirrly Link
     *
     * @param  $path
     * @return string
     */
    public static function getMySquirrlyLink($path)
    {
        return apply_filters('sq_cloudmenu', _SQ_DASH_URL_, $path);
    }

    /**
     * Get API Link
     *
     * @param  string  $path
     * @param  integer $version
     * @return string
     */
    public static function getApiLink($path)
    {
        return _SQ_APIV2_URL_ . $path . '?token=' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '&url_token='.(SQ_Classes_Helpers_Tools::getOption('sq_cloud_connect') ? SQ_Classes_Helpers_Tools::getOption('sq_cloud_token') : false).'&url=' . apply_filters('sq_homeurl', get_bloginfo('url'));
    }

    /**
     * Use the WP remote call
     *
     * @param  $url
     * @param  $options
     * @return array|bool|string|WP_Error
     */
    public static function sq_wpcall($url, $options)
    {
        $method = $options['method'];
        //not accepted as option
        unset($options['method']);

        switch ($method) {
        case 'get':
            $response = wp_remote_get($url, $options);
            break;
        case 'post':
            $response = wp_remote_post($url, $options);
            break;
        default:
            $response = wp_remote_request($url, $options);
            break;
        }

        if (is_wp_error($response)) {
            SQ_Classes_Error::setError($response->get_error_message());
            return false;
        }

        $response = self::cleanResponse(wp_remote_retrieve_body($response)); //clear and get the body

        SQ_Debug::dump('wp_remote_get', $method, $url, $options, $response); //output debug
        return $response;
    }

    /**
     * Get the Json from response if any
     *
     * @param  string $response
     * @return string
     */
    private static function cleanResponse($response)
    {
        return trim($response, '()');
    }

    /**********************
     * 
     * USER 
     ******************************/
    /**
     * @param  array $args
     * @return array|mixed|object|WP_Error
     */
    public static function connect($args = array())
    {
        self::$apimethod = 'post'; //call method
        $json = json_decode(self::apiCall('api/user/connect', $args));

        if (isset($json->error) && $json->error <> '') {

            if ($json->error == 'invalid_token') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
                SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', false);
            }
            if ($json->error == 'disconnected') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
                SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', false);
            }
            if ($json->error == 'banned') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
                SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', false);
            }
            return (new WP_Error('api_error', $json->error));
        }

        //Refresh the checkin on login
        delete_transient('sq_checkin');

        return $json;
    }

    /**
     * Login user to API
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function login($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/user/login', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        //Refresh the checkin on login
        delete_transient('sq_checkin');

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Register user to API
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function register($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/user/register', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        //Refresh the checkin on login
        delete_transient('sq_checkin');

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get a new token for the current URL
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function getCloudToken($args = array())
    {
        self::$apimethod = 'get'; //call method

        if(function_exists('rest_get_url_prefix')) {
            $apiUrl = trim(rest_get_url_prefix(), '/');
        }elseif(function_exists('rest_url')) {
            $apiUrl = trim(parse_url(rest_url(), PHP_URL_PATH), '/');
        }

        $args = array_merge($args, array('wp-json' => $apiUrl));

        $json = json_decode(self::apiCall('api/user/token', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * User Checkin
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function checkin($args = array())
    {
        self::$apimethod = 'get'; //call method

        if (get_transient('sq_checkin')) {
            return get_transient('sq_checkin');
        }

        $json = json_decode(self::apiCall('api/user/checkin', $args));

        if (isset($json->error) && $json->error <> '') {

            //prevent throttling on API
            if ($json->error == 'too_many_requests') {
                SQ_Classes_Error::setError(esc_html__("Too many API attempts, please slow down the request.", 'squirrly-seo'));
                SQ_Classes_Error::hookNotices();
                return (new WP_Error('api_error', $json->error));
            } elseif ($json->error == 'maintenance') {
                SQ_Classes_Error::setError(esc_html__("Squirrly Cloud is down for a bit of maintenance right now. But we'll be back in a minute.", 'squirrly-seo'));
                SQ_Classes_Error::hookNotices();
                return (new WP_Error('maintenance', $json->error));
            }

            SQ_Classes_RemoteController::connect(); //connect the website
            return (new WP_Error('api_error', $json->error));

        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        //Connect the website if not yet connected
        if (isset($json->data->connected) && !$json->data->connected) {
            SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', false);
            SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_connect', 0);

            //Make sure the website exists on the Cloud
            SQ_Classes_RemoteController::connect();

            if ($token = SQ_Classes_RemoteController::getCloudToken()) {
                if(isset($token->token) && $token->token <> '') {
                    SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', $token->token);
                    SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_connect', 1);
                }
            }
        }

        //Save the connections into database
        if (isset($json->data->connection_gsc) && isset($json->data->connection_ga)) {
            $connect = SQ_Classes_Helpers_Tools::getOption('connect');
            $connect['google_analytics'] = $json->data->connection_ga;
            $connect['google_search_console'] = $json->data->connection_gsc;
            SQ_Classes_Helpers_Tools::saveOptions('connect', $connect);
        }

        if(isset($json->data->subscription_devkit)) {
            SQ_Classes_Helpers_Tools::saveOptions('sq_auto_devkit', (int)$json->data->subscription_devkit);
        }

        set_transient('sq_checkin', $json->data, 60);
        return $json->data;
    }

    /********************************
     * 
     * NOTIFICATIONS 
     *********************/
    /**
     * Get the Notifications from API for the current blog
     *
     * @return array|WP_Error
     */
    public static function getNotifications()
    {
        self::$apimethod = 'get'; //call method

        $notifications = array();
        if ($json = json_decode(self::apiCall('api/audits/notifications', array()))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            $notifications = $json->data;

        }

        return $notifications;
    }

    /**
     * Get the API stats for this blog
     *
     * @return array|WP_Error|false
     */
    public static function getStats()
    {
        self::$apimethod = 'get'; //call method

        if (get_transient('sq_stats')) {
            return get_transient('sq_stats');
        }

        $args = array();
        $json = json_decode(self::apiCall('api/user/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            set_transient('sq_stats', $json->data, 60);
            return $json->data;
        }

        return false;

    }

    public static function saveFeedback($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/user/feedback', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }


    /********************************
     * LIVE ASSISTANT
     *********************/
    public static function getSLAKeywords($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/keyword', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getSLAPreview($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/research/ib/preview', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getSLATasks($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/seo/tasks', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getSLABriefcase($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/optimize/get', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function addSLABriefcase($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/optimize/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveSLABriefcase($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/optimize/save', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function deleteSLABriefcase($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/optimize/delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getCustomCall($url, $args = array())
    {
        self::$apimethod = 'get'; //call method

        return self::apiCall($url, $args);

    }

    /********************************
     * BRIEFCASE
     *********************/
    public static function getBriefcaseStats($args = array())
    {
        self::$apimethod = 'get'; //call method

        if (get_transient('sq_briefcase_stats')) {
            return get_transient('sq_briefcase_stats');
        }

        $json = json_decode(self::apiCall('api/briefcase/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            set_transient('sq_briefcase_stats', $json->data, 60);
            return $json->data;
        }

        return false;
    }

    public static function getBriefcase($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/get', $args, ['timeout' => 60]));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }


        if (!empty($json->data)) {
	        //prepare the pagination if there is a total number for array
	        if(isset($json->data->results)){
		        add_filter('sq_total_records', function () use ($json) {return $json->data->results;});
	        }

	        return $json->data;
        }

        return false;
    }

	public static function getBriefcaseLabels($args = array())
	{
		self::$apimethod = 'get'; //call method

		$json = json_decode(self::apiCall('api/briefcase/label/get', $args));

		if (isset($json->error) && $json->error <> '') {
			return (new WP_Error('api_error', $json->error));
		} elseif (!isset($json->data)) {
			return (new WP_Error('api_error', 'no_data'));
		}

		if (!empty($json->data)) {
			//prepare the pagination if there is a total number for array
			if (isset($json->message->total)) {
				add_filter('sq_total_records', function () use ($json) {return $json->message->total;});
			}

			return $json->data;
		}

		return false;
	}


    public static function importBriefcaseKeywords($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_briefcase_stats');

        $json = json_decode(self::apiCall('api/briefcase/import', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function addBriefcaseKeyword($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_briefcase_stats');

        $json = json_decode(self::apiCall('api/briefcase/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function removeBriefcaseKeyword($args = array())
    {
        self::$apimethod = 'post'; //call method

        if ($json = json_decode(self::apiCall('api/briefcase/hide', $args))) {
            return $json;
        }

        return false;
    }

	public static function removeBriefcaseKeywords($args = array())
	{
		self::$apimethod = 'post'; //call method

		if ($json = json_decode(self::apiCall('api/briefcase/hide/keywords', $args))) {
			return $json;
		}

		return false;
	}

    public static function saveBriefcaseKeywordLabel($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_briefcase_stats');

        $json = json_decode(self::apiCall('api/briefcase/label/keyword', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

	public static function saveBriefcaseKeywordsLabel($args = array())
	{
		self::$apimethod = 'post'; //call method

		//clear the briefcase stats
		delete_transient('sq_briefcase_stats');

		$json = json_decode(self::apiCall('api/briefcase/label/keywords', $args));

		if (isset($json->error) && $json->error <> '') {
			return (new WP_Error('api_error', $json->error));
		} elseif (!isset($json->data)) {
			return (new WP_Error('api_error', 'no_data'));
		}

		if (!empty($json->data)) {
			return $json->data;
		}

		return false;
	}

    public static function addBriefcaseLabel($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_briefcase_stats');

        $json = json_decode(self::apiCall('api/briefcase/label/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveBriefcaseLabel($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_briefcase_stats');

        $json = json_decode(self::apiCall('api/briefcase/label/save', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function removeBriefcaseLabel($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveBriefcaseMainKeyword($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/main', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }


    /********************************
     * 
     * Keyword RESEARCH
     ****************/

    /**
     * Get KR Countries
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function getKrCountries($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/countries', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

	/**
	 * Get KR Languages
	 *
	 * @param  array $args
	 * @return bool|WP_Error
	 */
    public static function getKrLanguages($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/languages', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getKROthers($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/other', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Set Keyword Research
     *
     * @param  array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function setKRSuggestion($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_stats');
        delete_transient('sq_briefcase_stats');

        $json = json_decode(self::apiCall('api/kr/suggestion', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getKRSuggestion($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/suggestion', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /********************************
     * 
     * KEYWORD HISTORY & FOUND  
     ****************/

    /**
     * Get Keyword Research History
     *
     * @param  array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function getKRHistory($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/history', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {

	        if (isset($json->message->total)) {
		        add_filter('sq_total_records', function () use ($json) {return $json->message->total;});
	        }

            return $json->data;
        }

        return false;
    }

    /**
     * Get the Kr Found by API
     *
     * @param  array $args
     * @return array|false|WP_Error
     */
    public static function getKrFound($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/kr/found', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {

	        if (isset($json->message->total)) {
		        add_filter('sq_total_records', function () use ($json) {return $json->message->total;});
	        }

            return $json->data;
        }

        return false;
    }

    /**
     * 
     * Remove Keyword from Suggestions
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function removeKrFound($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/kr/found/delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }
    /********************
     * 
     * WP Posts 
     ***************************/
    /**
     * Save the post status on API
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function savePost($args = array())
    {
        self::$apimethod = 'post'; //call method

        //clear the briefcase stats
        delete_transient('sq_stats');

        $json = json_decode(self::apiCall('api/posts/update', $args, ['timeout' => 5]));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Get the post optimization
     *
     * @param  array $args
     * @return array|mixed|object
     */
    public static function getPostOptimization($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/optimizations', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /********************
     * 
     * RANKINGS 
     ***************************/

    /**
     * Add a keyword in Rank Checker
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function addSerpKeyword($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/serp', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

	/**
	 * Add bulk keywords in Rank Checker
	 *
	 * @param  array $args
	 * @return bool|WP_Error
	 */
	public static function addSerpKeywords($args = array())
	{
		self::$apimethod = 'post'; //call method

		$json = json_decode(self::apiCall('api/briefcase/serp/keywords', $args));

		if (isset($json->error) && $json->error <> '') {
			return (new WP_Error('api_error', $json->error));
		} elseif (!isset($json->data)) {
			return (new WP_Error('api_error', 'no_data'));
		}

		if (!empty($json->data)) {
			return $json->data;
		}

		return false;
	}

    /**
     * Delete a keyword from Rank Checker
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function deleteSerpKeyword($args = array())
    {
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/serp-delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the Ranks for this blog
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function getRanksStats($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the Ranks for this blog
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function getRanks($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/get-ranks', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {

	        if (isset($json->message->total)) {
		        add_filter('sq_total_records', function () use ($json) {return $json->message->total;});
	        }

            return $json->data;
        }

        return false;
    }

    /**
     * Refresh the rank for a page/post
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function checkPostRank($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/refresh', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /********************
     * 
     * FOCUS PAGES 
     ***********************/

    /**
     * Get all focus pages and add them in the SQ_Models_Domain_FocusPage object
     * Add the audit data for each focus page
     *
     * @param  array $args
     * @return SQ_Models_Domain_FocusPage|WP_Error|false
     */
    public static function getFocusPages($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the focus page audit
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function getFocusAudits($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/audits/focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

	/**
	 * get the found innelinks for a specific Focus Page
	 * @param $args
	 *
	 * @return false|WP_Error
	 */
	public static function getFocusPageInnerlinks($args = array())
	{
		self::$apimethod = 'get'; //call method
		$json = json_decode(self::apiCall('api/posts/innelinks', $args));

		if (isset($json->error) && $json->error <> '') {
			return (new WP_Error('api_error', $json->error));
		} elseif (!isset($json->data)) {
			return (new WP_Error('api_error', 'no_data'));
		}

		if (!empty($json->data)) {
			return $json->data;
		}

		return false;
	}

	public static function setFocusPageInnerlink($args = array())
	{
		self::$apimethod = 'post'; //post call

		$json = json_decode(self::apiCall('api/posts/set-innelink', $args));

		if (isset($json->error) && $json->error <> '') {
			return (new WP_Error('api_error', $json->error));
		} elseif (!isset($json->data)) {
			return (new WP_Error('api_error', 'no_data'));
		}

		if (!empty($json->data)) {
			return $json->data;
		}

		return false;
	}

	public static function deleteFocusPageInnerlink($args = array())
	{
		self::$apimethod = 'post'; //post call

		$json = json_decode(self::apiCall('api/posts/delete-innelink', $args));

		if (isset($json->error) && $json->error <> '') {
			return (new WP_Error('api_error', $json->error));
		} elseif (!isset($json->data)) {
			return (new WP_Error('api_error', 'no_data'));
		}

		if (!empty($json->data)) {
			return $json->data;
		}

		return false;
	}

    /**
     * Add Focus Page
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function addFocusPage($args = array())
    {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/set-focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function updateFocusPage($args = array())
    {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/update-focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Delete the Focus Page
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function deleteFocusPage($args = array())
    {
        self::$apimethod = 'post'; //post call

        if (isset($args['user_post_id']) && $args['user_post_id'] > 0) {
            $json = json_decode(self::apiCall('api/posts/remove-focus/' . $args['user_post_id']));

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

	        if (!empty($json->data)) {
		        return $json->data;
	        }
        }

        return false;
    }

    /**
     * Get all focus pages and add them in the SQ_Models_Domain_FocusPage object
     * Add the audit data for each focus page
     *
     * @param  array $args
     * @return SQ_Models_Domain_FocusPage|WP_Error|false
     */
    public static function getInspectURL($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/crawl', $args, ['timeout' => 60]));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }
    /****************************************
     * 
     * CONNECTIONS 
     */
    /**
     * Disconnect Google Analytics account
     *
     * @return bool|WP_Error
     */
    public static function revokeGaConnection()
    {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/ga/revoke'));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        //Refresh the checkin on login
        delete_transient('sq_checkin');

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function getGAToken($args = array())
    {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/ga/token', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function getGAProperties($args = array())
    {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/ga/properties', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function saveGAProperties($args = array())
    {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/ga/properties', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Disconnect Google Search Console account
     *
     * @return bool|WP_Error
     */
    public static function revokeGscConnection()
    {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/gsc/revoke'));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        //Refresh the checkin on login
        delete_transient('sq_checkin');

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function syncGSC($args = array())
    {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/gsc/sync/kr', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function getGSCToken($args = array())
    {
        self::$apimethod = 'get'; //post call

        $json = json_decode(self::apiCall('api/gsc/token', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function sendGSCIndex($args = array())
    {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/gsc/index', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /********************
     * 
     * AUDITS 
     *****************************/

    public static function getAuditPages($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/audits', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Get the audit page
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function getAudit($args = array())
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/audits/audit', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    /**
     * Add Audit Page
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function addAuditPage($args = array())
    {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/set-audit', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }

    public static function updateAudit($args = array())
    {
        self::$apimethod = 'post'; //post call

        $json = json_decode(self::apiCall('api/posts/update-audit', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Delete the Audit Page
     *
     * @param  array $args
     * @return bool|WP_Error
     */
    public static function deleteAuditPage($args = array())
    {
        self::$apimethod = 'post'; //post call

        if (isset($args['user_post_id']) && $args['user_post_id'] > 0) {

            $json = json_decode(self::apiCall('api/posts/remove-audit/' . $args['user_post_id']));

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            } elseif (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            if (!empty($json->data)) {
                return $json->data;
            }

        }
        return false;
    }

    /********************
     * 
     * OTHERS 
     *****************************/
    public static function saveSettings($args)
    {
        self::$apimethod = 'post'; //call method

        self::apiCall('api/user/settings', array('settings' => wp_json_encode($args)));
    }

    /**
     * Get the Facebook APi Code
     *
     * @param  $args
     * @return bool|WP_Error
     */
    public static function getFacebookApi($args)
    {
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/tools/facebook', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        } elseif (!isset($json->data)) {
            return (new WP_Error('api_error', 'no_data'));
        }

        if (!empty($json->data)) {
            return $json->data;
        }

        return false;

    }



}
