<?php

namespace WebInterface\Models;

use System\MVC\ModelAbstract;

class SessionsArchive extends ModelAbstract
{
    public $id;

    public $datetime;

    public $sessionID;

    public $subscriber;

    public $shank_id;

    public $is_activated;

    public $last_answer;

    public $last_input;

    public $dialogID;

    public $status;

    public $balance;

    public $blacklist;

    public $carem_answer;

    public $teaser_answer;

}