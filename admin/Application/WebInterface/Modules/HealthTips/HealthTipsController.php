<?php

namespace WebInterface\Modules\HealthTips;


use Infrastructure\ConfirmationDisplay;
use Language\English\Logs;
use Infrastructure\SessionVariables;
use Repositories\SlugRepository;
use Shared\Controllers\WebInterfaceControllerAbstract;
use Shared\Model\AjaxGrid;
use Shared\Model\LoginUserLog;
use WebInterface\Models\HealthTips;
use Infrastructure\PHPFormToken;
use WebInterface\Models\Slug;


class HealthTipsController extends WebInterfaceControllerAbstract
{



    function __construct()
    {

        parent::__construct();

        $this->HealthTipsRepo = new HealthTipsRepository();

        $this->HealthTipsValidator = new HealthTipsValidator();

        $this->HealthTipsParameter = new HealthTipsParameter();

        $this->FormToken = new PHPFormToken();

        $this->SlugRepo = new SlugRepository();

    }

    function IndexAction()
    {

        $this->load->View("HealthTips/Index");
    }

    function FormAction()
    {
        $this->load->View("HealthTips/Form", $this->HealthTipsParameter->Form());

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

        $confirmation = $this->HealthTipsValidator->ValidateHealthTipsSubmit($_POST);

        if($this->FormToken->GetFormToken("HealthTipsFormToken") == $_POST['HealthTipsFormToken']) {

            $this->FormToken->UnsetFormToken("HealthTipsFormToken");

        if ($confirmation->MessageType == "Success") {

        $HealthTips = new HealthTips();

        $HealthTips->MapParameters($_POST);


/* Upload Image For both SAVE & Update of News or Tips */
            if (file_exists($_FILES['Image1']['tmp_name']) && is_uploaded_file($_FILES['Image1']['tmp_name'])) {
                $file = explode('.',$_FILES['Image1']['name']);
                $dest1 = $file[0].'Large'.date('Ymdhis').'.'.end($file);
                $src = $_FILES['Image1']['tmp_name'];
                $dest = '../Uploads/'.$dest1;
                move_uploaded_file($src, $dest);
                $HealthTips->Image1 = $dest1;
            }else { unset($HealthTips->Image1); }


            if (file_exists($_FILES['Image2']['tmp_name']) && is_uploaded_file($_FILES['Image2']['tmp_name'])) {
                $file = explode('.',$_FILES['Image2']['name']);
                $dest2 = $file[0].'Medium'.date('Ymdhis').'.'.end($file);
                $src = $_FILES['Image2']['tmp_name'];
                $dest = '../Uploads/'.$dest2;
                move_uploaded_file($src, $dest);
                $HealthTips->Image2 = $dest2;
            }else {
                unset($HealthTips->Image2);
            }


            if (file_exists($_FILES['Image3']['tmp_name']) && is_uploaded_file($_FILES['Image3']['tmp_name'])) {
                $file = explode('.',$_FILES['Image3']['name']);
                $dest3 = $file[0].'Small'.date('Ymdhis').'.'.end($file);
                $src = $_FILES['Image3']['tmp_name'];
                $dest = '../Uploads/'.$dest3;
                move_uploaded_file($src, $dest);
                $HealthTips->Image3 = $dest3;
            }else { unset($HealthTips->Image3); }



/*
        if (file_exists($_FILES['Image2']['tmp_name']) && is_uploaded_file($_FILES['Image2']['tmp_name'])) {
            $file = date('ymdhis').$_FILES['Image2']['name'];
            $src = $_FILES['Image2']['tmp_name'];
            $dest = '../Uploads/'.$file;
            move_uploaded_file($src, $dest);
            $HealthTips->Image2 = $file;
        }else { unset($HealthTips->Image2); }




        if (file_exists($_FILES['Image3']['tmp_name']) && is_uploaded_file($_FILES['Image3']['tmp_name'])) {
            $file = date('ymdhis').$_FILES['Image3']['name'];
            $src = $_FILES['Image3']['tmp_name'];
            $dest = '../Uploads/'.$file;
            move_uploaded_file($src, $dest);
            $HealthTips->Image3 = $file;
        }else { unset($HealthTips->Image3); }*/


        /* END Upload Image For both SAVE & Update of News or Tips */

        if (isset($_POST["ID"]) && !empty($_POST["ID"])) {

            $HealthTips->LastUpdateDate = $this->HealthTipsRepo->GetCurrentDateTime();

                $GetImages = $this->HealthTipsRepo->GetById($_POST["ID"], "ID");

                $NewHealthTipsDetail = new HealthTips();

            $NewHealthTipsDetail->MapParameters($GetImages);

            if (file_exists('../Uploads/'.$NewHealthTipsDetail->Image1) && $NewHealthTipsDetail->Image1!='' && isset($HealthTips->Image1)){
                unlink('../Uploads/'.$NewHealthTipsDetail->Image1);
            }
            if (file_exists('Uploads/'.$NewHealthTipsDetail->Image2) && $NewHealthTipsDetail->Image2!=''  && isset($HealthTips->Image2)){
                unlink('../Uploads/'.$NewHealthTipsDetail->Image2);
            }
            if (file_exists('../Uploads/'.$NewHealthTipsDetail->Image3) && $NewHealthTipsDetail->Image3!=''  && isset($HealthTips->Image3)){
                unlink('../Uploads/'.$NewHealthTipsDetail->Image3);
            }


                $HealthTipsLog = HealthTipsLog::UpdateHealthTips($HealthTips);

                $status = $this->HealthTipsRepo->Update($HealthTips,$HealthTipsLog);

if($status) {
    $Slug = new Slug();
    $Slug->Content = 'HealthTips';
    $Slug->ContentID = $NewHealthTipsDetail->ID;
    $Slug->Slug = $HealthTips->Slug;

    $this->SlugRepo->Update($Slug);

}


            HealthTipsConfirmation::Update($status);

            } else {


                $HealthTips->AddedDate = $this->HealthTipsRepo->GetCurrentDateTime();

                $HealthTips->LastUpdateDate = $this->HealthTipsRepo->GetCurrentDateTime();

                $HealthTipsLog = HealthTipsLog::SaveHealthTips($HealthTips);

                $status = $this->HealthTipsRepo->Save($HealthTips,$HealthTipsLog);

if($status) {
    $Slug = new Slug();
    $Slug->Content = 'HealthTips';
    $Slug->ContentID = $status;
    $Slug->Slug = $HealthTips->Slug;

    $this->SlugRepo->Save($Slug);


}
            HealthTipsConfirmation::Save($status);
            }
        } else {

            ConfirmationDisplay::SetConfirmation($confirmation);

        }
    }
        Redirect("HealthTips");
        exit;

    }

