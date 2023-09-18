<?php

require_once('DATABASECLASS.php');

class PRODUCTSCLASS extends DATABASECLASS{

    public function index(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT * FROM products";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    
    public function targetData($sku){
           
           $sku = $_GET['sku'];
        
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT * FROM products WHERE sku='$sku'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 0){
               header('Location:products.php');
           }
        
        
           return $result->fetch_assoc();
     
           
 }
    
    
    public function Product_add(){
     
      $category = $_POST['category'];
      $name = $_POST['name'];
      $sku = $_POST['sku'];
      $price= $_POST['price'];
      $strike_price = $_POST['strike_price'];
      $details = $_POST['details'];
      
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
      
     
     
       $errors = [];
     
        if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters ...'; 
          }
        if(strlen($sku) < 8 || strlen($sku) > 16){
            $errors['sku'] = '8-16 characters required ...'; 
        }
        
        $connection = $this->connection;
        $sku_sql_view = "SELECT * FROM products WHERE sku='$sku'";
		
		$result = $connection->query($sku_sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
		}
        
        if($result->num_rows > 0){
            $errors['sku'] = 'SKU doesnot exists';
        }
        
        if($price < 0){
              $errors['price'] = 'Price should be greater than 0'; 
        }
        if($strike_price < 0){
              $errors['strike_price'] = 'Strike price should be greater than 0'; 
        }
        if($strike_price < $price){
              $errors['strike_price'] = 'Strike price should be greater than price'; 
        }
        if(strlen($details) < 10 || strlen($details) > 500){
              $errors['details'] = 'Details should be in between 10-500  characters'; 
        }
        
               
        
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
       
        $new_image = time().$name.'.'.$get_image_extension;
        $target_extension = ['jpg', 'jpeg', 'png', 'gif'];
    
        if(!in_array($get_image_extension, $target_extension)){
            $errors['image'] = 'File format should be jpg/jpeg/png/gif';
        }
        if($img_size > 1048576){
            $errors['image'] = 'File size can not be larger than 1Mb';
        }
        
        $dir_path = '../images/products_img';
    
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
           
    
           $slug = str_replace('', '-',strtolower($name));
        
           $DETAILS = $connection->real_escape_string($details);
        
           $insert_products_query = "INSERT INTO products(name, sku, slug,  price, strike_price, image, details,category_id)VALUES('$name','$sku','$slug','$price','$strike_price','$new_image','$DETAILS','$category')";
        
           $result = $connection->query($insert_products_query);
           
           if($connection->error){
               die('Table Error:'.$connection->error);
           }

          $success['success'] = 'Product saved successfully!';
               
          return[
           'status' => 'success',
           'message' => $success
          ]; 
           
            
            
          
     
           
 }
    
    
    public function Product_edit(){
      $Update_product_id = $_POST['update_product_id'];   
      $name = $_POST['name'];
      $sku = $_POST['sku'];
      $price= $_POST['price'];
      $strike_price = $_POST['strike_price'];
      $details = $_POST['details'];
      
      
        
      $tmp_name = $_FILES['image']['tmp_name'];
      $real_name = $_FILES['image']['name'];
      $img_size = $_FILES['image']['size'];
		
        echo $Update_product_id;
		$errors = [];
		
		if(strlen($name) < 5){
              $errors['name'] = 'Minimum 5 characters ...'; 
        }
        
        if(strlen($sku) < 8 || strlen($sku) > 16){
            $errors['sku'] = '8-16 chracters required ...';
        }
        
        $connection = $this->connection;
        
         $sku_sql_view = "SELECT * FROM products WHERE id!='$Update_product_id' and sku='$sku'";
            
        #print_r($sku_sql_view);
		
		$result = $connection->query($sku_sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
		}
        print_r($result);
        if($result->num_rows > 0){
            $errors['sku'] = 'SKU already exists';
        }
        
        if($price < 0){
              $errors['price'] = 'Price should be greater than 0'; 
        }
        if($strike_price < 0){
              $errors['strike_price'] = 'Strike price should be greater than 0'; 
        }
        if($strike_price < $price){
              $errors['strike_price'] = 'Strike price should be greater than price'; 
        }
        if(strlen($details) < 10 || strlen($details) > 500){
              $errors['details'] = 'Details should be in between 10-500  characters'; 
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
			
			if($img_size > 1024000){
				$errors['image'] = 'Max Size 1mb';
			}
			
			$dir = 'images/products_img';
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
        
        
        
		
        $success = [];
		
		$slug = str_replace('', '-',strtolower($name));
		
        $details = $connection->real_escape_string($details);
        
        
		$sql_update = "UPDATE products SET name='$name', sku='$sku', slug='$slug', price='$price', strike_price='$strike_price', image='$new_img', details='$details' WHERE id='$Update_product_id'";
		
		$result = $connection->query($sql_update);
        
		
		if($connection->error){
			die('Table Error: '.$connection->error);
		}
        #print_r($result);
       
        $success['success'] = 'Product updated successfully!';
		
		return [
				'status' => 'success',
				'message' => $success
		];
    }
    
    public function Delete_Product(){
           $Product_id = $_POST['DeletedID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_product_query = "SELECT * FROM products WHERE id='$Product_id'";
    
           $result = $connection->query($view_product_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc();
               $Delete_product = "DELETE FROM products WHERE id='$Product_id'";
    
               $result = $connection->query($Delete_product);
    
               if($connection->error){
                   die('Table Error:'.$connection->error);
               }   
               
               if(file_exists('../images/products_img/'.$getData['image'])){
                   unlink('../images/products_img/'.$getData['image']);
               }
               
               $success['success'] = 'Deleted successfully!';
     
               return[
                   'status' => 'success',
                   'message' => $success
               ];
     
           }
     
           
 }
    
    
         public function Product_status(){
           $status_id = $_POST['statusID'];
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_product_query = "SELECT * FROM products WHERE id='$status_id'";
    
           $result = $connection->query($view_product_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           $getdata = $result->fetch_assoc();
           $status = $getdata['status'] == 0? 1: 0;       
        
           if($result->num_rows == 1){
               $getData = $result->fetch_assoc();
               $update_product = "UPDATE products SET status ='$status' WHERE id='$status_id'";
    
               $result = $connection->query($update_product);
    
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