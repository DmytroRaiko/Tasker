<?php
//session_start();
require_once "../../../function.php";
require_once "../../../db/database.php";
$db = new Database();

$parent_id = $_POST['task-parent-id'];
$project_id = $_POST['task-project-id'];
$user_empl = $_POST['task-employees-id'];

if (isset($_POST['task-name-new']) && !empty(trim($_POST['task-name-new']))) {

    $create_time = time();
    $array_rand = [
        0 => mt_rand(1, 99),
        1 => mt_rand(1, 99)
    ];
    $task_id = $array_rand[0].$create_time.$array_rand[1];
    $name = $_POST['task-name-new'];

    $type = 'task';
    if (isset($_POST['have-sub-task']) && !empty($_POST['have-sub-task']) && $_POST['have-sub-task'] == 'on') {

        $type = 'sub-task';
    }
    if (isset($_POST['date-start']) && !empty(trim($_POST['date-start'])) && trim($_POST['date-start']) != 'undefined') {

        $date_start = date('Y-m-d G:i:s' , strtotime(trim($_POST['date-start'])));
        if (isset($_POST['date-end']) && !empty(trim($_POST['date-end'])) && trim($_POST['date-end']) != 'undefined') {

            $time_end_hours = '00';
            $time_end_minute = '00';
            
            if (isset($_POST['time-end-hour']) && !empty(trim($_POST['time-end-hour'])) && isset($_POST['time-end-minute']) && !empty(trim($_POST['time-end-minute']))) {
                $time_end_hours = trim($_POST['time-end-hour']);
                $time_end_minute = trim($_POST['time-end-minute']);
            }

            $date_end = date('Y-m-d G:i:s' , strtotime(trim($_POST['date-end']." ". $time_end_hours . ":" . $time_end_minute)));

            $description = NULL;
            $documents = NULL;
            $links = NULL;
            
            if (isset($_POST['task-discription-new']) && !empty(trim($_POST['task-discription-new']))) {
                $description = trim($_POST['task-discription-new']);
            }

            if (isset($_FILES) && !empty($_FILES['attachment']['size'][0])) {
                $count = 0;
        
                foreach ($_FILES['attachment']['name'] as $file) {
        
                    if (!empty($_FILES['attachment']['size'][$count])) {
                        $documents[] = upload_documents ($file, $_FILES['attachment']['tmp_name'][$count], 'tasks', $task_id, $count);
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

            $db->query("INSERT INTO `tasks`(`TaskID`, `Title`, `Type`, `DataTaskStart`, `DataTaskFinish`, `ParentTaskID`, `ProjectID`, `Status`, `Descriptions`, `replyDocuments`, `replyLinks`) VALUES (:taskId, :title, :type, :DataTaskStart, :DataTaskFinish, :ParentTaskID, :ProjectID, :Status, :Descriptions, :replyDocuments, :replyLinks)",    
                [
                    ':taskId'           => $task_id,
                    ':title'            => $name,
                    ':type'             => $type,
                    ':DataTaskStart'    => $date_start,
                    ':DataTaskFinish'   => $date_end,
                    ':ParentTaskID'     => $parent_id,
                    ':ProjectID'        => $project_id,
                    ':Status'           => 'waiting',
                    ':Descriptions'     => $description,
                    ':replyDocuments'   => $documents,
                    ':replyLinks'       => $links
                ]
            );

            $executor = [
                0 => $user_empl
            ];

            if (isset($_POST['executor-create-task']) && !empty($_POST['executor-create-task'])) {
                $executor = $_POST['executor-create-task'];
            }   

            $privileges = NULL;    

            for ($executor_i = 0; $executor_i < count($executor); $executor_i++) {
                $task_list_id = $array_rand[0].$executor_i.$create_time.$array_rand[1];

                $db->query("INSERT INTO `tasklist`(`TaskListID`, `TaskID`, `EmployeeID`) VALUES (:task_list_id, :task_id, :employees)",
                    [
                        ':task_list_id' => $task_list_id,
                        ':task_id'      => $task_id,
                        ':employees'    => $executor[$executor_i]
                    ]
                );
            }


            //- add data to the `tasks` table - start

            

            //- - end

            //- task added to the table! - message
            echo 1;

            if (isset($_POST['notification-daily-checker']) && !empty($_POST['notification-daily-checker']) && $_POST['notification-daily-checker'] == 'on') {
                // добавить много нотификаций между началом и концом каждый день для данного таска
                if (isset($_POST['notification-daily-time'])) {
                    $time_daily_not = $_POST['notification-daily-time'];
                }
            }

            if (isset($_POST['notification-block-checker']) && !empty($_POST['notification-block-checker']) && $_POST['notification-block-checker'] == 'on') {
                // добавить нотификацию для блокирующего уведомления
                if (isset($_POST['notification-block-time'])) {
                    $time_daily_not = $$_POST['notification-block-time'];
                }
            }
        } else {
            //- error time -
            echo 2;
        }   
    } else {
        //- error time -
        echo 2; 
    }
}