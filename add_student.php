<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $role = 'student'; // กำหนดให้ role เป็น student
    $year_id = $_POST['year_id'];
    $program_id = $_POST['program_id'];
    $branch_id = $_POST['branch_id'];

    // ตรวจสอบค่าซ้ำ
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql_check);
    if ($result->num_rows > 0) {
        echo "อีเมลนี้มีผู้ใช้งานแล้ว!";
        exit();
    }

    // คำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO users (student_id, first_name, last_name, email, password, role, year_id, program_id, branch_id) 
            VALUES ('$student_id', '$first_name', '$last_name', '$email', '$password', '$role', '$year_id', '$program_id', '$branch_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_stu.php");  // เปลี่ยนไปยังหน้าที่แสดงข้อมูลนักเรียน
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลนักเรียน</title>
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
            <h1 class="text-2xl font-bold">ระบบจัดการนักเรียน</h1>
        </div>
         <!-- รวมเมนู -->
         <?php include('menu.php'); ?>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar -->
        <?php include('topbar.php'); ?>

        <!-- Form -->
        <main class="p-6 bg-gray-100 flex-1">
            <h3 class="text-xl font-bold text-gray-800 mb-4">เพิ่มข้อมูลนักศึกษา</h3>
            <form action="add_student.php" method="POST">
                <div class="mb-4">
                    <label for="student_id" class="block text-gray-700">รหัสนักเรียน</label>
                    <input type="text" id="student_id" name="student_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="first_name" class="block text-gray-700">ชื่อ</label>
                    <input type="text" id="first_name" name="first_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="last_name" class="block text-gray-700">นามสกุล</label>
                    <input type="text" id="last_name" name="last_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">อีเมล</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">รหัสผ่าน</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="year_id" class="block text-gray-700">ชั้นปี</label>
                    <select id="year_id" name="year_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="">เลือกชั้นปี</option>
                        <?php
                        $result = $conn->query("SELECT id, year_name FROM years");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['year_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="program_id" class="block text-gray-700">หลักสูตร</label>
                    <select id="program_id" name="program_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="">เลือกหลักสูตร</option>
                        <?php
                        $result = $conn->query("SELECT id, program_name FROM programs");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['program_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="branch_id" class="block text-gray-700">สาขาวิชา</label>
                    <select id="branch_id" name="branch_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="">เลือกสาขาวิชา</option>
                        <?php
                        $result = $conn->query("SELECT id, department_name FROM departments");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['department_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" onclick="window.location.href='admin_students.php'">ยกเลิก</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">บันทึก</button>
                </div>
            </form>
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
