<?php include 'inc/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
$msg = $_SESSION['msg'] ?? null;
$isSuccess = $msg && $msg['type'] === 'success';
?>

<?php if ($msg): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('messageModal'));
    modal.show();
});
</script>
<?php endif; ?>

<div class="modal fade" id="messageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm rounded-4 overflow-hidden">

      <div class="modal-header border-bottom px-4 pt-4 pb-3 align-items-start gap-3">

        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
          style="width:40px; height:40px; background-color: <?= $isSuccess ? '#d1fae5' : '#fee2e2' ?>;">

          <?php if ($isSuccess): ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
              viewBox="0 0 24 24" stroke="#059669" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
          <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
              viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
            </svg>
          <?php endif; ?>

        </div>

        <div>
          <h6 class="mb-0 fw-semibold">
            <?= $isSuccess ? 'Saved successfully' : 'Something went wrong' ?>
          </h6>
          <small class="text-muted">
            <?= $isSuccess ? 'The medical record has been added.' : 'Please review the details below.' ?>
          </small>
        </div>

        <button type="button" class="btn-close ms-auto mt-1" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body px-4 py-3 text-muted" style="font-size: 0.9rem;">
        <?= $msg['text'] ?? '' ?>
      </div>

      <div class="modal-footer border-0 px-4 pb-4 pt-0">
        <button type="button"
          class="btn btn-sm <?= $isSuccess ? 'btn-success' : 'btn-danger' ?> px-4"
          data-bs-dismiss="modal">
          OK
        </button>
      </div>

    </div>
  </div>
</div>

<?php unset($_SESSION['msg']); ?>

<!-- FORM -->
<div class="wrapper">

  <?php include 'inc/sidebar.php'; ?>

  <div class="main-panel">

    <div class="main-header">
      <?php include 'inc/logo.php'; ?>
      <?php include 'inc/navbar.php'; ?>
    </div>

    <div class="container">
      <div class="page-inner">

        <div class="card p-4 col-md-9 mx-auto">
          <form action="../pages/record.php" method="POST">

            <div class="card-header">
              <div class="card-title">New Medical Record</div>
            </div>

            <div class="card-body row">

              <div class="form-group col-md-6">
                <label>Student Number:</label>
                <input type="text" class="form-control" name="stud_number" required>
              </div>

              <input type="hidden" name="staff" value="<?= $_SESSION['id'] ?? '' ?>">

              <div class="form-group col-md-6">
                <label>Complaint:</label>
                <input type="text" class="form-control" name="complaint" required>
              </div>

              <div class="form-group col-md-6">
                <label>Diagnosis:</label>
                <input type="text" class="form-control" name="diag" required>
              </div>

              <div class="form-group col-md-4">
                <label>Medicine:</label>
                <input type="text" name="med" class="form-control" required>
              </div>

              <div class="form-group col-md-4">
                <label>Dosage:</label>
                <input type="text" name="dose" class="form-control" required>
              </div>

              <div class="form-group col-md-4">
                <label>Duration:</label>
                <input type="text" name="dur" class="form-control" required>
              </div>

              <div class="form-group col-md-6">
                <label>Instructions:</label>
                <textarea class="form-control" name="ins" required></textarea>
              </div>

              <div class="form-group col-md-6">
                <label>Note:</label>
                <textarea class="form-control" name="note" required></textarea>
              </div>

            </div>

            <div class="card-footer">
              <input type="submit" name="addRecord" class="btn btn-success float-end">
            </div>

          </form>
        </div>

      </div>
    </div>

  </div>
</div>

<?php include 'inc/footer.php'; ?>