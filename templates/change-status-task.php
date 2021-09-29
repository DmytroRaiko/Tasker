<?php
require_once "../db/database.php";
$db = new Database();

if (isset($_POST['id']) && !empty($_POST['id']) 
        && isset($_POST['status']) && !empty($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $db->query(
        "UPDATE `tasks` 
        SET `Status` = :status
        WHERE `TaskID` = :id",
        [
            ':id'       => $id,
            ':status'   => $status
        ]
    );

    echo 1;
} else {
    echo 2;
}