<?php

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
                for ($a = 0; isset($_FILES['files'][$a]); $a++) {
                    if (!is_dir($_storage."/".implode("/", $body['path']))) {
                        mkdir($_storage."/".implode("/", $body['path']), 0777, true);
                    }
                    $uploadSuccess = move_uploaded_file($_FILES['file'.$a]['tmp_name'], $_storage."/".implode("/", $body['path'])."/".$_FILES['file'.$a]['name'].".file");
                    if ($uploadSuccess)
                        file_put_contents($_storage."/".implode("/", $body['path'])."/".$_FILES['file'.$a]['name'].".details", json_encode(["details" => $body['details'], "fileDetails" => $_FILES['file'+$a]]));
                }
                echo "success";
                exit;
            break;
            case 'list':
                echo json_encode(glob($_storage."/".implode("/", $body['path'])."/*"));
                exit;
            break;
            default:
                echo "No action recognized";
                exit;
            break;
        }
    }