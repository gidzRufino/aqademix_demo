<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gradingsystem
 *
 * @author genesis
 */
class new_gs extends MX_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('new_gs_model');
    }
    

    private function post($name)
    {
        return $this->input->post($name);
    }
    
    public function getSHSubjects($component = NULL)
    {
        $this->db->join('subjects','sh_subjects.sh_sub_id  = subjects.subject_id','left');
        $this->db->group_by('sh_sub_id');
        $shSubjects = $this->db->get('sh_subjects')->result();
        $s = 1;
        foreach($shSubjects as $shSub):
        
            $this->db->where('subject_id', $shSub->subject_id);
            $this->db->where('component_id', 3);
            $ww = $this->db->get('gs_asses_category');
            
            if($ww->num_rows()>1):
                echo $s++.': '.$shSub->subject.'( '.$shSub->subject_id.' )'.'<br />';
            endif;
            
            
        endforeach;
    }
    
    public function selectAssessment()
    {
        $value = $this->post('value');
        $result = $this->new_gs_model->selectAssessment($value);
        
    }


    public function getTotalScoreByStudent($student_id = null, $category_id = null, $term = NULL, $subject_id = NULL) 
    {
        $score = $this->new_gs_model->getTotalScoreByStudent($student_id, $category_id, $term, $subject_id);
        return $score;
    }
    
    public function getEachScoreByStudent($student_id = null, $category_id = null, $term = NULL, $subject_id = NULL, $option = NULL, $section_id=NULL) 
    {
        $score = $this->new_gs_model->getEachScoreByStudent($student_id, $category_id, $term, $subject_id, $option, $section_id);
        return $score;
    }
    
    public function getCustomComponentList($sub_id = NULL)
    {
        $custom = $this->new_gs_model->getCustomComponentList($sub_id);
        return $custom;
    }
    
    public function getCustomComponent($sub_id = NULL, $sub_component_id=NULL)
    {
        $custom = $this->new_gs_model->getCustomComponent($sub_id, $sub_component_id);
        return $custom;
    }
    
    public function getSubComponent($id)
    {
        $subCom = $this->new_gs_model->getSubComponent($id);
        return $subCom;
    }
     
    public function componentPerSubject($subject_id, $component_id, $sy=NULL)
    {
        $result = $this->new_gs_model->componentPerSubject($subject_id, $component_id, $sy);
        return $result;
    }
            

    public function getNumericalTransmutation($bs_id, $numberGrade)
    {
        $plg = $this->new_gs_model->getBHTRansmutation($bs_id);
        foreach($plg as $plg){
            if( $numberGrade >= $plg->trans_from && $numberGrade <= $plg->trans_to){
                return $plg;
            }
        }
    }
    
    public function getBHTRansmutation($bs_id, $numberGrade)
    {
        $plg = $this->new_gs_model->getBHTRansmutation($bs_id);
        foreach($plg as $plg){
            if( $numberGrade >= $plg->trans_from && $numberGrade <= $plg->trans_to){
                return $plg->transmutation;
            }
        }
    }
    
    public function sumBHGroup($bhg_id, $st_id, $term, $sy)
    {
        $result = $this->new_gs_model->sumBHGroup($bhg_id, $st_id, $term, $sy);
        return $result;
    }
    
    public function getBHRate($bhg_id, $st_id, $term, $sy)
    {
        $result = $this->new_gs_model->getBHRate($bhg_id, $st_id, $term, $sy);
        return $result;
    }
    
    public function countBHGroup($bhg_id)
    {
        $result = $this->new_gs_model->countBHGroup($bhg_id);
        return $result;
    }
    
    public function getBHRating($st_id, $id, $term, $sy)
    {
        $result = $this->new_gs_model->getBHRating($st_id, $id, $term, $sy);
        return $result;
    }
    public function getFBR()
    {
       $indi_id = $this->post('indi_id');
       $st_id = $this->post('st_id');
       $rate = $this->post('rate');
       $term = $this->post('term');
       $sy = $this->post('sy');
       
       $details = array(
           'indi_id'    => $indi_id,
           'rate'       => $rate,
           'st_id'      => $st_id,
           'term'       => $term,
           'sy'         => $sy
       );
       $result = $this->new_gs_model->getFBR($details, $indi_id, $st_id, $term, $sy);
       $result =json_decode($result);
       if($result->status):
           switch ($result->details):
                case 1:
                    $msg = '<div id="alert-info" style="position:absolute; top:50%; left:45%; z-index:2000;" class="alert alert-success" data-dismiss="alert-message">
                        <h4>Rating was Recorded Successfully!</h4>

                    </div>';
                break;
                case 2:
                    $msg = '<div id="alert-info" style="position:absolute; top:50%; left:45%; z-index:2000;" class="alert alert-success" data-dismiss="alert-message">
                        <h4>Rating was Update Successfully!</h4>

                    </div>';
                    
                break;    
           endswitch;
            echo json_encode(array('status' => TRUE, 'msg' => $msg));  
       endif;
       
      
    }
   
    
    public function editSubjectWeight()
    {
        $subject_id = $this->input->post('subject_id');
        $assessment = $this->input->post('assessment');
        $weight = $this->input->post('weight');
        
        $array = array(
            'weight'  => $weight
        );
        
        if($this->new_gs_model->editSubjectWeight($array, $subject_id, $assessment, $this->session->userdata('school_year'), $weight)):
            echo 'Successfully Updated';
        else:
            echo 'Sorry Something went Wrong';
        endif;
    }
    
    public function editCustomSubjectWeight()
    {
        $subject_id = $this->input->post('subject_id');
        $assessment = $this->input->post('assessment');
        $weight = $this->input->post('weight');
        $inputSubCom = $this->input->post('subCom');
        $PSWeight = $this->input->post('PSweight');
        
        $array = array(
            'component_id'  => $assessment,
            'sub_com_id'    => $inputSubCom,
            'weight'        => $weight,
            'ps_weight'     => $PSWeight,
            'subject_id'    => $subject_id,
            'school_year'   => $this->session->userdata('school_year'),
        );
        
        if($this->new_gs_model->editCustomSubjectWeight($array, $subject_id, $assessment, $inputSubCom, $this->session->userdata('school_year'))):
            echo 'Successfully Updated';
        else:
            echo 'Sorry Something went Wrong';
        endif;
    }
    
    public function addCustomSubjectWeight()
    {
        $subject_id = $this->input->post('subject_id');
        $assessment = $this->input->post('assessment');
        $weight = $this->input->post('weight');
        $inputSubCom = $this->input->post('subCom');
        $PSWeight = $this->input->post('PSweight');
        
        $array = array(
            'component_id'  => $assessment,
            'sub_com_id'    => $inputSubCom,
            'weight'        => $weight,
            'ps_weight'     => $PSWeight,
            'subject_id'    => $subject_id,
            'school_year'   => $this->session->userdata('school_year'),
        );
        
        if($this->new_gs_model->addCustomSubjectWeight($array, $subject_id, $assessment, $inputSubCom, $this->session->userdata('school_year'))):
            echo 'Successfully Added';
        else:
            echo 'Sorry Something went Wrong';
        endif;
    }
    
    public function addSubjectWeight()
    {
        $subject_id = $this->input->post('subject_id');
        $assessment = $this->input->post('assessment');
        $weight = $this->input->post('weight');
        
        $array = array(
            'code'          => $this->eskwela->codeCheck("gs_asses_category", "code", $this->eskwela->code()),
           'component_id'  => $assessment,
            'weight'        => $weight,
            'subject_id'    => $subject_id,
            'school_year'   => $this->session->userdata('school_year'),
        );
        
        if($this->new_gs_model->addSubjectWeight($array, $subject_id, $assessment, $this->session->userdata('school_year'))):
            echo json_encode(array('msg' => 'Assessment Successfully Added'));
        else:
            echo json_encode(array('msg' => 'Sorry! Weights Already Set. Click the Edit button on each subject column instead to edit'));
        endif;
    }

    public function getTransmutation($numberGrade)
    {
        $plg = $this->new_gs_model->getTransmutation();
        foreach($plg as $plg){
            if( $numberGrade >= $plg->from_grade && $numberGrade <= $plg->to_grade){
                return $plg->transmutation;
            }
        }
    }
   

}

