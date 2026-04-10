<?php
$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $this->session->details->admission_id, NULL, $school_year);

?>
<section class="col-lg-12 col-md-12">
    <div class="card card-blue card-outline">
        <table class="table table-stripped">
            <tr>
                <th class="text-center">Subject Code</th>
                <th class="text-center col-lg-6">Description</th>
                <th class="text-center">Schedule</th>
                <th class="text-center">Units</th>
                <th class="text-center">Teacher</th>
            </tr>
            <?php
            $count = count($loadedSubject);
            $aprv = 0;
            foreach ($loadedSubject as $ls):
                ?>
                <tr class="pointer" id="trtaken_<?php echo $ls->s_id ?>" 
                    onclick="document.location='<?php echo base_url('opl/college/classBulletin/').$ls->cl_sub_id.'/'.$ls->cl_section.'/'.$ls->sec_sem.'/'.$school_year ?>'"
                    >
                    <td class="text-center"><?php echo $ls->sub_code ?></td>
                    <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                    <td class="text-center">
                        <?php
                        $scheds = Modules::run('college/schedule/getSchedulePerSection', $ls->cl_section, $ls->sec_sem, $school_year);

                        $sched = json_decode($scheds);
                        echo ($sched->count > 0 ? $sched->time . ' [ ' . $sched->day . ' ]' : 'TBA');
                        ?>
                    </td>
                    <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo $ls->s_lect_unit ?></td>
                    <td><?php echo ucwords(strtolower($sched->instructor)) ?></td>

                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</section>


