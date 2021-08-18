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

function site_modal ($postfix) {
    include "templates/modal/". $postfix . ".php";
}

function date_format_custom ($date) {

    $time = Date('H:i', strtotime($date));
    $notification_time = strtotime($date);
    $now = time();

    $notification_date = Date("d.m.Y", $notification_time);
    $today_date = Date("d.m.Y", $now);
    $raz = $now - $notification_time;   

    if ($raz < 60) {
        // output seconds (5 seconds ago)
        if ($notification_date == $today_date) {
            return $time = $raz . " seconds ago";
        } else {
            return "yesterday, " . $time;
        }
    } else if ($raz < 60 * 60) {
        // output minutes (5 minutes ago)
        if ($notification_date == $today_date) {
            return floor($raz/60) . " minutes ago";

        } else {
            return "yesterday, " . $time;
        }
    } else if ($raz < 60 * 60 * 24) {
        // output today (today, time)
        if ($notification_date == $today_date) {
            return floor($raz/60/60) . " hours ago";
        } else {
            return "yesterday, " . $time;
        }
    } else if ($raz < 60 * 60 * 24 * 2) {
        // output yesterday (yesterday, time)
        if ($notification_date == $today_date) {
            return "yesterday, " . $time;
        } else {
            return "1 days ago";
        }
    } else if ($raz < 60 * 60 * 24 * 7) {
        // output days ago (5 days ago)
        return floor($raz/60/60/24) . " days ago";
    } else {
        // output datatime 
        return  date('d.m.Y', strtotime($date)) . ', ' . $time;
    }
}

function upload_documents ($file, $tmp, $dir_type, $recording_id, $index){

    $path = '../../../documents';
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $path = '../../../documents/' . $dir_type;
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $path = '../../../documents/' . $dir_type . '/' . $recording_id;
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $position_dots = strripos ($file, '.');

    $name = substr($file, 0, $position_dots) . '[' . hash('ripemd160', $index . time()) . ']' . substr($file, $position_dots, strlen($file) -1);
    $new_file = $path . '/' . $name;
    copy($tmp, $new_file);

    return $name;
  }

function get_info_project()
{
    global $db;
    return $db->query(
        "WITH recursive project_name (TaskID, title, type, ParentTaskID, DataTaskStart, DataTaskFinish, Status, Descriptions, DocumentLink, lvl, path, ManagerID)
        AS (SELECT tasks.TaskID, title, type, ParentTaskID, DataTaskStart, DataTaskFinish, Status, Descriptions, DocumentLink, @lvl := @lvl + 1, CAST(employees.surname as varchar(300)), employees.ManagerID
       FROM tasks
        INNER JOIN tasklist 
       ON tasks.TaskID=tasklist.TaskID 
       INNER JOIN employees
       ON tasklist.EmployeeID=employees.EmployeeID 
       WHERE employees.ManagerID IS NULL 
       UNION ALL 
       SELECT t.TaskID, t.Title, t.type, t.ParentTaskID, t.DataTaskStart, t.DataTaskFinish, t.Status, t.Descriptions, t.DocumentLink, p.lvl + 1, CONCAT(path, '/', m.Surname), m.ManagerID
        FROM project_name AS p
       JOIN tasks AS t 
       ON p.ParentTaskID=t.TaskID 
       JOIN tasklist ON t.TaskID=tasklist.TaskID
       JOIN employees m ON tasklist.EmployeeID=m.EmployeeID
       WHERE p.ManagerID=m.EmployeeID AND m.EmployeeID=1)
       SELECT project_name.TaskID as 'id', project_name.type as 'type', project_name.title as 'title', project_name.ParentTaskID as 'parenttaskid',  project_name.DataTaskStart as 'datastart', project_name.DataTaskFinish as 'datafinish', project_name.Status as 'status', project_name.Descriptions as 'descriptions', project_name.DocumentLink as 'link', project_name.path as 'path'FROM project_name
       WHERE project_name.type='project' AND project_name.ParentTaskID IS NULL;"
    );
}

function get_info_task()
{
    global $db;
    return $db->query(
        "WITH RECURSIVE project (TaskID, Title, Type, DataTaskStart, DataTaskFinish, Status, Descriptions, DocumentLink, lvl, pro)
         as ( SELECT TaskID, Title, Type,DataTaskStart, DataTaskFinish, Status, Descriptions, DocumentLink, @lvl := @lvl + 1, CAST(Title as varchar(50))
              FROM tasks 
              WHERE ParentTaskID IS NULL 
                UNION ALL SELECT tasks.TaskID, tasks.Title, tasks.Type, tasks.DataTaskStart, tasks.DataTaskFinish,
                                 tasks.Status, tasks.Descriptions, tasks.DocumentLink, project.lvl + 1, CONCAT(pro) 
                FROM project JOIN tasks ON project.TaskID = tasks.ParentTaskID ) 
                    SELECT project.Title AS 'title', lvl as 'lvl' , pro as 'pro', project.TaskID as 'id', project.Type as 'type', project.DataTaskStart as 'datastart', 
                           project.DataTaskFinish as 'datafinish', project.Status as 'status', project.Descriptions as 'description', project.DocumentLink as 'documentlink', 
                           e.Name as 'empname', e.Surname as 'empsurname', m.Name as 'mname', m.Surname as 'msurname' 
                    FROM project JOIN tasks 
                                    ON project.TaskID = tasks.TaskID 
                                 JOIN tasklist 
                                    ON tasks.TaskID=tasklist.TaskID 
                                 INNER JOIN employees e 
                                    ON tasklist.EmployeeID=e.EmployeeID 
                                 INNER JOIN employees m 
                                    ON e.ManagerID=m.EmployeeID 
                    WHERE e.EmployeeID= 1
                    ORDER BY lvl, pro;"
    );
}
