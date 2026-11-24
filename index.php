<?php
require "db.php";

$result = mysqli_query($link, "SELECT * FROM employees ORDER BY full_name");
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Сотрудники</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="top">
    <span>Сотрудники</span>
    <a class="btn blue" href="form.php">Добавить</a>
</div>

<div class="content">
    <table>
        <tr>
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Паспорт</th>
            <th>Телефон</th>
            <th>Адрес</th>
            <th>Отдел</th>
            <th>Должность</th>
            <th>Зарплата</th>
            <th>Дата приёма</th>
        </tr>
        <?php
        while ($e = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . h($e['full_name']) . "</td>";
            echo "<td>" . h($e['birth_date']) . "</td>";
            echo "<td>" . h($e['passport']) . "</td>";
            echo "<td>" . h($e['phone']) . "</td>";
            echo "<td>" . h($e['address']) . "</td>";
            echo "<td>" . h($e['department']) . "</td>";
            echo "<td>" . h($e['position']) . "</td>";
            echo "<td>" . number_format($e['salary'], 0, ',', ' ') . " руб.</td>";
            echo "<td>" . h($e['hire_date']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
