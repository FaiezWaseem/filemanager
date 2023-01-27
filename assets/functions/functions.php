<?php
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

function fmredirect($url, $code = 302)
{
    header('Location: ' . $url, true, $code);
    exit;
}
function fm_enc($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
function fm_get_filesize($size)
{
    $size = (float) $size;
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = ($size > 0) ? floor(log($size, 1024)) : 0;
    $power = ($power > (count($units) - 1)) ? (count($units) - 1) : $power;
    return sprintf('%s %s', round($size / pow(1024, $power), 2), $units[$power]);
}
function fm_icon($ext){
    switch ($ext) {
        case "tar":
          return "./assets/images/Tar-icon.png";
          break;
        case "rar":
          return "./assets/images/rar-icon.png";
          break;
        case "php":
          echo "./assets/images/Mimetype-php-icon.png";
          break;
        case "zip":
          echo "./assets/images/zip-icon.png";
          break;
        case "html":
          echo "./assets/images/Other-html-5-icon.png";
          break;
        case "css":
          echo "./assets/images/css-3-icon.png";
          break;
        case "js":
          echo "./assets/images/text-x-javascript-icon.png";
          break;
        case "doc":
          echo "./assets/images/Microsoft-Office-Word-icon.png";
          break;
        case "docx":
          echo "./assets/images/Microsoft-Office-Word-icon.png";
          break;
        case "ppt":
          echo "./assets/images/Microsoft-Office-PowerPoint-icon.png";
          break;
        case "pptx":
          echo "./assets/images/Microsoft-Office-PowerPoint-icon.png";
          break;
        case "json":
          echo "./assets/images/app-json-icon.png";
          break;
        case "sql":
          echo "./assets/images/Sql-runner-icon.png";
          break;
        case "pdf":
          echo "./assets/images/Adobe-PDF-Document-icon.png";
          break;
        case "apk":
          echo "./assets/images/apk.png";
          break;
        case "mp3":
          echo "./assets/images/music-icon.png";
          break;
        case "wav":
          echo "./assets/images/music-icon.png";
          break;
        case "m4a":
          echo "./assets/images/music-icon.png";
          break;
        case "ogg":
          echo "./assets/images/music-icon.png";
          break;
        case "java":
          echo "./assets/images/Java-icon.png";
          break;
        default:
          return "./assets/images/Document-icon.png";
      }
}

 function message($m, $type){
   $bg = $type ? "red" : "green";
  echo "<span style='background-color:".$bg.";color:white;'>".$m."<span>";
 }
 function xcopy($source, $dest, $permissions = 0755)
 {
     $sourceHash = hashDirectory($source);
     // Check for symlinks
     if (is_link($source)) {
         return symlink(readlink($source), $dest);
     }
 
     // Simple copy for a file
     if (is_file($source)) {
         return copy($source, $dest);
     }
 
     // Make destination directory
     if (!is_dir($dest)) {
         mkdir($dest, $permissions);
     }
 
     // Loop through the folder
     $dir = dir($source);
     while (false !== $entry = $dir->read()) {
         // Skip pointers
         if ($entry == '.' || $entry == '..') {
             continue;
         }
 
         // Deep copy directories
         if($sourceHash != hashDirectory($source."/".$entry)){
              xcopy("$source/$entry", "$dest/$entry", $permissions);
         }
     }
 
     // Clean up
     $dir->close();
     return true;
 }

 // In case of coping a directory inside itself, there is a need to hash check the directory otherwise and infinite loop of coping is generated
 
 function hashDirectory($directory){
     if (! is_dir($directory)){ return false; }
 
     $files = array();
     $dir = dir($directory);
 
     while (false !== ($file = $dir->read())){
         if ($file != '.' and $file != '..') {
             if (is_dir($directory . '/' . $file)) { $files[] = hashDirectory($directory . '/' . $file); }
             else { $files[] = md5_file($directory . '/' . $file); }
         }
     }
 
     $dir->close();
 
     return md5(implode('', $files));
 }

 function passwordEnc(string $pass){
  return password_hash($pass, PASSWORD_DEFAULT);
}
function verifyPassword($pass , $hash){
  if (password_verify($pass, $hash)) {
     return true;
  } else {
     return false;
  }
}

?>