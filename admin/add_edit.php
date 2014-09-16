<?php
include "../common/common_admin.php";

if($REQUEST_METHOD!="POST")	msg_back("잘못된 접근방식");

if($np)	$add_url.= "&np=$np";
if($sp)	$add_url.= "&sp=$sp";
if($where)	$add_url.= "&where=$where";
if($where1)	$add_url.= "&where1=$where1";
if($where2)	$add_url.= "&where2=$where2";
if($where3)	$add_url.= "&where3=$where3";
if($keyword)	$add_url.= "&keyword=$keyword";
if($sort)	$add_url.= "&sort=$sort";
if($order)	$add_url.= "&order=$order";
if($div_list)	$add_url.= "&div_list=$div_list";

$tmp = "select * from tbl_add where pk_id='$uid'";
$que = mysql_query($tmp) or die($tmp);
if($que) $rows = mysql_fetch_array($que);

$dataArray = NULL;

// =============================
// 파일삭제할경우 데이터 삭제
// -----------------------------
if($file_del=="Y")
{ 
	$dataArray[] = "2,1,pk_id,".$uid;
	$dataArray[] = "1,2,add_image,";

	Run_Update2("tbl_add", $dataArray, $conn);

	@unlink("../file/$rows[add_image]");
}	//	end of if($file_del=="Y")
// =============================

$dataArray = NULL;

// =============================
// 파일업로드시
// -----------------------------
if($file!='none' && $file)
{
	if($file_size>(20480*1024)) msg_back("업로드 최대용량은 20MB 입니다");
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
		)	msg_back("이미지 파일이 아닙니다.");

	$file_nm = md5($cid.date("YmdHis").uniqid(rand())).".".$file_ext;
	
	// ===============
  // 파일업로드
	// ---------------
 	$tmp_save_dir = "../file/$file_nm";
 	$save_dir = "../file"; 	
  $exist = file_exists($tmp_save_dir);
  if($exist) msg_back("같은 파일이 존재합니다.");
  if(!copy($file,$tmp_save_dir)) msg_back("파일 업로드 실패");

	if(!unlink($file)) msg_back("파일 업로드 실패");
  @unlink("../file/$rows[add_image]");

	$dataArray[] = "1,2,add_image,".$file_nm;
}	//	end of if($file!='none' && $file)
// =============================

for($i=0;$i<sizeof($chk_users);$i++)
{
	$add_member .= "|".$chk_users[$i];
}

$dataArray[] = "2,1,pk_id,".$uid;
$dataArray[] = "1,2,add_id,".$add_id;
$dataArray[] = "1,2,add_type,".$add_type;
$dataArray[] = "1,2,add_name,".$add_name;
$dataArray[] = "1,2,add_url,".$add_add_url;
$dataArray[] = "1,2,add_member,".$add_member;
$dataArray[] = "1,2,add_cost,".$add_cost;
$dataArray[] = "1,2,add_price,".$add_price;
$dataArray[] = "1,2,add_gubun,".$add_gubun;
$dataArray[] = "1,2,add_desc,".$add_desc;
$dataArray[] = "1,2,add_start,".$add_start;
$dataArray[] = "1,2,add_end,".$add_end;
$dataArray[] = "1,2,add_stat,".$add_stat;

Run_Update2("tbl_add", $dataArray, $conn);

disConnect($conn);
msg("정상적으로 수정되었습니다.");
go_url("add_edit.html?uid=$uid$add_url");
exit;
?>

