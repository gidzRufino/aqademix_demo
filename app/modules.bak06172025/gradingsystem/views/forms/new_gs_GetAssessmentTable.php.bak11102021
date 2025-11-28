<div id="assessWrapper" class="hide">
    <div class="pull-left">
        <h6>Date of Test: <span id="date"><?php echo $getAssessment->assess_date ?></span></h6>
        <h6>Assessment Category: <?php echo $getAssessment->component ?></h6>
        <h6>Number of Items: <span id='numberOfItems'><?php echo $getAssessment->no_items ?></span></h6>
      </div> 
      <div class="pull-right">
        <h6>Subject: <?php echo ($getAssessment->subject_id==10?'TLE':$getAssessment->subject) ?></h6>
        <h6>Grade: <?php echo $getAssessment->level ?></h6>
        <h6>Section: <?php echo $getAssessment->section ?></h6>  
        <input type="hidden" id="qcode" value="<?php echo $getAssessment->assess_id ?>" />
      </div>
</div>


<div class="row">
    <div class="span12"> 
        <?php
            if($gs_settings->used_specialization && $getAssessment->subject_id == 10):
                switch ($getAssessment->grade_id):
                    case 10:
                    case 11:
                        $getSpecs = Modules::run('academic/getSpecificSubjectAssignment',$this->session->userdata('employee_id'), $getAssessment->section_id, $getAssessment->subject_id);
                        $Students = Modules::run('academic/getStudentWspecializedSubject', $getSpecs->specs_id);
                    break;    
                    default:
                            $Students = Modules::run('registrar/getAllStudentsForExternal', NULL, $getAssessment->section_id); 
                    break;
                endswitch;
            else:
                if($getAssessment->grade_id==12 || $getAssessment->grade_id==13):
                    if($getAssessment->is_core):
                        $Students = Modules::run('registrar/getAllStudentsForExternal', NULL, $getAssessment->section_id); 
                    else:
                        $Students = Modules::run('registrar/getAllStudentsBasicInfoByGender',$getAssessment->grade_id, NULL, 1, $getAssessment->school_year, $strand_id, $getAssessment->section_id);
                        //print_r($getAssessment->grade_id.' ');
                    endif;
                else:
                    $Students = Modules::run('registrar/getAllStudentsForExternal', NULL, $getAssessment->section_id, NULL, 1); 
                    
                endif;
            endif;
              
               ?>
               <table id="tableResult"  class="editableTable table table-striped table-bordered"> 
               
                   <tr> 
                       <td class="col-lg-4">Students</td> 
                       <td style="text-align:center;">Raw Score
                           
                           </td> 
                   </tr> 
                <?php
                    $n = 0;
                    foreach($Students->result() as $st){
                    $n++;
                ?>
                   <tr > 
                       <td style="font-size:14px;" id=""><?php echo $st->st_id.' '. strtoupper($st->lastname.', '.$st->firstname) ?></td> 
                       <?php
                       $qz = Modules::run('gradingsystem/getRawScore', $st->st_id, $getAssessment->assess_id);
                       $score = $qz->row();
                        ?>
                           <td tdn="<?php echo $st->st_id ?>" class="editable" style="text-align: center; font-size:14px;" id="<?php echo $n; ?>" >
                       <?php
                         if($qz->num_rows()>0){ echo $score->raw_score;} ?>
                       </td>

                   </tr> 
                <?php
                    }
                ?>
                  
           </table>
       </div>
</div>

<script type="text/javascript">
        $(document).ready(function() {
            var label = 'Record Assessment Results';
            var btnLabel = $('#lockedBtnLabel').val();
            $('#lockID').html(btnLabel)
            $('#lockID').attr('alt', $('#altLockBtnLabel').val());        
        });
        
