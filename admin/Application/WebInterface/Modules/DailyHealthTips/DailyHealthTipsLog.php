<?php

namespace WebInterface\Modules\DailyHealthTips;

use Infrastructure\SessionVariables;

use WebInterface\Models\DailyHealthTips;
use WebInterface\Models\LoginUserLog;

use Infrastructure\LanguageLog;

use Infrastructure\MessageLog;

use Language\English\Logs;

class DailyHealthTipsLog
{
    public function __construct()
    {

    }

    static function SaveDailyHealthTips(DailyHealthTips $DailyHealthTips)
    {
        $loginUserLog = new LoginUserLog();

        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

       $loginUserLog->DateTime = GetCurrentDateTime();


        $loginUserLog->Action = replaceString(LanguageLog::$English->addedDailyHealthTips,
          array(":User" => $_SESSION[SessionVariables::$Username],
            ":Title" => $DailyHealthTips->Title
           )
        );


        return $loginUserLog;
    }

    static function UpdateDailyHealthTips(DailyHealthTips $DailyHealthTips)
    {
        $loginUserLog = new LoginUserLog();
           $loginUserLog->DateTime = GetCurrentDateTime();
        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

           $loginUserLog->Action = replaceString(LanguageLog::$English->addedDailyHealthTips,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":ID" => $DailyHealthTips->ID,
               ":Title" => $DailyHealthTips->Title
             )
           );


        return $loginUserLog;
    }

    static function DeleteDailyHealthTips(DailyHealthTips $DailyHealthTips)
    {
        $loginUserLog = new LoginUserLog();

           $loginUserLog->DateTime = GetCurrentDateTime();

          $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

           $loginUserLog->Action = replaceString(LanguageLog::$English->deletedDailyHealthTips,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":ID" => $DailyHealthTips->ID,
               ":Title" => $DailyHealthTips->Title
             )
           );

        return $loginUserLog;
    }

       static function SetStatus(DailyHealthTips $DailyHealthTips)
       {
              $loginUserLog = new LoginUserLog();

              $loginUserLog->DateTime = GetCurrentDateTime();

              $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

              $loginUserLog->Action = replaceString(LanguageLog::$English->setStatusDailyHealthTips,
                array(":User" => $_SESSION[SessionVariables::$Username],
                  ":ID" => $DailyHealthTips->ID,
                  ":Status" => $DailyHealthTips->Status
                )
              );

              return $loginUserLog;
       }

} 