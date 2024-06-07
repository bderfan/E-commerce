
     <?php
       error_reporting(E_ERROR | E_PARSE);

       require('sidebar.php'); 
    
       require_once('../class_libs/HOMECLASS.php');
       $home = new HOMECLASS;

       $customer_profiles_index = $home->allcustomers();

     ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background: rgb(252,252,252); background: radial-gradient(circle, rgba(252,252,252,1) 0%, rgba(0,180,255,1) 66%);">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h5 class="fw-bold fs-1" style="color:#fff;">Customers profile</h5>
      </div>
      <div>
          
            <?php
              if(isset($success)){
           ?>
           <div class="alert alert-success fw-bold" role="alert" name="success">
             <?php print $success['success']; ?>
           </div>
           <?php
               header('refresh:3, url=profile.php');
              }
           ?>
         
         <div class="col-12">
             <table class="table table-secondary table-hover">
                 
               <tr>
                 <th>SL</th>
                 <th>Name</th>
                 <th>Age</th>
                 <th>Gender</th>
                 <th>Phone No</th>
                 <th>Email</th>
                 <th>Image</th>     
                 <th>Address</th>
               </tr>
                
              <?php 
                 if(mysqli_num_rows($customer_profiles_index) > 0){
                     $x = 1;
                     while($customer_profile_index = mysqli_fetch_assoc($customer_profiles_index)){
                     
               ?>
                <tr>
                 <td>
                     <?php 
                         $x = 1;
                         echo $x++;
                     ?>   
                 </td> 
                 <td><?php echo $customer_profile_index['name']; ?></td> 
                 <td><?php echo $customer_profile_index['age']; ?></td> 
                 <td><?php echo $customer_profile_index['gender']; ?></td> 
                 <td><?php echo $customer_profile_index['phone_no']; ?></td>
                 <td><?php echo $customer_profile_index['email']; ?></td>
                 <td>
                   <img src="../images/profile_image/<?php echo $customer_profile_index['image']?>" alt="<?php echo $customer_profile_index['name']?>" width="120" height="150">   
                 </td>
                 <td><?php echo $customer_profile_index['address']; ?></td>
                
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
               <button class="btn btn-dark" style="padding:10px 30px;" name="Loggedout">Logout</button>
          </form>
         
        </div>    
        <canvas width="900" height="380"></canvas>
    </main>



<?php
  require('footer.php');      
?>