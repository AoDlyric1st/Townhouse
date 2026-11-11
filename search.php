<?php 
require 'db.php'; 
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHouse.ru - Поиск проекта</title>
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
                      <li><a href="estate.php">Заявка на дом</a></li>
                      <li><a href="search.php">Поиск проекта</a></li>
                      <li><a href="sales.php">Архив сделок</a></li>
                      <li><a href="login.php">Вход</a></li>
                    </ul>
                  </li>
                </ul>

                <h3>Категории проектов</h3>
                <ol>
                    <li><a href="townhouses.html" class="townhouse-link">Проекты таунхаусов</a></li>
                    <li><a href="2family.html">Проекты домов на две семьи</a></li>
                </ol>
            </aside>

            <main class="main-content townhouses-bg">
                <h1>Поиск готового дома</h1>
                <p>Выберите параметры, и мы найдем дома, которые уже построены и выставлены на продажу.</p>

                <form method="post" class="estate-form" style="max-width: 600px;">
                    <div class="form-group">
                        <label>Что вы ищете?</label>
                        <select name="criterion">
                            <option value="address">По адресу (например: ул. Ленина)</option>
                            <option value="location">По направлению (Юг, Север...)</option>
                            <option value="floors">По количеству этажей</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Введите значение:</label>
                        <input name="value" type="text" placeholder="Введите ваш запрос..." required>
                    </div>

                    <button type="submit" class="btn-submit">Найти дом</button>
                </form>

                <div style="margin-top: 20px;">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $criterion = isset($_POST['criterion']) ? $_POST['criterion'] : '';
                    $value = isset($_POST['value']) ? trim($_POST['value']) : '';

                    if ($value === '') {
                        echo '<p class="error-msg">Введите значение для поиска.</p>';
                        exit;
                    }

                    $safeValue = $db->real_escape_string($value);

                    $sql = "SELECT DISTINCT
                                House.Address AS 'Адрес',
                                House.Floors AS 'Этажи',
                                House.Price AS 'Цена',
                                Location.Name AS 'Направление'
                            FROM Sale
                            JOIN House ON House.Id = Sale.House_Id
                            JOIN Location ON Location.Id = House.Location_Id
                            WHERE ";

                    if ($criterion === 'address') {
                        $sql .= "House.Address LIKE '%" . $safeValue . "%'";
                    } elseif ($criterion === 'location') {
                        $sql .= "Location.Name = '" . $safeValue . "'";
                    } elseif ($criterion === 'floors') {
                        $sql .= "House.Floors = " . (int)$value;
                    } else {
                        exit('Неверный критерий поиска');
                    }

                    $res = $db->query($sql);

                    if ($res === false) {
                        echo '<p class="error-msg">Ошибка SQL: ' . htmlspecialchars($db->error) . '</p>';
                    } elseif ($res->num_rows === 0) {
                        echo '<p>По вашему запросу ничего не найдено. Попробуйте изменить параметры.</p>';
                    } else {
                        echo '<h3>Найдено вариантов: ' . $res->num_rows . '</h3>';
                        echo '<table class="estate-table">';
                        echo '<tr>';
                        while ($field = $res->fetch_field()) {
                            echo '<th>' . htmlspecialchars($field->name) . '</th>';
                        }
                        echo '</tr>';

                        while ($row = $res->fetch_assoc()) {
                            echo '<tr>';
                            foreach ($row as $v) {
                                echo '<td>' . htmlspecialchars((string)$v) . '</td>';
                            }
                            echo '</tr>';
                        }
                        echo '</table>';
                    }
                }
                ?>
                </div>

                <p class="links" style="margin-top: 20px;">
                    <a href="townhouses.html">&larr; Вернуться к каталогу</a> | 
                    <a href="estate.php">Оставить заявку на дом</a>
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