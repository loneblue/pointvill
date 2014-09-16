<?
// =====================
// 전역변수의 선언 및 초기화
// ---------------------
// 이메일 리스트
	$A_EMAIL[] = "netian.com";
	$A_EMAIL[] = "naver.com";
	$A_EMAIL[] = "nate.com";
	$A_EMAIL[] = "hanmail.net";
	$A_EMAIL[] = "dreamwiz.com";
	$A_EMAIL[] = "lycos.co.kr";
	$A_EMAIL[] = "magicn.com";
	$A_EMAIL[] = "yahoo.co.kr";
	$A_EMAIL[] = "orgio.net";
	$A_EMAIL[] = "unitel.co.kr";
	$A_EMAIL[] = "chollian.net";
	$A_EMAIL[] = "kornet.net";
	$A_EMAIL[] = "korea.com";
	$A_EMAIL[] = "freechal.com";
	$A_EMAIL[] = "hananet.net";
	$A_EMAIL[] = "hitel.net";
	$A_EMAIL[] = "hanmir.com";
	$A_EMAIL[] = "hotmail.com";
// =====================
function script_alert_msg($msg){
	echo "<script language='javascript'><!--
		alert('$msg');
	--></script>";
}

function msg($msg){
	echo "<script language='javascript'><!--
		alert('$msg');
	--></script>";
}

function script_back(){
	echo "
	<script>
		<!--
		history.back();
		-->
	</script>";
	exit;
}


function back(){
	echo "
	<script>
		<!--
		history.back();
		-->
	</script>";
	exit;
}


function win_close(){
	echo "
	<script>
		<!--
		this.close();
		-->
	</script>";
	exit;
}

 function go_url_time($url, $time){
	echo "<meta http-equiv='refresh' content='$time; url=$url'>";
 }

  function go_url($url){
	echo "<meta http-equiv='refresh' content='0; url=$url'>";
	exit;
 }

  function go_url2($url,$target="this"){
	echo "
	<script>
		<!--
		$target.location='$url';
		-->
	</script>";
	exit;

 }

  function go_error_page(){
	echo "<meta http-equiv='refresh' content='0; url=../common/error.php'>";
	exit;
 }

   function error(){
	echo "<meta http-equiv='refresh' content='0; url=../common/error.php'>";
	exit;
 }

 function msg_back($msg){
	script_alert_msg($msg);
	script_back();
 }

// ==============================
// 서브함수의 선언
// ------------------------------
	function sub_check_per($level){	
		global $m_user_info;
		global $SESSION_KEY;
		global $url_login;
		if(!$SESSION_KEY && ($level <10)){
			echo "
				<form name=frm_login action='$url_login' method='get'>
				</form>
			<script>
				<!--
					frm_login.submit();
				-->
			</script>
			";			
			exit;
			go_url($url_login);
		}
		if(($level < $m_user_info[user_level]) || ($m_user_info[user_level]=="")){
			msg_back("권한이 없습니다");
		}

	}	//	end of function sub_check_per($level)
// ==============================

function getFileExt($filename){
	return substr($filename,strrpos($filename,".")+1);
}

