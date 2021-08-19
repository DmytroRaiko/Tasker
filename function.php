<?php

require_once './db/database.php';
$db = new Database();

function head($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/head.php";
    } else {
        include "templates/head-" . $postfix . ".php";
    }
}

function site_header($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/header.php";
    } else {
        include "templates/header-" . $postfix . ".php";
    }
}

function site_body($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/body.php";
    } else {
        include "templates/body-" . $postfix . ".php";
    }
}

function site_task($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/task.php";
    } else {
        include "templates/task-" . $postfix . ".php";
    }
}

function sign_form($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/sign_form.php";
    } else {
        include "templates/sign_form-" . $postfix . ".php";
    }
}

function site_footer($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/footer.php";
    } else {
        include "templates/footer-" . $postfix . ".php";
    }
}


function get_info_project()
{
    global $db;
    return $db->query(
        "SELECT TaskID as 'id', Title as 'title', Type as 'type', DataTaskStart as 'datastart', DataTaskFinish as 'dataend', Descriptions as 'description', Status as 'status', replyDocuments, replyLinks, ParentTaskID, ProjectID 
        FROM tasks 
        WHERE TaskID 
        IN (SELECT tasks.ProjectID FROM tasks INNER JOIN tasklist ON tasks.TaskID=tasklist.TaskID WHERE tasklist.EmployeeID=1);"
    );
}

function get_info_task()
{
    global $db;
    return $db->query(
       "SELECT tasks.TaskID as 'id', Title as 'title', Type as 'type', DataTaskStart as 'datastart', DataTaskFinish as 'dataend', ParentTaskID, ProjectID, Status as 'status', Descriptions as 'description', replyDocuments, replyLinks, e.EmployeeID, m.Name as 'mname', m.Surname as 'msurname', e.Name as 'ename', e.Surname as 'esurname', (SELECT Title FROM tasks WHERE ProjectID=1 AND Type='project') as 'projectname' FROM tasks JOIN tasklist ON tasks.TaskID=tasklist.TaskID INNER JOIN employees e ON tasklist.EmployeeID=e.EmployeeID INNER JOIN employees m ON e.ManagerID=m.EmployeeID WHERE ProjectID = 1 AND tasklist.EmployeeID =1"
    );
}
