<?php
$mysql_server_name="localhost"; //数据库服务器名称
$mysql_username="data"; // 连接数据库用户名
$mysql_password="password"; // 连接数据库密码
$mysql_database="data"; // 数据库的名字 // in index.php $userdir='cm_testcopy';
   
$conn = mysql_connect($mysql_server_name, $mysql_username,$mysql_password,'utf-8');
 if (!$conn) {
    die('sorry,localhost,usename or ps maybe is wrong....Could not connect:<br> pls visit later');
		}  
		// mysql_error()
mysql_select_db($mysql_database, $conn) or die ('sorry,database name maybe is wrong:<br> pls visit later');
//mysql_select_db($mysql_database, $conn) or die ('sorry,database name maybe is wrong:' . mysql_error().'');
	   
mysql_query("SET NAMES utf8");


 			
	//-----------------
function query($sql){  
$result = mysql_query($sql);
 
	return $result;
}
function fetch_array($query, $result_type = MYSQL_ASSOC) { 
		return mysql_fetch_array($query, $result_type);
	}
function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

    // 释放资源
   // mysql_free_result($result);
    // 关闭连接  mysql_close($conn);  


	


//-----------------
function getrow($sql) {
    $result = query($sql);
    $rowfirst = fetch_array($result);mysql_free_result($result);
    if(!$rowfirst)
       $rowfirst='no';
    return $rowfirst;
}

function getall($sql) {
    $result = query($sql); 
    $row = fetch_array($result);mysql_free_result($result);
    if($row){
       $result = query($sql);
       while($row = fetch_array($result)){
           $rowlist[] = $row;
       }
    }
    else
    $rowlist='no';
    return $rowlist;
}
function getnum($sql) {
    $result = query($sql);
    $rowlist = num_rows($result);mysql_free_result($result);
    return $rowlist;
}
 function get_numrows($sql) {
    $result = query($sql);
    $rowlist = num_rows($result);mysql_free_result($result);
    return $rowlist;
}
 
function iquery($sql) {
    query($sql);
}
function iquery_if($sql) {
    iquery($sql);
   $abc=mysql_affected_rows();
   if($abc<>1){ alert('sorry,insert error.');exit;}//insert success is 1 else is -1.use avoid dead circle when in block and flashimg(lunh) control.

}
function getclose() {
    GLOBAL  $conn;  mysql_close($conn); 
}

  // 释放资源
   // mysql_free_result($result);
    // 关闭连接
   // mysql_close($conn); 

 


?>
