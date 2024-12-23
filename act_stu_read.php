<?php
session_start();
include('db_connection.php');
// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // หากไม่มีสิทธิ์เข้าถึงหรือไม่ได้ล็อกอิน
    header("Location: index.php"); // เปลี่ยนเป็นหน้าเข้าสู่ระบบของคุณ
    exit();
}
// ตรวจสอบว่าได้ส่ง id มาใน URL หรือไม่
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // ดึงข้อมูลข่าวจากฐานข้อมูล
    $sql = "SELECT * FROM activities WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $news = $result->fetch_assoc();
        $currentDate = new DateTime();
        $startDate = new DateTime($news['start_date']);
        $endDate = new DateTime($news['end_date']);
    } else {
        echo "ไม่พบข้อมูลนี้";
        exit();
    }
} else {
    echo "ไม่พบข้อมูลนี้";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อ่านเพิ่มเติม</title>
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

        <!-- News Details -->
        <main class="p-6 bg-gray-100 flex-1"> 
            <div class="container mx-auto p-6">
                <!-- News Title -->
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-6"><?= $news['name'] ?></h1>
                <?php
                                            
                                            $image_url = $news['image']; // ดึง URL ของรูปภาพจากฐานข้อมูล
                                            ?>
               <!-- News Content -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img  src="<?= $image_url ?>" alt="ข่าว <?= $news['name'] ?>" class="w-full h-64 object-cover">
                    <div class="p-6">
                    


                        <p class="text-gray-600 text-sm mb-4"><?= $news['description'] ?></p>
                        <p class="text-gray-600 text-sm mb-2"><strong>วันเริ่มกิจกรรม:</strong> <?= date('j F Y', strtotime($news['start_date'])) ?></p>
                        <p class="text-gray-600 text-sm mb-2"><strong>เวลาเริ่มกิจกรรม:</strong> <?= date('H:i A', strtotime($news['start_time'])) ?></p>
                        <p class="text-gray-600 text-sm mb-2"><strong>วันสิ้นสุดกิจกรรม:</strong> <?= date('j F Y', strtotime($news['end_date'])) ?></p>
                        <p class="text-gray-600 text-sm mb-2"><strong>เวลาสิ้นสุดกิจกรรม:</strong> <?= date('H:i A', strtotime($news['end_time'])) ?></p>
                        <p class="text-gray-600 text-sm mb-4"><strong>หน่วยกิต:</strong> <?= $news['credits'] ?> หน่วยกิต</p>
                                             
                        
                        <!-- ตรวจสอบว่าเลยวันหรือไม่ -->
                        <?php if ($currentDate < $startDate): ?>
                            <a href="register_act.php?activity_id=<?= $news['id'] ?>" class="text-blue-500 hover:underline">ลงทะเบียน</a>
                        <?php else: ?>
                            <span class="text-gray-500">ไม่สามารถลงทะเบียนได้</span>
                        <?php endif; ?>
                    </div>
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
