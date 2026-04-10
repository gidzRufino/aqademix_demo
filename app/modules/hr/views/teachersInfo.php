<?php
$hrdb = Modules::load('hr/hrdbprocess/');
$leaveSpent = Modules::run('hr/payroll/getTotalLeaveSpent', $basicInfo->employee_id);
$daysLCredited = Modules::run('hr/payroll/getLeaveCredited', $basicInfo->employee_id, null);
$lcInHrs = ($basicInfo->leave_credits * 8) - $leaveSpent->totalLeaveSpent - $daysLCredited->leaveCredited;

$officialTime = Modules::run('hr/hrdbprocess/getTimeShift', $basicInfo->time_group_id);
$officialTimeInAm = ($officialTime ? $officialTime->ps_from : '08:00:00');
$officialTimeOutAm = ($officialTime ? $officialTime->ps_to : '12:00:00');
$totalTimeMorning = round(abs(strtotime($officialTimeInAm) - strtotime($officialTimeOutAm)) / 60, 2);

$officialTimeInPm = ($officialTime ? $officialTime->ps_from_pm : '13:00:00');
$officialTimeOutPm = ($officialTime ? $officialTime->ps_to_pm : '17:00:00');
$totalTimeAfternoon = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutPm)) / 60, 2);

$lunchBreak = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutAm)) / 60, 2);
$totalHoursReq = $totalTimeMorning + $totalTimeAfternoon;
$totalHoursReq = ($totalHoursReq >= 450 ? 480 : $totalHoursReq);

$timeInCompute = 0;
$timeOutCompute = 0;
$timeInPMCompute = 0;
$timeOutPMCompute = 0;
$totalUndertimeTardy = 0;
$totalUndertime = 0;
$overtime = 0;
$otID = 1;

$totalMin = 0;
$totalHours = 0;
$under = 0;

