<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= APP_NAME ?></title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="logo" href="/index.php">Arts Stationery</a>
    <nav>
      <a href="/products.php">Products</a>
      <a href="/about.php">About</a>
      <a href="/feedback.php">Feedback</a>
      <?php if ($user): ?>
        <?php if ($user['role'] === 'admin'): ?><a href="/admin/dashboard.php">Admin</a><?php endif; ?>
        <?php if ($user['role'] === 'employee'): ?><a href="/employee/dashboard.php">Employee</a><?php endif; ?>
        <?php if ($user['role'] === 'customer'): ?><a href="/customer/dashboard.php">My Account</a><?php endif; ?>
        <a href="/auth/logout.php">Logout</a>
      <?php else: ?>
        <a href="/auth/login.php">Login</a>
        <a href="/auth/register.php" class="btn-link">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
