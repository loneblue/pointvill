<?php
if($USER_INFO[member_id] && $USER_KEY)
{
  $m_user_key = md5($USER_INFO[member_id]);
	if($USER_KEY != $USER_KEY)
	{		
  	$login_status = false;
  	echo "<meta http-equiv='refresh' content='0; url=../admin/index.html'>";
  	exit;
	}
	else
	{
	  if($USER_INFO[member_group] == "")
	  {
      session_unregister("USER_INFO");
      setCookie("USER_KEY","",-1);					
      session_destroy();
      go_url("../admin/index.html");
      exit;
  	}
  	$login_status = true;
	}
}
else
{			
 	$login_status = true;  
 	echo "<meta http-equiv='refresh' content='0; url=../admin/index.html'>";
 	exit;
}

exec ("dir /tmp/sess_*", $list);

?>
