<?php

namespace mainadmin;

require_once '../connection.php';

class admin{

    public static function login($email, $password){
        global $db;
        $sql        = "SELECT * FROM `pro_users` WHERE `email` = '{$email}' AND `password` = '{$password}'";       
        $query      = mysqli_query($db,$sql);
        $result     = mysqli_fetch_array($query);

        if ($result) {

            $_SESSION['logged_user']    = $result;
            
            $msg   = '1';
        }else{

            $msg    = '0';

        }

        return $msg;
    }



    public static function remove_product($id){
        global $db;

        $sql    = "UPDATE `pro_products` SET `deleted` = '1' WHERE `id` = '{$id}'";
        $query  = mysqli_query($db,$sql);

        if ($query) {
            $msg = '1';
        }else {
            $msg = '2';
        }

        return $msg;

    }



    public static function edit_product($id){
        global $db;
    
        $sql        = "SELECT * FROM `pro_products` WHERE `id` = '{$id}' AND `deleted` = '0'";
        $query      = mysqli_query($db, $sql);
        $result     = mysqli_fetch_assoc($query);
        $form = '';
        if ($result) {
            $form = '<input type="hidden" name="id" value="'.$result['id'].'">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="'.$result['name'].'">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required>'.$result['description'].'</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required value="'.$result['price'].'">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required value="'.$result['quantity'].'">
                        </div>
                    <input type="hidden" name="action" value="update_product">';                
        } else {
            $form = '2';
        }
        return $form;
    }



    public static function pagination($pages){
        global $db;
    
        $results_per_page = 5;
        if (isset($pages)) {
            $page       = $pages;
        } else {
            $page       = 1;
        }
        $offset         = ($page-1) * $results_per_page;
        $sql            = "SELECT * FROM `pro_products` WHERE `deleted` = '0' LIMIT $offset, $results_per_page";
        $query          = mysqli_query($db, $sql);
        $products       = mysqli_fetch_all($query, MYSQLI_ASSOC);
        $num            = 1;
    
        $html = '';
    
        foreach ($products as $product) {
            $html .= '<tr>';
            $html .= '<th scope="row">' . $num . '</th>';
            $html .= '<td>' . $product['name'] . '</td>';
            $html .= '<td>' . $product['description'] . '</td>';
            $html .= '<td>' . $product['price'] . '</td>';
            $html .= '<td>';
            $html .= '<button type="button" class="btn btn-success prod_edit" data-toggle="modal" data-target="#exampleModal" data-id="' . $product['id'] . '">Edit</button>';
            $html .= '<button class="btn btn-danger prod_remove" data-id="' . $product['id'] . '">Remove</button>';
            $html .= '</td>';
            $html .= '</tr>';
            $num++;
        }
    
        return $html;
    }


















}



?>