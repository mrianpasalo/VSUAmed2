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
<style>
  @media print {
    body * { visibility: hidden !important; }
    #print-area, #print-area * { visibility: visible !important; }
    #print-area {
      position: fixed;
      inset: 0;
      width: 100%;
      padding: 0;
      margin: 0;
      background: #fff;
    }
  }
 
  #print-area {
    display: none;
    font-family: 'Georgia', serif;
    color: #1a1a1a;
    background: #fff;
  }
 
  .print-doc {
    width: 794px;
    min-height: 1123px;
    margin: 0 auto;
    padding: 48px 56px 40px;
    background: #fff;
    box-sizing: border-box;
    position: relative;
  }
 
  .print-header {
    display: flex;
    align-items: center;
    gap: 20px;
    border-bottom: 3px solid #1a3a5c;
    padding-bottom: 16px;
    margin-bottom: 8px;
  }
 
  .print-header img {
    width: 80px;
    height: 80px;
    object-fit: contain;
  }
 
  .print-header-text {
    flex: 1;
    text-align: center;
  }
 
  .print-header-text .republic {
    font-size: 10px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #555;
    margin: 0;
  }
 
  .print-header-text .university {
    font-size: 20px;
    font-weight: 700;
    color: #1a3a5c;
    margin: 2px 0;
    letter-spacing: 0.5px;
  }
 
  .print-header-text .campus {
    font-size: 13px;
    color: #2e6da4;
    margin: 0;
    letter-spacing: 0.3px;
  }
 
  .print-header-text .clinic {
    font-size: 11px;
    color: #555;
    margin: 4px 0 0;
    font-style: italic;
  }
 
  .print-sub-header {
    display: flex;
    justify-content: space-between;
    font-size: 10.5px;
    color: #444;
    margin-bottom: 20px;
    padding-top: 6px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 6px;
  }
 
  .print-form-title {
    text-align: center;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #1a3a5c;
    margin: 18px 0 20px;
    border: 1px solid #1a3a5c;
    padding: 7px 0;
    border-left: none;
    border-right: none;
  }
 
  .print-section {
    margin-bottom: 18px;
  }
 
  .print-section-title {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #2e6da4;
    font-weight: 700;
    margin-bottom: 8px;
    border-bottom: 0.5px solid #c0d4e8;
    padding-bottom: 4px;
  }
 
  .print-row {
    display: flex;
    gap: 0;
    margin-bottom: 6px;
    font-size: 12px;
  }
 
  .print-field {
    flex: 1;
    display: flex;
    gap: 6px;
    align-items: baseline;
  }
 
  .print-label {
    font-size: 10.5px;
    color: #555;
    white-space: nowrap;
    min-width: 100px;
  }
 
  .print-value {
    font-size: 12.5px;
    font-weight: 600;
    color: #1a1a1a;
    border-bottom: 0.5px dotted #aaa;
    flex: 1;
    padding-bottom: 1px;
    min-width: 0;
  }
 
  .print-value.full { flex: 1; }
 
  .rx-box {
    border: 1.5px solid #1a3a5c;
    border-radius: 4px;
    padding: 16px 20px;
    margin: 18px 0;
    position: relative;
  }
 
  .rx-symbol {
    position: absolute;
    top: -1px;
    left: 14px;
    background: #fff;
    padding: 0 6px;
    font-size: 18px;
    font-weight: 700;
    color: #1a3a5c;
    font-style: italic;
  }
 
  .rx-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 24px;
    margin-top: 6px;
  }
 
  .print-notes-box {
    background: #f7f9fc;
    border: 0.5px solid #c0d4e8;
    border-radius: 4px;
    padding: 12px 16px;
    font-size: 12px;
    line-height: 1.7;
    margin-bottom: 14px;
  }
 
  .print-notes-box .notes-label {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: #2e6da4;
    font-weight: 700;
    margin-bottom: 5px;
  }
 
  .print-footer {
    margin-top: 36px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
 
  .print-sig-block {
    text-align: center;
    width: 200px;
  }
 
  .print-sig-line {
    border-top: 1px solid #333;
    margin-bottom: 4px;
    width: 100%;
  }
 
  .print-sig-name {
    font-size: 12px;
    font-weight: 600;
    color: #1a1a1a;
  }
 
  .print-sig-role {
    font-size: 10px;
    color: #666;
  }
 
  .print-stamp-area {
    width: 120px;
    height: 80px;
    border: 0.5px dashed #bbb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #bbb;
    font-size: 9.5px;
    text-align: center;
    border-radius: 2px;
  }
 
  .print-doc-footer {
    margin-top: 28px;
    padding-top: 8px;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    font-size: 9px;
    color: #888;
  }
</style>
 
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
 
<script>
  document.querySelectorAll('.btn-print-pdf').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var d = this.dataset;
      document.getElementById('prt-name').textContent         = d.name;
      document.getElementById('prt-studno').textContent       = d.studno;
      document.getElementById('prt-date').textContent         = d.datetime;
      document.getElementById('prt-complaint').textContent    = d.complaint;
      document.getElementById('prt-diagnosis').textContent    = d.diagnosis;
      document.getElementById('prt-medicine').textContent     = d.medicine;
      document.getElementById('prt-dosage').textContent       = d.dosage;
      document.getElementById('prt-duration').textContent     = d.duration;
      document.getElementById('prt-instructions').textContent = d.instructions;
      document.getElementById('prt-notes').textContent        = d.notes;
      document.getElementById('prt-nurse').textContent        = d.nurse;
      document.getElementById('prt-datetime').textContent     = d.datetime;
      document.getElementById('prt-footer-date').textContent  = 'Printed: ' + new Date().toLocaleString();
      document.getElementById('print-area').style.display = 'block';
      window.print();
      document.getElementById('print-area').style.display = 'none';
    });
  });
</script>