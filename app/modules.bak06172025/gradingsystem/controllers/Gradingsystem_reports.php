<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gradingsystem reports
 *
 * @author genesis
 */
class gradingsystem_reports extends MX_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('gradingsystem_model');
    }

function getFinalBHRate($stid,$bhid,$term,$sy){
        $result = $this->gradingsystem_model->getFinalBHRate($stid,$bhid,$term,$sy);
        return $result;
    }

    public function bhTransmutted($details) {
        switch (TRUE):
            case ($details == 100):
                $deportment = 'A+';
                break;
            case ($details >= 98 && $details <= 99.9):
                $deportment = 'A';
                break;
            case ($details >= 95 && $details <= 97.9):
                $deportment = 'A-';
                break;
            case ($details >= 92 && $details <= 94.9):
                $deportment = 'B+';
                break;
            case ($details >= 89 && $details <= 91.9):
                $deportment = 'B';
                break;
            case ($details >= 86 && $details <= 88.9):
                $deportment = 'B-';
                break;
            case ($details >= 83 && $details <= 85.9):
                $deportment = 'C+';
                break;
            case ($details >= 80 && $details <= 82.9):
                $deportment = 'C';
                break;
            case ($details >= 77 && $details <= 79.9):
                $deportment = 'C-';
                break;
            case ($details >= 75 && $details <= 76.9):
                $deportment = 'D+';
                break;
            case ($details >= 72 && $details <= 74.9):
                $deportment = 'D';
                break;
            case ($details>=70 && $details<=71.9):
                $deportment = 'D-';
            break;
        endswitch;
        return $deportment;
    }

