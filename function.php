<?php
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

function get_info_project($user)
{
    require_once './db/database.php';
    $db = new Database();
    return $db->query(
        "SELECT TaskID as 'id', Title as 'title', Type as 'type', DataTaskStart as 'datastart', DataTaskFinish as 'dataend', Descriptions as 'description', Status as 'status', replyDocuments, replyLinks, ParentTaskID, ProjectID 
        FROM tasks 
        WHERE TaskID 
        IN (SELECT tasks.ProjectID FROM tasks INNER JOIN tasklist ON tasks.TaskID=tasklist.TaskID WHERE tasklist.EmployeeID=:empId);",
        [
            ':empId' => $user
        ]
    );
}

function get_info_task($user, $project)
{
    require_once './db/database.php';
    $db = new Database();
    return $db->query(
       "SELECT tasks.TaskID as 'id', Title as 'title', Type as 'type', DataTaskStart as 'datastart', DataTaskFinish as 'dataend', ParentTaskID, ProjectID as 'projectid', 
       Status as 'status', Descriptions as 'description', replyDocuments, replyLinks, e.EmployeeID, m.Name as 'mname', m.Surname as 'msurname', 
       e.Name as 'ename', e.Surname as 'esurname', 
       (SELECT Title FROM tasks WHERE ProjectID=:pr AND Type='project') as 'projectname' 
       FROM tasks 
       JOIN tasklist 
       ON tasks.TaskID=tasklist.TaskID 
       INNER JOIN employees e 
       ON tasklist.EmployeeID=e.EmployeeID 
       INNER JOIN employees m 
       ON e.ManagerID=m.EmployeeID 
       WHERE ProjectID =:pr AND tasklist.EmployeeID =:user AND tasks.type!='project'",
       [
           ':pr'   => $project,
           ':user' => $user
       ]
    );
}
