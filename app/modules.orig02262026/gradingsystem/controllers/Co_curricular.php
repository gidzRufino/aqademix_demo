<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of co_curricular
 *
 * @author genesis
 */
class co_curricular extends MX_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('cc_model');
    }    
        function saveCoCurricular()
    {
        $st_id = $string = preg_replace('/\s/', '', $this->input->post('st_id'));
        for($i=1;$i<=4;$i++):
            $array = array(
                'st_id' => $st_id,
                'rate' => $this->input->post('cc_'.$i),
                'grading' => $i,
                'school_year' => $this->input->post('school_year')
            );
        
            $this->cc_model->saveCoCurricular($array, $st_id, $i, $this->input->post('school_year'));
        endfor;
    }

    function extra($data, $student_id)
    {
        
        $data['term'] = $data;
        $data['st_id'] = $student_id;
        $this->load->view('co_curricular/extra', $data);
    }
    
        function getCoCurricular($student_id, $term)
    {
        $cc = $this->cc_model->getCoCurricular($student_id, $term);
        return $cc;
    }
    
    function main($section_id = NULL)
    {
        $data['students'] = Modules::run('gradingsystem/gs_tops/getFinalTops', $section_id, $this->session->userdata('school_year'));
        $data['gradeLevel'] = Modules::run('registrar/getGradeLevel');
        $data['modules'] = "gradingsystem";
        $data['main_content'] = 'co_curricular/default';
        echo Modules::run('templates/main_content', $data);
    }
    
    function getRanking($grade_id)
    {
        $data['names'] = $this->cc_model->groupNames($grade_id);
        $this->load->view('co_curricular/ranking', $data);
    }
    
    function getCCRaw($id)
    {
        $array = array(
            'cc' => $this->cc_model->getCCRaw($id, 1),
            'sl' => $this->cc_model->getCCRaw($id, 2),
            'cj' => $this->cc_model->getCCRaw($id, 3),
            'om' => $this->cc_model->getCCRaw($id, 4),
            'pa' => $this->cc_model->getCCRaw($id, 5)
        );
        
        return json_encode($array);
        
        
    }
    
    function saveTotalCC($st_id, $total, $grade_id)
    {
        $rank = $this->cc_model->saveTotalCC($st_id, $total, $grade_id);
        return $rank;
    }
    
    function getIndividualRank($st_id, $school_year)
    {
        $rank = $this->cc_model->getIndividualRank($st_id, $school_year);
        return $rank;
    }

    function getCC($id = Null)
    {
        $data['id'] = $id;
        $data['cc'] = $this->cc_model->getCC_involvement(base64_decode($id), 1);
        $data['sl'] = $this->cc_model->getCC_involvement(base64_decode($id), 2);
        $data['cj'] = $this->cc_model->getCC_involvement(base64_decode($id), 3);
        $data['om'] = $this->cc_model->getCC_involvement(base64_decode($id), 4);
        $data['pa'] = $this->cc_model->getCC_involvement(base64_decode($id), 5);
        $this->load->view('co_curricular/data', $data);
    }
    
    function getCC_cat($id)
    {
        $cc_cat = $this->cc_model->getCC_cat();
        return $cc_cat;
    }
    
    function getCC_level($id)
    {
        $cc_level = $this->cc_model->getCC_level($id);
        return $cc_level;
    }
    
    function getRank()
    {
        $cat_id = $this->input->post('cat_id');
        $part_pos = $this->input->post('part_pos');
        $rank = $this->cc_model->getRank($cat_id, $part_pos);
        ?>
            <option value="0">[Select Here]</option> 
          <?php
          foreach($rank as $r){  
        ?>                        
              <option value="<?php echo $r->part_id; ?>"><?php echo $r->rank; ?></option>
      <?php

              } 
    }
    
    function getCCInvolvementById($id)
    {
        $cc = $this->cc_model->getCCInvolvementById($id);
        
        $json = array(
            'part_pos' => $cc->part_pos,
            'rank' => $cc->rank,
            'date' => $cc->date_event,
            'name_event' => $cc->event_name
        );
        echo json_encode($json);
    }
    
    function saveCCParticipation()
    {
        $part_id = $this->input->post('part_id');
        $st_id = $this->input->post('st_id'); 
        $event_date= $this->input->post('event_date'); 
        $event_name= $this->input->post('event_name'); 
        $term= $this->input->post('term');
        $exist = $this->input->post('cc_id');
        if($exist!=""):
            $details = array(
                'st_id' => base64_decode($st_id),
                'cc_level_part_id' => $part_id,
                'event_name' => $event_name,
                'date_event' => $event_date,
                'term' => $term,
                'school_year' => $this->session->userdata('school_year'),
            );
            
            $this->cc_model->updateCCParticipation($exist, $details);
            echo 'Successfully Updated';
        else:
            $details = array(
                'st_id' => base64_decode($st_id),
                'cc_level_part_id' => $part_id,
                'event_name' => $event_name,
                'date_event' => $event_date,
                'term' => $term,
                'school_year' => $this->session->userdata('school_year'),
            );

            $this->cc_model->saveCCParticipation($details);
            echo 'Successfully Saved';
        endif;
        
        
        return;
    }
    
    function deleteCCParticipation($id)
    {
        $this->cc_model->deleteCCParticipation($id);
        echo 'Successfully Deleted';
    }
}

?>
