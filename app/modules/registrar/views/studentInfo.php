<?php
$isAdv = Modules::run('academic/getAdvisory', $this->session->faculty_id, $this->session->school_year, $students->section_id, 1);
?>
<div class="row mb-2">
    <div class="col-12">
        <h3 class="text-center border-bottom pb-2 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-danger" id="name_header"></small>

                <span>Student Information</span>

                <span>
                    <i id="profMin"
                        title="Minimize"
                        data-bs-toggle="tooltip"
                        data-bs-placement="left"
                        class="fa fa-minus pointer"
                        onclick="maxMin('prof', 'min')"></i>

                    <i id="profMax"
                        title="Maximize"
                        data-bs-toggle="tooltip"
                        data-bs-placement="left"
                        class="fa fa-plus pointer d-none"
                        onclick="maxMin('prof', 'max')"></i>
                </span>
            </div>
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm" id="profBody">
            <div class="card-body">
                <div class="row g-3">

                    <!-- ================= PHOTO ================= -->
                    <div class="col-lg-2 text-center">
                        <?php $user_id = $students->u_id; ?>

                        <div id="imgCrop" data-id="photo">
                            <?php if ($students->avatar != '' && file_exists('uploads/' . $students->avatar)): ?>
                                <img class="rounded-circle border border-4 border-white shadow"
                                    style="width:150px;"
                                    src="<?php echo base_url() . 'uploads/' . $students->avatar ?>" />
                            <?php else: ?>
                                <img class="rounded-circle border border-4 border-white shadow"
                                    style="width:150px;"
                                    src="<?php echo base_url() . 'images/avatar/' . ($students->sex == 'Female' ? 'female.png' : 'male.png') ?>" />
                            <?php endif; ?>
                        </div>
                    </div>

                    <input type="hidden" id="stdUserID" value="<?php echo $user_id ?>" />
                    <input type="hidden" id="admission_user_id" value="<?php echo $students->u_id ?>" />

                    <!-- ================= MAIN INFO ================= -->
                    <div class="col-lg-6">

                        <!-- NAME -->
                        <h2 class="mb-1">
                            <span id="name" class="text-danger">
                                <?php echo strtoupper($students->firstname . " " . $students->lastname) ?>
                            </span>

                            <small>
                                <i class="fa fa-pencil-square-o pointer <?php echo $editable ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#basicInfoModal"
                                    onclick="
                                    $('#firstname').val('<?= $students->firstname ?>'), 
                                    $('#middlename').val('<?= $students->middlename ?>'), 
                                    $('#lastname').val('<?= $students->lastname ?>'),
                                    $('#pos').val('s'),
                                    $('#st_user_id').val('<?= $user_id ?>'),
                                    $('#rowid').val('<?= $user_id ?>'),
                                    $('#name_id').val('name')
                                    "></i>
                            </small>
                        </h2>

                        <!-- LEVEL / SECTION -->
                        <?php $strand = Modules::run('subjectmanagement/getStrandCode', $students->strnd_id); ?>

                        <h5 class="mb-1">
                            <?php echo $students->level; ?> -
                            <span id="a_section"><?php echo $students->section; ?></span>
                            <span id="a_strand">
                                <?php echo ($strand ? ' - ' . $strand->short_code : '') ?>
                            </span>

                            <?php if ($this->session->userdata('is_admin') && $this->session->position_id != 39): ?>
                                <i class="fa fa-pencil-square-o pointer <?php echo $editable ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#levelSectionModal"></i>
                            <?php endif; ?>
                        </h5>

                        <!-- ID + LRN -->
                        <h6 class="text-danger mb-1">
                            <span id="a_user_id" class="text-danger">
                                <?php echo ($students->lrn == "" ? $students->uid : $students->lrn) ?>
                            </span>

                            <input class="form-control form-control-sm d-none w-75"
                                type="text"
                                id="input_user_id"
                                value="<?php echo $students->uid ?>"
                                readonly>

                            <input class="form-control form-control-sm d-none w-75 mt-1"
                                type="text"
                                id="input_lrn"
                                value="<?php echo $students->lrn ?>"
                                placeholder="LRN">

                            <?php if ($this->session->position_id != 39): ?>
                                <i class="fa fa-pencil-square-o pointer <?php echo $editable ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#idLrnModal" onclick="
                                    $('#modal_user_id').text('<?= $students->uid ?>'),
                                    $('#modal_lrn').val('<?= $students->lrn ?>'),
                                    $('#modal_uid').val('<?= $students->uid ?>')
                                    "></i>
                            <?php endif; ?>

                            <i id="saveLrnBtn" class="fa fa-save pointer d-none"></i>
                            <i id="closeLrnBtn" class="fa fa-times pointer text-danger d-none"></i>
                        </h6>

                        <!-- REMARKS -->
                        <div class="text-danger">
                            <?php
                            $remarks = Modules::run('main/getAdmissionRemarks', $students->uid, NULL, $students->sy);
                            if ($remarks->num_rows() > 0) {
                                echo $remarks->row()->Indicator . ' [ ' . $remarks->row()->remark_date . ' ]';
                            }
                            ?>
                        </div>

                        <!-- ESC SELECT -->
                        <?php if ($this->session->userdata('position_id') == 1 || $this->session->userdata('position_id') == 49): ?>
                            <select class="form-select form-select-sm w-50 mt-2">
                                <option value="1" <?php echo ($students->is_esc == 1 ? 'selected' : ''); ?>
                                    onclick="updateIfRegular(this.value, <?php echo $students->u_id ?>)">
                                    ESC Grantee
                                </option>
                                <option value="0" <?php echo ($students->is_esc == 0 ? 'selected' : ''); ?>
                                    onclick="updateIfRegular(this.value, <?php echo $students->u_id ?>)">
                                    Non ESC
                                </option>
                            </select>
                        <?php endif; ?>

                    </div>

                    <!-- ================= ACTIONS ================= -->
                    <div class="col-lg-4 text-end">

                        <button class="btn btn-success btn-sm mb-2"
                            st-iw="<?php echo base64_encode($students->st_id); ?>"
                            onclick="readyPrint_updated(this)">
                            Print Admission
                        </button>

                        <?php if (($this->session->userdata('position_id') == 1 ||
                            $this->session->userdata('position_id') == 49 ||
                            $this->session->userdata('position_id') == 69)): ?>

                            <?php if (!$userPass): ?>
                                <button class="btn btn-primary btn-sm"
                                    onclick="genPass('<?php echo base64_encode($students->st_id); ?>')">
                                    Generate Password
                                </button>
                            <?php else: ?>
                                <div class="text-muted mt-2">
                                    <label class="fw-semibold">Student's Password:</label><br>
                                    <span id="asterisk">********</span>
                                    <span class="d-none" id="secretPass"><?php echo $uPass->secret_key ?></span>

                                    <i class="fa fa-eye pointer ms-1"
                                        onclick="$(this).addClass('d-none'); $('#asterisk').addClass('d-none'); $('#secretPass').removeClass('d-none'); $('#hidePass').removeClass('d-none');"></i>

                                    <i id="hidePass"
                                        class="fa fa-times pointer text-danger ms-1 d-none"
                                        onclick="$(this).addClass('d-none'); $('#asterisk').removeClass('d-none'); $('#secretPass').addClass('d-none'); $('.fa-eye').removeClass('d-none');"></i>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">

        <!-- NAV TABS -->
        <ul class="nav nav-tabs align-items-center" id="profileTab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#PersonalInfo"
                    type="button">
                    Personal Information
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#attendanceInformation"
                    type="button">
                    Attendance Information
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#academicInformation">
                    Academic Information
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#medicalInformation">
                    Medical Information
                </button>
            </li>

            <?php if ($this->session->position_id != 39): ?>
                <li class="nav-item">
                    <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#enrollmentRequirements">
                        Enrollment Requirements
                    </button>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#personalFiles">
                    Personal Files
                </button>
            </li>

            <!-- RIGHT SIDE ACTION -->
            <!-- <li class="ms-auto nav-item">
                <button class="nav-link text-primary fw-semibold"
                    onclick="imgSignUpload(this.id)"
                    id="sign"
                    type="button">
                    Upload Signature
                </button>
            </li> -->

        </ul>


        <!-- TAB CONTENT -->
        <div class="tab-content border border-top-0 rounded-bottom p-4 bg-white shadow-sm">

            <!-- ================= PERSONAL ================= -->
            <div class="tab-pane fade show active"
                id="PersonalInfo"
                role="tabpanel">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">

                        <div class="row align-items-start g-4">

                            <!-- LEFT SIDE — DETAILS -->
                            <div class="col-md-9">

                                <h5 class="fw-bold mb-3">
                                    Basic Information
                                </h5>

                                <div class="row g-3">

                                    <!-- ================= ADDRESS — FULL WIDTH ================= -->
                                    <div class="col-12">
                                        <div class="border rounded-3 p-3 bg-light h-100 d-flex justify-content-between">
                                            <div>
                                                <div class="text-muted small mb-1">Address</div>
                                                <div class="fw-semibold">
                                                    <span id="address_span">
                                                        <?php echo strtoupper(
                                                            $students->street . ', ' .
                                                                $students->barangay . ' ' .
                                                                $students->mun_city . ', ' .
                                                                $students->province . ', ' .
                                                                $students->zip_code
                                                        ); ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <i class="fa fa-pencil text-primary pointer" data-bs-toggle="modal" data-bs-target="#addressInfoModal" title="Edit Address"
                                                onclick="
                                                setCity('<?= $students->city_id ?>'),
                                            $('#street').val('<?= $students->street ?>'),
                                            $('#barangay').val('<?= $students->barangay ?>'),
                                            $('#city').val('<?= $students->city_id ?>'),
                                            $('#inputProvince').val('<?= $students->province ?>'),
                                            $('#zip_code').val('<?= $students->zip_code ?>'),
                                            $('#address_id').val('<?= $students->address_id ?>'),
                                            $('#address_user_id').val('<?= $user_id ?>'),
                                            $('#inputPID').val('<?= $students->province_id ?>')
                                            "></i>
                                        </div>
                                    </div>


                                    <!-- ================= TWO COLUMN FIELDS ================= -->

                                    <!-- Contact No -->
                                    <div class="col-md-6">
                                        <div id="contactNo_card" class="info-card ie-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="info-label">Contact No</div>
                                                    <div class="info-value" id="contactNo_text">
                                                        <?= ($students->cd_mobile != "" ? $students->cd_mobile : "[empty]"); ?>
                                                    </div>
                                                    <div id="contactNo_inputWrap" class="d-none mt-3">
                                                        <input name="cd_mobile" id="contactNo_input" class="form-control form-control-sm" value="<?= $students->cd_mobile ?>">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button id="contactNo_btn_edit" class="edit-chip" onclick="ieEdit('contactNo')"><i class="fa fa-pencil"></i></button>
                                                    <div id="contactNo_btn_group" class="d-none">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('contactNo', 'contact_id', 'profile_contact_details')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('contactNo')">✕</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div id="email_card" class="info-card ie-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="info-label">Email</div>
                                                    <div class="info-value" id="email_text">
                                                        <?= ($students->cd_email != "" ? $students->cd_email : "[empty]"); ?>
                                                    </div>
                                                    <div id="email_inputWrap" class="d-none mt-3">
                                                        <input name="cd_email" id="email_input" class="form-control form-control-sm" value="<?= $students->cd_email ?>">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button id="email_btn_edit" class="edit-chip" onclick="ieEdit('email')"><i class="fa fa-pencil"></i></button>
                                                    <div id="email_btn_group" class="d-none">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('email', 'contact_id', 'profile_contact_details')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('email')">✕</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <div id="gender_card" class="info-card ie-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="info-label">Gender</div>
                                                    <div class="info-value" id="gender_text">
                                                        <?= $students->sex != NULL ? $students->sex : '[empty]'; ?>
                                                    </div>
                                                    <div id="gender_inputWrap" class="d-none mt-3">
                                                        <select name="sex" id="gender_input" class="form-select form-select-sm">
                                                            <option value="Male" <?= $students->sex == 'Male' ? 'selected' : '' ?>>Male</option>
                                                            <option value="Female" <?= $students->sex == 'Female' ? 'selected' : '' ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button id="gender_btn_edit" class="edit-chip" onclick="ieEdit('gender')"><i class="fa fa-pencil"></i></button>
                                                    <div id="gender_btn_group" class="d-none">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('gender', 'user_id', 'profile')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('gender')">✕</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Birthdate -->
                                    <div class="col-md-6">
                                        <div id="bdate_card" class="info-card ie-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="info-label">Birthdate</div>
                                                    <div class="info-value" id="bdate_text">
                                                        <?= $students->temp_bdate; ?>
                                                    </div>
                                                    <div id="bdate_inputWrap" class="d-none mt-3">
                                                        <input name="temp_bdate" id="bdate_input" type="date" class="form-control form-control-sm" value="<?= ($students->temp_bdate != NULL || $students->temp_bdate != '0000-00-00' ? $students->temp_bdate : '[empty]') ?>">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button id="bdate_btn_edit" class="edit-chip" onclick="ieEdit('bdate')"><i class="fa fa-pencil"></i></button>
                                                    <div id="bdate_btn_group" class="d-none">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('bdate', 'user_id', 'profile')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('bdate')">✕</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Religion -->
                                    <div class="col-md-6">
                                        <div id="religion_card" class="info-card ie-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="info-label">Religion</div>
                                                    <div class="info-value" id="religion_text">
                                                        <?php echo $students->rel_id ? $students->religion : '[empty]'; ?>
                                                    </div>
                                                    <div id="religion_inputWrap" class="d-none mt-3">
                                                        <select name="rel_id" id="religion_input" class="form-select form-select-sm">
                                                            <option value="">Select Religion</option>
                                                            <?php foreach ($religion as $rel): ?>
                                                                <option value="<?= $rel->rel_id ?>" <?= $rel->rel_id == $students->rel_id ? 'selected' : '' ?>><?= $rel->religion ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button id="religion_btn_edit" class="edit-chip" onclick="ieEdit('religion')"><i class="fa fa-pencil"></i></button>
                                                    <div id="religion_btn_group" class="d-none">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('religion', 'user_id', 'profile')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('religion')">✕</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mother Tongue -->
                                    <div class="col-md-6">
                                        <div id="motherTongue_card" class="info-card ie-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="info-label">Mother Tongue</div>
                                                    <div class="info-value" id="motherTongue_text">
                                                        <?php echo $students->mother_tongue_id ? $students->mother_tongue : '[empty]'; ?>
                                                    </div>
                                                    <div id="motherTongue_inputWrap" class="d-none mt-3">
                                                        <select name="mother_tongue_id" id="motherTongue_input" class="form-select form-select-sm">
                                                            <option value="">Select Mother Tongue</option>
                                                            <?php foreach ($motherTongue as $mt): ?>
                                                                <option value="<?= $mt->mt_id ?>" <?= $mt->mt_id == $students->mother_tongue_id ? 'selected' : '' ?>><?= $mt->mother_tongue ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button id="motherTongue_btn_edit" class="edit-chip" onclick="ieEdit('motherTongue')"><i class="fa fa-pencil"></i></button>
                                                    <div id="motherTongue_btn_group" class="d-none">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('motherTongue', 'user_id', 'profile_students')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('motherTongue')">✕</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- RIGHT SIDE — IMAGE -->
                            <!-- <div class="col-md-3 text-center text-md-end">
                                <div class="card border-0 shadow-sm rounded-4 d-inline-block p-3">
                                    <img class="img-fluid rounded-3"
                                        style="max-width:170px"
                                        src="<?php
                                                // if ($students->avatar != ""):
                                                //     echo base_url() . 'uploads/sign/' . $user_id . '.png';
                                                // else:
                                                //     echo base_url() . 'uploads/noImage.png';
                                                // endif;
                                                ?>">

                                    <div class="mt-2 small text-muted">
                                        Signature
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <hr class="my-3">

                <h5 class="fw-bold mb-3">
                    Family Information
                </h5>

                <div class="row g-4">
                    <!-- ================= Father NAME ================= -->
                    <div class="col-md-6">
                        <div id="fname_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="info-label">Father's Name</div>

                                    <div id="fname_text" class="info-value">
                                        <?= $students->f_lastname
                                            ? strtoupper($students->f_firstname . ' ' . $students->f_lastname)
                                            : '[empty]' ?>
                                    </div>

                                    <div id="fname_inputWrap" class="d-none mt-3">
                                        <div class="row g-2">
                                            <div class="col-4"><input name="f_firstname" id="f_fn" class="form-control form-control-sm" placeholder="First" value="<?= $students->f_firstname ?>"></div>
                                            <div class="col-4"><input name="f_middlename" id="f_mn" class="form-control form-control-sm" placeholder="Middle" value="<?= $students->f_middlename ?>"></div>
                                            <div class="col-4"><input name="f_lastname" id="f_ln" class="form-control form-control-sm" placeholder="Last" value="<?= $students->f_lastname ?>"></div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button id="fname_btn_edit" class="edit-chip" onclick="ieEdit('fname')">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <div id="fname_btn_group" class="d-none">
                                        <button class="icon-btn btn btn-success btn-sm"
                                            onclick="updateInformation('fname', 'u_id', 'profile_parent', {
                                            onSucess: () => {
                                                toastSucess('Father\'s Name Updated');
                                            }
                                        })"><i class="fa fa-check"></i></button>
                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('fname')">✕</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- ================= EDUCATION ================= -->
                    <div class="col-md-6">
                        <div id="feduc_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="info-label">Education</div>

                                    <div id="feduc_text" class="info-value">
                                        <?= ($f_educ ? strtoupper($f_educ->attainment) : '[empty]') ?>
                                    </div>

                                    <div id="feduc_inputWrap" class="d-none mt-3">
                                        <select name="f_educ" id="feduc_input" class="form-select form-select-sm">
                                            <option value="">Select attainment</option>
                                            <?php foreach ($educ_attain as $EA): ?>
                                                <option value="<?= $EA->ea_id ?>"><?= $EA->attainment ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <button id="feduc_btn_edit" class="edit-chip" onclick="ieEdit('feduc')">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <div id="feduc_btn_group" class="d-none">
                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('feduc', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('feduc')">✕</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ================= OCCUPATION ================= -->
                    <div class="col-md-6">
                        <div id="focc_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="info-label">Occupation</div>
                                    <div id="focc_text" class="info-value">
                                        <?php
                                        $focc = Modules::run('registrar/getOccupation', $students->f_occ);
                                        echo $students->f_occ ? $focc->occupation : '[empty]';
                                        ?>
                                    </div>

                                    <div id="focc_inputWrap" class="d-none mt-3">
                                        <input name="f_occ" id="focc_input" class="form-control form-control-sm" value="<?= ($students->f_occ ? $focc->occupation : '') ?>">
                                    </div>
                                </div>

                                <div>
                                    <button id="focc_btn_edit" class="edit-chip" onclick="ieEdit('focc')"><i class="fa fa-pencil"></i></button>
                                    <div id="focc_btn_group" class="d-none">
                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('focc', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('focc')">✕</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ================= OFFICE ================= -->
                    <div class="col-md-6">
                        <div id="foffice_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between align-items-start">

                                <div class="flex-grow-1">
                                    <div class="info-label">Office</div>

                                    <div id="foffice_text" class="info-value">
                                        <?= ($students->f_office_name
                                            ? strtoupper($students->f_office_name)
                                            : '[empty]') ?>
                                    </div>

                                    <div id="foffice_inputWrap" class="d-none mt-3">
                                        <input name="f_office_name" id="foffice_input" class="form-control form-control-sm" value="<?= $students->f_office_name ?>" placeholder="Enter office name">
                                    </div>
                                </div>

                                <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                    <div class="ms-3 text-end">

                                        <button id="foffice_btn_edit" class="edit-chip" onclick="ieEdit('foffice')"><i class="fa fa-pencil"></i></button>
                                        <div id="foffice_btn_group" class="d-none mt-1">
                                            <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('foffice', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                            <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('f0office')">✕</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ================= CONTACT ================= -->
                    <div class="col-md-6">
                        <div id="fmobile_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between align-items-start">

                                <div class="flex-grow-1">
                                    <div class="info-label">Contact Number</div>

                                    <div id="fmobile_text" class="info-value">
                                        <?= ($students->f_mobile ? $students->f_mobile : '[empty]') ?>
                                    </div>

                                    <div id="fmobile_inputWrap" class="d-none mt-3">
                                        <input name="f_mobile" id="fmobile_input" class="form-control form-control-sm" value="<?= $students->f_mobile ?>" placeholder="Enter contact number">
                                    </div>
                                </div>

                                <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                    <div class="ms-3 text-end">

                                        <button id="fmobile_btn_edit" class="edit-chip" onclick="ieEdit('fmobile')"><i class="fa fa-pencil"></i></button>
                                        <div id="fmobile_btn_group" class="d-none mt-1">
                                            <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('fmobile', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                            <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('fmobile')">✕</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-3">
                <div class="row g-4">

                    <!-- ================= MOTHER NAME ================= -->
                    <div class="col-md-6">
                        <div id="mname_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="info-label">Mother's Name</div>

                                    <div id="mname_text" class="info-value">
                                        <?= $students->m_lastname ? strtoupper($students->m_firstname . ' ' . $students->m_lastname) : '[empty]' ?>
                                    </div>

                                    <div id="mname_inputWrap" class="d-none mt-3">
                                        <div class="row g-2">
                                            <div class="col-4"><input name="m_firstname" id="m_fn" class="form-control form-control-sm" placeholder="First" value="<?= $students->m_firstname ?>"></div>
                                            <div class="col-4"><input name="m_middlename" id="m_mn" class="form-control form-control-sm" placeholder="Middle" value="<?= $students->m_middlename ?>"></div>
                                            <div class="col-4"><input name="m_lastname" id="m_ln" class="form-control form-control-sm" placeholder="Last" value="<?= $students->m_lastname ?>"></div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button id="mname_btn_edit" class="edit-chip" onclick="ieEdit('mname')">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <div id="mname_btn_group" class="d-none">
                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('mname', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('mname')">✕</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================= EDUCATION ================= -->
                    <div class="col-md-6">
                        <div id="meduc_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="info-label">Education</div>

                                    <div id="meduc_text" class="info-value">
                                        <?= ($m_educ ? strtoupper($m_educ->attainment) : '[empty]') ?>
                                    </div>

                                    <div id="meduc_inputWrap" class="d-none mt-3">
                                        <select name="m_educ" id="meduc_input" class="form-select form-select-sm">
                                            <option value="">Select attainment</option>
                                            <?php foreach ($educ_attain as $EA): ?>
                                                <option value="<?= $EA->ea_id ?>"><?= $EA->attainment ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <button id="meduc_btn_edit" class="edit-chip" onclick="ieEdit('meduc')">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    <div id="meduc_btn_group" class="d-none">
                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('meduc', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('meduc')">✕</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ================= OCCUPATION ================= -->
                    <div class="col-md-6">
                        <div id="mocc_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="info-label">Occupation</div>
                                    <div id="mocc_text" class="info-value">
                                        <?php
                                        $mocc = Modules::run('registrar/getOccupation', $students->m_occ);
                                        echo $students->m_occ ? $mocc->occupation : '[empty]';
                                        ?>
                                    </div>

                                    <div id="mocc_inputWrap" class="d-none mt-3">
                                        <input name="m_occ" id="mocc_input" class="form-control form-control-sm" value="<?= ($students->m_occ ? $mocc->occupation : '') ?>">
                                    </div>
                                </div>

                                <div>
                                    <button id="mocc_btn_edit" class="edit-chip" onclick="ieEdit('mocc')"><i class="fa fa-pencil"></i></button>
                                    <div id="mocc_btn_group" class="d-none">
                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('mocc', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('mocc')">✕</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- ================= OFFICE ================= -->
                    <div class="col-md-6">
                        <div id="moffice_card" class="info-card ie-card">

                            <div class="d-flex justify-content-between align-items-start">

                                <div class="flex-grow-1">
                                    <div class="info-label">Office</div>

                                    <div id="moffice_text" class="info-value">
                                        <?= ($students->m_office_name ? strtoupper($students->m_office_name) : '[empty]') ?>
                                    </div>

                                    <div id="moffice_inputWrap" class="d-none mt-3">
                                        <input name="m_office_name" id="moffice_input" class="form-control form-control-sm" value="<?= $students->m_office_name ?>" placeholder="Enter office name">
                                    </div>
                                </div>

                                <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                    <div class="ms-3 text-end">

                                        <button id="moffice_btn_edit" class="edit-chip" onclick="ieEdit('moffice')"><i class="fa fa-pencil"></i></button>
                                        <div id="moffice_btn_group" class="d-none mt-1">
                                            <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('moffice', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                            <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('moffice')">✕</button>
                                        </div>

                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <!-- ================= CONTACT ================= -->
                    <div class="col-md-6">
                        <div id="mmobile_card" class="info-card ie-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="info-label">Contact Number</div>
                                    <div id="mmobile_text" class="info-value">
                                        <?= ($students->m_mobile ? $students->m_mobile : '[empty]') ?>
                                    </div>
                                    <div id="mmobile_inputWrap" class="d-none mt-3">
                                        <input name="m_mobile" id="mmobile_input" class="form-control form-control-sm" value="<?= $students->m_mobile ?>" placeholder="Enter contact number">
                                    </div>
                                </div>

                                <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                    <div class="ms-3 text-end">
                                        <button id="mmobile_btn_edit" class="edit-chip" onclick="ieEdit('mmobile')"><i class="fa fa-pencil"></i></button>
                                        <div id="mmobile_btn_group" class="d-none mt-1">
                                            <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('mmobile', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                            <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('mmobile')">✕</button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <!-- ================= IN CASE OF EMERGENCY ================= -->
                    <div class="row g-3 mt-4"><!-- mt-4 adds space above -->

                        <!-- Emergency Contact -->
                        <div class="col-md-6">
                            <h5>In Case of Emergency</h5>
                            <hr class="my-2" />

                            <!-- Contact Name -->
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div id="eContactName_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Contact Name</div>
                                                <div id="eContactName_text" class="info-value">
                                                    <?= $students->ice_name != "" ? $students->ice_name : '[empty]' ?>
                                                </div>
                                                <div id="eContactName_inputWrap" class="d-none mt-3">
                                                    <input name="ice_name" id="eContactName_input" class="form-control form-control-sm" value="<?= $students->ice_name ?>" placeholder="Enter Emergency contact name">
                                                </div>
                                            </div>
                                            <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                                <div class="ms-3 text-end">
                                                    <button id="eContactName_btn_edit" class="edit-chip" onclick="ieEdit('eContactName')"><i class="fa fa-pencil"></i></button>
                                                    <div id="eContactName_btn_group" class="d-none mt-1">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('eContactName', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('eContactName')">✕</button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-md-12">
                                    <div id="eContactNumber_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Contact Number</div>
                                                <div id="eContactNumber_text" class="info-value">
                                                    <?= $students->ice_contact != "" ? $students->ice_contact : '[empty]' ?>
                                                </div>
                                                <div id="eContactNumber_inputWrap" class="d-none mt-3">
                                                    <input name="ice_contact" id="eContactNumber_input" class="form-control form-control-sm" value="<?= $students->ice_contact ?>" placeholder="Enter Emergency contact number">
                                                </div>
                                            </div>
                                            <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                                <div class="ms-3 text-end">
                                                    <button id="eContactNumber_btn_edit" class="edit-chip" onclick="ieEdit('eContactNumber')"><i class="fa fa-pencil"></i></button>
                                                    <div id="eContactNumber_btn_group" class="d-none mt-1">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('eContactNumber', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('eContactNumber')">✕</button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Relation to student -->
                                <div class="col-md-12">
                                    <div id="eContactRel_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Relation to Student</div>
                                                <div id="eContactRel_text" class="info-value">
                                                    <?= $students->ice_relation != "" ? $students->ice_relation : '[empty]' ?>
                                                </div>
                                                <div id="eContactRel_inputWrap" class="d-none mt-3">
                                                    <input name="ice_relation" id="eContactRel_input" class="form-control form-control-sm" value="<?= $students->ice_relation ?>" placeholder="Enter Relation to Student">
                                                </div>
                                            </div>
                                            <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                                <div class="ms-3 text-end">
                                                    <button id="eContactRel_btn_edit" class="edit-chip" onclick="ieEdit('eContactRel')"><i class="fa fa-pencil"></i></button>
                                                    <div id="eContactRel_btn_group" class="d-none mt-1">
                                                        <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('eContactRel', 'u_id', 'profile_parent')"><i class="fa fa-check"></i></button>
                                                        <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('eContactRel')">✕</button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Parent Portal Account -->
                        <div class="col-md-6">
                            <h5>Parent Portal Account</h5>
                            <hr class="my-2" />

                            <div class="row g-3">
                                <?php if ($students->uname != ''): ?>
                                    <!-- Credentials -->
                                    <div class="col-md-12 border rounded-3 p-3 bg-light">
                                        <div class="fw-semibold mb-2">Credentials:</div>
                                        <dl class="row mb-0">
                                            <dt class="col-4">Username:</dt>
                                            <dd class="col-8"><?php echo $students->uname ?></dd>
                                            <dt class="col-4">Password:</dt>
                                            <dd class="col-8"><?php echo ($students->autoGen ? $students->secret_key : '**********') ?></dd>
                                        </dl>
                                    </div>

                                    <!-- Siblings -->
                                    <div class="col-md-12 border rounded-3 p-3 bg-light">
                                        <div class="fw-semibold mb-2">Sibling/s in School:</div>
                                        <dl class="row mb-0">
                                            <?php
                                            $sibs = explode(",", $students->child_links);
                                            foreach ($sibs as $s):
                                                if ($s != $students->uid):
                                                    $ss = Modules::run('registrar/getStudentBySTID', $s);
                                            ?>
                                                    <dt class="col-4 pointer" onclick="window.location.href='<?php echo base_url() . 'registrar/viewDetails/' . base64_encode($ss->st_id); ?>'"><?php echo $s; ?></dt>
                                                    <dd class="col-8"><?php echo ucwords(strtolower($ss->firstname . " " . $ss->lastname)) ?></dd>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </dl>
                                    </div>

                                <?php else: ?>
                                    <div class="col-12">
                                        <button class="btn btn-success btn-md" onclick="generateAcc('<?php echo $students->ice_name ?>','<?php echo $students->ice_contact ?>','<?php echo $students->p_id ?>')">
                                            Generate Parent's Account
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= ATTENDANCE ================= -->
            <div class="tab-pane fade" id="attendanceInformation">
                <!-- <div class="row"> -->
                <div class="col-md-6">
                    <?php echo Modules::run('attendance/current', $option, base64_decode($this->uri->segment(3))); ?>
                </div>
                <!-- </div> -->
            </div>


            <!-- ================= ACADEMIC ================= -->
            <div class="tab-pane fade" id="academicInformation">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <?php echo Modules::run('widgets/getWidget', 'gradingsystem_widget', 'acadInfo', $students); ?>
                    </div>
                </div>
            </div>


            <!-- ================= MEDICAL ================= -->
            <div class="tab-pane fade" id="medicalInformation">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-light border-0 rounded-top-4">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="fa fa-heartbeat me-2"></i>Medical Information
                            </h6>
                        </div>

                        <div class="card-body">

                            <!-- Blood Type -->
                            <div class="col-md-12">
                                <div id="bloodType_card" class="info-card ie-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="info-label">Blood Type</div>
                                            <div id="bloodType_text" class="info-value">
                                                <?= $students->blood_type != "" ? $students->blood_type : '[empty]' ?>
                                            </div>
                                            <div id="bloodType_inputWrap" class="d-none mt-3">
                                                <input name="blood_type" id="bloodType_input" class="form-control form-control-sm" value="<?= $students->blood_type ?>" placeholder="Enter Blood Type">
                                            </div>
                                        </div>
                                        <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                            <div class="ms-3 text-end">
                                                <button id="bloodType_btn_edit" class="edit-chip" onclick="ieEdit('bloodType')"><i class="fa fa-pencil"></i></button>
                                                <div id="bloodType_btn_group" class="d-none mt-1">
                                                    <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('bloodType', 'user_id', 'profile_medical')"><i class="fa fa-check"></i></button>
                                                    <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('bloodType')">✕</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Height -->
                            <div class="col-md-12">
                                <div id="height_card" class="info-card ie-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="info-label">Height</div>
                                            <div id="height_text" class="info-value">
                                                <?= $students->height != "" ? $students->height : '[empty]' ?>
                                            </div>
                                            <div id="height_inputWrap" class="d-none mt-3">
                                                <input name="height" id="height_input" class="form-control form-control-sm" value="<?= $students->height ?>" placeholder="Enter Height">
                                            </div>
                                        </div>
                                        <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                            <div class="ms-3 text-end">
                                                <button id="height_btn_edit" class="edit-chip" onclick="ieEdit('height')"><i class="fa fa-pencil"></i></button>
                                                <div id="height_btn_group" class="d-none mt-1">
                                                    <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('height', 'user_id', 'profile_medical')"><i class="fa fa-check"></i></button>
                                                    <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('height')">✕</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Weight -->
                            <div class="col-md-12">
                                <div id="weight_card" class="info-card ie-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="info-label">Weight</div>
                                            <div id="weight_text" class="info-value">
                                                <?= $students->weight != "" ? $students->weight : '[empty]' ?>
                                            </div>
                                            <div id="weight_inputWrap" class="d-none mt-3">
                                                <input name="weight" id="weight_input" class="form-control form-control-sm" value="<?= $students->weight ?>" placeholder="Enter Weight">
                                            </div>
                                        </div>
                                        <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                            <div class="ms-3 text-end">
                                                <button id="weight_btn_edit" class="edit-chip" onclick="ieEdit('weight')"><i class="fa fa-pencil"></i></button>
                                                <div id="weight_btn_group" class="d-none mt-1">
                                                    <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('weight', 'user_id', 'profile_medical')"><i class="fa fa-check"></i></button>
                                                    <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('weight')">✕</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Medical Info -->
                            <div class="col-md-12">
                                <div id="otherImp_card" class="info-card ie-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="info-label">Other Medical Info</div>
                                            <div id="otherImp_text" class="info-value">
                                                <?= $students->other_important != "" ? $students->other_important : '[empty]' ?>
                                            </div>
                                            <div id="otherImp_inputWrap" class="d-none mt-3">
                                                <textarea name="other_important" id="otherImp_input" class="form-control form-control-sm" value="<?= $students->other_important ?>" placeholder="Enter Other Medical Info"></textarea>
                                            </div>
                                        </div>
                                        <?php if ($this->session->position_id != 39 || $isAdv): ?>
                                            <div class="ms-3 text-end">
                                                <button id="otherImp_btn_edit" class="edit-chip" onclick="ieEdit('otherImp')"><i class="fa fa-pencil"></i></button>
                                                <div id="otherImp_btn_group" class="d-none mt-1">
                                                    <button class="icon-btn btn btn-success btn-sm" onclick="updateInformation('otherImp', 'user_id', 'profile_medical')"><i class="fa fa-check"></i></button>
                                                    <button class="icon-btn btn btn-light btn-sm" onclick="ieCancel('otherImp')">✕</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= FILES ================= -->
            <div class="tab-pane fade" id="personalFiles">
                <?php echo $this->load->view('file_lists', $data); ?>
            </div>


            <!-- ================= REQUIREMENTS ================= -->
            <?php if ($this->session->position_id != 39): ?>
                <div class="tab-pane fade" id="enrollmentRequirements">
                    <?php
                    $data['stid'] = $students->uid;
                    $data['level'] = $students->gl_id;
                    echo $this->load->view('checkListPerDept', $data);
                    ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div id="ieToast" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="ieToastBody">
                    Updated successfully.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <?php
    $this->load->view('ovrLoadSubj');
    ?>

    <script type="text/javascript">
        const csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
        let csrfHash = "<?= $this->security->get_csrf_hash(); ?>";
        const BASE_URL = "<?= base_url() ?>";

        $(document).ready(function() {

            $("#Feduc_attain").select2();
            $(".tip-top").tooltip();
        });
        $('#profile_tab a[data-toggle="tab"]').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // Handle tab shown event to update active states
        $('#profile_tab a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            // Update active class on li elements
            $('#profile_tab li').removeClass('active');
            $(this).parent('li').addClass('active');
        });

        document.getElementById('idLrnModal')
            .addEventListener('shown.bs.modal', function() {
                document.getElementById('modal_lrn').focus();
            });

        function showToast(message) {
            const toastBody = document.getElementById('ieToastBody');
            toastBody.textContent = message;

            const toastEl = document.querySelector('#ieToast .toast');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        function updateInformation(keyCard, uid, tbl, options = {}) {

            const {
                url = BASE_URL + "registrar/updateParentsInfo",
                    method = "POST",
                    successMessage = "Information successfully updated.",
                    onSuccess = null,
                    onError = null
            } = options;

            const payload = ieSerializeCard(keyCard);

            const user_id = $('#stdUserID').val();
            payload.keyCard = keyCard;
            payload.key_id = user_id;
            payload.pk_id = uid;
            payload.tbl_name = tbl;

            // ✅ ADD CSRF TOKEN HERE
            payload[csrfName] = csrfHash;

            if (Object.keys(payload).length <= 4) {
                console.warn('No editable fields found for card:', keyCard);
                return;
            }

            const card = document.getElementById(keyCard + '_card');
            const textDiv = document.getElementById(keyCard + '_text');

            if (card) {
                card.classList.add('updating');
                card.querySelectorAll('button').forEach(b => b.disabled = true);
            }

            $.ajax({
                url: url,
                type: method,
                data: payload,
                dataType: "json",

                success: function(res) {

                    if (res.status === 'success') {

                        // 🔹 Update CSRF token
                        if (res.csrfHash) csrfHash = res.csrfHash;

                        // 🔹 Replace displayed value
                        if (textDiv) {
                            const newValue = buildDisplayValue(payload);
                            textDiv.textContent = newValue ? newValue : '[empty]';
                        }

                        // 🔹 Exit edit mode
                        if (typeof ieCancel === 'function') {
                            ieCancel(keyCard);
                        }

                        // 🔹 Success prompt
                        showToast(successMessage);

                        if (onSuccess) onSuccess(res);

                    } else {
                        alert(res.message || 'Update failed.');
                    }

                    unlockCard(card);
                },

                error: function(xhr) {
                    unlockCard(card);

                    if (onError) onError(xhr);
                    else alert('Update failed. Please try again.');
                }
            });
        }

        function unlockCard(card) {
            if (!card) return;
            card.classList.remove('updating');
            card.querySelectorAll('button').forEach(b => b.disabled = false);
        }

        function buildDisplayValue(payload) {

            // 🔹 Remove system fields (including CSRF automatically)
            const ignoreKeys = ['key_id', 'pk_id', 'tbl_name', 'keyCard', csrfName];

            // 🔹 Detect if this payload contains name fields
            const firstNameKey = Object.keys(payload).find(k => k.includes('first'));
            const lastNameKey = Object.keys(payload).find(k => k.includes('last'));

            // ✅ If it's a name card → show only First + Last
            if (firstNameKey && lastNameKey) {

                const first = payload[firstNameKey] || '';
                const last = payload[lastNameKey] || '';

                return `${first} ${last}`.trim().toUpperCase() || '[empty]';
            }

            // 🔹 Otherwise process normally
            const values = Object.keys(payload)
                .filter(key => !ignoreKeys.includes(key))
                .map(key => {

                    const field = document.querySelector(`[name="${key}"]`);

                    // Handle SELECT → use label instead of value
                    if (field && field.tagName === 'SELECT') {
                        return field.options[field.selectedIndex].text;
                    }

                    return payload[key];
                })
                .filter(val => val && val !== '');

            return values.length ? values.join(' ').toUpperCase() : '[empty]';
        }

        function ieSerializeCard(cardKey) {
            const wrap = document.getElementById(cardKey + '_inputWrap');
            if (!wrap || wrap.classList.contains('d-none')) return {};

            const data = {};

            wrap.querySelectorAll('input, select, textarea')
                .forEach(field => {

                    // skip if no name or disabled
                    if (!field.name || field.disabled) return;

                    // skip hidden inputs unless they have class 'ie-include'
                    if (field.type === 'hidden' && !field.classList.contains('ie-include')) return;

                    // ✅ normal input, textarea, single select
                    data[field.name] = field.value.trim();
                });

            return data;
        }

        function ieLockOthers(activeName) {
            $('.ie-card').addClass('edit-disabled');
            $('#' + activeName + '_card').removeClass('edit-disabled').addClass('edit-active');
        }

        function ieUnlockAll() {
            $('.ie-card')
                .removeClass('edit-disabled')
                .removeClass('edit-active');
        }

        function ieEdit(name) {
            // highlight + lock others
            ieLockOthers(name);

            $('#' + name + '_text').hide();
            $('#' + name + '_inputWrap').removeClass('d-none');
            $('#' + name + '_btn_edit').hide();
            $('#' + name + '_btn_group').removeClass('d-none');

            $('#' + name + '_inputWrap').find('input,select').first().focus();
        }

        function ieCancel(name) {
            $('#' + name + '_text').show();
            $('#' + name + '_inputWrap').addClass('d-none');
            $('#' + name + '_btn_edit').show();
            $('#' + name + '_btn_group').addClass('d-none');

            // unlock all cards
            ieUnlockAll();
        }

        function setCity(id) {
            const sel = document.getElementById('city');
            sel.value = id;

            getProvince(id);
        }


        function saveBasicInfoModal() {
            editBasicInfo(); // your existing function

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('basicInfoModal')
            );
            modal.hide();
        }

        function saveLevelSectionModal() {
            updateProfileLevel(); // your existing function

            bootstrap.Modal.getInstance(
                document.getElementById('levelSectionModal')
            ).hide();
        }

        function saveIdLrnModal() {
            let uid = $('#modal_uid').val();
            let lrn = $('#modal_lrn').val();

            updateProfile(
                '<?php echo base64_encode("st_id") ?>',
                '<?php echo base64_encode("esk_profile_students") ?>',
                uid,
                'lrn',
                lrn,
                'lrn'
            );

            $('#a_user_id').text(lrn);

            bootstrap.Modal.getInstance(
                document.getElementById('idLrnModal')
            ).hide();
        }

        function updateIfRegular(val, uid) {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() . 'registrar/updateIfRegular/' ?>' + val + '/' + uid,
                success: function() {
                    location.reload();
                }
            });
        }

        function saveMobile(user_id, mobile_no, column, tbl_name, field_id) {
            // alert(user_id + ' ' + mobile_no + ' ' + column + ' ' + tbl_name + ' ' + field_id);
            var url = "<?php echo base_url() . 'hr/saveContacts/' ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: 'user_id=' + user_id + '&mobile_no=' + mobile_no + '&column=' + column + '&tbl_name=' + tbl_name + '&field_id=' + field_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                success: function(data) {
                    // $('#' + span).html(mobile_no)
                    alert('Successfully Updated');
                }
            })
        }

        function maxMin(body, action) {
            if (action == "max") {
                $('#' + body + 'Min').removeClass('hide');
                $('#' + body + 'Max').addClass('hide')
                $('#' + body + 'Body').removeClass('hide fade');
                $('#name_header').html('')
                $('#attend_widget').attr('style', 'max-height: 250px; overflow-y: scroll;');
                //$('#attendance_container').attr('style', 'max-height: 250px; overflow-y: scroll;');
                $('#attend_widget_body').attr('style', 'max-height: 300px; overflow-y: scroll;');
            } else {
                $('#' + body + 'Min').addClass('hide')
                $('#' + body + 'Max').removeClass('hide');
                $('#' + body + 'Body').addClass('hide fade');
                $('#name_header').html($('#name').html())
                $('#attend_widget').attr('style', 'max-height:auto');
                //$('#attendance_container').attr('style', 'max-height:auto');
                $('#attend_widget_body').attr('style', 'max-height:auto');

            }
        }

        function getProvince(value) {
            var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
                success: function(data) {
                    $('#inputProvince').val(data.name)
                    $('#inputPID').val(data.id)
                }
            })
        }

        function updateEducAttain(mf, btn) {
            var pk = '<?php echo base64_encode('u_id') ?>'
            var tbl = '<?php echo base64_encode('profile_parent') ?>'
            var pk_value = $(btn).attr('u-id');
            if (mf == 'F') {
                var column = 'f_educ';
            } else {
                var column = 'm_educ';
            }
            var value = $('#' + mf + '_educAttain').val()
            var id = mf + '_educAttainValue'

            updateProfile(pk, tbl, pk_value, column, value, id)

        }

        function updateOccupation(occ, user_id, mf) {
            var url = "<?php echo base_url() . 'registrar/editOccupation/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType: 'json',
                data: 'value=' + occ + '&owner=' + user_id + '&mf=' + mf + '&sy=' + '<?php echo $students->school_year ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //alert(data)
                    if (mf == 'f') {
                        $('#a_f_occupation').html(data)
                        $('#a_f_occupation').show()
                        $('#f_occupation').hide()
                    } else {
                        $('#a_m_occupation').html(data)
                        $('#a_m_occupation').show()
                        $('#m_occupation').hide()
                    }



                }
            });

            return false;
        }

        function editId_number(idNum, id) {
            var editedIdNum = $('#input_' + id).val();
            var url = "<?php echo base_url() . 'registrar/editIdNumber/' ?>"
            $.ajax({
                type: "POST",
                url: url,
                data: "origIdNumber=" + idNum + "&editedIdNumber=" + editedIdNum + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$('#Pos').show();
                    $('#a_' + id).html(data)
                    $('#a_' + id).show()
                    $('#input_' + id).hide()
                }
            });

            return false;
        }

        function editAddressInfo() {
            var url = "<?php echo base_url() . 'registrar/editAddressInfo/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType: 'json',
                data: 'street=' + $('#street').val() + '&user_id=' + $('#address_user_id').val() + '&barangay=' + $('#barangay').val() + '&city=' + $('#city').val() + '&province=' + $('#inputPID').val() + '&address_id=' + '<?php echo $user_id ?>' + '&zip_code=' + $('#zip_code').val() + '&sy=' + '<?php echo $students->school_year ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$('#address_span').html(data);
                    location.reload();
                }
            });

            return false;
        }

        function editBasicInfo() {
            var name_id = $('#name_id').val();
            //alert($('#lastname').val() + ' ' + $('#firstname').val() + ' ' + $('#middlename').val() + ' ' + $('#rowid').val() + ' ' + $('#st_user_id').val() + ' ' + $('#pos').val())
            var url = "<?php echo base_url() . 'registrar/editBasicInfo/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType: 'json',
                data: 'lastname=' + $('#lastname').val() + '&firstname=' + $('#firstname').val() + '&middlename=' + $('#middlename').val() + '&rowid=' + $('#rowid').val() + '&user_id=' + $('#st_user_id').val() + '&pos=' + $('#pos').val() + '&sy=' + '<?php echo $students->school_year ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#' + name_id).html(data);
                    // location.reload;
                }
            });

            return false;
        }

        function editBdate(cal_id, owner) {
            var tbl = 'profile';
            var field = 'temp_bdate';
            var url = "<?php echo base_url() . 'calendar/editBdate/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType: 'json',
                data: 'bDate=' + cal_id + '&owner=' + owner + '&field=' + field + '&table=' + tbl + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#a_bdate').show()
                    $('#bdate').hide()
                    $('#a_bdate').html(cal_id)

                }
            });

            return false;
        }

        function editEnBdate(cal_id, owner) {
            var url = "<?php echo base_url() . 'calendar/editEndate/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                //dataType: 'json',
                data: 'enDate=' + cal_id + '&owner=' + owner + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#a_enDate').show()
                    $('#enDate').hide()
                    $('#enDate').html(cal_id)

                }
            });

            return false;
        }

        function updateProfile(pk, table, pk_id, column, value, id) {
            var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&sy=<?php echo $students->school_year ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$("form#quoteForm")[0].reset()
                    $('#a_' + id).show()
                    $('#' + id).hide()
                    $('#a_' + id).html(data.msg)

                }
            });
            location.reload();

            return false; // avoid to execute the actual submit of the form.
        }

        function saveProfileLevel() {
            var hash = '<?php echo $this->uri->segment(3) ?>';
            var user_id = $('#admission_user_id').val();
            var st_id = $('#st_id').val();
            var section_id = $('#inputSection').val();
            var grade_id = $('#inputGrade').val();
            var school_year = $('#inputEditSY').val();
            var strand_id = $('#inputStrand').val();

            switch (grade_id) {
                case '10':
                case '11':
                    var specs = $('#inputSpecialization').val();
                    break;
                default:
                    specs = 0;
                    break;
            }

            var url = "<?php echo base_url() . 'users/editProfileLevel/' ?>"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'st_id=' + st_id + '&user_id=' + user_id + '&specs=' + specs + '&school_year=' + school_year + '&section_id=' + section_id + '&grade_id=' + grade_id + '&strand_id=' + strand_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$("form#quoteForm")[0].reset()
                    alert(data.msg)
                    document.location = '<?php echo base_url('registrar/viewDetails') ?>/' + hash + '/' + school_year

                }
            });

            return false; // avoid to execute the actual submit of the form.
        }

        function selectSection(level_id) {
            var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#inputSection').html(data);
                    switch (level_id) {
                        case '10':
                        case '11':
                            $('#tle_specs').show();
                            $('#sh_strand').hide();
                            break;
                        case '12':
                        case '13':
                            $('#tle_specs').hide();
                            $('#sh_strand').show();
                            break;
                        default:
                            $('#tle_specs').hide();
                            $('#sh_strand').hide();
                            break;
                    }
                }
            });

            return false;
        }

        function saveGender() {
            var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
            var table = '<?php echo base64_encode('esk_profile') ?>'
            var pk = '<?php echo base64_encode('user_id') ?>'
            var st_id = '<?php echo $students->u_id ?>'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id=' + st_id + '&column=sex&value=' + $('#inputGender').val() + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$("form#quoteForm")[0].reset()
                    $('#st_sex').html(data.msg)

                }
            });
            return false;
        }

        function saveReligion() {
            var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
            var table = '<?php echo base64_encode('esk_profile') ?>'
            var pk = '<?php echo base64_encode('user_id') ?>'
            var st_id = '<?php echo $students->u_id ?>'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id=' + st_id + '&column=rel_id&value=' + $('#inputReligion').val() + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$("form#quoteForm")[0].reset()
                    $('#a_religion').html(data.msg)

                }
            });
            return false;
        }

        function saveMotherTongue() {
            var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
            var table = '<?php echo base64_encode('esk_profile_students') ?>'
            var pk = '<?php echo base64_encode('user_id') ?>'
            var st_id = '<?php echo $students->u_id ?>'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id=' + st_id + '&column=mother_tongue_id&value=' + $('#inputMotherTongue').val() + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$("form#quoteForm")[0].reset()
                    $('#a_motherTongue').html(data.msg)

                }
            });
            return false;
        }

        function saveEthnicGroup() {
            var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
            var table = '<?php echo base64_encode('esk_profile') ?>'
            var pk = '<?php echo base64_encode('user_id') ?>'
            var st_id = '<?php echo $students->u_id ?>'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id=' + st_id + '&column=ethnic_group_id&value=' + $('#inputEthnicGroup').val() + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    //$("form#quoteForm")[0].reset()
                    $('#a_ethnicGroup').html(data.msg)

                }
            });
            return false;
        }

        function saveNewValue(table) {
            var db_table = $('#' + table).attr('table');
            var db_column = $('#' + table).attr('column')
            var pk = $('#' + table).attr('pk')
            var retrieve = $('#' + table).attr('retrieve')
            var db_value = $('#add' + db_column).val()
            var url = "<?php echo base_url() . 'registrar/saveNewValue/' ?>" // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "table=" + db_table + "&column=" + db_column + "&value=" + db_value + "&pk=" + pk + "&retrieve=" + retrieve + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#input' + db_column).html(data);
                }
            });

            return false;
        }

        function imgSignUpload(id) {
            //alert(id + ' ' + $('#stdUserID').val());
            $('#stdUID').val($('#stdUserID').val());
            $('#picture_option').val(id);
            $('#imgUpload').modal('show');
        }


        $(document).ready(function() {
            $('#imgCrop').click(function() {
                $('#stdUID').val($('#stdUserID').val());
                $('#picture_option').val($(this).data('id'));
                $('#imgUpload').modal('show');
            });

            $('#saveOvrSubj').click(function() {
                var grade_level = $('#grade_level').val();
                var section = $('#selectSection').val();
                var subject = $('#selectSubject').val();
                var stid = '<?php echo $students->uid ?>';
                var ifRegular = '<?php echo $students->if_regular ?>';
                var term = $('#semSelect').val();
                var url = '<?php echo base_url() . 'registrar/saveOverload' ?>';
                //            alert(grade_level + ' ' + section + ' ' + subject + ' ' + term);

                if (grade_level == 0 || section == 0 || subject == 0) {
                    $("#errorMsg").append('<div class="alert alert-danger">' +
                        '<span class="glyphicon glyphicon-remove"> </span>' +
                        ' All Fields Should not be Empty!!!' +
                        '</div>');
                    $('.alert-danger').delay(500).show(10, function() {
                        $(this).delay(3000).hide(10, function() {
                            $(this).remove();
                        });
                    });
                    //            } else if (grade_level == 12 || grade_level == 13) {
                    //                if (term == 0) {
                    //                    $("#errorMsg").append('<div class="alert alert-danger">' +
                    //                            '<span class="glyphicon glyphicon-remove"> </span>' +
                    //                            ' Please Select Term' +
                    //                            '</div>');
                    //                    $('.alert-danger').delay(500).show(10, function () {
                    //                        $(this).delay(3000).hide(10, function () {
                    //                            $(this).remove();
                    //                        });
                    //                    });
                    //                }
                } else {
                    $('#ovrSubj').modal('hide');
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'st_id=' + stid + '&level=' + grade_level + '&section=' + section + '&subject=' + subject + '&ifRegular=' + ifRegular + '&term=' + term + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                        success: function(data) {

                        }
                    });
                }
            });
        });

        function delSelSubj(id) {
            $.confirm({
                title: 'Confirmation Alert!',
                content: 'Are you sure you want to delete this record?',
                buttons: {
                    confirm: function() {
                        var url = '<?php echo base_url() . 'registrar/delSelSubj/' ?>' + id;
                        $.ajax({
                            type: 'GET',
                            data: 'id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                            url: url,
                            success: function(data) {
                                $.alert('Record Deleted Successfuly!');
                            }
                        });
                    },
                    cancel: function() {
                        $.alert('Canceled!');
                    }
                }
            });
        }

        function genPass(id) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: 'id=' + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                url: '<?php echo base_url() . 'registrar/generatePass' ?>',
                success: function(data) {
                    if (data.status == 'true') {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                        location.reload();
                    }
                }
            });
        }

        function generateAcc(name, number, pid) {
            if (name == '') {
                alert('Emergency Contact Name is Required');
                proceed = 0;
            } else if (number == '') {
                alert('Emergency Contact Name is Required');
            } else {
                var url = '<?php echo base_url('registrar/generateParentsAcc') ?>';

                $.ajax({
                    type: 'POST',
                    data: 'name=' + name + '&number=' + number + '&pid=' + pid + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                    dataType: 'json',
                    url: url,
                    success: function(data) {
                        alert(data.msg);
                        location.reload();
                    }
                })
            }
        }

        function requestOTP(val) {
            alert(val)
            var url = '<?php echo base_url('registrar/requestOTP') ?>';

            $.ajax({
                type: 'POST',
                data: 'value=' + val + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('#otpCode').modal('show');
                        $('#otp').text(data.otp);
                        $('#oCode').val(data.otp);
                        $('#pid').val(data.pid);
                    }
                }
            })
        }

        function genNewPass() {
            var otp = $('#oCode').val();
            var pid = $('#pid').val();
            var url = '<?php echo base_url('registrar/resetPassword/') ?>' + otp + '/' + pid;

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    if (data) {
                        alert('Password Successfuly Reset');
                    } else {
                        alert('An Error Occured');
                    }
                    location.reload();
                }
            })
        }
    </script>

    <style>
        .info-card {
            background: #f8fafc;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 16px;
            transition: .18s ease;
        }

        .info-card.edit-active {
            background: #ffffff;
            border: 2px solid #4f46e5;
            box-shadow: 0 8px 22px rgba(79, 70, 229, .18);
            transform: translateY(-2px);
        }

        .info-card.edit-disabled {
            opacity: .45;
            filter: grayscale(.2);
            pointer-events: none;
        }

        .info-card:hover {
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
            transform: translateY(-2px);
        }

        .info-label {
            font-size: .78rem;
            color: #6c757d;
            letter-spacing: .3px;
        }

        .info-value {
            font-weight: 600;
            font-size: 1rem;
        }

        .edit-chip {
            border: 0;
            background: #eef2ff;
            color: #4f46e5;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: .8rem;
        }

        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            /* consistent square buttons */
            height: 34px;
            padding: 0;
            line-height: 1;
        }

        .icon-btn i {
            font-size: 14px;
            /* consistent icon size */
        }

        .info-card.updating {
            opacity: .6;
            pointer-events: none;
            border: 2px solid #0d6efd;
            transition: .2s;
        }
    </style>