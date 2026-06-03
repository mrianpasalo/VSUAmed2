
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
