<?php
require_once __DIR__ . '/../includes/header.php';
requireLogin('employee');

$orders = [];
$error = null;

try {
    $orders = db()->query('SELECT order_number, status, dispatch_status, created_at FROM orders ORDER BY created_at DESC LIMIT 15')->fetchAll();
} catch (Throwable $e) {
    $error = 'Connect database to view order dispatch queue.';
}
?>
<h2>Employee Dashboard</h2>
<p>Employees can review orders, update dispatch status, and change only their passwords.</p>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<table>
  <thead><tr><th>Order Number</th><th>Status</th><th>Dispatch</th><th>Date</th></tr></thead>
  <tbody>
  <?php foreach ($orders as $order): ?>
    <tr>
      <td><?= htmlspecialchars($order['order_number']) ?></td>
      <td><?= htmlspecialchars($order['status']) ?></td>
      <td><?= htmlspecialchars($order['dispatch_status']) ?></td>
      <td><?= htmlspecialchars($order['created_at']) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
