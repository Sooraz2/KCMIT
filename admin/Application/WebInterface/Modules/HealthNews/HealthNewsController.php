<?php

namespace WebInterface\Modules\HealthNews;


use Infrastructure\ConfirmationDisplay;
use Language\English\Logs;
use Infrastructure\SessionVariables;
use Repositories\SlugRepository;
use Shared\Controllers\WebInterfaceControllerAbstract;
use Shared\Model\AjaxGrid;
use Shared\Model\LoginUserLog;
use WebInterface\Models\HealthNews;
use Infrastructure\PHPFormToken;
use WebInterface\Models\Slug;


class HealthNewsController extends WebInterfaceControllerAbstract
{



    function __construct()
    {

        parent::__construct();

        $this->HealthNewsRepo = new HealthNewsRepository();

        $this->HealthNewsValidator = new HealthNewsValidator();

        $this->HealthNewsParameter = new HealthNewsParameter();

        $this->FormToken = new PHPFormToken();

        $this->SlugRepo = new SlugRepository();

    }

    function IndexAction()
    {

        $this->load->View("HealthNews/Index");
    }

    function FormAction()
    {
        $this->load->View("HealthNews/Form", $this->HealthNewsParameter->Form());

    }

    function CheckSlugAction(){

        $response = array();

        $response[0] = $_GET["fieldId"];

        $id = 0;

        if(isset($_GET['ContentID'])){

        $id = $_GET['ContentID'];

        }


        $response[1] =$this->SlugRepo->CheckSlug($_GET['fieldValue'], $id) > 0 ? false : true;

        echo json_encode($response);

    }

    function SaveUpdateFormAction()
    {

        $confirmation = $this->HealthNewsValidator->ValidateHealthNewsSubmit($_POST);

        if($this->FormToken->GetFormToken("HealthNewsFormToken") == $_POST['HealthNewsFormToken']) {

            $this->FormToken->UnsetFormToken("HealthNewsFormToken");

        if ($confirmation->MessageType == "Success") {

        $HealthNews = new HealthNews();

        $HealthNews->MapParameters($_POST);


/* Upload Image For both SAVE & Update of News or Tips */
            /* Upload Image For both SAVE & Update of News or Tips */
           if (file_exists($_FILES['Image1']['tmp_name']) && is_uploaded_file($_FILES['Image1']['tmp_name'])) {
                $file = explode('.',$_FILES['Image1']['name']);
                $dest1 = $file[0].'Large'.date('Ymdhis').'.'.end($file);
                $src = $_FILES['Image1']['tmp_name'];
                $dest = '../Uploads/'.$dest1;
                move_uploaded_file($src, $dest);
                $HealthNews->Image1 = $dest1;
            }else { unset($HealthNews->Image1); }


            if (file_exists($_FILES['Image2']['tmp_name']) && is_uploaded_file($_FILES['Image2']['tmp_name'])) {
                $file = explode('.',$_FILES['Image2']['name']);
                $dest2 = $file[0].'Medium'.date('Ymdhis').'.'.end($file);
                $src = $_FILES['Image2']['tmp_name'];
                $dest = '../Uploads/'.$dest2;
                move_uploaded_file($src, $dest);
                $HealthNews->Image2 = $dest2;
            }else {
                unset($HealthNews->Image2);
            }


                if (file_exists($_FILES['Image3']['tmp_name']) && is_uploaded_file($_FILES['Image3']['tmp_name'])) {
                    $file = explode('.',$_FILES['Image3']['name']);
                    $dest3 = $file[0].'Small'.date('Ymdhis').'.'.end($file);
                    $src = $_FILES['Image3']['tmp_name'];
                    $dest = '../Uploads/'.$dest3;
                    move_uploaded_file($src, $dest);
                    $HealthNews->Image3 = $dest3;
                }else { unset($HealthNews->Image3); }



        /* END Upload Image For both SAVE & Update of News or Tips */

        if (isset($_POST["ID"]) && !empty($_POST["ID"])) {

            $HealthNews->LastUpdateDate = $this->HealthNewsRepo->GetCurrentDateTime();

                $GetImages = $this->HealthNewsRepo->GetById($_POST["ID"], "ID");

                $NewHealthNewsDetail = new HealthNews();

            $NewHealthNewsDetail->MapParameters($GetImages);
//dd($NewHealthNewsDetail);
            if (file_exists('../Uploads/'.$NewHealthNewsDetail->Image1) && $NewHealthNewsDetail->Image1!='' && isset($HealthNews->Image1)){
                unlink('../Uploads/'.$NewHealthNewsDetail->Image1);
            }
            if (file_exists('../Uploads/'.$NewHealthNewsDetail->Image2) && $NewHealthNewsDetail->Image2!=''  && isset($HealthNews->Image2)){
                unlink('../Uploads/'.$NewHealthNewsDetail->Image2);
            }
            if (file_exists('uploads/'.$NewHealthNewsDetail->Image3) && $NewHealthNewsDetail->Image3!=''  && isset($HealthNews->Image3)){
                unlink('../Uploads/'.$NewHealthNewsDetail->Image3);
            }

                $HealthNewsLog = HealthNewsLog::UpdateHealthNews($HealthNews);

                $status = $this->HealthNewsRepo->Update($HealthNews,$HealthNewsLog);

                $Slug = new Slug();
                $Slug->Content = 'HealthTips';
                $Slug->ContentID = $NewHealthNewsDetail->ID;
                $Slug->Slug = $HealthNews->Slug;
                $this->SlugRepo->Update($Slug);


            HealthNewsConfirmation::Update($status);

            } else {

                $HealthNews->AddedDate = $this->HealthNewsRepo->GetCurrentDateTime();

                $HealthNews->LastUpdateDate = $this->HealthNewsRepo->GetCurrentDateTime();

                $HealthNewsLog = HealthNewsLog::SaveHealthNews($HealthNews);

                $status = $this->HealthNewsRepo->Save($HealthNews,$HealthNewsLog);

                $Slug = new Slug();
                $Slug->Content = 'HealthTips';
                $Slug->ContentID =$status;
                $Slug->Slug = $HealthNews->Slug;
                $this->SlugRepo->Save($Slug);

                HealthNewsConfirmation::Save($status);

            }
        } else {

            ConfirmationDisplay::SetConfirmation($confirmation);

        }
    }
        Redirect("HealthNews");
        exit;

    }

