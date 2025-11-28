<?php
    $subject = Modules::run('academic/getSpecificSubjects', $subject_id);
    $section = Modules::run('registrar/getSectionById', $section_id);
    $students = Modules::run('registrar/getAllStudentsBasicInfoByGender',$section_id, null, 1, NULL);
    
    $cat = Modules::run('gradingsystem/getAssessCatBySubject', $subject_id, $school_year);
    if($cat->num_rows()>0):
        $sub_id = $subject_id;
    else:
        $sub_id = '0';
    endif;
    $category = Modules::run('gradingsystem/getAssessCategory',$sub_id, $school_year);
    
    $subject_teacher = Modules::run('academic/getSubjectTeacher', $subject_id, $section_id);
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
<div class="emailForm panel panel-yellow clearfix" >
    <div class="panel-heading clearfix">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 id="myModalLabel" class="pull-left">Class Record Details in <?php echo $subject->subject.' ( '.$section->level.' - '.$section->section.' )' ?></h4>
            <div onmouseover='$(".tip-top").tooltip();' class="btn-group pull-right" data-toggle="buttons" style="margin-right:10px;">
                <label id="graphical"  onclick="getClassProgressReport()" class="btn btn-primary tip-top">
                    <input type="radio" name="options" id="option2"><i class="fa fa-pie-chart "></i>
                </label>
                <label id="tabular"  onclick="classRecordDetails()" class="btn btn-primary hide">
                    <input type="radio" name="options" id="option2"><i class="fa fa-table "></i>
                </label>
            </div>
    </div>
    
        <div class="panel-body col-lg-12 col-md-12" id="pbody" style="max-height: 500px; overflow-y:auto;">
           
            <table id="CRdetails" class="table table-striped table-bordered text-center tablesorter" >
                <thead id="crdetails_head">
                    <tr style="font-weight:bold;">
                        <th id="thn" class="pointer" style="width:200px;">Name</th>
                        <td id="thg" style="width:50px;">Gender</td>
                        <?php 
                        
                        foreach($category as $cat => $k)
                        {
                            switch ($k->category_name){
                                case 'Knowledge':
                                    $color = '#8CDCFF';
                                break;
                                case 'Process':
                                    $color = '#FF8CFB';
                                break;    
                                case 'Understanding':
                                    $color = '#B0FF8C';
                                break;    
                                case 'Product':
                                    $color = '#FC5555';
                                break;    
                                case 'Behavior':
                                    $color = '#FFFBA0';
                                break;    
                                case 'Written Work':
                                    $color = '#8CDCFF';
                                break;    
                                case 'Performance Task':
                                    $color = '#B0FF8C';
                                break;    
                            }
                           // echo $subject_teacher->faculty_id.$section_id.$subject_id.$k->code.$term;
                            $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year );
                           // print_r($teachersAssessment->result());
                            ?>
                        <th color="<?php echo $color; ?>" id="th_<?php echo substr($k->category_name, 0, 4) ?>" rows="<?php echo $teachersAssessment->num_rows() ?>" class="pointer text-center" style="background:<?php echo $color; ?>;" colspan="<?php echo $teachersAssessment->num_rows(); ?>">
                            <?php echo substr($k->category_name, 0, 1).' ('.($k->weight*100).'% )'; ?>
                        </th>

                        <?php
                        }
                        ?>
                        <th id="th_totn" class="pointer" >
                            PNG
                        </th>
                        <th id="th_totl">PLG</th>
                    </tr>
                <tr style="font-weight:bold">
                    <td style="font-weight:bold" >NUMBER OF ITEMS >>></td>
                    <td></td>
                    <?php
                        foreach($category as $cat => $k)
                        {
                            switch ($k->category_name){
                                case 'Knowledge':
                                    $color = '#8CDCFF';
                                break;
                                case 'Process':
                                    $color = '#FF8CFB';
                                break;    
                                case 'Understanding':
                                    $color = '#B0FF8C';
                                break;    
                                case 'Product':
                                    $color = '#FC5555';
                                break;    
                                case 'Behavior':
                                    $color = '#FFFBA0';
                                break;    
                            }
                            $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id,$section_id, $subject_id, $k->code, $term, $school_year );
                            foreach ($teachersAssessment->result() as $IABS){
                                ?>
                            <td onmouseover='$(".tip-top").tooltip();' style="background:<?php echo $color; ?>;" >
                                <span title="<?php echo $IABS->assess_date; ?>" data-toggle="tooltip" data-placement="top"  class="tip-top pointer"   >
                                    <?php 
                                     echo  $IABS->no_items; 
                                 ?> 
                                </span>
                                
                            </td>
                                <?php
                            }
                            if(empty($teachersAssessment->result())):
                                echo '<td></td>';
                            endif;

                        }
                    ?>
                            <td></td>
                            <td></td>
                </tr>
                 </thead>
                <tbody>
        <?php 
        $countStudents=0;
        foreach ($students->result() as $s)
        {
            
        $countStudents++;
        ?>
               
                <tr>
                    <td style="text-align:left; width:200px;">
                        <?php echo $s->lastname.', '.$s->firstname ?>
                    </td>
                    <td style="width:100px;">
                        <?php echo $s->sex ?>
                    </td>
                    <?php
                       foreach($category as $cat => $k)
                        {
                            
                           switch ($k->category_name){
                                case 'Knowledge':
                                    $color = '#8CDCFF; width:40px;';
                                break;
                                case 'Process':
                                    $color = '#FF8CFB; width:40px;';
                                break;    
                                case 'Understanding':
                                    $color = '#B0FF8C; width:40px;';
                                break;    
                                case 'Product':
                                    $color = '#FC5555; width:40px;';
                                break;    
                                case 'Behavior':
                                    $color = '#FFFBA0;';
                                break;    
                            }
                            $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id,$section_id, $subject_id, $k->code, $term, $school_year );
                            
                            foreach($teachersAssessment->result() as $IABS){
                                $rawScore = Modules::run('gradingsystem/getRawScore', $s->st_id, $IABS->assess_id );
                                ?>
                                <td class="td_<?php echo substr($k->category_name, 0, 4) ?>" style="background:<?php echo $color; ?>" >
                                    <?php 
                                     echo $rawScore->row()->raw_score;
                                    ?>
                                </td>
                               <?php
                               
                            }
                             if(empty($teachersAssessment->result())):
                                echo '<td></td>';
                            endif;
                         
                       }
                      $totalGrade = Modules::run('gradingsystem/getPartialAssessment',$s->st_id, $section_id, $subject_id, $school_year);  
                    ?>
                                <td class="td_totn text-center" style="font-weight:bold; width:50px"><?php echo round($totalGrade->$grading,2); ?></td>
                                <td class="td_totl text-center" style="font-weight:bold; width:50px"><?php echo Modules::run('gradingsystem/getEquivalent',$totalGrade->$grading) ?></td>
                    
                </tr>        
                
        <?php
        }
        ?>
                </tbody>    
                
            </table>
            
        </div>
