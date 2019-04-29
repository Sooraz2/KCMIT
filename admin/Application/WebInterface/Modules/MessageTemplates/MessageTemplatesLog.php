<?php

namespace WebInterface\Modules\MessageTemplates;

use Infrastructure\SessionVariables;

use WebInterface\Models\LoginUserLog;

use Infrastructure\LanguageLog;

use Infrastructure\MessageLog;

use Language\English\Logs;

class MessageTemplatesLog
{
    public function __construct()
    {

    }

    static function SaveMessageTemplates($template,$message)
    {
        $loginUserLog = new LoginUserLog();

        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

       $loginUserLog->DateTime = GetCurrentDateTime();


        $loginUserLog->Action = replaceString(LanguageLog::$English->addedMessageTemplate,
          array(":User" => $_SESSION[SessionVariables::$Username],
            ":messageTemplateID" => $template->id,
            ":oldMessageTemplate" => $message->template,
            ":oldMessageType" => $message->message_type,
            ":oldLanguage" => $message->lang,
            ":newMessageTemplate" => $template->template,
            ":newMessageType" => $template->message_type,
            ":newLanguage" => $template->lang,
            ":PageName" => MessageLog::$English->MessageTemplates)
        );

           $loginUserLog->ActionFR = replaceString(LanguageLog::$Russian->addedMessageTemplate,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":messageTemplateID" => $template->id,
               ":oldMessageTemplate" => $message->template,
               ":oldMessageType" => $message->message_type,
               ":oldLanguage" => $message->lang,
               ":newMessageTemplate" => $template->template,
               ":newMessageType" => $template->message_type,
               ":newLanguage" => $template->lang,
               ":PageName" => MessageLog::$Russian->MessageTemplates)
           );

        return $loginUserLog;
    }

    static function UpdateMessageTemplates($template,$message)
    {
        $loginUserLog = new LoginUserLog();
           $loginUserLog->DateTime = GetCurrentDateTime();
        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];


        $loginUserLog->Action = replaceString(LanguageLog::$English->updatedMessageTemplate,
            array(":User" => $_SESSION[SessionVariables::$Username],
              ":messageTemplateID" => $template->id,
              ":oldMessageTemplate" => $message->template,
              ":oldMessageType" => $message->message_type,
              ":oldLanguage" => $message->lang,
              ":newMessageTemplate" => $template->template,
              ":newMessageType" => $template->message_type,
              ":newLanguage" => $template->lang,
              ":PageName" => MessageLog::$English->MessageTemplates)
        );

           $loginUserLog->ActionFR = replaceString(LanguageLog::$Russian->updatedMessageTemplate,
             array(":User" => $_SESSION[SessionVariables::$Username],
               ":messageTemplateID" => $template->id,
               ":oldMessageTemplate" => $message->template,
               ":oldMessageType" => $message->message_type,
               ":oldLanguage" => $message->lang,
               ":newMessageTemplate" => $template->template,
               ":newMessageType" => $template->message_type,
               ":newLanguage" => $template->lang,
               ":PageName" => MessageLog::$Russian->MessageTemplates)
           );

        return $loginUserLog;
    }

    static function DeleteMessageTemplates($template)
    {
        $loginUserLog = new LoginUserLog();

           $loginUserLog->DateTime = GetCurrentDateTime();
        $loginUserLog->UserID = $_SESSION[SessionVariables::$UserID];

        $loginUserLog->Action = replaceString(LanguageLog::$English->deletedMessageTemplate,

          array(":User" => $_SESSION[SessionVariables::$Username],
            ":messageTemplateID" => $template->id,
            ":oldMessageTemplate" => $template->template,
            ":oldMessageType" => $template->message_type,
            ":oldLanguage"=>$template->lang,
            ":PageName" => MessageLog::$English->MessageTemplates)
        );

           $loginUserLog->ActionFR = replaceString(LanguageLog::$Russian->deletedMessageTemplate,

             array(":User" => $_SESSION[SessionVariables::$Username],
               ":messageTemplateID" => $template->id,
               ":oldMessageTemplate" => $template->template,
               ":oldMessageType" => $template->message_type,
               ":oldLanguage"=>$template->lang,
               ":PageName" => MessageLog::$Russian->MessageTemplates)
           );


        return $loginUserLog;
    }

} 