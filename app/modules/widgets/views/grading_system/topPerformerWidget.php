<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5><?php echo $subject ?></h5>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th class="text-center">Rank</th>
                    <th>Student</th>
                    <th class="text-center">Grade</th>
                </tr>
            <?php 
                $r = 1;
                
                foreach($topTen as $tt=>$gt):
             ?>
                <tr>
                    <td class="text-center"><?php echo $r++; ?></td>
                    <td><?php echo $gt->st_id.' '. strtoupper($gt->lastname).', '.$gt->firstname ?></td>
                    <td class="text-center"><?php echo $gt->total ?></td>
                </tr>
                
             <?php
                endforeach;
            ?>
            </table>
        </div>
    </div>
</div>