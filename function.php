<?php

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
?>