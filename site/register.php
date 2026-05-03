<?php

session_start();
@include 'config.php';

// Redirect already logged-in users
if(isset($_SESSION['user_id'])){
   header('location:products.php');
   exit();
}

$errors = [];

if(isset($_POST['register'])){
   $username = strtolower(trim($_POST['username']));
   $password = $_POST['password'];
   $confirm  = $_POST['confirm_password'];

   if(empty($username))          $errors[] = 'username is required';
   if(strlen($username) < 3)     $errors[] = 'username must be at least 3 characters';
   if(empty($password))          $errors[] = 'password is required';
   if(strlen($password) < 6)     $errors[] = 'password must be at least 6 characters';
   if($password !== $confirm)    $errors[] = 'passwords do not match';

   if(empty($errors)){
      // Check username is unique
      $stmt = $conn->prepare("SELECT id FROM `users` WHERE username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->store_result();

      if($stmt->num_rows > 0){
         $errors[] = 'username already taken, choose another';
      } else {
         $hashed = password_hash($password, PASSWORD_DEFAULT);
         $role   = 'user'; // new registrations are always regular users

         $insert = $conn->prepare("INSERT INTO `users`(username, password, role) VALUES(?, ?, ?)");
         $insert->bind_param("sss", $username, $hashed, $role);

         if($insert->execute()){
            // Auto-login after registration
            $_SESSION['user_id']   = $insert->insert_id;
            $_SESSION['username']  = $username;
            $_SESSION['user_role'] = $role;
            header('location:products.php');
            exit();
         } else {
            $errors[] = 'registration failed, please try again';
         }
      }
   }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register – foodies</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      body{ background-color: var(--bg-color); display:flex; align-items:center; justify-content:center; min-height:100vh; }
      .login-wrap{ background:var(--white); border-radius:.5rem; padding:3rem; width:40rem; box-shadow:var(--box-shadow); }
      .login-wrap .brand{ text-align:center; font-size:3rem; color:var(--blue); font-weight:600; margin-bottom:.5rem; }
      .login-wrap h2{ text-align:center; font-size:2rem; color:var(--black); margin-bottom:2rem; font-weight:400; }
      .login-wrap .field{ position:relative; margin-bottom:1.5rem; }
      .login-wrap .field i{ position:absolute; top:50%; left:1.4rem; transform:translateY(-50%); color:#999; font-size:1.6rem; }
      .login-wrap .field input{ width:100%; padding:1.2rem 1.4rem 1.2rem 4rem; font-size:1.7rem; border-radius:.5rem; border:var(--border); background:var(--bg-color); color:var(--black); }
      .login-wrap .field input:focus{ border-color:var(--blue); }
      .login-wrap .btn{ margin-top:.5rem; }
      .login-wrap .login-link{ text-align:center; font-size:1.5rem; margin-top:1.5rem; color:#666; }
      .login-wrap .login-link a{ color:var(--blue); }
      .error-list{ background:#ffe0e0; border-radius:.5rem; padding:1rem 1.5rem; margin-bottom:1.5rem; list-style:none; }
      .error-list li{ font-size:1.5rem; color:var(--red); padding:.3rem 0; }
      .error-list li::before{ content:"✕ "; }
   </style>
</head>
<body>

<div class="login-wrap">
   <div class="brand">foodies</div>
   <h2>create an account</h2>

   <?php if(!empty($errors)): ?>
   <ul class="error-list">
      <?php foreach($errors as $e): ?>
         <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
   </ul>
   <?php endif; ?>

   <form action="" method="post">
      <div class="field">
         <i class="fas fa-user"></i>
         <input type="text" name="username" placeholder="choose a username"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
      </div>
      <div class="field">
         <i class="fas fa-lock"></i>
         <input type="password" name="password" placeholder="create a password" required>
      </div>
      <div class="field">
         <i class="fas fa-check-circle"></i>
         <input type="password" name="confirm_password" placeholder="confirm your password" required>
      </div>
      <input type="submit" name="register" value="register" class="btn">
   </form>

   <p class="login-link">already have an account? <a href="login.php">login here</a></p>
</div>

</body>
</html>
