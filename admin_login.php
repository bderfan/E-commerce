
<?php
   error_reporting(E_ERROR | E_PARSE);
  require('header.php');
  
  if(isset($_SESSION['authenticate'])){
     header('Location:dashboard/dashboard.php');
  }
  if(isset($_POST['admin_loggedin'])){
    $old = $_POST;
    require('authenticate.php'); 
    $login = admin_login();
    if($login['status'] == 'error'){
        $errors = $login['message'];
    }
    
    //print_r($old);
  }
   
    
  
?>
<main>  
  <!============================= Login part ==================================>
  <section id="login" style="background-image: linear-gradient(to right, rgba(255,0,0,0), rgb(76 114 246));">
    <div class="container">
      <div class="class1 mx-auto d-flex align-items-center" style="height: 200px; width: 200px; clip-path: circle(50% at 50% 50%); background: #5e6b7f;">
        <h1 class="text-uppercase text-white text-center">Admin Login</h1>  
      </div>
      <form class="row" method="post">
        <div class="col-6 mx-auto">
          <div class="form-floating my-3">
            <input type="text" class="form-control text-black" id="floatingInput" placeholder="" name="username" value="<?php echo $old['username']??$_COOKIE['username']?? ''?>">
            <label for="floatingInput">User Name</label>
          </div>
          <p class="text-danger fw-bold" style="font-size:15px;"> <?php echo $errors['username']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <input type="password" class="form-control text-black" id="floatingPassword" placeholder="" name="password" value="<?php echo $old['password']??$_COOKIE['password']??'' ?>" style="position:relative;">
              <i class="fa-solid fa-eye-slash" id="togglePassword" style="position: absolute;top: 50%;right: 10px;transform:translateY(-50%);cursor: pointer;color: #000;" onclick="myFunction()"></i>
            <label for="floatingPassword">Password</label>
          </div>
          <p class="text-danger fw-bold" style="font-size:15px;"> <?php echo $errors['password']??'' ?></p>
            
            
          <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember_check" <?php echo $_COOKIE['remember_check']?? ''?>>
              <label class="form-check-label text-dark" for="flexCheckDefault">
                Remember me
              </label>
          </div>
            
          <div class="d-flex justify-content-center">
               <button type="submit" class="btn btn-dark" style="padding:10px 30px;" name="admin_loggedin">Login</button>  
          </div>
            
           <h5 class="text-center mt-5"><a href="admin_registration.php" class="text-dark">New admin? Please sign up...</a></h5>
        </div>
      </form>
    </div>  
  </section>
</main>        


<?php
 require('footer.php');
?>