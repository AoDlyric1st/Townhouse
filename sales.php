<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHouse.ru - Архив сделок</title>
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
                      <li><a href="estate.php">Оставить заявку</a></li>
                      <li><a href="search.php">Поиск проекта</a></li>
                      <li><a href="sales.php">Архив сделок</a></li>
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

            <main class="main-content townhouses-bg">
                <h1>Архив успешных сделок</h1>
                <p>Здесь представлены дома, которые уже нашли своих владельцев с помощью нашего агентства.</p>

                <?php
                $countQuery = $db->query("SELECT COUNT(*) AS total FROM Sale");
                $totalSales = $countQuery->fetch_assoc()['total'];
                echo "<h3 style='margin-bottom: 20px; color: #0056b3;'>Всего успешно закрыто сделок: " . $totalSales . "</h3>";

                $sql = "SELECT 
                            Sale.ContractNumber AS 'Договор',
                            Sale.SaleDate AS 'Дата',
                            House.Address AS 'Адрес',
                            House.Floors AS 'Этажи',
                            House.Price AS 'Цена',
                            Location.Name AS 'Направление',
                            Client.SecondName AS 'Клиент',
                            Realtor.SecondName AS 'Риэлтор'
                        FROM Sale
                        JOIN House ON House.Id = Sale.House_Id
                        JOIN Location ON Location.Id = House.Location_Id
                        JOIN Client ON Client.Id = Sale.Client_Id
                        JOIN Realtor ON Realtor.Id = Sale.Realtor_Id
                        ORDER BY Sale.SaleDate DESC"; 

                $result = $db->query($sql);

                if ($result->num_rows === 0) {
                    echo '<p>Сделок пока нет.</p>';
                } else {
                    echo '<table class="estate-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>№ Договора</th>';
                    echo '<th>Дата</th>';
                    echo '<th>Адрес</th>';
                    echo '<th>Этажи</th>';
                    echo '<th>Стоимость (руб)</th>';
                    echo '<th>Направление</th>';
                    echo '<th>Клиент</th>';
                    echo '<th>Риэлтор</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['Договор']) . '</td>';
                        echo '<td>' . date('d.m.Y', strtotime($row['Дата'])) . '</td>'; // Форматируем дату
                        echo '<td>' . htmlspecialchars($row['Адрес']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Этажи']) . '</td>';
                        echo '<td>' . number_format($row['Цена'], 0, '', ' ') . '</td>'; 
                        echo '<td>' . htmlspecialchars($row['Направление']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Клиент']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Риэлтор']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                }
                ?>
                
                <p class="links" style="margin-top: 25px;">
                    <a href="townhouses.html" style="font-weight: bold; color: #cc0000;">&larr; Вернуться к каталогу</a> | 
                    <a href="estate.php">Оставить новую заявку</a>
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