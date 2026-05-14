<?php
    require_once '../model/students.php';
    require_once '../model/connector.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {

        if(isset($_POST['addStudent'])){
            $add = addStdnt($conn, $_POST);
        
        }

        
        if(isset($_POST['searchStud'])){
            $search = search($conn, $_POST);
            if(!empty($search)){
                $_SESSION['search_res'] = $search;
            }else{
                $_SESSION['search_error'] = "error";
            }
            header("Location: ../views/manage_students.php?page=SearchStudent");
            exit();
        }

    }

?>