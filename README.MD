<img src="./assets/images/filemanger.PNG" height="280px">

## SIMPLE PHP FILE MANAGER
 hey folks this is a very simple easy to use php based 
 file manager.

### Config 
 - edit index.php 
 - To add absolute url change the path at line 61 variable $web_url
 - To change root path change at line 64 $root_path
 - To Go into read mode only edit line 70 to true
 - To enable auth edit line 70 to true
 - by default 
 - username = admin
 - password = admin
 - To change username & password goto line 72


```php
$web_url = "https://example.com";  //  line 61
// Root path for file manager 
// use absolute path of directory i.e: '/var/www/folder' or $_SERVER['DOCUMENT_ROOT'].'/folder'
$root_path = $_SERVER['DOCUMENT_ROOT']; // line 64 

$read_only = false; // line 70
$auth = false; // line 71
```



### TODO
- [x]  Upload file (upto 9gb)
- [x]  Multiple File Uploads
- [x]  Edit Text Files
- [x]  create new Folders
- [x]  create new Files
- [x]  in-built text editor
- [x]  Delete Folder/Files
- [x]  Dark mode
- [x]  File/Folders Icon
- [x]  File Download
- [x]  Grid Layout
- [x]  Rename Folder/file
- [x]  Copy file
- [x]  Copy Folder
- [x]  AUTH / READONLY MODE 
- [ ]  List Layout
- [ ]  Unzip
- [ ]  move Folder/file
- [ ]  PDF Viewer
- [ ]  PPT VIEWER