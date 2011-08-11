<?php

include('../inc/include_fns.php');

if ( (!isset($_POST['username'])) || (!isset($_POST['password'])) ) {
  print 'Vous devez entrer votre nom et mot de passe pour continuer';
  exit;
}

$conn = db_connect();

 if(get_magic_quotes_gpc()) {
            $username = stripslashes($_POST['username']);
            $password = stripslashes($_POST['password']);
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];
        }

$username = mysql_real_escape_string($username, $conn);
$password = mysql_real_escape_string($password, $conn);


if (login($username, $password)) {
  $_SESSION['auth_user'] = $username;
  header('Location: '.$_SERVER['HTTP_REFERER']);
}
else {
  print 'Votre couple nom/mot de passe est incorrect';
  exit;
}

?>
