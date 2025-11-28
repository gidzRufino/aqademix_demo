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
class Qm extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('qm_model');
    	
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function getSkills($qq_id)
    {
        $tags = $this->qm_model->getSkills($qq_id);
        return $tags;
    }
    
    function saveSkills()
    {
        $skill = $this->input->post('skills');
        $q_id = $this->input->post('q_id');
        
            $details = array(
                    'qq_skills'   => $skill,     
            );
            $this->qm_model->saveSkills($q_id, $details);
    }
    
    function getTags($qq_id)
    {
        $tags = $this->qm_model->getTags($qq_id);
        return $tags;
    }
    
    function saveTags()
    {
        $tags = $this->input->post('tags');
        $q_id = $this->input->post('q_id');
        $subs = explode(',', $tags);
        foreach ($subs as $cat)
        {
            $data = array(
                'qm_category' => ucfirst($cat)
            );
            $this->qm_model->saveCategory($cat, $data);
        }
        
            $details = array(
                    'qci_qq_id'   =>$q_id,      
                    'qci_qc_tags' => $tags
            );
            $this->qm_model->saveTags($q_id, $details);
    }
    
    function getAccessLevel($user_id=NULL)
    {
        $accessLevel = $this->qm_model->getAccessLevel($user_id);
        return $accessLevel;
    }
    
    function getAllQuestions($qcat=NULL)
    {
        $questions = $this->qm_model->getAllQuestions($qcat);
        return $questions;
    }
    
    function questionsBank()
    {
        $data['accessLevel'] = $this->getAccessLevel($this->session->userdata('employee_id'));
        $data['skill'] = $this->qm_model->getSkillsList();
        $data['quiz_cat'] = $this->qm_model->getQuizCat();
        $data['questions'] = $this->getAllQuestions();
        $data['modules'] = 'qm';
        $data['main_content'] = 'questionsBank';
        echo Modules::run('templates/main_content', $data);
    }
    
    function publishQuiz()
    {
        $qi = $this->post('qi');
        $final = array('qi_is_final' => 1);
        $this->qm_model->publishQuiz($final, $qi);
        return;
    }
    
    function addQuestions()
    {
        $choices = $this->post('choices');
        $qq = $this->post('qq');
        $ans = $this->post('ans');
        $qt = $this->post('qt');
        $qi = $this->post('qi');
        
        $qqArray = array(
            'question'      => $qq,
            'qq_qt_id'      => $qt,
            'created_by'    => $this->session->userdata('employee_id')
        );
        
        $qq_id = $this->qm_model->addQuestions($qqArray);
        
        $status = json_decode($this->qm_model->checkQI($qi));
        if($status->exist):
            if($status->qq_ids==''):
                $qq_ids = array('qi_qq_ids'=>$qq_id);
                $this->qm_model->updateQuizItems($qi, $qq_ids);
            else:
                $currentValue = $status->qq_ids.','.$qq_id;
                $sorValue = explode(',', $currentValue);
                $arrayUnique = array_unique($sorValue);
                sort($arrayUnique);
                $arval = implode(',', $arrayUnique);
                $array = array(
                    'qi_qq_ids' => $arval, 
                );
                
                $this->qm_model->updateQuizItems($qi, $array);
            endif;
        endif;
        
        if($qt==2):
            $choiceItems = explode(',', $choices);
            foreach($choiceItems as $ch=>$item):
                $letter = chr(65+$ch);
                $choice = array('qs_qq_id'=>$qq_id, 'qs_selection'=>strtolower($letter),'qs_choice'=>$item,'ans_flag'=>0);
                $this->qm_model->saveAnswer($choice);
            endforeach;
        endif;
        
        $answer = array('qs_qq_id'=>$qq_id, 'qs_selection'=>$ans,'ans_flag'=>1);
        $this->qm_model->saveAnswer($answer);
        return;    
        
    }
    
    function saveAnswers()
    {
        $wrongAnswers = array();
        $checkAnswers = array();
        $score = 0;
        $ans = $this->post('answer');
        $ans2 = json_decode(html_entity_decode($ans));
        foreach ($ans2 as $pj => $key):
            $check = $this->qm_model->checkAnswer($key->id, $key->ans);
            $check = json_decode($check);
            if($check->result):
                $score++;
                $checkAnswers[] = $check->id;
            else:
                $wrongAnswers[] = $check->id;
            endif;
        endforeach;
            echo json_encode(array('check'=> $checkAnswers, 'wrong'=>$wrongAnswers, 'score'=>$score)) ;
        
    }
            
    function getQuizAnswer($qq_id, $flag)
    {
        $ans = $this->qm_model->getQuizAnswer($qq_id, $flag);
        return $ans;
    }
    
    function getQuizQuestions($qq_id)
    {
        $questions = $this->qm_model->getQuizQuestions($qq_id);
        return $questions;
    }
    
    function createItems($item_id = NULL)
    {
        $quiz['quiz_type'] = $this->qm_model->getQuizType();
        $quiz['grade'] = Modules::run('registrar/getGradeLevel');
        $quiz['quiz_cat'] = $this->qm_model->getQuizCat();
        $quiz['quiz_item'] = $this->qm_model->getQuizItem($this->session->userdata('user_id'));
        $quiz['qdata'] = $this->qm_model->getSpecificQuiz($item_id);
        $quiz['subjects'] = Modules::run('academic/getSubjects');
        $quiz['modules'] = 'qm';
        $quiz['main_content'] = 'items';
        echo Modules::run('templates/main_content', $quiz);
    }
    
    function getQuizList($id, $option=NULL)
    {
        $list = $this->qm_model->getQuizList($id, $option);
        return $list;
    }
    
    function saveQuizItem()
    {
        $qc_id = $this->post('category');
        $subject = $this->post('subject');
        $qci_array = array(
            'qci_qc_id'     => $qc_id,
            'qci_sub_id'    => $subject
        );
        $qi_qci_id = $this->qm_model->saveQCI($qci_array);
        $qi_array = array(
            'qi_qci_id'         => $qi_qci_id,
            'qi_title'          => $this->post('qi_title'),
            'qi_qq_ids'         => '',
            'qi_section_id'     => $this->post('section'),
            'qi_date_created'   => date('Y-m-d'),
            'qi_created_by'     => $this->session->userdata('user_id'),
            'qi_date_activation'=> $this->post('dateOfExam')
        );
        
        $success = $this->qm_model->saveQuizItem($qi_array);
        if($success):
            echo json_encode(array('msg' => 'Successfully Saved'));
        else:
            echo json_encode(array('msg' => 'Sorry, Something went wrong'));
        endif;
        
        
    }
    
    function saveCategory()
    {
        $cat = $this->post('quizCat');
        $data = array(
            'qm_category' => $cat
        );
        $result = $this->qm_model->saveCategory($cat, $data);
        echo json_encode(array('category'=> $cat, 'cat_id'=>$result));
    }
    
    function index()
    {
        $data['modules'] = 'qm';
        $data['main_content'] = 'admin';
        echo Modules::run('templates/main_content', $data);
    }
    
    function create()
    {   
        $data['questions'] = $this->getAllQuestions();
        $data['quiz_item'] = $this->qm_model->getQuizItem($this->session->userdata('user_id'));
        $data['quiz_cat'] = $this->qm_model->getQuizCat();
        $data['subjects'] = Modules::run('academic/getSubjects');
        $data['quiz_type'] = $this->qm_model->getQuizType();
        $data['modules'] = 'qm';
        $data['main_content'] = 'create';
        echo Modules::run('templates/main_content', $data);
        
    }
    
    function assessmentList()
    {
        $data['list'] = $this->getQuizList($this->session->userdata('user_id'));
        $data['grade'] = Modules::run('registrar/getGradeLevel');
        $data['quiz_item'] = $this->qm_model->getQuizItem($this->session->userdata('user_id'));
        $data['quiz_cat'] = $this->qm_model->getQuizCat();
        $data['subjects'] = Modules::run('academic/getSubjects');
        $data['quiz_type'] = $this->qm_model->getQuizType();
        $data['modules'] = 'qm';
        $data['main_content'] = 'default';
        echo Modules::run('templates/main_content', $data);
        
    }
   
    
}
