<?php

namespace Shared\Controllers;

use Infrastructure\SessionVariables;
use System\MVC\Controller;


abstract class WebInterfaceControllerAbstract extends Controller
{
    function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION[SessionVariables::$UserID]) || !isset($_SESSION[SessionVariables::$UserType])) {
            Redirect("Login");
        }

//        $this->CheckIfPasswordExpired($_SESSION[SessionVariables::$UserID]);

        $ini_array = parse_ini_file(BASE_PATH . "/config.ini", true);

        /*$PageController= explode("\\",get_called_class());
        $ControllerName=substr($PageController[2],0,strlen($PageController[2])-10);
        if(!$ini_array['Pages'][$ControllerName]==true){
           Redirect("NoAccess");
            exit;
        }*/

    }


}