<?php

namespace WebInterface\Modules\HealthNews;

use Infrastructure\SessionVariables;

use WebInterface\Models\HealthNews;
use WebInterface\Models\LoginUserLog;

use Infrastructure\LanguageLog;

use Infrastructure\MessageLog;

use Language\English\Logs;

class HealthNewsLog
{
    public function __construct()
    {

    }

    static function SaveHealthNews(HealthNews $healthNews)
    {
        $loginUserLog = new LoginUserLog();

        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

       $loginUserLog->DateTime = GetCurrentDateTime();


        $loginUserLog->Action = replaceString(LanguageLog::$English->addedHealthNews,
          array(":User" => $_SESSION[SessionVariables::$Username],
            ":Title" => $healthNews->Title
           )
        );


        return $loginUserLog;
    }

    static function UpdateHealthNews(HealthNews $healthNews)
    {
        $loginUserLog = new LoginUserLog();
           $loginUserLog->DateTime = GetCurrentDateTime();
        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

           $loginUserLog->Action = replaceString(LanguageLog::$English->addedHealthNews,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":ID" => $healthNews->ID,
               ":Title" => $healthNews->Title
             )
           );


        return $loginUserLog;
    }

    static function DeleteHealthNews(HealthNews $healthNews)
    {
        $loginUserLog = new LoginUserLog();

           $loginUserLog->DateTime = GetCurrentDateTime();

          $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

           $loginUserLog->Action = replaceString(LanguageLog::$English->deletedHealthNews,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":ID" => $healthNews->ID,
               ":Title" => $healthNews->Title
             )
           );

        return $loginUserLog;
    }

       static function SetStatus(HealthNews $healthNews)
       {
              $loginUserLog = new LoginUserLog();

              $loginUserLog->DateTime = GetCurrentDateTime();

              $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

              $loginUserLog->Action = replaceString(LanguageLog::$English->setStatusHealthNews,
                array(":User" => $_SESSION[SessionVariables::$Username],
                  ":ID" => $healthNews->ID,
                  ":Status" => $healthNews->Status
                )
              );

              return $loginUserLog;
       }

} 