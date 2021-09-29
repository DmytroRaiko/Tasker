<?php 
    require '../../db/database.php';

    session_start();
    $db = new Database();
    $formData = array();
    if(isset($_POST['bio-data'])){
        
        parse_str($_POST['bio-data'], $formData);
        $name = null;
        $surname = null;
        if(isset($formData['last-name-input']) && !empty($formData['last-name-input'])){
            $surname = $formData['last-name-input'];
        }
        if(isset($formData['first-name-input']) && !empty($formData['first-name-input'])){
            $name = $formData['first-name-input'];
        }
        try{
            $sql = $db -> query(
                "UPDATE employees SET Name = :name, Surname = :surname WHERE UserID = :user ",
                [
                    ":name" => $name,
                    ":surname" => $surname,
                    ":user" => $_SESSION['user_id']
                ]
            );
            echo "OK";
        }
        catch (PDOException $e){
            echo "ERROR";
        }
    }
    if(isset($_POST['contact-data'])){
        
        parse_str($_POST['contact-data'], $formData);
        $phone = null;
        $email = null;
        if(isset($formData['contact-tel-input']) && !empty($formData['contact-tel-input'])){
            $phone = $formData['contact-tel-input'];
        }
        if(isset($formData['contact-email-input']) && !empty($formData['contact-email-input'])){
            $email = $formData['contact-email-input'];
        }
        try{
            $sql = $db -> query(
                "UPDATE employees SET Phone = :phone WHERE UserID = :user ",
                [
                    ":phone" => $phone,
                    ":user" => $_SESSION['user_id']
                ]
            );
            $sql = $db -> query(
                "UPDATE user SET Email = :email WHERE UserID = :user ",
                [
                    ":email" => $email,
                    ":user" => $_SESSION['user_id']
                ]
            );
            $sql = $db -> query(
                "UPDATE employees SET Email = :email WHERE UserID = :user ",
                [
                    ":email" => $email,
                    ":user" => $_SESSION['user_id']
                ]
            );
            echo "OK";
        }
        catch (PDOException $e){
            echo "ERROR";
        }
    }
    if(isset($_POST['login-password'])){
        $error = array();
        parse_str($_POST['login-password'], $formData);
        if(isset($formData['login-change'])){
            $login = $formData['modal-login-new'];
            $password = $formData['modal-login-new-password'];
            $loginPattern = '/^[a-zA-Z]([_]?[a-zA-Z0-9]){4,38}$/';
            if(!preg_match($loginPattern, $login)){
                $error['login-error'] = 'Login does not match the template';
            }
            try{
                $sql = $db -> query(
                "SELECT Password from user where UserID = :user ",
                    [
                        ":user" => $_SESSION['user_id']
                    ]
                );
            }
            catch (PDOException $e){
                echo "ERROR";
            }
            if(!password_verify($password, $sql[0]['Password'])){
                $error['password-error'] = 'Incorrect Pasword';
            }
            if(empty($error)){
                try{
                    $sql = $db -> query(
                    "UPDATE user set Login = :login where UserID = :user ",
                        [
                            ":login" => $login,
                            ":user" => $_SESSION['user_id']
                        ]
                    );
                    echo "OK";
                }
                catch (PDOException $e){
                    echo "ERROR";
                }
            }
            else{
                echo json_encode($error);
            }
        }
        if(isset($formData['password-change'])){
            $old_password = $formData['modal-password-old'];
            $new_password = $formData['modal-password-new'];
            $repeat_password = $formData['modal-repeat-password'];
            $passPattern = '/\w{6,40}/';
            if(!preg_match($passPattern, $new_password)){
                $error['new-password-error'] = 'Password does not match the template';
            }
            try{
                $sql = $db -> query(
                "SELECT Password from user where UserID = :user ",
                    [
                        ":user" => $_SESSION['user_id']
                    ]
                );
            }
            catch (PDOException $e){
                echo "ERROR";
            }
            if(!password_verify($old_password, $sql[0]['Password'])){
                $error['old-password-error'] = 'Incorrect Pasword';
            }
            if($new_password != $repeat_password){
                $error['repeat-new-password-error'] = 'Passwords do not match';
            }
            if(empty($error)){
                try{
                    $sql = $db -> query(
                    "UPDATE user set Password = :password where UserID = :user ",
                        [
                            ":password" => password_hash($new_password, PASSWORD_DEFAULT),
                            ":user" => $_SESSION['user_id']
                        ]
                    );
                    echo "OK";
                }
                catch (PDOException $e){
                    echo "ERROR";
                }
            }
            else{
                echo json_encode($error);
            }
        }
    }