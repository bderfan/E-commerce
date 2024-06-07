<?php
 error_reporting(E_ERROR | E_PARSE);
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
    
    
    
     public function sub_categories_index(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_sub_categories_query = "SELECT * FROM sub_categories WHERE id in (5,7,8)";
    
           $result = $connection->query($view_sub_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    
    
    public function brand_index(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_brands_query = "SELECT * FROM brands";
    
           $result = $connection->query($view_brands_query);
    
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
     
        if(strlen($name) == 0){
              $errors['name'] = 'Please input category name'; 
          }
        if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters'; 
          }
     
     
        if($tmp_name){
                  
            $get_image_extension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION));
            //echo $get_image_extension;
            
            function RemoveSpecialChar($str) {
 
               // Using str_replace() function 
               // to replace the word 
               $res = str_replace( array( '\'', '"',
               ',' , ';', '<', '>' ), '', $str);
 
               // Returning the result 
               return $res;
            }
          
           $NAME = RemoveSpecialChar($name);
    
           $slug = str_replace(' ', '-',strtolower($NAME));
            
            $new_image = time().$NAME.'.'.$get_image_extension;
     
            $target_extension = ['jpg', 'jpeg', 'png', 'gif'];
    
            if(!$tmp_name){
                $errors['image'] = 'Please upload image';
            }else{
                if(!in_array($get_image_extension, $target_extension)){
                    $errors['image'] = 'File format should be jpg/jpeg/png/gif';
                }
                if($img_size > 1048576){
                    $errors['image'] = 'File size can not be larger than 1Mb';
                }
            }
            
             $dir_path = '../images/categories_img';
    
              if(!file_exists($dir_path)){
                  mkdir($dir_path);
              }
            
        }
     
               
               if(count($errors) > 0){
                 $errors['modal'] = 'Category_model';
                    return[
                       'status' => 'error',
                       'message' => $errors
                   ]; 
                }   
                  
             
          
     
           $success = [];
           $connection = $this->connection;
           //print_r($Connection);
           
           
        
          
        
           $insert_categories_query = "INSERT INTO categories(name, slug, image)VALUES('$NAME','$slug','$new_image')";
        
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
		
		$sql_update = "UPDATE categories SET name = '$name', slug = '$slug', image = '$new_img' WHERE id = '$Update_category_id'";
		
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
    
    
    public function sub_category_index(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_sub_categories_query = "SELECT * FROM sub_categories";
    
           $result = $connection->query($view_sub_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    
    

    
    
    public function Delete_Sub_Category(){
           $Sub_Category_id = $_POST['DeletedID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_sub_category_query = "SELECT * FROM sub_categories WHERE id='$Sub_Category_id'";
    
           $result = $connection->query($view_sub_category_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc;
               $Delete_sub_category = "DELETE FROM sub_categories WHERE id='$Sub_Category_id'";
    
               $result = $connection->query($Delete_sub_category);
    
               if($connection->error){
                   die('Table Error:'.$connection->error);
               }   
               
               if(file_exists('../images/sub_categories_img/'.$getData['image'])){
                   unlink('../images/sub_categories_img/'.$getData['image']);
               }
               
               $success['success'] = 'Deleted successfully!';
     
               return[
                   'status' => 'success',
                   'message' => $success
               ];
     
           }
     
           
 }

    
     public function Sub_Category_status(){
           $status_id = $_POST['statusID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_sub_category_query = "SELECT * FROM sub_categories WHERE id='$status_id'";
    
           $result = $connection->query($view_sub_category_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           $getdata = $result->fetch_assoc();
           $status = $getdata['status'] == 0? 1: 0;       
        
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc();
               $update_sub_category = "UPDATE sub_categories SET status ='$status' WHERE id='$status_id'";
    
               $result = $connection->query($update_sub_category);
    
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
    
    
    
      public function Sub_categories_add(){
     
      $category = $_POST['category'];
      $name = $_POST['name'];
      

      
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
      
     
     
       $errors = [];
     
        if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters ...'; 
          }
        
        $connection = $this->connection;
       
        
      
               
        
        $sql_view = "SELECT * FROM categories";
		
		$result = $connection->query($sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
        }
        
               
        $checkCategoryid = [];
        if($result->num_rows == 0){
           $errors['category'] == 'Invalid categories';
        }else{
            while($Category = $result->fetch_assoc()){
                $checkCategoryid[] = $Category['id'];
            }
              /**
            print_r($checkCategoryid);
            return true;
           **/
            if(!in_array($category, $checkCategoryid)){
                $errors['category'] = 'Category does not exists';
            }
        }
        
         $get_image_extension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION));
        //echo $get_image_extension;
       
        function RemoveSpecialChar($str) {
 
               // Using str_replace() function 
               // to replace the word 
               $res = str_replace( array( '\'', '"',
               ',' , ';', '<', '>' ), '', $str);
 
               // Returning the result 
               return $res;
            }
          
        $NAME = RemoveSpecialChar($name);
        
         $slug = str_replace(' ', '-',strtolower($NAME));
        
        $new_image = time().$NAME.'.'.$get_image_extension;
        $target_extension = ['jpg', 'jpeg', 'png', 'gif'];
    
        if(!in_array($get_image_extension, $target_extension)){
            $errors['image'] = 'File format should be jpg/jpeg/png/gif';
        }
        if($img_size > 1048576){
            $errors['image'] = 'File size can not be larger than 1Mb';
        }
        
        $dir_path = '../images/sub_categories_img';
    
        if(!file_exists($dir_path)){
            mkdir($dir_path);
        }
        
        move_uploaded_file($tmp_name, $dir_path.'/'.$new_image); 
          
          
           if(count($errors) > 0){
             return[
                'status' => 'error',
                'message' => $errors
             ]; 
          }
          
           $success = []; 
    
        
          
           $insert_sub_categories_query = "INSERT INTO sub_categories(name, slug, category_id, image)VALUES('$NAME','$slug','$category','$new_image')";
        
           $result = $connection->query($insert_sub_categories_query);
           
           if($connection->error){
               die('Table Error:'.$connection->error);
           }
           print_r($result);
          
          $success['success'] = 'Sub Category created successfully!';
               
          return[
           'status' => 'success',
           'message' => $success
          ]; 
           
            
            
          
     
           
 }
    
    
    
    public function Brands_add(){
     
      $sub_category = $_POST['sub_category'];
      $name = $_POST['name'];
      

      
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
      
     
     
       $errors = [];
     
        if(strlen($name) < 2){
              $errors['name'] = 'Minimum 2 characters ...'; 
          }
        
        $connection = $this->connection;
       
        
      
               
        
        $sql_view = "SELECT * FROM sub_categories WHERE id in (5,7,8)";
		
		$result = $connection->query($sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
        }
        
               
        $checkSubCategoryid = [];
        if($result->num_rows == 0){
           $errors['sub_category'] == 'Invalid sub categories';
        }else{
            while($SubCategory = $result->fetch_assoc()){
                $checkSubCategoryid[] = $SubCategory['id'];
            }
              /**
            print_r($checkCategoryid);
            return true;
           **/
            if(!in_array($sub_category, $checkSubCategoryid)){
                $errors['sub_category'] = 'Sub category does not exists';
            }
        }
        
         $get_image_extension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION));
        //echo $get_image_extension;
       
        function RemoveSpecialChar($str) {
 
               // Using str_replace() function 
               // to replace the word 
               $res = str_replace( array( '\'', '"',
               ',' , ';', '<', '>' ), '', $str);
 
               // Returning the result 
               return $res;
            }
          
        $NAME = RemoveSpecialChar($name);
        
         $slug = str_replace(' ', '-',strtolower($NAME));
        
        $new_image = time().$NAME.'.'.$get_image_extension;
        $target_extension = ['jpg', 'jpeg', 'png', 'gif'];
    
        if(!in_array($get_image_extension, $target_extension)){
            $errors['image'] = 'File format should be jpg/jpeg/png/gif';
        }
        if($img_size > 1048576){
            $errors['image'] = 'File size can not be larger than 1Mb';
        }
        
        $dir_path = '../images/brands_img';
    
        if(!file_exists($dir_path)){
            mkdir($dir_path);
        }
        
        move_uploaded_file($tmp_name, $dir_path.'/'.$new_image); 
          
          
           if(count($errors) > 0){
             return[
                'status' => 'error',
                'message' => $errors
             ]; 
          }
          
           $success = []; 
    
        
          
           $insert_brands_query = "INSERT INTO brands(name, slug, sub_category_id, image)VALUES('$NAME','$slug','$sub_category','$new_image')";
        
           $result = $connection->query($insert_brands_query);
           
           if($connection->error){
               die('Table Error:'.$connection->error);
           }
           print_r($result);
          
          $success['success'] = 'Brand created successfully!';
               
          return[
           'status' => 'success',
           'message' => $success
          ]; 
           
            
            
          
     
           
 }
    
    
    
     public function Brand_edit(){
      $update_brand_id = $_POST['update_brand_id'];   
      $name = $_POST['name'];
      
      
        
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
		
       
		$errors = [];
		
		if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters ...'; 
        }
        
       
        
        $connection = $this->connection;
        
        $sql_view = "SELECT * FROM brands WHERE id='$update_brand_id'";
            
        #print_r($sku_sql_view);
		
		$result = $connection->query($sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
		}
        #print_r($result);
       
		
		$getEditData = $result->fetch_assoc();
		$path = $getEditData['image'];
        
       
        if($tmp_name){ 
		
			$getImageExtension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION ));
            
			
			function RemoveSpecialChar($str) {
 
               // Using str_replace() function 
               // to replace the word 
               $res = str_replace( array( '\'', '"',
               ',' , ';', '<', '>' ), '', $str);
 
               // Returning the result 
               return $res;
            }
          
           $NAME = RemoveSpecialChar($name);
        
           $slug = str_replace(' ', '-',strtolower($NAME));
        
           $new_img = time().$NAME.'.'.$getImageExtension;
            
           
            
			$targeted_extension = ['jpg', 'jpeg', 'png', 'gif'];
			if(!in_array($getImageExtension, $targeted_extension)){
				$errors['image'] = 'Only jpg/jpeg/png/gif file required';
			}
			
			if($img_size > 1024000){
				$errors['image'] = 'Max Size 1mb';
			}
			
			$dir = 'images/brands_img';
            
			if(!file_exists('../'.$dir)){
				mkdir('../'.$dir);
			}
			
			 
			
			 $img_path = $dir.'/'.$new_img;
        
             
		
		     move_uploaded_file($tmp_name, '../'.$img_path);
			
			
		    
		
        }
        
        
		if(count($errors) > 0){
			
			return [
				'status' => 'error',
				'message' => $errors
			];
		}
        
        
        
		
        $success = [];
		
		
		
       
        
        
		$sql_update = "UPDATE brands SET name='$NAME', slug='$slug', image='$new_img' WHERE id='$update_brand_id'";
		
		$result = $connection->query($sql_update);
        
		
		if($connection->error){
			die('Table Error: '.$connection->error);
		}
        print_r($result);
        
       
       
        $success['success'] = 'Brand updated successfully!';
		
		return [
				'status' => 'success',
				'message' => $success
		];
    }
    
    
    
    public function Delete_Brand(){
           $Brand_id = $_POST['DeletedID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_brand_query = "SELECT * FROM brands WHERE id='$Brand_id'";
    
           $result = $connection->query($view_brand_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc;
               $Delete_brand = "DELETE FROM brands WHERE id='$Brand_id'";
    
               $result = $connection->query($Delete_brand);
    
               if($connection->error){
                   die('Table Error:'.$connection->error);
               }   
               
               if(file_exists('../images/brands_img/'.$getData['image'])){
                   unlink('../images/brands_img/'.$getData['image']);
               }
               
               $success['success'] = 'Deleted successfully!';
     
               return[
                   'status' => 'success',
                   'message' => $success
               ];
     
           }
     
           
 }
    
    
    
    public function Brand_status(){
           $status_id = $_POST['statusID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_brand_query = "SELECT * FROM brands WHERE id='$status_id'";
    
           $result = $connection->query($view_brand_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           $getdata = $result->fetch_assoc();
           $status = $getdata['status'] == 0? 1: 0;       
        
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc();
               $update_brand = "UPDATE brands SET status ='$status' WHERE id='$status_id'";
    
               $result = $connection->query($update_brand);
    
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
    
     public function Sub_Category_edit(){
      $update_sub_category_id = $_POST['update_sub_category_id'];   
      $name = $_POST['name'];
      
      
        
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
		
       
		$errors = [];
		
		if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters ...'; 
        }
        
       
        
        $connection = $this->connection;
        
        $sql_view = "SELECT * FROM sub_categories WHERE id='$update_sub_category_id'";
            
        #print_r($sku_sql_view);
		
		$result = $connection->query($sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
		}
        #print_r($result);
       
		
		$getEditData = $result->fetch_assoc();
		$path = $getEditData['image'];
        
       
        if($tmp_name){ 
		
			$getImageExtension = strtolower(pathinfo($real_name, PATHINFO_EXTENSION ));
            
			
			function RemoveSpecialChar($str) {
 
               // Using str_replace() function 
               // to replace the word 
               $res = str_replace( array( '\'', '"',
               ',' , ';', '<', '>' ), '', $str);
 
               // Returning the result 
               return $res;
            }
          
           $NAME = RemoveSpecialChar($name);
        
           $slug = str_replace(' ', '-',strtolower($NAME));
        
           $new_img = time().$NAME.'.'.$getImageExtension;
            
           
            
			$targeted_extension = ['jpg', 'jpeg', 'png', 'gif'];
			if(!in_array($getImageExtension, $targeted_extension)){
				$errors['image'] = 'Only jpg/jpeg/png/gif file required';
			}
			
			if($img_size > 1024000){
				$errors['image'] = 'Max Size 1mb';
			}
			
			$dir = 'images/sub_categories_img';
            
			if(!file_exists('../'.$dir)){
				mkdir('../'.$dir);
			}
			
			 
			
			 $img_path = $dir.'/'.$new_img;
        
             
		
		     move_uploaded_file($tmp_name, '../'.$img_path);
			
			
		    
		
        }
        
        
		if(count($errors) > 0){
			
			return [
				'status' => 'error',
				'message' => $errors
			];
		}
        
        
        
		
        $success = [];
		
		
		
       
        
        
		$sql_update = "UPDATE sub_categories SET name='$NAME', slug='$slug', image='$new_img' WHERE id='$update_sub_category_id'";
		
		$result = $connection->query($sql_update);
        
		
		if($connection->error){
			die('Table Error: '.$connection->error);
		}
        print_r($result);
        
       
       
        $success['success'] = 'Sub Category updated successfully!';
		
		return [
				'status' => 'success',
				'message' => $success
		];
    }
    
    
       public function targetData($id){
           
           #$sku = $_GET['sku'];
        
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_sub_category_query = "SELECT * FROM sub_categories WHERE id='$id'";
    
           $result = $connection->query($view_sub_category_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 0){
               header('Location:sub_category.php');
           }
        
        
           return $result->fetch_assoc();
     
           
 }
    
    
     public function targetBrandData($id){
           
           #$sku = $_GET['sku'];
        
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_sub_category_query = "SELECT * FROM brands WHERE id='$id'";
    
           $result = $connection->query($view_sub_category_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 0){
               header('Location:brand.php');
           }
        
        
           return $result->fetch_assoc();
     
           
 }
    
}

?>