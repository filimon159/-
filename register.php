<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    include('db.php');
    $query = $con->query("INSERT INTO users (login, password, fullname, phone, email) VALUES ('$login', '$password', '$fullname', '$phone', '$email')");
    if (!$query) die('query error: ' . $con->error);
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Регистрация - Корочки.есть</title>
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
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        form button:hover {
            background-color: #218838;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        <p>Создайте аккаунт для составления заявки</p>

        <form method="POST" action="">
            <label for="fullname">ФИО</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="phone">Телефон</label>
            <input type="tel" id="phone" name="phone" placeholder="+7(___)___-__-__" pattern="\+7\(\d{3}\)\d{3}-\d{2}-\d{2}" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="login">Логин (латиница, от 6 символов)</label>
            <input type="text" id="login" name="login" pattern="[a-zA-Z0-9\s]{6,}" required>

            <label for="password">Пароль (от 8 символов)</label>
            <input type="password" id="password" name="password" minlength="8" required>

            <button type="submit">Зарегистрироваться</button>
        </form>

        <div class="link">
            <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
        </div>
    </div>
</body>
</html>