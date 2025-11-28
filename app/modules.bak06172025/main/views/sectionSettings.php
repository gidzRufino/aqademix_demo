<div class="panel panel-default">
    <div class="panel-heading">
        <h5>List of Grade Level and Section</h5>
    </div>
    <div class="panel-body">
        <ul style="list-style: none;" id="gradeSection">
        <?php
            foreach($grade as $g)
            {
        ?>
            <li class="parent" onmouseout="$('#<?php echo $g->grade_id ?>_a').hide()"
                onmouseover="$('#<?php echo $g->grade_id ?>_a').show()" 
                id="<?php echo $g->grade_id ?>_li"><?php echo $g->level; ?> 
                <a style="display: none;" id="<?php echo $g->grade_id ?>_a" class="help-inline pull-right" 
                  rel="clickover" 
                  data-content=" 
                       <div style='width:100%;'>
                       <h6>Add Section</h6>
                       <input type='text' id='addsection' />
                       <div style='margin:5px 0;'>
                       <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                       <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='clickover' table='esk_section' column='section' pk='section_id' retrieve='getSectionByGradeId' onclick='saveNewValue(this.id)' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                       </div>
                        "   
                  class="btn" data-toggle="modal" href="#">Add Section</a>
            </li>
            <hr style="margin:5px auto">
            <ul id="<?php echo $g->grade_id ?>_section" style="list-style: disc">
                <?php $section = Modules::run('registrar/getSectionByGradeId', $g->grade_id);
                      foreach($section->result() as $s){  
                        ?>
                <li><?php echo $s->section ?></li>
                <?php } ?>
            </ul>
        <?php
            }
        ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function saveNewValue(table){
         var db_table = $('#'+table).attr('table')
         var db_column = $('#'+table).attr('column')
         var db_value = $('#add'+db_column).val()
         var url = "<?php echo base_url().'registrar/saveSectionValue/'?>"// the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "table="+db_table+"&column="+db_column+"&value="+db_value+"&pk="+table, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#'+table+'_section').html(data)
                   }
                 });

            return false;
   
      }
</script>