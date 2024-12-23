้<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include('db_connection.php');

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

// ตรวจสอบว่ามีการส่ง activity_id มาหรือไม่
if (isset($_GET['activity_id'])) {
    $activity_id = $_GET['activity_id'];
    $student_id = $_SESSION['user_id']; // สมมติว่า user_id เก็บ ID ของนักเรียนใน session

    // ตรวจสอบว่าผู้ใช้ได้ลงทะเบียนกิจกรรมนี้ไปแล้วหรือไม่
    $check_sql = "SELECT * FROM registrations WHERE student_id = ? AND activity_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $student_id, $activity_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ใช้ SweetAlert แสดงข้อความว่า "คุณได้ลงทะเบียนกิจกรรมนี้แล้ว"
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'คุณได้ลงทะเบียนกิจกรรมนี้แล้ว',
                    icon: 'info',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'dashboard_student.php'; // เปลี่ยนเป็นหน้าที่แสดงกิจกรรม
                });
              </script>";
    } else {
        // ทำการลงทะเบียนกิจกรรม
        $insert_sql = "INSERT INTO registrations (student_id, activity_id, registration_date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ii", $student_id, $activity_id);

        if ($stmt->execute()) {
            // ใช้ SweetAlert แสดงข้อความสำเร็จ
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        title: 'ลงทะเบียนกิจกรรมสำเร็จ!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'dashboard_student.php'; // เปลี่ยนเป็นหน้าที่แสดงกิจกรรม
                    });
                  </script>";
        } else {
            // ใช้ SweetAlert แสดงข้อความข้อผิดพลาด
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาดในการลงทะเบียน',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    }
} else {
    echo "ไม่พบกิจกรรมที่ต้องการลงทะเบียน";
}

$conn->close();
?>

</body>
</html>