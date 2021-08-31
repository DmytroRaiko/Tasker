<?php

$project = $_GET['office-id'];
$user=$_SESSION["emp_id"];

$sql= get_info_full_project($user);
?>
<div class="main-office">
    <div class="office-card">
        <div class="office-card-header">
            <div class="office-card-title">
               <?= $sql[0]['title']?>
               
            </div>
            <hr>
            <div class="office-card-time">
                <div class="data-time-start text-13">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 1.25C4.05375 1.25 1.25 4.05375 1.25 7.5C1.25 10.9462 4.05375 13.75 7.5 13.75C10.9462 13.75 13.75 10.9462 13.75 7.5C13.75 4.05375 10.9462 1.25 7.5 1.25ZM9.55813 10.4419L6.875 7.75875V3.75H8.125V7.24125L10.4419 9.55813L9.55813 10.4419Z" fill="#565252"/>
                    </svg>
                    <?=date('d.m.Y g:i' , strtotime($sql[0]['datastart'])) ?> 
                </div>

                <div class="office-date-end">
                    <div class="data-time-end text-13">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.5 1.25C4.05375 1.25 1.25 4.05375 1.25 7.5C1.25 10.9462 4.05375 13.75 7.5 13.75C10.9462 13.75 13.75 10.9462 13.75 7.5C13.75 4.05375 10.9462 1.25 7.5 1.25ZM9.55813 10.4419L6.875 7.75875V3.75H8.125V7.24125L10.4419 9.55813L9.55813 10.4419Z" fill="#565252"/>
                        </svg>

                        <?=date('d.m.Y g:i' , strtotime($sql[0]['dataend'])) ?> 
                    </div>
                </div>
            </div>
        </div>
        <hr>

       
        <div class="office-block">
            <?php
            ShowTree($project, NULL, $user);
            ?>
            <!--<div class="card-office-block text-9">
                <div class="card-office-block-main">
                    <div class="card-office-block-title">
                        Create people in the Earth

                       
                    </div>
                        
                    <hr>
                    <div class="card-office-block-executor">
                        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.7645 10.4503C13.4955 10.1773 10.2357 8.87765 9.64424 8.63249C9.05585 8.39161 8.82112 7.7241 8.82112 7.7241C8.82112 7.7241 8.55627 7.87505 8.55627 7.4511C8.55627 7.02662 8.82112 7.7241 9.08597 6.08719C9.08597 6.08719 9.82081 5.87468 9.67488 4.11732H9.49831C9.49831 4.11732 9.93973 2.23845 9.49831 1.60253C9.05533 0.966601 8.88188 0.542651 7.90919 0.238606C6.93806 -0.0649032 7.2912 -0.0044154 6.58597 0.0266314C5.87969 0.057143 5.29182 0.451116 5.29182 0.662556C5.29182 0.662556 4.8504 0.693068 4.67487 0.875066C4.4983 1.05706 4.20436 1.90496 4.20436 2.11694C4.20436 2.32891 4.35133 3.75493 4.4983 4.05683L4.32329 4.11571C4.17632 5.8736 4.91116 6.08665 4.91116 6.08665C5.17601 7.72357 5.44087 7.02608 5.44087 7.45057C5.44087 7.87452 5.17601 7.72357 5.17601 7.72357C5.17601 7.72357 4.94076 8.39054 4.35289 8.63195C3.76502 8.87444 0.501612 10.1773 0.23624 10.4498C-0.0286132 10.7282 0.000987981 12 0.000987981 12H6.25152L6.70749 10.1479L6.30242 9.73037L6.99986 9.0104L7.69731 9.72983L7.29224 10.1474L7.7482 11.9995H13.9987C13.9987 11.9995 14.0315 10.7265 13.7635 10.4487L13.7645 10.4503Z" fill="#565252"/>
                        </svg>
                            <p class="ex text-9">
                                Antipenko V.V.
                            </p>
                    </div>
                </div>
                <div class="card-office-status">
                    <div class="card-office-block-main-status">

                    </div>

                    <div class="card-office-block-optional-status">

                    </div>
                </div>
                
                <div class="add-task-office text-9">
                    
                    Add Sub-Task
                </div>
            </div>-->
        </div> 
       
    </div>

    <div class="body-filter">
                <div class="head-sorting">
                    <p>Sorting</p>
                </div>
        
                <div class="sorting-by">
                    <select size=1>
                        <option selected value="pinning"> by pinning </option>
                        <option value="newest"> by newest </option>
                        <option value="oldest"> by oldest </option>
                        <option value="deadline"> by deadline </option>
                    </select>
                    
        
                </div>
        
        
                <div class="arrow">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 12.5V2.5" stroke="#565252" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.125 8.125L7.5 12.5L11.875 8.125" stroke="#565252" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            
            
            <div class="filter">
                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.83877 18.8223C7.83877 19.2198 8.15772 19.541 8.55303 19.541H14.4468C14.8421 19.541 15.161 19.2198 15.161 18.8223V14.4199H7.83877V18.8223ZM19.7678 3.45898H3.23204C2.68174 3.45898 2.33809 4.05869 2.61436 4.53711L7.58497 12.9824H15.4193L20.3899 4.53711C20.6617 4.05869 20.3181 3.45898 19.7678 3.45898Z" fill="#565252"/>
                    </svg>
        
                    <form method="post" action="">
                        <div class="checker">
                            <input type="checkbox" class="pop" name="option1" value="filter1"><p class="pop-text">Expired</p><br>
                            <input type="checkbox" class="pop" name="option2" value="filter2"><p class="pop-text">Done</p><br>
                            <input type="checkbox" class="pop" name="option3" value="filter3"><p class="pop-text">Performed</p><br>
                            <input type="checkbox" class="pop" name="option4" value="filter4"><p class="pop-text">Not accepted</p><br>
                            <input type="checkbox" class="pop" name="option5" value="filter5"><p class="pop-text">Planed</p><br>
                        </div>
                    </form>
                </div>
                </div>
               
            </div>
</div>