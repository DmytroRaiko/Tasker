<?php
//session_start();

require_once "../db/database.php";
$db = new Database();
$project_list = [
    '0' => [
        'count(*)' => 0
    ]
];
try {
    $project_list = $db->query(
        "SELECT count(*) 
        FROM `notifications` INNER JOIN `tasks` ON `notifications`.`TaskID`=`tasks`.`TaskID`
            INNER JOIN `tasklist` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `tasklist`.`EmployeeID` = :id AND `notifications`.`Status` LIKE 'unread'",
        [
            ':id' => 1
        ]
    );
} catch (Exception $ex) {}


if (count($project_list) > 0 ) {
    if (is_numeric($project_list[0]['count(*)'])) {
        $return_value = $project_list[0]['count(*)'];   
        if ($return_value > 9) {
            $return_value = "9..";
        }
    } else {
        $return_value = 0;
    }
} else {
    $return_value = 0;
}

echo $return_value;