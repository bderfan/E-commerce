<?php
  error_reporting(E_ERROR | E_PARSE);
  require('header.php');

   require_once('../class_libs/HOMECLASS.php');

   $home = new HOMECLASS;

  
   
   
   $product_indexes = $home->allProducts($_GET['id']);
       

    if(isset($_POST['cart'])){
      
      $cart = $home->Cart($_POST);
      $old = $_POST;         
      #print_r($old);
      if($cart['status'] == 'error'){
         $errors = $cart['message'];
     }
      
  }

   
?>
  
  

<div class="content">
	  <div class="container-full">
         <div class="d-flex justify-content-end my-3" style="padding-top: 50px;">
                <!-- Button trigger modal -->
                 <a href="dashboard2.php" class="btn btn-dark">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                     </svg>
                 </a>
           </div>
		<!-- Main content -->
		<section class="content">
            
            <div class="row">
              <?php
                 if(mysqli_num_rows($product_indexes)>0){
                     while($product_index = $product_indexes->fetch_assoc()){
               ?>
              <div class="col-3 d-flex align-items-stretch">
                <div class="card rounded" style="width: 100%; background-color: #BDBDBD;">
                    <img src="../images/products_img/<?php echo $product_index['image']; ?>" alt="<?php echo $product_index['name']; ?>" style="width:100%; height: 200px;" class="rounded">
                    <div class="card-body text-center">
                      <h5 class="fw-bold fs-2"><?php echo $product_index['name']; ?></h5>
                      <h6 class="fw-bold fs-4"><?php echo $product_index['price']; ?>  <del><?php echo $product_index['strike_price']; ?></del></h6> 
                      <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal_<?php echo $product_index['id'];?>">Add to cart</a>
                      </div>
                    </div>
                  </div>
               </div>
               <!-- Modal -->
                 <div class="modal fade" id="exampleModal_<?php echo $product_index['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                       <div class="modal-content" style="background-color: #455A64;">
                         <div class="modal-header">
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                           <div class="my-2 d-flex justify-content-center"> 
                              <img src="../images/products_img/<?php echo $product_index['image']; ?>" alt="<?php echo $product_index['name']; ?>" style="width:75%; height: 200px;">
                           </div>
                           <h4 class="text-white fs-4"><?php echo $product_index['name']; ?></h4>
                           <h5 class="text-white fs-4"><?php echo $product_index['price']; ?> <del><?php echo $product_index['strike_price']; ?></del></h5> 
                           <h6 class="text-white mt-2 fs-5"><?php echo $product_index['details']; ?></h6>
                            <form class="my-3" method="post">
                               <label for="quantity" class="text-white d-flex justify-content-center">Quantity</label>
                               <div class="d-flex justify-content-center">
                                  <input type="hidden" name="prdct_id" id="prdct_id" value="<?php echo $product_index['id']?>">
                                  <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $old['quantity']; ?>" style="width:300px;">
                               </div>
                               <div class="d-flex justify-content-center">
                                  <p class="mt-2 text-warning fw-bold" style="font-size:15px;"> <?php echo $errors['quantity']??'' ?></p> 
                               </div>
                               <div class="d-flex justify-content-center">
                                  <button type="submit" name="cart" class="btn btn-danger mt-4">Cart</button>
                               </div>
                           </form>
                         </div>
                         <div class="modal-footer">
                           <div class="d-flex justify-content-center">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
               <?php
                     }
                 }else{
              ?>
                <h1 class="text-center py-5">Sorry! no product is available</h1>
              <?php
                 }
              ?>
            </div>
			<div class="row">
				<div class="col-6 mx-auto">
                   <div class="d-flex justify-content-center">
                     <form method="post">
                       <button class="btn btn-dark btn-lg" type="submit" name="logout">Logout</button>
                     </form>
                   </div>
                </div>
			</div>
		</section>
		<!-- /.content -->
	  </div>
  </div>

<?php
  require('footer.php');
?>