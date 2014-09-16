<?php
include "../common/common_admin.php";

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

$tmp = "select * from tbl_add where pk_id='$uid'";
$que = mysql_query($tmp) or die($tmp);
if($que) $rows = mysql_fetch_array($que);

if($rows[add_yn] == "Y")
{
	$tmp_upd = "update tbl_add set add_yn='N' where pk_id='$uid'";
	$que_upd = mysql_query($tmp_upd) or die($tmp_upd);

	disConnect($conn);
	msg("정상적으로 삭제되었습니다.");
	go_url("add_list.html?mode=list$add_url");
} else {
	$tmp_upd = "update tbl_add set add_yn='Y' where pk_id='$uid'";
	$que_upd = mysql_query($tmp_upd) or die($tmp_upd);

	disConnect($conn);
	msg("정상적으로 복구되었습니다.");
	go_url("add_list.html?mode=list$add_url");
}

disConnect($conn);
exit;
?>

