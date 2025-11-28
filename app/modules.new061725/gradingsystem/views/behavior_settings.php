<?php
$isSub = 0;
foreach ($coreValues as $cv):
    $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
    if ($bStatements->num_rows() > 0):
        $isSub++;
    endif;
endforeach;
?>
<div class="col-lg-12">
    <div class="panel panel-green">
        <div class="panel-heading clearfix">
            <h4>Observed Values and Behavioral Statements
                <i onclick="$('#addCoreValues').modal('show'), $('#opt').val(1), $('#inputCore').val('')"class="pull-right pointer fa fa-2x fa-plus"></i>
            </h4>
            <i class="fa fa-info-circle"></i> Right click on each Values or Statements to view options.
        </div>
        <div class="panel-body">
            <table class="table table-bordered" id="ovAndbs">
                <tr>
                    <?php if ($isSub > 0): ?>
                    <th style="width: 40%">Observed Values</th>
                    <th >Behavioral Statements</th>
                    <?php else: ?>
                        <th>Observed Values</th>
                    <?php endif; ?>
                </tr>
                <?php 
                foreach ($coreValues as $cv):
                    $bStatements = Modules::run('gradingsystem/getListOfValues', $cv->core_id);
                    //count($bStatements->result());
                ?>
                <tr>
                    <td style="vertical-align: middle; text-align: left;" data-toggle="context" data-target="#editValues" onmouseover="$('#core_id').val('<?php echo $cv->core_id ?>'), $('#bStatement').text('<?php echo $cv->core_values ?>', $('#inputCore').val('<?php echo $cv->core_values ?>'))">
                        <?php echo $cv->core_values; ?>
                    </td>
                    <?php if ($isSub > 0): ?>
                    <td>
                        <!-- <table class="table table-bordered"> -->
                        <ul>
                        <?php foreach ($bStatements->result() as $bs): 
                            ?>
                            <!-- <tr>
                                <td style="vertical-align: middle; text-align: left;"> -->
                                <li data-toggle="context" data-target="#editBS" onmouseover="$('#bh_id').val('<?php echo $bs->bh_id ?>'), $('#addEditBS').text('Edit Behavioral Statement'), $('#inputBS').val('<?php echo $bs->bh_name; ?>')">
                                    <?php echo $bs->bh_name; ?>
                                </li>
                            <!--     </td>
                            </tr> -->
                        <?php endforeach; ?>
                        </ul>
                        <!-- </table> -->
                    </td>
                    <?php endif; ?>
                </tr>    
                    
                <?php
                endforeach;
            ?>
                
            </table>
        </div>
    </div>
</div>
<div id="addCoreValues" style="width:500px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4 id="addEditCV">Add Observed Values </h4>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" name="inputCore" id="inputCore" placeholder="Enter Observed Values" /><br />
            <button onclick="addBh()" class="btn btn-success btn-sm pull-right">Save</button>
            <button type="button" data-dismiss="modal" class="btn btn-warning btn-sm pull-right">Cancel</button>
        </div>
    </div>    
</div>
<div id="addBS" style="width:500px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4 id="addEditBS">Add Behavioral Statements to <br/><b id="bStatement"></b></h4>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" name="inputBS" id="inputBS" placeholder="Enter Behavioral Statement" /><br />
            <button onclick="addBehavioralStatement()" class="btn btn-success btn-sm pull-right">Save</button>
            <button type="button" data-dismiss="modal" class="btn btn-warning btn-sm pull-right">Cancel</button>
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
                    success: function (data) {
                        $('#ovAndbs').html(data);
                    }
                })
            },
            error: function () {
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
                    success: function (data) {
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
            success: function (data){
                alert(data.msg);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'gradingsystem/displayObservedValues' ?>',
                    success: function (data) {
                        $('#ovAndbs').html(data);
                    }
                })
            }
        })
    }
</script>