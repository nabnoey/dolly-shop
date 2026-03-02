<?php
require_once '../includes/db_connect.php';

// ดึงคำสั่งซื้อทั้งหมด
$sql = "SELECT id, customer_name, customer_email, order_date, total_price, status FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// ลบคำสั่งซื้อ
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM orders WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: orders.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการคำสั่งซื้อ - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>⚙️ จัดการคำสั่งซื้อ</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin-nav">
                <a href="index.php">Dashboard</a>
                <a href="products.php">สินค้า</a>
                <a href="categories.php">หมวดหมู่</a>
            </div>

            <h2>รายการคำสั่งซื้อ</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อลูกค้า</th>
                        <th>อีเมล</th>
                        <th>วันที่</th>
                        <th>ราคารวม</th>
                        <th>สถานะ</th>
                        <th>ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                <td>฿<?php echo number_format($order['total_price'], 2); ?></td>
                                <td>
                                    <span style="background-color: 
                                    <?php
                                    if ($order['status'] == 'completed')
                                        echo '#d4edda';
                                    elseif ($order['status'] == 'pending')
                                        echo '#fff3cd';
                                    else
                                        echo '#f8d7da';
                                    ?>
                                    ; padding: 5px 10px; border-radius: 3px;">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn"
                                        style="padding: 5px 10px; font-size: 12px;">รายละเอียด</a>
                                    <a href="orders.php?delete=<?php echo $order['id']; ?>" class="btn btn-danger"
                                        style="padding: 5px 10px; font-size: 12px;"
                                        onclick="return confirm('ต้องการลบคำสั่งซื้อนี้หรือไม่?');">ลบ</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #999;">ยังไม่มีคำสั่งซื้อ</td>
                        </tr>
                    <?php endif; ?>
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