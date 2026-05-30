<?php
require_once '../model/students.php';
require_once '../model/connector.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    if (isset($_POST['addRecord'])) {

        $stud = getStudentByNumber($_POST);

        if ($stud) {

            $v_id = addVisitInfo($stud, $_POST);
            $add = addPrescriptInfo($v_id, $_POST);

            if ($add) {
                $_SESSION['msg'] = [
                    'type' => 'success',
                    'text' => 'Record Added Successfully'
                ];
            } else {
                $_SESSION['msg'] = [
                    'type' => 'error',
                    'text' => 'Failed to add record.'
                ];
            }

        } else {
            $_SESSION['msg'] = [
                'type' => 'error',
                'text' => 'No Student with number ' . $_POST['stud_number']
            ];
        }

        header('Location: ../views/addRecord.php');
        exit();
    }
}
?>