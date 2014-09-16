<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("잘못된 접근방식");

if($np)	$add_url.= "&np=$np";
if($sp)	$add_url.= "&sp=$sp";
if($where)	$add_url.= "&where=$where";
if($where1)	$add_url.= "&where1=$where1";
if($keyword)	$add_url.= "&keyword=$keyword";
if($sort)	$add_url.= "&sort=$sort";
if($order)	$add_url.= "&order=$order";
if($div_list)	$add_url.= "&div_list=$div_list";

$dataArray[] = "2,2,member_id,".$uid;
$dataArray[] = "1,2,member_pw,".$member_pw;
$dataArray[] = "1,2,member_name,".$member_name;
$dataArray[] = "1,2,member_attn,".$member_attn;
$dataArray[] = "1,2,member_email,".$member_email;
$dataArray[] = "1,2,member_tel,".$member_tel;
$dataArray[] = "1,2,member_reward_url,".$member_reward_url;
$dataArray[] = "1,2,member_bigo_url,".$member_bigo_url;
$dataArray[] = "1,2,member_con_date,".$member_con_date;

Run_Update2("tbl_member", $dataArray, $conn);

disConnect($conn);
msg("정상적으로 수정되었습니다.");
go_url("member_edit.html?uid=$uid$add_url");
exit;
?>

