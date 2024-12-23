<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

// ตรวจสอบว่าได้รับ `id` จาก URL หรือไม่
if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // ดึงข้อมูลอาจารย์จากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' AND role = 'teacher'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลอาจารย์!";
        exit();
    }
} else {
    echo "ไม่พบรหัสอาจารย์!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลที่แก้ไขจากฟอร์ม
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $teacher['password']; // ถ้าไม่ได้แก้ไขรหัสผ่าน ใช้รหัสผ่านเดิม
    $role = 'teacher'; // กำหนด role เป็น teacher
    $year_id = 0; // กำหนดค่าเป็น 0 สำหรับชั้นปี
    $program_id = 0; // กำหนดค่าเป็น 0 สำหรับหลักสูตร
    $branch_id = 0; // กำหนดค่าเป็น 0 สำหรับสาขาวิชา

    // คำสั่ง SQL สำหรับอัพเดตข้อมูล
    $sql_update = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', password = '$password', role = '$role', year_id = '$year_id', program_id = '$program_id', branch_id = '$branch_id' WHERE id = '$teacher_id'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: admin_teacher.php"); // เปลี่ยนไปยังหน้าที่แสดงข้อมูลอาจารย์
        exit();
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลอาจารย์</title>
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
            <h1 class="text-2xl font-bold">ระบบจัดการอาจารย์</h1>
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
            <h3 class="text-xl font-bold text-gray-800 mb-4">แก้ไขข้อมูลอาจารย์</h3>
            <form action="edit_teacher.php?id=<?php echo $teacher['id']; ?>" method="POST">
                <div class="mb-4">
                    <label for="first_name" class="block text-gray-700">ชื่อ</label>
                    <input type="text" id="first_name" name="first_name" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $teacher['first_name']; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="last_name" class="block text-gray-700">นามสกุล</label>
                    <input type="text" id="last_name" name="last_name" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $teacher['last_name']; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">อีเมล</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $teacher['email']; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">รหัสผ่าน (ถ้าไม่ต้องการเปลี่ยนไม่ต้องกรอก)</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" onclick="window.location.href='admin_teachers.php'">ยกเลิก</button>
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
