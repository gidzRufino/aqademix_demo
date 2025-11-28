
<div class="col-lg-12 no-padding">
    <div class="page-header no-margin clearfix">
        <input type="hidden" id="qi_id" value="<?php echo $qdata->qi_id ?>" />
        <div class="col-lg-5 pull-right" style="margin-top: 5px;">
            <button class="btn btn-sm btn-default pull-right" ><i class="fa fa-cogs"></i></button>
            <button class="btn btn-sm btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-archive"></i></button>
            <button class="btn btn-sm btn-info pull-right" onclick="document.location='<?php echo base_url('qm') ?>'" style="margin-right: 5px;"><i class="fa fa-list"></i></button>
            <button class="btn btn-sm btn-primary pull-right" onclick="$('#createQuiz').modal('show')" style="margin-right: 5px;"><i class="fa fa-file"></i></button>
        </div>
        <h2 class="no-margin col-lg-7">Online Quiz Management</h2>
    </div>
</div>
<div class="col-lg-12">
    <?php if(!$qdata->qi_is_final):?>
    <button style="margin-top:10px;" onclick="$('#addQuiz').modal('show')" class="btn btn-xs btn-success pull-right"><i class="fa fa-plus"></i></button>
    <button id="publishQuiz" style="margin-top:10px; margin-right: 10px;" class="btn btn-xs btn-primary pull-right"><i class="fa fa-paper-plane"></i> Publish</button>
    <?php endif; ?>
    <button id="submitQuiz" style="margin-top:10px; margin-right: 10px;" class="btn btn-xs btn-warning pull-right"><i class="fa fa-paper-plane"></i> Submit</button>
    <h4><?php echo $qdata->qi_title ?></h4>
    <div class="col-lg-12 clearfix">
        <ol id="quiz_items">
            <?php 
            $questions = explode(',', $qdata->qi_qq_ids);
            if($qdata->qi_qq_ids!=""):
                foreach($questions as $qq=>$id ):
                    $qstn = Modules::run('qm/getQuizQuestions', $id);
                    $selection = Modules::run('qm/getQuizAnswer', $id, 0);
                ?>
                <li  style="margin-bottom:5px;"><?php echo $qstn->question; ?><span id="li_<?php echo $id ?>"> </span><br />
                    <?php
                    if($qstn->qq_qt_id!=2):?>
                    <input class="form-control" style="width:50%;" placeholder="answer" type="text" id="<?php echo $id ?>" name="<?php echo $id ?>"/>
                    <?php
                    else: 
                        foreach ($selection->result() as $choice):
                        ?>
                    <input type="radio" name="sel_<?php echo $id ?>" onclick="$('#<?php echo $id ?>').val(this.value)" value="<?php echo $choice->qs_selection ?>" /> <?php echo $choice->qs_selection.'. '.$choice->qs_choice ?><br />

                    <?php
                        endforeach;
                    ?>
                        <input  type="hidden" id="<?php echo $id ?>" name="<?php echo $id ?>" />
                    <?php
                    endif;
                    ?>
                </li>
                <?php
                endforeach;
            endif;
            ?>
        </ol>
    </div>
</div>
<script src="<?php echo base_url().'assets/js/editor/tinymce/'?>tiny_mce.js"></script>
<script src="<?php echo base_url().'assets/js/editor/'?>ASCIIMathML.js"></script>
<?php //$this->load->view('quizModal');?>

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
        plugins : 'asciimath,asciisvg,table,inlinepopups,media',

        AScgiloc : '<?php echo base_url().'assets/js/editor/'?>php/asciisvgimg.php',			      //change me  
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


