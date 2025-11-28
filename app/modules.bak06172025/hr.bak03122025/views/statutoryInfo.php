<div id='statutoryInfo'>
    <div class='control-group pull-left'>
              <label class='control-label'>SSS</label>
              <div class='controls'>
                <input type='text' name='street' value='<?php echo $sss ?>' placeholder='<?php echo $sss ?>' id='editSSS' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>PhilHealth</label>
              <div class='controls'>
                <input type='text' name='barangay' value='<?php echo $philHealth ?>' placeholder='<?php echo $philHealth ?>' id='editPhilHealth' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>Pag-ibig</label>
              <div class='controls'>
                <input type='text' name='lastname' value='<?php echo $pag_ibig ?>' placeholder='<?php echo $pag_ibig ?>' id='editPag_ibig' />
              </div>
              
    </div>
    <div class='control-group pull-left'>
              <label class='control-label'>TIN</label>
              <div class='controls'>
                <input type='text' name='lastname' value='<?php echo $tin ?>' placeholder='<?php echo $tin ?>' id='editTIN' />
              </div>
              
    </div>
            
            
</div>
<div style='margin:5px 0 10px; float:right;'>
     
    <input type='hidden' id='st_id' value='<?php echo $st_id ?>' />
     
     <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
     <a href='#' data-dismiss='clickover' onclick='editEmployeeInfo()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>    

