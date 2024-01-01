<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockJorney extends SQ_Classes_BlockController
{

    public $days = false;

    public function init()
    {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('jorney');

        if (!$seojorney = SQ_Classes_Helpers_Tools::getOption('sq_seojourney')) {
            $this->show_view('Blocks/Jorney');
        }else {

            $days = 1;
            $seconds = strtotime(date('Y-m-d')) - strtotime($seojorney);

            if ($seconds > 0) {
                $days = $seconds / (3600 * 24);
                $days = (int)$days + 1;
            }

            $this->days = $days;
            $this->show_view('Blocks/Jorney');
        }
    }

    public function getJourneyDays()
    {
        return $this->days;
    }

    /**
     * 14 days journey action
     */
    public function action()
    {
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            //login action
	        case 'sq_journey_close':

		        if (!SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet')) {
			        return;
		        }

	            SQ_Classes_Helpers_Tools::saveOptions('sq_seojourney_congrats', 0);
	            break;

        }
    }
}
