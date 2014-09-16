<?
// DB 관련 작업을 하는 곳입니다.

   $conn=mysql_connect($db_server, $db_user, $db_passwd) or  die(mysql_error()); 
   mysql_select_db($db_name,$conn);
   mysql_query('set names euckr'); 

//#######################################################################################
//Function connect($conn_host = "localhost", $conn_user = "root", $conn_pw = ""){
//		$conn=mysql_connect($conn_host,$conn_user,$conn_pw) OR die("Connect Host Fail");
//		if(!$conn){			exit;		}
//		return $conn;
//	}	//	end of Function connect()
//
//#######################################################################################

	Function disConnect(&$conn){
		return mysql_close($conn);
	}	//	end of Function 

//#######################################################################################
/*	Function selectDB($l_DbName,&$conn){
		$status=mysql_select_db($l_DbName,$conn) or die("데이터베이스 접근실패");
		if(!$status){			
			mysql_close($conn);
			exit;
					}
		return $status;
	}	
*/
//#######################################################################################
	Function addSingleQuotation($status,$s_word){
		// $status가 ( 1 : 숫자, 2 : 문자일때)   ..........문자일때... 이때만 작동을 함
		$returnData = $s_word;
		if($status=="2") $returnData = "'".Addslashes($s_word)."'";
		return $returnData;
	}	//	end of Function addSingleQuotation($status,$s_word)

//#######################################################################################
	Function tokenizer($getString,$div_char,$divNum){
		for($i=0;$i<$divNum-1;$i++){
			$count = strpos($getString,$div_char);
			$returnData[]=substr($getString,0,$count);
			$len=strlen($returnData[$i]);
			$getString=substr($getString,$count+1,strlen($getString)-$len);
		}	//	end of for
			$returnData[]=$getString;

		return $returnData;

	}	//	end of Function tokenizer

//#######################################################################################
	Function tokenizer_old($getString,$div_char,$divNum){
		$tempData = explode($div_char,$getString);
		$countTempData=count($tempData);

		for($h=0;$h<$countTempData;$h++)	$tempData[$h]=$tempData[$h];

		if($divNum>$countTempData){
//			echo "문자열이 더 적을때?";
			for($i=$countTempData-1;$i<$divNum;$i++){
				$tempData[$i]="";
			} // end of for
		}elseif($divNum<$countTempData){
//			echo "문자열이 더 많을때?";
			for($i=$divNum;$i<$countTempData;$i++){
				$tempData[$divNum-1].=", ".$tempData[$i];
			} // end of for
		}


		return $tempData;
	}	//	end of Function tokenizer

//#######################################################################################
	Function makeWhereString($status, &$oldData, $addDataName, $addDataValue){
		$word="AND";

		if($status=="3"){
			$word="OR";
		}	//	end of if($status=="3")

		if(strlen($oldData)!=0){
			$oldData = $oldData." ".$word." ".$addDataName." = ".$addDataValue;							
		}else{
			$oldData = $addDataName." = ".$addDataValue;
		}

	}	//	end of Function makeWhereString

//#######################################################################################
	Function collectParamsInsert($s_arrayObject){

			for($i=0;$i<count($s_arrayObject);$i++){

				$tmpData=tokenizer($s_arrayObject[$i],",",3);
						
				$fieldType = $tmpData[0];
				$fieldName = $tmpData[1];
				$fieldValue = addSingleQuotation($fieldType,$tmpData[2]);

				$fieldNames= $fieldNames.", ".$fieldName;
				$fieldValues = $fieldValues.", ".$fieldValue;
							
			}	//	end of for

			$returnData[0]=substr($fieldNames,1,strlen($fieldNames)-1);
			$returnData[1]=substr($fieldValues,1,strlen($fieldValues)-1);

			return $returnData;
	}	//	end of Function collectParams