function sortByPercentage(percentage)
      {
          var sortControl = $('#sortControl').val()
          if(sortControl=="desc"){
              sortControl = "asc";
              $('#sortControl').val("asc")
          }else{
              $('#sortControl').val("desc")
              sortControl = 'desc'
          }
           var url = "<?php echo base_url().'gradingsystem/getRowSort/'?>"+percentage ;
           var quizCode = document.getElementById('qcode').value;
          $.ajax({
           type: "POST",
           url: url,
           data: 'sortBy='+percentage+'&qcode='+quizCode+'&sortControl='+sortControl, // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
              $('#tableResult').html(data)
             
           }
         });
      }
      
$(function () { 
$(".editable").dblclick(function () 
{   
    var altLockBtnLabel = $('#altLockBtnLabel').val();
    var OriginalContent = $(this).text(); 
    var ID = $(this).attr('tdn');
    var tdn = $(this).attr('id');
   
    $(this).addClass("cellEditing"); 
    $(this).html("<input  type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
    $(this).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $(this).val(); 
            var searchDate = document.getElementById('date').innerHTML;
            var quizCode = document.getElementById('qcode').value;
            var numberOfItems = document.getElementById('numberOfItems').innerHTML;
            
            
              var dataString = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems+"&original="+OriginalContent+"&relock=0"+'&csrf_test_name='+$.cookie('csrf_cookie_name')  
            
            
            $(this).parent().text(newContent); 
            $(this).parent().removeClass("cellEditing");
            //ID.trigger('dblclick'); 
            
            if(parseInt(numberOfItems) >= parseInt(newContent)){

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'gradingsystem/recordScore' ?>",
                dataType: 'json',
                data: dataString,
                cache: false,
                success: function(data) {
                  $('#success').html(data.msg);
                  $('#alert-info').fadeOut(5000);
                  
                    var nxt = parseInt(1)+parseInt(tdn);
                    getNext(nxt)
                }
            });

            }else{
                alert('Score is greater than the number of Items. Score will not be recorded')
                $('#'+ID).html('')
            }
        } 
    }); 

        $(this).children().first().blur(function(){ 
        $(this).parent().text(OriginalContent); 
        $(this).parent().removeClass("cellEditing"); 
    }); 
}); 
});

function getNext(id)
{
            var ID = $('#'+id).attr('tdn');
            var tdn = $('#'+id).attr('id');
            
            var OriginalContent = $('#'+id).text(); 
            $('#'+id).addClass("cellEditing"); 
            $('#'+id).html("<input id ='input_"+tdn+"'type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
            $('#'+id).children().first().focus(); 
            $('#'+id).children().first().keypress(function (e) 
            { if (e.which == 13) { 
                    
                    var newContent = $('#input_'+id).val();
                    
                    $('#'+id).text(newContent); 
                    $('#'+id).parent().removeClass("cellEditing");
                    
                    var searchDate = document.getElementById('date').innerHTML;
                    var quizCode = document.getElementById('qcode').value;
                    var numberOfItems = document.getElementById('numberOfItems').innerHTML;
                    var nxt = parseInt(1)+parseInt(tdn);
                    getNext(nxt);

                      var dataString2 = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems+"&original="+OriginalContent+"&relock=0"+'&csrf_test_name='+$.cookie('csrf_cookie_name')  
                      
                      if(parseInt(numberOfItems) >= parseInt(newContent)){

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url().'gradingsystem/recordScore' ?>",
                            dataType: 'json',
                            data: dataString2,
                            cache: false,
                            success: function(data) {
                              $('#success').html(data.msg);
                              $('#alert-info').fadeOut(5000);

                                var nxt = parseInt(1)+parseInt(tdn);
                                getNext(nxt)
                            }
                        });

                        }else{
                            alert('Score is greater than the number of Items. Score will not be recorded')
                            $('#'+ID).html('')
                        }
                   
                } 
            });

        $('#'+id).children().first().blur(function(){ 
            $('#'+id).text(OriginalContent); 
            $('#'+id).parent().removeClass("cellEditing"); 
        });
}
</script>

