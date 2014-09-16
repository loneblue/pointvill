<?

//################################################
//## 날짜 관련 함수....
//################################################

	Function getTodayLong(){
		return date("YmdHis");			
	}	//	end of Function getTodayLong()

	Function getTodayShort(){
		return date("Y")."-".date("m")."-".date("d");
	}	//	end of Function getTodayShort()
	
	Function getToday(){
		return date("Ymd");			
	}	//	end of Function getToday()

	Function getDateArray(){
		$returnData[0]=date("Y");
		$returnData[1]=date("m");
		$returnData[2]=date("d");
		$returnData[3]=date("w");
		$returnData[4]=date("His");
		return $returnData;
	}	//	end of Function getToday()

    Function convertDate($m_Date,$m_DivChar){
		return convertDate1($m_Date,$m_DivChar);
	}	//	end of Function convertDate

    Function convertDate1($m_Date,$m_DivChar){
		$year = substr($m_Date,0,4).$m_DivChar;
		$month = substr($m_Date,4,2).$m_DivChar;
		$day = substr($m_Date,6,2);

		return $year.$month.$day;
	}	//	end of Function convertDate

    Function getDate1Array($m_Date){
		$returnArray[] = substr($m_Date,0,4);
		$returnArray[] = substr($m_Date,4,2);
		$returnArray[] = substr($m_Date,6,2);

		return $returnArray;
	}	//	end of Function convertDate

    Function getDate2Array($m_Date){
		$returnArray[] = substr($m_Date,0,4);
		$returnArray[] = substr($m_Date,5,2);
		$returnArray[] = substr($m_Date,8,2);

		return $returnArray;
	}	//	end of Function convertDate

    Function convertDate2($m_Date,$m_DivChar){
		$year = substr($m_Date,0,4).$m_DivChar;
		$month = substr($m_Date,5,2).$m_DivChar;
		$day = substr($m_Date,8,2);

		return $year.$month.$day;
	}	//	end of Function convertDate

    Function convertDate3($m_Date,$m_DivChar){
		$month = substr($m_Date,5,2).$m_DivChar;
		$day = substr($m_Date,8,2);

		return $month.$day;
	}	//	end of Function convertDate

    Function convertDate4($m_Date,$m_DivChar){
		$year = substr($m_Date,2,2).$m_DivChar;
		$month = substr($m_Date,5,2).$m_DivChar;
		$day = substr($m_Date,8,2);

		return $year.$month.$day;
	}	//	end of Function convertDate


	Function getAddMonthEndDate($start_yyyy,$start_mm,$start_dd,$addMonth){
		$s_yyyy =intval($start_yyyy);
		$s_mm = intval($start_mm)+intval($addMonth);
		$s_dd= intval($start_dd);

		return date("Y-m-d", mktime(0,0,0,$s_mm,$s_dd,$s_yyyy));
	}

	Function getAddDayEndDate($start_yyyy,$start_mm,$start_dd,$addDay){
		$s_yyyy =intval($start_yyyy);
		$s_mm = intval($start_mm);
		$s_dd= intval($start_dd)+intval($addDay);

		return date("Y-m-d", mktime(0,0,0,$s_mm,$s_dd,$s_yyyy));
	}


	function getLeapYear($p_year){
		/*
		윤년의 정의
		연도가 4로 나누어 떨어지는 해는 윤년이고,  
		그 중 연도가 100으로 나누어 떨어지는 해는 윤년이 아니다.  
		그중 연도가 400으로 나누어 떨어지는 해는 윤년이다.  
		*/
		$yd_fg=0;

		(($p_year % 4)==0) ? (((($p_year % 400)!=0) && ($p_year%100)==0) ? $yd_fg=0 : $yd_fg=1) : $yd_fg=0;
		return $yd_fg;
	}

	function getWeekName($p_month,$p_day,$p_year){
		return date("w", mktime(0,0,0,$p_month,$p_day,$p_year));
	}


