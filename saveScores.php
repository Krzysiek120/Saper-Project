<?php

    $name = $_POST['name'];
    $seconds = $_POST['seconds'];

require_once 'db/Db.php';

$db = new Db();

$sth = $db->getPdo();

$statement = $sth->query("INSERT INTO `highscores`(`id`, `name`, `time`) VALUES (null, $name,$seconds)");

header('location', 'index.php');