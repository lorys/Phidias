<?php

    @include_once("./env.php");

    @include_once("./functions.php");
    
    function login($mail, $password) {
        $users = json_decode(file_get_contents("./users.json"));
        $mail = strtolower($mail);
        if (!isset($users[$mail])) {
            echo "Email doesn't exists";
            exit;
        }
        if ($users[$mail] === md5(sha1($password))) {
            $_SESSION['user'] = $mail;
            echo "success";
        }
    }

    function loggedInActions($body) {
        switch ($body['action']) {
            case 'upload':
                echo json_encode(uploadFile($body['name'], $body['keywords'], $body['location']));
                exit;
            break;
            case 'list':
                echo json_encode(getFiles());
                exit;
            break;
            default:
                echo "No action recognized";
                exit;
            break;
        }
    }