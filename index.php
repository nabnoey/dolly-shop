<?php
require_once 'includes/db_connect.php';

// ดึงสินค้าทั้งหมด
$sql = "SELECT product_id, product_name, product_price, image FROM product LIMIT 12";
$result = $conn->query($sql);

$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ร้านขายตุ๊กตา - Doll Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
            padding: 20px 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
            text-align: center;
        }

        .product-info h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .price {
            color: #e91e63;
            font-weight: bold;
            font-size: 18px;
        }

        .empty {
            text-align: center;
            color: #999;
        }

        .btn-add {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background: #45a049;
        }
    </style>
</head>

<body>

    <main>
        <div class="container">
            <section class="products">
                <h2>สินค้าแนะนำ</h2>

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>สินค้าแนะนำ</h2>
                    <a href="add_product.php" class="btn-add">+ เพิ่มสินค้า</a>
                </div>

                <div class="product-grid">

                    <?php if (count($products) > 0): ?>

                        <?php foreach ($products as $product): ?>
                            <div class="product-card">

                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                        alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x220?text=No+Image" class="product-image">
                                <?php endif; ?>

                                <div class="product-info">
                                    <h3>
                                        <?php echo htmlspecialchars($product['product_name']); ?>
                                    </h3>

                                    <p class="price">
                                        ฿<?php echo number_format($product['product_price'], 2); ?>
                                    </p>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p class="empty">ยังไม่มีสินค้าในร้าน</p>
                    <?php endif; ?>

                </div>
            </section>
        </div>
    </main>

</body>

</html>

<?php $conn->close(); ?>