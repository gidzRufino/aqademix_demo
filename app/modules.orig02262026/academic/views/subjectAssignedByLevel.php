<div class='col-lg-12 no-padding'>
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h5 class="text-center no-margin col-lg-12">Subjects Assigned</h5>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Grade Level</th>
                    <th>Section</th>
                    <th>Schedule</th>
                </tr>
                <tbody id="subjectsAssignedTable">
                    <?php
                    $i = 1;
                    //print_r($assignment);
                    foreach ($assignment->result() as $as): ?>
                    <tr id="as_<?php echo $as->ass_id ?>">
                        <td><?php echo $i++ ?></td>
                        <td><?php echo strtoupper($as->firstname.' '.$as->lastname) ?></td>
                        <td><?php echo $as->subject ?></td>
                        <td><?php echo $as->level ?></td>
                        <td><?php echo $as->section ?></td>
                        <td>COMING SOON</td>
                       
                    </tr>
                    <?php endforeach; ?> 
                </tbody>
                
            </table>
        </div>
    </div>
</div>