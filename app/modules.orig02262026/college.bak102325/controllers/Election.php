<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chat_system
 *
 * @author genesis
 */
class Election extends MX_Controller {
    //put your code here
    //Global variable  
    
   public function __construct() {
        parent::__construct();
        $this->load->model('election_model');
        //$this->load->library('pagination');
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }

    public function index()
    {
        
            $data['candidate_position'] = $this->election_model->getCandidatePosition();
            $data['modules'] = 'college';
            $data['main_content'] = 'election/default';
            echo Modules::run('templates/college_content', $data);
    }
    
    public function getElectionSettings()
    {
        $settings = $this->election_model->getElectionSettings();
        return $settings;
    }
    
    public function openResult($value)
    {
        $this->election_model->openResult($value);
        return;
    }
    
    public function closeElection($value)
    {
        $this->election_model->closeElection($value);
        return;
    }
    
    public function electionBody()
    {
        $data['candidate_position'] = $this->election_model->getCandidatePosition();
        $data['settings'] = Modules::run('main/getSet');
        $data['electionSettings'] = $this->getElectionSettings();
        $this->load->view('election/electionBody', $data);
    }
    
    public function liveElectionResult()
    { 
        $data['candidate_position'] = $this->election_model->getCandidatePosition();
        $data['settings'] = Modules::run('main/getSet');
        $this->load->view('election/guessWho', $data);
    }
    
    public function getLiveElectionResult()
    {
        $data['candidate_position'] = $this->election_model->getCandidatePosition();
        $this->load->view('election/liveElectionResult', $data);
    }
    
    public function getVotes($pos_id, $can_id=NULL)
    {
        $votes = $this->election_model->getVotes($pos_id, $can_id);
        return $votes;
    }
    
    public function login($user_id)
    {
        $student = json_decode($this->election_model->isRegistered($user_id));
        if($student->status):
            $data = array(
                    'isVoterLoggedIn'  => TRUE,
                    'votersID'         => $user_id
            );
            $this->session->set_userdata($data);
            echo json_encode(array('msg' => 'Welcome to Pilgrim Election Management System'));
        else:
            echo json_encode(array('msg' => $student->msg));
        endif;
    }
    
    public function castVotes()
    {
        $position = $this->election_model->getCandidatePosition();
        $basicInfo = $this->getBasicInfoBySTID($this->session->userdata('votersID'));
        foreach ($position as $p):
            $details = array(
                'v_pos_id'      => $p->pos_id,
                'v_can_id'      => $this->post($p->pos_id), 
                'v_voters_id'   => $basicInfo->user_id
            );
        
           
           ($this->post($p->pos_id)!=0?$this->election_model->castVotes($details):''); 
        endforeach;
        //$this->election->model->castVotes($details);
        $this->election_model->updateVoterStatus($this->session->userdata('votersID'));
        $this->election_model->updateTotalVotes();    
        
        $this->session->sess_destroy();
        return TRUE;
        //print_r($details);
    }


    public function registerVoter()
    {
        $id = $this->post('value');
        $basicInfo = Modules::run('college/getBasicInfo', $id);
        
        $details = array(
            'rv_rfid'   => $basicInfo->rfid,
            'rv_st_id'  => $basicInfo->st_id
        );
        $reg = json_decode($this->election_model->registerVoter($details, $basicInfo->st_id));
        echo json_encode(array('msg' => $reg->msg));
    }


    public function removeCandidate($can_id)
    {
        if($this->election_model->removeCandidate($can_id)):
            echo json_encode(array('status' => TRUE));
        else:
            echo json_encode(array('status' => FALSE));
            
        endif;
    }
    
    public function getCandidateList($pos_id)
    {
        $candidates = $this->election_model->getCandidateList($pos_id);
        return $candidates;
    }
    
    function getBasicInfoBySTID($user_id)
    {
        $student = $this->election_model->getBasicInfoBySTID($user_id);
        return $student;
    }
    
