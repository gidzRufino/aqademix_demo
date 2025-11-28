<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Gradingsystem_api extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('api_model');
        $this->load->model('profile_model');
    }
    
    function getSubjects($id)
    {
        $student = json_decode(Modules::run('api/getDetails', $id));
        //print_r($student);
        $subjects = Modules::run('academic/getSpecificSubjectPerlevel',$student->student->grade_id );
        
        echo json_encode(array(
            'subjects' => $subjects
        ));
    }
}
 