//#######################################################################################
	Function collectParamsUpdate($s_arrayObject){
		
			for($i=0;$i<count($s_arrayObject);$i++){
			
				$tmpData=tokenizer($s_arrayObject[$i],",",4);
						
				$fieldType1 = $tmpData[0];
				$fieldType2 = $tmpData[1];
				$fieldName = $tmpData[2];
				$fieldValue = addSingleQuotation($fieldType2, $tmpData[3]);

				switch($fieldType1){
					case "1"	: //변경할 데이터일때;
							$returnData[0] = $returnData[0].", ".$fieldName."=".$fieldValue;
						break;

					case "2"	: //조건데이터(AND);
							makeWhereString($fieldType1, $returnData[1], $fieldName, $fieldValue);
						break;

					case "3"	: //조건데이터(OR);
							makeWhereString($fieldType1, $returnData[1], $fieldName, $fieldValue);
						break;
				}	//	end of switch($fieldType1)
							
			}	//	end of for

		if(strlen($returnData[1])>0){
			$returnData[1] = "where ".$returnData[1];
		}

		$returnData[0]=substr($returnData[0],1,strlen($returnData[0])-1);
		$returnData[1]=$returnData[1];

			return $returnData;
	}	//	end of Function collectParams		

//#######################################################################################
	Function collectParamsCondition($s_arrayObject){		//	뒤의 조건부분만 만들어 내는 부분입니다 (Select count, Delete 일때 사용)
		
			for($i=0;$i<count($s_arrayObject);$i++){
			
				$tmpData=tokenizer($s_arrayObject[$i],",",4);
						
				$fieldType1 = $tmpData[0];
				$fieldType2 = $tmpData[1];
				$fieldName = $tmpData[2];
				$fieldValue = addSingleQuotation($fieldType2,$tmpData[3]);

				switch($fieldType1){
					case "2"	: //조건데이터(AND);
							makeWhereString($fieldType1, $returnData, $fieldName, $fieldValue);
						break;

					case "3"	: //조건데이터(OR);
							makeWhereString($fieldType1, $returnData, $fieldName, $fieldValue);
						break;
				}	//	end of switch($fieldType1)
							
			}	//	end of for

		if(strlen($returnData)>0){
			$returnData = "where ".$returnData;
		}

		$returnData=$returnData;

			return $returnData;
	}	//	end of Function collectParams


//#######################################################################################
	Function Run_Insert($s_strcon,$s_table, $s_arrayObject, &$conn){
//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsInsert($s_arrayObject);
			$SQL="insert into ".$s_table."(".$preSQL[0].") values(".$preSQL[1].")";
//			echo "DB : ".$s_strcon."<br>";
//			echo "SQL : ".$SQL."<br>";	
			$count=mysql_db_query($s_strcon, $SQL, $conn);
//		}
		if(!$count){		echo "데이터 입력시 에러가 났습니다";	exit;		}
		return $count;
	}	//	end of Function Run_Insert

//#######################################################################################
	Function Run_Update($s_strcon,$s_table, $s_arrayObject, &$conn){
//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsUpdate($s_arrayObject);
			$SQL="update ".$s_table." set ".$preSQL[0]." ".$preSQL[1];
//			echo " Update SQL : ".$SQL."<br>";
			$count=mysql_db_query($s_strcon,$SQL,$conn);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$count){		echo "데이터 수정시 에러가 났습니다";	exit;		}
		return $count;			
	}	//	end of Function Run_Update

//#######################################################################################
	Function Run_Delete($s_strcon,$s_table, $s_arrayObject, &$conn){

//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsCondition($s_arrayObject);
			$SQL="delete from ".$s_table." ".$preSQL;
			$count=mysql_db_query($s_strcon, $SQL, $conn);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$count){		echo "데이터 삭제시 에러가 났습니다";	exit;		}
		return $count;			
	}	//	end of Function Run_Update*/


