<?php
session_start();
if (!isset($_SESSION['user_id'])) die('Чтобы оставить заявку, надо войти в аккаунт.');

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review = $_POST['review'];
    $date = $_POST['date'];
    $curses = $_POST['curses'];
    $payment = $_POST['payment'];
    $status = 'Новая'; // Статус устанавливается автоматически
    
    include('db.php');
    
    // Для безопасности в реальном проекте используйте подготовленные выражения (prepared statements)
    $user_id = (int)$_SESSION['user_id']; // Защита от SQL-инъекций
    $review = $con->real_escape_string($review);
    $curses = $con->real_escape_string($curses);
    $payment = $con->real_escape_string($payment);
    
    $query = $con->query("INSERT INTO request (review, date, curses, payment, user_id, status) 
                          VALUES ('$review', '$date', '$curses', '$payment', '$user_id', '$status')");
    
    if (!$query) {
        $error = true;
        $error_msg = 'Ошибка: ' . $con->error;
    } else {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание заявки - Конференция.Рф</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 500px;
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
        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form textarea {
            resize: vertical;
            min-height: 100px;
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
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        .success-message a {
            color: #155724;
            font-weight: bold;
            text-decoration: underline;
        }
        .success-message a:hover {
            color: #0b2e13;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
        .btn-history {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn-history:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="history.php" class="btn-history"> История заявок на бронирование</a>
        
        <h1>Создание заявки</h1>

        <?php if ($success): ?>
            <div class="success-message">
                ✅ Заявка успешно отправлена!<br><br>
              
                <a href="history.php">🔍 Перейти к истории моих бронирований →</a>
                <br><br>
                
            </div>
        <?php elseif ($error): ?>
            <div class="error-message">
                ❌ Ошибка при отправке заявки: <?php echo htmlspecialchars($error_msg); ?><br>
                <a href="javascript:history.back()">◀ Попробовать снова</a>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" action="">
            
            <label for="curses">Бронирование помещений для проведения Всероссийских конференций</label>
            <select id="curses" name="curses" required>
                <option value="Аудитория">Аудитория</option>
                <option value="Коворкинг">Коворкинг</option>
                <option value="Кинозал">Кинозал</option>
               
                <!-- Добавьте сюда другие курсы при необходимости -->
            </select>

            <label for="date">Когда желаете забронировать помещений для проведения конференций</label>
            <input id="date" type="datetime-local" name="date" required>

            <label for="payment">Способ оплаты</label>
            <select id="payment" name="payment" required>
                <option value="наличные">Наличные</option>
                <option value="перевод">Переводом по номеру</option>
             
                
            </select>

             <label for="review">Дополнительная информация (пожелания или комментарий)</label>
             <textarea id="review" name="review" placeholder="Опишите ваши пожелания..."></textarea>

             <!-- Поле "статус" не заполняется пользователем, устанавливается системой -->
             
             <button type="submit">Отправить заявку на бронирование</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>