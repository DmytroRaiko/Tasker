<?php
    require './db/database.php';
    session_start();
    $db = new Database();
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_hash'])){
        
        $sql = $db -> query(
                "SELECT Hash1 from user where UserID = :id",
                [
                    ":id" => $_SESSION['user_id']
                ]
            );
        if(count($sql) != 0){
            if($sql[0]['Hash1'] != $_SESSION['user_hash']){
                $authorize = false;
            }
            else{
                $authorize = true;
            }
        }
        else{
            $authorize = false;
        }
    }
    else{
        if(isset($_COOKIE['remember_token']) && !empty($_COOKIE['remember_token'])){
            
            $sql = $db -> query(
                "SELECT user.UserID, user.Hash1, employees.EmployeeID from user join employees on user.UserID = employees.UserID where user.Hash2 = :hash",
                [
                    ":hash" => $_COOKIE['remember_token']
                ]
            );

            if(count($sql) != 0){
                $_SESSION['user_hash'] = $sql[0]['Hash1'];
                $_SESSION['user_id'] = $sql[0]['UserID'];
                $_SESSION['emp_id'] = $sql[0]['EmployeeID'];
                $authorize = true;
            }
            else{
                $authorize = false;
            }

        }
        else{
            $authorize = false;
        }
        
    }
    if(!$authorize){
        header("Location: ./log_page.php?action=signin");
    }
    

