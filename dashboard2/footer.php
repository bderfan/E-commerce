  <!-- /.content-wrapper -->
  <footer>
    <!-- Vendor JS -->
	<script src="../js/vendors.min.js"></script>
    <script src="../js/feather.min.js"></script>	
	<script src="../js/jquery.easypiechart.js"></script>
	<script src="../js/irregular-data-series.js"></script>
	<script src="../js/apexcharts.js"></script>
      
    <!-- Bootstrap js -->
    <script src="../js/bootstrap.bundle.min.js"></script>
	
	<!-- Sunny Admin App -->
	<script src="../js/template.js"></script>
	<script src="../js/pages/dashboard.js"></script>
	


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript">
    $(function(){
      $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");

        const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-warning",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "Are you sure?",
  text: "Delete it!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel!",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href= link
    swalWithBootstrapButtons.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success"
    });
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire({
      title: "Cancelled",
      icon: "error"
    });
  }
});
      });
    });
  </script>

      <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
          document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
          if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("treeview-menu");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
          }        
        }
        </script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



  </footer>


</body>
</html>