function saveBHRate(){
        $stid = $this->input->post('studentID');
        $rate = $this->input->post('rate');
        $bhID = $this->input->post('bhid');
        $term = $this->input->post('term');
        $sy = $this->input->post('sy');
        
        $result = $this->gradingsystem_model->saveBHRate($stid,$rate,$bhID,$term,$sy);
        if($result){
            echo 'Successfuly Updated';
        }
    }
    
    public function viewAssessmentPerSection($section_id=NULL, $term=NULL, $school_year = NULL)
    {
        $data['school_year'] = ($school_year!=NULL?$school_year:$this->session->school_year);
        $data['sections'] = Modules::run('registrar/getAllSection');
        $data['section_id'] = $section_id;
        $data['male'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section_id, 'Male', "1", $school_year);
        $data['female'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section_id, 'Female', "1", $school_year);
        $data['modules'] = "gradingsystem";
        $data['main_content'] = 'gs_monitoring';
        echo Modules::run('templates/main_content', $data);
    }
    
    public function viewAssessments($s, $category, $term, $singleSub)
    {
        $final = 0;
        
        foreach($category as $cat => $k):
            $record = Modules::run('gradingsystem/getTotalScoreByStudent', $s->st_id, $k->code, $term , $singleSub->subject_id);
            $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $s->st_id, $k->code, $term, $singleSub->subject_id, 1, $s->section_id);
           if($numberOfAssessment->num_rows()>0){
              $record = $record->row()->score;
              $tps = $numberOfAssessment->row()->TPS;
              if($tps!=0):
                $ps = (($record/$tps)*100);
                $ws = round(($ps*$k->weight), 2);
                else:
                    $ws = 0;
                endif;
                
            }else{
                $ws = 0;
            }
            $final += $ws;
          endforeach;
          $plg = Modules::run('gradingsystem/new_gs/getTransmutation', round($final, 2));
          
          //testing purposes
          //return ($plg>60?round($final, 2):'');
          //Uncomment below for final return;
          return ($plg>60?$plg:'');
    }
    
    public function getAssessments($s, $category, $term, $singleSub)
    {
        $final = 0;
        
        foreach($category as $cat => $k):
            $record = Modules::run('gradingsystem/getTotalScoreByStudent', $s->st_id, $k->code, $term , $singleSub->subject_id);
            $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $s->st_id, $k->code, $term, $singleSub->subject_id, 1, $s->section_id);
            if($numberOfAssessment->num_rows()>0){
                $record = $record->row()->score;
                $tps = $numberOfAssessment->row()->TPS;
                if($tps!=0):
                    $ps = (($record/$tps)*100);
                    $ws = round(($ps*$k->weight), 2);
                else:
                    $ws = 0;
                endif;
                
            }else{
                $ws = 0;
            }
            $final += $ws;
          endforeach;
          $plg = Modules::run('gradingsystem/new_gs/getTransmutation', round($final, 2));
          
          //testing purposes
          //return ($plg>60?round($final, 2):'');
          //Uncomment below for final return;
          return ($plg>60?$plg:'');
    }
    
    public function generateFinalTop($section_id, $term)
    {
        $student = $this->generateTop($section_id, $term);
        $sameRank = $this->getSameRank($student);
        echo '<table>';
        $i = 1;
        $previousRank = 0;
        foreach ($student as $key => $s):
            echo '<tr>';
            echo '<td>'.$s['student'].'</td>';
            echo '<td>'.$s['grade'].'</td>';
            $rank = $i++;
            $previousRank = $rank;
            foreach ($sameRank as $sk => $sr):
                if($s['grade']==$sr['grade']):
                    $rank = $sr['rank'];
                endif;
            endforeach;
            echo '<td>'.$rank.'</td>';
            '</tr>';
        endforeach;
        

      
    }
    
    public function generateTop($section_id, $term, $students = NULL) {
        $section = Modules::run('registrar/getSectionById', $section_id);
        $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
        $students = ($students == NULL ? Modules::run('registrar/getAllStudentsBasicInfoByGender', $section->grade_id, NULL, "1", $this->session->school_year, NULL, $section_id) : $students);

        $totalGrade = 0;
        $column = array();
        $nm = 0;
        foreach ($students->result() as $s):
            $i = 0;
            $tm = 0;
            foreach ($subject_ids as $sub):
                $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
                if ($singleSub->parent_subject == 11):
                    $tm++;
                    $fg = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, $term, $this->session->school_year);
                    $tf += $fg->row()->final_rating;
                else:
                    $nm++;
                endif;
            endforeach;
            $total_mapeh = round($tf / $tm);

            foreach ($subject_ids as $sub) {
                $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
                $finalGrade = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, $term, $this->session->school_year);
                if (!empty($finalGrade)):
                    switch ($gs_settings->gs_used):
                        case 1:
                            $ass_gr = $finalGrade->row()->final_rating;
                            break;
                        case 2:
                            $ass_gr = ($finalGrade->row()->final_rating == "" ? "" : $finalGrade->row()->final_rating);
                            break;
                    endswitch;

                    if ($singleSub->parent_subject != 11):
                        $finalAssessment += $finalGrade->row()->final_rating;
                    endif;
                else:
                    $finalAssessment += 0;
                endif;
            }



            $totalGrade = round(($finalAssessment + $total_mapeh) / ($nm + 1), 2);

            $details = array(
                'student' => strtoupper($s->lastname . ', ' . $s->firstname . ' ' . substr($s->middlename, 0, 1) . '.'),
                'grade' => $totalGrade
            );
            array_push($column, $details);
            $totalGrade = 0;
            $mapeh = 0;
            $finalAssessment = 0;
            $tf = 0;
            $nm = 0;
        endforeach;

        // print_r($column);
        // echo '<br />';
        $result = $this->sortToTop($column, 'grade');
        return $result;
        //print_r($result);
    }
    
    // public function generateTop($section_id, $term, $students=NULL)
    // {
    //     $section = Modules::run('registrar/getSectionById', $section_id);
    //     $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);   
    //     $students = ($students == NULL?Modules::run('registrar/getAllStudentsBasicInfoByGender', $section_id, NULL, "1", $this->session->school_year):$students);
        
    //     $totalGrade = 0;
    //     $column = array();
    //     foreach ($students->result() as $s):
    //         $i =0;
    //             foreach($subject_ids as $sub):
    //                 $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
    //                 $category = Modules::run('gradingsystem/new_gs/getCustomComponentList', $singleSub->subject_id);
    //                 $grade = $this->getAssessments($s, $category, $term, $singleSub);
    //                 if($singleSub->subject_id != 55 && $singleSub->subject_id != 56):
    //                     if($singleSub->parent_subject!=11):
    //                         $i++;
    //                         $totalGrade += $grade;
    //                     endif;    
    //                 endif;   
    //                 if($singleSub->parent_subject==11):
    //                     $mapehAve += $grade;
    //                     if($singleSub->subject_id==16):
    //                         $mapehAve = ($mapehAve >0?round(($mapehAve/4)):0);
    //                         $i++;
    //                     endif;
    //                 endif;
    //             endforeach;
    //              $totalGrade = $totalGrade + $mapehAve;
    //             $mapehAve = 0;
    //             $totalGrade = round($totalGrade/$i,3);
    //             $details = array(
    //                 'student'   => strtoupper($s->lastname.', '.$s->firstname.' '.substr($s->middlename, 0, 1).'.'),
    //                 'grade'     => $totalGrade
    //             );
    //             array_push($column, $details);
    //             $totalGrade = 0;
    //     endforeach;
        
    //   // print_r($column);
    //   // echo '<br />';
    //   $result = $this->sortToTop($column, 'grade');
    //   return $result;
    //   //print_r($result);

      
    // }
    
    function getSameRank($result)
    {
        $previousGrade = 0;
        $previousKey = 0;
        $it = 0;
        foreach ($result as $current_key => $current_array):
            foreach ($result as $search_key => $search_array):
                  if($search_array['grade'] == $current_array['grade']):
                      if ($search_key != $current_key):
                         // echo $search_array['grade'].' | '. $search_key .'<br />';
                          $rank[] = array(
                              'key'   => $search_key,
                              'grade' => $search_array['grade']
                          );

                      endif; 
                  endif;
            endforeach;
        endforeach;
        $rank = $this->unique_multidim_array($rank, 'key');
        $key = 0;
        foreach($rank as $r => $rnk):
           $it++;
           if($it==1):
               $previousGrade = $rnk['grade'];
               $previousKey = $rnk['key'];
           endif;
           if($previousGrade==$rnk['grade']):
              //$key = $key + $previousKey;
               if($previousKey == $rnk['key']):
                   $it=1;
               endif;
               if($it==1):
                   $key = $previousKey;
               else:
                   $key = $key+($rnk['key']+2);
               endif;
               
           else:
               if($it==1):
                    $key = $rnk['key'];
                    $previousKey = $key;
               else:
                    $key = $rnk['key'];
                    $previousKey = $key+1;
                    $it = 1; 
               endif;
              
           endif;

             // echo $key.' | '.$rnk['grade'].'<br />';
           $ranks[] = array(
              'key'   => $key,
              'grade' => $rnk['grade'],
              'it'    => $it,
              'rank'  => round($key/$it,1,PHP_ROUND_HALF_DOWN)
           );

           $previousGrade = $rnk['grade'];

        endforeach;

        return $this->sortToTop($this->unique_multidim_array($this->sortToTop($ranks, 'key'), 'grade'), 'key', 1);
    }
    
    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    } 
    
    public function sortToTop($array, $order, $sort_type = NULL)
    {
         $keys = array_column($array, $order);
         
         array_multisort($keys, ($sort_type==NULL?SORT_DESC:SORT_ASC), $array);
         
         return $array;
    }
    
    
    function getRank($grade, $pGrade, $pRank, $dupRank)
    {
        if($grade < $pGrade):
            $pRank = $pRank + 1;
        else:
            $dupRank = $dupRank +1;
        endif;

        return $pRank;
    }
    
    function getGSLegend($grade)
    {
        switch (TRUE):
            case ($grade >= 90):
                $abr = 'O';
                $legend = 'Outstanding';
            break;    
            case ($grade >= 85 && $grade < 90):
                $abr = 'VS';
                $legend = 'Very Satisfactory';
            break;    
            case ($grade >= 80 && $grade < 85):
                $abr = 'S';
                $legend = 'Satisfactory';
            break;    
            case ($grade >= 75 && $grade < 80):
                $abr = 'FS';
                $legend = 'Fairly Satisfactory';
            break;    
            case ($grade < 75):
                $abr = 'D';
                $legend = 'Did Not Meet Expectations';
            break;    
        endswitch;
        
        return json_encode(array('abr' => $abr, 'legend' => $legend));
    }
    
    function getGSHonorsLegend($grade)
    {
        switch (TRUE):
            case ($grade >= 98):
                $abr = 'O';
                $legend = 'With Highest Honors';
            break;    
            case ($grade >= 95 && $grade < 98):
                $abr = 'VS';
                $legend = 'With High Honors';
            break;    
            case ($grade >= 90 && $grade < 95):
                $abr = 'S';
                $legend = 'With Honors';
            break;    
            case ($grade >= 75 && $grade < 90):
                $abr = 'FS';
                $legend = 'Met the Standard Grade';
            break;    
            case ($grade < 90):
                $abr = 'D';
                $legend = 'Did Not Meet Expectations';
            break;    
        endswitch;
        
        return json_encode(array('abr' => $abr, 'legend' => $legend));
    }
    
   

}
