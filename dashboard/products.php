
    <?php
       error_reporting(E_ERROR | E_PARSE);

      require('sidebar.php');

       require_once('../class_libs/PRODUCTSCLASS.php');
       $add_product = new PRODUCTSCLASS;

       $products_index = $add_product->index();

       $old = $_POST;
     
       $edit_product = new PRODUCTSCLASS;
     
     

      if(isset($_POST['DeletedID'])){
        $dlt_product = $edit_product->Delete_Product();
         if($dlt_product['status'] == 'success'){
            $success = $dlt_product['message'];
        }
    }

     if(isset($_POST['statusID'])){
        $updt_product = $edit_product->Product_status();
         if($updt_product['status'] == 'success'){
            $success = $updt_product['message'];
        }
    }

    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #fbdd3c;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h5 class="text-black fw-bold fs-1">Products</h5>
           <!-- Button trigger modal -->
           <div class="d-flex justify-content-end my-3">
                <!-- Button trigger modal -->
                 <a href="create_products.php" class="btn btn-dark">
                     Add Product
                 </a>
           </div>
      </div>
        
       <div>
          <?php
            if(isset($success)){
          ?>
          <div class="alert alert-success fw-bold" role="alert" name="success">
            <?php print $success['success']; ?>
          </div>
          <?php
             header('Refresh:1,url=products.php');
             }
          ?>  
      </div>
          
          <div class="col-12">
             <table class="table table-secondary table-hover">
                 
               <tr>
                 <th>SL</th>
                 <th>Name</th>
                 <th>SKU</th>
                 <th>Price</th>
                 <th>Strike_price</th>
                 <th>Image</th>
                 <th>Details</th>     
                 <th></th>
               </tr>
                
              <?php 
                 if(mysqli_num_rows($products_index) > 0){
                     $x = 1;
                     while($product_index = mysqli_fetch_assoc($products_index)){
                     
               ?>
                <tr>
                 <td>
                     <?php 
                         $x = $product_index['id'];
                         echo '<h5>'.$x++.'</h5>';
                     ?>   
                 </td> 
                    <td><h5><?php echo $product_index['name']; ?></h5></td> 
                    <td><h5><?php echo $product_index['sku']; ?></h5></td> 
                    <td><h5><?php echo $product_index['price']; ?></h5></td> 
                    <td><h5><?php echo $product_index['strike_price']; ?></h5></td>
                 <td>
                   <img src="../images/products_img/<?php echo $product_index['image']?>" alt="<?php echo $product_index['name']?>" width="120" height="120">   
                 </td>
                 <td><h6><?php echo $product_index['details']; ?></h6></td>
                 <td class="align-middle">
                   <div class="d-flex justify-content-center">
                           <button class="btn <?php echo ($product_index['status'] == 1 ? 'btn-info' : 'btn-warning'); ?> btn-sm me-2" onclick="if(!confirm('Do you want to <?php echo ($product_index['status'] == 1? 'non-active': 'active'); ?> <?php echo $product_index['name']; ?> product')){
                          return event.preventDefault();                                                  
                        }else{
                            statusproduct(<?php echo $product_index['id']; ?>);                            
                        }">
                        <?php
                          if($product_index['status'] == 1){
                        ?>
                             <h6 class="text-dark">Make Product Deactive</h6>
                        <?php
                            }else{
                        ?>
                            <h6 class="text-dark">Make Product Active</h6>
                        <?php
                            } 
                         ?>
                          </button>
                           <a href="update_products.php?id=<?php echo $product_index['id']; ?>" name="edit_product" class="btn btn-danger btn-sm me-2">
                              <h6 class="text-dark">Edit Product</h6>
                          </a>
                          <button class="btn btn-dark btn-sm" onclick="if(!confirm('Do you want to delete <?php echo $product_index['name'];?> product?')){
                            return event.preventDefault();                                              
                          }else{
                            deleteProduct(<?php echo $product_index['id']?>);                                              
                          }">
                              <h6 class="text-light">Delete Product</h6>
                          </button>
                   </div>
                 </td>
               </tr>
               <?php 
                    }
                 }else{
               ?>
               <tr>
                 <td colspan="7" class="text-center"><h4>No data available</h4></td>
               </tr>
               <?php
                 }
               ?>
             </table>
             <form class="d-none" id="Deletedform" method="post">
               <input type="hidden" id="DeletedID" name="DeletedID">
             </form>
              
              <form class="d-none" id="statusform" method="post">
               <input type="hidden" id="statusID" name="statusID">
             </form>
        </div>
              
         <form class="d-flex justify-content-center mt-3" method="post">
              <button class="btn btn-danger" style="padding:10px 30px;" name="Loggedout">Logout</button>
         </form>
        <canvas width="900" height="380"></canvas>

<?php
  require('footer.php');  
?>

<script>

  function deleteProduct(x){
      document.querySelector('#DeletedID').value = x;
      document.querySelector('#Deletedform').submit();
  }

    function statusproduct(x){
      document.querySelector('#statusID').value = x;
      document.querySelector('#statusform').submit();
  } 
</script>