<style>
    /* ===============================
   GLOBAL BACKGROUND
=================================*/
    body {
        background: linear-gradient(135deg, #eef2f7, #f9fbfd);
    }

    /* ===============================
   HEADER / HERO
=================================*/
    .settings-header {
        background: linear-gradient(135deg, #0d6efd, #4f8dfd);
        color: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .settings-header::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 200px;
        height: 200px;
        background: url("https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=600&q=60");
        background-size: cover;
        opacity: .25;
        border-radius: 50%;
    }

    .settings-header h2 {
        font-weight: 600;
    }

    /* ===============================
   MODERN CARDS (Single System)
=================================*/
    /* .settings-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
        transition: all .2s ease;
    }

    .settings-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    } */

    .settings-card {
        border-radius: 14px;
        transition: .2s ease;
    }

    .settings-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .08);
    }

    .settings-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }

    .sy-arrow {
        font-size: 20px;
        padding-top: 32px;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .form-control {
        border-radius: 8px;
    }

    .enroll-arrow {
        font-size: 20px;
        padding-top: 32px;
    }

    /* ===============================
   SCHOOL INFO EDIT MODE
=================================*/
    .field-wrapper {
        position: relative;
        min-height: 38px;
    }

    .view-mode {
        display: block;
        line-height: 38px;
    }

    .field-wrapper.editing .view-mode {
        display: none;
    }

    /* Blur other cards when editing */
    body.editing-mode .settings-card:not(#schoolCard) {
        filter: blur(3px);
        opacity: .6;
        pointer-events: none;
        user-select: none;
    }

    /* Keep school card active */
    #schoolCard {
        filter: none !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    /* ===============================
   STRAND LIST STYLING
=================================*/
    .strand-list .list-group-item {
        border-color: #f1f3f5;
        transition: all .25s ease;
    }

    .strand-item {
        position: relative;
        overflow: hidden;
    }

    .strand-item:hover {
        background: #f8f9fb;
    }

    /* Icon */
    .strand-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef3ff;
        border-radius: 10px;
    }

    /* Content */
    .strand-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Actions Area */
    .strand-actions {
        display: flex;
        align-items: stretch;
    }

    /* Short Code Badge */
    .strand-code {
        display: flex;
        align-items: center;
        background: transparent !important;
        border: 0 !important;
        transition: all .25s ease;
    }

    /* Wrapper */
    .badge-wrapper {
        position: relative;
        display: flex;
        align-items: stretch;
        height: 100%;
        /* ensure children (including delete button) stretch to full row height */
    }

    /* Delete Button - Hidden State */
    .delete-strand {
        position: absolute;
        top: -13px;
        /* bottom: 0; */
        height: 100%;
        /* Full height */
        right: 0;
        width: 55px;

        display: grid;
        place-items: center;

        opacity: 0;

        transform: translateX(100%);
        transition: all .35s cubic-bezier(.22, 1, .36, 1);

        z-index: 2;
    }

    .delete-strand i {
        font-size: 15px;
        line-height: 1;
        pointer-events: none;
    }

    .delete-strand.btn {
        padding: 0 !important;
    }

    /* Show on hover */
    .strand-item:hover .delete-strand {
        opacity: 1;
        transform: translateX(0);
    }

    /* Badge reacts on hover */
    .strand-item:hover .strand-code {
        opacity: .3;
        transform: scale(.9);
    }

    /* Button hover */
    .delete-strand:hover {
        background: #dc3545;
        color: #fff;
    }

    /* Button default when visible */
    .strand-item:hover .delete-strand {
        background: #dc3545;
        color: #fff;
    }

    /* ===============================
   UTILITIES
=================================*/
    .btn-soft {
        border-radius: 8px;
    }

    .section-title {
        font-size: 15px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .setting-row {
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .setting-row:last-child {
        border-bottom: none;
    }

    .setting-label {
        color: #6c757d;
        font-weight: 600;
    }

    .setting-value {
        color: #0d6efd;
        font-weight: 500;
    }

    /* ===============================
   RESPONSIVE
=================================*/
    @media (max-width:768px) {
        .info-label {
            text-align: left !important;
        }
    }

    /*-------- Level Catered ----------- */
    .level-option {
        padding: 10px 12px;
        border: 1px solid #f1f1f1;
        border-radius: 8px;
        transition: all .2s ease;
        background: #fff;
    }

    .level-option:hover {
        background: #f8f9fb;
        border-color: #e6e6e6;
    }


    /* Hide radio button */
    .level-card input {
        display: none;
    }

    .level-card {
        display: block;
        cursor: pointer;
    }

    .level-card-body {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        background: #fff;
        transition: all .2s ease;
    }

    .level-card-body i {
        font-size: 20px;
        display: block;
        margin-bottom: 6px;
        color: #6c757d;
    }

    .level-card:hover .level-card-body {
        background: #f8f9fb;
    }

    .level-card input:checked+.level-card-body {
        border-color: #0d6efd;
        background: #eef4ff;
    }

    .level-card input:checked+.level-card-body i {
        color: #0d6efd;
    }

    .strand-card {
        transition: all .2s ease;
        border-radius: 10px;
    }

    .strand-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .08);
    }

    .strand-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f7fb;
        border-radius: 8px;
    }

    .strand-row input:focus {
        box-shadow: none;
    }

    .strand-row {
        transition: background .15s ease;
    }

    .strand-row:hover {
        background: #f8f9fa;
    }

    .strand-name[readonly],
    .strand-code[readonly] {
        background: transparent;
        cursor: default;
    }
