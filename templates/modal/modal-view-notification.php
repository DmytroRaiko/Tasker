<?php
//session_start();
require_once "../db/database.php";
$db = new Database();

function modal_notification ($id) { 
    global $db;

    $notification = $db->query (
        "SELECT * FROM `notifications` WHERE `NotificationID` = :idNotification",
        [
            ':idNotification' => $id
        ]
    );

    $status_not = $notification[0]['Status'];

    $sender = false;
    if ($notification[0]['EmployeesSenderID'] == 1 
            && $status_not != 'unread' 
            && $status_not != 'read'
            && $notification[0]['SenderRead'] == 'unread') {
        $sender = true;
    }

    $task = $db->query(
        "SELECT * FROM `tasks` INNER JOIN `tasklist` ON `tasks`.`TaskID` = `tasklist`.`TaskID`
        WHERE `tasklist`.`TaskListID` = :idTasklist",
        [
            ':idTasklist' => $notification[0]['TasklistID']
        ]
    )
    ?>

    <div class="modal-of modal-of-center modal-of-show notification-modal" id="view-modal-notification-<?= $id ?>">
        <form class="modal notification-modal-view" data-modal-id="view-modal-notification-<?= $id ?>">
            <input type="hidden" name="id-notification" value="<?= $id ?>">
            <div class="modal-header">
                <div class="title-header text text-20">
                    View notification
                </div>
                <div class="x-close text">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.41 7L12.71 2.71C12.8983 2.5217 13.0041 2.2663 13.0041 2C13.0041 1.7337 12.8983 1.47831 12.71 1.29C12.5217 1.1017 12.2663 0.995911 12 0.995911C11.7337 0.995911 11.4783 1.1017 11.29 1.29L7 5.59L2.71 1.29C2.5217 1.1017 2.2663 0.995911 2 0.995911C1.7337 0.995911 1.4783 1.1017 1.29 1.29C1.1017 1.47831 0.995908 1.7337 0.995908 2C0.995908 2.2663 1.1017 2.5217 1.29 2.71L5.59 7L1.29 11.29C1.19627 11.383 1.12188 11.4936 1.07111 11.6154C1.02034 11.7373 0.994202 11.868 0.994202 12C0.994202 12.132 1.02034 12.2627 1.07111 12.3846C1.12188 12.5064 1.19627 12.617 1.29 12.71C1.38296 12.8037 1.49356 12.8781 1.61542 12.9289C1.73728 12.9797 1.86799 13.0058 2 13.0058C2.13201 13.0058 2.26272 12.9797 2.38458 12.9289C2.50644 12.8781 2.61704 12.8037 2.71 12.71L7 8.41L11.29 12.71C11.383 12.8037 11.4936 12.8781 11.6154 12.9289C11.7373 12.9797 11.868 13.0058 12 13.0058C12.132 13.0058 12.2627 12.9797 12.3846 12.9289C12.5064 12.8781 12.617 12.8037 12.71 12.71C12.8037 12.617 12.8781 12.5064 12.9289 12.3846C12.9797 12.2627 13.0058 12.132 13.0058 12C13.0058 11.868 12.9797 11.7373 12.9289 11.6154C12.8781 11.4936 12.8037 11.383 12.71 11.29L8.41 7Z" fill="#565252"/>
                    </svg>  
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-left-column modal-column">
                    <div class="modal-row">
                        <div class="modal-icon-row">
                            <label for="task-name-new">
                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V2C20 0.9 19.1 0 18 0ZM2 8H6V10H2V8ZM12 14H2V12H12V14ZM18 14H14V12H18V14ZM18 10H8V8H18V10Z" fill="#565252"/>
                                </svg>
                            </label>
                        </div>
                        <div class="row-right-side">
                            <div class="title-block text text-19">
                            Task:  <?= $task[0]['Title'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-row">
                        <div class="modal-icon-row">
                            <label>
                                <svg width="20" height="16" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.5 0C0.367392 0 0.240215 0.0526785 0.146447 0.146447C0.0526785 0.240215 0 0.367392 0 0.5C0 0.632608 0.0526785 0.759785 0.146447 0.853553C0.240215 0.947321 0.367392 1 0.5 1H15.5C15.6326 1 15.7598 0.947321 15.8536 0.853553C15.9473 0.759785 16 0.632608 16 0.5C16 0.367392 15.9473 0.240215 15.8536 0.146447C15.7598 0.0526785 15.6326 0 15.5 0H0.5Z" fill="#565252"/>
                                    <path d="M0.5 3C0.367392 3 0.240215 3.05268 0.146447 3.14645C0.0526785 3.24021 0 3.36739 0 3.5C0 3.63261 0.0526785 3.75978 0.146447 3.85355C0.240215 3.94732 0.367392 4 0.5 4H15.5C15.6326 4 15.7598 3.94732 15.8536 3.85355C15.9473 3.75978 16 3.63261 16 3.5C16 3.36739 15.9473 3.24021 15.8536 3.14645C15.7598 3.05268 15.6326 3 15.5 3H0.5Z" fill="#565252"/>
                                    <path d="M0 6.5C0 6.36739 0.0526785 6.24021 0.146447 6.14645C0.240215 6.05268 0.367392 6 0.5 6H15.5C15.6326 6 15.7598 6.05268 15.8536 6.14645C15.9473 6.24021 16 6.36739 16 6.5C16 6.63261 15.9473 6.75979 15.8536 6.85355C15.7598 6.94732 15.6326 7 15.5 7H0.5C0.367392 7 0.240215 6.94732 0.146447 6.85355C0.0526785 6.75979 0 6.63261 0 6.5Z" fill="#565252"/>
                                    <path d="M0.5 9C0.367392 9 0.240215 9.05268 0.146447 9.14645C0.0526785 9.24021 0 9.36739 0 9.5C0 9.63261 0.0526785 9.75979 0.146447 9.85355C0.240215 9.94732 0.367392 10 0.5 10H10.5C10.6326 10 10.7598 9.94732 10.8536 9.85355C10.9473 9.75979 11 9.63261 11 9.5C11 9.36739 10.9473 9.24021 10.8536 9.14645C10.7598 9.05268 10.6326 9 10.5 9H0.5Z" fill="#565252"/>
                                </svg>
                            </label>
                        </div>
                        <div class="row-right-side">
                            <div class="title-block">
                                <div class="input-iteractive text-title-modal text text-19">
                                    <?= $notification[0]['NotificationText'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="abandon-notification modal-row text">
                        <?php 
                            if (!$sender) {
                        ?>
                            <div class="abandon-notification-left">
                                <input type="checkbox" name="abandon-checker" id="abandon-checker">
                            </div>
                            <div class="abandon-notification-right text text-15">
                                <label for="abandon-checker">
                                    <b>abandon a notification</b>   
                                </label>
                            </div>
                        <?php
                            } else {
                        ?>
                            <div class="abandon-notification-left">
                                <input type="checkbox" name="abandon-checker" id="abandon-checker" <?= $status_not == 'canceled' ? "checked=\"checked\"" : ''?> onclick="return false" />
                            </div>
                            <div class="abandon-notification-right text text-15">
                                <label for="abandon-checker">
                                    <b>abandon a notification</b>   
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                    <script>
                        $(document).ready( function () {
                            $('body').on('change','#abandon-checker', function (event ) {
                                if(event.target.checked){
                                    $('#discription-task-new').attr('required', 'required');
                                } else {
                                    $('#discription-task-new').removeAttr('required');
                                }
                            });  
                        })
                    </script>
                    <textarea class="text text-14" name="notification-feedback" id="discription-task-new" cols="30" rows="8" placeholder="Enter reason or answer..." <?= $sender ? 'readonly' : '' ?>><?php 
                            if ($sender) {
                                echo $notification[0]['ReplyMessage'];
                            }?></textarea>
                </div>
                <div class="modal-right-column modal-column">
                    <div class="modal-right-top">
                        <div class="modal-row">
                            <div class="modal-icon-row">
                                <label>
                                    <svg width="20" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.0625 19.6875H7.21875C6.87076 19.6872 6.53712 19.5488 6.29106 19.3027C6.04499 19.0566 5.9066 18.723 5.90625 18.375V14.4375H7.21875V18.375H17.0625V3.9375H11.1562V2.625H17.0625C17.4105 2.62535 17.7441 2.76374 17.9902 3.00981C18.2363 3.25587 18.3747 3.58951 18.375 3.9375V18.375C18.3747 18.723 18.2363 19.0566 17.9902 19.3027C17.7441 19.5488 17.4105 19.6872 17.0625 19.6875Z" fill="#565252"/>
                                        <path d="M11.1562 6.5625H15.75V7.875H11.1562V6.5625Z" fill="#565252"/>
                                        <path d="M10.5 9.84375H15.75V11.1562H10.5V9.84375Z" fill="#565252"/>
                                        <path d="M9.84375 13.125H15.75V14.4375H9.84375V13.125Z" fill="#565252"/>
                                        <path d="M5.90625 12.4688C5.03627 12.4679 4.20218 12.1219 3.58702 11.5067C2.97185 10.8916 2.62587 10.0575 2.625 9.1875V1.96875H3.9375V9.1875C3.9375 9.70965 4.14492 10.2104 4.51413 10.5796C4.88335 10.9488 5.3841 11.1562 5.90625 11.1562C6.4284 11.1562 6.92915 10.9488 7.29837 10.5796C7.66758 10.2104 7.875 9.70965 7.875 9.1875V3.28125C7.875 3.1072 7.80586 2.94028 7.68279 2.81721C7.55972 2.69414 7.3928 2.625 7.21875 2.625C7.0447 2.625 6.87778 2.69414 6.75471 2.81721C6.63164 2.94028 6.5625 3.1072 6.5625 3.28125V9.84375H5.25V3.28125C5.25 2.75911 5.45742 2.25835 5.82663 1.88913C6.19585 1.51992 6.69661 1.3125 7.21875 1.3125C7.74089 1.3125 8.24165 1.51992 8.61087 1.88913C8.98008 2.25835 9.1875 2.75911 9.1875 3.28125V9.1875C9.18663 10.0575 8.84065 10.8916 8.22548 11.5067C7.61032 12.1219 6.77623 12.4679 5.90625 12.4688Z" fill="#565252"/>
                                    </svg>
                                </label>
                            </div>
                            <div class="row-right-side">
                                <div class="title-block">
                                    <div class="input-iteractive text-title-modal text text-19">
                                        Attach document
                                    </div>
                                </div>
                                <div id="moreUpload">
                                    <div class="attachment-block">
                                        <label for="attachment">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="32" height="32" rx="7" fill="#FBFBFB"/>
                                                <rect x="0.25" y="0.25" width="31.5" height="31.5" rx="6.75" stroke="#565252" stroke-opacity="0.4" stroke-width="0.5"/>
                                                <path d="M8.88898 24.8889H19.5557V23.1111H8.88898V12.4444H7.11121V23.1111C7.11121 24.0916 7.90854 24.8889 8.88898 24.8889Z" fill="#565252"/>
                                                <path d="M23.1112 7.1111H12.4445C11.4641 7.1111 10.6667 7.90843 10.6667 8.88888V19.5555C10.6667 20.536 11.4641 21.3333 12.4445 21.3333H23.1112C24.0916 21.3333 24.889 20.536 24.889 19.5555V8.88888C24.889 7.90843 24.0916 7.1111 23.1112 7.1111ZM21.3334 15.1111H18.6667V17.7778H16.889V15.1111H14.2223V13.3333H16.889V10.6667H18.6667V13.3333H21.3334V15.1111Z" fill="#565252"/>
                                            </svg>
                                        </label>
                                        <input class="input-file-first" style="display: none" type="file" name="attachment[]" id="attachment"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-row">
                            <div class="modal-icon-row">
                                <label>
                                    <svg width="20" height="20" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.7223 8.27768C10.0739 7.62949 9.19453 7.26537 8.27766 7.26537C7.36079 7.26537 6.48145 7.62949 5.83299 8.27768L3.38753 10.7223C2.73906 11.3708 2.37476 12.2503 2.37476 13.1674C2.37476 14.0845 2.73906 14.964 3.38753 15.6125C4.036 16.2609 4.91552 16.6253 5.8326 16.6253C6.74967 16.6253 7.62919 16.2609 8.27766 15.6125L9.49999 14.3901" stroke="#565252" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.27771 10.7223C8.92617 11.3705 9.80551 11.7347 10.7224 11.7347C11.6392 11.7347 12.5186 11.3705 13.167 10.7223L15.6125 8.27767C16.261 7.6292 16.6253 6.74969 16.6253 5.83261C16.6253 4.91553 16.261 4.03602 15.6125 3.38755C14.964 2.73908 14.0845 2.37477 13.1674 2.37477C12.2504 2.37477 11.3708 2.73908 10.7224 3.38755L9.50004 4.60988" stroke="#565252" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </label>
                            </div>
                            <div class="row-right-side">
                                <div class="title-block">
                                    <div class="input-iteractive text-title-modal text text-19">
                                        Attach link
                                    </div>
                                </div>
                                <div id="moreUpload-link">
                                    <div class="lattachment-link-block block-link-add">
                                        <label for="lattachment-link">
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.8333 8.70833C15.6234 8.70833 15.422 8.79174 15.2735 8.94021C15.1251 9.08867 15.0417 9.29004 15.0417 9.5V14.25C15.0417 14.46 14.9583 14.6613 14.8098 14.8098C14.6613 14.9583 14.46 15.0417 14.25 15.0417H4.75C4.54004 15.0417 4.33867 14.9583 4.19021 14.8098C4.04174 14.6613 3.95833 14.46 3.95833 14.25V4.75C3.95833 4.54004 4.04174 4.33867 4.19021 4.19021C4.33867 4.04174 4.54004 3.95833 4.75 3.95833H9.5C9.70996 3.95833 9.91133 3.87493 10.0598 3.72646C10.2083 3.57799 10.2917 3.37663 10.2917 3.16667C10.2917 2.9567 10.2083 2.75534 10.0598 2.60687C9.91133 2.45841 9.70996 2.375 9.5 2.375H4.75C4.12011 2.375 3.51602 2.62522 3.07062 3.07062C2.62522 3.51602 2.375 4.12011 2.375 4.75V14.25C2.375 14.8799 2.62522 15.484 3.07062 15.9294C3.51602 16.3748 4.12011 16.625 4.75 16.625H14.25C14.8799 16.625 15.484 16.3748 15.9294 15.9294C16.3748 15.484 16.625 14.8799 16.625 14.25V9.5C16.625 9.29004 16.5416 9.08867 16.3931 8.94021C16.2447 8.79174 16.0433 8.70833 15.8333 8.70833Z" fill="#565252"/>
                                                <path d="M12.6667 3.95833H13.9175L8.93791 8.93C8.86371 9.0036 8.80481 9.09115 8.76462 9.18763C8.72443 9.2841 8.70374 9.38757 8.70374 9.49208C8.70374 9.59659 8.72443 9.70007 8.76462 9.79654C8.80481 9.89301 8.86371 9.98057 8.93791 10.0542C9.0115 10.1284 9.09906 10.1873 9.19554 10.2275C9.29201 10.2676 9.39548 10.2883 9.49999 10.2883C9.6045 10.2883 9.70798 10.2676 9.80445 10.2275C9.90092 10.1873 9.98848 10.1284 10.0621 10.0542L15.0417 5.0825V6.33333C15.0417 6.5433 15.1251 6.74466 15.2735 6.89313C15.422 7.04159 15.6234 7.125 15.8333 7.125C16.0433 7.125 16.2447 7.04159 16.3931 6.89313C16.5416 6.74466 16.625 6.5433 16.625 6.33333V3.16667C16.625 2.9567 16.5416 2.75534 16.3931 2.60687C16.2447 2.45841 16.0433 2.375 15.8333 2.375H12.6667C12.4567 2.375 12.2553 2.45841 12.1069 2.60687C11.9584 2.75534 11.875 2.9567 11.875 3.16667C11.875 3.37663 11.9584 3.57799 12.1069 3.72646C12.2553 3.87493 12.4567 3.95833 12.6667 3.95833Z" fill="#565252"/>
                                            </svg>
                                        </label>
                                        <input class="input-link-first" type="url" name="lattachment-link[]" id="lattachment-link" placeholder="Add link..."/>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-right-bottom">
                        <div class="block-button-modal">
                            <button class="text text-21">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal-reaction"></div>
        </form>
    </div>
    <?php 
    if ($notification[0]['Status'] == 'unread') {
        $db->query (
            "UPDATE `notifications` SET `Status`='read' WHERE `NotificationID` = :idNotification",
            [
                ':idNotification' => $id
            ]
        );
    } else if ($notification[0]['EmployeesSenderID'] == 1 
            && $status_not != 'unread' 
            && $status_not != 'read' 
            && $notification[0]['SenderRead'] == 'unread') {
        $db->query (
            "UPDATE `notifications` SET `SenderRead`='read' WHERE `NotificationID` = :idNotification",
            [
                ':idNotification' => $id
            ]
        );
    }
} 
?>

<script>
    $(document).ready( function () {
        $('body').on('submit','.notification-modal-view', function (e) {  
            e.preventDefault();
            console.log($(this).serialize());
            var data = new FormData($(this)[0]);

            var modalOfClose = $(this).data('modal-id');

            $.ajax({
                
                type: "POST",
                url: "./templates/modal/form-processing/notification-reaction.php",
                data: data,

                cache: false, 
                contentType: false,
                processData: false,


                success: function(data) {
                    $.ajax({
                        type: "POST",
                        url: "./templates/number-block-notification.php",

                        success: function(data) {
                            if (data == 0) {
                                $('#count-unread-message').css('display', 'none');
                            } else {
                                $('#count-unread-message').css('display', 'flex');
                                $('#count-unread-message').html(data);
                            }
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "./templates/block-notification.php",

                        success: function(data) {
                            $('#notification-list').html(data);
                        }
                    });

                    $('#'+modalOfClose).toggleClass('modal-of-show');
                }
            });
        }); 
    })
</script>