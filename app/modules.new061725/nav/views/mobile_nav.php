<ul data-role="listview" data-theme="d">
    <?php
         $menu = $menus->menu_access; //this is taken from the template.php
         
         //echo $menu;
        if($menu!=""){
        $item = explode(",", $menu);

        foreach ($item as $m){
            $menuItem = Modules::run('nav/getMenuAccess', $m);
            if($menuItem->menu_li_class!='dropdown' && $m!=6  && $m!=22):
                ?>
                 <li>
                        <a onclick="document.location=this.href" href="<?php echo base_url().$menuItem->menu_link ?>" class="<?php echo $menuItem->menu_li_class ?>">
                            <i class="fa <?php echo $menuItem->menu_a_class ?> fa-fw"></i> <?php echo $menuItem->menu_name ?>
                        </a>
                </li>    
                <?php
            endif;

                }
            
        }

   ?>
                <li>
                    <a onclick="document.location=this.href" href="<?php echo base_url().'login/logout'?>">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
                </li>
</ul>
