<?php
include "../common/common.php";

if($REQUEST_METHOD != "POST")	msg_back("잘못된 접근방식");
if(!$chk_id	|| !$chk_pwd) msg_back("아이디와 비밀번호를 입력하세요.");

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
if(!$rows) msg_back("아이디가 존재하지 않거나 권한이 없습니다.");
if($rows[member_pw] != $chk_pwd)	msg_back("비밀번호가 일치하지 않습니다");

$now = date("Y-m-d H:i:s");

$USER_KEY = md5($rows[member_id]);
setCookie("USER_KEY",$USER_KEY,0,"/");
session_register("USER_INFO");
$USER_INFO = $rows;

if ($idcheckbox) { //자동로그인일경우(체크값을 auto_login이라는 파라메타로 주면되겠죠)
  // 쿠키 한달간 저장
  setCookie('idck', $chk_id,31536000000,"/"); //member_id 쿠키 생성
} else {
  setCookie('idck', '', -1,"/");
}

if ($pwcheckbox) { //자동로그인일경우(체크값을 auto_login이라는 파라메타로 주면되겠죠)
  // 쿠키 한달간 저장
  setCookie('pwck', $chk_pwd,31536000000,"/"); //member_pw 쿠키 생성
} else {
  setCookie('pwck', '', -1,"/");
}

$now = date("Y-m-d");
$tmp = "update tbl_add set add_stat='진행' where add_start >= '$now' and add_stat!='진행'";
$que = mysql_query($tmp) or die($tmp);
$tmp = "update tbl_add set add_stat='종료' where add_end < '$now' and add_stat='진행'";
$que = mysql_query($tmp) or die($tmp);

go_url("../admin/main.html");
?>