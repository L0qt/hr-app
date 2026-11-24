<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $full_name = trim($_POST['full_name']);
    $birth_date = $_POST['birth_date'];
    $passport = trim($_POST['passport']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $department = trim($_POST['department']);
    $position = trim($_POST['position']);
    $salary = $_POST['salary'];
    $hire_date = $_POST['hire_date'];

    $f = mysqli_real_escape_string($link, $full_name);
    $b = mysqli_real_escape_string($link, $birth_date);
    $p = mysqli_real_escape_string($link, $passport);
    $ph = mysqli_real_escape_string($link, $phone);
    $a = mysqli_real_escape_string($link, $address);
    $d = mysqli_real_escape_string($link, $department);
    $po = mysqli_real_escape_string($link, $position);
    $s = mysqli_real_escape_string($link, $salary);
    $hd = mysqli_real_escape_string($link, $hire_date);

    mysqli_query($link, "INSERT INTO employees
        (full_name, birth_date, passport, phone, address, department, position, salary, hire_date)
        VALUES ('$f', '$b', '$p', '$ph', '$a', '$d', '$po', '$s', '$hd')");

    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Новый сотрудник</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="top">
    <span>Новый сотрудник</span>
    <a class="btn" href="index.php">Назад</a>
</div>

<div class="content">
    <form method="post" class="form">
        <label>ФИО
            <input type="text" name="full_name">
        </label>
        <label>Дата рождения
            <input type="date" name="birth_date">
        </label>
        <label>Паспорт
            <input type="text" name="passport" placeholder="0000 000000" maxlength="11">
        </label>
        <label>Телефон
            <input type="text" name="phone" placeholder="+7 (999) 123-45-67" maxlength="18">
        </label>
        <label>Адрес
            <input type="text" name="address">
        </label>
        <label>Отдел
            <input type="text" name="department">
        </label>
        <label>Должность
            <input type="text" name="position">
        </label>
        <label>Зарплата
            <input type="number" name="salary">
        </label>
        <label>Дата приёма
            <input type="date" name="hire_date">
        </label>
        <div class="form-buttons">
            <button class="btn blue" type="submit">Сохранить</button>
            <a class="btn" href="index.php">Отмена</a>
        </div>
    </form>
</div>
</body>
</html>
