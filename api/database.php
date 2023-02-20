<?php

    include_once("./env.php");

    function getDatabase() {
        try{
            return new PDO("mysql:port=".$_ENV['db_port'].";host=" . $_ENV['db_host'] . ";dbname=" . $_ENV['db_name'], $_ENV['db_user'], $_ENV['db_password']);
        } catch(PDOException $exception){
            return [ 'error' => $exception->getMessage()];
            exit;
        }
    }