<div id='selectSchool'>
    <div class='panel panel-info' style='margin:0; width: 100%'>
        <div class='panel-heading '>
            Select School
        </div>
        <div class='panel-body'>
            <h6>Not on the list? Click <a href'' class='pointer' onclick='$(&quot;#addSchool&quot;).modal(&quot;show&quot;), data-dismiss=&quot;clickover&quot;'>here</a> to Add school</h6>
            <select id='schoolList'>
                
            </select>
        </div>

        <div class='panel-footer clearfix'>
            <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <a href='#' data-dismiss='clickover' onclick='updateSchoolInfo(&quot;school_id&quot;)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
        </div>         
    </div>


</div>
