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

    <div id="main-block">
        <h1>Account Information</h1>

        <div id="info-blocks-wrapper">
            <div id="personal-info" class="info-block">
                <div class="info-blocks-heading">
                    <h3>Personal Information</h3>
                </div>
                <div class="info-blocks-body">
                    <form action="" id="personal-info-form" class="info-block-form">
                        <div class="info-block">
                            <div class="info-block-component non-edit">
                                <label for="last-name-input" class="info-block-label">Last Name</label>
                                <p id="sett-last-name" class="info-block-value">Глуховцов</p>
                                <input type="text" id="last-name-input" name="last-name-input">
                            </div>
                            <div class="info-block-component non-edit">
                                <label for="first-name-input" class="info-block-label">First Name</label>
                                <p id="sett-first-name" class="info-block-value">Дмитро</p>
                                <input type="text" id="first-name-input" name="first-name-input">
                            </div>
                            <div class="info-form-btns non-edit">
                                <button class="confirm-btn">Change</button>
                                <button class="cancel-btn">Cancel</button>
                            </div>
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
                        <div class="info-block">
                            <div class="info-block-component non-edit">
                                <label for="contact-tel-input" class="info-block-label">Phone</label>
                                <p id="sett-contact-tel" class="info-block-value">+380952211089</p>
                                <input type="text" id="contact-tel-input" name="contact-tel-input">
                            </div>
                            <div class="info-block-component non-edit">
                                <label for="contact-email-input" class="info-block-label">Email</label>
                                <p id="sett-email" class="info-block-value">Дмитро</p>
                                <input type="text" id="contact-email-input" name="contact-email-input">
                            </div>
                        </div>
                        <div class="info-form-btns non-edit">
                            <button class="confirm-btn">Change</button>
                            <button class="cancel-btn">Cancel</button>
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