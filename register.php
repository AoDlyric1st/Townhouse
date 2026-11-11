<?php
session_start();
include('config.php');

$message = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone']; 

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $message = '<p class="error">Этот адрес уже зарегистрирован!</p>';
    } else {
        $query = $connection->prepare("INSERT INTO users(username, password, email, phone) VALUES (:username, :password_hash, :email, :phone)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("phone", $phone, PDO::PARAM_STR); 
        
        $result = $query->execute();

        if ($result) {
            $message = '<p class="success">Регистрация прошла успешно!</p>';
        } else {
            $message = '<p class="error">Неверные данные!</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&family=Passion+One&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Регистрация</h1>
    

    <?php echo $message; ?>

    <form method="post" action="" name="signup-form">
        <div class="form-element">
            <label>Имя</label>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
        </div>
        <div class="form-element">
            <label>Почта</label>
            <input type="email" name="email" required />
        </div>
        <div class="form-element">
            <label>Пароль</label>
            <input type="password" name="password" required />
        </div>
        <div class="form-element">
            <label>Телефон</label>
            <input type="text" name="phone" pattern="[0-9]+" placeholder="Только цифры" required />
        </div>
        <button type="submit" name="register" value="register">Регистрация</button>
    </form>

    <div style="margin-top: 20px; font-family: 'Lato', sans-serif;">
        <a href="login.php" style="color: #0056b3; text-decoration: none;">Войти</a><br><br>
        <a href="index.html" style="color: #777; text-decoration: none;">&larr; Вернуться на главную</a>
    </div>
</body>
</html>