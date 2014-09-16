<?
include "../common/common.php"; 

if($pid && $site && $id)
{
	$tmp = "select * from tbl_add where pk_id='$pid'";
	$que = mysql_query($tmp) or die($tmp);
	if($que) $rows = mysql_fetch_array($que); else $rows = NULL;

	// pk_id ╠╦го╠Б
	$pk_id = 0;
	$sql = "select max(pk_id) from tbl_point";
	$pk_id = getOneDataSQL2($sql, $conn) + 1;

	$rand = rand(100,999);
	$order_id = $site."^".$id."^".$rows[pk_id]."^".$rand;
	$dataArray = NULL;

	$dataArray[] = "1,pk_id,".$pk_id;
	$dataArray[] = "2,point_link_id,".$rows[add_id];
	$dataArray[] = "2,point_add_id,".$rows[pk_id];
	$dataArray[] = "2,point_osp_id,".$site;
	$dataArray[] = "2,point_member_id,".$id;
	$dataArray[] = "2,point_order_id,".$order_id;
	$dataArray[] = "2,point_add_name,".$rows[add_name];
	$dataArray[] = "2,point_cost,".$rows[add_cost];
	$dataArray[] = "2,point_price,".$rows[add_price];
	$dataArray[] = "2,point_date,".date("Y-m-d H:i:s");
	$dataArray[] = "2,point_result,"."N";

	Run_Insert2("tbl_point", $dataArray, $conn);

	go_url("$rows[add_url]$order_id");
}
disConnect($conn);
exit;
?>