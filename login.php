<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    include('db.php');
    $query = $con->query("SELECT * FROM users WHERE login='$login' AND password='$password'");
    if (!$query) die('query error: ' . $con->error);
    $user = $query->fetch_assoc();
    if (!$user) {
        echo 'Неверный логин или пароль';
        die();
    }
    session_start();
    $_SESSION['user_id'] = $user['id'];
    // Проверка на администратора
    if ($user['login'] == 'Admin26') {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
    } else {
        header('Location: create.php');
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - Корочки.есть</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #28a745;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Вход в систему</h1>
        <p>Войдите в свой аккаунт</p>

        <form method="POST" action="">
            <label for="login">Логин</label>
            <input type="text" id="login" name="login" required>

            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Войти</button>
        </form>

        <div class="link">
            <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
        </div>
    </div>
</body>
</html>