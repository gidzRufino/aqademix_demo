<section class="col-lg-12">
    <div class="card card-blue card-outline">
        <div class="card-body">
            <div class="col-xs-12 col-lg-12 float-left">
                <label for="Quiz Title">Quiz Title</label>
                <input type="text" class="form-control" id="quizTitle" placeholder="Quiz Title" />
            </div>
<!--            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Start Date</label>
                <input type="date" class="form-control" id="startDate" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Start Time</label>

                <input type="time" value="00:00 pm" class="form-control timePick" id="timeStart" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Date Deadline</label>
                <input type="date" class="form-control" id="deadlineDate" placeholder="">
            </div>
            <div class="form-group col-lg-6 col-xs-12 float-left">
                <label for="exampleInputEmail1">Time Deadline</label>

                <input type="time" value="00:00 pm" class="form-control timePick" id="timeDeadline" placeholder="">
            </div>-->
            
            <div class="col-xs-12 col-lg-6 pull-left">
                <label>Select Subject, Grade Level and Section </label>
                <select id="gradeLevel" class="form-control">
                    <?php foreach($getSubjects as $gl): 
                        ?>
                    <option value="<?php echo $gl->subject_id.'-'.$gl->grade_id.'-'.$gl->section_id ?>"><?php echo $gl->subject.' - '.$gl->level.' [ '. $gl->section.' ] '?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6 col-xs-12 float-right">
                <button onclick="createQuiz($(this))" id="createQuizBtn" class="btn btn-primary btn-sm float-right">Create Quiz</button>
            </div>
        </div>
    </div>
    <input type="hidden" id="quiz_id" value="0" />
    <input type="hidden" id="grade_level_id" value="<?php echo $gradeDetails->grade_level_id ?>" />
    <input type="hidden" id="section_id" value="<?php echo $gradeDetails->section_id ?>" />
    <input type="hidden" id="subject_id" value="<?php echo $subjectDetails->subject_id ?>" />
</section>

