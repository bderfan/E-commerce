<?php
error_reporting(E_ERROR | E_PARSE);
  require('header.php');

   require_once('../class_libs/HOMECLASS.php');

   $home = new HOMECLASS;

  
   
   
   $cat_sub_cat_indexes = $home->categorysubcategorylist($_GET['id']);
       

    

   
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
            if(mysqli_num_rows($cat_sub_cat_indexes) > 0){   
               while($cat_sub_cat_index = $cat_sub_cat_indexes->fetch_assoc()){ 
          ?>
              <li class="py-2">
                <a href="products.php?id=<?php echo $cat_sub_cat_index['id']; ?>" style="text-decoration: none;">
                  <img src="../images2/categoryicon.png" alt="manicon" style="width:25px; height:325x;">
			      <h4 class="text-white fw-bold" style="display:inline-block; text-decoration: none;"><?php echo       $cat_sub_cat_index['name']; ?></h4>
                </a>
              </li> 
           <?php
                   }
                }
           ?>
        </ul>
    </section>
	
	
  </aside>

<div class="content-wrapper">
	  <div class="container-full">

		<!-- Main content -->
		<section class="content">
            
			<div class="row">
				<div class="col-6 mx-auto">
                   <div class="d-flex justify-content-center">
                     <form method="post">
                       <button class="btn btn-dark btn-lg" type="submit" name="logout">Logout</button>
                     </form>
                   </div>
                </div>
			</div>
		</section>
		<!-- /.content -->
	  </div>
  </div>

<?php
  require('footer.php');
?>
