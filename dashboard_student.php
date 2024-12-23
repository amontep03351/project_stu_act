<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
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
            include('db_connection.php'); // เชื่อมต่อกับฐานข้อมูล

            // ดึงข้อมูลกิจกรรมที่สถานะเป็น 1 (ใช้งาน) และเรียงลำดับตามวันที่เริ่มกิจกรรม
            $sql = "SELECT * FROM activities WHERE status = 1   ORDER BY start_date ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ?>
                <main class="p-6 bg-gray-100 flex-1">
                    <div class="container mx-auto p-6">
                        <!-- Header -->
                        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">กิจกรรม</h1>
                        <div class="p-6">
                            <input type="text" id="search" placeholder="ค้นหากิจกรรม..." class="w-full p-2 border rounded-lg">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        <?php 
                // เรียกดูข้อมูลกิจกรรม
                while($activity = $result->fetch_assoc()) {
                    // ตรวจสอบวันที่กิจกรรม
                    $currentDate = new DateTime();
                    $startDate = new DateTime($activity['start_date']);
                    $endDate = new DateTime($activity['end_date']);

                           
                        ?>
                            <!-- News Cards Grid -->
                            
                               <!-- Card -->
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden activity-card">
                                            <?php
                                            
                                            $image_url = $activity['image']; // ดึง URL ของรูปภาพจากฐานข้อมูล
                                            ?>

                                        <img src="<?= $image_url ?>" alt="กิจกรรม <?= htmlspecialchars($activity['name']) ?>" class="w-full h-48 object-cover">                                    <div class="p-6">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-2 activity-name"><?= $activity['name'] ?></h2> 

                                    <!-- วันที่และเวลา -->
                                        <div class="text-sm text-gray-600 space-y-4">
                                            <div class="flex items-center space-x-2">
                                                <!-- Icon สำหรับช่วงวันที่ -->
                                                <i class="fas fa-calendar-day text-blue-500"></i>
                                                <p> <?= date('j F Y', strtotime($activity['start_date'])) ?> ถึง <?= date('j F Y', strtotime($activity['end_date'])) ?></p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <!-- Icon สำหรับช่วงเวลา -->
                                                <i class="fas fa-clock text-blue-500"></i>
                                                <p>  <?= date('H:i A', strtotime($activity['start_time'])) ?> - <?= date('H:i A', strtotime($activity['end_time'])) ?></p>
                                            </div>
                                        </div>


                                        <!-- ลิงก์เพิ่มเติม -->
                                        <div class="mt-4 space-x-4">
                                            <a href="act_stu_read.php?id=<?= $activity['id'] ?>" class="text-blue-500 text-sm hover:underline">อ่านเพิ่มเติม</a>
                                            
                                            <!-- ตรวจสอบว่าเลยวันหรือไม่ -->
                                            <?php if ($currentDate > $startDate): ?>
                                                <a href="javascript:void(0);" onclick="confirmRegistration(<?= $activity['id'] ?>)" class="text-blue-500 text-sm hover:underline">ลงทะเบียน</a>
 
                                            <?php else: ?>
                                                <span class="text-gray-500 text-sm">ไม่สามารถลงทะเบียนได้</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                    
                    <?php
                }  ?>
                </div>
                </div>
                </main> <?php
            } else {
                echo "ไม่มีข้อมูลกิจกรรม";
            }

            $conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
            ?>

    </div>

    <!-- JavaScript --> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // เมื่อมีการพิมพ์ในช่องค้นหา
            $('#search').on('keyup', function() {
                var query = $(this).val().toLowerCase(); // คำค้นที่พิมพ์
                $('.activity-card').each(function() {
                    var activityName = $(this).find('.activity-name').text().toLowerCase(); // ชื่อกิจกรรม
                    var activityDescription = $(this).find('.activity-description').text().toLowerCase(); // รายละเอียดกิจกรรม
                    
                    // ตรวจสอบว่า ชื่อหรือรายละเอียดกิจกรรมตรงกับคำค้นหรือไม่
                    if (activityName.includes(query) || activityDescription.includes(query)) {
                        $(this).show(); // แสดงกิจกรรม
                    } else {
                        $(this).hide(); // ซ่อนกิจกรรม
                    }
                });
            });
        });
        function logout() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = "logout.php";
            }
        }
        function confirmRegistration(activityId) {
            // แสดงกล่องยืนยัน
            if (confirm("คุณต้องการลงทะเบียนกิจกรรมนี้หรือไม่?")) {
                // ถ้าผู้ใช้กดยืนยัน จะเปลี่ยนเส้นทางไปยังหน้าลงทะเบียน
                window.location.href = "add_register.php?activity_id=" + activityId;
            }
        }
    </script>

</body>
</html>
