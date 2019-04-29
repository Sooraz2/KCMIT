<?php

namespace System\MVC;

use Infrastructure\LanguageLog;
use Infrastructure\MessageLog;
use Admin\Repositories\LoginUserRepository;
use Repositories\MenuControlTableRepository;
use System\Core\Loader;


abstract class Controller
{
    private static $instance;
    protected $language;
    public $loginUserRepoObj;
    public function __construct()
    {
        global $langConfig;
        $this->language = $langConfig->languageClass;

        self::$instance =& $this;
        $this->load = new Loader();

        LanguageLog::SetLog();
        MessageLog::SetMessage();

        $MenuControlRepo = new MenuControlTableRepository();
        global $uri;

        $parts = trim($uri, '/');
        $parts = explode('/', $parts);

        $slug = array_shift($parts);
        if (isset($_SESSION["UserType"])):
            switch ($_SESSION["UserType"]):
                case(1):
                    $UserType = "Administrator";
                    break;

                case(2):
                    $UserType = "Moderator";
                    break;
                case(3):
                    $UserType = "Operator";
                    break;
                case(4):
                    $UserType = "CustomerCare";
                    break;
                default:
                    $UserType = "";
                    break;
            endswitch;

            if ($UserType == "Administrator" || $UserType == "Operator" || $slug == "LogOut" || $slug == "Login" || $slug == "ChangePassword") {

            } else {

                $count = $MenuControlRepo->Count(array("MenuSlug" => $slug, $UserType => 1));

                if( property_exists($this->load->configArray->AllocationCriteria,$slug) ||
                    property_exists($this->load->configArray->BlackListControllers,$slug)){

                    $count->Count = 1;

                }

                $param = array("slug"=>$slug);
                if ($count->Count == "0") {
                    $this->load->View('NoAccess/Index',$param);
                    exit;
                }
            }
        endif;
    }

    protected function CheckIfPasswordExpired($userID, $redirectURI="ActiveTeasers"){
        $this->loginUserRepoObj = new LoginUserRepository();
        $passwordExpired = $this->loginUserRepoObj->CheckPasswordExpiry($userID);
        if(!!$passwordExpired->Expired){
            $this->load->View('Login/ChangePassword', array("RedirectURI"=>$redirectURI));
            exit;
        }
    }

}