<?php
$settings = Modules::run('main/getSet');
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $details['details']);   
//print_r($subject_ids);
//
//$subject = explode(',', $subject_ids->subject_id);
switch ($details['term']) {
    case 1:
        $grading = 'first';
        break;
    case 2:
        $grading = 'second';
        break;
    case 3:
        $grading = 'third';
        break;
    case 4:
        $grading = 'fourth';
        break;
}
 foreach($subject_ids as $s):
        $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
        $assessment = Modules::run('gradingsystem/getPartialAssessment', base64_decode($details['st_id']), $details['section_id'], $s->sub_id, $details['year']);
        $finalAssessment +=$assessment->$grading;
        //echo $s->subject_id;
endforeach;

if($finalAssessment>0):
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <td></td>  
            <?php 
            foreach($subject_ids as $s):
                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            ?>
            <td><?php echo $singleSub->subject; ?></td>
        <?php
        endforeach;
        ?>
        </tr>
    </thead>
    <tbody>
    <td>Partial Number Grade</td>
        <?php 
            foreach($subject_ids as $s):
                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                $assessment = Modules::run('gradingsystem/getPartialAssessment', base64_decode($details['st_id']), $details['section_id'], $s->sub_id, $details['year']);

            ?>
            <td><?php echo $assessment->$grading; ?></td>
        <?php
        endforeach;
        ?>
    </tbody>
</table>
<?php
else:
?>
<div class="alert alert-warning">
    <h2 class="text-center">Sorry, No Record Found</h2>
</div>

<?php    
endif;
