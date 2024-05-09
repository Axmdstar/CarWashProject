
<!-- ====== NavBar ========-->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">JAZZERA</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <script>
  var toggleButton = document.querySelector('.toggle-sidebar-btn');

  // Check if the element exists
  if (toggleButton) {
      // Add onclick event handler
      toggleButton.onclick = function(e) {
          // Toggle the class on body
          document.body.classList.toggle('toggle-sidebar');
      };
  }

  
</script>

</header><!-- End Header -->

<?php include "../Components/SideBar.php" ?>