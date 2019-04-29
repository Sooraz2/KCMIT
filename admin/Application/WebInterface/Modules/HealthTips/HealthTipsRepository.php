<?php
namespace WebInterface\Modules\HealthTips;

use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\HealthTips;

class HealthTipsRepository extends Repo
{
    private $table;

    function __construct()
    {
        $this->table = "health_tips";

        parent::__construct($this->table, "WebInterface\\Models\\HealthTips");
    }

    function FindAll(AjaxGrid $ajaxGrid)
    {
        //global $langConfig;
       // $language = $langConfig->languageClass;


        $sql = "SELECT * FROM {$this->table} ORDER BY $ajaxGrid->sortExpression $ajaxGrid->sortOrder LIMIT $ajaxGrid->offset,$ajaxGrid->rowNumber";

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);

        $sqlQuery = $this->GetDbConnection()->query("SELECT Count(*) FROM {$this->table}");
        $rowCount = $sqlQuery->fetch();

        $list['RowCount'] = $rowCount[0];
        $list['Data'] = $data;
        $list['PageNumber'] = $ajaxGrid->pageNumber;
        $list['Header'] = true;
        $list['titleCol'] = 2;


        return $list;
    }

    public function Update(HealthTips $HealthTips,$HealthTipsLog)
    {
        try {

            $this->UpdateTable($HealthTips, array("ID"), "ID");

            $this->Insert($HealthTipsLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }


    public function Save(HealthTips $HealthTips,$HealthTipsLog)
    {
        try {

            $id = $this->Insert($HealthTips, array("ID"));

            $this->Insert($HealthTipsLog, array("ID"), "login_user_logs");

            return $id;
        } catch (\Exception $e) {

            return false;
        }
    }



    public function SaveHealthTipsLog($HealthTipsLog)
    {
        try {

            $this->Insert($HealthTipsLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }

}