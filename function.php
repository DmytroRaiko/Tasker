<?php

require_once './db/database.php';
$db= new Database();

function head ($postfix = NULL) {
    if ($postfix == NULL) {
        include "templates/head.php";
    } else {
        include "templates/head-" . $postfix . ".php";
    }
}

function site_header ($postfix = NULL) {
    if ($postfix == NULL) {
        include "templates/header.php";
    } else {
        include "templates/header-" . $postfix . ".php";
    }
}

function site_body ($postfix = NULL) {
    if ($postfix == NULL) {
        include "templates/body.php";
    } else {
        include "templates/body-" . $postfix . ".php";
    }
}

function site_task ($postfix = NULL) {
    if ($postfix == NULL) {
        include "templates/task.php";
    } else {
        include "templates/task-" . $postfix . ".php";
    }
}

function sign_form ($postfix = NULL) {
    if ($postfix == NULL) {
        include "templates/sign_form.php";
    } else {
        include "templates/sign_form-" . $postfix . ".php";
    }
}

function site_footer ($postfix = NULL) {
    if ($postfix == NULL) {
        include "templates/footer.php";
    } else {
        include "templates/footer-" . $postfix . ".php";
    }
}


function get_info_project() {
    global $db;
    return $db -> query(
        "SELECT tasks.TaskID as 'id', tasks.Title  as 'title', tasks.DataTaskStart as 'datestart', tasks.DataTaskFinish as 'dateend', tasks.ParentTaskID, tasks.Status, tasks.Descriptions as 'description', tasks.NotificationID, tasks.DocumentLink, employees.Name, employees.Surname 
        FROM tasks INNER JOIN tasklist 
                        ON tasks.TaskID = tasklist.TaskID 
                            INNER JOIN employees 
                                ON tasklist.EmployeeID=employees.EmployeeID
            WHERE employees.EmployeeID = :id",
        [
            ':id' => 1
        ]
        );

 }



?>