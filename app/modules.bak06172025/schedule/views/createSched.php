<div id="sched"  style="width:35%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Create Schedule
        </div>
        <div class="panel-body clearfix">
            <?php
                $attributes = array('class' => 'form-inline','role'=>'form', 'id'=>'addSched');
                echo form_open(base_url().'', $attributes);
            ?>
                <div class="control-group ">
                        <div class="controls">
                            <dl class="dl-horizontal">
                                <dt style="width:30%;">
                                From:
                                </dt>
                                <dd style="margin-left:35%;">            
                                    <select id='inputHourFrom' style='width:50px;'>
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
                                   <select id='inputMinutesFrom' style='width:50px;'>
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
                                   <select onclick='finalTime(this.id)' id='From' style='width:120px;'>
                                       <option> Select Choice </option> 
                                       <option value='AM'>AM</option>
                                       <option value='PM'>PM</option>

                                   </select>
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt style="width:30%;">
                                To:
                                </dt>
                                <dd style="margin-left:35%;">            
                                    <select id='inputHourTo' style='width:50px;'>
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
                                    <select id='inputMinutesTo' style='width:50px;'>
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
                                    <select onclick='finalTime(this.id)' id='To' style='width:120px;'>
                                        <option> Select Choice </option> 
                                        <option value='AM'>AM</option>
                                        <option value='PM'>PM</option>

                                    </select>
                                </dd>
                            </dl>
                        </div>
                    </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Day</dt>
                        <dd style="margin-left:35%;">
                            <select name="day" id='day' style='width:120px;'>
                                <option value='0'>Sunday</option>
                                <option value='1'>Monday</option>
                                <option value='2'>Tuesday</option>
                                <option value='3'>Wednesday</option>
                                <option value='4'>Thursday</option>
                                <option value='5'>Friday</option>
                                <option value='6'>Saturday</option>

                            </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Room:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputRoom" id="inputRoom" required>
                              <option value="0">Select Room</option> 
                                <?php 
                                       foreach ($rooms as $r)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $r->rm_id; ?>"><?php echo $r->room; ?></option>
                                <?php }?>
                            </select>
                        </dd>
                    </dl>
                </div>  
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Subject:</dt>
                        <dd style="margin-left:35%;">
                          <select name="inputSubject" id="inputSubject" style="width:120px;"  class="controls-row" required>
                               <option>Select Subject</option> 
                             <?php  foreach ($subjects as $s)
                                {     
                             ?>
                              <option value="<?php echo $s->subject_id; ?>"><?php echo $s->subject ?></option>  
                             <?php } ?>
                          </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Grade / Section:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputGrade" onclick="selectSection(this.value)" id="inputGrade" required>
                              <option>Select Grade Level</option> 
                                <?php 
                                       foreach ($grade as $level)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                <?php }?>
                            </select>
                            <select style="width:120px;"  name="inputSection" id="getSection" required>
                                  <option>Select Section</option>  
                              </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Teacher:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputTeacher" id="inputTeachers" required>
                              <option>Select Teacher</option> 
                                <?php 
                                       foreach ($employees->result() as $em)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $em->employee_id; ?>"><?php echo $em->lastname.', '.$em->firstname; ?></option>
                                <?php }?>
                            </select>
                        </dd>
                    </dl>
                </div>
              <input type='hidden' name="timeFrom" id='inputFinalFrom' value='' />
              <input type='hidden' name="timeTo" id='inputFinalTo' value='' />

            <?php
                echo form_close();
            ?>            
          
            
        </div>
        <div class="panel-footer clearfix">
             <div class="control-group pull-right">
                <button onclick="createSched()" id="addRoomBtn" class="btn btn-small btn-primary">Create</button>
            </div>
        </div>
        
    </div>
