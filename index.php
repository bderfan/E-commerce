<?php
  include('header.php');

  require_once('class_libs/HOMECLASS.php');

  $home = new HOMECLASS;

  
?>

<!-- ============================== Banner part ========================= -->
<main>    
<section id="Banner" class="section-padding" style="background-image: url('images/banner-bg.jpg'); background-repeat: no-repeat; background-size: auto;">
     <div class="container py-5">
       <div class="row py-5">
        <div class="col-6 border border-3 border-dark rounded-5">
           <div class="p-5">
             <h1 class="fw-bold" style="color:#c40202;">My E-commerce</h1>
             <h2 class="mt-2 text-dark fw-bold">A landing E-commerce platform</h2> 
           </div>
         </div>
         <div class="col-6">
         </div>  
        </div>       
      </div>  
</section>    
</main>

<?php
 include('footer.php');
?> 
