<?php
    $dept_id = $this->session->userdata('dept_id');
    $position_id = $this->session->userdata('position_id');
   // print_r($this->session->userdata('user_id'));
?>

<div class="row-fluid" style="background: #02008C; ">
          <div class="span12">
<!--			  <div class="span12 visible-phone">
				<img style="width:100px; text-align: center; padding-right:10px;" src="<?php echo base_url();?>assets/img/logo.png" />
			  </div>-->
            <h1 id="schoolName" class="text-center" style="height:10px; color:white;font-size:20px;margin:0;"><?php echo Modules::run('main/getSiteName') ?></h1>
            <!--<h5 class="text-center" style="color:white;">( Integrated <?php //echo $title ?> Management System )</h5>-->
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
                        $menuItem = Modules::run('nav/getMenuAccess', $m);
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
                                                $submenu =  Modules::run('nav/getSubMenu', $menuItem->menu_id, $m);
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
                          
                     </a>       
                   <ul class="dropdown-menu">
                       <?php if(!$this->session->userdata('is_parent')): ?>
                       <li class=""><a href="<?php echo base_url('hr/viewTeacherInfo').'/'.base64_encode($this->session->userdata('user_id'))?>">View Personal Information</a></li>
<!--                       <li class=""><a style="float:left;" href="<?php echo base_url(); ?>notification">Notification
                         <?php endif; ?>   
                       </li>-->
                       <li class=""><a href="<?php echo base_url(); ?>login/logout">Logout</a></li>
                    </ul>
                
                  </li>
               </ul>  
                
              </div>
          </div>

</div>