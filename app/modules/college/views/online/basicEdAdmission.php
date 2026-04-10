<?php
// Header & grade range
switch ($dept):
    case 2: $header='Grade School Admission Form'; $st=2; $en=7; break;
    case 3: $header='Junior High School Admission Form'; $st=8; $en=11; break;
    case 4: $header='Senior High School Admission Form'; $st=12; $en=13; break;
    default: $header='Admission Form';
endswitch;

?>

<form id="admissionForm">

<div class="container-fluid my-4">

    <!-- HEADER -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body text-center py-4">
            <h3 class="fw-bold mb-1"><?= $header ?></h3>
            <p class="text-muted mb-0">Please fill out all required fields accurately</p>
        </div>
    </div>

    <!-- STUDENT INFORMATION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white fw-semibold py-3">
            <i class="fa fa-user-graduate me-2 text-primary"></i> Student Information
        </div>
        <div class="card-body row g-4">
            <div class="col-md-3">
                <label class="form-label">First Name *</label>
                <input type="text" id="inputCFirstName" name="inputCFirstName" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Middle Name</label>
                <input type="text" id="inputCMiddleName" name="inputCMiddleName" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Last Name *</label>
                <input type="text" id="inputCLastName" name="inputCLastName" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Grade Level *</label>
                <select name="getLevel" id="getLevel" class="form-select">
                    <option value="">Select Grade Level</option>
                    <?php if($st==2): ?>
                        <option value="14">Nursery</option>
                        <option value="15">Kinder 1</option>
                        <option value="1">Kinder 2</option>
                    <?php endif; ?>
                    <?php for($i=$st;$i<=$en;$i++): ?>
                        <option value="<?= $i ?>">Grade <?= $i-1 ?></option>
                    <?php endfor; ?>
                </select>
                <input type="hidden" id="valueGL" name="valueGL">
            </div>

            <div class="col-md-3">
                <label class="form-label">Semester</label>
                <select name="inputSemester" id="inputSemester" class="form-select">
                    <option value="0">Regular Class</option>
                    <option value="3">Summer Class</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Date of Birth *</label>
                <input type="date" id="inputBdate" name="inputBdate" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Place of Birth</label>
                <input type="text" id="inputPlaceOfBirth" name="inputPlaceOfBirth" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Nationality</label>
                <input type="text" id="inputNationality" name="inputNationality" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Religion</label>
                <select name="inputCReligion" id="inputCreligion" class="form-select">
                    <option value="">Select Religion</option>
                    <?php foreach($religion as $r): if($r->religion!=""): ?>
                        <option value="<?= $r->rel_id ?>"><?= $r->religion ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Gender *</label>
                <select name="inputCGender" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Date Enrolled *</label>
                <input type="text" name="inputCEdate" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">School Year *</label>
                <select name="inputCSY" id="inputCSY" class="form-select">
                    <option value="">Select School Year</option>
                    <?php for($ro=2019;$ro<=date('Y');$ro++): ?>
                        <option value="<?= $ro ?>"><?= $ro ?> - <?= $ro+1 ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- STUDENT CONTACT INFORMATION -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold py-3">
        <i class="fa fa-address-book me-2 text-primary"></i> Contact Information
    </div>

    <div class="card-body row g-4">

        <div class="col-md-3">
            <label class="form-label">Street</label>
            <input type="text" id="inputStreet" name="inputStreet" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Barangay *</label>
            <input type="text" id="inputBarangay" name="inputBarangay" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">City / Municipality *</label>
            <select name="inputMunCity" id="inputMunCity" class="form-select city-select">
                <option value="">Select City / Municipality</option>
                <?php foreach($cities as $c): ?>
                    <option 
                        value="<?= $c->cid ?>"
                        data-pid="<?= $c->id ?>"
                        data-province="<?= $c->province ?>">
                        <?= $c->mun_city ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- hidden fields used by JS -->
            <input type="hidden" id="munCityInput" name="munCityInput">
            <input type="hidden" id="inputPID" name="inputPID">
        </div>

        <div class="col-md-3">
            <label class="form-label">Province *</label>
            <input type="text" id="inputProvince" name="inputProvince" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Postal Code *</label>
            <input type="text" id="inputPostal" name="inputPostal" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Phone</label>
            <input type="text" id="inputPhone" name="inputPhone" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control">
        </div>

    </div>
