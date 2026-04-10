<div id="chatArea" class="hide">

</div>

<div id="syncModal" class="modal fade" style="width:450px; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="alert alert-danger" id="onSyncMessage">
        <h3 class="text-center"> PLEASE DO NOT CLOSE THIS WINDOW WHILE THE SYSTEM IS SYNCHRONIZING.</h3>
        <h6 class="text-center"><span id="noOfRecords">500</span> Records to Sync...</h6>
        <h6 class="text-center"><span id="noOfRecordsRemaining">500</span> Remaining Record(s) to Sync. <i class="fa fa-spinner fa-spin fa-2x"></i></h6>
    </div>
    <div class="alert alert-info hide" id="onSyncComplete">
        <h3 class="text-center">SYSTEM SUCCESSFULLY SYNCHRONIZED</h3>
        <button class="pull-right btn btn-success btn-sm" data-dismiss="modal">CLOSE</button>
    </div>
</div>


<div id="idleModal" class="modal fade" style="width:450px; margin: 0 auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="alert alert-danger" id="idleMessage">
        <h4 class="text-center">Your Session in e-sKwela is about to Expire in <span id="idleCount"></span> seconds.</h4>
        <button class="pull-right btn btn-success btn-sm" data-dismiss="modal" onclick="resetTimer()">STAY</button>
        <input type="hidden" value="1" id="idleLogController" />
        <button class="pull-right btn btn-danger btn-sm" onclick="document.location='<?php echo base_url() . 'login/logout' ?>'">LOGOUT</button>
    </div>
</div>

<div id="loadingModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 3000;">
    <div class="panel panel-default clearfix" style="width:20%; margin:75px auto;">
        <div class="col-xs-12" style="width:100%;">
            <div class="col-xs-12">
                <p class="text-center">Please wait while processing your request <br />

                    <!-- <img src="<?php //echo base_url().'images/loading.gif'
                                    ?>" style="width:150px;" /> -->
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attendanceRemarkModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Attendance Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label">Remark</label>
                <select class="form-select form-select-sm" id="inputRemark">
                    <option value="">Select Remark</option>
                    <option value="1">Late</option>
                    <option value="2">Cutting Classes</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success btn-sm" onclick="saveAttendanceRemarks()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Progress Modal -->
<div class="modal fade" id="attendanceProgress" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-sm">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Monthly Attendance Progress Report</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="apGraph">
                <!-- Graph will load here -->
            </div>
        </div>
    </div>
</div>

<!-- ATTENDANCE MODAL -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" id="modal_id">
            <div class="modal-header">
                <h5 class="modal-title">Employee Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Hour:</label>
                    <select id="modal_hr" class="form-select form-select-sm"></select>
                </div>
                <div class="mb-2">
                    <label>Minute:</label>
                    <select id="modal_min" class="form-select form-select-sm"></select>
                </div>
                <div class="mb-2">
                    <label>AM/PM:</label>
                    <select id="modal_ampm" class="form-select form-select-sm">
                        <option>AM</option>
                        <option>PM</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>IN/OUT:</label>
                    <select id="modal_inout" class="form-select form-select-sm">
                        <option>IN</option>
                        <option>OUT</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="modalSaveBtn" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Event Name</label>
                    <input type="text" id="eventTitle" class="form-control">
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select id="eventCategory" class="form-select">
                        <?php
                        $event_category = Modules::run('calendar/getEventCategory');
                        foreach ($event_category as $cat): ?>
                            <option value="<?= $cat->cat_id ?>"><?= $cat->events_category ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- REQUIRED HIDDEN FIELDS -->
                <input type="hidden" id="ev_from" value="0800">
                <input type="hidden" id="ev_to" value="1700">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveEvent">Save Event</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cardPreview" tabindex="-1" aria-labelledby="cardPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-danger">

            <!-- Header -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="cardPreviewLabel">
                    Grades Review
                </h5>

                <div class="d-flex gap-2 ms-auto">

                    <!-- Print Button -->
                    <button
                        onclick="printCard()"
                        class="btn btn-light btn-sm">
                        <i class="fa fa-print"></i>
                    </button>

                    <!-- Close -->
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                </div>
            </div>

            <!-- Body -->
            <div class="modal-body" id="cardPreviewData" style="max-height:70vh; overflow:auto;">
                <!-- Dynamic content here -->
            </div>

            <!-- Footer Extra Fields -->
            <div class="modal-footer" id="admittedToWrapper" style="display:none;">
                <div class="container-fluid">
                    <div class="row g-3 w-100">

                        <div class="col-md-6">
                            <label class="form-label">Admitted To</label>
                            <input type="text"
                                id="admittedTo"
                                class="form-control"
                                placeholder="Grade Level">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date"
                                id="dateAdmitted"
                                value="2020-04-01"
                                class="form-control">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal: Add RFID -->
<div class="modal fade" id="addId" tabindex="-1" aria-labelledby="addIdLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title d-flex align-items-center gap-2" id="addIdLabel">
                    <i class="fa fa-id-card"></i>
                    Scan Identification Card
                </h5>
                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">

                <div class="mb-3">
                    <figure>
                        <blockquote class="blockquote">
                            <p>Name</p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            <cite id="stName" title="Source Title">Source Title</cite>
                        </figcaption>
                    </figure>

                    <!-- Input group for better scan UX -->
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">
                            <i class="fa fa-credit-card"></i>
                        </span>
                        <input type="text"
                            id="inputCard"
                            class="form-control"
                            placeholder="Tap or Scan RFID"
                            onclick="this.value=''"
                            autocomplete="off"
                            required>
                    </div>

                    <input type="hidden" id="stud_id">
                    <input type="hidden" id="rfid">
                </div>

                <!-- Result message -->
                <div id="resultSection" class="small fw-semibold text-success"></div>

            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-between">
                <button type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>

                <button type="button"
                    onclick="updateProfile('<?= base64_encode('user_id') ?>','<?= base64_encode('esk_profile') ?>','rfid')"
                    class="btn btn-primary">
                    <i class="fa fa-save me-1"></i>
                    Save RFID
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Modal: Delete ID Confirmation -->
<div class="modal fade" id="deleteIDConfirmation" tabindex="-1" aria-labelledby="deleteIDLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteIDLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i>Delete Student ID
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="user_id" class="form-label fw-bold">Enter Employee ID #:</label>
                    <input type="text" id="user_id" class="form-control rounded" placeholder="ID #:" onclick="this.value=''" required>
                    <input type="hidden" id="stud_id">
                    <input type="hidden" id="sy" value="<?= $this->uri->segment(3) ?>">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="deleteAll" onclick="deleteAll($('#sp_stud_id').html())">
                    <label class="form-check-label" for="deleteAll">
                        Delete all data for student ID (<span id="sp_stud_id"></span>)
                    </label>
                </div>
                <div id="resultSection" class="form-text text-danger"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="$('#deleteAll').prop('checked', false)" data-bs-dismiss="modal">Close</button>
                <button onclick="deleteROStudent()" class="btn btn-danger">
                    <i class="fa fa-trash me-1"></i> Confirm Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Roll Over -->
