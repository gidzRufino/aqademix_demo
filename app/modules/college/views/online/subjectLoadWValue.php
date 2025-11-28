<div class="col-lg-12 no-padding">
    <h6 class="no-margin text-left">
        Legend :
        &nbsp; &nbsp; <button class="btn btn-success btn-xs" disabled><i class="fa fa-search"></i></button> - search schedule
        &nbsp; &nbsp; <button class="btn btn-warning btn-xs" disabled><i class="fa fa-minus"></i></button> - clear schedule
        &nbsp; &nbsp; <button class="btn btn-danger btn-xs" disabled><i class="fa fa-trash"></i></button> - remove subject
        &nbsp; &nbsp; <button class="btn btn-info btn-xs" disabled=""><i class="fa fa-search-plus"></i></button> - add subject
    </h6><br/>
    <table class="table table-striped table-bordered table-responsive" id="tableSched">
        <tr>
            <th>Subject</th>
            <th>Day / Time</th>
            <th>Instructor</th>
            <th>Units</th>
        </tr>
        <tbody id="subjectLoadBody">
            <?php
            $totalUnits = 0;
            foreach ($subjects as $s):
                ?>
                <tr class="trSched"
                    id="tr_<?php echo $s->s_id ?>"
                    sec_id="" time_from="" time_to="" day="" tchr=""
                    sub_code="<?php echo $s->sub_code ?>"
                    >
                    <td><?php echo strtoupper($s->sub_code) ?></td>
                    <td class="hasValue" id="daytime_<?php echo $s->s_id ?>">
                        <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->cl_section, $semester, $school_year); 
                                $sched = json_decode($scheds);
                                echo ($sched->count > 0 ? $sched->time.' [ '.$sched->day.' ]':'TBA');
                                $totalUnits += ($s->sub_code=="NSTP 11" || $s->sub_code=="NSTP 12"|| $s->sub_code=="NSTP 1"|| $s->sub_code=="NSTP 2"?3:$s->s_lect_unit + $s->s_lab_unit);
                            ?>
                    </td>
                    <td class="hasValue" id="instructor_<?php echo $s->s_id ?>">'<?php echo strtoupper($sched->instructor) ?>'</td>
                    <td class="hasValue" id="units_<?php echo $s->s_id ?>">
                        <?php echo ($s->sub_code=="NSTP 11" || $s->sub_code=="NSTP 12"|| $s->sub_code=="NSTP 1"|| $s->sub_code=="NSTP 2"?3:$s->s_lect_unit + $s->s_lab_unit) ?>
                    </td>
                </tr>


                <?php
            endforeach;
            ?>
        </tbody>
        <tfoot>
            <tr class="info">
                <td>TOTAL UNITS</td>
                <td></td>
                <td></td>
                <td id="totalUnits"><?php echo $totalUnits ?></td>
            </tr>
            <tr>
                <td colspan="4" class="warning text-center"><i class="fa fa-info fa-fw" ></i>&nbsp;&nbsp;<?php echo $msg ?></td>
                
            </tr>
            <?php if($admissionRemarks): ?>
            <tr>
                <td colspan="4" class="danger text-center">Admission Remarks</td>
                
            </tr>
            <tr>
                <td colspan="4" class="info text-center"><i class="fa fa-info fa-fw" ></i>&nbsp;&nbsp;<?php echo $admissionRemarks->remarks ?></td>
                
            </tr>
            <?php endif; ?>
        </tfoot>

    </table>
</div>



