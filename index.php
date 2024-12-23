<?php
session_start();
include 'db_connection.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    // ตรวจสอบว่ามีอีเมลและรหัสผ่านในฐานข้อมูลหรือไม่
    $stmt = $conn->prepare("SELECT id, role, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $role, $hashedPassword);
        $stmt->fetch();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $hashedPassword)) {
            
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;

            // นำไปยังหน้า Dashboard ตามบทบาท
            switch ($role) {
                case 'student':
                    header("Location: dashboard_student.php");
                    break;
                case 'teacher':
                    header("Location: dashboard_teacher.php");
                    break;
                case 'admin':
                    header("Location: dashboard_admin.php");
                    break;
            }
            exit();
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง!";
        }
    } else {
        $error = "ไม่พบอีเมลนี้ในระบบ!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
      body {
          font-family: 'Prompt', sans-serif;
          background-color: #ff0080;
      }
  </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <div class="text-center mb-6"> 
            <h1 class="text-2xl font-bold text-gray-800 mt-2">ระบบลงทะเบียนเข้าร่วมกิจกรรม</h1>
        </div>
        <h2 class="text-xl font-semibold text-gray-700 text-center mb-4">เข้าสู่ระบบ</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="index.php">
            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-medium mb-2">อีเมล</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="กรอกอีเมล" 
                    required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-medium mb-2">รหัสผ่าน</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="กรอกรหัสผ่าน" 
                    required>
            </div>
            <button 
                type="submit" 
                class="w-full bg-blue-500 text-white font-medium py-2 rounded-lg hover:bg-blue-600 transition">
                เข้าสู่ระบบ
            </button>
        </form>
        <div class="text-center mt-4">
            <p class="text-gray-600">ยังไม่มีบัญชี? 
                <a href="register.php" class="text-blue-500 font-medium hover:underline">สมัครสมาชิก</a>
            </p>
        </div>
    </div>
</body>
</html>