</div>

    <!-- FATHER INFORMATION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white fw-semibold py-3">
            <i class="fa fa-male me-2 text-primary"></i> Father Information
        </div>
        <div class="card-body row g-4">
            <div class="col-md-3"><label class="form-label">First Name</label><input type="text" id="inputFName" name="inputFName" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Middle Name</label><input type="text" id="inputFMName" name="inputFMName" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Last Name</label><input type="text" id="inputFLName" name="inputFLName" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Date of Birth</label><input type="date" name="f_inputBdate" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Occupation</label><input type="text" name="inputF_occ" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Phone</label><input type="text" name="inputF_num" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="inputPEmail" class="form-control"></div>
        </div>
    </div>

    <!-- MOTHER INFORMATION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white fw-semibold py-3">
            <i class="fa fa-female me-2 text-primary"></i> Mother Information
        </div>
        <div class="card-body row g-4">
            <div class="col-md-3"><label class="form-label">First Name</label><input type="text" id="inputMother" name="inputMother" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Maiden Middle Name</label><input type="text" id="inputMMName" name="inputMMName" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Maiden Last Name</label><input type="text" id="inputMLName" name="inputMLName" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Date of Birth</label><input type="date" name="m_inputBdate" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Occupation</label><input type="text" name="inputM_occ" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Phone</label><input type="text" name="inputM_num" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="inputMEmail" class="form-control"></div>
        </div>
    </div>

    <!-- EMERGENCY CONTACT -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white fw-semibold py-3">
            <i class="fa fa-phone-alt me-2 text-primary"></i> Emergency Contact
        </div>
        <div class="card-body row g-4">
            <div class="col-md-4"><label class="form-label">Name</label><input type="text" id="inputInCaseName" name="inputInCaseName" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Phone</label><input type="text" id="inputInCaseContact" name="inputInCaseContact" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Relation</label><input type="text" id="inputInCaseRelation" name="inputInCaseRelation" class="form-control"></div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body d-flex justify-content-end gap-3">
            <button type="button" class="btn btn-outline-danger px-4" id="cancelAdmission">Cancel</button>
            <button type="button" class="btn btn-success px-5" id="showReview">Review & Submit</button>
        </div>
    </div>

</div>

                </form>
