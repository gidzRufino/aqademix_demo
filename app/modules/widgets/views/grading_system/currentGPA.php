<?php
    $st_id = base64_decode($this->uri->segment(3));
    
    $section = Modules::run('registrar/getSectionById', $details['student']->section_id);
    $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);    
    $subject = explode(',', $subject_ids->subject_id);
    switch ($details['term']){
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
      default:
          $term = 'final';
      break;
     }
    $totalSubs = 0;
    $finalAssessment = 0;
    foreach ($subject as $sub):;
        $assessment = Modules::run('gradingsystem/getPartialAssessment', $st_id, $section->section_id, $sub, $this->session->userdata('school_year'));
        //echo $sub;  
      
        //print_r($assessment);
        if(!empty($assessment) || $assessment == NULL):
            $totalSubs++;
            $finalAssessment += $assessment->$term;
        else:
            $finalAssessment += 0;
        endif;
        
    endforeach;
    
   $numberGrade = $finalAssessment/$totalSubs;
   
   
    
?>
<div class="well text-center" style="margin: 0; padding:0;">
    <span  class="fa-5x text-warning"><?php echo Modules::run('gradingsystem/getEquivalent', $numberGrade); ?></span><br />
    <span class="text-danger">Current GPA</span>

</div>