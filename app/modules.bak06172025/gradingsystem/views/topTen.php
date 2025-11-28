<h4 class="text-center">Matrix on Academic Performance</h4>
<table class="table table-bordered">
    <tr>
        <td class="text-center col-lg-2">Name of Candidate</td>
        <td class="text-center">Average of Grades</td>
        <td class="text-center">Rank</td>
        <td class="text-center">Weighted Rank</td>
    </tr>
    <?php
        $i=0;
        foreach ($finalTops->result() as $f):
            $i = $i+1
    ?>
    <tr>
        <td class="text-center col-lg-2"><?php echo strtoupper($f->lastname.', '.$f->firstname) ?></td>
        <td class="text-center"><?php echo number_format(round($f->final_rating, 3),3); ?></td>
        <td class="text-center"><?php echo $i; ?></td>
        <td class="text-center"><?php echo $i*7; ?></td>
    </tr>
    
    <?php
        endforeach;
    ?>
</table>
<?php
