<?php
include "../common/common_admin.php";

if($np)	$add_url.= "&np=$np";
if($sp)	$add_url.= "&sp=$sp";
if($where)	$add_url.= "&where=$where";
if($keyword)	$add_url.= "&keyword=$keyword";
if($sort)	$add_url.= "&sort=$sort";
if($order)	$add_url.= "&order=$order";
if($div_list)	$add_url.= "&div_list=$div_list";

$tmp = "select * from tbl_member where member_id='$uid'";
$que = mysql_query($tmp) or die($tmp);
if($que) $rows = mysql_fetch_array($que);

if($rows[member_stat] == "Y")
{
	$tmp_upd = "update tbl_member set member_stat='N' where member_id='$uid'";
	$que_upd = mysql_query($tmp_upd) or die($tmp_upd);

	disConnect($conn);
	msg("정상적으로 삭제되었습니다.");
	go_url("member_list.html?mode=list$add_url");
} else {
	$tmp_upd = "update tbl_member set member_stat='Y' where member_id='$uid'";
	$que_upd = mysql_query($tmp_upd) or die($tmp_upd);

	disConnect($conn);
	msg("정상적으로 복구되었습니다.");
	go_url("member_list.html?mode=list$add_url");
}

disConnect($conn);
exit;
?>