    function ListAction()
    {
        $ajaxGrid = new AjaxGrid();

        $ajaxGrid->MapParameters($_GET);

        echo json_encode($this->HealthTipsRepo->FindAll($ajaxGrid));
    }

    function DeleteAction()
    {


        $HealthTipsDetails = $this->HealthTipsRepo->GetById($_POST["ID"]);

        $HealthTips= new HealthTips();

        $HealthTips->MapParameters($HealthTipsDetails);

         $HealthTipsLog =   HealthTipsLog::DeleteHealthTips($HealthTips);

        $status = $this->HealthTipsRepo->Delete($_POST["ID"]);

        if($status){

            $Slug = new Slug();
            $Slug->Content = 'HealthTips';
            $Slug->ContentID = $_POST["ID"];
            $this->SlugRepo->DeleteSlug($Slug);

            $this->HealthTipsRepo->SaveHealthTipsLog($HealthTipsLog);

        }

        HealthTipsConfirmation::Delete($status);

        Redirect("HealthTips");
    }


    function SetStatusAction()
    {

        $HealthTipsDetails = $this->HealthTipsRepo->GetById($_POST["ID"]);

        $HealthTips= new HealthTips();

        $HealthTips->MapParameters($HealthTipsDetails);

        if($_POST["Status"]==1){

            $HealthTips->Status = 0;
        } else {

            $HealthTips->Status = 1;
        }

        $HealthTipsLog =   HealthTipsLog::SetStatus($HealthTips);

        $status = $this->HealthTipsRepo->Update($HealthTips,$HealthTipsLog);

        if($status){
          echo '1';
        } else {
            echo '0';
        }


    }
}