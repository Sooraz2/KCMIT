<?php

namespace WebInterface\Modules\ReportBug;


use Admin\Repositories\MenuControlRepository;
use Infrastructure\SessionVariables;
use Repositories\LoginUserTableRepository;
use System\MVC\Controller;
use WebInterface\ViewModel\ReportBug;


class ReportBugController extends Controller
{

    function __construct()
    {
        parent::__construct();

        $this->Loginuser = new LoginUserTableRepository();

        $this->MenuControl = new MenuControlRepository();
    }

    function IndexAction()
    {

        if (isset($_POST['PageName']) && $_POST['Subject'] != "") {
            $loginUser = $this->Loginuser->GetById($_SESSION[SessionVariables::$UserID]);

            $UserName = $loginUser->Name;
            $Email = $loginUser->Email;

            $reportBug = new ReportBug();

            $reportBug->MapParameters($_POST);

            $messageBody = "";

            $messageBody .= "<br/><br/><strong>{$this->language->translate('Bug Report')} : </strong>";
            $messageBody .= "<br/><br/>{$this->language->translate('First Name')} : $reportBug->FirstName";
            $messageBody .= "<br/><br/>{$this->language->translate('Email')}: $reportBug->Email";
            $messageBody .= "<br/><br/>{$this->language->translate('Page Name')}: $reportBug->PageName";
            $messageBody .= "<br/><br/>{$this->language->translate('Language Version')}: $reportBug->LanguageVersion";
            $messageBody .= "<br/><br/>{$this->language->translate('Subject')}: $reportBug->Subject";
            $messageBody .= "<br/><br/>{$this->language->translate('Steps')}: " . str_replace("\n", "<br />", $reportBug->Steps);
            $messageBody .= "<br/><br/>{$this->language->translate('Desired Behaviour')}: $reportBug->DesiredBehaviour";
            $messageBody .= "<br/><br/>{$this->language->translate('Can Duplicate')}: $reportBug->CanDuplicate";
            $messageBody .= "<br/><br/>{$this->language->translate('Frequency')}: $reportBug->Frequency";

            $this->load->Library("PHPMailerAutoload", "PHPMailer");

            $mail = new \PHPMailer;

            $mail->CharSet = "UTF-8";

            if (isset($_FILES["AttachFile"]) && $_FILES["AttachFile"]['size'] > 0) {

                $file = $_FILES["AttachFile"]["tmp_name"];
                $filename = $_FILES["AttachFile"]["name"];
                $destination = "uploads/$filename";
                $uploaded = move_uploaded_file( $file, $destination);
                $messageBody .= "<br/><br/> {$this->language->translate('Please find attachment')}";
                $mail->AddAttachment( $destination, $filename);

            }

            $mail->isSMTP();

            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            // $mail->SMTPDebug = 2;

            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';

            //Set the hostname of the mail server
            $mail->Host = '10.8.1.1';

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 25;

            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "l.shrestha@unifun.com";

            //Password to use for SMTP authentication
            $mail->Password = "4C26Giq2K1z56wr";


            $NameFrom = "Bug Report Unifun";
            $EmailFrom = "bugreport@unifun";

            //Set who the message is to be sent from
            $mail->setFrom($NameFrom, $EmailFrom);

            $mail->addAddress("balance+@unifun.com", "Balance+ Team");
            //Set who the message is to be sent to
            //Set the subject line
            $mail->Subject = 'Balance+ Bug Report - UMS';

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            //$mail->msgHTML("New Message");
            $mail->msgHTML($messageBody);

            //Replace the plain text body with one created manually
//        $mail->AltBody = 'This is a plain-text message body';


            //send the message, check for errors
            if (!$mail->send()) {
                $_SESSION[SessionVariables::$ConfirmationMessage]= $this->language->FailedSendingBugReport;
                $_SESSION[SessionVariables::$ConfirmationMessageType] = "Failed";
            }else {
                $_SESSION[SessionVariables::$ConfirmationMessage]= $this->language->SuccessfullySentBugReport;
                $_SESSION[SessionVariables::$ConfirmationMessageType] = "Success";
            }
            if(file_exists( isset($destination) && $destination))
                unlink($destination);
        }
        $redirectURI =  $_POST["redirectUrl"];

        if(isset($_COOKIE['LastVisitedUrl']) && $_COOKIE['LastVisitedUrl']!='') {

            $redirectURI = $_COOKIE['LastVisitedUrl'];
            $redirectURI =   str_replace('/','',$redirectURI);
        }

        Redirect($redirectURI);


    }


    function FormAction()
    {
        $AdminCondition = "";
        if ($_SESSION['UserType'] == 2) {

            $AdminCondition = " Administrator=1";

        } else if ($_SESSION['UserType'] == 3) {
            $AdminCondition = " Moderator=1";

        } else if ($_SESSION['UserType'] == 4) {

            $AdminCondition = " CustomerCare=1";

        }
        $AccessedMenu = array();
        if ($_SESSION['UserType'] != 1) {
            $MenuControl = $this->MenuControl->FindAllByAdminType($AdminCondition);


            foreach ($MenuControl as $key => $menu) {

                $AccessedMenu[] = $menu['MenuSlug'];

            }

        }


        $pattern["redirectUrl"] = substr($_GET["RedirectUrl"], strrpos($_GET["RedirectUrl"], "/") + 1);
        $pattern['AccessedMenu'] = $AccessedMenu;
        $pattern['AdminType'] = $_SESSION['UserType'];


        $this->load->View("ReportBug/Form", $pattern);

    }
}