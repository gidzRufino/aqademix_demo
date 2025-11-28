<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gs_tops
 *
 * @author genesis
 */
class gs_tops extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->model('gs_tops_model');
    }
    
    function getTopTenByGradeLevel($section_id, $grade_id, $grading, $school_year)
    {
    $honors='';
        switch ($grading) {
            case 1:
                $term = 'first';
                break;
            case 2:
                $term = 'second';
                break;
            case 3:
                $term = 'third';
                break;
            case 4:
                $term = 'fourth';
                break;
        }
        
        $topTen = $this->gs_tops_model->getTopTenByGradeLevel($grade_id, $term, $school_year, $section_id);
        $x = 1;
        foreach ($topTen->result() as $tt):
           // echo $tt->total.'<br />';
          if($this->checkGradeIfBelowEighty($tt->s_id, $grading, $grade_id)>0):
              
          else:
            $honors[] = $tt;
         //echo $x++.')  '.$tt->lastname.' ';
          endif;
          
        endforeach;
        //print_r($honors);
        return $honors;
        
    }
    
    function checkGradeIfBelowEighty($st_id, $term, $grade_id)
    {
       // echo $st_id.'<br />';
        $finalRating=0;
        $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $grade_id);    
        //$subject = explode(',', $subject_ids->subject_id);
        //print_r($subject_ids);
        $y=0;
        foreach($subject_ids as $s){  
                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                $ifHasBelowEighty = $this->gs_tops_model->checkGrades($st_id, $singleSub->subject_id, $term);

                if($ifHasBelowEighty->final_rating < 80):

                    $y++;
                else:
                   $finalRating += $ifHasBelowEighty->final_rating;
                endif;
                        
        }
       // print_r($y);
        return $y;
    }
    
    function getTopTenPerSubject($level, $subject, $grading, $school_year)
    {
        switch ($grading) {
            case 1:
                $term = 'first';
                break;
            case 2:
                $term = 'second';
                break;
            case 3:
                $term = 'third';
                break;
            case 4:
                $term = 'fourth';
                break;
        }
        $getTops = $this->gs_tops_model->getTopTenPerSubject($level, $subject, $term, $school_year);
        foreach ($getTops->result() as $tt):
          $topTen[] = $tt;
        endforeach;
        return $topTen;
    }
    
    
    public function getFinalTopTen($grade_id, $school_year)
    {
        $data['section_id'] = $grade_id;
        $data['finalTops']=$this->gs_tops_model->getFinalTopTen($grade_id, $school_year);
        $this->load->view('topTen', $data);
    }
    
    public function getFinalTops($grade_id, $school_year)
    {
        $finalTops=$this->gs_tops_model->getFinalTopTen($grade_id, $school_year);
        return $finalTops;
    }
    
    function saveFinalRank($st_id, $total, $grade_id, $school_year)
    {
        $rank = $this->gs_tops_model->saveFinalRank($st_id, $total, $grade_id, $school_year);
        return $rank;
    }
    
}
