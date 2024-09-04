<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ملفي الشخصي</title>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // عرض بيانات المستخدم
    echo "<h1>مرحباً، " . $_SESSION['username'] . "</h1>";
    echo "<img src='" . $_SESSION['avatar'] . "' alt='Avatar' style='width:150px;height:150px;border-radius:50%;'>";
    echo "<p><a href='logout.php'>تسجيل الخروج</a></p>";
    ?>

</body>
</html>
