<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("�߸��� ���ٹ��");

if($np)	$add_url.= "&np=$np";
if($sp)	$add_url.= "&sp=$sp";
if($where)	$add_url.= "&where=$where";
if($where1)	$add_url.= "&where1=$where1";
if($where2)	$add_url.= "&where2=$where2";
if($where3)	$add_url.= "&where3=$where3";
if($keyword)	$add_url.= "&keyword=$keyword";
if($sort)	$add_url.= "&sort=$sort";
if($order)	$add_url.= "&order=$order";
if($div_list)	$add_url.= "&div_list=$div_list";

$dataArray[] = "2,1,pk_id,".$pid;
$dataArray[] = "1,2,sub_content,".$add_reply;
$dataArray[] = "1,2,reserve_yn,"."Y";
Run_Update2("tbl_boards", $dataArray, $conn);

$tmp = "select * from tbl_boards where pk_id='$pid'";
$que = mysql_query($tmp) or die($tmp);
if($que) $rows = mysql_fetch_array($que); else $rows = NULL;

$from_name="����Ʈ��";
$from_email=$USER_INFO[member_email];
$to_name = $rows[name];
$to_email = $rows[email];    
$subject = "[����Ʈ��] $rows[name] �� �������� ���� �����Դϴ�.";	
$content=html_format($add_desc)."<br><br><br><br>���� �����Դϴ�.================================================<br><br>".html_format($rows[content]);
$header="From: $from_name<$from_email>\r\nReply-To: <?=$from_email?>\r\nContent-type: text/html; charset=euc-kr\r\n";
mail($to_email, $subject, $content, $header);

disConnect($conn);
msg("���������� ó���Ͽ����ϴ�.");

go_url("board_list.html?mode=list$add_url");
exit;
?>