//################################################
//## 문자 변환 함수
//################################################

	//## 숫자의 , 표시 해주는 함수
	Function NumberFormat($m_Number){
		return number_format($m_Number,10,".",",");
	}	//	end of NumberFormat

	Function addNbspTag($number){
		$returnData="";
		for($i=0;$i<$number;$i++){
			$returnData.="&nbsp;&nbsp;";
		}
		return $returnData;
	}	//	end of NumberFormat

	//## &nbsp; 및 <br>태그의 삽입
	Function replaceBrTag($string){
		return nl2br($string);
	}	//	end of NumberFormat	

	Function replaceNbspTag($string){
		return eregi_replace("\" \"","&nbsp;",$string);
////		return eregi_replace("\" \",\"&nbsp;\"",$string); 

	}	//	end of NumberFormat	

	Function convertHtml($string){
		return replaceBrTag(replaceNbspTag($string));
	}

	Function addZeroNumberString($String, $number){
		$length=strlen(strval($String));
		$ZeroString="";
		//--------------------------------
		for($i=$length;$i<$number;$i++){
			$ZeroString.="0";
		}	//	end of for
		//--------------------------------
		$StringData=trim($ZeroString.$String);
		return $StringData;
	}

	Function getLimitStringManager($String, $int, $shortString){
		$returnData="";		

		if(strlen($String)>$int){
			$returnData = substr($String,0,$int).$shortString;
		}else{
			$returnData = $String;
		}	//	end of else [if(strlen($String)>$int)]

		return $returnData;
	}

	Function getLimitString($String, $int){
		return getLimitStringManager($String, $int, "...");
	}	// end of Function getLimitString($String, $int)

	Function checkedHtml($String){
		$String = str_replace("<","&lt",$String);//   (< less-than symbol) 
//		$String = str_replace(">","&gt",$String);   //(> greater-than symbol) 
//		$String = ("&","&amp",$String);  //(& ampersand) 
//		$String = (""","&quot",$String); //(" quotation mark) 
//		$String = ("~","&shy",$String);  //(~ soft hyphen) 
		return $String;
	}	// end of Function getLimitString($String, $int)

	Function unCheckedHtml($String){
		$String = str_replace("&lt","<",$String);//   (< less-than symbol) 
//		$String = str_replace("&gt",">",$String);   //(> greater-than symbol) 
		return $String;
	}	// end of Function getLimitString($String, $int)

	Function reply_content_String($string,$start_word){
		$string = str_replace("\n","\n".$start_word."&nbsp;",$string);
		$string = "============ 원문 ============ \n".$start_word."&nbsp;".$string;
		$string = "\n".$start_word."&nbsp;".$string;
		return $string;
	}

	Function reply_content($string){
		return reply_content_String($string,"|");
	}

	Function search_word_bold($string, $keyword, $bold_color){
		$string = str_replace($keyword,"<font color='$bold_color'><b>$keyword</b></font>",$string);
		return $string;

	}

	Function convertNumber($number){
		return number_format($number,0,".",",");
	}

	Function html_format($text, $break = 1) 
	  { 
		$text = stripslashes($text); 
		$text = ereg_replace("<\?", "&lt;?", $text); 
		$text = ereg_replace("\?>", "?&gt;", $text); 
		$text = eregi_replace("<html", "<x-html", $text); 
		$text = eregi_replace("</html", "</x-html", $text); 
		$text = eregi_replace("<body", "<x-body", $text); 
		$text = eregi_replace("</body", "</x-body", $text); 
		$text = eregi_replace("<head", "<x-head", $text); 
		$text = eregi_replace("</head", "</x-head", $text); 
		$text = eregi_replace("<title", "<x-title", $text); 
		$text = eregi_replace("</title", "</x-title", $text); 
		$text = eregi_replace("<script", "<x-script", $text); 
		$text = eregi_replace("</script", "</x-script", $text); 
		$text = eregi_replace("<form", "<x-form", $text); 
		$text = eregi_replace("</form", "</x-form", $text); 
		$text = eregi_replace("<select", "<x-select", $text); 
		$text = eregi_replace("</select", "</x-select", $text); 
		$text = eregi_replace("<textarea", "<x-textarea", $text); 
		$text = eregi_replace("</textarea", "</x-textarea", $text); 
		$text = eregi_replace("<input", "<x-input", $text); 

		//<?
		// 공백만큼 공간을 넓혀주기 위한 부분입니다. 
		// ereg_replace(" ","&nbsp;", $text)처럼 사용하게 되면 
		// 브라우저에서 자동 행구분을 못해주기 때문에 문자열의 길이만큼 
		// 표의 폭이 늘어나거나 하는 부작용이 생길 수 있습니다. 
		// 이 부분은 필요에 따라 사용하시면 됩니다. 
		$text = ereg_replace("  "," &nbsp;",$text); 

		if( $break ) 
		  $text = nl2br($text); 

		return $text; 
	  } 

	Function auto_link($text) 
	{ 
		$ret = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\" target=\"_blank\" target=\"_new\">\\1://\\2\\3</a>", $text); 
	$ret = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href=\"mailto:\\1\" target=\"_new\">\\1</a>", $ret); 
	return($ret); 
	} 


