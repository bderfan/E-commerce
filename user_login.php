
<?php
   error_reporting(E_ERROR | E_PARSE);
  require('header.php');
  
  if(isset($_SESSION['authentication'])){
     header('Location:dashboard2/dashboard2.php');
  }
  if(isset($_POST['user_loggedin'])){
    $old = $_POST;
    require('authenticate.php'); 
    $login = user_login();
    if($login['status'] == 'error'){
        $errors = $login['message'];
    }
    
    //print_r($old);
  }
   
    
  
?>
<main>  
  <!============================= Login part ==================================>
  <section id="login" style="background-image: linear-gradient(to bottom right, #D4BA18, #C33E30);">
    <div class="container">
      <div class="class1 mx-auto d-flex align-items-center" style="height: 200px; width: 200px; clip-path: circle(50% at 50% 50%); background: white;">
        <h1 class="text-uppercase text-black text-center">User Login</h1>  
      </div>
      <form class="row" method="post">
        <div class="col-6 mx-auto">
          <div class="form-floating my-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="" name="email" value="<?php echo $old['email']??$_COOKIE['email']?? ''?>">
            <label for="floatingInput">Email address</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['email']??'' ?></p>
            
            
          <div class="form-floating my-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="" name="password" value="<?php echo $old['password']??$_COOKIE['password']??'' ?>" style="position:relative;">
              <i class="fa-solid fa-eye-slash" id="togglePassword" style="position: absolute;top: 50%;right: 10px;transform:translateY(-50%);cursor: pointer;color: #000;" onclick="myFunction()"></i>
            <label for="floatingPassword">Password</label>
          </div>
          <p class="text-black fw-bold" style="font-size:15px;"> <?php echo $errors['password']??'' ?></p>
            
            
          <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember_check" <?php echo $_COOKIE['remember_check']?? ''?>>
              <label class="form-check-label text-white" for="flexCheckDefault">
                Remember me
              </label>
          </div>
            
          <div class="d-flex justify-content-center">
               <button type="submit" class="btn btn-light" style="padding:10px 30px;" name="user_loggedin">Login</button>  
          </div>
            
            <h5 class="text-center mt-5"><a href="registration.php" class="text-light">New user? Please sign up...</a></h5>
        </div>
      </form>
    </div>  
  </section>
</main>        


<?php
 require('footer.php');
?>