<?php

include('../inc/include_fns.php');
include ('inc/header.php');

if (!check_auth_user()) {
	print_login_form();
}
else {
	?>
	
<div class="pagearea">
<div class="titlearea formarea">
<h1>Gestion des utilisateurs</h1>
</div>

<div class="formarea">
<?php
if ( isset($_GET['new']) ){
	$_SESSION['destination'] = $_SERVER['HTTP_REFERER'];
	if ( $_POST['username'] != "" && $_POST['password'] != "" && $_POST['password2'] != "" ){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		if ($password == $password2) {
			$conn = db_connect();
			$sql = "insert into writers (username, password) values ('$username', password('$password') )";
			$result = mysql_query($sql, $conn);

			if (!$result) {
			  print "Désolé, mais il y a eu une erreur... <pre>$sql</pre>";
			  print mysql_error();
			  exit;
			}else {
			print "<h2>Utilisateur créé avec succès!</h2>";
			print '<a href="index.php"><img src="img/precedent_natural.png" align="middle" border="0"></a> ';
			print '<a href="index.php">retourner au menu principal</a>';
			}
			
		}else {
			print 'Vous avez entré deux mots de passe différents.';
		}
		
	}else {
		print 'Merci de compléter tous les champs';
	}
	
	
	
} elseif ( isset($_GET['edit']) && $_GET['edit'] !="" ){
	$_SESSION['destination'] = 'users.php';
	$id_writer = $_GET['edit'];
	
	if ( $_POST['username'] != "" && $_POST['old_password'] != "" && $_POST['password'] != "" && $_POST['password2'] != "" ){
		$username = $_POST['username'];
		$old_password = $_POST['old_password'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		
		if ( login(get_writer_name($id_writer), $old_password) && $password == $password2) {
			$conn = db_connect();
			$sql = "update writers set username = '$username', password = password('$password') where id = '$id_writer'";
			$result = mysql_query($sql, $conn);

			if (!$result) {
			  print "Désolé, mais il y a eu une erreur... <pre>$sql</pre>";
			  print mysql_error();
			  exit;
			}else {
			print "<h2>Modification effectuée avec succès!</h2>";
			print '<a href="index.php"><img src="img/precedent_natural.png" align="middle" border="0"></a> ';
			print '<a href="index.php">retourner au menu principal</a>';
			}
			
		}else {
			print 'Mots de passe incorrects.';
			$_SESSION['destination'] = $_SERVER['HTTP_REFERER'];
		}
		
	}elseif ( !isset($_POST['username']) && !isset($_POST['old_password']) && !isset($_POST['password']) && !isset($_POST['password2']) ){
		print 'Editer un utilisateur';
		
	?>
		<form action="users.php?edit=<?php print $id_writer; ?>" method="post">
			<table border="0" align="center" >
				<tr>
				<td>Nom d'utilisateur</td>
				<td><input size="16" name="username" value="<?php print get_writer_name($id_writer); ?>"></td>
				</tr>
				
				<tr>
				<td>Ancien mdp</td>
				<td><input size="16" type="password" name="old_password"></td>
				</tr>
				
				<tr>
				<td>Mot de passe</td>
				<td><input size="16" type="password" name="password"></td>
				</tr>
				
				<tr>
				<td>Mot de passe</td>
				<td><input size="16" type="password" name="password2"></td>
				</tr>
				
				<tr>
				<td></td>
				<td><input type="submit" value="Modifier"></td>
				</tr>
			</table>
		</form>
	<?php
	}else {
		print 'Merci de compéter tous les champs';
		$_SESSION['destination'] = $_SERVER['HTTP_REFERER'];
	}

	
	
	
	
} elseif ( isset($_GET['delete']) && $_GET['delete'] !="" ){
	$conn = db_connect();
	$id_writer = $_GET['delete'];
	$sql = "delete from writers where id = '$id_writer'";
	$result = mysql_query($sql, $conn);
	$_SESSION['destination'] = $_SERVER['HTTP_REFERER'];
	if (!$result) {
		print "There was a database error when executing <pre>$sql</pre>";
		print mysql_error();
		exit;
	}else {
			print "<h2>Utilisateur supprimé avec succès!</h2>";
			print '<a href="index.php"><img src="img/precedent_natural.png" align="middle" border="0"></a> ';
			print '<a href="index.php">retourner au menu principal</a>';
	}

	
} else {
	$_SESSION['destination'] = 'index.php';
	$conn = db_connect();
	$sql = 'select * from writers';
	$result = mysql_query($sql, $conn);
	if (!$result) {
		print "There was a database error when executing <pre>$sql</pre>";
		print mysql_error();
		exit;
	}
		
	print "<table>\n";
	while ($writer = mysql_fetch_array($result)) {
		
		print '<tr>';
		print '<td>';
		print $writer['username'];
		print '</td>';
		print '<td>';
		if ( mysql_num_rows($result) > 1 ) {
			print '[<a href="users.php?edit='.$writer['id'].'">éditer</a>] ';
			print '[<a href="users.php?delete='.$writer['id'].'" onclick="return confirm(\'Etes vous sur de vouloir supprimer l\\\'utilisateur '.$writer['username'].'?\')">supprimer</a>] ';
		}else {
			print '[pas de modification possible : 1 seul utilisateur] ';
		}
		print '</td>';
		print '</tr>';
	}
?>	
</table>
</div>

<div class="formarea">
<a href="javascript:document.getElementById('add_form').style.display = ''; void(0);">Ajouter un utilisateur</a>

		<form action="users.php?new" method="post" style="display : none" id="add_form">
			<table border="0" align="center" >
				<tr>
				<td>Nom d'utilisateur</td>
				<td><input size="16" name="username"></td>
				</tr>
				
				<tr>
				<td>Mot de passe</td>
				<td><input size="16" type="password" name="password"></td>
				</tr>
				
				<tr>
				<td>Mot de passe</td>
				<td><input size="16" type="password" name="password2"></td>
				</tr>
				
				<tr>
				<td></td>
				<td><input type="submit" value="Créer"></td>
				</tr>
			</table>
		</form>


<?php
}
?>
</div>
<div class="backarea">
	<a href="<?php print $_SESSION['destination']; ?>"><img src="img/precedent_natural.png">retour</a>
</div>
</div>
<?php	
	include ('inc/footer.php');
}
?>