foreach ($records as $row) {
    if ($row->time_in != "") {
        if (mb_strlen($row->time_in) <= 3):
            $time_in = date("g:i a", strtotime("0" . $row->time_in));
            $forUnderIn = date("g:i:s", strtotime("0" . $row->time_in));
        else:
            $time_in = date("g:i a", strtotime($row->time_in));
            $forUnderIn = date("g:i:s", strtotime($row->time_in));
        endif;

        $timeInCompute = $row->time_in;
    } else {
        $time_in = "";
        $forUnderIn = "";
    }

    if ($row->time_out != "") {
        if (mb_strlen($row->time_out) <= 3):
            $time_out = date("g:i a", strtotime('0' . $row->time_out));
        else:
            $time_out = date("g:i a", strtotime($row->time_out));
        endif;
        $timeOutCompute = $row->time_out;
    } else {
        $time_out = "";
    }

    if ($row->time_in_pm != "") {
        $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
        $timeInPMCompute = $row->time_in_pm;
    } else {
        $time_in_pm = "";
    }
    if ($row->time_out_pm != "") {
        $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
        $timeOutPMCompute = $row->time_out_pm;
        $forUnderPMOut = date("g:i:s", strtotime($row->time_out_pm));
    } else {
        $time_out_pm = "";
        $forUnderPMOut = "";
    }

    if ($timeInCompute != 0): // In AM
        $tardyAm = ((strtotime($time_in) - strtotime($officialTimeInAm))) <= 0 ? 0 : (strtotime($time_in) - strtotime($officialTimeInAm)) / 60;
    else:
        $tardyAm = $totalTimeMorning;
    endif;

    if ($timeOutCompute != 0):
        if (strtotime($time_out) < strtotime($officialTimeInAm)):
            if ($timeOutPMCompute == 0):
                $totalUndertime = $totalTimeMorning;
            else:
                $totalUndertime = 0;
            endif;
        else:
            $undertimeAm = ((strtotime($officialTimeOutAm) - strtotime($time_out))) <= 0 ? 0 : (strtotime($officialTimeOutAm) - strtotime($time_out)) / 60;
            $totalUndertime = $tardyAm + $undertimeAm;
        endif;
    elseif ($timeOutPMCompute != 0):
        $totalUndertime = $tardyAm;
    else:
        $totalUndertime = $totalTimeMorning;
    endif;

    //---------------- Afternoon --------------------------------------------------------///

    if ($timeInPMCompute != 0):
        if ($timeInCompute != 0):
            $tardyPm = 0;
        else:
            $tardyPm = ((strtotime($time_in_pm) - strtotime($officialTimeInPm))) <= 0 ? 0 : (strtotime($time_in_pm) - strtotime($officialTimeInPm)) / 60;
        endif;
    elseif ($timeOutPMCompute != 0):
        $tardyPm = 0;
    else:
        $tardyPm = $totalTimeAfternoon;
    endif;

    if ($timeOutPMCompute != 0):
        $undertimePM =  (strtotime($officialTimeOutPm) - strtotime($time_out_pm)) <= 0 ? 0 : (strtotime($officialTimeOutPm) - strtotime($time_out_pm)) / 60;
        $totalUndertimePm = $undertimePM + $tardyPm;
    elseif ($timeInPMCompute != 0):
        $totalUndertimePm = $totalTimeAfternoon;
    else:
        $totalUndertimePm = $tardyPm;
    endif;

    $totalRender = 0;
    if ($timeInCompute != 0):
        if ($timeOutPMCompute != 0):
            if ($tardyAm == 0):
                if ($undertimePM == 0):
                    $totalRender = ((strtotime($officialTimeOutPm) - strtotime($officialTimeInAm)) / 60) - $lunchBreak;
                    if (strtotime($time_out_pm) > strtotime($officialTimeOutPm)):
                        $overtime = strtotime($time_out_pm) - strtotime($officialTimeOutPm);
                    endif;
                else:
                    $totalRender = ((strtotime($time_out_pm) - strtotime($officialTimeInAm)) / 60) - $lunchBreak;
                endif;
            else:
                if ($undertimePM == 0):
                    $totalRender = ((strtotime($officialTimeOutPm) - strtotime($time_in)) / 60) - $tardyAm - $lunchBreak;
                    if (strtotime($time_out_pm) > strtotime($officialTimeOutPm)):
                        $overtime = strtotime($time_out_pm) - strtotime($officialTimeOutPm);
                    endif;
                else:
                    $totalRender = ((strtotime($time_out_pm) - strtotime($time_in)) / 60) - $tardyAm - $lunchBreak;
                endif;
            endif;
        elseif ($timeOutCompute != 0):
            if ($tardyAm == 0):
                if ($undertimeAm == 0):
                    $totalRender = ((strtotime($officialTimeOutAm) - strtotime($officialTimeInAm)) / 60);
                else:
                    $totalRender = ((strtotime($time_out) - strtotime($officialTimeInAm)) / 60);
                endif;
            else:
                if ($undertimeAm == 0):
                    $totalRender = ((strtotime($officialTimeOutAm) - strtotime($time_in)) / 60);
                else:
                    $totalRender = ((strtotime($time_out) - strtotime($time_in)) / 60);
                endif;
            endif;
        else:
            $totalRender = 0;
        endif;
    elseif ($timeInPMCompute != 0):
        if ($timeOutPMCompute != 0):
            if ($tardyPm == 0):
                if ($undertimePM == 0):
                    $totalRender = ((strtotime($officialTimeOutPm) - strtotime($officialTimeInPm)) / 60);
                else:
                    $totalRender = ((strtotime($time_out_pm) - strtotime($officialTimeInPm)) / 60);
                endif;
            else:
                if ($undertimePM == 0):
                    $totalRender = ((strtotime($officialTimeOutPm) - strtotime($time_in_pm)) / 60);
                else:
                    $totalRender = ((strtotime($time_out_pm) - strtotime($time_in_pm)) / 60);
                endif;
            endif;
        else:
            $totalRender = 0;
        endif;
    endif;

    $totalRender = ($totalRender >= 450 ? 480 : $totalRender);

    if ($totalRender > 0):
        $under = ($totalHoursReq - $totalRender <= 0 ? 0 : $totalHoursReq - $totalRender);
        $totalRender = $totalRender;
    else:
        $under = 0;
        $totalRender = 0;
    endif;
    // echo abs(date('H:i', mktime(0, $totalHoursReq))) . 'h ' . abs(date('i', mktime(0, $totalHoursReq))) . 'm';

    //echo $totalUndertimePm+$tardyPm;
    // $totalUndertimeTardy = ($tardyAm + $undertimeAm)+($tardyPm+$undertimePm);

    if ($row->date != date('Y-m-d')):
        $totalUndertimeTardy = $totalUndertime + $totalUndertimePm;
        $overtime = ($totalUndertimeTardy > 0 ? 0 : ($overtime / 60));
    endif;
    $isOT = Modules::run('hr/payroll/getOverTimeByDate', base64_encode($info->employee_id), base64_encode($row->att_id));

    $HoursAM = $hrdb->getManHours($time_in, $time_out, $row->date);
    $HoursPM = $hrdb->getManHours($time_in_pm, $time_out_pm, $row->date);
    $totaltimeAM = json_decode($HoursAM);
    $totaltimePM = json_decode($HoursPM);

    $totalAmH = $totaltimeAM->totalTime;
    $totalPmH = $totaltimePM->totalTime;
    if ($time_out == 0 && $time_out_pm != 0):
        $totalAmH = 4;
    endif;


    $totalTimeH = $totalAmH + $totalPmH;
    $totalTimeM = $totaltimeAM->minutes + $totaltimePM->minutes;

    if ($row->date != date('Y-m-d')):
        $totalH = (8 * 60) - $totalUndertimeTardy;
    else:
        $totalH = 0;
    endif;

    // echo abs(date('H:i', mktime(0, $totalRender))) . 'h ' . abs(date('i', mktime(0, $totalRender))) . 'm';
    $renderTime = 0;

    if ($totalRender > $totalHoursReq):
        $renderTime = $totalHoursReq;
    else:
        $renderTime = $totalRender;
    endif;

    $totalHours += abs(date('H', mktime(0, $renderTime)));
    $totalMin += date('i', mktime(0, $renderTime));
    $overAllTardy += $totalUndertimeTardy;

    unset($totalTimeH);
    unset($totalTimeM);
    unset($undertimeAm);
    unset($undertimePM);
    unset($totalUndertime);
    unset($totalUndertimePm);
    unset($totalUndertimeTardy);
    $timeInCompute = 0;
    $timeInPMCompute = 0;
    $timeOutCompute = 0;
    $timeOutPMCompute = 0;
}
$th = abs(date('H', mktime(0, $totalHoursReq)));
$tm = abs(date('i', mktime(0, $totalHoursReq)));
$tt = round(($tm / 60), 2) + $th;
$hoursRequired = (Modules::run('hr/getNumberOfDaysWork', $dateFrom, $dateTo)) * $tt;
$leaveDaysCredited = Modules::run('hr/payroll/getLeaveByDates', $dateFrom, $dateTo, $basicInfo->employee_id);
?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h3 class="text-center border-bottom pb-2">Teacher's Information</h3>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <input type="hidden" id="empUserID" value="<?= $basicInfo->uid ?>" />

            <div class="row g-3 align-items-start">
                <!-- Profile Photo -->
                <div class="col-lg-2 text-center">
                    <div onclick="imgSignUpload(this.id)" id="photo" class="cursor-pointer">
                        <?php if ($basicInfo->avatar != '' && file_exists('uploads/' . $basicInfo->avatar)): ?>
                            <img class="rounded-circle img-fluid border border-4 border-white shadow"
                                style="width:150px;"
                                src="<?= base_url() . 'uploads/' . $basicInfo->avatar ?>" />
                        <?php else: ?>
                            <img class="rounded-circle img-fluid border border-4 border-white shadow"
                                style="width:150px;"
                                src="<?= base_url() . 'images/avatar/' . ($basicInfo->sex == 'Female' ? 'female.png' : 'male.png') ?>" />
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="col-lg-6">
                    <h2 class="mb-1">
                        <span id="name"><?= $basicInfo->firstname . ' ' . $basicInfo->lastname ?></span>
                        <?php if ($this->session->employee_id == $basicInfo->employee_id): ?>
                            <small>
                                <i class="fa fa-pencil-square-o text-muted pointer"
                                    data-bs-toggle="modal"
                                    data-bs-target="#basicInfoModal"
                                    onclick="
                                $('#firstname').val('<?= $basicInfo->firstname ?>'), 
                                    $('#middlename').val('<?= $basicInfo->middlename ?>'), 
                                    $('#lastname').val('<?= $basicInfo->lastname ?>'),
                                    $('#pos').val('s'),
                                    $('#st_user_id').val('<?= $basicInfo->uid ?>'),
                                    $('#rowid').val('<?= $basicInfo->uid ?>'),
                                    $('#name_id').val('name')"></i>
                            </small>
                        <?php endif; ?>
                    </h2>

                    <!-- Position -->
                    <h5 class="mb-2">
                        <span class="text-danger">Position:</span>
                        <?php
                        if (isset($employeePositions) && is_array($employeePositions) && count($employeePositions)) {
                            $activePosition = null;
                            $otherPositions = [];

                            foreach ($employeePositions as $ep) {
                                if ((int)$ep->is_primary === 1) $activePosition = $ep;
                                else $otherPositions[] = $ep;
                            }
                            if (!$activePosition) $activePosition = $employeePositions[0];
                        ?>
                            <span class="badge bg-success">
                                <?= ($activePosition->department ? $activePosition->department . ' - ' : '') . $activePosition->position; ?>
                                <small>[active]</small>
                            </span>

                            <?php if (!empty($otherPositions)): ?>
                                <span class="badge bg-info text-dark pointer"
                                    data-bs-toggle="popover"
                                    data-bs-html="true"
                                    data-bs-placement="bottom"
                                    data-bs-content='
                                      <div class="p-2">
                                          <?php foreach ($otherPositions as $op): ?>
                                              <div class="border-bottom mb-2 pb-2">
                                                  <strong><?= ($op->department ? $op->department . " - " : "") . $op->position; ?></strong>
                                                  <?php if ($this->session->employee_id == $basicInfo->employee_id): ?>
                                                      <button class="btn btn-sm btn-success w-100 mt-1"
                                                          onclick="activateEmployeePosition(<?= $basicInfo->employee_id ?>,<?= $op->position_id ?>,<?= $op->user_id ?>,<?= $op->dept_id ?>)">
                                                          Activate
                                                      </button>
                                                  <?php endif; ?>

                                                  <?php if ($this->session->userdata("is_admin")): ?>
                                                      <button class="btn btn-sm btn-danger w-100 mt-1"
                                                          onclick="deleteEmployeePosition(<?= $basicInfo->employee_id ?>,<?= $op->position_id ?>)">
                                                          Remove
                                                      </button>
                                                  <?php endif; ?>
                                              </div>
                                          <?php endforeach; ?>
                                      </div>'>
                                    +<?= count($otherPositions) ?> more
                                </span>
                            <?php endif; ?>
                        <?php } else {
                            echo $basicInfo->position;
                        } ?>
                    </h5>

                    <div class="mb-2">
                        <small class="text-muted">
                            ID: <?= $basicInfo->employee_id ?>
                            <input type="hidden" id="em_id" value="<?= $basicInfo->employee_id ?>" />
                        </small>
                    </div>

                    <div class="mb-2">
                        <small>
                            Username: <?= $basicInfo->uname ?><br>
                            Password: <em id="dotdot">* * * * * *</em>
                            <?php if ($this->session->employee_id == $basicInfo->employee_id): ?>
                                <i class="fa fa-pencil-square-o text-muted pointer"
                                    data-bs-toggle="modal"
                                    data-bs-target="#passChangeModal"></i>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>

                <!-- Attendance Summary -->
                <div class="col-lg-4">
                    <div class="card border-primary shadow-sm">
                        <div class="card-header bg-primary text-white">
                            Work Summary
                        </div>
                        <div class="card-body p-2">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <th class="text-end">Hours Required :</th>
                                    <td><span id="totalHoursRequired"><?= $hoursRequired ?></span> hrs</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Hours Rendered :</th>
                                    <td><span id="hoursRendered"><?= round(($totalMin / 60), 2) + $totalHours ?></span> hrs</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Tardy/Undertime :</th>
                                    <td><span id="totalMinutesTardy"><?= date('i', $under) ?></span> hrs</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Leave :</th>
                                    <td>
                                        <span id="dlInHrs"><?= ($dlCredited / 8) ?></span> hrs
                                        [<span id="totalDaysLeave"><?= $dlCredited ?></span> days]
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    $absent = $hoursRequired - (round(($totalMin / 60), 2) + $totalHours) - $dlCredited;
                                    ?>
                                    <th class="text-end">Absent :</th>
                                    <td>
                                        <span id="daInHrs"><?= number_format($absent, 2) ?></span> hrs
                                        [<span id="totalDaysAbsent"><?= number_format($absent / 8, 2); ?></span> days]
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-end">Leave Credits :</th>
                                    <td><span id="LCredits"><?= $lcInHrs ?></span> hrs remaining</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="profile_tab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#PersonalInfo">Personal Information</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#academicInformation">Academic Information</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#statutory">Salary / Benefits</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dtr">Daily Time Record</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#od_info">Loans / Deductions</button>
        </li>
        <!-- <li class="ms-auto">
            <button class="btn btn-sm btn-outline-primary" onclick="imgSignUpload('sign')">Upload Signature</button>
        </li> -->
    </ul>

    <div class="tab-content border border-top-0 p-3 bg-white">
        <div class="tab-pane fade show active" id="PersonalInfo">
            <div class="row g-4">

                <!-- Left: Personal Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Personal Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- ================= ADDRESS — FULL WIDTH ================= -->
                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light h-100 d-flex justify-content-between align-items-start info-card ie-card">
                                        <div>
                                            <div class="text-muted small mb-1">Address</div>
                                            <div class="fw-semibold text-uppercase">
                                                <span id="address_span">
                                                    <?= strtoupper(
                                                        $basicInfo->street . ', ' .
                                                            $basicInfo->barangay . ' ' .
                                                            $basicInfo->mun_city . ', ' .
                                                            $basicInfo->province . ', ' .
                                                            $basicInfo->zip_code
                                                    ); ?>
                                                </span>
                                            </div>
                                        </div>

                                        <i class="fa fa-pencil text-primary pointer"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addressInfoModal"
                                            title="Edit Address"
                                            onclick="
                                            setCity('<?= $basicInfo->city_id ?>',
                                            $('#street').val('<?= $basicInfo->street ?>'),
                                            $('#barangay').val('<?= $basicInfo->barangay ?>'),
                                            $('#city').val('<?= $basicInfo->city_id ?>'),
                                            $('#inputProvince').val('<?= $basicInfo->province ?>'),
                                            $('#zip_code').val('<?= $basicInfo->zip_code ?>'),
                                            $('#address_id').val('<?= $basicInfo->address_id ?>'),
                                            $('#address_user_id').val('<?= $basicInfo->user_id ?>'),
                                            $('#inputPID').val('<?= $basicInfo->province_id ?>')
                                            )"></i>
                                    </div>
                                </div>

                                <!-- ================= CONTACT NO ================= -->
                                <div class="col-md-6">
                                    <div id="mobile_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Contact No</div>
                                                <div class="info-value" id="mobile_text">
                                                    <?= ($basicInfo->cd_mobile != "" ? $basicInfo->cd_mobile : "[empty]"); ?>
                                                </div>

                                                <div id="mobile_inputWrap" class="d-none">
                                                    <input type="text" name="cd_mobile" id="mobile_input" class="form-control form-control-sm"
                                                        value="<?= $basicInfo->cd_mobile ?>">
                                                </div>
                                            </div>
                                            <button id="mobile_btn_edit" class="edit-chip" onclick="ieEdit('mobile')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="mobile_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('mobile', 'contact_id', 'profile_contact_details')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('mobile')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================= EMAIL ================= -->
                                <div class="col-md-6">
                                    <div id="email_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Email</div>
                                                <div class="info-value" id="email_text">
                                                    <?= ($basicInfo->cd_email != "" ? $basicInfo->cd_email : "[empty]"); ?>
                                                </div>

                                                <div id="email_inputWrap" class="d-none mt-3">
                                                    <input type="text" name="cd_email" id="email_input" class="form-control form-control-sm"
                                                        value="<?= $basicInfo->cd_email ?>">
                                                </div>
                                            </div>
                                            <button id="email_btn_edit" class="edit-chip" onclick="ieEdit('email')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="email_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('email', 'contact_id', 'profile_contact_details')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('email')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================= GENDER ================= -->
                                <div class="col-md-6">
                                    <div id="gender_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Gender</div>
                                                <div class="info-value" id="gender_text">
                                                    <?= $basicInfo->sex != NULL ? $basicInfo->sex : '[empty]'; ?>
                                                </div>
                                                <div id="gender_inputWrap" class="d-none mt-3">
                                                    <select name="sex" id="gender_input" class="form-select form-select-sm">
                                                        <option value="Male" <?= $basicInfo->sex == 'Male' ? 'selected' : '' ?>>Male</option>
                                                        <option value="Female" <?= $basicInfo->sex == 'Female' ? 'selected' : '' ?>>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button id="gender_btn_edit" class="edit-chip" onclick="ieEdit('gender')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="gender_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('gender', 'user_id', 'profile')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('gender')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================= BIRTHDATE ================= -->
                                <div class="col-md-6">
                                    <div id="bdate_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Birthdate</div>
                                                <div class="info-value" id="bdate_text">
                                                    <?= $basicInfo->temp_bdate; ?>
                                                </div>
                                                <div id="bdate_inputWrap" class="d-none mt-3">
                                                    <input name="temp_bdate" id="bdate_input" type="date" class="form-control form-control-sm" value="<?= ($basicInfo->temp_bdate != NULL || $basicInfo->temp_bdate != '0000-00-00' ? $basicInfo->temp_bdate : '[empty]') ?>">
                                                </div>
                                            </div>
                                            <div>
                                                <button id="bdate_btn_edit" class="edit-chip" onclick="ieEdit('bdate')"><i class="fa fa-pencil"></i></button>
                                            </div>

                                            <!-- Bottom Action Buttons -->
                                            <div id="bdate_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                                <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                    onclick="updateInformation('bdate', 'user_id', 'profile')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                    onclick="ieCancel('bdate')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================= BLOOD TYPE ================= -->
                                <div class="col-md-4">
                                    <div id="bloodType_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Blood Type</div>
                                                <div class="info-value" id="bloodType_text">
                                                    <?= $basicInfo->blood_type; ?>
                                                </div>
                                                <div id="bloodType_inputWrap" class="d-none mt-3">
                                                    <input name="blood_type" id="bloodType_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->blood_type != NULL ? $basicInfo->blood_type : '[empty]') ?>">
                                                </div>
                                            </div>
                                            <button id="bloodType_btn_edit" class="edit-chip" onclick="ieEdit('bloodType')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="bloodType_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('bloodType', 'user_id', 'profile_medical')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('bloodType')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================= HEIGHT ================= -->
                                <div class="col-md-4">
                                    <div id="height_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Height</div>
                                                <div class="info-value" id="height_text">
                                                    <?= $basicInfo->height; ?>
                                                </div>
                                                <div id="height_inputWrap" class="d-none mt-3">
                                                    <input name="height" id="height_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->height != NULL ? $basicInfo->height : '[empty]') ?>">
                                                </div>
                                            </div>
                                            <button id="height_btn_edit" class="edit-chip" onclick="ieEdit('height')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="height_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('height', 'user_id', 'profile_medical')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('height')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================= WEIGHT ================= -->
                                <div class="col-md-4">
                                    <div id="weight_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Weight</div>
                                                <div class="info-value" id="weight_text">
                                                    <?= $basicInfo->weight; ?>
                                                </div>
                                                <div id="weight_inputWrap" class="d-none mt-3">
                                                    <input name="weight" id="weight_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->weight != NULL ? $basicInfo->weight : '[empty]') ?>">
                                                </div>
                                            </div>
                                            <button id="weight_btn_edit" class="edit-chip" onclick="ieEdit('weight')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="weight_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('weight', 'user_id', 'profile_medical')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('weight')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency -->
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">In Case of Emergency</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div id="eName_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Name</div>
                                                <div class="info-value" id="eName_text">
                                                    <?= $basicInfo->incase_name != null ? $basicInfo->incase_name : '[empty]'; ?>
                                                </div>
                                                <div id="eName_inputWrap" class="d-none mt-3">
                                                    <input name="incase_name" id="eName_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->incase_name != NULL ? $basicInfo->incase_name : '[empty]') ?>">
                                                </div>
                                            </div>
                                            <button id="eName_btn_edit" class="edit-chip" onclick="ieEdit('eName')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="eName_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('eName', 'user_id', 'profile_employee')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('eName')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="eContact_card" class="info-card ie-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Contact</div>
                                                <div class="info-value" id="eContact_text">
                                                    <?= $basicInfo->incase_contact != null ? $basicInfo->incase_contact : '[empty]'; ?>
                                                </div>
                                                <div id="eContact_inputWrap" class="d-none mt-3">
                                                    <input name="incase_contact" id="eContact_input" type="text" class="form-control form-control-sm" value="<?= ($basicInfo->incase_contact != NULL ? $basicInfo->incase_contact : '[empty]') ?>">
                                                </div>
                                            </div>
                                            <button id="eContact_btn_edit" class="edit-chip" onclick="ieEdit('eContact')"><i class="fa fa-pencil"></i></button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="eContact_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('eContact', 'user_id', 'profile_employee')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('eContact')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="eRelation_card" class="info-card ie-card h-100 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="info-label">Relation</div>
                                                <div class="info-value" id="eRelation_text">
                                                    <?= $basicInfo->incase_relation != null ? $basicInfo->incase_relation : '[empty]'; ?>
                                                </div>

                                                <div id="eRelation_inputWrap" class="d-none mt-3">
                                                    <input name="incase_relation" id="eRelation_input" type="text"
                                                        class="form-control form-control-sm"
                                                        value="<?= ($basicInfo->incase_relation != NULL ? $basicInfo->incase_relation : '[empty]') ?>">
                                                </div>
                                            </div>

                                            <!-- Edit Button -->
                                            <button id="eRelation_btn_edit" class="edit-chip"
                                                onclick="ieEdit('eRelation')">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </div>

                                        <!-- Bottom Action Buttons -->
                                        <div id="eRelation_btn_group" class="d-none mt-auto d-flex justify-content-end">
                                            <button class="icon-btn btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                onclick="updateInformation('eRelation', 'user_id', 'profile_employee')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="icon-btn btn btn-light btn-sm d-flex align-items-center justify-content-center"
                                                onclick="ieCancel('eRelation')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right: Signature -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <!-- Header -->
                        <div class="card-header bg-white border-0 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-semibold text-secondary text-uppercase small">
                                    <i class="fa fa-signature me-2 text-primary"></i>Signature
                                </div>
                                <button class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
                                    onclick="imgSignUpload('sign')">
                                    <i class="fa fa-upload"></i>
                                    <span class="d-none d-sm-inline">Upload</span>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body p-2 text-center">
                            <div class="bg-light rounded-3 p-2 border">
                                <img class="img-fluid"
                                    style="max-height:160px; object-fit:contain;"
                                    src="<?php
                                            if ($basicInfo->uid != ""):
                                                echo base_url() . 'uploads/sign/' . $basicInfo->signature_img;
                                            else:
                                                echo base_url() . 'uploads/noImage.png';
                                            endif;
                                            ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="academicInformation">
            <?php
            $data['basicInfo'] = $basicInfo;
            $data['edHis'] = $edHis;
            $this->load->view('academicInformation', $data);
            ?>
        </div>

        <div class="tab-pane fade" id="statutory">
            <?php
            $data['salaryType'] = Modules::run('hr/getSalaryType');
            $data['basicInfo'] = $basicInfo;
            $this->load->view('statutoryInformation', $data);
            ?>
        </div>

        <div class="tab-pane fade" id="dtr">
            <?php echo Modules::run('hr/dtr', base64_encode($basicInfo->employee_id), base64_encode($basicInfo->uid)); ?>
        </div>

        <div class="tab-pane fade" id="od_info">
            <?php
            $data['basicInfo'] = $basicInfo;
            $data['deductions'] = Modules::run('hr/payroll/getOD_list');
            $data['paymentTerms'] = Modules::run('hr/payroll/getPaymentTerms');
            $data['myLoans'] = Modules::run('hr/payroll/loanAmortization', $basicInfo->employee_id, 0);
            $this->load->view('loans_deductions', $data);
            ?>
        </div>
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

