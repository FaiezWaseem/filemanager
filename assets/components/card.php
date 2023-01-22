<?php
          
          // Open a directory, and read its contents
         if (is_dir($current_path)){
           if ($dh = opendir($current_path)){
            while (($file = readdir($dh)) !== false){
                if(is_dir($current_path."/".$file)){ 
                    ?>
                            <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <img src="./assets/images/Folder-icon.png" alt="folder" class="file-item-icon far fa-folder text-secondary">
            <!-- <div class="file-item-icon far fa-folder text-secondary"></div> -->
            <a href="?p=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file ?>" class="file-item-name">
                <?php echo $file ?>
            </a>
            <div class="file-item-changed">02/13/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Move</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                </div>
            </div>
        </div>
                 <?php   
                }else{
                    $ext = pathinfo($file, PATHINFO_EXTENSION); 
                    if(in_array($ext, $images_ext)){ ?>
                            <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <div class="file-item-img" style="background-image: url(<?php echo $web_url; ?>file.php?file=<?php  echo ($current_path."/".$file); ?>);"></div>
            <a href="javascript:void(0)" class="file-item-name">
                <?php echo $file ?>
            </a>
            <div class="file-item-changed">02/20/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>
                        <?php
                    }else if (in_array($ext, $video_ext)){ ?>

            <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <video style="width : 100%" src="<?php echo $web_url; ?>file.php?file=<?php  echo ($current_path."/".$file); ?>"></video>
            <!-- <div class="file-item-icon far fa-file-video text-secondary">
            </div> -->
            <a href="javascript:void(0)" class="file-item-name">
                <?php echo $file; ?>
            </a>
            <div class="file-item-changed">03/01/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>
                   <?php  }else if (in_array($ext, $audio_ext)){ ?>
                            <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <div class="file-item-icon far fa-file-audio text-secondary"></div>
            <a href="javascript:void(0)" class="file-item-name">
            <?php echo $file;?>
            </a>
            <div class="file-item-changed">02/28/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>


                  <?php  }elseif (in_array($ext, $compressed_ext)) { ?>
                        <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <img src="<?php echo fm_icon($ext); ?>" alt="folder" class="file-item-icon far fa-folder text-secondary">
            <a href="javascript:void(0)" class="file-item-name">
                <?php echo $file; ?>
            </a>
            <div class="file-item-changed">02/16/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>
                    
                    <?php
                    }elseif ($ext == "css") { ?>
                              <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <img src="<?php echo fm_icon($ext); ?>" alt="folder" class="file-item-icon far fa-folder text-secondary">
            <a href="<?php echo $web_url; ?>?edit=<?php  echo ($current_path."/".$file); ?>" class="file-item-name"  >
                <?php echo $file; ?>
            </a>
            <div class="file-item-changed">02/27/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>
                   
                  <?php 
                   }else if(in_array($ext, $files_ext)){ ?>
        <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <img src="<?php echo fm_icon($ext); ?>" alt="folder" class="file-item-icon far fa-folder text-secondary">
            <a href="<?php echo $web_url; ?>?edit=<?php  echo ($current_path."/".$file); ?>" class="file-item-name" >
                <?php echo $file ?>
            </a>
            <div class="file-item-changed">02/26/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>
                <?php    }elseif ($file == "..") { ?>
                    <div class="file-item">
            <div class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary"></div>
            <a href="<?php echo $file; ?>" class="file-item-name">
                <?php echo $file; ?>
            </a>
        </div>
                    
                
              <?php  }else{ ?>
        <div class="file-item">
            <div class="file-item-select-bg bg-primary"></div>
            <label class="file-item-checkbox custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label"></span>
            </label>
            <img src="<?php echo fm_icon($ext); ?>" alt="folder" class="file-item-icon far fa-folder text-secondary">
            <a href="javascript:void(0);" class="file-item-name" data-toggle="modal" data-target="#exampleModal">
                <?php echo $file;?>
            </a>
            <div class="file-item-changed">02/24/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button" class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="?d=<?php echo isset($_GET["p"]) ? $_GET["p"]." ".$file : end($current_path_array)." ".$file  ?>">Remove</a>
                    <a class="dropdown-item" href="<?php echo $web_url; ?>file.php?dw=<?php  echo ($current_path."/".$file); ?>">Download</a>
                </div>
            </div>
        </div>
<?php
                    }
                }
           }
          closedir($dh);
         }
      }else{
        echo "Doesnt Recoggnize Path : ". $current_path;
      }
          
          ?>
        