<div class="modal fade" id="rollOver" tabindex="-1" aria-labelledby="rollOverLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow border-0">

            <!-- Header -->
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title fw-bold" id="rollOverLabel">
                    Roll Over to the Next Level
                </h5>
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <p class="mb-2">
                    You are about to roll over
                    <strong id="stName"></strong>
                    from <strong id="curr_lDesc"></strong>
                    to <strong id="new_lDesc"></strong>.
                </p>

                <p class="text-muted mb-3">
                    Click <b>Confirm</b> to proceed, check the option below to enroll in summer,
                    or close to cancel the process.
                </p>

                <!-- Hidden Fields (UNCHANGED) -->
                <input type="hidden" id="ro_strand_id" />
                <input type="hidden" id="curr_grade_id" />
                <input type="hidden" id="ro_st_id" />
                <input type="hidden" id="ro_grade_id" />
                <input type="hidden" id="ro_section_id" />
                <input type="hidden" id="ro_prev_sec_selected" />
                <input type="hidden" id="ro_badgeIndicator" />

                <!-- Summer Checkbox -->
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="semRoll">
                    <label class="form-check-label" for="semRoll">
                        Enroll to Summer Class
                    </label>
                </div>

                <!-- Result -->
                <div id="resultSection" class="form-text mt-2"></div>

            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-between">

                <button type="button"
                    class="btn btn-outline-secondary"
                    onclick="location.reload()"
                    data-bs-dismiss="modal">
                    Close
                </button>

                <button type="button"
                    onclick="saveRO()"
                    class="btn btn-success">
                    CONFIRM
                </button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Admin Remarks -->
<div class="modal fade" id="adminRemarks" tabindex="-1" aria-labelledby="adminRemarksLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="adminRemarksLabel">
                    Update Student Status
                </h5>
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Remarks -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Remarks</label>

                    <input type="hidden"
                        name="dateRemarked"
                        id="dateRemarked"
                        value="<?php echo date('m-d-Y'); ?>">

                    <select id="inputRemarks" class="form-select">
                        <option>Select Student Status</option>
                        <?php
                        $codeIndicators = Modules::run('main/getCodeIndicators');
                        foreach ($codeIndicators as $ci) { ?>
                            <option value="<?php echo $ci->id ?>">
                                <?php echo $ci->Indicator ?>
                            </option>
                        <?php } ?>
                    </select>

                    <input type="hidden" id="st_id" name="st_id" value="" />
                    <input type="hidden" id="us_id" name="user_id" value="" />
                </div>

                <!-- Required Info -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Required Information for selected Remark
                    </label>
                    <div class="form-text mb-2">
                        ( Please refer to DepEd forms for List and Code Indicators )
                    </div>

                    <textarea id="required_information"
                        name="required_information"
                        rows="5"
                        class="form-control"></textarea>
                </div>

                <!-- Effectivity Date -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Effectivity Date</label>
                    <input type="text"
                        name="inputEffectivity"
                        id="inputEffectivity"
                        class="form-control"
                        placeholder="Effectivity Date"
                        required>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-between">

                <div id="resultSection" class="form-text"></div>

                <button type="button"
                    class="btn btn-primary"
                    data-bs-dismiss="modal"
                    onclick="submitRemarks(); $('#secretContainer').fadeOut(500);">
                    Save
                </button>

            </div>

        </div>
    </div>
</div>

<!------- Basic Info Modal --------------->
<div class="modal fade" id="basicInfoModal" tabindex="-1" aria-labelledby="basicInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="basicInfoModalLabel">
                    <i class="fa fa-user-edit me-2"></i> Edit Student Name
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="firstname" class="form-label fw-semibold">First Name</label>
                        <input type="text" class="form-control rounded-3 shadow-sm"
                            id="firstname"
                            placeholder="Enter first name"
                            value="">
                    </div>

                    <div class="col-md-4">
                        <label for="middlename" class="form-label fw-semibold">Middle Name</label>
                        <input type="text" class="form-control rounded-3 shadow-sm"
                            id="middlename"
                            placeholder="Enter middle name"
                            value="">
                    </div>

                    <div class="col-md-4">
                        <label for="lastname" class="form-label fw-semibold">Last Name</label>
                        <input type="text" class="form-control rounded-3 shadow-sm"
                            id="lastname"
                            placeholder="Enter last name"
                            value="">
                    </div>

                </div>

                <!-- Hidden Fields -->
                <div class="d-none">
                    <input type="hidden" id="pos" value="">
                    <input type="hidden" id="st_user_id" value="">
                    <input type="hidden" id="rowid" value="">
                    <input type="hidden" id="name_id" value="">
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top-0 justify-content-between">
                <button class="btn btn-outline-secondary btn-md px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-success btn-md px-4"
                    onclick="saveBasicInfoModal()">
                    <i class="fa fa-save me-2"></i> Save Changes
                </button>
            </div>

        </div>
    </div>
</div>

