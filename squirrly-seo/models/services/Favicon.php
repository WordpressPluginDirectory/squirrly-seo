<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Models_Services_Favicon extends SQ_Models_Abstract_Seo
{

    public function __construct()
    {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            add_filter('sq_favicon', array($this, 'generateFavicon'));
            add_filter('sq_favicon', array($this, 'packFavicon'), 99);
        } else {
            add_filter('sq_favicon', array($this, 'returnFalse'));
        }
    }

    public function generateFavicon($favicons = array())
    {
        $rnd = '';
	    $favicons = array();
	    $path = parse_url(get_option( 'home' ), PHP_URL_PATH);

        if (SQ_Classes_Helpers_Tools::userCan('sq_manage_settings') && function_exists('is_user_logged_in') && is_user_logged_in()) {
            $rnd = '?' . substr(md5(SQ_Classes_Helpers_Tools::getOption('favicon')), 0 , 5);
        }

        if (SQ_Classes_Helpers_Tools::getOption('favicon') <> '' && file_exists(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon'))) {
            if (!get_option('permalink_structure')) {
                $favicon = $path . '/index.php?sq_get=favicon';
                $path . '/index.php?sq_get=touchicon';
            } else {
                $favicon = $path . '/favicon.ico' . $rnd;
                $path . '/touch-icon.png' . $rnd;
            }

            $favicons['shortcut icon'] = $favicon;

            if(SQ_Classes_Helpers_Tools::getOption('sq_favicon_apple')) {
                $appleSizes = preg_split('/[,]+/', _SQ_MOBILE_ICON_SIZES);
                foreach ($appleSizes as $size) {
                    if (!get_option('permalink_structure')) {
                        $favicon = $path . '/index.php?sq_get=touchicon&sq_size=' . $size;
                    } else {
                        $favicon = $path . '/touch-icon' . $size . '.png' . $rnd;
                    }
					if($size == end($appleSizes)){
						$favicons['icon'][$size] = $favicon;
					}
	                $favicons['apple-touch-icon'][$size] = $favicon;

                }
            }
        } else {
            if (file_exists(ABSPATH . 'favicon.ico')) {
                $favicons['icon'] = $path . '/favicon.ico';
            }
        }

        return $favicons;
    }

    public function packFavicon($favicons = array())
    {
        $allfavicons = array();
        if (!empty($favicons)) {
            foreach ($favicons as $key => $favicon) {
	            if (!is_array($favicon)) {

					$mime = 'image/x-icon';
		            $allfavicons[] = sprintf( '<link href="%s" rel="%s" type="%s" />', $favicon, $key, $mime );

                } elseif (!empty($favicon)) {
                    foreach ($favicon as $size => $value) {
	                    $mime = 'image/png';
	                    $allfavicons[] = sprintf('<link href="%s" rel="%s" type="%s" sizes="%s" />', $value, $key, $mime, $size . 'x' . $size);
                    }
                }
            }

            return "\n" . join("\n", array_values($allfavicons));
        }

        return false;
    }

}
