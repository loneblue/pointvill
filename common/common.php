<?php
session_cache_limiter('no-cache, must-revalidate');
session_start();
header("content-type: text/html; charset=euc-kr"); 

include "../common/config.php";
include "../common/dbconn.php";
include "../common/mlib.php";
include "../common/sub_mlib.php";
include "../common/i_login_chk.php";

/*
$dir=opendir("/tmp");
$onSession = 0;
while(($read=readdir($dir)) !== false)
{ 
  $when_read = explode("_",$read);
  $read0 = $when_read[0];
  if( $read0 == "sess" )
  {
    $fh = fopen('/tmp/'.$read, 'r');
    while (!feof($fh)) $vContent = fread($fh,2098);
    fclose($fh);
    if ( 0 < strlen($vContent) ) { $onSession++; }
  }
}
*/
?>
