
    <?php
        
       error_reporting(E_ERROR | E_PARSE);

       require('sidebar.php');
    

       require_once('../class_libs/CATEGORYCLASS.php');
       $sub_category = new CATEGORYCLASS;

       

      if(isset($_POST['edit_sub_category'])){
          $old = $_POST;
          $sub_categories_edit = $sub_category->Sub_Category_edit();
          
           if($sub_categories_edit['status'] == 'error'){
             $errors = $sub_categories_edit['message'];
         }
          if($sub_categories_edit['status'] == 'success'){
             $success = $sub_categories_edit['message'];
         }  
      
      }
     
      $targetdata = $sub_category->targetData($_GET['id']);

    ?>



    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #8e8ffc;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h5 class="text-white fw-bold fs-1">Update <span class="text-black"><?php echo $targetdata['name']; ?></span> Sub Category</h5>
           <!-- Button trigger modal -->
           <div class="d-flex justify-content-end my-3">
                <!-- Button trigger modal -->
                 <a href="sub_category.php" class="btn btn-dark">
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
             header('Refresh:1,url=sub_category.php');
             }
          ?>  
      </div>
      <div class="container">
        <div class="row">
           <div class="col-9 mx-auto">   
             <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_sub_category_id" value="<?php echo $targetdata['id']?? ''; ?>">
                <div class="form-floating my-3">
                      <input class="form-control" id="name" name="name" value="<?php echo $old['name']??$targetdata['name']??''; ?>">
                      <label for="name">Name</label>
                </div>
                <p class="text-white" style="font-size:15px;"> <?php echo $errors['name']??'' ?></p>
                 
               
               
               
                <div class="d-flex justify-content-center">
                   <img src="../images/sub_categories_img/<?php echo $targetdata['image']??''; ?>" style="width:200px;"> 
                </div>
                
                <div class="form-floating my-3">
                      <input type="file" class="form-control" id="image" name="image">
                      <label for="image">Image</label>
                </div>
                 <p class="text-white" style="font-size:15px;"> <?php echo $errors['image']??'' ?></p>
               
              
                
                 <div class="d-flex justify-content-center">
                     <button type="submit" class="btn btn-light me-2" style="padding:10px 30px;" name="edit_sub_category">Update</button> 
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