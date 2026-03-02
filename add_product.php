<?php
require_once 'includes/db_connect.php';

$message = "";

// เมื่อกดปุ่ม submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $image = $_POST['image'];

    // ป้องกัน SQL Injection แบบพื้นฐาน
    $name = $conn->real_escape_string($name);
    $price = $conn->real_escape_string($price);
    $image = $conn->real_escape_string($image);

    $sql = "INSERT INTO product (product_name, product_price, image)
        VALUES ('$name', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        $message = "เพิ่มสินค้าสำเร็จ!";
    } else {
        $message = "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้า</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #e91e63;
            color: white;
            border: none;
        }

        .msg {
            text-align: center;
            color: green;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>เพิ่มสินค้า</h2>

        <?php if ($message): ?>
            <p class="msg">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="product_name" placeholder="ชื่อสินค้า" required>
            <input type="number" name="product_price" placeholder="ราคา" step="0.01" required>
            <input type="text" name="image" placeholder="URL รูปภาพ หรือ images/xxx.jpg">
            <button type="submit">เพิ่มสินค้า</button>
        </form>

        <br>
        <a href="index.php">← กลับหน้าหลัก</a>
    </div>

</body>

</html>

<?php $conn->close(); ?>