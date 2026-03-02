# ร้านขายตุ๊กตา (Doll Shop)

โปรเจคร้านขายตุ๊กตาออนไลน์ที่พัฒนาด้วย PHP และ MySQL

## ความต้องการของระบบ

- PHP 7.0 หรือสูงกว่า
- MySQL 5.7 หรือสูงกว่า
- Web Server (Apache, Nginx)

## การตั้งค่า

### 1. โครงสร้างโปรเจค
```
doll-shop/
├── includes/
│   ├── db_connect.php       (เชื่อมต่อฐานข้อมูล)
│   └── init_db.php          (สร้างตารางฐานข้อมูล)
├── admin/
│   ├── index.php            (Dashboard)
│   ├── products.php         (จัดการสินค้า)
│   ├── categories.php       (จัดการหมวดหมู่)
│   └── orders.php           (จัดการคำสั่งซื้อ)
├── css/
│   └── style.css            (Stylesheet)
├── js/
│   └── script.js            (JavaScript)
├── index.php                (หน้าแรก)
├── products.php             (หน้าสินค้า)
├── cart.php                 (ตะกร้าสินค้า)
└── README.md                (ไฟล์นี้)
```

### 2. ตั้งค่า phpMyAdmin
- **Hostname:** localhost
- **Username:** root
- **Password:** root
- **Database:** doll_shop (จะสร้างอัตโนมัติ)

### 3. การใช้งาน

#### ขั้นแรก: สร้างฐานข้อมูล

**วิธีที่ 1: ใช้ PHP Built-in Server**
```bash
cd d:\coffee\doll-shop
php -S localhost:8000
```
จากนั้นเปิด: `http://localhost:8000/includes/init_db.php`

**วิธีที่ 2: ใช้ Docker**
```bash
cd d:\coffee\doll-shop
docker-compose up -d
```
จากนั้นเปิด: `http://localhost/includes/init_db.php`

ระบบจะสร้างตาราง 4 ตาราง:
- `categories` - หมวดหมู่สินค้า
- `products` - สินค้า
- `orders` - คำสั่งซื้อ
- `order_items` - รายการสินค้าในคำสั่งซื้อ

#### เข้าสู่ Admin Panel
- **PHP Server:** `http://localhost:8000/admin/`
- **Docker:** `http://localhost/admin/`

### Features ที่มี

✅ **Frontend:**
- หน้าแรกแสดงสินค้าแนะนำ
- หน้าแสดงสินค้าทั้งหมด
- ตะกร้าสินค้า (พร้อมพัฒนา)

✅ **Admin Dashboard:**
- จัดการสินค้า (เพิ่ม/ลบ/แก้ไข)
- จัดการหมวดหมู่ (เพิ่ม/ลบ)
- จัดการคำสั่งซื้อ
- ดูสถิติร้าน (จำนวนสินค้า, หมวดหมู่, คำสั่งซื้อ, ยอดขาย)

## ตารางฐานข้อมูล

### categories
```sql
- id (PRIMARY KEY)
- name (VARCHAR 255, UNIQUE)
- description (TEXT)
- created_at (TIMESTAMP)
```

### products
```sql
- id (PRIMARY KEY)
- name (VARCHAR 255, UNIQUE)
- description (TEXT)
- price (DECIMAL 10,2)
- quantity (INT)
- image (VARCHAR 255)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### orders
```sql
- id (PRIMARY KEY)
- customer_name (VARCHAR 255)
- customer_email (VARCHAR 255)
- customer_phone (VARCHAR 20)
- order_date (TIMESTAMP)
- total_price (DECIMAL 10,2)
- status (ENUM: pending, completed, cancelled)
- notes (TEXT)
```

### order_items
```sql
- id (PRIMARY KEY)
- order_id (FOREIGN KEY)
- product_id (FOREIGN KEY)
- quantity (INT)
- price (DECIMAL 10,2)
```

## การใช้ phpmyadmin

1. เปิด phpmyadmin ที่ `http://localhost/phpmyadmin`
2. ใส่ Username: `root`
3. ใส่ Password: `root`
4. คลิก Login

หลังจากนั้น ระบบจะสร้าง database `doll_shop` ขึ้นเอง

## ขั้นตอนการเพิ่มสินค้า

1. ไปที่ Admin → จัดการสินค้า
2. กรอกข้อมูล:
   - ชื่อสินค้า
   - รายละเอียด
   - ราคา (บาท)
   - จำนวน
3. คลิก "เพิ่มสินค้า"

## Troubleshooting

### "Connection Failed"
- ตรวจสอบว่า MySQL Server กำลังทำงาน
- ตรวจสอบ username/password ใน `includes/db_connect.php`

### "Database doesn't exist"
- เปิด `includes/init_db.php` เพื่อสร้างฐานข้อมูล

### ไม่เห็น Admin menu
- ตรวจสอบการสร้างตารางสำเร็จหรือไม่

## หมายเหตุ

- ทั้งหมดเข้ารหัส UTF-8 เพื่อสนับสนุนภาษาไทย
- ระบบยังไม่มีระบบเข้าสู่ระบบ (login) - ควรเพิ่มเติมในภายหลัง
- ตะกร้าสินค้า ใช้ Session (ลบเมื่อปิด browser)

---

สร้างเมื่อ: 2 มีนาคม 2026
