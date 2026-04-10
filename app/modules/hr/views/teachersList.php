<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="page-header">List of Employees</h3>
            <div class="btn-group" role="group" aria-label="Actions">
                <button type="button" class="btn btn-secondary" onclick="document.location='<?php echo base_url('hr/payroll') ?>'">Payroll</button>

                <?php if ($this->session->userdata('position_id') == 1): ?>
                    <a id="CSVExportBtn" href="<?php echo base_url() . 'reports/exportTeachersToCsv' ?>" class="btn btn-success">Export To CSV</a>
                    <a href="#importCsv" data-bs-toggle="modal" id="uploadAssessment" class="btn btn-warning">
                        <i class="fa fa-upload"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$tl = 0;
foreach ($leave as $l):
    if ($l->pld_is_approved == 0 && $l->pld_approve_by == ''):
        $tl++;
    endif;
endforeach;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="employeeTabs" role="tablist">
                <li class="nav-item" onclick="getEmStat(1)">
                    <a class="nav-link <?php echo ($option == 1 ? 'active' : '') ?>" id="active-tab" data-bs-toggle="tab" href="#home" role="tab">
                        <i class="fa fa-check-circle"></i> <span>Active</span>
                    </a>
                </li>
                <li class="nav-item" onclick="getEmStat(2)">
                    <a class="nav-link <?php echo ($option == 2 ? 'active' : '') ?>" id="suspended-tab" data-bs-toggle="tab" href="#profile" role="tab">
                        <i class="fa fa-times-circle"></i> <span>Suspended</span>
                    </a>
                </li>
                <li class="nav-item" onclick="getEmStat(3)">
                    <a class="nav-link <?php echo ($option == 3 ? 'active' : '') ?>" id="resigned-tab" data-bs-toggle="tab" href="#messages" role="tab">
                        <i class="fa fa-minus-circle"></i> <span>Resigned</span>
                    </a>
                </li>
                <li class="nav-item" onclick="getEmStat(0)">
                    <a class="nav-link <?php echo ($option == 0 ? 'active' : '') ?>" id="deactivated-tab" data-bs-toggle="tab" href="#settings" role="tab">
                        <i class="fa fa-exclamation-circle"></i> <span>Deactivated</span>
                    </a>
                </li>
                <li class="nav-item ms-auto">
                    <a class="nav-link" href="#leaveRequest" data-bs-toggle="tab">
                        <span class="badge bg-danger" id="lr"><?php echo $tl; ?></span> Leave Requests
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-3">
                <div class="tab-pane fade show active" id="home">
                    <?php
                    $data['links'] = $links;
                    $data['employee'] = $employee;
                    $this->load->view('activeEmployees', $data);
                    ?>
                </div>
                <div class="tab-pane fade" id="profile">
                    <?php $this->load->view('activeEmployees', $data); ?>
                </div>
                <div class="tab-pane fade" id="messages">
                    <?php $this->load->view('activeEmployees', $data); ?>
                </div>
                <div class="tab-pane fade" id="settings">
                    <?php $this->load->view('activeEmployees', $data); ?>
                </div>
                <div class="tab-pane fade" id="leaveRequest">
                    <?php
                    $data['leave'] = $leave;
                    $this->load->view('leaveRequests', $data);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import CSV Modal -->
