<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Debug
{

    /**
     * 
     *
     * @var array 
     */
    private static $debug;

    /**
     * Check if debug is called
     */
    public static function checkDebug()
    {
        //if debug is called
        if (isset($_GET['sq_debug']) && $_GET['sq_debug'] === 'on' && SQ_DEBUG) {

            defined('WP_DEBUG_DISPLAY') || define('WP_DEBUG_DISPLAY', true);

            if (function_exists('register_shutdown_function')) {
                register_shutdown_function(array(new SQ_Debug(), 'showDebug'));
            }
            
            echo '<script>var SQ_DEBUG = true;</script>';
        }
    }

    /**
     * Store the debug for a later view
     *
     * @return bool|void
     */
    public static function dump()
    {
        if (isset($_GET['sq_debug']) && $_GET['sq_debug'] === 'on' && SQ_DEBUG) {

            $output = '';
            $callee = array('file' => '', 'line' => '');
            if (function_exists('func_get_args')) {
                $arguments = func_get_args();
                $total_arguments = count($arguments);
            } else
                $arguments = array();


            $run_time = number_format(microtime(true) - SQ_REQUEST_TIME, 3);
            if (function_exists('debug_backtrace'))
                list($callee) = debug_backtrace();

            $output .= '<fieldset style="background: #FFFFFF; border: 1px #CCCCCC solid; padding: 5px; font-size: 9pt; margin: 0;">';
            $output .= '<legend style="background: #EEEEEE; padding: 2px; font-size: 8pt;">' . $callee['file'] . ' Time: ' . $run_time . ' @ line: ' . $callee['line']
                . '</legend><pre style="margin: 0; font-size: 8pt; text-align: left;">';

            $i = 0;
            foreach ($arguments as $argument) {
                if (count($arguments) > 1)
                    $output .= "\n" . '<strong>#' . (++$i) . ' of ' . $total_arguments . '</strong>: ';

                // if argument is boolean, false value does not display, so ...
                if (is_bool($argument))
                    $argument = ($argument) ? 'TRUE' : 'FALSE';
                else
                    if (is_object($argument) && function_exists('array_reverse') && function_exists('class_parents'))
                        $output .= implode("\n" . '|' . "\n", array_reverse(class_parents($argument))) . "\n" . '|' . "\n";

                $output .= htmlspecialchars(print_r($argument, true))
                    . ((is_object($argument) && function_exists('spl_object_hash')) ? spl_object_hash($argument) : '');
            }
            $output .= "</pre>";
            $output .= "</fieldset>";

            self::$debug[] = $output;
        }
    }

    /**
     * Show the debug dump
     */
    public static function showDebug()
    {
        SQ_Classes_Helpers_Tools::setHeader('html');
        error_get_last();

        if(is_array(self::$debug) && !empty(self::$debug)) {
            echo "Debug result: <br />" . '<div id="wpcontent">' . '<br />' . wp_kses_post(implode('<br />', self::$debug)) . '<div>';
        }
    }

}

defined('SQ_DEBUG') || define('SQ_DEBUG', false);
SQ_Debug::checkDebug();