<div class="modal fade" id="loginInfo" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4">

      <!-- Header -->
      <div class="modal-header bg-info text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="loginInfoLabel">
          Please Take Note of the Following
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body" id="admissionBody">
        <!-- dynamically injected content -->
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-between">
        <button
          type="button"
          class="btn btn-outline-danger"
          id="addStudentBtn">
          Add Student
        </button>

        <button
          type="button"
          class="btn btn-success px-4"
          id="continueEnrollmentBtn">
          Done Adding
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Review Info Modal (Bootstrap 5) -->
<div class="modal fade" id="reviewInfo" tabindex="-1" aria-labelledby="reviewInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4">

      <!-- Header -->
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="reviewInfoLabel">
          Review Your Information
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- PERSONAL INFO -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-light fw-semibold">
            Personal Information
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4"><strong>First Name</strong><br><span id="rev-inputCFirstName"></span></div>
              <div class="col-md-4"><strong>Middle Name</strong><br><span id="rev-inputCMiddleName"></span></div>
              <div class="col-md-4"><strong>Last Name</strong><br><span id="rev-inputCLastName"></span></div>

              <div class="col-md-4"><strong>Grade Level</strong><br><span id="rev-valueGL"></span></div>
              <div class="col-md-4"><strong>Date of Birth</strong><br><span id="rev-inputBdate"></span></div>
              <div class="col-md-4"><strong>Place of Birth</strong><br><span id="rev-inputPlaceOfBirth"></span></div>

              <div class="col-md-4"><strong>Nationality</strong><br><span id="rev-inputNationality"></span></div>
              <div class="col-md-4"><strong>Religion</strong><br><span id="rev-religionSelect"></span></div>
              <div class="col-md-4"><strong>Gender</strong><br><span id="rev-inputCGender"></span></div>
            </div>
          </div>
        </div>

        <!-- CONTACT INFO -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-light fw-semibold">
            Contact Information
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4"><strong>Street</strong><br><span id="rev-inputStreet"></span></div>
              <div class="col-md-4"><strong>Barangay</strong><br><span id="rev-inputBarangay"></span></div>
              <div class="col-md-4"><strong>City / Municipality</strong><br><span id="rev-munCityInput"></span></div>

              <div class="col-md-4"><strong>Province</strong><br><span id="rev-inputProvince"></span></div>
              <div class="col-md-4"><strong>Postal Code</strong><br><span id="rev-inputPostal"></span></div>
              <div class="col-md-4"><strong>Phone</strong><br><span id="rev-inputPhone"></span></div>

              <div class="col-md-4"><strong>Email</strong><br><span id="rev-inputEmail"></span></div>
            </div>
          </div>
        </div>

        <!-- FAMILY INFO -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-light fw-semibold">
            Family Information
          </div>
          <div class="card-body">
            <div class="row g-3">

              <div class="col-md-4"><strong>Father First Name</strong><br><span id="rev-inputFName"></span></div>
              <div class="col-md-4"><strong>Father Middle Name</strong><br><span id="rev-inputFMName"></span></div>
              <div class="col-md-4"><strong>Father Last Name</strong><br><span id="rev-inputFLName"></span></div>

              <div class="col-md-4"><strong>Father DOB</strong><br><span id="rev-f_inputBdate"></span></div>
              <div class="col-md-4"><strong>Father Occupation</strong><br><span id="rev-inputF_occ"></span></div>
              <div class="col-md-4"><strong>Father Contact</strong><br><span id="rev-inputF_num"></span></div>

              <div class="col-md-4"><strong>Father Email</strong><br><span id="rev-inputPEmail"></span></div>
              <div class="col-md-4"><strong>Father Education</strong><br><span id="rev-inputFeduc"></span></div>

              <hr class="my-3">

              <div class="col-md-4"><strong>Mother First Name</strong><br><span id="rev-inputMother"></span></div>
              <div class="col-md-4"><strong>Mother Middle Name</strong><br><span id="rev-inputMMName"></span></div>
              <div class="col-md-4"><strong>Mother Last Name</strong><br><span id="rev-inputMLName"></span></div>

              <div class="col-md-4"><strong>Mother DOB</strong><br><span id="rev-m_inputBdate"></span></div>
              <div class="col-md-4"><strong>Mother Occupation</strong><br><span id="rev-inputM_occ"></span></div>
              <div class="col-md-4"><strong>Mother Contact</strong><br><span id="rev-inputM_num"></span></div>

              <div class="col-md-4"><strong>Mother Email</strong><br><span id="rev-inputMEmail"></span></div>
              <div class="col-md-4"><strong>Mother Education</strong><br><span id="rev-inputMeduc"></span></div>

            </div>
          </div>
        </div>

        <!-- EMERGENCY INFO -->
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-light fw-semibold">
            Emergency Contact
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4"><strong>Contact Name</strong><br><span id="rev-inputInCaseName"></span></div>
              <div class="col-md-4"><strong>Contact Number</strong><br><span id="rev-inputInCaseContact"></span></div>
              <div class="col-md-4"><strong>Relation</strong><br><span id="rev-inputInCaseRelation"></span></div>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer align-items-center">
        <div class="form-check me-auto">
          <input class="form-check-input" type="checkbox" id="confirmInfo">
          <label class="form-check-label" for="confirmInfo">
            I confirm that the information is accurate.
          </label>
          <span id="errConfirm" class="text-danger ms-2"></span>
        </div>

        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-success px-4" id="submitApp">
          Submit
        </button>
      </div>

    </div>
  </div>
</div>



