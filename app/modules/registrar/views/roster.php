<?php
switch ($this->uri->segment(2)) {
    case 'getAllStudentsBySection':
        $allStudents = Modules::run('registrar/getAllStudentsByLevel', Null, $section_id, NULL, NULL);
        break;
    case 'getAllStudentsByGradeLevel':
        $allStudents = Modules::run('registrar/getAllStudentsForExternal', $grade_id);
        break;

    case 'getStudentByYear':
        $allStudents = Modules::run('registrar/getStudentByYear', $this->uri->segment(3));
        echo 'hey';
        break;

    case "":

        break;

    default:
        $allStudents = Modules::run('registrar/getAllStudentsForExternal', Null, Null, NULL, 1, $this->session->userdata('school_year'));
        break;
}
?>
<div class="container-fluid py-4">

    <!-- ====== HEADER & ACTIONS ====== -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h3 class="mb-2">List of Students
            <small id="num_students">[ <?= $allStudents->num_rows . ' / ' . $num_of_students ?> ]</small>
        </h3>

        <div class="d-flex flex-wrap gap-2">
            <!-- Only for position_id 1 -->
            <?php if ($this->session->userdata('position_id') == 1): ?>
                <button class="btn btn-primary btn-sm" onclick="backupToExell()" title="Backup Data">
                    <i class="fa fa-database"></i>
                </button>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importCsv">
                    <i class="fa fa-upload"></i>
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteAllStudent()">
                    <i class="fa fa-trash"></i>
                </button>
            <?php endif; ?>

            <!-- Admin/SuperAdmin Actions -->
            <?php if ($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')): ?>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#printIdModal">
                    Print ID
                </button>
                <button class="btn btn-success btn-sm" onclick="document.location='<?= base_url('search/exportStudentListToExcell/profile_students_admission.section_id/') ?>' + $('#inputSection').val() + '/' + $('#inputSY').val()">
                    Export To Excel
                </button>

                <!-- School Year & Term -->
                <select id="inputSY" class="form-select form-select-sm ms-2" style="width:180px;" onchange="getStudentByYear(this.value)">
                    <option>School Year</option>
                    <?php foreach ($ro_year as $ro): ?>
                        <option value="<?= $ro->ro_years ?>" <?= ($this->session->userdata('school_year') == $ro->ro_years ? 'selected' : '') ?>>
                            <?= $ro->ro_years . ' - ' . ($ro->ro_years + 1) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select id="sem" class="form-select form-select-sm ms-2" style="width:160px;" onchange="getStudentByTerm(this.value)">
                    <option value="0">Regular Class</option>
                    <option value="3">Summer Class</option>
                </select>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row" id="student-table">

    <?php
    $user_is_allowed = $this->session->userdata('is_adviser')
        || $this->session->userdata('is_admin')
        || $this->session->userdata('is_superAdmin')
        || $this->session->userdata('position') === 'Admin Officer';

    if ($user_is_allowed):
        $customTablePath = APPPATH . 'modules/registrar/views/' . strtolower($settings->short_name) . '_studentTable.php';
        if (file_exists($customTablePath)):
            $this->load->view(strtolower($settings->short_name) . '_studentTable');
        else:
            $this->load->view('studentTable');
        endif;
    else:
        redirect(base_url('academic/mySubjects'));
    endif;
    ?>
</div>

<!-- Modal -->
<div class="modal fade" id="printIdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> Print ID Card</h4>
            </div>
            <div class="modal-body">
                <div class="form-group ">
                    <select onclick="$('#url_id').val('<?php echo base_url('registrar/exportForId'); ?>/'+this.value)" tabindex="-1" id="" style="width:200px; font-size: 15px;">
                        <option value="0">Search Grade level here</option>
                        <?php
                        foreach ($grade as $level) {
                        ?>
                            <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="url_id" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button onclick="document.location=$('#url_id').val()" type="button" class="btn btn-success" data-dismiss="modal">Export</button>
                <a target="_blank" href="#" id="printIdBtn" style="margin-top:0;" onmouseover="printId(<?php echo $this->uri->segment(3) ?>, this.id, $('#frontBack').val(),$('#pageID').val() )" class="btn btn-small btn-info pull-right">Print ID</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chartDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog " style="width:90%; margin: 10px auto 0;">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="col-lg-4 pull-right">
                    <select class="pull-right populate select2-offscreen" onclick="getMMG(this.value, $('#inputSY').val())" tabindex="-1" id="inputMonthReport" style="width:200px">
                        <option>Select Month</option>
                        <option value="annual">Annual</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
            <div class="modal-body clearfix">

                <div id="mmg_details" class="col-lg-12 pull-left clearfix">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="importCsv" style="width:350px; margin: 10px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Upload Students CSV</h4>
        </div>
        <?php
        $attributes = array('class' => '', 'id' => 'importCSV', 'style' => 'margin-top:20px;');
        echo form_open_multipart(base_url() . 'reports/importStudentsNew', $attributes);
        //echo form_open_multipart(base_url().'reports/importSample', $attributes);
        ?>
        <div class="panel-body">
            <select name="school_type" onclick="setAction(this.value)">

                <option value="public">Public School</option>
                <option value="private">Private School</option>
            </select> <br />
            <input style="height:30px" type="file" name="userfile">
            <input class="form-control" type="text" name="sheet_number" id="sheet" placeholder="sheet number" /><br />
            <input type="submit" name="submit" value="UPLOAD" class="btn btn-success">
        </div>
        <?php
        echo form_close();
        ?>
    </div>

</div>

<?php echo Modules::run('main/showAdminRemarksForm') ?>
</div>
<script type="text/javascript">
    function setAction(value) {
        if (value == 'private') {
            $('#importCSV').attr('action', '<?php echo base_url() . 'reports/importPrivateStudents' ?>')
        } else {
            $('#importCSV').attr('action', '<?php echo base_url() . 'reports/importStudents' ?>')
        }
    }

    function deleteAllStudent() {
        var sy = $('#inputSY').val()
        var rsure = confirm("Are you Sure You Want to delete all student from the list? Warning: You Cannot Undo this action.");
        if (rsure == true) {
            var url = "<?php echo base_url() . 'registrar/deleteAllStudent/' ?>" + sy; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data) {
                    alert(data)
                    //location.reload();
                }
            });

            return false;
        } else {
            location.reload();
        }
    }

    function getMMG(value, sy) {
        var url = "<?php echo base_url() . 'registrar/getMMG/' ?>" + value + '/' + sy; // the script where you handle the form input.

        $.ajax({
            type: "GET",
            url: url,
            data: "value=" + value, // serializes the form's elements.
            //dataType: 'json',
            beforeSend: function() {
                showLoading('mmg_details');
            },
            success: function(data) {
                $('#mmg_details').html(data);
            }
        });

        return false;
    }

    function printId(section_id, id, frontBack, pageID) {
        if (frontBack == 'printIdCardBack') {
            var limit = 4;

        } else {
            limit = 8;
        }
        document.getElementById(id).href = '<?php echo base_url() . 'registrar/' ?>' + frontBack + '/' + section_id + '/' + limit + '/' + pageID
    }

    function showDeleteConfirmation(st_id, psid) {
        //alert(psid)
        $('#stud_id').val(psid)
        $('#sp_stud_id').html(st_id)
        document.getElementById("user_id").focus()
    }

    function deleteStudent() {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val()
        var sy = $('#inputSY').val()
        var rsure = confirm("Are you Sure You Want to delete student ( " + st_id + " ) from the list?");
        if (rsure == true) {
            var url = "<?php echo base_url() . 'registrar/deleteID/' ?>" + st_id; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "st_id=" + st_id + "&user_id=" + user_id + "&school_year=" + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                        location.reload();
                    }
                }
            });

            return false;
        } else {
            location.reload();
        }

    }

    function getRemarks(st_id, user_id) {
        $('#st_id').val(st_id);
        $('#us_id').val(user_id);
    }

    function submitRemarks() {
        var url = "<?php echo base_url() . 'main/saveAdmissionRemarks/' ?>"; // the script where you handle the form input.
        var st_id = $('#st_id').val()
        var user_id = $('#us_id').val()
        var code = $('#inputRemarks').val()
        var info = $('#required_information').val()
        $.ajax({
            type: "POST",
            url: url,
            data: "codeIndicator_id=" + code + "&required_information=" + info + "&st_id=" + $('#st_id').val() + "&user_id=" + user_id + "&effectivity_date=" + $('#inputEffectivity').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#remarks_' + st_id + "_td").html(data);
                if (code == 1 || code == 3) {
                    $('#img_' + st_id + "_td img").attr("src", '<?php echo base_url(); ?>images/unofficial.png');
                } else {
                    $('#img_' + st_id + "_td img").attr("src", '<?php echo base_url(); ?>images/official.png');
                }
                location.reload();
            }
        });

        return false;
    }

    function getStudentBySection(id) {
        var url = "<?php echo base_url() . 'registrar/getAllStudentsBySection/' ?>" + id + '/' + $('#inputSY').val();
        document.location = url;
    }

    function getStudentByLevel(id) {
        var url = "<?php echo base_url() . 'registrar/getAllStudentsByGradeLevel/' ?>" + id + '/'; // the script where you handle the form input.
        document.location = url;
        //        $.ajax({
        //               type: "GET",
        //               url: url,
        //               data: "id="+id, // serializes the form's elements.
        //               success: function(data)
        //               {
        //                   if(data!=""){
        //                       $('#student-table').html(data)   
        //                   }else{
        //                       $('#student-table').html('<h4>Sorry, No Students is Enrolled in this Grade Level')   
        //                   }
        //                   
        //                   $('#CSVExportBtn').show();
        //                   var CSVUrl ="<?php //echo base_url().'reports/exportToCsv/'
                                            ?>"+id+'/';
        //                   document.getElementById('CSVExportBtn').href = CSVUrl
        //                     
        //               }
        //             });
        //
        //        return false;
    }

    function getStudentByYear(id) {
        var sem = $('#sem').val();
        var url = "<?php echo base_url() . 'registrar/getStudentByYear/' ?>" + id + '/' + sem; // the script where you handle the form input.
        document.location = url;

    }

    function deleteAdmissionRemark(st_id, code_id) {
        var url = "<?php echo base_url() . 'main/deleteAdmissionRemark/' ?>" + st_id + '/' + code_id; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "st_id=" + st_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                location.reload()
                //$('#inputSection').html(data);
            }
        });

        return false;

    }

    // function showAddRFIDForm(id, st_id, name) {
    //     $('#addId').show();
    //     $('#secretContainer').html($('#addId').html())
    //     $('#secretContainer').fadeIn(500)
    //     $('#stName').text(name)
    //     $('#stud_id').val(id)
    //     $("#inputCard").attr('placeholder', st_id);
    //     $("#inputCard").val('')
    //     window.setTimeout(function() {
    //         document.getElementById("inputCard").focus()
    //     }, 1);
    //     $('#inputCard').blur(function() {
    //         //alert('hey')
    //         window.setTimeout(function() {
    //             document.getElementById("inputCard").focus();
    //         }, 0);


    //     })

    // }

    function updateProfile(pk, table, column) {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        var pk_id = $('#stud_id').val();
        var value = $('#inputCard').val()
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert('RFID Successfully Saved');
                location.reload();
            }
        });

        return false; // avoid to execute the actual submit of the form.
    }


    $(document).ready(function() {
        $("#inputGrade").select2({});
        $("#inputSection").select2();
        $("#inputMonthReport").select2();
        $("#inputSY").select2();
        $("#sem").select2();
        setFocus();
        if ($('#hiddenSection').val() != "") {
            $('#CSVExportBtn').show();
            var CSVUrl = "<?php echo base_url() . 'reports/exportToCsv/' ?>" + "Null" + '/' + $('#hiddenSection').val();
            <?php if ($this->session->userdata('is_superAdmin')): ?>
                // document.getElementById('CSVExportBtn').href = CSVUrl
            <?php endif; ?>
        }

    });


    function deleteROStudent() {
        var user_id = $('#user_id').val();
        var st_id = $('#stud_id').val()
        var sy = $('#sy').val()
        var rsure = confirm("Are you Sure You Want to delete student ( " + st_id + " ) from the list?");
        if (rsure == true) {
            if ($('#deleteAll').is(":checked")) {

                var url = "<?php echo base_url() . 'registrar/deleteID/' ?>" + st_id;
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "st_id=" + st_id + "&user_id=" + user_id + "&school_year=" + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            alert(data.msg);
                            location.reload();
                        } else {
                            alert(data.msg);
                            location.reload();
                        }
                    }
                });

                return false;


            }
            var url = "<?php echo base_url() . 'registrar/deleteROStudent/' ?>" + st_id; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: "st_id=" + st_id + "&user_id=" + user_id + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                //dataType: 'json',
                success: function(data) {
                    alert(data);
                    location.reload();
                    //console.log(data)
                }
            });

            return false;

        } else {
            location.reload();
        }

    }

    function deleteAll(st_id) {

        var deleteAll = confirm('Are you Sure You want to delete all the record of student # ( ' + st_id + ' )?');
        if (deleteAll == false) {
            $('#deleteAll').prop('checked', false);
        }
    }


    function setFocus() {
        window.setTimeout(function() {
            document.getElementById("rfid").focus();
        }, 500);
    }

    function scanStudents(value) {
        var url = "<?php echo base_url() . 'registrar/scanStudent/' ?>" + value; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#rfid').val('');
                document.location = '<?php echo base_url('registrar/viewDetails/') ?>' + data.st_id
                //console.log(data)
            }
        });

        return false;
    }

    function getStudentByTerm(sem) {
        var sy = $('#inputSY').val();
        var url = "<?php echo base_url() . 'registrar/getStudentByYear/' ?>" + sy + '/' + sem; // the script where you handle the form input.
        document.location = url;
    }

    function backupToExell() {
        var sy = $('#inputSY').val();
    }
</script>