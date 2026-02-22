<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';
requireLogin('customer');

$user = currentUser();
$orders = [];
$error = null;

try {
    $stmt = db()->prepare('SELECT order_number, total_amount, payment_type, payment_status, dispatch_status, status, created_at FROM orders WHERE customer_id = :id ORDER BY created_at DESC');
    $stmt->execute(['id' => $user['id']]);
    $orders = $stmt->fetchAll();
} catch (Throwable $e) {
    $error = 'Connect database to view your orders.';
}
?>
<h2>Customer Dashboard</h2>
<a class="btn" href="/products.php">Browse Products</a>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<table>
  <thead><tr><th>Order #</th><th>Total</th><th>Payment</th><th>Payment Status</th><th>Dispatch</th><th>Status</th><th>Date</th></tr></thead>
  <tbody>
  <?php foreach ($orders as $order): ?>
    <tr>
      <td><?= htmlspecialchars($order['order_number']) ?></td>
      <td><?= money((float)$order['total_amount']) ?></td>
      <td><?= htmlspecialchars(strtoupper($order['payment_type'])) ?></td>
      <td><?= htmlspecialchars($order['payment_status']) ?></td>
      <td><?= htmlspecialchars($order['dispatch_status']) ?></td>
      <td><?= htmlspecialchars($order['status']) ?></td>
      <td><?= htmlspecialchars($order['created_at']) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
