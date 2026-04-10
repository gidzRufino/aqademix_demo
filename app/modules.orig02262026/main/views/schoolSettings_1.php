<div class="row" >
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:0">School Settings <small style="cursor: pointer;" onclick="showStats()">[ SCHOOL STATS ]</small>
            <a href="<?php echo base_url() ?>main/backup" class="btn btn-warning pull-right" >Backup School Data</a>
            
        </h3>
    </div> 
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div style="position:absolute; top:30%; left:50%;" class="alert alert-error hide" id="notify" data-dismiss="alert-message">
                <h4></h4>
        </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>School Information</h5>
            </div>
            <div class="panel-body">
                <table class="editableTable table table-hover insetBg">
                <tr>
                    <td><h5 class="pull-right">School ID : </h5></td>
                    <td><h5><span id="school_id" style="color:red;"><?php if($settings->school_id!=""){ echo $settings->school_id;  }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td style="width:30%;"><h5 class="pull-right">Name of School : </h5></td>
                    <td><h5><span id="set_school_name" style="color:red;"><?php if(!empty($settings)){ echo $settings->set_school_name; }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td style="width:30%;"><h5 class="pull-right">Short Name : </h5></td>
                    <td><h5><span id="short_name" style="color:red;"><?php if(!empty($settings)){ echo $settings->short_name; }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Address : </h5></td>
                    <td><h5><span id="set_school_address" style="color:red;"><?php if(!empty($settings)){ echo $settings->set_school_address; }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Region : </h5></td>
                    <td><h5><span id="region" style="color:red;"><?php if($settings->region!=""){ echo $settings->region; }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">District : </h5></td>
                    <td><h5><span id="district" style="color:red;"><?php if($settings->district!=""){ echo $settings->district; }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Division : </h5></td>
                    <td><h5><span id="division" style="color:red;"><?php if($settings->division!=""){ echo $settings->division    ; }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">School Year : </h5></td>
                    <td><h5><span id="school_year" style="color:red;"><?php if($settings->school_year!=""){ echo $sy;  }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Website : </h5></td>
                    <td><h5><span id="web_address" style="color:red;"><?php if($settings->web_address!=""){ echo $settings->web_address;  }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Official Time In : </h5></td>
                    <td><h5><span id="time_in" style="color:red;"><?php if($settings->time_in!=""){ echo $settings->time_in;  }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Official Time Out : </h5></td>
                    <td><h5><span id="time_out" style="color:red;"><?php if($settings->time_out!=""){ echo $settings->time_out;  }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
                <tr>
                    <td><h5 class="pull-right">Final Passing Mark : </h5></td>
                    <td><h5><span id="final_passing_mark" style="color:red;"><?php if($settings->final_passing_mark!=""){ echo $settings->final_passing_mark;  }else{ echo '[empty]'; } ?></span></h5></td>
                </tr>
            </table>
         </div>
        </div>
        <div  class="alert alert-error hide" id="qnotify" data-dismiss="alert-message">
            <h4></h4>

         </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Grading Period <button id="saveQuarter" onclick="saveGrading()" class="btn btn-small btn-success pull-right">SAVE</button></h5>
            </div>
            <div class="panel-body">
                <?php echo Modules::run('main/quarterSettings') ?>
            </div>
        </div>
        
    </div>
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Attendance Checking </h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                 <h5>
                     <?php if($settings->att_check): 
                         $auto = 'checked="checked"';
                         $manual = '';
                         ?>

                     <?php else:
                         $auto = '';
                         $manual = 'checked="checked"';
                         endif;

                         ?>
                     <input onclick="changeAttendanceSetting(this.value)" style="margin-right: 10px;" <?php echo $auto ?> type="radio" name="att_check" value="1">Check through RFID &nbsp;&nbsp;&nbsp;
                     <input onclick="changeAttendanceSetting(this.value)" style="margin-right: 10px;" <?php echo $manual ?> type="radio" name="att_check" value="0">Check Attendance Manually
                 </h5>
              </div>
            </div>
        </div>      
    </div>
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Grade Level Catered</h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                 <h5>
                    <?php
                        switch($settings->level_catered):
                            case 0:
                                $all ='checked="checked"';
                                $elem = '';
                                $hs = '';
                                $college = '';
                            break;
                            case 1:
                                $all ='';
                                $elem = 'checked="checked"';
                                $hs = '';
                                $college = '';
                            break;
                            case 2:
                                $all ='';
                                $elem = '';
                                $hs = 'checked="checked"';
                                $college = '';
                            break;
                            case 5:
                                $all ='';
                                $elem = '';
                                $hs = '';
                                $college = 'checked="checked"';
                            break;
                        
                        endswitch;
                    ?>
                     <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $all ?> type="radio" name="level_check" value="0">All Level &nbsp;&nbsp;&nbsp;
                     <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $elem ?> type="radio" name="level_check" value="1">Elementary Only&nbsp;&nbsp;&nbsp;
                     <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $hs ?> type="radio" name="level_check" value="2">High School
                     <input onclick="changeLevelSetting(this.value)" style="margin-right: 10px;" <?php echo $college ?> type="radio" name="level_check" value="4">College
                 </h5>
              </div>
            </div>
        </div>
           
    </div>
        
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Customized Card </h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                 <h5>
                     <?php if($gs_settings->customized_card): 
                         $auto_c = 'checked="checked"';
                         $manual_c = '';
                         ?>

                     <?php else:
                         $auto_c = '';
                         $manual_c = 'checked="checked"';
                         endif;

                         ?>
                     <input onclick="changeGSSetting(this.value, 'customized_card')" style="margin-right: 10px;" <?php echo $auto_c ?> type="radio" name="card_check" value="1">Customized Report Card &nbsp;&nbsp;&nbsp;
                     <input onclick="changeGSSetting(this.value, 'customized_card')" style="margin-right: 10px;" <?php echo $manual_c ?> type="radio" name="card_check" value="0">Use Default Report
                 </h5>
              </div>
            </div>
        </div>      
    </div>
        
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Customized Permanent Record </h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                 <h5>
                     <?php if($gs_settings->customized_f137): 
                         $auto_f = 'checked="checked"';
                         $manual_f = '';
                         
                         ?>

                     <?php else:
                         $auto_f = '';
                         $manual_f = 'checked="checked"';
                         endif;
 
                         ?>
                     <input onclick="changeGSSetting(this.value, 'customized_f137')" style="margin-right: 10px;" <?php echo $auto_f ?> type="radio" name="f137_check" value="1">Customized Students Permanent Record&nbsp;&nbsp;&nbsp;
                     <input onclick="changeGSSetting(this.value, 'customized_f137')" style="margin-right: 10px;" <?php echo $manual_f ?> type="radio" name="f137_check" value="0">Use Default
                 </h5>
              </div>
            </div>
        </div>      
    </div>    
        
    <div class="col-lg-6 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Use Specialization in TLE Subject</h5>
            </div>
            <div class="panel-body">
                <div class="control-group">
                 <h5>
                     <?php if($gs_settings->used_specialization): 
                         $auto_f = 'checked="checked"';
                         $manual_f = '';
                         
                         ?>

                     <?php else:
                         $auto_f = '';
                         $manual_f = 'checked="checked"';
                         endif;
 
                         ?>
                     <input onclick="changeGSSetting(this.value, 'used_specialization')" style="margin-right: 10px;" <?php echo $auto_f ?> type="radio" name="use_spec" value="1">Yes&nbsp;&nbsp;&nbsp;
                     <input onclick="changeGSSetting(this.value, 'used_specialization')" style="margin-right: 10px;" <?php echo $manual_f ?> type="radio" name="use_spec" value="0">No
                 </h5>
              </div>
            </div>
        </div>      
    </div>    
