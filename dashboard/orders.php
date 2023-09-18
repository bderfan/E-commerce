
   <?php
     require('sidebar.php'); 
     require('../class_libs/ORDERCLASS.php');
     

     $old = $_POST;
     
     $orders = new ORDERCLASS;
     
     $rows = $orders->index();
    

   ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #4e6e43b3;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h5 class="text-black fw-bold fs-1">Orders</h5>
      </div>
        
        
        
        
      <div>
           <?php
            if(isset($success)){
             ?>
             <div class="alert alert-success" role="alert" name="success">
               <?php print $success['success']; ?>
             </div>
             <?php
                header('Refresh:1,url=categories.php');
                }
             ?>
         
            
        </div>
        
        
        <div>
           
           
        </div>
         <div class="col-12">
             <table class="table table-secondary table-hover">
                 
               <tr>
                 <th>SL</th>
                 <th>Invoice</th>
                 <th>Customer Details</th>
                 <th>Total Price</th>
                 <th>Total Payment</th>
                 <th>Status</th>
                 <th></th>
               </tr>
                 
                 
               <?php 
                 if(mysqli_num_rows($rows) > 0){
                     $x = 1;
                     while($row = mysqli_fetch_assoc($rows)){
                     
               ?>
                <tr>
                 <td>
                  <?php 
                      $x = $row['id'];
                      echo $x++;
                  ?>
                 </td> 
                    
                 <td><?php echo $row['invoice']; ?></td>
                    
                    
                 <td>
                   <p><?php echo $row['name'];?></p> 
                   <p><?php echo $row['phone'];?></p> 
                   <p><?php echo $row['address'];?></p> 
                 </td> 
                    
                 <td><?php echo $row['total_bill'];?></td> 
                    
                 <td><?php echo $row['total_payment'];?></td> 
                    
                 <td>
                   <?php if($row['status'] == 0){
					     echo '<span class="badge bg-warning">Pending</span>';
				     }elseif($row['status'] == 1){
					     echo '<span class="badge bg-success">Approve</span>';
				     }elseif($row['status'] == 2){
					     echo '<span class="badge bg-danger">Cancel</span>';
				     } 
                   ?>   
                 </td>
                    
                 <td>
                   <div class="d-flex justify-content-center">
                     <a href="order-lists.php?invoice=<?php echo $row['invoice'];?>">
                       <button class="btn btn-danger">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="10" height="15" class="d-flex align-items-center">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                          </svg>  
                        </button>  
                     </a>
                   </div>   
                 </td>
               </tr>
              <?php 
                  }
                 }else{
               ?>
               <tr>
                 <td colspan="4" class="text-center">No data available</td>
               </tr>
               <?php
                 }
               ?>
             </table>
            
              <form class="d-flex justify-content-center mt-3" method="post">
                  <button class="btn btn-dark" style="padding:10px 30px;" name="Loggedout">Logout</button>
             </form>
        </div>
        <canvas width="900" height="380"></canvas>
        
        
       
    </main>
    
 
<?php
  require('footer.php');  
?>

