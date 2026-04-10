<style>
    .accordion-button {
        font-size: 15px;
        padding: 14px 18px;
    }

    .accordion-item {
        border-radius: 10px;
        overflow: hidden;
    }

    .accordion-body {
        background: #fafafa;
    }
</style>

<div class="container-fluid py-4">

    <div class="accordion shadow-sm" id="deptAccordion">

        <!-- Pre-School & Elementary -->
        <div class="accordion-item border-0 mb-3">

            <h2 class="accordion-header">

                <button class="accordion-button collapsed fw-semibold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#deptElem">

                    <i class="fa fa-school text-primary me-2"></i>
                    Pre-School & Elementary Department

                </button>

            </h2>

            <div id="deptElem" class="accordion-collapse collapse"
                data-bs-parent="#deptAccordion">

                <div class="accordion-body">

                    <!-- Elementary -->
                    <div class="mb-4">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <strong>A. Incoming Grade 1 & Transferees</strong>

                            <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#insertReq"
                                onclick="$('#dept_desc').text('Elementary Department'); $('#dept_id').val(2);">

                                <i class="fa fa-plus"></i>

                            </button>

                        </div>

                        <div id="elemList"></div>

                    </div>


                    <!-- Pre-School -->
                    <div>

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <strong>B. Pre-School</strong>

                            <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#insertReq"
                                onclick="$('#dept_desc').text('Pre-School Department'); $('#dept_id').val(1);">

                                <i class="fa fa-plus"></i>

                            </button>

                        </div>

                        <div id="preSchoolList"></div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Junior High -->
        <div class="accordion-item border-0 mb-3">

            <h2 class="accordion-header">

                <button class="accordion-button collapsed fw-semibold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#deptJHS">

                    <i class="fa fa-graduation-cap text-success me-2"></i>
                    Junior High School

                </button>

            </h2>

            <div id="deptJHS" class="accordion-collapse collapse"
                data-bs-parent="#deptAccordion">

                <div class="accordion-body">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <strong>Requirements</strong>

                        <button class="btn btn-sm btn-outline-success"
                            data-bs-toggle="modal"
                            data-bs-target="#insertReq"
                            onclick="$('#dept_desc').text('Junior High School Department'); $('#dept_id').val(3);">

                            <i class="fa fa-plus"></i>

                        </button>

                    </div>

                    <div id="jhsList"></div>

                </div>

            </div>

        </div>


        <!-- Senior High -->
        <div class="accordion-item border-0 mb-3">

            <h2 class="accordion-header">

                <button class="accordion-button collapsed fw-semibold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#deptSHS">

                    <i class="fa fa-book text-info me-2"></i>
                    Senior High School

                </button>

            </h2>

            <div id="deptSHS" class="accordion-collapse collapse"
                data-bs-parent="#deptAccordion">

                <div class="accordion-body">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <strong>Requirements</strong>

                        <button class="btn btn-sm btn-outline-info"
                            data-bs-toggle="modal"
                            data-bs-target="#insertReq"
                            onclick="$('#dept_desc').text('Senior High School Department'); $('#dept_id').val(4);">

                            <i class="fa fa-plus"></i>

                        </button>

                    </div>

                    <div id="shsList"></div>

                </div>

            </div>

        </div>


        <!-- College -->
        <div class="accordion-item border-0 mb-3">

            <h2 class="accordion-header">

                <button class="accordion-button collapsed fw-semibold"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#deptCollege">

                    <i class="fa fa-university text-dark me-2"></i>
                    College Department

                </button>

            </h2>

            <div id="deptCollege" class="accordion-collapse collapse"
                data-bs-parent="#deptAccordion">

                <div class="accordion-body">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <strong>Requirements</strong>

                        <button class="btn btn-sm btn-outline-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#insertReq"
                            onclick="$('#dept_desc').text('College Department'); $('#dept_id').val(5);">

                            <i class="fa fa-plus"></i>

                        </button>

                    </div>

                    <div id="collegeList"></div>

                </div>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {

        checkPerDeptList(1);
        checkPerDeptList(2);
        checkPerDeptList(3);
        checkPerDeptList(4);
        checkPerDeptList(5);

        $('#addSelected').click(function() {
            var id = $('#reqSelect').val();
            var deptID = $('#dept_id').val();
            if (id != 0) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'main/checkForDuplicate/' ?>' + id + '/' + deptID,
                    success: function(data) {
                        if (data == 1) {
                            $('#alertMsg').append('<div class="alert alert-danger">' +
                                '<i class="fa fa-exclamation-triangle"></i>&nbsp;' +
                                'Requirement Selected Already Exist!' +
                                '</div>');

                            $('.alert-danger').delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            });
                        } else {
                            $.ajax({
                                type: 'GET',
                                url: '<?php echo base_url() . 'main/insertListPerDept/' ?>' + id + '/' + deptID,
                                success: function(info) {
                                    $('#alertMsg').append('<div class="alert alert-success">' +
                                        '<span class="glyphicon glyphicon-ok"></span>&nbsp;' +
                                        'Successfuly Added!' +
                                        '</div>');

                                    $('.alert-success').delay(1500).show(10, function() {
                                        $(this).delay(3000).hide(10, function() {
                                            $(this).remove();
                                        });
                                        $('#insertReq').modal('hide');
                                    });
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(data) {
                        alert('error');
                    }
                });
            } else {
                $('#alertMsg').append('<div class="alert alert-danger">' +
                    '<i class="fa fa-exclamation-triangle"></i>&nbsp;' +
                    'Please Select Requirements!' +
                    '</div>');

                $('.alert-danger').delay(500).show(10, function() {
                    $(this).delay(3000).hide(10, function() {
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
            success: function(data) {
                switch (id) {
                    case 1:
                        $('#preSchoolList').html(data);
                        break;
                    case 2:
                        $('#elemList').html(data);
                        break;
                    case 3:
                        $('#jhsList').html(data);
                        break;
                    case 4:
                        $('#shsList').html(data);
                        break;
                    case 5:
                        $('#collegeList').html(data);
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
                success: function(data) {

                }
            });
            $('#viewList').modal('hide');
            alert('Requirement Deleted Successfuly!');
            location.reload();
        } else {
            alert('Operation Cancelled');
        }
        //        var url = '<?php // echo base_url() . 'main/deleteItem/' 
                                ?>' + id + '/' + dept;
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