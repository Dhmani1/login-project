<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>تسجيل الدخول</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">اسم المستخدم:</label>
        <input type="text" name="username" required>
        
        <label for="password">كلمة المرور:</label>
        <input type="password" name="password" required>
        
        <button type="submit">تسجيل الدخول</button>
    </form>
</body>
</html>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $conn = new mysqli('localhost', 'root', '', 'user_system');
    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];
            
            header("Location: profile.php");
            exit();
        } else {
            echo "كلمة المرور غير صحيحة";
        }
    } else {
        echo "المستخدم غير موجود";
    }
    
    $conn->close();
}
?>
