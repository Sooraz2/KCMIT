<?php

namespace WebInterface\Modules\HealthTips;

use Infrastructure\SessionVariables;

use WebInterface\Models\HealthTips;
use WebInterface\Models\LoginUserLog;

use Infrastructure\LanguageLog;

use Infrastructure\MessageLog;

use Language\English\Logs;

class HealthTipsLog
{
    public function __construct()
    {

    }

    static function SaveHealthTips(HealthTips $HealthTips)
    {
        $loginUserLog = new LoginUserLog();

        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

       $loginUserLog->DateTime = GetCurrentDateTime();


        $loginUserLog->Action = replaceString(LanguageLog::$English->addedHealthTips,
          array(":User" => $_SESSION[SessionVariables::$Username],
            ":Title" => $HealthTips->Title
           )
        );


        return $loginUserLog;
    }

    static function UpdateHealthTips(HealthTips $HealthTips)
    {
        $loginUserLog = new LoginUserLog();
           $loginUserLog->DateTime = GetCurrentDateTime();
        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

           $loginUserLog->Action = replaceString(LanguageLog::$English->addedHealthTips,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":ID" => $HealthTips->ID,
               ":Title" => $HealthTips->Title
             )
           );


        return $loginUserLog;
    }

    static function DeleteHealthTips(HealthTips $HealthTips)
    {
        $loginUserLog = new LoginUserLog();

           $loginUserLog->DateTime = GetCurrentDateTime();

          $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

           $loginUserLog->Action = replaceString(LanguageLog::$English->deletedHealthTips,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":ID" => $HealthTips->ID,
               ":Title" => $HealthTips->Title
             )
           );

        return $loginUserLog;
    }

       static function SetStatus(HealthTips $HealthTips)
       {
              $loginUserLog = new LoginUserLog();

              $loginUserLog->DateTime = GetCurrentDateTime();

              $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

              $loginUserLog->Action = replaceString(LanguageLog::$English->setStatusHealthTips,
                array(":User" => $_SESSION[SessionVariables::$Username],
                  ":ID" => $HealthTips->ID,
                  ":Status" => $HealthTips->Status
                )
              );

              return $loginUserLog;
       }

} 