<?php
session_start();
require_once "../../../function.php";
require_once "../../../db/database.php";
$db = new Database();

if (isset($_POST['adding-comment'])) {
    if (!empty($_POST['adding-comment']) && !empty($_POST['user'])) {
        if ((!empty($_FILES['file']) && isset($_FILES['file'])) || (!empty($_POST['text']) && isset($_POST['text']))) {
            $task = $_POST['adding-comment'];
            $user = $_POST['user'];
            $text = NULL;
            $file = NULL;


            if (!empty($_FILES['file']) && isset($_FILES['file'])) {

                $file = upload_documents ($_FILES['file']['name'], $_FILES['file']['tmp_name'], 'tasks', $task, 0, true);
            }

            if (!empty($_POST['text']) && isset($_POST['text'])) {
                $text = $_POST['text'];
            }


            $db->query(
                "INSERT INTO `Activity`(`TaskID`, `Text`, `EmployeeID`, `Type`, `DateTime`, `File`) 
                VALUES (:task, :text, :emp, :type, :time, :file)
                ",
                [
                    ':task' => $task,
                    ':text' => $text,
                    ':emp'  => $user,
                    ':type' => 'comment',
                    ':time' => date('Y-m-d G:i:s'), 
                    ':file' => $file
                ]
            );

            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 3;
    }
}

if (isset($_POST['delete-activity'])) {

    if (!empty($_POST['delete-activity'])) {

        $sql = $db->query(
                "SELECT TaskID, File 
                FROM Activity
                WHERE ActivityID = :ActivityID",
            [
                ':ActivityID'   => $_POST['delete-activity']
            ]
        );

        $db->query(
            "DELETE FROM `Activity` WHERE `ActivityID`=:act",
            [
                ':act' => $_POST['delete-activity']
            ]
        );

        if ($sql[0]['File'] != NULL) {
            $file = "../../../documents/tasks/".$sql[0]['TaskID']."/comments/".$sql[0]['File'];
            if (file_exists($file)) {
                unlink($file);
            }
        }

        echo 1;
    } else {
        echo 2;
    }
}