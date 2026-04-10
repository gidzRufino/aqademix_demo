<?php
$isSub = 0;
foreach ($coreValues as $cv):
    $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
    if ($bStatements->num_rows() > 0):
        $isSub++;
    endif;
endforeach;
?>
<div class="col-12 mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0 text-dark">
                Observed Values & Behavioral Statements
                <small class="text-muted d-block">Right click or click the options icon to manage values/statements</small>
            </h5>
            <button class="btn btn-sm btn-outline-success" onclick="$('#addCoreValues').modal('show'); $('#opt').val(1); $('#inputCore').val('')">
                <i class="fa fa-plus"></i> Add Value
            </button>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="ovAndbs">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40%">Observed Values</th>
                            <?php if ($isSub > 0): ?>
                                <th>Behavioral Statements</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coreValues as $cv):
                            $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
                        ?>
                            <tr class="align-top">
                                <td class="text-dark fw-semibold"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Right click for options"
                                    onmouseover="$('#core_id').val('<?php echo $cv->core_id ?>'), $('#inputCore').val('<?php echo $cv->core_values ?>')">
                                    <?php echo $cv->core_values; ?>
                                    <div class="dropdown float-end">
                                        <a class="text-secondary" href="#" role="button" id="cvOptions<?php echo $cv->core_id ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cvOptions<?php echo $cv->core_id ?>">
                                            <li><a class="dropdown-item" href="#" onclick="$('#addBS').modal('show'); $('#opt').val(1);"><i class="fa fa-plus fa-fw"></i> Add Behavioral Statement</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="$('#addCoreValues').modal('show'); $('#addEditCV').text('Edit Observed Values'); $('#opt').val(2)"><i class="fa fa-edit fa-fw"></i> Edit Observed Value</a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteValues(1)"><i class="fa fa-trash fa-fw"></i> Remove Observed Value</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <?php if ($isSub > 0): ?>
                                    <td>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($bStatements->result() as $bs): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-2"
                                                    onmouseover="$('#bh_id').val('<?php echo $bs->bh_id ?>'); $('#inputBS').val('<?php echo $bs->bh_name ?>'); $('#addEditBS').text('Edit Behavioral Statement')">
                                                    <?php echo $bs->bh_name; ?>
                                                    <div class="dropdown">
                                                        <a class="text-secondary" href="#" role="button" id="bsOptions<?php echo $bs->bh_id ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bsOptions<?php echo $bs->bh_id ?>">
                                                            <li><a class="dropdown-item" href="#" onclick="$('#opt').val(2); $('#addBS').modal('show');"><i class="fa fa-edit fa-fw"></i> Edit</a></li>
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteValues(2)"><i class="fa fa-trash fa-fw"></i> Remove</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add/Edit Core Value -->
<div class="modal fade" id="addCoreValues" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addEditCV">Add Observed Value</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" id="inputCore" placeholder="Enter Observed Value">
                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-success" onclick="addBh()">Save</button>
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add/Edit Behavioral Statement -->
<div class="modal fade" id="addBS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addEditBS">Add Behavioral Statement <br /><b id="bStatement"></b></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" id="inputBS" placeholder="Enter Behavioral Statement">
                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-success" onclick="addBehavioralStatement()">Save</button>
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editValues">
    <ul class="dropdown-menu" role="menu">
        <li class="pointer"><a onclick="$('#addBS').modal('show'), $('#opt').val(1)"><i class="fa fa-plus fa-fw"></i> Add Behavioral Statements</a></li>
        <li class="divider"></li>
        <li class="pointer"><a onclick="$('#addCoreValues').modal('show'), $('#addEditCV').text('Edit Observed Values'), $('#opt').val(2)"><i class="fa fa-edit fa-fw"></i> Edit Observed Values</a></li>
        <li class="divider"></li>
        <li onclick="deleteValues(1)" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i> Remove Observed Values</a></li>
    </ul>
</div>
<div id="editBS">
    <ul class="dropdown-menu" role="menu">
        <li class="pointer"><a onclick="$('#opt').val(2), $('#addBS').modal('show')"><i class="fa fa-edit fa-fw"></i>Edit Behavioral Statements</a></li>
        <li class="divider"></li>
        <li onclick="deleteValues(2)" class="pointer"><a tabindex="-1"><i class="fa fa-trash fa-fw"></i>Remove Behavioral Statements</a></li>
    </ul>
</div>
<input type="hidden" id="core_id" value="0" />
<input type="hidden" id="bh_id" value="0" />
<input type="hidden" id="desc" />
<input type="hidden" id="opt" />
<script type="text/javascript">
    function addBh() {
        var opt = $('#opt').val();
        var core = $('#inputCore').val();
        var core_id = $('#core_id').val();
        var url = '<?php echo base_url() . 'gradingsystem/addBh/' ?>' + core + '/' + core_id + '/' + opt;

        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {
                $('#addCoreValues').modal('hide');
                alert(data.text);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'gradingsystem/displayObservedValues' ?>',
                    success: function(data) {
                        $('#ovAndbs').html(data);
                    }
                })
            },
            error: function() {
                alert('An Error Occured!');
            }
        })
    }

    function addBehavioralStatement() {
        var opt = $('#opt').val();
        var core_id = $('#core_id').val();
        var desc = $('#inputBS').val();
        var bh_id = $('#bh_id').val();
        var url = '<?php echo base_url() . 'gradingsystem/addBehavioralStatement/' ?>' + core_id + '/' + desc + '/' + bh_id + '/' + opt;

        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {
                $('#addBS').modal('hide');
                alert(data.msg);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'gradingsystem/displayObservedValues' ?>',
                    success: function(data) {
                        $('#ovAndbs').html(data);
                    }
                })
            }
        })
    }

    function deleteValues(opt) {
        var core_id = $('#core_id').val();
        var bh_id = $('#bh_id').val();
        var url = '<?php echo base_url() . 'gradingsystem/deleteCVorBS/' ?>' + core_id + '/' + bh_id + '/' + opt;

        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {
                alert(data.msg);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'gradingsystem/displayObservedValues' ?>',
                    success: function(data) {
                        $('#ovAndbs').html(data);
                    }
                })
            }
        })
    }
</script>