<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("�߸��� ���ٹ��");

// pk_id ���ϱ�
$pk_id = 0;
$sql = "select max(pk_id) from tbl_member";
$pk_id = getOneDataSQL2($sql, $conn) + 1;

// ������ ���� �� �ʱ�ȭ
$reg_date = date("Y-m-d");

$dataArray[] = "1,pk_id,".$pk_id;
$dataArray[] = "2,member_group,".$member_group;
$dataArray[] = "2,member_id,".$member_id;
$dataArray[] = "2,member_pw,".$member_pw;
$dataArray[] = "2,member_name,".$member_name;
$dataArray[] = "2,member_attn,".$member_attn;
$dataArray[] = "2,member_email,".$member_email;
$dataArray[] = "2,member_tel,".$member_tel;
$dataArray[] = "2,member_reward_url,".$member_reward_url;
$dataArray[] = "2,member_bigo_url,".$member_bigo_url;
$dataArray[] = "2,member_con_date,".$member_con_date;
$dataArray[] = "2,member_reg_date,".$reg_date;
$dataArray[] = "2,member_stat,"."Y";

Run_Insert2("tbl_member", $dataArray, $conn);

disConnect($conn);
msg("���������� ��ϵǾ����ϴ�.");
go_url("member_list.html");
exit;
?>

