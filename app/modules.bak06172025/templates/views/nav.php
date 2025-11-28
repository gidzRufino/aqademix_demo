<div class="row-fluid" style="background: #b00; ">
          <div class="span12">
<!--			  <div class="span12 visible-phone">
				<img style="width:100px; text-align: center; padding-right:10px;" src="<?php echo base_url();?>assets/img/logo.png" />
			  </div>-->
            <h1 id="schoolName" class="text-center" style="height:25px; color:white;font-size:25px;margin:0;"><?php //echo $schoolName; ?></h1>
            <h4 class="text-center" style="color:white;">( Integrated <?php echo $title ?> Management System )</h4>
          </div>
    <div class="span1">
    </div>
          <div class="span9">
              
               <!--For main navigation--> 
              <div style="width:106%" class="tabbable mainMenu hidden-phone"> 
                <ul class="nav nav-tabs" role="menu"> 
                  
                <?php
                    if($position_id==0){
                ?>
                    
                  <li class="">
                      <a class="" href="<?php echo base_url()?>main/dashboard" >
                            Dashboard
                        </a>
                  </li>
                  
                 <?php
                    }
                    $menu = $menus->menu_access; //this is taken from the template.php
                    if($menu!=""){
                    $item = explode(",", $menu);
                    
                    foreach ($item as $m){
                        $menuItem = $this->dashboard_model->getMenuAccess($m);
                    if($menuItem->menu_parent==0){    
                        
                        if($menuItem->menu_type == 'modal'){
                            $modal = 'data-toggle="modal"';
                        }else{
                            $modal = '';
                        }
                        if($menuItem->menu_li_class=='dropdown'){
                            $modal = 'data-toggle="dropdown"';
                        }
                        if($menuItem->menu_link!='#'){
                            $href ='href="'.base_url().$menuItem->menu_link.'"';
                        }else{
                            $href = 'href="#"';
                    }
                  ?>
                    
                    <li class="<?php echo $menuItem->menu_li_class ?>">
                        <a class="<?php echo $menuItem->menu_a_class ?>" <?php echo $href?> <?php echo $modal ?> >
                            <?php echo $menuItem->menu_name ?>
                        </a>
                  <?php
                        if ($menuItem->menu_li_class=='dropdown'){          
                            ?>
                                <ul class="dropdown-menu">
                                    <?php 
                                        foreach ($item as $m){
                                            $submenu = $this->dashboard_model->getSubMenu($menuItem->menu_id, $m);
                                                if($submenu!='0'){
                                                    if($submenu->menu_type=='submenu'){    
                                                    ?>  
                                                        <li><a class="<?php echo $submenu->menu_a_class ?>" href="<?php echo base_url(); ?><?php echo $submenu->menu_link; ?>"><?php echo $submenu->menu_name ?></a></li> 
                                                    <?php
                                                    }
                                                }
                                        }
                                    ?>
                                </ul>
                       
                            <?php  
                        }
                        ?>
                     </li> 
                    <?php    
                    }
                    }
                    }
                  ?>  
                     
                     <li style="float:right;" onclick="document.getElementById('notiCount1').innerHtml = document.getElementById('notiCount').innerHtml" class="dropdown">    
                      <a class="dropdown-toggle"
                        data-toggle="dropdown"
                        href="#">Hi <?php echo $this->session->userdata('name'); ?> !&nbsp;
                          
                          <?php 
                          if($dept_id==33){
                            if($notiCount['num_rows']>0){ // if there is unread notifications?>
                                <span id="notiCount" class="notiCount pull-right"><?php echo $notiCount['num_rows'] ?></span>
                          <?php 
                          
                          }else{ ?>
                              <span id="notiCount" class="pull-right"></span>
                          <?php    
                          } 
                          } 
                          ?>
                     </a>       
                   <ul class="dropdown-menu">
                       <li class=""><a data-toggle="modal" href="#changePassword">Edit login Information</a></li>
                       <li class=""><a style="float:left;" href="<?php echo base_url(); ?>notification">Notification
                             <?php
                             if($dept_id==33){
                                if($notiCount['num_rows']>0){ // if there is unread notifications?>
                                <span id="notiCount1" onclick="markNotiRead()"  style="padding:2px 5px; margin-left:35px;" class="notiCount"><?php echo $notiCount['num_rows'] ?></span>
                            <?php }else{ ?>
                              <span id="notiCount1" class="pull-right"></span>
                            <?php    
                                }
                             }
                                ?>
                        
                       </li>
                       <li class=""><a href="<?php echo base_url(); ?>login/logout">Logout</a></li>
                    </ul>
                
                  </li>
               </ul>  
                
              </div>
          </div>

</div>