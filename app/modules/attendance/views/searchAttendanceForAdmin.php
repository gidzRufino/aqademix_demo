<?php
// foreach ($section->result() as $sec):
//     $data = array(
//         'date' => $date,
//         'section' => $sec->section_id
//     );
//     echo Modules::run('widgets/getWidget', 'attendance_widgets', 'attendancePerformance', $data);

// endforeach;
?>
<div id="attPerformance" class="row g-4">
                    <?php foreach ($section->result() as $sec):
                        $data = ['date' => $date, 'section' => $sec->section_id, 'grade' => $sec->grade_id];
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="card shadow-sm h-100 border-0 pointer hover-shadow" 
                            onclick="//getAttendanceProgress('<?= $sec->section_id ?>','<?= strtoupper($sec->level) ?>','<?= strtoupper($sec->section) ?>')">
                            
                            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                <i class="fa fa-chart-line fs-5"></i>
                                <span class="fw-semibold small text-uppercase">Attendance &mdash; <?= strtoupper($sec->level) ?> - <?= strtoupper($sec->section) ?></span>
                            </div>
                            
                            <div class="card-body p-3">
                                <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'attendancePerformance', $data); ?>
                            </div>
                            
                            <div class="card-footer bg-light text-center py-2">
                                <a href="<?= base_url(); ?>attendance/dailyPerSubject/NULL/<?= $sec->section_id ?>/<?= $date ?>" class="text-decoration-none fw-semibold small">
                                    <?= strtoupper($sec->level) ?> - <?= strtoupper($sec->section) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>