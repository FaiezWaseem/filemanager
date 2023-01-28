
<?php
// display image/video file
if(isset($_GET['file'])){
  echo readfile($_GET['file']);
  exit;
}
// Download file
if(isset($_GET["dw"])){
  $file = $_GET["dw"];

if (file_exists($file)) {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.basename($file));
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file));
  ob_clean();
  flush();
  readfile($file);
  exit;
}
}

?>

<?php
require("assets/functions/functions.php");



// 8 hours in seconds
$inactive = 28800; 
ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 8 hours

session_start();

if (isset($_SESSION['exptime']) && (time() - $_SESSION['exptime'] > $inactive)) {
    // last request was more than 8 hours ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();   // destroy session data
}
$_SESSION['exptime'] = time(); // Update session



// Root url for links in file manager.Relative to $http_host. Variants: '', 'path/to/subfolder'
// Will not working if $root_path will be outside of server document root
$root_url = '';

// Server hostname. Can set manually if wrong
// $_SERVER['HTTP_HOST'].'/folder'
$http_host = $_SERVER['HTTP_HOST'];
$is_https = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)
    || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https';

// add your web url here
$web_url = ($is_https ? 'https' : 'http') . '://' . $http_host . $_SERVER['PHP_SELF'];
// Root path for file manager
// use absolute path of directory i.e: '/var/www/folder' or $_SERVER['DOCUMENT_ROOT'].'/folder'
$root_path = $_SERVER['DOCUMENT_ROOT'];
// $root_path = "C:";
// Extension supported
$is_logged_in = false;  // dont edit this 


$read_only = false;
$auth = false;
$auth_users = array(
  "user" => 'admin',
  "password" => '$2y$10$Dslt6unl7BrTGG0yNg37zOLNHQ/n7cpSAxGpklQHsBa/zvlb8OrvO', // admin
);


if(isset($_POST["username"])&& isset($_POST["password"]) && isset($_GET["login"])){
   if(verifyPassword($_POST["password"],$auth_users["password"])){
    $_SESSION["is_logged_in"] = true;
  }else{
     message("Invalid", false);
   }
}

if(isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"]){
  $is_logged_in = true;
}


$images_ext = array('ico', 'gif', 'jpg', 'jpeg', 'jpc', 'jp2', 'jpx', 'xbm', 'wbmp', 'png', 'bmp', 'tif', 'tiff', 'psd', 'svg', 'webp', 'avif','PNG','JPEG','JPG');
$video_ext = array('avi', 'webm', 'wmv', 'mp4', 'm4v', 'ogm', 'ogv', 'mov', 'mkv');
$audio_ext = array('wav', 'mp3', 'ogg', 'm4a');
$compressed_ext = array("zip","tar","gz","rar");
$files_ext = array(
    'txt', 'css', 'ini', 'conf', 'log', 'htaccess', 'passwd', 'ftpquota', 'sql', 'js', 'ts', 'jsx', 'tsx', 'mjs', 'json', 'sh', 'config',
    'php', 'php4', 'php5', 'phps', 'phtml', 'htm', 'html', 'shtml', 'xhtml', 'xml', 'xsl', 'm3u', 'm3u8', 'pls', 'cue', 'bash', 'tpl', 'vue',
    'eml', 'msg', 'csv', 'bat', 'twig', 'tpl', 'md', 'gitignore', 'less', 'sass', 'scss', 'c', 'cpp', 'cs', 'py', 'go', 'zsh', 'swift', 'yml',
    'map', 'lock', 'dtd', 'svg', 'scss', 'asp', 'aspx', 'asx', 'asmx', 'ashx', 'jsp', 'jspx', 'cfm', 'cgi', 'dockerfile', 'ruby', 'twig',
    'yml', 'yaml', 'toml', 'md', 'vhost', 'scpt', 'applescript', 'c', 'cs', 'csx', 'cshtml', 'cpp', 'c++', 'coffee', 'cfm', 'rb',
    'graphql', 'mustache', 'jinja', 'phtml', 'http', 'handlebars', 'lock', 'java', 'es', 'es6', 'markdown', 'wiki', 'vhost', 'sql',
);



// Don't Edit Below 
$current_path = $root_path;
$current_path_array = explode("/",$root_path);

// clean and check $root_path
$root_path = rtrim($root_path, '\\/');
$root_path = str_replace('\\', '/', $root_path);



// Remove A file or Folder
// d parameter contains the path of file/dir
if(isset($_GET["d"])){
  
  if(!$read_only){
     $file_path = str_replace(" ","/",$_GET["d"]);
     $file_path = str_replace(array_slice(explode("/",$root_path), -1)[0],"",$file_path);
     $file_path = $root_path . $file_path;
     if(is_dir($file_path)){
        if(deleteDirectory($file_path)){
            echo "directory Deleted : ".$file_path;
           }else{
               echo "directory Delete Failed";
           }
     }else{

         if(unlink($file_path)){
             echo "File Deleted : ".$file_path;
            }else{
                message("File Delete Failed",true);
            }
        }
        fmredirect($web_url."?p=".str_replace(array_slice(explode(" ",$_GET["d"]), -1)[0],"",$_GET["d"])."&frm=1");
      }else{
        message("currently in read only mode",true);
      }
}



