<table class="table table-striped">
    <tr>
        <td style="text-align: center; vertical-align: middle;" rowspan="2">
            <h4>List of Subjects</h4>
        </td>
        <td style="text-align: center" colspan="2">First Grading</td>
<!--        <td style="text-align: center" colspan="2">Second Grading</td>
        <td style="text-align: center" colspan="2">Third Grading</td>
        <td style="text-align: center" colspan="2">Fourth Grading</td>-->
    </tr>
    <tr>
        <td style="text-align: center"><small>Partial Number Grade</small></td>
        <td style="text-align: center"><small>Partial Letter Grade</small></td>
<!--        <td style="text-align: center"><small>Partial Number Grade</small></td>
        <td style="text-align: center"><small>Partial Letter Grade</small></td>
        <td style="text-align: center"><small>Partial Number Grade</small></td>
        <td style="text-align: center"><small>Partial Letter Grade</small></td>
        <td style="text-align: center"><small>Partial Number Grade</small></td>
        <td style="text-align: center"><small>Partial Letter Grade</small></td>-->
    </tr>


    <?php
        $partial = NULL;
        if($studentInfo->grade_id<=10){
            $assess_dept = 0;
        }
        $subjects = Modules::run('academic/getSpecificSubjectPerlevel', $studentInfo->grade_id);
        $subject = explode(',', $subjects->subject_id);
        
        foreach($subject as $s){
            $subjectName = Modules::run('academic/getSpecificSubjects', $s);
          ?>
    <tr>
        <td><h6><?php echo $subjectName->subject; ?></h6></td>
        <td style="text-align: center"><h6>
             <?php
        $assessment = Modules::run('gradingsystem/getPartialAssessment', $studentInfo->user_id, $studentInfo->section_id, $s, $this->session->userdata('school_year'));    
        if($assessment->first!=""):
            $partial = $assessment->first;
            echo $assessment->first;
        else:
            echo 0;
        endif;
       ?>  
            </h6>
        </td>
        <td style="text-align: center"><h6>
        <?php
         if($partial!=0){
            $plg = Modules::run('gradingsystem/getLetterGrade', $partial);
                foreach($plg->result() as $plg){
                    if( $partial > $plg->from_grade && $partial <= $plg->to_grade){
                        
                            echo $plg->letter_grade;
                       
                    }
                }
                
            }else{
                echo "B";
            } ?>
            </h6>
        </td>
<!--        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>-->
    </tr>
    
    <?php
        }
    ?>
</table>