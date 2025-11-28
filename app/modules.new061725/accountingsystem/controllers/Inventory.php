<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of scanController
 *
 * @author genesis
 */
class inventory extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('inventory_model');
    	
    }
    
    function index()
    {
        $data['inventory'] = $this->getInventoryItems();
        $data['category'] = $this->getInventoryCategory();
        $data['modules'] = 'accountingsystem';
        $data['main_content'] = 'inventory/default';
        echo Modules::run('templates/canteen_content', $data);
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function addItems()
    {
        $itemDetails = array(
            'inv_name'      => $this->post('item_name'),
            'inv_desc'      => $this->post('item_desc'),
            'inv_no_stocks' => $this->post('item_stocks'),
            'inv_cat_id'    => $this->post('item_category'),
            'inv_price'     => $this->post('item_price'),
            'inv_markUp'    => $this->post('item_markUp')
        );
        
        $result = $this->inventory_model->addItem($itemDetails);
        
        if($result->status):
            echo json_encode(array('status'=>TRUE));
        else:
            echo json_encode(array('status'=>FALSE));
        endif;
    }
    
    function addCategory()
    {
        $cat = $this->post('category');
        
        $details = array(
           'inv_category'       => $cat,
        );
        
        $result = $this->inventory_model->addCategory($details);
        
        if($result->status):
            echo json_encode(array('status'=>TRUE));
        else:
            echo json_encode(array('status'=>FALSE));
        endif;
    }
    
    function getInventoryItems($item_id = NULL)
    {
        $inventory = $this->inventory_model->getInventoryItems($item_id);
        return $inventory;
    }
    
    function getInventoryCategory($cat_id=NULL)
    {
        $category = $this->inventory_model->getInventoryCategory($cat_id);
        return $category;
    }
    
}
