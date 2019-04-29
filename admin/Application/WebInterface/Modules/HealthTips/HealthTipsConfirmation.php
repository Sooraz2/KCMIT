<?php

namespace WebInterface\Modules\HealthTips;

use Infrastructure\ConfirmationDisplay;
use Libraries\Validation\ConfirmationMessage;

class HealthTipsConfirmation
{


    public static function Save($status)
    {
        $confirmationMessage = new ConfirmationMessage();

        $confirmationMessage->Message = $status ? $confirmationMessage->language->SuccessfullySaved : $confirmationMessage->language->FailedSaving;

        $confirmationMessage->MessageType = $status ? "Success" : "Failed";

        ConfirmationDisplay::SetConfirmation($confirmationMessage);
    }

    public static function Update($status)
    {
        $confirmationMessage = new ConfirmationMessage();

        $confirmationMessage->Message = $status ? $confirmationMessage->language->SuccessfullyUpdated : $confirmationMessage->language->FailedUpdating;

        $confirmationMessage->MessageType = $status ? "Success" : "Failed";

        ConfirmationDisplay::SetConfirmation($confirmationMessage);
    }

    public static function Delete($status)
    {
        $confirmationMessage = new ConfirmationMessage();

        $confirmationMessage->Message =  $status ? $confirmationMessage->language->SuccessfullyDeleted : $confirmationMessage->language->FailedDeleting;

        $confirmationMessage->MessageType = $status ? "Success" : "Failed";

        ConfirmationDisplay::SetConfirmation($confirmationMessage);
    }

} 