function checkFile($filename){
	$ext =  getFileExt($filename);
	$result_boolean = false;

	if(!eregi("htm",$ext) && !eregi("php",$ext)){
	$result_boolean = true;
	}

	return $result_boolean;
}
	


	function select_status($code){
		switch($code){
			case 1:	$m_select[0]="selected";	break;
			case 2:	$m_select[1]="selected";	break;
			case 8:	$m_select[2]="selected";	break;
			case 9:	$m_select[3]="selected";	break;
		}	//	end of switch

		echo "<option value='1' $m_select[0]>가입1";
		echo "<option value='2' $m_select[1]>가입2";
		echo "<option value='8' $m_select[2]>임시";
		echo "<option value='9' $m_select[3]>탈퇴";		
	}	//	end of 	function select_status($code)

	function getSundayReturnArray($m_year,$m_month){
		$m_returnDataArray;

		if($m_month == 2){
			$total_day = 28 + getLeapYear($m_year);
		}else{
			if((($m_month<8) && ($m_month % 2 ==1)) || ($m_month>7) && ($m_month % 2 ==0)){
				$total_day = 31;
			}else{
				$total_day = 30;
			}	//	end of else [if((($m_month<8) ... ]
		}	//	end of else [if($m_month == 2)]

		$m_day = 1;
		$first_day_week = getWeekName($m_month, $m_day, $m_year);
		$m_day = $total_day;
		$last_day_week = getWeekName($m_month, $m_day, $m_year);

		for($i=1;$i<=$total_day;$i++){
			if(getWeekName($m_month, $i, $m_year)==0){
				$m_returnDataArray[]=$m_year.addZeroNumberString($m_month,2).addZeroNumberString($i,2);
			}
		}	//	end of for
		return $m_returnDataArray;
	}	//	end of function

	function regSunday($m_year, $tbl_schedule, &$conn){
	// ===========================
	// 년도에 따른 등록이 있는지 검사
	// ---------------------------
		$sql = "SELECT count(reserved_date) FROM $tbl_schedule WHERE substring(reserved_date,1,4)='$m_year'";
		if(!$result = mysql_query($sql, $conn)){
			disConnect($conn);
			script_alert_msg("스케쥴 테이블 정보 추출 실패");
			go_error_page();		
		}else{
			$m_count = mysql_result($result,0,0);
			mysql_free_result($result);
		}
	// ===========================

	// 없으면.... 등록...
	//	$m_reserved_date

		if($m_count<1){		
			for($i=1;$i<=12;$i++){
				$m_get_date = getSundayReturnArray($m_year,$i);

					// --------------------
					for($j=0;$j<count($m_get_date);$j++){
						$m_reserved_date = $m_get_date[$j];
						$sql = "insert unb_schedule(reserved_date) values($m_reserved_date)";				
						// --------------------
						if(!mysql_query($sql,$conn)){
							disConnect($conn);
							script_alert_msg("스케쥴 테이블 Insert 실패");
							go_error_page();					
						}
						// --------------------
					}
					// --------------------
			}
		}	//	end of if


		return true;
	}	//	end of function


	function getSelectMonthList($counter){
		for($i=1;$i<=$counter;$i++){
			if($i<10)	 $nbsp="&nbsp;";
			else	$nbsp="";
			echo "<option value='".addZeroNumberString($i,2)."'>$nbsp$i	 \n";
		}	//	end of for
	}





// ===========================
//	레벨 셀렉트 박스
// ---------------------------
	function get_select_level($level){
		for($i=1;$i<=10;$i++){
			if($i==$level){
				echo "<option value='$i' selected>$i";
			}else{
				echo "<option value='$i'>$i";
			}	//	end of if
		}	//	end of for
	}	//	end of function get_select_level($level)
