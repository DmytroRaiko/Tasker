<?php
$array_tasks = [];
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

function site_office($postfix = NULL)
{
    if ($postfix == NULL) {
        include "templates/office.php";
    } else {
        include "templates/office-" . $postfix . ".php";
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

function upload_documents ($file, $tmp, $dir_type, $recording_id, $index, $comment=false){

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

    if ($comment) {
        $path = '../../../documents/' . $dir_type . '/' . $recording_id . '/comments';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    $position_dots = strripos ($file, '.');
    
    $name = substr($file, 0, $position_dots) . '[' . hash('ripemd160', $index . time()) . ']' . substr($file, $position_dots, strlen($file) -1);
    $new_file = $path . '/' . $name;
    copy($tmp, $new_file);

    return $name;
  }

function get_info_full_project($user)
{
    require_once './db/database.php';
    $db = new Database();
    return $db->query(
        "SELECT TaskID as 'id', Title as 'title', Type as 'type', DataTaskStart as 'datastart', DataTaskFinish as 'dataend', Descriptions as 'description', Status as 'status', replyDocuments, replyLinks, ParentTaskID, ProjectID 
        FROM tasks 
        WHERE TaskID 
        IN (SELECT tasks.ProjectID FROM tasks INNER JOIN tasklist ON tasks.TaskID=tasklist.TaskID WHERE tasklist.EmployeeID=:empId)",
        [
            ':empId'     => $user
        ]
    );
}

function get_info_project($user, $offset, $size_page)
{
    require_once './db/database.php';
    $db = new Database();
    return $db->query(
        "SELECT TaskID as 'id', Title as 'title', Type as 'type', DataTaskStart as 'datastart', DataTaskFinish as 'dataend', Descriptions as 'description', Status as 'status', replyDocuments, replyLinks, ParentTaskID, ProjectID 
        FROM tasks 
        WHERE TaskID 
        IN (SELECT tasks.ProjectID FROM tasks INNER JOIN tasklist ON tasks.TaskID=tasklist.TaskID WHERE tasklist.EmployeeID=:empId)
        LIMIT ".$offset.", ".$size_page,
        [
            ':empId'     => $user
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

function ShowTree($project, $ParentID, $user){ 
    require_once './db/database.php'; 
    global $db, $array_tasks;
    $db = new Database();
 
    if ($ParentID == NULL) { 
        $sql = $db->query( 
            "SELECT tasks.TaskID as 'id', tasks.Title as 'title', tasks.Type as 'type', tasks.DataTaskStart as 'datastart', tasks.DataTaskFinish as 'dataend', 
            tasks.ParentTaskID as 'pid', tasks.ProjectID as 'projectid', tasks.Status as 'status', tasks.replyDocuments as 'doc', tasks.Descriptions as 'description',
            tasks.replyLinks as 'links', employees.Name as 'name', employees.Surname as 'surname' 
            FROM tasks INNER JOIN tasklist ON tasks.TaskID=tasklist.TaskID 
            INNER JOIN employees ON tasklist.EmployeeID=employees.EmployeeID 
 
            WHERE  employees.EmployeeID=:user And tasks.Type IN ('task', 'project') AND tasks.ProjectID = :project; 
            ",   
            [ 
                ':user'     => $user, 
                ':project'  => $project 
            ] 
        ); 
    } else { 
        $sql = $db->query( 
            "SELECT tasks.TaskID as 'id', tasks.Title as 'title', tasks.Type as 'type', tasks.DataTaskStart as 'datastart', tasks.DataTaskFinish as 'dataend',
             tasks.ParentTaskID as 'pid', tasks.ProjectID as 'projectid', tasks.Status as 'status', tasks.replyDocuments as 'doc', tasks.Descriptions as 'description',
             tasks.replyLinks as 'links', employees.Name as 'name', employees.Surname as 'surname' 
            FROM tasks INNER JOIN tasklist ON tasks.TaskID=tasklist.TaskID 
            INNER JOIN employees ON tasklist.EmployeeID=employees.EmployeeID 
 
            WHERE tasks.ParentTaskID = :pid AND tasks.ProjectID = :project; 
            ",   
            [ 
                ':pid'      => $ParentID, 
                ':project'  => $project 
            ] 
        ); 
    } 
    for($i = 0; $i < count($sql); $i++) :  
        $k = 0; 
        if ($k == 0 && $ParentID == NULL) {
            if (!in_array($sql[$i]['id'], $array_tasks)) echo '<ul class="margin-left-none"> <div class="vertical-line"></div>   <div class="card-office-block text-9">'; 
        } else if (!in_array($sql[$i]['id'], $array_tasks)) echo '<ul> <div class="vertical-line"></div> <div class="horizontal-line"></div>   <div class="card-office-block text-9">'; 
        if (!in_array($sql[$i]['id'], $array_tasks)) {
            echo '<li class="view-task" data-task-id="'.$sql[$i]['id'].'">   
                <div class="card-office-block-main">  
                    <div class="card-office-block-title">' . $sql[$i]['title'] .' 
                    </div>  
                        <hr>  
                    <div class="card-office-block-executor">  
                        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                            <path d="M13.7645 10.4503C13.4955 10.1773 10.2357 8.87765 9.64424 8.63249C9.05585 8.39161 8.82112 7.7241 8.82112 7.7241C8.82112 7.7241 8.55627 7.87505
                            8.55627 7.4511C8.55627 7.02662 8.82112 7.7241 9.08597 6.08719C9.08597 6.08719 9.82081 5.87468 9.67488 4.11732H9.49831C9.49831 4.11732 9.93973 2.23845 9.49831 1.60253C9.05533
                            0.966601 8.88188 0.542651 7.90919 0.238606C6.93806 -0.0649032 7.2912 -0.0044154 6.58597 0.0266314C5.87969 0.057143 5.29182 0.451116 5.29182 0.662556C5.29182 0.662556 4.8504 
                            0.693068 4.67487 0.875066C4.4983 1.05706 4.20436 1.90496 4.20436 2.11694C4.20436 2.32891 4.35133 3.75493 4.4983 4.05683L4.32329 4.11571C4.17632 5.8736 4.91116 6.08665 4.91116
                            6.08665C5.17601 7.72357 5.44087 7.02608 5.44087 7.45057C5.44087 7.87452 5.17601 7.72357 5.17601 7.72357C5.17601 7.72357 4.94076 8.39054 4.35289 8.63195C3.76502 8.87444 0.501612
                            10.1773 0.23624 10.4498C-0.0286132 10.7282 0.000987981 12 0.000987981 12H6.25152L6.70749 10.1479L6.30242 9.73037L6.99986 9.0104L7.69731 9.72983L7.29224 10.1474L7.7482 11.9995H13.9987C13.9987 
                            11.9995 14.0315 10.7265 13.7635 10.4487L13.7645 10.4503Z" fill="#565252"/> 
                        </svg>  
                        <p class="ex text-9">' . $sql[$i]['name'] . ' ' .$sql[$i]['surname'] . ' 
                        </p>  
                    </div>  
                </div> 
            </li> ';
            array_push($array_tasks, $sql[$i]['id']);

        if ($sql[$i]['type'] != 'sub-task') {
            echo '<div class="add-task-office text-9" data-parent-id="'.$sql[$i]['id'].'">  
                Add Sub-Task  
            </div>';
        }
        echo '</div>'; 
        ShowTree($project, $sql[$i]['id'],$user); 
        $k++; 
        if ($k > 0)  
            echo '</ul>'; 
        }
    endfor; 
}

if (isset($_POST['office-block']) && $_POST['office-block'] == 1) {
    $project = $_POST['project'];
    $user = $_POST['employees'];
    ShowTree($project, NULL, $user);
}