<?php
// Database Configuration
// รองรับทั้ง Localhost และ Docker
$servername = getenv('MYSQL_HOST') ?: "127.0.0.1";
$username = getenv('MYSQL_USER') ?: "root";
$password = getenv('MYSQL_PASSWORD') ?: "root";
$database = getenv('MYSQL_DB') ?: "Shop";
$port = getenv('DB_PORT') ?: 3306;

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// สร้างฐานข้อมูลถ้ายังไม่มี (สำหรับ localhost เท่านั้น)
if (($servername === "127.0.0.1" || $servername === "localhost") && getenv('MYSQL_HOST') === false) {
    $conn_temp = new mysqli($servername, $username, $password, "", $port);
    $sql_db = "CREATE DATABASE IF NOT EXISTS doll_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn_temp->query($sql_db);
    $conn_temp->close();
}

// ตั้งค่าการเข้ารหัส UTF-8
$conn->set_charset("utf8mb4");
?>