<?php
if(session_status() === PHP_SESSION_NONE){ session_start(); }
?>
<header class="header">

   <div class="flex">

      <a href="products.php" class="logo">foodies</a>

      <nav class="navbar">
         <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="admin.php"><i class="fas fa-cog"></i> admin panel</a>
         <?php endif; ?>
         <a href="products.php">view products</a>
      </nav>

      <?php
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);
      ?>

      <a href="cart.php" class="cart">cart <span><?php echo $row_count; ?></span></a>

      <?php if(isset($_SESSION['username'])): ?>
         <span class="user-info">
            <i class="fas fa-user-circle"></i>
            <?php echo htmlspecialchars($_SESSION['username']); ?>
         </span>
         <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> logout</a>
      <?php else: ?>
         <a href="login.php" class="logout-btn"><i class="fas fa-sign-in-alt"></i> login</a>
      <?php endif; ?>

      <div id="menu-btn" class="fas fa-bars"></div>

   </div>

</header>
