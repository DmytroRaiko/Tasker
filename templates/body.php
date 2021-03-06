<?php 

    $user=$_SESSION["emp_id"];
    
    if (isset($_GET['pageno']) && !empty($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }

    $sql = get_info_full_project($user); // project`s
    $count_project = count($sql); // 3

    $size_page = 8; // 2
    $offset = ($pageno - 1) * $size_page; // 2

    if ( $count_project > 0 ) {

        $total_pages = ceil($count_project / $size_page); // 3/2 = 1.5  2 

        $i = $offset;
        ?>
        <div class="body-main">
            <div class="body-cards">
        <?php
        while ($i < $offset + $size_page && $i < $count_project) {

                    ?>
                    <a class="card-body" href="?project-id=<?= $sql[$i]['id'] ?>">
                    
                        <div class="blurr">
                            <div class="card-header">
        
                                <p class="card-name" title="<?= $sql[$i]['title'] ?>">
                                    <?= $sql[$i]['title'] ?>
                                </p>
        
        
                                <?php if (!empty($sql[$i]['datastart']) || !empty($sql[$i]['dataend'])) { ?>
                                    <div class="date-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.50008 1.41667C4.59433 1.41667 1.41675 4.59426 1.41675 8.50001C1.41675 12.4058 4.59433 15.5833 8.50008 15.5833C12.4058 15.5833 15.5834 12.4058 15.5834 8.50001C15.5834 4.59426 12.4058 1.41667 8.50008 1.41667ZM10.8326 11.8341L7.79175 8.79326V4.25001H9.20842V8.20676L11.8342 10.8325L10.8326 11.8341Z" fill="white"/>
                                        </svg>
        
<<<<<<< HEAD
                                    </div>
        
                                    <div class="card-time">
                                        <?php if (!empty($sql[$i]['datastart'])) { ?>
                                            <div class="date-start">
                                                <?= date('d.m.Y', strtotime($sql[$i]['datastart'])) ?>
                                            </div>
                                        <?php } ?>
        
                                        <?php if (!empty($sql[$i]['dataend'])) { ?>
                                            <div class="date-end">
                                            <?= date('d.m.Y', strtotime($sql[$i]['dataend'])) ?>
                                            </div>
                                        <?php } ?>
        
                                    </div>
=======
                                    </div>
        
                                    <div class="card-time">
                                        <?php if (!empty($sql[$i]['datastart'])) { ?>
                                            <div class="date-start">
                                                <?= date('d.m.Y', strtotime($sql[$i]['datastart'])) ?>
                                            </div>
                                        <?php } ?>
        
                                        <?php if (!empty($sql[$i]['dataend'])) { ?>
                                            <div class="date-end">
                                            <?= date('d.m.Y', strtotime($sql[$i]['dataend'])) ?>
                                            </div>
                                        <?php } ?>
        
                                    </div>
>>>>>>> fe192060f87c464f1dbb2aca9f77ff5f6b69998c
                                <?php } ?>  
                                
                            </div>
                        
                            <hr>
        
                            <div class="card-description">
                                <p class="description">
                                <?= $sql[$i]['description'] ?>
                                </p>
                            </div>
        
        
                            <div class="card-footer">
                                <p class="executor">
                            
                                </p>
                            </div>
                        </div>
                        
                        
                    </a>
                <?php
                    $i++;
                    } 
                ?>
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


            <?php if ($total_pages > 1) { ?>
                <div class="pagination">
                    <ul class="pagination">
                        <div class="list-pag">
                            <li class="<?php if($pageno == 1){ echo 'active'; } ?>">
                                <a href="?pageno=1"><<</a>
                            </li>
                        </div>
                        <div class="list-pag">
                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><</a>
                            </li>
                        </div>
                        <div class="list-pag">
                            <li class="active"> 
                                <a><?php echo $pageno; ?></a>
                            </li>
                        </div>
                        <div class="list-pag">
                            <li class="<?php if($pageno == $total_pages){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno == $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">></a>
                            </li>
                        </div>
                        <div class="list-pag">
                            <li class="<?php if($pageno == $total_pages){ echo 'active'; } ?>">
                                <a href="?pageno=<?php echo $total_pages; ?>">>></a>
                            </li>
                        </div>
                    </ul>
                </div>
                <?php } ?>
        <?php
    } else {

    }