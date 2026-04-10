<div class="col-lg-12 clearboth no-padding col-xs-12" style="background: #ccc;">
    <div class="col-lg-8 col-xs-12" style="margin:10px auto; float: none !important" tabindex="-1" aria-hidden="true">
        <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">

            <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location = '<?php echo base_url('college') ?>'">
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:50px; background: white; margin:0 auto;" />
            </div>
            <div class="col-lg-5 col-xs-10">
                <h1 class="text-left no-margin" style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                <h6 class="text-left" style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
            </div>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll; min-height: 100vh;">
            <div class="modal-body">
                <div class="col-lg-12 col-xs-12">
                    <?php
                    switch ($dept):
                        case 2:
                            $header = 'Grade School Admission Form';
                            $st = 2;
                            $en = 7;
                            break;
                        case 3:
                            $header = 'Junior High School Admission Form';
                            $st = 8;
                            $en = 11;
                            break;
                        case 4:
                            $header = 'Senior High School Admission Form';
                            $st = 12;
                            $en = 13;
                            break;
                    endswitch;
                    ?>
                    <h3 style="margin-top: 20px;" class="page-header"><?php echo $header ?><br />
                        <small class="muted">Please fill up the form completely</small>
                    </h3>
                </div>
                <?php
                $attributes = array('class' => '', 'role' => 'form', 'id' => 'admissionForm', 'onsubmit' => 'event.preventDefault();');
                echo form_open(base_url() . 'college/enrollment/saveBasicEdAdmission', $attributes);
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
                        <label>Select Grade Level<span class="error">*</span></label><br />
                        <select class="selectOpt" style="height:35px; width: 100%;" name="getLevel" id="getLevel">
                            <option value="">Select Grade Level</option>
                            <?php
                            if ($st == 2):
                            ?>
                                <option value="14" tdn="Nursery" inp="valueGL">Nursery</option>
                                <option value="15" tdn="Kinder 1" inp="valueGL">Kinder 1</option>
                                <option value="1" tdn="Kinder 2" inp="valueGL">Kinder 2</option>
                            <?php
                            endif;
                            for ($i = $st; $i <= $en; $i++) :
                            ?>
                                <option value="<?php echo $i; ?>" tdn="<?php echo 'Grade ' . ($i - 1); ?>" inp="valueGL"><?php echo 'Grade ' . ($i - 1); ?></option>
                            <?php endfor; ?>
                        </select>
                        <input type="hidden" id="valueGL" />
                        <div class="text-danger" id="inputCourseEmpty"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <?php
                    if ($dept == 4):
                        $strand = Modules::run('registrar/getSeniorHighStrand');
                    ?>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label>Select Strand<span class="error">*</span></label><br />
                            <select style="height:35px; width: 100%;" name="strand" id="strand">
                                <?php foreach ($strand as $s): ?>
                                    <option value="<?php echo $s->st_id ?>"><?php echo $s->strand ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php
                    else:
                    ?>
                        <input type="hidden" name="strand" id="strand" value="0" />
                    <?php
                    endif; ?>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Date of Birth<span class="error">*</span></label>
                        <input style="margin-right: 10px;" class="form-control" name="inputBdate" type="date" data-date-format="yyyy-mm-dd" id="inputBdate" placeholder="Date of Birth">
                        <div class="text-danger" id="inputBdateEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label>Place of Birth</label>
                        <input style="margin-right: 10px;" class="form-control" name="inputPlaceOfBirth" type="text" id="inputPlaceOfBirth" placeholder="Place of Birth">
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
                            <select name="inputCReligion" id="inputCreligion" class="selectOpt" style="height:35px; width: 90%;">
                                <option value="">Select Religion</option>
                                <?php
                                foreach ($religion as $r) {
                                    if ($r->religion != ""):
                                ?>
                                        <option value="<?php echo $r->rel_id; ?>" tdn="<?php echo $r->religion; ?>" inp="religionSelect"><?php echo $r->religion; ?></option>

                                <?php endif;
                                }
                                ?>
                            </select>
                            <input type="hidden" id="religionSelect" />
                            <i class="fa fa-plus fa-sm text-info" style="cursor:pointer" id="addRel" role="button" data-toggle="popover" title="Add Religion" data-content="
                            <form id='addReligionForm' class='form-group row'>
                                <div class='col-lg-12'>
                                    <input type='text' class='form-control' placeholder='Type Religion' name='religionName' />
                                </div>
                                <div class='col-lg-12' style='margin-top: 10px;'>
                                    <div class='pull-right'>
                                        <button type='button' class='btn btn-success btn-xs' onclick='saveReligion(this)'>Save</button>
                                        <button type='button' class='btn btn-danger btn-xs' onclick='closeMe(this)'>Close</button>
                                    </div>
                                </div>
                            </form>"></i>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputGender">Gender<span class="error">*</span></label>
                        <div class="controls">
                            <select name="inputCGender" id="inputCGender" class="selectOpt" style="height:35px; width: 100%;">
                                <option value="">Select Your Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="text-danger" id="inputCGenderEmpty"></div>

                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputBirthDate">Date Enrolled<span class="error">*</span></label>
                        <input class="form-control" name="inputCEdate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="inputEdate" placeholder="Date Enrolled">

                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputBirthDate">School Year<span class="error">*</span></label><br />
                        <select tabindex="-1" id="inputCSY" name="inputCSY" class="selectOpt" style="height:35px; width: 100%;">
                            <option value="none">School Year</option>
                            <?php
                            //for ($ro = 2018; $ro <= date('Y'); $ro++) { //disabled due to enrollment restriction
                            for ($ro = 2019; $ro <= date('Y'); $ro++) {
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
                        <input type="hidden" id="syValue" />
                        <div class="text-danger" id="inputCSYEmpty"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <?php
                    if ($dept == 4): ?>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label>Semester<span class="error">*</span></label><br />
                            <div id="AddedSection">
                                <select name="inputSemester" id="inputSemester" style="height:35px; width: 100%;">
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
                                    <option Selected value="1">First</option>
                                    <option <?php //echo $second 
                                            ?> value="2">Second</option>
                                    <option <?php //echo $third 
                                            ?> value="3">Summer</option>
                                </select>
                            </div>
                        </div>
                    <?php else:

                    endif;
                    ?>
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
                        <input style="margin-bottom:0;" class="form-control" name="inputStreet" type="text" id="inputStreet" placeholder="Street">
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputAddress">Barangay:<span class="error">*</span></label>
                        <input style="margin-bottom:0;" class="form-control" name="inputBarangay" type="text" id="inputBarangay" placeholder="Barangay">
                        <div id="inputBarangayEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputCity">City / Municipality:<span class="error">*</span></label>
                        <select onclick="getProvince(this.value), alert(this.attr('opt'))" placeholder="Select A Municipality / City" class="populate select2-offscreen selectOpt" style="width:100%;" id="inputMunCity" name="inputMunCity">
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo $city->cid ?>" tdn="<?php echo $city->mun_city ?>" inp="munCityInput"><?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="munCityInput" />
                        <!--<input style="margin-bottom:0;" class="form-control"  name="inputMunCity" class="select2-search" type="text" id="inputMunCity" placeholder="City / Municipality" required>-->
                        <div class="text-danger" id="inputMunCityEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputState">Province:<span class="error">*</span></label>
                        <input style="margin-bottom:0;" class="form-control" name="inputProvince" type="text" id="inputProvince" placeholder="State / Province">
                        <input style="margin-bottom:0;" class="form-control" name="inputPID" type="hidden" id="inputPID" placeholder="State / Province">
                        <div class="text-danger" id="inputProvinceEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputPostal">Postal Code:<span class="error">*</span></label>
                        <input style="margin-bottom:0;" class="form-control" name="inputPostal" type="text" id="inputPostal" placeholder="Postal Code">
                        <div class="text-danger" id="inputPostalEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputContact">Contact Number:</label>
                        <input style="margin-bottom:0;" class="form-control" name="inputPhone" type="text" id="inputPhone" placeholder="Phone">
                        <div class="text-danger" id="inputPhoneEmpty"></div>
                    </div>

                    <div class="form-group col-lg-3 col-xs-12">
                        <label class="control-label" for="inputEmail">Email:</label>
                        <input style="margin-bottom:0;" class="form-control" name="inputEmail" type="text" id="inputEmail" placeholder="Email">
                    </div>
                </div>

                <div class="col-lg-12 col-xs-12">
                    <h4 style="margin-top: 20px;" class="page-header">Family Information :
                    </h4>
                </div>

                <div id="Parents">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputFather">Father's First Name</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputFName" type="text" id="inputFName" placeholder="Father's First Name">
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputF_occ">Father's Middle Name:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputFMName" type="text" id="inputFMName" placeholder="Father's Middle Name">
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputF_occ">Father's Last Name:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputFLName" type="text" id="inputFLName" placeholder="Father's Last Name">
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label>Date of Birth<span class="error">*</span></label>
                            <input style="margin-right: 10px;" class="form-control" name="f_inputBdate" type="date" data-date-format="yyyy-mm-dd" id="f_inputBdate" placeholder="Date of Birth">
                            <div class="text-danger" id="inputBdateEmpty"></div>
                        </div>
                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputF_occ">Profession / Occupation:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputF_occ" type="text" id="inputF_occ" placeholder="Father's Occupation">
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputF_num">Contact Number:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputF_num" type="text" id="inputF_num" placeholder="Father's Contact Number">
                        </div>

                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputPEmail">Email:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputPEmail" type="text" id="inputPEmail" placeholder="Father's Email">
                        </div>

                        <div class="form-group  col-lg-3 col-md-12">
                            <label class="control-label" for="inputFather">Educational Attainment:</label>
                            <select name="inputFeduc" id="inputFeduc" style="height:35px; width: 100%;">
                                <option value="">Select Educational Attainment</option>
                                <?php foreach ($educ_attain as $EA) { ?>
                                    <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputAddress">Father's Office Name</label>
                            <input style="margin-bottom:0;" class="form-control" name="f_officeName" type="text" id="f_officeName" placeholder="Office Name">
                        </div>
                        <div class="col-lg-12 no-padding">
                            <h5 style="margin:0;">Father's Office Address:</h5>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Street</label>
                                <input style="margin-bottom:0;" class="form-control" name="f_officeStreet" type="text" id="f_officeStreet" placeholder="Street">
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Barangay:</label>
                                <input style="margin-bottom:0;" class="form-control" name="f_officeBarangay" type="text" id="f_officeBarangay" placeholder="Barangay">
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputCity">City / Municipality:</label>
                                <select onclick="getFofficeProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen citySelect" style="width:100%;" id="f_officeMunCity" name="f_officeMunCity">
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?php echo $city->cid ?>" tdn="<?php echo $city->mun_city ?>" inp="f_munCityInput"><?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" id="f_munCityInput" />
                            </div>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputState">Province:</label>
                                <input style="margin-bottom:0;" class="form-control" name="f_officeProvince" type="text" id="f_officeProvince" placeholder="State / Province">
                                <input style="margin-bottom:0;" class="form-control" name="f_officePID" type="hidden" id="f_officePID" placeholder="State / Province">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-xs-12" style="border-top: 1px solid gray; padding-top:10px;">
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputMother">Mother's First Name:</label>
                            <input style="width:220px; margin-right:10px; margin-bottom:0;" class="form-control" name="inputMother" type="text" id="inputMother" placeholder="Mother's First Name" />
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputMother">Mother's Maiden Middle Name:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputMMName" type="text" id="inputMMName" placeholder="Mother's Middle Name">
                        </div>

                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputMother">Mother's Maiden Last Name:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputMLName" type="text" id="inputMLName" placeholder="Mother's Last Name">
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label>Date of Birth<span class="error">*</span></label>
                            <input style="margin-right: 10px;" class="form-control" name="m_inputBdate" type="date" data-date-format="yyyy-mm-dd" id="m_inputBdate" placeholder="Date of Birth">
                            <div class="text-danger" id="inputBdateEmpty"></div>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputM_num">Profession / Occupation:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputM_occ" type="text" id="inputM_occ" placeholder="Mother's Occupation" />
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputM_occ">Contact Number:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputM_num" type="text" id="inputM_num" placeholder="Mother's Contact Number" />
                        </div>
                        <div class="form-group col-lg-3 col-md-12">
                            <label class="control-label" for="inputMEmail">Email:</label>
                            <input style="margin-bottom:0;" class="form-control" name="inputMEmail" type="text" id="inputMEmail" placeholder="Mother's Email">
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputFather">Educational Attainment:</label>
                            <select name="inputMeduc" id="inputMeduc" style="height:35px; width: 100%;">
                                <option value="">Select Educational Attainment</option>
                                <?php foreach ($educ_attain as $EA) { ?>
                                    <option value="<?php echo $EA->ea_id ?>"><?php echo $EA->attainment ?></option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputAddress">Mother's Office Name</label>
                            <input style="margin-bottom:0;" class="form-control" name="m_officeName" type="text" id="m_officeName" placeholder="Office Name" />
                        </div>
                        <div class="col-lg-12 no-padding col-xs-12">
                            <h5 style="margin:0;">Mother's Office Address:</h5>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Street</label>
                                <input style="margin-bottom:0;" class="form-control" name="m_officeStreet" type="text" id="m_officeStreet" placeholder="Street" />
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputAddress">Barangay:</label>
                                <input style="margin-bottom:0;" class="form-control" name=" " type="text" id="m_officeBarangay" placeholder="Barangay" />
                            </div>

                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputCity">City / Municipality:</label>
                                <select onclick="getMofficeProvince(this.value)" placeholder="Select A Municipality / City" class="populate select2-offscreen citySelect" style="width:100%;" id="m_officeMunCity" name="m_officeMunCity" />
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?php echo $city->cid ?>" tdn="<?php echo $city->mun_city ?>" inp="m_munCityInput"><?php echo $city->mun_city . ' [ ' . $city->province . ' ]' ?></option>
                                <?php endforeach; ?>
                                </select>
                                <input type="hidden" id="m_munCityInput" />
                            </div>
                            <div class="form-group col-lg-3 col-xs-12">
                                <label class="control-label" for="inputState">Province:</label>
                                <input style="margin-bottom:0;" class="form-control" name="m_officeProvince" type="text" id="m_officeProvince" placeholder="State / Province" />
                                <input style="margin-bottom:0;" class="form-control" name="m_officePID" type="hidden" id="m_officeProvince" placeholder="State / Province" />
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
                            <div class="text-danger" id="inputInCaseNameEmpty"></div>
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
                            <div class="text-danger" id="inputInCaseContactEmpty"></div>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label class="control-label" for="inputEmail">Relation to Student:</label>
                            <div class="controls">
                                <?php
                                $inputInCaseRelation = array(
                                    'name' => 'inputInCaseRelation',
                                    'id' => 'inputInCaseRelation',
                                    'placeholder' => 'Relation to Student',
                                    'class' => 'form-control',
                                    'style' => 'width:230px;'
                                );

                                echo form_input($inputInCaseRelation);
                                ?>

                            </div>
                            <div class="text-danger" id="inputInCaseRelationEmpty"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-12 pull-right">
                    <button id="saveAdmission" class="btn btn-success btn-sm col-lg-2 col-xs-12 btn-block">SUBMIT</button>
                    <button onclick="document.location = '<?php echo base_url('entrance') ?>'" class="btn btn-danger btn-sm col-lg-2 col-xs-12 btn-block">CANCEL</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="loginInfo">
    <div class="panel panel-info" style="width: 50%; margin-left: 25%; margin-top: 5%;">
        <div class="panel-heading">
            Please take note of the Following
        </div>
        <div class="panel-body" id="admissionBody">

        </div>
        <div class="panel-footer">
            <button class="btn btn-danger " onclick="location.reload()">Add Student?</button>
            <button class="btn btn-success" onclick="document.location.href = '<?php echo base_url() . 'enrollment' ?>'">Continue Enrollment Process ?</button>
        </div>
    </div>
</div>

<div class="modal" id="reviewInfo">
    <div class="panel panel-primary" style="width: 50%; margin-left: 25%; margin-top: 5%; ">
        <div class="panel-heading">
            Double-check the details below to ensure everything is correct before submission
        </div>
        <div class="panel-body">
            <h4 class="text-left">Personal Information</h4>
            <hr>
            <div class="col-md-12">
                <div class="row" style="padding: 10px; border-left: thin blue solid; border-radius: 5px">
                    <div class="col-md-4">
                        <label for="studentId">Firstname: </label><br>
                        <span id="rev-inputCFirstName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Middlename: </label><br>
                        <span id="rev-inputCMiddleName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Lastname: </label><br>
                        <span id="rev-inputCLastName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Grade Level: </label><br>
                        <span id="rev-getLevel" hidden></span>
                        <span id="rev-valueGL"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Date of Birth: </label><br>
                        <span id="rev-inputBdate"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Place of Birth: </label><br>
                        <span id="rev-inputPlaceOfBirth"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Nationality: </label><br>
                        <span id="rev-inputNationality"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Religion: </label><br>
                        <span id="rev-inputCreligion" hidden></span>
                        <span id="rev-religionSelect"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Gender: </label><br>
                        <span id="rev-inputCGender"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="studentId" class="form-label">School Last Attended: </label><br>
                        <span id="rev-inputSLA"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="studentId" class="form-label">Address of School Last Attended: </label><br>
                        <span id="rev-inputAddressCSLA"></span>
                    </div>
                </div>
                <h4 class="mb-4 text-left">Contact Information</h4>
                <hr>
                <div class="row mb-3" style="padding: 10px; border-left: thin green solid; border-radius: 5px">
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Street: </label><br>
                        <span id="rev-inputStreet"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Barangay: </label><br>
                        <span id="rev-inputBarangay"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">City / Municipality: </label><br>
                        <span id="rev-inputMunCity" hidden></span>
                        <span id="rev-munCityInput"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Province: </label><br>
                        <span id="rev-inputProvince"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Postal Code: </label><br>
                        <span id="rev-inputPostal"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Contact Number: </label><br>
                        <span id="rev-inputPhone"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Email: </label><br>
                        <span id="rev-inputEmail"></span>
                    </div>
                </div>
                <h4 class="mb-4 text-left">Family Information</h4>
                <hr>
                <div class="row mb-3" style="padding: 10px; border-left: thin red solid; border-radius: 5px">
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Father's First Name: </label><br>
                        <span id="rev-inputFName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Father's Middle Name: </label><br>
                        <span id="rev-inputFMName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Father's Last Name: </label><br>
                        <span id="rev-inputFLName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Date of Birth: </label><br>
                        <span id="rev-f_inputBdate"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Profession / Occupation: </label><br>
                        <span id="rev-inputF_occ"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Contact Number: </label><br>
                        <span id="rev-inputF_num"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Email: </label><br>
                        <span id="rev-inputPEmail"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Educational Attainment: </label><br>
                        <span id="rev-inputFeduc"></span>
                    </div>
                    <div class="col-md-12"><br>
                        <h4>Father's Office Info</h4>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Father's Office Name: </label><br>
                        <span id="rev-f_officeName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Street: </label><br>
                        <span id="rev-f_officeStreet"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Barangay: </label><br>
                        <span id="rev-f_officeBarangay"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">City / Municipality: </label><br>
                        <span id="rev-f_officeMunCity" hidden></span>
                        <span id="rev-f_munCityInput"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Province: </label><br>
                        <span id="rev-f_officeProvince"></span>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Mother's First Name: </label><br>
                        <span id="rev-inputMother"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Mother's Maiden Middle Name: </label><br>
                        <span id="rev-inputMMName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Mother's Maiden Last Name: </label><br>
                        <span id="rev-inputMLName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Date of Birth: </label><br>
                        <span id="rev-m_inputBdate"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Profession / Occupation: </label><br>
                        <span id="rev-inputM_occ"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Contact Number: </label><br>
                        <span id="rev-inputM_num"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Email: </label><br>
                        <span id="rev-inputMEmail"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Educational Attainment: </label><br>
                        <span id="rev-inputMeduc"></span>
                    </div>
                    <div class="col-md-12">
                        <h4>Mother's Office Info</h4>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Mother's Office Name: </label><br>
                        <span id="rev-m_officeName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Street: </label><br>
                        <span id="rev-m_officeStreet"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Barangay: </label><br>
                        <span id="rev-m_officeBarangay"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">City / Municipality: </label><br>
                        <span id="rev-m_officeMunCity" hidden></span>
                        <span id="rev-m_munCityInput"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Province: </label><br>
                        <span id="rev-m_officeProvince"></span>
                    </div>
                </div>
                <h4 class="mb-4 text-left">Emergency Contact Information</h4>
                <hr>
                <div class="row mb-3" style="padding: 10px; border-left: thin yellow solid; border-radius: 5px">
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Contact Name: </label><br>
                        <span id="rev-inputInCaseName"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Contact Number: </label><br>
                        <span id="rev-inputInCaseContact"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentId" class="form-label">Relation to Student: </label>
                        <span id="rev-inputInCaseRelation"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div style="margin: 20px; padding: 15px; background-color:aquamarine; border-radius: 10px">
                <input type="checkbox" id="confirmInfo">
                I hereby confirm that the above information is accurate and up-to-date. I understand that any changes must be reported to the school registrar immediately.
                <span id="errConfirm" style="color: red;"></span>
                <button class="btn btn-md btn-primary pull-right" id="submitApp" style="margin-right: 10px; margin-top: 10px">Submit</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="base" value="<?php echo base_url() ?>" />
<script type="text/javascript">
    var base = $('#base').val();

    $(document).ready(function() {
        $('.selectOpt').change(function() {
            var opt = $('#' + this.id).find('option:selected').attr('tdn');
            var inp = $('#' + this.id).find('option:selected').attr('inp');
            $('#' + inp).val(opt);
        });
    });

    // function isConfirm() {
    //     if ($('#confirmInfo').is(':checked')) {
    //         $('#submitApp').attr('disabled', false);
    //     } else {
    //         $('#submitApp').attr('disabled', true);
    //     }
    // }

    function closeMe(btn) {
        $(btn).parent().prev().val('');
        $("#addRel").popover('hide');
    }

    function saveReligion(btn) {
        var form = $(btn).parent().parent().parent().serialize() + "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
            url = base + "/college/enrollment/saveReligion";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: form,
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(data) {
                alert(data.message);
                $('#loadingModal').modal('hide');
                console.info(data.details);
                switch (data.type) {
                    case 1:
                        $("#addRel").popover('hide');
                        $("#inputCreligion").html(data.details);
                        break;
                    case 1000:
                        $("#addRel").popover('hide');
                        $("#inputCreligion").html(data.details);
                        break;
                }
            }
        })
    }

    $(document).ready(function() {
        // $("#inputMunCity").select2({
        //     maximumSelectionSize: 1
        // });
        // $("#m_officeMunCity").select2({
        //     maximumSelectionSize: 1
        // });
        // $("#f_officeMunCity").select2({
        //     maximumSelectionSize: 1
        // });
        // $("#inputCreligion").select2()
        $('select').select2({
            maximumSelectionSize: 1
        });
        $("#addRel").popover({
            html: true,
            container: 'body',
            placement: 'bottom'
        });

        $('.col-md-4').click(function() {
            var childID = $(this).find('span').attr('id');
            const cid = childID.split('-');
            $('#reviewInfo').modal('hide');
            $('#' + cid[1]).focus().select();
        });

        $('.col-md-6').click(function() {
            var childID = $(this).find('span').attr('id');
            const cid = childID.split('-');
            $('#reviewInfo').modal('hide');
            $('#' + cid[1]).focus().select();
        });

        $("#saveAdmission").click(function() {
            var proceed = 1;
            var warning = " is required";
            if ($("#inputCFirstName").val() === '') {
                proceed = 0;
                $("#inputCFirstNameEmpty").html("<small class='error'>Firstname" + warning + "</small>");
            }
            if ($("#inputCLastName").val() === '') {
                proceed = 0;
                $("#inputCLastNameEmpty").html("<small class='error'>Lastname" + warning + "</small>");

            }
            if ($("#getCourse").val() == "none") {
                proceed = 0;
                $("#inputCourseEmpty").html("<small class='error'>Course" + warning + "</small>");
            }
            if ($("#inputYear").val() == "none") {
                proceed = 0;
                $("#inputYearEmpty").html("<small class='error'>School year" + warning + "</small>");
            }
            if ($("#inputBdate").val() == "") {
                proceed = 0;
                $("#inputBdateEmpty").html("<small class='error'>Birthdate" + warning + "</small>");
            }
            if ($("#inputCGender").val() == 'none') {
                proceed = 0;
                $("#inputCGenderEmpty").html("<small class='error'>Gender" + warning + "</small>");
            }
            if ($("#inputCSY").val() == 'none') {
                proceed = 0;
                $("#inputCSYEmpty").html("<small class='error'>School Year" + warning + "</small>");
            }

            if ($("#inputBarangay").val() == '') {
                proceed = 0;
                $("#inputBarangayEmpty").html("<small class='error'>Barangay" + warning + "</small>");
            }
            if ($("#inputMunCity").val() == null) {
                proceed = 0;
                $("#inputMunCityEmpty").html("<small class='error'>Municipality" + warning + "</small>");
            }
            if ($("#inputProvince").val() == '') {
                proceed = 0;
                $("#inputProvinceEmpty").html("<small class='error'>Province" + warning + "</small>");
            }
            if ($("#inputPostal").val() == '') {
                proceed = 0;
                $("#inputPostalEmpty").html("<small class='error'>Postal" + warning + "</small>");
            }
            if ($("#inputInCaseName").val() == '') {
                proceed = 0;
                $("#inputInCaseNameEmpty").html("<small class='error'>Phone" + warning + "</small>");
            }
            if ($("#inputInCaseContact").val() == '') {
                proceed = 0;
                $("#inputInCaseContactEmpty").html("<small class='error'>Phone" + warning + "</small>");
            }
            if (proceed == 1) {
                var ids = $('#admissionForm [id]').map(function() {
                    return this.id;
                }).get();
                $('#reviewInfo').modal('show');

                $('.col-md-6').addClass('pointer');
                $('.col-md-4').addClass('pointer');

                $.each(ids, function(index, value) {
                    $('#rev-' + value).text($('#' + value).val());
                });
            } else {
                setTimeout(clearEmptyMessage, 3000);
            }

        });
    });

    $('#submitApp').click(function() {
        if ($('#confirmInfo').is(':checked')) {
            var url = base + 'college/enrollment/saveBasicEdAdmission';
            $.ajax({
                type: "POST",
                url: url,
                data: $('#admissionForm').serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                beforeSend: function() {
                    $('#loadingModal').modal('show');
                },
                success: function(data) {
                    $('#loadingModal').modal('hide');
                    $('#reviewInfo').modal('hide');
                    $('#loginInfo').modal('show');
                    $('#admissionBody').html('<p style="margin: 20px;" class="text-center">' + data + '</p>')
                    // document.location = base + 'enrollment';
                }
            });
        } else {
            $('#errConfirm').fadeIn();
            $('#submitApp').fadeOut();
            $('#errConfirm').html('<p style="color: white; background-color: red; margin: 15px; padding: 15px"><i class="fa fa-exclamation-triangle"></i> Please select the confirmation checkbox to proceed.');
            setTimeout(function() {
                $('#errConfirm').fadeOut();
                $('#submitApp').fadeIn();
            }, 5000);
        }
    })

    function getProvince(value) {
        var url = base + 'main/getProvince/' + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#inputProvince').val(data.name)
                $('#inputPID').val(data.id)
            }
        });
    }

    function refreshIdGeneration() {
        var url = "<?php echo base_url() . 'main/refreshIdGeneration/' ?>";
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {

            }
        })
    }


    function getFofficeProvince(value) {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#f_officeProvince').val(data.name)
                $('#f_officePID').val(data.id)
            }
        })
    }

    function getMofficeProvince(value) {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#m_officeProvince').val(data.name)
                $('#m_officePID').val(data.id)
            }
        })
    }

    function checkID(value) {
        var url = "<?php echo base_url() . 'registrar/checkID' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: 'id=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function(data) {
                if (data.status) {
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
            success: function(data) {
                var id = parseInt(data.id) + parseInt(1)
                var prefix = '000';
                if (id < 10) {
                    prefix = '000';
                } else {
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

<style type="text/css">
    #reviewInfo {
        font-family: Arial, Helvetica, sans-serif;
    }

    #reviewInfo .col-md-4 {
        height: 60px;
    }

    #reviewInfo span {
        margin-left: 5px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        color: green;
    }
</style>