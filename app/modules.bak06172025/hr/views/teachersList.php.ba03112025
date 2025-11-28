<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">List of Employees
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('hr/payroll') ?>'">Payroll</button>
                <!--<button type="button" class="btn btn-primary" id="subOver" rel="clickover" onclick="document.location = '<?php echo base_url('hr/listSubOver'); ?>'">Substitution / Overload</button>-->

                <?php if ($this->session->userdata('position_id') == 1): ?>
                    <a id="CSVExportBtn" href="<?php echo base_url() . 'reports/exportTeachersToCsv' ?>" class="btn btn-default btn-success">Export To CSV </a>
                    <a href="#importCsv" data-toggle="modal"  id="uploadAssessment" class="btn btn-warning pull-right" >
                        <i class="fa fa-upload"></i>
                    </a>
                <?php endif; ?>
            </div>

        </h3>


    </div>
</div>


<div class="">
    <div class="row">
        <div class="col-md-12"> 
            <!-- Nav tabs -->
            <div class="card">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="<?php echo ($option == 1 ? 'active' : '') ?>" onclick="getEmStat(1)"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-check-circle"></i>  <span>Active</span></a></li>
                    <li role="presentation" class="<?php echo ($option == 2 ? 'active' : '') ?>" onclick="getEmStat(2)"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-times-circle"></i>  <span>Suspended</span></a></li>
                    <li role="presentation" class="<?php echo ($option == 3 ? 'active' : '') ?>" onclick="getEmStat(3)"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-minus-circle"></i>  <span>Resigned</span></a></li>
                    <li role="presentation" class="<?php echo ($option == 0 ? 'active' : '') ?>" onclick="getEmStat(0)"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-exclamation-circle"></i>  <span>Deactivated</span></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <?php
                        $data['links'] = $links;
                        $data['employee'] = $employee;
                        $this->load->view('activeEmployees', $data);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <?php
                        $data['links'] = $links;
                        $data['employee'] = $employee;
                        $this->load->view('activeEmployees', $data);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <?php
                        $data['links'] = $links;
                        $data['employee'] = $employee;
                        $this->load->view('activeEmployees', $data);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="settings">
                        <?php
                        $data['links'] = $links;
                        $data['employee'] = $employee;
                        $this->load->view('activeEmployees', $data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Identification Card -->
<div id="addId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div style='width:450px; height:auto; margin:50px auto 0;  background:white;'>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"  aria-hidden="true">&times;</button>
            <h3 id="myModalLabel">Scan Employee's Identification Card</h3>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="input">CARD NUMBER:</label>
                <div class="controls">
                    <input type="text" id="inputCard" onclick="this.value = ''" placeholder="RFID" required>
                    <input type="hidden" id="stud_id" >
                    <input type="hidden" id="emp_id" >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal">Close</button>
            <button onclick="updateProfile('<?php echo base64_encode('user_id') ?>', '<?php echo base64_encode('esk_profile') ?>', 'rfid')" class="btn btn-primary">Save </button>
            <div id="resultSection" class="help-block" ></div>
        </div>
    </div> 
</div>
<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload Teachers CSV</h4>
        </div>
        <?php
        $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:20px;');
        echo form_open_multipart(base_url() . 'hr/importTeachers', $attributes);
        ?>
        <div class="panel-body">

            <input style="height:30px" type="file" name="userfile" ><br />
            <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
        echo form_close();
        ?>
    </div>

</div>

<script type="text/javascript">
    $(function () {
        $('#subOver').clickover({
            placement: 'bottom',
            html: true
        });
    });
    function showAddRFIDForm(id, st_id, emp_id)
    {
        $('#stud_id').val(id)
        $('#emp_id').val(emp_id)
        $("#inputCard").attr('placeholder', st_id);
        document.getElementById("inputCard").focus()
    }
    function updateProfile(pk, table, column)
    {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var pk_id = $('#stud_id').val();
        var emp_id = $('#emp_id').val();
        var value = $('#inputCard').val()
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert('RFID Successfully Saved');
                // updateAttendanceFormat(emp_id, value)
                location.reload();
            }
        });
        return false; // avoid to execute the actual submit of the form.
    }

    function updateAttendanceFormat(user_id, rfid)
    {
        var url = "<?php echo base_url() . 'attendance/updateAttendanceFormat/' ?>" + user_id + '/' + rfid; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            // dataType: 'json',
            data: 'id=' + user_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data);
                location.reload();
            }
        });
        return false; // avoid to execute the actual submit of the form.
    }

    function deleteEmployee(user_id, employee_id)
    {
        var rsure = confirm("Are you Sure You Want to delete Employee # ( " + user_id + " ) from the list?");
        if (rsure == true) {
            var url = "<?php echo base_url() . 'hr/deleteEmployee/' ?>"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "employee_id=" + employee_id + "&user_id=" + user_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                // dataType: 'json',
                success: function (data)
                {
                    alert(data)
                    location.reload();
                }
            });
            return false;
        } else {
            location.reload();
        }

    }


    function searchTeacher(value)
    {
        var url = "<?php echo base_url() . 'hr/searchEmployees/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
            },
            success: function (data)
            {
                $('#tableDetails').html(data);
            }
        });
        return false;
    }

    function updateStatus() {
        var st_id = $('#eid').val();
        var status = $('#editEmStat').val();
        //alert(st_id + ' ' + status);

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'hr/updateEmStatus' ?>',
            data: 'eid=' + st_id + '&status=' + status + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                location.reload();
            }
        })
    }

    function getEmStat(option) {
        window.location.href = '<?php echo base_url() . 'hr/getAllEmployee/' ?>' + option;
    }
    
    function formSelected(){
        var form = $('#SOForm').val();
        window.location.href = '<?php echo base_url() . 'hr/SubOver/' ?>' + form;
    }
</script>
<style type="text/css">
    /*.nav-tabs { border-bottom: 2px solid #DDD; }
        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
        .nav-tabs > li > a { border: none; color: #ffffff;background: #5a4080; }
            .nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #5a4080 !important; background: #fff; }
            .nav-tabs > li > a::after { content: ""; background: #5a4080; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
        .nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
    .tab-nav > li > a::after { background: #5a4080 none repeat scroll 0% 0%; color: #fff; }
    .tab-pane { padding: 15px 0; }
    .tab-content{padding:20px}
    .nav-tabs > li  {width:20%; text-align:center;}
    .card {background: #FFF none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-bottom: 30px; }
    body{ background: #EDECEC; padding:50px}
    
    @media all and (max-width:724px){
    .nav-tabs > li > a > span {display:none;}	
    .nav-tabs > li > a {padding: 5px 5px;}
    }*/

</style>