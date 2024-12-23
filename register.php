<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Face Registration</title>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
      body {
          font-family: 'Prompt', sans-serif;
          background-color: #ff0080;
      }
  </style>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">สมัครสมาชิก</h1>
    <form id="registrationForm" class="space-y-4" method="POST" action="process_registration.php">
      <div>
        <label for="studentId" class="block text-gray-600 font-medium">รหัสนักศึกษา</label>
        <input type="text" id="studentId" name="studentId" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
      </div>
      <div>
        <label for="firstName" class="block text-gray-600 font-medium">ชื่อ</label>
        <input type="text" id="firstName" name="firstName" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
      </div>
      <div>
        <label for="lastName" class="block text-gray-600 font-medium">นามสกุล</label>
        <input type="text" id="lastName" name="lastName" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
      </div>
      <div>
        <label for="email" class="block text-gray-600 font-medium">อีเมล</label>
        <input type="email" id="email" name="email" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
      </div>
      <div>
        <label for="password" class="block text-gray-600 font-medium">รหัสผ่าน</label>
        <input type="password" id="password" name="password" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
      </div>

      <div>
        <label for="year" class="block text-gray-600 font-medium">ชั้นปี</label>
        <select id="year" name="year" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
          <?php
          include 'db_connection.php';
          $result = $conn->query("SELECT id, year_name FROM years");
          while ($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['year_name']}</option>";
          }
          ?>
        </select>
      </div>
      <div>
        <label for="program" class="block text-gray-600 font-medium">หลักสูตร</label>
        <select id="program" name="program" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
          <?php
          $result = $conn->query("SELECT id, program_name FROM programs");
          while ($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['program_name']}</option>";
          }
          ?>
        </select>
      </div>
      <div>
        <label for="department" class="block text-gray-600 font-medium">สาขา</label>
        <select id="department" name="department" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
          <?php
          $result = $conn->query("SELECT id, department_name FROM departments");
          while ($row = $result->fetch_assoc()) {
              echo "<option value='{$row['id']}'>{$row['department_name']}</option>";
          }
          $conn->close();
          ?>
        </select>
      </div>
      <div class="text-center">
        <button type="submit" class="w-full bg-purple-500 text-white py-2 px-4 rounded-lg hover:bg-purple-600 focus:outline-none focus:ring focus:ring-purple-300">
          ลงทะเบียน
        </button>
      </div>
    </form>
  </div>
</body>
</html>
