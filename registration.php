<?php
   error_reporting(E_ERROR | E_PARSE);
  require('header.php');
  if(isset($_SESSION['authenticate'])){
    header('Location:user_login.php');
  }
  if(isset($_POST['Registered'])){
    $old = $_POST;
    require('authenticate.php'); 
    $new_user = New_user();
    if($new_user['status'] == 'error'){
        $errors = $new_user['message'];
    }
    if($new_user['status'] == 'success'){
        $success = $new_user['message'];
    }
  }
?>

<!============================= Registration part ==================================>
  <section id="registration" style="background-image: linear-gradient(to bottom right, #D4BA18, #C33E30)">
    <div class="container">
      <div class="class1 mx-auto d-flex align-items-center" style="height: 370px; width: 370px; clip-path: circle(50% at 50% 50%); background: white;">
        <h1 class="text-uppercase text-black text-center">Registration page</h1>  
      </div>
      <?php
         if(isset($success)){
      ?>
      <div class="alert alert-danger fw-bold" role="alert" name="sucess">
        <?php print $success['sucess']; ?>
      </div>
      <?php
         header('Refresh:3,url=login.php');
         }
      ?>
      <form class="row" method="post">
        <div class="col-6 mx-auto">
          <div class="form-floating my-3">
            <input type="text" class="form-control" id="Name" name="name" value="">
            <label for="Name">Name</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['name']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <input type="text" class="form-control" id="Age" name="age" value="">
            <label for="Age">Age</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['age']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <select class="form-control" id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <label for="gender">Gender</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['gender']??'' ?></p>  
            
          <div class="form-floating my-3">
            <input type="text" class="form-control" id="Phone_no" name="phone_no" value="">
            <label for="Phone_no">Phone No.</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['phone_no']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <input type="email" class="form-control" id="Email" name="email" value="">
            <label for="Email">Email</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['email']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <input type="password" class="form-control" id="floatingPassword" name="password" value="" style="position:relative;">
            <i class="fa-solid fa-eye-slash" id="togglePassword" style="position: absolute;top: 50%;right: 10px;transform:translateY(-50%);cursor: pointer;color: #000;" onclick="myFunction()"></i>  
            <label for="floatingPassword">Password</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['password']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" style="position:relative;">
            <i class="fa-solid fa-eye-slash" id="password" style="position: absolute;top: 50%;right: 10px;transform:translateY(-50%);cursor: pointer;color: #000;" onclick="myFunction2()"></i>  
            <label for="confirm_password">Confirm Password</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['confirm_password']??'' ?></p>
            
           <div class="form-floating my-3">
            <input type="text" class="form-control" id="Address" name="address" value="">
            <label for="Address">Address</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['address']??'' ?></p>
            
            
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-light" style="padding:10px 30px;" name="Registered">Registration</button>
          </div>
            
           <h5 class="text-center mt-5"><a href="user_login.php" class="text-light">Old user? Please log in...</a></h5>
        </div>
      </form>
    </div>  
  </section>

<?php
 require('footer.php');
?>