// ===========================

	function getSelectCountList1($counter){
		for($i=1;$i<=$counter;$i++){
			if($i<10)	 $nbsp="&nbsp;";
			else	$nbsp="";
			echo "<option value='".addZeroNumberString($i,2)."'>$nbsp$i	 \n";
		}	//	end of for
	}

	function getSelectCountList2($counter,$select_number){
		for($i=1;$i<=$counter;$i++){
			$m_status = "";
			if($select_number==$i)	$m_status = "selected";
			if($i<10)	 $nbsp="&nbsp;";
			else	$nbsp="";

			echo "<option value='".addZeroNumberString($i,2)."' $m_status>$nbsp$i	 \n";
		}	//	end of for
	}

	function getUserCountOptions($start,$stop){
		for($i=$start;$i<=$stop;$i++){
			if($i<10)	 $nbsp="&nbsp;";
			else	$nbsp="";
			echo "<option value='".addZeroNumberString($i,2)."'>$nbsp$i	 \n";
		}	//	end of for
	}

	function getSelectUserCountOptions($start,$stop,$select){
		for($i=$start;$i<=$stop;$i++){
			$m_status = "";
			if($select==$i)	$m_status = "selected";
			if($i<10)	 $nbsp="&nbsp;";
			else	$nbsp="";

			echo "<option value='".addZeroNumberString($i,2)."' $m_status>$nbsp$i	 \n";
		}	//	end of for
	}


	function getYearOptions1($year,$add_num){
		$start=$year;
		$stop=$year+$add_num;
		getUserCountOptions($start,$stop);
	}

	function getYearOptions2($year,$add_num){
		$start=$year-$add_num;
		$stop=$year;
		getUserCountOptions($start,$stop);
	}

	function getYearOptions3($year,$add_num){
		$start=$year-(ceil($add_num/2));
		$stop=$year+(ceil($add_num/2));
		getUserCountOptions($start,$stop);
	}

	function getSelectYearOptions1($year,$add_num,$select){
		$start=$year;
		$stop=$year+$add_num;
		getSelectUserCountOptions($start,$stop,$select);
	}

	function getSelectYearOptions2($year,$add_num,$select){
		$start=$year-$add_num;
		$stop=$year;
		getSelectUserCountOptions($start,$stop,$select);
	}

	function getSelectYearOptions3($year,$add_num,$select){
		$start=$year-(ceil($add_num/2));
		$stop=$year+(ceil($add_num/2));
		getSelectUserCountOptions($start,$stop,$select);
	}


	function getEndDay($m_year, $m_month){
		if($m_month == 2){
			$total_day = 28 + getLeapYear($m_year);
		}else{
			if((($m_month<8) && ($m_month % 2 ==1)) || ($m_month>7) && ($m_month % 2 ==0)){
				$total_day = 31;
			}else{
				$total_day = 30;
			}	//	end of else [if((($m_month<8) ... ]
		}	//	end of else [if($m_month == 2)]
		return $total_day;
	}





	function getWeekly($p_date){
		$weekly_array = array("일","월","화","수","목","금","토");
		$p_date2 = getDate2Array($p_date);
		$p_number = getWeekName($p_date2[1],$p_date2[2],$p_date2[0]);


		return $weekly_array[(int)$p_number];
	}



	function getDaySelectSundayList($p_startDay,$p_stopDay){
		$st_date_array = getDate2Array($p_startDay);
		$m_day_count	 = getWeekName($st_date_array[1], $st_date_array[2], $st_date_array[0]);

		if($m_day_count!=0){
			$p_startDay = getAddDayEndDate($st_date_array[0],$st_date_array[1],$st_date_array[2],-$m_day_count);
		}	//	end of if
			echo "<option value='$p_startDay'>$p_startDay \n";
		while($p_startDay != $p_stopDay){
			$st_date_array = getDate2Array($p_startDay);
			$p_startDay = getAddDayEndDate($st_date_array[0],$st_date_array[1],$st_date_array[2],7);
			echo "<option value='$p_startDay'>$p_startDay \n";
		}	//	end of while
	
	}	//	end of function




		function getYearOptions($des_year,$select_year,$count,$status=1){
			//	$status	(1:이전카운트	2: 이후카운트,	3:중간)

			if(!$select_year)	$select_year=date("Y");

			switch($status){
				case 1:
					$start = $des_year-$count;
					$stop = $des_year;
					break;
				case 2:
					$start = $des_year;
					$stop = $des_year+$count;
					break;
				case 3:
					$start = $des_year-(int)($count/2);
					$stop = $des_year+(int)($count/2);
					break;
			}	//	end of switch


			for($start;$start<=$stop;$start++){
				$select = null;
				if($start==$select_year)	 $select = "selected";
				echo "<option value='$start'	$select>$start</option>	\n";
			}	//	end of for
	}	//	end of function getYear($start_year,$count,$status=1)


function getMedicalOptions($group_id,&$conn){
	global $t_join;
	global $t_group;
	global $t_mdc;
// a: 조인정보
// b: 지점정보
// c: 병원정보 

	$sql = " select c.pk_id,c.name from";
	$sql.= " $t_join as a,";
	$sql.= " $t_group as b,"; 
	$sql.= " $t_mdc as c";
	$sql.= " where a.group_id='$group_id'";
	$sql.= " and a.group_id=b.group_id ";
	$sql.= " and a.pk_id=c.pk_id";
	$sql.= " and a.status=1";
	if($result = mysql_query($sql, $conn)){
		for($i=0;$i<mysql_num_rows($result);$i++){
			mysql_data_seek($result,$i);
			$rows=mysql_fetch_array($result);
			echo "<option value=$rows[name]>$rows[name] \n";
		}	//	end of for
	}
}	//	end of function

