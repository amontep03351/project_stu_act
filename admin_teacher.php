<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล
// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}
 
$sql = "SELECT users.*,years.year_name,programs.program_name,departments.department_name 

 FROM users  

 LEFT JOIN years ON users.year_id = years.id
 
 LEFT JOIN programs ON users.program_id = programs.id
 
 LEFT JOIN departments ON users.branch_id = departments.id

 WHERE users.role ='teacher'
";  
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลอาจารย์</title>
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
            <h3 class="text-xl font-bold text-gray-800 mb-4">ข้อมูลอาจารย์</h3>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4" onclick="window.location.href='add_teacher.php'">เพิ่มข้อมูลอาจารย์</button>
            
            <!-- DataTable -->
            <table id="studentTable" class="display w-full">
                <thead>
                    <tr>  
                        <th>ชื่อ นามสกุล</th> 
                        <th>อีเมล</th>  
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
         
                    <?php
                    if ($result->num_rows > 0) {
                        // วนลูปข้อมูลจากฐานข้อมูลและแสดงในตาราง
                        while ($row = $result->fetch_assoc()) { 
                            echo "<tr> 
                                    <td>{$row['first_name']} {$row['last_name']}</td>  
                                    <td>{$row['email']}</td> 
                                    <td>
                                        <button class='bg-yellow-500 text-white px-4 py-2 rounded-lg' onclick='editTea({$row['id']})'>แก้ไข</button> 
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>ไม่มีข้อมูล</td></tr>";
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
 

        function editTea(id) {
            
            window.location.href = `edit_teacher.php?id=${id}`;
        }

  

        function logout() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = "logout.php"; // เปลี่ยนเป็นลิงก์หน้าเข้าสู่ระบบจริง
            }
        }
    </script>
</body>
</html>
