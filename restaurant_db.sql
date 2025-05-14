-- إنشاء قاعدة البيانات
CREATE DATABASE IF NOT EXISTS restaurant CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE restaurant;

-- إنشاء جدول الحجوزات
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    date DATE,
    time TIME,
    guests INT
);

-- إنشاء جدول عناصر القائمة
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    image_path VARCHAR(255),
    category VARCHAR(50)
);

-- إضافة بيانات أولية للقائمة
INSERT INTO menu_items (name, description, price, image_path, category) VALUES
('صنيه الوحوش', 'صنيه مشويات مشكله', 250.00, 'images/dish22.jpg', 'trays'),
('صنيه العتاوله', 'صنيه مشويات مكس', 300.00, 'images/dish12.jpg', 'trays'),
('طبق رئيسي 1', 'وصف الطبق الرئيسي 1', 120.00, 'images/dish30.jpg', 'main'),
('طبق رئيسي 2', 'وصف الطبق الرئيسي 2', 150.00, 'images/dish31.jpg', 'main'),
('محشي كرنب', 'محشي كرنب', 80.00, 'images/dish34.jpg', 'mahshi'),
('طاجن ورق عنب', 'طاجن ورق عنب', 90.00, 'images/dish46.jpg', 'mahshi'),
('وجبه سجق', 'وجبه سجق', 110.00, 'images/dish37.jpg', 'rice'),
('ارز', 'ارز بسمتي', 50.00, 'images/dish23.jpg', 'rice'),
('ارز', 'ارز كبسه', 60.00, 'images/dish24.jpg', 'rice'),
('مكس لحوم', 'مكس لحوم', 200.00, 'images/dish39.jpg', 'casserole'),
('طاجن 2', 'وصف طاجن 2', 180.00, 'images/dish44.jpg', 'casserole'),
('طاجن 3', 'وصف طاجن 3', 190.00, 'images/dish45.jpg', 'casserole'),
('ملوخيه', 'ملوخيه', 40.00, 'images/dish55.jpg', 'salads'),
('سلطة', 'سلطة خضراء', 35.00, 'images/dish32.jpg', 'salads'),
('سلطة خضراء', 'سلطة خضراء', 45.00, 'images/dish57.jpg', 'salads'),
('سلطة', 'سلطة طحينه', 30.00, 'images/dish58.jpg', 'salads'),
('سلطة', 'سلطة زبادي', 30.00, 'images/dish59.jpg', 'salads'),
('طحينه', 'طحينه', 25.00, 'images/dish60.jpg', 'salads'),
('بطاطس', 'بطاطس مقليه', 35.00, 'images/dish61.jpg', 'salads');