function getSelectMedicalOptions($group_id,$selectCode,&$conn){
	global $t_join;
	global $t_group;
	global $t_mdc;
// a: 조인정보
// b: 지점정보
// c: 병원정보
	$sql = " select c.pk_id,c.name from";
	$sql.= " $t_join as a,";
	$sql.= " $t_group as b,"; 
	$sql.= " $t_mdc as c";
	$sql.= " where a.group_id='$group_id'";
	$sql.= " and a.group_id=b.group_id ";
	$sql.= " and a.pk_id=c.pk_id";

	if($result = mysql_query($sql, $conn)){
		for($i=0;$i<mysql_num_rows($result);$i++){
			mysql_data_seek($result,$i);
			$rows=mysql_fetch_array($result);
			$checked="";
			if($selectCode==$rows[pk_id])	$checked="selected";
			echo "<option value='$rows[pk_id]' $checked>$rows[name] \n";
		}	//	end of for
	}
}	//	end of function

function getSelectMedicalOptionName($group_id,$selectCode,&$conn){
	global $t_join;
	global $t_group;
	global $t_mdc;
// a: 조인정보
// b: 지점정보
// c: 병원정보
	$sql = " select c.pk_id,c.name from";
	$sql.= " $t_join as a,";
	$sql.= " $t_group as b,"; 
	$sql.= " $t_mdc as c";
	$sql.= " where a.group_id='$group_id'";
	$sql.= " and a.group_id=b.group_id ";
	$sql.= " and a.pk_id=c.pk_id";

	if($result = mysql_query($sql, $conn)){
		for($i=0;$i<mysql_num_rows($result);$i++){
			mysql_data_seek($result,$i);
			$rows=mysql_fetch_array($result);
			$checked="";
			if($selectCode==$rows[name])	$checked="selected";
			echo "<option value='$rows[name]' $checked>$rows[name] \n";
		}	//	end of for
	}
}	//	end of function
			

function getEmailList(){
	global $A_EMAIL;
	for($i=0;$i<count($A_EMAIL);$i++){
		echo "<option value='$A_EMAIL[$i]'>$A_EMAIL[$i] \n";
	}	//	end of for
}	//	end of function getEmailList()

function getSelectEmailList($email_dns){
	global $A_EMAIL;

	for($i=0;$i<count($A_EMAIL);$i++){
		$selected="";
		if($A_EMAIL[$i]==$email_dns)	$selected="selected";

			echo "<option value='$A_EMAIL[$i]' $selected>$A_EMAIL[$i] \n";
	}	//	end of for
}	//	end of function getEmailList()

