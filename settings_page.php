<?php
    include_once("function.php");
    require_once './authenticate/check_auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
    head();
?>
<body>
    <?php
        site_header();
    ?>

    <div id="settings-main-block">
        <h1>Account Information</h1>

        <div id="info-blocks-wrapper">
            <div id="personal-info" class="info-block">
                <div class="info-blocks-heading">
                    <h3>Personal Information</h3>
                </div>
                <div class="info-blocks-body">
                    <form action="" id="personal-info-form" class="info-block-form">
                        <div class="info-block-component">
                            <label for="last-name-input" class="info-block-label">Last Name</label>
                            <input type="text" id="last-name-input" name="last-name-input" value="Глуховцов">
                        </div>
                        <div class="info-block-component">
                            <label for="first-name-input" class="info-block-label">First Name</label>
                            <input type="text" id="first-name-input" name="first-name-input" value="Дмитро">
                        </div>
                        <div class="info-form-btns">
                            <button class="confirm-btn" >Change</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="contact-info" class="info-block">
                <div class="info-blocks-heading">
                    <h3>Contacts</h3>
                </div>
                <div class="info-blocks-body">
                    <form action="" id="contact-form" class="info-block-form">
                        <div class="info-block-component">
                            <label for="contact-tel-input" class="info-block-label">Phone</label>
                            <input type="text" id="contact-tel-input" name="contact-tel-input" value="+380952211089">
                        </div>
                        <div class="info-block-component">
                            <label for="contact-email-input" class="info-block-label">Email</label>
                            <input type="text" id="contact-email-input" name="contact-email-input" value="dmitrogluhovcov@gmail.com">
                        </div>
                        <div class="info-form-btns">
                            <button class="confirm-btn">Change</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="security-info" class="info-block">
                <div class="info-blocks-heading">
                    <h3>Security</h3>
                </div>
                <div class="info-blocks-body">
                    <a class="security-btn">Change Login</a>
                    <a class="security-btn">Change Password</a>
                    <a href="./authenticate/logout.php" class="security-btn">Log Out</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>