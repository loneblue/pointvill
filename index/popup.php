<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("잘못된 접근방식");

$tmp = "select * from tbl_add where pk_id='$add_id'";
$que = mysql_query($tmp) or die($tmp);
if($que) $rows = mysql_fetch_array($que);

// pk_id 구하기
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
msg("정상적으로 등록되었습니다.\\n\\n입력하신 이메일이나 연락처로 처리결과를 알려드리겠습니다.");
?>
<script>
window.close();
</script>

