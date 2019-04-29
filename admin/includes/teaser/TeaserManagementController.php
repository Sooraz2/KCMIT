<?php

namespace WebInterface\Modules\TeaserManagement;

use Infrastructure\InterfaceVariables;
use Infrastructure\MessageCriterionType;
use Infrastructure\PHPFormToken;
use Infrastructure\SessionVariables;
use Repositories\LanguageTableRepository;
use Admin\Repositories\LoginUserLogRepository;
use Repositories\MessagePeriodTableRepository;
use Repositories\TeaserActivationLogTableRepository;
use Repositories\TeaserTableRepository;
use Repositories\TimeCriteriaTableRepository;
use Shared\Controllers\WebInterfaceControllerAbstract;
use Shared\ListRepository;
use Shared\Model\AjaxGrid;
use WebInterface\Models\MessageCriterion;
use WebInterface\Models\MessagePeriod;
use WebInterface\Models\Teaser;
use WebInterface\Models\TeaserOldScheduleLog;

class TeaserManagementController extends WebInterfaceControllerAbstract
{
    private $teaserRepository;

    private $languageRepository;

    private $timeCriteriaRepository;

    private $teaserManagementParameter;

    private $phpFormToken;

    private $TeaserManagementValidator;

    function __construct()
    {
        parent::__construct();

        $this->teaserRepository = new TeaserTableRepository();

        $this->UserLogRepository = new LoginUserLogRepository();

        $this->languageRepository = new LanguageTableRepository();

        $this->activationLogRepository = new TeaserActivationLogTableRepository();

        $this->timeCriteriaRepository = new TimeCriteriaTableRepository();

        $this->teaserRepository->GetAllActiveTeaserCount();

        $this->listRepository = new ListRepository();

        $this->teaserManagementParameter = new TeaserManagementParameter();

        $this->phpFormToken = new PHPFormToken();

        $this->TeaserManagementValidator = new TeaserManagementValidator();
    }

    function IndexAction()
    {
        $param = $this->teaserManagementParameter->IndexActionParameters();

        $this->load->View("TeaserManagement/Index", $param);
    }

    function FormAction()
    {
        $params = $this->teaserManagementParameter->FormActionParameters();

        $this->load->View("TeaserManagement/Form", $params);
    }

    function ListAction()
    {
        $ajaxGrid = new AjaxGrid();

        $ajaxGrid->MapParameters($_GET);

        echo json_encode($this->sortAllTeasers($this->teaserRepository->FindAll($ajaxGrid), $ajaxGrid->pageNumber));
    }

    private function sortAllTeasers($teasers, $pageNumber)
    {
        global $langConfig;
        $this->language = $langConfig->languageClass;

        foreach ($this->language as $key => $value) {
            $value = func_mysql_escape_string($value);
            $this->language->$key = $value;
        }

        $sortedArray = array(
            $this->language->DefaultTeasersSection => array(),
            $this->language->OtherTeasersSection => array()
        );

        if ($pageNumber > 1) {
            unset($sortedArray[$this->language->DefaultTeasersSection]);
        }

        foreach ($teasers['Data'] as $key => $value):
            if ($value['DefaultTeaser'] == '1') {
                $sortedArray[$this->language->DefaultTeasersSection][] = $value;
            } else {
                $sortedArray[$this->language->OtherTeasersSection][] = $value;
            }
        endforeach;

        foreach ($sortedArray as $key => $value):
            if (count($value) == 0) {
                $sortedArray[$key][] = $this->EmptyTeasersData();
            }
        endforeach;

        $teasers['Data'] = $sortedArray;
        if ($teasers['RowCount'] == 0)
            $teasers['RowCount'] = 1;
        $teasers['titleCol'] = 3;

        return $teasers;
    }

    private function EmptyTeasersData()
    {
        return array(
            "id" => "",
            "text" => "<div style='color: #A7A5A6;' class='no-teasers-row'>" . $this->language->ThereAreNoTeasersYet . "</div>",
            "stamp" => "",
            "is_active" => "",
            "is_deleted" => "",
            "priority_" => "0"
        );
    }


    function GetPlannedTimeFramesAction()
    {
        extract($_POST);
        if (!isset($messageId)) {
            echo "message_id is not set.";
            exit;
        }
        $data = $this->teaserRepository->GetPlannedTimesByMessageID($messageId);
        echo json_encode($data);
    }

