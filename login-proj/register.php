<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>idh7-register</title>
</head>
<body>
    <form action="register.php" method="POST" enctype="multipart/form-data">
        <label for="username">اسم المستخدم:</label>
        <input type="text" name="username" required>
        
        <label for="email">البريد الإلكتروني:</label>
        <input type="email" name="email" required>
        
        <label for="password">كلمة المرور:</label>
        <input type="password" name="password" required>
        
        <label for="avatar">الصورة الرمزية:</label>
        <input type="file" name="avatar">
        
        <button type="submit">تسجيل</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatar = 'uploads/' . basename($_FILES['avatar']['name']);
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar)) {
                echo "<div class='success-message'>تم رفع الصورة بنجاح.</div>";
            } else {
               
            }
        } else {
            switch ($_FILES['avatar']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<div class='error-message'>الملف المرفوع كبير جدًا.</div>";
                    $avatar = 'uploads/default.png';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "<div class='error-message'>تم رفع جزء من الملف فقط.</div>";
                    $avatar = 'uploads/default.png';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<div class='error-message'>لم يتم رفع أي ملف.</div>";
                    $avatar = 'uploads/default.png';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "<div class='error-message'>المجلد المؤقت مفقود.</div>";
                    $avatar = 'uploads/default.png';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "<div class='error-message'>فشل في كتابة الملف إلى القرص.</div>";
                    $avatar = 'uploads/default.png';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "<div class='error-message'>تم إيقاف رفع الملف بواسطة ملحق PHP.</div>";
                    $avatar = 'uploads/default.png';
                    break;
                default:
                    echo "<div class='error-message'>خطأ غير معروف.</div>";
                    $avatar = 'uploads/default.png';
                    break;
            }
        }

        $conn = new mysqli('localhost', 'root', '', 'user_system');
        if ($conn->connect_error) {
            die("فشل الاتصال: " . $conn->connect_error);
        }

        $sql = "INSERT INTO users (username, email, password, avatar) VALUES ('$username', '$email', '$password', '$avatar')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='success-message'>تم التسجيل بنجاح</div>";
        } else {
            echo "<div class='error-message'>خطأ: " . $sql . "<br>" . $conn->error . "</div>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
