<?php
//session_start();
require_once "../../../function.php";
require_once "../../../db/database.php";
$db = new Database();

$notification = $db->query (
    "SELECT * FROM `notifications` WHERE `NotificationID` = :idNotification",
    [
        ':idNotification' => $id
    ]
);

if ($notification[0]['EmployeesSenderID'] == 1 
        && $notification[0]['Status'] != 'unread' && $notification[0]['Status'] != 'canceled'
        && $notification[0]['SenderRead'] == 'unread') {
    $db->query (
        "UPDATE `notifications` SET `SenderRead`='read' WHERE `NotificationID` = :idNotification",
        [
            ':idNotification' => $id
        ]
    );
} else if (isset($_POST['id-notification']) && !empty($_POST['id-notification'])) {
    $id = $_POST['id-notification'];

    $reaction_time = date('Y-m-d H:i:s', time());
    $description = NULL;
    $documents = NULL;
    $links = NULL;


    if (isset($_POST['abandon-checker'])) {
        if ($_POST['abandon-checker'] === 'on') {
            $status = 'canceled';
        } else {
            $status = 'answered';
        }
    } else {
        $status = 'answered';
    }

    if (isset($_POST['notification-feedback']) && !empty(trim($_POST['notification-feedback']))) {
        $description = trim($_POST['notification-feedback']);
    }

    if (isset($_FILES) && !empty($_FILES['attachment']['size'][0])) {
        $count = 0;

        foreach ($_FILES['attachment']['name'] as $file) {

            if (!empty($_FILES['attachment']['size'][$count])) {
                $documents[] = upload_documents ($file, $_FILES['attachment']['tmp_name'][$count], 'notifications', $id, $count);
            }
            ++$count;
        }

        $documents = json_encode($documents);
    }

    if (isset($_POST['lattachment-link']) && !empty($_POST['lattachment-link'][0])) {
        $links_post = $_POST['lattachment-link'];
        for ($i = 0; $i < count($links_post); $i++) {
            if (!empty($_POST['lattachment-link'][$i])) {
                $links[] = $_POST['lattachment-link'][$i];
            }
        }
        $links = json_encode($links);
    }

    $sql = $db->query (
        "UPDATE `notifications` 
        SET `Status`=:status,`ReactionTime`=:reactionTime,`ReplyMessage`=:description,
            `replyDocuments`=:documents,`replyLinks`=:links
        WHERE NotificationID = :id",
        [
            ':id'           => $id,
            ':reactionTime' => $reaction_time,
            ':status'       => $status,
            ':description'  => $description,
            ':documents'    => $documents,
            ':links'        => $links
        ] 
    );

} 