<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of lesson log
 *
 * @author genesis
 */
class Daily_lesson_log extends MX_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('daily_lesson_log_model');
    }
    
    function getDllSections()
    {
        $sections = $this->daily_lesson_log_model->getDllSections();
        return $sections;
    }
    
    function checkAssessmentResult($assess_id=NULL)
    {
        $rawScore = Modules::run('gradingsystem/getRawScore',NULL,$assess_id);
        //print_r($rawScore->result());
        foreach ($rawScore->result() as $assess):
            $flg = Modules::run('gradingsystem/getDescriptor', $assess->assess_id, $assess->raw_score);
            switch($flg):
                case 'O':
                    $ml += 1;
                break;    
                case 'VS': 
                    $ml += 1;
                break;    
                case 'S':
                    $ml += 1;
                break;
                case 'FS':
                    $ml += 1;
                break;  
                case 'F':
                    $nr += 1;
                break;    
            endswitch;
        endforeach;    
            
        $result = array(
                'ml'    => $ml,
                'nr'    => $nr,
            );
            
         return json_encode($result);
       
    }
            
    function getDllRemarks($dll_id)
    {
        $q = $this->daily_lesson_log_model->getDllRemarks($dll_id);
        return $q;
    }
    
    function updateDllRemarks($a, $p, $ap, $d, $b, $total, $dll_id)
    {
        $this->daily_lesson_log_model->updateDllRemarks($a, $p, $ap, $d, $b, $total, $dll_id);
        return;
    }
    
    function updateDll($dll_id, $details)
    {
        $this->daily_lesson_log_model->updateDll($dll_id, $details);
        return;
    }
    
    function deleteItem($item, $id)
    {
        $this->daily_lesson_log_model->deleteItem($item, $id);
        return;
    }
    
    function getActivities($dll_id)
    {
        $mat = $this->daily_lesson_log_model->getActivities($dll_id);
        return $mat;
    }
    
    function getAllDLL($t_id = NULL, $from=NULL, $to=NULL)
    {
//        if($from==NULL):
//            //$from = date("Y-m-d", strtotime('monday this week'));
//            $first = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), $this->session->userdata('school_year'), 'first');
//            $from = date('Y').'-'.date('m').'-'.$first;
//            $to   = date("Y-m-d", strtotime('friday this week'));
//        endif;
        
        $dll = $this->daily_lesson_log_model->getDLL($t_id, $from, $to);
        
        return $dll;
    }
    
    function checkDLL($id)
    {
        $dll = $this->daily_lesson_log_model->checkDLL($id);
        //Modules::run('notification_system/sendNotification',1, 3, $dll->t_id, 'Principal - High School' , 'submitted a DLL.', date('Y-m-d'), base_url().'daily_lesson_log/getDLL/'.base64_encode($dll->t_id));
    }
    
    function submitDLL($id)
    {
        $dll = $this->daily_lesson_log_model->getDLLbyID($id);
        Modules::run('notification_system/sendNotification',1, 3, $dll->t_id, 'Principal - High School' , 'submitted a DLL.', date('Y-m-d'), base_url().'daily_lesson_log/getDLL/'.base64_encode($dll->t_id));
        Modules::run('notification_system/sendNotification',1, 3, $dll->t_id, 'Admin' , 'submitted a DLL.', date('Y-m-d'), base_url().'daily_lesson_log/getDLL/'.base64_encode($dll->t_id));
    }
    
    function getReferences($dll_id)
    {
        $mat = $this->daily_lesson_log_model->getReferences($dll_id);
        return $mat;
    }
    
    function getMaterialUsed($dll_id)
    {
        $mat = $this->daily_lesson_log_model->getMaterialUsed($dll_id);
        return $mat;
    }
    
    function getDLL($t_id=NULL, $from = NULL, $to = NULL)
    {
        
        if($from==NULL):
            //$from = date("Y-m-d", strtotime('monday this week'));
            $first = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), $this->session->userdata('school_year'), 'first');
            $from = date('Y').'-'.date('m').'-'.$first;
            $to   = date("Y-m-d", strtotime('friday this week'));
        endif;
        
        $data['refMat'] = $this->getRefMat();
        $data['lessons'] = $this->daily_lesson_log_model->getDLL(base64_decode($t_id), $from, $to);
        $data['modules'] = "daily_lesson_log";
        $data['main_content'] = 'lessonList';
        echo Modules::run('templates/main_content', $data);
    }
    
    function saveDLL()
    {
        $dll_details = array(
            't_id'              => $this->session->userdata('employee_id'),
            'dll_sub_id'        => $this->input->post('subject_id'),
            'dll_grade_id'      => $this->input->post('grade_id'),
            'dll_section_id'    => $this->input->post('section_id'),
            'dll_date'          => $this->input->post('dll_date'),
            'dll_submitted'     => '',
            'school_year'       => $this->session->userdata('school_year'),
        );
        
        $dll_id = $this->daily_lesson_log_model->saveDLL($dll_details);
        
        $lesson_details = array(
            'lesson'   => $this->input->post('title'),
            'less_dll_id'   => $dll_id
        );
        
        $this->daily_lesson_log_model->saveLesson($lesson_details);
        
        echo json_encode(array('dll_id' => $dll_id));
    }
    
    function addMaterial($ref, $page_num, $dll_id)
    {
        $details = array(
            'mat_type_id' => $ref,
            'page_num'      => urldecode($page_num),
            'mat_dll_id'      => $dll_id,
        );
        
        $result = $this->daily_lesson_log_model->saveMaterial($details);
        
        echo '<li>'.$result->ref_mat.'</li>';
        
    }
    
    function addReference($ref, $page_num, $dll_id)
    {
        $details = array(
            'ref_type_id' => $ref,
            'page_num'      => urldecode($page_num),
            'ref_dll_id'      => $dll_id,
        );
        
        $result = $this->daily_lesson_log_model->saveReference($details);
        
        echo '<li>'.$result->ref_mat.'</li>';
    }
    
    function addActivities($page_num, $dll_id)
    {
        $details = array(
            'activity'      => urldecode($page_num),
            'act_dll_id'      => $dll_id,
        );
        
        $result = $this->daily_lesson_log_model->saveActivities($details);
        
        echo '<li>'.$result->ref_mat.'</li>';
    }
    
    function saveComment($dll_id)
    {
        $details = array(
            'comments'      => $this->input->post('data'),
            'com_dll_id'      => $dll_id,
        );
        
        $result = $this->daily_lesson_log_model->saveComment($details, $dll_id);
        
    }
    
    function getComments($dll_id)
    {
        $comments = $this->daily_lesson_log_model->getComments($dll_id);
        return $comments;
    }
    
    function getRefMat()
    {
        $ref = $this->daily_lesson_log_model->getRefMat();
        return $ref;
    }
    
    function index($from, $to)
    {
        if($from==NULL):
            //$from = date("Y-m-d", strtotime('monday this week'));
            $first = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), $this->session->userdata('school_year'), 'first');
            $from = date('Y').'-'.date('m').'-'.$first;
            $to   = date("Y-m-d", strtotime('friday this week'));
        endif;
        
        $data['submitted'] = $this->daily_lesson_log_model->submittedDLL($from, $to);
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['modules'] = "daily_lesson_log";
        $data['main_content'] = 'default';
        echo Modules::run('templates/main_content', $data);
    }
    function create()
    {
        $settings = Modules::run('main/getSet');
        $user_id = $this->session->userdata('username');
        $data['sections'] = $this->getDllSections();
        $data['refMat'] = $this->getRefMat();
        $data['getSubject'] = Modules::run('academic/mySubject', $user_id, $this->session->userdata('school_year'));
        if(!file_exists(APPPATH.'/modules/daily_lesson_log/views/'.strtolower($settings->short_name).'_create.php')):
            $data['main_content'] = 'create';
        else:
            $data['main_content'] = strtolower($settings->short_name).'_create';
        endif;
        $data['modules'] = "daily_lesson_log";
        echo Modules::run('templates/main_content', $data);
    }
}
