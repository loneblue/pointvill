<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("�߸��� ���ٹ��");

$tmp = "select * from tbl_add where pk_id='$add_id'";
$que = mysql_query($tmp) or die($tmp);
if($que) $rows = mysql_fetch_array($que);

// pk_id ���ϱ�
$pk_id = 0;
$sql = "select max(pk_id) from tbl_boards";
$pk_id = getOneDataSQL2($sql, $conn) + 1;

$dataArray = NULL;

$dataArray[] = "1,pk_id,".$pk_id;
$dataArray[] = "2,bpid,".$add_id;
$dataArray[] = "2,category,".$rows[add_id];
$dataArray[] = "2,opt,".$site;
$dataArray[] = "2,user_id,".$member_id;
$dataArray[] = "2,name,".$member_name;
$dataArray[] = "2,email,".$member_email;
$dataArray[] = "2,homepage,".$member_tel;
$dataArray[] = "2,content,".$content;
$dataArray[] = "2,reg_date,".date("Y-m-d H:i:s");
$dataArray[] = "2,reserve_yn,"."N";

Run_Insert2("tbl_boards", $dataArray, $conn);

disConnect($conn);
msg("���������� ��ϵǾ����ϴ�.\\n\\n�Է��Ͻ� �̸����̳� ����ó�� ó������� �˷��帮�ڽ��ϴ�.");
?>
<script>
window.close();
</script>

