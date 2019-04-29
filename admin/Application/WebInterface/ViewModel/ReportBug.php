<?php
/**
 * Created by PhpStorm.
 * User: Love Shankar Shresth
 * Date: 12/8/2015
 * Time: 5:44 PM
 */

namespace WebInterface\ViewModel;


use System\MVC\ModelAbstract;

class ReportBug extends ModelAbstract
{

    public $PageName;

    public $LanguageVersion;

    public $Subject;

    public $Steps;

    public $DesiredBehaviour;

    public $CanDuplicate;

    public $Frequency;

    public $AttachFile;

    public $FirstName;

    public $Email;


}