<header class="bg-white shadow-md flex justify-between items-center px-6 py-4">
    <h2 class="text-lg font-semibold text-gray-800"> </h2>
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2">
            <!-- ใช้ไอคอน Font Awesome สำหรับผู้ใช้ -->
            <i class="fas fa-user-circle text-gray-800 text-2xl"></i>
            <span class="text-gray-800 font-medium"><?php echo $_SESSION['email']; ?></span>
        </div>
        <button 
            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
            onclick="logout()">
            ออกจากระบบ
        </button>
    </div>
</header>
