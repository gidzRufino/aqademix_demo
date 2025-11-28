<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Spr_records extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('install_model');
        $this->load->dbforge();
        $this->load->dbutil();
        
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    public function databaseList()
    {
        $dbs = $this->dbutil->list_databases();
        
        return $dbs;
    }
            
    
    public function create_database($year)
    {
        $settings = $this->eskwela->getSet();
        
        $db_name = 'eskwela_'.strtolower($settings->short_name).'_'.$year;
        
        if($this->dbutil->database_exists($db_name))
        {
            echo json_encode(array('status' => TRUE));
        }else{
            if ($this->dbforge->create_database($db_name))
            {
                $this->install_model->createSPRTables($db_name, 'spr_tables.sql');
                echo json_encode(array('status' => TRUE));
            }else{
                echo json_encode(array('status' => TRUE));
            }
             
        }
        
        
    }
    
}
 
