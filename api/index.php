<?php

    session_start();

    include_once("env.php");
    include_once("actions.php");

    $bodyReceived = file_get_contents("php://input");
    $body = json_decode($bodyReceived, true);
    if (!$body && count($_POST)) {
        $body = $_POST;
    }

    switch ($body['action']) {
        case 'login':
            login($body['mail'], $body['password']);
        break;
        default:
            if (isset($_SESSION['login']))
              loggedInActions($body);
        break;
    }
?>