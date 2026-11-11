<?php
session_start();
include('config.php');

$message = ''; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        $message = '<p class="error">Неверные пароль или имя пользователя!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id'];
            $message = '<p class="success">Поздравляем, вы прошли авторизацию!</p>';
        } else {
            $message = '<p class="error">Неверные пароль или имя пользователя!</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&family=Passion+One&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Вход в систему</h1>
    
    <?php echo $message; ?>

    <form method="post" action="" name="signin-form">
        <div class="form-element">
            <label>Username</label>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
        </div>
        <div class="form-element">
            <label>Password</label>
            <input type="password" name="password" required />
        </div>
        <button type="submit" name="login" value="login">Log In</button>
    </form>
    
    <div style="margin-top: 20px; font-family: 'Lato', sans-serif;">
        <a href="register.php" style="color: #0056b3; text-decoration: none;">Нет аккаунта? Зарегистрироваться</a><br><br>
        <a href="index.html" style="color: #777; text-decoration: none;">&larr; Вернуться на главную</a>
    </div>
</body>
</html>