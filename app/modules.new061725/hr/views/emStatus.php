<div class='row clearfix'>
    <div class='form-group col-lg-12'>
        <label class='control-label' for='inputDepartment'>Employee Status</label>
        <div class='controls'>
            <select style='width:230px;' name='inputDepartment' id='editEmStat' required>
                <option value='1' <?php echo ($eStat == 1 ? 'selected' : '') ?>>Active</option>
                <option value='0' <?php echo ($eStat == 0 ? 'selected' : '') ?>>Deactivated</option>
                <option value='2' <?php echo ($eStat == 2 ? 'selected' : '') ?>>Suspended</option>
                <option value='3' <?php echo ($eStat == 3 ? 'selected' : '') ?>>Resigned</option>
            </select>
        </div>
    </div>
    <input type='hidden' id='eid' value='<?php echo $eid ?>' />
    <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
    <a href='#' data-dismiss='clickover' onclick='updateStatus()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a>
</div>  
</div>