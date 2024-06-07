<?php
 error_reporting(E_ERROR | E_PARSE);
  require_once('class_libs/HOMECLASS.php');

  $home = new HOMECLASS;

  $products_slider = $home->Sliderproducts($_GET['category_id']);
?>


<!-- ============================== Banner part ========================= -->
<main>    


    


    
<!-- =================================== Service part ================================== -->
    
<section id="service" class="section-padding text-center bg-black">
  <div class="container">
     <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner"> 
                 <?php
                   if($products_slider->num_rows > 0){
                       $i = 0;
                       $x = 0;
                       while($product_slider = $products_slider->fetch_assoc()){
                       if($i===0){
                           $x = $product_slider['id'];
                  ?>
                     <div class="carousel-item active">
                       <img src="images/products_img/<?php echo $product_slider['image']; ?>" class="d-block w-100" style="height:500px;" alt="<?php echo $product_slider['name']; ?>">
                    </div>
                  <?php
                      $i++;
                      }else{
                  ?>
                 <div class="carousel-item">
                   <img src="images/products_img/<?php echo $product_slider['image']; ?>" class="d-block w-100" style="height:500px;" alt="<?php echo $product_slider['name']; ?>">
                 </div>
                 <?php
                        }
                       }
                   }
                 ?>
              </div>
            </div>  
  </div>      
</section>
   
    
   
    
  


   
    
 
</main>

<?php
 include('footer.php');
?>
