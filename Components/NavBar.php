
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

  let selectHeader = document.getElementById('header');
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled');
      } else {
        selectHeader.classList.remove('header-scrolled');
      }
    };

    window.addEventListener('load', headerScrolled);
    window.addEventListener('scroll', headerScrolled); // Add this line to listen for scroll events
  }
</script>

</header><!-- End Header -->

<?php include "../Components/SideBar.php" ?>