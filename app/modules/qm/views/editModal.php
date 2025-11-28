<div id="addTag"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h4 id="tagHeader">Add Tag</h4>
        </div>
        <div class="panel-body">
                <input style="width:90%;" multiple="multiple" name="addedTags" type="text" id="addedTags" placeholder="Select Tags" /> 
                <input type="hidden" id="q_id" />
            <div style='margin:5px 0;'>
            <a href='#' data-dismiss='modal' onclick='addTag()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Add</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="addSkill"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h4 id="skillHeader">Add Skill</h4>
        </div>
        <div class="panel-body">
                <input style="width:90%;" multiple="multiple" name="addedSkills" type="text" id="addedSkills" placeholder="Select Skills" /> 
                <input type="hidden" id="sq_id" />
            <div style='margin:5px 0;'>
            <a href='#' data-dismiss='modal' onclick='addSkill()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Add</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>