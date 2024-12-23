<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = 'localhost'; // ชื่อโฮสต์
$username = 'root';  // ชื่อผู้ใช้ MySQL
$password = '';      // รหัสผ่าน MySQL
$database = 'facedb'; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าภาษาให้รองรับ UTF-8
$conn->set_charset("utf8");
?>
