<?php
 error_reporting(E_ERROR | E_PARSE);
require_once('DATABASECLASS.php');

class ORDERCLASS extends DATABASECLASS{

    public function index(){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_orders_query = "SELECT * FROM orders";
    
           $result = $connection->query($view_orders_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    

public function user_index($m){
           $invoice=$m;
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_orders_query = "SELECT * FROM orders WHERE invoice='$invoice'";
    
           $result = $connection->query($view_orders_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
     
           
 }
    
    
 public function getOrderlist($r){
           
           $connection = $this->connection;
           //print_r($Connection);
    
           $view_orders_query = "SELECT * FROM orders WHERE invoice='$r'";
    
           $result = $connection->query($view_orders_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result->fetch_assoc();
     
           
 }
   

 public function getProducts($t){
      $connection = $this->connection;
           //print_r($Connection);
    
           $view_products_query = "SELECT *,products.name,products.sku,products.image FROM order_list JOIN(products) ON order_list.product_id=products.id WHERE order_list.order_id='$t'";
    
           $result = $connection->query($view_products_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }   
     
           return $result;
 }
    
  
    
     
 public function Approved_order($s){
     
           $invoice = $s['invoice'];
           
           $connection = $this->connection;
     
           $success = []; 
    
           $update_orders_query = "UPDATE orders SET status='1' WHERE invoice='$invoice'";
    
           $result = $connection->query($update_orders_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }  
     
     
            $success['success'] = 'Order approved successfully!';
     
            session_destroy();
               
            return[
             'status' => 'success',
             'message' => $success
            ]; 
     
           
 }
    
    
  public function Delete_order($s){
     
           $invoice = $s['invoice'];
           
           $connection = $this->connection;
     
           $success = []; 
    
           $delete_orders_query = "UPDATE orders SET status='0' WHERE invoice='$invoice'";
    
           $result = $connection->query($delete_orders_query);
    
           if($connection->error){
               die('Table Error:'.$connection->error);
           }  
     
           
           $success['success'] = 'Order deleted successfully!';
      
       
           if($result->num_rows == 0){
               header('Location:orders.php');
           }
     
              
            return[
             'status' => 'success',
             'message' => $success
            ]; 
     
           
 }
   
   
}

?>