<section class="col-lg-6 float-left">
    <div class="card card-widget card-warning card-outline">
        <div class="card-header">
            Create a Question
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <select style="width:80% !important;"  tabindex="-1" id="inputQuizType">
                        <option>Select Quiz Type</option>
                        <?php
                        foreach ($quiz_type as $qt) {
                            ?>                        
                            <option value="<?php echo $qt->qm_type_id; ?>"><?php echo $qt->qm_type; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">

                <div id="question_wrapper" class="control-group" style="display:none;">
                    <div class="controls">
                        <label for="question">Question</label>
                        <textarea class="textarea form-control" id="question" rows="5" cols="12" placeholder="Question"></textarea>
                    </div>
                </div>    
                <div id="multipleChoice" style="display:none;" class="control-group col-lg-12 no-padding">
                    <div class="col-lg-12 controls">
                        <span class="pull-left">Number of choices &nbsp
                            <input type="number" min="1" style="width:40px; font-size: 14px; text-align: center;" id="num_of_choices" name="num_of_choices" placeholder="#">
                        </span>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <ol type="a" id="mcChoices">

                        </ol>
                    </div>
                </div>
                <div class="controls" id="answerWrapper" style="display: none;">
                    <div class="clearfix">
                        <input type="text" class="form-control" id="answer" placeholder="Answer" />
                    </div>
                    <div class="col-lg-12 mt-2 mb-2">
                        <button onclick="addToItems(0)" class="btn btn-primary btn-sm float-right">Add to Quiz Items</button>
                    </div>
                </div>
                <div class="controls" id="identAnswer" style="display: none;">
                    <div class="col-lg-12 mt-1 mb-2">
                        <button onclick="addAnswerBox()" class="btn btn-transparent btn-xs float-right" title="Add Answer Box"><i class="fa fa-plus fa-xs text-success"></i></button>
                    </div>
                    <div class="clearfix mt-2" id="answerBoxes">
                        <input type="text" class="form-control answer" class="answer" placeholder="Answer" />
                    </div>
                    <div class="col-lg-12 mt-2 mb-2">
                        <button onclick="addToItems(1)" class="btn btn-primary btn-sm float-right">Add to Quiz Items</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="float-left col-lg-6">
    <div class="card card-green card-outline">
        <div class="card-header">
            Quiz Items
            <button onclick="$('#loadQuestion').modal('show')" class="btn btn-xs btn-primary float-right">Load a Question</button>
        </div>   
        <div class="card-body">

            <div id="qWrapper">
                <ol id="quizItems">

                </ol>
            </div>
        </div>
    </div>
    
    <div class="modal" id='loadQuestion' tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card card-green card-outline">
                    <div class="card-header">
                        Load Question
                    </div>
                    <div class="card-body">
                        <input type="text" onkeyup="searchQuestions(this.value)" id="searchBox"  class="form-control input-lg" aria-label="..." placeholder="Search Name Here" />

                        <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 85%; display: none;" class="resultOverflow" id="searchQuestions">

                        </div>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
</section>



<script type="text/javascript">
    $(document).ready(function () {
       
        var numChoices = 0;
        var numItems = 0;
        var nex = 'a';
        $('#inputQuizType').on('select2:select', function (e) {
            addQT();
        });
        $('.timePick').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        $('.textarea').summernote();
        
        addAnswerBox = function () {
            $("#answerBoxes").append('<input type="text" class="form-control answer mt-1" class="answer" placeholder="Answer" />');
        }

        addQT = function () {
            var qt = $('#inputQuizType').val();
            switch (qt)
            {
                case '1':
                    $('#question_wrapper').show();
                    $('#multipleChoice').hide();
                    $('#answerWrapper').hide();
                    $('#identAnswer').show();
                    break;
                case '2':
                    $('#question_wrapper').show();
                    $('#multipleChoice').hide();
                    $('#answerWrapper').show();
                    break;
                case '3':
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
        };

        $('#num_of_choices').change(function () {
            var cur = this.value;

            if (cur >= numChoices) {
                numChoices += 1;
                $('#mcChoices').append(
                        '<li id="mc_' + numChoices + '"><input id="mc_input_' + numChoices + '" class="mcChoices_input" type="text" class="form-control" /></li>'
                        );
            } else {
                $('#mc_' + numChoices).remove()
                numChoices = numChoices - 1;
                //alert('sub'+numChoices);
            }
            //alert(numChoices)
        });
        
        remove = function(q) {
            q.remove();
            var list = $('#quizItemList').val();
            var remList = removeValue(list, q.attr('q_code'));
            $('#quizItemList').val(remList);
        };
        
        getSingleQuestion = function(value) {
            var quiz_code = $('#quiz_id').val();
            var url = "<?php echo base_url() . 'opl/qm/getSingleQuestion/' ?>"+value+'/<?php echo $school_year ?>/'+quiz_code;
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (response)
                {
                    $('#quizItems').append(response);
                    
                }
            });
        };
        
        searchQuestions = function(value) {
        
            var url = "<?php echo base_url() . 'opl/qm/searchQuestions/' ?>"+value+'/'+'<?php echo $school_year ?>';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                     $('#searchQuestions').show();
                     $('#searchQuestions').html(data);
                    
                }
            });
        };
        
        createQuiz = function (b) {
             var url = "<?php echo base_url() . 'opl/qm/createQuiz/' ?>";
            $.ajax({
                type: "POST",
                url: url,
                dataType:'json',
                data: {
                    quizTitle   : $('#quizTitle').val(),
                    quiz_id     : $('#quiz_id').val(),
                    subGradeSec : $('#gradeLevel').val(),
//                    startDate   : $('#startDate').val()+' '+$('#timeStart').val(),
//                    endDate     : $('#deadlineDate').val()+' '+$('#timeDeadline').val(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    $('#createQuizBtn').remove();
                    $('#quiz_id').val(data.quiz_code);
                    showNotification('System','Quiz Successfully Created');
                }
            });
        };

        addToItems = function (type) {
            var qt = $('#inputQuizType').val();
            var qq = $('#question').val();
            var ans = $('#answer').val();
            var qi = '<?php echo $this->uri->segment(3) ?>';
            if(type!=0){
                var ansbox = $("#answerBoxes").find('.answer');
                ans = "";
                $.each(ansbox, function(idx, val){
                    var newval = $(val).val();
                    if(newval.length != 0){
                        ans += newval+"|";
                    }
                })
                ans = ans.slice(0, -1);
//                console.info(ans);
            }
            if (qt == '3')
            {
                var mulAns = [];
                for (var item = 1; item <= numChoices; item++)
                {
                    mulAns.push($('#mc_input_' + item).val())
                }
                var choices = mulAns.toString();
            } else {
                choices = "";
            }
            numItems++;
            var url = "<?php echo base_url() . 'opl/qm/loadCode/' ?>";
            $.ajax({
                type: "POST",
                url: url,
                //dataType:'json',
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
                success: function (data)
                {
                    loadQuestions(qt, qq, ans, choices, data);
                }
            });
            //console.log(qq)
        };

        loadQuestions = function (qt, question, answer, choices, code)
        {
            var answerOptions = "";
            switch (qt)
            {
                case "1":
                        answerOptions = '<input type="text" qt="1" q_id="' + code + '" name="answerText_'+code+'" class="form-control answerOption" />';
                    break;
                case "2":
                    answerOptions += '<ul class="qm_question" style="list-style:none;">';
                    answerOptions += '<li><input type="radio" qt="2"  q_id="' + code + '" name="trueFalse_' + code + '" value="true" class="answerOption" /> &nbsp; TRUE</li>';
                    answerOptions += '<li><input type="radio" qt="2"  q_id="' + code + '" name="trueFalse_' + code + '" value="false" class="answerOption" /> &nbsp; FALSE</li>';
                    answerOptions += '</ul>';
                    break;
                case "3":
                    var choiceItems = choices.split(',');
                    answerOptions += '<ol class="qm_question" type="a">';
                    for (var c = 0; c < choiceItems.length; c++)
                    {
                        answerOptions += '<li><input type="radio" qt="3" name="choices_' + code + '" value="' + nex + '" class="answerOption" /> &nbsp; ' + choiceItems[c] + '</li>';
                        nex = nextChar(nex);
                    }
                    answerOptions += '</ol>';
//                    $('.textarea').summernote('pasteHTML', answerOptions);
                break;
            }


            var url = "<?php echo base_url() . 'opl/qm/addQuestions/' ?>";
            $.ajax({
                type: "POST",
                url: url,
                dataType:'json',
                data: {
                    question    : '<li class="pointer" ondblclick="remove($(this))" q_id="' + code + '" >' + question + answerOptions + '</li>',
                    plain_q     : $($("#question").summernote("code")).text(),
                    q_code      : code,
                    qtype       : qt,
                    answer      : answer,
                    quizTitle   : $('#quizTitle').val(),
                    quiz_id     : $('#quiz_id').val(),
                    subGradeSec : $('#gradeLevel').val(),
                    startDate   : $('#startDate').val()+' '+$('#timeStart').val(),
                    endDate     : $('#deadlineDate').val()+' '+$('#timeDeadline').val(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    $('#mcChoices').html('');
                    $('#num_of_choices').val('');
                    $('#answer').val('');
                    $('#question').html('');
                    nex = 'a';
                    numChoices = 0;
                    $('.textarea').summernote('reset');
                    $('#quiz_id').val(data.quizCode)
                    $('#quizItems').append('<li  class="pointer" ondblclick="remove($(this))" q_id="' + code + '">' + question + answerOptions + '</li>');
                    
                }
            });




        }

    });

    function nextChar(c) {
        return String.fromCharCode(c.charCodeAt(0) + 1);
    }
</script>
