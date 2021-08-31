<?php

session_start();


if (isset($_POST['notification-view'])) {
    require_once "./modal/modal-view-notification.php";
    echo modal_view_notification($_POST['notification-view']);    
} else if (isset($_POST['notification-create'])) {
    // require_once "./modal/modal-view-notification.php";
    // echo modal_create_notification($_POST['notification-create']);   
} else if (isset($_POST['task-view'])) {
    // require_once "./modal/modal-view-task.php";
    // echo modal_view_task($_POST['task-view']);   
} else if (isset($_POST['task-create'])) {
    require_once "./modal/modal-create-task.php";
    echo modal_create_task($_POST['task-create'], $_POST['task-create-project'], 1);   
}