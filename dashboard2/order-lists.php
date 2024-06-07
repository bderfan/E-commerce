
 <?php
   error_reporting(E_ERROR | E_PARSE);
   
   require('sidebar.php'); 
   require('../class_libs/ORDERCLASS.php');
   
   
   $old = $_POST;
   
   $orders = new ORDERCLASS;
   
   $order = $orders->getOrderlist($_GET['invoice']);
   $rows = $orders->getProducts($order['id']);
   
   if(isset($_POST['approve'])){
       $approve = $orders->Approved_order($_POST);
       
       if($approve['status'] == 'success'){
           $success = $approve['message'];
       }  
   
   }
   
   if(isset($_POST['delete'])){
       $delete = $orders->Delete_order($_POST);
       
       if($delete['status'] == 'success'){
           $success = $delete['message'];
       }  
   
   }
   
   
   ?>

<div class="content-wrapper">
   <div class="container-full">
      <!-- Main content -->
      <section class="content">
         <div class="row">
            <div class="col-12">
               <div>
                  <?php
                     if(isset($success)){
                      ?>
                  <div class="alert alert-success" role="alert" name="success">
                     <?php print $success['success']; ?>
                  </div>
                  <?php
                     header('Refresh:1,url=dashboard2.php');
                     }
                     ?>
               </div>
               <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                  <h5 class="text-white fw-bold fs-1">Order Lists of <span class="text-black"><?php echo $order['invoice']; ?></span></h5>
                  <a href="orders.php?invoice=<?php echo $order['invoice']; ?>" class="btn btn-light">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-6">
               <h5 class="text-dark fs-4"><?php echo $order['invoice'];?></h5>
               <p class="my-1 text-dark fs-4"><?php echo $order['name'];?></p>
               <p class="my-1 text-dark fs-4"><?php echo $order['phone'];?></p>
               <p class="my-1 text-dark fs-4"><?php echo $order['address'];?></p>
            </div>
            <div class="col-6">
               <h6 class="text-dark fs-4"><b>Total price:</b> <?php echo $order['total_bill']; ?></h6>
               <h6 class="text-dark fs-4"><b>Total payment:</b> <?php echo $order['total_payment']; ?></h6>
            </div>
         </div>
         <div class="row">
            <div class="col-12 mt-5">
               <table class="table table-secondary table-hover">
                  <tr>
                     <th class="fs-5">SL</th>
                     <th class="fs-5">Name</th>
                     <th class="fs-5">Image</th>
                     <th class="fs-5">SKU</th>
                     <th class="fs-5">Price</th>
                     <th class="fs-5">Quantity</th>
                     <th class="fs-5">Total</th>
                  </tr>
                  <?php 
                     if(mysqli_num_rows($rows) > 0){
                         $x = 1;
                         while($row = mysqli_fetch_assoc($rows)){
                         
                     ?>
                  <tr>
                     <td>
                        <?php 
                           $x = $row['id'];
                           echo $x++;
                           ?>
                     </td>
                     <td>
                       <h6 class="my-1 fs-5"><?php echo $row['name'];?></h6> 
                     </td>
                     <td>
                        <img src="../images/products_img/<?php echo $row['image']?>" alt="<?php echo $row['name']?>" width="120" height="150">   
                     </td>
                     <td>
                        <h6 class="my-1 fs-5"><?php echo $row['sku'];?></h6>
                     </td>
                      <td><h6 class="fs-5"><?php echo $row['product_price'];?></h6></td>
                      <td><h6 class="fs-5"><?php echo $row['product_quantity'];?></h6></td>
                      <td><h6 class="fs-5"><?php echo $row['product_quantity']*$row['product_price'];?></h6></td>
                  </tr>
                  <?php 
                     }
                     }else{
                     ?>
                  <tr>
                     <td colspan="4" class="text-center"><h5>No data available</h5></td>
                  </tr>
                  <?php
                     }
                     ?>
               </table>
               <?php
                  if($order['status'] == 0){
                  ?>
               <form method="post">
                  <input type="hidden" name="invoice" value="<?php echo $order['invoice']; ?>">
                  <div class="container">
                     <div class="row">
                        <div class="col-6 mx-auto">
                           <div class="row">
                              <div class="col-6">
                                 <div class="d-flex justify-content-end">
                                    <button type="submit" name="delete" class="btn btn-warning">Delete</button>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="d-flex justify-content-start">
                                    <button type="submit" name="approve" class="btn btn-danger">Approve</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               <?php
                  }else if($order['status'] == 1){
                  ?>
               <form method="post">
                  <input type="hidden" name="invoice" value="<?php echo $order['invoice']; ?>">
                  <div class="container">
                     <div class="row">
                        <div class="col-6 mx-auto">
                           <div class="row">
                              <div class="d-flex justify-content-center">
                                 <button type="submit" name="delete" class="btn btn-warning">Delete</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               <?php
                  }
                  ?>
            </div>
         </div>
      </section>
      <!-- /.content -->
   </div>
</div>
<?php
   require('footer.php');  
   ?>