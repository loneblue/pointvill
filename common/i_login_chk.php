<?php
// �α��� ���θ� üũ�ϴ� ���Դϴ�.
if($USER_INFO[member_id] && $USER_KEY)
{
  $m_user_key = md5($USER_INFO[member_id]);
	if($USER_KEY != $USER_KEY)
	{
  	session_unregister("USER_INFO");
		setCookie("USER_KEY","",-1);					
		$login_status = false;
//  	echo "<meta http-equiv='refresh' content='0; url=../'>";		
	}
	else
	{
  	$login_status = true;
	}
}
else
{
  session_unregister("USER_INFO");
	setCookie("USER_KEY","",-1);
	$login_status = false;
// 	echo "<meta http-equiv='refresh' content='0; url=../'>";	
}

//exec ("dir /tmp/sess_*", $list);
?>