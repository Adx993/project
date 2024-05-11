<?php
require_once 'admin.php';

use mainadmin\admin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action     = $_POST['action'];

    if (!empty($action)) {

        if ($action == 'login') {

            $email      = $_POST['email'];
            $email      = trim($email);
            $email      = htmlspecialchars($email);
            $password   = $_POST['password'];
            $password   = trim($password);
            $password   = htmlspecialchars($password);

            $result     = admin::login($email, $password);

            if ($result == 1) {
                
                $_SESSION['logged_user_status'] = '1';
            }
            echo $result;

        }elseif ($action == 'remove_product') {
            $id     = $_POST['id'];
            $id     = trim($id);
            $id     = htmlspecialchars($id);

            $result = admin::remove_product($id);
            echo $result;
        }elseif($action == 'edit_product') {

            $id     = $_POST['id'];
            $id     = trim($id);
            $id     = htmlspecialchars($id);

            $result = admin::edit_product($id);
            echo $result;  
        }elseif ($action == "update_product") {
            
            // print_r($_POST);
            
        }elseif ($action == "pagination") {
            $pages = $_POST['page'];
            $pages = trim($pages);
            $pages = htmlspecialchars($pages);
        
            $result = admin::pagination($pages);
            echo $result;
        }
    }else{

        echo "invalid action";
        
    }

}else{
        echo "Invalid request";
    // header('location: ../index.php');
}

?>