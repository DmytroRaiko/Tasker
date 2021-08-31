<?php

$project = $_GET['office-id'];
$user = 1;

$sql = get_info_full_project($user);
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
                    <?=date('d.m.Y g:i:s' , strtotime($sql[0]['datastart'])) ?> 
                </div>

                <div class="office-date-end">
                    <div class="data-time-end text-13">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.5 1.25C4.05375 1.25 1.25 4.05375 1.25 7.5C1.25 10.9462 4.05375 13.75 7.5 13.75C10.9462 13.75 13.75 10.9462 13.75 7.5C13.75 4.05375 10.9462 1.25 7.5 1.25ZM9.55813 10.4419L6.875 7.75875V3.75H8.125V7.24125L10.4419 9.55813L9.55813 10.4419Z" fill="#565252"/>
                        </svg>

                        <?=date('d.m.Y g:i:s' , strtotime($sql[0]['dataend'])) ?> 
                    </div>
                </div>
            </div>
        </div>
        <hr>

       
        <div class="office-block">
            <?php
            ShowTree($project, NULL, $user);
            ?>
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