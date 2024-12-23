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

            
            $sql = "SELECT * FROM news ORDER BY publish_date DESC, publish_time DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ?>
                <main class="p-6 bg-gray-100 flex-1">
                    <div class="container mx-auto p-6">
                        <!-- Header -->
                        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">ข่าวประชาสัมพันธ์</h1>
                        <div class="p-6">
                            <input type="text" id="search" placeholder="ค้นหาข่าวประชาสัมพันธ์.." class="w-full p-2 border rounded-lg">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        <?php 
                // เรียกดูข้อมูลข่าวประชาสัมพันธ์
                while($activity = $result->fetch_assoc()) {
                  

                           
                        ?>
                            <!-- News Cards Grid -->
                            
                                <!-- Card -->
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden activity-card">
                                    <img src="<?= $activity['image'] ?>" alt="หัวข้อข่าว <?= $activity['title'] ?>" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-2 activity-name"><?= $activity['title'] ?></h2> 
                                        <p class="text-gray-600 text-sm mb-2"><strong>วันที่ : </strong> <?= date('j F Y', strtotime($activity['publish_date'])) ?></p>
                                        <p class="text-gray-600 text-sm mb-2"><strong>เวลา :</strong> <?= date('H:i A', strtotime($activity['publish_time'])) ?></p> 
                                        
                                        <a href="new_stu_read.php?id=<?= $activity['id'] ?>" class="text-blue-500 hover:underline">อ่านเพิ่มเติม</a>
                                         
                                    </div>
                                </div>
                            
                    
                    <?php
                }  ?>
                </div>
                </div>
                </main> <?php
            } else {
                echo "ไม่มีข้อมูล";
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
                    var activityName = $(this).find('.activity-name').text().toLowerCase(); 
                    var activityDescription = $(this).find('.activity-description').text().toLowerCase();  
                    
                    
                    if (activityName.includes(query) || activityDescription.includes(query)) {
                        $(this).show();  
                    } else {
                        $(this).hide();  
                    }
                });
            });
        });
        function logout() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = "logout.php";
            }
        }
    </script>

</body>
</html>
