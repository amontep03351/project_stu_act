<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

// ตรวจสอบว่าได้รับ id ของข่าวหรือไม่
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // คำสั่ง SQL สำหรับลบข่าว
    $sql = "DELETE FROM news WHERE id = $news_id";

    if ($conn->query($sql) === TRUE) {
        // หากลบสำเร็จให้กลับไปที่หน้า admin_new.php
        header("Location: admin_new.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการลบข่าว: " . $conn->error;
    }
} else {
    echo "ไม่พบข้อมูลข่าวที่ต้องการลบ!";
}

$conn->close();
?>
