    <?php include 'inc/header.php' ?>
    <!-------------------------------------------------------------------------------------------------->

    <div class="wrapper">
      <!-- Sidebar -->
        <?php include 'inc/sidebar.php'; ?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          
          <!-- LOGO -->
            <?php include 'inc/logo.php' ?>
          <!-- End LOGO -->

          <!-- Navbar Header -->
            <?php include 'inc/navbar.php' ?>
          <!-- End Navbar -->
        
        </div>

        <!---------------------------------Content------------------------------------->

        <div class="container">
          <div class="page-inner">
            



            <!----------------------------Edit Here------------------------------------>
              
            <?php
              if ($_GET['page'] == "SearchStudent"):

                echo "hello bitch add";

              else:

                echo "hello teh";
              endif;
            ?>

            <!--------------------------End Edit Here---------------------------------->
      



          </div>
        </div>

        <!---------------------------------End Content------------------------------------->

      </div>

    <!-------------------------------------------------------------------------------------------------->
    <?php include 'inc/footer.php' ?>