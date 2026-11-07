<?php
$connection = mysqli_connect(
    "localhost",
    "root",
    "",
    "night_runners"
);

if (!$connection) {
    die("Ошибка подключения к базе данных");
}
?>