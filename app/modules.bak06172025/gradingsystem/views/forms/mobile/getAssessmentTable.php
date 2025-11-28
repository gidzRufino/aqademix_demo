<div class="row">
    <div class="col-xs-12">
            <div class="col-xs-6">
        <h6>Date of Test: <span id="date"><?php echo $getAssessment->assess_date ?></span></h6>
      <h6>Assessment Category: <?php echo $getAssessment->category_name ?></h6>
      <h6>Number of Items: <span id='numberOfItems'><?php echo $getAssessment->no_items ?></span></h6>
    </div> 
    <div class="col-xs-6">
      <h6>Subject: <?php echo $getAssessment->subject ?></h6>
      <h6>Grade: <?php echo $getAssessment->level ?></h6>
      <h6>Section: <?php echo $getAssessment->section ?></h6>  
      <input type="hidden" id="qcode" value="<?php echo $getAssessment->assess_id ?>" />
    </div>
    </div>

</div>

<div class="row">
     <?php
            $Students = Modules::run('registrar/getAllStudentsForExternal', $getAssessment->grade_id, $getAssessment->section_id);   
               ?>
    <div class="col-xs-12 table-responsive">
        <table class="table table-stripped table-bordered">
            <tr>
                <th>
                    STUDENTS
                </th>
                <th>
                    RAW SCORE
                </th>
                <th>
                    PERCENTAGE
                </th>
            </tr>

        <?php
            foreach($Students->result() as $st){
                
        ?>
            <tr style="height:15px !important;">
                <td>
               <?php echo strtoupper($st->firstname.' '.$st->lastname) ?>  
                </td>
            
                <?php
                   $qz = Modules::run('gradingsystem/getRawScore', $st->st_id, $getAssessment->assess_id);
                   $score = $qz->row();
                ?>
                <td  class="col-xs-4" id="score_<?php echo $st->st_id ?>"  name="<?php echo strtoupper($st->firstname.' '.$st->lastname) ?>" user_id="<?php echo $st->st_id ?>" score="<?php if($qz->num_rows()>0){ echo $score->raw_score;} ?>">
                        <?php if($qz->num_rows()>0){ echo $score->raw_score;}else{echo '0';} ?>
                </td>
                <td <?php if($qz->num_rows()>0){ if($score->equivalent<75){echo "style='color:red; height:45px;'";}else{ echo 'style="height:60px" ';}}else{ echo 'style="height:60px" ';} ?> id="<?php echo $st->user_id ?>_result">
                   <?php if($qz->num_rows()>0){ echo $score->equivalent;}   ?>
                </td>
            </tr>
        <?php
          }
        ?>
    </div><!-- /grid-c -->
    </table>
     <!--onclick="showRecordScore('<?php echo $st->user_id ?>', '<?php if($qz->num_rows()>0){ echo $score->raw_score;} ?>')"-->
</div>
<div id="scoreModal">
    <div id="enterScore" class="hide" style="width:90%; margin:0 auto; border-radius:5px; height:150px !important; padding:5px; background:white;">
        <div class="contentHeader">
            <h4 id="h_score">Enter Raw Score</h4>
        </div>
        <input style="height:30px;"  name="assessTitle" type="text" id="rawScore" placeholder="Score" required>
        <input id="score_user_id" type="hidden" value="" />
        <div class="pull-right">
            <button class="btn" onclick="$('#secretContainer').addClass('hide')"  data-dismiss="modal" aria-hidden="true" >Close</button>
            <button onclick="saveScore()" data-dismiss="modal" id="saveScoreBtn" class="btn btn-primary">Save </button>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">

$('.col-xs-4').bind("tap", function(e){
    var user_id = $(this).attr('user_id');
    var score = $(this).attr('score');
    var name = $(this).attr('name');
    $('#secretContainer').removeClass('hide');
    $('#secretContainer').html($('#scoreModal').html()) 
    $('#enterScore').removeClass('hide');
    $('#enterScore').fadeIn();
    $('#rawScore').val(score);
    $('#h_score').html(name);
    $('#score_user_id').val(user_id);
});
    
function showRecordScore(user_id, score)
{
    $('#enterScore').fadeIn();
    $('#rawScore').val(score);
    $('#score_user_id').val(user_id);
}
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

function saveScore()
{
    var score = $('#rawScore').val();
    var ID = $('#score_user_id').val();
    $('#enterScore').addClass('hide') 
    $('#secretContainer').addClass('hide') 
    var newContent = score; 
    var searchDate = document.getElementById('date').innerHTML;
    var quizCode = document.getElementById('qcode').value;
    var numberOfItems = document.getElementById('numberOfItems').innerHTML;

    var dataString = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems
    
    if(parseInt(numberOfItems) >= parseInt(newContent)){

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'gradingsystem/recordScore' ?>",
            dataType: 'json',
            data: dataString+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            cache: false,
            success: function(data) {

              $('#success').html(data.msg);
              $('#alert-info').fadeOut(5000);
              $('#score_'+ID).html(newContent)
              $('#'+ID+'_result').html(data.equivalent)
             // $('#score_'+ID).attr('style','background:#E9E9E9; text-align:center;  height:45px; font-weight:bold;');
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

function recordScore(editable)
{   
    var OriginalContent = $('.'+editable).text(); 
    var ID = $('.'+editable).attr('id');
   
    $(this).addClass("cellEditing"); 
    $(this).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
    $(this).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $(this).val(); 
            var searchDate = document.getElementById('date').innerHTML;
            var quizCode = document.getElementById('qcode').value;
            var numberOfItems = document.getElementById('numberOfItems').innerHTML;
            
            var dataString = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems
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
}
</script>