</div>  
<div id="schedDay"  style="width:35%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Create Schedule
        </div>
        <div class="panel-body clearfix">
            <?php
                $attributes = array('class' => 'form-inline','role'=>'form', 'id'=>'addSched');
                echo form_open(base_url().'', $attributes);
            ?>
                <div class="control-group ">
                        <div class="controls">
                            <dl class="dl-horizontal">
                                <dt style="width:30%;">
                                From:
                                </dt>
                                <dd style="margin-left:35%;">            
                                    <select id='inputHourFrom' style='width:50px;'>
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
                                   <select id='inputMinutesFrom' style='width:50px;'>
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
                                   <select onclick='finalTime(this.id)' id='From' style='width:120px;'>
                                       <option> Select Choice </option> 
                                       <option value='AM'>AM</option>
                                       <option value='PM'>PM</option>

                                   </select>
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt style="width:30%;">
                                To:
                                </dt>
                                <dd style="margin-left:35%;">            
                                    <select id='inputHourTo' style='width:50px;'>
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
                                    <select id='inputMinutesTo' style='width:50px;'>
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
                                    <select onclick='finalTime(this.id)' id='To' style='width:120px;'>
                                        <option> Select Choice </option> 
                                        <option value='AM'>AM</option>
                                        <option value='PM'>PM</option>

                                    </select>
                                </dd>
                            </dl>
                        </div>
                    </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Day</dt>
                        <dd style="margin-left:35%;">
                            <span id="currentDay"></span>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Room:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputRoom" id="inputRoom" required>
                              <option value="0">Select Room</option> 
                                <?php 
                                       foreach ($rooms as $r)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $r->rm_id; ?>"><?php echo $r->room; ?></option>
                                <?php }?>
                            </select>
                        </dd>
                    </dl>
                </div>  
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Subject:</dt>
                        <dd style="margin-left:35%;">
                          <select name="inputSubject" id="inputSubject" style="width:120px;"  class="controls-row" required>
                               <option>Select Subject</option> 
                             <?php  foreach ($subjects as $s)
                                {     
                             ?>
                              <option value="<?php echo $s->subject_id; ?>"><?php echo $s->subject ?></option>  
                             <?php } ?>
                          </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Grade / Section:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputGrade" onclick="selectSection(this.value)" id="inputGrade" required>
                              <option>Select Grade Level</option> 
                                <?php 
                                       foreach ($grade as $level)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                                <?php }?>
                            </select>
                            <select style="width:120px;"  name="inputSection" id="getSection" required>
                                  <option>Select Section</option>  
                              </select>
                        </dd>
                    </dl>
                </div>
                <div class="control-group">
                    <dl class="dl-horizontal">
                        <dt style="width:30%;">Teacher:</dt>
                        <dd style="margin-left:35%;">
                          <select style="width: 120px;" name="inputTeacher" id="inputTeacher" required>
                              <option>Select Teacher</option> 
                                <?php 
                                       foreach ($employees->result() as $em)
                                         {   
                                   ?>                        
                                        <option value="<?php echo $em->employee_id; ?>"><?php echo $em->lastname.', '.$em->firstname; ?></option>
                                <?php }?>
                            </select>
                        </dd>
                    </dl>
                </div>
              <input type='hidden' name="timeFrom" id='inputFinalFrom' value='' />
              <input type='hidden' name="timeTo" id='inputFinalTo' value='' />

            <?php
                echo form_close();
            ?>            
          
            
        </div>
        <div class="panel-footer clearfix">
             <div class="control-group pull-right">
                <button onclick="createSched()" id="addRoomBtn" class="btn btn-small btn-primary">Create</button>
            </div>
        </div>
        
    </div>
</div>  

<script type="text/javascript">
    $(document).ready(function() {
        $('#inputTeacher').select2()
});
    
    function createSched()
    {
        var url = "<?php echo base_url().'schedule/createSched/' ?>"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               data: $('#addSched').serialize(), // serializes the form's elements.
               success: function(data)
               {
                   alert(data)
                   location.reload()
               }
             });

        return false;
    }
    
    function finalTime(fromTo)
{
    var hour = $('#inputHour'+fromTo).val()
    var minutes = $('#inputMinutes'+fromTo).val()
    var AmPm = $('#'+fromTo).val()
    
    if(AmPm=="PM"){
        hour = parseInt(hour) + 12;
    }

    $('#inputFinal'+fromTo).val(hour+':'+minutes+':'+'00')
}

    function selectSection(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#getSection').html(data);
               }
             });

        return false;
    }
</script>