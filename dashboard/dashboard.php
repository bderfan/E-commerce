
     <?php
       require('sidebar.php'); 
     ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #45458e;">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h5 class="text-white fw-bold fs-1">Dashboard</h5>
          <div class="d-flex justify-content-end my-3">
                <!-- Button trigger modal -->
                 <a href="../index.php" class="btn btn-light">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                     </svg>
                 </a>
           </div>
      </div>
      <div>
           <form class="d-flex justify-content-center mt-3" method="post">
               <button class="btn btn-danger" style="padding:10px 30px;" name="Loggedout">Logout</button>
          </form>
      </div>    
        <canvas width="900" height="380"></canvas>
    </main>
  
<?php
   require('footer.php');    
?>