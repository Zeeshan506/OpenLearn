<?php
include 'connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $sql = "SELECT * FROM users WHERE reset_token = '$token' AND token_expiry > NOW()";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if (isset($_POST['submit'])) {
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $sql = "UPDATE users SET password = '$hashed_password', reset_token = NULL, token_expiry = NULL WHERE reset_token = '$token'";
                mysqli_query($conn, $sql);

                echo "Password has been successfully reset. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Passwords do not match.";
            }
        }
    } else {
        echo "Invalid or expired token.";
        exit();
    }
} else {
    echo "No token provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="header">
   <section class="flex">
      <a href="home.html" class="logo">openLearn</a>
      <form action="search.html" method="post" class="search-form" style="display: none;">
         <input type="text" name="search_box" required placeholder="search courses..." maxlength="100">
         <button type="submit" class="fas fa-search"></button>
      </form>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>
      <div class="profile" style="display: none;">
         <img src="images/pic-1.jpg" class="image" alt="">
         <h3 class="name">shaikh anas</h3>
         <p class="role">student</p>
         <a href="profile.html" class="btn">view profile</a>
         <div class="flex-btn">
            <a href="login.html" class="option-btn">login</a>
            <a href="register.html" class="option-btn">register</a>
         </div>
      </div>
   </section>
</header>   

<div class="side-bar">
   <div id="close-btn">
      <i class="fas fa-times"></i>
   </div>
   <div class="profile" style="display: none;">
      <img src="images/pic-1.jpg" class="image" alt="">
      <h3 class="name">shaikh anas</h3>
      <p class="role">student</p>
      <a href="profile.html" class="btn">view profile</a>
   </div>
   <nav class="navbar" style="display: none;">
      <a href="home.html"><i class="fas fa-home"></i><span>home</span></a>
      <a href="about.html"><i class="fas fa-question"></i><span>about</span></a>
      <a href="courses.html"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
      <a href="teachers.html"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
      <a href="contact.html"><i class="fas fa-headset"></i><span>contact us</span></a>
      <a href="blog.html"><i class="fas fa-blog"></i><span>Blog</span></a>
   </nav>
</div>

<section class="form-container">
   <form action="reset_password.php?token=<?php echo $token; ?>" method="post">
      <h3>Reset Password</h3>
      <?php if (isset($error)): ?>
         <p class="error"><?php echo $error; ?></p>
      <?php endif; ?>
      <p>New Password <span>*</span></p>
      <input type="password" name="new_password" placeholder="Enter new password" required maxlength="20" class="box">
      <p>Confirm Password <span>*</span></p>
      <input type="password" name="confirm_password" placeholder="Confirm new password" required maxlength="20" class="box">
      <input type="submit" value="Reset Password" name="submit" class="btn">
   </form>
</section>

<footer class="footer">
   &copy; copyright @ 2024 by <span>01-134221-080</span> | all rights reserved!
</footer>

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
