<?php
include "../common/common.php";

if($REQUEST_METHOD != "POST")	msg_back("�߸��� ���ٹ��");
if(!$chk_id	|| !$chk_pwd) msg_back("���̵�� ��й�ȣ�� �Է��ϼ���.");

$chk_id = strtolower($chk_id);

$sql = " select  ";
$sql.= " member_pw, ";
$sql.= " member_id, ";
$sql.= " member_name, ";
$sql.= " member_email, ";
$sql.= " member_tel, ";
$sql.= " member_group ";
$sql.= " from ";
$sql.= " tbl_member ";
$sql.= " where ";
$sql.= " member_id='$chk_id' ";

$rows = getObjectSQL2($sql, $conn);
if(!$rows) msg_back("���̵� �������� �ʰų� ������ �����ϴ�.");
if($rows[member_pw] != $chk_pwd)	msg_back("��й�ȣ�� ��ġ���� �ʽ��ϴ�");

$now = date("Y-m-d H:i:s");

$USER_KEY = md5($rows[member_id]);
setCookie("USER_KEY",$USER_KEY,0,"/");
session_register("USER_INFO");
$USER_INFO = $rows;

if ($idcheckbox) { //�ڵ��α����ϰ��(üũ���� auto_login�̶�� �Ķ��Ÿ�� �ָ�ǰ���)
  // ��Ű �Ѵް� ����
  setCookie('idck', $chk_id,31536000000,"/"); //member_id ��Ű ����
} else {
  setCookie('idck', '', -1,"/");
}

if ($pwcheckbox) { //�ڵ��α����ϰ��(üũ���� auto_login�̶�� �Ķ��Ÿ�� �ָ�ǰ���)
  // ��Ű �Ѵް� ����
  setCookie('pwck', $chk_pwd,31536000000,"/"); //member_pw ��Ű ����
} else {
  setCookie('pwck', '', -1,"/");
}

$now = date("Y-m-d");
$tmp = "update tbl_add set add_stat='����' where add_start >= '$now' and add_stat!='����'";
$que = mysql_query($tmp) or die($tmp);
$tmp = "update tbl_add set add_stat='����' where add_end < '$now' and add_stat='����'";
$que = mysql_query($tmp) or die($tmp);

go_url("../admin/main.html");
?>