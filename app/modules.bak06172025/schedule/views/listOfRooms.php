<div class="panel panel-yellow" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <h4>List of Rooms</h4>
        </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:60px;">Rm ID</th>
                    <th>Room</th>
                    <th>Room Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($rooms as $r):
                ?>
                <tr>
                    <td class="text-center"><?php echo $r->rm_id ?></td>
                    <td><?php echo $r->room ?></td>
                    <td><?php echo $r->rm_desc ?></td>
                    <td style="width:100px;">
                        <button style="margin-right:5px;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                        <button style="margin-right:5px;" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>