<?php

namespace WebInterface\Modules\HealthTips;


use Infrastructure\PHPFormToken;
use WebInterface\Models\HealthTips;


class HealthTipsParameter
{

    function __construct()
    {
        $this->HealthTipsRepo = new HealthTipsRepository();
        $this->FormToken = new PHPFormToken();
    }

    public function Form()
    {
        $HealthTips = new HealthTips();

        $saveOrUpdate = "Save";

        if (isset($_GET['ID'])) {

            $saveOrUpdate = "Update";

            $HealthTips = $this->HealthTipsRepo->GetById($_GET['ID']);
        }
        $this->FormToken->SetFormToken("HealthTipsFormToken");

        $params["formToken"] = $this->FormToken->GetFormToken("HealthTipsFormToken");

        $params["HealthTips"] = $HealthTips;

        $params["saveOrUpdate"] = $saveOrUpdate;

        return $params;
    }

} 