<style>
    .error {
        color: red;
        margin-left: 5px;
    }
</style>
<div class="col-lg-12">
    <div class="form-group col-lg-3">
        <label>First Name<span class="error">*</span></label>
        <?php
        $inputFirstName = array(
            'name' => 'inputCFirstName',
            'id' => 'inputCFirstName',
            'class' => 'form-control',
            'placeholder' => 'First Name',
            'style' => 'margin-bottom:0;'
        );

        echo form_input($inputFirstName);
        ?>
        <div id="inputCFirstNameEmpty"></div>
    </div>
    <div class="form-group col-lg-3">
        <label>Middle Name</label>

<?php
$inputMiddleName = array(
    'name' => 'inputCMiddleName',
    'id' => 'inputCMiddleName',
    'class' => 'form-control',
    'placeholder' => 'Middle Name',
    'style' => 'margin-bottom:0;'
);

echo form_input($inputMiddleName);
?>
    </div>

    <div class="form-group  col-lg-3">
        <label>Last Name<span class="error">*</span> </label>
<?php
$inputLastName = array(
    'name' => 'inputCLastName',
    'id' => 'inputCLastName',
    'class' => 'form-control',
    'placeholder' => 'Last Name',
    'style' => ' margin-right:10px; margin-bottom:0;'
);

echo form_input($inputLastName);
?>
        <div id="inputCLastNameEmpty"></div>
    </div>

    <div class="form-group col-lg-3">
        <label>Select Course<span class="error">*</span></label><br />
        <select style="height:35px; width: 200px;" name="getCourse" onclick="setId(this.value)" id="getCourse" required>
            <option value="none">Select Course</option>
<?php
foreach ($course as $level) {
    ?>
                <option value="<?php echo $level->course_id; ?>"><?php echo $level->short_code; ?></option>
            <?php } ?>
        </select>
        <div id="inputCourseEmpty"></div>
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group col-lg-3">
        <label>Year Level<span class="error">*</span></label><br />
        <div id="AddedSection">
            <select name="inputYear" id="inputYear" style="width:225px;" required>
                <option value="none">Select Year Level</option>
                <option value="1">First Year</option>
                <option value="2">Second Year</option>
                <option value="3">Third Year</option>
                <option value="4">Fourth Year</option>
            </select>
        </div>
        <div id="inputYearEmpty"></div>
    </div>

    <div class="form-group col-lg-3">
        <label>Date of Birth<span class="error">*</span></label>
        <input style="margin-right: 10px;" class="form-control" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" id="inputBdate" placeholder="Date of Birth" required>
        <div id="inputBdateEmpty"></div>
    </div>

    <div class="form-group col-lg-3">
        <label>Place of Birth</label>
        <input style="margin-right: 10px;" class="form-control" name="inputPlaceOfBirth" type="text" id="inputPlaceOfBirth" placeholder="Place of Birth" required>
    </div>


    <div class="form-group col-lg-3">
        <label class="control-label" for="inputNationaly">Nationality</label>
        <input class="form-control" name="inputNationality" type="text" id="inputNationality" placeholder="Nationality">

    </div>
</div>
<div class="col-lg-12">
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputCReligion">Religion</label>
        <div class="controls">
            <select name="inputCReligion" id="inputCreligion" style="width:225px;" required>
                <option>Select Religion</option>
<?php
foreach ($religion as $r) {
    ?>
                    <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>

                <?php }
                ?>
            </select><a class="help-inline" rel="clickover" data-content="
                        <div style='width:100%;'>
                        <h6>Add Religion</h6>
                        <input type='text' id='addreligion' />
                        <div style='margin:5px 0;'>
                        <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                        <a href='#' id='religion' data-dismiss='clickover' table='religion' column='religion' pk='rel_id' retrieve='getReligion' onclick='saveNewValue(this.id)' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                        </div>
                        " class="btn" data-toggle="modal" href="#">[ Add Religion ]</a>
        </div>
    </div>

    <div class="form-group col-lg-3">
        <label class="control-label" for="inputGender">Gender<span class="error">*</span></label>
        <div class="controls">
            <select name="inputCGender" id="inputCGender" style="width:225px;" required>
                <option value="none">Select Your Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div id="inputCGenderEmpty"></div>

    </div>
</div>

<div class="col-lg-12">
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputBirthDate">Date Enrolled<span class="error">*</span></label>
        <input class="form-control" name="inputCEdate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="inputEdate" placeholder="Date Enrolled" required>

    </div>
    <div class="form-group col-lg-3">
        <label class="control-label" for="inputBirthDate">School Year<span class="error">*</span></label><br />
        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputCSY" name="inputCSY" style="width:200px; font-size: 15px;">
            <option value="none">School Year</option>
<?php
foreach ($ro_year as $ro) {
    $roYears = $ro->ro_years + 1;
    if ($this->session->school_year == $ro->ro_years):
        $selected = 'Selected';
    else:
        $selected = '';
    endif;
    ?>
                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years . ' - ' . $roYears; ?></option>
            <?php } ?>
        </select>
        <div id="inputCSYEmpty"></div>
    </div>
    <div class="form-group col-lg-3">
        <label>Semester<span class="error">*</span></label><br />
        <div id="AddedSection">
            <select name="inputSemester" id="inputSemester" style="width:225px;" required>
            <?php
            $sem = Modules::run('main/getSemester');
            switch ($sem):
                case 1:
                    $first = 'Selected';
                    $second = '';
                    $third = '';
                    break;
                case 2:
                    $first = '';
                    $second = 'selected';
                    $third = '';
                    break;
                case 3:
                    $first = '';
                    $second = '';
                    $third = 'Selected';
                    break;
            endswitch;
            ?>
                <option <?php echo $first ?> value="1">First</option>
                <option <?php echo $second ?> value="2">Second</option>
                <option <?php echo $third ?> value="3">Summer</option>
            </select>
        </div>
    </div>

    <div class="form-group col-lg-3">
        <label class="control-label">School Last Attended:</label>
        <input style="margin-bottom:0;" class="form-control" name="inputCSLA" type="text" id="inputSLA" placeholder="School Last Attended">
    </div>
    <div>
    </div>
    <div class="col-lg-12">
        <div class="form-group col-lg-6">
            <div class="form-group col-lg-3">
                <label class="control-label">Address of School Last Attended:</label>
                <input style="margin-bottom:0;" class="form-control" name="inputCAddressSLA" type="text" id="inputAddressCSLA" placeholder="Address">
            </div>
        </div>
    </div>
</div>
