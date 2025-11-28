
<div id='basicInfo'>
    <div class='control-group pull-left'>
              <label class='control-label'>First Name</label>
              <div class='controls'>
                <input type='text' name='firstname' value='<?php echo $firstname ?>' placeholder='<?php echo $firstname ?>' id='firstname' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>Middle Name</label>
              <div class='controls'>
                <input type='text' name='middlename' value='<?php echo $middlename ?>' placeholder='<?php echo $middlename ?>' id='middlename' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>Last Name</label>
              <div class='controls'>
                <input type='text' name='lastname' value='<?php echo $lastname ?>' placeholder='<?php echo $lastname ?>' id='lastname' />
              </div>
              
    </div>
            
            
</div>
<div style='margin:5px 0 10px; float:right;'>
     
    <input type='hidden' id='rowid' value='<?php echo $user_id?>' />
    <input type='hidden' id='name_id' value='<?php echo $name_id?>' />
     
     <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
     <a href='#' data-dismiss='clickover' onclick='editBasicInfo()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>    

