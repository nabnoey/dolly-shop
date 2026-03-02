<?php
require_once '../includes/db_connect.php';

// แก้ไขสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    $sql = "UPDATE products SET name='$name', description='$description', price=$price, quantity=$quantity WHERE id=$id";
    if ($conn->query($sql)) {
        $message = "✓ แก้ไขสินค้าสำเร็จ";
        $message_type = "success";
    } else {
        $message = "✗ แก้ไขสินค้าไม่สำเร็จ";
        $message_type = "error";
    }
}

// ดึงข้อมูลสินค้า
$product = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT id, name, description, price, quantity FROM products WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสินค้า - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>⚙️ แก้ไขสินค้า</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin-nav">
                <a href="products.php">← กลับไปจัดการสินค้า</a>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($product): ?>
                <h2>แก้ไข: <?php echo htmlspecialchars($product['name']); ?></h2>
                <form method="POST" style="background: white; padding: 20px; border-radius: 8px; max-width: 600px;">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                    <div class="form-group">
                        <label>ชื่อสินค้า</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>รายละเอียด</label>
                        <textarea name="description"
                            required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>ราคา (บาท)</label>
                        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>จำนวน</label>
                        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>
                    </div>

                    <button type="submit" name="update_product" class="btn">บันทึกการเปลี่ยนแปลง</button>
                </form>
            <?php else: ?>
                <p style="color: red; text-align: center; padding: 50px;">ไม่พบสินค้านี้</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 ร้านขายตุ๊กตา | Admin Panel</p>
    </footer>
</body>

</html>
<?php $conn->close(); ?>