
    <?php
       error_reporting(E_ERROR | E_PARSE);

      require('sidebar.php');

       require_once('../class_libs/CATEGORYCLASS.php');
       $sub_category = new CATEGORYCLASS;

       $sub_categories_index = $sub_category->sub_category_index();

       $old = $_POST;
     
       if(isset($_POST['DeletedID'])){
        $dlt_sub_category = $sub_category->Delete_Sub_Category();
         if($dlt_sub_category['status'] == 'success'){
            $success = $dlt_sub_category['message'];
        }
    }

     if(isset($_POST['statusID'])){
        $updt_sub_category = $sub_category->Sub_Category_status();
         if($updt_sub_category['status'] == 'success'){
            $success = $updt_sub_category['message'];
        }
    }
     
     

    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #fbdd3c;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h5 class="text-black fw-bold fs-1">Sub Categories</h5>
           <!-- Button trigger modal -->
           <div class="d-flex justify-content-end my-3">
                <!-- Button trigger modal -->
                 <a href="create_sub_category.php" class="btn btn-dark">
                     Add Sub Category
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
          
          <div class="col-12">
             <table class="table table-secondary table-hover">
                 
               <tr>
                 <th>SL</th>
                 <th>Name</th>
                 <th>Image</th>
                 <th></th>
               </tr>
                
              <?php 
                 if(mysqli_num_rows($sub_categories_index) > 0){
                     
                     while($sub_category_index = mysqli_fetch_assoc($sub_categories_index)){
                     
               ?>
                <tr>
                 <td>
                     <?php 
                         $x = $sub_category_index['id'];
                         echo '<h5>'.$x.'</h5>';
                     ?>   
                 </td> 
                    <td><h5><?php echo $sub_category_index['name']; ?></h5></td> 
                 <td>
                   <img src="../images/sub_categories_img/<?php echo $sub_category_index['image']?>" alt="<?php echo $product_index['name']?>" width="150" height="150">   
                 </td>
                 <td class="align-middle">
                   <div class="d-flex justify-content-center">
                           <button class="btn <?php echo ($sub_category_index['status'] == 1 ? 'btn-success' : 'btn-warning'); ?> btn-sm me-2" onclick="if(!confirm('Do you want to <?php echo ($sub_category_index['status'] == 1? 'non-active': 'active'); ?> <?php echo $sub_category_index['name']; ?> product')){
                          return event.preventDefault();                                                  
                        }else{
                            statussubcategory(<?php echo $sub_category_index['id']; ?>);                            
                        }">
                        <?php
                          if($sub_category_index['status'] == 1){
                        ?>
                             <h6 class="text-dark">Make Sub Category Deactive</h6>
                        <?php
                            }else{
                        ?>
                            <h6 class="text-dark">Make Sub Category Active</h6>
                        <?php
                            } 
                         ?>
                          </button>
                           <a href="update_sub_category.php?id=<?php echo $sub_category_index['id']; ?>" name="edit_sub_category" class="btn btn-danger btn-sm me-2">
                              <h6 class="text-dark">Edit Sub Category</h6>
                          </a>
                          <button class="btn btn-dark btn-sm" onclick="if(!confirm('Do you want to delete <?php echo $sub_category_index['name'];?> product?')){
                            return event.preventDefault();                                              
                          }else{
                            deleteSubCategory(<?php echo $sub_category_index['id']?>);                                              
                          }">
                              <h6 class="text-light">Delete Sub Category</h6>
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

  function deleteSubCategory(x){
      document.querySelector('#DeletedID').value = x;
      document.querySelector('#Deletedform').submit();
  }

    function statussubcategory(x){
      document.querySelector('#statusID').value = x;
      document.querySelector('#statusform').submit();
  } 
</script>