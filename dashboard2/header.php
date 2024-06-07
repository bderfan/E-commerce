<?php
error_reporting(E_ERROR | E_PARSE);
 ob_start();
 session_start();

 if(!isset($_SESSION['authentication'])){
     header('Location:../index.php');
 }

 if(isset($_POST['logout'])){
         session_destroy();
         session_unset();
         header('Location:../index.php');
 }

 if(isset($_POST['save_btn'])){
     require('../authenticate.php');
     $update = update_user();
     if($update['status'] == 'success'){
        $success = $update['message'];
    }
      if($update['status'] == 'error'){
        $errors = $update['message'];
    }
    
  }



     
 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>My E-commerce</title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="../css/vendors_css.css">
    <!-- Bootstrap Style -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
	<!-- Style-->  
	<link rel="stylesheet" href="../css/style2.css">
	<link rel="stylesheet" href="../css/skin_color.css">
     
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
  </head>

<body class="hold-transition sidebar-mini theme-primary fixed" style="background-color: #FFF59D;">
	


<header class="main-header" style="background-color: #000;">
    <!-- Header Navbar -->
    
    
  </header>