<input type="hidden" id="base" value="<?php echo base_url() ?>" />
<script type="text/javascript">

    // Reload page (Add Student)
    $('#addStudentBtn').on('click', function () {
        location.reload();
    });

    $('#continueEnrollmentBtn').on('click', function () {
        window.history.back();
    })

    var base = $('#base').val();

    // Cancel button inside review modal returns to previous page
    $('#cancelReview').on('click', function() {
        // Close modal first
        var reviewModal = bootstrap.Modal.getInstance(document.getElementById('reviewInfo'));
        reviewModal.hide();

        // Return to previous page
        // window.history.back();
    });

    document.getElementById('getLevel').addEventListener('change', function(){
        document.getElementById('valueGL').value = this.value;
    });

    $('#getLevel').on('change', function (){
        $('#valueGL').val(this.options[this.selectedIndex].text);
    })

    // Student city → province auto-fill
    $('select').select2({
        maximumSelectionSize: 1
    });

    // City → Province autofill (works on main form)
    $('#inputMunCity').on('change', function () {
        const selected = $(this).find(':selected');
        const province = selected.data('province') || '';
        $('#inputProvince').val(province);
        $('#munCityInput').val(selected.text());
    });

    // Show review modal when main form submit button is clicked
    $('#showReview').on('click', function () {

    // Reset validation
        $('.form-control, .form-select').removeClass('is-invalid');

        let firstInvalid = null;

        const fields = [
            '#inputCFirstName',
            '#inputCLastName',
            '#getLevel',
            '#inputBdate',
            '#inputGender',        // SELECT
            '#inputCSY',
            '#inputBarangay',
            '#inputMunCity',
            '#inputProvince',
            '#inputInCaseName',
            '#inputInCaseContact',
            '#inputInCaseRelation'
        ];

        fields.forEach(function (selector) {
            const el = $(selector);

            // Skip if element does not exist
            if (!el.length) return;

            let val = el.val();

            // Normalize value (important for selects)
            if (Array.isArray(val)) val = val.length ? val[0] : '';

            if (val === null || val === '' || val === '0' || val === '-1') {
                el.addClass('is-invalid');

                // If Select2, highlight its container
                if (el.hasClass('select2-hidden-accessible')) {
                    el.next('.select2-container')
                    .find('.select2-selection')
                    .addClass('is-invalid');
                }

                if (!firstInvalid) firstInvalid = el;
            }
        });

        // Stop if invalid
        if (firstInvalid) {
            firstInvalid.focus();
            return;
        }

        // Populate review modal
        $('#reviewInfo [id^="rev-"]').each(function () {
            const fieldId = $(this).attr('id').replace('rev-', '');
            const input = $('#' + fieldId);

            if (!input.length) return;

            if (input.is('select')) {
                $(this).text(input.find('option:selected').text());
            } else {
                $(this).text(input.val());
            }
        });

        // Show Bootstrap 5 modal
        const reviewModal = new bootstrap.Modal(
            document.getElementById('reviewInfo')
        );
        reviewModal.show();
    });



    // Submit button (existing AJAX)
    $('#submitApp').click(function() {
        if ($('#confirmInfo').is(':checked')) {
            var url = base + 'college/enrollment/saveBasicEdAdmission';
            console.log($('#admissionForm').serialize());
            $.ajax({
                type: "POST",
                url: url,
                data: $('#admissionForm').serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                beforeSend: function() {
                    $('#reviewInfo').modal('hide');
                    // $('#loadingModal').modal('show');
                },
                success: function(data) {
                    // $('#loadingModal').modal('hide');
                    $('#loginInfo').modal('show');
                    $('#admissionBody').html('<p class="text-center my-3">' + data + '</p>');
                }
            });
        } else {
            $('#errConfirm').text('Please check the confirmation box before submitting.').fadeIn();
            setTimeout(function() { $('#errConfirm').fadeOut(); }, 5000);
        }
    });

    $('#cancelAdmission').on('click', function() {
        // Go back to previous page
        window.history.back();
    });


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

    //     $("#saveAdmission").click(function() {
    //         var proceed = 1;
    //         var warning = " is required";
    //         if ($("#inputCFirstName").val() === '') {
    //             proceed = 0;
    //             $("#inputCFirstNameEmpty").html("<small class='error'>Firstname" + warning + "</small>");
    //         }
    //         if ($("#inputCLastName").val() === '') {
    //             proceed = 0;
    //             $("#inputCLastNameEmpty").html("<small class='error'>Lastname" + warning + "</small>");

    //         }
    //         if ($("#getCourse").val() == "none") {
    //             proceed = 0;
    //             $("#inputCourseEmpty").html("<small class='error'>Course" + warning + "</small>");
    //         }
    //         if ($("#inputYear").val() == "none") {
    //             proceed = 0;
    //             $("#inputYearEmpty").html("<small class='error'>School year" + warning + "</small>");
    //         }
    //         if ($("#inputBdate").val() == "") {
    //             proceed = 0;
    //             $("#inputBdateEmpty").html("<small class='error'>Birthdate" + warning + "</small>");
    //         }
    //         if ($("#inputCGender").val() == 'none') {
    //             proceed = 0;
    //             $("#inputCGenderEmpty").html("<small class='error'>Gender" + warning + "</small>");
    //         }
    //         if ($("#inputCSY").val() == 'none') {
    //             proceed = 0;
    //             $("#inputCSYEmpty").html("<small class='error'>School Year" + warning + "</small>");
    //         }

    //         if ($("#inputBarangay").val() == '') {
    //             proceed = 0;
    //             $("#inputBarangayEmpty").html("<small class='error'>Barangay" + warning + "</small>");
    //         }
    //         if ($("#inputMunCity").val() == null) {
    //             proceed = 0;
    //             $("#inputMunCityEmpty").html("<small class='error'>Municipality" + warning + "</small>");
    //         }
    //         if ($("#inputProvince").val() == '') {
    //             proceed = 0;
    //             $("#inputProvinceEmpty").html("<small class='error'>Province" + warning + "</small>");
    //         }
    //         if ($("#inputPostal").val() == '') {
    //             proceed = 0;
    //             $("#inputPostalEmpty").html("<small class='error'>Postal" + warning + "</small>");
    //         }
    //         if ($("#inputInCaseName").val() == '') {
    //             proceed = 0;
    //             $("#inputInCaseNameEmpty").html("<small class='error'>Phone" + warning + "</small>");
    //         }
    //         if ($("#inputInCaseContact").val() == '') {
    //             proceed = 0;
    //             $("#inputInCaseContactEmpty").html("<small class='error'>Phone" + warning + "</small>");
    //         }
    //         if (proceed == 1) {
    //             var ids = $('#admissionForm [id]').map(function() {
    //                 return this.id;
    //             }).get();
    //             $('#reviewInfo').modal('show');

    //             $('.col-md-6').addClass('pointer');
    //             $('.col-md-4').addClass('pointer');

    //             $.each(ids, function(index, value) {
    //                 $('#rev-' + value).text($('#' + value).val());
    //             });
    //         } else {
    //             setTimeout(clearEmptyMessage, 3000);
    //         }

    //     });
    });

    // $('#submitApp').click(function() {
    //     if ($('#confirmInfo').is(':checked')) {
    //         var url = base + 'college/enrollment/saveBasicEdAdmission';
    //         $.ajax({
    //             type: "POST",
    //             url: url,
    //             data: $('#admissionForm').serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
    //             beforeSend: function() {
    //                 $('#loadingModal').modal('show');
    //             },
    //             success: function(data) {
    //                 $('#loadingModal').modal('hide');
    //                 $('#reviewInfo').modal('hide');
    //                 $('#loginInfo').modal('show');
    //                 $('#admissionBody').html('<p style="margin: 20px;" class="text-center">' + data + '</p>')
    //                 // document.location = base + 'enrollment';
    //             }
    //         });
    //     } else {
    //         $('#errConfirm').fadeIn();
    //         $('#submitApp').fadeOut();
    //         $('#errConfirm').html('<p style="color: white; background-color: red; margin: 15px; padding: 15px"><i class="fa fa-exclamation-triangle"></i> Please select the confirmation checkbox to proceed.');
    //         setTimeout(function() {
    //             $('#errConfirm').fadeOut();
    //             $('#submitApp').fadeIn();
    //         }, 5000);
    //     }
    // })

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

    $('select').on('change', function () {
        $(this).removeClass('is-invalid');

        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).next('.select2-container')
                .find('.select2-selection')
                .removeClass('is-invalid');
        }
    });

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

    .is-invalid {
        border-color: red !important;
        box-shadow: 0 0 3px red;
    }

    .select2-container .select2-selection.is-invalid {
        border-color: #dc3545 !important;
    }

</style>