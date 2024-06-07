
    <?php
        error_reporting(E_ERROR | E_PARSE);

       $old = $_POST;
       require('sidebar.php');
       require_once('../class_libs/CATEGORYCLASS.php');
       $add_category = new CATEGORYCLASS;

       $categories_index = $add_category->index();

       $sub_categories_index = $add_category->sub_category_index();

       $brands_index = $add_category->brand_index();

       require_once('../class_libs/PRODUCTSCLASS.php');
       $add_product = new PRODUCTSCLASS;

     
      if(isset($_POST['add_products'])){
          $products_add = $add_product->Product_add();
          
           if($products_add['status'] == 'error'){
             $errors = $products_add['message'];
         }
          if($products_add['status'] == 'success'){
             $success = $products_add['message'];
         }  
      
      }
     
      
    ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #33632c;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h5 class="text-white fw-bold fs-1">Create Product</h5>
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
                  <div class="form-floating my-3">
                     <select class="form-control" id="category" name="category">
                        <option value="">Select Categories</option>
                     <?php
                        if(mysqli_num_rows($categories_index) > 0){
                          while($category_index = mysqli_fetch_assoc($categories_index)){
                      ?>
                        <option value="<?php echo $category_index['id']; ?>"><?php echo $category_index['name']; ?></option>
                      <?php
                         }
                        }      
                      ?>
                      </select>
                      <label for="category">Categories</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['category']??'' ?></p>
                 
                 
                 <div class="form-floating my-3">
                     <select class="form-control" id="sub_category" name="sub_category">
                        <option value="">Select Sub Categories</option>
                     <?php
                        if(mysqli_num_rows($sub_categories_index) > 0){
                          while($sub_category_index = mysqli_fetch_assoc($sub_categories_index)){
                      ?>
                        <option value="<?php echo $sub_category_index['id']; ?>"><?php echo $sub_category_index['name']; ?></option>
                      <?php
                         }
                        }      
                      ?>
                      </select>
                      <label for="sub_category">Sub Categories</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['sub_category']??'' ?></p>
                 
                 
                 
                 <div class="form-floating my-3">
                     <?php
                        if(mysqli_num_rows($brands_index) > 0){
                     ?>
                     <select class="form-control" id="brand" name="brand">
                        <option value="">Select Brand</option>
                     <?php
                        
                          while($brand_index = mysqli_fetch_assoc($brands_index)){
                      ?>
                        <option value="<?php echo $brand_index['id']; ?>"><?php echo $brand_index['name']; ?></option>
                      <?php
                         }
                         
                      ?>
                      </select>
                      <?php
                        }
                      ?>
                      <label for="brand">Brands</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['brand']??'' ?></p>
               
               
                <div class="form-floating my-3">
                      <input class="form-control" id="name" name="name" value="<?php echo $old['name']?? ''; ?>">
                      <label for="name">Name</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['name']??'' ?></p>
                 
               <div class="form-floating my-3">
                      <input class="form-control" id="sku" name="sku" value="<?php echo $old['sku']?? ''; ?>">
                      <label for="sku">SKU</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['sku']??'' ?></p>
               
                <div class="form-floating my-3">
                   <input type="number" class="form-control" id="price" name="price" value="<?php echo $old['price']?? ''; ?>">
                   <label for="price">Price</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['price']??'' ?></p>
               
                 
               <div class="form-floating my-3">
                      <input type="number" class="form-control" id="strike_price" name="strike_price" value="<?php echo $old['strike_price']?? ''; ?>">
                      <label for="strike_price">Strike Price</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['strike_price']??'' ?></p>
                <div class="form-floating my-3">
                      <input type="file" class="form-control" id="image" name="image">
                      <label for="image">Image</label>
                 </div>
                 <p class="text-white" style="font-size:15px;"> <?php echo $errors['image']??'' ?></p>
               
                  <div class="form-floating my-3">
                      <textarea id="details" name="details"><?php echo $old['details']?? ''; ?></textarea>
                      <label for="details">Details</label>
                  </div>
                  <p class="text-white" style="font-size:15px;"> <?php echo $errors['details']??'' ?></p>
               
                 <div class="d-flex justify-content-center">
                     <button type="submit" class="btn btn-dark me-2" style="padding:10px 30px;" name="add_products">Submit</button> 
                     <button type="reset" class="btn btn-warning" style="padding:10px 30px;">Reset</button> 
                 </div>  
             </form>   
           </div>
        </div>  
      </div>
        
      
          
         
              
        <canvas width="900" height="380"></canvas>
    </main>
  </div>
</div>
    
<script src="../js/ckeditor.js"></script>


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