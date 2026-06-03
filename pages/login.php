<?php
    require_once '../model/connector.php';
    require_once '../model/login.php';
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST["login"])) {
            $username = $_POST['user'];
            $password = $_POST['password'];
            $user = getUser($conn, $username, $password);
            if($user){
                $_SESSION['name'] = $user['fulll_name'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['staff_id'];
                header("Location: ../views/dashboard.php");
            } else {
                $_SESSION['login_error'] = "Invalid username or password.";
                header("Location: ../views/login.php");
            }
        }
    }
?>