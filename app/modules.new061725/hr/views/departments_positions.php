<div class="panel panel-primary">
    <div class="panel-heading">
        <h5>List Of Departments & Positions  <i class="fa fa-plus fa-fw fa-2x pull-right pointer clickover" 
                                                rel="clickoverDept" 
                                                data-content=" 
                                                <div style='width:100%; color:black;'>
                                                <h6 style='color:black'>Add Department</h6>
                                                <input type='text' id='addDepartment' placeholder='department' /><br />
                                                <small>( Use this with caution. ) </small>
                                                <input type='text' id='idDepartment' placeholder='custome ID'  />
                                                <div style='margin:5px 0;'>
                                                <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                                <a href='#' id='Department' data-dismiss='clickover' onclick='saveDepartment(this.id)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a></div>
                                                </div>
                                                "   
                                                ></i>
        </h5>
    </div>

    <div class="panel-body">
        <ol id="Department_ol">
            <?php
            foreach ($department as $dept) {
                $position = Modules::run('hr/getPositionbyDepartment', $dept->dept_id);
                ?>
                <div  style="border-bottom: thin solid lightgray; padding: 10px">
                    <li class="parent" 
                        id="<?php echo $dept->dept_id ?>_li"><?php echo $dept->department ?>
                        <div id="<?php echo $dept->dept_id ?>_a">
                            <a class="btn btn-sm btn-success help-inline pull-right" 
                               rel="clickover" 
                               data-content=" 
                               <div style='width:100%;'>
                               <h6>Add Position</h6>
                               <input type='text' id='add<?php echo $dept->dept_id ?>' />
                               <div style='margin:5px 0;'>
                               <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                               <a href='#' id='<?php echo $dept->dept_id ?>' data-dismiss='clickover' table='profile_position' column='position' pk='position_id' retrieve='getPosition' onclick='saveNewValue(this.id)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a></div>
                               </div>
                               "   
                               data-toggle="modal" href="#"><i class="fa fa-plus"></i>   Add Position</a>
                            <a class="btn btn-sm btn-primary help-inline pull-right" 
                               rel="clickover" 
                               data-content="
                               <?php
                               $data['action'] = 1;
                               $data['dept'] = $dept->department;
                               $data['position'] = $position;
                               $this->load->view('deptPosition', $data);
                               ?>
                               "   
                               data-toggle="modal" href="#"><i class="fa fa-edit"></i>   Edit Position</a>
                            <a class="btn btn-sm btn-danger help-inline pull-right" 
                               rel="clickover" 
                               data-content="
                               <?php
                               $data['action'] = 2;
                               $data['dept'] = $dept->department;
                               $data['position'] = $position;
                               $this->load->view('deptPosition', $data);
                               ?>
                               "   
                               data-toggle="modal" href="#"><i class="fa fa-trash"></i>   Delete Position</a>
                        </div>
                    </li>
                    <?php
                    ?>
                    <ol id="<?php echo $dept->dept_id ?>_ol" type="a">
                        <?php
                        foreach ($position as $pos) {
                            ?>
                            <li><?php echo $pos->position ?></li>
                            <?php
                        }
                        ?>
                    </ol>
                </div>
                <?php
            }
            ?>
        </ol>
    </div>


</div>

<style>
    .popover{
        width: 75%
    }
</style>

<script type="text/javascript">
    $(function () {
        $('[rel="clickoverDept"]').clickover({
            placement: 'bottom',
            html: true
        });
    })


    function saveNewValue(table) {
        var db_table = $('#' + table).attr('table')
        var db_column = $('#' + table).attr('column')
        var pk = $('#' + table).attr('pk')
        var retrieve = $('#' + table).attr('retrieve')
        var db_value = $('#add' + table).val()
        var url = "<?php echo base_url() . 'hr/saveNewValue/' ?>"// the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "table=" + db_table + "&column=" + db_column + "&value=" + db_value + "&pk=" + pk + "&retrieve=" + retrieve + "&dept_id=" + table + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#' + table + '_ol').html(data)
            }
        });

        return false;

    }

    function saveDepartment(table) {
        var department = $('#add' + table).val()
        var customized_id = $('#id' + table).val()

        var url = "<?php echo base_url() . 'hr/saveDepartment/' ?>";// the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "department=" + department + "&customized_id=" + customized_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                location.reload()
            }
        });

        return false;

    }
</script>