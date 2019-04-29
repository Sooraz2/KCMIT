<?php
/**
 * Created by PhpStorm.
 * User: Anup
 * Date: 12/12/2015
 * Time: 10:21 AM
 */
namespace WebInterface\Modules\TeaserManagement;


use Repositories\MessageCriterionTableRepository;
use Shared\Model\AjaxGrid;
use System\Repositories\Repo;
use WebInterface\Models\MessageCriterion;
use WebInterface\Models\MessagePeriod;
use WebInterface\Models\Teaser;

class TeaserManagementRepository extends Repo{

    private $table;

    private $refrenceList;

    function __construct()
    {
        $this->table = "messages_message";

        parent::__construct($this->table, "WebInterface\\Models\\Teaser");

    }

    function CloneTeaser($id)
    {
        try {
            $sql = "INSERT INTO messages_message (text,stamp,counter,is_active,is_deleted,chars,lang,is_perm_deleted,is_interactiv,activation_code,service,is_high_priority,is_whitelist)
                    SELECT text,stamp,counter,0,is_deleted,chars,lang,is_perm_deleted,is_interactiv,activation_code,service,is_high_priority,is_whitelist
                    FROM messages_message WHERE id=:id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            $messageId = $this->dbConnection->lastInsertId();

            /*$sql = "INSERT INTO messages_periods (message_id,start,end) SELECT $messageId, start,end FROM messages_periods WHERE message_id = :id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));*/

            $sql = "INSERT INTO messages_criterion (message_id, criterion_type_id, criterion_id) SELECT $messageId, criterion_type_id, criterion_id FROM messages_criterion WHERE message_id = :id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            $sql = "INSERT INTO criterion_roaming (TeaserID, Value) SELECT $messageId, Value FROM criterion_roaming WHERE `TeaserID`=:id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function SaveAdvance(Teaser $teaser, $messagePeriods, $messageCriterionList, $criterionRoaming = null)
    {
        $this->dbConnection->beginTransaction();

        try {

            if (count($messagePeriods) > 0) {
                $teaser->is_active = 1;
            } else {
                $teaser->is_active = 0;
            }

            $this->UpdateTable($teaser, array("id"), "id");

            $this->dbConnection->query("DELETE FROM messages_periods where message_id={$teaser->id}");



            if (count($messagePeriods) > 0) {

                foreach ($messagePeriods as $messagePeriod) {
                    $this->Insert($messagePeriod, array('id'), 'messages_periods');
                }
            }

            $this->dbConnection->query("DELETE FROM messages_criterion where message_id={$teaser->id}");

            if (count($messageCriterionList) > 0) {

                foreach ($messageCriterionList as $messageCriterion) {

                    if ($messageCriterion->criterion_id != 0) {

                        $this->Insert($messageCriterion, array('id'), 'messages_criterion');
                    }
                }
            }

//            $this->dbConnection->query("DELETE FROM criterion_roaming where TeaserID={$teaser->id}");

            //$this->Insert($criterionRoaming, array('ID'), 'criterion_roaming');

            $this->dbConnection->commit();



            $this->dbConnection->errorInfo();

            return true;
        } catch (\Exception $e) {
            $this->dbConnection->rollBack();
            $this->dbConnection->errorInfo();
            return false;
        }
    }

    function UpdateStatus($teaser_id, $status)
    {

        $this->GetDbConnection()->beginTransaction();
        try {

            $this->GetDbConnection()->query("UPDATE {$this->table} SET is_active=$status WHERE id=$teaser_id");

            $this->GetDbConnection()->commit();
            return true;
        } catch (\Exception $e) {
            $this->GetDbConnection()->rollBack();
            return false;
        }
    }

    function UpdatePriority($teaser_id, $priority)
    {
        $this->GetDbConnection()->beginTransaction();
        try {

            if ($priority == 0) {
                $this->GetDbConnection()->query("UPDATE {$this->table} SET is_high_priority=NULL WHERE id=$teaser_id");
            } else {
                $this->GetDbConnection()->query("UPDATE {$this->table} SET is_high_priority=$priority WHERE id=$teaser_id");
            }


            $this->GetDbConnection()->commit();
            return true;
        } catch (\Exception $e) {
            $this->GetDbConnection()->rollBack();
            return false;
        }
    }

    function FindAll(AjaxGrid $ajaxGrid)
    {
        extract($_GET);
        $condition = "WHERE 1 = 1 AND is_deleted=0 AND is_history=0";
        if (isset($search) && !empty($search) and $search = trim($search)) {
            $condition .= " AND (`text` LIKE '%$search%'  OR `id`= '$search')";
        }

        $criteriaScript = $this->GetCriteriaScript();

        $sql = <<<SQL

        SELECT *,CHAR_LENGTH (text) `NumberOfSymbols`,
        CASE
            WHEN
            CURRENT_TIMESTAMP > (SELECT MAX(`end`) FROM `messages_periods` WHERE message_id=messageOut.`id`)
            THEN 'Finished'
            ELSE 'Ongoing'
        END AS PublicationStatus, $criteriaScript,
        CASE WHEN messageOut.stamp='0000-00-00 00:00:00'
        THEN '1'
        ELSE '0'
        END AS DefaultTeaser

        FROM messages_message AS messageOut $condition ORDER BY DefaultTeaser DESC,

SQL;

        if ($ajaxGrid->advanceSorting == null) {
            $sql .= " $ajaxGrid->sortExpression $ajaxGrid->sortOrder ";
        } else {
            $sql .= "{$ajaxGrid->advanceSorting}";
        }

        $sql .= " LIMIT $ajaxGrid->offset,$ajaxGrid->rowNumber";

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);

        $sqlQuery = $this->GetDbConnection()->query("SELECT Count(*) FROM {$this->table} $condition");

        $rowCount = $sqlQuery->fetch();

        $list['RowCount'] = $rowCount[0];
        $list['Data'] = $data;
        $list['PageNumber'] = $ajaxGrid->pageNumber;
        $list['Header'] = true;

        return $list;
    }

    function GetPlannedTimesByMessageID($messageId)
    {
        $sql = "SELECT * FROM `messages_periods` WHERE `message_id`=:id";
        $sth = $this->dbConnection->prepare($sql);
        $sth->execute(array(":id" => $messageId));
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }


    function GetCriterionByTypeAndMessageID($criterionType, $messageId)
    {
        $oMessageCriterionType = new \ReflectionClass('Infrastructure\MessageCriterionType');

        $criterionTypeId = $oMessageCriterionType->getConstant($criterionType);

        $MessageCriterionType = array("TimeCriteria" => "criterion_time",
            "SubBalance" => "criterion_balance",
            "ValidTill" => "criterion_valid",
            "SubRegion" => "criterion_region",
            "MsisdnPrefix" => "criterion_dfn",
            "TariffPlan" => "criterion_packet",
            "LastRecharge" => "last_recharge",
            "PaidActions" => "paid_actions",
            "RoamingCriteria" => "criterion_roaming",
            "USSDShortNumbers" => "criterion_ussd_short_number",
            "OptionActivationCheck" => "activation_links",
            'BonusesBalance'=>"bonuses_balance",
            'SubList'=>"criterion_subscribers_group",
        );

        $sql = "SELECT t.*,'$criterionType' as `CriterionType` FROM  `messages_criterion` as mc
                INNER JOIN `{$MessageCriterionType["$criterionType"]}` t ON mc.criterion_id = t.id
                WHERE mc.`criterion_type_id`=:criterionTypeId and mc.message_id= :messageId";

        $sth = $this->GetDbConnection()->prepare($sql);
        $sth->execute(array(":criterionTypeId" => $criterionTypeId,
            ":messageId" => $messageId
        ));
        $res = $sth->fetchAll(\PDO::FETCH_ASSOC);

        $col = array();
        foreach ($res as $resField) {
            array_walk($resField, function (&$item, $key) {
                $item = is_null($item) ? "null : " . $key : $item;
            });
            $arr = array_flip($resField);
            array_walk($arr, function (&$item) {
                global $langConfig;

                $item = $langConfig->languageClass->$item;
            });
            $newArr = array_flip($arr);
            array_push($col, $newArr);
        }

        return $col;
    }


    function FindAllActiveTeaser(AjaxGrid $ajaxGrid)
    {
        extract($_GET);
        $condition = "WHERE 1 = 1 AND messageFinal.is_active=1 AND messageFinal.is_history=0 AND messageFinal.is_deleted=0 AND ((messageFinal.stamp!='0000-00-00 00:00:00' AND CURRENT_DATE BETWEEN  CAST(messagePeriod.start AS Date) AND CAST(messagePeriod.end AS Date) ) OR messageFinal.stamp='0000-00-00 00:00:00') ";

        if (isset($search) && !empty($search) and $search = trim($search)) {
            $condition .= " AND (`text` LIKE '%$search%' OR messageFinal.id= '$search')";
        }

        $criteriaScript = $this->GetCriteriaScript();

        $base_url = BASE_URL;
        global $langConfig;
        $language = $langConfig->languageClass;

        foreach ($language as $key => $value) {
            $value = func_mysql_escape_string($value);
            $language->$key = $value;
        }

        $sql = <<<SQL

         SELECT messageFinal.id AS TeaserId,messageFinal.*,

         CASE WHEN LanguageNumber=1
                      THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->EnglishLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_en.png"/></button>'
                      WHEN LanguageNumber=2
                      THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->RussianLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_ru.png"/></button>'
                      WHEN LanguageNumber=3
                      THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->GeorgianLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_ge.png"/></button>'
                      WHEN LanguageNumber=4
                      THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->FrenchLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_fr.png"/></button>'
                      ELSE ''
                END AS `Language`
         FROM  (SELECT *,$criteriaScript,CHAR_LENGTH (TEXT) `NumberOfSymbols`, CASE
                    WHEN
                    CURRENT_TIMESTAMP > (SELECT MAX(`end`) FROM `messages_periods` WHERE message_id=messageOut.`id`)
                    THEN 'Finished'
                    ELSE 'Ongoing'
                END AS PublicationStatus,
                CASE WHEN messageOut.stamp='0000-00-00 00:00:00'
                THEN '1'
                ELSE '0'
                END AS DefaultTeaser, CASE WHEN stamp='0000-00-00 00:00:00' THEN lang

        ELSE

        (SELECT  `criterion_id` FROM `messages_criterion` WHERE
         `criterion_type_id`=10 AND messageOut.id=message_id) END AS
         `LanguageNumber`

         FROM `messages_message` messageOut ) messageFinal
        Left JOIN  `messages_periods` messagePeriod ON messagePeriod.message_id=messageFinal.id
        $condition GROUP BY messageFinal.id ORDER BY DefaultTeaser DESC ,

SQL;
        if ($ajaxGrid->advanceSorting == null) {
            $sql .= " $ajaxGrid->sortExpression $ajaxGrid->sortOrder ";
        } else {
            $sql .= "{$ajaxGrid->advanceSorting}";
        }

        $sql .= " ,text ASC ";

        $sql .= " LIMIT $ajaxGrid->offset,$ajaxGrid->rowNumber";

//        echo ($sql); exit;

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);

        $sqlQuery = $this->GetDbConnection()->query("SELECT Count(*) FROM {$this->table} as messageFinal LEFT JOIN  `messages_periods` messagePeriod ON messagePeriod.message_id=messageFinal.id $condition");

        $rowCount = $sqlQuery->fetch();

        $list['RowCount'] = $rowCount[0];
        $list['Data'] = $data;
        $list['PageNumber'] = $ajaxGrid->pageNumber;
        $list['Header'] = true;

        return $list;
    }

