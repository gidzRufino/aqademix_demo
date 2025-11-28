<div class="col-xs-12">
    <div class="col-xs-12 mobile-blue-trans">
        <table style="font-size: 12px; margin-top:5px; " class="table table-bordered">
            <tr>
                <td>
                    Date of Test
                </td>
                <td>
                    <span id="date"><?php echo $getAssessment->assess_date ?></span>
                </td>
            </tr>
            <tr>
                <td>
                Assessment Category
                </td>
                <td>
                    <span><?php echo $getAssessment->category_name ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Subject
                </td>
                <td>
                    <span> <?php echo $getAssessment->subject ?></span>
                </td>
                
            </tr>
            <tr>
                <td>
                    Grade
                </td>
                <td >
                    <span>  <?php echo $getAssessment->level ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Section
                </td>
                <td >
                    <span><?php echo $getAssessment->section ?></span>
                    
                    <input type="hidden" id="qcode" value="<?php echo $getAssessment->assess_id ?>" />
                </td>
            </tr>
        </table>
        
        <h4 class="text-center">Number of Items: <span id='numberOfItems'><?php echo $getAssessment->no_items ?></span></h4>
    </div>
    
</div>

<div class="col-xs-12">
     <?php
            $Students = Modules::run('registrar/getAllStudentsForExternal', $getAssessment->grade_id, $getAssessment->section_id);   
               ?>
    <div class="col-xs-12 mobile-blue-trans no-padding">
        <table class="table table-stripped table-bordered">
            <tr>
                <th>
                    STUDENTS
                </th>
                <th class="text-center">
                    RAW SCORE
                </th>
            </tr>

        <?php
            $count = 0;
            foreach($Students->result() as $st){
                $count = $count+1;
        ?>
            <tr style="height:15px !important;">
                <td>
                <?php echo strtoupper($st->firstname.' '.$st->lastname) ?>  
                </td>
            
                <?php
                   $qz = Modules::run('gradingsystem/getRawScore', $st->st_id, $getAssessment->assess_id);
                   $score = $qz->row();
                ?>
                <td class="col-xs-4 text-center" id="score_<?php echo $st->st_id ?>" count="<?php echo $count; ?>"  name="<?php echo strtoupper($st->firstname.' '.$st->lastname) ?>" user_id="<?php echo $st->st_id ?>" score="<?php if($qz->num_rows()>0){ echo $score->raw_score;} ?>">
                        <?php if($qz->num_rows()>0){ echo $score->raw_score;}else{echo '0';} ?>
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

var count = 0;

function saveScore()
{
    var score = $('#rawScore').val();
    var ID = $('#score_user_id').val();
    count = $('#score_'+ID).attr('count');
    varNewCount = parseInt(count)+1;
    //$('#enterScore').addClass('hide') 
    //$('#secretContainer').addClass('hide') 
    var newContent = score; 
    var searchDate = document.getElementById('date').innerHTML;
    var quizCode = document.getElementById('qcode').value;
    var numberOfItems = document.getElementById('numberOfItems').innerHTML;

    var dataString = 'rawScore='+newContent + "&recordStudent="+ID+"&searchDate="+searchDate+"&quizCode="+quizCode+"&total="+numberOfItems;
    
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
             $('#enterScore').addClass('hide');
              
    $('#secretContainer').addClass('hide');
            }
        });

        }else{
            alert('Score is greater than the number of Items. Score will not be recorded')
            $('#'+ID).html('')
        }

}

function replenish(name, id, count)
{
    $('#rawScore').val()
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
