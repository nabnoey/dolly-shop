<?php
require_once '../includes/db_connect.php';
session_start();

// เพิ่มสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    $sql = "INSERT INTO products (name, description, price, quantity) VALUES ('$name', '$description', $price, $quantity)";
    if ($conn->query($sql)) {
        $message = "✓ เพิ่มสินค้าสำเร็จ";
        $message_type = "success";
    } else {
        $message = "✗ เพิ่มสินค้าไม่สำเร็จ: " . $conn->error;
        $message_type = "error";
    }
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: products.php");
        exit;
    }
}

// ดึงสินค้าทั้งหมด
$sql = "SELECT id, name, description, price, quantity FROM products";
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
    <title>จัดการสินค้า - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>⚙️ จัดการสินค้า</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin-nav">
                <a href="index.php">Dashboard</a>
                <a href="categories.php">หมวดหมู่</a>
                <a href="orders.php">คำสั่งซื้อ</a>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <h2>เพิ่มสินค้าใหม่</h2>
            <form method="POST" style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                <div class="form-group">
                    <label>ชื่อสินค้า</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>รายละเอียด</label>
                    <textarea name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label>ราคา (บาท)</label>
                    <input type="number" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>จำนวน</label>
                    <input type="number" name="quantity" required>
                </div>

                <button type="submit" name="add_product" class="btn">เพิ่มสินค้า</button>
            </form>

            <h2>รายการสินค้า</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อสินค้า</th>
                        <th>รายละเอียด</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars(substr($product['description'], 0, 30)); ?>...</td>
                            <td>฿<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn"
                                    style="padding: 5px 10px; font-size: 12px;">แก้ไข</a>
                                <a href="products.php?delete=<?php echo $product['id']; ?>" class="btn btn-danger"
                                    style="padding: 5px 10px; font-size: 12px;"
                                    onclick="return confirm('ต้องการลบสินค้านี้หรือไม่?');">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 ร้านขายตุ๊กตา | Admin Panel</p>
    </footer>
</body>

</html>
<?php $conn->close(); ?>