<!--------------- Level / Section Update --------------->
<div class="modal fade" id="levelSectionModal" tabindex="-1" aria-labelledby="levelSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="levelSectionModalLabel">
                    <i class="fa fa-layer-group me-2"></i>
                    Edit Level & Section
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">

                <div class="row g-3">

                    <!-- Grade Level -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Grade Level</label>
                        <select name="inputGrade"
                            id="inputGrade"
                            class="form-select shadow-sm"
                            onchange="selectSection(this.value)"
                            required>
                            <option value="">Select Grade Level</option>
                            <?php
                            $gradeLevel = Modules::run('registrar/getGradeLevel');
                            foreach ($gradeLevel as $level) {
                            ?>
                                <option value="<?php echo $level->grade_id; ?>">
                                    <?php echo $level->level; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Section</label>
                        <select name="inputSection"
                            id="inputSection"
                            class="form-select shadow-sm"
                            required>
                            <option value="">Select Section</option>
                        </select>
                    </div>

                    <!-- Specialization -->
                    <div class="col-md-6 d-none" id="tle_specs">
                        <label class="form-label fw-semibold">Specialization</label>
                        <select name="inputSpecialization"
                            id="inputSpecialization"
                            class="form-select shadow-sm">
                            <option value="">Select Specialization</option>
                            <?php
                            $specs = Modules::run('registrar/getSpecialization');
                            foreach ($specs as $s) {
                            ?>
                                <option value="<?php echo $s->specialization_id; ?>">
                                    <?php echo $s->specialization; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Strand -->
                    <div class="col-md-6 d-none" id="sh_strand">
                        <label class="form-label fw-semibold">Strand</label>
                        <select name="inputStrand"
                            id="inputStrand"
                            class="form-select shadow-sm">
                            <option value="">Select Strand</option>
                            <?php $strand = Modules::run('registrar/getSHOfferedStrand'); ?>
                            <?php foreach ($strand as $str) { ?>
                                <option value="<?php echo $str->st_id; ?>">
                                    <?php echo $str->strand; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- School Year -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">School Year</label>
                        <select id="inputEditSY"
                            name="inputEditSY"
                            class="form-select shadow-sm">
                            <option value="">Select School Year</option>
                            <?php
                            foreach ($ro_year as $ro) {
                                $roYears = $ro->ro_years + 1;
                                $selected = ($this->uri->segment(4) == $ro->ro_years) ? 'selected' : '';
                            ?>
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>">
                                    <?php echo $ro->ro_years . ' - ' . $roYears; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>

                <!-- Hidden -->
                <input type="hidden" id="st_id" value="<?php echo base64_encode($st_id) ?>">

            </div>

            <!-- Footer -->
            <div class="modal-footer border-top-0 d-flex justify-content-between px-4 pb-4">

                <button class="btn btn-outline-secondary btn-md px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-success btn-md px-4"
                    onclick="saveProfileLevel()">
                    <i class="fa fa-save me-2"></i>
                    Save Changes
                </button>

            </div>

        </div>
    </div>
</div>

<!----- Update LRN -------->

<div class="modal fade" id="idLrnModal" tabindex="-1" aria-labelledby="idLrnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="idLrnModalLabel">
                    <i class="fa fa-id-card me-2"></i>
                    Edit LRN
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">

                <!-- Student ID Display -->
                <div class="card bg-light border-0 shadow-sm mb-3">
                    <div class="card-body py-3">
                        <div class="text-muted small">Student ID</div>
                        <div class="fw-bold fs-5" id="modal_user_id"></div>
                    </div>
                </div>

                <!-- LRN Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Learner Reference Number (LRN)</label>
                    <input type="text"
                        id="modal_lrn"
                        class="form-control form-control-lg rounded-3 shadow-sm"
                        placeholder="Enter LRN">
                    <div class="form-text">
                        Make sure the LRN is correct before saving.
                    </div>
                </div>

                <input type="hidden" id="modal_uid">

            </div>

            <!-- Footer -->
            <div class="modal-footer border-top-0 d-flex justify-content-between px-4 pb-4">

                <button class="btn btn-outline-secondary btn-md px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-success btn-md px-4"
                    onclick="saveIdLrnModal()">
                    <i class="fa fa-save me-2"></i>
                    Save Changes
                </button>

            </div>

        </div>
    </div>
</div>

<!----------------- Address Info Update -------------------------->
<!-- Edit Address Modal -->
<div class="modal fade" id="addressInfoModal" tabindex="-1" aria-labelledby="addressInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow">

            <!-- Header -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="addressInfoLabel">Edit Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="row g-3">

                    <!-- Street -->
                    <div class="col-md-12">
                        <label class="form-label">Street</label>
                        <input class="form-control"
                            type="text"
                            name="street"
                            value=""
                            placeholder=""
                            id="street">
                    </div>

                    <!-- Barangay -->
                    <div class="col-md-12">
                        <label class="form-label">Barangay</label>
                        <input class="form-control"
                            type="text"
                            name="barangay"
                            value=""
                            id="barangay">
                    </div>

                    <!-- City -->
                    <div class="col-md-12">
                        <label class="form-label">City / Municipality</label>
                        <select class="form-select"
                            id="city"
                            name="inputCity"
                            onclick="getProvince(this.value)">
                            <?php
                            $cities = Modules::run('main/getCities');
                            foreach ($cities as $cit):
                            ?>
                                <option value="<?= $cit->cid ?>">
                                    <?= $cit->mun_city . ' [ ' . $cit->province . ' ]' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Province -->
                    <div class="col-md-12">
                        <label class="form-label">Province</label>
                        <input class="form-control mb-2"
                            value=""
                            name="inputProvince"
                            type="text"
                            id="inputProvince"
                            placeholder="State / Province"
                            required>

                        <input type="hidden"
                            value=""
                            name="inputPID"
                            id="inputPID">
                    </div>

                    <!-- Zip Code -->
                    <div class="col-md-12">
                        <label class="form-label">Zip Code</label>
                        <input class="form-control"
                            type="text"
                            name="zip_code"
                            value=""
                            placeholder=""
                            id="zip_code">
                    </div>

                </div>

                <!-- Hidden Fields -->
                <input type="hidden" id="address_id" value="">
                <input type="hidden" id="address_user_id" value="">

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-sm btn-success"
                    onclick="editAddressInfo()"
                    data-bs-dismiss="modal">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<!-- OTP Code -->
<div id="otpCode" style="width:10%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h6>Enter OTP Code</h6>

        </div>
        <div class="panel-body">
            <h2 id="otp" style="text-align: center; letter-spacing: 3px"></h2>
        </div>
        <div class="paenl-footer">
            <input type="hidden" id="oCode" />
            <input type="hidden" id="pid" />
            <button class="btn-success" style="width: 100%; height: 50px" onclick="genNewPass()">Reset Password</button>
        </div>
    </div>
</div>

<!-- ================= UPLOAD Personal Files MODAL ================= -->

<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa fa-upload me-1"></i> Upload Files
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <?= form_open_multipart('registrar/uploadPersonalFiles'); ?>

            <div class="modal-body">

                <input type="hidden" name="st_id" id="stid_pf" value="">
                <input type="hidden" name="redirect_url" id="redirect_url" value="">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Files</label>
                    <input type="file"
                        name="files[]"
                        class="form-control"
                        multiple
                        required>

                    <small class="text-muted">
                        Allowed: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX (Max 2MB per file)
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="btn btn-primary">
                    Upload
                </button>
            </div>

            <?= form_close(); ?>

        </div>
    </div>
</div>

<!-- ================= RENAME Personal Files MODAL ================= -->

<div class="modal fade" id="renameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fa fa-edit me-1"></i> Rename File
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
            </div>

            <?= form_open('registrar/renamePersonalFile', array('id' => 'renameForm')); ?>

            <div class="modal-body">

                <input type="hidden" name="file_id" id="rename_file_id" value="">
                <input type="hidden" name="stid_renamePF" id="stid_renamePF" value="">
                <input type="hidden" name="rename_redirect_url" id="rename_redirect_url" value="">
                <input type="hidden" name="file_extension" id="rename_file_extension" value="">

                <div class="mb-3">
                    <label class="form-label fw-semibold">File Name</label>
                    <input type="text"
                        name="new_name"
                        id="rename_new_name"
                        class="form-control"
                        required
                        autocomplete="off">
                    <small class="text-muted">
                        Enter the new name for the file (extension will be preserved automatically)
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fa fa-save me-1"></i> Save
                </button>
            </div>

            <?= form_close(); ?>

        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="passChangeModal" tabindex="-1" aria-labelledby="passChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="passChangeModalLabel">Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="oldPass" class="form-label">Enter Old Password</label>
                    <input type="password" name="oldPass" id="oldPass" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="newPass" class="form-label">Enter New Password</label>
                    <input type="password" name="newPass" id="newPass" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="confirmPass" class="form-label">Confirm Password</label>
                    <input type="password" name="confirmPass" id="confirmPass" class="form-control">
                </div>

                <p id="errorMsg" class="alert alert-danger d-none mb-0"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="updatePassword()">Update Password</button>
            </div>

        </div>
    </div>
</div>

<!-- Set Payroll Period Modal -->
<div id="createPay" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Set Payroll Period</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label">From Date</label>
                        <input name="payrollFromDate" type="date" id="payrollFromDate"
                            class="form-control"
                            value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-6">
                        <label class="form-label">To Date</label>
                        <input name="payrollToDate" type="date" id="payrollToDate"
                            class="form-control"
                            value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <input type="hidden" id="pc_code" />
            </div>

            <div class="modal-footer">
                <button onmouseover="generateCode()" onclick="setPayRoll()" class="btn btn-success w-100">
                    Set
                </button>
            </div>
        </div>
    </div>
</div>

<div id="submitPayroll" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h6 class="modal-title">Submit to Payroll</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Number of Hours Rendered</label>
                    <input type="text" id="payrollHoursRendered"
                        class="form-control text-center fw-bold text-danger fs-5"
                        disabled />
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="useLC" onclick="useLC()">
                    <label class="form-check-label">Use Leave Credit?</label>
                </div>

                <div class="mb-3" id="LCWrapper" style="display:none">
                    <label class="form-label">Leave Credit to Use <small>(in hours)</small></label>
                    <input type="text" id="LCHours"
                        class="form-control text-center fw-bold text-danger fs-5" value="0">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary w-100" onclick="submitToPayroll()">Submit</button>
            </div>
        </div>
    </div>
</div>

<div id="editDTR" class="modal fade" tabindex="-1" aria-labelledby="editDTRLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content shadow border-0 rounded-3">

            <!-- Header -->
            <div class="modal-header bg-primary text-white py-2">
                <h6 class="modal-title fw-semibold" id="editDTRLabel">Enter Time to Edit</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" id="bodyid">

                <div class="mb-3">
                    <label for="editDate" class="form-label fw-semibold">Date</label>
                    <input
                        name="editDate"
                        type="date"
                        value=""
                        data-date-format="yyyy-mm-dd"
                        id="editDate"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label for="time_option" class="form-label fw-semibold">Time Option</label>
                    <select id="time_option" class="form-select">
                        <option value="time_in">Time In AM</option>
                        <option value="time_out">Time Out AM</option>
                        <option value="time_in_pm">Time In PM</option>
                        <option value="time_out_pm">Time Out PM</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="timeEdited" class="form-label fw-semibold">Select Time</label>
                    <input
                        id="timeEdited"
                        name="timeEdited"
                        type="time"
                        class="form-control">
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" onclick="saveTimeData()" class="btn btn-sm btn-success">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

<div id="viewDTR" class="modal fade" tabindex="-1" aria-labelledby="viewDTRLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-success">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="viewDTRLabel">Edit DTR</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="dtrBody">
                <!-- Dynamic content here -->
            </div>

        </div>
    </div>
</div>

<!-- Payroll Adjustments Modal -->
<div id="addCharges"
    class="modal fade"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content payroll-modal">

            <!-- HEADER -->
            <div class="modal-header payroll-header">
                <div>
                    <h5 class="modal-title mb-1">Payroll Adjustments</h5>
                    <small class="text-light opacity-75">
                        Manage additional income and deductions
                    </small>
                </div>
                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <form id="updateDeductionForm" class="modal-body px-4 py-4">

                <!-- SUMMARY -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="pay-summary-box">
                            <small class="text-muted">Gross Pay</small>
                            <h5 class="fw-bold text-danger mb-0" id="grossPay">₱0.00</h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="pay-summary-box">
                            <small class="text-muted">Total Income</small>
                            <h5 class="fw-bold text-success mb-0" id="totalIncome">₱0.00</h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="pay-summary-box">
                            <small class="text-muted">Total Deductions</small>
                            <h5 class="fw-bold text-danger mb-0" id="totalDeduction">₱0.00</h5>
                        </div>
                    </div>
                </div>

                <!-- ADD ITEM SECTION -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">

                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    Select Payroll Item
                                </label>
                                <select id="payrollItemsMain" class="form-select">
                                    <option selected disabled>Select Item</option>
                                    <?php
                                    $items = Modules::run('hr/payroll/getPayrollItems');
                                    foreach ($items as $item):
                                        $type = (int)$item->pi_item_type; // 1=Income, 2=Deduction
                                    ?>
                                        <option value="<?php echo $item->pi_item_id ?>" data-type="<?php echo $type ?>">
                                            <?php echo trim($item->pi_item_name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">
                                    Amount
                                </label>
                                <input type="number"
                                    id="itemAmountMain"
                                    class="form-control"
                                    placeholder="Enter amount"
                                    min="0"
                                    step="0.01">

                                <input type="hidden" id="em_id" />
                                <input type="hidden" id="item_pc_code" />
                            </div>

                            <div class="col-lg-2 d-grid">
                                <button type="button"
                                    class="btn btn-primary"
                                    onclick="addItemMain()">
                                    <i class="fa fa-plus me-1"></i> Add
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- APPLIED ITEMS -->
                <h6 class="fw-semibold mb-3">Applied Adjustments</h6>
                <div id="payrollDeductionBodyMain" class="payroll-items-container"></div>

                <input type="hidden" id="pc_profile_id" name="pc_profile_id" />
                <input type="hidden" id="pcCode" name="pcCode" />

            </form>

            <!-- FOOTER -->
            <div class="modal-footer payroll-footer d-flex justify-content-between">

                <div>
                    <small class="text-muted">Net Pay</small>
                    <h5 class="fw-bold text-success mb-0" id="netPay">₱0.00</h5>
                </div>

                <div>
                    <button type="button"
                        class="btn btn-light me-2"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button"
                        onclick="addDeduction()"
                        class="btn btn-success px-4">
                        <i class="fa fa-check me-1"></i> Save Changes
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="loanBreakdownModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-primary text-white p-2">
                <h6 class="modal-title mb-0">Loan Breakdown</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2">
                <ul id="loanBreakdownList" class="list-group list-group-flush small"></ul>
            </div>
            <div class="modal-footer justify-content-between p-2">
                <span class="fw-bold">Total: <span id="loanBreakdownTotal"></span></span>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-success text-white p-2">
                <h6 class="modal-title mb-0">Additional Income Breakdown</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2">
                <ul id="addIncomeList" class="list-group list-group-flush small"></ul>
            </div>
            <div class="modal-footer justify-content-between p-2">
                <span class="fw-bold">Total: <span id="addIncomeTotal"></span></span>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="addItems"
    class="modal fade"
    tabindex="-1"
    aria-labelledby="addItemsLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content shadow-sm border-0">

            <!-- Header -->
            <div class="modal-header bg-success text-white">

                <h5 class="modal-title" id="addItemsLabel">
                    <i class="fa fa-plus-circle me-2"></i>
                    Set Payroll Items
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>

            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Item Name -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Item Name
                    </label>

                    <input name="itemName"
                        id="itemName"
                        type="text"
                        class="form-control"
                        placeholder="Enter payroll item name">
                </div>

                <!-- Item Type -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Item Type
                    </label>

                    <select id="itemType"
                        name="itemType"
                        class="form-select">

                        <option value="">Select Item Type</option>
                        <option value="0">Deduction</option>
                        <option value="1">Additional Income</option>

                    </select>

                </div>

                <!-- Item Category -->
                <div class="mb-3" id="odWrapper" style="display:none;">

                    <label class="form-label fw-semibold">
                        Item Category
                    </label>

                    <select id="itemCat"
                        name="itemCat"
                        class="form-select">

                        <option value="">Select Category</option>
                        <option value="0">Statutory</option>
                        <option value="1">Other Deductions</option>

                    </select>

                </div>

                <input type="hidden" id="pc_code">

            </div>

            <!-- Footer -->
            <div class="modal-footer">

                <button type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button onclick="addItems()"
                    class="btn btn-success">
                    <i class="fa fa-save me-1"></i>
                    Add Item
                </button>

            </div>

        </div>

    </div>

</div>

<!-------------------- Common Modal Alert ------------------------>
<div class="modal fade" id="systemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header" id="systemModalHeader">
                <h5 class="modal-title" id="systemModalTitle">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <div id="systemModalIcon" class="mb-3"></div>
                <p id="systemModalMessage"></p>
            </div>

            <div class="modal-footer justify-content-center">

                <button id="modalCancelBtn"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    style="display:none;">
                    Cancel
                </button>

                <button id="modalConfirmBtn"
                    class="btn btn-primary">
                    OK
                </button>

            </div>

        </div>
    </div>
</div>

<input type="hidden" id="csrf_name" value="<?= $this->security->get_csrf_token_name(); ?>">
<input type="hidden" id="csrf_hash" value="<?= $this->security->get_csrf_hash(); ?>">
<?php

$data['subjects'] = $subjects;
$data['GradeLevel'] = $grade;
$this->load->view('registrar/imgCrop');
$this->load->view('academic/regModal', $data);
$this->load->view('hr/hr_modals');
$this->load->view('hr/deptPosition');
$this->load->view('main/schoolSettingsModal');
$this->load->view('subjectmanagement/seniorHigh_modal');
$this->load->view('subjectmanagement/addSubject_modal');
$this->load->view('coursemanagement/coursemanagement_modal');
$this->load->view('finance/financeModals');
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Loans
        document.querySelectorAll('.loan-toggle').forEach(function(el) {
            el.addEventListener('click', function() {
                const breakdown = JSON.parse(el.dataset.breakdown);
                const list = document.getElementById('loanBreakdownList');
                list.innerHTML = '';
                let total = 0;

                if (breakdown.length === 0) {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'text-center', 'text-muted');
                    li.textContent = 'No active loans';
                    list.appendChild(li);
                } else {
                    breakdown.forEach(item => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'd-flex', 'justify-content-between');
                        li.textContent = item.name;
                        const span = document.createElement('span');
                        span.textContent = '₱ ' + parseFloat(item.amount).toLocaleString('en-PH', {
                            minimumFractionDigits: 2
                        });
                        li.appendChild(span);
                        list.appendChild(li);
                        total += parseFloat(item.amount);
                    });
                }

                document.getElementById('loanBreakdownTotal').textContent =
                    '₱ ' + total.toLocaleString('en-PH', {
                        minimumFractionDigits: 2
                    });

                var loanModal = new bootstrap.Modal(document.getElementById('loanBreakdownModal'));
                loanModal.show();
            });
        });

        // Additional Income
        document.querySelectorAll('.add-toggle').forEach(function(el) {
            el.addEventListener('click', function() {
                const breakdown = JSON.parse(el.dataset.breakdown);
                const list = document.getElementById('addIncomeList');
                list.innerHTML = '';
                let total = 0;

                if (breakdown.length === 0) {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'text-center', 'text-muted');
                    li.textContent = 'No additional income';
                    list.appendChild(li);
                } else {
                    breakdown.forEach(item => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'd-flex', 'justify-content-between');
                        li.textContent = item.name;
                        const span = document.createElement('span');
                        span.textContent = '₱ ' + parseFloat(item.amount).toLocaleString('en-PH', {
                            minimumFractionDigits: 2
                        });
                        li.appendChild(span);
                        list.appendChild(li);
                        total += parseFloat(item.amount);
                    });
                }

                document.getElementById('addIncomeTotal').textContent =
                    '₱ ' + total.toLocaleString('en-PH', {
                        minimumFractionDigits: 2
                    });

                var incomeModal = new bootstrap.Modal(document.getElementById('addIncomeModal'));
                incomeModal.show();
            });
        });

    });

    Push.Permission.request();

    <?php
    //
    //        if(Modules::run('main/isMobile')):
    //            if($this->session->is_logged_in):
    ?>
    // sendNotification('Welcome to e-sKwela Mobile');
    <?php
    //            endif;
    //        endif;

    ?>


    function showAddRFIDForm(id, rfid, name) {
        $('#addId').show();
        $('#secretContainer').html($('#addId').html())
        $('#secretContainer').fadeIn(500)
        $('#stName').text(name)
        $('#stud_id').val(id)
        $("#inputCard").attr('placeholder', rfid);
        $('#rfid').val(rfid);
        $("#inputCard").val('')
        window.setTimeout(function() {
            document.getElementById("inputCard").focus()
        }, 1);
        $('#inputCard').blur(function() {
            //alert('hey')
            window.setTimeout(function() {
                document.getElementById("inputCard").focus();
            }, 0);


        })

    }

    function sendNotification(msg) {
        Push.create('e-sKwela', {
            body: msg,
            icon: '<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>',
            timeout: 15000, // Timeout before notification closes automatically.
            vibrate: [100, 100, 100], // An array of vibration pulses for mobile devices.
            onClick: function() {
                // Callback for when the notification is clicked.
                console.log(this);
            }
        });
    }

    <?php
    if ($this->session->userdata('is_adviser') && date('m') != 4 && date('m') != 5):
    ?>
        $(function() {
            var url = "<?php echo base_url() . 'attendance/checkAdviser/' ?>"
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: url,
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    if (data.status) {
                        //  alert(data.msg)
                    }
                }
            });

            return false;
        });
    <?php
    endif;
    ?>
    $(function() {
        $('#inputBdate').datepicker();
        $('[rel="clickover"]').clickover({
            placement: 'top',
            html: true
        });

        $('#inputEffectivity').datepicker();
    });

    function eCampusCheckIn() {
        var school_id = '<?php echo $settings->school_id ?>';
        var url = 'http://<?php echo $settings->web_address ?>' + '/login/clientCheckIn/';
        $.ajax({
            type: "POST",
            crossDomain: true,
            url: url,
            data: 'school_id=' + school_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            error: function(xhr, textStatus, errorThrown) {
                console.log(textStatus)
            },
            success: function(data) {
                if (data.status) {
                    console.log(data.timestamp);
                } else {
                    console.log('an error has occured')
                }


            }
        });
    }
    // checkForNewMessage();
    function checkForNewMessage() {
        var url = '<?php echo base_url() . 'chatsystem/checkForNewMessage/' ?>';
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                var i;

                if (data.hasMessage) {
                    if (data.num_msgs > 0) {
                        var rel = (data.rel).split(',')
                        var item = (data.ids).split(',')
                        var name = (data.names).split(',')
                        for (i = 0; i <= ((item).length - 1); i++) {
                            var css = i * 310
                            //console.log(item[i])
                            $('#chatArea').append('<div class="chatbox panel panel-green" id="chatbox_' + item[i] + '" style="bottom: 0px; margin-bottom: 0px; right: ' + css + 'px;">\n\
                                        <div class="chatboxhead clearfix">\n\
                                        <div class="panel-heading "><span id="chatHeader">' + name[i] + '</span><div class="chatboxoptions"><a href="javascript:void(0)"><i class="fa fa-minus-square"></i></a> <a href="javascript:void(' + item[i] + ')"><i class="fa fa-close"></i></a></div></div>\n\
                                        <div class="panel-body" id="chitchatBody" style="padding:0 15px;">\n\
                                        <ul id="chitchat_' + item[i] + '" class="chatboxcontent chat">' + data.body + ' </ul>\n\
                                        <div class="chatboxinput panel-footer">\n\
                                        <textarea class="chatboxtextarea" onkeydown="sendChatMessage(event,this,' + item[i] + ')"></textarea>\n\
                                        <input type="hidden" id="pChat_' + item[i] + '" value="' + rel[i] + '" />\n\
                                        </div></div></div></div></div>')
                            //console.log(data.last_id)
                            $("#chitchat_" + item[i]).scrollTop($("#chitchat_" + item[i])[0].scrollHeight);
                            read(rel[i])
                            loadMessage(data.last_id, item[i], 1)

                        }

                    }

                    $('#chatArea').removeClass('hide');

                } else {
                    checkForNewMessage();
                }

            }
        });

        return false;
    }

    function read(pChat) {
        var url = '<?php echo base_url() . 'chatsystem/readMessage/' ?>' + pChat;
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {


            }

        })
    }

    function sendChatMessage(event, chatboxtextarea, user_id) {
        // alert('hey ')
        if (event.keyCode == 13 && event.shiftKey == 0) {

            var chat_url = $('#chat_url').val();
            var pChat_id = $('#pChat_' + user_id).val();
            read(pChat_id)
            var message = $(chatboxtextarea).val();
            message = message.replace(/^\s+|\s+$/g, "");

            $(chatboxtextarea).val(' ');
            $(chatboxtextarea).focus();
            $(chatboxtextarea).css('height', '44px');
            if (message != '') {
                //$.post("http://localhost/CodeIgniter/application/views/chat/chat.php?action=sendchat", {to: user_id, message: message} , function(data){
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: chat_url + "sendchat",
                    data: 'csrf_test_name=' + $.cookie('csrf_cookie_name') + '&to=' + user_id + '& message=' + message + '&pChat_id=' + pChat_id, // serializes the form's elements.
                    success: function(data) {
                        message = message.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\"/g, "&quot;");
                        $("#chitchat_" + user_id).append('<li class="alert alert-success pull-right col-lg-10 col-md-10 col-sm-10" style="margin-bottom:5px; padding:2px"><span class="chatboxmessagecontent">' + message + '</span></li>');
                        $("#chitchat_" + user_id).scrollTop($("#chitchat_" + user_id)[0].scrollHeight);

                    }
                });

                return false;
            }

            return false;
        } else {

        }
    }
    $(document).ready(function() {

        //eCampusCheckIn();
        //checkPortal()
        $('#createCB').click(function() {
            //loadMessage(0,0,0);
            $('#chatArea').removeClass('hide');
            var user_name = $(this).attr('username');
            var user_id = $(this).attr('user_id')
            $('#chatbox_' + user_id).removeClass('hide');

            $(" <div />").attr("id", "chatbox_" + $(this).attr('user_id'))
                .addClass("chatbox panel panel-green")
                .html('<div class="chatbox panel panel-green" id="chatbox_' + user_id + '" style="bottom: 0px; margin-bottom: 0px; right: 10px;">\n\
                    <div class="chatboxhead clearfix">\n\
                    <div class="panel-heading "><span id="chatHeader">' + user_name + '</span><div class="chatboxoptions"><a href="javascript:void(0)"><i class="fa fa-minus-square"></i></a> <a onclick="$(\'#chatbox_' + user_id + '\').addClass(\'hide\')" href="javascript:void(' + user_id + ')"><i class="fa fa-close"></i></a></div></div>\n\
                    <div class="panel-body" id="chitchatBody" style="padding:0 15px;">\n\
                    <ul id="chitchat_' + user_id + '" class="chatboxcontent chat"></ul>\n\
                    <div class="chatboxinput panel-footer">\n\
                    <textarea class="chatboxtextarea" onkeydown="sendChatMessage(event,this,' + user_id + ')"></textarea>\n\
                    <input type="hidden" id="pChat_' + user_id + '" value="" />\n\
                                        </div></div></div></div></div>')
                .appendTo($("#chatArea"));
            $("#chatbox_" + user_id).css('bottom', '0px');
            $("#chatbox_" + user_id).css('margin-bottom', '0');
            $("#chatbox_" + user_id).css('right', '10px');

            var url = '<?php echo base_url() . 'chatsystem/getPreviousChat/' ?>'
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: url,
                data: 'last_id=' + 0 + '&to=' + user_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //console.log(data);
                    if (data.hasMessage) {
                        $("#chitchat_" + user_id).append(data.body)
                        $('#pChat_' + user_id).val(data.rel);
                        $("#chitchat_" + user_id).scrollTop($("#chitchat_" + user_id)[0].scrollHeight);
                    }
                    loadMessage(data.last_id, user_id, 1)
                }

            })
        })
        //
    })
    //loadMessage(0,0,0);

    function loadMessage(msgs, to, Option) {
        if (Option == 1) {

            var url = '<?php echo base_url() . 'chatsystem/loadNewMessage/' ?>'
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: url,
                data: 'last_id=' + msgs + '&to=' + to + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {

                    var i;
                    //console.log('chitchat_'+to)
                    //console.log(data)
                    if (data.hasMessage) {
                        $("#chitchat_" + to).html(data.body)
                        $("#chitchat_" + to).scrollTop($("#chitchat_" + to)[0].scrollHeight);
                    }

                    loadMessage(data.last_id, to, 1)
                }


            })
        } else {

        }


    }




    function showLoading(body) {
        $('#' + body).html($('#submitLoad').html())
    }

    function stopLoading(body) {
        $('#' + body).html('')
    }
    <?php
    if ($this->session->userdata('is_admin')):
        if ($this->uri->uri_string() == 'main/dashboard'):
    ?>
            //checkForNewUpdate();
            //checkForCollegeUpdate();

            function checkForNewUpdate(presents) {
                var url = '<?php echo base_url() . 'widgets/attendance_widgets/getAttendanceUpdates/' ?>' + presents;
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: url,
                    data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    success: function(data) {
                        //console.log(data.presents)
                        if (data.presents == 'undefined') {
                            $('#num_presents').html(0)
                            checkForNewUpdate(0)
                        } else {
                            $('#num_presents').html(data.presents)
                            checkForNewUpdate(data.presents)
                        }

                    }
                });

                return false;
            }

            function checkForCollegeUpdate(presents) {
                var url = '<?php echo base_url() . 'widgets/attendance_widgets/getCollegeAttendanceUpdates/' ?>' + presents;
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: url,
                    data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    success: function(data) {
                        //console.log(data.presents)
                        if (data.presents == 'undefined') {
                            $('#num_college_presents').html(0)
                            checkForCollegeUpdate(0)
                        } else {
                            $('#num_college_presents').html(data.presents)
                            checkForCollegeUpdate(data.presents)
                        }

                    }
                });

                return false;
            }
    <?php
        endif;
    endif;
    ?>

    function notMouseMove() {

        $('#idleModal').modal('show');
        startCountDown(120, 1000, idleLogOut, 'idleCount', 1);
        StartBlinking('Logout')

    }

    function idleLogOut() {
        var option = $('#idleLogController').val();
        if (option == 1) {
            document.location = '<?php echo base_url() . 'login/logout' ?>'

        }
    }

    function stayLogIn() {
        clearTimeout(timer)
        timer = setTimeout(notMouseMove, 600000);
        StopBlinking()
    }


    var timer = setTimeout(notMouseMove, 600000);

    function resetTimer() {
        startCountDown(0, 1000, stayLogIn, 'idleCount', 0);
    }


    $(document).on('mousemove', function() {
        clearTimeout(timer)
        timer = setTimeout(notMouseMove, 600000);
    });

    var originalTitle;

    var blinkTitle;

    var blinkLogicState = false;

    function StartBlinking(title) {
        originalTitle = document.title;

        blinkTitle = title;

        BlinkIteration();
    }

    function BlinkIteration() {
        if (blinkLogicState == false) {
            document.title = blinkTitle;
        } else {
            document.title = originalTitle;
        }

        blinkLogicState = !blinkLogicState;

        blinkHandler = setTimeout(BlinkIteration, 2000);
    }

    function StopBlinking() {
        if (blinkHandler) {
            clearTimeout(blinkHandler);
        }

        document.title = originalTitle;
    }

    //reading notification

    function readNotification(noti_id, user_id, link) {
        var url = '<?php echo base_url() . 'notification_system/readNoti/' ?>' + noti_id + '/' + user_id;
        $.ajax({
            type: "GET",
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                document.location = link;

            }
        });
        return false;
    }

    function string2number(svariable) {
        var cNumber = svariable.replace(/\,/g, '');
        cNumber = parseFloat(cNumber);
        if (isNaN(cNumber) || !cNumber) {
            cNumber = 0;
        }
        return cNumber;
    }

    function number2string(sNumber) {
        var n = sNumber.toString().split(".");
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return n.join(".");
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".count-up").forEach(el => {
            const target = parseInt(el.dataset.count, 10);
            let count = 0;
            const speed = Math.max(15, target / 30);

            const tick = () => {
                count += speed;
                if (count >= target) {
                    el.textContent = target;
                } else {
                    el.textContent = Math.floor(count);
                    requestAnimationFrame(tick);
                }
            };

            tick();
        });
    });

    function generateCode() {
        var fromdate = $('#payrollFromDate').val();
        var todate = $('#payrollToDate').val();

        var d1 = fromdate.split('-');
        var d2 = todate.split('-');

        var pc_code = d1[2] + d2[2] + d1[0] + d2[1]
        $('#pc_code').val(pc_code)
    }

    function setPayRoll() {
        var fromdate = $('#payrollFromDate').val();
        var todate = $('#payrollToDate').val();
        var pc_code = $('#pc_code').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'hr/payroll/setPayrollPeriod' ?>',
            //dataType: 'json',
            data: {
                fromDate: fromdate,
                toDate: todate,
                pc_code: pc_code,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                $('#createPay').modal('hide');
                updatePayrollPeriodList(pc_code);
            }

        });
    }

    function updatePayrollPeriodList(pc_code) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'hr/payroll/updatePayrollPeriodList/' ?>' + pc_code,
            success: function(list) {
                $('#payPeriod').html(list)
            }
        })
    }

    function generatePayroll(pType) {
        var from = $('#option_' + pType).attr('from');
        var to = $('#option_' + pType).attr('to');
        var url = "<?php echo base_url() . 'hr/payroll/create/' ?>" + pType + '/' + from + '/' + to; // the script where you handle the form input.
        document.location = url;
    }

    let grossAmount = 25000; // Replace with PHP if needed
    let totalIncome = 0;
    let totalDeduction = 0;

    function formatPeso(val) {
        return "₱" + parseFloat(val).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function recalcTotals() {
        document.getElementById("totalIncome").innerText = formatPeso(totalIncome);
        document.getElementById("totalDeduction").innerText = formatPeso(totalDeduction);

        let net = grossAmount + totalIncome - totalDeduction;
        const netEl = document.getElementById("netPay");
        netEl.innerText = formatPeso(net);

        if (net < 0) {
            netEl.classList.add("net-negative");
        } else {
            netEl.classList.remove("net-negative");
        }
    }

    function addItemMain() {
        const select = document.getElementById("payrollItemsMain");
        const amountInput = document.getElementById("itemAmountMain");
        const container = document.getElementById("payrollDeductionBodyMain");

        const selectedOption = select.options[select.selectedIndex];

        if (!select.value) {
            alert("Please select a payroll item.");
            return;
        }

        const itemName = selectedOption.text.trim();
        const itemValue = parseInt(selectedOption.value);
        const itemType = parseInt(selectedOption.getAttribute("data-type"));
        const amountValue = parseFloat(amountInput.value);

        if (!itemName || isNaN(itemType) || isNaN(amountValue) || amountValue <= 0) {
            alert("Please provide a valid item and amount.");
            return;
        }

        const row = document.createElement("div");
        row.className = "payroll-item-row";

        let typeLabel = "";

        // 🔹 Adjusted type mapping
        if (itemType === 1) {
            // Credit → Additional Income
            row.classList.add("payroll-income");
            totalIncome += amountValue;
            typeLabel = "CREDIT";
        } else if (itemType === 0) {
            // Debit → Deduction
            row.classList.add("payroll-deduction");
            totalDeduction += amountValue;
            typeLabel = "DEBIT";
        } else if (itemType === 2) {
            // Amortization → treat as deduction (or you can customize)
            row.classList.add("payroll-deduction");
            totalDeduction += amountValue;
            typeLabel = "AMORTIZATION";
        } else {
            alert("Unknown payroll item type: " + itemType);
            return;
        }

        row.innerHTML = `
        <div class="row deduction-row">
            <div>
                <strong>${itemName}</strong>
                <div class="small text-muted">${typeLabel}</div>
                <input type="hidden" class="itemID" value="${itemValue}">
            </div>
            <div class="text-end">
                <strong>${formatPeso(amountValue)}</strong>
                <input type="hidden" class="amountVal" value="${amountValue}">
                <button type="button" class="remove-btn ms-2">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    `;

        row.querySelector(".remove-btn").addEventListener("click", function() {
            if (itemType === 1) totalIncome -= amountValue;
            else totalDeduction -= amountValue;

            row.remove();
            recalcTotals();
        });

        container.appendChild(row);

        // Reset inputs
        select.selectedIndex = 0;
        amountInput.value = "";

        recalcTotals();
    }

    // Focus on select when modal opens
    document.getElementById("addCharges").addEventListener("shown.bs.modal", function() {
        document.getElementById("payrollItemsMain").focus();
    });

    // Initialize gross pay
    document.getElementById("grossPay").innerText = formatPeso(grossAmount);
    recalcTotals();

    // Placeholder save function

    function addDeduction() {
        let deductions = [];
        var pc_code = $('#pcCode').val();
        var profile_id = $('#pc_profile_id').val();

        $('#payrollDeductionBodyMain .deduction-row').each(function() {

            let itemValue = $(this).find('.itemID').val();
            let amount = $(this).find('.amountVal').val();

            deductions.push({
                pc_item_id: itemValue,
                pc_amount: amount,
                pc_code: pc_code,
                pc_profile_id: profile_id,
                pc_amort_id: 0
            });

        });

        $.ajax({
            type: 'POST',
            url: '<?= base_url() . 'hr/payroll/addDeduction' ?>',
            dataType: 'json',
            data: {
                deductions: deductions,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                console.log(response);
            }
        })
    }

    /* -------- common modal alert function ----------------- */
    let modalCallback = null;

    function showSystemModal(type, message, title = "Notification", callback = null) {

        let header = document.getElementById("systemModalHeader");
        let icon = document.getElementById("systemModalIcon");
        let confirmBtn = document.getElementById("modalConfirmBtn");
        let cancelBtn = document.getElementById("modalCancelBtn");

        document.getElementById("systemModalTitle").innerText = title;
        document.getElementById("systemModalMessage").innerText = message;

        modalCallback = callback;

        cancelBtn.style.display = "none";
        confirmBtn.innerText = "OK";

        let headerClass = "";
        let iconHtml = "";

        switch (type) {

            case "success":
                headerClass = "bg-success text-white";
                iconHtml = '<i class="fa-solid fa-circle-check text-success"></i>';
                break;

            case "error":
                headerClass = "bg-danger text-white";
                iconHtml = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                break;

            case "warning":
                headerClass = "bg-warning text-dark";
                iconHtml = '<i class="fa-solid fa-triangle-exclamation text-warning"></i>';
                break;

            case "confirm":
                headerClass = "bg-primary text-white";
                iconHtml = '<i class="fa-solid fa-circle-question text-primary"></i>';

                confirmBtn.innerText = "Yes";
                cancelBtn.style.display = "inline-block";
                break;

            default:
                headerClass = "bg-info text-white";
                iconHtml = '<i class="fa-solid fa-circle-info text-info"></i>';
        }

        header.className = "modal-header " + headerClass;
        icon.innerHTML = iconHtml;

        let modal = new bootstrap.Modal(document.getElementById('systemModal'));
        modal.show();
    }

    document.getElementById("modalConfirmBtn").addEventListener("click", function() {

        let modalElement = document.getElementById('systemModal');
        let modalInstance = bootstrap.Modal.getInstance(modalElement);

        modalInstance.hide();

        if (modalCallback) {
            modalCallback();
        }
    });
</script>

<!-- timepicker JavaScript -->
<!-- <script src="<?php //echo base_url('assets/js/plugins/timepicker/bootstrap-timepicker.min.js');
                    ?>"></script> -->
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/metisMenu/metisMenu.min.js'); ?>"></script>
<script src="<?php echo base_url("assets/js/tablesorter.js"); ?>"></script>

<!-- Web Sync Controller JavaScript -->
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/bootstrap.clickover.js'); ?>"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url('assets/js/sb-admin-2.js'); ?>"></script>

<!--table sorter javascript -->
<script src="<?php echo base_url('assets/js/plugins/jquery.tablesorter.js'); ?>"></script>

<!--Editable Table Javascript-->
<script src="<?php echo base_url('assets/js/plugins/bootstrap-editable.js'); ?>"></script>

<!--Tootip Plugin Javascript-->
<script src="<?php echo base_url('assets/js/plugins/bootstrap-tooltip.js'); ?>"></script>

<!--graph Javascript-->
<script src="<?php echo base_url('assets/js/plugins/flotr2.min.js'); ?>"></script>

<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-contextmenu.js"></script>

<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>

<style>
    .pointer {
        cursor: pointer;
    }

    .payroll-modal {
        border-radius: 18px;
        border: none;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    }

    .payroll-header {
        background: linear-gradient(135deg, #198754, #20c997);
        color: white;
        padding: 1.3rem 1.8rem;
    }

    .pay-summary-box {
        background: #f8f9fa;
        padding: 18px;
        border-radius: 14px;
        border: 1px solid #e9ecef;
    }

    .payroll-items-container {
        max-height: 300px;
        overflow-y: auto;
    }

    .payroll-item-row {
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeInUp .25s ease;
    }

    .payroll-income {
        background: rgba(25, 135, 84, 0.08);
        border-left: 4px solid #198754;
    }

    .payroll-deduction {
        background: rgba(220, 53, 69, 0.08);
        border-left: 4px solid #dc3545;
    }

    .remove-btn {
        background: none;
        border: none;
        color: #6c757d;
    }

    .remove-btn:hover {
        color: #dc3545;
    }

    .net-negative {
        color: #dc3545 !important;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .loan-toggle,
    .add-toggle {
        display: inline-block;
        min-width: 80px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .loan-toggle:hover,
    .add-toggle:hover {
        background-color: #f0f8ff;
        border-radius: 5px;
    }
</style>

</body>

</html>