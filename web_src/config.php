<?php
$link = mysql_connect('localhost:1009', 'root', 'root');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db('taxi_pickups', $link)) {
    echo 'Could not select database';
    exit;
}
?>
