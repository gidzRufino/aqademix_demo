<div class="col-lg-12 clearboth no-padding col-xs-12" style="background: #ccc;">
    <div class="col-lg-8 col-xs-12" style="margin:10px auto; float: none !important" tabindex="-1" aria-hidden="true">
        <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">

            <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location = '<?php echo base_url('college') ?>'">
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
            </div>
            <div class="col-lg-5 col-xs-10">
                <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
            </div>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll; min-height: 100vh;">
            <div class="modal-body">
                <div class="col-lg-12 col-xs-12">
                    <h3 style="margin-top: 20px;" class="page-header">College Admission Form<br />
                        <small class="muted">Please fill up the form completely</small>
                    </h3>
                </div>
                <?php
                $attributes = array('class' => '', 'role' => 'form', 'id' => 'admissionForm', 'onsubmit' => 'event.preventDefault();');
                echo form_open(base_url() . 'college/enrollment/saveAdmission', $attributes);
                ?>
                <div class="col-lg-12">
                    <div class="form-group col-lg-3 col-xs-12">
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
                        <div class="text-danger" id="inputCFirstNameEmpty"></div>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
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

                    <div class="form-group col-lg-3 col-xs-12">
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
                        <div class="text-danger" id="inputCLastNameEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Select Course<span class="error">*</span></label><br />
                        <select style="height:35px; width: 100%;" name="getCourse"  id="getCourse" required>
                            <option value="none">Select Course</option>
                            <?php
                            foreach ($course as $level) {
                                ?>
                                <option value="<?php echo $level->course_id; ?>"><?php echo $level->short_code; ?></option>
                            <?php } ?>
                        </select>
                        <div class="text-danger" id="inputCourseEmpty"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Year Level<span class="error">*</span></label><br />
                        <div id="AddedSection">
                            <select name="inputYear" id="inputYear" style="height:35px; width: 100%;" required>
                                <option value="none">Select Year Level</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                            </select>
                        </div>
                        <div class="text-danger" id="inputYearEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Date of Birth<span class="error">*</span></label>
                        <input style="margin-right: 10px;" class="form-control" name="inputBdate" type="date"  data-date-format="yyyy-mm-dd" id="inputBdate" placeholder="Date of Birth" required>
                        <div class="text-danger" id="inputBdateEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Place of Birth</label>
                        <input style="margin-right: 10px;" class="form-control" name="inputPlaceOfBirth" type="text" id="inputPlaceOfBirth" placeholder="Place of Birth" required>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputNationaly">Nationality</label>
                        <input class="form-control" name="inputNationality" type="text" id="inputNationality" placeholder="Nationality">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputCReligion">Religion</label>
                        <div class="controls">
                            <select name="inputCReligion" id="inputCreligion" style="height:35px; width: 100%;" required>
                                <option>Select Religion</option>
                                <?php
                                foreach ($religion as $r) {
                                    ?>
                                    <option value="<?php echo $r->rel_id; ?>"><?php echo $r->religion; ?></option>

                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputGender">Gender<span class="error">*</span></label>
                        <div class="controls">
                            <select name="inputCGender" id="inputCGender" style="height:35px; width: 100%;" required>
                                <option value="none">Select Your Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="text-danger" id="inputCGenderEmpty"></div>

                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputBirthDate">Date Enrolled<span class="error">*</span></label>
                        <input class="form-control" name="inputCEdate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="inputEdate" placeholder="Date Enrolled" required>

                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputBirthDate">School Year<span class="error">*</span></label><br />
                        <select tabindex="-1" id="inputCSY" name="inputCSY" style="height:35px; width: 100%;">
                            <option value="none">School Year</option>
                            <?php
                            //for ($ro = 2018; $ro <= date('Y'); $ro++) { //disabled due to enrollment restriction
                            for ($ro = 2019; $ro <= 2021; $ro++) {
                                $roYears = $ro + 1;
                                if ($settings->school_year == $ro):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $ro; ?>"><?php echo $ro . ' - ' . $roYears; ?></option>
                            <?php } ?>
                        </select>
                        <div class="text-danger" id="inputCSYEmpty"></div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Semester<span class="error">*</span></label><br />
                        <div id="AddedSection">
                            <select name="inputSemester" id="inputSemester" style="height:35px; width: 100%;" required>
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
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label">School Last Attended:</label>
                        <input style="margin-bottom:0;" class="form-control" name="inputCSLA" type="text" id="inputSLA" placeholder="School Last Attended">
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label">Address of School Last Attended:</label>
                        <input style="margin-bottom:0;" class="form-control" name="inputCAddressSLA" type="text" id="inputAddressCSLA" placeholder="Address">
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <h4 style="margin-top: 20px;" class="page-header">Contact Information</h4>
                </div>
                <div class="col-lg-12">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputAddress">Street</label>
                        <input style="margin-bottom:0;" class="form-control" name="inputStreet" type="text" id="inputStreet" placeholder="Street" required>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputAddress">Barangay:<span class="error">*</span></label>
                        <input style="margin-bottom:0;" class="form-control"  name="inputBarangay" type="text" id="inputBarangay" placeholder="Barangay" required>
                        <div id="inputBarangayEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputCity">City / Municipality:<span class="error">*</span></label>
                        <select onclick="getProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="inputMunCity" name="inputMunCity">
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!--<input style="margin-bottom:0;" class="form-control"  name="inputMunCity" class="select2-search" type="text" id="inputMunCity" placeholder="City / Municipality" required>-->
                        <div class="text-danger" id="inputMunCityEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputState">Province:<span class="error">*</span></label>
                        <input style="margin-bottom:0;" class="form-control"  name="inputProvince" type="text" id="inputProvince" placeholder="State / Province" required>
                        <input style="margin-bottom:0;" class="form-control"  name="inputPID" type="hidden" id="inputPID" placeholder="State / Province" required>
                        <div class="text-danger" id="inputProvinceEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputPostal">Postal Code:<span class="error">*</span></label>
                        <input style="margin-bottom:0;" class="form-control"  name="inputPostal" type="text" id="inputPostal" placeholder="Postal Code" required>
                        <div class="text-danger" id="inputPostalEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputContact">Contact Number:</label>
                        <input style="margin-bottom:0;" class="form-control"  name="inputPhone" type="text" id="inputPhone" placeholder="Phone">
                        <div class="text-danger" id="inputPhoneEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputEmail">Email:</label>
                        <input style="margin-bottom:0;" class="form-control"  name="inputEmail" type="text" id="inputEmail" placeholder="Email">
                    </div>
                </div>

                <div class="col-lg-12 col-xs-12">
                    <h4 style="margin-top: 20px;" class="page-header">Family Information :
                    </h4>
                </div>

                <div id="Parents">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputFather">Father's First Name</label>
                            <input name="inputFExist" type="hidden" id="inputFExist" placeholder="Father's First and Middle Name" required>
                            <input style="margin-bottom:0;" class="form-control"   name="inputFName" type="text" id="inputFName" placeholder="Father's First Name" required>
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputF_occ">Father's Middle Name:</label>
                            <input style="margin-bottom:0;" class="form-control"   name="inputFMName" type="text" id="inputFMName" placeholder="Father's Middle Name" required>
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputF_occ">Father's Last Name:</label>
                            <input style="margin-bottom:0;" class="form-control"   name="inputFLName" type="text" id="inputFLName" placeholder="Father's Last Name" required>
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputF_occ">Profession / Occupation:</label>
                            <input style="margin-bottom:0;" class="form-control"   name="inputF_occ" type="text" id="inputF_occ" placeholder="Father's Occupation" required>
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputF_num">Contact Number:</label>
                            <input style="margin-bottom:0;" class="form-control"   name="inputF_num" type="text" id="inputF_num" placeholder="Father's Contact Number" required>
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputPEmail">Email:</label>
                            <input style="margin-bottom:0;" class="form-control"   name="inputPEmail" type="text" id="inputPEmail" placeholder="Father's Email" >
                        </div>

                        <div class="form-group  col-lg-3 col-xs-12">
                            <label class="control-label" for="inputFather">Educational Attainment:</label>
                            <select name="inputFeduc" id="inputFeduc" style="height:35px; width: 100%;" required>
                                <option>Select Educational Attainment</option>
                                <?php foreach ($educ_attain as $EA) { ?>
                                    <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputAddress">Father's Office Name</label>
                            <input style="margin-bottom:0;" class="form-control" name="f_officeName" type="text" id="f_officeName" placeholder="Office Name" >
                        </div>
                        <div class="col-lg-12 no-padding">
                            <h5 style="margin:0;">Father's Office Address:</h5>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Street</label>
                                <input style="margin-bottom:0;" class="form-control" name="f_officeStreet" type="text" id="f_officeStreet" placeholder="Street" >
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Barangay:</label>
                                <input style="margin-bottom:0;" class="form-control"  name="f_officeBarangay" type="text" id="f_officeBarangay" placeholder="Barangay" >
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputCity">City / Municipality:</label>
                                <select onclick="getFofficeProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="f_officeMunCity" name="f_officeMunCity">
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputState">Province:</label>
                                <input style="margin-bottom:0;" class="form-control"  name="f_officeProvince" type="text" id="f_officeProvince" placeholder="State / Province" >
                                <input style="margin-bottom:0;" class="form-control"  name="f_officePID" type="hidden" id="f_officePID" placeholder="State / Province" >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-xs-12" style="border-top: 1px solid gray; padding-top:10px;">
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputMother">Mother's First Name:</label>
                            <input style="width:220px; margin-right:10px; margin-bottom:0;" class="form-control" name="inputMother" type="text" id="inputMother" placeholder="Mother's First Name" >
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputMother">Mother's Middle Name:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputMMName" type="text" id="inputMMName" placeholder="Mother's Middle Name" >
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputMother">Mother's Last Name:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputMLName" type="text" id="inputMLName" placeholder="Mother's Last Name" >
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputM_num">Profession / Occupation:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputM_occ" type="text" id="inputM_occ" placeholder="Mother's Occupation" >
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputM_occ">Contact Number:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputM_num" type="text" id="inputM_num" placeholder="Mother's Contact Number" >
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputFather">Educational Attainment:</label>
                            <select name="inputMeduc" id="inputMeduc" style="height:35px; width: 100%;" required>
                                <option>Select Educational Attainment</option>
                                <?php foreach ($educ_attain as $EA) { ?>
                                    <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputAddress">Mother's Office Name</label>
                            <input style="margin-bottom:0;" class="form-control" name="m_officeName" type="text" id="m_officeName" placeholder="Office Name">
                        </div>
                        <div class="col-lg-12 no-padding col-xs-12">
                            <h5 style="margin:0;">Mother's Office Address:</h5>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Street</label>
                                <input style="margin-bottom:0;" class="form-control" name="m_officeStreet" type="text" id="m_officeStreet" placeholder="Street">
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Barangay:</label>
                                <input style="margin-bottom:0;" class="form-control"  name=" " type="text" id="m_officeBarangay" placeholder="Barangay">
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputCity">City / Municipality:</label>
                                <select onclick="getMofficeProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen " style="width:100%;" multiple="" id="m_officeMunCity" name="m_officeMunCity">
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?php echo $city->cid ?>"><?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputState">Province:</label>
                                <input style="margin-bottom:0;" class="form-control"  name="m_officeProvince" type="text" id="m_officeProvince" placeholder="State / Province" >
                                <input style="margin-bottom:0;" class="form-control"  name="m_officePID" type="hidden" id="m_officeProvince" placeholder="State / Province" >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-xs-12" style="border-top: 1px solid gray; padding-top:10px;">
                        <h5>(IN CASE OF EMERGENCY):</h5>
                        <div class="form-group col-lg-3 col-xs-12">

                            <label class="control-label" for="inputEmail">Contact Name:</label>
                            <div class="controls">
                                <?php
                                $inputInCaseName = array(
                                    'name' => 'inputInCaseName',
                                    'id' => 'inputInCaseName',
                                    'placeholder' => 'Contact Name',
                                    'class' => 'form-control',
                                    'style' => 'width:230px;'
                                );

                                echo form_input($inputInCaseName);
                                ?> 

                            </div>
                        </div> 
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputEmail">Contact Number:</label>
                            <div class="controls">
                                <?php
                                $inputInCaseContact = array(
                                    'name' => 'inputInCaseContact',
                                    'id' => 'inputInCaseContact',
                                    'placeholder' => 'Contact Number',
                                    'class' => 'form-control',
                                    'style' => 'width:230px;'
                                );

                                echo form_input($inputInCaseContact);
                                ?>    

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="control-label">
                                By Clicking the Submit Button, I am confirming that the data is true and correct. I understand that the school reserves right to revise any decision made base on the information I provided if it is found to be untrue or incorrect. I likewise agree that any issue that may arise in connection with processing of my personal information will be settled amicably with the school before resorting to appropriate arbitration or court proceedings with the Philippine jurisdiction. Finally, I voluntary provide consent and authorization to the school and its duly authorized representative/s to lawfully process my information.
                            </label>
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-lg-3 col-xs-12 pull-right">
                    <button id="saveAdmission" class="btn btn-success btn-sm col-lg-2 col-xs-12 btn-block">SUMBIT</button>
                    <button onclick="document.location='<?php echo base_url('entrance') ?>'" class="btn btn-danger btn-sm col-lg-2 col-xs-12 btn-block">CANCEL</button>
                </div>
            </div>
        </div>
    </div>    
</div>
<input type="hidden" id="base" value="<?php echo base_url() ?>" />
<script type="text/javascript">
    var base = $('#base').val();

    $(document).ready(function () {
        $("#inputMunCity").select2({maximumSelectionSize: 1});
        $("#m_officeMunCity").select2({maximumSelectionSize: 1});
        $("#f_officeMunCity").select2({maximumSelectionSize: 1});

        $("#saveAdmission").click(function () {
            var url = base + 'college/enrollment/saveAdmission'; // the script where you handle the form input.
            var proceed = 1;
            var warning = " is required";
             if($("#inputCFirstName").val() === ''){
                proceed = 0;
                $("#inputCFirstNameEmpty").html("<small class='error'>Firstname"+warning+"</small>");
             }
             if($("#inputCLastName").val() === ''){
                proceed = 0;
                $("#inputCLastNameEmpty").html("<small class='error'>Lastname"+warning+"</small>");

             }
             if($("#getCourse").val() == "none"){
                proceed = 0;
                $("#inputCourseEmpty").html("<small class='error'>Course"+warning+"</small>");
             }
             if($("#inputYear").val() == "none"){
                proceed = 0;
                $("#inputYearEmpty").html("<small class='error'>School year"+warning+"</small>");
             }
             if($("#inputBdate").val() == ""){
                proceed = 0;
                $("#inputBdateEmpty").html("<small class='error'>Birthdate"+warning+"</small>");
             }
             if($("#inputCGender").val() == 'none'){
                proceed = 0;
                $("#inputCGenderEmpty").html("<small class='error'>Gender"+warning+"</small>");
             }
             if($("#inputCSY").val() == 'none'){
                proceed = 0;
                $("#inputCSYEmpty").html("<small class='error'>School Year"+warning+"</small>");
             }

             if($("#inputBarangay").val() == ''){
                proceed = 0;
                $("#inputBarangayEmpty").html("<small class='error'>Barangay"+warning+"</small>");
             }
             if($("#inputMunCity").val() == null){
                proceed = 0;
                $("#inputMunCityEmpty").html("<small class='error'>Municipality"+warning+"</small>");
             }
             if($("#inputProvince").val() == ''){
                proceed = 0;
                $("#inputProvinceEmpty").html("<small class='error'>Province"+warning+"</small>");
             }
             if($("#inputPostal").val() == ''){
                proceed = 0;
                $("#inputPostalEmpty").html("<small class='error'>Postal"+warning+"</small>");
             }
             if($("#inputPhone").val() == ''){
                proceed = 0;
                $("#inputPhoneEmpty").html("<small class='error'>Phone"+warning+"</small>");
             }
            if (proceed == 1) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $('#admissionForm').serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    beforeSend: function(){
                        $('#loadingModal').modal('show');
                    },
                    success: function (data)
                    {
                        $('#saveAdmission').attr('disabled');
                        alert(data);
                        console.log(data);
                        document.location = base+'entrance';
                    }
                });
            } else {
                setTimeout(clearEmptyMessage, 3000);
            }

        });
    });

    function getProvince(value)
    {
        var url = base + 'main/getProvince/' + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                $('#inputProvince').val(data.name)
                $('#inputPID').val(data.id)
            }
        });
    }

    function refreshIdGeneration()
    {
        var url = "<?php echo base_url() . 'main/refreshIdGeneration/' ?>";
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {

            }
        })
    }


    function getFofficeProvince(value)
    {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                $('#f_officeProvince').val(data.name)
                $('#f_officePID').val(data.id)
            }
        })
    }

    function getMofficeProvince(value)
    {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                $('#m_officeProvince').val(data.name)
                $('#m_officePID').val(data.id)
            }
        })
    }

    function checkID(value)
    {
        var url = "<?php echo base_url() . 'registrar/checkID' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: 'id=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function (data)
            {
                if (data.status)
                {
                    $('#infoReply').html(data.msg)
                    $('#infoReply').fadeIn()
                    $('#inputFirstName').attr('disabled', 'disabled');
                    $('#inputMiddleName').attr('disabled', 'disabled');
                    $('#inputLastName').attr('disabled', 'disabled');
                    // $('#inputLRN').val('');
                } else {
                    $('#infoReply').html(data.msg)
                    $('#infoReply').fadeOut(5000)
                    $('#inputFirstName').removeAttr('disabled');
                    $('#inputMiddleName').removeAttr('disabled');
                    $('#inputLastName').removeAttr('disabled');
                }
            }
        });

        return false; // avoid to execute the actual submit of the form.

    }

    function setId(levelCode) {

        var url = "<?php echo base_url() . 'college/getLatestCollegeNum/' ?>" + levelCode;


        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "level_id=" + levelCode + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                var id = parseInt(data.id) + parseInt(1)
                var prefix = '000';
                if (id < 10)
                {
                    prefix = '000';
                } else
                {
                    if (id < 100) {
                        prefix = '00';
                    } else {
                        prefix = '0';
                    }

                }


            }
        });

        return false;

    }

</script>
