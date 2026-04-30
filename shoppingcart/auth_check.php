<?php
/**
 * auth_check.php
 * Include this at the top of any page that requires a logged-in user.
 * Usage:
 *   require_once 'auth_check.php';            // any logged-in user
 *   require_once 'auth_check.php'; check_admin(); // admin only
 */

if(session_status() === PHP_SESSION_NONE){
   session_start();
}

function is_logged_in(){
   return isset($_SESSION['user_id']);
}

function is_admin(){
   return is_logged_in() && $_SESSION['user_role'] === 'admin';
}

/** Redirect to login if not authenticated. */
function require_login(){
   if(!is_logged_in()){
      header('location:login.php');
      exit();
   }
}

/** Redirect to products if authenticated but not admin. */
function require_admin(){
   require_login();
   if(!is_admin()){
      header('location:products.php');
      exit();
   }
}
?>
