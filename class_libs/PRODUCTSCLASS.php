<?php
 error_reporting(E_ERROR | E_PARSE);
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
    
    public function targetData($id){
           
           #$sku = $_GET['sku'];
        
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT * FROM products WHERE id='$id'";
    
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
      $sub_category = $_POST['sub_category'];
      $brand =$_POST['brand'];
        
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
        if(strlen($details) < 10 || strlen($details) > 1000){
              $errors['details'] = 'Details should be in between 10-1000  characters'; 
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
        
        
        
        $sub_sql_view = "SELECT * FROM sub_categories";
		
		$result2 = $connection->query($sub_sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
        }
        
               
        $checkSubCategoryid = [];
        if($result2->num_rows == 0){
           $errors['sub_category'] == 'Invalid sub categories';
        }else{
            while($SubCategory = $result2->fetch_assoc()){
                $checkSubCategoryid[] = $SubCategory['id'];
                
                
            }
              /**
            print_r($checkCategoryid);
            return true;
           **/
            if(!in_array($sub_category, $checkSubCategoryid)){
                $errors['sub_category'] = 'Sub Category does not exists';
            }
            
            
        }
        
        $brand_sql_view = "SELECT * FROM brands";
		
		$result3 = $connection->query($brand_sql_view);
		
		if($connection->error){
			   die('Table Error: '.$connection->error);
        }
        
         $checkBrandid = [];
        if($result2->num_rows == 0){
           $errors['brand'] == 'Invalid brands';
        }else{
            while($Brand = $result3->fetch_assoc()){
                $checkBrandid[] = $Brand['id'];
            }
              /**
            print_r($checkCategoryid);
            return true;
           **/
            
            
            $sub_device_category = array('5','7','8');
            

            
            if(!in_array($sub_category, $sub_device_category)){
                $brand = '';
            }else if(!in_array($brand, $checkBrandid)){
                $errors['brand'] = 'Brand does not exists';
            }
        }
        
        
        /*if($sub_category!="5"){
            $errors['brand'] = 'Not brands for other sub-category';
        }else if($sub_category!="7"){
            $errors['brand'] = 'Not brands for other sub-category';
        }else if($sub_category!="8"){
            $errors['brand'] = 'Not brands for other sub-category';
        }*/
        
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
           
    
          
        
           
           $DETAILS = $connection->real_escape_string($details);
        
          
           $insert_products_query = "INSERT INTO products(name, sku, slug,  price, strike_price, image, details,category_id,sub_category_id)VALUES('$NAME','$sku','$slug','$price','$strike_price','$new_image','$DETAILS','$category','$sub_category')";
        
           $result = $connection->query($insert_products_query);
           
           if($connection->error){
               die('Table Error:'.$connection->error);
           }

          $success['success'] = 'Product created successfully!';
               
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
        #print_r($result);
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
        if(strlen($details) < 10 || strlen($details) > 1000){
              $errors['details'] = 'Details should be in between 10-1000  characters'; 
        }
		
       
        
		
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
			
			$dir = 'images/products_img';
            
			if(!file_exists('../'.$dir)){
				mkdir('../'.$dir);
			}
			
			 
			
			 $img_path = $dir.'/'.$new_img;
        
             
		
		     move_uploaded_file($tmp_name, '../'.$img_path);
			
			
		    
		
        }
        
        
		if(count($errors) > 0){
			$errors['modal'] = 'addCategoryModal';
			return [
				'status' => 'error',
				'message' => $errors
			];
		}
        
        
        
		
        $success = [];
		
		
		
        $details = $connection->real_escape_string($details);
        
        
		$sql_update = "UPDATE products SET name='$NAME', sku='$sku', slug='$slug', price='$price', strike_price='$strike_price', image='$new_img', details='$details' WHERE id='$Update_product_id'";
		
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
               
               
               $success['success'] = 'Status updated successfully!';
     
               return[
                   'status' => 'success',
                   'message' => $success
               ];
     
           }
     
           
 }

}
    

   
?>