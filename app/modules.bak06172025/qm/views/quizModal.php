<div id="addQuiz"  style="width:45%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Create Quiz
        </div>
        <div class="panel-body clearfix">
<!--            
            <div class="control-group">
               <div class="controls">
                   <select  tabindex="-1" id="inputQuizItem" style="width:100%; margin-bottom: 5px;"  class="populate select2-offscreen span2">
                       <option>Select Test</option>
                       <?php 
                            foreach ($quiz_item as $qi) 
                              {   
                             ?>                        
                                <option value="<?php echo $qi->qi_id; ?>"><?php echo $qi->qi_title; ?></option>
                           <?php }?>
                   </select>

                </div>
            </div>
            -->
            <div class="control-group">
               <div class="controls">
                   <select  tabindex="-1" id="inputQuizType" style="width:100%; margin-bottom: 5px;"  class="populate select2-offscreen span2">
                       <option>Select Quiz Type</option>
                       <?php 
                            foreach ($quiz_type as $qt) 
                              {   
                             ?>                        
                                <option value="<?php echo $qt->qm_type_id; ?>"><?php echo $qt->qm_type; ?></option>
                           <?php }?>
                   </select>

                </div>
            </div>
            <div id="question_wrapper" class="control-group" style="display:none;">
               <div class="controls">
                   <textarea class="textarea form-control" id="question" rows="5" cols="12" placeholder="Question"></textarea>
               </div>
            </div>    
            <div id="multipleChoice" style="display:none;" class="control-group col-lg-6 no-padding">
               <div class="controls">
                  <span class="pull-left">Number of choices &nbsp<input type="number" min="1" style="width:40px; font-size: 12px; text-align: center;" id="num_of_choices" name="num_of_choices" placeholder="#"></span>
               </div>
                <div class="col-lg-12">
                    <ol type="a" id="mcChoices">
                    
                    </ol>
                </div>
            </div>
           <div class="controls" id="answerWrapper" style="display: none;">
               <input type="text" class="form-control" id="answer" placeholder="Answer" />
           </div>    
        </div>
        <div class="modal-footer clearfix">
            <button class="btn btn-small btn-success pull-right" id="addItem">ADD</button>
        </div>
        <input type="hidden" id="subject_id" />
    </div>
