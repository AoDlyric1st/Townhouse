<?php
session_start();
require 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['Address']);
    $floors = (int)$_POST['Floors'];
    $price = (float)$_POST['Price'];
    $loc_id = (int)$_POST['Location_Id'];
    $image_path = trim($_POST['ImagePath']); 

    if ($address === '' || $floors === 0 || $price <= 0 || $loc_id === 0 || $image_path === '') {
        $message = '<p class="error-msg">Пожалуйста, заполните все поля.</p>';
    } else {
        $stmt = $db->prepare("INSERT INTO House (Address, Floors, Price, Location_Id, ImagePath) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sidis', $address, $floors, $price, $loc_id, $image_path);

        if ($stmt->execute()) {
            $message = '<p class="success-msg">Дом успешно добавлен в базу данных!</p>';
        } else {
            $message = '<p class="error-msg">Ошибка при добавлении: ' . htmlspecialchars($db->error) . '</p>';
        }
    }
}

$locations = $db->query("SELECT Id, Name FROM Location");

// Выход
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>MyHouse.ru - Панель управления</title>
    <link rel="stylesheet" href="final.css">
    <link rel="stylesheet" href="estate.css">
</head>
<body>
    <div class="container">
        <header></header>
        <div class="layout">
            <aside class="sidebar">
                <div class="logo">
                    <a href="index.html"><img src="logo_myhouse.gif" alt="Logo"></a>
                </div>
                <p><a href="index.html">← На главную</a></p>
                <p style="margin-top: 20px;"><a href="?logout=1" style="color: #cc0000; font-weight: bold;">Выйти из панели</a></p>
            </aside>

            <main class="main-content townhouses-bg">
                <h1>Служебная карточка</h1>
                <p>Заполните данные для добавления нового дома в базу недвижимости.</p>

                <?php echo $message; ?>

                <form method="post" class="estate-form">
                    <div class="form-group">
                        <label>Улица (Адрес):</label>
                        <input name="Address" type="text" placeholder="Например: ул. Ленина, д. 15" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Этажность:</label>
                        <select name="Floors" required>
                            <option value="">-- Выберите --</option>
                            <option value="1">1 этаж</option>
                            <option value="2">2 этажа</option>
                            <option value="3">3 этажа</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Цена (руб):</label>
                        <input name="Price" type="number" step="0.01" placeholder="Например: 7500000" required>
                    </div>

                    <div class="form-group">
                        <label>Направление (Район):</label>
                        <select name="Location_Id" required>
                            <option value="">-- Выберите --</option>
                            <?php while($row = $locations->fetch_assoc()): ?>
                                <option value="<?php echo $row['Id']; ?>"><?php echo htmlspecialchars($row['Name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Путь к картинке:</label>
                        <input name="ImagePath" type="text" placeholder="Например: house1.jpg" required>
                    </div>

                    <button type="submit" class="btn-submit">Добавить дом в базу</button>
                </form>
            </main>
        </div>
    </div>
</body>
</html>