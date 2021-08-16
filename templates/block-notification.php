<?php
//session_start();

require_once "../function.php";
require_once "../db/database.php";

$db = new Database();
$project_list = [
    '0' => [
        'count(*)' => 0
    ]
];

try {
    $project_list = $db->query(
        "SELECT `tasks`.`Title` AS 'TitleTask', `tasks`.`Descriptions` AS 'Descriptions', 
                `notifications`.`Status` AS 'statusNot', `notifications`.`SenderRead` AS 'SenderRead', 
                `notifications`.`NotificationID` AS 'NotificationID', `notifications`.`ReplyMessage` AS 'ReplyMessage', 
                `notifications`.`ScheduledTime` AS 'ScheduledTime', `notifications`.`NotificationText` AS 'NotificationText', EmployeesSenderID
        FROM `notifications` INNER JOIN `tasklist` ON `notifications`.`TasklistID`=`tasklist`.`TaskListID`
            INNER JOIN `tasks` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `tasklist`.`EmployeeID` = :id AND `notifications`.`EmployeesSenderID` != :id AND `notifications`.`Status` IN('unread', 'read')

        UNION ALL SELECT `tasks`.`Title` AS 'TitleTask', `tasks`.`Descriptions` AS 'Descriptions', 
                `notifications`.`Status` AS 'statusNot', `notifications`.`SenderRead` AS 'SenderRead', 
                `notifications`.`NotificationID` AS 'NotificationID', `notifications`.`ReplyMessage` AS 'ReplyMessage',
                `notifications`.`ScheduledTime` AS 'ScheduledTime', `notifications`.`NotificationText` AS 'NotificationText', EmployeesSenderID
        FROM `notifications` INNER JOIN `tasklist` ON `notifications`.`TasklistID`=`tasklist`.`TaskListID`
                INNER JOIN `tasks` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `notifications`.`EmployeesSenderID` = :id AND `notifications`.`SenderRead` IN('unread') AND `notifications`.`Status` IN('unread', 'read')

        UNION ALL SELECT `tasks`.`Title` AS 'TitleTask', `tasks`.`Descriptions` AS 'Descriptions', 
                `notifications`.`Status` AS 'statusNot', `notifications`.`SenderRead` AS 'SenderRead', 
                `notifications`.`NotificationID` AS 'NotificationID', `notifications`.`ReplyMessage` AS 'ReplyMessage',
                `notifications`.`ScheduledTime` AS 'ScheduledTime', `notifications`.`NotificationText` AS 'NotificationText', EmployeesSenderID
        FROM `notifications` INNER JOIN `tasklist` ON `notifications`.`TasklistID`=`tasklist`.`TaskListID`
                INNER JOIN `tasks` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `notifications`.`EmployeesSenderID` = :id AND `notifications`.`SenderRead` IN('unread') AND `notifications`.`Status` NOT IN('unread', 'read')
        ORDER BY `ScheduledTime` DESC
        ",
        [
            ':id' => 1
        ]
    );

} catch (Exception $ex) {}

$count = count($project_list);
if ( $count > 0 ) {
    for ($i = 0; $i < $count; $i++) {
        ?>
        <div class="notification-item " data-notificationId="<?= $project_list[$i]['NotificationID'] ?>" title="Click to open">
        <!-- </?= //$project_list[$i]['statusNot'] == 'unread' ? 'unread-notification' : '' ?> -->
            <div class="title-notification text" title=" <?= $project_list[$i]['TitleTask'] ?>">
                <strong>Task:</strong> <b><?= $project_list[$i]['TitleTask'] ?></b> 
            </div>
            <div class="notification-text text">
                <?= $project_list[$i]['NotificationText'] ?>
            </div>
            <div class="notification-time text text-12" title="<?= Date('d.m.Y H:i', strtotime($project_list[$i]['ScheduledTime'])) ?>">
                <?= date_format_custom ($project_list[$i]['ScheduledTime']) ?>
            </div>

            <?php 
            if ($project_list[$i]['statusNot'] == 'unread' 
                    || ($project_list[$i]['EmployeesSenderID'] == 1 && $project_list[$i]['SenderRead'] == 'unread' && $project_list[$i]['statusNot'] != 'read' && $project_list[$i]['statusNot'] != 'unread')) {
                ?>
                <div class="point-unread-notification"></div>
                <?php
            }
            ?>
        </div>
        <?php
    }
} else {
    ?>
    <!-- выводим иконку отстутствия уведомлений -->

    <div class="no-notifications">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 274 249"><defs><style>.a,.b,.c,.d,.e,.f,.g,.h,.i,.j,.k,.l{fill:none;stroke:#e5e4e4;stroke-miterlimit:10;stroke-width:4px;}.a{stroke-dasharray:54 5 18;}.b{stroke-dasharray:74 5 70 10;}.c{stroke-dasharray:50 5 30 4 22 10;}.d{stroke-dasharray:30 5 25 10;}.e{stroke-dasharray:10 5 30 15 80 20;}.f{stroke-dasharray:70 5 50 10 10 10;}.g{stroke-dasharray:74 5 30 5;}.h{stroke-dasharray:30 5 5 3 40;}.i{stroke-dasharray:30 5 15 60;}.j{stroke-dasharray:20 5 40 10;}.k{stroke-dasharray:37 11 15;}.l{stroke-dasharray:74 5;}.m{fill:#373433;}</style></defs><line class="a" x1="15" y1="62" x2="261" y2="62"/><line class="b" x1="7" y1="83" x2="270" y2="83"/><line class="c" x1="2" y1="103" x2="274" y2="103"/><line class="d" y1="125" x2="270" y2="125"/><line class="e" x1="2" y1="146" x2="274" y2="146"/><line class="f" x1="7" y1="165" x2="269" y2="165"/><line class="g" x1="15" y1="186" x2="261" y2="186"/><line class="h" x1="28" y1="207" x2="248" y2="207"/><line class="i" x1="46" y1="226" x2="230" y2="226"/><line class="j" x1="76" y1="247" x2="200" y2="247"/><line class="k" x1="46" y1="40" x2="249" y2="40"/><line class="l" x1="47" y1="21" x2="220" y2="21"/><line class="l" x1="73" y1="2" x2="203" y2="2"/><path class="m" d="M144,213.7c-10.51.06-13.74-9.7-13.74-9.7h27.49S154.35,213.64,144,213.7Z" transform="translate(-6 -20)"/><path class="m" d="M217.86,61.31l6.92,6.7L63.66,227.38l-6.81-6.82L85,192.73V185c31.18-1.44-2.2-59.26,27.29-84,7.76-8.69,17.82-11.6,26.71-12.81L139,68l10,0,.08,20.14s13.11-.78,27.52,13.84Z" transform="translate(-6 -20)"/><path class="m" d="M188,172.47c-.61-8.07,1.46-46.06-2-51.93L108.71,195H203v-9.33S190.9,185.69,188,172.47Z" transform="translate(-6 -20)"/></svg>
        <div class="text text-24">
            Any notifications
        </div>
    </div>
    <?php
}