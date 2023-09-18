<footer>  

</footer>    
<script>
  function myFunction() {
     var x = document.getElementById("floatingPassword");
     if (x.type === "password") {
       x.type = "text";
     } else {
       x.type = "password";
     }
   }
  
   function myFunction2() {
     var x = document.getElementById("confirm_password");
     if (x.type === "password") {
       x.type = "text";
     } else {
       x.type = "password";
     }
   }
</script>
</body>
    <script src="js/bootstrap.bundle.min.js"></script>
</html>

<?php
 ob_flush();
?>