</div>
</div>


    

            

</div>
<script type="text/javascript">
    $(function () { 
$(".editableTable td h5 span").dblclick(function () 
{   
    var OriginalContent = $(this).text(); 
    var ID = $(this).attr('id');
   
    $(this).addClass("cellEditing"); 
    $(this).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
    $(this).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $(this).val(); 
            
            var dataString = "column="+ID+"&value="+newContent+'&csrf_test_name='+$.cookie('csrf_cookie_name')
            $(this).parent().text(newContent); 
            $(this).parent().removeClass("cellEditing");

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'main/inLineEdit' ?>",
                dataType: 'json',
                data: dataString,
                cache: false,
                success: function(data) {

//                  $('#success').html(data.msg);
//                  $('#alert-info').fadeOut(5000);
//                  $('#'+ID+'_result').html(data.equivalent)
                }
            });

        } 
    }); 

        $(this).children().first().blur(function(){ 
        $(this).parent().text(OriginalContent); 
        $(this).parent().removeClass("cellEditing"); 
    }); 
}); 
});

function showStats()
{
     var url = "<?php echo base_url().'main/showStats/'?>"; // the script where you handle the form input.

     document.location = url
}

function changeGSSetting(value, column)
{
    $.ajax({
                type: "POST",
                url: "<?php echo base_url().'gradingsystem/editSettings' ?>",
                data: 'column='+column+'&value='+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                success: function(data) {
                    console.log(data);
                }
            });
}

function changeAttendanceSetting(value)
{
    $.ajax({
                type: "POST",
                url: "<?php echo base_url().'main/inLineEdit' ?>",
                data: 'column=att_check&value='+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                cache: false,
                success: function(data) {
                    
                }
            });
}

function changeLevelSetting(value)
{
    $.ajax({
                type: "POST",
                url: "<?php echo base_url().'main/inLineEdit' ?>",
                data: 'column=level_catered&value='+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                cache: false,
                success: function(data) 
                {
                    
                }
            });
}
</script>
