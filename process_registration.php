<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = $conn->real_escape_string($_POST['studentId']);
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $year = $conn->real_escape_string($_POST['year']);
    $program = $conn->real_escape_string($_POST['program']);
    $department = $conn->real_escape_string($_POST['department']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // เข้ารหัสรหัสผ่าน

    if (!empty($studentId) && !empty($firstName) && !empty($lastName) && !empty($year) && 
        !empty($program) && !empty($department) && !empty($email) && !empty($password)) {

        $sql = "INSERT INTO users (student_id, first_name, last_name, year_id, program_id, branch_id, email, password) 
                VALUES ('$studentId', '$firstName', '$lastName', '$year', '$program', '$department', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('ลงทะเบียนสำเร็จ!'); window.location.href = 'register.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
    }
}

$conn->close();
?>
