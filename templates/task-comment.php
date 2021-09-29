<?php
// require_once "../function.php";
require_once "../db/database.php";
$db = new Database();
?>

<div class="modal-row activity">
    <div class="modal-icon-row">
        <label>
            <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.625 8.5H5.125L7.75 15.5L11.25 1.5L13.875 8.5H17.375" stroke="#565252" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </label>
    </div>

    <div class="row-right-side">
        <div class="title-block">
            <div class="input-iteractive text-title-modal text text-19">
                Activity
            </div>
            <hr>
            <div class="text text-12 hide-button">show</div>

            <script>
                $('.hide-button').click(function () {
                    let status = $('.hide-button').html();
                    if (status == 'show') {
                        $('.hide-button').html('hide')
                        $('.comment.activity').css('display', 'flex');
                    } else {
                        $('.hide-button').html('show')
                        $('.comment.activity').css('display', 'none');
                    }
                });
            </script>
        </div>

        <div class="comment comment-form">
            <input type="text" name="comment-text" id="comment-text" class="text text-14" placeholder="Left comment...">
            <input type="submit" class="text text-14" id="add-comment" value="Post">

            <label for="file-comment">
                <svg width="15" height="21" viewBox="0 0 15 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.4719 5.68438L9.44063 0.653125C9.29688 0.509375 9.15313 0.4375 8.9375 0.4375H1.75C0.959375 0.4375 0.3125 1.08437 0.3125 1.875V19.125C0.3125 19.9156 0.959375 20.5625 1.75 20.5625H13.25C14.0406 20.5625 14.6875 19.9156 14.6875 19.125V6.1875C14.6875 5.97187 14.6156 5.82813 14.4719 5.68438ZM8.9375 2.1625L12.9625 6.1875H8.9375V2.1625ZM13.25 19.125H1.75V1.875H7.5V6.1875C7.5 6.97813 8.14687 7.625 8.9375 7.625H13.25V19.125Z" fill="#565252"/>
                    <path d="M3.1875 14.8125H11.8125V16.25H3.1875V14.8125Z" fill="#565252"/>
                    <path d="M3.1875 10.5H11.8125V11.9375H3.1875V10.5Z" fill="#565252"/>
                </svg>
            </label>
            <input style="display: none" type="file" name="file-comment" id="file-comment"/>
        </div>

        
        <?php 

        $sql = $db->query(
            "SELECT ActivityID, Text, EmployeeID, Type, DateTime
            FROM Activity
            WHERE TaskID = :TaskId
            ORDER BY DateTime DESC",
            [
                ':TaskId'   => $id
            ]
        );

        $count = count($sql);
        
        if ($count > 0) :
            for($i=0; $i < $count; $i++) : 

                $profile = $db->query(
                    "SELECT EmployeeID, Name, Surname
                    FROM employees
                    WHERE EmployeeID = :UserId",
                    [
                        ':UserId'   => $sql[$i]['EmployeeID']
                    ]
                );
                switch ($sql[$i]['Type']) :
                    case 'Comment' :?>
                        <div class="comment" id="coment-<?= $sql[$i]['ActivityID'] ?>">
                            <div class="comment-icon">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.2567 25.2672C28.8275 23.3773 29.92 21.1369 30.4417 18.7355C30.9635 16.3341 30.8992 13.8424 30.2543 11.4711C29.6094 9.09978 28.4029 6.91868 26.7368 5.1123C25.0707 3.30591 22.994 1.92738 20.6825 1.09332C18.3709 0.259262 15.8925 -0.00579174 13.4568 0.320583C11.0212 0.646958 8.69996 1.55516 6.68953 2.96836C4.67911 4.38156 3.03863 6.25819 1.90687 8.43948C0.775103 10.6208 0.185353 13.0426 0.187506 15.5C0.188332 19.0724 1.44723 22.5304 3.74329 25.2672L3.72141 25.2858C3.79797 25.3777 3.88547 25.4564 3.96422 25.5472C4.06266 25.6598 4.16875 25.7659 4.27047 25.8753C4.57672 26.2078 4.89172 26.5272 5.22204 26.8269C5.32266 26.9187 5.42657 27.0041 5.52829 27.0916C5.87829 27.3934 6.23813 27.68 6.6111 27.9469C6.65922 27.9797 6.70297 28.0223 6.7511 28.0562V28.0431C9.31277 29.8458 12.3687 30.8133 15.5011 30.8133C18.6335 30.8133 21.6894 29.8458 24.2511 28.0431V28.0562C24.2992 28.0223 24.3419 27.9797 24.3911 27.9469C24.763 27.6789 25.1239 27.3934 25.4739 27.0916C25.5756 27.0041 25.6795 26.9177 25.7802 26.8269C26.1105 26.5261 26.4255 26.2078 26.7317 25.8753C26.8334 25.7659 26.9384 25.6598 27.038 25.5472C27.1156 25.4564 27.2042 25.3777 27.2808 25.2847L27.2567 25.2672ZM15.5 6.75C16.4735 6.75 17.4251 7.03866 18.2344 7.57948C19.0438 8.1203 19.6747 8.889 20.0472 9.78835C20.4197 10.6877 20.5172 11.6773 20.3273 12.6321C20.1374 13.5868 19.6686 14.4638 18.9803 15.1522C18.292 15.8405 17.415 16.3093 16.4602 16.4992C15.5055 16.6891 14.5158 16.5916 13.6165 16.2191C12.7171 15.8466 11.9484 15.2157 11.4076 14.4063C10.8668 13.5969 10.5781 12.6453 10.5781 11.6719C10.5781 10.3665 11.0967 9.11461 12.0197 8.19158C12.9427 7.26855 14.1946 6.75 15.5 6.75ZM6.75766 25.2672C6.77663 23.8311 7.36026 22.4601 8.38227 21.451C9.40428 20.4419 10.7825 19.8757 12.2188 19.875H18.7813C20.2175 19.8757 21.5957 20.4419 22.6177 21.451C23.6397 22.4601 24.2234 23.8311 24.2423 25.2672C21.8436 27.4288 18.729 28.6251 15.5 28.6251C12.271 28.6251 9.15643 27.4288 6.75766 25.2672Z" fill="#565252"/>
                                </svg>
                            </div>
                            <div class="comment-body">
                                <div class="comment-header">
                                    <a class="text text-15 header-name" href="?profile=<?= $sql[$i]['EmployeeID'] ?>">
                                        <?= $profile[0]['Name'] . ' ' . $profile[0]['Surname'];?>
                                    </a>
                                    <div class="comment-time text text-13" title="<?=date('d.m.Y, g:i' , strtotime($sql[$i]['DateTime']))?>">
                                        <?= date_format_custom($sql[$i]['DateTime']) ?>
                                    </div>

                                    <svg data-activity-id="<?= $sql[$i]['ActivityID'] ?>" class="delete-comment" width="14" height="14" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.42969 1.33594H7.53125C7.47539 1.33594 7.42969 1.29023 7.42969 1.23438V1.33594H3.57031V1.23438C3.57031 1.29023 3.52461 1.33594 3.46875 1.33594H3.57031V2.25H2.65625V1.23438C2.65625 0.78623 3.02061 0.421875 3.46875 0.421875H7.53125C7.97939 0.421875 8.34375 0.78623 8.34375 1.23438V2.25H7.42969V1.33594ZM1.03125 2.25H9.96875C10.1935 2.25 10.375 2.43154 10.375 2.65625V3.0625C10.375 3.11836 10.3293 3.16406 10.2734 3.16406H9.50664L9.19307 9.80371C9.17275 10.2366 8.81475 10.5781 8.38184 10.5781H2.61816C2.18398 10.5781 1.82725 10.2379 1.80693 9.80371L1.49336 3.16406H0.726562C0.670703 3.16406 0.625 3.11836 0.625 3.0625V2.65625C0.625 2.43154 0.806543 2.25 1.03125 2.25ZM2.71592 9.66406H8.28408L8.59131 3.16406H2.40869L2.71592 9.66406Z" fill="#676464" fill-opacity="0.41"/>
                                    </svg>
                                </div>
                                <div class="comment-text text">
                                    <?= $sql[$i]['Text'] ?>
                                </div>
                            </div>
                        </div>
                        <?php 
                        break;
                    case 'Activity' : ?>
                        <div class="comment activity">
                            <div class="comment-icon">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.2567 25.2672C28.8275 23.3773 29.92 21.1369 30.4417 18.7355C30.9635 16.3341 30.8992 13.8424 30.2543 11.4711C29.6094 9.09978 28.4029 6.91868 26.7368 5.1123C25.0707 3.30591 22.994 1.92738 20.6825 1.09332C18.3709 0.259262 15.8925 -0.00579174 13.4568 0.320583C11.0212 0.646958 8.69996 1.55516 6.68953 2.96836C4.67911 4.38156 3.03863 6.25819 1.90687 8.43948C0.775103 10.6208 0.185353 13.0426 0.187506 15.5C0.188332 19.0724 1.44723 22.5304 3.74329 25.2672L3.72141 25.2858C3.79797 25.3777 3.88547 25.4564 3.96422 25.5472C4.06266 25.6598 4.16875 25.7659 4.27047 25.8753C4.57672 26.2078 4.89172 26.5272 5.22204 26.8269C5.32266 26.9187 5.42657 27.0041 5.52829 27.0916C5.87829 27.3934 6.23813 27.68 6.6111 27.9469C6.65922 27.9797 6.70297 28.0223 6.7511 28.0562V28.0431C9.31277 29.8458 12.3687 30.8133 15.5011 30.8133C18.6335 30.8133 21.6894 29.8458 24.2511 28.0431V28.0562C24.2992 28.0223 24.3419 27.9797 24.3911 27.9469C24.763 27.6789 25.1239 27.3934 25.4739 27.0916C25.5756 27.0041 25.6795 26.9177 25.7802 26.8269C26.1105 26.5261 26.4255 26.2078 26.7317 25.8753C26.8334 25.7659 26.9384 25.6598 27.038 25.5472C27.1156 25.4564 27.2042 25.3777 27.2808 25.2847L27.2567 25.2672ZM15.5 6.75C16.4735 6.75 17.4251 7.03866 18.2344 7.57948C19.0438 8.1203 19.6747 8.889 20.0472 9.78835C20.4197 10.6877 20.5172 11.6773 20.3273 12.6321C20.1374 13.5868 19.6686 14.4638 18.9803 15.1522C18.292 15.8405 17.415 16.3093 16.4602 16.4992C15.5055 16.6891 14.5158 16.5916 13.6165 16.2191C12.7171 15.8466 11.9484 15.2157 11.4076 14.4063C10.8668 13.5969 10.5781 12.6453 10.5781 11.6719C10.5781 10.3665 11.0967 9.11461 12.0197 8.19158C12.9427 7.26855 14.1946 6.75 15.5 6.75ZM6.75766 25.2672C6.77663 23.8311 7.36026 22.4601 8.38227 21.451C9.40428 20.4419 10.7825 19.8757 12.2188 19.875H18.7813C20.2175 19.8757 21.5957 20.4419 22.6177 21.451C23.6397 22.4601 24.2234 23.8311 24.2423 25.2672C21.8436 27.4288 18.729 28.6251 15.5 28.6251C12.271 28.6251 9.15643 27.4288 6.75766 25.2672Z" fill="#565252"/>
                                </svg>
                            </div>
                            <div class="comment-body">
                                <div class="comment-header">
                                    <a class="text text-15 header-name" href="?profile=<?= $sql[$i]['EmployeeID'] ?>">
                                        <?= $profile[0]['Name'] . ' ' . $profile[0]['Surname'];?>
                                    </a>
                                    <div class="comment-time text text-13" title="<?=date('d.m.Y, g:i' , strtotime($sql[$i]['DateTime']))?>">
                                        <?=date_format_custom($sql[$i]['DateTime'])?>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-text text">
                                <?= $sql[$i]['Text'] ?>
                            </div>
                        </div>
                        <?php break;
                endswitch;
            endfor; 
        else : ?>
            <div class="comment text text-15 text-center">
                No comment!<br>Be first!
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('body').on('click', '#add-comment', function (e) {
            e.preventDefault();

            let fData = new FormData();
            fData.append('adding-comment', <?=$id?>);
            fData.append('text', $('#comment-text').val());
            fData.append('user', <?=$user?>);
            fData.append('file', $('#file-comment')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "./templates/modal/form-processing/processing-comment.php",
                сache: false, 
                contentType: false,
                processData: false,

                data: fData,

                success: function(data) {
                    let header = 'Adding comment', body, color;

                    if (data == 1) {
                        body = 'Complete!';
                        color = 'green';

                        $('#comment-text').val("");
                        $('#file-comment').val("");
                    } else if (data == 2) {
                        body = 'Please change file or enter text';
                        color = 'red';
                    } else if (data == 3) {
                        body = 'Unknown error';
                        color = 'red';
                    }

                    Toast.add({
                        header: header,
                        body: body,
                        color: color,
                        autohide: true,
                        delay: 10000
                    });
                }
            });
        });

        $('body').on('click', '.delete-comment', function (e) {
            e.preventDefault();
            var deleteActivity = $(this).data('activity-id');

            $.ajax({
                type: "POST",
                url: "./templates/modal/form-processing/processing-comment.php",
                data: 'delete-activity=' + deleteActivity,

                success: function(data) {

                    let header = 'Delete comment', body, color;

                    if (data == 1) {
                        $('#coment-' + deleteActivity).remove();
                        body = 'Complete!';
                        color = 'green';
                    } else {
                        body = 'Unknown error';
                        color = 'red';
                    }

                    Toast.add({
                        header: header,
                        body: body,
                        color: color,
                        autohide: true,
                        delay: 10000
                    });
                }
            });
        });
    });
</script>