
<style>
    .md-input {
        position: relative;
        margin-bottom: 5px;
    }
    .md-input .md-form-control {
        font-size: 16px;

        display: block;
        border: none;
        border-bottom: 2px solid #CACACA;
        box-shadow: none;
        width: 100%;
    }


    .md-input .bar:before {
        left: 50%;
    }

    .md-input .bar:after {
        right: 50%;
    }

    .md-input .highlight {
        position: absolute;
        height: 60%;
        width: 100px;
        top: 25%;
        left: 0;
        pointer-events: none;
        opacity: 0.5;
    }
    .md-input .md-form-control:focus ~ label, .md-input .md-form-control:valid ~ label {
        top: -15px;
        font-size: 14px;
        color: #183D5D;
    }
    .md-input .bar:before, .md-input .bar:after {
        content: '';
        height: 2px;
        width: 0;
        bottom: 0px;
        position: absolute;
        background: #81e8d7;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }

    .md-input .md-form-control:focus ~ .bar:before, .md-input .md-form-control:focus ~ .bar:after {
        width: 50%;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">QUIZ MANAGEMENT
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-th-list fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div>Quiz Type</div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">
                    <div class="panel-footer">
                        <span class="pull-left">Create New</span>
                        <span class="pull-right"><i class="fa fa-plus-circle"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- /MODAL -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Create New Category</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">

                            <form action="<?php echo base_url() . 'page/addCategorydata' ?>" method="post" accept-charset="utf-8">
                                <input class="form-control" placeholder="Type Category..." name="category">                     
                                </div>
                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="save">
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-check fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div>TAG</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="modal" data-target="#myModal1" data-backdrop="static" data-keyboard="false">
                                <div class="panel-footer">
                                    <span class="pull-left">Create New</span>
                                    <span class="pull-right"><i class="fa fa-plus-circle"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- /MODAL -->
                    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Create New Tag</h4>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <br>
                                        <form method="POST" action="<?php echo base_url() . 'page/addTagdata' ?>">
                                            <input class="form-control" placeholder="Type Tag..." name="tag">
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-primary" value="save">
                                                </form>
                                            </div>
                                    </div>
                                </div>
                            </div>         
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-yellow">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-list-alt   fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div>CREATE QUIZ</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#myModal2" data-backdrop="static" data-keyboard="false">
                                            <div class="panel-footer">
                                                <span class="pull-left">Create New</span>
                                                <span class="pull-right"><i class="fa fa-plus-circle"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- /MODAL -->
                                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="panel panel-yellow">
                                            <div class="panel-heading">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="panel-title" id="contactLabel"><span class="fa fa-list-alt"></span> Create New Quiz.</h4>
                                            </div>
                                            <br>

                                            <form action="<?php echo base_url() . 'page/insertQuizitemsdata' ?>" method="post" accept-charset="utf-8">
                                                <div class="modal-body" style="padding: 5px;">
                                                    <div class="row">

                                                        <table align="center">
                                                            <tr>
                                                                <td align="center">
                                                                    <select class="form-control" name="quiztype" id="quiztype">
                                                                        <option>Type of Quiz</option>
                                                                        <?php foreach ($quiztype as $type): ?>
                                                                            <option value="<?php echo $type->qt_id ?>"><?php echo $type->qtuiz_type; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <br>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table align="center" > 
                                                            <tr style="padding-top: 10px">
                                                                <td>

                                                                    <input class="form-control" id="counts" placeholder="Input Number of Items" type="text" required />

                                                                </td>
                                                                <td id="num_choices">

                                                                </td>

                                                                <td style="padding-left: 5px">
                                                                    <button class="btn btn-success" id="generate"> generate</button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <br>           
                                                    <table align="center">
                                                        <tr>
                                                            <td>
                                                                <label>Date:</label>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <table align="center">
                                                        <tr>
                                                            <td>
                                                                <label>Creation:</label>
                                                            </td>
                                                            <td style="padding-left: 5px">
                                                                <input type="date" name="datecreated" id="date" value="<?php echo date('Y-m-d'); ?>" required>                                 
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <table align="center">
                                                        <tr>
                                                            <td>
                                                                <label>Activation:</label>
                                                            </td>
                                                            <td style="padding-left: 5px">
                                                                <input type="date" name="dateactivated" id="date" value="" required>                                 
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <table align="center">
                                                        <tr>
                                                            <td>
                                                                <label>Expiration:</label>
                                                            </td>
                                                            <td style="padding-left: 5px">
                                                                <input type="date" name="dateexpired" id="date" value="" required>                                 
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>

                                                    <div class="row">
                                                        <div class="col-xs-6 col-md-4" style="padding-bottom: 10px;">
                                                            <select class="form-control">
                                                                <option>Grade Level</option>
                                                                <option>Identification</option>
                                                                <option>True or False</option>
                                                                <option>Multiple Choice</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-6 col-md-4" style="padding-bottom: 10px;">
                                                            <select class="form-control" name="tags">
                                                                <option>Tag</option>
                                                                <?php foreach ($quiztag as $tag): ?>
                                                                    <option value="<?php echo $tag->qtag_id ?>"><?php echo $tag->tag_name ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-6 col-md-4" style="padding-bottom: 10px;">
                                                            <select class="form-control">
                                                                <option>Section</option>
                                                                <option>Identification</option>
                                                                <option>True or False</option>
                                                                <option>Multiple Choice</option>
                                                            </select>
                                                        </div>
                                                        <div class="container" >
                                                            <div class="row" >
                                                                <div class="col-xs-6 col-md-6" style="padding-bottom: 10px;">
                                                                    <label class="control-label">Tags:</label>
                                                                    <input type="text" id="autocomplete" value="" class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <table align="center">
                                                            <tr style="paddin-bottom: 10px;">
                                                                <td align="center">
                                                                    <h4>Quiz title</h4>
                                                                    <input class="form-control" name="title" placeholder="type title.." type="text"  required /><br>

                                                                </td>
                                                            </tr >
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <textarea style="resize:vertical;" class="form-control" placeholder="Intructions..." rows="6" name="instruction" required></textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table id="tbl">

                                                    </table>
                                                    <br>
                                                    <input type="submit" class="btn btn-primary" value="Submit Query"/>
                                                    <input type="reset" class="btn btn-danger" value="Clear" />
                                                    
                                                        <!--<span class="glyphicon glyphicon-remove"></span>-->

                                                    <button style="float: right;" type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">  
                                                        <i class="fa fa-list-alt   fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div>QUIZ</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" data-toggle="modal" data-target="#myModal3" data-backdrop="static" data-keyboard="false">
                                                <div class="panel-footer">
                                                    <span class="pull-left">View Quiz</span>
                                                    <span class="pull-right"><i class="fa fa-plus-circle"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /MODAL -->
                                <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">         
                                                
                                                <h4 class="panel-title" id="contactLabel"><span class="fa fa-list-alt"></span> QUIZ </h4>
                                            </div>

                                            <div class="modal-body" style="padding: 5px;">


                                                <blockquote>
                                                    <div class="row">
                                                        <div class="col-sm-3 text-center">
                                                            <img class="img-circle" src="assets/img/cocomartin.jpg" style="width: 100px;height:100px;">
                                                            <!--<img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/128.jpg" style="width: 100px;height:100px;">-->
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <p id="instrcut"> </p>
                                                            <small>Instructor Cocomartin</small>
                                                            <br>
                                                            <table> 
                                                                <tr>

                                                                    <td>

                                                                        <select name="selector" id="select">
                                                                            <option>Select title..</option>
                                                                            <?php foreach ($id_items as $id_ite): ?>

                                                                                <option value="<?php echo $id_ite->qi_id ?> "> <?php echo $id_ite->qi_title ?> </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </td>

                                                                    <td style="padding-left: 5px">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </blockquote>
                                                <br>
                                                <p id="hud"> </p>
                                                <hr>
                                                <table id="tblqdisplay">
                                                </table>
                                                <br>
                                                   <hr>                           <!--<span class="glyphicon glyphicon-ok"></span>-->
                                                <input type="reset" class="btn btn-danger" value="Clear" />
                                                <input type="button" id="btntest" class="btn btn-primary" value="test"/>
                                                <input style=" padding-left:5px;" type="button" class="btn btn-default" value="Print" />
                                                
                                                 <!--<span class="glyphicon glyphicon-remove"></span>-->

                                                <button style="float: right;" type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>   
                                                 
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
<script type="text/javascript">
    $("#generate").click(function ()
    {
        var partialnum = "";
        var questionmult = "";
        var multnum = $("#countsChoice").val();
        var choice_array = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "O", "P", "Q", "R", "S", "T", "U", "V"];
        var num_choice = $("#countsChoice").val();
        var choice = "";
        var choicestate = "";
        var num = "";
        var i;
        var n = ($("#counts").val());
        for (var s = 0; s < num_choice; s++)
        {
            var ids;
            var idformult = num_choice * n;
            var partial = [];
            var final = 0;

            choice += '<tr><td>' + choice_array[s] + ') <input type="hidden" value="' + choice_array[s] + '" name="choice' + s + '"><input type="text" name="stated' + s + '" placeholder=" stated' + s + '"> </td></tr>';
            choicestate += '<option>' + choice_array[s] + '</option> ';
        }
        for (i = 1; i <= n; i++) {

            if ($("#quiztype").val() == 1)
            {
                num += '<tr> <td style="padding-bottom: 20px; padding-top: 20px; ">' +
                        '<label>Question #' + i + ':</label></td>' +
                        '<td>' +
                        '<input class="form-control" name="question' + i + '" placeholder="Question ' + i + '" value="Question ' + i + '" type="text"></td>' +
                        '<td>' +
                        '<label> Right Answer:</label></td>' +
                        '<td>  <select class="form-control" id="opt" name="right' + i + '" >' +
                        choicestate + '</select>' +
                        choice + '</td></tr>';
            } else if ($("#quiztype").val() == 2)
            {
                num += ' question # ' + i + ' \n\
                          <input  type="text" value="" name="question' + i + '"> right answer <input type="text" name="right' + i + '" value=""><br>';
            } else if ($("#quiztype").val() == 3)
            {
                num += '<tr>  <td style="padding-left: 5px"> <label>Question #' + i + ':</label>' +
                        ' </td><td style="padding-left: 5px"> <input class="form-control" name="question' + i + '" placeholder="Question ' + i + '" type="text" required /> ' +
                        '</td><td style="padding-left: 40px"><label>Right Answer:</label></td> ' +
                        '<td style="padding-left:  5px">' +
                        '<input  type="radio" name="right' + i + '" id="optionsRadiosInline1" value="True">  True  </td>' +
                        '<td style="padding-left: 5px">   <input type="radio" name="right' + i + '" id="optionsRadiosInline2" value="False">  False </td>  </tr>';
            }
        }
        $('#tbl').html('<tr style="padding-bottom: 10px;" ><td>  <br>' + num + ' <input type="hidden" name="itemcounts" value="' + n + '"> </td></tr>');
    });
                    
                    
    $("#select").change(function ()
    {
        var x = 0;
        var num = "";
        var id = ($("#select").val());
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url() . 'page/multdisplaydata' ?>',
            data: {id: id},
            success: function (data)
            {
                for (var i = 0; i < data.length; i++)
                {
                    if (data[0].qt_id == 2)
                    {
                        $("#hud").html((' Date Now <input type="date" value="<?php echo date('Y-m-d'); ?>" id="dtnow" disabled> Date Created ' + '<input type="date" value="' + data[i].date_created) + '" disabled>');

                        if (($('#dtnow').val()) == data[i].date_activation_key)
                        {
                            num += '<tr> <td style="padding-left: 20px"><label>'
                                    + (i + 1) + '. ' + data[i].question +
                                    '</label> </td><td style="padding-left: 20px"> <div class="md-input"><input class="md-form-control" id="answer' + i + '" type="text" placeholder="">' +
                                    '<span class="highlight"></span> ';
                        } else
                        {
                            alert('not available');
                            return;
                        }
                    } else if (data[0].qt_id == 3)
                    {

                        $("#hud").html((' Date Now <input type="date" value="<?php echo date('Y-m-d'); ?>" id="dtnow" disabled> Date Created ' + '<input type="date" value="' + data[i].date_created) + '" disabled>');
                        if (($('#dtnow').val()) == data[i].date_activation_key)
                        {
                            num += '<tr> <td style="padding-left: 20px"><label>'
                                    + (i + 1) + '. ' + data[i].question +
                                    '</label> <td style="padding-left:  5px">' +
                                    '<input  type="radio" name="answer' + i + '" id="answer' + i + '" value="True">  True  </td>' +
                                    '<td style="padding-left: 5px"> <input  type="radio" name="answer' + i + '" id="answer' + i + '" value="False">    False </td>  </tr>';
                        } else
                        {
                            alert('not available');
                            return;
                        }
                    } else if (data[0].qt_id == 1)
                    {
                        var stated = "";
                        var question = "";
                        var num_choice = parseInt(data[i].num_choices);
                        if (i == x)
                        {
                            question += data[i].question;
                            x += num_choice;
                        }
                        $("#hud").html(('Date Now <input type="date" value="<?php echo date('Y-m-d'); ?>" id="dtnow" disabled> Date Created ' + '<input type="date" value="' + data[i].date_created) + '" disabled>');
                        if (($('#dtnow').val()) == data[i].date_activation_key)
                        {
                            num += '<tr> <td style="padding-left: 20px;padding-left: 20px"><label>' + question +
                                    '</label> </td></tr><tr><td style="padding-left:  5px"> ' + data[i].choice + '<input type="radio" name="answer.' + data[i].qq_id + '">' + data[i].choice_stated + '</td></tr>';
                        } else
                        {
                            alert('not available');
                            return;
                        }
                    }
                }
                $('#instrcut').html('INSTRUCTION -' + data[1].instruction);
                $('#tblqdisplay').html(num + '<input type="hidden" name="check" value="' + data.length + '">');
            },
            error: function ()
            {
                alert('fail');
            }
        });

    });
                    
    $("#btntest").click(function () {
        var id = ($("#select").val());
        var correct = 0;
        var wrong = 0;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url() . 'page/multdisplaydata' ?>',
            data: {id: id},
            success: function (data)
            {

                for (var i = 0; i < data.length; i++)
                {
                    if (data[i].qt_id == 3)
                    {
                        var $radio = $('input[name=answer' + i + ']:checked');
                        var updateDay = $radio.val();
                        var canswer = (data[i].right_answer);
                        var useranswer = updateDay;
                        if (canswer == useranswer)
                        {
                            correct++;
                        } else
                        {
                            wrong++;
                        }
                    } else if (data[i].qt_id == 2)
                    {
                        var canswer = (data[i].right_answer);
                        var useranswer = ($('#answer' + i).val());
                        if (canswer == useranswer)
                        {
                            correct++;
                        } else
                        {
                            wrong++;
                        }
                    }

                }
                $("#hud").html(("correct ['" + correct + "'] | wrong ['" + wrong + "']"));
            },
            error: function ()
            {
                alert("wrong");
            }
        });
    });
                    
    $("#quiztype").change(function () {
        if ($("#quiztype").val() == 1)
        {
            //alert("hello");
            $("#num_choices").html('<input class="form-control" id="countsChoice" name="multnumber" placeholder="Input Number of Choices" type="text" required />');
        } else if ($("#quiztype").val() != 1)
        {
            $("#num_choices").html('');
        }
    });
</script>
                