</div>
<div id="createQuiz"  style="width:45%; margin: 20px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green"  style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button class="pull-right btn btn-xs btn-info" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 ondblclick="$('#a_qq_title').hide(), $('#qq_title').show(),$('#qq_title').val($(this).html())" id="a_qq_title" style="display: none;"></h4>
            <input placeholder="Please Enter your Assessment Title" style="width:300px; color:black" type="text" id="qq_title"
                       onkeypress="if (event.keyCode==13){$('#a_qq_title').html(this.value),$('#a_qq_title').show(), $('#qq_title').hide()}"
                        title=""
                        onblur="if(this.value!=''){$('#a_qq_title').show(), $('#qq_title').hide()}"/>
        </div>
        <div class="panel-body clearfix">
            <div class="control-group">
               <div class="controls">
                   <select  tabindex="-1" id="inputSubjectAssign" style="width:100%; margin-bottom: 5px;"  class="populate select2-offscreen span2">
                       <option>Select Subject</option>
                       <?php 
                       
                            foreach ($subjects   as $s) 
                              {   
                             ?>                        
                                <option value="<?php echo $s->subject_id; ?>"><?php echo $s->subject; ?></option>
                           <?php }?>
                   </select>

                </div>
            </div>
            <div class="control-group">
               <div class="controls">
                   <select  tabindex="-1" id="inputQuizCategory" style="width:95%; margin-bottom: 5px;"  class="populate select2-offscreen span2">
                       <option>Select Category</option>
                       <?php 
                       
                            foreach ($quiz_cat as $qc) 
                              {   
                             ?>                        
                                <option value="<?php echo $qc->qc_id; ?>"><?php echo $qc->qm_category; ?></option>
                           <?php }?>
                   </select>
                   <button class="btn btn-xs btn-warning" onclick="$('#addQuizCategory').modal('show')"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                     <select  class="form-control" style="height:35px;" name="inputGrade" onclick="selectSection(this.value)" id="inputGrade" required>
                        <option>Select Grade Level</option> 
                        <?php 
                               foreach ($grade as $level)
                                 {   
                           ?>                        
                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="control-group" style="margin-top:5px;">
                <div class="controls">
                    <div id="AddedSection">
                      <select  class="form-control" style="height:35px;"  name="inputSection" id="inputSection" required>
                          <option>Select Section</option>  
                      </select>
                    </div>
                </div>
            </div>
            <div class="control-group" style="margin-top:5px;">
                <div class="controls">
                    <input style="margin-right: 10px;" class="form-control" name="inputDateOfExam" type="text" data-date-format="yyyy-mm-dd" id="inputDateOfExam" placeholder="Date of Exam" required>
                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button style="margin-top:5px;" data-dismiss="modal" onclick="saveQuizItem()" class="btn btn-success btn-xs pull-right">SAVE</button>
        </div>
    </div>
</div>
<div id="addQuizCategory"  style="width:20%; margin: 30px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow"  style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button class="pull-right btn btn-xs btn-danger" data-dismiss="modal"><i class="fa fa-close"></i></button>
            Add Category
        </div>
        <div class="panel-body clearfix" style="padding:5px;">
            <div class="control-group">
                <div class="controls">
                    <input type="text" class="form-control" id="inputQC" name="inputQC" />
                </div>
            </div>
            <button style="margin-top:5px;" data-dismiss="modal" onclick="addQuizCategory()" class="btn btn-success btn-xs pull-right">SAVE</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var numChoices = 0;
        $('#inputDateOfExam').datepicker();
        $('#inputSubjectAssign').select2();
        $('#inputQuizCategory').select2();
        $('#inputQuizItem').select2();
        $('#inputQuizType').select2();
        $('#inputQuizType').click(function(){
            switch($(this).val())
            {
                case '1':
		case '3':
		case '4':
                    $('#question_wrapper').show();
                    $('#multipleChoice').hide();
                    $('#answerWrapper').show();
                break;    
                case '2':
                    $('#question_wrapper').show();
                    $('#multipleChoice').show();
                    $('#answerWrapper').show();
                break; 
                default:
                    $('#answerWrapper').hide();
                    $('#question_wrapper').hide();
                    $('#multipleChoice').hide();
                break;
            }
        })
        $('#num_of_choices').change(function(){
            var cur = this.value;
            
            if(cur>=numChoices){
                numChoices += 1;
                $('#mcChoices').append(
                    '<li id="mc_'+numChoices+'"><input id="mc_input_'+numChoices+'" class="mcChoices_input" type="text" class="form-control" /></li>'    
                );
            }else{
                $('#mc_'+numChoices).remove()
                numChoices = numChoices-1;
                //alert('sub'+numChoices);
            }
            //alert(numChoices)
        });
        
        $('#addItem').click(function(){
            var qt = $('#inputQuizType').val();
            var qq = tinyMCE.get('question').getContent();
            var ans = $('#answer').val();
            var qi = '<?php echo $this->uri->segment(3) ?>';
            if(qt=='2')
            {
                var mulAns = [];
                for(var item=1;item<=numChoices;item++)
                {
                    mulAns.push($('#mc_input_'+item).val())
                }
                var choices = mulAns.toString();
            }else{
                choices = "";
            }
            //console.log(qq)
            var url = "<?php echo base_url().'qm/addQuestions/'?>";
            $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 'qt='+qt+'&qq='+encodeURIComponent(qq)+'&ans='+ans+'&choices='+choices+'&qi='+qi+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   alert('successfully Added');
                   location.reload();
               }
            });
        })
            
    });
    
    function addQuestions()
    {
        
    }
    
    function addQuizCategory()
    {
        var quizCat = $('#inputQC').val();
        var url = "<?php echo base_url().'qm/saveCategory/'?>";
        $.ajax({
                   type: "POST",
                   url: url,
                   dataType:'json',
                   data: 'quizCat='+quizCat+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                   success: function(data)
                   {
                       $('#inputQuizCategory').prepend("<option value='"+data.cat_id+"'>"+data.category+"</option>");
                       alert('Added Successfully')
                   }
        });
    }
    
    function saveQuizItem()
    {
        var qi_title = $('#qq_title').val();
        var subject = $('#inputSubjectAssign').val();
        var category = $('#inputQuizCategory').val();
        var grade = $('#inputGrade').val();
        var section = $('#inputSection').val();
        var dateOfExam = $('#inputDateOfExam').val();
        
        var url = "<?php echo base_url().'qm/saveQuizItem/'?>";
        $.ajax({
                   type: "POST",
                   url: url,
                   dataType:'json',
                   data: 'qi_title='+qi_title+'&subject='+subject+'&category='+category+'&grade='+grade+'&section='+section+'&dateOfExam='+dateOfExam+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                   success: function(data)
                   {
                       alert(data.msg)
                   }
        });
    }
    
        
    function selectSection(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputSection').html(data);
               }
             });

        return false;
    }

</script>
