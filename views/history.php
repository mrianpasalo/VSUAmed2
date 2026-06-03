<?php
ob_start();
require_once '../model/connector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete_visit_id'])) {
    $visit_id = intval($_POST['delete_visit_id']);

    // Delete prescription first (child), then visit (parent)
    $stmt = $conn->prepare("DELETE FROM prescription WHERE visit_id = ?");
    $stmt->bind_param("i", $visit_id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM visits WHERE visit_id = ?");
    $stmt->bind_param("i", $visit_id);
    $stmt->execute();

    ob_end_clean();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<?php include 'inc/header.php' ?>
 
<!-- Print PDF Styles -->
<link rel="stylesheet" href="../assets/css/pdfprint.css" />
 
<!-- Hidden print area populated dynamically -->
<div id="print-area">
  <div class="print-doc">
    <div class="print-header">
      <img src="../assets/img/vsum.png" alt="VSU Seal" crossorigin="anonymous">
      <div class="print-header-text">
        <p class="republic">Republic of the Philippines</p>
        <p class="university">Visayas State University</p>
        <p class="campus">Alang-Alang Campus</p>
        <p class="clinic">University Health Services &amp; Clinic</p>
      </div>
    </div>
 
    <div class="print-sub-header">
      <span>Alang-Alang, Leyte</span>
      <span id="prt-datetime"></span>
      <span>Visit Record / Patient Slip</span>
    </div>
 
    <div class="print-form-title">Clinic Visit Record</div>
 
    <div class="print-section">
      <div class="print-section-title">Patient Information</div>
      <div class="print-row">
        <div class="print-field">
          <span class="print-label">Full Name:</span>
          <span class="print-value full" id="prt-name"></span>
        </div>
        <div class="print-field" style="max-width:220px;">
          <span class="print-label">Student No.:</span>
          <span class="print-value" id="prt-studno"></span>
        </div>
      </div>
      <div class="print-row">
        <div class="print-field">
          <span class="print-label">Date &amp; Time:</span>
          <span class="print-value" id="prt-date"></span>
        </div>
      </div>
    </div>
 
    <div class="print-section">
      <div class="print-section-title">Clinical Findings</div>
      <div class="print-row">
        <div class="print-field">
          <span class="print-label">Complaint:</span>
          <span class="print-value full" id="prt-complaint"></span>
        </div>
      </div>
      <div class="print-row">
        <div class="print-field">
          <span class="print-label">Diagnosis:</span>
          <span class="print-value full" id="prt-diagnosis"></span>
        </div>
      </div>
    </div>
 
    <div class="rx-box">
      <span class="rx-symbol">℞</span>
      <div class="rx-grid">
        <div class="print-field">
          <span class="print-label">Medicine:</span>
          <span class="print-value" id="prt-medicine"></span>
        </div>
        <div class="print-field">
          <span class="print-label">Dosage:</span>
          <span class="print-value" id="prt-dosage"></span>
        </div>
        <div class="print-field">
          <span class="print-label">Duration:</span>
          <span class="print-value" id="prt-duration"></span>
        </div>
      </div>
    </div>
 
    <div class="print-notes-box">
      <div class="notes-label">Instructions</div>
      <div id="prt-instructions"></div>
    </div>
 
    <div class="print-notes-box">
      <div class="notes-label">Nurse's Notes</div>
      <div id="prt-notes"></div>
    </div>
 
    <div class="print-footer">
      <div class="print-stamp-area">Clinic<br>Stamp</div>
      <div class="print-sig-block">
        <div class="print-sig-line"></div>
        <div class="print-sig-name" id="prt-nurse"></div>
        <div class="print-sig-role">Nurse on Duty</div>
      </div>
    </div>
 
    <div class="print-doc-footer">
      <span>VSU Alang-Alang Health Services</span>
      <span>This document is for official use only.</span>
      <span id="prt-footer-date"></span>
    </div>
  </div>
</div>
 
<div class="wrapper">
  <?php include 'inc/sidebar.php'; ?>
 
  <div class="main-panel">
    <div class="main-header">
      <?php include 'inc/logo.php' ?>
      <?php include 'inc/navbar.php' ?>
    </div>
 
    <div class="container">
      <div class="page-inner">
        <div class="card p-5">
          <table id="basic-datatables" class="display table table-striped table-hover">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Student Number</th>
                <th>Diagnosis</th>
                <th>Date Time</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $history = getVisitHistory();
                if ($history):
                  $n = 1;
                  foreach ($history as $h):
              ?>
              <tr data-bs-toggle="modal" data-bs-target="#visitModal<?= $h['visit_id'] ?>" style="cursor:pointer;">
                <td class="text-end"><?= $n++ . ".)" ?></td>
                <td class="text-center"><?= $h['student_number'] ?></td>
                <td><?= $h['diagnosis'] ?></td>
                <td class="text-center"><?= date("F d, Y - g:i A", strtotime($h['created_at'])) ?></td>
              </tr>
 
              <!-- Visit Detail Modal -->
              <div class="modal fade" id="visitModal<?= $h['visit_id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body p-5">
                      <div class="text-center mb-4">
                        <h4 class="mb-1"><?= ucwords($h['last_name'] . ", " . $h['first_name'] . " " . $h['middle_name'][0] . ".") ?></h4>
                        <small><?= date("F d, Y - g:i A", strtotime($h['created_at'])) ?></small>
                      </div>
                      <hr>
                      <div class="mb-4 row">
                        <div class="col-md-6 text-center">
                          <div class="mb-3">
                            <strong>Complaint:</strong>
                            <p class="mb-0"><?= $h['complaint'] ?></p>
                          </div>
                          <div class="mb-3">
                            <strong>Diagnosis:</strong>
                            <p class="mb-0"><?= $h['diagnosis'] ?></p>
                          </div>
                        </div>
                        <div class="col-md-6 text-center border-start">
                          <div class="mb-3">
                            <strong>Medicine:</strong>
                            <p class="mb-0"><?= $h['medicine_name'] . " " . $h['dosage'] ?></p>
                          </div>
                          <div class="mb-3">
                            <strong>Duration:</strong>
                            <p class="mb-0"><?= $h['duration'] ?></p>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="mx-4">
                        <strong>Instructions:</strong>
                        <p class="mx-4"><?= $h['instructions'] ?></p>
                      </div>
                      <div class="mx-4">
                        <strong>Notes:</strong>
                        <p class="mx-4"><?= $h['notes'] ?></p>
                      </div>
                      <div class="text-end mt-4">
                        <strong>Nurse:</strong>
                        <p class="mb-0"><?= $h['fulll_name'] ?></p>
                      </div>
                    </div>
 
                    <div class="modal-footer">
                      <!-- Print PDF Button -->
                      <button
                        type="button"
                        class="btn btn-primary btn-print-pdf"
                        data-name="<?= htmlspecialchars(ucwords($h['last_name'] . ', ' . $h['first_name'] . ' ' . $h['middle_name'][0] . '.'), ENT_QUOTES) ?>"
                        data-studno="<?= htmlspecialchars($h['student_number'], ENT_QUOTES) ?>"
                        data-datetime="<?= htmlspecialchars(date('F d, Y - g:i A', strtotime($h['created_at'])), ENT_QUOTES) ?>"
                        data-complaint="<?= htmlspecialchars($h['complaint'], ENT_QUOTES) ?>"
                        data-diagnosis="<?= htmlspecialchars($h['diagnosis'], ENT_QUOTES) ?>"
                        data-medicine="<?= htmlspecialchars($h['medicine_name'], ENT_QUOTES) ?>"
                        data-dosage="<?= htmlspecialchars($h['dosage'], ENT_QUOTES) ?>"
                        data-duration="<?= htmlspecialchars($h['duration'], ENT_QUOTES) ?>"
                        data-instructions="<?= htmlspecialchars($h['instructions'], ENT_QUOTES) ?>"
                        data-notes="<?= htmlspecialchars($h['notes'], ENT_QUOTES) ?>"
                        data-nurse="<?= htmlspecialchars($h['fulll_name'], ENT_QUOTES) ?>"
                      >
                        <i class="fas fa-print me-1"></i> Print PDF
                      </button>
 
                      <!-- Delete Button -->
                      <form method="POST" onsubmit="return confirm('Are you sure you want to delete this visit record? This cannot be undone.');">
                        <input type="hidden" name="delete_visit_id" value="<?= $h['visit_id'] ?>">
                        <button type="submit" class="btn btn-danger">
                          <i class="fas fa-trash me-1"></i> Delete
                        </button>
                      </form>
 
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
 
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
 
<?php include 'inc/footer.php' ?>
 
<script src="../assets/js/pdf.js"></script>