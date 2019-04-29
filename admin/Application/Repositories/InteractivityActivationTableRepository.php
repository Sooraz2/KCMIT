<?php

namespace Repositories;


use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\InteractivityActivation;

class InteractivityActivationTableRepository extends Repo
{
    private $table;

    function __construct()
    {
        $this->table = "activation_links";

        parent::__construct($this->table, "WebInterface\\Models\\InteractivityActivation");
    }

    public function Save(InteractivityActivation $interactivity)
    {
        try {
            $id=$this->Insert($interactivity, array("id"));

            return $id;
        } catch (\Exception $e) {

            return false;
        }

    }

    public function Update(InteractivityActivation $interactivity)
    {
        try {

           $this->UpdateTable($interactivity, array("id"), "id");

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }

    public function GetByName($service,$id=null)
    {
        $sql = "SELECT * from { $this->table}
                where service = '$service'";
        if ($id != '' && $id > 0 && $id != null) {
            $sql .= " AND id<>$id";
        }
        $sql .= " limit 0,1";
        $model = new InteractivityActivation();
        $sqlQuery = $this->GetDbConnection()->query($sql);

        while ($row = $sqlQuery->fetch(\PDO::FETCH_ASSOC)) {
            $model->MapParameters($row);
        }
        return $model;
    }

    public function UpdateSingleField($field, $fieldValue, $id)
    {
        $updateSql = "UPDATE `{$this->table}` SET $field = :fieldValue where id = :id";
        $sqlQuery = $this->GetDbConnection()->prepare($updateSql);
        $sqlQuery->bindValue(":id", $id);
        $sqlQuery->bindValue(":fieldValue", $fieldValue);
        $sqlQuery->execute();

        $sql = "SELECT $field from `{$this->table}` where id =$id";
        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);
        return $data[0][$field];


    }
} 