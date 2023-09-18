<?php

require_once('DATABASECLASS.php');

class CATEGORYCLASS extends DATABASECLASS{

    public function index(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_categories_query = "SELECT * FROM categories";
    
           $result = $connection->query($view_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    
    
    public function Category_add(){
     
      $name = $_POST['name'];
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
        
     
       $errors = [];
     
        if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters ...'; 
          }
     
     
              $get_image_extension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION));
              //echo $get_image_extension;
              $new_image = time().$name.'.'.$get_image_extension;
     
              $target_extension = ['jpg', 'jpeg', 'png', 'gif'];
    
              if(!in_array($get_image_extension, $target_extension)){
                  $errors['image'] = 'File format should be jpg/jpeg/png/gif';
              }
              if($img_size > 1048576){
                  $errors['image'] = 'File size can not be larger than 1Mb';
              }
     
               
               if(count($errors) > 0){
                 $errors['modal'] = 'Category_model';
                    return[
                       'status' => 'error',
                       'message' => $errors
                   ]; 
                }   
                  
              $dir_path = '../images/categories_img';
    
              if(!file_exists($dir_path)){
                  mkdir($dir_path);
              }
    
     
           $success = [];
           $connection = $this->connection;
           //print_r($Connection);
    
           $slug = str_replace('', '-',strtolower($name));
        
           $insert_categories_query = "INSERT INTO categories(name, slug,  image)VALUES('$name','$slug','$new_image')";
        
           $result = $connection->query($insert_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }
               
           move_uploaded_file($tmp_name, $dir_path.'/'.$new_image);
             
           $success['success'] = 'Data saved successfully!';
     
           return[
               'status' => 'success',
               'message' => $success
           ];
     
           
 }
    
    public function Category_edit(){
        $Update_category_id = $_POST['updateId'];
		$name = $_POST['name'];
		$real_name = $_FILES['image']['name'];
		$tmp_name = $_FILES['image']['tmp_name'];
		$image_size = $_FILES['image']['size'];
		
		$errors = [];
		
		if(strlen($name) < 3 || strlen($name) > 100){
			$errors['name'] = '3-100 Characters Required';
		}
		
		$connection = $this->connection;
		$sql_view = "SELECT * FROM categories where id = '$Update_category_id'";
		
		$result = $connection->query($sql_view);
		
		if($connection->error){
			die('Table Error: '.$connection->error);
		}
		
		$getEditData = $result->fetch_assoc();
		$path = $getEditData['image'];
        
		if($tmp_name){
			$getImageExtension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION ));
			
			$new_img = time().$name.'.'.$getImageExtension;
			
			$targeted_extension = ['jpg', 'jpeg', 'png', 'gif'];
			if(!in_array($getImageExtension, $targeted_extension)){
				$errors['image'] = 'Only jpg/jpeg/png/gif file required';
			}
			
			if($image_size > 1024000){
				$errors['image'] = 'Max Size 1mb';
			}
			
			$dir = 'images/categories_img';
			if(!file_exists('../'.$dir)){
				mkdir('../'.$dir);
			}
			
			if($path && file_exists('../'.$path)){
				unlink('../'.$path);
			}
			
			$path = $dir.'/'.$new_img;
		
			move_uploaded_file($tmp_name, '../'.$path);
			
			
		}
		
		
		if(count($errors) > 0){
			$errors['modal'] = 'addCategoryModal';
			return [
				'status' => 'error',
				'message' => $errors
			];
		}
		
		
		
		
		$slug = str_replace(' ', '-', strtolower($name));
		
		$name = $connection->real_escape_string($name); 
		
		$sql_update = "UPDATE categories SET name = '$name', slug = '$slug', image = '$path' WHERE id = '$Update_category_id'";
		
		$result = $connection->query($sql_update);
		
		if($connection->error){
			die('Table Error: '.$connection->error);
		}
        
        $success['success'] = 'Categrory updated successfully!';
		
		return [
				'status' => 'success',
				'message' => $success
		];
    }
    
    
    
    public function Delete_Category(){
           $Category_id = $_POST['DeletedID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_category_query = "SELECT * FROM categories WHERE id='$Category_id'";
    
           $result = $connection->query($view_category_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc;
               $Delete_category = "DELETE FROM categories WHERE id='$Category_id'";
    
               $result = $connection->query($Delete_category);
    
               if($connection->error){
                   die('Table Error:'.$connection->error);
               }   
               
               if(file_exists('../images/categories_img/'.$getData['image'])){
                   unlink('../images/categories_img/'.$getData['image']);
               }
               
               $success['success'] = 'Deleted successfully!';
     
               return[
                   'status' => 'success',
                   'message' => $success
               ];
     
           }
     
           
 }

    
     public function Catagory_status(){
           $status_id = $_POST['statusID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_category_query = "SELECT * FROM categories WHERE id='$status_id'";
    
           $result = $connection->query($view_category_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           $getdata = $result->fetch_assoc();
           $status = $getdata['status'] == 0? 1: 0;       
        
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc();
               $update_category = "UPDATE categories SET status ='$status' WHERE id='$status_id'";
    
               $result = $connection->query($update_category);
    
               if($connection->error){
                   die('Table Error:'.$connection->error);
               }   
               
               
               $success['success'] = 'Updated successfully!';
     
               return[
                   'status' => 'success',
                   'message' => $success
               ];
     
           }
     
           
 }
}

?>