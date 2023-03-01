<?php
 
// Set up cross-domain headers
header('Access-Control-Allow-Origin:*');

header('Access-Control-Allow-Methods:PUT,POST,GET,DELETE,OPTIONS');

header('Access-Control-Allow-Headers:x-requested-with,content-type');

header('Content-Type:application/json; charset=utf-8');

$file = isset($_FILES['file_data']) ? $_FILES['file_data']:null; //分段的文件

$name = isset($_POST['file_name']) ? $_POST['file_name']:null; //要保存的文件名

$total = isset($_POST['file_total']) ? $_POST['file_total']:0; //总片数

$index = isset($_POST['file_index']) ? $_POST['file_index']:0; //当前片数

$md5   = isset($_POST['file_md5']) ? $_POST['file_md5'] : 0; //文件的md5值

$size  = isset($_POST['file_size']) ?  $_POST['file_size'] : null; //文件大小

$path  = isset($_GET['p']) ?  str_replace('~', ' ',$_GET['p']) : null; //文件大小

//echo 'Total number of files:'.$total.'Current number of files:'.$index;

// Output json information
function jsonMsg($status,$message,$url=''){
   $arr['status'] = $status;
   $arr['message'] = $message;
   $arr['url'] = $url;
   echo json_encode($arr);
   die();
}

if(!$file || !$name){
	jsonMsg(0,'No files');
}

// Simply determine the file type

$info = pathinfo($name);

// Obtain the file suffix
$ext = isset($info['extension'])?$info['extension']:'';


// In actual use, md5 is used to name the file, which can reduce conflicts

$file_name = $name;

$newfile = $path."/".$file_name;

// The address to which the file is accessible
$url = $path."/".$file_name;

/** 判断是否重复上传 **/
// Clears the file status
clearstatcache($newfile);
// If the file size is the same, it has been uploaded
if(is_file($newfile) && ($size == filesize($newfile))){
   jsonMsg(3,'Already uploaded',$url);          
}
/** Determine if the upload is repeated  **/

// Here is the point to determine whether there is an uploaded file stream
if ($file['error'] == 0) {
    // If the file does not exist, it is created
    if (!file_exists($newfile)) {
        if (!move_uploaded_file($file['tmp_name'], $newfile)) {
            jsonMsg(0,'The file could not be moved');
        }
        // Equal number of pieces equals completion
        if($index == $total ){  
          jsonMsg(2,'Upload complete',$url);
        }        
        jsonMsg(1,'Uploading in progress');
    }     
    // If the current number of tiles is less than or equal to the total number of tiles, continue adding after the file
    if($index <= $total){
        $content = file_get_contents($file['tmp_name']);
        if (!file_put_contents($newfile, $content, FILE_APPEND)) {
          jsonMsg(0,'Unable to write to file');
        }
        // Equal number of pieces equals completion
        if($index == $total ){  
          jsonMsg(2,'Upload complete',$url);
        }
        jsonMsg(1,'Uploading in progress');
    }               
} else {
    jsonMsg(0,'No files were uploaded');
}
 