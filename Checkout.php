<?php
   error_reporting(E_ERROR | E_PARSE);
  include('header.php');
 
  require_once('class_libs/HOMECLASS.php');

  $home = new HOMECLASS;

  if(isset($_POST['remove_btn'])){
      $home->Removeproduct($_POST);
      //print_r($_POST);
  } 

   if(isset($_POST['goto_customer_details']) && (isset($_SESSION['cartList']) && $_SESSION['cartList']['customer_details']['status'] == 0)){
      //$home->Removeproduct($_POST);
      //print_r($_POST); 
     $home->confirm_checkout($_POST);
      //print_r($_SESSION['cartList']);  
  } 

  if(isset($_POST['customer_details']) && (isset($_SESSION['cartList']) && $_SESSION['cartList']['customer_details']['status'] == 1)){
      //$home->Removeproduct($_POST);
      //print_r($_POST); 
      $old = $_POST;
      $customer_details = $home->customer_details($_POST);
      if($customer_details['status'] == 'error'){
        $errors = $customer_details['message'];
     }
      //print_r($_SESSION['cartList']);  
  } 

  if(isset($_POST['goto_payment_details']) && (isset($_SESSION['cartList']) && $_SESSION['cartList']['payment_details']['status'] == 0)){
      //$home->Removeproduct($_POST);
      $home->confirm_payment($_POST);
      
     // print_r($_SESSION['cartList']);  
  } 

    if(isset($_POST['payment_details']) && (isset($_SESSION['cartList']) && $_SESSION['cartList']['payment_details']['status'] == 1)){
      //$home->Removeproduct($_POST);
      //print_r($_POST); 
      $old = $_POST;
      $payment_details = $home->payment_details($_POST);
      if($payment_details['status'] == 'error'){
        $errors = $payment_details['message'];
      }
      if($payment_details['status'] == 'success'){
          $success = $payment_details['message'];
      }
      //print_r($_SESSION['cartList']);  
  } 
  
?>

<!-- ============================== Banner part ========================= -->
<main>    


    


    
<!-- =================================== Service part ================================== -->
    