// Loads the Current Dir
if(isset($_GET["p"])){
    if($_GET["p"] != ""){
        loadDir($_GET["p"]);
    }
}

// copy folder/file
if(isset($_POST["_path"]) && isset($_POST["_dest"]) ){
  if(!$read_only){
    if(xcopy($_POST["_dest"],$_POST["_path"])){
      message("Folder/file Copied!",false);
    }else{
      message("Folder/file Copied! Failed",true);
    }
  }else{
    message("currently in read only mode",true);
  }
}



// create a new folder
if(isset($_POST["folderName"]) && isset($_POST["folderPath"])){
  if(!$read_only){
    if(mkdir($_POST["folderPath"].$_POST["folderName"])){
      message($_POST['folderName']." FOLDER CREATED",false);
  }
  }else{
    message("currently in read only mode",true);
  }
}else if (isset($_POST["fileName"]) && isset($_POST["folderPath"]) && isset($_POST["ftext"])){
  if(!$read_only){
    $myfile = fopen($_POST["folderPath"].$_POST["fileName"], "w") or die("Unable to open file!");  
    fwrite($myfile, $_POST["ftext"]); 
    fclose($myfile);
    message($_POST['fileName']." FILE CREATED",false);
  }else{
    message("currently in read only mode",true);
  }
  }

//  Edit file
if(isset($_POST["editFileText"]) && isset($_POST["filePath"])){
  if(!$read_only){
  $myfile = fopen($_POST["filePath"], "w") or die("Unable to open file!");  
   $text = json_decode($_POST["editFileText"]);
     fwrite($myfile, $text->text); 
     fclose($myfile);
    }else{
      message("currently in read only mode",true);
    }  
}

// rename folder/file
if(isset($_POST["dir"])&&isset($_POST["rfolderName"])){
  if(!$read_only){
  if(rename($_POST["dir"],$_POST["rfolderPath"].$_POST["rfolderName"])){
    message("Folder/file Renamed",false);
   }
  }else{
    message("currently in read only mode",true);
  }  
}


function loadDir($input){
    global $root_path , $current_path , $current_path_array;
    $c_dir = array_slice(explode("/",$root_path), -1)[0]; // extract current Directory name 
    $temp =  (explode(" ",str_replace("..","",$input))); 
    unset($temp[0]);
    $current_path = $root_path;
    foreach ($temp as $key => $value) {
        $current_path = $current_path."/".$value;
        $current_path_array = explode("/",$current_path);
    }
}

?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Primary Meta Tags -->
<title>Simple Php File Manager</title>
<meta name="title" content="Simple Php File Manager">
<meta name="description" content="Hey Folks this is a simple php based File Manager . Which supports file upload , delete , copy , download etc features . Simply put it in the public directory of your server and Enjoy">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://faiezwaseem.github.io/">
<meta property="og:title" content="Simple Php File Manager">
<meta property="og:description" content="Hey Folks this is a simple php based File Manager . Which supports file upload , delete , copy , download etc features . Simply put it in the public directory of your server and Enjoy">
<meta property="og:image" content="./assets/images/filemanger.PNG">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://faiezwaseem.github.io/">
<meta property="twitter:title" content="Simple Php File Manager">
<meta property="twitter:description" content="Hey Folks this is a simple php based File Manager . Which supports file upload , delete , copy , download etc features . Simply put it in the public directory of your server and Enjoy">
<meta property="twitter:image" content="./assets/images/filemanger.PNG">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css"> <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css" integrity="sha512-0/rEDduZGrqo4riUlwqyuHDQzp2D1ZCgH/gFIfjMIL5az8so6ZiXyhf1Rg8i6xsjv+z/Ubc4tt1thLigEcu6Ug==" crossorigin="anonymous" referrerpolicy="no-referrer"> 
    <link rel="stylesheet" href="./assets/css/custom.css">  
    <link rel="stylesheet" href="./assets/boostrapDark/darktheme.css"/>
    <link rel="stylesheet" href="./assets/css/switch.css">
    
    <style type="text/css" media="screen">
    #editor { 
        position: absolute;
        top: 20%;
        right: 0;
        bottom: 0;
        left: 0;

        
    }
</style>
</head>
  <body>
    <!-- BEGIN INSERTION -->
