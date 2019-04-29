<?php

namespace Application\Config;

class ConnectionHelper extends DbConfig
{
    function __construct()
    {
        parent::__construct();
    }

    function dbConnect()
    {
        $db = new \PDO("mysql:host={$this->databaseConnection->ServerName};dbname={$this->databaseConnection->DatabaseName}"
            , $this->databaseConnection->Username, $this->databaseConnection->Password, array(
                \PDO::MYSQL_ATTR_LOCAL_INFILE => true));


        $db->exec("SET CHARACTER SET utf8");
        $db->exec("SET NAMES utf8");

        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $db->exec("USE {$this->databaseConnection->DatabaseName};");



        return $db;
    }
}