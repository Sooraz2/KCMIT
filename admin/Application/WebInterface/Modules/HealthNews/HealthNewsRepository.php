<?php
namespace WebInterface\Modules\HealthNews;

use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\HealthNews;

class HealthNewsRepository extends Repo
{
    private $table;

    function __construct()
    {
        $this->table = "health_news";

        parent::__construct($this->table, "WebInterface\\Models\\HealthNews");
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

    public function Update(HealthNews $healthNews,$healthNewsLog)
    {
        try {

            $this->UpdateTable($healthNews, array("ID"), "ID");

            $this->Insert($healthNewsLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }


    public function Save(HealthNews $healthNews,$healthNewsLog)
    {
        try {

            $id = $this->Insert($healthNews, array("ID"));

            $this->Insert($healthNewsLog, array("ID"), "login_user_logs");

            return $id;
        } catch (\Exception $e) {

            return false;
        }
    }



    public function SaveHealthNewsLog($healthNewsLog)
    {
        try {

            $this->Insert($healthNewsLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }

}