/*
	function getUserImage($user_id, &$conn, $align ="left", $detail = "Y", $tbl_align="right"){

		global $save_dir;
		global $USERHOME;

//    $USERHOME = "http://cocophoto.bebero.com/home/?id=";

		$img_src = "http://cocophoto.bebero.com/bebero/comm/basic_img/pic_no.gif";
		$add_location = "";

		$sql = "select * from tbl_home_album where search_fg=1 and user_id='$user_id'";
		$img_info = getObjectSQL2($sql, $conn);

		$img_size_info[0] = 100;
		$img_size_info[1] = 121;
		
		if($img_info){
			if($img_info[dir]){
				$add_location = "$img_info[dir]/";
			}
			$src = "$save_dir/album2/".$add_location.$img_info[file];
			$img_src = "http://cocophoto.bebero.com/upload_home/album2/".$add_location.$img_info[file];

			$size = 130;
			$gsize = getimagesize ($src);

			$img_size_info = null;
			$img_size_info = getImageReSize($size,$size, $gsize[0], $gsize[1]);
		}
		
		$sql = "select homepage from tbl_members where user_id='$user_id'";
		$home_fg = getOneDataSQL2($sql, $conn);

		if($home_fg!=9)	$url_home = "<a href=\"$USERHOME$user_id\" target=\"_blank\">";
		else					$url_home = "";

		$returned = "$url_home<img src='$img_src' width='$img_size_info[0]' height='$img_size_info[1]' border=4 style=\"border-color:EEEEEE\" align='$align'></a>";


		if($detail == "Y"){
			$header = "<table align=$tbl_align cellspacing=0 cellpadding=0 border=0>";
			$header.= "	 <tr>";
			$header.= "		<td align=center>";

			$footer = "</td>";
			$footer.= "	 </tr>";
			$footer.= " <tr>";
			$footer.= "		<td align=center><font color='#939067'>[";
			$footer.= getBabyDays($user_id, date("Y-m-d"), $conn);
			$footer.= "]&nbsp;&nbsp;";
			$footer.= getBabyName($user_id, $conn);
			$footer.= "</font></td>";
			$footer.= "	 </tr>";
			$footer.= "</table>";
		}else{
			$header = "";
			$footer = "";
		}

		return $header.$returned.$footer;

	}	
*/
function getUserImage($user_id, &$conn, $align ="left", $detail = "Y", $tbl_align="right")
{
  global $save_dir;
	global $USERHOME;

	$img_src = "http://cocophoto.bebero.com/bebero/comm/basic_img/pic_no.gif";
	$add_location = "";

  $class_id = substr("$user_id",0,1);
  $t_home_album = "tbl_home_album"."_"."$class_id";

 	$sql = "select * from $t_home_album where search_fg=1 and user_id='$user_id'";
  $img_info = getObjectSQL2($sql, $conn);

 	$img_size_info[0] = 100;
  $img_size_info[1] = 121;
		
  if($img_info)
  {
	  if($img_info[dir])
 		{
  	  $add_location = "$img_info[dir]/";
	  }

    $photo_dir = substr("$img_info[file]",0,1);
    
 		$src = "$save_dir/album2/".$add_location."/".$photo_dir."/".$img_info[file];
   	$img_src = "http://cocophoto.bebero.com/upload_home/album2/".$add_location."/".$photo_dir."/".$img_info[file];

/*
			$src = "../../home/upload/album2/".$add_location.$img_info[file];
			$img_src = "../../upload_home/album2/".$add_location.$img_info[file];
*/			
 		$size = 130;
  	$gsize = getimagesize ($src);

	  $img_size_info = null;
 		$img_size_info = getImageReSize($size,$size, $gsize[0], $gsize[1]);
  }
		
 	$sql = "select homepage from tbl_members where user_id='$user_id'";
  $home_fg = getOneDataSQL2($sql, $conn);

 	if($home_fg!=9)	$url_home = "<a href=\"$USERHOME$user_id\" target=\"_blank\">";
  else					$url_home = "";

 	$returned = "$url_home<img src='$img_src' width='$img_size_info[0]' height='$img_size_info[1]' border=4 style=\"border-color:EEEEEE\" align='$align'></a>";

 	if($detail == "Y")
  {
 		$header = "<table align=$tbl_align cellspacing=0 cellpadding=0 border=0>";
  	$header.= "	 <tr>";
 		$header.= "		<td align=center>";
  	$footer = "</td>";
	  $footer.= "	 </tr>";
 		$footer.= " <tr>";
  	$footer.= "		<td align=center><font color='#939067'>[";
	  $footer.= getBabyDays($user_id, date("Y-m-d"), $conn);
 		$footer.= "]&nbsp;&nbsp;";
  	$footer.= getBabyName($user_id, $conn);
 		$footer.= "</font></td>";
  	$footer.= "	 </tr>";
 		$footer.= "</table>";
  }
 	else
  {
	  $header = "";
 		$footer = "";
  }

  return $header.$returned.$footer;	
}	

