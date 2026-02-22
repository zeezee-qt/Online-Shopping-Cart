<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$search = trim($_GET['q'] ?? '');
$products = [];
$error = null;

try {
    $products = fetchAllProducts($search);
} catch (Throwable $e) {
    $error = 'Database is not connected yet. Configure connection in includes/config.php and import database/schema.sql.';
}
?>

<h2>Products</h2>
<form class="search-row" method="get">
  <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name, category, product ID..." />
  <button type="submit" class="btn">Search</button>
</form>

<?php if ($error): ?>
  <p class="notice"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="product-grid">
<?php foreach ($products as $product): ?>
  <article class="card product-card">
    <h3><?= htmlspecialchars($product['name']) ?></h3>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p><strong>Product ID:</strong> <?= htmlspecialchars($product['product_id']) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
    <p><strong>Price:</strong> <?= money((float)$product['price']) ?></p>
    <?php if (isLoggedIn() && hasRole('customer')): ?>
      <a class="btn" href="/customer/place_order.php?product=<?= urlencode($product['product_id']) ?>">Order</a>
    <?php endif; ?>
  </article>
<?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
