<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/*
  made by jason.zhang
*/
if(!defined('IN_CMSMENG')) {
	exit('this is wrong page,please back to homepage');
}

$routeid='';$alias='';$ifalias='';$file='';

$routeid = @htmlentities($_GET['routeid']);
$alias = @htmlentities($_GET['alias']);
$ifalias = @htmlentities($_GET['ifalias']);
$file = @htmlentities($_GET['file']);
$detailid = @htmlentities($_GET['detailid']);

if($test=='y'){
echo 'echo routeid='.$routeid.' alias='.$alias.' ifalias='.$ifalias.' file='.$file.' detailid='.$detailid;
}

require_once 'component/cmsmeng_html/func_init.php';

if($file=='')  require_once 'component/cmsmeng_html/file_index.php';
else {
  //if ifalias =y,then judge file var by htaccess file...
  if($ifalias=='y'){
		$filearr = filealias($alias);
		$routeid= $filearr[0]; 
		$detailid= $filearr[2]; 
		require_once $filearr[1];
  
  }
  
  else require_once 'component/cmsmeng_html/file_'.$file.'.php';
}


 
?>


<?php
function filealias($alias){
global $andlangbh;global $noid;global $filearr;
$sql = "SELECT pid,type from ".TABLE_ALIAS."  where  name='$alias' $andlangbh  order by id limit 1";	
		//echo $sqllayout;exit; 
		  if(getnum($sql)>0){ 
			$row=getrow($sql);
			$type=$row['type'];
			$pidname=$row['pid'];
			if($type=='page'){
				$sql2 = "SELECT id from ".TABLE_MENU."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				$row2=getrow($sql2);
				$routeid= $row2['id'];	
				$reqfile =  'component/cmsmeng_html/file_page.php';	
				$detailid='';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}			
			else if($type=='cate'){
				$sql2 = "SELECT id from ".TABLE_CATE."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				$row2=getrow($sql2);
				$routeid= $row2['id'];	
				$detailid='';	
				$reqfile =  'component/cmsmeng_html/file_category.php';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}
			else if($type=='detail'){global $row_detail;
				$sql2 = "SELECT * from ".TABLE_NODE."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				$row_detail=getrow($sql2);//$row_detail for system/syst_content_article_detail.php
				$detailid= $row_detail['id'];	
				$pid= $row_detail['pid'];
				$title_detail= $row_detail['title'];	
				$sta_noaccess= $row_detail['sta_noaccess'];
				if($sta_noaccess=='y') {echo $noaccess;exit;}
				//----------------
				$sql2 = "SELECT id from ".TABLE_CATE."  where  pidname='$pid' $andlangbh  order by id limit 1";
				$row2=getrow($sql2);
				$routeid= $row2['id'];	
				//echo '<br>'.$sql2.'<br>';
				
				//-----------------
				$reqfile =  'component/cmsmeng_html/file_category.php';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}
			
			
			
		  }
		  else{echo $noid;exit;}
  



}//end func

?>
