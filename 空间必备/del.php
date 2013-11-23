<head>
<title>夕虚强力删除</title>
</head>
﻿<?php
header("content-Type: text/html; charset=utf-8");
//配置开始
$path=".";//在些设置所删除的目录.为当前目录 如：删除path目录，引号里请添path;
$guolv="del.php,zip.zip";//设置需要过滤的文件或文件夹用英文状态下,号分隔
//配置结束
if($_GET['action']=="del"){
	$file= array_values_recursive(recurdir($path,$guolv));
	foreach($file as $k => $v){
		remove_directory($v);
	}
}else{
	echo "您的配置如下<br>
	要删除的目录为：
	";
	if($path==".")echo "当前目录";else echo $path;
	echo "<br>您要过滤的文件或文件夹有：".$guolv."<br>
	如果确认过滤请<a href='?action=del'>点击此处开始删除相应的目录及目录下的所有文件</a>，如果配置不正确请到文件中修改
	";
}


//删除目录及文件
function remove_directory($dir) {
  foreach(glob($dir) as $fn) { 
  		echo " removing $fn<br>\n";
		if (!is_writable($fn))@chmod($fn, 0777);
		if(is_dir($fn)){@rmdir($fn);}else{@unlink($fn);}
   } 
}
//扫描目录
function recurdir($pathname,$guolv='del.php')
{
	$result=array();$temp=array();
	//检查目录是否有效和可读
	if(!is_dir($pathname) || !is_readable($pathname))
	return null;
	//得到目录下的所有文件夹
	$allfiles=scandir($pathname);
	foreach($allfiles as $key => $filename)
	{
		//如果是“.”或者“..”的话则略过
		if(in_array($filename,array('.','..')))continue;
		if(count($guolv)>0){$lv=explode(",",$guolv);if(in_array($filename,$lv))continue;}
		
		//得到文件完整名字
		$fullname =$pathname . "/" .$filename;
		//如果该文件是目录的话，递归调用recurdir
		$temp[]=$fullname;
		if(is_dir($fullname)){
			$nowpath=explode("/",$fullname);
			if(count($guolv)>0){$lv=explode(",",$guolv);if(in_array($nowpath[count($nowpath)-1],$lv))continue;}
			$result[$filename] = recurdir($fullname);}
	}	
	//最后把临时数组中的内容添加到结果数组，确保目录在前，文件在后
	foreach($temp as $f){
		$result[]=$f;
	}
	return $result;
}
//获取所有文件
function array_values_recursive($ary)
{
   $lst = array();
   foreach( array_keys($ary) as $k ){
	 $v = $ary[$k];
	 if (is_array($v)) {$lst = array_merge( $lst, array_values_recursive($v));}else{$lst[] = $v;}
   }
   return $lst;
}
?> 
