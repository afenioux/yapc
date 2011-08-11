<?php

include('inc/include_fns.php');
include('inc/header.php');

if ( isset($_GET['id_cat']) && $_GET['id_cat'] != "" && (int)$_GET['id_cat'] != 0){
		$id_cat = (int)$_GET['id_cat'];
} else{
	$id_cat = 1;
}

$conn = db_connect();

$sql = "select * from articles where id_category = '".$id_cat."'order by priority desc";
$result = mysql_query($sql, $conn);
if (!$result) {
	print "There was a database error when executing <pre>$sql</pre>";
	print mysql_error();
	exit;
}
	$published = 0;	 
	if (mysql_num_rows($result)) {
		while ($article = mysql_fetch_array($result)) {
			if ($article['published']){
				$published++;
				print '<div class="contenu">'."\n".'<h2>'.$article['title'].'</h2>'."\n";
	
				$pictures_array=get_article_pictures($article['id']);
				if ( mysql_num_rows($pictures_array) ){
					$first_loop = 1;
					while ($picture = mysql_fetch_array($pictures_array)) {
						$size   = getImageSize(preg_replace('/big/', 'small', $picture['path']));
				 		$width  = $size[0];
						$height = $size[1];
						if ($first_loop){
							$first_loop = 0;
							print  '<div class="floatleft">
							<a href="'.$picture['path'].'" title = "'.$picture['title'].'">
									<img src="'.preg_replace('/big/', 'small', $picture['path']).'" width="'.$width.'" height="'.$height.
									'" alt = "'.$picture['title'].'" /></a></div>';
									print '<p>'.nl2br($article['art_text']).'</p>'."\n".'<div class="clear">'."\n";
						}else{
							print '<a href="'.$picture['path'].'" title = "'.$picture['title'].'">
								<img src="'.preg_replace('/big/', 'small', $picture['path']).'" width="'.$width.'" height="'.$height.
								'" class="spaceright" alt = "'.$picture['title'].'" /></a>';
						}
					}
					print  "\n".'</div><!-- end of clear -->'."\n".'</div><!-- end of contenu -->';
					}else { 
						print '<p>'.nl2br($article['art_text']).'</p>'."\n".'</div><!-- end of contenu -->';
					}
			}	
		}
	}

	if ($published == 0){
		print '<div class="contenu"><h2>Pas encore d\'article dans cette catégorie</h2>
		<pre>Patience...</pre>
		</div><!-- end of contenu -->';
	}


/*
$pages_sql = 'select * from pages order by code';
$pages_result = mysql_query($pages_sql, $conn);

while ($pages = mysql_fetch_array($pages_result)) {

  $story_sql = "select * from stories
                where page = '".$pages['code']."'
                and published is not null
                order by published desc";
  $story_result = mysql_query($story_sql, $conn);
  if (mysql_num_rows($story_result)) {
    $story = mysql_fetch_array($story_result);
    print '<table border="0" width="400">';
    print '<tr>';
    print '<td rowspan="2" width="100">';
    if ($story[picture])
      print "<img src=\"resize_image.php?image=$story[picture]\" />";
    print '</td>';
    print '<td>';
    print '<h3>'.$pages['description'].'</h3>';
    print $story['headline'];
    print '</td>';
    print '</tr>';
    print '<tr><td align="right">';
    print '<a href="page.php?page='.$pages['code'].'">';
    print '<font size="1">Read more '.$pages['code'].' ...</font>';
    print '</a>';
    print '</table>';
  }
}
*/

include('inc/footer.php');
?>
