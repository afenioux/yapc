<?php

include('../inc/include_fns.php');

$conn = db_connect();

$time = time();
$title = $_POST['title'];
$id_category = $_POST['id_category'];
$art_text = $_POST['art_text'];
$published = $_POST['published'];
if($published == 1){
  	 $published = $time;
}

if ( $_POST['id_article'] != 999666 ) {
	// It's an update
  $id_article = $_POST['id_article'];

  $sql = "update articles
          set title 		= '$title', 
              art_text 		= '$art_text',
              id_category 	= '$id_category',
              modified 		= '$time',
              published		= '$published'
          where id = '$id_article'";

}

else {         // It's a new article
  $priority = get_articles_max_priority($id_category)+1;
  $sql = "insert into articles 
            (title, art_text, id_category, id_writer, created, modified, published, priority)
          values ('$title', '$art_text', '$id_category', '"
             .get_auth_user_id($_SESSION['auth_user'])."', '$time', '$time', '$published', '$priority')";
 $result = mysql_query($sql, $conn);

	if (!$result) {
	  print "There was a database error when executing <pre>$sql</pre>";
	  print mysql_error();
	  exit;
	}    
	
	$id_article = mysql_insert_id();
	$sql = "update pictures set id_article = '$id_article' where id_article = '999666'";
	   
}

//done each time
$result = mysql_query($sql, $conn);

if (!$result) {
  print "There was a database error when executing <pre>$sql</pre>";
  print mysql_error();
  exit;
}


$i = 0;
while ( isset($_POST['id_'.$i]) ){
	$id_picture = $_POST['id_'.$i++];
	$my_picture = get_picture_record($id_picture);

	if ( isset($_POST['picture_del_'.$id_picture]) ){
		//delete the picture
		//unset first or you will lose the path!
		unlink('../'.$my_picture['path']);
		unlink('../'.preg_replace('/big/', 'small', $my_picture['path']));
		$sql = "delete from pictures where id = '$id_picture'";

	}else {
		//update legende
		$legende = $_POST['picture_leg_'.$id_picture];
		$sql = "update pictures set title = '$legende' where id = '$id_picture'";
		
	}
	//done each time
	$result = mysql_query($sql, $conn);
        if (!$result) {
        	print "There was a database error when executing <pre>$sql</pre>";
                print mysql_error();
                exit;
	}

}


if (get_article_record($id_article)){
	$_SESSION['submit_ok'] = 1;
}
header("Location: new_article.php?id_article=$id_article");

//OLD header('Location: '.$_POST['destination']);

?>
