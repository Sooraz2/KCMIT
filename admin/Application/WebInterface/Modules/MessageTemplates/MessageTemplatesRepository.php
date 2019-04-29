<?php
namespace WebInterface\Modules\MessageTemplates;

use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\MessageTemplates;
use WebInterface\Models\BlackListGroupMsisdn;

class MessageTemplatesRepository extends Repo
{
    private $table;

    function __construct()
    {
        $this->table = "message_templates";

        parent::__construct($this->table, "WebInterface\\Models\\MessageTemplates");
    }

    function FindAll(AjaxGrid $ajaxGrid)
    {
        global $langConfig;
        $language = $langConfig->languageClass;
//dd($language);
        foreach ($language as $key => $value) {
            $value = func_mysql_escape_string($value);
            $language->$key = $value;
        }

        $sql = "SELECT CASE `lang`
                WHEN 1 THEN '$language->English'
                WHEN 2 THEN '$language->Russian'
                WHEN 6 THEN '$language->Uzbek'
                END AS GroupName,
                CASE `message_type`
                WHEN 1 THEN '$language->StandardMessage'
                WHEN 2 THEN '$language->BalanceReceivingError'
                WHEN 3 THEN '$language->TheServiceIsUnavailableForTheNumber'
                WHEN 4 THEN '$language->NoSuitableTeasers' END as `message_type`,
                template, id FROM {$this->table} ORDER BY $ajaxGrid->sortExpression $ajaxGrid->sortOrder LIMIT $ajaxGrid->offset,$ajaxGrid->rowNumber";

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);

        $sqlQuery = $this->GetDbConnection()->query("SELECT Count(*) FROM {$this->table}");
        $rowCount = $sqlQuery->fetch();

        $group = array();
        $group["Others"]=array();
        foreach ($data as $value) {
            if ($value['GroupName'] != null && $value['GroupName'] != "") {
                $group[$value['GroupName']][] = $value;
            } else {
                $group["Others"][] = $value;
            }
        }
        if (count($group["Others"]) > 0) {
            $others = $group["Others"];
            array_shift($group);
            $group["Others"] = $others;
        }else{
            unset($group["Others"]);
        }
        $data = $group;
        $list['RowCount'] = $rowCount[0];
        $list['Data'] = $data;
        $list['PageNumber'] = $ajaxGrid->pageNumber;
        $list['Header'] = true;
        $list['titleCol'] = 2;


        return $list;
    }

    public function Update(MessageTemplates $message_template,$messageTemplatesLog)
    {
        try {

            $this->UpdateTable($message_template, array("id"), "id");

            $this->Insert($messageTemplatesLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }


    public function Save(MessageTemplates $message_template)
    {
        try {

            $id=$this->Insert($message_template, array("id"));

            return $id;
        } catch (\Exception $e) {

            return false;
        }
    }



    public function SaveMessageTemplatesLog($messageTemplatesLog)
    {
        try {

            $this->Insert($messageTemplatesLog, array("ID"), "login_user_logs");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }

}