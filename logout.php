<?php
session_start();
session_destroy(); // ลบ session ทั้งหมด
header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
exit();
?>
