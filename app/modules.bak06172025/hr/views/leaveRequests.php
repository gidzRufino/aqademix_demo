<h4>Leave Requests</h4>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Name of Employee</th>
        <th>Date of Leave</th>
        <th>Reason</th>
        <th>Duration</th>
        <th>Date Requested</th>
        <th>Date Approved</th>
        <th>Status</th>
    </tr>
    <?php
    $t = 1;
    foreach ($leave as $l): ?>
        <tr>
            <td><?php echo $t++; ?></td>
            <td><?php echo $l->firstname . ' ' . $l->lastname ?></td>
            <td><?php echo $l->pld_date ?></td>
            <td><?php echo $l->pld_reason_of_leave ?></td>
            <td><?php echo ($l->pld_num_hours == 8 ? 'Whole Day' : 'Half Day'); ?></td>
            <td><?php echo date('Y-m-d', strtotime($l->pld_date_filed)) ?></td>
            <td><?php echo date('Y-m-d') ?></td>
            <td class="text-center" id="td-<?php echo $l->pld_id ?>">
                <?php if ($l->pld_is_approved): ?>
                    <span style="color: green" class="clickover pointer" rel="clickover" data-content="<button class='btn btn-sm btn-warning' onclick='leaveUpdate(<?php echo $l->pld_id ?>, 0, 3)'><i class='fa fa-undo'></i> Revert Action</button>"><i class="fa fa-thumbs-up"></i> Leave Approved</span>;
                    <?php else:
                    if ($l->pld_approve_by != ''): ?>
                        <span style="color: red" class="clickover pointer" rel="clickover" data-content="<button class='btn btn-sm btn-warning' onclick='leaveUpdate(<?php echo $l->pld_id ?>, 0, 3)'><i class='fa fa-undo'></i> Revert Action</button>"><i class="fa fa-thumbs-down"></i> Leave Rejected!</span>;
                    <?php else: ?>
                        <span>
                            <button class="btn btn-xs btn-success" title="Approve?" onclick="leaveUpdate('<?php echo $l->pld_id ?>', 1, 1)"><i class="fa fa-thumbs-up fa-sm"></i></button>
                            <button class="btn btn-xs btn-danger" title="Reject?" onclick="leaveUpdate('<?php echo $l->pld_id ?>', 0, 2)"><i class="fa fa-thumbs-down fa-sm"></i></button>
                        </span>
                <?php
                    endif;
                endif;
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
    $(document).ready(function() {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });
    })
</script>