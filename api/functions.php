<?php

    @include_once("./env.php");
    @include_once("./database.php");
    function uploadFile($name, $keywords, $location) {
        $errors = [];
        $success = [];
        for ($a = 0; isset($_FILES['files'.$a]); $a++) {
            if (!is_dir($_storage."/".implode("/", $location))) {
                mkdir($_storage."/".implode("/", $location), 0777, true);
            }
            $fullLocation = $_storage."/".implode("/", $location)."/".$_FILES['file'.$a]['name'].".file";
            $uploadSuccess = move_uploaded_file($_FILES['file'.$a]['tmp_name'], $fullLocation);
            if ($uploadSuccess) {
                $co = getDatabase();
                $stmt = $co->prepare("INSERT INTO files (name, location, size, integrity, keywords, filetype) VALUES (:name, :location, :size, :integrity, :keywords, :filetype)");
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":location", $location);
                $size = $_FILES['files'.$a]['size'];
                $stmt->bindParam(":size", $size);
                $integrity = hash_file("sha256", $fullLocation);
                $stmt->bindParam(":integrity", $integrity);
                $stmt->bindParam(":keywords", $keywords);
                $filetype = mime_content_type($fullLocation);
                $stmt->bindParam(":filetype", $filetype);
                try {
                    $stmt->execute();
                } catch (Exception $e) {
                    $errors[] = [ "filename" => $name, "error" => $e->getMessage() ];
                    continue;
                }

                $success[] = [ "filename" => $name, "id" => $stmt->lastInsertId() ];
            }
        }
        return [ "success" => $success, "errors" => $errors ];
    }

    function getFiles($search, $page) {
        $co = getDatabase();
        $query = "SELECT name, location, size, integrity, keywords, filetype FROM files";
        $wordSearch = explode(" ", $search);
        if (!empty($search)) {
            $query .= " WHERE keywords LIKE ";
        }
        foreach ($wordSearch as $key => $word) {
            $query.= "'%".$word."%' ";
            if (isset($word[$key+1]))
                $query .= "OR LIKE ";
        }
        $query .= "  LIMIT 100 OFFSET ".(100*($page-1));
        $stmt = $co->prepare($query);
        try {
            $stmt->execute();
            $allFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $allFiles;
        } catch (Exception $e) {
            return ["error" => $e->getMessage()];
        }
        
    }