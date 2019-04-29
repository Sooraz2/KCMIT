<?php

namespace WebInterface\Modules\DailyHealthTips;


use Infrastructure\ConfirmationDisplay;
use Language\English\Logs;
use Infrastructure\SessionVariables;
use Repositories\SlugRepository;
use Shared\Controllers\WebInterfaceControllerAbstract;
use Shared\Model\AjaxGrid;
use Shared\Model\LoginUserLog;
use WebInterface\Models\DailyHealthTips;
use Infrastructure\PHPFormToken;
use WebInterface\Models\Slug;



class DailyHealthTipsController extends WebInterfaceControllerAbstract
{



    function __construct()
    {

        parent::__construct();

        $this->DailyHealthTipsRepo = new DailyHealthTipsRepository();

        $this->DailyHealthTipsValidator = new DailyHealthTipsValidator();

        $this->DailyHealthTipsParameter = new DailyHealthTipsParameter();

        $this->FormToken = new PHPFormToken();

        $this->SlugRepo = new SlugRepository();

    }

    function IndexAction()
    {

        $this->load->View("DailyHealthTips/Index");
    }

    function FormAction()
    {
        $this->load->View("DailyHealthTips/Form", $this->DailyHealthTipsParameter->Form());

    }

    function CheckSlugAction(){

        $response = array();

        $response[0] = $_GET["fieldId"];

        $id = 0;

        if(isset($_GET['ID'])){

        $id = $_GET['ID'];

        }


        $response[1] =$this->SlugRepo->CheckSlug($_GET['fieldValue'], $id) > 0 ? false : true;

        echo json_encode($response);

    }

    function SaveUpdateFormAction()
    {

        $confirmation = $this->DailyHealthTipsValidator->ValidateDailyHealthTipsSubmit($_POST);

        if($this->FormToken->GetFormToken("DailyHealthTipsFormToken") == $_POST['DailyHealthTipsFormToken']) {

            $this->FormToken->UnsetFormToken("DailyHealthTipsFormToken");


        if ($confirmation->MessageType == "Success") {

        $DailyHealthTips = new DailyHealthTips();

        $DailyHealthTips->MapParameters($_POST);


/* Upload Image For both SAVE & Update of News or Tips */
        /*if (file_exists($_FILES['Image1']['tmp_name']) && is_uploaded_file($_FILES['Image1']['tmp_name'])) {

            $file = explode('.',$_FILES['Image1']['name']);

            $src = $_FILES['Image1']['tmp_name'];

            $dest1 = $file[0].'Large'.date('Ymdhis').'.jpg';
            $dest2 = $file[0].'Medium'.date('Ymdhis').'.jpg';


            ImageResize($src, '../Uploads/'.$dest1,'780','360');

            ImageResize($src, '../Uploads/'.$dest2,'270','380');



           // move_uploaded_file($src, $dest);
            $DailyHealthTips->Image1 = $dest1;
            $DailyHealthTips->Image2 = $dest2;

        } else {
            unset($DailyHealthTips->Image1);
            unset($DailyHealthTips->Image2);

        }*/




        if (file_exists($_FILES['Image1']['tmp_name']) && is_uploaded_file($_FILES['Image1']['tmp_name'])) {
            $file = explode('.',$_FILES['Image1']['name']);
            $dest1 = $file[0].'Large'.date('Ymdhis').'.'.end($file);
            $src = $_FILES['Image1']['tmp_name'];
            $dest = '../Uploads/'.$dest1;
            move_uploaded_file($src, $dest);
            $DailyHealthTips->Image1 = $dest1;
        }else { unset($DailyHealthTips->Image1); }


            if (file_exists($_FILES['Image2']['tmp_name']) && is_uploaded_file($_FILES['Image2']['tmp_name'])) {
                $file = explode('.',$_FILES['Image2']['name']);
                $dest2 = $file[0].'Large'.date('Ymdhis').'.'.end($file);
                $src = $_FILES['Image2']['tmp_name'];
                $dest = '../Uploads/'.$dest2;
                move_uploaded_file($src, $dest);
                $DailyHealthTips->Image2 = $dest2;
            }else { unset($DailyHealthTips->Image2); }

        /* END Upload Image For both SAVE & Update of News or Tips */

        if (isset($_POST["ID"]) && !empty($_POST["ID"])) {

            $DailyHealthTips->LastUpdateDate = $this->DailyHealthTipsRepo->GetCurrentDateTime();

                $GetImages = $this->DailyHealthTipsRepo->GetById($_POST["ID"], "ID");

                $NewDailyHealthTipsDetail = new DailyHealthTips();

            $NewDailyHealthTipsDetail->MapParameters($GetImages);

            if (file_exists('../Uploads/'.$NewDailyHealthTipsDetail->Image1) && $NewDailyHealthTipsDetail->Image1!='' && isset($HealthTips->Image1)){
                unlink('../Uploads/'.$NewDailyHealthTipsDetail->Image1);
            }
            if (file_exists('Uploads/'.$NewDailyHealthTipsDetail->Image2) && $NewDailyHealthTipsDetail->Image2!=''  && isset($HealthTips->Image2)){
                unlink('../Uploads/'.$NewDailyHealthTipsDetail->Image2);
            }


                $DailyHealthTipsLog = DailyHealthTipsLog::UpdateDailyHealthTips($DailyHealthTips);

                $status = $this->DailyHealthTipsRepo->Update($DailyHealthTips,$DailyHealthTipsLog);

/*
                $Slug = new Slug();
                $Slug->Content = 'HealthTips';
                $Slug->ContentID = $NewDailyHealthTipsDetail->ID;
                $Slug->Slug = $DailyHealthTips->Slug;

                $this->SlugRepo->Update($Slug);*/

               DailyHealthTipsConfirmation::Update($status);

            } else {


                $DailyHealthTips->AddedDate = $this->DailyHealthTipsRepo->GetCurrentDateTime();

                $DailyHealthTips->LastUpdateDate = $this->DailyHealthTipsRepo->GetCurrentDateTime();

                $DailyHealthTipsLog = DailyHealthTipsLog::SaveDailyHealthTips($DailyHealthTips);

                $status = $this->DailyHealthTipsRepo->Save($DailyHealthTips,$DailyHealthTipsLog);

                DailyHealthTipsConfirmation::Save($status);

            }
        } else {

            ConfirmationDisplay::SetConfirmation($confirmation);

        }
    }
        Redirect("DailyHealthTips");
        exit;

    }

