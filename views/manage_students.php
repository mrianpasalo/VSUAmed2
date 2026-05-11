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
              if ($_GET['page'] == "SearchStudent"): ?>

                <div class="row m-5">
                  <div class="col-md-12">
                    <div class="card p-5">
                      <div class="card-body">
                        <div class="form-group">
                          <div class="input-icon">
                            <input
                              type="text"
                              class="form-control"
                              placeholder="Search Student..."
                            />
                            <span class="input-icon-addon">
                              <i class="fa fa-search"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="card-body p-5">
                        after search the admin can click the students info then they will be redirected to the medical record page and there click the modal for checking the students record
                      </div>
                    </div>
                  </div>
                </div>

              <?php else: ?>

                <div class="row m-5">
                  <div class="col-md-6">
                    <div class="card">

                      <form action="../pages/student.php" method="POST" id="addStudent">
                        <div class="card-header">
                          <div class="card-title">ADD STUDENT</div>
                        </div>
                      
                        <div class="card-body">

                          <div class="row">

                            <div class="col-md-8">
                              <div class="form-group">
                                <label for="sn">Student Number: </label>
                                <input
                                  id="sn"
                                  class="form-control"
                                  placeholder="2024-01"
                                  required
                                />
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="lname">Sex: </label>
                                <input
                                  id="lname"
                                  class="form-control"
                                  placeholder="Male"
                                  required
                                />
                              </div>
                            </div>

                          </div>

                          <div class="row">

                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="lname">Student Last Name: </label>
                                <input
                                  id="lname"
                                  class="form-control"
                                  placeholder="Cruz"
                                  required
                                />
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="lname">Student First Name: </label>
                                <input
                                  id="lname"
                                  class="form-control"
                                  placeholder="John Doe"
                                  required
                                />
                              </div>
                            </div>

                          </div>

                          <div class="row">

                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="lname">Student Middle Name: </label>
                                <input
                                  id="lname"
                                  class="form-control"
                                  placeholder="Mendoza"
                                />
                              </div>
                            </div>

                            
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="lname">Birthday: </label>
                                <input
                                  id="lname"
                                  class="form-control"
                                  type="date"
                                  required
                                />
                              </div>
                            </div>
                            
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="lname">Email: </label>
                                <input
                                  id="lname"
                                  class="form-control"
                                  placeholder="johndoe@gmail.com"
                                  required
                                />
                              </div>
                            </div>

                          </div>
                          <div class="form-group">
                            <label for="lname">Contact Number: </label>
                            <input
                              id="lname"
                              class="form-control"
                              placeholder="Philippines [+ 639]"
                              required
                            />
                          </div>
                        </div>

                        <div class="card-footer p-3">
                          <input type="submit" name="addStudent" class="btn btn-success ">
                        </div>
                      </form>

                    </div>
                  </div>
                </div>

            <?php endif; ?>

            <!--------------------------End Edit Here---------------------------------->
      



          </div>
        </div>

        <!---------------------------------End Content------------------------------------->

      </div>

    <!-------------------------------------------------------------------------------------------------->
    <?php include 'inc/footer.php' ?>