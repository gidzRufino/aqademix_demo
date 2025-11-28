<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class vm extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        //$this->load->library('form_validation');
        //$this->form_validation->CI =& $this;
        $this->load->model('vm_model'); 
        $this->load->library('pagination');
    }

	public function index(){
        if(!$this->session->userdata('is_logged_in')){

            ?>
                <script type="text/javascript">
                    document.location = "<?php echo base_url()?>"
                </script>
            <?php
            
        }else{
            $data['news'] = Modules::run('messaging/getAnnouncement', 1);
            $data['vlog'] = $this->vm_model->display_log();
            $data['main_content'] = 'default';
	        $data['modules'] = 'vm';
	        echo Modules::run('vm/vm_template', $data);	
		}
    }
    
    public function status()
    {
        if(!$this->session->userdata('is_logged_in')){

            ?>
                <script type="text/javascript">
                    document.location = "<?php echo base_url()?>"
                </script>
            <?php
            
        }else{

            $data['vid'] = $this->vm_model->vm_get_vid();
            $data['main_content'] = 'vid_status';
            $data['modules'] = 'vm';
            echo Modules::run('vm/vm_template', $data); 

        }
    }

    public function timeline()
    {
        if(!$this->session->userdata('is_logged_in')){

            ?>
                <script type="text/javascript">
                    document.location = "<?php echo base_url()?>"
                </script>
            <?php
            
        }else{

            $data['log'] = $this->vm_model->display_log();
            $data['main_content'] = 'timeline';
            $data['modules'] = 'vm';
            echo Modules::run('vm/vm_template', $data); 

        }
    }

    public function id_status()
    {
        if(!$this->session->userdata('is_logged_in')){

            ?>
                <script type="text/javascript">
                    document.location = "<?php echo base_url()?>"
                </script>
            <?php
            
        }else{

            $vid = $this->uri->segment(3);
            $data['vinfo'] = $this->vm_model->display_log_vid(base64_decode($vid));
            $data['pinfo'] = $this->vm_model->display_vid_profile(base64_decode($vid));
            $data['main_content'] = 'vid_history';
            $data['modules'] = 'vm';
            echo Modules::run('vm/vm_template', $data); 

        }        
    }

    public function vm_status()
    {
        if(!$this->session->userdata('is_logged_in')){

            ?>
                <script type="text/javascript">
                    document.location = "<?php echo base_url()?>"
                </script>
            <?php
            
        }else{

            $vm = $this->uri->segment(3);
            $data['minfo'] = $this->vm_model->display_log_vm(base64_decode($vm));
            $data['pminfo'] = $this->vm_model->display_vm_profile(base64_decode($vm));
            $data['main_content'] = 'vm_history';
            $data['modules'] = 'vm';
            echo Modules::run('vm/vm_template', $data); 

        }        
    }    

    public function vm_template($data)
    {
        $this->load->view('vm_template', $data);
    }

    public function register()
    {
        if(!$this->session->userdata('is_logged_in')){
            ?>
                <script type="text/javascript">
                document.location =  "<?php echo base_url() ?>"
                </script>
            <?php
        }else{
            $data['vm_accounts'] = $this->vm_model->vm_accounts();
            $data['vm_dept'] = $this->vm_model->vm_dept();
            $data['vm_rfid'] = $this->vm_model->vm_get_id();
            $data['main_content'] = 'register';
            $data['modules'] = 'vm';
            echo Modules::run('vm/vm_template', $data);
        }
    }

    public function snap_upload()
    {
        $encoded_data = $this->input->post('pic');
        $binary_data = base64_decode($encoded_data);
        $snap_id = date("ymdHis");
        $file_name = $snap_id;
        $directory = "/images/vm/".$file_name.".jpg";
        $dr = base_url($directory);
        // $parts = explode('/', $dr);
        // $file = array_pop($parts);
        // $dir = '';

        // foreach($parts as $part){
        //     if(!is_dir($dir .= "/$part")){ mkdir($dr);}
        // }
        // file_put_contents("$dr", $binary_data);

        // $myfile = fopen($dr, "w") or die("Unable to open file!");
        // $txt = "John Doe\n";
        // fwrite($myfile, $binary_data);
        $result = file_put_contents($file_name.'.jpg', $binary_data );
        $file = $file_name.'.jpg';

        // print_r($dr."/".$file);
        echo json_encode(array(
        'file'      => $file,
        ));
    }

    public function file_force_contents($dir, $contents){
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        file_put_contents("$dir/$file", $contents);
    }

    public function save_profile()
    {
        // $active_tab = $this->input->post('active_tab');
        $avatar = $this->input->post('avatar_file');
        $sdept = base64_decode($this->input->post('searchdept'));
        $userid = base64_decode($this->input->post('searchvid'));        
        $lname = $this->input->post('lname');
        $fname = $this->input->post('fname');
        $cname = $this->input->post('cname');

        $va_id = $this->vm_model->save_new_profile($lname, $fname, $cname, $sdept, $userid, $avatar);

        $items = array(
            'avatar' => $avatar,
            'status' => $va_id,
        );
        
        $this->vm_model->update_profile($items, $userid);

        $lgdate = date("m/d/y");
        $lgin = date("h:i a");

        $this->vm_model->save_vm_login($userid, $lgdate, $lgin, $sdept, $va_id, $avatar); 
        
    }

    public function update_profile()
    {
        $avatar = $this->input->post('avatar_file');
        $va_id = base64_decode($this->input->post('searchvisitor')); 
        $sdept = base64_decode($this->input->post('searchdept'));
        $userid = base64_decode($this->input->post('searchvid'));   
        
        $items = array(
            'va_dept' => $sdept,
            'va_uid' => $userid,
            'va_avatar' => $avatar,
        );
        
        $item = array(
            'avatar' => $avatar,
            'status' => $va_id,
        );
        
        $this->vm_model->update_v_profile($items, $va_id);
        $this->vm_model->update_profile($item, $userid);

        $lgdate = date("m/d/y");
        $lgin = date("h:i a");

        $this->vm_model->save_vm_login($userid, $lgdate, $lgin, $sdept, $va_id, $avatar); 
    }

    public function logout_profile()
    {
        $userid = $this->input->post('user_id');
        $logid = $this->input->post('log_id');
        $vmid = $this->input->post('vm_id');

        $user = array(
            'avatar' => "",
            'status' => "",
        );

        $tnow = date("h:i a");
        $log = array(
            'log_out' => $tnow,
        );

        $dnow = date("m/d/y");
        $vm = array(
            'va_last_visit' => $dnow,
            'va_uid' => "",

        );

        $this->vm_model->update_profile_logout($user, $userid);
        $this->vm_model->update_log_logout($log, $logid);
        $this->vm_model->update_vm_logout($vm, $vmid);

    }


}