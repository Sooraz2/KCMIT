<?php

namespace Repositories;


use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\Slug;

class SlugRepository extends Repo
{
    private $table;

    function __construct()
    {
        $this->table = "slug";

        parent::__construct($this->table, "WebInterface\\Models\\Slug");
    }

    public function Save(Slug $slug)
    {
        try {
            $id = $this->Insert($slug, array("ID"));

            return $id;
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


        public function CheckSlug($slug,$id=null)
        {
            $sql = "SELECT * from {$this->table}

                where Slug = '$slug'";

            if ($id != '' && $id > 0 && $id != null) {
                $sql .= " AND ContentID <> '$id' ";
            }


            $sqlQuery = $this->GetDbConnection()->query($sql);

            return $sqlQuery->rowCount();
        }



    public function Update(Slug $slug)
    {

        $sql = "UPDATE  {$this->table} SET Slug = '$slug->Slug' WHERE
           ContentID = $slug->ContentID AND Content = '$slug->Content'";

        $sqlQuery =  $this->GetDbConnection()->query($sql);

        $sqlQuery->execute();

        return true;
    }




    public function DeleteSlug(Slug $slug)
    {

        $sql = "DELETE FROM   {$this->table}  WHERE
           ContentID = $slug->ContentID AND Content = '$slug->Content'";

        $sqlQuery =  $this->GetDbConnection()->query($sql);

        $sqlQuery->execute();

        return true;
    }


} 