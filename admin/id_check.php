<?php 
include "../common/common_admin.php";

if($chk_id)
{
	$count = 0;
	$sql = "select count(*) from tbl_member where member_id='$chk_id'";
	$result = mysql_query($sql, $conn) or die($sql);
	$row = mysql_fetch_row($result);
	mysql_free_Result($result);
	$count1 = $row[0];

	// ��ϵ� ���̵��ϰ��
	if($count>0)
	{
?>
<script>
alert("�̹� ��ϵ� ���̵� �Դϴ�.");
parent.frm_member.member_id.value="";
parent.frm_member.member_id.focus();
</script>
<?
  }
  else
  {
?>
<script>
alert("��� ������ ���̵� �Դϴ�.");
parent.frm_member.chk_id.value="Y";
parent.frm_member.member_pw.focus();
</script>
<?
  }
}
else
{
?>
<script>
alert("���̵� �Է��ϼ���.");
parent.frm_member.member_id.focus();
</script>
<?
}
?>
