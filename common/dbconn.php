<?
// DB ���� �۾��� �ϴ� ���Դϴ�.

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
		$status=mysql_select_db($l_DbName,$conn) or die("�����ͺ��̽� ���ٽ���");
		if(!$status){			
			mysql_close($conn);
			exit;
					}
		return $status;
	}	
*/
//#######################################################################################
	Function addSingleQuotation($status,$s_word){
		// $status�� ( 1 : ����, 2 : �����϶�)   ..........�����϶�... �̶��� �۵��� ��
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
//			echo "���ڿ��� �� ������?";
			for($i=$countTempData-1;$i<$divNum;$i++){
				$tempData[$i]="";
			} // end of for
		}elseif($divNum<$countTempData){
//			echo "���ڿ��� �� ������?";
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
					case "1"	: //������ �������϶�;
							$returnData[0] = $returnData[0].", ".$fieldName."=".$fieldValue;
						break;

					case "2"	: //���ǵ�����(AND);
							makeWhereString($fieldType1, $returnData[1], $fieldName, $fieldValue);
						break;

					case "3"	: //���ǵ�����(OR);
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
	Function collectParamsCondition($s_arrayObject){		//	���� ���Ǻκи� ����� ���� �κ��Դϴ� (Select count, Delete �϶� ���)
		
			for($i=0;$i<count($s_arrayObject);$i++){
			
				$tmpData=tokenizer($s_arrayObject[$i],",",4);
						
				$fieldType1 = $tmpData[0];
				$fieldType2 = $tmpData[1];
				$fieldName = $tmpData[2];
				$fieldValue = addSingleQuotation($fieldType2,$tmpData[3]);

				switch($fieldType1){
					case "2"	: //���ǵ�����(AND);
							makeWhereString($fieldType1, $returnData, $fieldName, $fieldValue);
						break;

					case "3"	: //���ǵ�����(OR);
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
//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
			$preSQL=collectParamsInsert($s_arrayObject);
			$SQL="insert into ".$s_table."(".$preSQL[0].") values(".$preSQL[1].")";
//			echo "DB : ".$s_strcon."<br>";
//			echo "SQL : ".$SQL."<br>";	
			$count=mysql_db_query($s_strcon, $SQL, $conn);
//		}
		if(!$count){		echo "������ �Է½� ������ �����ϴ�";	exit;		}
		return $count;
	}	//	end of Function Run_Insert

//#######################################################################################
	Function Run_Update($s_strcon,$s_table, $s_arrayObject, &$conn){
//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
			$preSQL=collectParamsUpdate($s_arrayObject);
			$SQL="update ".$s_table." set ".$preSQL[0]." ".$preSQL[1];
//			echo " Update SQL : ".$SQL."<br>";
			$count=mysql_db_query($s_strcon,$SQL,$conn);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$count){		echo "������ ������ ������ �����ϴ�";	exit;		}
		return $count;			
	}	//	end of Function Run_Update

//#######################################################################################
	Function Run_Delete($s_strcon,$s_table, $s_arrayObject, &$conn){

//		$count=0;
//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
			$preSQL=collectParamsCondition($s_arrayObject);
			$SQL="delete from ".$s_table." ".$preSQL;
			$count=mysql_db_query($s_strcon, $SQL, $conn);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$count){		echo "������ ������ ������ �����ϴ�";	exit;		}
		return $count;			
	}	//	end of Function Run_Update*/


//#######################################################################################
	Function getTotalCount($s_strcon,$s_table, $s_arrayObject, &$conn){

//		$count=0;

//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
			$preSQL=collectParamsCondition($s_arrayObject);
//			echo "preSQL : ".$preSQL."<br>";
			$SQL="select count(*) from ".$s_table." ".$preSQL;
			$result=mysql_db_query($s_strcon, $SQL, $conn);
			$returnData=intval(mysql_result($result,0,0));
			mysql_free_result($result);
//			echo " SQL : ".$SQL."<br>";
//		}
		if(!$result){		echo "ī���ý� ������ �����ϴ�";	exit;		}

		return $returnData;			// ���ϰ��� ������
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
//##  mysql_db_query�� �ƴ� mysql_query�� ����ϴ� �Լ��Դϴ�.##
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
//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
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
//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
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
//		if(selectDB($s_strcon)==1){	 // DB ���ӿ� ������ �ϸ�
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



	//	Connection �� ������... ����?	

//	$conn=connect($ȣ��Ʈ��,$�Ƶ��,$��й�ȣ);
//		Function RunSQLReturnLimitResult($s_strcon, $m_MainSQL, &$m_DivList, $m_NowPage){

/*		mysql_select_db("test");
		$divList=5;
		$nowPage=1;
		$SQL="select * from test where name='���¹�' order by pk_num asc";
		$result = RunSQLReturnLimitResult("test", $SQL, $divList, $nowPage);
		$count = mysql_num_rows($result);
		for($i=0;$i<$count;$i++){
			echo mysql_result($result,$i,0).", ";
			echo mysql_result($result,$i,1).", ";
			echo mysql_result($result,$i,2).", ";
			echo mysql_result($result,$i,3)."<br>";
		}

//		$test1[]="3,2,name,���¹�";
//		echo getTotalCount("test","test", $test1,$conn);

		//###########################################
		//## Insert �ÿ� ����Ǵ� ���Դϴ�.							    ##
		//###########################################
		/*�迭����
			2��° �ʵ����� - ( 1 : ���� ������, 2 : ���ڿ� ������ ) 
			3��° �ʵ��̸�
			4��° �ʵ尪
		*/


		//## Insert Test
/*		$test[]="1, pk_id, 7";
		$test[]="2, name, ���¹�1";
		$test[]="1, age, 25 ";
		$test[]="2,  other,";
		echo Run_Insert("test","test",$test,$conn);
		echo Run_Insert2("test",$test,$conn);

		//	*/



		//###########################################
		//## UpDate, Delete �ÿ� ����Ǵ� ���Դϴ�.                ##
		//###########################################

		/*�迭����
			1��° �迭��� - ( 1 : ���� ������, 2 : AND ���� ��ȸ, 3 : ��ȸ OR ���� ��ȸ ) 
			2��° �ʵ����� - ( 1 : ���� ������, 2 : ���ڿ� ������ ) 
			3��° �ʵ��̸�
			4��° �ʵ尪
		*/
	
		/*
		//## Update Test
		$test[]="1,2,name,���¹�";
		$test[]="1,1,age,25";
		$test[]="1,2,other,��Ÿ����2�Դϴ�.. Update �����Դϴ�.";
//		$test[]="3,1,pk_num,2";
//		$test[]="2,1,age,25";				//	AND �����϶�
//		$test[]="3,2,name,���¹�1";		//	OR �����϶�
		echo Run_Update("test","test",$test,$conn);
		echo Run_Update2("test",$test,$conn);
		//	*/


		/*
		//## Delete Test
		$test[]="3,1,pk_num,11";		//	2 : AND �����϶�,	 3 : OR �����϶�
		echo Run_Delete("test","test",$test,$conn);		
		echo Run_Delete2("test",$test,$conn);		
		//	*/

//	disConnect($conn);

	//	������ �ϸ� ���� ���� �մϴ�.

//#######################################################################################
//#######################################################################################
//#######################################################################################
?>
