<?php
// 로그인 여부를 체크하는 곳입니다.
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