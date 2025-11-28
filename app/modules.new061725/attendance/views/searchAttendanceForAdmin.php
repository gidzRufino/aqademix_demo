<?php
foreach ($section->result() as $sec):
    $data = array(
        'date' => $date,
        'section' => $sec->section_id
    );
    echo Modules::run('widgets/getWidget', 'attendance_widgets', 'attendancePerformance', $data);

endforeach;
