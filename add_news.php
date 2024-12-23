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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $publish_date = $_POST['publish_date'];
    $publish_time = $_POST['publish_time']; 

    // ตรวจสอบค่าซ้ำ
    $sql_check = "SELECT * FROM news WHERE title = '$title'";
    $result = $conn->query($sql_check);
    if ($result->num_rows > 0) {
        echo "หัวข้อนี้มีอยู่แล้วในระบบ!";
        exit();
    }

    // การอัปโหลดไฟล์ภาพ
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_new_name = uniqid('news_', true) . '.' . $image_extension;
        $image_upload_path = 'uploads/' . $image_new_name;

        // ตรวจสอบประเภทของไฟล์ที่อัปโหลด
        if (in_array($image_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
                $image = $image_upload_path;
            } else {
                echo "ไม่สามารถอัปโหลดไฟล์ได้!";
                exit();
            }
        } else {
            echo "โปรดเลือกไฟล์ภาพที่ถูกต้อง!";
            exit();
        }
    }

    // คำสั่ง SQL สำหรับเพิ่ม
    $sql = "INSERT INTO news (title, description, publish_date, publish_time, image) 
            VALUES ('$title','$description', '$publish_date', '$publish_time', '$image')";

    if ($conn->query($sql) === TRUE) {
         
        header("Location: admin_new.php");  
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
    <title>ข้อมูลข่าว</title>
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

        <!-- Form -->
        <main class="p-6 bg-gray-100 flex-1">
            <h3 class="text-xl font-bold text-gray-800 mb-4">เพิ่มกิจกรรม</h3>
            <form action="add_news.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">หัวข้อ</label>
                    <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">รายละเอียด</label>
                    <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="publish_date" class="block text-gray-700">วันที่</label>
                    <input type="date" id="publish_date" name="publish_date" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="publish_time" class="block text-gray-700">เวลา</label>
                    <input type="time" id="publish_time" name="publish_time" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div> 
                <div class="mb-4">
                    <label for="image" class="block text-gray-700">อัปโหลดภาพ</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" onclick="window.location.href='admin_new.php'">ยกเลิก</button>
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
