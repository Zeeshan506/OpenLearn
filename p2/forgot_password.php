<?php
include 'connection.php';

if (isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($conn, $_POST['email']);

   // Check if the email exists in the database
   $sql = "SELECT * FROM users WHERE email = '$email'";
   $result = mysqli_query($conn, $sql);
   $row = mysqli_fetch_assoc($result);

   if ($row) {
      $token = bin2hex(random_bytes(50)); // Generate a unique token
      $sql = "UPDATE users SET reset_token = '$token', token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = '$email'";
      mysqli_query($conn, $sql);
      $reset_link = "http://localhost/reset_password.php?token=$token";

      $subject = "Password Reset";
      $message = "Click here to reset your password: $reset_link";
      $headers = "From: zeeshanazhar506@gmail.com"; // Replace with your email address

      // Send the email
      if (mail($email, $subject, $message, $headers)) {
         echo "Password reset link has been sent to your email.";
      } else {
         echo "Error sending email. Please try again later.";
      }
     
   } else {
      $error = "Email not found.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>
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
      <form action="forgot_password.php" method="post">
         <h3>Forgot Password</h3>
         <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
         <?php endif; ?>
         <p>Your Email <span>*</span></p>
         <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
         <input type="submit" value="Send Reset Link" name="submit" class="btn">
         <p>Remember your password? <a href="index.php">Login now</a></p>
      </form>
   </section>

   <footer class="footer">
      &copy; copyright @ 2024 by <span>01-134221-080</span> | all rights reserved!
   </footer>

   <!-- Custom JS File Link -->
   <script src="js/script.js"></script>

</body>

</html>