//################################################
//## 카테고리 Select 함수
//################################################

function getSelectCategoryCode($table_name, $major_cd, $code, &$conn){
	$sql = "select minor_cd, code_nm from $table_name where major_cd='$major_cd' and status=1 order by code_nm asc";
	$result = mysql_query($sql,$conn);
	if($result){
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			$minor_cd = mysql_result($result,$i,0);
			$code_nm = mysql_result($result,$i,1);
				if($minor_cd==$code)	{ 
					$selectStatus="selected";
				}else{	
					$selectStatus="";
				}	//	end of if($minor_cd==$code)
			echo "<option value='".$minor_cd."' ".$selectStatus." >".$code_nm;
		}	//	end of for
	}	//	end of if($result)
}	//	end of function getSelectCategoryCode

function getCategoryCode($table_name, $major_cd, &$conn){
	$sql = "select minor_cd, code_nm from $table_name where major_cd='$major_cd' and status=1 order by code_nm asc";

	$result = mysql_query($sql,$conn);
	if($result){
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			$minor_cd = mysql_result($result,$i,0);
			$code_nm = mysql_result($result,$i,1);
			echo "<option value='".$minor_cd."'>".$code_nm;
		}	//	end of for
	}	//	end of if($result)
}	//	end of function getCategoryCode

function getSelectCategoryCodeName($table_name, $major_cd, $code_name, &$conn){
	$sql = "select code_nm from $table_name where major_cd='$major_cd' and status=1";
	$result = mysql_query($sql,$conn);
	if($result){
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			$code_nm = mysql_result($result,$i,0);
				if($code_nm==$code_name)	{ 
					$selectStatus="selected";
				}else{	
					$selectStatus="";
				}	//	end of if($minor_cd==$code)
			echo "<option value='".$code_nm."' ".$selectStatus." >".$code_nm;
		}	//	end of for
	}	//	end of if($result)
}	//	end of function getSelectCategoryCode

function getCategoryCodeName($table_name, $major_cd, &$conn){
	$sql = "select code_nm from $table_name where major_cd='$major_cd' and status=1";
	$result = mysql_query($sql,$conn);
	if($result){
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			$code_nm = mysql_result($result,$i,0);
			echo "<option value='".$code_nm."'>".$code_nm;
		}	//	end of for
	}	//	end of if($result)
}	//	end of function getCategoryCode



function getCategoryCode2($table_name, $major_cd, &$conn){
	$sql = "select minor_cd, code_nm from $table_name where major_cd='$major_cd' and status=1 order by code_nm asc";

	$result = mysql_query($sql,$conn);
	if($result){
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			$minor_cd = mysql_result($result,$i,0);
			$code_nm = mysql_result($result,$i,1);
			echo "<option value='".$minor_cd."'>".((int)$minor_cd).". ".$code_nm;
		}	//	end of for
	}	//	end of if($result)
}	//	end of function getCategoryCode

function getSelectCategoryCode2($table_name, $major_cd, $code, &$conn){
	$sql = "select minor_cd, code_nm from $table_name where major_cd='$major_cd' and status=1 order by code_nm asc";
	$result = mysql_query($sql,$conn);
	if($result){
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			$minor_cd = mysql_result($result,$i,0);
			$code_nm = mysql_result($result,$i,1);
				if($minor_cd==$code)	{ 
					$selectStatus="selected";
				}else{	
					$selectStatus="";
				}	//	end of if($minor_cd==$code)
			echo "<option value='".$minor_cd."' ".$selectStatus." >".((int)$minor_cd).". ".$code_nm;
		}	//	end of for
	}	//	end of if($result)
}	//	end of function getSelectCategoryCode2