</div>
<script type="text/javascript">
$(function() {
    $("#CRdetails").tablesorter({debug: true});
   
    });
    var totn = $('#th_totn').width();
    var totl = $('#th_totl').width();
    var beha = $('#th_Beha').width();
    //console.log(beha)
//$('#pbody').scroll(function() {
//
//    var b = $('#CRdetails').position();
//    var k_row = $('#th_Know').attr('rows');
//    var k_color = $('#th_Know').attr('color');
//    var k_col = parseInt(40)*parseInt(k_row);
//    
//    var proc_row = $('#th_Proc').attr('rows');
//    var proc_color = $('#th_Proc').attr('color');
//    var proc_col = parseInt(40)*parseInt(proc_row);
//    
//    var unde_row = $('#th_Unde').attr('rows');
//    var unde_color = $('#th_Unde').attr('color');
//    var unde_col = parseInt(40)*parseInt(unde_row);
//    
//    var prod_row = $('#th_Prod').attr('rows');
//    var prod_color = $('#th_Prod').attr('color');
//    var prod_col = parseInt(40)*parseInt(prod_row);
//    
//    var beh_row = $('#th_Beha').attr('rows');
//    var beh_color = $('#th_Beha').attr('color');
//    //console.log(proc_col)
//    if(b.top < 15){
//      $('#crdetails_head').attr('style','position:fixed; background:white; left:50px; top:62px;');
//      //$('#crdetails_head tr').attr('style',' width:25.7%;');
//      $('#thn').attr('style',' width:345px;');
//      $('#thg').attr('style',' width:75px;');
//      $('#th_Know').width(k_col-17);
//      $('.td_Know').attr('style',' width:40px; background:'+k_color)
//      $('#th_Proc').width(proc_col-17);
//      $('.th_Proc').attr('style',' width:40px; background:'+proc_color)
//      $('#th_Unde').width(unde_col-17);
//      $('.th_Unde').attr('style',' width:40px; background:'+unde_color)
//      $('#th_Prod').width(prod_col-17);
//      $('.th_Prod').attr('style',' width:40px; background:'+prod_color)
//      $('#th_Beha').width(beha);
//      $('.th_Beha').attr('style',' width:'+beha+' background:'+beh_color)
//      $('#th_totn').width(totn);
//      $('.td_totn').width(totn);
//      $('#th_totl').width(totl);
//      $('.td_totl').width(totl);
//
//    }
//    
//    if(b.top == 15){
//        $('#thg').attr('style',' width:75px;');
//        $('#thn').attr('style',' width:200px;');
//        $('#crdetails_head').removeAttr('style');  
//        $('#crdetails_head tr').removeAttr('style');  
//    }
//    
//});    

    </script>

