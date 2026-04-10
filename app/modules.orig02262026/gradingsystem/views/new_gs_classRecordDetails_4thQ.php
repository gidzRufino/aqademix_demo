<?php
$gs_settings = Modules::run('gradingsystem/getSet');
$subject = Modules::run('academic/getSpecificSubjects', $subject_id);
$section = Modules::run('registrar/getSectionById', $section_id);
if ($gs_settings->used_specialization && $subject_id == 10):
    switch ($section->grade_level_id):
            //case 10:
        case 11:
            $getSpecs = Modules::run('academic/getSpecificSubjectAssignment', $this->session->userdata('employee_id'), $section_id, $subject_id);
            $students = Modules::run('academic/getStudentWspecializedSubject', $getSpecs->specs_id);
            $yearSectionName = Modules::run('registrar/getSpecialization', $getSpecs->specs_id)->specialization;
            break;
        default:
            $students = Modules::run('registrar/getAllStudentsForExternal', '', $section_id, NULL, 1);
            $yearSectionName = $section->level . ' - ' . $section->section;
            break;
    endswitch;
else:
    $students = Modules::run('registrar/getAllStudentsForExternal', '', $section_id, NULL, 1);
    $yearSectionName = $section->level . ' - ' . $section->section;
endif;

$cat = Modules::run('gradingsystem/getAssessCatBySubject', $subject_id, $school_year);
if ($cat->num_rows() > 0):
    $sub_id = $subject_id;
else:
    $sub_id = '0';
endif;
$category = Modules::run('gradingsystem/getAssessCategory', $sub_id, $school_year);

