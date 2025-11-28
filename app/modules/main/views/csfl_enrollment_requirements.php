<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5>Pre-School & Elementary Department</h5>
            </div>
            <div class="panel panel-body">
                <i class="fa fa-plus-circle pull-right fa-1x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('NEW (3 to 5 years old)'), $('#dept_id').val(1)"></i>
                <span>A. NEW (3 to 5 years old):</span>
                <div id="preSchoolList"></div>
                <br/>
                <i class="fa fa-plus-circle pull-right fa-1x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('Incoming Grade 1'), $('#dept_id').val(2)"></i>
                <span>B. Incoming Grade 1:</span>
                <div id="in_grade1"></div>
                <br/>
                <i class="fa fa-plus-circle pull-right fa-1x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('Transferee - Grade 2 to Grade 6'), $('#dept_id').val(3)"></i>
                <span>C. Transferee - Grade 2 to Grade 6:</span>
                <div id="transfereeStud"></div>
                <br/>
                <i class="fa fa-plus-circle pull-right fa-1x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('Continuing Student (Kinder 2 to Grade 6)'), $('#dept_id').val(4)"></i>
                <span>D. Continuing Student (Kinder 2 to Grade 6):</span>
                <div id="cont_stud"></div>
            </div>
        </div>
    </div>
<!--    <div class="col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <i class="fa fa-plus-circle pull-right fa-2x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('Junior High School Department'), $('#dept_id').val(3)"></i>
                <h5>Junior High School</h5>
            </div>
            <div class="panel panel-body">
                <div id="jhsList"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-plus-circle pull-right fa-2x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('Senior High School Department'), $('#dept_id').val(4)"></i>
                <h5>Senior High School</h5>
            </div>
            <div class="panel panel-body">
                <div id="shsList"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <i class="fa fa-plus-circle pull-right fa-2x" style="cursor: pointer" data-toggle="modal" data-target="#insertReq" onclick="$('#dept_desc').text('College Department'), $('#dept_id').val(5)"></i>
                <h5>College Department</h5>
            </div>
            <div class="panel panel-body">
                <div id="collegeList"></div>
            </div>
        </div>
    </div>-->
</div>

<div id="insertReq" class="modal fade" role="dialog" style="width: 25%; margin: 15% 0 0 35%">
    <?php $reqList = Modules::run('main/listRequirements'); ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <input type="hidden" id="dept_id" name="dept_id" />
            Insert Requirements for <span id="dept_desc"></span>
            <i class="fa fa-times-circle pull-right fa-2x" style="cursor: pointer;" onclick="$('#insertReq').modal('hide')"></i>
        </div>
        <div class="panel panel-body">
            <select id="reqSelect" name="reqSelect">
                <option value="0">Select Requirements</option>
                <?php foreach ($reqList as $r): ?>
                    <option value="<?php echo $r->eReq_list_id ?>"><?php echo $r->eReq_desc ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="panel panel-footer">
            <button class="btn btn-sm btn-danger pull-right" id="addSelected">Save</button><br/>
            <span id="alertMsg"></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        checkPerDeptList(1);
        checkPerDeptList(2);
        checkPerDeptList(3);
        checkPerDeptList(4);

        $('#addSelected').click(function () {
            var id = $('#reqSelect').val();
            var deptID = $('#dept_id').val();
            if (id != 0) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'main/checkForDuplicate/' ?>' + id + '/' + deptID,
                    success: function (data) {
                        if (data == 1) {
                            $('#alertMsg').append('<div class="alert alert-danger">' +
                                    '<i class="fa fa-exclamation-triangle"></i>&nbsp;' +
                                    'Requirement Selected Already Exist!' +
                                    '</div>');

                            $('.alert-danger').delay(500).show(10, function () {
                                $(this).delay(3000).hide(10, function () {
                                    $(this).remove();
                                });
                            });
                        } else {
                            $.ajax({
                                type: 'GET',
                                url: '<?php echo base_url() . 'main/insertListPerDept/' ?>' + id + '/' + deptID,
                                success: function (info) {
                                    $('#alertMsg').append('<div class="alert alert-success">' +
                                            '<span class="glyphicon glyphicon-ok"></span>&nbsp;' +
                                            'Successfuly Added!' +
                                            '</div>');

                                    $('.alert-success').delay(1500).show(10, function () {
                                        $(this).delay(3000).hide(10, function () {
                                            $(this).remove();
                                        });
                                        $('#insertReq').modal('hide');
                                    });
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (data) {
                        alert('error');
                    }
                });
            } else {
                $('#alertMsg').append('<div class="alert alert-danger">' +
                        '<i class="fa fa-exclamation-triangle"></i>&nbsp;' +
                        'Please Select Requirements!' +
                        '</div>');

                $('.alert-danger').delay(500).show(10, function () {
                    $(this).delay(3000).hide(10, function () {
                        $(this).remove();
                    });
                });
            }
        });
    });


    function checkPerDeptList(id) {
        var url = '<?php echo base_url() . 'main/checkPerDeptList/' ?>' + id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                switch (id) {
                    case 1:
                        $('#preSchoolList').html(data);
                        break;
                    case 2:
                        $('#in_grade1').html(data);
                        break;
                    case 3:
                        $('#transfereeStud').html(data);
                        break;
                    case 4:
                        $('#cont_stud').html(data);
                        break;
                }
            }
        });
    }

    function deleteItem(id, dept) {
        var url = '<?php echo base_url() . 'main/deleteItem/' ?>' + id + '/' + dept;
        var r = confirm('Are you sure you want to delete this requirement?');
        if (r == true) {
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {

                }
            });
            $('#viewList').modal('hide');
            alert('Requirement Deleted Successfuly!');
            location.reload();
        } else {
            alert('Operation Cancelled');
        }
//        var url = '<?php // echo base_url() . 'main/deleteItem/' ?>' + id + '/' + dept;
//        $.confirm({
//            title: 'Confirmation Alert!',
//            content: 'Are you sure you want to delete this requirement?',
//            buttons: {
//                confirm: function () {
//                    $.ajax({
//                        type: 'GET',
//                        url: url,
//                        success: function (data) {
//
//                        }
//                    });
//                    $('#viewList').modal('hide');
//                    $.alert('Requirement Deleted Successfuly!');
//                    location.reload();
//                },
//                cancel: function () {
//                    $.alert('Canceled!');
//                }
//            }
//        });
    }
</script>