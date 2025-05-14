<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>معرض الصور</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>معرض صور الأطباق</h1>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li><a href="menu.php">القائمة</a></li>
                <li><a href="reservation.php">احجز طاولة</a></li>
                <li><a href="contact.php">اتصل بنا</a></li>
                <li><a href="gallery.php">معرض الصور</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>استمتع بمشاهدة بعض من أطباقنا المميزة!</h2>
        <div class="gallery">
            <img src="images/dish30.jpg" alt="طبق 1" onclick="showPopup(this.src)">
            <img src="images/dish32.jpg" alt="طبق 2" onclick="showPopup(this.src)">
            <img src="images/dish43.jpg" alt="طبق 3" onclick="showPopup(this.src)">
            <img src="images/dish41.jpg" alt="طبق 4" onclick="showPopup(this.src)">
        </div>
    </section>

    <footer>
        <p>&copy; 2025 مطعمنا. جميع الحقوق محفوظة.</p>
    </footer>
    <div id="image-popup" class="popup" onclick="closePopup()">
        <img id="popup-img" src="" alt="صورة مكبرة">
    </div>

    <script>
        function showPopup(src) {
            const popup = document.getElementById("image-popup");
            const popupImg = document.getElementById("popup-img");
            popupImg.src = src;
            popup.style.display = "flex";
        }

        function closePopup() {
            document.getElementById("image-popup").style.display = "none";
        }
    </script>

</body>

</html>