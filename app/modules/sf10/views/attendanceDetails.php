<?php
$settings = Modules::run('main/getSet');
$gs_start = date('m', strtotime($settings->bosy));
$gs_end = date('m', strtotime($settings->eosy));
$gsDays = Modules::run('reports/getRawSchoolDays', $sy, 2);
$totalDays = 0;
?>

<!-- Bootstrap 5 Attendance Card -->
<div class="container-fluid mb-3">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success text-white rounded-top-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">
                    <i class="fa fa-calendar-check me-2"></i>
                    Attendance Record
                </h5>

                <button class="btn btn-light btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#attendanceOveride<?php echo $semester ?>"
                        id="addAttendance2">
                    <i class="fa fa-clock-o me-1"></i> Override
                </button>
            </div>
        </div>

        <div class="card-body">

            <!-- ================= SCHOOL DAYS ================= -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th colspan="12" class="fw-bold">
                                Number of School Days
                                <small id="confirmMsg" class="text-info ms-2"></small>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="table-light fw-semibold">
                            <?php
                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                            ?>
                                <td><?php echo $monthName ?></td>
                            <?php
                                $totalDays += $gsDays->$monthName;
                            endfor;
                            ?>
                        </tr>

                        <tr>
                            <?php
                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                            ?>
                                <td>
                                    <span class="badge bg-success-subtle text-success-emphasis fs-6">
                                        <?php echo ($attendanceDetails ? $attendanceDetails->row()->$monthName : 0) ?>
                                    </span>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ================= TARDY ================= -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-warning">
                        <tr>
                            <th colspan="12" class="fw-bold">
                                Number of Times Tardy
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="table-light fw-semibold">
                            <?php
                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                            ?>
                                <td><?php echo $monthName ?></td>
                            <?php endfor; ?>
                        </tr>

                        <tr>
                            <?php
                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
                                $m = $i;
                                $n = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                            ?>
                                <td class="overideTardy fw-bold" id="<?php echo $monthName ?>">
                                    <?php echo ($attendaceTardy ? $attendaceTardy->$monthName : 0) ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="attMsg" class="alert alert-info mt-3 d-none"></div>

        </div>
    </div>
</div>


<!-- ================= EDIT STYLE ================= -->
<style>
.cellEditing {
    padding: 0 !important;
}
.cellEditing input {
    width: 60px;
    height: 34px;
    text-align: center;
    border-radius: 8px;
    border: 1px solid #0d6efd;
}
.overideTardy {
    cursor: pointer;
}
</style>


<!-- ================= JS (Bootstrap 5 safe) ================= -->
<script>
$(function () {

    $(".overideTardy").on('dblclick', function () {
        const cell = $(this);
        const OriginalContent = cell.text().trim();
        const month = cell.attr('id');

        cell.addClass("cellEditing");
        cell.html("<input type='number' min='0' class='form-control form-control-sm text-center' value='" + OriginalContent + "'>");

        const input = cell.children().first();
        input.focus();

        input.on('keypress', function (e) {
            if (e.which === 13) {
                const newContent = $(this).val();

                const sprid = '<?php echo $attendaceTardy->spr_id ?>';
                const st_id = '<?php echo $st_id ?>';
                const sy = '<?php echo $school_year ?>';
                const sem = '<?php echo $sem ?>';

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'sf10/saveTardy/' ?>',
                    beforeSend: function () {
                        $('#confirmMsg').html('<span class="spinner-border spinner-border-sm"></span>');
                    },
                    data: {
                        value: newContent,
                        spr_id: sprid,
                        st_id: st_id,
                        month: month,
                        school_year: sy,
                        semester: sem,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (result) {
                        $('#attMsg')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-info')
                            .text('Alert: ' + result)
                            .fadeIn()
                            .delay(4000)
                            .fadeOut();
                        $('#confirmMsg').html('');
                    }
                });

                cell.text(newContent).removeClass("cellEditing");
            }
        });

        input.on('blur', function () {
            cell.text(OriginalContent).removeClass("cellEditing");
        });
    });

});
</script>
