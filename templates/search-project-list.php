<?php 
//session_start();

$project_list = [];

if (isset($_POST['header-project-search'])) {
    $search = '%' . trim($_POST['header-project-search']) . '%';
    
    require_once "../db/database.php";
    $db = new Database();
    
    $project_list = $db->query(
        "SELECT * 
        FROM `tasks` INNER JOIN `tasklist` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `EmployeeID` = :id AND `Title` LIKE :search",
        [
            ':id' => 1,
            ':search' => $search
        ]
    );
} else {
    require_once "./db/database.php";
    $db = new Database();
    $project_list = $db->query(
        "SELECT * 
        FROM `tasks` INNER JOIN `tasklist` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `EmployeeID` = :id",
        [
            ':id' => 1
        ]
    );
}

$count_project_list = count($project_list);

?>

        <a href="" class="project-item">
            <div class="project-icon">
            </div>
            <div class="project-list-content">
                <div class="project-name-list text text-19">
                    Life board
                </div>
                <div class="project-type-list text text-14">
                    Life, Tasks
                </div>
            </div>
        </a>
        <hr>

        <?php
        

        if ($count_project_list < 1) {
            ?>

            <div class="project-none-text text text-18 text-center">
                You do not have project or search without result
            </div>

            <?php
        } else {
            for ($i = 0; $i < $count_project_list; $i++) : ?>

            <a href="?project=<?= $project_list[$i]['TaskListID'] ?>" data-id="?project=<?= $project_list[$i]['TaskListID'] ?>" class="project-item">
            
                <div class="project-icon">
                </div>
                
                <div class="project-list-content">
                    <div class="project-name-list text text-19">
                        <?= $project_list[$i]['Title'] ?>
                    </div>
                    <div class="project-type-list text text-14">
                        <?= $project_list[$i]['Descriptions'] ?>
                    </div>
                </div>
            </a>
            <?php

            endfor;
        } ?>
        
