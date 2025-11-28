<div id="addQuiz"  style="width:35%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Create Quiz
        </div>
        <div class="panel-body clearfix">
            <div class="control-group">
               <div class="controls">
                   <input type="text" class="form-control" id="qq_title" placeholder="Assessment Title" />
               </div>
            </div>
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
                   <input type="text" class="form-control question" id="question" placeholder="Question" />
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
        </div>
        <div class="modal-footer clearfix">
            <button class="btn btn-small btn-success pull-right" id="addItem">ADD</button>
        </div>
        <input type="hidden" id="subject_id" />
</div>  

<script type="text/javascript">
    $(document).ready(function() {
        var numChoices = 0;
        $('#inputSubjectAssign').select2();
        $('#inputQuizType').select2();
        $('#inputQuizType').click(function(){
            switch($(this).val())
            {
                case '1':
                    $('#question_wrapper').show();
                    $('#multipleChoice').hide();
                break;    
                case '2':
                    $('#question_wrapper').show();
                    $('#multipleChoice').show();
                break; 
                default:
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
            var question = $('#question').val();
            var subject_id = $('#inputSubjectAssign').val();
            var type_id = $('#inputQuizType').val()
            if(type_id=='2')
            {
                for(var item=1;item<=numChoices;item++)
                {
                    alert($('#mc_input_'+item).val())
                }
            }
        })
            
    });

</script>

<html moznomarginboxes mozdisallowselectionprint>
    <head></head>
    <body>
        <style>
</style>
        <math title="sqrt(1/4)">
  <mstyle fontfamily="Times,STIXGeneral,serif" displaystyle="true">

    <msqrt>
      <mrow>
        <mfrac>
          <mn>1</mn>
          <mn>4</mn>
        </mfrac>
      </mrow>
    </msqrt>

  </mstyle>
</math>
        <div class="col-lg-12 clearfix">
        <ol id="quiz_items">
                            ___________<li  style="margin-bottom:5px;">It is a part of speech that denotes a person, animal, place, thing, or idea.<span id="li_1"> </span><br />
                                        <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="1" name="1"/>
                                    </li>
                                <li  style="margin-bottom:5px;">It is a word that takes the place of a noun.<span id="li_2"> </span><br />
                                        <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="2" name="2"/>
                                    </li>
                                <li  style="margin-bottom:5px;">These are words we use to describe other words.<span id="li_3"> </span><br />
                                        <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="3" name="3"/>
                                    </li>
                                <li  style="margin-bottom:5px;">It is a word that modifies a verb, adjective, another adverb, determiner, noun phrase, clause, or sentence.<span id="li_4"> </span><br />
                                        <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="4" name="4"/>
                                    </li>
                                <li  style="margin-bottom:5px;">It is a noun that is used to denote a particular person, place, or thing<span id="li_5"> </span><br />
                                        <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="5" name="5"/>
                                    </li>
                                <li  style="margin-bottom:5px;">I always go to the <b>Park</b> on Week Ends<span id="li_6"> </span><br />
                                        <input type="radio" name="sel_6" onclick="$('#6').val(this.value)" value="a" /> a. verb<br />

                                        <input type="radio" name="sel_6" onclick="$('#6').val(this.value)" value="b" /> b. noun<br />

                                        <input type="radio" name="sel_6" onclick="$('#6').val(this.value)" value="c" /> c. pronoun<br />

                                            <input  type="hidden" id="6" name="6" />
                                    </li>
                                <li  style="margin-bottom:5px;">During <b>cold</b> days, I like to drink a cup of hot chocolate<span id="li_7"> </span><br />
                                        <input type="radio" name="sel_7" onclick="$('#7').val(this.value)" value="a" /> a. verb<br />

                                        <input type="radio" name="sel_7" onclick="$('#7').val(this.value)" value="b" /> b. adverb<br />

                                        <input type="radio" name="sel_7" onclick="$('#7').val(this.value)" value="c" /> c. adjective<br />

                                            <input  type="hidden" id="7" name="7" />
                                    </li>
                                <li  style="margin-bottom:5px;">How many hot dogs your friend <strong>eat</strong> yesterday?<span id="li_9"> </span><br />
                                        <input type="radio" name="sel_9" onclick="$('#9').val(this.value)" value="a" /> a. noun<br />

                                        <input type="radio" name="sel_9" onclick="$('#9').val(this.value)" value="b" /> b. adverb<br />

                                        <input type="radio" name="sel_9" onclick="$('#9').val(this.value)" value="c" /> c. verb<br />

                                            <input  type="hidden" id="9" name="9" />
                                    </li>
                                <li  style="margin-bottom:5px;">August is my <strong>favorite</strong> month in a year.<span id="li_10"> </span><br />
                                        <input type="radio" name="sel_10" onclick="$('#10').val(this.value)" value="a" /> a. adjective<br />

                                        <input type="radio" name="sel_10" onclick="$('#10').val(this.value)" value="b" /> b. verb<br />

                                        <input type="radio" name="sel_10" onclick="$('#10').val(this.value)" value="c" /> c. noun<br />

                                            <input  type="hidden" id="10" name="10" />
                                    </li>
                                <li  style="margin-bottom:5px;">I <strong>usually</strong> study in the library in an hour after class.<span id="li_11"> </span><br />
                                        <input type="radio" name="sel_11" onclick="$('#11').val(this.value)" value="a" /> a. adjective<br />

                                        <input type="radio" name="sel_11" onclick="$('#11').val(this.value)" value="b" /> b. adverb<br />

                                        <input type="radio" name="sel_11" onclick="$('#11').val(this.value)" value="c" /> c. noun<br />

                                            <input  type="hidden" id="11" name="11" />
                                    </li>
                        </ol>
    </div>
        <script src="<?php echo base_url().'assets/js/editor/tinymce/'?>tiny_mce.js"></script>

<script type="text/javascript" src="<?php echo base_url().'assets/js/editor/tinymce/'?>/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script>


<script type="text/javascript">
   $(document).ready(function() { 
       //tinymce.init({ forced_root_block : "", selector:'#question' });
       tinyMCE.init({
        forced_root_block : "",   
        mode : "textareas",
        theme : "advanced",
        theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
        theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg",
        theme_advanced_buttons3 : "",
        theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        plugins : 'asciimath,asciisvg,table,inlinepopups,media,tiny_mce_wiris',

        AScgiloc : '<?php echo base_url().'assets/js/editor/tinymce/'?>php/svgimg.php',			      //change me  
        ASdloc : '<?php echo base_url().'assets/js/editor/tinymce/'?>plugins/asciisvg/js/d.svg',  //change me  	

        content_css : "css/content.css"
    });
        $('#submitQuiz').click(function(){
            var finalAnswer = []
            var answer
            var i = 0;
            $('#quiz_items :input[type=text],#quiz_items :input[type=hidden]').each(function(){
                answer = {
                    'id': $(this).attr('id'),
                    'ans': $(this).val()
                }
                
               finalAnswer.push(answer);
            });
            
            //console.log(JSON.stringify(finalAnswer))
            var url = "<?php echo base_url().'qm/saveAnswers/'?>";
            $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: 'answer='+JSON.stringify(finalAnswer)+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   var checkAns = [];
                   var wrongAns = [];
                   var wrong = data.wrong;
                   var check = data.check;
                   for (var i = 0; i < check.length; i++) {
                       checkAns.push(check[i])
                       $('#li_'+check[i]).append(' <i class="fa fa-check text-success"></i>');
                   }
                   for (var w = 0; w < wrong.length; w++){
                       wrongAns.push(wrong[i]);
                       $('#li_'+wrong[w]).append(' <i class="fa fa-close text-danger"></i>');
                       }
                   console.log('check :'+checkAns);
               }
            });
        });
        
        $('#publishQuiz').click(function(){
            
            var qi = '<?php echo $this->uri->segment(3) ?>';
            
            var cf = confirm('Are you sure you want to publish this Assessment? Doing so will prevent you from editing');
            if(cf==true){
                var url = "<?php echo base_url().'qm/publishQuiz/'?>";
                $.ajax({
                   type: "POST",
                   url: url,
                   //dataType:'json',
                   data: 'qi='+qi+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                   success: function(data)
                   {
                       alert('successfully published');
                   }
                });
            }
            
        });
   });
</script>
    </body>
</html>