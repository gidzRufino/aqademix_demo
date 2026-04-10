<div id="printOpt" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Select Form 137 Department to print</h4>
        </div>
        <div class="panel-body">
            <button class="btn btn-sm btn-default" onclick="printForm(1)" style="width: 100%">Elementary</button><br/><br/>
            <button class="btn btn-sm btn-primary" onclick="printForm(2)" style="width: 100%">Junior High School</button><br/><br/>
            <?php if (segment_6 >= 12 && segment_6 <= 13): ?>
                <button class="btn btn-sm btn-danger" onclick="printForm(3)" style="width: 100%">Senior High School</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="deleteOpt" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Select Option to delete</h4>
        </div>
        <div class="panel-body">
            <button class="btn btn-sm btn-default" onclick="deleteArec(0)" style="width: 100%">Delete Entire Record</button><br/><br/>
            <button class="btn btn-sm btn-primary" onclick="$('.ar_id' + $('#sySelected').val()).show(), $('#deleteOpt').modal('hide')" style="width: 100%">Delete Individual Subject</button><br/><br/>
        </div>
    </div>
</div>

<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload Academic Records</h4>
        </div>
        <?php
        $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:20px;');
        echo form_open_multipart(base_url() . 'f137/importAssessment', $attributes);
        ?>
        <div class="panel-body">
            <input type="hidden" id="st_sprid" name="st_sprid" />
            <input type="hidden" id="student_id" name="student_id" />
            <input type="hidden" id="selectSY" name="selectSY" />
            <input type="hidden" id="sLevel" name="sLevel" />
            <input type="hidden" id="lastSYen" name="lastSYen" value="<?php echo segment_5 ?>" />
            <input type="hidden" id="importTerm" name="importTerm" />
            <input style="height:30px" type="file" name="userfile" ><br />
            <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
        echo form_close();
        ?>
    </div>    
</div>

<div id="addSchool" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php $cities = Modules::run('main/getCities'); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>Add School</h4>
        </div>
        <div class="panel-body">
            <div class='form-group'>
                <label class='control-label'>Name of School</label>
                <div class='controls'>
                    <input type="text" name="nameSchool" id="nameSchool" placeholder="Enter Name of School" />
                </div>
            </div>
            <div class='form-group'>
                <label class='control-label'>School ID</label>
                <div class='controls'>
                    <input type="text" name="idSchool" id="idSchool" placeholder="Enter School ID" />
                </div>
            </div>
            <hr>
            <h4>School Address</h4>
            <div class='form-group'>
                <label class='control-label'>Street</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='text' name='street' id='street' placeholder="Enter Street" />
                </div>
            </div>
            <div class='form-group'>
                <label class='control-label'>Barangay</label>
                <div class='controls'>
                    <input class='form-control col-lg-12' type='text' name='barangay' id='barangay' placeholder="Enter Barangay" />
                </div>
            </div>
            <div class='control-group'>
                <label class='control-label' for='inputCity'>City / Municipality:</label>
                <select onclick='getProvince(this.value)' placeholder='Select A Municipality / City' style='width:100%;'  id='city' name='inputCity'>
                    <?php
                    foreach ($cities as $cit):
                        if ($city == $cit->cid):
                            $selected = 'selected';
                        else:
                            $selected = '';
                        endif;
                        ?>
                        <option <?php echo $selected; ?> value='<?php echo $cit->cid ?>'><?php echo $cit->mun_city . ' [ ' . $cit->province . ' ]' ?></option>
                    <?php endforeach; ?>
                </select>  
            </div>
            <div class='control-group'>
                <label class='control-label'>Province</label>
                <div class='controls'>
                    <input style='margin-bottom:0;' value='' class='form-control'  name='inputProvince' type='text' id='inputProvince' placeholder='State / Province' required>
                    <input style='margin-bottom:0;' value='' class='form-control'  name='inputPID' type='hidden' id='inputPID' placeholder='State / Province' required>
                </div>

            </div>
        </div>
        <div class="panel-footer">
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;
            <a href='#' data-dismiss='modal' onclick='addSchool()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
        </div>
    </div>    
</div>