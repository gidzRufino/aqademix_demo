<div id="assessWrapper" class="hide">
    <div class="pull-left">
        <h6>Date of Test: <span id="date"><?php echo $getAssessment->assess_date ?></span></h6>
        <h6>Assessment Category: <?php echo $getAssessment->category_name ?></h6>
        <h6>Number of Items: <span id='numberOfItems'><?php echo $getAssessment->no_items ?></span></h6>
      </div> 
      <div class="pull-right">
        <h6>Subject: <?php echo $getAssessment->subject ?></h6>
        <h6>Grade: <?php echo $getAssessment->level ?></h6>
        <h6>Section: <?php echo $getAssessment->section ?></h6>  
        <input type="hidden" id="qcode" value="<?php echo $getAssessment->assess_id ?>" />
      </div>
</div>


<div class="row">
    <div class="span12"> 
        <?php
            $Students = Modules::run('registrar/getAllStudentsForExternal', $getAssessment->grade_id, $getAssessment->section_id);   
               ?>
               <table id="tableResult"  class="editableTable table table-striped table-bordered"> 
               
                   <tr> 
                       <td class="col-lg-4">Students</td> 
                       <td style="text-align:center;">Raw Score &nbsp; 
<!--                           <a style="font-size:12px;" href="<?php echo base_url().'gradingSystem/viewClassRecord/' ?>">
                               [ View Class Record ]
                           </a>-->
                           
                           </td> 
                       <td style="cursor:pointer" onclick ="sortByPercentage('equivalent')">Percentage</td>    
                   </tr> 
                <?php
                    foreach($Students->result() as $st){
                ?>
                   <tr > 
                       <td style="font-size:14px;" id=""><?php echo $st->st_id.' '. strtoupper($st->lastname.', '.$st->firstname) ?></td> 
                       <?php
                       $qz = Modules::run('gradingsystem/getRawScore', $st->st_id, $getAssessment->assess_id);
                       $score = $qz->row();
                        ?>
                           <td class="editable" style="text-align: center; font-size:14px;" id="<?php echo $st->st_id ?>" >
                       <?php

                           
                         if($qz->num_rows()>0){ echo $score->raw_score;} ?>
                       </td>
                       <td <?php if($qz->num_rows()>0){ if($score->equivalent<75){echo "style='color:red;'";}} ?> id="<?php echo $st->st_id ?>_result" >
                            <?php if($qz->num_rows()>0){ echo $score->equivalent;}                     
                            ?>
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
    var ID = $(this).attr('id');
   
    $(this).addClass("cellEditing"); 
    $(this).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
    $(this).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $(this).val(); 
            var searchDate = document.getElementById('date').innerHTML;
            var quizCode = document.getElementById('qcode').value;
            var numberOfItems = document.getElementById('numberOfItems').innerHTML;
            
            if(altLockBtnLabel=='relock'){
              var dataString = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems+"&original="+OriginalContent+"&relock=1"+'&csrf_test_name='+$.cookie('csrf_cookie_name')  
            }else{
              var dataString = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems+"&original="+OriginalContent+"&relock=0"+'&csrf_test_name='+$.cookie('csrf_cookie_name')  
            }
            
            $(this).parent().text(newContent); 
            $(this).parent().removeClass("cellEditing");

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
                  $('#'+ID+'_result').html(data.equivalent)
                  if(data.equivalent<75){
                      $('#'+ID+'_result').attr('style','color:red;');
                  }
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
</script>
