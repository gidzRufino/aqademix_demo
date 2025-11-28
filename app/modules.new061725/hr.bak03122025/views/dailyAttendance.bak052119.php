<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:5px auto">Employee's Daily Attendance
            <small class="pull-right" >
                <div class="form-group input-group">
                    <input style="height:34px;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $date; ?>" id="inputBdate" placeholder="Search for Date" required>
                    <span class="input-group-btn">
                        <button class="btn btn-success"onclick="searchAttendance($('#inputBdate').val())">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                
            </small>
        
        </h3>
        
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-6">
            <div class="panel panel-primary" style="margin:0;">
                <div class="panel-heading">
                    <h4>Present</h4>
                </div>
                <div class="panel-body clearfix" id="present_em" style="max-height: 450px; overflow-y: scroll; ">
                    <?php 
                        foreach($presents->result() as $basicInfo):
                            if(mb_strlen($basicInfo->time_in)<=3):
                                $time_in = date("g:i a", strtotime("0".$basicInfo->time_in));
                             else:
                                 $time_in = date("g:i a", strtotime($basicInfo->time_in));
                             endif;

                            if($basicInfo->time_out!=""){
                                if(mb_strlen($basicInfo->time_out)<=3):
                                    $time_out = ' - '.date("g:i a", strtotime('0'.$basicInfo->time_out));
                                else:
                                    $time_out = ' - '.date("g:i a", strtotime($basicInfo->time_out));
                                endif;
                            }else{
                                $time_out = "";
                            }
                            
                            if($basicInfo->time_in_pm!=""){
                                $time_in_pm = date("g:i a", strtotime($basicInfo->time_in_pm));
                            }else{
                                $time_in_pm = "";
                            }
                            if($basicInfo->time_out_pm!=""){
                                $time_out_pm = ' - '.date("g:i a", strtotime($basicInfo->time_out_pm));
                            }else{
                                $time_out_pm = "";
                            }
                            
                    ?>
                            <div data-content=" 
                                        <div class='col-lg-12 form-group' style='width:230px;'>
                                            <b>Select Time </b><br />
                                            <select id='<?php echo $basicInfo->u_rfid ?>_hr' style='width:50px;'>
                                               <?php
                                               for ($i=1; $i<=12; $i++)
                                               {
                                                   if($i<10)
                                                   {
                                                       $i='0'.$i;
                                                   }
                                                   
                                               ?>
                                               <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                               <?php } ?>
                                           </select> :  
                                           <select id='<?php echo $basicInfo->u_rfid ?>_min' style='width:50px;'>
                                               <?php
                                               for ($i=0; $i<=60; $i++)
                                               {
                                                   if($i<10)
                                                   {
                                                       $i='0'.$i;
                                                   }
                                               ?>
                                               <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                               <?php } ?>
                                           </select>
                                           <select id='<?php echo $basicInfo->u_rfid ?>_ampm' style='width:60px;'>
                                               <option> Select Choice </option>
                                               <option value='AM'>AM</option>
                                               <option value='PM'>PM</option>
                                           </select>
                                           <select id='<?php echo $basicInfo->u_rfid ?>_inout' style='width:60px;'>
                                               <option value='in'>IN</option>
                                               <option value='out'>OUT</option>
                                           </select>
                                           
                                           <input type='hidden' value='<?php echo $basicInfo->u_rfid ?>' id='<?php echo $basicInfo->u_rfid ?>_dtr' />
                                        </div>
                                        <div class='col-lg-12 pull-right'>
                                             <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                             <a href='#' data-dismiss='clickover' onclick='saveTime(<?php echo $basicInfo->u_rfid ?>)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
                                        </div>
                                        
                                     " 
                                
                                class="alert alert-success clearfix clickover pointer" style="height:70px; padding:2px">
                                <div class="col-lg-2">
                                    <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                                </div>   
                                <div class="col-lg-10" style="margin-top:20px;">
                                    <h4><?php echo strtoupper($basicInfo->firstname.' '.$basicInfo->lastname).' [ '. $time_in.$time_out.' '.$time_in_pm.$time_out_pm.' ] '?></h4>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-danger" style="margin:0;">
                <div class="panel-heading">
                    <h4>Absent</h4>
                </div>
                <div class="panel-body clearfix" style="max-height: 450px; overflow-y: scroll; ">
                    <?php 
                        foreach($employees->result() as $basicInfo):
                            if($basicInfo->rfid==''):
                                    $t_id = $basicInfo->employee_id;
                                else:
                                    $t_id = $basicInfo->rfid;
                                endif;
                            $ifPresent = Modules::run('attendance/ifPresent', $t_id, date('d', strtotime($date)), date('m', strtotime($date)), NULL, TRUE);
                            if(!$ifPresent):
                                
                    ?>      
                            <div data-content=" 
                                        <div class='col-lg-12 form-group' style='width:230px;'>
                                            <b>Select Time </b><br />
                                            <select id='<?php echo $basicInfo->user_id ?>_hr' style='width:50px;'>
                                               <?php
                                               for ($i=1; $i<=12; $i++)
                                               {
                                                   if($i<10)
                                                   {
                                                       $i='0'.$i;
                                                   }
                                               ?>
                                               <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                               <?php } ?>
                                           </select> :  
                                           <select id='<?php echo $basicInfo->user_id ?>_min' style='width:50px;'>
                                               <?php
                                               for ($i=0; $i<=60; $i++)
                                               {
                                                   if($i<10)
                                                   {
                                                       $i='0'.$i;
                                                   }
                                               ?>
                                               <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                               <?php } ?>
                                           </select>
                                           <select id='<?php echo $basicInfo->user_id ?>_ampm' style='width:60px;'>
                                               <option> Select Choice </option>
                                               <option value='AM'>AM</option>
                                               <option value='PM'>PM</option>
                                           </select>
                                           
                                           <input type='hidden' value='in' id='<?php echo $basicInfo->user_id ?>_inout' />
                                           <input type='hidden' value='<?php echo $t_id ?>' id='<?php echo $basicInfo->user_id ?>_dtr' />
                                        </div>
                                        <div class='col-lg-12 pull-right'>
                                             <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                             <a href='#' data-dismiss='clickover' onclick='saveTime(<?php echo $basicInfo->user_id ?>)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
                                        </div>
                                        
                                     "
                                 class="alert alert-danger clearfix pointer clickover" style="height:70px; padding:2px">
                                <div class="col-lg-2">
                                    <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                                </div>   
                                <div class="col-lg-8" style="margin-top:20px;">
                                    
                                    <h4><?php echo strtoupper($basicInfo->firstname.' '.$basicInfo->lastname)?></h4>
                                </div>
                            </div>
                    <?php
                          endif;
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".clickover").clickover({
                placement: 'bottom',
                html: true
              });
    })
    
    function saveTime(id)
    {
        var hour = $('#'+id+'_hr').val();
        var min = $('#'+id+'_min').val();
        var select = $('#'+id+'_ampm').val();
        var t_id = $('#'+id+'_dtr').val();
        var date = $('#inputBdate').val();
        var inout = $('#'+id+'_inout').val();
        
        var url = "<?php echo base_url().'hr/saveManualHrAttendance/'?>";
        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 't_id='+t_id+'&hour='+hour+'&min='+min+'&ampm='+select+'&date='+date+'&inout='+inout+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   $('#present_em').html(data)
               }
        })
    }
    function searchAttendance(date)
    {
            
            var url = "<?php echo base_url().'hr/getDailyAttendance/' ?>"+date; // the script where you handle the form input.
            document.location = url;
    }
</script>