<?php
$GradeLevel = Modules::run('registrar/getSectionByGradeId', $grade_id); 
if($section_id==NULL):
    $grade_title = $GradeLevel->row()->level;
else:
    $section = Modules::run('registrar/getSectionById', $section_id);
    $grade_title = $section->level.' - '.$section->section;
endif;
$student = Modules::run('registrar/getAllStudentsByLevel', $grade_id, $section_id, $school_year);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $grade_id);    
$subject = explode(',', $subject_ids->subject_id);
$i=0;
foreach ($student->result() as $s):
    
    foreach($subject as $sub):
        $assessment = Modules::run('gradingsystem/getPartialAssessment', $s->st_id, $section_id, $sub, $school_year);
        $finalAssessment += $assessment->$term;
        //echo $assessment->$term.' ';
    endforeach;
    if($grade_id!=18):
        $subjects=count($subject);
    else:
        $subjects=count($subject)-1;
    endif;
    $FA = $finalAssessment/$subjects;
    if($FA>=90):
            $a += 1;
    else:
        if($FA>=85 && $FA<90):
            $p +=1;
        else:
            if($FA>=80 && $FA<85):
                $ap +=1;
            else:
                if($FA>=75 && $FA<80):
                    $d +=1;
                else:
                    if($FA<75):
                        $b +=1;
                    endif;
                endif;
            endif;
        endif;
    endif;
    
    unset($finalAssessment);
endforeach;       
?>
<div class="col-lg-4 panel" style="position: fixed; width: 250px; margin-top:10px;">
    <div class="panel-heading" style="height:40px;">
        <h6 class="text-center" style="margin:0">Graph Breakdown</h6>
    </div>
    <div class="panel-body" style="padding:0;">
        <table class="table table-bordered text-center">
            <tr>
                <td># of Students</td>
                <td>Level of Proficiency</td>
            </tr>
            <tr style="background:#5CC1EC;">
                <td><?php echo $a; ?></td>
                <td>Advanced</td>
            </tr>
            <tr style="background: #CFDE5C;">
                <td><?php echo $p; ?></td>
                <td>Proficient</td>
            </tr>
            <tr style="background: #D68989;">
                <td><?php echo $ap; ?></td>
                <td>Approaching Proficient</td>
            </tr>
            <tr style="background:#8AC08A;">
                <td><?php echo $d; ?></td>
                <td>Developing</td>
            </tr>
            <tr style="background: #B582EA;">
                <td><?php echo $b; ?></td>
                <td>Beginning</td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $student->num_rows().' - total students'; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<input type="hidden" id="a" value="<?php if($a!=''):echo $a; else: echo '0'; endif; ?>" />
<input type="hidden" id="p" value="<?php if($p!=''):echo $p; else: echo '0'; endif; ?>" />
<input type="hidden" id="ap" value="<?php if($ap!=''):echo $ap; else: echo '0'; endif; ?>" />
<input type="hidden" id="d" value="<?php if($d!=''):echo $d; else: echo '0'; endif; ?>" />
<input type="hidden" id="b" value="<?php if($b!=''):echo $b; else: echo '0'; endif; ?>" />
<div id="graph_pie" class="col-lg-8" style="height:400px;">
    
</div>
<div class="col-lg-4">
    <table class="table table-hover">
        <tr>
            <th><?php echo $GradeLevel->row()->level ?></th>
        </tr>
        <?php foreach($GradeLevel->result() as $rs): ?>
        <tr>
            <td><?php echo $rs->section; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<script type="text/javascript">
    
   (function basic_pie(container) {
    $('#lop_grade').html('<?php echo $grade_title; ?>');
    var
    a = $('#a').val(),
    p = $('#p').val(),
    ap = $('#ap').val(),
    d = $('#d').val(),
    b = $('#b').val(),
    d1 = [[0, parseInt(a)]],
    d2 = [[0, parseInt(p)]],
    d3 = [[0, parseInt(ap)]],
    d4 = [[0, parseInt(d)]],
    d5 = [[0, parseInt(b)]],
        graph;

    graph = Flotr.draw(container, [
        {
        
        data: d1, label: 'Advance',
        pie: {
            explode: 20
        }}, 
        {
        data: d2,label: 'Proficient'}, 
        {
        data: d3,
        label: 'Aproaching Proficient'
        
    }, {
        data: d4,
        label: 'Developing'
    }, {
        data: d5,
        label: 'Beginning'
    }
], {
        HtmlText: false,
        fontSize   : 8,
        grid: {
            verticalLines: false,
            horizontalLines: false
        },
        xaxis: {
            showLabels: false
        },
        yaxis: {
            showLabels: false
        },
        pie: {
            show: true,
            explode: 6
        },
        mouse: {
            track: true
        },
        legend: {
            position: 'se',
            backgroundColor: '#D2E8FF',
            
        }
    });
})(document.getElementById("graph_pie")); 
</script>