//#######################################################################################
	Function getTotalCount($s_strcon,$s_table, $s_arrayObject, &$conn){

//		$count=0;

//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsCondition($s_arrayObject);
//			echo "preSQL : ".$preSQL."<br>";
			$SQL="select count(*) from ".$s_table." ".$preSQL;
			$result=mysql_db_query($s_strcon, $SQL, $conn);
			$returnData=intval(mysql_result($result,0,0));
			mysql_free_result($result);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$result){		echo "카운팅시 에러가 났습니다";	exit;		}

		return $returnData;			// 리턴값은 정수임
	}	//	end of Function Run_Update*/

//#######################################################################################

	Function RunSQLReturnLimitResult($s_strcon, $m_MainSQL, &$m_DivList, $m_NowPage, &$conn){
		
		$startList = $m_DivList * ($m_NowPage - 1);
		$lastList = $StartList + $m_DivList;

//		echo "Start : ".$m_DivList." , Last : ".$lastList."<br>";

		$addSQL = "limit ".$startList.", ".$lastList;
		$m_MainSQL = $m_MainSQL." ".$addSQL;

//		echo " m_MainSQL : ".$m_MainSQL."<br>";
//		echo "s_strcon ".$s_strcon."<br>";
//		echo "conn ".$conn."<br>";
//		echo "test_db".$test_db."<br>";
		$result = mysql_db_query($s_strcon,$m_MainSQL,$conn);
		if(!$result){		echo "RunSQLReturnLimitResult ERROR";	exit;		}

		return $result;
	}	//	end of Function RunSQLReturnLimitResult
//#######################################################################################





//#######################################################################################
//##  mysql_db_query가 아닌 mysql_query를 사용하는 함수입니다.##
//#######################################################################################

	Function RunSQLReturnLimitResult2($m_MainSQL, &$m_DivList, $m_NowPage, &$conn){
		
		$startList = $m_DivList * ($m_NowPage - 1);
		$lastList = $StartList + $m_DivList;

//		echo "Start : ".$m_DivList." , Last : ".$lastList."<br>";

		$addSQL = "limit ".$startList.", ".$lastList;
		$m_MainSQL = $m_MainSQL." ".$addSQL;

//		echo " m_MainSQL : ".$m_MainSQL."<br>";
//		echo "s_strcon ".$s_strcon."<br>";
//		echo "conn ".$conn."<br>";
//		echo "test_db".$test_db."<br>";
		$result = mysql_query($m_MainSQL,$conn);
		if(!$result){		echo "error - $m_MainSQL";	exit;		}

		return $result;
	}	//	end of Function RunSQLReturnLimitResult


//#######################################################################################
	Function Run_Insert2($s_table, $s_arrayObject, &$conn){
//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsInsert($s_arrayObject);
			$SQL="insert into ".$s_table."(".$preSQL[0].") values(".$preSQL[1].")";
//			echo "DB : ".$s_strcon."<br>";
//			echo "SQL : ".$SQL."<br>";	
			$count=mysql_query($SQL, $conn);
//		}
		if(!$count){		echo "error - $SQL";	exit;		}
		return $count;
	}	//	end of Function Run_Insert

//#######################################################################################
	Function Run_Update2($s_table, $s_arrayObject, &$conn){
//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsUpdate($s_arrayObject);
			$SQL="update ".$s_table." set ".$preSQL[0]." ".$preSQL[1];
//			echo " Update SQL : ".$SQL."<br>";
			$count=mysql_query($SQL,$conn);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$count){		echo "error - $SQL";	exit;		}
		return $count;			
	}	//	end of Function Run_Update

//#######################################################################################
	Function Run_Delete2($s_table, $s_arrayObject, &$conn){

//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB 접속에 성공을 하면
			$preSQL=collectParamsCondition($s_arrayObject);
			$SQL="delete from ".$s_table." ".$preSQL;
			$count=mysql_query($SQL, $conn);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$count){		echo "error - $SQL";	exit;		}
		return $count;			
	}	//	end of Function Run_Update*/


