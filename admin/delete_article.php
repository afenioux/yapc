<?php

include('../inc/include_fns.php');

$conn = db_connect();

$id_article = $_GET['id_article'];
$sql = "delete from articles where id = $id_article";
$result = mysql_query($sql, $conn);

header('Location: '.$_SERVER['HTTP_REFERER']);
?> 