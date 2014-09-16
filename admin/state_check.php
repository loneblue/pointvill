<?php 
include "../common/common_admin.php";

$tmp_pnt = "select * from tbl_point where pk_id='$pid'";
$que_pnt = mysql_query($tmp_pnt) or die($tmp_pnt);
if($que_pnt) $row_pnt = mysql_fetch_array($que_pnt); else $row_pnt = NULL;

$tmp_mem = "select * from tbl_member where member_id='$mid'";
$que_mem = mysql_query($tmp_mem) or die($tmp_mem);
if($que_mem) $row_mem = mysql_fetch_array($que_mem); else $row_mem = NULL;
?>
<form name="reward" method="post" action="<?=$row_mem[member_bigo_url]?>">
<input type="hidden"  name="oid" value='<?=$row_pnt[point_order_id]?>'>
<input type="hidden" name="pname" value='<?=$row_pnt[point_add_name]?>'>
<input type="hidden" name="price" value='<?=$row_pnt[point_price]?>'>
<input type="hidden" name="id" value="<?=$row_pnt[point_member_id]?>">
</form>

<script>
document.reward.submit();
</script>