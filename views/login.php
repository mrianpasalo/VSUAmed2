<?php
    session_start();
    if(isset($_SESSION['name'])){
        header("Location: dashboard.php");
    }
    $error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>School Clinic Login</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>

  <div class="container">

    <!-- LEFT -->
    <div class="left">
      <img src="https://www.vsu.edu.ph/images/VSU_Seal_2022.png" alt="VSU Logo" class="logo" />
    </div>

    <!-- RIGHT -->
    <div class="right">
      <div class="login-box">
        <h2>School Clinic Login</h2>
        <form action="../pages/login.php" method="POST">
          <div class="input-group">
            <input type="text" name="user" placeholder="Username" required />
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" required />
          </div>
           <?php if ($error): ?>
  <div class="error-msg"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
          <input type="submit" name="login" value="Login" id="button" />
        </form>
        <div class="footer-text">© 2026 School Clinic System</div>
      </div>
    </div>

  </div>

</body>
</html>