    public function GetTeaserStatus($teaserId)
    {
        $sql = "SELECT is_active FROM {$this->table} WHERE id=$teaserId";

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetch();

        return $data[0];
    }

    public function CheckIfMessagePeriodExist($teaser)
    {
        $sql = "SELECT Count(*) FROM messages_periods WHERE message_id=$teaser";

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetch();

        return $data[0] > 0 ? true : false;
    }

    function GetCriteriaScript()
    {
        $base_url = BASE_URL;
        global $langConfig;
        $language = $langConfig->languageClass;

        foreach ($language as $key => $value) {
            $value = func_mysql_escape_string($value);
            $language->$key = $value;
        }

        $sql = <<<SQL
      CASE WHEN chars=1
              THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->EnglishLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_en.png"/></button>'
              WHEN chars=2
              THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->RussianLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_ru.png"/></button>'
              WHEN chars=3
              THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->FrenchLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_fr.png"/></button>'
              WHEN chars=4
              THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->GeorgianLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_ge.png"/></button>'
              WHEN chars=5
              THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="LanguageCriteria" title="$language->TajikLanguageCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_language_tj.png"/></button>'
              ELSE ''
        END AS LanguageCriteria,
        CASE WHEN (SELECT Count(id) from `messages_criterion` WHERE `criterion_type_id`=1 and message_id=messageOut.id)>0
             THEN '<button class="btn btn-circle nobtndesign onhovertooltip" data-criterion-type="TimeCriteria" title="$language->TimeCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_time.png"/></span></button>'
             ELSE ''
        END AS TimeCriteria,
        CASE WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=3 AND message_id=messageOut.id)>0
             THEN '<button class="btn btn-circle nobtndesign onhovertooltip" data-criterion-type="ValidTill" title="$language->BalanceValidityCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_valid_till.png"/></button>'
             ELSE ''
        END AS ValidTill,
        CASE WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=2 AND message_id=messageOut.id)>0
             THEN '<button class="btn btn-circle nobtndesign onhovertooltip" data-criterion-type="SubBalance" title="$language->SubscribersBalanceCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_balance.png"/></button>'
             ELSE ''
        END AS SubscriberBalance,
        CASE WHEN (SELECT COUNT(id) FROM `criterion_roaming` WHERE TeaserID=messageOut.id AND `Value`='Yes')>0
             THEN '<button class="btn btn-circle nobtndesign" data-criterion-type="RoamingCriteria" title="$language->RoamingCriteria" style="margin-right: 5px"><i class="fa fa-mobile"><span>R</span></i></button>'
             ELSE ''
        END AS RoamingCriteria,
        CASE WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=4 AND message_id=messageOut.id)>0
             THEN '<button class="btn btn-circle nobtndesign onhovertooltip" data-criterion-type="SubRegion" title="$language->SubscribersRegion" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_region.png"/></button>'
             ELSE ''
        END AS SubscriberRegion,
        CASE WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=6 AND message_id=messageOut.id)>0
             THEN '<button class="btn btn-circle nobtndesign onhovertooltip" data-criterion-type="TariffPlan" title="$language->TariffCriteria" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_tarif.png"/></button>'
             ELSE ''
        END AS TariffPlan,
        CASE WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=5 AND message_id=messageOut.id)>0
             THEN '<button class="btn nobtndesign onhovertooltip" data-criterion-type="MsisdnPrefix" title="$language->MsisdnPrefix" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_prefix.png"/></button>'
             ELSE ''
        END AS MsisdnPrefix,
        CASE  WHEN is_termless=1
             THEN '<button class="btn nobtndesign onhovertooltip" title="$language->Termless" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_termless.png"/></button>'
             ELSE ''
        END AS Termless,
        CASE  WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=15 AND message_id=messageOut.id)>0
             THEN '<button class="btn nobtndesign onhovertooltip" data-criterion-type="BonusesBalance" title="$language->BonusesBalance" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_bonus.png"/></button>'
             ELSE ''
        END AS Bonus,
        CASE  WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=14 AND message_id=messageOut.id)>0
             THEN '<button class="btn nobtndesign onhovertooltip" data-criterion-type="PaidActions" title="$language->LastCall" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_last_call.png"/></button>'
             ELSE ''
        END AS Payment,
        CASE  WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=13 AND message_id=messageOut.id)>0
             THEN '<button class="btn nobtndesign onhovertooltip" data-criterion-type="LastRecharge" title="$language->LastRefill" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_refill.png"/></button>'
             ELSE ''
        END AS Refill,
        CASE  WHEN (SELECT COUNT(id) FROM `messages_criterion` WHERE `criterion_type_id`=12 AND message_id=messageOut.id)>0
             THEN '<button class="btn nobtndesign onhovertooltip" data-criterion-type="SubList" title="$language->SubscriberList" style="margin-right: 5px"><img class="languageIcon" src="$base_url/includes/teaser/criteria_subscriber_list.png"/></button>'
             ELSE ''
        END AS SubscriberList

