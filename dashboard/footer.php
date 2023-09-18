  <script src="../js/bootstrap.bundle.min.js"></script>

      <script src="../js/feather.min.js" ></script>
      <script src="../js/chart.umd.min.js"></script>
      <script src="../js/dashboard.js"></script>

      <script>

         new bootstrap.Modal("#<?php echo (isset($errors)? ($errors['modal']?? ''): '');?>", {
         keyboard: false
         }).show();

      </script>
  </body>
</html>

<?php
  ob_flush();
?>