<script src="./assets/bundles/bootstrap-darkmode.umd.js"></script>
<script>
	const BootstrapDarkmode = window['bootstrap-darkmode'];
	const themeConfig = new BootstrapDarkmode.ThemeConfig();
	themeConfig.initTheme();
    // themeConfig.saveTheme("dark")
</script>
<!-- END INSERTION -->

<?php  if(($auth && $is_logged_in) || !$auth){ ?>

<?php
if(!isset($_GET["edit"])){ ?>
<div class="container flex-grow-1 light-style container-p-y">
      <?php 
      if(isset($_GET["frm"])){
         echo "<div class='alert alert-primary' role='alert'>
         FILE/FOLDER DELETED
       </div>";
       }
      ?>
       <?php include_once("./assets/components/breadcrumps.php"); ?>
       
       <div class="file-manager-container file-manager-col-view">
           <div class="file-manager-row-header">
               <div class="file-item-name pb-2">Filename</div>
               <div class="file-item-changed pb-2">Changed</div>
            </div>
            
            <?php include_once("./assets/components/card.php"); ?>
            
        </div>
        <?php echo  "Total Free : ".fm_get_filesize(disk_free_space($root_path)). "/".fm_get_filesize(disk_total_space($root_path)); ?>
        
    </div>
<?php }?>

<?php
if(isset($_GET["edit"])){ 
    echo "file : ".$_GET["edit"];

    ?>
     <form action="<?php echo $web_url."?edit=".$_GET["edit"]; ?>" method="post" id="fileEdit">
<input type="text" hidden name="editFileText" id="editFileText">
<input type="text" hidden name="filePath" value="<?php echo $_GET["edit"]; ?>" >
<input type="submit" class="btn btn-primary" value="save">
<button type="button" class="btn btn-info" onclick="window.history.back();">cancel</button>
</form>
<div id="editor">
<?php
echo fm_enc(file_get_contents($_GET["edit"]));
?>
</div>


<?php }?>

<!-- CREATE NEW FOLDER Modal -->
<div class="modal fade" id="createFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create new folder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $web_url."?p=".$_GET["p"]; ?>" method="post">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Enter Folder Name : </span>
                </div>
                <input type="text" class="form-control" name="folderName"  aria-label="Default" aria-describedby="inputGroup-sizing-default">
                <input type="text" class="form-control" name="folderPath" hidden value="<?php  echo ($current_path."/"); ?>" >
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary"  value="Create">
        </div>
    </form>
    </div>
  </div>
</div>


<!-- CREATE NEW FILE MODEL -->
<!-- Modal -->
<div class="modal fade" id="createFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $web_url."?p=".$_GET["p"]; ?>" method="post">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Enter FILE Name : </span>
                </div>
                <input type="text" class="form-control" name="fileName"  aria-label="Default" aria-describedby="inputGroup-sizing-default">
                <input type="text" class="form-control" name="folderPath" hidden value="<?php  echo ($current_path."/"); ?>" >
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Write Here</label>
               <textarea class="form-control" id="filedata" name="ftext" rows="3"></textarea>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary"  value="Create">
        </div>
    </form>
    </div>
  </div>
</div>
 

<!-- RENAME FOLDER Modal -->
<div class="modal fade" id="renameFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $web_url."?p=".$_GET["p"]; ?>" method="post">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name : </span>
                </div>
                <input type="text" class="form-control" id="rfolderName" name="rfolderName"  aria-label="Default" aria-describedby="inputGroup-sizing-default">
                <input type="text" class="form-control" name="rfolderPath" hidden value="<?php  echo ($current_path."/"); ?>" >
                <input type="text" class="form-control" id="rPath" name="dir" hidden  >
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary"  value="SAVE">
        </div>
    </form>
    </div>
  </div>
</div>


<!-- COPY FILE/FOLDER Modal -->
<div class="modal fade" id="copyFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Copy File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $web_url."?p=".$_GET["p"]; ?>" method="post">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Current Dir : </span>
                </div>
                <input type="text" class="form-control" id="currentDir" name="_dest"  >
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Copy Dir : </span>
                </div>
                <input type="text" class="form-control" id="copyDir" name="_path"  aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary"  value="SAVE">
        </div>
    </form>
    </div>
  </div>
</div>


<?php if(isset($_GET["edit"])){ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.14.0/ace.min.js" integrity="sha512-s57ywpCtz+4PU992Bg1rDtr6+1z38gO2mS92agz2nqQcuMQ6IvgLWoQ2SFpImvg1rbgqBKeSEq0d9bo9NtBY0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    (async () => {
    let opt;
    let lang;
    ["xcode","gob","chrome","tomorrow_night","solarized_dark","kuroir","github","dracula","katzenmilch","merbivore","nord_dark","sqlserver","textmate"].forEach(function(e){
        opt += `<option value="${e}">${e}</option>`
    });
    ["abap","abc","actionscript","ada","alda","apache_conf","apex","aql","asciidoc","asl","assembly_x86","autohotkey","batchfile","bibtex","c_cpp","c9search","cirru","clojure","cobol","coffee","coldfusion","crystal","csharp","csound_document","csound_orchestra","csound_score","css","curly","d","dart","diff","dockerfile","dot","drools","edifact","eiffel","ejs","elixir","elm","erlang","forth","fortran","fsharp","fsl","ftl","gcode","gherkin","gitignore","glsl","gobstones","golang","graphqlschema","groovy","haml","handlebars","haskell","haskell_cabal","haxe","hjson","html","html_elixir","html_ruby","ini","io","ion","jack","jade","java","javascript","jexl","json","json5","jsoniq","jsp","jssm","jsx","julia","kotlin","latex","latte","less","liquid","lisp","livescript","log","logiql","logtalk","lsl","lua","luapage","lucene","makefile","markdown","mask","matlab","maze","mediawiki","mel","mips","mixal","mushcode","mysql","nginx","nim","nix","nsis","nunjucks","objectivec","ocaml","partiql","pascal","perl","pgsql","php_laravel_blade","php","pig","powershell","praat","prisma","prolog","properties","protobuf","puppet","python","qml","r","raku","razor","rdoc","red","rhtml","robot","rst","ruby","rust","sac","sass","scad","scala","scheme","scrypt","scss","sh","sjs","slim","smarty","smithy","snippets","soy_template","space","sparql","sql","sqlserver","stylus","svg","swift","tcl","terraform","tex","text","textile","toml","tsx","turtle","twig","typescript","vala","vbscript","velocity","verilog","vhdl","visualforce","wollok","xml","xquery","yaml","zeek","django"].forEach(function(e){
        lang += `<option value="${e}">${e}</option>`
    });
    await import('https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.14/ace.js').catch((error) => console.log('Loading failed' + error))
    document.body.appendChild(Object.assign(document.createElement("select"), {id: "themes", innerHTML: opt}))
    document.body.appendChild(Object.assign(document.createElement("select"), {id: "modes", innerHTML: lang}))
    
    let editor = await ace.edit('editor')
    ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.14/')
    editor.setOptions({
        theme: 'ace/theme/tomorrow_night',
        mode: 'ace/mode/javascript'
    })
    themes.addEventListener('change', function(e){
      editor.setOptions({
        theme: 'ace/theme/' + e.target.value
      })
    })
    modes.addEventListener('change', function(e){
      editor.setOptions({
        mode: 'ace/mode/' + e.target.value
      })
    })
    let form = document.getElementById("fileEdit");
  form.onsubmit = (e) =>{
    e.preventDefault();
    let inputTextFeild = $("#editFileText");
    let text = editor.getValue();
    inputTextFeild[0].value = JSON.stringify({ text : text});
    console.log(text)
    console.log(inputTextFeild[0].value)
     form.submit();
   }
})()
</script>
<?php } ?>
<script>
   
  try {
    document.getElementById("darkSwitch").checked = window.localStorage.getItem("theme") === "dark" ? true : false;
  document.querySelector(".slider").onclick = () =>{
    if(document.getElementById("darkSwitch").checked){
      themeConfig.saveTheme("light")
    }else{
      themeConfig.saveTheme("dark")
    }
    window.location.reload();
  }
  } catch (error) {
    
  }

  function DeleteClicked(){
    var markedCheckbox = document.querySelectorAll('.custom-control-input');
     for (let name of markedCheckbox) {
        if(name.checked == true){
          console.log(name.parentNode.parentNode)
       }
     }
  }
  function folderRename(_){
    const folderName = _.getAttribute("folder");
    const path = _.getAttribute("path");
    const folderNameInput = $("#rfolderName"); 
    folderNameInput[0].value = folderName;
    $("#rPath")[0].value = path;
  }
  function foldercopy(_){
    const folderName = _.getAttribute("folder");
    const path = _.getAttribute("path");
    const folderNameInput = $("#currentDir"); 
    folderNameInput[0].value = path;
    $("#copyDir")[0].value = path;
  }

</script>

<?php }  if($auth && !$is_logged_in){?>

  <div class="container" style="justify-content:center;display:flex;height: 100vh;align-items:center;">

  <form style="width: 300px" action="<?php echo $web_url."?login=" ?>" method="post">
  <!-- Email input -->
  <div class="form-outline mb-4">
    <label class="form-label" for="form2Example1">Username</label>
    <input type="text" name="username" class="form-control" />
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <label class="form-label" for="form2Example2">Password</label>
    <input type="password" name="password" class="form-control" />
  </div>


  <!-- Submit button -->
  <input type="submit" class="btn btn-primary btn-block mb-4" value="Sign in" name="submit_login" />

</form>
  </div>
  
  
<?php
}


?>
</body>
</html>

