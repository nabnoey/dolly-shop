<?php
require_once '../includes/db_connect.php';

// ดึงสถิติ
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_categories = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_sales = $conn->query("SELECT SUM(total_price) as total FROM orders")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ร้านขายตุ๊กตา</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .dashboard-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .dashboard-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .dashboard-card .label {
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>⚙️ Admin Dashboard</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="admin-nav">
                <a href="products.php">จัดการสินค้า</a>
                <a href="categories.php">จัดการหมวดหมู่</a>
                <a href="orders.php">จัดการคำสั่งซื้อ</a>
                <a href="../">ไปที่หน้าแรก</a>
            </div>

            <h2>สถิติร้านขายตุ๊กตา</h2>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>📦 สินค้า</h3>
                    <div class="number"><?php echo $total_products; ?></div>
                    <div class="label">ทั้งหมด</div>
                </div>

                <div class="dashboard-card">
                    <h3>📂 หมวดหมู่</h3>
                    <div class="number"><?php echo $total_categories; ?></div>
                    <div class="label">ทั้งหมด</div>
                </div>

                <div class="dashboard-card">
                    <h3>📋 คำสั่งซื้อ</h3>
                    <div class="number"><?php echo $total_orders; ?></div>
                    <div class="label">ทั้งหมด</div>
                </div>

                <div class="dashboard-card">
                    <h3>💰 ยอดขายรวม</h3>
                    <div class="number">฿<?php echo number_format($total_sales, 0); ?></div>
                    <div class="label">ทั้งหมด</div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 ร้านขายตุ๊กตา | Admin Panel</p>
    </footer>
</body>

</html>
<?php $conn->close(); ?>