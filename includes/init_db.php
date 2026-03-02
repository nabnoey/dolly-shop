<?php
// Include database connection
require_once 'db_connect.php';

// สร้างตารางสินค้า
$sql_products = "
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

// สร้างตารางหมวดหมู่
$sql_categories = "
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

// สร้างตารางคำสั่งซื้อ
$sql_orders = "
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    notes TEXT
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

// สร้างตารางรายการสั่งซื้อ
$sql_order_items = "
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

// Execute queries
if ($conn->query($sql_categories) === TRUE) {
    echo "✓ ตาราง categories สร้างสำเร็จ<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

if ($conn->query($sql_products) === TRUE) {
    echo "✓ ตาราง products สร้างสำเร็จ<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

if ($conn->query($sql_orders) === TRUE) {
    echo "✓ ตาราง orders สร้างสำเร็จ<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

if ($conn->query($sql_order_items) === TRUE) {
    echo "✓ ตาราง order_items สร้างสำเร็จ<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

// เพิ่มตัวอย่างข้อมูล
$sample_categories = [
    ['name' => 'ตุ๊กตาสัตว์', 'description' => 'ตุ๊กตารูปสัตว์โลก'],
    ['name' => 'ตุ๊กตาอะนิเมะ', 'description' => 'ตุ๊กตาตัวละครจากอะนิเมะ'],
    ['name' => 'ตุ๊กตาสตัฟ', 'description' => 'ตุ๊กตาผ้านิ่มนาน']
];

foreach ($sample_categories as $cat) {
    $sql = "INSERT IGNORE INTO categories (name, description) VALUES ('" . $conn->real_escape_string($cat['name']) . "', '" . $conn->real_escape_string($cat['description']) . "')";
    $conn->query($sql);
}

echo "<br><p style='color: green; font-weight: bold;'>✓ ฐานข้อมูลพร้อมใช้งาน!</p>";
$conn->close();
?>