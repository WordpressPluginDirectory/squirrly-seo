<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Show on the WordPress Dashboard
 * Class SQ_Controllers_Dashboard
 */
class SQ_Controllers_Dashboard extends SQ_Classes_FrontController
{


    public function dashboard()
    {

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('dashboard');
        if (is_rtl()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        }

        $this->show_view('Blocks/Dashboard');
    }

    public function action()
    {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
	        case 'sq_ajaxcheckseo':

	            SQ_Classes_Helpers_Tools::setHeader('json');

		        if (!SQ_Classes_Helpers_Tools::userCan('sq_manage_settings')) {
			        $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", 'squirrly-seo'), 'error');
			        echo wp_json_encode($response);
			        exit();
		        }

	            //Check all the SEO
	            //Process all the tasks and save the report
	            SQ_Classes_ObjController::getClass('SQ_Models_CheckSeo')->checkSEO();

	            echo wp_json_encode(array('data' => $this->get_view('Blocks/Dashboard')));
	            exit();
        }
    }
}
