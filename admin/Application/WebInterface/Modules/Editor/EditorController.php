<?php

namespace WebInterface\Modules\Editor;

use Infrastructure\ConfirmationDisplay;
use Language\English\Logs;
use Infrastructure\SessionVariables;
use Shared\Controllers\WebInterfaceControllerAbstract;
use Shared\Model\AjaxGrid;
use Shared\Model\LoginUserLog;
use WebInterface\Models\HealthTips;
use Infrastructure\PHPFormToken;


class EditorController extends WebInterfaceControllerAbstract
{


    function __construct()
    {
        parent::__construct();

      //  $this->MessageTemplatesRepository = new HealthTipsRepository();

       // $this->UserLog = new LoginUserLogRepository();

        $this->loginUserLog = new LoginUserLog();

        //$this->messagesTemplatesValidator = new HealthTipsValidator();

       // $this->messageTemplatesParameter = new HealthTipsParameter();

        $this->FormToken = new PHPFormToken();

    }

    function IndexAction()
    {

        $this->load->View("Editor/Index");
    }

    function ckeditorAction(){


    }

    function ckfinderAction(){

    }


}