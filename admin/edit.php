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
<h1> Editer les articles et leurs catégories</h1>
</div>

<div class="formarea">
<?php
	$_SESSION['destination'] = 'edit.php';
	$conn = db_connect();
	$sql = 'select * from categories order by priority asc';
	$result = mysql_query($sql, $conn);
	if (!$result) {
		print "There was a database error when executing <pre>$sql</pre>";
		print mysql_error();
		exit;
	}
	
	while ($category = mysql_fetch_array($result)) {
	
		print '<h2>'.$category['name'];
		if ($category['id'] != 1) {
			print ' [<a href="manage_categories.php?method=delete&id_category='.$category['id'].'" 
			onclick="return confirm(\'Etes vous sur de vouloir supprimer la catégorie nommée : '
			.addslashes($category['name']).'?\')"><small>supprimer</small></a>]';
		}
		if ($category['description']){
		    print '<small> ('.$category['description'].')</small>';
		}
		print '</h2>';
		 
		$sql = "select * from articles where id_category = '".$category['id']."'order by priority desc";
		$result2 = mysql_query($sql, $conn);
		if (!$result2) {
		  print "There was a database error when executing <pre>$sql</pre>";
		  print mysql_error();
		  exit;
		}
		 
		  if (mysql_num_rows($result2)) {
		    print "<table id=\"edit\">\n";
		    print "<tr><th>Titre</th><th>Auteur</th>\n";
		    print "<th>création</th><th>Dernière modification</th><th>Publication</th></tr>\n";
		    while ($article = mysql_fetch_array($result2)) {
		      print '<tr>';
		      print '<td>';
		      print $article['title'];
		      print '</td>';
		      print '<td>';
		      print get_article_author($article['id']);
		      print '</td>';
		      print '<td>';
		      print date('d M, H:i', $article['created']);
		      print '</td>';
		      print '<td>';
		      print date('d M, H:i', $article['modified']);
		      print '</td>';
		      print '<td>';
		      if ($article['published']){
		      print date('d M, H:i', $article['published']);
		      }else{
		      	print "Non publié";
		      }
		      print '</td>';
		      print '<td>';
		      print '[<a href="new_article?id_article='.$article['id'].'">éditer</a>] ';
		      print '[<a href="delete_article.php?id_article='.$article['id'].'" onclick="return confirm(\'Etes vous sur de vouloir supprimer l\\\'article intitulé : '.addslashes($article['title']).'?\')">supprimer</a>] ';
		      print '</td>';
		      print '</tr>';
		    }
		    print "</table><br/>\n";
		  } else { print 'Pas d\'article dans cette catégorie.<br />'; }
		  print '<a href="new_article.php?id_category='.$category['id'].'">Postez un article dans cette categorie!</a><br /><hr><br />';

	}
		$sql = "select * from articles where id_category = '0' order by priority";
		$result3 = mysql_query($sql, $conn);
		if (!$result3) {
			print "There was a database error when executing <pre>$sql</pre>";
			print mysql_error();
			exit;
		}  
		print '<h2>Articles sans catégorie</h2>';
		 if (mysql_num_rows($result3)) {
		    print "<table id=\"edit\">\n";
		    print "<tr><th>Titre</th><th>Auteur</th>\n";
		    print "<th>création</th><th>Dernière modification</th><th>Publication</th></tr>\n";
		    while ($article = mysql_fetch_array($result3)) {
		      print '<tr>';
		      print '<td>';
		      print $article['title'];
		      print '</td>';
		      print '<td>';
		      print get_article_author($article['id']);
		      print '</td>';
		      print '<td>';
		      print date('d M, H:i', $article['created']);
		      print '</td>';
		      print '<td>';
		      print date('d M, H:i', $article['modified']);
		      print '</td>';
		      print '<td>';
		      if ($article['published']){
		      print date('d M, H:i', $article['published']);
		      }else{
		      	print "Non publié";
		      }
		      print '</td>';
		      print '<td>';
		      print '[<a href="new_article?id_article='.$article['id'].'">éditer</a>] ';
		      print '[<a href="delete_article.php?id_article='.$article['id'].'" onclick="return confirm(\'Etes vous sur de vouloir supprimer l\\\'article intitulé : '.addslashes($article['title']).'?\')">supprimer</a>] ';
		      print '</td>';
		      print '</tr>';
		    }
		    print "</table><br/>\n";
		  } else { print "Pas d'article dans cette catégorie."; }
		
?>	
</div>

<div class="formarea">
<a href="javascript:document.getElementById('add_form').style.display = ''; void(0);">Ajouter une catégorie</a>

<form action="manage_categories.php?method=new" method="post" style="display : none" id="add_form">
			<br />
			<table border="0" align="center" >
				<tr>
				<td>Nom</td>
				<td><input size="32" name="name"></td>
				</tr>
				
				<tr>
				<td>Descriptif</td>
				<td><input size="50" name="description"></td>
				</tr>
				
				<tr>
				<td></td>
				<td><input type="submit" value="Créer"></td>
				</tr>
			</table>
		</form>
</div>

<div class="backarea">
	<a href="index.php"><img src="img/precedent_natural.png">retourner au menu principal</a>
</div>
</div>

<?php	
	include ('inc/footer.php');
}
?>
