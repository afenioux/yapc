<?php
  // putting all the include files here means 
  // that it will take time to load each one 
  // for every page, but that we wil not 
  // forget any

  include_once('db_fns.php');
  include_once('user_auth_fns.php');
  //the next 3 lines are for OVH only
  //but now look in the .htaccess
 //ini_set('session.use_trans_sid', false);
 //ini_set('session.use_cookies', true);
 //ini_set('url_rewriter.tags','');
  session_start();
?>
