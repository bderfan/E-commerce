<?php

require_once('DATABASECLASS.php');

class HOMECLASS extends DATABASECLASS{

    public function categorylist(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_categories_query = "SELECT * FROM categories WHERE status= '1'";
    
           $result = $connection->query($view_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    
    
    public function allProducts(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT * FROM products WHERE status= '1'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
   }
    
   
    public function RandomProducts($x){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_categories_query = "SELECT * FROM categories WHERE slug='$x'";
    
           $result = $connection->query($view_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           $category = $result->fetch_assoc()['id'];
     
           $view_products_query = "SELECT * FROM products WHERE status='1' && category_id ='$category'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
           
          return $result;
 }

    
    public function ProductsCard($x){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT * FROM products WHERE sku='$x'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           
          return $result->fetch_assoc();
 }
    
    public function Cart($y){
           $Product_id = $_POST['prdct_id'];
           #print_r($y);
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT * FROM products WHERE id='$Product_id'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }  
        
           $product = $result->fetch_assoc();
        
           if($_SESSION['cartList']){
               if(count($_SESSION['cartList']['items']) > 0){
                   if(isset($_SESSION['cartList']['items'][$product['sku']])){
                        $_SESSION['cartList']['items'][$product['sku']]['Quantity'] = $_SESSION['cartList']['items'][$product['sku']]['Quantity'] + $y['quantity'];
                   }else{
                       $_SESSION['cartList']['items'][$product['sku']] = [
                                    'Name' => $product['name'],
                                    'SKU' => $product['sku'],
                                    'Price' => $product['price'],
                                    'Strike_price' => $product['strike_price'],
                                    'Image' => $product['image'],
                                    'Quantity' => $y['quantity'],
                                ];
                       
                   }  
               }
           }else{
               $_SESSION['cartList'] = [
                       'product_id' => $product['id'],
                       'customer_details' => [
                          'Name' => '',
                          'Phone Number' => '',
                          'Address' => '',
                          'status' => 0,
                        ],
                        'payment_details' => [
                          // cash on delivery / cash payment
					          'payment_policy' => 'cod',
					          'sender_number' => null,
					          'transaction_id' => null,
				          // bkash/nagad/rocket
					          'payment_method' => null,
					          'status' => 0,
                        ],
                        'items' => [
                            $product['sku'] => [
                                'id' => $product['id'],
                                'Name' => $product['name'],
                                'SKU' => $product['sku'],
                                'Price' => $product['price'],
                                'Strike_price' => $product['strike_price'],
                                'Image' => $product['image'],
                                'Quantity' => $y['quantity'],
                            ]
                        ],
               ];  
           }
          
           print_r($_SESSION['cartList']);
           
           
           header('Location:product-card.php?sku='.$product['sku']);
           
           
           #print_r($cartList);
          # return true;
          
 }
    
    public function customer_details($t){
          $name = $_SESSION['authenticate']['name'];
          $phone_no = $_SESSION['authenticate']['phone_no'];
          $address = $_SESSION['authenticate']['address'];
     
         
        
        $_SESSION['cartList']['customer_details'] = [
                  'Name' => $name,
                  'Phone Number' => $phone_no,
                  'Address' => $address,
                  'status' => 2,
        ];
    }
    
    public function confirm_checkout($g){
        if(!isset($_SESSION['authenticate'])){
             header('Location:login.php');
         }
        
         $_SESSION['cartList']['customer_details']['status'] = 1;
    }
    
     public function confirm_payment($x){
         if(!isset($_SESSION['authenticate'])){
             header('Location:login.php');
         }
         $_SESSION['cartList']['payment_details']['status'] = 1;
    }
    
     public function payment_details($m){
          $payment_policy = $_POST['payment_policy']??'';
          $sender_number = $_POST['sender_number'];
          $transaction_id = $_POST['transaction_id'];
     
          $errors = [];

          if(!$payment_policy && !in_array($payment_policy,['cod' , 'cp'])){
              $errors['payment_policy'] = 'Empty payment poilicy';
          }
          if($payment_policy && $payment_policy == 'cp'){
              if(strlen($sender_number) < 11){
                  $errors['sender_number'] = 'Your digit of input sender number should reach 11 ...';
              }
              if(strlen($transaction_id)< 8 || strlen($transaction_id) > 12){
                  $errors['transaction_id'] = 'Can not less than 8 characters and more than 12 characters';
              }
          }
          
           
           if(count($errors) > 0){
                return[
                   'status' => 'error',
                   'message' => $errors
               ];
           }
        
        $_SESSION['cartList']['payment_details'] = [
                  'payment_policy' => $payment_policy,
				  'sender_number' => $sender_number,
				  'transaction_id' => $transaction_id,
                  'status' => 2,
        ];
         
        $invoice = 'ETS-'.time();
        $user_id = $_SESSION['authenticate']['id'];
        $name = $_SESSION['authenticate']['name'];
        $phone = $_SESSION['authenticate']['phone_no'];
        $address = $_SESSION['authenticate']['address'];
        $cart_data = $_SESSION['cartList'];
        $total_bill = 0;
         
        foreach($cart_data['items'] as $items){
           $total_bill += $items['Price']*$items['Quantity'];
        }
         
        $total_payment = $payment_policy == 'cp' ?$total_bill : null;
        $sender_number = $payment_policy == 'cp' ?($sender_number??null) : null;
        $transaction_id = $payment_policy == 'cp' ?($transaction_id??null) : null;
         
        $connection = $this->connection;
        //print_r($Connection);
        
        $order_insert_query = "INSERT INTO orders(invoice, user_id, name, phone, address, payment_policy, total_bill, total_payment, sender_number, transaction_id) VALUES ('$invoice','$user_id','$name','$phone','$address','$payment_policy','$total_bill','$total_payment','$sender_number','$transaction_id')";
    
        $result = $connection->query($order_insert_query);
    
        if($connection->error){
            die('Table Error:'.$connection->error);
        }  
         
        $order_id = $connection->insert_id;
         
        foreach($cart_data['items'] as $items){
            
            $product_id = $items['id'];
            $product_name = $items['Name'];
            $product_price = $items['Price'];
            $product_quantity = $items['Quantity'];
           
            $order_list_insert_query = "INSERT INTO order_list(order_id, product_id, product_name, product_price, product_quantity) VALUES ('$order_id','$product_id','$product_name','$product_price','$product_quantity')";
    
            $result = $connection->query($order_list_insert_query);
    
            if($connection->error){
                die('Table Error:'.$connection->error);
            }  
            
            $success['success'] = 'Order placed successfully!';
     
            unset($_SESSION['cartList']);
            
            return[
                'status' => 'success',
                'message' => $success
            ];
        }
    }
    
    public function Sliderproducts($z){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_categories_query = "SELECT * FROM categories WHERE slug='$z'";
    
           $result = $connection->query($view_categories_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           $category = $result->fetch_assoc()['id'];
     
           $view_products_query = "SELECT * FROM products WHERE status='1' && category_id ='$category'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
           
          return $result;
 }

    public function Removeproduct($m){
        print_r($m);
        $remove_id = $m['remove_id'];
        
        if($_SESSION['cartList']){
            $cartItem = $_SESSION['cartList']['items'];
            echo $cartItem;
            if(count($cartItem)>0 && !empty($remove_id) && isset($cartItem[$remove_id])){
                unset($cartItem[$remove_id]);
                
                $_SESSION['cartList']['items']=$cartItem;
            }
            
            /*if(count($_SESSION['cartList']['items'] == 0)){
                unset($_SESSION['cartList']);
            }*/
            
            header('Location:Checkout.php');
        }
    }
}

?>