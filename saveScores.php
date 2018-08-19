<?php

    $name = $_POST['name'];
    $seconds = $_POST['seconds'];

require_once 'db/Db.php';

$db = new Db();

$sth = $db->getPdo();

$statement = $sth->prepare("INSERT INTO `highscores`(`id`, `name`, `time`) VALUES (:id, :sname, :sSeconds)");

$statement->execute(array(
    "id" => null,
    "sname" => $name,
    "sSeconds" => $seconds,
));

header("Location: index.php");
exit;