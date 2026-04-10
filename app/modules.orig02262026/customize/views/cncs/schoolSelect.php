<div id='selectSchool'>
    <div class='panel panel-info' style='margin:0; width: 100%'>
        <div class='panel-heading '>
            Select School
        </div>
        <div class='panel-body'>
            <h6>Not on the list? Click <a class='pointer' data-dismiss='clickover' data-toggle='clickover' data-trigger='focus' tabindex='0' onclick='$(&quot;#addSchool&quot;).modal(&quot;show&quot;)'>here</a> to Add school</h6>
            <select id='schoolList'>
                
            </select>
        </div>

        <div class='panel-footer clearfix'>
            <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <a href='#' data-dismiss='clickover' onclick='updateCSFLskulInfo(&quot;sch_id&quot;)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
            <input type='hidden' id='lvalue' value='<?php echo $field ?>'/> 
        </div>         
    </div>
</div>