    function OneMoreTimeAction()
    {
        $id = $_POST['ID'];

        $status = false;

        if (!($this->teaserRepository->checkDefaultTeaser($id)) || ($this->teaserRepository->checkDefaultTeaser($id) && ($this->teaserRepository->GetDefaultTeaser() < InterfaceVariables::DefaultTeasers))) {

            $loginUserLog = TeaserManagementLog::TeaserClonedLog($id);

            $status = $this->teaserRepository->CloneTeaser($id, $loginUserLog, $_SESSION[SessionVariables::$UserID]);

        }

        TeaserManagementConfirmation::CloneTeaserConfirmation($status);

        Redirect("TeaserManagement/Index");

    }

    function DeleteAction()
    {
        $id = $_POST['ID'];

        $activationLog = TeaserManagementLog::DeleteActionTeaserArchiveLog($id);

        $deleteLog = TeaserManagementLog::DeleteActionLog($id);

        $status = $this->teaserRepository->ArchiveRestoreTeaser($id, 1, $activationLog, $deleteLog);

        TeaserManagementConfirmation::DeleteActionConfirmation($status);

        Redirect("TeaserManagement/Index");
    }

    private function SaveTeaserData(Teaser $teaser)
    {
        $teaser->MapParameters($_POST);

        $teaser->stamp = $this->teaserRepository->GetCurrentDateTime();

        $teaser->counter = 0;

        $teaser->is_active = 0;

        $teaser->lang = null;

        $teaser->is_deleted = 0;

        $teaser->is_perm_deleted = 0;

        $teaser->updated_by = $_SESSION[SessionVariables::$UserID];

        $teaser->created_by = $_SESSION[SessionVariables::$UserID];

        $teaser->updated_date = $this->teaserRepository->GetCurrentDateTime();

        $messageCriteria = new MessageCriterion();

        //chars 1 for english and 2 for french
        //chars is used for defining unicode
        //Language criteria 4-default french and 1 for english

        if ($teaser->chars == 1) {
            //english
            $messageCriteria->criterion_type_id = MessageCriterionType::Language;
            $messageCriteria->criterion_id = 1;

        } elseif ($teaser->chars == 2) {
            //russian
            $messageCriteria->criterion_type_id = MessageCriterionType::Language;
            $messageCriteria->criterion_id = 2;
        } elseif ($teaser->chars == 3) {
            //georgian
            $messageCriteria->criterion_type_id = MessageCriterionType::Language;
            $messageCriteria->criterion_id = 3;
        } elseif ($teaser->chars == 4) {
            //french
            $messageCriteria->criterion_type_id = MessageCriterionType::Language;
            $messageCriteria->criterion_id = 4;
        }
        elseif ($teaser->chars == 5) {
            //tajik
            $messageCriteria->criterion_type_id = MessageCriterionType::Language;
            $messageCriteria->criterion_id = 5;
        }

        elseif ($teaser->chars == 6) {
            //uzbek
            $messageCriteria->criterion_type_id = MessageCriterionType::Language;
            $messageCriteria->criterion_id = 6;
        }


        $messagePeriod = new MessagePeriod();

        $teaserId = $this->teaserRepository->Save($teaser, $messageCriteria, $messagePeriod);

        $teaser->id = $teaserId;
    }

