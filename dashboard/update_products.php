
    <?php
        
       error_reporting(E_ERROR | E_PARSE);

       require('sidebar.php');
    

       require_once('../class_libs/PRODUCTSCLASS.php');
       $add_product = new PRODUCTSCLASS;

       

      if(isset($_POST['edit_products'])){
          $old = $_POST;
          $products_edit = $add_product->Product_edit();
          
           if($products_edit['status'] == 'error'){
             $errors = $products_edit['message'];
         }
          if($products_edit['status'] == 'success'){
             $success = $products_edit['message'];
         }  
      
      }
     
      $targetdata = $add_product->targetData($_GET['id']);

    ?>



    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #8e8ffc;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h5 class="text-white fw-bold fs-1">Update <span class="text-black"><?php echo $targetdata['name']; ?></span> Product</h5>
           <!-- Button trigger modal -->
           <div class="d-flex justify-content-end my-3">
                <!-- Button trigger modal -->
                 <a href="products.php" class="btn btn-dark">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                     </svg>
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
      <div class="container">
        <div class="row">
           <div class="col-9 mx-auto">   
             <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_product_id" value="<?php echo $targetdata['id']?? ''; ?>">
                <div class="form-floating my-3">
                      <input class="form-control" id="name" name="name" value="<?php echo $old['name']??$targetdata['name']??''; ?>">
                      <label for="name">Name</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['name']??'' ?></p>
                 
                <div class="form-floating my-3">
                      <input class="form-control" id="sku" name="sku" value="<?php echo $old['sku']??$targetdata['sku']??''; ?>">
                      <label for="sku">SKU</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['sku']??'' ?></p>
               
                <div class="form-floating my-3">
                   <input type="number" class="form-control" id="price" name="price" value="<?php echo $old['price']??$targetdata['price']??''; ?>">
                   <label for="price">Price</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['price']??'' ?></p>
                      
               <div class="form-floating my-3">
                      <input type="number" class="form-control" id="strike_price" name="strike_price" value="<?php echo $old['strike_price']??$targetdata['strike_price']??''; ?>">
                      <label for="strike_price">Strike Price</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['strike_price']??'' ?></p>
               
                <div class="d-flex justify-content-center">
                   <img src="../images/products_img/<?php echo $targetdata['image']??''; ?>" style="width:200px;"> 
                </div>
                
                <div class="form-floating my-3">
                      <input type="file" class="form-control" id="image" name="image">
                      <label for="image">Image</label>
                </div>
                 <p class="text-white" style="font-size:15px;"> <?php echo $errors['image']??'' ?></p>
               
                <div class="form-floating my-3">
                      <textarea id="details" name="details"><?php echo $old['details']??$targetdata['details']??''; ?></textarea>
                      <label for="details">Details</label>
                </div>
                  <p class="text-white" style="font-size:15px;"> <?php echo $errors['details']??'' ?></p>
                
                 <div class="d-flex justify-content-center">
                     <button type="submit" class="btn btn-light me-2" style="padding:10px 30px;" name="edit_products">Update</button> 
                 </div>  
             </form>   
           </div>
        </div>  
      </div>
        
      
          
         
              
        <canvas width="900" height="380"></canvas>
    </main>
  </div>
</div>
    
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


<script>
    ClassicEditor
        .create( document.querySelector( '#details' ) )
        .then( editor => {
             editor.ui.view.editable.element.style.height = '500px';
         } )
        .catch( error => {
            console.error( error );
        } );
</script>
<?php
  require('footer.php');  
?>