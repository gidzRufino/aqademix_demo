<div class='panel panel-info' style='margin:0;'>
	<div class='panel-heading'>
		Course Department
	</div>
	<div class='panel-body'>
		<select style='width:230px;' name='inputDepartment' id='editDepartment' required>
              <option>Select Department</option>
             <?php 
                    foreach ($dept as $p)
                      {
                      	if($ccID == $p->cc_id)
                      	{
                      		$selected = 'Selected';
                      	} else {
                      		$selected = '';
                      	}
                ?>                        
              <option <?php echo $selected; ?> value='<?php echo $p->cc_id; ?>'><?php echo $p->college_department; ?></option>

              <?php }?>
            </select>
	</div>
	<div class='panel-footer'>
		<input type='hidden' id='courseid' value='<?php echo $courseID ?>' />
		<button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
        <a href='#' data-dismiss='clickover' onclick='editCourseDept()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
	</div>
</div>