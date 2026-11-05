<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHouse.ru - Оставить заявку на дом</title>
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

                <p><a href="#" class="order-link">Заказать проект</a></p><br>

                <ul id="menu_slide">
                  <li><b><a href="javascript:void(0);">Меню 01</a></b></li>
                  <li><b><a href="javascript:void(0);">Меню 02 -></a></b>
                    <ul class="menu_slide">
                      <li><a href="estate.php">Оставить заявку на дом</a></li>
                      <li><a href="search.php">Поиск проекта</a></li>
                      <li><a href="login.php">Вход</a></li>
                    </ul>
                  </li>
                  <li><b><a href="javascript:void(0);">Меню 03 -></a></b>
                    <ul class="menu_slide">
                      <li><a href="#">Ссылка 04</a></li>
                      <li><a href="#">Ссылка 05</a></li>
                    </ul>
                  </li>
                </ul>

                <h3>Категории проектов</h3>
                <ol>
                    <li><a href="townhouses.html" class="townhouse-link">Проекты таунхаусов</a></li>
                    <li><a href="2family.html">Проекты домов на две семьи</a></li>
                </ol>
            </aside>

            <!-- Правая часть (Контент) -->
            <main class="main-content townhouses-bg">
                <h1>Оформление заявки на строительство</h1>
                <p>Заполните форму ниже, и наши специалисты подберут для вас лучший проект или разработают индивидуальный.</p>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $address = isset($_POST['Address']) ? trim($_POST['Address']) : '';
                    $floors  = isset($_POST['Floors']) ? (int)$_POST['Floors'] : 0;
                    $price   = isset($_POST['Price']) ? (float)$_POST['Price'] : 0;
                    $loc_id  = isset($_POST['Location_Id']) ? (int)$_POST['Location_Id'] : 0;

                    if ($address === '' || $floors === 0 || $price <= 0 || $loc_id === 0) {
                        echo '<p class="error-msg">Пожалуйста, заполните все поля.</p>';
                    } else {
                        $stmt = $db->prepare("INSERT INTO House (Address, Floors, Price, Location_Id) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('sidi', $address, $floors, $price, $loc_id);

                        if ($stmt->execute()) {
                            echo '<p class="success-msg">Спасибо! Ваша заявка принята. Менеджер свяжется с вами.</p>';
                        } else {
                            echo '<p class="error-msg">Ошибка при отправке: ' . htmlspecialchars($db->error) . '</p>';
                        }
                    }
                }

                $locations = $db->query("SELECT Id, Name FROM Location");
                ?>

                <form method="post" class="estate-form">
                    <div class="form-group">
                        <label>Желаемый адрес:</label>
                        <input name="Address" type="text" placeholder="ул. Южная" required>
                    </div>
                    <div class="form-group">
                        <label>Желаемая этажность:</label>
                        <select name="Floors" required>
                            <option value="">-- Выберите --</option>
                            <option value="1">1 этаж</option>
                            <option value="2">2 этажа</option>
                            <option value="3">3 этажа</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ваш бюджет (руб):</label>
                        <input name="Price" type="number" step="0.01" placeholder="Например: 5000000" required>
                    </div>
                    <div class="form-group">
                        <label>Предпочтительное направление:</label>
                        <select name="Location_Id" required>
                            <option value="">-- Выберите --</option>
                            <?php while($row = $locations->fetch_assoc()): ?>
                                <option value="<?php echo $row['Id']; ?>"><?php echo htmlspecialchars($row['Name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-submit">Отправить заявку</button>
                    </div>
                </form>

                <p class="links">
                    <a href="townhouses.html">&larr; Вернуться к каталогу проектов</a> | 
                    <a href="search.php">Поискать готовый дом</a>
                </p>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#menu_slide li').click(function (event) {
                event.stopPropagation();
                var submenu = $(this).children('ul');
                if (submenu.length > 0) { submenu.slideToggle(500); }
            });
            $(document).click(function () { $('#menu_slide ul').slideUp(500); });
        });
    </script>
</body>
</html>