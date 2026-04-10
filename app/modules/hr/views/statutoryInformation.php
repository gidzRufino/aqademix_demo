<div class="row g-4">

    <!-- Salary -->
    <div class="col-md-4">
        <div id="salary_card" class="info-card ie-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="info-label">Salary</div>
                    <div class="info-value" id="salary_text">
                        <?php echo ($basicInfo->salary != "" ? $basicInfo->salary : "[empty]"); ?>
                    </div>
                    <div id="salary_inputWrap" class="d-none mt-3">
                        <input name="salary" id="salary_input" type="text" class="form-control form-control-sm"
                            value="<?php echo $basicInfo->salary; ?>">
                    </div>
                </div>
                <?php if ($this->session->userdata('is_admin')): ?>
                    <button id="salary_btn_edit" class="edit-chip" onclick="ieEdit('salary')">
                        <i class="fa fa-pencil"></i>
                    </button>
                <?php endif; ?>
            </div>

            <div id="salary_btn_group" class="d-none mt-auto d-flex justify-content-end">
                <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                    onclick="updateProfile('salary','<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee') ?>','<?php echo $basicInfo->employee_id ?>','salary',$('#salary_input').val(),'salary_input')">
                    <i class="fa fa-check"></i>
                </button>
                <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                    onclick="ieCancel('salary')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Pay Type -->
    <div class="col-md-4">
        <div id="ptype_card" class="info-card ie-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="info-label">Pay Type</div>
                    <div class="info-value" id="ptype_text">
                        <?php echo ($basicInfo->pay_type == 0 ? 'Based on Time Attendance' : 'Fixed Rate') ?>
                    </div>
                    <div id="ptype_inputWrap" class="d-none mt-3">
                        <select id="ptype_input" class="form-select form-select-sm">
                            <option value="0" <?= $basicInfo->pay_type == 0 ? 'selected' : '' ?>>Based on Time Attendance</option>
                            <option value="1" <?= $basicInfo->pay_type == 1 ? 'selected' : '' ?>>Fixed Rate</option>
                        </select>
                    </div>
                </div>
                <?php if ($this->session->userdata('is_admin')): ?>
                    <button id="ptype_btn_edit" class="edit-chip" onclick="ieEdit('ptype')">
                        <i class="fa fa-pencil"></i>
                    </button>
                <?php endif; ?>
            </div>

            <div id="ptype_btn_group" class="d-none mt-auto d-flex justify-content-end">
                <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                    onclick="savePtype('ptype')">
                    <i class="fa fa-check"></i>
                </button>
                <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                    onclick="ieCancel('ptype')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Salary Type -->
    <div class="col-md-4">
        <div id="sg_card" class="info-card ie-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="info-label">Salary Type</div>
                    <div class="info-value" id="sg_text">
                        <?php echo ($basicInfo->pst_id != "" ? $basicInfo->pst_type : "[empty]"); ?>
                    </div>
                    <div id="sg_inputWrap" class="d-none mt-3">
                        <select id="sg_input" class="form-select form-select-sm">
                            <option>Select Salary Type</option>
                            <?php foreach ($salaryType as $st): ?>
                                <option value="<?php echo $st->pst_id ?>"><?php echo $st->pst_type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php if ($this->session->userdata('is_admin')): ?>
                    <button id="sg_btn_edit" class="edit-chip" onclick="ieEdit('sg')">
                        <i class="fa fa-pencil"></i>
                    </button>
                <?php endif; ?>
            </div>

            <div id="sg_btn_group" class="d-none mt-auto d-flex justify-content-end">
                <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                    onclick="saveSG('sg')">
                    <i class="fa fa-check"></i>
                </button>
                <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                    onclick="ieCancel('sg')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Leave Credits -->
    <div class="col-md-4">
        <div id="credits_card" class="info-card ie-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="info-label">Leave Credits (days)</div>
                    <div class="info-value" id="credits_text">
                        <?php echo ($basicInfo->leave_credits != 0.0 ? $basicInfo->leave_credits : "[empty]"); ?>
                    </div>
                    <div id="credits_inputWrap" class="d-none mt-3">
                        <input name="leave_credits" id="credits_input" type="text" class="form-control form-control-sm"
                            value="<?php echo $basicInfo->leave_credits; ?>">
                    </div>
                </div>
                <?php if ($this->session->userdata('is_admin')): ?>
                    <button id="credits_btn_edit" class="edit-chip" onclick="ieEdit('credits')">
                        <i class="fa fa-pencil"></i>
                    </button>
                <?php endif; ?>
            </div>

            <div id="credits_btn_group" class="d-none mt-auto d-flex justify-content-end">
                <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                    onclick="updateProfile('credits', '<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee') ?>','<?php echo $basicInfo->employee_id ?>','leave_credits',$('#credits_input').val(),'credits_input')">
                    <i class="fa fa-check"></i>
                </button>
                <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                    onclick="ieCancel('credits')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Government Numbers (Reusable Pattern) -->
    <?php
    $govFields = [
        'sss' => 'SSS',
        'phil_health' => 'PhilHealth',
        'pag_ibig' => 'Pag-Ibig',
        'tin' => 'TIN'
    ];
    foreach ($govFields as $field => $label):
        $value = ($field == 'phil_health') ? $basicInfo->phil_health : (($field == 'pag_ibig') ? $basicInfo->pag_ibig : $basicInfo->$field);
    ?>
        <div class="col-md-4">
            <div id="<?php echo $field; ?>_card" class="info-card ie-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="info-label"><?php echo $label; ?></div>
                        <div class="info-value" id="<?php echo $field; ?>_text">
                            <?php echo ($value != "" ? $value : "[empty]"); ?>
                        </div>
                        <div id="<?php echo $field; ?>_inputWrap" class="d-none mt-3">
                            <input name="<?php echo $field; ?>" id="<?php echo $field; ?>_input"
                                type="text" class="form-control form-control-sm"
                                value="<?php echo $value; ?>">
                        </div>
                    </div>
                    <button id="<?php echo $field; ?>_btn_edit" class="edit-chip" onclick="ieEdit('<?php echo $field; ?>')">
                        <i class="fa fa-pencil"></i>
                    </button>
                </div>

                <div id="<?php echo $field; ?>_btn_group" class="d-none mt-auto d-flex justify-content-end">
                    <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                        onclick="updateProfile('<?php echo $field; ?>', '<?php echo base64_encode('employee_id') ?>','<?php echo base64_encode('esk_profile_employee') ?>','<?php echo $basicInfo->employee_id ?>','<?php echo $field; ?>',$('#<?php echo $field; ?>_input').val(),'<?php echo $field; ?>_input')">
                        <i class="fa fa-check"></i>
                    </button>
                    <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                        onclick="ieCancel('<?php echo $field; ?>')">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>