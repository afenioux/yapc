<?php
 
include('../inc/include_fns.php');

$result = array();

if (isset($_FILES['photoupload']) && $_FILES['photoupload']['tmp_name'] !="" )
{
	$file = $_FILES['photoupload']['tmp_name'];
	$error = false;
	$size = false;
 
	if (!is_uploaded_file($file) || ($_FILES['photoupload']['size'] > 2 * 1024 * 1024) )
	{
		$error = 'Please upload only files smaller than 2Mb!';
	}
	if (!$error && !($size = @getimagesize($file) ) )
	{
		$error = 'Please upload only images, no other files are supported.';
	}
	if (!$error && !in_array($size[2], array(1, 2, 3, 7, 8) ) )
	{
		$error = 'Please upload only images of type JPEG.';
	}
	if (!$error && ($size[0] < 50) || ($size[1] < 50))
	{
		$error = 'Merci de n\'envoyer que des images, et pas trop petites non plus!';
	}
 

//Process here for 1 img 
if (!$error) {
 	$title = $_FILES["photoupload"]['name'];
	$id_article = $_POST['id_article'];
	$priority = get_pictures_max_priority($id_article)+1;

	//Ok, c est moche, mais ca marche
	$arr = split( '\.', $title);
	while (list($key, $value) = each ($arr))
	$type = $value;
	 	
 	$conn = db_connect();
 	$sql = "insert into pictures (id_article, priority, title) values ('$id_article', '$priority', '$title')";
	$resultsql = mysql_query($sql, $conn);
	if (!$resultsql) {
  		$error .= "There was a database error when executing <pre>$sql</pre>";
		$error .= mysql_error();
		exit;
	}
					      	 
	$id_picture = mysql_insert_id();
	$filename = "pictures/big/$id_picture.$type";
		
	$original_image = $_FILES["photoupload"]['tmp_name'];
	$max_width = "800";
	$max_height = "800";
	
	$size = GetImageSize($original_image);
	$width = $size[0];
	$height = $size[1];
	
	if ( ($width >= $max_width) || ($height >= $max_height) ) {
		exec("convert $original_image -thumbnail $max_widthx$max_height ../$filename");
	} else {
		exec("convert $original_image -thumbnail $widthx$height ../$filename");
		//move_uploaded_file($original_image, "../$filename");
	}

	

	$sql = "update pictures set path = '$filename' where id = '$id_picture'";
	$resultsql = mysql_query($sql, $conn);
	if (!$resultsql) {
  		$error .= "There was a database error when executing <pre>$sql</pre>";
		$error .= mysql_error();
		exit;
	}
	
	//now the thumbnail
	$new_filename = "pictures/small/$id_picture.$type";
	// Maximum image width
	$max_width = "100";
	// Maximum image height
	$max_height = "100";
	
	// Resize the image and save, but not everywhere
	//OVH /usr/bin/convert
	//system("convert "?
	exec("convert $original_image -thumbnail $max_widthx$max_height ../$new_filename");
	
}
 
	if ($error)
	{
		$result['result'] = 'failed';
		$result['error'] = $error;
	}
	else
	{
		$result['result'] = 'success';
		$result['size'] = "Uploaded an image ({$size['mime']}) with  {$size[0]}px/{$size[1]}px.";
	}
 
}
else
{
	$result['result'] = 'error';
	$result['error'] = 'Missing file or internal error!';
}
 
include ('inc/header.php');
if (isset($result['error'])){
	print $result['error'];
}else {
	print "la photo a été envoyée avec succes, vous pouvez fermer cette fenetre et recharger la page precedente";
}
include ('inc/footer.php');
 
?>
