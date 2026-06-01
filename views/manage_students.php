<?php 
include 'inc/header.php';

$msg = $_SESSION['msg'] ?? null;
$isSuccess = $msg && $msg['type'] === 'success';
unset($_SESSION['msg']);
?>
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
        <?php if ($msg): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('messageModal')).show();
});
</script>
<?php endif; ?>

        <!---------------------------------Content------------------------------------->

        <div class="container">
          <div class="page-inner p-5">


            <!----------------------------Edit Here------------------------------------>
        <div class="modal fade" id="messageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">

      <div class="modal-header px-4 pt-4 pb-3">

        <div class="rounded-circle d-flex justify-content-center align-items-center"
          style="width:40px;height:40px;background:<?= $isSuccess ? '#d1fae5' : '#fee2e2' ?>;">

          <?php if ($isSuccess): ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
              <path d="M5 13l4 4L19 7"/>
            </svg>
          <?php else: ?>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
              <path d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
            </svg>
          <?php endif; ?>

        </div>

        <div class="ms-3">
          <h6 class="mb-0 fw-semibold">
            <?= $isSuccess ? 'Success' : 'Error' ?>
          </h6>
          <small class="text-muted">
            <?= $isSuccess ? 'Operation completed.' : 'Please check details.' ?>
          </small>
        </div>

        <button class="btn-close ms-auto" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body px-4 py-3">
        <?= $msg['text'] ?? '' ?>
      </div>

      <div class="modal-footer border-0 px-4 pb-4">
        <button class="btn btn-sm <?= $isSuccess ? 'btn-success' : 'btn-danger' ?>" data-bs-dismiss="modal">
          OK
        </button>
      </div>

    </div>
  </div>
</div>      
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
                                  <td class="text-center"><?= ucwords($res['year_level_name'] . " - ") . strtoupper($res['program_code'])?></td>
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
                        <p class="text-center text-danger" style="font-family: 'Roboto', sans-serif;">* Note: Only enrolled students can be searched in the system."</p>
                        <p class="text-center" style="font-family: 'Roboto', sans-serif;">"Search. Find. Care."</p>
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

                            <!-- Student Number -->
                              <div class="col-md-7">
                                <div class="form-group">
                                  <label for="sn">Student Number: </label>
                                  <input
                                    id="sn"
                                    class="form-control"
                                    name="num"
                                    placeholder="00-0-00000"
                                    required
                                  />
                                </div>
                              </div>

                            <!-- FIXED: Sex Dropdown -->
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="sex">Sex: </label>
                                  <select
                                    class="form-select form-control w-100"
                                    id="sex"
                                    name="sex"
                                    style="min-width: 140px;"
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
                                    placeholder="Last name"
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
                                    placeholder="First name"
                                    required
                                  />
                                </div>
                              </div>

                            </div>

                            <div class="row">

                              <div class="col-md-7">
                                <div class="form-group">
                                  <label for="lname">Student Middle Name: </label>
                                  <input
                                    id="mname"
                                    name="mname"
                                    class="form-control"
                                    placeholder="Middle name"
                                  />
                                </div>
                              </div>

                              
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="bday">Birthday: </label>
                                  <input
                                    id="bday"
                                    name="bday"
                                    class="form-control"
                                    type="date"
                                    required
                                  />
                                </div>
                              </div>
                              
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="email">Email: </label>
                                  <input
                                    id="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="email@gmail.com"
                                    required
                                  />
                                </div>
                              </div>
                              
                              <div class="form-group col-md-6">
                                <label for="contact">Contact Number: </label>
                                <input
                                  id="contact"
                                  name="cont"
                                  class="form-control"
                                  placeholder="Philippines [+ 639]"
                                  required
                                />
                              </div>

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
                              <label for="year">Year Level: </label>
                              <select
                                class="form-select form-control text-center w-100"
                                id="year"
                                name="year"
                                required
                                style="min-width: 160px;"
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
                              <label for="prog">Program: </label>
                              <select
                                class="form-select form-control text-center w-100"
                                id="prog"
                                name="prog"
                                required
                                style="min-width: 160px;"
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

                            <!-- FIXED: Section Dropdown -->
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="sec">Section: </label>
                                <select
                                  class="form-select form-control text-center w-100"
                                  id="sec"
                                  name="sec"
                                  required
                                  style="min-width: 130px;"
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

                            <!-- FIXED: Status Dropdown -->
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="status">Status: </label>
                                <select
                                  class="form-select form-control text-center w-100"
                                  id="status"
                                  name="status"
                                  required
                                  style="min-width: 130px;"
                                  >
                                  <option value="" disabled selected>Select Status</option>
                                  <option value="Active">REGULAR</option>
                                  <option value="Irregular">IRREGULAR</option>
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