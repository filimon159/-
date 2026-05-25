<?php
include('db.php');
session_start();
if (!$_SESSION['admin']) die('Чтобы посмотреть панель администратора, надо войти в его аккаунт.');

// Обработка изменения статуса заявки
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $query = $con->query("UPDATE request SET status='$status' WHERE id=$request_id");
    if (!$query) die('update error: ' . $con->error);
}

// Получение всех заявок с данными пользователей
$query = $con->query("SELECT request.*, users.login, users.fullname 
                      FROM request 
                      INNER JOIN users ON request.user_id = users.id");
if (!$query) die('query error: ' . $con->error);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель Администратора</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 900px;
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
        .request-card {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .request-card h2 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
        }
        .request-card b {
            display: inline-block;
            width: 150px;
            margin-bottom: 5px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form select,
        form button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Панель администратора</h1>
        <p>Управление заявками пользователей</p>

        <?php
        $i = 0;
        while ($request = $query->fetch_assoc()) {
            $i++;
        ?>
            <div class="request-card">
                <h2>Заявка №<?= $i ?> от <?= htmlspecialchars($request['login']) ?></h2>
                <b>ФИО:</b> <?= htmlspecialchars($request['fullname']) ?><br>
                <b>Дата:</b> <?= htmlspecialchars($request['date']) ?><br>
                <b>Вид услуги:</b> <?= htmlspecialchars($request['curses']) ?><br>
                <b>Тип оплаты:</b> <?= htmlspecialchars($request['payment']) ?><br>
                <b>Статус:</b>
                <form action="" method="POST">
                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                    <select name="status">
                        <option <?= $request['status'] == 'Новая' ? 'selected' : '' ?> value="Новая">Новая</option>
                        <option <?= $request['status'] == 'Мероприятие назначено' ? 'selected' : '' ?> value="Мероприятие назначено">Мероприятие назначено</option>
                        <option <?= $request['status'] == 'Мероприятие завершено' ? 'selected' : '' ?> value="Мероприятие завершено">Мероприятие завершено</option>
                    </select>
                    <button type="submit">Сохранить</button>
                </form>
                <hr style="margin: 20px 0; border: 0; border-top: 1px dashed #ccc;">
            </div>
        <?php } ?>
    </div>
</body>
</html>