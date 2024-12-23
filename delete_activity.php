<?php 
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล
// รับค่า ID จาก URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // แปลงเป็นตัวเลขเพื่อความปลอดภัย

    // อัปเดตสถานะเป็น 0
    $sql = "UPDATE activities SET status = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('ยกเลิกกิจกรรมสำเร็จ'); window.location.href = 'admin_activity.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการยกเลิกกิจกรรม'); window.location.href = 'admin_activity.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ไม่พบ ID ของกิจกรรม'); window.location.href = 'admin_activity.php';</script>";
}

$conn->close();
?>