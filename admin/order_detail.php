<?php
require_once '../includes/db_connect.php';

// ดึงรายละเอียดคำสั่งซื้อ
$order = null;
$order_items = [];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ดึงข้อมูลคำสั่งซื้อ
    $sql = "SELECT id, customer_name, customer_email, customer_phone, order_date, total_price, status, notes FROM orders WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // ดึงรายการสินค้า
        $sql = "SELECT oi.product_id, oi.quantity, oi.price, p.name FROM order_items oi 
                JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $order_items[] = $row;
        }
    }
}

// อัปเดตสถานะ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE orders SET status='$status' WHERE id=$order_id";
    if ($conn->query($sql)) {
        header("Location: order_detail.php?id=$order_id");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดคำสั่งซื้อ - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .order-detail {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .detail-item label {
            font-weight: 600;
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }

        .detail-item span {
            color: #333;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>⚙️ รายละเอียดคำสั่งซื้อ</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin-nav">
                <a href="orders.php">← กลับไปจัดการคำสั่งซื้อ</a>
            </div>

            <?php if ($order): ?>

                <div class="order-detail">
                    <h2>Order #<?php echo $order['id']; ?></h2>

                    <div class="order-detail-grid">
                        <div class="detail-item">
                            <label>ชื่อลูกค้า:</label>
                            <span><?php echo htmlspecialchars($order['customer_name']); ?></span>
                        </div>

                        <div class="detail-item">
                            <label>อีเมล:</label>
                            <span><?php echo htmlspecialchars($order['customer_email']); ?></span>
                        </div>

                        <div class="detail-item">
                            <label>เบอร์โทรศัพท์:</label>
                            <span><?php echo htmlspecialchars($order['customer_phone']); ?></span>
                        </div>

                        <div class="detail-item">
                            <label>วันที่สั่งซื้อ:</label>
                            <span><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
                        </div>

                        <div class="detail-item">
                            <label>ราคารวม:</label>
                            <span style="font-size: 18px; font-weight: bold; color: #667eea;">
                                ฿<?php echo number_format($order['total_price'], 2); ?>
                            </span>
                        </div>

                        <div class="detail-item">
                            <label>หมายเหตุ:</label>
                            <span><?php echo htmlspecialchars($order['notes'] ?? 'ไม่มี'); ?></span>
                        </div>
                    </div>

                    <form method="POST" style="margin-top: 20px;">
                        <div class="form-group">
                            <label>อัปเดตสถานะ:</label>
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status"
                                style="width: 200px; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending
                                </option>
                                <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>
                                    Completed</option>
                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>
                                    Cancelled</option>
                            </select>
                            <button type="submit" name="update_status" class="btn"
                                style="margin-left: 10px;">อัปเดต</button>
                        </div>
                    </form>
                </div>

                <h3>รายการสินค้า</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>฿<?php echo number_format($item['price'], 2); ?></td>
                                <td>฿<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p style="color: red; text-align: center; padding: 50px;">ไม่พบคำสั่งซื้อนี้</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 ร้านขายตุ๊กตา | Admin Panel</p>
    </footer>
</body>

</html>
<?php $conn->close(); ?>