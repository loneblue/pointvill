<?
include "../common/common.php"; 

$tmp = "select * from tbl_point where point_order_id='$oid' and point_result='Y'";
$que = mysql_query($tmp) or die($tmp);
$tot = mysql_num_rows($que);
if($tot > 0) $result = "SUCCESS"; else $result = "FAILED";

echo "oid : $oid<br>";
echo "pname : $pname<br>";
echo "price : $price<br>";
echo "id : $id<br>";
echo "result : $result";
?>
