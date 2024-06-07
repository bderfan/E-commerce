<?php
 error_reporting(E_ERROR | E_PARSE);
  require('header.php');

   require_once('../class_libs/HOMECLASS.php');

   $home = new HOMECLASS;

  
   $indexes = $home->categorylist();
   
  

   
?>
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background-color: #FDD835;">
    <!-- sidebar-->
    <section class="sidebar">	
		
        <div class="user-profile">
			<div class="ulogo">
				 <a href="../index.php">
				  <!-- logo for regular state and mobile devices -->
					 <div class="d-flex align-items-center justify-content-center" style="background-color: #fff;">					 	
						  <img src="../images2/logo.png" alt="logo" style="width:100px; height: 100px;">
					 </div>
				</a>
			</div>
        </div>
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree" style="background-color: #5D4037;">  
		  
		<li class="py-2">
          <a href="dashboard2.php" style="text-decoration: none;">
            <img src="../images2/dashboardicon.png" alt="dashboardicon" style="width:25px; height:25px;">
			<h4 class="text-white fw-bold" style="display:inline-block; text-decoration: none;">Dashboard</h4>
          </a>
        </li>  
          
        <li class="py-2">
          <a href="profile.php" style="text-decoration: none;">
            <img src="../images2/manicon.png" alt="manicon" style="width:25px; height:325x;">
			<h4 class="text-white fw-bold" style="display:inline-block; text-decoration: none;">Profile</h4>
          </a>
        </li> 
        
		 <?php
             if(mysqli_num_rows($indexes) > 0){
                while($index = $indexes->fetch_assoc()){ 
          ?>
        <li class="py-2">
          <a href="category.php?id=<?php echo $index['id']; ?>" style="text-decoration: none;">
            <img src="../images2/categoryicon.png" alt="manicon" style="width:25px; height:325x;">
			<h4 class="text-white fw-bold" style="display:inline-block; text-decoration: none;"><?php echo $index['name']; ?></h4>
          </a>
        </li> 
        <?php
                }
             }
        ?>
            
        
       
      </ul>
    </section>
	
	
  </aside>