<?php
require_once __DIR__ . '/../includes/header.php';
requireLogin('admin');

$stats = ['products' => 0, 'orders' => 0, 'customers' => 0, 'feedback' => 0];
$error = null;

try {
    $stats['products'] = (int) db()->query('SELECT COUNT(*) FROM products')->fetchColumn();
    $stats['orders'] = (int) db()->query('SELECT COUNT(*) FROM orders')->fetchColumn();
    $stats['customers'] = (int) db()->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn();
    $stats['feedback'] = (int) db()->query('SELECT COUNT(*) FROM feedback')->fetchColumn();
} catch (Throwable $e) {
    $error = 'Connect database to view admin insights.';
}
?>
<h2>Admin Dashboard</h2>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<div class="grid-4">
  <div class="card"><h3>Products</h3><p><?= $stats['products'] ?></p></div>
  <div class="card"><h3>Orders</h3><p><?= $stats['orders'] ?></p></div>
  <div class="card"><h3>Customers</h3><p><?= $stats['customers'] ?></p></div>
  <div class="card"><h3>Feedback Entries</h3><p><?= $stats['feedback'] ?></p></div>
</div>
<p class="notice">Admin has exclusive permission to manage products, stock, employees, and business reports.</p>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
