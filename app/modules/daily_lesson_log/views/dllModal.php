<div id="addReference"  style="width:15%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            Add Reference
        </div>
        <div class="panel-body">
            <div style='width:100%; color:black; margin-bottom: 10px;'>
            <select name    ='refType' id='refType' style='width:100%;' class='pull-left' required>
               <option>Reference Type</option> 
             <?php  foreach ($refMat as $ref)
                {     
             ?>
              <option value='<?php echo $ref->type_id; ?>'><?php echo $ref->ref_mat ?></option>  
             <?php } ?>
            </select>
            <input type='text' placeholder='Details' id='page_num' />
            <div style='margin:5px 0;'>
            <button data-dismiss="modal"  class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <button data-dismiss="modal" table='esk_section' column='section' pk='section_id' retrieve='getSectionByGradeId' onclick='addReference()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Add</button></div>
        </div>
        </div>
    </div>
</div>


<div id="addMaterials"  style="width:15%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            Add Materials
        </div>
        <div class="panel-body">
            <select name='matType' id='matType' style='width:100%;' class='pull-left' required>
           <option>Material Type</option> 
         <?php  foreach ($refMat as $ref)
            {     
         ?>
          <option value='<?php echo $ref->type_id; ?>'><?php echo $ref->ref_mat ?></option>  
         <?php } ?>
        </select>
        <input type='text' placeholder='Details' id='mat_page_num' />
        <div style='margin:5px 0;'>
        <button data-dismiss="modal" class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
        <button data-dismiss="modal" table='esk_section' column='section' pk='section_id' retrieve='getSectionByGradeId' onclick='saveMatType()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Add</button></div>

        </div>
    </div>
</div>

<div id="addActivities"  style="width:20%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            Add Activities
        </div>
        <div class="panel-body">
            <textarea id="activity" style="float:left; text-align: left;" onclick="this.value=''"cols="25" rows="5">activities here...
            </textarea> 
        <div style='margin:5px 0;'>
            <button data-dismiss="modal" class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <button data-dismiss="modal" table='esk_section' column='section' pk='section_id' retrieve='getSectionByGradeId' onclick='saveActivities()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Add</button>
        </div>

        </div>
    </div>
</div>

<div id="addComment"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            Add Comment
        </div>
        <div class="panel-body">
            <textarea id="comment" style="float:left; text-align: left;" onclick="this.value=''"cols="25" rows="5" placeholder="Comment">
            </textarea> 
        <div style='margin:5px 0;'>
            <button data-dismiss="modal" class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
            <button data-dismiss="modal" onclick='saveComment()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Add</button>
        </div>

        </div>
    </div>
</div>