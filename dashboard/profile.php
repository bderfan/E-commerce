
     <?php
       require('sidebar.php'); 
     ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #000;">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h5 class="fw-bold fs-1" style="color:#fe2424;">User profile</h5>
      </div>
      <div>
          
            <?php
              if(isset($success)){
           ?>
           <div class="alert alert-success" role="alert" name="success">
             <?php print $success['success']; ?>
           </div>
           <?php
              }
           ?>
         
          <div class="row mx-1 mt-3">
            <form class="card text-center" method="post" enctype="multipart/form-data">
              
               <div class="card-body">
                  <!-- ================== image form ===================== -->   
                       <?php
                         if($_SESSION['authenticate']['image']){
                       ?>
                       <img src="../images/profile_image/<?php echo $_SESSION['authenticate']['image'];?>" style="max-height:200px; color: #fe0404c4; font-size: 15px;" alt="Please upload your profile picture ...">
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
                        <td><input type="text" class="form-control" id="Name" name="Name" value="<?php echo $_SESSION['authenticate']['name']; ?>"></td>
                      </tr>
                      <tr>
                        <th scope="row">Age</th>
                          <td><input type="text" class="form-control" id="Age" name="Age" value="<?php     echo $_SESSION['authenticate']['age']; ?>"></td>
                        </tr>
                        <tr>
                          <th scope="row">Gender</th>
                          <td><input type="text" class="form-control" id="Gender" name="Gender" value="<?php echo $_SESSION['authenticate']['gender']; ?>"></td>
                        </tr>
                         <tr>
                          <th scope="row">Phone No.</th>
                          <td><input type="text" class="form-control" id="Phone_no" name="Phone_no" value="<?php echo $_SESSION['authenticate']['phone_no']; ?>"></td>
                        </tr>
                         <tr>
                          <th scope="row">Email</th>
                          <td><input type="email" class="form-control" id="Email" name="email" value="<?php echo $_SESSION['authenticate']['email']; ?>" readonly></td>
                        </tr>
                        <tr>
                          <th scope="row">Address</th>
                          <td><input type="text" class="form-control" id="Address" name="Address" value="<?php echo $_SESSION['authenticate']['address']; ?>"></td>
                        </tr>
                      </tbody>
                    </table>
                    <form method="post">
                      <button class="btn btn-dark" name="save_btn">Save</button> 
                    </form>
                 </div>
              </form>
          </div>
          <form class="d-flex justify-content-center mt-3" method="post">
               <button class="btn btn-warning" style="padding:10px 30px;" name="Loggedout">Logout</button>
          </form>
         
        </div>    
        <canvas width="900" height="380"></canvas>
    </main>



<?php
  require('footer.php');      
?>