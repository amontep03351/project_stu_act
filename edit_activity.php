<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

// ตรวจสอบว่ามี ID ของกิจกรรมที่ต้องการแก้ไขหรือไม่
if (!isset($_GET['id'])) {
    echo "ไม่พบข้อมูลกิจกรรมที่ต้องการแก้ไข!";
    exit();
}

$id = $_GET['id'];

// ดึงข้อมูลกิจกรรมจากฐานข้อมูล
$sql = "SELECT * FROM activities WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "ไม่พบข้อมูลกิจกรรม!";
    exit();
}

$activity = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $start_time = $_POST['start_time'];
    $end_date = $_POST['end_date'];
    $end_time = $_POST['end_time'];
    $credits = $_POST['credits'];
    $status = $_POST['status'];

    // การอัปโหลดไฟล์ภาพ (ถ้ามี)
    $image = $activity['image']; // ใช้ภาพเดิมเป็นค่าเริ่มต้น
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_new_name = uniqid('activity_', true) . '.' . $image_extension;
        $image_upload_path = 'uploads/' . $image_new_name;

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

    // อัปเดตข้อมูลกิจกรรม
    $sql_update = "UPDATE activities SET 
        name = '$name',
        description = '$description',
        start_date = '$start_date',
        start_time = '$start_time',
        end_date = '$end_date',
        end_time = '$end_time',
        credits = '$credits',
        status = '$status',
        image = '$image'
        WHERE id = '$id'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: admin_activity.php"); // เปลี่ยนไปที่หน้ารายการกิจกรรม
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

        <!-- Form -->
        <main class="p-6 bg-gray-100 flex-1">
            <h3 class="text-xl font-bold text-gray-800 mb-4">แก้ไขกิจกรรม</h3>
            <form action="edit_activity.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">ชื่อกิจกรรม</label>
                    <input type="text" id="name" name="name" value="<?= $activity['name'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">รายละเอียด</label>
                    <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" required><?= $activity['description'] ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700">วันที่เริ่ม</label>
                    <input type="date" id="start_date" name="start_date" value="<?= $activity['start_date'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="start_time" class="block text-gray-700">เวลาเริ่ม</label>
                    <input type="time" id="start_time" name="start_time" value="<?= $activity['start_time'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700">วันที่สิ้นสุด</label>
                    <input type="date" id="end_date" name="end_date" value="<?= $activity['end_date'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="end_time" class="block text-gray-700">เวลาสิ้นสุด</label>
                    <input type="time" id="end_time" name="end_time" value="<?= $activity['end_time'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="credits" class="block text-gray-700">หน่วยกิต</label>
                    <input type="number" id="credits" name="credits" value="<?= $activity['credits'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700">สถานะ</label>
                    <select id="status" name="status" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="1" <?= $activity['status'] == 1 ? 'selected' : '' ?>>เปิดรับสมัคร</option>
                        <option value="0" <?= $activity['status'] == 0 ? 'selected' : '' ?>>ปิดรับสมัคร</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700">อัปโหลดภาพ</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
                    <?php if ($activity['image']): ?>
                        <img src="<?= $activity['image'] ?>" alt="Current Image" class="mt-2 w-32 h-32 object-cover">
                    <?php endif; ?>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" onclick="window.location.href='admin_activity.php'">ยกเลิก</button>
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
 
