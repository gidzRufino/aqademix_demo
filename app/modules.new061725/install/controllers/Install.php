<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Install extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('form_validation');
        $this->load->model('install_model');
        $this->load->dbforge();
        
        header('Access-Control-Allow-Origin: *');
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
            
    
    public function index()
    {
        $data['modules'] = 'install';
        $data['main_content'] = 'install';
        echo Modules::run('templates/college_content', $data);
    }
    
    public function create_database()
    {
        $year = $this->post('year');
        $settings = $this->eskwela->getSet();
        
        $db_name = 'eskwela_'.strtolower($settings->short_name).'_'.$year;
        
        if ($this->dbforge->create_database($db_name))
        {
                echo 'Database Successfully created!';
        }
    }
    
    public function generateInitialTables()
    {
        $this->load->dbutil();
        $this->db = $this->eskwela->db('2018');
        $tables = $this->db->list_tables();
        
        $i = 0;
        foreach ($tables as $table)
        {
            $i++;
            if($i==1):
                 //if(Modules::run('install/db_tables/'.$table, '2019')):
                 if(Modules::run('install/db_tables/esk_cities', '2019')):
                     echo "table successfully created";
                 endif;

            endif;
        }
    }
    
    
    private function writeConfig($fileName)
    {
        
        $template_path 	= APPPATH.'modules/install/config/'.$fileName.'-bak.php';
        $output_path 	= APPPATH.'config/'.$fileName.'.php';
        $file = file_get_contents($template_path);
        
        // Write the new database.php file
        $handle = fopen($output_path,'w+');

        // Chmod the file, in case the user forgot
        @chmod($output_path,0777);

        // Verify file permissions
        if(is_writable($output_path)) {

                // Write the file
                if(fwrite($handle,$file)) {
                    return TRUE;
                } else {
                    return FALSE;
                }

        } else {
                return false;
        }
    }

    public function writeDBfile($uname, $pass, $db)
    {
        $this->load->helper('file');
        
        if(file_exists(APPPATH.'modules/install/config/database-bak.php')):
            $template_path 	= APPPATH.'modules/install/config/database-bak.php';
            $output_path 	= APPPATH.'config/database.php';
            $database_file = file_get_contents($template_path);
            
            $new  = str_replace("%HOSTNAME%",'localhost',$database_file);
            $new  = str_replace("%USERNAME%",$uname,$new);
            $new  = str_replace("%PASSWORD%",$pass,$new);
            $new  = str_replace("%DATABASE%",$db,$new);
            
            // Write the new database.php file
            $handle = fopen($output_path,'w+');

            // Chmod the file, in case the user forgot
            @chmod($output_path,0777);

            // Verify file permissions
            if(is_writable($output_path)) {

                    // Write the file
                    if(fwrite($handle,$new)) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }

            } else {
                    return false;
            }

        else: 
            echo 'file not found';
        endif;
        
        //$this->load->view('default');
    }
    
    public function doInstall()
    {
        $dbName = $this->input->post('dbName');
        $uname = $this->input->post('name');
        $pass = $this->input->post('pass');
        $year = $this->input->post('year');
        $data = $this->input->post('data');
        if($this->install_model->create_database($uname,$pass,'eskwela_'.$dbName.'_'.$year)):
            if($this->install_model->create_tables($uname,$pass,'eskwela_'.$dbName.'_'.$year, 'install.sql')):
                if($this->install_model->create_tables($uname,$pass,'eskwela_'.$dbName.'_'.$year, 'finance.sql')):
                    if($this->install_model->create_tables($uname,$pass,'eskwela_'.$dbName.'_'.$year, 'grading_system.sql')):
                        if($this->install_model->create_tables($uname,$pass,'eskwela_'.$dbName.'_'.$year, 'library_management.sql')):
                            if($this->install_model->create_tables($uname,$pass,'eskwela_'.$dbName.'_'.$year, 'profile.sql')):
                                echo json_encode(array('msg'=>'Database Created', 'status' => TRUE));
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        endif;
    }
    
    public function saveInfo()
    {
        $dbName = $this->input->post('dbName');
        $uname = $this->input->post('name');
        $pass = $this->input->post('pass');
        $school_year = $this->input->post('school_year');
        $data = $this->input->post('data');
        $this->load->library('eskwela');
        $dbCon = $this->eskwela->dbInstall($uname, $pass, $dbName, $school_year);
        $dt = json_decode($data);
        foreach ($dt as $d => $key):
            $a[$key->id] = $key->value;
        endforeach;
        $a['school_year'] = $school_year;
        if($this->install_model->insertDetails($dbCon, $a)):
            if($this->writeDBfile($uname, $pass, 'eskwela_'.$dbName.'_'.$school_year)):
                $this->writeConfig('autoload');
                if($this->writeConfig('routes')):
                    echo 'Successfully Installed';
                else:
                    echo 'Something is wrong with routes';
                endif;
            else:
                echo 'Something is wrong with the database file';
            endif;
        else:
            echo 'Something went wrong with the last step';
        endif;
        
       //echo json_encode(array('id'=> $a));
    }

}
 
