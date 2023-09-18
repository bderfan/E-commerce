<!DOCTYPE html>
<html>
<head>
  <title>Authentication page</title>
</head>
<body>


     
<?php
#Post method
  require('database.php');
     


     
function login(){
          
          $email = $_POST['email'];
          $password = $_POST['password'];
          $remember = isset($_POST['remember_check'])? true:false;
     
          $errors = [];


           $connection = db_connection();
           $sql_view = "SELECT * FROM users WHERE email='$email' and password='$password'";
    
           $result = mysqli_query($connection, $sql_view);
    
          
           if(mysqli_error($connection)){
               die('Table error:'.mysqli_error($connection));
           }
    
           
    
           if(strlen($email) == 0 || strlen($password) == 0){
               $errors['email'] = 'Empty Email';
               $errors['password'] = 'Empty Password';
           }else{
               if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                 $errors['email'] = 'Invalid Email';
               }else{
                   if($result->num_rows == 0){
                       $errors['email'] = "Email/password doesn't match";
                   }  
               }
           }
 
           if(count($errors) > 0){
                return[
                   'status' => 'error',
                   'message' => $errors
               ];
           }       
    
           $_SESSION['authenticate']= mysqli_fetch_assoc($result);
           //print_r($result);
           //return true;
           
          
           if($remember){
                setcookie('email',$email, time()+(60), '/');
                setcookie('password',$password, time()+(60), '/');
            }else{
                setcookie('email','', 0, '/');
                setcookie('password','', 0, '/');
           }
                
           header('Location:dashboard/dashboard.php');    
           
           
              
}
   
   
     
function New_user(){
          $name = $_POST['name'];
          $age = $_POST['age'];
          $gender = $_POST['gender'];
          $phone_no = $_POST['phone_no'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $confirm_password = $_POST['confirm_password'];
          $address = $_POST['address'];
     
          $errors = [];

          if(strlen($name) < 5 || str_word_count($name) < 2){
              $errors['name'] = 'Minimum 5 characters and 2 words ...'; 
          }
          if(strlen($age) <2){
              $errors['age'] = 'Age digit can not be less than two ...';
          }
          if(strlen($phone_no) < 11){
              $errors['phone_no'] = 'Your digit of input phone number should reach 11 ...';
          }
          if(strlen($email) == 0){
              $errors['email'] = 'Please input email address ...';
          }
          if(strlen($password) == 0){
              $errors['password'] = 'Please insert password ...';
          }
          if(strlen($confirm_password) == 0){
              $errors['confirm_password'] = 'This field can not be empty ...';
          }
          if($password != $confirm_password){
              $errors['confirm_password'] = 'Password is not matched ...';
          }
          if(strlen($address) > 150){
              $errors['address'] = 'Can not more than 150 characters';
          }
          
        
           
           if(count($errors) > 0){
                return[
                   'status' => 'error',
                   'message' => $errors
               ];
           }
    
           $success = [];
           $Connection = db_connection();
           //print_r($Connection);
    
           $insert_query = "INSERT INTO users(name, age, gender, phone_no, email, password, address) VALUES('$name','$age','$gender','$phone_no','$email','$password','$address')";
    
           $result = mysqli_query($Connection,$insert_query);
    
           if(mysqli_error($Connection)){
               die('Table Error:'.mysqli_error($Connection));
           }else{
               $success['sucess'] = 'Data Saved Successfully!';
           }
            
           return[
               'status' => 'success',
               'message' => $success
           ];
    
          
           
              
}

     
function update_user(){
          $name = $_POST['Name'];
          $age = $_POST['Age'];
          $gender = $_POST['Gender'];
          $phone_no = $_POST['Phone_no'];
          $address = $_POST['Address'];
          $email = $_SESSION['authenticate']['email'];
          
    
         echo '<pre>';
         print_r($_FILES);
         echo'</pre>';
    
          $errors = [];
    
    
          $tmp_name = $_FILES['img_upload']['tmp_name'];
          $real_name = $_FILES['img_upload']['name'];
          $img_size = $_FILES['img_upload']['size'];
          
          
         
          if($tmp_name){
              $get_image_extension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION));
              //echo $get_image_extension;

              $target_extension = ['jpg', 'jpeg', 'png', 'gif'];
    
              if(!in_array($get_image_extension, $target_extension)){
                  $errors['img_upload'] = 'File format should be jpg/jpeg/png/gif';
              }
              if($img_size > 1048576){
                  $errors['img_upload'] = 'File size can not be larger than 1Mb';
              }
          }
          
          
          if(count($errors) > 0){
                return[
                   'status' => 'error',
                   'message' => $errors
               ];
           }  
    
          
              
           $success = [];
           $connection = db_connection();

           $user_view = "SELECT * FROM users WHERE email='$email'";  
           
           $result = mysqli_query($connection, $user_view);
         
           if(mysqli_error($connection)){
               die('Table Error:'.mysqli_error($connection));
           }
    
           $userdata = mysqli_fetch_assoc($result);
           $path = $userdata['image'];
    
          if($tmp_name){
              $dir_path = '../images/profile_image';
    
              if(!file_exists($dir_path)){
                  mkdir($dir_path);
              }
              $new_image = time().$_SESSION['authenticate']['name'].'.'.$get_image_extension;
              
              if($path){
                  if(file_exists($dir_path.'/'.$path)){
                      unlink($dir_path.'/'.$path);
                  }
              }
              move_uploaded_file($tmp_name, $dir_path.'/'.$new_image);
              
              $path = $new_image;
          }
          
            
           //print_r($Connection);
    
         
    
           $update_user = "UPDATE users SET name='$name', age='$age', gender='$gender', phone_no='$phone_no', image='$path', address='$address' WHERE email='$email'";
    
    
           $result = mysqli_query($connection, $update_user);
         
            if(mysqli_error($connection)){
               die('Table Error:'.mysqli_error($connection));
           } 
           
           
           $user_view = "SELECT * FROM users WHERE email='$email'";  
           
           $result = mysqli_query($connection, $user_view);
         
           if(mysqli_error($connection)){
               die('Table Error:'.mysqli_error($connection));
           }
    
           $_SESSION['authenticate'] = mysqli_fetch_assoc($result);

    
          $success['success'] = 'Data updated successfully!';
                
            
           
            return[
               'status' => 'success',
               'message' => $success
           ];
    
            
              
           
}
    


    

     
?>
     
     
 </div>
</body>
</html>