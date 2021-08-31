<?php 
    session_start();
    if(isset($_SESSION['user-id']) && isset($_SESSION['hash'])){
        unset($_SESSION['user-id']);
        unset($_SESSION['hash']);
        unset($_SESSION['emp_id']);
    }
    if(isset($_COOKIE['remember_token'])){
        setcookie("remember_token", '', time() - 3600, '/');
    }
    session_destroy();
    header('Location: /log_page.php?action=signin');
?>