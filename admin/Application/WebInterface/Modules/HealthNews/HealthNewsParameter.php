<?php

namespace WebInterface\Modules\HealthNews;


use Infrastructure\PHPFormToken;
use WebInterface\Models\HealthNews;


class HealthNewsParameter
{

    function __construct()
    {
        $this->HealthNewsRepo = new HealthNewsRepository();
        $this->FormToken = new PHPFormToken();
    }

    public function Form()
    {
        $healthNews = new HealthNews();

        $saveOrUpdate = "Save";

        if (isset($_GET['ID'])) {

            $saveOrUpdate = "Update";

            $healthNews = $this->HealthNewsRepo->GetById($_GET['ID']);
        }
        $this->FormToken->SetFormToken("HealthNewsFormToken");

        $params["formToken"] = $this->FormToken->GetFormToken("HealthNewsFormToken");

        $params["HealthNews"] = $healthNews;

        $params["saveOrUpdate"] = $saveOrUpdate;

        return $params;
    }

} 