
    <?php
      require('sidebar.php');

       require_once('../class_libs/PRODUCTSCLASS.php');
       $add_product = new PRODUCTSCLASS;

       $products_index = $add_product->index();

       $old = $_POST;
     
       $edit_product = new PRODUCTSCLASS;
     
      if(isset($_POST['edit_product'])){
          $products_edit = $edit_product->Product_add();
          
           if($products_edit['status'] == 'error'){
             $errors = $products_edit['message'];
         }
          if($products_edit['status'] == 'success'){
             $success = $products_edit['message'];
         }  
      
      }

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
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" width="20" height="20" class="d-flex align-items-center">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                     </svg>
                 </a>
           </div>
      </div>
        
       <div>
          <?php
            if(isset($success)){
          ?>
          <div class="alert alert-success" role="alert" name="success">
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
                         echo $x++;
                     ?>   
                 </td> 
                 <td><?php echo $product_index['name']; ?></td> 
                 <td><?php echo $product_index['sku']; ?></td> 
                 <td><?php echo $product_index['price']; ?></td> 
                 <td><?php echo $product_index['strike_price']; ?></td>
                 <td>
                   <img src="../images/products_img/<?php echo $product_index['image']?>" alt="<?php echo $product_index['name']?>" width="120" height="150">   
                 </td>
                 <td><?php echo $product_index['details']; ?></td>
                 <td class="align-middle">
                   <div class="d-flex justify-content-center">
                           <button class="btn <?php echo ($product_index['status'] == 1 ? 'btn-success' : 'btn-secondary'); ?> btn-sm me-2" onclick="if(!confirm('Do you want to <?php echo ($product_index['status'] == 1? 'non-active': 'active'); ?> <?php echo $product_index['name']; ?> product')){
                          return event.preventDefault();                                                  
                        }else{
                            statusproduct(<?php echo $product_index['id']; ?>);                            
                        }">
                        <?php
                          if($product_index['status'] == 1){
                        ?>
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="10" height="15" class="d-flex align-items-center">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                             </svg>
                        <?php
                            }else{
                        ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="10" height="15" class="d-flex align-items-center">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        <?php
                            } 
                         ?>
                          </button>
                           <a href="update_products.php?sku=<?php echo $product_index['sku']; ?>" name="edit_product" class="btn btn-danger btn-sm me-2">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="10" height="15" class="d-flex align-items-center">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                           </svg>
                          </a>
                          <button class="btn btn-dark btn-sm" onclick="if(!confirm('Do you want to delete <?php echo $product_index['name'];?> product?')){
                            return event.preventDefault();                                              
                          }else{
                            deleteProduct(<?php echo $product_index['id']?>);                                              
                          }">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="10" height="15" class="d-flex align-items-center">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                              </svg>
                          </button>
                   </div>
                 </td>
               </tr>
               <?php 
                    }
                 }else{
               ?>
               <tr>
                 <td colspan="7" class="text-center">No data available</td>
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