    public function addCandidate()
    {
        $user_id = $this->post('user_id');
        $position_id = $this->post('position_id');
        $basicInfo = Modules::run('college/getBasicInfo', $user_id);
        
        $details = array(
            'ec_rfid'       => $basicInfo->rfid,
            'ec_st_id'      => $basicInfo->st_id,
            'ec_pos_id'     => $position_id
        );
        
        if($this->election_model->addCandidate($details, $basicInfo->st_id)):
            echo json_encode(array('msg' => 'Successfully Added'));
        else:
            echo json_encode(array('msg' => 'Sorry this student already exist'));
        endif;
    }
    
    public function admin()
    {
        if($this->session->userdata('is_logged_in')):
            $data['electionSettings'] = $this->getElectionSettings();
            $data['candidate_position'] = $this->election_model->getCandidatePosition();
            $data['modules'] = 'college';
            $data['main_content'] = 'election/admin';
            echo Modules::run('templates/college_content', $data);
        else:
            die('ACCESS DENIED');
        endif;
    }
    
    public function electionResult()
    {
        if($this->session->userdata('is_logged_in')):
            $data['candidate_position'] = $this->election_model->getCandidatePosition();
            $data['modules'] = 'college';
            $data['main_content'] = 'election/electionResult';
            echo Modules::run('templates/college_content', $data);
        else:
            die('ACCESS DENIED');
        endif;
    }
    
        
    function scanStudent()
    {
        $value = $this->input->post('value');
        $isRegistered = json_decode($this->election_model->checkIfVoted($value));
        $student = $this->election_model->scanStudent($value);
        
          
            switch ($student->year_level):
                case 1:
                    $year = 'First Year';
                break;
                case 2:
                    $year = 'Second Year';
                break;
                case 3:
                    $year = 'Third Year';
                break;
                case 4:
                    $year = 'Fourth Year';
                break;
                case 5:
                    $year = 'Fifth Year';
                break;
            endswitch;
        if(!$isRegistered->status):
            
            echo json_encode(array(
                'lastname' => $student->lastname, 
                'firstname' => $student->firstname, 
                'avatar' => $student->avatar, 
                'user_id' => $student->user_id,
                'course'    => $student->course,
                'year'      => $year,
                'status'    => TRUE
            ));
        else:    
            echo json_encode(array(
                'lastname' => $student->lastname, 
                'firstname' => $student->firstname, 
                'avatar' => $student->avatar, 
                'user_id' => $student->user_id,
                'course'    => $student->course,
                'year'      => $year,
                'status'    => FALSE,
                'msg'       => $isRegistered->msg
            ));
        endif;
        
            
    }
    
    function searchStudent()
    {
        $value = $this->input->post('value');
        $student = $this->election_model->searchStudent($value);
        ?>
        <ul>
          <?php
          foreach($student as $s):
              switch ($s->year_level):
                case 1:
                    $year = 'First Year';
                break;
                case 2:
                    $year = 'Second Year';
                break;
                case 3:
                    $year = 'Third Year';
                break;
                case 4:
                    $year = 'Fourth Year';
                break;
                case 5:
                    $year = 'Fifth Year';
                break;
              endswitch;
          $name = strtoupper($s->firstname.' '.$s->lastname);
          ?>
          <li onclick='$("#userId").val("<?php echo $s->user_id ?>"),$("#inputStudent").val(this.innerHTML),$("#name").html(this.innerHTML),
                   $("#profile").show(), $("#course").html("<?php echo $s->course ?>"), $("#year_level").html("<?php echo $year ?>")
                   $("#profileImage").attr("src","<?php echo base_url().'uploads/'.$s->avatar ?>"), $("#studentSearch").hide(), $("#searchControls").hide()'><?php echo $name ?></li>
          <?php  
          endforeach;
          ?>
          </ul>
        <?php    
    }
    

}