$subject_teacher = Modules::run('academic/getSubjectTeacher', $subject_id, $section_id, $school_year);
$settings = Modules::run('main/getSet');
switch ($term) {
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
?>
<div class="emailForm panel panel-yellow clearfix">
    <div class="panel-heading clearfix">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="myModalLabel" class="pull-left">New Class Record Details in <?php echo $subject->subject . ' ( ' . $yearSectionName . ' )' ?></h4>
        <div onmouseover='$(".tip-top").tooltip();' class="btn-group pull-right" data-toggle="buttons" style="margin-right:10px;">
            <label id="graphical" onclick="getClassProgressReport()" class="btn btn-primary tip-top">
                <input type="radio" name="options" id="option2"><i class="fa fa-pie-chart "></i>
            </label>
            <label id="tabular" onclick="classRecordDetails()" class="btn btn-primary hide">
                <input type="radio" name="options" id="option2"><i class="fa fa-table "></i>
            </label>
        </div>
        <button class="btn btn-small pull-right btn-success" onclick="printGradingSheet()"><i class="fa fa-print"></i>&nbsp;Print</button>
    </div>

    <div class="panel-body col-lg-12 col-md-12" id="pbody" style="max-height: 500px; overflow-y:auto;">

        <?php
        $ww = 0;
        $pt = 0;
        $qa = 0;
        $ss = 0;
        foreach ($category as $cat => $k):
            $t = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year);
            switch ($k->id):
                case 1:
                    $ww += $t->num_rows();
                    break;
                case 2:
                    $pt += $t->num_rows();
                    break;
                case 3:
                    $qa += $t->num_rows();
                    break;
            endswitch;
        endforeach;
        $tt = ($ww == 0 ? 1 : $ww) + ($pt == 0 ? 1 : $pt) + ($qa == 0 ? 1 : $qa);

        $ta = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $subject_id . '04', $term, $school_year);
        $ss += $ta->num_rows();
        ?>

        <table id="CRdetails" class="table table-bordered text-center tablesorter">
            <thead id="crdetails_head">
                <tr>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Gender</th>
                    <th colspan="<?php echo ($tt + 3) ?>" class="text-center fourth">4th Quarter</th>
                    <th colspan="<?php echo ($ss + 3) ?>" class="text-center achievement">Achievement Test</th>
                    <th class="pointer text-center" rowspan="3">Final Grade</th>
                </tr>
                <tr style="font-weight:bold;">
                    <?php

                    foreach ($category as $cat => $k) {
                        switch ($k->component) {
                            case 'Written Work':
                                $color = '#8CDCFF';
                                break;
                            case 'Performance Task':
                                $color = '#FF8CFB';
                                break;
                            case 'Quarterly Assessment':
                                $color = '#B0FF8C';
                                break;
                        }
                        //echo $subject_teacher->faculty_id.'-'.$section_id.'-'.$subject_id.'-'.$k->code.$term.'-'.$school_year;
                        $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year);

                        //print_r($teachersAssessment->result());
                    ?>
                        <th color="<?php echo $color; ?>" id="th_<?php echo substr($k->category_name, 0, 4) ?>" rows="<?php echo $teachersAssessment->num_rows() ?>" class="pointer text-center fourth" style="background:<?php // echo $color; 
                                                                                                                                                                                                                            ?>;" colspan="<?php echo $teachersAssessment->num_rows(); ?>">
                            <?php echo substr($k->category_name, 0, 1) . ' (' . ($k->weight * 100) . '% )'; ?>
                        </th>

                    <?php
                    }
                    ?>
                    <th class="pointer text-center fourth">Initial Grade</th>
                    <th id="th_totn" class="pointer text-center fourth">
                        Transmuted Grade
                    </th>
                    <th class="pointer text-center fourth">70%</th>
                    <?php
                    foreach ($ta->result() as $a):
                    ?>
                        <th class="text-center achievement">
                            <?php echo $a->assess_title ?>
                        </th>
                    <?php
                    endforeach;
                    ?>
                    <th class="pointer text-center achievement">AT Initial Grade</th>
                    <th id="th_totn" class="pointer text-center achievement">
                        AT Transmuted Grade
                    </th>
                    <th class="pointer text-center achievement">30%</th>
                </tr>
                <tr style="font-weight:bold">
                    <td style="font-weight:bold">NUMBER OF ITEMS >>></td>
                    <td></td>
                    <?php
                    foreach ($category as $cat => $k) {
                        switch ($k->component) {
                            case 'Written Work':
                                $color = '#8CDCFF';
                                break;
                            case 'Performance Task':
                                $color = '#FF8CFB';
                                break;
                            case 'Quarterly Assessment':
                                $color = '#B0FF8C';
                                break;
                        }
                        $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year);
                        foreach ($teachersAssessment->result() as $IABS) {
                    ?>
                            <td onmouseover='$(".tip-top").tooltip();' class="fourth" style="background:<?php //echo $color; 
                                                                                                        ?>;">
                                <span title="<?php echo $IABS->assess_title . ' [ ' . $IABS->assess_date . ' ]'; ?>" data-toggle="tooltip" data-placement="top" class="tip-top pointer">
                                    <?php
                                    echo  $IABS->no_items;
                                    ?>
                                </span>

                            </td>
                    <?php
                        }
                        if (empty($teachersAssessment->result())):
                            echo '<td class="fourth"></td>';
                        endif;
                    }
                    ?>
                    <td class="fourth"></td>
                    <td class="fourth"></td>
                    <td class="fourth"></td>
                    <?php
                    foreach ($ta->result() as $a):
                    ?>
                        <th class="text-center achievement">
                            <?php echo $a->no_items ?>
                        </th>
                    <?php
                    endforeach;
                    ?>
                    <th class="achievement"></th>
                    <th class="achievement"></th>
                    <th class="achievement"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $countStudents = 0;
                foreach ($students->result() as $s) {

                    $countStudents++;
                ?>

                    <tr>
                        <td style="text-align:left; width:200px;">
                            <?php echo strtoupper($s->lastname . ', ' . $s->firstname) ?>
                        </td>
                        <td style="width:50px;">
                            <?php echo substr($s->sex, 0, 1) ?>
                        </td>
                        <?php
                        foreach ($category as $cat => $k) {

                            switch ($k->component) {
                                case 'Written Work':
                                    $color = '#8CDCFF; width:40px;';
                                    break;
                                case 'Performance Task':
                                    $color = '#FF8CFB; width:40px;';
                                    break;
                                case 'Quarterly Assessment':
                                    $color = '#B0FF8C; width:40px;';
                                    break;
                            }
                            $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year);
                            //print_r($teachersAssessment->result());
                            $r = 0;
                            $t = 0;
                            foreach ($teachersAssessment->result() as $IABS) {
                                $rawScore = Modules::run('gradingsystem/getRawScore', $s->st_id, $IABS->assess_id);
                                $r += $rawScore->row()->raw_score;
                                $t += $IABS->no_items;
                        ?>
                                <td class="td_<?php echo substr($k->category_name, 0, 4) ?> fourth" style="background:<?php // echo $color; 
                                                                                                                        ?>">
                                    <?php
                                    echo $rawScore->row()->raw_score;
                                    ?>
                                </td>
                        <?php
                            }

                            $ps = (($r / $t) * 100);
                            $ws = round(($ps * $k->weight), 2);
                            $final += $ws;

                            if (empty($teachersAssessment->result())):
                                echo '<td class="fourth"></td>';
                            endif;
                        }
                        //   $totalGrade = Modules::run('gradingsystem/getPartialAssessment',$s->st_id, $section_id, $subject_id, $school_year);
                        $totalGrade = Modules::run('gradingsystem/getPartialGrade', $s->st_id, $subject_teacher->faculty_id, $section_id, $subject_id, $school_year, $term);
                        $seventy = $totalGrade * 0.7;
                        ?>
                        <td class="td_totn text-center fourth"><?php echo $final; ?></td>
                        <td class="td_totn text-center fourth"><?php echo $totalGrade; ?></td>
                        <td class="td_totn text-center fourth"><?php echo $seventy; ?></td>
                        <?php
                        unset($final);

                        foreach ($ta->result() as $a):
                            $totalItems += $a->no_items;
                            $rawScore = Modules::run('gradingsystem/getRawScore', $s->st_id, $a->assess_id);
                            $rs += $rawScore->row()->raw_score;
                        ?>
                            <td class="text-center achievement">
                                <?php echo $rawScore->row()->raw_score ?>
                            </td>
                    <?php
                        endforeach;
                        $tg = round(($rs / $totalItems) * 100, 1);
                        $fin_tg = Modules::run('gradingsystem/new_gs/getTransmutation', $tg, 2);
                        $thirty = $fin_tg * 0.3;
                        echo  '<td class="achievement">' . $tg . '</td>';
                        echo  '<td class="achievement">' . $fin_tg . '</td>';
                        echo  '<td class="achievement">' . $thirty . '</td>';
                        echo  '<td>' . round($seventy + $thirty) . '</td>';
                        echo '</tr>';

                        $totalItems = 0;
                        $rs = 0;
                    }
                    ?>
            </tbody>

        </table>

    </div>
</div>
<script type="text/javascript">
    function printGradingSheet() {
        var section_id = <?php echo $section_id ?>;
        var strand_id = <?php echo $strand_id ?>;
        var subject_id = <?php echo $subject_id ?>;
        var term = <?php echo $term ?>;
        var school_year = <?php echo $school_year ?>;
        var url = '<?php echo base_url() . 'gradingsystem/printGradingSheet/' ?>' + section_id + '/' + strand_id + '/' + subject_id + '/' + term + '/' + school_year;
        window.open(url, '_blank');
    }

    $(function() {
        $("#CRdetails").tablesorter({
            debug: true
        });

    });
    var totn = $('#th_totn').width();
    var totl = $('#th_totl').width();
    var beha = $('#th_Beha').width();
</script>

<style type="text/css">
    .fourth {
        background-color: #c1f1d6;
        color: #4d4d4d;
    }

    .achievement {
        background-color: #6699ff;
        color: #4d4d4d;
    }
</style>