<?php
namespace WebInterface\Modules\DailyHealthTips;

use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\DailyHealthTips;

class DailyHealthTipsRepository extends Repo
{
    private $table;

    function __construct()
    {
        $this->table = "daily_health_tips";

        parent::__construct($this->table, "WebInterface\\Models\\DailyHealthTips");
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

    public function Update(DailyHealthTips $DailyHealthTips,$DailyHealthTipsLog)
    {
        try {

            $this->UpdateTable($DailyHealthTips, array("ID"), "ID");

            $this->Insert($DailyHealthTipsLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }


    public function Save(DailyHealthTips $DailyHealthTips,$DailyHealthTipsLog)
    {
        try {

            $id = $this->Insert($DailyHealthTips, array("ID"));

            $this->Insert($DailyHealthTipsLog, array("ID"), "login_user_logs");

            return $id;
        } catch (\Exception $e) {

            return false;
        }
    }



    public function SaveDailyHealthTipsLog($DailyHealthTipsLog)
    {
        try {

            $this->Insert($DailyHealthTipsLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }

}