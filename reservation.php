<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$message = ""; // متغير لتخزين الرسائل

// استقبال بيانات النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $guests = $_POST['guests'] ?? '';

    // تأكد أن البيانات غير فارغة
    if ($name && $date && $time && $guests) {
        // إدخال البيانات
        $stmt = $conn->prepare("INSERT INTO reservations (name, email, phone, date, time, guests) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $phone, $date, $time, $guests);

        if ($stmt->execute()) {
            $message = "✅ تم الحجز بنجاح!";
        } else {
            $message = "❌ حدث خطأ أثناء الحجز: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "❗ الرجاء ملء جميع الحقول المطلوبة.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>حجز طاولة</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>حجز طاولة</h1>
        <nav>
            <a href="index.html">الرئيسية</a>
            <a href="about.html">من نحن</a>
            <a href="menu.html">القائمة</a>
            <a href="reservation.php">احجز طاولة</a>
            <a href="contact.html">اتصل بنا</a>
        </nav>
    </header>

    <section>
        <h2>املأ بيانات الحجز</h2>
        <form method="post">
            <label>الاسم:</label>
            <input type="text" name="name" required><br>

            <label>البريد الإلكتروني:</label>
            <input type="email" name="email"><br>

            <label>رقم الهاتف:</label>
            <input type="text" name="phone"><br>

            <label>التاريخ:</label>
            <input type="date" name="date" required><br>

            <label>الوقت:</label>
            <input type="time" name="time" required><br>

            <label>عدد الضيوف:</label>
            <input type="number" name="guests" required><br><br>

            <button type="submit">احجز الآن</button>
        </form>

        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 مطعمنا. جميع الحقوق محفوظة.</p>
    </footer>
</body>

</html>