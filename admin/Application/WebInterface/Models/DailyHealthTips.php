<?php

namespace WebInterface\Models;

use System\MVC\ModelAbstract;

class DailyHealthTips extends ModelAbstract
{
public $ID;
    
public  $Title;

public $Content;

public $Image1;

public $Image2;

public $AddedDate;

public $LastUpdateDate;

public $Hits;

public $Status;
}