<div class="modal fade" id="importCsv" tabindex="-1" aria-labelledby="importCsvLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:350px;">
        <div class="modal-content">
            <div class="modal-header bg-success-subtle">
                <h5 class="modal-title" id="importCsvLabel">Upload Teachers CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?php
            $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:10px;');
            echo form_open_multipart(base_url() . 'hr/importTeachers', $attributes);
            ?>
            <div class="modal-body">
                <input type="file" name="userfile" class="form-control mb-2">
                <input type="submit" name="submit" value="UPLOAD" class="btn btn-success w-100">
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#subOver').clickover({
            placement: 'bottom',
            html: true
        });
    });

    // function showAddRFIDForm(id, st_id, emp_id) {
    //     alert(id + ' ' + st_id + ' ' + emp_id)
    //     $('#stud_id').val(id)
    //     $('#emp_id').val(emp_id)
    //     $("#inputCard").attr('placeholder', st_id);
    //     document.getElementById("inputCard").focus()
    // }

    function updateProfile(pk, table, column) {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var pk_id = $('#stud_id').val();
        var emp_id = $('#emp_id').val();
        var value = $('#inputCard').val();
        var rfid = $('#rfid').val();
        var cont = 0;

        if (value === '') {
            if (rfid == 'RFID') {
                alert('No Card Number Entered');
            } else {
                value = rfid;
                cont = 1;
            }
        } else {
            cont = 1;
        }

        if (cont === 1) {
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    alert('RFID Successfully Saved');
                    // updateAttendanceFormat(emp_id, value)
                    location.reload();
                }
            });
            return false; // avoid to execute the actual submit of the form.
        }
    }

    function updateAttendanceFormat(user_id, rfid) {
        var url = "<?php echo base_url() . 'attendance/updateAttendanceFormat/' ?>" + user_id + '/' + rfid; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            // dataType: 'json',
            data: 'id=' + user_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data);
                location.reload();
            }
        });
        return false; // avoid to execute the actual submit of the form.
    }

    function deleteEmployee(user_id, employee_id) {
        var rsure = confirm("Are you Sure You Want to delete Employee # ( " + user_id + " ) from the list?");
        if (rsure == true) {
            var url = "<?php echo base_url() . 'hr/deleteEmployee/' ?>"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "employee_id=" + employee_id + "&user_id=" + user_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                // dataType: 'json',
                success: function(data) {
                    alert(data)
                    location.reload();
                }
            });
            return false;
        } else {
            location.reload();
        }

    }


    function searchTeacher(value) {
        var url = "<?php echo base_url() . 'hr/searchEmployees/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function() {},
            success: function(data) {
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
            success: function(data) {
                location.reload();
            }
        })
    }

    function getEmStat(option) {
        window.location.href = '<?php echo base_url() . 'hr/getAllEmployee/' ?>' + option;
    }

    function formSelected() {
        var form = $('#SOForm').val();
        window.location.href = '<?php echo base_url() . 'hr/SubOver/' ?>' + form;
    }

    function leaveUpdate(id, value, opt) {
        var url = '<?php echo base_url() . 'hr/payroll/updateLeave' ?>';
        var tl = $('#lr').text();
        var t = 0;

        $.ajax({
            type: 'POST',
            url: url,
            data: 'id=' + id + '&value=' + value + '&opt=' + opt + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#td-' + id).html(data);
                if (opt == 3) {
                    t = parseInt(tl) + parseInt(1);
                } else {
                    t = parseInt(tl) - parseInt(1);
                }
                $('#lr').text(t);
            }
        })
    }

    function updateEmployeeStatus(employeeId, status) {
        var csrf = $.cookie('csrf_cookie_name'); // CSRF token
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("hr/updateEmStatus") ?>',
            data: {
                eid: employeeId,
                status: status,
                csrf_test_name: csrf
            },
            success: function() {
                // Reload the page to reflect changes
                location.reload();
            },
            error: function() {
                alert('Failed to update status.');
            }
        });
    }

    function togglePassword(empId) {
        const mask = document.getElementById('pw_mask_' + empId);
        const real = document.getElementById('pw_real_' + empId);

        if (real.classList.contains('d-none')) {
            real.classList.remove('d-none');
            mask.classList.add('d-none');
        } else {
            real.classList.add('d-none');
            mask.classList.remove('d-none');
        }
    }

    function resetPassword(empId) {
        if (!confirm("Reset this employee's password?")) return;

        $.ajax({
            url: "<?= base_url('hr/resetPassword') ?>",
            type: "POST",
            data: {
                employee_id: empId,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(res) {
                alert("Password has been reset successfully.");
            },
            error: function() {
                alert("Error resetting password.");
            }
        });
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