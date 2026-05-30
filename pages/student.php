<?php
require_once '../model/students.php';
require_once '../model/connector.php';
session_start();

// Handle DELETE via GET
if (isset($_GET['deleteStudent'])) {
    $id      = (int) $_GET['deleteStudent'];
    $program = $_GET['program'] ?? '';
    $yr      = $_GET['yr'] ?? '';

    $deleted = deleteStudent($id);

    $_SESSION['msg'] = [
        'type' => $deleted ? 'success' : 'error',
        'text' => $deleted ? 'Student deleted successfully.' : 'Failed to delete student.'
    ];

    header("Location: ../views/medicalrecord.php?program=$program&&yr=$yr");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    if (isset($_POST['addStudent'])) {

        $result = addStdnt($conn, $_POST);

        if ($result === "exists") {
            $_SESSION['msg'] = [
                'type' => 'error',
                'text' => 'Student already exists.'
            ];
        } elseif ($result) {
            $enroll = enrollStud($result, $_POST);
            $_SESSION['msg'] = [
                'type' => $enroll ? 'success' : 'error',
                'text' => $enroll ? 'Student added successfully.' : 'Student added but enrollment failed.'
            ];
        } else {
            $_SESSION['msg'] = [
                'type' => 'error',
                'text' => 'Failed to add student.'
            ];
        }

        header("Location: ../views/manage_students.php?page=AddStudent");
        exit;
    }

    if (isset($_POST['searchStud'])) {

        $prompt = $_POST['search'];
        $search = search($conn, $_POST);

        if (!empty($search)) {
            $_SESSION['search_res'] = $search;
        } else {
            $_SESSION['search_error'] = "error";
        }

        header("Location: ../views/manage_students.php?pages=SearchStudent&&search=" . $prompt);
        exit;
    }

    if (isset($_POST['editStudent'])) {

        $updated = updateStudent($_POST);

        $_SESSION['msg'] = [
            'type' => $updated ? 'success' : 'error',
            'text' => $updated ? 'Student updated successfully.' : 'Failed to update student.'
        ];

        $program = $_POST['program'] ?? '';
        $yr      = $_POST['yr'] ?? '';
        $student = $_POST['student_id'] ?? '';

        header("Location: ../views/medicalrecord.php?program=$program&&yr=$yr&&student=$student");
        exit;
    }

}
?>