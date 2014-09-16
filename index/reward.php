<?
include "../common/common.php"; 

if($r_member_id)
{
	$gubun = explode("^",$r_member_id);
	$site = $gubun[0];
	$id = $gubun[1];
	$pid = $gubun[2];
	$rand = $gubun[3];

	$tmp = "select * from tbl_point where point_order_id='$r_member_id'";
	$que = mysql_query($tmp) or die($tmp);
	$tot = mysql_num_rows($que);

	if($tot > 0)
	{
		$tmp_upd = "update tbl_point set point_result='Y' where point_order_id='$r_member_id'";
		$que_upd = mysql_query($tmp_upd) or die($tmp_upd);
	} else {
		// pk_id ±¸ÇÏ±â
		$pk_id = 0;
		$sql = "select max(pk_id) from tbl_point";
		$pk_id = getOneDataSQL2($sql, $conn) + 1;

		$tmp_add = "select * from tbl_add where pk_id='$pid'";
		$que_add = mysql_query($tmp_add) or die($tmp_add);
		if($que_add) $row_add = mysql_fetch_array($que_add); else $row_add = NULL;

		$dataArray = NULL;

		$dataArray[] = "1,pk_id,".$pk_id;
		$dataArray[] = "2,point_link_id,".$row_add[add_id];
		$dataArray[] = "2,point_add_id,".$pid;
		$dataArray[] = "2,point_osp_id,".$site;
		$dataArray[] = "2,point_member_id,".$id;
		$dataArray[] = "2,point_order_id,".$r_member_id;
		$dataArray[] = "2,point_add_name,".$row_add[add_name];
		$dataArray[] = "2,point_cost,".$row_add[add_cost];
		$dataArray[] = "2,point_price,".$row_add[add_price];
		$dataArray[] = "2,point_date,".date("Y-m-d H:i:s");
		$dataArray[] = "2,point_result,"."Y";

		Run_Insert2("tbl_point", $dataArray, $conn);
	}

	$tmp_mem = "select * from tbl_member where member_id='$site'";
	$que_mem = mysql_query($tmp_mem) or die($tmp_mem);
	if($que_mem) $row_mem = mysql_fetch_array($que_mem); else $row_mem = NULL;

	$post_data = array(
	"oid" => "$r_member_id",
	"pname" => "$rows[add_name]",
	"price" => "$rows[add_price]",
	"id" => "$id",
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "$row_mem[member_reward_url]");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_exec($ch);
}

disConnect($conn);
exit;
?>