<section id="service" class="section-padding text-center bg-warning">
  <div class="container">
        <div class= "row">
           <?php
            if(isset($success)){
             ?>
             <div class="alert alert-success fw-bold" role="alert" name="success">
               <?php print $success['success']; ?>
             </div>
             <?php
                header('Refresh:1,url=dashboard/dashboard.php');
                }
             ?>
           <div class="col-sm-12 col-md-6 col-lg-6 mx-auto">
             <?php
                if(isset($_SESSION['cartList'])){
             ?>
               <table class="table table-info">
                 <tr>
                   <th>Product Details</th>
                   <th>Quantity</th>
                   <th>Price</th>
                   <th>Subtotal</th>
                 </tr> 
              <?php
                 if(count($_SESSION['cartList']['items']) > 0){
                     $total=0;
                     foreach($_SESSION['cartList']['items'] as $item){
              ?>
                  <tr>
                   <td>
                     <div class="d-flex gap-2">
                       <img src="images/products_img/<?php echo $item['Image']; ?>" alt="<?php echo $item['Name']; ?>" style="height:50px; width:50px;">  
                       <div class="text-start">
                         <h6><?php echo $item['Name']; ?><br><?php echo $item['SKU']; ?></h6> 
                         <form method="post">
                            <input type="hidden" name="remove_id" value="<?php echo $item['SKU'];?>">
                            <button type="submit" name="remove_btn" class="bg-transparent border-0 text-danger text-center">Delete</button>  
                         </form>
                       </div>
                     </div>     
                   </td> 
                    
                   <td><?php echo $item['Quantity']; ?></td> 
                   <td><?php echo $item['Price']; ?></td> 
                   <td><?php echo $subtotal=($item['Quantity']*$item['Price']); ?></td> 
                 </tr> 
              <?php
                    $total += $subtotal;
                     }
                 }else{
                     
              ?>
                 <tr>
                   <td colspan="4">No product available</td>  
                 </tr>   
              <?php
                 }   
              ?>
                 <tr>
                   <td></td>
                   <td></td>
                   <td class="fw-bold">Total:</td>  
                   <td><?php echo $total??0; ?></td>
                 </tr>
             
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr> 
               </table>
             <?php
                }
             ?>
             <?php
               if(isset($total) && $total>0){
             ?>
              <form method="post">
             <?php  
                  if($_SESSION['cartList']['customer_details']['status'] > 0){
             ?>
              <div class="border border-dark border-4 my-5 px-4">
                 <h3 class="text-center text-black my-2 fw-bold">Customer Information</h3>
                 <div class="form-floating my-3">
                   <input type="text" class="form-control" id="Name" name="name" value="<?php echo $old['name']??$_SESSION['authentication']['name']?? ''; ?>">
                   <label for="Name">Name</label>
                 </div>
                   
                 <div class="form-floating my-3">
                   <input type="text" class="form-control" id="Phone_no" name="phone_no" value="<?php echo $old['phone_no']??$_SESSION['authentication']['phone_no']?? ''; ?>">
                   <label for="Phone_no">Phone No.</label>
                  </div>
                   
                 <div class="form-floating my-3">
                   <input type="text" class="form-control" id="Address" name="address" value="<?php echo $old['address']??$_SESSION['authentication']['address']?? ''; ?>">
                   <label for="Address">Address</label>
                 </div>
             </div>
             <?php
              }if($_SESSION['cartList']['payment_details']['status'] > 0){
             ?> 
             <div class="border border-dark border-4 my-5 px-4">
                  <h3 class="text-center text-black my-2 fw-bold">Payment Information of<span class="text-body"> +8801776487402</span></h3>
                  <div class="my-3 ms-0">
                  <div class="mt-2" data-bs-toggle="collapse" data-bs-target="#collapseExample" >
                    <input type="radio" class="btn-check" name="payment_policy" id="cp" autocomplete="off" value="cp" <?php echo isset($old['payment_policy']) && $old['payment_policy'] == 'cp'? 'checked' : ''; ?>>
                    <label class="btn btn-outline-dark" for="cp">Cash payment</label> 
                  </div>
                </div>
                <p class="text-dark fw-bold text-start my-2" style="font-size:15px;"> <?php echo $errors['payment_policy']??'' ?></p>
                <div class="collapse" id="collapseExample">
                  <div class="">
                    <div class="form-floating my-3">
                       <input type="text" class="form-control" id="Sender_number" name="sender_number" value="<?php echo $old['sender_number']??$_SESSION['authentication']['phone_no']?? ''; ?>">
                       <label for="Sender_number">Sender number</label>
                       <p class="text-dark fw-bold text-start my-2" style="font-size:15px;"> <?php echo $errors['sender_number']??'' ?></p>
                    </div>
                   
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" id="Transaction_id" name="transaction_id" value="<?php echo $old['transaction_id']??$_SESSION['cartList']['payment_details']['transaction_id']?? ''; ?>">
                      <label for="Transaction_id">Transaction id</label>
                      <p class="text-dark fw-bold text-start my-2" style="font-size:15px;"> <?php echo $errors['transaction_id']??'' ?></p>
                    </div>
                  </div>
                </div> 
              </div>
              <?php
               } 
                   $CART = $_SESSION['cartList'];
                   $CART_status = $CART['customer_details']['status'] == 1 ? 'customer_details' : ($CART['customer_details']['status'] == 2 && $CART['payment_details']['status'] == 0 ? 'goto_payment_details' : ($CART['payment_details']['status'] == 1 ? 'payment_details' : 'goto_customer_details'));
                 ?>
                 <button class="btn btn-dark" type="submit" name="<?php echo $CART_status; ?>">Check out now</button>
               </form>
            <?php
               }
            ?>
           </div>
        </div>
    </div>      
</section>
   
    


   
    
 
</main>

<?php
 include('footer.php');
?>
