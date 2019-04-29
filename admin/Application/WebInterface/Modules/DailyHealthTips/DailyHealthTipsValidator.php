<?php
/**
 * Created by PhpStorm.
 * User: Sajesh
 * Date: 12/21/2015
 * Time: 3:44 PM
 */

namespace WebInterface\Modules\DailyHealthTips;


use Libraries\Validation\ConfirmationMessage;
use Libraries\Validation\Validation;

class DailyHealthTipsValidator
{
    private $validator;

    public function __construct(){
        $this->validator = new Validation();
    }

    public function ValidateDailyHealthTipsSubmit($data){
        $validation = $this->validator
                            ->SetValidationArray($data)
                            ->ValidationRule("Title", array("required"))
                            ->Validate();

        $ConfirmationMessage = new ConfirmationMessage();
        $ConfirmationMessage->Message = $validation->messages;
        $ConfirmationMessage->MessageType = $validation->status ? "Success" : "Failed";

        $this->validator->ClearValidator();
        return $ConfirmationMessage;
    }
}