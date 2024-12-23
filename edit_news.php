<?php
session_start();
include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}

// ตรวจสอบว่า id ถูกส่งมาหรือไม่
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // รับ id ของข่าวที่ต้องการแก้ไข

    // ดึงข้อมูลข่าวจากฐานข้อมูล
    $sql = "SELECT * FROM news WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $publish_date = $row['publish_date'];
        $publish_time = $row['publish_time'];
        $image = $row['image'];
    } else {
        echo "ไม่พบข่าวนี้!";
        exit();
    }
} else {
    echo "ไม่พบ ID ของข่าว!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $title = $_POST['title'];
    $description = $_POST['description'];
    $publish_date = $_POST['publish_date'];
    $publish_time = $_POST['publish_time']; 

    // การอัปโหลดไฟล์ภาพ
    $image = $row['image']; // ใช้ภาพเดิมหากไม่ได้อัปโหลดใหม่
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

    // คำสั่ง SQL สำหรับอัปเดตข้อมูลข่าว
    $sql_update = "UPDATE news SET title = '$title', description = '$description', publish_date = '$publish_date', publish_time = '$publish_time', image = '$image' WHERE id = $id";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: admin_new.php");  
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
    <title>แก้ไขข่าว</title>
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
            <h3 class="text-xl font-bold text-gray-800 mb-4">แก้ไขข่าว</h3>
            <form action="edit_news.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">หัวข้อ</label>
                    <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $title; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">รายละเอียด</label>
                    <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" required><?php echo $description; ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="publish_date" class="block text-gray-700">วันที่</label>
                    <input type="date" id="publish_date" name="publish_date" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $publish_date; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="publish_time" class="block text-gray-700">เวลา</label>
                    <input type="time" id="publish_time" name="publish_time" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $publish_time; ?>" required>
                </div> 
                <div class="mb-4">
                    <label for="image" class="block text-gray-700">อัปโหลดภาพ</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
                    <?php if ($image) { ?>
                        <div class="mt-2">
                            <img src="<?php echo $image; ?>" alt="Image" class="w-32 h-32 object-cover">
                        </div>
                    <?php } ?>
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
