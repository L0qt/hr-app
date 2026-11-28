<?php
require "db.php";

$id = (int)$_POST['id'];

if ($id > 0) {
    mysqli_query($link, "UPDATE employees SET is_fired = 1 WHERE id = $id");
}

header("Location: index.php");
