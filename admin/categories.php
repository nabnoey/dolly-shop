<?php
require_once '../includes/db_connect.php';

// เพิ่มหมวดหมู่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
    if ($conn->query($sql)) {
        $message = "✓ เพิ่มหมวดหมู่สำเร็จ";
        $message_type = "success";
    } else {
        $message = "✗ เพิ่มหมวดหมู่ไม่สำเร็จ";
        $message_type = "error";
    }
}

// ลบหมวดหมู่
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM categories WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: categories.php");
        exit;
    }
}

// ดึงหมวดหมู่ทั้งหมด
$sql = "SELECT id, name, description, created_at FROM categories";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่ - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>⚙️ จัดการหมวดหมู่</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin-nav">
                <a href="index.php">Dashboard</a>
                <a href="products.php">สินค้า</a>
                <a href="orders.php">คำสั่งซื้อ</a>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <h2>เพิ่มหมวดหมู่ใหม่</h2>
            <form method="POST" style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                <div class="form-group">
                    <label>ชื่อหมวดหมู่</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>รายละเอียด</label>
                    <textarea name="description"></textarea>
                </div>

                <button type="submit" name="add_category" class="btn">เพิ่มหมวดหมู่</button>
            </form>

            <h2>รายการหมวดหมู่</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อหมวดหมู่</th>
                        <th>รายละเอียด</th>
                        <th>วันที่สร้าง</th>
                        <th>ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category['id']; ?></td>
                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                            <td><?php echo htmlspecialchars(substr($category['description'], 0, 30)); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($category['created_at'])); ?></td>
                            <td>
                                <a href="categories.php?delete=<?php echo $category['id']; ?>" class="btn btn-danger"
                                    style="padding: 5px 10px; font-size: 12px;"
                                    onclick="return confirm('ต้องการลบหมวดหมู่นี้หรือไม่?');">ลบ</a>
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