    /**
     * @throws \Exception
     */
    function TeaserEditAction()
    {



        if (!isset($_GET['TeaserID']) && isset($_POST["text"])) {

            $teaser = new Teaser();

            $teaser->MapParameters($_POST);

            $teaser->lang = $teaser->chars;

        } else {
            $teaser = $this->teaserRepository->GetById($_GET['TeaserID'], "id");

        }

        $messagePeriodList = array();

        if (isset($_POST['IsEdited'])) {
//            $confirmation = $this->TeaserManagementValidator->ValidateTeaserEditForm($_POST);
//            if ($confirmation->MessageType == "Success") {

            if (!(isset($_GET["TeaserID"]))) {

                if ($this->phpFormToken->GetFormToken("TeaserAuthToken") == $_POST['TeaserAuthToken']) {

                    $this->phpFormToken->UnsetFormToken("TeaserAuthToken");
                    $this->SaveTeaserData($teaser);

                } else {

                    if (isset($_GET['BroadcastingCalendar']) && $_GET["BroadcastingCalendar"] == "true") {
                        Redirect("BroadcastingCalendar/index");
                    } else if (isset($_GET['active-teasers']) && $_GET['active-teasers'] == 'true')
                        Redirect("ActiveTeasers/index");
                    else {
                        if (isset($_POST['PageIndex'])) {
                            $_SESSION['TeaserCurrentPage'] = $_POST['PageIndex'];
                        }
                        Redirect("TeaserManagement/Index");
                    }
                }
            }
            $messageCriterionList = array();

            $oldTeaser = clone($teaser);

            $oldText = $teaser->text;

            $isMadeTermless = false;

            if (isset($_POST["DefaultTeaser"]) && $_POST["DefaultTeaser"] == "1" && isset($_POST["text"])) {


                $teaser->stamp = "0000-00-00 00:00:00";

                $teaser->is_interactiv = null;

                $teaser->activation_code = null;

                if ($teaser->lang == null) {
                    $teaser->lang = $this->teaserRepository->GetTeaserLanguageExceptDefault($teaser->id);
                }

                $teaser->service = null;

                $teaser->is_high_priority = null;

                $teaser->is_termless = null;


            } else {
                if ($teaser->stamp == "0000-00-00 00:00:00") {
                    $teaser->stamp = date('Y-m-d H:i:s');
                }

                $eventPeriods = json_decode($_POST['EventPeriods']);

                array_walk($eventPeriods, function (&$period) {
                    $period->start = date('Y-m-d H:i:s', strtotime($period->start));
                    $period->end = date('Y-m-d H:i:s', strtotime($period->end));
                });

                $oldBroadcastingDates = array();

                foreach ($_POST["teaserOldSchedules"] as $oldSchedule) {
                    $broadcastingDate = array();
                    $broadcastingDate["TeaserID"] = $teaser->id;
                    $broadcastingDate["BroadcastSchedule"] = date('Y-m-d', strtotime($oldSchedule));
                    $oldBroadcastingDates[] = $broadcastingDate;
                }


                if (isset($_POST['TimeCriteria']))
                    foreach ($_POST['TimeCriteria'] as $timeCriteriaId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::TimeCriteria;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $timeCriteriaId;

                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['SubscriberBalance']))

                    foreach ($_POST['SubscriberBalance'] as $subscriberBalanceId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::SubBalance;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $subscriberBalanceId;


                        array_push($messageCriterionList, $messageCriterion);

                    }

                if (isset($_POST['ValidTill'])) {
                    $messageCriterion = new MessageCriterion();

                    $messageCriterion->criterion_type_id = MessageCriterionType::ValidTill;
                    $messageCriterion->message_id = $teaser->id;
                    $messageCriterion->criterion_id = $_POST['ValidTill'];

                    array_push($messageCriterionList, $messageCriterion);
                }

                if (isset($_POST['SubscriberRegion']))
                    foreach ($_POST['SubscriberRegion'] as $subscriberRegionId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::SubRegion;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $subscriberRegionId;

                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['MsisdnPrefix']))
                    foreach ($_POST['MsisdnPrefix'] as $msisdnPrefixId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::MsisdnPrefix;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $msisdnPrefixId;

                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['TariffPlan']))
                    foreach ($_POST['TariffPlan'] as $tariffPlanId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::TariffPlan;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $tariffPlanId;


                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['ActiveServices']))
                    foreach ($_POST['ActiveServices'] as $activeServicesId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::ActiveServices;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $activeServicesId;


                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['SubscriberClub']))
                    foreach ($_POST['SubscriberClub'] as $subscriberClubId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::SubscriberClub;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $subscriberClubId;


                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['LastRecharge'])) {
                    $messageCriterion = new MessageCriterion();

                    $messageCriterion->criterion_type_id = MessageCriterionType::LastRecharge;
                    $messageCriterion->message_id = $teaser->id;
                    $messageCriterion->criterion_id = $_POST['LastRecharge'];

                    array_push($messageCriterionList, $messageCriterion);
                }

                if (isset($_POST['PaidActions'])) {
                    $messageCriterion = new MessageCriterion();

                    $messageCriterion->criterion_type_id = MessageCriterionType::PaidActions;
                    $messageCriterion->message_id = $teaser->id;
                    $messageCriterion->criterion_id = $_POST['PaidActions'];

                    array_push($messageCriterionList, $messageCriterion);
                }

                if (isset($_POST['SubscriberList']))
                    foreach ($_POST['SubscriberList'] as $subscriberListId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::SubList;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $subscriberListId;

                        array_push($messageCriterionList, $messageCriterion);

                        $teaser->is_whitelist = 1;

                    }
                else
                    $teaser->is_whitelist = 0;


                if (isset($_POST['UssdShortNumbers']))
                    foreach ($_POST['UssdShortNumbers'] as $ussdShortNumbersId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::USSDShortNumbers;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $ussdShortNumbersId;

                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (isset($_POST['OptionActivationCheck']))
                    foreach ($_POST['OptionActivationCheck'] as $optionActivationCheckId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::OptionActivationCheck;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $optionActivationCheckId;

                        array_push($messageCriterionList, $messageCriterion);
                    }

                if (!isset($_POST['is_termless']) || $_POST['is_termless'] != 1) {

                    foreach ($eventPeriods as $eventPeriod) {
                        $messagePeriod = new MessagePeriod();

                        $messagePeriod->MapParameters($eventPeriod);

                        $messagePeriod->message_id = $teaser->id;

                        if (strtotime($messagePeriod->start) >= strtotime($this->teaserRepository->GetCurrentDate())) {
                            array_push($messagePeriodList, $messagePeriod);
                        }
                    }
                }

                if (isset($_POST['BonusesBalance'])) {

                    foreach ($_POST['BonusesBalance'] as $bonusesBalanceId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::BonusesBalance;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $bonusesBalanceId;

                        array_push($messageCriterionList, $messageCriterion);
                    }

                }

                if (isset($_POST['BlackListGroup'])) {

                    foreach ($_POST['BlackListGroup'] as $bonusesBalanceId) {
                        $messageCriterion = new MessageCriterion();

                        $messageCriterion->criterion_type_id = MessageCriterionType::BlackListGroup;
                        $messageCriterion->message_id = $teaser->id;
                        $messageCriterion->criterion_id = $bonusesBalanceId;

                        array_push($messageCriterionList, $messageCriterion);
                    }
                }

                $teaser->MapParameters($_POST);

                $teaser->text = $oldText;

                $teaser->lang = null;

                $teaser->is_interactiv = isset($_POST['is_interactiv']) ? isset($_POST['is_interactiv']) : null;

                $teaser->send_sms = isset($_POST['send_sms']) ? isset($_POST['send_sms']) : null;

                $teaser->service = isset($_POST["service"]) && isset($_POST['is_interactiv']) ? $_POST['service'] : null;

                $teaser->activation_code = isset($_POST["activation_code"]) && isset($_POST['is_interactiv']) ? $_POST['activation_code'] : null;

                $teaser->sms_text = isset($_POST["sms_text"]) && (isset($_POST['send_sms']) && $_POST['send_sms'] == 1) ? $_POST["sms_text"] : null;


                if (isset($_POST["high_priority"]) && $_POST["high_priority"] == 1) {

                    if (isset($_POST["is_high_priority"]) && $_POST["is_high_priority"] > 0)
                        $teaser->is_high_priority = trim($_POST["is_high_priority"]);

                    else {

                        $teaser->is_high_priority = 0;
                    }

                    $teaser->is_termless = null;

                } elseif (isset($_POST['is_termless']) && $_POST['is_termless'] == 1) {

                    if ($teaser->is_termless != null) {
                        $isMadeTermless = true;
                    }

                    $teaser->is_termless = $_POST['is_termless'];
                    $teaser->is_high_priority = null;

                } else {
                    $teaser->is_termless = null;
                    $teaser->is_high_priority = null;
                }
            }

            if ((isset($_POST['is_termless']) && $_POST['is_termless'] == 1) || (isset($_POST["DefaultTeaser"]) && $_POST["DefaultTeaser"] == "1")) {
                $messagePeriod = new MessagePeriod();

                $endDate = '2050-12-31 23:59:59';
                $messagePeriod->message_id = $teaser->id;
                $messagePeriod->start = date("Y-m-d") . " 00:00:00";
                $messagePeriod->end = $endDate;
                array_push($messagePeriodList, $messagePeriod);
            }

            $teaser->broadcast_date_sel_type = 0;

            if (isset($_POST["broadcast_date_sel_type"]) && $_POST["broadcast_date_sel_type"] == 1) {
                $teaser->broadcast_date_sel_type = 1;
                $messagePeriod = new MessagePeriod();
                $endDate = '2050-12-31 23:59:59';
                $messagePeriod->message_id = $teaser->id;
                $messagePeriod->start = $_POST["only_start_date"] . " 00:00:00";
                $messagePeriod->end = $endDate;
                array_push($messagePeriodList, $messagePeriod);
            } elseif (isset($_POST["broadcast_date_sel_type"]) && $_POST["broadcast_date_sel_type"] == 2) {

                $teaser->broadcast_date_sel_type = 2;

            }

            if (isset($_POST['LanguageCriteria'])) {
                $messageCriterion = new MessageCriterion();

                //chars 1 for english and 2 for french
                //chars is used for defining unicode
                //Language criteria 4-default french and 1 for english

                $messageCriterion->criterion_type_id = MessageCriterionType::Language;
                $messageCriterion->message_id = $teaser->id;
                $messageCriterion->criterion_id = $_POST['LanguageCriteria'];
                if ($_POST['LanguageCriteria'] == 1) {
                    $teaser->chars = 1;

                } elseif ($_POST['LanguageCriteria'] == 4) {
                    $teaser->chars = 2;
                }
                array_push($messageCriterionList, $messageCriterion);
            }

            $changedTeaserLog = null;

            $changedTeaserDefaultLog = null;

            $launchedTeaser = null;

            $termlessTeaserLog = null;

            $changedTeaserLog = TeaserManagementLog::TeaserChangedLog($teaser->id);

            if ($oldTeaser->stamp == "0000-00-00 00:00:00" && $teaser->stamp != "0000-00-00 00:00:00") {
                $changedTeaserDefaultLog = TeaserManagementLog::TeaserDefaultChangedLog($teaser->id, $teaser->stamp);
            }

            if ($oldTeaser->stamp != "0000-00-00 00:00:00" && $teaser->stamp == "0000-00-00 00:00:00") {
                $changedTeaserDefaultLog = TeaserManagementLog::TeaserDefaultChangedLog($teaser->id, $teaser->stamp);
            }

            if (count($messagePeriodList) > 0)
                $launchedTeaser = TeaserManagementLog::LaunchTeaser($teaser->id);

            if ($isMadeTermless)
                $termlessTeaserLog = TeaserManagementLog::TermLessTeaser($teaser->id);

            if (isset($_POST['IsEdited']) && $_POST['IsEdited'] == 0) {
                $status = $this->teaserRepository->SaveAdvance($teaser, $messagePeriodList, $messageCriterionList, null, $changedTeaserLog, $changedTeaserDefaultLog, $launchedTeaser, $termlessTeaserLog);
            } else {
//                $status = $this->teaserRepository->Update($teaser, $changedTeaserLog, $changedTeaserDefaultLog, $launchedTeaser, $termlessTeaserLog);

                $activationLog = TeaserManagementLog::InactivatedTeaserActivationLog($teaser->id);

                $this->activationLogRepository->Save($activationLog);

            }

            if (isset($_GET["TeaserID"])) {
                if ($_POST['text'] != $teaser->text || $_POST['IsEdited'] == 1) {
                    $changedTeaserTextLog = null;

                    $newData[':termLess'] = (isset($_POST['is_termless']))? "{$_POST['is_termless']}" : null;
                    $newData[':priority'] = (isset($_POST['is_high_priority']) && $_POST['is_high_priority'] != '')? "{$_POST['is_high_priority']}" : null;
                    $newData[':whitelist'] = (isset($_POST['SubscriberList']))? "1" : null;
                    $newData[':activationCode'] = (isset($_POST['activation_code']))? "{$_POST['activation_code']}" : null;
                    $newData[':service'] = (isset($_POST['service']))? "{$_POST['service']}" : null;
                    $newData[':is_interactiv'] = (isset($_POST['is_interactiv']))? "1" : null;

                    if($newData[':termLess'] == "'1'")
                        $newData[':priority'] = null;


                    if ($_POST['text'] != $teaser->text)
                        $changedTeaserTextLog = TeaserManagementLog::TeaserTextChangedLog($teaser->id, $oldTeaser->text, $_POST['text']);

                    $status = $this->teaserRepository->updateTeaserWithNewText($teaser->id, $_POST['text'], $_SESSION[SessionVariables::$UserID], $changedTeaserTextLog, $newData);
                    $teaser_ = $this->teaserRepository->GetById($status, 'id');

                    if (isset($_POST["DefaultTeaser"]) && $_POST["DefaultTeaser"] == "1" && isset($_POST["text"])) {
                        $teaser_->stamp = "0000-00-00 00:00:00";
                    }else{
                        $teaser_->stamp = date('Y-m-d H:i:s');
                    }

                    $messagePeriodList = $this->ChangeTeaserField($messagePeriodList, 'message_id', $teaser_->id);
                    $messageCriterionList = $this->ChangeTeaserField($messageCriterionList, 'message_id', $teaser_->id);

                    $teaser_->chars = $_POST['chars'];
                    $status = $this->teaserRepository->SaveAdvance($teaser_, $messagePeriodList, $messageCriterionList, null);
                }
            }

            TeaserManagementConfirmation::EditTeaserConfirmation($status, isset($_GET["TeaserID"]));

            if (isset($_GET['BroadcastingCalendar']) && $_GET["BroadcastingCalendar"] == "true") {
                Redirect("BroadcastingCalendar/index");
            } else if (isset($_GET['active-teasers']) && $_GET['active-teasers'] == 'true')
                Redirect("ActiveTeasers/index");
            else {
                if (isset($_POST['PageIndex'])) {
                    $_SESSION['TeaserCurrentPage'] = $_POST['PageIndex'];
                }
                Redirect("TeaserManagement/Index");
            }
        /*}else{
                ConfirmationDisplay::SetConfirmation($confirmation);
            }*/
        }

        $params = $this->teaserManagementParameter->TeaserEditParameters($teaser);
       // $params['TotalCharLeft'] = $_POST['TotalCharLeft'];
      //  $params['LanguageID'] = $_POST['chars'];

        $this->load->View("TeaserManagement/TeaserEdit", $params);

    }

    private function ChangeTeaserField($array, $field, $value)
    {

        for ($i = 0; $i < count($array); $i++) {
            $array[$i]->$field = $value;
        }

        return $array;
    }

    function DefaultTeaserActivationDeActivationAction()
    {
        if (isset($_POST["ID"])) {

            $messagePeriodRepo = new MessagePeriodTableRepository();

            $status = $messagePeriodRepo->count(array("message_id" => $_POST["ID"]));

            $status = $status->Count;

            $teaserRepo = new TeaserTableRepository();

            $teaser = $teaserRepo->GetById($_POST["ID"]);

            if ($teaser->stamp == '0000-00-00 00:00:00')

                $status = 1;

            $responseStatus = 0;

            if ($status > 0) {

                $activationLog = TeaserManagementLog::DefaultTeaserActivationDeActivationActionLog(trim($_POST['ID']), trim($_POST['Status']));

                $loginUserLog = TeaserManagementLog::DefaultTeaserActivationDeActivationActionUserLog(trim($_POST['ID']), trim($_POST['Status']));

                $responseStatus = $this->teaserRepository->UpdateStatus($_POST["ID"], $_POST['Status'], $activationLog, $loginUserLog);
            }

            TeaserManagementConfirmation::DefaultTeaserActivationDeActivationAction($_POST['Status'], $responseStatus, $status);

        }
        Redirect("TeaserManagement/Index");
    }


    function PriorityAction()
    {
        if (isset($_POST['id'])) {
            $priorityActionLog = TeaserManagementLog::PriorityActionLog($_POST['id'], $_POST['new_value']);

            $response = $this->teaserRepository->UpdatePriority(
                ($_POST['id']),
                ($_POST['new_value']),
                $priorityActionLog
            );

            TeaserManagementConfirmation::PriorityActionConfirmation($response);
        }

        Redirect("TeaserManagement/Index");

    }

} 