SQL;

        return $sql;

    }

    public function FindAllArchiveTeaser(AjaxGrid $ajaxGrid, $search)
    {
        $condition = "WHERE 1 = 1 AND is_deleted=1 and is_perm_deleted !=1 ";

        if (isset($search) && !empty($search) and $search = trim($search)) {
            $condition .= " AND (`text` LIKE '%$search%' OR `id`= '$search')";
        }
        $criteriaScript = $this->GetCriteriaScript();

        $sql = <<<SQL

        SELECT *, $criteriaScript

        FROM messages_message AS messageOut $condition ORDER BY $ajaxGrid->sortExpression $ajaxGrid->sortOrder LIMIT $ajaxGrid->offset,$ajaxGrid->rowNumber

SQL;

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);

        $sqlQuery = $this->GetDbConnection()->query("SELECT Count(*) FROM {$this->table} $condition");

        $rowCount = $sqlQuery->fetch();

        $list['RowCount'] = $rowCount[0];
        $list['Data'] = $data;
        $list['PageNumber'] = $ajaxGrid->pageNumber;

        return $list;

    }

    public function ArchiveRestoreTeaser($teaserId, $status)
    {
        try {
            $this->dbConnection->query("UPDATE messages_message SET is_deleted=$status, is_active=0 WHERE id=$teaserId");
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function GetAllActiveTeaserCount()
    {
        //$sqlQuery = $this->dbConnection->query("SELECT COUNT(*) FROM {$this->table} WHERE is_active=1 && is_deleted=0 ");
        $sqlQuery = $this->dbConnection->query("SELECT COUNT(MM.id) FROM {$this->table} MM LEFT JOIN messages_periods MP ON MM.id=MP.message_id WHERE is_active=1 && is_deleted=0 AND is_history=0
                                                AND ((MM.stamp!='0000-00-00 00:00:00' AND CURRENT_DATE BETWEEN  CAST(MP.start AS Date) AND CAST(MP.end AS Date) ) OR MM.stamp='0000-00-00 00:00:00')");
        $ActiveTeaserCount = $sqlQuery->fetchColumn();
        $_SESSION["ActiverTeaserCount"] = $ActiveTeaserCount;
        $sqlQuery = $this->dbConnection->query("SELECT COUNT(*) FROM {$this->table} WHERE is_active=1 && is_deleted=0  AND is_history=0 ");
        $AllTeaserCount = $sqlQuery->fetchColumn();
        $_SESSION["TotalTeaserCount"] = $AllTeaserCount;
    }

    function GetDefaultTeaser($id = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE is_deleted=0 AND is_history=0 && `stamp`='0000-00-00 00:00:00'";
        if ($id != null) {
            $sql .= " &&  id !={$id}";
        }
        $sqlQuery = $this->dbConnection->query($sql);
        $DefaultTeaserCount = $sqlQuery->fetchColumn();

        return $DefaultTeaserCount;
    }

    function checkDefaultTeaser($id = null)
    {
        if ($id != null) {
            $sqlQuery = $this->dbConnection->query("SELECT COUNT(*) FROM {$this->table} WHERE is_deleted=0 && `stamp`='0000-00-00 00:00:00' && `id` = '$id' ");
            echo "SELECT COUNT(*) FROM {$this->table} WHERE is_deleted=0 && `stamp`='0000-00-00 00:00:00' && `id` = '$id' ";
            $DefaultTeaserCount = $sqlQuery->fetchColumn();

            return ((int)$DefaultTeaserCount) > 0 ? true : false;
        }
    }

    function LogicalDelete($id)
    {
        $sql = "UPDATE {$this->table} SET is_perm_deleted=1 WHERE `id`=:id";

        $sth = $this->dbConnection->prepare($sql);

        return ($sth->execute(array(":id" => $id)));
    }

    function DeleteAll()
    {
        $sql = "UPDATE {$this->table} SET is_perm_deleted=1 WHERE is_deleted=1";

        $sth = $this->dbConnection->prepare($sql);

        return ($sth->execute());
    }

    function DeleteSelectedItem($delId)
    {
        $sql = "";
        foreach ($delId as $id) {
            $sql .= "UPDATE {$this->table} SET is_perm_deleted=1 WHERE is_deleted=1 and id IN($id); ";
        }
        $sth = $this->dbConnection->prepare($sql);

        return ($sth->execute());
    }

    function TeaserHistory(AjaxGrid $ajaxGrid, $TeaserID = null)
    {

        $this->refrenceList = array($TeaserID);

        $this->getChildRows($TeaserID);

        $this->refrenceList = array_filter($this->refrenceList, function ($value) {
            return (is_null($value)) ? 0 : 1;
        });

        $this->refrenceList = implode(',', $this->refrenceList);

        extract($_GET);
        $condition = "WHERE 1 = 1 ";
        if (isset($search) && !empty($search) and $search = trim($search)) {
            $condition .= " AND (`text` LIKE '%$search%'  OR messageOut.`id`= '$search')";
        }

        $criteriaScript = $this->GetCriteriaScript();

        $sql = <<<SQL

        SELECT messageOut.id,messageOut.text,messageOut.updated_date,is_history,
        login_user.Username as updated_by,
        CHAR_LENGTH (text) `NumberOfSymbols`,
        CASE
            WHEN
            CURRENT_TIMESTAMP > (SELECT MAX(`end`) FROM `messages_periods` WHERE message_id=messageOut.`id`)
            THEN 'Finished'
            ELSE 'Ongoing'
        END AS PublicationStatus, $criteriaScript,
        CASE WHEN messageOut.stamp='0000-00-00 00:00:00'
        THEN '1'
        ELSE '0'
        END AS DefaultTeaser,
       CASE WHEN (SELECT IFNULL(SUM(is_activated), 0) FROM sessions_archive
           WHERE shank_id = messageOut.id)=0 THEN '-'
           ELSE (SELECT IFNULL(SUM(is_activated), 0) FROM sessions_archive
           WHERE shank_id = messageOut.id)  END AS  Activation,
           (SELECT ifnull(sum(COUNT), 0) FROM statistic_archive WHERE shank_id=messageOut.id) AS `Views`

        FROM messages_message AS messageOut LEFT JOIN login_user on login_user.ID=messageOut.updated_by
        $condition AND messageOut.id in ($this->refrenceList) ORDER BY DefaultTeaser DESC,

SQL;

        if ($ajaxGrid->advanceSorting == null) {
            $sql .= " $ajaxGrid->sortExpression $ajaxGrid->sortOrder ";
        } else {
            $sql .= "{$ajaxGrid->advanceSorting}";
        }

        $sql .= " LIMIT $ajaxGrid->offset,$ajaxGrid->rowNumber";

        $sqlQuery = $this->GetDbConnection()->query($sql);

        $data = $sqlQuery->fetchAll(\PDO::FETCH_ASSOC);

        $sqlQuery = $this->GetDbConnection()->query("SELECT Count(*) FROM {$this->table} messageOut  LEFT JOIN login_user on login_user.ID=messageOut.updated_by  $condition AND messageOut.id in ($this->refrenceList) ");

        $rowCount = $sqlQuery->fetch();

        $list['RowCount'] = $rowCount[0];
        $list['Data'] = $data;
        $list['PageNumber'] = $ajaxGrid->pageNumber;
        $list['Header'] = true;
        $list['CurrentTeaser'] = $TeaserID;

        return $list;
    }

    function getChildRows($teaser_id)
    {
        $sql = $this->dbConnection->query("SELECT * FROM `messages_message` as messageOut WHERE `id` =$teaser_id");
        $row = $sql->fetch();

        if (!is_null($row['reference_id'])) {
            array_push($this->refrenceList, $row['reference_id']);
            $this->getChildRows($row['reference_id']);
        }
    }

    /*
     * Update teaser that has got updated text
     * @param id: Id of the Teaser
     * @param newText: Updated Text
     * @return New id of the updated Teaser
     * */
    function updateTeaserWithNewText($id, $newText, $username)
    {
        try {
            $this->dbConnection->beginTransaction();

            $sql = "INSERT INTO messages_message (text,stamp,counter,is_active,is_deleted,chars,lang,is_perm_deleted,is_interactiv,activation_code,
                    service,is_high_priority,is_whitelist,updated_by,is_termless,send_sms,sms_text)
                    SELECT '$newText', stamp,counter,is_active,is_deleted,chars,lang,is_perm_deleted,is_interactiv,activation_code,
                    service,is_high_priority,is_whitelist, '$username',is_termless,send_sms,sms_text
                    FROM messages_message WHERE id=:id";

            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            $messageId = $this->dbConnection->lastInsertId();


            $sql = "INSERT INTO `messages_periods` (`message_id`,`start`,`end`) SELECT $messageId, `start`,`end` FROM `messages_periods` WHERE `message_id` = :id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->bindParam(':id', $id);
            $sthMessages->execute();

            $sql = "INSERT INTO messages_criterion (message_id, criterion_type_id, criterion_id) SELECT $messageId, criterion_type_id, criterion_id FROM
                  messages_criterion WHERE message_id = :id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            $sql = "INSERT INTO criterion_roaming (TeaserID, Value) SELECT $messageId, Value FROM criterion_roaming WHERE `TeaserID`=:id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            $sql = "UPDATE `messages_message` SET `reference_id` = :oldId, is_modified=1, updated_date=CURRENT_TIMESTAMP  WHERE id=:id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $messageId, ":oldId" => $id));

            $sql = "UPDATE `messages_message` SET `is_history` = 1  WHERE id=:id";
            $sthMessages = $this->dbConnection->prepare($sql);
            $sthMessages->execute(array(":id" => $id));

            $this->dbConnection->commit();

            $this->UpdateStatus($id, 0);

            return $messageId;
        } catch (\Exception $e) {

            $this->dbConnection->rollBack();
            return false;
        }
    }


    function GetPriority()
    {
        $sqlQuery = $this->dbConnection->query("SELECT DISTINCT is_high_priority FROM messages_message WHERE is_high_priority IS NOT NULL AND is_deleted != 1 AND is_history !=1 AND is_perm_deleted != 1 ORDER BY is_high_priority");

        return $sqlQuery->fetchAll(\PDO::FETCH_COLUMN);
    }


} 