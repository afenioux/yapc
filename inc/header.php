<?php
include('inc/include_fns.php');
?>
<!-- Design inspiré du cours http://css.alsacreations.com/Faire-une-mise-en-page-sans-tableaux/design-css de Olivier Patry -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>My website</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta http-equiv="Content-Language" content="fr" />
		
		<meta name="Description" content="" />
		<meta name="keywords" content="" />
		<meta name="Indentifier-URL" content="http://www.yourwebsite.tld" />
		
		<link media="screen" href="css/style.css" type="text/css" rel="stylesheet" />
	        <!--[if IE]>
			 <style type="text/css">
			 html pre
			{
				width: 994px ;
			}
			</style>
			<![endif]-->
			<script src="inc/js-global/FancyZoom.js" type="text/javascript"></script>
			<script src="inc/js-global/FancyZoomHTML.js" type="text/javascript"></script>
	</head>
	
	<body onload="setupZoom()">
	<div id="conteneur">		
		<h1 id="header"><a href="index.php" title="Homepage"><span>My website</span></a></h1>

		<p id="back"><a href="index.php">Home</a></p>


		<ul id="menu">
		
<?php	
	$conn = db_connect();
	$sql = 'select * from categories order by priority asc';
	$result = mysql_query($sql, $conn);
	if (!$result) {
		print "There was a database error when executing <pre>$sql</pre>";
		print mysql_error();
		exit;
	}
	
	while ($category = mysql_fetch_array($result)) {
		if ($category['name'] != "Edito") {
			print '<li><a href="index.php?id_cat='.$category['id'].'" title="'.$category['description'].
			'">'.$category['name'].'</a></li>'."\n";
		}
	}
		print "</ul>\n";