function getUserImage2($user_id, &$conn, $align ="left", $detail = "Y", $tbl_align="center")
{
  global $save_dir;
	global $USERHOME;

	$img_src = "http://cocophoto.bebero.com/bebero/comm/basic_img/pic_no.gif";
	$add_location = "";

  $class_id = substr("$user_id",0,1);
  $t_home_album = "tbl_home_album"."_"."$class_id";

 	$sql = "select * from $t_home_album where search_fg=1 and user_id='$user_id'";
  $img_info = getObjectSQL2($sql, $conn);

 	$img_size_info[0] = 100;
  $img_size_info[1] = 121;
		
  if($img_info)
  {
	  if($img_info[dir])
 		{
  	  $add_location = "$img_info[dir]/";
	  }

    $photo_dir = substr("$img_info[file]",0,1);
    
 		$src = "$save_dir/album2/".$add_location."/".$photo_dir."/".$img_info[file];
   	$img_src = "http://cocophoto.bebero.com/upload_home/album2/".$add_location."/".$photo_dir."/".$img_info[file];

/*
			$src = "../../home/upload/album2/".$add_location.$img_info[file];
			$img_src = "../../upload_home/album2/".$add_location.$img_info[file];
*/			
 		$size = 130;
  	$gsize = getimagesize ($src);

	  $img_size_info = null;
 		$img_size_info = getImageReSize($size,$size, $gsize[0], $gsize[1]);
  }
		
 	$sql = "select homepage from tbl_members where user_id='$user_id'";
  $home_fg = getOneDataSQL2($sql, $conn);

 	if($home_fg!=9)	$url_home = "<a href=\"$USERHOME$user_id\" target=\"_blank\">";
  else					$url_home = "";

 	$returned = "$url_home<img src='$img_src' width='$img_size_info[0]' height='$img_size_info[1]' border=4 style=\"border-color:EEEEEE\" align='$align'></a>";

 	if($detail == "Y")
  {
 		$header = "<table align=$tbl_align cellspacing=0 cellpadding=0 border=0>";
  	$header.= "	 <tr>";
 		$header.= "		<td align=center>";
  	$footer = "</td>";
	  $footer.= "	 </tr>";
 		$footer.= " <tr>";
  	$footer.= "		<td align=center class=webzizon><font color='#939067'>[";
	  $footer.= getBabyDays($user_id, date("Y-m-d"), $conn);
 		$footer.= "]&nbsp;&nbsp;";
  	$footer.= getBabyName($user_id, $conn);
 		$footer.= "</font></td>";
  	$footer.= "	 </tr>";
 		$footer.= "</table>";
  }
 	else
  {
	  $header = "";
 		$footer = "";
  }

  return $header.$returned.$footer;	
}	

function getUserImage3($user_id, &$conn, $align ="left", $detail = "Y", $tbl_align="center")
{
  global $save_dir;
	global $USERHOME;

	$img_src = "http://cocophoto.bebero.com/bebero/comm/basic_img/pic_no.gif";
	$add_location = "";

  $class_id = substr("$user_id",0,1);
  $t_home_album = "tbl_home_album"."_"."$class_id";

 	$sql = "select * from $t_home_album where search_fg=1 and user_id='$user_id'";
  $img_info = getObjectSQL2($sql, $conn);

 	$img_size_info[0] = 100;
  $img_size_info[1] = 121;
		
  if($img_info)
  {
	  if($img_info[dir])
 		{
  	  $add_location = "$img_info[dir]/";
	  }

    $photo_dir = substr("$img_info[file]",0,1);
    
 		$src = "$save_dir/album2/".$add_location."/".$photo_dir."/".$img_info[file];
   	$img_src = "http://cocophoto.bebero.com/upload_home/album2/".$add_location."/".$photo_dir."/".$img_info[file];

/*
			$src = "../../home/upload/album2/".$add_location.$img_info[file];
			$img_src = "../../upload_home/album2/".$add_location.$img_info[file];
*/			
 		$size = 130;
  	$gsize = getimagesize ($src);

	  $img_size_info = null;
 		$img_size_info = getImageReSize($size,$size, $gsize[0], $gsize[1]);
  }
		
 	$sql = "select homepage from tbl_members where user_id='$user_id'";
  $home_fg = getOneDataSQL2($sql, $conn);

 	if($home_fg!=9)	$url_home = "<a href=\"$USERHOME$user_id\" target=\"_blank\">";
  else					$url_home = "";

 	$returned = "$url_home<img src='$img_src' width='80' height='100' border=0></a>";

/*
 	if($detail == "Y")
  {
 		$header = "<table align=center cellspacing=0 cellpadding=0 border=0>";
  	$header.= "	 <tr>";
 		$header.= "		<td align=center>";
  	$footer = "</td>";
	  $footer.= "	 </tr>";
 		$footer.= " <tr>";
  	$footer.= "		<td align=center class=webzizon><font color='#939067'>[";
	  $footer.= getBabyDays($user_id, date("Y-m-d"), $conn);
 		$footer.= "]<br>";
  	$footer.= getBabyName($user_id, $conn);
 		$footer.= "</font></td>";
  	$footer.= "	 </tr>";
 		$footer.= "</table>";
  }
 	else
  {
	  $header = "";
 		$footer = "";
  }
*/

  return $header.$returned.$footer;	
}	

