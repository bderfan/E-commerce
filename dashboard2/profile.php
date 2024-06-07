<?php
   error_reporting(E_ERROR | E_PARSE);
   require('sidebar.php'); 
   ?>


<div class="content-wrapper">
   <div class="container-full">
      <?php
         if(isset($success)){
      ?>
      <div class="alert alert-info" role="alert" name="success">
        <?php print $success['success']; ?>
      </div>
      <?php
          header('Refresh:1,url=profile.php');
         }
      ?>
      <!-- Main content -->
      <section class="content">
         <div class="row">
            <div class="col-9 mx-auto">
               <form class="card text-center" method="post" enctype="multipart/form-data">
                  <div class="card-body" style="background-color: #BBDEFB;">
                     <!-- ================== image form ===================== -->   
                     <?php
                        if($_SESSION['authentication']['image']){
                        ?>
                     <img src="../images/profile_image/<?php echo $_SESSION['authentication']['image'];?>" style="max-height:200px; color: #fe0404c4; font-size: 15px;" alt="Please upload your profile picture ...">
                     <?php
                        }else{
                        ?>         
                     <img src="../images/330164726_159031780281707_4994481048478868290_n.jpg" style="max-height:200px;">
                     <?php
                        }
                        ?>
                     <div class="input-group my-3">
                        <input type="file" class="form-control" id="inputGroupFile02" name="img_upload">
                        <label class="input-group-text" for="inputGroupFile02">Upload Image</label>
                     </div>
                     <p class="text-warning" style="font-size:15px;"><?php echo $errors['img_upload']??'' ?></p>
                     <!-- ============================= Input form =============================== -->    
                     <table class="table table-warning mt-5">
                        <tbody>
                           <tr>
                              <th scope="row">Name</th>
                              <td><input type="text" class="form-control" id="Name" name="Name" value="<?php echo $_SESSION['authentication']['name']; ?>"></td>
                           </tr>
                           <tr>
                              <th scope="row">Age</th>
                              <td><input type="text" class="form-control" id="Age" name="Age" value="<?php     echo $_SESSION['authentication']['age']; ?>"></td>
                           </tr>
                           <tr>
                              <th scope="row">Gender</th>
                              <td><input type="text" class="form-control" id="Gender" name="Gender" value="<?php echo $_SESSION['authentication']['gender']; ?>"></td>
                           </tr>
                           <tr>
                              <th scope="row">Phone No.</th>
                              <td><input type="text" class="form-control" id="Phone_no" name="Phone_no" value="<?php echo $_SESSION['authentication']['phone_no']; ?>"></td>
                           </tr>
                           <tr>
                              <th scope="row">Email</th>
                              <td><input type="email" class="form-control" id="Email" name="email" value="<?php echo $_SESSION['authentication']['email']; ?>" readonly></td>
                           </tr>
                           <tr>
                              <th scope="row">Address</th>
                              <td><input type="text" class="form-control" id="Address" name="Address" value="<?php echo $_SESSION['authentication']['address']; ?>"></td>
                           </tr>
                        </tbody>
                     </table>
               <form method="post">
               <button class="btn btn-dark" name="save_btn">Save</button> 
               </form>
               </div>
               </form>
            </div>
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
