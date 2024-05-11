 <?php
//  error_reporting('0');
 require_once 'connection.php';

 $req_type = $_SERVER['REQUEST_METHOD'];

 if ($_SESSION['logged_user_status'] == 1) {
  
   switch ($req_type) {
      case 'POST':
   
         if(empty($_POST['view'])){
   
            include_once('layouts/login.php');
        
         }elseif ($_POST['view'] == 'login') {
        
            include_once('layouts/login.php');
        
         }elseif ( $_POST['view'] == 'dashboard') {
        
            include_once('layouts/dashboard.php');
        
         }
   
         break;
   
      case 'GET':
   
         if(empty($_GET['view'])){
   
            include_once('layouts/login.php');
        
         }elseif ($_GET['view'] == 'login') {
   
            include_once('layouts/login.php');
        
         }elseif($_GET['view'] == 'dashboard') {
        
            include_once('layouts/dashboard.php');
        
         }      
   
         break;
      
      default:
         echo "<p>Invalid Request</p>: " . $req_type;
         break;
    }


 }else{
    include_once('layouts/login.php');
 }



 
 
  
 
 ?>