    function ListAction()
    {
        $ajaxGrid = new AjaxGrid();

        $ajaxGrid->MapParameters($_GET);

        echo json_encode($this->DailyHealthTipsRepo->FindAll($ajaxGrid));
    }

    function DeleteAction()
    {


        $DailyHealthTipsDetails = $this->DailyHealthTipsRepo->GetById($_POST["ID"]);

        $DailyHealthTips= new DailyHealthTips();

        $DailyHealthTips->MapParameters($DailyHealthTipsDetails);

         $DailyHealthTipsLog =  DailyHealthTipsLog::DeleteDailyHealthTips($DailyHealthTips);

        $status = $this->DailyHealthTipsRepo->Delete($_POST["ID"]);

        if($status){


            $this->DailyHealthTipsRepo->SaveDailyHealthTipsLog($DailyHealthTipsLog);

        }

        DailyHealthTipsConfirmation::Delete($status);

        Redirect("DailyHealthTips");
    }


    function SetStatusAction()
    {

        $DailyHealthTipsDetails = $this->DailyHealthTipsRepo->GetById($_POST["ID"]);

        $DailyHealthTips= new DailyHealthTips();

        $DailyHealthTips->MapParameters($DailyHealthTipsDetails);

        if($_POST["Status"]==1){

            $DailyHealthTips->Status = 0;
        } else {

            $DailyHealthTips->Status = 1;
        }

        $DailyHealthTipsLog =   DailyHealthTipsLog::SetStatus($DailyHealthTips);

        $status = $this->DailyHealthTipsRepo->Update($DailyHealthTips,$DailyHealthTipsLog);

        if($status){
          echo '1';
        } else {
            echo '0';
        }


    }
}