<?php

namespace WebInterface\Modules\MessageTemplates;

use Infrastructure\ConfirmationDisplay;
use Language\English\Logs;
use Infrastructure\SessionVariables;
use Shared\Controllers\WebInterfaceControllerAbstract;
use Shared\Model\AjaxGrid;
use Shared\Model\LoginUserLog;
use WebInterface\Models\MessageTemplates;
use Infrastructure\PHPFormToken;


class MessageTemplatesController extends WebInterfaceControllerAbstract
{


    private $EnglishLang;
    private $FrenchLang;

    function __construct()
    {
        $this->EnglishLang = 1;
        $this->FrenchLang = 2;

        parent::__construct();

        $this->MessageTemplatesRepository = new MessageTemplatesRepository();

       // $this->UserLog = new LoginUserLogRepository();

        $this->loginUserLog = new LoginUserLog();

        $this->messagesTemplatesValidator = new MessageTemplatesValidator();

        $this->messageTemplatesParameter = new MessageTemplatesParameter();

        $this->FormToken = new PHPFormToken();

    }

    function IndexAction()
    {

        $this->load->View("MessageTemplates/Index");
    }

    function FormAction()
    {
        $this->load->View("MessageTemplates/Form", $this->messageTemplatesParameter->Form());

    }

    function UpdateTemplateAction()
    {

        $confirmation = $this->messagesTemplatesValidator->ValidateMessageTemplatesSubmit($_POST);

        if($this->FormToken->GetFormToken("MessageTemplatesFormToken") == $_POST['MessageTemplatesFormToken']) {

            $this->FormToken->UnsetFormToken("MessageTemplatesFormToken");

        if ($confirmation->MessageType == "Success") {

            if (isset($_POST["id"]) && !empty($_POST["id"])) {

                $message = $this->MessageTemplatesRepository->GetById($_POST["id"], "id");

                $template = new MessageTemplates();

                $template->MapParameters($message);

                $template->template = $_POST["template"];

                $template->message_type = $_POST["message_type"];

                $template->lang = $_POST["lang"];

                $messageTemplatesLog = MessageTemplatesLog::UpdateMessageTemplates($template, $message);

                $status = $this->MessageTemplatesRepository->Update($template, $messageTemplatesLog);

                MessageTemplatesConfirmation::Update($status);

            } else {

                $template = new MessageTemplates();

                $template->MapParameters($_POST);

                $status = $this->MessageTemplatesRepository->Save($template);

                $message = $this->MessageTemplatesRepository->GetById($status, "id");

                $messageTemplatesLog = MessageTemplatesLog::SaveMessageTemplates($template, $message);

                $this->MessageTemplatesRepository->SaveMessageTemplatesLog($messageTemplatesLog);

                MessageTemplatesConfirmation::Save($status);

            }
        } else {

            ConfirmationDisplay::SetConfirmation($confirmation);

        }
    }
        Redirect("MessageTemplates");
        exit;

    }

    function ListAction()
    {
        $ajaxGrid = new AjaxGrid();

        $ajaxGrid->MapParameters($_GET);


        echo json_encode($this->MessageTemplatesRepository->FindAll($ajaxGrid));
    }

    function DeleteAction()
    {

        $template = $this->MessageTemplatesRepository->GetById($_POST["ID"]);

         $messageTemplatesLog =   MessageTemplatesLog::DeleteMessageTemplates($template);

        $status = $this->MessageTemplatesRepository->Delete($_POST["ID"]);
        if($status){

            $this->MessageTemplatesRepository->SaveMessageTemplatesLog($messageTemplatesLog);

        }

        MessageTemplatesConfirmation::Delete($status);

        Redirect("MessageTemplates");
    }
}