//#######################################################################################
	Function getObjectSQL($s_strcon,$sql, &$conn){
		$result = mysql_db_query($s_strcon,$sql, $conn) or die($sql);
		$object  = mysql_fetch_array($result);
		mysql_free_result($result);
		return $object;
	}	//	end of Function tokenizer

	Function getObjectSQL2($sql, &$conn){
		$result = mysql_query($sql, $conn) or die($sql);
		$object  = mysql_fetch_array($result);
		mysql_free_result($result);
		return $object;
	}	//	end of Function tokenizer

	Function getOneDataSQL($s_strcon,$sql, &$conn){
		$result = mysql_db_query($s_strcon,$sql, $conn) or die($sql);
		$row = mysql_fetch_row($result);
		mysql_free_result($result);
		return $row[0];
	}	//	end of Function tokenizer

	Function getOneDataSQL2($sql, &$conn){
		$result = mysql_query($sql, $conn) ;//or die($sql);
		$row = mysql_fetch_row($result);
		mysql_free_result($result);
		return $row[0];
	}	//	end of Function tokenizer
//#######################################################################################

//#######################################################################################
//#######################################################################################
//#######################################################################################



	//	Connection 을 하지요... 그쵸?	

//	$conn=connect($호스트명,$아디디,$비밀번호);
//		Function RunSQLReturnLimitResult($s_strcon, $m_MainSQL, &$m_DivList, $m_NowPage){

/*		mysql_select_db("test");
		$divList=5;
		$nowPage=1;
		$SQL="select * from test where name='조승뭐' order by pk_num asc";
		$result = RunSQLReturnLimitResult("test", $SQL, $divList, $nowPage);
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			echo mysql_result($result,$i,0).", ";
			echo mysql_result($result,$i,1).", ";
			echo mysql_result($result,$i,2).", ";
			echo mysql_result($result,$i,3)."<br>";
		}

//		$test1[]="3,2,name,조승뭐";
//		echo getTotalCount("test","test", $test1,$conn);

		//###########################################
		//## Insert 시에 적용되는 것입니다.							    ##
		//###########################################
		/*배열형태
			2번째 필드형식 - ( 1 : 정수 데이터, 2 : 문자열 데이터 ) 
			3번째 필드이름
			4번째 필드값
		*/


		//## Insert Test
/*		$test[]="1, pk_id, 7";
		$test[]="2, name, 조승뭐1";
		$test[]="1, age, 25 ";
		$test[]="2,  other,";
		echo Run_Insert("test","test",$test,$conn);
		echo Run_Insert2("test",$test,$conn);

		//	*/



		//###########################################
		//## UpDate, Delete 시에 적용되는 것입니다.                ##
		//###########################################

		/*배열형태
			1번째 배열모드 - ( 1 : 변경 데이터, 2 : AND 조건 조회, 3 : 조회 OR 조건 조회 ) 
			2번째 필드형식 - ( 1 : 정수 데이터, 2 : 문자열 데이터 ) 
			3번째 필드이름
			4번째 필드값
		*/
	
		/*
		//## Update Test
		$test[]="1,2,name,조승뭐";
		$test[]="1,1,age,25";
		$test[]="1,2,other,기타사항2입니다.. Update 시험입니다.";
//		$test[]="3,1,pk_num,2";
//		$test[]="2,1,age,25";				//	AND 조건일때
//		$test[]="3,2,name,조승뭐1";		//	OR 조건일때
		echo Run_Update("test","test",$test,$conn);
		echo Run_Update2("test",$test,$conn);
		//	*/


		/*
		//## Delete Test
		$test[]="3,1,pk_num,11";		//	2 : AND 조건일때,	 3 : OR 조건일때
		echo Run_Delete("test","test",$test,$conn);		
		echo Run_Delete2("test",$test,$conn);		
		//	*/

//	disConnect($conn);

	//	시작을 하면 끝을 봐야 합니다.

//#######################################################################################
//#######################################################################################
//#######################################################################################
?>
