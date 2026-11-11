<?php
session_start();

$error = '';

$admin_password = 'admin123'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password']) && $_POST['password'] === $admin_password) {
        $_SESSION['is_admin'] = true;
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = 'Неверный пароль!';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>MyHouse.ru - Вход для сотрудников</title>
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
            </aside>

            <main class="main-content townhouses-bg">
                <h1>Вход для сотрудников</h1>
                <p>Введите служебный пароль для доступа к карточке добавления домов.</p>

                <?php if ($error): ?>
                    <p class="error-msg"><?php echo $error; ?></p>
                <?php endif; ?>

                <form method="post" class="estate-form" style="max-width: 400px;">
                    <div class="form-group">
                        <label>Служебный пароль:</label>
                        <input type="password" name="password" required autofocus>
                    </div>
                    <button type="submit" class="btn-submit">Войти</button>
                </form>
            </main>
        </div>
    </div>
</body>
</html>