<?php
  error_reporting(E_ERROR | E_PARSE);
  include('header.php');
 
  require_once('class_libs/HOMECLASS.php');

  $home = new HOMECLASS;

   $products_card = $home->ProductsCard($_GET['id']);
   #print_r($products_card);

  
  
?>

<!-- ============================== Banner part ========================= -->
<main>    


    


    
<!-- =================================== Service part ================================== -->
    
<section id="service" class="section-padding text-center bg-black">
  <div class="container">
    
    <!-- Service contents -->
        <div class= "row">
           <div class="col-sm-12 col-md-6 col-lg-6 mx-auto"><!-- Service 1 -->
               <div class="content py-5 px-3" style="background-color: #bbb9b924;">
                       
                        <h3 class="text-white fw-900 text-start">Details of <?php echo $products_card['name']?> product</h3>
                        <div class="d-flex justify-content-end">
                          <img src="images/products_img/<?php echo $products_card['image']?>" alt="<?php echo $products_card['name']?>" class="img-fluid">
                        </div>
                        <h4 class="text-danger fw-600 text-start mt-5">Name: <?php echo $products_card['name']?></h4>
                        <h5 class="text-warning text-start">Price: <?php echo $products_card['price']?></h5>
                        <h5 class="text-warning text-start">Strike price: <del><?php echo $products_card['strike_price']?></del></h5>
                        <h6 class="text-light text-start mt-4"><?php echo $products_card['details']?></h6>
                       
                
                   <form class="mt-5" method="post">
                       <label for="quantity" class="text-white d-flex justify-content-center">Quantity</label>
                       <div class="d-flex justify-content-center">
                          <input type="hidden" name="prdct_id" id="prdct_id" value="<?php echo $products_card['id']?>">
                          <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $old['quantity']; ?>" style="width:300px;">
                       </div>
                       <button type="submit" name="cart" class="btn btn-danger mt-4">Cart</button>
                   </form>
               </div>
           </div>
          
         </div>
         
    </div>      
</section>
   
    


   
    
 
</main>

<?php
 include('footer.php');
?>
