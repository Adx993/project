<?php

namespace mainadmin;
$path   = 'C:\wamp64\www\2024\local\PROJECT/';
require_once $path.'connection.php';

class admin{

        public static function products($type = null, $search = null) {
            global $db;
    
            $sql = "SELECT * FROM `pro_products` WHERE `deleted` = '0'";
    
            if ($type && $search) {
                $type = mysqli_real_escape_string($db, $type);
                $search = mysqli_real_escape_string($db, $search);
                $sql .= " AND `$type` LIKE '%$search%'";
            }
    
            $results_per_page = 5;
            $current_page = isset($_POST['page']) ? $_POST['page'] : 1;
            $offset = ($current_page - 1) * $results_per_page;
            $sql .= " LIMIT $offset, $results_per_page";
    
            $query = mysqli_query($db, $sql);
    
            $products = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $products[] = $row;
            }
    
            $total_products_query = mysqli_query($db, "SELECT COUNT(*) as total FROM `pro_products` WHERE `deleted` = '0'");
            if ($type && $search) {
                $total_products_query = mysqli_query($db, "SELECT COUNT(*) as total FROM `pro_products` WHERE `deleted` = '0' AND `$type` LIKE '%$search%'");
            }
            $total_products = mysqli_fetch_assoc($total_products_query)['total'];
    
            $total_pages = ceil($total_products / $results_per_page);
    
            $result = [];
            $result['products'] = $products;
            $result['total_pages'] = $total_pages;
            $result['current_page'] = $current_page;
            $result['results_per_page'] = $results_per_page;
    
            return $result;
        } 
    

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



    public static function update_product($id, $name, $description, $price, $quantity){
        global $db;
    
        $sql    = "UPDATE `pro_products` SET `name` = '{$name}', `description` = '{$description}', `price` = '{$price}', `quantity` = '{$quantity}' WHERE `id` = '{$id}'";
        $query  = mysqli_query($db, $sql);
    
        if ($query) {
            $msg = '1';
        } else {
            $msg = '2';
        }
    
        return $msg;
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



    public static function cleanValue($data){
        global $db;
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = mysqli_real_escape_string($db, $data);
        return $data;
    }


















}



?>