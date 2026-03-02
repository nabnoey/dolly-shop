# Docker Quick Start Guide

## 📋 ความต้องการ
- Docker Desktop ติดตั้งแล้ว
- Docker Compose (มาพร้อม Docker Desktop)

## 🚀 วิธีเริ่มต้น

### Windows
1. เปิด Command Prompt / PowerShell
2. ไปที่โฟลเดอร์โปรเจค:
```bash
cd d:\coffee\doll-shop
```

3. **วิธีที่ 1: ใช้ Script Menu**
```bash
docker-start.bat
```

4. **วิธีที่ 2: ใช้ Command ตรง**
```bash
docker-compose up -d
```

### Linux/macOS
```bash
cd /path/to/doll-shop
chmod +x docker-start.sh
./docker-start.sh
```

---

## 🌐 เข้าใช้งาน

เมื่อ Container เปิดสำเร็จ:

| สิ่งที่ต้องการ | URL |
|---------|------|
| 🏠 หน้าแรกเว็บ | http://localhost |
| ⚙️ Admin Panel | http://localhost/admin |
| 📊 phpMyAdmin | http://localhost:8080 |
| 🗄️ MySQL CLI | `docker exec -it doll-shop-mysql mysql -u root -proot doll_shop` |

---

## 📊 MySQL Details

```
Host: localhost (หรือ mysql ถ้าใช้ใน Container)
Username: root
Password: root
Database: doll_shop
Port: 3306
```

---

## 🛠️ คำสั่งพื้นฐาน

### เปิด Containers
```bash
docker-compose up -d
```

### ปิด Containers
```bash
docker-compose down
```

### ดู Logs
```bash
docker-compose logs -f php
docker-compose logs -f mysql
```

### เข้า Shell ของ PHP Container
```bash
docker exec -it doll-shop-php bash
```

### เข้า MySQL CLI
```bash
docker exec -it doll-shop-mysql mysql -u root -proot doll_shop
```

### Rebuild Images (หลังจากแก้ Dockerfile)
```bash
docker-compose up -d --build
```

### ดูสถานะ Containers
```bash
docker-compose ps
```

---

## 🔧 Troubleshooting

### Port 80 หรือ 3306 ถูกใช้งาน
แก้ไขใน `docker-compose.yml`:
```yaml
ports:
  - "8080:80"    # เปลี่ยนจาก 80:80 เป็น 8080:80
```

### Containers ไม่เปิด
ลองสั่ง:
```bash
docker-compose down
docker-compose up -d --build
```

### ลืมรหัส MySQL
รหัส default:
- Username: root
- Password: root

### ต้องการลบ Database
```bash
docker-compose down -v
```
(ใช้ `-v` เพื่อลบ volumes ด้วย)

---

## 📁 ไฟล์ที่สำคัญ

- `docker-compose.yml` - Configuration สำหรับ Container
- `Dockerfile` - Build image สำหรับ PHP+Apache
- `.env.example` - Environment variables template
- `docker-start.bat` - Script ช่วยการใช้งาน (Windows)
- `docker-start.sh` - Script ช่วยการใช้งาน (Linux/Mac)

---

## 💡 Tips

- ใช้ `docker-compose logs -f` เพื่อดู logs แบบ real-time
- สร้างไฟล์ `.env` จาก `.env.example` เพื่อ override environment variables
- ถ้าแก้ไข Dockerfile ต้อง rebuild: `docker-compose up -d --build`

ตอนนี้พร้อมใช้งาน! 🎉
