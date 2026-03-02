<?php
require_once 'includes/db_connect.php';

// ดึงสินค้าทั้งหมด
$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สินค้า - ร้านขายตุ๊กตา</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>🧸 ร้านขายตุ๊กตา</h1>
            <nav>
                <a href="index.php">หน้าหลัก</a>
                <a href="products.php">สินค้า</a>
                <a href="cart.php">ตะกร้าสินค้า</a>
                <a href="admin/">จัดการร้าน</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>สินค้าทั้งหมด</h2>
            <div class="product-grid">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="<?php echo $product['image'] ?: 'images/placeholder.png'; ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="price">฿<?php echo number_format($product['price'], 2); ?></p>
                            <button class="btn-add-cart">เพิ่มลงตะกร้า</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column: 1/-1; text-align: center; color: #999; padding: 50px;">ยังไม่มีสินค้าในร้าน</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 ร้านขายตุ๊กตา | All Rights Reserved</p>
    </footer>
</body>

</html>
<?php $conn->close(); ?>