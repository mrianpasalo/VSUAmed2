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