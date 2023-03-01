<div class="container-m-nx container-m-ny bg-lightest mb-3">
        <ol class="breadcrumb text-big container-p-x py-3 m-0">
            <?php
              foreach ($current_path_array as $key => $value) {
                if($value != array_slice(explode("/",$root_path), -1)[0]){
                  if($value != ""){
                      $load_url = explode($value,$current_path);
                      $load_url = $load_url[0];
                      $load_url = str_replace($root_path,"",$load_url);
                      $load_url = str_replace("/"," ",$load_url);
                      $load_url = $load_url .$value;
                      $load_url = rtrim($load_url);
                      $load_url = ltrim($load_url);
                      $load_url = array_slice(explode("/",$root_path), -1)[0] ." ".$load_url;
                    }
                    }else{
                    $load_url = $value;
                }


              ?>
              <?php 
                if(end($current_path_array) == $value){
                    echo "<li class='breadcrumb-item active'>$value</li>";
                }else{       
              ?>
            <li class="breadcrumb-item">
                <a href="?p=<?php echo $load_url;?>"><?php echo $value ?></a>
            </li>
            <?php 
                }
              } 
            ?>
            
        </ol>

        <hr class="m-0" />

        <div class="file-manager-actions container-p-x py-2">
            <div>
                <a href="./~upload/index.html?p=<?php echo $current_path; ?>" class="btn btn-primary mr-2"><i class="ion ion-md-cloud-upload"></i>&nbsp; Upload</a>
                
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-default md-btn-flat dropdown-toggle px-2" data-toggle="dropdown"><i class="ion ion-ios-settings"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#createFolder">Create Folder</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#createFile">Create File</a>
                    </div>
                </div>
            </div>
            <div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="switch">
                        <input type="checkbox" id="darkSwitch">
                        <span class="slider round"></span>
                      </label> 
                    <label class="btn btn-default icon-btn md-btn-flat active"> <input type="radio" name="file-manager-view" value="file-manager-col-view" checked="" /> <span class="ion ion-md-apps"></span> </label>
                    <label class="btn btn-default icon-btn md-btn-flat"> <input type="radio" name="file-manager-view" value="file-manager-row-view" /> <span class="ion ion-md-menu"></span> </label>
                </div>
            </div>
        </div>

        <hr class="m-0" />
    </div>

    <ul class="sidebar-folder-list">
    <?php
          
          // Open a directory, and read its contents

         if (is_dir(str_replace('~', ' ',$current_path))){
           if ($dh = opendir(str_replace('~', ' ',$current_path))){
            while (($file = readdir($dh)) !== false){
                $file = str_replace(' ', '~', $file);
                if($file == ".." || $file == "."){
                    // skipping .. . folder
                }
                else if(is_dir(str_replace('~', ' ',$current_path)."/".str_replace('~', ' ', $file))){ 
                    ?>
                    <!-- <li class="sidebar-folder"> -->
                      <a class="sidebar-folder" href="?p=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file ?>">
                        <img src="./assets/images/Folder-icon.png" alt="folder"  style="width:30px;height:30px;">
                        <?php echo $file ?>
                      </a>
                      <!-- </li> -->
                    <?php  }}}} ?>
    </ul>