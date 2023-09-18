<?php
  ob_start();
  session_start();
  
  
  require_once('class_libs/HOMECLASS.php');

  $home = new HOMECLASS;

  $indexes = $home->categorylist();

 
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">    
   <title>My E-commerce</title>
   <link rel="stylesheet" href="css/all.min.css">    
   <link rel="stylesheet" href="css/bootstrap-icons.css">  
   <link rel="stylesheet" href="css/bootstrap.min.css">  
   <link rel="stylesheet" href="css/bootstrap-extensions.css">    
   <link rel="stylesheet" href="css/style.css">
   <style>
       section{
           padding-top: 115px;
           padding-bottom: 50px;
       } 
       
       
       .carousel-control-prev-icon, .carousel-control-next-icon {
           height: 50px;
           width: 50px;
           outline: #01275a;
           background-color: #01275a;
           background-size: 100%, 100%;
           border-radius: 10%;
           border: 1px solid black;
       }
       .nav-link:hover{
           background-color: #f7f723;
           transition: all linear 1s;
           border-radius: 10%;
       }
       .nav-Link button:hover{
           background-color: #b80101;
           transition: all linear 1s;
       }
   </style>
</head>
<body>
<header>
<!-- ============================ logo and menu part ================================ -->  
<nav id="Main-nav" class="navbar navbar-expand-lg navbar-dark bg-white">
         <div class="container-fluid">
              <a class="navbar-brand text-black" href="#"><img src="images/logo.png" alt="logo" class="img-fluid" style="width:100px; height:100px;"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                  <span class="navbar-toggler-icon"></span>
              </button>
             <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
             <div class="offcanvas-header">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
             </div>
            <div class="offcanvas-body">
               <ul class="navbar-nav d-flex align-items-center justify-content-end flex-grow-1 pe-3 text-dark">
                <li class="nav-item transition-all duration-500">
                  <a class="nav-link text-dark fw-bold fs-5" href="index.php">Home</a>
                </li>
                <?php 
                  if(mysqli_num_rows($indexes) > 0){
                      
                ?>
                   <li class="nav-item">
                     <a class="nav-link text-dark fw-bold fs-5" href="your-products.php">Chose Products</a>
                   </li>
                <?php          
                      
                  }   
                ?> 
                <div class="btn-group dropstart">
                   <?php
                   if(isset($_SESSION['cartList'])){
                       if(count($_SESSION['cartList']['items']) > 0){
                   ?>
                     <button class="btn dropdown-toggle text-black py-2 position-relative fw-bold fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products cart list
                           <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                             <?php echo count($_SESSION['cartList']['items']); ?>
                           </span>
                      </button>
                   <?php
                          }
                      }
                   ?>
                  
                     <?php
                        if(isset($_SESSION['cartList'])){
                     ?>        
                       <ul class="dropdown-menu dropdown-menu-start" style="width:400px;">
                     <?php 
                            if(count($_SESSION['cartList']['items']) > 0){
                                foreach($_SESSION['cartList']['items'] as $items){
                                   # print_r($items);
                      ?>             
                           <li class="dropdown-item">
                              <div class="container">
                                <div class="row">
                                  <div class="col-6">
                                    <img src="images/products_img/<?php echo $items['Image']; ?>" alt="<?php echo $items['Name']; ?>" style="width:75px; height:75px;"> 
                                  </div>
                                  <div class="col-6">
                                     <h6 class="text-danger">Name: <?php echo $items['Name']; ?><br>Sku: <?php echo $items['SKU']; ?><br>Price: <?php echo $items['Price']; ?><br>Qty: <?php echo $items['Quantity']; ?><br>Total price: <?php echo $items['Price']*$items['Quantity']; ?></h6>   
                                  </div>
                                </div> 
                              </div>  
                              <div class="mt-1 d-flex justify-content-center">
                                <a href="Checkout.php" class="btn btn-sm btn-warning w-50">Checkout</a>
                              </div>
                           </li> 
                     <?php  
                                }
                            }else{
                     ?>
                             <li class="dropdown-item text-center text-danger">No product</li>
                     <?php  
                            }
                     ?>
                    </ul>
                     <?php
                        }
                      ?>
                </div>
                <?php
                  if(isset($_SESSION['authenticate'])){
                      
                ?>
                <li class="nav-item">
                  <a class="nav-Link text-dark ms-2" href="login.php"><button type="button" class="btn btn-dark fw-bold fs-5">Dashboard</button></a>
                </li> 
                <?php
                  }else{  
                ?>
                <li class="nav-item">
                  <a class="nav-Link text-dark ms-2" href="login.php"><button type="button" class="btn btn-dark fw-bold fs-5">Login</button></a>
                </li>
                <?php
                  }
                ?>
               </ul>
        </div>
      </div>
    </div>
  </nav>
 

</header>