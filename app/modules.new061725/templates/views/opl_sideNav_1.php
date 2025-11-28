<div class="sidebar" style="margin-top:50px">
    <nav class="sidebar-nav">
        <ul class="nav">
            
            <?php $menu = Modules::run('main/getUserMenus', $this->session->position_id); 
                
                $menus = explode(',', $menu->menu_access);
                foreach ($menus as $menu):
                    $menuAccess = Modules::run('main/getMenuAccess', $menu);
                    
                    if(!empty($menuAccess)):
            ?>
                
                    <li class="nav-item <?php echo $menuAccess->menu_li_class ?>">
                        <a class="nav-link <?php echo $menuAccess->menu_a_class ?>" href="<?php echo base_url($menuAccess->menu_link) ?>">
                            <i class="nav-icon <?php echo $menuAccess->menu_i_class ?>"></i> <?php echo $menuAccess->menu_name ?>
                            <!--<span class="badge badge-primary">NEW</span>-->
                        </a>
                        <?php if($menuAccess->menu_type=='dropdown'):?>
                            <ul class="nav-dropdown-items">
                                <?php $subMenuAccess = Modules::run('main/getSubMenu', $menu );
                                if(!empty($subMenuAccess)):
                                    foreach($subMenuAccess as $sub):
                                ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url($sub->menu_link); ?>">
                                                <i class="nav-icon <?php echo $menuAccess->menu_i_class ?>"></i> <?php echo $sub->menu_name ?></a>
                                        </li>
                        <?php 
                                    endforeach;
                                endif;
                            echo '</ul>';    
                            endif; ?>
                               
                    </li>
                
            <?php
                    endif;
                endforeach;
            ?>
                                        <li class="nav-item">
             <a class="nav-link" href="<?php echo base_url('login/logout'); ?>">
              <i class="nav-icon fa fa-lock"></i> Logout
            </a>
                                        </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>