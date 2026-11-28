<?php
require "db.php";

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

$dept = "";
if (isset($_GET['department'])) {
    $dept = $_GET['department'];
}

$pos = "";
if (isset($_GET['position'])) {
    $pos = $_GET['position'];
}

$sql = "SELECT * FROM employees WHERE 1=1";

if ($search != "") {
    $s = mysqli_real_escape_string($link, $search);
    $sql = $sql . " AND full_name LIKE '%$s%'";
}
if ($dept != "") {
    $d = mysqli_real_escape_string($link, $dept);
    $sql = $sql . " AND department = '$d'";
}
if ($pos != "") {
    $p = mysqli_real_escape_string($link, $pos);
    $sql = $sql . " AND position = '$p'";
}

$sql = $sql . " ORDER BY is_fired ASC, full_name ASC";
$result = mysqli_query($link, $sql);
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
    <form class="filters" method="get">
        <input type="text" name="search" placeholder="Поиск по ФИО" value="<?php echo h($search); ?>">

        <select name="department">
            <option value="">Все отделы</option>
            <?php
            $res = mysqli_query($link, "SELECT DISTINCT department FROM employees ORDER BY department");
            while ($row = mysqli_fetch_assoc($res)) {
                $d = $row['department'];
                if ($d == $dept) {
                    echo "<option value='" . h($d) . "' selected>" . h($d) . "</option>";
                } else {
                    echo "<option value='" . h($d) . "'>" . h($d) . "</option>";
                }
            }
            ?>
        </select>

        <select name="position">
            <option value="">Все должности</option>
            <?php
            $res = mysqli_query($link, "SELECT DISTINCT position FROM employees ORDER BY position");
            while ($row = mysqli_fetch_assoc($res)) {
                $p = $row['position'];
                if ($p == $pos) {
                    echo "<option value='" . h($p) . "' selected>" . h($p) . "</option>";
                } else {
                    echo "<option value='" . h($p) . "'>" . h($p) . "</option>";
                }
            }
            ?>
        </select>

        <button class="btn" type="submit">Применить</button>
        <a class="btn" href="index.php">Сбросить</a>
    </form>

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
            <th>Статус</th>
            <th></th>
        </tr>
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11' class='empty'>Ничего не найдено</td></tr>";
        }

        while ($e = mysqli_fetch_assoc($result)) {
            if ($e['is_fired'] == 1) {
                echo "<tr class='fired'>";
            } else {
                echo "<tr>";
            }

            echo "<td>" . h($e['full_name']) . "</td>";
            echo "<td>" . h($e['birth_date']) . "</td>";
            echo "<td>" . h($e['passport']) . "</td>";
            echo "<td>" . h($e['phone']) . "</td>";
            echo "<td>" . h($e['address']) . "</td>";
            echo "<td>" . h($e['department']) . "</td>";
            echo "<td>" . h($e['position']) . "</td>";
            echo "<td>" . number_format($e['salary'], 0, ',', ' ') . " руб.</td>";
            echo "<td>" . h($e['hire_date']) . "</td>";

            if ($e['is_fired'] == 1) {
                echo "<td><span class='badge red'>Уволен</span></td>";
            } else {
                echo "<td><span class='badge green'>Работает</span></td>";
            }

            echo "<td>";
            if ($e['is_fired'] == 0) {
                echo "<a class='btn small' href='form.php?id=" . $e['id'] . "'>Изменить</a> ";
                echo "<form method='post' action='fire.php' style='display:inline' onsubmit='return confirm(\"Уволить?\")'>";
                echo "<input type='hidden' name='id' value='" . $e['id'] . "'>";
                echo "<button class='btn small red' type='submit'>Уволить</button>";
                echo "</form>";
            } else {
                echo "—";
            }
            echo "</td>";

            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
