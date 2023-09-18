<?php
  include('header.php');

  require_once('class_libs/HOMECLASS.php');

  $home = new HOMECLASS;

  $products = $home->allProducts();
?>

<!-- ============================== Banner part ========================= -->
<main>    
<section id="Banner" class="section-padding" style="background-image: url('images/banner-bg.jpg'); background-repeat: no-repeat; background-size: auto;">
     <div class="container py-5">
       <div class="row py-5">
        <div class="col-6 py-5">
          <h1 class="fw-bold" style="color:#c40202; font-size:60px;">My E-commerce</h1>
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
