<?php

function db_connect() {
   $result = @mysql_pconnect('mysql.hostname', 'your.login', 'your.password'); 
   //$result = @mysql_pconnect('localhost', 'user', 'pass');
   if (!$result)
      return false;
   if (!@mysql_select_db('your.databasename'))
      return false;

   return $result;
}

function get_writer_name($id_writer) {
  $conn = db_connect();
  $sql = "select username from writers where id = '".$id_writer."'";
  $result = mysql_query($sql, $conn);
  return(mysql_result($result, 0, 0));
}


function get_article_record($id_article) {
  $conn = db_connect();
  $sql = "select * from articles where id = '$id_article'";
  $result = mysql_query($sql, $conn);
  return(mysql_fetch_array($result));
}

function get_article_pictures($id_article) {
  $conn = db_connect();
  $sql = "select * from pictures where id_article = '$id_article' order by priority";
  $result = mysql_query($sql, $conn);
  return($result);
}

function get_article_author($id_article) {
  $conn = db_connect();
  $sql = "select w.username from writers w, articles a where a.id_writer = w.id and a.id = '".$id_article."'";
  $result = mysql_query($sql, $conn);
  return(mysql_result($result, 0, 0));
}

function get_article_published($id_article) {
  $conn = db_connect();
  $sql = "select published from articles where id = '$id_article'";
  $result = mysql_query($sql, $conn);
  if (!$result){
    return(0);
  }
  return(mysql_result($result, 0, 0));
}


function query_select($name, $query, $default='')
{

  $conn = db_connect();
  $result = mysql_query($query, $conn);

  if (!$result){
    return(0);
  }
  $select  = "<SELECT NAME=\"$name\">";
  $select .= "<OPTION VALUE=\"\">-- Choisissez --</OPTION>";

  $nb_rows = mysql_numrows($result);
  
  for ($i=0; $i < $nb_rows ; $i++) {
  	$opt_id   = mysql_result($result, $i, 0);
    $opt_name = mysql_result($result, $i, 1);
    $opt_desc = mysql_result($result, $i, 2);
    $select .= "<OPTION VALUE=\"$opt_id\"";
    if ($opt_id == $default) {
      $select .= ' SELECTED';
    }
    $select .=  ">[$opt_name] $opt_desc</OPTION>";
  }
  $select .= "</SELECT>\n";

  return($select);

}

function get_max_priority($table) {
  $conn = db_connect();
  $sql = "select priority from $table order by priority desc";
  $result = mysql_query($sql, $conn);
  return(mysql_result($result, 0, 0));
}

function get_articles_max_priority($id_category) {
  $conn = db_connect();
  $sql = "select priority from articles where id_category = '$id_category' order by priority desc";
  $result = mysql_query($sql, $conn);
  if (!mysql_num_rows($result)) {
  	return 0;
  }else{
  	return(mysql_result($result, 0, 0));
  }
}

function get_pictures_max_priority($id_article) {
  $conn = db_connect();
  $sql = "select priority from pictures where id_article = '$id_article' order by priority desc";
  $result = mysql_query($sql, $conn);
  if (!mysql_num_rows($result)) {
  	return 0;
  }else{
  	return(mysql_result($result, 0, 0));
  }
}

function get_picture_record($id_picture) {
  $conn = db_connect();
  $sql = "select * from pictures where id = '$id_picture'";
  $result = mysql_query($sql, $conn);
  return(mysql_fetch_array($result));
}

?>
