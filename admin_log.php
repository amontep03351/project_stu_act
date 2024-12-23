<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล
// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}
 
$sql = "
    SELECT 
        r.id AS registration_id,
        u.first_name, 
        u.last_name, 
        a.name AS activity_name, 
        a.start_date, 
        a.start_time, 
        a.end_date, 
        a.end_time, 
        a.credits,
        ci.check_in_date, 
        ci.check_in_time
    FROM registrations r
    JOIN users u ON r.student_id = u.id
    JOIN activities a ON r.activity_id = a.id
    LEFT JOIN check_ins ci ON ci.student_id = u.id AND ci.activity_id = a.id
    WHERE u.role = 'student';
";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลนักศึกษา</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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

        <!-- Student Data Table -->
        <main class="p-6 bg-gray-100 flex-1">
            <h3 class="text-xl font-bold text-gray-800 mb-4">ประวัติเข้าร่วมกิจกรรม</h3>
            <!-- <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4" onclick="window.location.href='add_student.php'">เพิ่มนักศึกษา</button> -->
            
            <!-- DataTable -->
            <table id="studentTable" class="display w-full">
                <thead>
                    <tr>  
                        <th>ชื่อนักเรียน</th>
                        <th>กิจกรรม</th>
                        <th>วันที่เริ่มต้น</th>
                        <th>เวลาเริ่มต้น</th>
                        <th>วันที่สิ้นสุด</th>
                        <th>เวลาสิ้นสุด</th>
                        <th>หน่วยกิต</th>
                        <th>วันที่เช็คอิน</th>
                        <th>เวลาเช็คอิน</th>
                    </tr>
                </thead>
                <tbody>
         
                    <?php
                    if ($result->num_rows > 0) {
                        // วนลูปข้อมูลจากฐานข้อมูลและแสดงในตาราง
                        while ($row = $result->fetch_assoc()) { 
                            echo "<tr> 
                            <td>{$row['first_name']} {$row['last_name']}</td>
                            <td>{$row['activity_name']}</td>
                            <td>{$row['start_date']}</td>
                            <td>{$row['start_time']}</td>
                            <td>{$row['end_date']}</td>
                            <td>{$row['end_time']}</td>
                            <td>{$row['credits']}</td>
                            <td>{$row['check_in_date']}</td>
                            <td>{$row['check_in_time']}</td>
                        </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>ไม่มีข้อมูล</td></tr>";
                    }
                    ?> 
                </tbody>
            </table>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {
            $('#studentTable').DataTable(); // Initialize DataTable
        }); 
        function logout() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = "logout.php"; // เปลี่ยนเป็นลิงก์หน้าเข้าสู่ระบบจริง
            }
        }
      
        
    </script>
</body>
</html>
