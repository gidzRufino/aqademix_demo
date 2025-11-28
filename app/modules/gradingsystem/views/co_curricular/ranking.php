<?php
    $data['grade_id'] = $this->uri->segment(4);
    $this->load->view('finalTops', $data) ?>
<h4 class="text-center">Matrix on Co Curricular Performance</h4>
<table class="table table-bordered table-stripped">
    <tr>
        <td class="text-center col-lg-2"rowspan="2">Candidate</td>
        <td class="text-center" colspan="5">Area / Activity</td>
        <td class="text-center" rowspan="2">Total</td>
        <td class="text-center" rowspan="2">Rank</td>
        <td class="text-center" rowspan="2">Weighted Rank</td>
    </tr>
    <tr>
        <td class="text-center">Contest and Competition</td>
        <td class="text-center">Student Leadership</td>
        <td class="text-center">Campus Journalism</td>
        <td class="text-center">Officership and Membership</td>
        <td class="text-center">Participation and Attendance</td>
        
    </tr>
    <?php
        $cc_points = 0;
        $sl_points = 0;
        $cj_points = 0;
        $om_points = 0;
        $pa_points = 0;
        foreach ($names as $r ):
            $rank = json_decode(Modules::run('gradingsystem/co_curricular/getCCRaw', $r->stid));
    ?>
    <tr>
        <td><?php echo strtoupper($r->lastname.', '.$r->firstname) ?></td>
        <td class="text-center">
            <?php
                foreach ($rank->cc as $cc):
                     $cc_points += $cc->points;
                endforeach;
                echo number_format($cc_points,2);
            ?>
        </td>
        <td class="text-center">
            <?php
                foreach ($rank->sl as $sl):
                     $sl_points += $sl->points;
                endforeach;
                echo number_format($sl_points,2);
            ?>
        </td>
        <td class="text-center">
            <?php
                foreach ($rank->cj as $cj):
                     $cj_points += $cj->points;
                endforeach;
                echo number_format($cj_points,2);
            ?>
        </td>
        <td class="text-center">
            <?php
                foreach ($rank->om as $om):
                     $om_points += $om->points;
                endforeach;
                echo number_format($om_points,2);
            ?>
        </td>
        <td class="text-center">
            <?php
                foreach ($rank->pa as $pa):
                     $pa_points += $pa->points;
                endforeach;
                echo number_format($pa_points,2);
            ?>
        </td>
        <td class="text-center">
               <?php 
                    $total = $cc_points+$sl_points+$cj_points+$om_points+$pa_points;
                    $rlist = Modules::run('gradingsystem/co_curricular/saveTotalCC', $r->stid, $total, $r->grade_level_id);
                    echo number_format($total,2);
               ?>
        </td>
        <td class="text-center">
            <?php
                echo $rlist->rank;
            ?>
        </td>
        <td class="text-center">
            <?php
                echo $rlist->weighted_rank;
            ?>
        </td>
        
    </tr>
    <?php
            
            unset($cc_points);
            unset($sl_points);
            unset($cj_points);
            unset($om_points);
            unset($pa_points);
        
        endforeach;
    ?>
</table>
<br />
<?php 

echo Modules::run('gradingsystem/gs_tops/getFinalTopTen', $this->uri->segment(4), $this->session->userdata('school_year'));