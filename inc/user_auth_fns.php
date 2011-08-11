<?php
function login($username, $password) {
// check username and password with db

  $conn = db_connect();
  if (!$conn)
    return 0;

  $result = mysql_query("select * from writers
                         where username='$username'
                         and password = password('$password')");
  if (!$result)
     return 0;
  
  if (mysql_num_rows($result)>0)
     return 1;
  else 
     return 0;
}


function check_auth_user() {
// see if somebody is logged in and notify them if not

  if (isset($_SESSION['auth_user']))
    return true;
  else
    return false;
}

function get_auth_user_id($auth_user) {
  $conn = db_connect();
  $sql = "select id from writers where username = '$auth_user'";
  $result = mysql_query($sql, $conn);
  return(mysql_result($result, 0, 0));
}


function print_login_form() {
?>
<div class="pagearea">
	<div class="formarea">
	
		<table border="0" width="100%">
			<tr>
				<td>
					<center><h1>Merci de vous authentifier</h1></center>
					
					<form action="login.php" method="post">
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
								<td></td>
								<td><input type="submit" value="Connexion"></td>
							</tr>
						</table>
					</form>
					
				<br/>	
				</td>
			</tr>
		</table>
		
	</div>
</div>
<?php
}
?>