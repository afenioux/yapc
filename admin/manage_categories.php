<?php

include('../inc/include_fns.php');

$method = $_GET['method'];
$conn = db_connect();

if ($method == 'delete'){
	$id_category = $_GET['id_category'];
	$sql = "update articles set id_category = '0' where id_category = '$id_category'";
	mysql_query($sql, $conn);
	$sql = "delete from categories where id = $id_category";
}

elseif ($method == 'new'){
	$name = $_POST['name'];
	$description = $_POST['description'];
	$priority = get_max_priority('categories')+1;
	$sql = "insert into categories (name, description, priority) values ('$name', '$description', '$priority')";
}

elseif ($method == 'edit'){
	$id_category = $_POST['id_category'];
	$name = $_POST['name'];
	$descritpion = $_POST['description'];
	$sql = "update categories
    	set name 		= '$name',
        description 	= '$description'
	where id = '$id_category'";
}

else { header('Location: '.$_SERVER['HTTP_REFERER']); }

$result = mysql_query($sql, $conn);
if (!$result) {
  print "There was a database error when executing <pre>$sql</pre>";
  print mysql_error();
  exit;
}
header('Location: '.$_SERVER['HTTP_REFERER']);
?> 