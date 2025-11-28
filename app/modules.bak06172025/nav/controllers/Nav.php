<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of nav
 *
 * @author genesis
 */
class Nav extends MX_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('nav_model');
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function saveMenu()
    {
        $menu_id = $this->post('menu_id');
        $menu_type = $this->post('menu_type');
        $menu_parent = $this->post('menu_parent');
        $menu_title = $this->post('menu_name');
        $menu_link = $this->post('menu_link');
        $menu_icon = $this->post('menu_icon');
        $menu_class = $this->post('menu_class');
        
        $menu_array = array(
            'menu_name' => $menu_title,
            'menu_link' => $menu_link,
            'menu_type' => $menu_type,
            'menu_parent' => $menu_parent,
            'menu_li_class' => $menu_class,
            'menu_a_class' => $menu_icon,
        );
        
        if($this->nav_model->saveMenu($menu_array, $menu_id)):
            echo 'Successfully Saved!';
        else:
            echo 'An error has occured, Please contact CSS Technical Team';
        endif;
    }
    
    function menuManagement()
    {
        $data['menuList'] = $this->getMenuList();   
        $data['modules'] = "nav";
        $data['main_content'] = 'menu_list';
        echo Modules::run('templates/main_content', $data);
    }
    function getUserMenus()
    {
        $position_id = $this->session->userdata('position_id');
        $data['menus']= $this->nav_model->getMenu($position_id); 
         if(Modules::run('main/isMobile'))
        {
            $this->load->view('mobile_nav', $data); 
         }else{
            $this->load->view('default', $data);
         }
        
    }
    
    function getMenuAccess($id)
    {
        $menuItem = $this->nav_model->getMenuAccess($id);
        return $menuItem;
    }
    
    function getSubMenu($id, $menu_id)
    {
        $submenu = $this->nav_model->getSubMenu($id, $menu_id);
        return $submenu;
    }
      
    function getSideNav()
    {
        $data['menus'] = $this->nav_model->getIcons($this->session->userdata('position_id'));
        $this->load->view('sideNav', $data); 

    }
    
    function getDashIcons()
    {
        $data['settings'] = Modules::run('main/getSet');
        $data['icons'] = $this->nav_model->getIcons($this->session->userdata('position_id'));
         if($this->agent->is_mobile())
        {
            $this->load->view('mobile_icons', $data); 
         }else{
            $this->load->view('topNav', $data); 
         }

    }
    
    function getDashAccess($id)
    {
       $dashAccess = $this->nav_model->getDashAccess($id);
        return $dashAccess;
    }
    
    function getDashboardList()
    {
        $dashboard = $this->nav_model->getDashboardList();
        return $dashboard;
    }
    
    function getMenuList()
    {
        $menu = $this->nav_model->getMenuList();
        return $menu;
    }
    
    function getMenuDashAccess($position_id, $menu_id, $type)
    {
        $menuDash = $this->nav_model->getMenuDashAccess($position_id, $menu_id, $type);
        return $menuDash;
    }
    
    function positionAccess($id)
    {
        $menuDash = $this->nav_model->getPositionAccess($id);
        return $menuDash;
    }
    
    function getMenuById($id)
    {
        $menu = $this->nav_model->getMenuById($id);
        return $menu->row();
    }
    
    function getMenuByPosition($id){
        return $this->nav_model->getMenu($id);
    }
    
    function checkAccess(){
        $uri = $this->uri->uri_string();
        $link = $this->nav_model->getMenuLink($uri);
        $t = 0;
        
        $access = $this->session->userdata('menu_access');
        $loop = explode(',', $access);
        
        foreach ($loop as $l):
            if($l == $link->menu_id):
                $t++;
            endif;
        endforeach;
        
        if($t > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}
