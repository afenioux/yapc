<?php

include ('../inc/include_fns.php');
include ('inc/header_new_article.php');

if (!check_auth_user()) {
	print_login_form();
}
else {

?>
<div class="pagearea">
<div class="titlearea formarea">
<h1> Création/Edition d'un article</h1>

<?php
if ( isset($_GET['id_article']) && $_GET['id_article'] != "" ){
	$my_article = get_article_record($_GET['id_article']);
	if (isset($_SESSION['submit_ok'])){
		print "<h2>Article enregistré avec succès!</h2>";
		print '<a href="index.php"><img src="img/precedent_natural.png" align="middle" border="0"></a> ';
		print '<a href="index.php">retourner au menu principal</a>';
		print '<br /><a href="../index.php?id_cat='.$my_article['id_category'].'">voir le site</a>';
		unset($_SESSION['submit_ok']);
	}
}
else {
	//giving a tmp id
	$my_article['id'] = 999666;
}

if ( isset($_GET['id_category']) && $_GET['id_category'] != "" ){
	$id_category = $_GET['id_category'];
} else {
	$id_category = $my_article['id_category'];
}
?>
</div>

<div class="formarea">
<div class="explain-step">
<h2>1 - Choisissez vos images puis Envoyez</h2>
</div>

<form method="post" enctype="multipart/form-data" id="form-extra">
<input type="hidden" name="id_article" value="<?php print $my_article['id'];?>">
</form>

<!-- script path *HAS* to be hardcoded from / -->
<form action="/admin/submit_photo.php" method="post" enctype="multipart/form-data" id="form-demo">
	
	<fieldset id="demo-fallback">
		<legend>File Upload</legend>
		<p>
			Selected your photo to upload.<br />
			<!-- <strong>This form is just an example fallback for the unobtrusive behaviour of FancyUpload.</strong> -->
		</p>
		<label for="demo-photoupload">
			Upload Photos:
			<input type="file" name="photoupload" id="demo-photoupload" />
		</label>
	</fieldset>
 
	<div id="demo-status" class="hide">
		<p>
			<a href="#" id="demo-browse-all">Parcourir</a> |
			<a href="#" id="demo-browse-images">Parcourir seulement les Images</a> |
			<a href="#" id="demo-clear">Vider la liste</a> |
			<a href="#" id="demo-upload">Envoyer</a>
		</p>
		<div>
			<strong class="overall-title">Overall progress</strong><br />
			<img src="img/bar.gif" class="progress overall-progress" />
		</div>
		<div>
			<strong class="current-title">File Progress</strong><br />
			<img src="img/bar.gif" class="progress current-progress" />
		</div>
		<div class="current-text"></div>
	</div>
 
	<ul id="demo-list"></ul>
 
</form>
</div><!--end of formarea-->

<div class="formarea">
<div class="explain-step">
<h2>2 - Complétez</h2>
</div>

<form action="submit_article.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id_article" value="<?php print $my_article['id'];?>">
	<input type="hidden" name="destination" value="<?php print $_SERVER['HTTP_REFERER'];?>">
	
	<div class="completer" id="demo-photos">
	<table border="0" align="center">
	<tr>
	<td>Titre</td><td><input size="50" name="title" value="<?php print $my_article['title'];?>"></td>
	</tr><tr>
	<td>Catégorie</td><td><?php print query_select('id_category', "select * from categories", $id_category);?></td>
	</tr><tr>
	<td>Etat</td><td><SELECT NAME="published">
		  	  <?php
		  	  $published = get_article_published($my_article['id']);
		  	  if ($published){
		  	  	print '<OPTION VALUE="0">Non publié</OPTION>';
		  	    print '<OPTION VALUE="'.$published.'" SELECTED>Publié</OPTION>';
		  	  }else{
		  	    print '<OPTION VALUE="0">Non publié</OPTION>';
		  	    print '<OPTION VALUE="1" SELECTED>Publié</OPTION>';
		  	  }
		  	  ?></SELECT></td>
        </tr><tr>
	<td colspan="2">Contenu de l'article (peut contenir des tags HTML)<br />
	<textarea cols="90" rows="10" name="art_text"
		           wrap="virtual"><?php print $my_article['art_text'];?></textarea>
	</td></tr></table>
		<?php
		$pictures_array=get_article_pictures($my_article['id']);
		if ( mysql_num_rows($pictures_array) ){
			print '<div class="explain-step"><h3>Images</h3></div>';
			$i = 0;
			print ' <table border="0" align="center">
                                <tr><th>Miniature</th><th>Legende</th><th>Supprimer</th></tr>';
			while ($picture = mysql_fetch_array($pictures_array)) {
				//print $picture['id']."_".$picture['priority'];
				$size   = getImageSize("../".preg_replace('/big/', 'small', $picture['path']));
		 		$width  = $size[0];
				$height = $size[1];
		?>		
				<input type="hidden" name="id_<?php print $i++;?>" value="<?php print $picture['id'];?>"> 
				<tr><td><?php print '<a href="../'.$picture['path'].'" title = "'.$picture['title'].'">
                                        <img src="../'.preg_replace('/big/', 'small', $picture['path']).'" width="'.$width.'" height="'.$height.'" alt = "'.$picture['title'].'" /></a>';?>
				</td><td><input size="30" name="<?php print 'picture_leg_'.$picture['id'];?>" value="<?php print $picture['title'];?>">
				</td><td><input type="checkbox" name="<?php print 'picture_del_'.$picture['id'];?>" ></td></tr>
		<?php 
			}
		print "</table>";
		} 
		?>
		</div><!--end of completer-->
		<br />
</div><!--end of formarea-->

<div class="formarea">

<div class="explain-step">
<h2>3 - <input type="submit" value="Validez!"></h2> </form>
</div>

</div> <!-- end of formarea content -->

<div class="backarea">
<a href="<?php print $_SESSION['destination']; ?>"><img src="img/precedent_orange.png">retour</a>
</div>
</div>
<?php
	include ('inc/footer.php');
}
?>