<input type="hidden" id="employeeID" value="<?php echo $basicInfo->user_id ?>" />
<input type="hidden" id="leaveDaysCredited" value="<?php echo $dlCredited ?>" />
<input type="hidden" id="totalHoursRendered" value="<?php echo round(($totalMin / 60), 2) + $totalHours ?>" />
<input type="hidden" id="hoursRequired" value="<?php echo $hoursRequired ?>" />
<!--<input type="hidden" id="minutesTardy" value="<?php echo abs(date('H', mktime(0, $totalHours))) ?>" />-->
<!-- <input type="hidden" id="minutesTardy" value="<?php // echo date('i', $overAllTardy) 
                                                    ?>" /> -->
<input type="hidden" id="minutesTardy" value="<?php echo date('i', $under) ?>" />
<input type="hidden" id="otTime" />

<script type="text/javascript">
    const csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
    let csrfHash = "<?= $this->security->get_csrf_hash(); ?>";
    const BASE_URL = "<?= base_url() ?>";

    $(function() {

        $('#totalHoursRequired').text($('#hoursRequired').val())

        $('[data-toggle="popover"]').popover({
            container: 'body',
            html: true,
            trigger: 'click',
            content: function() {
                const target = $(this).data('popover-target');
                return $(target).html();
            }
        });

        // Close on outside click
        $(document).on('click', function(e) {
            $('[data-toggle="popover"]').each(function() {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    });

    // existing mapped positions for this employee (all departments)
    var existingPositions = <?php
                            $positionIds = array();
                            $primaryPositionId = isset($basicInfo->position_id) ? (int) $basicInfo->position_id : 0;
                            if (isset($employeePositions) && is_array($employeePositions)) {
                                foreach ($employeePositions as $ep) {
                                    $positionIds[] = (int) $ep->position_id;
                                    if (isset($ep->is_primary) && (int) $ep->is_primary === 1) {
                                        $primaryPositionId = (int) $ep->position_id;
                                    }
                                }
                            }
                            echo json_encode($positionIds);
                            ?>;
    var primaryPositionId = <?php echo (int) $primaryPositionId; ?>;

    $(document).ready(function() {
        $(".clickover").clickover({
            placement: 'right',
            html: true
        });
        $('#submitSign').click(function() {
            $('#uploadSign').submit();
        })

        $("#major").select2({
            tags: [
                <?php
                foreach ($minmaj as $mm):
                    echo '\'' . $mm->maj_min . '\'' . ',';
                endforeach;
                ?>
            ],
            closeOnSelect: true,
            maximumSelectionSize: 1
        });
        $("#minor").select2({
            tags: [
                <?php
                foreach ($minmaj as $mm):
                    echo '\'' . $mm->maj_min . '\'' . ',';
                endforeach;
                ?>
            ],
            closeOnSelect: true,
            maximumSelectionSize: 1
        });

    });
    $('#profile_tab a').click(function(e) {
        e.preventDefault()
        $(this).tab('show')
    });

    function saveMobile(user_id, mobile_no, column) {
        var url = "<?php echo base_url() . 'hr/saveContacts/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'user_id=' + user_id + '&mobile_no=' + mobile_no + '&column=' + 'cd_' + column + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#a_' + column).html(mobile_no)
                alert('Successfully Updated ' + data);
            }
        })
    }

    function deleteEducBac(id) {
        var rsure = confirm("Are you Sure You Want to delete this information from the list? Warning: You can't undo this action");
        if (rsure == true) {
            var url = "<?php echo base_url() . 'hr/deleteEducBak/' ?>" + id; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: '' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    alert(data);
                    location.reload()
                }
            });

            return false;
        } else {
            location.reload();
        }
    }


    function saveMinMaj(value, id, majmin) {
        var url = "<?php echo base_url() . 'hr/saveMinMaj/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: 'id=' + id + '&value=' + value + '&maj_min=' + majmin + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                alert(data)
                $('#major_wrapper').addClass('hide')
                $('#a_major').show();
            }

        });
        return false;
    }

    function setCity(id) {
        const sel = document.getElementById('city');
        sel.value = id;

        getProvince(id);
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

    function editId_number(idNum, id) {
        var editedIdNum = $('#input_' + id).val();
        var url = "<?php echo base_url() . 'hr/editIdNumber/' ?>"
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

    function getPosition() {
        var department_id = document.getElementById("editDepartment").value;
        var url = "<?php echo base_url() . 'hr/getPosition/' ?>" + department_id; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "dept_id=" + department_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$('#Pos').show();
                document.getElementById("inputPosition").innerHTML = data
            }
        });

        return false;
    }

    function saveDepartment() {
        var userId = '<?php echo $basicInfo->uid; ?>';
        var employeeId = '<?php echo $basicInfo->employee_id; ?>';
        var selectedPositions = $('#inputPosition').val() || [];
        // merge new selections with existing positions (so we don't drop those from other departments)
        var combined = existingPositions.slice(0);
        for (var i = 0; i < selectedPositions.length; i++) {
            if (combined.indexOf(selectedPositions[i]) === -1) {
                combined.push(selectedPositions[i]);
            }
        }
        var dept = $('#editDepartment').val();

        // Keep current primary if set; otherwise use first newly-selected
        var primaryPosition = primaryPositionId ? primaryPositionId : (selectedPositions.length ? selectedPositions[0] : '');
        var urlProfile = "<?php echo base_url() . 'users/editProfile/' ?>";

        $.ajax({
            type: "POST",
            url: urlProfile,
            dataType: 'json',
            data: 'id=' + userId +
                '&csrf_test_name=' + $.cookie('csrf_cookie_name') +
                '&column=position_id&value=' + primaryPosition +
                '&tbl=<?php echo base64_encode('esk_profile_employee') ?>&pk=<?php echo base64_encode('user_id') ?>',
            success: function(data) {
                // After primary position is saved, persist full list into mapping table
                var urlMap = "<?php echo base_url() . 'hr/saveEmployeePositions' ?>";
                $.ajax({
                    type: "POST",
                    url: urlMap,
                    dataType: 'json',
                    data: {
                        employee_id: employeeId,
                        user_id: userId,
                        positions: combined,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function(resp) {
                        // refresh page to reflect updated positions
                        location.reload();
                    }
                });
            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    function activateEmployeePosition(employee_id, position_id, user_id, dept_id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() . 'hr/updateEmployeePosition' ?>',
            dataType: 'json',
            data: {
                employee_id: employee_id,
                positions: position_id,
                user_id: user_id,
                department_id: dept_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(res) {
                location.reload();
            }
        })
    }

    function deleteEmployeePosition(employeeId, positionId) {
        if (!confirm('Are you sure you want to remove this position?')) {
            return false;
        }
        var url = "<?php echo base_url() . 'hr/deleteEmployeePosition' ?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                employee_id: employeeId,
                position_id: positionId,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(resp) {
                location.reload();
            }
        });
        return false;
    }

    function updateAccountProfile(dept = NULL) {
        var pk_id = '<?php echo $basicInfo->uid; ?>';
        var value = dept
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=account_type&value=' + value + '&tbl=<?php echo base64_encode('esk_profile') ?>&pk=<?php echo base64_encode('user_id') ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                updateAccounts(dept);

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    function updateAccounts(dept = NULL) {
        var pk_id = '<?php echo $basicInfo->employee_id; ?>';
        var value = dept
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=utype&value=' + value + '&tbl=<?php echo base64_encode('esk_user_accounts') ?>&pk=<?php echo base64_encode('u_id') ?>' + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                // location.reload();

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    function updateProfile(keyCard, pk, table, pk_id, column, value, id) {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>";
        const card = document.getElementById(keyCard + '_card');
        const textDiv = document.getElementById(keyCard + '_text');

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (data.status) {

                    // 🔹 Replace displayed value
                    if (textDiv) {
                        textDiv.textContent = value ? value : '[empty]';
                    }

                    // 🔹 Exit edit mode
                    if (typeof ieCancel === 'function') {
                        ieCancel(keyCard);
                    }

                    if (onSuccess) onSuccess(res);

                } else {
                    alert(res.message || 'Update failed.');
                }

                unlockCard(card);

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    function saveBasicInfoModal() {
        editBasicInfo(); // your existing function

        const modal = bootstrap.Modal.getInstance(
            document.getElementById('basicInfoModal')
        );
        modal.hide();
    }

    function editBasicInfo() {
        var url = "<?php echo base_url() . 'hr/editBasicInfo/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'lastname=' + $('#lastname').val() + '&firstname=' + $('#firstname').val() + '&middlename=' + $('#middlename').val() + '&rowid=' + $('#rowid').val() + '&user_id=' + $('#st_user_id').val() + '&pos=' + $('#pos').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()

                $('#name').html(data);
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
            data: 'street=' + $('#street').val() + '&user_id=' + $('#address_user_id').val() + '&barangay=' + $('#barangay').val() + '&city=' + $('#city').val() + '&province=' + $('#inputPID').val() + '&address_id=' + '<?php echo $basicInfo->user_id ?>' + '&zip_code=' + $('#zip_code').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()

                location.reload();
            }
        });

        return false;
    }

    function editEmployeeInfo() {
        var st_id = $('#st_id').val();
        var url = "<?php echo base_url() . 'hr/editEmployeeInfo/' ?>" + st_id; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'sss=' + $('#editSSS').val() + '&philHealth=' + $('#editPhilHealth').val() + '&pag_ibig=' + $('#editPag_ibig').val() + '&tin=' + $('#editTIN').val(), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                location.reload();
                //$('#address_span').html(data);
            }
        });

        return false;
    }

    function editAcademicInfo() {
        var course_id = $('#courseId').val();
        var school_id = $('#collegeId').val();
        var t_id = $('#t_id').val();
        var url = "<?php echo base_url() . 'hr/editAcademicInfo/' ?>"
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'course_id=' + course_id + '&school_id=' + school_id + '&t_id=' + t_id, // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                location.reload();
                //$('#address_span').html(data);
            }
        });

        return false;

    }

    function editBdate(cal_id, owner) {
        var url = "<?php echo base_url() . 'calendar/editBdate/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'bDate=' + cal_id + '&owner=' + owner + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                $('#a_bdate').show()
                $('#bdate').hide()
                $('#a_bdate').html(cal_id)

            }
        });

        return false;
    }

    function savePtype(keyCard) {
        var url = "<?php echo base_url() . 'hr/savePtype/' ?>"; // the script where you handle the form input.
        var payType = $('#ptype_input').val()
        var id = $('#em_id').val()

        const card = document.getElementById(keyCard + '_card');
        const textDiv = document.getElementById(keyCard + '_text');
        const typeLabel = document.getElementById(keyCard + '_input');
        const selected = typeLabel.options[typeLabel.selectedIndex].text;
        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'em_id=' + id + '&payroll_type=' + payType + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (textDiv) {
                    textDiv.textContent = payType ? selected : '[empty]';
                }

                // 🔹 Exit edit mode
                if (typeof ieCancel === 'function') {
                    ieCancel(keyCard);
                }

                unlockCard(card)
            }
        });

        return false;
    }

    function saveSG(keyCard) {
        var url = "<?php echo base_url() . 'hr/saveSG/' ?>"; // the script where you handle the form input.
        var salary = $('#' + keyCard + '_input').val()
        var id = $('#em_id').val()

        const card = document.getElementById(keyCard + '_card');
        const textDiv = document.getElementById(keyCard + '_text');
        const typeLabel = document.getElementById(keyCard + '_input');
        const selected = typeLabel.options[typeLabel.selectedIndex].text;

        $.ajax({
            type: "POST",
            url: url,
            //dataType: 'json',
            data: 'em_id=' + id + '&salary_grade=' + salary + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (textDiv) {
                    textDiv.textContent = salary ? selected : '[empty]';
                }

                // 🔹 Exit edit mode
                if (typeof ieCancel === 'function') {
                    ieCancel(keyCard);
                }

                unlockCard(card)
            }
        });

        return false;
    }

    function searchCourse(value) {
        var url = "<?php echo base_url() . 'hr/searchCourse/' ?>"; // the script where you handle the form input.
        if (value == "") {
            $('#courseSearch').hide();
            $('#course_id').val('0');
        } else {
            $.ajax({
                type: "POST",
                url: url,
                data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#courseSearch').show();
                    $('#courseSearch').html(data);
                }
            });

            return false;
        }

    }

    function searchSchool(value) {
        var url = "<?php echo base_url() . 'hr/searchCollege/' ?>"; // the script where you handle the form input.
        if (value == "") {
            $('#collegeSearch').hide();
            $('#collegeId').val('0');
        } else {
            $.ajax({
                type: "POST",
                url: url,
                data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    $('#collegeSearch').show();
                    $('#collegeSearch').html(data);
                }
            });

            return false;
        }

    }

    function saveGender() {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var table = '<?php echo base64_encode('esk_profile') ?>'
        var pk = '<?php echo base64_encode('user_id') ?>'
        var st_id = '<?php echo $basicInfo->uid ?>'
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
    /*
     $(document).ready(function(){
     $('#imgCrop').click(function(){
     $('#picture_option').val($(this).data('id'));
     $('#imgUpload').modal('show');
     })
     })
     */
    function imgSignUpload(id) {
        $('#stdUID').val($('#empUserID').val());
        $('#picture_option').val(id);
        $('#imgUpload').modal('show');
    }

    function updatePassword() {
        var sKey = '<?php echo $basicInfo->secret_key ?>';
        var oldPass = $('#oldPass').val();
        var newpass = $('#newPass').val();
        var confirmpass = $('#confirmPass').val();
        var emp_id = '<?php echo base64_encode($basicInfo->employee_id) ?>';
        //        alert(sKey + ' ' + oldPass + ' ' + newpass + ' ' + confirmpass);

        if (sKey == oldPass) {
            if (newpass == '') {
                errorMsg('New Password is empty!!!');
            } else {
                if (newpass != confirmpass) {
                    errorMsg('Password did not match!!!');
                } else {
                    $('#passChange').hide();
                    var url = '<?php echo base_url() . 'hr/changePass' ?>';

                    $.ajax({
                        type: 'POST',
                        data: 'emp_id=' + emp_id + '&newpass=' + newpass + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                        url: url,
                        success: function(data) {
                            alert('Password Successfuly change!!!');
                            location.reload();
                        }
                    });
                }
            }
        } else {
            errorMsg('Old Password entered is incorrect!!!');
        }

    }

    function errorMsg(msg) {
        $('#errorMsg').show().delay(5000).queue(function(n) {
            $(this).hide();
            n();
        });
        $('#errorMsg').text(msg);
    }

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

        const user_id = $('#employeeID').val();
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

        console.log(payload);

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
                } else {
                    alert('Update failed.');
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
        ieLockOthers(name);

        const card = document.getElementById(name + '_card');
        card.style.zIndex = 10; // keep on top

        $('#' + name + '_text').hide();
        $('#' + name + '_inputWrap').removeClass('d-none').addClass('ie-input-area');
        $('#' + name + '_btn_edit').hide();
        $('#' + name + '_btn_group').removeClass('d-none').addClass('ie-btn-area');

        $('#' + name + '_inputWrap').find('input,select').first().focus();
    }

    function ieCancel(name) {
        const card = document.getElementById(name + '_card');
        card.style.zIndex = '';

        $('#' + name + '_text').show();
        $('#' + name + '_inputWrap').addClass('d-none').removeClass('ie-input-area');
        $('#' + name + '_btn_edit').show();
        $('#' + name + '_btn_group').addClass('d-none').removeClass('ie-btn-area');

        ieUnlockAll();
    }

    //========================================================= Overtime Pay ==========================================================================================//

    $(document).on("click", ".timeOvr", function() {
        var otID = this.id;
        var arrOt = [];
        arrOt = otID.split('-');
        var time = [$('#otTime').val()];

        if (arrOt[1] != 0) {
            if ($('#' + otID).hasClass('highlight')) {
                $('#' + otID).removeClass('highlight');
                removeItem(otID);
            } else {
                $('#' + otID).addClass('highlight');
                $('#' + otID).css('background', 'greenyellow');
                time.push(otID);
                $('#otTime').val(time);
            }
        }
    });

    function removeItem(value) {
        var arrTime = $('#otTime').val();
        var arr = [];
        var id = [];
        var del = [];
        arr = arrTime.split(',');
        var index = arr.indexOf(value);
        if (index > -1) {
            arr.splice(index, 1);
        }
        $('#otTime').val(arr);
    }

    function saveOT(emp_id) {
        var url = '<?php echo base_url() . 'hr/payroll/saveOverTime' ?>';
        var ot = [$('#otTime').val()];

        $.ajax({
            type: 'POST',
            url: url,
            data: 'details=' + ot + '&emp_id=' + emp_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                console.log(data);
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
        position: relative;
        min-height: 120px;
        /* adjust based on tallest non-edit state */
    }

    /* Prevent layout shift when editing */
    .info-card .ie-input-area {
        position: absolute;
        left: 16px;
        right: 16px;
        top: 44px;
        /* below label/value */
        z-index: 5;
    }

    /* Ensure buttons stay aligned but not push layout */
    .info-card .ie-btn-area {
        position: absolute;
        right: 0px;
        top: 0px;
        z-index: 6;
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
        width: 32px;
        height: 32px;
        border: none;
        background: #e9f2ff;
        border-radius: 50%;
        color: #4f46e5;
        padding: 4px 10px;
        font-size: .8rem;
    }

    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        /* consistent square buttons */
        height: 25px;
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

    .highlight {
        background: greenyellow;
    }
</style>