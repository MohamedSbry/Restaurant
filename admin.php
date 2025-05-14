<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$sql = "SELECT name, email, phone, date, time, guests FROM reservations ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>لوحة المدير</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
<nav>
    <ul>
        <li><a href="index.html">الرئيسية</a></li>
        <li><a href="admin.php">لوحة المدير</a></li>
        <li><a href="admin_menu.php">إدارة القائمة</a></li>  </ul>
</nav>
    <header>
        <h1>لوحة تحكم المدير</h1>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="admin.php">لوحة المدير</a></li>
                <li><a href="admin_menu.php">إدارة القائمة</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2 style="text-align:center;">عرض جميع الحجوزات</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>رقم الهاتف</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>عدد الضيوف</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["name"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                        <td><?= htmlspecialchars($row["phone"]) ?></td>
                        <td><?= htmlspecialchars($row["date"]) ?></td>
                        <td><?= htmlspecialchars($row["time"]) ?></td>
                        <td><?= htmlspecialchars($row["guests"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center;">لا توجد حجوزات حالياً.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 مطعمنا. جميع الحقوق محفوظة.</p>
    </footer>
</body>

</html>

<?php
$conn->close();
?>