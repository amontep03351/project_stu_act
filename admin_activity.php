<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล
// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

// ดึงข้อมูลกิจกรรมจากฐานข้อมูล
$sql = "SELECT * FROM activities"; // สมมติว่าในฐานข้อมูลมีตารางชื่อ activities
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลกิจกรรม</title>
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

        <!-- Activity Data Table -->
        <main class="p-6 bg-gray-100 flex-1"> 
            <h3 class="text-xl font-bold text-gray-800 mb-4">ข้อมูลกิจกรรม</h3>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4"  onclick="window.location.href='add_activity.php'">เพิ่มกิจกรรม</button> 
            
            <!-- DataTable -->
            <table id="ActivityTable" class="display w-full">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อกิจกรรม</th>
                        <th>วันที่เริ่ม</th>
                        <th>เวลา</th>
                        <th>วันที่สิ้นสุด</th> 
                        <th>เวลา</th>
                        <th>หน่วยกิต</th>
                        <th>สถานะ</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // วนลูปข้อมูลจากฐานข้อมูลและแสดงในตาราง
                        while ($row = $result->fetch_assoc()) {
                            $statusText = $row['status'] == 1 ? 'เปิดรับสมัคร' : 'ปิดรับสมัคร';
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td> 
                                    <td>{$row['start_date']}</td>
                                    <td>{$row['start_time']}</td>
                                    <td>{$row['end_date']}</td>
                                    <td>{$row['end_time']}</td>
                                    <td>{$row['credits']}</td> 
                                    <td>{$statusText}</td>
                                    <td>
                                        <button class='bg-yellow-500 text-white px-4 py-2 rounded-lg' onclick='editActivity({$row['id']})'>แก้ไข</button>
                                        <button class='bg-red-500 text-white px-4 py-2 rounded-lg' onclick='deleteActivity({$row['id']})'>ลบ</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>ไม่มีข้อมูลกิจกรรม</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {
            $('#ActivityTable').DataTable(); // Initialize DataTable
        });
        function logout() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = "logout.php";
            }
        }
        
        function editActivity(id) {
            // ส่งผู้ใช้งานไปยังหน้าแก้ไขข้อมูล พร้อมพารามิเตอร์ id
            window.location.href = `edit_activity.php?id=${id}`;
        }

        function deleteActivity(id) {
            if (confirm('คุณต้องการลบกิจกรรมนี้หรือไม่?')) {
                // ส่งผู้ใช้งานไปยังหน้า delete_activity.php พร้อมพารามิเตอร์ id
                window.location.href = `delete_activity.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
