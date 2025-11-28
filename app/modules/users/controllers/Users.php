<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Users extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
       // $this->form_validation->CI =& $this;
        $this->load->model('users_model');
    }
        
    public function post($value){
        return $this->input->post($value);
    }
    
     function checkWhosOnline()
    {
        $userdata = $this->users_model->checkWhosOnline();
        return $userdata;
    }
    
    // Get users
    function getUsers()
    {
        $users= $this->users_model->getUsers();
        return $users;
    }


    //Get the Position of the user in the users_model
    public function getUserType($user_id)
    {
        $position = $this->users_model->getUserType($user_id);
        return $position;
    }
    
    //This function gets the position information details including department info's 
    
    public function getPositionInfo($user_id)
    {
        $position = $this->users_model->getPositionInfo($user_id);
        return $position;
    }
    
    //This function gets the basic information of the users through the users_model.
    
    public function getBasicInfo($user_id)
    {
        $basicInfo = $this->users_model->getBasicInfo($user_id);
        return $basicInfo;
    }
    
    // get the parent Details
    
    public function getParentData($user_id)
    {
        $parentInfo = $this->users_model->getParentInfo($user_id);
        return $parentInfo;
    }
    
    function saveContactDetails()
    {
        $user_id = $this->input->post('user_id');
        $number = $this->input->post('number');
        $processAdmission = Modules::load('registrar/registrardbprocess/');
        $processAdmission->setContacts($number, '', $user_id);
        echo json_encode(array('status' => TRUE, 'msg' =>$number));
    }
    
    function editOccupation() {
        $occupation = $this->post('value');
        $user_id = $this->post('owner');
        $mf = $this->post('mf');
        $sy = $this->input->post('sy');
        $processAdmission = Modules::load('registrar/registrardbprocess/');

        $processAdmission->chooseOcc($occupation, $user_id, $sy, $mf);

        echo $occupation;
    }

    function editProfile()
    {
        $table = $this->input->post('tbl');
        $pk = $this->input->post('pk');
        $id = $this->input->post('id');
        $column = $this->input->post('column');
        $value  = $this->input->post('value');
        $sy = $this->input->post('sy');

        $this->users_model->editUserInfo(base64_decode($pk),base64_decode($table), $id, $column, $value,$sy);
        
        echo json_encode(array('status' => TRUE, 'msg' =>$value));
    }
    
    function editProfileLevel()
    {
        $st_id =$this->input->post('st_id');
        $user_id =$this->input->post('user_id');
        $section_id = $this->input->post('section_id');
        $school_year = $this->input->post('school_year');
        $grade_id = $this->input->post('grade_id');
        $specs = $this->input->post('specs');
        $strand_id = $this->input->post('strand_id');
        
        switch ($grade_id):
            case 10:
            case 11:
                if($specs!=0):
                    $sp = array(
                        'spec_user_id'      => $user_id,
                        'spec_st_id'        => base64_decode($st_id),
                        'spec_taken_id'     => $specs,
                        'spec_school_year'  => $school_year
                    );

                    $saveSpecs = Modules::run('gradingsystem/saveSpecialization',$sp, $user_id, $specs, $school_year);
                    $saveSpecs = json_decode($saveSpecs);
                endif;    
                    $msg = 'Successfully Saved! '.$saveSpecs->msg;
            break;    
            default:
                $msg = 'Successfully Saved!';
            break;
        endswitch;
        
        $profile_level = array(
            'grade_level_id' => $grade_id,
            'section_id'  => $section_id,
            'school_year'  => $school_year,
        );
        
        $this->users_model->editProfileLevel($profile_level, $user_id, $school_year, $section_id);
        
        $this->users_model->editStrand($user_id, $strand_id, $school_year);
        
        $getLevelSection = Modules::run('registrar/getSectionById', $section_id );
        echo json_encode(array('level' => $getLevelSection->level, 'section' =>$getLevelSection->section,'msg'=>$msg));
    }
    
    function saveReligion($religion)
    {
       if($this->users_model->saveReligion(urldecode($religion))){
           $this->getReligion();
       }
    }
    
    public function getReligion()
    {
        $religion = $this->users_model->getReligion();
         foreach ($religion as $r)
          {   
        ?>                        
      <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>

      <?php }
    }
    
    public function updateBasicInfo($pk_value, $pk, $column, $value, $table)
    {
        $this->users_model->editUserInfo($pk, $table, $pk_value, $column, $value);
        return;
    }
    
    
}
 
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */
