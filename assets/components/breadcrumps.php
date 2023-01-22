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
                <a href="./upload/index.html?p=<?php echo $current_path; ?>" class="btn btn-primary mr-2"><i class="ion ion-md-cloud-upload"></i>&nbsp; Upload</a>
                <button type="button" class="btn btn-secondary icon-btn mr-2" disabled=""><i class="ion ion-md-cloud-download"></i></button>
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