    function ListAction()
    {
        $ajaxGrid = new AjaxGrid();

        $ajaxGrid->MapParameters($_GET);

        echo json_encode($this->HealthNewsRepo->FindAll($ajaxGrid));
    }

    function DeleteAction()
    {

        $healthNewsDetails = $this->HealthNewsRepo->GetById($_POST["ID"]);

        $healthNews= new HealthNews();

        $healthNews->MapParameters($healthNewsDetails);

         $healthNewsLog =   HealthNewsLog::DeleteHealthNews($healthNews);

        $status = $this->HealthNewsRepo->Delete($_POST["ID"]);
        if($status){

            $Slug = new Slug();
            $Slug->Content = 'HealthTips';
            $Slug->ContentID = $_POST["ID"];
            $this->SlugRepo->DeleteSlug($Slug);

            $this->HealthNewsRepo->SaveHealthNewsLog($healthNewsLog);

        }

        HealthNewsConfirmation::Delete($status);

        Redirect("HealthNews");
    }


    function SetStatusAction()
    {

        $healthNewsDetails = $this->HealthNewsRepo->GetById($_POST["ID"]);

        $healthNews= new HealthNews();

        $healthNews->MapParameters($healthNewsDetails);

        if($_POST["Status"]==1){

            $healthNews->Status = 0;
        } else {

            $healthNews->Status = 1;
        }

        $HealthNewsLog =   HealthNewsLog::SetStatus($healthNews);

        $status = $this->HealthNewsRepo->Update($healthNews,$HealthNewsLog);

        if($status){
          echo '1';
        } else {
            echo '0';
        }


    }
}