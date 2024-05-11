<?php
require_once 'admin.php';

use mainadmin\admin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action     = $_POST['action'];

    if (!empty($action)) {

        if ($action == 'login') {

            $email      = $_POST['email'];
            $email      = admin::cleanValue($email);
            $password   = $_POST['password'];
            $password   = admin::cleanValue($password);
            $result     = admin::login($email, $password);

            if ($result == 1) {
                
                $_SESSION['logged_user_status'] = '1';
            }
            echo $result;

        }elseif ($action == 'remove_product') {
            $id     = $_POST['id'];
            $id     = admin::cleanValue($id);
            $result = admin::remove_product($id);
            echo $result;
        }elseif($action == 'edit_product') {

            $id     = $_POST['id'];
            $id     = admin::cleanValue($id);
            $result = admin::edit_product($id);
            echo $result;  
        }elseif ($action == "update_product") {

            $id             = $_POST['id'];
            $id             = admin::cleanValue($id);
            $name           = $_POST['name'];
            $name           = admin::cleanValue($name);
            $description    = $_POST['description'];
            $description    = admin::cleanValue($description);
            $price          = $_POST['price'];
            $price          = admin::cleanValue($price);
            $quantity       = $_POST['quantity'];
            $quantity       = admin::cleanValue($quantity);
            $result         = admin::update_product($id, $name, $description, $price, $quantity);
           
            echo $result;
            
            
        }elseif ($action == "pagination") {
            $pages  = $_POST['page'];
            $pages  = admin::cleanValue($pages);
            $result = admin::pagination($pages);
            echo $result;
        }
    }else{

        echo "invalid action";
        
    }

}else{
        echo "Invalid request";
}

?>