function getSelectCategoryReturnCode_nm($table_name, $major_cd, $code, &$conn){
	$sql = "select code_nm from $table_name where major_cd='$major_cd' and minor_cd='$code'";
//	echo "sql : $sql <br>";
	if($result = mysql_query($sql,$conn)){
		$rows = mysql_fetch_array($result);
		mysql_free_result($result);
	}
	return $rows[code_nm];
}	//	end of function getSelectCategoryReturnCode_nm

function getSelectCategoryReturnObject($table_name, $major_cd, $code, &$conn){
	$sql = "select code_nm from $table_name where major_cd='$major_cd' and minor_cd='$code'";
	if($result = mysql_query($sql,$conn)){
		$rows = mysql_fetch_array($result);
		mysql_free_result($result);
	}
	return $rows;
}	//	end of function getSelectCategoryReturnObject



//################################################

function getURL(){ 
	$server=getenv("SERVER_NAME"); 
	$file=getenv("SCRIPT_NAME"); 
	$query=getenv("QUERY_STRING"); 
	$url="http:// $server$file"; 
	if($query) $url.="?$query"; 
	return $url; 
} 

function getURL2(){ 
	$server=getenv("SERVER_NAME"); 
	$file=$PHP_SELF;
	$query=getenv("QUERY_STRING"); 
	$url="http:// $server$file"; 
	if($query) $url.="?$query"; 
	return $url; 
} 



