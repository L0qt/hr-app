<?php
require "db.php";

$id = 0;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

$error = "";
$full_name = "";
$birth_date = "";
$passport = "";
$phone = "";
$address = "";
$department = "";
$position = "";
$salary = "";
$hire_date = date("Y-m-d");

// если редактируем — загружаем данные
if ($id > 0 && $_SERVER['REQUEST_METHOD'] == "GET") {
    $res = mysqli_query($link, "SELECT * FROM employees WHERE id = $id");
    $row = mysqli_fetch_assoc($res);

    if (!$row) {
        die("Сотрудник не найден");
    }
    if ($row['is_fired'] == 1) {
        die("Уволенного нельзя редактировать");
    }

    $full_name = $row['full_name'];
    $birth_date = $row['birth_date'];
    $passport = $row['passport'];
    $phone = $row['phone'];
    $address = $row['address'];
    $department = $row['department'];
    $position = $row['position'];
    $salary = $row['salary'];
    $hire_date = $row['hire_date'];
}

// сохранение
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = (int)$_POST['id'];
    $full_name = trim($_POST['full_name']);
    $birth_date = $_POST['birth_date'];
    $passport = trim($_POST['passport']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $department = trim($_POST['department']);
    $position = trim($_POST['position']);
    $salary = $_POST['salary'];
    $hire_date = $_POST['hire_date'];

    if ($full_name == "") {
        $error = "Введите ФИО";
    } elseif ($birth_date == "") {
        $error = "Введите дату рождения";
    } elseif (strlen($passport) != 11) {
        $error = "Паспорт: 0000 000000";
    } elseif (strlen($phone) != 18) {
        $error = "Телефон: +7 (999) 123-45-67";
    } elseif ($address == "") {
        $error = "Введите адрес";
    } elseif ($department == "") {
        $error = "Введите отдел";
    } elseif ($position == "") {
        $error = "Введите должность";
    } elseif ($salary == "" || !is_numeric($salary)) {
        $error = "Введите зарплату";
    } elseif ($hire_date == "") {
        $error = "Введите дату приёма";
    }

    if ($error == "") {
        $f = mysqli_real_escape_string($link, $full_name);
        $b = mysqli_real_escape_string($link, $birth_date);
        $p = mysqli_real_escape_string($link, $passport);
        $ph = mysqli_real_escape_string($link, $phone);
        $a = mysqli_real_escape_string($link, $address);
        $d = mysqli_real_escape_string($link, $department);
        $po = mysqli_real_escape_string($link, $position);
        $s = mysqli_real_escape_string($link, $salary);
        $hd = mysqli_real_escape_string($link, $hire_date);

        if ($id > 0) {
            mysqli_query($link, "UPDATE employees SET
                full_name='$f', birth_date='$b', passport='$p',
                phone='$ph', address='$a', department='$d',
                position='$po', salary='$s', hire_date='$hd'
                WHERE id = $id");
        } else {
            mysqli_query($link, "INSERT INTO employees
                (full_name, birth_date, passport, phone, address, department, position, salary, hire_date)
                VALUES ('$f', '$b', '$p', '$ph', '$a', '$d', '$po', '$s', '$hd')");
        }

        header("Location: index.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Сотрудник</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="top">
    <span><?php if ($id > 0) echo "Редактирование"; else echo "Новый сотрудник"; ?></span>
    <a class="btn" href="index.php">Назад</a>
</div>

<div class="content">
    <?php if ($error != "") echo "<p class='error'>" . h($error) . "</p>"; ?>

    <form method="post" class="form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label>ФИО
            <input type="text" name="full_name" value="<?php echo h($full_name); ?>">
        </label>
        <label>Дата рождения
            <input type="date" name="birth_date" value="<?php echo h($birth_date); ?>">
        </label>
        <label>Паспорт
             <input type="text" id="passport" name="passport" value="<?php echo h($passport); ?>" placeholder="0000 000000" maxlength="11">
        </label>
        <label>Телефон
            <input type="text" id="phone" name="phone" value="<?php echo h($phone); ?>" placeholder="+7 (999) 123-45-67" maxlength="18">
        </label>
        <label>Адрес
            <input type="text" name="address" value="<?php echo h($address); ?>">
        </label>
        <label>Отдел
            <input type="text" name="department" value="<?php echo h($department); ?>">
        </label>
        <label>Должность
            <input type="text" name="position" value="<?php echo h($position); ?>">
        </label>
        <label>Зарплата
            <input type="number" name="salary" value="<?php echo h($salary); ?>">
        </label>
        <label>Дата приёма
            <input type="date" name="hire_date" value="<?php echo h($hire_date); ?>">
        </label>

        <div class="form-buttons">
            <button class="btn blue" type="submit">Сохранить</button>
            <a class="btn" href="index.php">Отмена</a>
        </div>
       </form>
</div>

<script>
// маска паспорта
var passField = document.getElementById("passport");
passField.oninput = function() {
    var v = this.value.replace(/\D/g, "");
    if (v.length > 4) {
        this.value = v.substr(0, 4) + " " + v.substr(4, 6);
    } else {
        this.value = v;
    }
};

// маска телефона
var phoneField = document.getElementById("phone");
phoneField.oninput = function() {
    var v = this.value.replace(/\D/g, "");
    if (v.charAt(0) == "7" || v.charAt(0) == "8") {
        v = v.substr(1);
    }
    v = v.substr(0, 10);
    var out = "+7";
    if (v.length > 0) out += " (" + v.substr(0, 3);
    if (v.length > 3) out += ") " + v.substr(3, 3);
    if (v.length > 6) out += "-" + v.substr(6, 2);
    if (v.length > 8) out += "-" + v.substr(8, 2);
    this.value = out;
};
</script>
</body>
</html>
