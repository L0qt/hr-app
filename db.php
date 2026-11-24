<?php
$link = mysqli_connect("localhost", "root", "", "hr_db");
if (!$link) {
    die("Не удалось подключиться к базе");
}
mysqli_set_charset($link, "utf8mb4");

function h($text) {
    return htmlspecialchars($text);
}
