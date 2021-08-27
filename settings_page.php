<?php
    include_once("function.php");
    require_once './functions/authenticate/check_auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
    head();
?>
<body>
    <?php
        site_header();
        include_once "./templates/settings-login-password-modal.php";
    ?>

    <div id="settings-page-main-block">
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
                            <input type="text" id="last-name-input" name="last-name-input" value="<?php echo ($employee['Surname'] != null?$employee['Surname']:"") ?>" placeholder="Not Specified">
                        </div>
                        <div class="info-block-component">
                            <label for="first-name-input" class="info-block-label">First Name</label>
                            <input type="text" id="first-name-input" name="first-name-input" value="<?php echo ($employee['Name'] != null?$employee['Name']:"") ?>" placeholder="Not Specified">
                        </div>
                        <div class="info-form-btns">
                            <button class="confirm-btn" name="bio-btn" id="bio-btn">Change</button>
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
                            <input type="text" id="contact-tel-input" name="contact-tel-input" value="<?php echo ($employee['Phone'] != null?$employee['Phone']:"") ?>" placeholder="+380XXXXXXXXX">
                        </div>
                        <div class="info-block-component">
                            <label for="contact-email-input" class="info-block-label">Email</label>
                            <input type="text" id="contact-email-input" name="contact-email-input" value="<?php echo ($employee['Email'] != null?$employee['Email']:"") ?>" placeholder="Not Specified">
                        </div>
                        <div class="info-form-btns">
                            <button class="confirm-btn" name="contact-btn" id="contact-btn">Change</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="security-info" class="info-block">
                <div class="info-blocks-heading">
                    <h3>Security</h3>
                </div>
                <div class="info-blocks-body">
                    <a class="security-btn" data-modal="change-login">Change Login</a>
                    <a class="security-btn" data-modal="change-password">Change Password</a>
                    <a href="./functions/authenticate/logout.php" class="security-btn">Log Out</a>
                </div>
            </div>
        </div>
    </div>
</body>



<script>

</script>


<script>

    $(document).ready( function () {
        $('body').on('click', '#security-info a', function (e) {  
            e.preventDefault();

            let modal = $(this).data("modal");

            $('#'+ modal + "-modal").toggleClass('modal-of-show');
        })
        
        $('body').on('click', '.modal-of', function (e) {

            const target = e.target;

            if (target.closest('.x-close')) {
                $(this).parent('.modal-of');
                modal = $(this).attr('id');
                $('#' + modal).removeClass('modal-of-show');
                $('#' + modal).find('form')[0].reset();
                $('#' + modal + ' .error').remove();
                $('#' + modal).find(".eye-svg").data('open', 'open');
                $('#' + modal).find(".eye-svg").attr('src', './inc/images/eye-icon.svg')
                $('#' + modal).find(".eye-svg").siblings('input').attr('type', 'password');
            }

            if (target === target.closest('.modal-of')) {
                modal = $(this).attr('id');
                $('#' + modal).removeClass('modal-of-show');
                $('#' + modal).find('form')[0].reset();
                $('#' + modal + ' .error').remove();
                $('#' + modal).find(".eye-svg").data('open', 'open');
                $('#' + modal).find(".eye-svg").attr('src', './inc/images/eye-icon.svg')
                $('#' + modal).find(".eye-svg").siblings('input').attr('type', 'password');
            }

        });

        var eyes = $(".eye-svg");
        eyes.on('click', function(){
            let input = $(this).parent().find("input");
            if( $(this).data('open') == 'open'){
                $(this).data('open', 'close');
                $(this).attr('src', './inc/images/close-eye-icon.svg')
                input.attr('type', 'text');
            }
            else{
                $(this).data('open', 'open');
                $(this).attr('src', './inc/images/eye-icon.svg')
                input.attr('type', 'password');
            }
        });

        

        $('#contact-form').on('input','input',function(){
            $('#'+ this.id + '~ span.error').remove();
            if(this.id == 'contact-tel-input'){
                var pattern = new RegExp("^\\+380\\d{3}\\d{2}\\d{2}\\d{2}$");
                var item = "Phone";
            }
            else{
                var pattern = new RegExp("^((?!\\.)[\\w\\-_.]*[^.])(@\\w+)(\\.\\w+(\\.\\w+)?[^.\\W])$");
                var item = "Email";
            }
            if(!pattern.test($(this).val()) && $(this).val()!=""){
                $(this).addClass('invalid-input');
                $(this).after('<span class="error">'+item+' does not match the template</span>');
                $('#contact-btn').prop('disabled',true)
            }
            else{
                $(this).removeClass('invalid-input');
                $('#'+ this.id + '~ span.error').remove();
                $('#contact-btn').prop('disabled',false);
                console.log($('span.error'))
            }

        })
        $('.info-block form').on('submit', function(event){
            event.preventDefault();
            if(this.id == "personal-info-form"){
                var data = {'bio-data' : $(this).serialize()}
            }
            else{
                var data = {'contact-data' : $(this).serialize()}
            }
            console.log(data)
            $.ajax({
                type: "POST",
                url: './functions/user_settings/set_account_info.php', 
                data: data, 
                success: function(data) {
                    console.log(data);
                    if(data == "OK"){
                        add_result_message('Data was changed successfully', 'success-reply-message');
                        setTimeout(remove_result_message, 3000);
                    }
                    if(data == "ERROR"){
                        add_result_message('Something go wrong :(', 'error-reply-message');
                        setTimeout(remove_result_message, 3000);
                    }

                }
           });
        });

        $('.settings-modal form').on('submit', function(e){
            e.preventDefault();
            var form = $(this);
            form.find('.error').remove();
            $.ajax({
                type: "POST",
                url: './functions/user_settings/set_account_info.php',
                data: {'login-password' : $(this).serialize()},
                success: function(data) {
                    console.log(data);
                    if(data == "OK"){
                        add_result_message('Data was changed successfully', 'success-reply-message');
                        setTimeout(remove_result_message, 3000);
                        form[0].reset();
                    }
                    if(data == "ERROR"){
                        add_result_message('Something go wrong :(', 'error-reply-message');
                        setTimeout(remove_result_message, 3000);
                        form[0].reset();
                    }
                    else{
                        let errors = JSON.parse(data);
                        console.log(errors);
                        for (const key in errors) {
                            form.find('[data-error="'+key+'"]').after('<span class="error">'+errors[key]+'</span>');
                        }
                    }
                    
                }
           });
        });
        $('body').on('input', '.settings-modal input', function(){
            $(this).parent().siblings('.error').remove();
        })
        function add_result_message(msg, type){
            $('#settings-main-block').before('<div id="response-message-block" class="response-message"></div>');
            $('#response-message-block').append('<span id="settings-response-message" class="settings-response-message '+type+'">'+msg+'</span>');
            fading_result_message($('#settings-response-message'));
            console.log(msg);
        }
        function fading_result_message(msgBlock){
            msgBlock.fadeTo(0.5,1).delay(2000).fadeTo(0.5,0);
        }
        function remove_result_message(){
            $('#response-message-block').remove();
        }
    });
    

</script>

</html>