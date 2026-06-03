<?php include 'inc/header.php' ?>

<?php
  $toast = null;
  if (isset($_SESSION['msg'])) {
      $toast = $_SESSION['msg'];
      unset($_SESSION['msg']);
  }
?>

<div class="wrapper">
  <?php include 'inc/sidebar.php'; ?>

  <div class="main-panel">
    <div class="main-header">
      <?php include 'inc/logo.php' ?>
      <?php include 'inc/navbar.php' ?>
    </div>

    <div class="container">
      <div class="page-inner p-5">

        <!-- Toast -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
          <div id="liveToast" class="toast align-items-center border-0 text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body">
                <?= htmlspecialchars($toast['text'] ?? '') ?>
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8 <?= (isset($_GET['pagess']) && !empty($_GET['pagess'])) ? 'd-none' : '' ?>">
            <div class="card p-5">
              <div class="card-header">
                <?php
                  if (isset($_GET['program']) && isset($_GET['yr'])):
                  include '../model/students.php';
                ?>
                  <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Section</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $pr = $_GET['program'];
                        $yr = $_GET['yr'];
                        $students = getStudentsByYear($pr, $yr);
                        if (!empty($students)):
                          foreach ($students as $stud):
                      ?>
                        <tr>
                          <td><?= strtoupper($stud['section_name']) ?></td>
                          <td>
                            <a href="?program=<?= $pr ?>&&yr=<?= $yr ?>&&student=<?= $stud['student_id'] ?>" style="color:inherit;text-decoration:none;">
                              <?= ucwords($stud['last_name'] . ", " . $stud['first_name'] . " " . $stud['middle_name']) ?>
                            </a>
                          </td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="openEdit(
                              '<?= $stud['student_id'] ?>',
                              '<?= addslashes($stud['last_name']) ?>',
                              '<?= addslashes($stud['first_name']) ?>',
                              '<?= addslashes($stud['middle_name']) ?>',
                              '<?= $stud['sex'] ?>',
                              '<?= $stud['birth_date'] ?>',
                              '<?= $stud['contact_number'] ?>',
                              '<?= $stud['stud_email'] ?>',
                              '<?= $stud['year_level_id'] ?>',
                              '<?= $stud['program_id'] ?>',
                              '<?= $stud['section_id'] ?>',
                              '<?= $stud['status'] ?>'
                            )">
                              <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $stud['student_id'] ?>, '<?= $pr ?>', '<?= $yr ?>')">
                              <i class="fa fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; endif; ?>
                    </tbody>
                  </table>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="<?= (isset($_GET['pagess']) && $_GET['pagess'] == 'addProgram') ? 'col-md-8' : 'col-md-4' ?>">
            <div class="card p-5">
              <?php
                if (!empty($_GET['student'])):
                  $id = $_GET['student'];
                  $stud = getStudentById($id);
              ?>
                <div class="row justify-content-center">
                  <h4 class="text-center">Mini-Medical Record</h4>
                  <hr>
                  <h6>Student Information</h6>
                  <p>
                    <strong style="font-size:13px;">Student No:</strong> <u><?= $stud['student_number'] ?></u><br>
                    <strong style="font-size:13px;">Name:</strong> <u><?= ucwords($stud['last_name'] . ", " . $stud['first_name'] . " " . $stud['middle_name']) ?></u><br>
                    <strong style="font-size:13px;">Birthday:</strong> <u><?= date("F d, Y", strtotime($stud['birth_date'])) ?></u><br>
                    <strong style="font-size:13px;">Sex:</strong> <u><?= strtoupper($stud['sex']) ?></u><br>
                    <strong style="font-size:13px;">Contact #:</strong> <u><?= $stud['contact_number'] ?></u><br>
                    <strong style="font-size:13px;">Email:</strong> <u><?= $stud['stud_email'] ?></u><br>
                    <strong style="font-size:13px;">Year Level:</strong> <u><?= strtoupper($stud['year_level_name']) ?> YEAR</u><br>
                    <strong style="font-size:13px;">Program:</strong> <u><?= strtoupper($stud['program_code']) ?></u><br>
                    <strong style="font-size:13px;">Section:</strong> <u><?= strtoupper($stud['section_name']) ?></u><br>
                    <strong style="font-size:13px;">Student Type:</strong> <u><?= ucwords($stud['status']) ?></u><br>
                  </p>
                  <hr>
                  <h6>Recent Visits</h6>
                  <?php
                    $visit = getRecentVisits($id);
                    if ($visit):
                      foreach ($visit as $vs): ?>
                    <small class="px-5">
                      <?= ucwords($vs['diagnosis']) ?><br>
                      <?= date("F d, Y - g:i A", strtotime($vs['created_at'])) ?>
                    </small>
                  <?php endforeach; else: ?>
                    <small>No Data Found.</small>
                  <?php endif; ?>
                </div>

              <?php elseif (isset($_GET['pagess']) && $_GET['pagess'] == "addProgram"): ?>
                <form action="../pages/program.php" method="POST">
                  <div class="card-header">
                    <div class="card-title">ADD PROGRAM</div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <span class="input-group-text">Program Name: </span>
                        <input type="text" name="prog_name" class="form-control" placeholder="e.g. Bachelor of Science in Information Technology" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <span class="input-group-text">Program Code: </span>
                        <input type="text" name="code" class="form-control" placeholder="e.g. BSIT" required />
                      </div>
                    </div>
                  </div>
                  <div class="card-footer p-3">
                    <input type="submit" name="addProgram" class="btn btn-success float-end mb-3">
                  </div>
                </form>
                <p class="text-center" style="font-size:12px;">Create a new program to organize student records effectively.</p>
                <p class="text-center" style="font-size:12px;">"Add program details to continue managing academic records."</p>

              <?php else: ?>
                <p class="text-center mt-3">
                  "Medicine is not only about treating illness but also about caring
                  for people with compassion, accuracy, and responsibility. Every
                  medical record represents a person's health journey and serves as
                  an important guide in providing proper care and treatment.
                  Maintaining organized and reliable health information helps
                  healthcare professionals make better decisions, improve patient
                  safety, and ensure quality healthcare for everyone."
                </p>
                <p class="text-end">— William Osler</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
              <div class="modal-header px-4 pt-4 pb-3">
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold">Edit Student</h6>
                  <small class="text-muted">Update student information.</small>
                </div>
                <button class="btn-close ms-auto" data-bs-dismiss="modal"></button>
              </div>
              <form action="../pages/student.php" method="POST">
                <div class="modal-body px-4 py-3 row">
                  <input type="hidden" name="student_id" id="edit_id">
                  <input type="hidden" name="program" value="<?= $_GET['program'] ?? '' ?>">
                  <input type="hidden" name="yr" value="<?= $_GET['yr'] ?? '' ?>">

                  <?php
                    include_once '../model/fetch.php';
                    $programs = getPrograms();
                    $years    = getYear();
                    $sections = getsection();
                  ?>

                  <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input type="text" name="lname" id="edit_lname" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input type="text" name="fname" id="edit_fname" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Middle Name</label>
                    <input type="text" name="mname" id="edit_mname" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Sex</label>
                    <select name="sex" id="edit_sex" class="form-control">
                      <option value="Male">MALE</option>
                      <option value="Female">FEMALE</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Birthday</label>
                    <input type="date" name="bday" id="edit_bday" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Contact Number</label>
                    <input type="text" name="cont" id="edit_cont" class="form-control" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Year Level</label>
                    <select name="year" id="edit_year" class="form-control">
                      <?php foreach ($years as $yr): ?>
                        <option value="<?= $yr['year_level_id'] ?>"><?= strtoupper($yr['year_level_name']) ?> YEAR</option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Program</label>
                    <select name="prog" id="edit_prog" class="form-control">
                      <?php foreach ($programs as $pr): ?>
                        <option value="<?= $pr['program_id'] ?>"><?= strtoupper($pr['program_code']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Section</label>
                    <select name="sec" id="edit_sec" class="form-control">
                      <?php foreach ($sections as $sec): ?>
                        <option value="<?= $sec['section_id'] ?>"><?= strtoupper($sec['section_name']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Student Type</label>
                    <select name="student_type" id="edit_student_type" class="form-control">
                      <option value="Regular">REGULAR</option>
                      <option value="Irregular">IRREGULAR</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" name="editStudent" class="btn btn-sm btn-success">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
              <div class="modal-header px-4 pt-4 pb-3">
                <div class="rounded-circle d-flex justify-content-center align-items-center" style="width:40px;height:40px;background:#fee2e2;">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                    <path d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
                  </svg>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold">Delete Student</h6>
                  <small class="text-muted">This action cannot be undone.</small>
                </div>
                <button class="btn-close ms-auto" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body px-4 py-3">
                Are you sure you want to delete this student? All related records will also be removed.
              </div>
              <div class="modal-footer border-0 px-4 pb-4">
                <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-sm btn-danger">Yes, Delete</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function openEdit(id, lname, fname, mname, sex, bday, cont, email, year, prog, sec, student_type) {
  document.getElementById('edit_id').value           = id;
  document.getElementById('edit_lname').value        = lname;
  document.getElementById('edit_fname').value        = fname;
  document.getElementById('edit_mname').value        = mname;
  document.getElementById('edit_sex').value          = sex;
  document.getElementById('edit_bday').value         = bday;
  document.getElementById('edit_cont').value         = cont;
  document.getElementById('edit_email').value        = email;
  document.getElementById('edit_year').value         = year;
  document.getElementById('edit_prog').value         = prog;
  document.getElementById('edit_sec').value          = sec;
  document.getElementById('edit_student_type').value = student_type;
  new bootstrap.Modal(document.getElementById('editModal')).show();
}

function confirmDelete(id, program, yr) {
  document.getElementById('confirmDeleteBtn').href =
    '../pages/student.php?deleteStudent=' + id + '&&program=' + program + '&&yr=' + yr;
  new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<?php if (!empty($toast)): ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('liveToast');
    toastEl.classList.add('<?= $toast['type'] === 'success' ? 'text-bg-success' : 'text-bg-danger' ?>');
    new bootstrap.Toast(toastEl, { delay: 3000 }).show();
  });
</script>
<?php endif; ?>

<?php include 'inc/footer.php' ?>