function getUserImage4($user_id, &$conn, $align ="left", $detail = "Y", $tbl_align="center")
{
  global $save_dir;
	global $USERHOME;

	$img_src = "http://cocophoto.bebero.com/bebero/comm/basic_img/pic_no.gif";
	$add_location = "";

  $class_id = substr("$user_id",0,1);
  $t_home_album = "tbl_home_album"."_"."$class_id";

 	$sql = "select * from $t_home_album where search_fg=1 and user_id='$user_id'";
  $img_info = getObjectSQL2($sql, $conn);

 	$img_size_info[0] = 100;
  $img_size_info[1] = 121;
		
  if($img_info)
  {
	  if($img_info[dir])
 		{
  	  $add_location = "$img_info[dir]/";
	  }

    $photo_dir = substr("$img_info[file]",0,1);
    
 		$src = "$save_dir/album2/".$add_location."/".$photo_dir."/".$img_info[file];
   	$img_src = "http://cocophoto.bebero.com/upload_home/album2/".$add_location."/".$photo_dir."/".$img_info[file];

/*
			$src = "../../home/upload/album2/".$add_location.$img_info[file];
			$img_src = "../../upload_home/album2/".$add_location.$img_info[file];
*/			
 		$size = 130;
  	$gsize = getimagesize ($src);

	  $img_size_info = null;
 		$img_size_info = getImageReSize($size,$size, $gsize[0], $gsize[1]);
  }
		
 	$sql = "select homepage from tbl_members where user_id='$user_id'";
  $home_fg = getOneDataSQL2($sql, $conn);

 	if($home_fg!=9)	$url_home = "<a href=\"$USERHOME$user_id\" target=\"_blank\">";
  else					$url_home = "";

 	$returned = "$url_home<img src='$img_src' width='$img_size_info[0]' height='$img_size_info[1]' border=0 style=\"border-color:EEEEEE\" align='$align'></a>";

/*
 	if($detail == "Y")
  {
 		$header = "<table align=$tbl_align cellspacing=0 cellpadding=0 border=0>";
  	$header.= "	 <tr>";
 		$header.= "		<td align=center>";
  	$footer = "</td>";
	  $footer.= "	 </tr>";
 		$footer.= " <tr>";
  	$footer.= "		<td align=center class=webzizon><font color='#939067'>[";
	  $footer.= getBabyDays($user_id, date("Y-m-d"), $conn);
 		$footer.= "]&nbsp;&nbsp;";
  	$footer.= getBabyName($user_id, $conn);
 		$footer.= "</font></td>";
  	$footer.= "	 </tr>";
 		$footer.= "</table>";
  }
 	else
  {
	  $header = "";
 		$footer = "";
  }
*/
  return $returned;	
}	

function getBabyDays($user_id, $this_date, &$conn){
// =============================
// 월령 추출
// -----------------------------
	$sql = "select birthday from tbl_members where user_id='$user_id'";
	$birthday = getOneDataSQL2($sql, $conn);

	$tmp = 0;

	$m_this_date = convertDate2($this_date,"");
	$m_birthdate = convertDate2($birthday,"");
	$tmp = date_gab($m_this_date, $m_birthdate)+1;					
	// 생일보다 이전의 글이라면...
	if( ($m_this_date - 0) < ($m_birthdate - 0) ){
		$tmp = "D-".($tmp-1)."일";
	}else{
		$tmp.= " 일째";
	}
	return $tmp;
// =============================
}	//	end of function getBabyDays($user_id, &$conn){


function getBabyName($user_id, &$conn){
	global $USERHOME;
	$sql = "select bname,homepage from tbl_members where user_id='$user_id'";
	$rows = getObjectSQL2($sql, $conn);

	$bname = stripslashes($rows[bname])."</a>";;

	if($rows[homepage]!=9)	$add_str = "<a href=\"$USERHOME$user_id\" target=\"_blank\">";

	return $add_str.$bname;
}	//	end of function getBabyName($user_id, &$conn)

function getAlbumSrc($fileName)
{
	$returned = "../file/image1/$fileName";
	return $returned;
}	//	end of function 
?>