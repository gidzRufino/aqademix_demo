<?php
    if($subject_id==6||$subject_id==10):
        $sub_id = $subject_id;
    else:
        $sub_id = '0';
    endif;
    $category = Modules::run('gradingsystem/getAssessCategory', $sub_id, $school_year);
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
    $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, '', $term, $school_year );
    $totalGrade = Modules::run('gradingsystem/getPartialAssessment','', $section_id, $subject_id, $school_year);
    
    ?>
<div id="graph" class="col-lg-8 col-md-8" style="height:300px;">
    
</div>
<div class="col-lg-4 col-md-4 pull-right">
    <div class="panel">
        <div class="panel-heading" style="height:40px;">
            <h4 class="text-center" style="margin:0">Graph Details</h4>
        </div>
        <div class="panel-body clearfix" style="padding:0;">
            <div class="pull-left" style="border:1px solid #ddd; height:30px; width:37%;">
                <h6 class="text-center">Date</h6>
            </div>
            <div class="pull-left"  style="border:1px solid #ddd; height:30px; width:63%;">
                <h6 class="text-center">Assessment Title</h6>
            </div>
            <div class="pull-left" style="overflow-y: scroll;  height:300px; width:100%;">
             <table  id="graph_details" class="table table-bordered table-hover">
   
                 <?php 
                    
                    $i=0;
                    foreach ($teachersAssessment->result() as $IABS){
                    $i++;
                   ?>
                    <tr onclick="getIndividualAssessmentGraph('<?php echo $IABS->assess_id; ?>','<?php echo $section_id; ?>','<?php echo $subject_id; ?>','<?php echo $term; ?>')" id="<?php echo $IABS->assess_id; ?>_tr" class="pointer">
                        <td><?php echo $IABS->assess_date ?></td>
                        <td><?php echo $IABS->assess_title ?></td>
                       
                    </tr>
                    <?php
                    }
                    ?>
            </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="prevSelected" name="selectStudentId" />
<script type="text/javascript">
  
function getIndividualAssessmentGraph(id, section_id, subject_id, term)
{
   // alert(id);
        var prev = $('#prevSelected').val()
        
        
    var url = "<?php echo base_url().'gradingsystem/getCPR_graph/'?>"+id+'/'+section_id+'/'+subject_id+'/'+term
      $.ajax({
                   type: "GET",
                   url: url,
                   //dataType:'json',
                   data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
                   success: function(data)
                   {
                       $('#graph').html(data)
                       if(prev=="")
                        {
                            document.getElementById("prevSelected").value = id;
                            document.getElementById(id+'_tr').style.background='#F5F5F5'
                        }
                    if(prev==id){
                        if(document.getElementById(id+'_tr').style.background !='#FFF'){
                            document.getElementById(id+'_tr').style.background='#FFF'
                        }else{
                            document.getElementById(id+'_tr').style.background='#F5F5F5'
                        }

                    }
                    if(prev!=id){
                        document.getElementById(id+'_tr').style.background='#F5F5F5'
                        document.getElementById(prev+'_tr').style.background='#FFF'
                        document.getElementById("prevSelected").value = id;
                    };
                   }
      })    
}
</script>