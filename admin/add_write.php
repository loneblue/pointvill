<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("�߸��� ���ٹ��");

// pk_id ���ϱ�
$pk_id = 0;
$sql = "select max(pk_id) from tbl_add";
$pk_id = getOneDataSQL2($sql, $conn) + 1;

$dataArray = NULL;

// =============================
// ���Ͼ��ε��
// -----------------------------
if($file!='none' && $file)
{
	if($file_size>(20480*1024)) msg_back("���ε� �ִ�뷮�� 20MB �Դϴ�");
	$file_old = $file_name;
	$file_ext = getFileExt(strtolower($file_name));

	if(($file_ext!="jpg")
		&&($file_ext!="JPG")
		&&($file_ext!="jpeg")
		&&($file_ext!="JPEG")
		&&($file_ext!="gif")
		&&($file_ext!="GIF")
		&&($file_ext!="png")
		&&($file_ext!="PNG")
		&&($file_ext!="bmp")
		&&($file_ext!="BMP")
		)	msg_back("�̹��� ������ �ƴմϴ�.");

	$file_nm = md5($cid.date("YmdHis").uniqid(rand())).".".$file_ext;
	
	// ===============
  // ���Ͼ��ε�
	// ---------------
 	$tmp_save_dir = "../file/$file_nm";
 	$save_dir = "../file"; 	
  $exist = file_exists($tmp_save_dir);
  if($exist) msg_back("���� ������ �����մϴ�.");
  if(!copy($file,$tmp_save_dir)) msg_back("���� ���ε� ����");

	if(!unlink($file)) msg_back("���� ���ε� ����");

	$dataArray[] = "2,add_image,".$file_nm;
}	//	end of if($file!='none' && $file)
// =============================

for($i=1;$i<sizeof($chk_users);$i++)
{
	$add_member .= "|".$chk_users[$i];
}

$dataArray[] = "1,pk_id,".$pk_id;
$dataArray[] = "2,add_id,".$add_id;
$dataArray[] = "2,add_type,".$add_type;
$dataArray[] = "2,add_name,".$add_name;
$dataArray[] = "2,add_url,".$add_add_url;
$dataArray[] = "2,add_member,".$add_member;
$dataArray[] = "2,add_cost,".$add_cost;
$dataArray[] = "2,add_price,".$add_price;
$dataArray[] = "2,add_gubun,".$add_gubun;
$dataArray[] = "2,add_desc,".$add_desc;
$dataArray[] = "2,add_start,".$add_start;
$dataArray[] = "2,add_end,".$add_end;
$dataArray[] = "2,add_stat,".$add_stat;
$dataArray[] = "2,add_yn,"."Y";

Run_Insert2("tbl_add", $dataArray, $conn);

disConnect($conn);
msg("���������� ��ϵǾ����ϴ�.");
go_url("add_list.html");
exit;
?>

