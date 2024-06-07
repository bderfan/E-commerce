 <?php
     error_reporting(E_ERROR | E_PARSE);    
 
     require('sidebar.php'); 
     require('../class_libs/CATEGORYCLASS.php');
     

     $old = $_POST;
     
     $category_objects = new CATEGORYCLASS;
      
     
    if(isset($_POST['add_categories'])){
        $add_category = $category_objects->Category_add();
        if($add_category['status'] == 'error'){
           $errors = $add_category['message'];
       }
        if($add_category['status'] == 'success'){
           $success = $add_category['message'];
       }
      
    }

    if (isset($_POST['edit_categories'])){
         echo $_POST['edit_categories'];
         $edit_category = $category_objects->Category_edit();
        if($edit_category['status'] == 'error'){
           $errors = $edit_category['message'];
       }
        if($edit_category['status'] == 'success'){
           $success = $edit_category['message'];
       }
      
    }

    if(isset($_POST['DeletedID'])){
        $dlt_category = $category_objects->Delete_Category();
         if($dlt_category['status'] == 'success'){
            $success = $dlt_category['message'];
        }
    }

    if(isset($_POST['statusID'])){
        $updt_category = $category_objects->Catagory_status();
         if($updt_category['status'] == 'success'){
            $success = $updt_category['message'];
        }
    }

     
     $rows = $category_objects->index();
    

   ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #0f4002;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h5 class="text-white fw-bold fs-1">Categories</h5>
         <div class="d-flex justify-content-end my-3">
               <!-- Button trigger modal -->
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#Category_model">
                   Add Category
                </button>
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
                header('Refresh:1,url=categories.php');
                }
             ?>
         
            
        </div>
        
        
        <div>
            <!-- ADD category model -->
           <div class="modal fade" id="Category_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              
           <div class="modal-dialog" style="--bs-modal-bg: #e22f2f;">
             <form class="modal-content" method="post" enctype="multipart/form-data">
               <div class="modal-header">
                 <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Add Category</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="row">
                     <div class="col-9 mx-auto">
                       <div class="form-floating my-3">
                         <input type="text" class="form-control" id="Name" name="name" value="<?php echo $old['name']?? ''; ?>">
                         <label for="Name">Name</label>
                       </div>
                       <p class="text-white" style="font-size:15px;"> <?php echo $errors['name']??'' ?></p>
                      
                       <div class="form-floating my-3">
                         <input type="file" class="form-control" id="Image" name="image">
                             <label for="Image">Image</label>
                           </div>
                         <p class="text-white" style="font-size:15px;"> <?php echo $errors['image']??'' ?></p>
                        </div>
                      </div>
                 </div>
                 <div class="modal-footer d-flex justify-content-center">
                      <button type="submit" class="btn btn-light" style="padding:10px 30px;" name="add_categories">Save</button> 
                 </div>
               </form>   
             </div>
           </div>
           
        </div>
         <div class="col-12">
             <table class="table table-secondary table-hover">
                 
               <tr>
                 <th>SL</th>
                 <th>Name</th>
                 <th style="width: 250px;">Image</th>
                 <th></th>
               </tr>
                 
                 
               <?php 
                 if(mysqli_num_rows($rows) > 0){
                     
                     while($row = mysqli_fetch_assoc($rows)){
                     
               ?>
                <tr>
                 <td>
                  <?php 
                      $x= $row['id'];
                      echo '<h5>'.$x.'</h5>';
                  ?>
                 </td> 
                    
                    <td><h5><?php echo $row['name']?></h5></td> 
                    
                 <td><img src="../images/categories_img/<?php echo $row['image']?>" alt="<?php echo $row['name']?>" width="150" height="150"></td> 
                    
                 <td class="align-middle">
                   <div class="d-flex justify-content-center">
                        <button class="btn <?php echo ($row['status'] == 1 ? 'btn-success' : 'btn-warning'); ?> btn-sm me-2" onclick="if(!confirm('Do you want to <?php echo ($row['status'] == 1? 'non-active': 'active'); ?> <?php echo $row['name']; ?> category')){
                          return event.preventDefault();                                                  
                        }else{
                            statuscategory(<?php echo $row['id']; ?>);                            
                        }">
                        <?php
                          if($row['status'] == 1){
                        ?>
                             <h6 class="text-dark">Make Category Deactive</h6>
                        <?php
                            }else{
                        ?>
                            <h6 class="text-dark">Make Category Active</h6>
                        <?php
                            } 
                         ?>
                          </button>
                           <button class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#Edit_Category_model_<?php echo $row['id'];?>">
                               <h6 class="text-dark">Edit Category</h6>
                          </button>
                          <button class="btn btn-dark btn-sm" onclick="if(!confirm('Do you want to delete <?php echo $row['name'];?> category?')){
                            return event.preventDefault();                                              
                          }else{
                            deleteCategory(<?php echo $row['id']?>);                                      
                          }">
                              <h6 class="text-light">Delete Category</h6>
                          </button>
                           <!-- Edit categroy model -->
                          <div class="modal fade" id="Edit_Category_model_<?php echo $row['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              
                           <div class="modal-dialog" style="--bs-modal-bg: #6f682d;">
                             <form class="modal-content" method="post" enctype="multipart/form-data">
                               <input type="hidden" name="updateId" value="<?php echo $row['id'];?>">
                               <div class="modal-header">
                                 <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit <span class="text-black fw-bold"><?php echo $row['name'];?></span> Category</h1>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body">
                                   <div class="row">
                                     <div class="col-9 mx-auto">
                                       <div class="form-floating my-3">
                                         <input type="text" class="form-control" id="Name" name="name" value="<?php echo $old['name']?? $row['name']??''; ?>">
                                         <label for="Name" style="color:#000;">Name</label>
                                       </div>
                                       <p class="text-white" style="font-size:15px;"> <?php echo $errors['name']??'' ?></p>
                                       <div class="d-flex justify-content-center">
                                         <img src="../images/categories_img/<?php echo $row['image']?>" alt="<?php echo $row['name']?>" width="80" height="110">  
                                       </div>
                                       <div class="form-floating my-3">
                                         <input type="file" class="form-control" id="Image" name="image">
                                            <label for="Image">Image</label>
                                          </div>
                                        <p class="text-white" style="font-size:15px;"> <?php echo $errors['image']??'' ?></p>
                                       </div>
                                     </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                     <button type="submit" class="btn btn-light" style="padding:10px 30px;" name="edit_categories">Edit Category</button> 
                                </div>
                              </form>   
                            </div>
                          </div>     
                   </div>
                 </td>
               </tr>
              <?php 
                             $x++;
                  }
                 }else{
               ?>
               <tr>
                 <td colspan="4" class="text-center"><h4>No data available</h4></td>
               </tr>
               <?php
                 }
               ?>
             </table>
             
              <form class="d-flex justify-content-center mt-3" method="post">
                  <button class="btn btn-warning" style="padding:10px 30px;" name="Loggedout">Logout</button>
             </form>
             
             <form class="d-none" id="Deletedform" method="post">
               <input type="hidden" id="DeletedID" name="DeletedID">
             </form>
             
              <form class="d-none" id="statusform" method="post">
               <input type="hidden" id="statusID" name="statusID">
             </form>
        </div>
        <canvas width="900" height="380"></canvas>
        
       
       
    </main>
    

    
<?php
  require('footer.php');  
?>

<script>

  function deleteCategory(x){
      document.querySelector('#DeletedID').value = x;
      document.querySelector('#Deletedform').submit();
  }
    
  function statuscategory(x){
      document.querySelector('#statusID').value = x;
      document.querySelector('#statusform').submit();
  }    

</script>