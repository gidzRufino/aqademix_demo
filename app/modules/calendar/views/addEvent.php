<div id="addEventModal"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class='panel panel-default' style='width:100%; color:black;'>
        <div class='panel-heading'>
            <h6>ADD EVENT</h6> 
        </div>
        <div class='panel-body'>
            <input class='form-control' type='text' id='inputEvent' placeholder='Name of Event' /><br />
            <?php if($this->session->userdata('position_id')!=4){ ?>
            <select class='form-control' id='inputEventCategory' style=''>
               <?php
               foreach($category as $cat){
               ?>
               <option value='<?php echo $cat->cat_id ?>'><?php echo $cat->events_category ?></option>
               <?php } ?>
           </select>
            <?php } ?>
            <br />
            <p>Time [from] </p>
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
           <select onclick='finalTime(this.id)' id='From' style='width:60px;'>
               <option> Select Choice </option>
               <option value='AM'>AM</option>
               <option value='PM'>PM</option>

           </select><br /><br />
            <p>Time [to] </p>
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
           <select onclick='finalTime(this.id)' id='To' style='width:60px;'>
               <option> Select Choice </option>
               <option value='AM'>AM</option>
               <option value='PM'>PM</option>

           </select>
        </div>
        <div class='panel-footer clearfix'>
         <button data-dismiss='modal' class='btn btn-sm btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
         <a href='#' id="addEvent"style='margin-right:10px; color:white;' class='btn btn-sm btn-success pull-right'>Save</a>
        </div>

        <input type='hidden' id='inputFinalFrom' value='' />
        <input type='hidden' id='inputFinalTo' value='' />
        <input type='hidden' id='fromDate' value='' />
        <input type='hidden' id='toDate' value='' />
    </div>
</div>

