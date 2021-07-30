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

?>