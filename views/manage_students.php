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
          <div class="page-inner p-5">


            <!----------------------------Edit Here------------------------------------>
              
            <?php
              if (isset($_GET['pages']) == "SearchStudent"): ?>

                <div class="row m-5">
                  <div class="col-md-12">
                    <div class="card p-5">
                      <div class="card-header">
                        <div class="form-group">
                          <div class="input-icon">
                            <form action="../pages/student.php" method="POST">
                              <input
                                type="text"
                                class="form-control"
                                placeholder="Search Student..."
                                name="search"
                                <?= isset($_GET['search']) ? "value='" . ucwords($_GET['search']) . "'" : '' ?>
                                autofocus
                              />
                              <input type="submit" name="searchStud" hidden>
                            </form>
                            <span class="input-icon-addon">
                              <i class="fa fa-search"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="card-body p-5">
                        <table class="table table-borderless <?= !empty($_SESSION['search_res']) ? 'mb-5' : 'd-none' ?>">
                          <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Student Number</th>
                                <th>Name</th>
                                <th>Year & Program</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $n = 1;
                              if(isset($_SESSION['search_res'])){
                                foreach($_SESSION['search_res'] as $res){
                            ?>
                              <tr onclick="window.location='medicalrecord.php?program=<?= $res['program_id'] ?>&&yr=<?= $res['year_level_id'] ?>&&student=<?= $res['student_id'] ?>'" style="cursor:pointer;">
                                  <td class="text-center"><?= $n++ . ". )" ?></td>
                                  <td><?= $res['student_number'] ?></td>
                                  <td><?= ucwords($res['last_name'] . ", " . $res['first_name'] . " " . $res['middle_name']) ?></td>
                                  <td class="text-center"><?= ucwords($res['year_level_name'] . " Year - ") . strtoupper($res['program_code'])?></td>
                              </tr>
                            <?php }} unset($_SESSION['search_res']); ?>
                          </tbody>
                        </table>
                        <?php
                          if(isset($_SESSION['search_error'])){
                              echo "<h2 class='text-center mb-5' style=\"font-family: 'Roboto', sans-serif;\">Nothing Found.</h2>";
                              unset($_SESSION['search_error']);
                          }
                        ?>
                        <p class="text-center" style="font-family: 'Roboto', sans-serif;">Enter a name or student number to begin searching records.</p>
                        <p class="text-center text-danger" style="font-family: 'Roboto', sans-serif;">* Note: Only enrolled students can be searched in the system.”</p>
                        <p class="text-center" style="font-family: 'Roboto', sans-serif;">“Search. Find. Care.”</p>
                      </div>
                    </div>
                  </div>
                </div>

              <?php else: ?>

                <div class="row mx-5">
                  <div class="col-md-12">
                    <div class="card">

                      <form action="../pages/student.php" method="POST" id="addStudent">
                        <div class="card-header row text-center">
                          <div class="col-md-6">
                            <div class="card-title">ADD STUDENTS' INFORMATION</div>
                          </div>
                          <div class="col-md-6">
                            <div class="card-title">ENROLLMENT INFORMATION</div>
                          </div>
                        </div>
                      
                        <div class="card-body row">
                          <div class="col-md-6">
                            <div class="row">

                              <div class="col-md-8">
                                <div class="form-group">
                                  <label for="sn">Student Number: </label>
                                  <input
                                    id="sn"
                                    class="form-control"
                                    name="num"
                                    placeholder="2024-01"
                                    required
                                  />
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="defaultSelect">Sex: </label>
                                  <select
                                    class="form-select form-control"
                                    id="sex"
                                    name="sex"
                                    >
                                    <option value="" disabled selected>Select Sex</option>
                                    <option value="Female">FEMALE</option>
                                    <option value="Male">MALE</option>
                                  </select>
                                </div>
                              </div>

                            </div>

                            <div class="row">

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="lname">Student Last Name: </label>
                                  <input
                                    id="lname"
                                    name="lname"
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
                                    id="fname"
                                    name="fname"
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
                                    id="mname"
                                    name="mname"
                                    class="form-control"
                                    placeholder="Mendoza"
                                  />
                                </div>
                              </div>

                              
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="lname">Birthday: </label>
                                  <input
                                    id="bday"
                                    name="bday"
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
                                    id="email"
                                    name="email"
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
                                id="contact"
                                name="cont"
                                class="form-control"
                                placeholder="Philippines [+ 639]"
                                required
                              />
                            </div>
                          </div>
                          <div class="col-md-6 p-5 row">
                            <?php
                              include_once '../model/fetch.php';
                              $programs = getPrograms();
                              $years = getYear();
                              $sections = getsection();
                              ?>
                            <div class="form-group">
                              <label for="defaultSelect">Year Level: </label>
                              <select
                                class="form-select form-control text-center"
                                id="year"
                                name="year"
                                required
                                >
                                <option value="" disabled selected>Select Year Level</option>
                                <?php
                                  if($years):
                                    foreach($years as $yr):
                                  ?>
                                  <option value="<?= $yr['year_level_id'] ?>"><?= strtoupper($yr['year_level_name']) ?> YEAR</option>
                                <?php endforeach; else: ?>
                                  <option disabled>No Year Level Available</option>
                                <?php endif ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="defaultSelect">Program: </label>
                              <select
                                class="form-select form-control text-center"
                                id="prog"
                                name="prog"
                                required
                                >
                                  <option value="" disabled selected>Select Program</option>
                                <?php
                                  if($programs):
                                    foreach($programs as $pr):
                                  ?>
                                  <option value="<?= $pr['program_id'] ?>"><?= strtoupper($pr['program_code']) ?></option>
                                <?php endforeach; else: ?>
                                  <option disabled>No Program Available</option>
                                <?php endif; ?>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="defaultSelect">Section: </label>
                                <select
                                  class="form-select form-control text-center"
                                  id="sec"
                                  name="sec"
                                  required
                                  >
                                  <option value="" disabled selected>Select Section</option>
                                  <?php
                                    if($sections):
                                      foreach($sections as $sec):
                                    ?>
                                    <option value="<?= $sec['section_id'] ?>"><?= strtoupper($sec['section_name']) ?></option>
                                  <?php endforeach; else: ?>
                                    <option disabled>No Sections Available</option>
                                  <?php endif; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="defaultSelect">Status: </label>
                                <select
                                  class="form-select form-control text-center"
                                  id="status"
                                  name="status"
                                  required
                                  >
                                  <option value="" disabled selected>Select Status</option>
                                  <option value="Active">Regular</option>
                                  <option value="Irregular">Irregular</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card-footer p-3">
                          <input type="submit" name="addStudent" class="btn btn-success float-end mb-3">
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