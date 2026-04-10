<div id="addTimeModal"  style="width:35%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class='panel panel-default no-padding'>
    <div class='panel-heading'>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        Add Time
    </div>
    <div class='panel-body'>
        <div class='control-group '>
            <div class='controls'>
                <dl class='dl-horizontal'>
                    <dt style='width:30%;'>
                    From:
                    </dt>
                    <dd style='margin-left:35%;'>            
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
                       <select onclick='addTimeSelect(this.id)' id='From' style='width:120px;'>
                           <option> Select Choice </option> 
                           <option value='AM'>AM</option>
                           <option value='PM'>PM</option>

                       </select>
                    </dd>
                </dl>
                <dl class='dl-horizontal'>
                    <dt style='width:30%;'>
                    To:
                    </dt>
                    <dd style='margin-left:35%;'>            
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
                        <select onclick='addTimeSelect(this.id)' id='To' style='width:120px;'>
                            <option> Select Choice </option> 
                            <option value='AM'>AM</option>
                            <option value='PM'>PM</option>

                        </select>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="panel-footer clearfix">
        <button onclick="saveTime()" class="btn btn-xs btn-primary pull-right">Save Time</button>
    </div>
</div>
    <?php
         if($this->uri->segment(2)=='college'):
             $department = 2;
         else: 
             $department = 1;
         endif;
   ?>
  <input type='hidden' name="timeFrom" id='addTimeFrom' value='' />
  <input type='hidden' name="timeTo" id='addTimeTo' value='' />
  <input type='hidden' name="timeDepartment" id='timeDepartment' value='<?php echo $department ?>' />
</div>