</style>
<div class="container-fluid py-3">

    <div class="settings-header shadow-sm">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1"><i class="fa fa-school"></i> School System Settings</h2>
                <small>Manage school configuration, enrollment, and academic settings</small>
            </div>
        </div>
    </div>


    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-6">

            <!-- SCHOOL INFO -->
            <div class="card settings-card" id="schoolCard">

                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

                    <div>
                        <i class="fa fa-building"></i> School Information
                    </div>

                    <div class="mt-2 mt-md-0">

                        <button class="btn btn-sm btn-primary btn-soft" id="editSchoolBtn">
                            <i class="fa fa-edit"></i> Edit
                        </button>

                        <button class="btn btn-sm btn-success btn-soft d-none" id="saveSchoolBtn">
                            <i class="fa fa-save"></i> Save
                        </button>

                        <button class="btn btn-sm btn-secondary btn-soft d-none" id="cancelSchoolBtn">
                            <i class="fa fa-times"></i> Cancel
                        </button>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row info-row">

                        <div class="col-md-4 info-label">
                            School ID
                        </div>

                        <div class="col-md-8">

                            <div class="field-wrapper">

                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->school_id) ? $settings->school_id : '[empty]' ?>
                                </span>

                                <input
                                    type="text"
                                    id="school_id"
                                    name="school_id"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->school_id ?>">

                            </div>

                        </div>

                    </div>

                    <div class="row info-row">
                        <div class="col-md-4 info-label">Name of School</div>
                        <div class="col-md-8">
                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->set_school_name) ? $settings->set_school_name : '[empty]' ?>
                                </span>

                                <input type="text"
                                    id="set_school_name"
                                    name="set_school_name"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->set_school_name ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row info-row">
                        <div class="col-md-4 info-label">Address</div>
                        <div class="col-md-8">

                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->set_school_address) ? $settings->set_school_address : '[empty]' ?>
                                </span>

                                <textarea
                                    id="set_school_address"
                                    name="set_school_address"
                                    class="form-control form-control-sm edit-mode d-none"
                                    style="height:38px; resize:none"><?= $settings->set_school_address ?></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="row info-row">
                        <div class="col-md-4 info-label">Region</div>
                        <div class="col-md-8">

                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->region) ? $settings->region : '[empty]' ?>
                                </span>

                                <input type="text"
                                    id="region"
                                    name="region"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->region ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row info-row">
                        <div class="col-md-4 info-label">District</div>
                        <div class="col-md-8">

                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->district) ? $settings->district : '[empty]' ?>
                                </span>

                                <input type="text"
                                    id="district"
                                    name="district"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->district ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row info-row">
                        <div class="col-md-4 info-label">Division</div>
                        <div class="col-md-8">

                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->division) ? $settings->division : '[empty]' ?>
                                </span>

                                <input type="text"
                                    id="division"
                                    name="division"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->division ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row info-row">
                        <div class="col-md-4 info-label">Official Time In</div>
                        <div class="col-md-8">

                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->time_in) ? $settings->time_in : '[empty]' ?>
                                </span>

                                <input type="time"
                                    id="time_in"
                                    name="time_in"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->time_in ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row info-row">
                        <div class="col-md-4 info-label">Official Time Out</div>
                        <div class="col-md-8">

                            <div class="field-wrapper">
                                <span class="view-mode text-primary fw-semibold">
                                    <?= !empty($settings->time_out) ? $settings->time_out : '[empty]' ?>
                                </span>

                                <input type="time"
                                    id="time_out"
                                    name="time_out"
                                    class="form-control form-control-sm edit-mode d-none"
                                    value="<?= $settings->time_out ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- ENROLLMENT REQUIREMENTS -->
            <div class="card settings-card mt-4">

                <div class="card-header">
                    <i class="fa fa-list"></i> Enrollment Requirements
                </div>

                <div class="card-body">
                    <?php echo Modules::run('main/enrollmentRequirements'); ?>
                </div>

            </div>
            <div class="card settings-card mt-4">

                <div class="card-header">
                    <i class="fa fa-list"></i> Requirement Lists
                </div>

                <div class="card-body">
                    <?php echo Modules::run('main/getAllEnrollmentReq'); ?>
                </div>

            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-6">

            <div class="row g-4">

                <!-- STRANDS -->
                <div class="col-12">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white d-flex justify-content-between align-items-center">

                            <h6 class="mb-0 fw-semibold">
                                <i class="fa fa-graduation-cap text-primary me-2"></i>
                                SHS Strands
                            </h6>

                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#seniorHighModal">
                                <i class="fa fa-plus"></i> Add Strand
                            </button>

                        </div>

                        <div class="card-body p-0">

                            <ul class="list-group list-group-flush">

                                <?php if (!empty($strand)): ?>

                                    <?php foreach ($strand as $st): ?>

                                        <li class="list-group-item d-flex align-items-center justify-content-between"
                                            data-id="<?= $st->st_id ?>">

                                            <!-- LEFT SIDE -->
                                            <div class="flex-grow-1">

                                                <!-- Strand Name -->
                                                <div class="strand-text fw-semibold">
                                                    <?= $st->strand ?>
                                                </div>

                                                <input type="text"
                                                    class="form-control strand-edit-input d-none mt-1" name="strand"
                                                    value="<?= $st->strand ?>">

                                                <!-- Short Code -->
                                                <small class="text-muted d-block mt-1">

                                                    Code:

                                                    <span class="strand-code-text">
                                                        <?= $st->short_code ?>
                                                    </span>

                                                    <!-- Edit Input (placed beside label) -->
                                                    <input type="text" name="short_code"
                                                        class="form-control form-control-sm d-inline-block strand-code-input d-none ms-2"
                                                        value="<?= $st->short_code ?>"
                                                        style="width:120px;">

                                                </small>

                                            </div>

                                            <!-- RIGHT SIDE -->
                                            <div class="ms-3">

                                                <div class="btn-group btn-group-sm" role="group">

                                                    <!-- Toggle -->
                                                    <div class="btn btn-light d-flex align-items-center px-2">
                                                        <div class="form-check form-switch m-0">
                                                            <input class="form-check-input strand-toggle"
                                                                type="checkbox"
                                                                data-id="<?= $st->st_id ?>"
                                                                <?= $st->offered ? 'checked' : '' ?>>
                                                        </div>
                                                    </div>

                                                    <!-- Edit -->
                                                    <button class="btn btn-light edit-btn" title="Edit">
                                                        <i class="fa fa-edit text-success"></i>
                                                    </button>

                                                    <!-- Save -->
                                                    <button class="btn btn-light save-btn d-none" title="Save">
                                                        <i class="fa fa-check text-primary"></i>
                                                    </button>

                                                    <!-- Delete -->
                                                    <button class="btn btn-light"
                                                        onclick="deleteStrand('<?= $st->st_id ?>')"
                                                        title="Delete">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </button>

                                                </div>

                                            </div>

                                        </li>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <div class="text-center py-5 text-muted">

                                        <i class="fa fa-layer-group fa-2x mb-2 opacity-50"></i>
                                        <div>No strands added</div>

                                    </div>

                                <?php endif; ?>

                            </ul>

                        </div>

                    </div>

                </div>

                <!-- ATTENDANCE -->
                <div class="col-12">
                    <div class="card settings-card">

                        <div class="card-header">
                            <i class="fa fa-fingerprint"></i> Attendance Checking
                        </div>

                        <div class="card-body">

                            <?php
                            $auto = ($settings->att_check) ? 'checked' : '';
                            $manual = (!$settings->att_check) ? 'checked' : '';
                            ?>

                            <div class="form-check form-check-inline">

                                <input onclick="changeAttendanceSetting(this.value)"
                                    class="form-check-input"
                                    type="radio"
                                    <?= $auto ?>
                                    name="att_check"
                                    value="1">

                                <label class="form-check-label">
                                    RFID Attendance
                                </label>

                            </div>


                            <div class="form-check form-check-inline">

                                <input onclick="changeAttendanceSetting(this.value)"
                                    class="form-check-input"
                                    type="radio"
                                    <?= $manual ?>
                                    name="att_check"
                                    value="0">

                                <label class="form-check-label">
                                    Manual Attendance
                                </label>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card settings-card shadow-sm border-0">

                        <!-- Header -->
                        <div class="card-header bg-white d-flex align-items-center">
                            <i class="fa fa-fingerprint text-primary me-2"></i>
                            <span class="fw-semibold">Grade Level Catered</span>
                        </div>

                        <div class="card-body">

                            <?php
                            $levels = explode(',', $settings->level_catered ?? '');
                            $totalLevel = count($levels);
                            $allSelected = in_array('0', $levels); // if 0 exists
                            ?>

                            <div class="row g-3">

                                <!-- All Level -->
                                <div class="col-6 col-md-4 col-lg-2">
                                    <label class="level-card">
                                        <input type="checkbox" name="level_check[]" value="0"
                                            <?= $totalLevel == 5 ? 'checked' : '' ?>>
                                        <div class="level-card-body">
                                            <i class="fa fa-layer-group"></i>
                                            <span>All Level</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Preschool -->
                                <div class="col-6 col-md-4 col-lg-2">
                                    <label class="level-card">
                                        <input type="checkbox" name="level_check[]" value="1"
                                            <?= ($allSelected || in_array('1', $levels)) ? 'checked' : '' ?>>
                                        <div class="level-card-body">
                                            <i class="fa fa-child"></i>
                                            <span>Preschool</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Elementary -->
                                <div class="col-6 col-md-4 col-lg-2">
                                    <label class="level-card">
                                        <input type="checkbox" name="level_check[]" value="2"
                                            <?= ($allSelected || in_array('2', $levels)) ? 'checked' : '' ?>>
                                        <div class="level-card-body">
                                            <i class="fa fa-school"></i>
                                            <span>Elementary</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Junior HS -->
                                <div class="col-6 col-md-4 col-lg-2">
                                    <label class="level-card">
                                        <input type="checkbox" name="level_check[]" value="3"
                                            <?= ($allSelected || in_array('3', $levels)) ? 'checked' : '' ?>>
                                        <div class="level-card-body">
                                            <i class="fa fa-user-graduate"></i>
                                            <span>Junior HS</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Senior HS -->
                                <div class="col-6 col-md-4 col-lg-2">
                                    <label class="level-card">
                                        <input type="checkbox" name="level_check[]" value="4"
                                            <?= ($allSelected || in_array('4', $levels)) ? 'checked' : '' ?>>
                                        <div class="level-card-body">
                                            <i class="fa fa-graduation-cap"></i>
                                            <span>Senior HS</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- College -->
                                <div class="col-6 col-md-4 col-lg-2">
                                    <label class="level-card">
                                        <input type="checkbox" name="level_check[]" value="5"
                                            <?= ($allSelected || in_array('5', $levels)) ? 'checked' : '' ?>>
                                        <div class="level-card-body">
                                            <i class="fa fa-university"></i>
                                            <span>College</span>
                                        </div>
                                    </label>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- SCHOOL YEAR -->
                <div class="col-12">

                    <div class="card settings-card border-0 shadow-sm">

                        <!-- Header -->
                        <div class="card-header bg-white d-flex align-items-center">
                            <i class="fa fa-calendar-alt text-primary me-2"></i>
                            <span class="fw-semibold">School Year Configuration</span>
                        </div>

                        <div class="card-body">

                            <!-- Timeline Style -->
                            <div class="row g-4 align-items-end">

                                <!-- Start Date -->
                                <div class="col-12 col-md-5">

                                    <label class="form-label text-muted small">
                                        Beginning of School Year
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-play text-primary"></i>
                                        </span>

                                        <input type="date"
                                            id="bosy"
                                            class="form-control"
                                            school-id="<?= $settings->school_id ?>"
                                            change-type="1"
                                            value="<?= ($settings->bosy != '0000-00-00') ? $settings->bosy : '' ?>"
                                            onchange="confirmChange(this); calculateDuration();">
                                    </div>

                                </div>

                                <!-- Arrow -->
                                <div class="col-md-2 text-center d-none d-md-block">
                                    <div class="sy-arrow">
                                        <i class="fa fa-arrow-right text-muted"></i>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-12 col-md-5">

                                    <label class="form-label text-muted small">
                                        End of School Year
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-flag-checkered text-success"></i>
                                        </span>

                                        <input type="date"
                                            id="eosy"
                                            class="form-control"
                                            school-id="<?= $settings->school_id ?>"
                                            change-type="0"
                                            value="<?= ($settings->eosy != '0000-00-00') ? $settings->eosy : '' ?>"
                                            onchange="confirmChange(this); calculateDuration();">
                                    </div>

                                </div>

                            </div>

                            <!-- Duration Display -->
                            <div class="mt-4">
                                <div class="alert alert-light border d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fa fa-clock text-primary me-2"></i>
                                        School Year Duration:
                                    </span>
                                    <strong id="durationText">--</strong>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- ENROLLMENT -->
                <div class="col-12">

                    <div class="card settings-card border-0 shadow-sm">

                        <!-- Header -->
                        <div class="card-header bg-white d-flex align-items-center">
                            <i class="fa fa-user-plus text-primary me-2"></i>
                            <span class="fw-semibold">Enrollment Schedule</span>
                        </div>

                        <div class="card-body">

                            <div class="row g-4 align-items-end">

                                <!-- Start Date -->
                                <div class="col-12 col-md-5">

                                    <label class="form-label text-muted small">
                                        Enrollment Start Date
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa fa-play text-primary"></i>
                                        </span>

                                        <input type="date"
                                            class="form-control"
                                            school-id="<?= $settings->school_id; ?>"
                                            change-type="0"
                                            enrollment_start="<?= $settings->enrollment_start; ?>"
                                            value="<?= ($settings->enrollment_start != '0000-00-00') ? $settings->enrollment_start : '' ?>"
                                            onchange="changeEnrollDate(this)">
                                    </div>

                                </div>

                                <!-- Arrow (Desktop Only) -->
                                <div class="col-md-2 d-none d-md-flex justify-content-center">
                                    <div class="enroll-arrow">
                                        <i class="fa fa-arrow-right text-muted"></i>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-12 col-md-5">

                                    <label class="form-label text-muted small">
                                        Enrollment End Date
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa fa-flag-checkered text-danger"></i>
                                        </span>

                                        <input type="date"
                                            class="form-control"
                                            school-id="<?= $settings->school_id; ?>"
                                            change-type="1"
                                            enrollment_end="<?= $settings->enrollment_end; ?>"
                                            value="<?= ($settings->enrollment_end != '0000-00-00') ? $settings->enrollment_end : '' ?>"
                                            onchange="changeEnrollDate(this)">
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div id="addEnReq" class="modal fade" tabindex="-1" aria-labelledby="addEnReqLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEnReqLabel">Add Requirement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="reqName" class="form-label">Enter Description</label>
                <input type="text" name="reqName" id="reqName" required
                    class="form-control mb-3"
                    placeholder="Enter Requirement" />
                <button class="btn btn-primary btn-sm" id="addReq">
                    <i class="fa fa-save me-1"></i>Save
                </button>
                <div class="mt-3">
                    <span id="errorAlert"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editEnReq" class="modal fade" tabindex="-1" aria-labelledby="editEnReqLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEnReqLabel">Edit Requirement Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="editReqDesc" class="form-label">Edit Description</label>
                <input id="editReqDesc" name="editReqDesc" class="form-control mb-3" />
                <button class="btn btn-success btn-sm"
                    onclick="editReq($('#editReqDesc').val(), $('#eReqID').val())">
                    <i class="fa fa-save me-1"></i>Update
                </button>
                <input type="hidden" id="eReqID" name="eReqID" />
            </div>
            <div class="modal-footer">
                <span id="updateSuccess" class="w-100"></span>
            </div>
        </div>
    </div>
