<?php

include ('../inc/include_fns.php');
include ('inc/header.php');

if (!check_auth_user()) {
	print_login_form();
}
else {

if ( isset($_GET['id_article']) && $_GET['id_article'] != "" ){
	$my_article['id'] = $_GET['id_article'];
}
else {
	//giving a tmp id
	$my_article['id'] = 999666;
}
?>

<form method="post" enctype="multipart/form-data" action="submit_photo_simple.php">
<input type="hidden" name="id_article" value="<?php print $my_article['id'];?>">
<p>
Selectionnez la photo a envoyer :
<br /><br />
<input type="file" name="photoupload" size="30">
<input type="submit" name="upload" value="Uploader">
</p>
</form>

<?php
	include ('inc/footer.php');
}
?>
