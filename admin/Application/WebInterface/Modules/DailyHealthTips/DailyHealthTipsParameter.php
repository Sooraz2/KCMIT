<?php

namespace WebInterface\Modules\DailyHealthTips;


use Infrastructure\PHPFormToken;
use WebInterface\Models\DailyHealthTips;



class DailyHealthTipsParameter
{

    function __construct()
    {
        $this->DailyHealthTipsRepo = new DailyHealthTipsRepository();
        $this->FormToken = new PHPFormToken();
    }

    public function Form()
    {
        $DailyHealthTips = new DailyHealthTips();

        $saveOrUpdate = "Save";

        if (isset($_GET['ID'])) {

            $saveOrUpdate = "Update";

            $DailyHealthTips = $this->DailyHealthTipsRepo->GetById($_GET['ID']);
        }
        $this->FormToken->SetFormToken("DailyHealthTipsFormToken");

        $params["formToken"] = $this->FormToken->GetFormToken("DailyHealthTipsFormToken");

        $params["DailyHealthTips"] = $DailyHealthTips;

        $params["saveOrUpdate"] = $saveOrUpdate;

        return $params;
    }

} 