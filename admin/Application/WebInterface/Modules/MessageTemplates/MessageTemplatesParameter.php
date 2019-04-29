<?php

namespace WebInterface\Modules\MessageTemplates;


use Infrastructure\PHPFormToken;
use WebInterface\Models\MessageTemplates;


class MessageTemplatesParameter
{

    function __construct()
    {
        $this->MessageTemplatesRepository = new MessageTemplatesRepository();
        $this->FormToken = new PHPFormToken();
    }

    public function Form()
    {
        $template = new MessageTemplates();

        $saveOrUpdate = "Save";

        if (isset($_GET['ID'])) {
            $saveOrUpdate = "Update";
            $template = $this->MessageTemplatesRepository->GetById($_GET['ID']);
        }
        $this->FormToken->SetFormToken("MessageTemplatesFormToken");
        $params["formToken"] = $this->FormToken->GetFormToken("MessageTemplatesFormToken");

        $params["MessageTemplates"] = $template;
        $params["saveOrUpdate"] = $saveOrUpdate;

        return $params;
    }

} 