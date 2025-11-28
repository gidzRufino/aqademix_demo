<?php
$student = $details['student'];
$subject_teacher = Modules::run('academic/getSubjectTeacher', $details['subject_id'], $student->section_id);
//echo $details['subject_id'];
if($details['subject_id']==6||$details['subject_id']==10):
        $sub_id = $details['subject_id'];
    else:
        $sub_id = '0';
    endif;
$category = Modules::run('gradingsystem/getAssessCategory','', $sub_id);
//echo $details['school_year'];
$teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $student->section_id,  $details['subject_id'], '', $details['term'], $details['sy'] );

if($teachersAssessment->num_rows()>0):
?>
<div id="graph" class="col-lg-7 pull-left" style="height:350px;">
    
</div>
<div class="col-lg-5 pull-right">
    <div class="panel panel-default">
        <div class="panel-heading" style="height:40px;">
            <h4 class="text-center" style="margin:0">Graph Details</h4>
        </div>
        <div id="pbody" class="panel-body" style="padding:0; height:300px; overflow-y: scroll;">
            <table  id="graph_details" class="table table-bordered table-striped">
                <thead id="gd_head">
                    <tr class="text-center">
                        <td>Date</td>
                        <td>Title</td>
                        <td>Raw Score</td>
                        <td>No. Items</td>
                    </tr>
                </thead>
                <tbody id="gd_body">
                    <?php 
                    $i=0;
                    foreach ($teachersAssessment->result() as $IABS){
                    $i++;
                    $rawScore = Modules::run('gradingsystem/getRawScore', $student->st_id, $IABS->assess_id );
                   ?>
                    <tr>
                        <td><?php echo $IABS->assess_date ?></td>
                        <td><?php echo $IABS->assess_title ?></td>
                        <td class="text-center"><?php echo $rawScore->row()->raw_score ?></td>
                        <td class="text-center"><?php echo $IABS->no_items ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    
(function basic(container) {

    var
    d1 = [[0,0],
        <?php
        $i=0;
        foreach ($teachersAssessment->result() as $IABS){
        $i++;
            $rawScore = Modules::run('gradingsystem/getRawScore', $student->st_id, $IABS->assess_id );
            echo '['.$i.','.$rawScore->row()->raw_score.']';
           if($i<$teachersAssessment->num_rows()):
               echo ',';
           endif;
        }
        ?>
    ],
        // First data series


    // Draw Graph
    graph = Flotr.draw(container, [
          {data:
            d1, 
            lines: {
                show: true,
                fill: true
            }
          }], 
        {
        fontSize: 10,
        xaxis: {
            ticks:[
                <?php
                    $i=0;
                    foreach ($teachersAssessment->result() as $IABS){
                    $i++;
                        $rawScore = Modules::run('gradingsystem/getRawScore', $student->st_id, $IABS->assess_id );
                        echo '['.$i.',\''.$IABS->assess_date.'\']';
                       if($i<$teachersAssessment->num_rows()):
                           echo ',';
                       endif;
                    }
                    ?>
            ],
            labelsAngle: 45,
            //tickDecimals:0,
            title: 'Assessment Taken',
            font:{
                size:20
            }
        },
        yaxis: {
            
            titleAngle: 90,
            title: 'Equivalent',
            max: 100
        },
        grid: {
            minorVerticalLines: true
        },
        HtmlText: false
    });
})(document.getElementById("graph"));    
</script>
<?php
else:
?>
<div class="alert alert-warning">
    <h2 class="text-center">Sorry, No Record Found</h2>
    <h5 class="text-center">If you haven't selected a subject below, please do so, otherwise contact the subject teacher</h5>
</div>
<?php
endif;