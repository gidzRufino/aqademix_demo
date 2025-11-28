<div class='row clearfix'>
    <div class='form-group col-lg-12'>
        <label class='control-label' for='inputDepartment'>Department</label>
        <div class='controls'>
          <select style='width:230px;' name='inputDepartment'  onclick='getPosition(this.value)'  id='editDepartment' required>
              <option>Select Department</option>
             <?php 
                    foreach ($position as $p)
                      {   
                ?>                        
              <option value='<?php echo $p->dept_id; ?>'><?php echo $p->department; ?></option>

              <?php }?>
            </select>
        </div>
   </div>

      <div class='form-group col-lg-3' id='Pos'>
            <label id='labelPosition' class='control-label' for='inputSection'>Position</label>
            <div class='controls' id='AddedPosition'>
              <select name='inputPosition' style='width:230px;' id='inputPosition' required>
                  <option></option>

                </select>
            </div>
      </div>
     <div class='col-lg-12' style='margin:5px 0 10px; float:right;'>

        <input type='hidden' id='st_id' value='<?php echo base64_encode($user_id) ?>' />

         <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
         <a href='#' data-dismiss='clickover' onclick='saveDepartment()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
    </div>  
</div>