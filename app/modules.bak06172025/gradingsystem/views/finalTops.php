<script type="text/javascript">
      $(function() {
			$("#tableSort").tablesorter({debug: true});
		});  
    </script>
<h4 class="text-center">Final Ranking</h4>
<table  id="tableSort" class="tablesorter table table-bordered">
    <thead>
          <tr>
            <td class="text-center col-lg-2">Name of Candidate</td>
            <td class="text-center">Academic Excellence</td>
            <td class="text-center">Co-Curricular Performance</td>
            <td class="text-center">Total</td>
            <th class="text-center" style="font-size:18px; font-weight: bold;">Rank</th>
        </tr>  
    </thead>
    <tbody>
        <?php
            $i=0;
            $finalTops = Modules::run('gradingsystem/gs_tops/getFinalTops', $grade_id, $this->session->userdata('school_year'));
            foreach ($finalTops->result() as $f):
                $i = $i+1;
                $acad_rank = $i*7;
                $cc = Modules::run('gradingsystem/co_curricular/getIndividualRank', $f->stid, $this->session->userdata('school_year') );
                if($cc->weighted_rank!=0): 
                    $cc_rank =  $cc->weighted_rank; 
                else: 
                    $cc_rank = 30; 
                endif;

        ?>
        <tr>
            <td class="text-center col-lg-3"><?php echo strtoupper($f->lastname.' '.$f->firstname) ?></td>
            <td class="text-center col-lg-2"><?php echo $acad_rank; ?></td>
            <td class="text-center col-lg-2"><?php echo $cc_rank?></td>
            <td class="text-center"><?php echo ($acad_rank)+($cc_rank); ?></td>
            <?php $finalRank = Modules::run('gradingsystem/gs_tops/saveFinalRank', $f->stid, ($acad_rank)+($cc_rank), $f->grade_level_id, $this->session->userdata('school_year') ); ?>
            <td class="text-center"  style="font-size:18px; font-weight: bold;"><?php echo $finalRank->rank?></td> 
        </tr>

        <?php
            unset($acad_rank);
            endforeach;
        ?>
    </tbody>
    
</table>
<?php
