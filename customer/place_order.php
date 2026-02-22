<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';
requireLogin('customer');

$productId = trim($_GET['product'] ?? $_POST['product_id'] ?? '');
$message = null;
$error = null;
$product = null;

try {
    if ($productId !== '') {
        $stmt = db()->prepare('SELECT * FROM products WHERE product_id = :pid LIMIT 1');
        $stmt->execute(['pid' => $productId]);
        $product = $stmt->fetch();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $product) {
        $deliveryType = (int) ($_POST['delivery_type'] ?? 1);
        $paymentType = $_POST['payment_type'] ?? 'vpp';
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        $lastNo = (int) db()->query('SELECT COALESCE(MAX(id), 0) + 1 FROM orders')->fetchColumn();
        $orderNumber = generateOrderNumber($deliveryType, $product['product_id'], $lastNo);

        $paymentStatus = in_array($paymentType, ['credit_card', 'cheque'], true) ? 'pending_clearance' : 'due_on_delivery';
        $total = (float) $product['price'] * $quantity;

        $insert = db()->prepare('INSERT INTO orders (order_number, customer_id, product_id, quantity, delivery_type, payment_type, payment_status, dispatch_status, status, total_amount) VALUES (:num, :customer, :pid, :qty, :delivery, :payment, :pstatus, :dispatch, :status, :amount)');
        $insert->execute([
            'num' => $orderNumber,
            'customer' => currentUser()['id'],
            'pid' => $product['product_id'],
            'qty' => $quantity,
            'delivery' => $deliveryType,
            'payment' => $paymentType,
            'pstatus' => $paymentStatus,
            'dispatch' => 'not_dispatched',
            'status' => 'placed',
            'amount' => $total,
        ]);

        $message = 'Order placed successfully! Your 16-digit order number: ' . $orderNumber;
    }
} catch (Throwable $e) {
    $error = 'Unable to place order. Configure database first.';
}
?>
<h2>Place Order</h2>
<?php if ($message): ?><p class="success"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>

<?php if (!$product): ?>
  <p class="notice">Invalid product. Please select a product from the products page.</p>
<?php else: ?>
  <div class="card">
    <h3><?= htmlspecialchars($product['name']) ?></h3>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p><strong>Product ID:</strong> <?= htmlspecialchars($product['product_id']) ?></p>
    <p><strong>Price:</strong> <?= money((float)$product['price']) ?></p>
  </div>

  <form class="form-card" method="post">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
    <label>Quantity <input type="number" name="quantity" value="1" min="1" required></label>
    <label>Delivery Type
      <select name="delivery_type">
        <option value="1">Standard</option>
        <option value="2">Express</option>
        <option value="3">VPP Priority</option>
      </select>
    </label>
    <label>Payment Type
      <select name="payment_type">
        <option value="credit_card">Credit Card</option>
        <option value="cheque">Cheque</option>
        <option value="vpp">VPP / Pay on Delivery</option>
      </select>
    </label>
    <button type="submit" class="btn">Confirm Order</button>
  </form>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
