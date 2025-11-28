<div style='width:100%; color:black; margin-bottom: 10px;'>
<h6>Add Reference</h6>
<select name='refType' id='refType' style='width:100%;' class='pull-left' required>
   <option>Reference Type</option> 
 <?php  foreach ($refMat as $ref)
    {     
 ?>
  <option value='<?php echo $ref->type_id; ?>'><?php echo $ref->ref_mat ?></option>  
 <?php } ?>
</select>
<input type='text' placeholder='Details' id='page_num' />
<div style='margin:5px 0;'>
<button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
<button data-dismiss='clickover' table='esk_section' column='section' pk='section_id' retrieve='getSectionByGradeId' onclick='addReference()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Add</button></div>
</div>