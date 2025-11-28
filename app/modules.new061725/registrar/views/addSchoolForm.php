<div class="col-lg-12">
    <div class="form-group col-lg-12">
        <label class="control-label" for="inputAddress"><?php echo $id ?>. School المدرسة</label>
          <input style="margin-bottom:0;" class="form-control" name="inputSchool_<?php echo $id ?>" type="text" id="inputSchool_<?php echo $id ?>" placeholder="School" required>
    </div>
    
    <div class="form-group col-lg-6">
        <label class="control-label" for="">Attended From (Academic Year)</label>
        <input style="margin-bottom:0;" class="form-control" name="attendFrom_<?php echo $id ?>" type="text" id="attendFrom_<?php echo $id ?>" placeholder="" required>
    </div>
    <div class="form-group col-lg-6">
        <label class="control-label" for="">Attended To (Academic Year)</label>
        <input style="margin-bottom:0;" class="form-control" name="attendTo_<?php echo $id ?>" type="text" id="attendTo_<?php echo $id ?>" placeholder="" required>
    </div>
    <div class="form-group col-lg-6">
      <label>From Grade من المرحلة</label><br />
         <select class="form-control" style="width: 280px;" name="gradeFrom_<?php echo $id ?>"  id="gradeFrom_<?php echo $id ?>" required>
              <option>Select an Option</option> 
                <?php 
                       foreach ($grade as $level)
                         {   
                   ?>                        
                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                <?php }?>
            </select>
  </div>
    <div class="form-group col-lg-6">
      <label>To Grade إلى المرحلة</label><br />
         <select class="form-control" style="width: 280px;" name="gradeTo_<?php echo $id ?>"  id="gradeTo_<?php echo $id ?>" required>
              <option>Select an Option</option> 
                <?php 
                       foreach ($grade as $level)
                         {   
                   ?>                        
                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                <?php }?>
            </select>
  </div>
</div>