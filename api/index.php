<?php

    session_start();

    include_once("env.php");
    include_once("actions.php");

    switch ($_POST['action']) {
        case 'login':
            login($_POST['mail'], $_POST['password']);
        break;
        default:
            loggedInActions($_POST);
        break;
    }
?>