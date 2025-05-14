<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$message = "";

// إضافة عنصر جديد
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $image_path = $_POST['image_path'] ?? '';
    $category = $_POST['category'] ?? '';

    if ($name && $description && $price && $image_path && $category) {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, description, price, image_path, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $description, $price, $image_path, $category);

        if ($stmt->execute()) {
            $message = "تمت إضافة العنصر بنجاح!";
        } else {
            $message = "حدث خطأ: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "الرجاء ملء جميع الحقول.";
    }
}

// تعديل عنصر
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_item'])) {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $image_path = $_POST['image_path'] ?? '';
    $category = $_POST['category'] ?? '';

    if ($id && $name && $description && $price && $image_path && $category) {
        $stmt = $conn->prepare("UPDATE menu_items SET name=?, description=?, price=?, image_path=?, category=? WHERE id=?");
        $stmt->bind_param("ssdssi", $name, $description, $price, $image_path, $category, $id);

        if ($stmt->execute()) {
            $message = "تم تحديث العنصر بنجاح!";
        } else {
            $message = "حدث خطأ: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "الرجاء ملء جميع الحقول.";
    }
}

// حذف عنصر
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "تم حذف العنصر بنجاح!";
    } else {
        $message = "حدث خطأ: " . $stmt->error;
    }
    $stmt->close();
}

// جلب جميع العناصر لعرضها
$result = $conn->query("SELECT * FROM menu_items");

?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>إدارة قائمة الطعام</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* تنسيقات إضافية */
        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        .edit-btn,
        .delete-btn {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4caf50;
            color: white;
            border: none;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <header>
        <h1>إدارة قائمة الطعام</h1>
        <nav>
            <a href="index.html">الرئيسية</a>
            <a href="admin.php">لوحة المدير</a>
            <a href="admin_menu.php">إدارة القائمة</a>
        </nav>
    </header>

    <section>
        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        <div class="form-container">
            <h2>إضافة عنصر جديد</h2>
            <form method="post">
                <input type="hidden" name="add_item" value="1">
                <label>الاسم:</label>
                <input type="text" name="name" required><br>

                <label>الوصف:</label>
                <textarea name="description" required></textarea><br>

                <label>السعر:</label>
                <input type="number" name="price" step="0.01" required><br>

                <label>مسار الصورة:</label>
                <input type="text" name="image_path" required><br>

                <label>الفئة:</label>
                <select name="category" required>
                    <option value="trays">صواني</option>
                    <option value="main">أطباق رئيسية</option>
                    <option value="mahshi">محاشي</option>
                    <option value="rice">ارز</option>
                    <option value="casserole">طواجن</option>
                    <option value="salads">سلطات</option>
                </select><br>

                <button type="submit">إضافة</button>
            </form>
        </div>

        <h2>عرض جميع العناصر</h2>
        <table>
            <tr>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>السعر</th>
                <th>الصورة</th>
                <th>الفئة</th>
                <th>العمليات</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                    <td><?= htmlspecialchars($row['image_path']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td>
                        <button class="edit-btn" onclick="openEditForm(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', '<?= htmlspecialchars($row['description']) ?>', <?= $row['price'] ?>, '<?= htmlspecialchars($row['image_path']) ?>', '<?= htmlspecialchars($row['category']) ?>')">تعديل</button>
                        <button class="delete-btn" onclick="deleteItem(<?= $row['id'] ?>)">حذف</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div id="editForm" class="form-container" style="display:none;">
            <h2>تعديل عنصر</h2>
            <form method="post">
                <input type="hidden" name="edit_item" value="1">
                <input type="hidden" id="edit_id" name="id">

                <label>الاسم:</label>
                <input type="text" id="edit_name" name="name" required><br>

                <label>الوصف:</label>
                <textarea id="edit_description" name="description" required></textarea><br>

                <label>السعر:</label>
                <input type="number" id="edit_price" name="price" step="0.01" required><br>

                <label>مسار الصورة:</label>
                <input type="text" id="edit_image_path" name="image_path" required><br>

                <label>الفئة:</label>
                <select id="edit_category" name="category" required>
                    <option value="trays">صواني</option>
                    <option value="main">أطباق رئيسية</option>
                    <option value="mahshi">محاشي</option>
                    <option value="rice">ارز</option>
                    <option value="casserole">طواجن</option>
                    <option value="salads">سلطات</option>
                </select><br>

                <button type="submit">حفظ التغييرات</button>
            </form>
        </div>
    </section>

    <script>
        function openEditForm(id, name, description, price, image_path, category) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_image_path').value = image_path;
            document.getElementById('edit_category').value = category;
            document.getElementById('editForm').style.display = 'block';
        }

        function deleteItem(id) {
            if (confirm('هل أنت متأكد من أنك تريد حذف هذا العنصر؟')) {
                window.location.href = 'admin_menu.php?delete_id=' + id;
            }
        }
    </script>

    <?php $conn->close(); ?>
</body>

</html>