</div> -->
<script type="text/javascript">
    $(document).ready(function() {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });

        $('#addReq').click(function() {
            var req = $('#reqName').val();
            if (req == '') {
                $('#reqName').focus();
                $('#errorAlert').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    '<i class="fa fa-exclamation-triangle me-1"></i>' +
                    'This field should not be empty!' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');

                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                });
            } else {
                var url = '<?php echo base_url() . 'main/addEnrollmentReq/' ?>' + req;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        $('#reqName').val('');
                        $('#errorAlert').append('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="fa fa-check-circle me-1"></i>' +
                            'Successfully Added!' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>');

                        $('.alert-success').delay(500).show(10, function() {
                            $(this).delay(3000).hide(10, function() {
                                $(this).remove();
                            });
                        });
                    }
                });
            }
        });
    });

    // EDIT
    $('#editSchoolBtn').click(function() {

        // Enable edit mode
        $('.view-mode').hide();
        $('.edit-mode').removeClass('d-none').show();

        // Blur everything else
        $('body').addClass('editing-mode');

        // Toggle buttons
        $('#editSchoolBtn').addClass('d-none');
        $('#saveSchoolBtn').removeClass('d-none');
        $('#cancelSchoolBtn').removeClass('d-none');

    });

    // CANCEL
    $('#cancelSchoolBtn').click(function() {

        // Exit edit mode
        $('.edit-mode').hide().addClass('d-none');
        $('.view-mode').show();

        // Remove blur
        $('body').removeClass('editing-mode');

        // Toggle buttons back
        $('#editSchoolBtn').removeClass('d-none');
        $('#saveSchoolBtn').addClass('d-none');
        $('#cancelSchoolBtn').addClass('d-none');

    });

    // SAVE
    $('#saveSchoolBtn').click(function() {

        var formData = {};

        // Get all inputs and textareas inside schoolCard
        $('#schoolCard .card-body').find('input, textarea').each(function() {

            var name = $(this).attr('name');

            if (name) {
                formData[name] = $(this).val();
            }

        });

        // CSRF
        var csrfName = $('#csrf_name').val();
        var csrfHash = $('#csrf_hash').val();

        formData[csrfName] = csrfHash;

        console.log(formData);

        $.ajax({
            url: '<?= base_url("main/updateSettings") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {

                if (res.status) {

                    if (res.csrfHash) {
                        $('#csrf_hash').val(res.csrfHash);
                    }
                    showTopAlert(res.msg, res.status ? 'success' : 'danger', 'reload');
                }

            }
        });
    });

    function editReq(value, id) {
        var url = '<?php echo base_url() . 'main/editReqList' ?>';
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&opt=1' + '&value=' + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function(data) {
                $('#updateSuccess').append('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    '<i class="fa fa-check-circle me-1"></i>' +
                    'Successfully Updated!' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');

                $('.alert-success').delay(1500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
                        $(this).remove();
                    });
                    $('#editEnReq').modal('hide');
                });
            },
            error: function() {
                alert('error');
            }
        });
    }

    function deleteReq(id, option) {
        $.confirm({
            title: 'Confirmation Alert!',
            content: 'Are you sure you want to delete this requirement?',
            buttons: {
                confirm: function() {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() . 'main/deleteReq/' ?>' + id + '/' + option,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                $('#viewList').modal('hide');
                                // $.alert('Requirement Deleted Successfuly!');
                                showTopAlert(data.msg, 'success', 'reload');
                            }
                        }
                    });

                },
                cancel: function() {
                    showTopAlert('Canceled!', 'warning');
                }
            }
        });
    }

    function deleteStrand(id) {
        $.confirm({
            title: 'Confirmation Alert!',
            content: 'Are you sure you want to delete this Strand?',
            buttons: {
                confirm: function() {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() . 'subjectmanagement/deleteStrand/' ?>' + id,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                showTopAlert(data.msg, 'success', 'reload');
                            }
                        },
                        error: function() {
                            showTopAlert('Failed to Delete', 'danger', 'reload');
                        }
                    });

                },
                cancel: function() {
                    showTopAlert('Canceled!', 'warning');
                }
            }
        });
    }

    function getSubListByType(id) {
        var url = '<?php echo base_url() . 'main/getSubListByType/' ?>' + id;
        $.ajax({
            type: 'GET',
            data: 'id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function(data) {
                $('#notifySubList').html(data);
            }
        });
    }

    function deleteSub(notif_id, emp_id) {
        $.confirm({
            title: 'Confirmation Alert!',
            content: 'Are you sure you want to delete the subscriber?',
            buttons: {
                confirm: function() {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() . 'main/delSubByID/' ?>' + emp_id + '/' + notif_id,
                        success: function(data) {

                        }
                    });
                    $.alert('Subscriber Deleted Successfuly!');
                },
                cancel: function() {
                    $.alert('Canceled!');
                }
            }
        });
    }

    function searchTeacher(value) {
        var url = "<?php echo base_url() . 'main/searchEmployees/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function() {},
            success: function(data) {
                $('#empList').html(data);
            }
        });
        return false;
    }

    function addSubNotif(emp_id, name) {
        var notifSelected = $('#notifSelected').val();
        if (notifSelected == 0) {
            alert('Please select Notification Type');
        } else {
            $.confirm({
                title: 'Confirmation Alert',
                content: 'Are you sure you want to add ' + name + '?',
                buttons: {
                    confirm: function() {
                        $.ajax({
                            type: 'GET',
                            dataType: 'json',
                            url: '<?php echo base_url() . 'main/addSubNotif/' ?>' + notifSelected + '/' + emp_id,
                            success: function(data) {
                                if (data.status) {
                                    $.alert(name + ' Successfully Added!');
                                    $('#addSubsNotifList').modal('hide');
                                } else {
                                    $.alert(name + ' is already on the Notification List');
                                    $('#addSubsNotifList').modal('hide');
                                }
                            }
                        });
                    },
                    cancel: function() {
                        $.alert('Operation Canceled!');
                    }
                }
            });
        }
    }

    $(document).on('change', 'input[name="level_check[]"]', function() {

        var all = $('input[value="0"]');
        var others = $('input[name="level_check[]"]').not('[value="0"]');
        var formData = {}

        // If ALL clicked
        if ($(this).val() == "0") {
            others.prop('checked', $(this).is(':checked'));
        } else {
            // If any level unchecked -> remove ALL
            if (!$(this).is(':checked')) {
                all.prop('checked', false);
            }

            // If all individual levels checked -> check ALL
            if (others.length === others.filter(':checked').length) {
                all.prop('checked', true);
            }
        }

        var levels = [];

        $('input[name="level_check[]"]:checked').each(function() {
            if ($(this).val() != 0) {
                levels.push($(this).val());
            }
        });

        formData['level_catered'] = levels.join(',');
        var csrfName = $('#csrf_name').val();
        var csrfHash = $('#csrf_hash').val();

        formData[csrfName] = csrfHash;

        console.log(formData)

        $.ajax({
            type: 'POST',
            url: '<?= base_url() . 'main/updateSettings' ?>',
            data: formData,
            dataType: 'json',
            success: function(d) {
                showTopAlert(d.msg, d.status ? 'success' : 'danger', 'reload');
            }
        })
    });

    function confirmChange(input) {

        const $input = $(input);
        const changeType = $input.attr('change-type');
        const schoolId = $input.attr('school-id');
        const newValue = $input.val();

        const originalDate = changeType == 1 ?
            $input.attr('bosy') :
            $input.attr('eosy');

        const message = changeType == 1 ?
            "Are you sure you want to change the Beginning of the School Year?" :
            "Are you sure you want to change the End of the School Year?";

        // Confirm change
        if (changeType == 0) {
            const start = $('#bosy').val();
            if (value <= start) {
                alert("End of School Year must be after Beginning of School Year.");
                $(input).val($(input).attr('eosy'));
                return;
            }
        }
        if (!confirm(message)) {
            $input.val(originalDate);
            return;
        }

        // Disable input while saving
        $input.prop("disabled", true);

        $.ajax({
            url: "<?= site_url('main/updateSchoolDates'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                type: changeType,
                school: schoolId,
                date: newValue,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },

            success: function(response) {

                alert(response.msg);

                if (response.status == 0) {
                    // revert value if failed
                    $input.val(originalDate);
                } else {
                    // update stored value
                    if (changeType == 1) {
                        $input.attr('bosy', newValue);
                    } else {
                        $input.attr('eosy', newValue);
                    }
                }

            },

            error: function() {
                alert("Something went wrong while updating the school year.");
                $input.val(originalDate);
            },

            complete: function() {
                $input.prop("disabled", false);
            }
        });
    }

    function calculateDuration() {

        const start = document.getElementById('bosy').value;
        const end = document.getElementById('eosy').value;
        const durationText = document.getElementById('durationText');

        if (!start || !end) {
            durationText.innerHTML = "--";
            return;
        }

        const startDate = new Date(start);
        const endDate = new Date(end);

        if (endDate <= startDate) {
            durationText.innerHTML = "<span class='text-danger'>Invalid Date Range</span>";
            return;
        }

        const diffTime = endDate - startDate;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        const months = (diffDays / 30).toFixed(1);

        durationText.innerHTML = diffDays + " days (" + months + " months)";
    }

    $('#strandSearch').on('keyup', function() {

        let value = $(this).val().toLowerCase();

        $('#strandContainer .strand-row').filter(function() {

            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );

        });

    });

    function toggleStrand(id, status) {

        $.ajax({
            url: "<?= base_url('subjectmanagement/toggleStrand') ?>",
            type: "POST",
            data: {
                strand_id: id,
                offered: status ? 1 : 0,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            success: function(res) {
                showTopAlert(res.msg, res.status ? 'success' : 'danger');
            }
        });

    }

    $(document).on('change', '.strand-toggle', function() {

        let id = $(this).data('id')
        let status = $(this).is(':checked') ? 1 : 0

        $.ajax({
            url: "<?= base_url('subjectmanagement/updateSHStrand') ?>",
            type: "POST",
            data: {
                st_id: id,
                offered: status,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            success: function(res) {
                showTopAlert(res.msg, res.status ? 'success' : 'danger');
            }
        });

    })

    document.addEventListener("DOMContentLoaded", function() {

        // EDIT
        document.querySelectorAll(".edit-btn").forEach(function(btn) {

            btn.addEventListener("click", function() {

                const item = this.closest("li");

                item.querySelector(".strand-text").classList.add("d-none");
                item.querySelector(".strand-edit-input").classList.remove("d-none");

                item.querySelector(".strand-code-text").classList.add("d-none");
                item.querySelector(".strand-code-input").classList.remove("d-none");

                item.querySelector(".edit-btn").classList.add("d-none");
                item.querySelector(".save-btn").classList.remove("d-none");

            });

        });

        // SAVE
        document.querySelectorAll(".save-btn").forEach(function(btn) {

            btn.addEventListener("click", function() {

                const item = this.closest("li");
                const id = item.dataset.id;

                const strand = item.querySelector(".strand-edit-input").value;
                const code = item.querySelector(".strand-code-input").value;

                // CSRF
                var csrfName = document.getElementById('csrf_name').value;
                var csrfHash = document.getElementById('csrf_hash').value;

                // Use URLSearchParams (THIS IS THE FIX)
                const params = new URLSearchParams();
                params.append("st_id", id);
                params.append("strand", strand);
                params.append("short_code", code);
                params.append(csrfName, csrfHash);

                fetch("<?= base_url('subjectmanagement/updateSHStrand') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: params.toString()
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status) {

                            showTopAlert(data.msg, data.status ? 'success' : 'danger', 'reload');
                            item.querySelector(".strand-text").innerText = strand;
                            item.querySelector(".strand-code-text").innerText = code;

                            item.querySelector(".strand-text").classList.remove("d-none");
                            item.querySelector(".strand-edit-input").classList.add("d-none");

                            item.querySelector(".strand-code-text").classList.remove("d-none");
                            item.querySelector(".strand-code-input").classList.add("d-none");

                            item.querySelector(".edit-btn").classList.remove("d-none");
                            item.querySelector(".save-btn").classList.add("d-none");

                        } else {
                            showTopAlert(data.msg, data.status ? 'success' : 'danger', 'reload');
                        }

                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });

            });

        });

    });
</script>

<?php //echo Modules::run('subjectmanagement/seniorHighModal');