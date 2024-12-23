<!-- menu.php -->
<nav class="flex-1">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
        <ul>       
            <li class="px-6 py-2 hover:bg-blue-700"><a href="dashboard_student.php" class="block">กิจกรรม</a></li> 
            <li class="px-6 py-2 hover:bg-blue-700"><a href="new_stu.php" class="block">ข่าวประชาสัมพันธ์</a></li>  
            <li class="px-6 py-2 hover:bg-blue-700"><a href="log_stu_register.php" class="block">ประวัติการลงทะเบียน</a></li> 
            <li class="px-6 py-2 hover:bg-blue-700"><a href="log_stu_act.php" class="block">ประวัติเข้าร่วมกิจกรรม</a></li> 
        </ul>
    <?php endif; ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <ul>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="dashboard_admin.php" class="block">Dashboard</a></li> 
            <li class="px-6 py-2 hover:bg-blue-700"><a href="admin_activity.php" class="block">กิจกรรม</a></li>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="admin_new.php" class="block">ข่าวประชาสัมพันธ์</a></li>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="admin_register.php" class="block">ประวัติการลงทะเบียน</a></li>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="admin_teacher.php" class="block">อาจารย์</a></li>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="admin_stu.php" class="block">ข้อมูลนักศึกษา</a></li>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="admin_log.php" class="block">ประวัติเข้าร่วมกิจกรรม</a></li>
        </ul>
    <?php endif; ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher'): ?>
        <ul>
            <li class="px-6 py-2 hover:bg-blue-700"><a href="dashboard_teacher.php" class="block">Dashboard</a></li>  
            <li class="px-6 py-2 hover:bg-blue-700"><a href="teacher_new.php" class="block">ข่าวประชาสัมพันธ์</a></li> 
            <li class="px-6 py-2 hover:bg-blue-700"><a href="teacher_log.php" class="block">ประวัติเข้าร่วมกิจกรรม</a></li>
        </ul>
    <?php endif; ?>
</nav>

 
