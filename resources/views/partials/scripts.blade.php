<!-- Core scripts shared globally across SISCAP views -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
     // Global javascript methods for SISCAP interactive behaviors
     $(document).ready(function() {
          console.log("SISCAP: Blade scripts initialized.");
          
          // Hover submenu handler
          $('.dropdown-submenu').hover(function() {
               $(this).find('.dropdown-menu').first().stop(true, true).delay(50).fadeIn(150);
          }, function() {
               $(this).find('.dropdown-menu').first().stop(true, true).delay(50).fadeOut(150);
          });
     });
</script>