//################################################
// 이미지 사이즈 조정
	function getImageReSize($tag_width, $tag_height, $src_width, $src_heigh){
			
		// ==========================
		// 변수의 선언
		// --------------------------
			$return_size[0] = $tag_width;
			$return_size[1] = $tag_height;
			$tag_rate = doubleVal($tag_height) / $tag_width;
			$src_rate = doubleVal($src_heigh) / $src_width;
			$tmp_num=0;
		// ==========================

		// ==========================
		// 넓이를 기준으로 비율을 먼저 구한다.
		// --------------------------
		if($tag_rate<$src_rate){
			// 더 높이가 긴 그림이므로
			// 높이를 기준으로 작업
			$tmp_num = doubleVal($tag_height) / $src_heigh;
			$return_size[0] = intval($src_width * $tmp_num);
		
		}else{
			// 비율이 같거나 넓이가 더 긴그림
			// 넓이를 기준으로 작업
			$tmp_num = doubleVal($tag_width) / $src_width;
			$return_size[1] = intval($src_heigh * $tmp_num);
		}
		// ==========================

		return $return_size;
		// return_size[0] = width
		// return_size[1] = height
	}	// end of get_ImageSize()

	function getImageReSize2($tag_width, $tag_height, $src_width, $src_heigh){
			
		// ==========================
		// 변수의 선언
		// --------------------------
			$return_size[0] = $tag_width;
			$return_size[1] = $tag_height;
			$tag_rate = doubleVal($tag_height) / $tag_width;
			$src_rate = doubleVal($src_heigh) / $src_width;
			$tmp_num=0;
		// ==========================

		// ==========================
		// 넓이를 기준으로 비율을 먼저 구한다.
		// --------------------------
			// 더 높이가 긴 그림이므로
			// 높이를 기준으로 작업
			$tmp_num = doubleVal($tag_width) / $src_width;
			$return_size[1] = intval($src_heigh * $tmp_num);

		return $return_size;
		// return_size[0] = width
		// return_size[1] = height
	}	// end of get_ImageSize()
	
	function get_src_img_object($src_dir){
		$src;

			if(getFileExt($src_dir)=="gif"){
				$src = ImageCreateFromGIF($src_dir); 
			}else if((getFileExt($src_dir)=="jpg") || (getFileExt($src_dir)=="jpeg")){
				$src = ImageCreateFromJPEG($src_dir); 
			}else if((getFileExt($src_dir)=="png")){
				$src = ImageCreateFromPNG($src_dir); 
			}			  
		return $src;
	}


	function thumb_img($src,$width,$height,$save_file){
				$get_size = getImageReSize($width,$height,imagesx($src),imagesy($src));
				//$thumb = ImageCreate($get_size[0],$get_size[1]); 
				$thumb = imagecreatetruecolor($get_size[0],$get_size[1]);      

				ImageCopyResized($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				ImageJPEG($thumb,$save_file); 
				ImageDestroy($thumb); 
	}	//	end of function

	function thumb_img2($src,$width,$height,$save_file){
				$get_size = getImageReSize($width,$height,imagesx($src),imagesy($src));
				//$thumb = ImageCreate($get_size[0],$get_size[1]); 
				$thumb = imagecreatetruecolor($get_size[0],$get_size[1]);      

//				ImageCopyResized($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				imageCopyResampled($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				ImageJPEG($thumb,$save_file); 
				ImageDestroy($thumb); 
	}	//	end of function

	function thumb_img2_1($src,$width,$height,$save_file){
				$get_size = getImageReSize($width,$height,imagesx($src),imagesy($src));
				//$thumb = ImageCreate($get_size[0],$get_size[1]); 
				$thumb = imagecreatetruecolor($get_size[0],$get_size[1]);      

//				ImageCopyResized($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				imageCopyResampled($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
 				ImagePNG($thumb,$save_file);  
				ImageDestroy($thumb); 
	}	//	end of function

	function thumb_img3($src,$width,$height,$save_file){
				$get_size = getImageReSize2($width,$height,imagesx($src),imagesy($src));
				//$thumb = ImageCreate($get_size[0],$get_size[1]); 
				$thumb = imagecreatetruecolor($get_size[0],$get_size[1]);      

//				ImageCopyResized($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				imageCopyResampled($thumb,$src,0,0,0,0,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				ImageJPEG($thumb,$save_file); 
				ImageDestroy($thumb); 
	}	//	end of function

	function thumb_img_3by4($src,$width,$save_file){
//				$get_size = getImageReSize($width,$height,imagesx($src),imagesy($src));
				$get_size[0] = $width;
				$get_size[1] = (int)($width*((double)3/4));
				//$thumb = ImageCreate($get_size[0],$get_size[1]); 
				$thumb = imagecreatetruecolor($get_size[0],$get_size[1]);      

				$div_height = (int)((imagesy($src) - ((double)3/4)*(imagesx($src)))/2);
//				ImageCopyResized($thumb,$src,0,10,0,10,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				ImageCopyResized($thumb,$src,0,0,0,$div_height/1.5,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)-($div_height*2)); 
				ImageJPEG($thumb,$save_file); 
				ImageDestroy($thumb); 
	}	//	end of function

	function thumb_img_4by3($src,$width,$save_file){
//				$get_size = getImageReSize($width,$height,imagesx($src),imagesy($src));
				$get_size[0] = $width;
				$get_size[1] = (int)($width*((double)4/3));
				//$thumb = ImageCreate($get_size[0],$get_size[1]); 
				$thumb = imagecreatetruecolor($get_size[0],$get_size[1]);      

				$div_height = (int)((imagesy($src) - ((double)4/3)*(imagesx($src)))/2);
//				ImageCopyResized($thumb,$src,0,10,0,10,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)); 
				ImageCopyResized($thumb,$src,0,0,0,$div_height/1.5,$get_size[0],$get_size[1],ImageSX($src),ImageSY($src)-($div_height*2)); 
				ImageJPEG($thumb,$save_file); 
				ImageDestroy($thumb); 
	}	//	end of function
	// 글자길이 제한하여 출력 함수
		function cutString($pSOURCE, $nLENGTH) 
		{ 
		if (strlen($pSOURCE) > $nLENGTH) { 
		$i = 0; 
		$re = ""; 
		do { 
		$ch = substr($pSOURCE, $i, 1); 
		if (ord($ch) > 127) { 
		$ch2 = substr($pSOURCE, $i+1, 1); 
		$re .= $ch . $ch2; 
		$i+=2; 
		} else { 
		$re .= $ch; 
		$i++; 
		} 
		} while($i<$nLENGTH); 
		return $re.".."; 
		} else 
		return $pSOURCE; 
		} 

function date_gab($date1, $date2) { 
  return 
	  abs(
      mktime(0, 0, 0, 
        intval(substr($date2,4,2)), 
        intval(substr($date2,6,2)), 
        intval(substr($date2,0,4)) 
      ) - 
      mktime(0, 0, 0, 
        intval(substr($date1,4,2)), 
        intval(substr($date1,6,2)), 
        intval(substr($date1,0,4)) 
      ) 
    ) / 86400; // 하루 = 86400초 

/*
    abs( 
      mktime(0, 0, 0, 
        intval(substr($date2,4,2)), 
        intval(substr($date2,6,2)), 
        intval(substr($date2,0,4)) 
      ) - 
      mktime(0, 0, 0, 
        intval(substr($date1,4,2)), 
        intval(substr($date1,6,2)), 
        intval(substr($date1,0,4)) 
      ) 
    ) / 86400; // 하루 = 86400초 
*/
} 
function check_word($string){
	$string = eregi_replace("\&", "&amp;", $string); 
	$string = eregi_replace("\ⓒ", "&copy;", $string); 
	$string = eregi_replace("\"", "&quot;", $string); 
	$string = eregi_replace("\<", "&lt;", $string); 
	$string = eregi_replace("\>", "&gt;", $string); 

	return stripslashes($string);
}

	function sendmailer($type, $to, $to_name, $from, $from_name, $subject, $comment, $cc="", $bcc="") {
		$recipient = "$to_name <$to>";

		if($type==1) $comment = nl2br($comment);

		$headers = "From: $from_name <$from>\n";
		$headers .= "X-Sender: <$from>\n";
		$headers .= "X-Mailer: PHP ".phpversion()."\n";
		$headers .= "X-Priority: 1\n";
		$headers .= "Return-Path: <$from>\n";

		if(!$type) $headers .= "Content-Type: text/plain; ";
		else $headers .= "Content-Type: text/html; ";
		$headers .= "charset=euc-kr\n";

		if($cc)  $headers .= "cc: $cc\n";
		if($bcc)  $headers .= "bcc: $bcc";

		$comment = stripslashes($comment);
		$comment = str_replace("\n\r","\n", $comment);

		return mail($recipient , $subject , $comment , $headers);
	}	


//권한 반환 함수
function member_permission_chk($site, $mem_id, $vod_pid) {	//사이트구분, 회원아이디, vod pk값
	
	$pms1='E1'; //E1 : 비회원, E2:사용가능바니가 부족한 경우, S0:모바일전용정액제인경우, S1:사용가능바니가 있는경우, S2:24시간 이전 구매 고객, S3:무료정액회원, S4:정액

	switch($site) {
		case "st" : $member_tb="pb_member"; $order_tb="pb_order"; $f_name="price"; break;	//스파이스 티비일 경우 사용되는 멤버 테이블, 구매정보테이블, 가격 필드
		case "gt" : $member_tb="tbl_member"; $order_tb="tbl_order"; $f_name="point"; break; //걸스 티비일 경우 사용되는 멤버 테이블, 구매정보테이블, 가격 필드
	}
	
	if($mem_id != '') {
		
		//기본 회원정보
		$tmp_mem = "select * from $member_tb where member_id='$mem_id'";
		$que_mem = mysql_query($tmp_mem) or die($tmp_mem);
		if($que_mem) $row_mem = mysql_fetch_array($que_mem);

		//vod 가격 정보
		$tmp_price = "select $f_name from tbl_vod where pk_id='$vod_pid'";
		$que_price = mysql_query($tmp_price) or die($tmp_price);
		if($que_price) $row_price = mysql_fetch_array($que_price);
		
		$now = date("Y-m-d");
		$now_time = date("Y-m-d H:i:s");

		$tmp_check = "select order_date from $order_tb where member_id='$mem_id' and content_seq='$vod_pid' and content_type='3' order by order_date desc limit 1";
		$que_check = mysql_query($tmp_check) or die($tmp_check);
		$tot_check = mysql_num_rows($que_check);
		
		//$tot_check=0;
		if($tot_check > 0) {
			$row_check = mysql_fetch_array($que_check);
			if((strtotime("$now_time") - strtotime("$row_check[order_date]")) < 86400) $pms1 = "S2";

		}
		
		if($pms1 != "S2") {
			if(substr($row_mem[member_edate],0,10) >= $now) { //정액회원일 경우
				$pms1 = "S4";
				if($row_mem[member_address]=="m" || $row_mem[member_address]=="l") $pms1 = "S0";
			}else if(substr($row_mem[member_free_edate],0,10) >= $now) { //무료정액회원
				$pms1 = "S3";
				if($row_mem[member_address]=="m" || $row_mem[member_address]=="l") $pms1 = "S0";
			}else {
				$point_q = 0;
				$point_q = ($row_mem[member_bany] + $row_mem[member_free]) - $row_price[0];
				if($point_q < 0) {	//무료,유료 바니가 컨텐츠 가격보다 작은경우
					$pms1 = "E2";
				}else {	//바니가 컨텐츠 가격보다 많거나 같은경우
					$pms1 = "S1";
				}
			}
		}

		if($row_mem[member_group] < 9) $pms1="S4";	//관리자 권한일때
	}

	return $pms1;
}


//권한 반환 함수
function member_permission_chk2($site, $mem_id, $vod_pid) {	//사이트구분, 회원아이디, vod pk값
	
	$pms1='E1'; //E1 : 비회원, E2:사용가능바니가 부족한 경우, S0:모바일전용정액제인경우, S1:사용가능바니가 있는경우, S2:24시간 이전 구매 고객, S3:무료정액회원, S4:정액

	switch($site) {
		case "st" : $member_tb="pb_member"; $order_tb="pb_order"; $f_name="price"; break;	//스파이스 티비일 경우 사용되는 멤버 테이블, 구매정보테이블, 가격 필드
		case "gt" : $member_tb="tbl_member"; $order_tb="tbl_order"; $f_name="point"; break; //걸스 티비일 경우 사용되는 멤버 테이블, 구매정보테이블, 가격 필드
	}
	
	if($mem_id != '') {
		
		//기본 회원정보
		$tmp_mem = "select * from $member_tb where member_id='$mem_id'";
		$que_mem = mysql_query($tmp_mem) or die($tmp_mem);
		if($que_mem) $row_mem = mysql_fetch_array($que_mem);

		//vod 가격 정보
		$tmp_price = "select $f_name,opt_value from tbl_vod where pk_id='$vod_pid'";
		$que_price = mysql_query($tmp_price) or die($tmp_price);
		if($que_price) $row_price = mysql_fetch_array($que_price);
		
		if($row_price[1] == "NEW") $row_price[0] = "1000"; else $row_price[0] = "500";

		$now = date("Y-m-d");
		$now_time = date("Y-m-d H:i:s");

		$tmp_check = "select order_date from $order_tb where member_id='$mem_id' and content_seq='$vod_pid' and content_type='3' order by order_date desc limit 1";
		$que_check = mysql_query($tmp_check) or die($tmp_check);
		$tot_check = mysql_num_rows($que_check);
		
		//$tot_check=0;
		if($tot_check > 0) {
			$row_check = mysql_fetch_array($que_check);
			if((strtotime("$now_time") - strtotime("$row_check[order_date]")) < 86400) $pms1 = "S2";

		}
		
		if($pms1 != "S2") {
			if(substr($row_mem[member_edate],0,10) >= $now) { //정액회원일 경우
				$pms1 = "S4";
				if($row_mem[member_address]=="m" || $row_mem[member_address]=="l") $pms1 = "S0";
			}else if(substr($row_mem[member_free_edate],0,10) >= $now) { //무료정액회원
				$pms1 = "S3";
				if($row_mem[member_address]=="m" || $row_mem[member_address]=="l") $pms1 = "S0";
			}else {
				$point_q = 0;
				$point_q = ($row_mem[member_bany] + $row_mem[member_free]) - $row_price[0];
				if($point_q < 0) {	//무료,유료 바니가 컨텐츠 가격보다 작은경우
					$pms1 = "E2";
				}else {	//바니가 컨텐츠 가격보다 많거나 같은경우
					$pms1 = "S1";
				}
			}
		}

		if($row_mem[member_group] < 9) $pms1="S4";	//관리자 권한일때
	}

	return $pms1;
}
?>