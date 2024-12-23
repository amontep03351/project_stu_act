<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล
// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-600 text-white flex flex-col">
        <div class="p-6 text-center">
            <h1 class="text-2xl font-bold">ระบบลงทะเบียนเข้าร่วมกิจกรรม</h1>
        </div>
        <!-- รวมเมนู -->
        <?php include('menu.php'); ?>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar --> 
        <?php include('topbar.php'); ?>
        
        <?php
        // ดึงจำนวนของนักเรียน
        $result_students = $conn->query("SELECT COUNT(*) AS total_students FROM users WHERE role = 'student'");
        $row_students = $result_students->fetch_assoc();
        $total_students = $row_students['total_students'];

        // ดึงจำนวนของอาจารย์
        $result_teachers = $conn->query("SELECT COUNT(*) AS total_teachers FROM users WHERE role = 'teacher'");
        $row_teachers = $result_teachers->fetch_assoc();
        $total_teachers = $row_teachers['total_teachers'];
        ?>
        <!-- Dashboard Content -->
        <main class="p-6 bg-gray-100 flex-1">
            <h3 class="text-xl font-bold text-gray-800 mb-4">ยินดีต้อนรับสู่ Dashboard</h3>
            <p class="text-gray-600">เลือกเมนูทางด้านซ้ายเพื่อดำเนินการต่อ</p>
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-white shadow-md p-4 rounded">
                    <h4 class="text-lg font-semibold text-gray-700">จำนวนนักเรียน</h4>
                    <p class="text-2xl font-bold text-gray-800"><?= $total_students ?></p>
                </div>
                <div class="bg-white shadow-md p-4 rounded">
                    <h4 class="text-lg font-semibold text-gray-700">จำนวนอาจารย์</h4>
                    <p class="text-2xl font-bold text-gray-800"><?= $total_teachers ?></p>
                </div>
            </div>
        </main>

    </div>

    <!-- JavaScript -->
    <script>
        function logout() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>
</html>
