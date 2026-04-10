<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white fw-semibold">
        Educational Background
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="text-center">Level</th>
                        <th rowspan="2" class="text-center">Name of School</th>
                        <th rowspan="2" class="text-center">Degree / Course</th>
                        <th rowspan="2" class="text-center">Year Graduated</th>
                        <th colspan="2" class="text-center">Years Attended</th>
                        <th rowspan="2" class="text-center" style="width:100px;">Actions</th>
                    </tr>
                    <tr>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                    </tr>
                </thead>

                <tbody id="educHisBody">
                    <?php foreach ($edHis->result() as $edInfo): ?>
                        <tr>
                            <td class="fw-semibold"><?php echo $edInfo->el_level; ?></td>
                            <td><?php echo $edInfo->school_name; ?></td>
                            <td><?php echo $edInfo->course; ?></td>
                            <td class="text-center"><?php echo $edInfo->eb_year_grad; ?></td>
                            <td class="text-center"><?php echo $edInfo->eb_dates_from; ?></td>
                            <td class="text-center"><?php echo $edInfo->eb_dates_to; ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        onclick="getEducHis('<?php echo $edInfo->eb_id; ?>')"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addEdHis"
                                        class="btn btn-outline-primary">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button
                                        onclick="deleteEducBac('<?php echo $edInfo->eb_id; ?>')"
                                        class="btn btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- College Education Section -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-semibold">
        College Education
    </div>
    <div class="card-body">

        <!-- Major -->
        <div class="row g-4">
            <div class="col-md-5">
                <?php $major = Modules::run('hr/getMajorSubjects', $basicInfo->employee_id); ?>
                <div id="cMajor_card" class="info-card ie-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="info-label">Major</div>
                            <div class="info-value" id="cMajor_text">
                                <?= ($basicInfo->course != "" || $basicInfo->course != "N/A") ? ($major ? $major->maj_min : '[empty]') : '[empty]'; ?>
                            </div>
                            <div id="cMajor_inputWrap" class="d-none mt-3">
                                <input name="incase_name" id="cMajor_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->incase_name != NULL ? $basicInfo->incase_name : '[empty]') ?>">
                            </div>
                        </div>
                        <button id="cMajor_btn_edit" class="edit-chip" onclick="ieEdit('cMajor')"><i class="fa fa-pencil"></i></button>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div id="cMajor_btn_group" class="d-none mt-auto d-flex justify-content-end">
                        <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                            onclick="updateInformation('cMajor', 'user_id', 'profile_employee')">
                            <i class="fa fa-check"></i>
                        </button>
                        <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                            onclick="ieCancel('cMajor')">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <?php $minor = Modules::run('hr/getMinorSubjects', $basicInfo->employee_id); ?>
                <div id="cMinor_card" class="info-card ie-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="info-label">Minor</div>
                            <div class="info-value" id="cMinor_text">
                                <?= ($basicInfo->course != "" || $basicInfo->course != "N/A") ? ($minor ? $minor->maj_min : '[empty]') : '[empty]'; ?>
                            </div>
                            <div id="cMinor_inputWrap" class="d-none mt-3">
                                <input name="incase_name" id="cMinor_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->incase_name != NULL ? $basicInfo->incase_name : '[empty]') ?>">
                            </div>
                        </div>
                        <button id="cMinor_btn_edit" class="edit-chip" onclick="ieEdit('cMinor')"><i class="fa fa-pencil"></i></button>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div id="cMinor_btn_group" class="d-none mt-auto d-flex justify-content-end">
                        <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                            onclick="updateInformation('cMinor', 'user_id', 'profile_employee')">
                            <i class="fa fa-check"></i>
                        </button>
                        <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                            onclick="ieCancel('cMinor')">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>