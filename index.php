
<link href="https://fonts.googleapis.com/css?family=Hanalei+Fill" rel="stylesheet">


<?php

require_once 'db/Db.php';

$db = new Db();

$sth = $db->getPdo();

$statement = $sth->query("SELECT * FROM `highscores` ORDER BY `time`");

require_once 'frontpage.php';
