<footer>  

</footer>    
<script>
  function myFunction() {
     var x = document.getElementById("floatingPassword");
     var eye_icon = document.getElementById("togglePassword");
     if (x.type === "password") {
       x.type = "text";
       eye_icon.classList.add("fa-eye");
     } else {
       x.type = "password";
       eye_icon.classList.remove("fa-eye");
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