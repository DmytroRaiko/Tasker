<?php 
session_start();

require_once "../db/database.php";
$db = new Database();

$project_list = [];

if (isset($_POST['header-project-search']) && !empty($_POST['header-project-search'])) {
    $search = '%' . trim($_POST['header-project-search']) . '%';
    
    
    $project_list = $db->query(
        "SELECT * 
        FROM `tasks` INNER JOIN `tasklist` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
        WHERE `EmployeeID` = :id AND `Title` LIKE :search",
        [
            ':id' => $_SESSION["emp_id"],
            ':search' => $search
        ]
    );
} else {
    $project_list = $db->query(
        "SELECT * 
        FROM `tasks` 
        WHERE `TaskID` IN (SELECT DISTINCT `ProjectID` 
            FROM `tasks` INNER JOIN `tasklist` ON `tasklist`.`TaskID`=`tasks`.`TaskID`
            WHERE `EmployeeID` = :id)",
        [
            ':id' => $_SESSION["emp_id"],
        ]
    );
}

$count_project_list = count($project_list);?>

<a href="?project-id=0" class="project-item">
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

    <a href="?project-id=<?= $project_list[$i]['ProjectID'] ?>" data-id="?project=<?= $project_list[$i]['ProjectID'] ?>" class="project-item">
    
        <div class="project-icon">
        </div>
        
        <div class="project-list-content">
            <div class="project-name-list text text-19">
                <?= $project_list[$i]['Title'] ?>
            </div>
            <div class="project-type-list text text-14">
                <?= $project_list[$i]['Type'] ?>
            </div>
        </div>
    </a>
    <?php

    endfor;
} ?>
        
