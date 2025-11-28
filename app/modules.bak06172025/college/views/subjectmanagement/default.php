<style>
    .select2-container .select2-choice {
        display: block!important;
        height: 30px!important;
        white-space: nowrap!important;
        line-height: 25px!important;
    }
</style>

<div class="row" style="height: 100vh;" >
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Subject Management
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college/subjectmanagement/classList') ?>'">List of Classes</button>
                <button type="button" class="btn btn-default" onclick="">Schedule Per Subject</button>
                <button type="button" class="btn btn-default" onclick="getAdd('CollegeSubject')">Add Subject</button>
            </div>
        </h3>
    </div>
    <div class="col-lg-12 no-padding">
        <div class="col-lg-12">
            <div style="width:70%; margin: 20px auto" id="subject_body">
                <div id="links" class="pull-left">
                    <?php echo $links; ?>
                </div>

                <div style="margin-top:20px;" class="input-group col-lg-5 pull-right">
                    <input   onkeypress="if (event.keyCode == 13) {
                                searchSubject(this.value)
                            }"  type="text"id="searchSubject" class="form-control col-lg-2" placeholder="Search Subject" />                    

                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default" id="searchLoading"><i class="fa fa-search"></i></button>
                        <button type="button" class="btn btn-default dropdown-toggle" id="sySettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><?php echo $this->session->school_year . ' - ' . ($this->session->school_year + 1) ?></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <?php for ($sy = 2018; $sy <= date('Y'); $sy++): ?>
                                <li onclick="$('#inputSY').val('<?php echo $sy ?>'), $('#sySettings').html('<?php echo $sy . ' - ' . ($sy + 1) ?>')" ><a href="#"><?php echo $sy . ' - ' . ($sy + 1) ?></a></li>

<?php endfor; ?>
                        </ul>
                    </div>
                    <input type="hidden" value="<?php echo $this->session->school_year ?>" id="inputSY" />
                </div>
                <table class="table table-striped col-lg-6">
                    <thead>
                        <tr>
                            <th style="width:10%;">Course Title</th>
                            <th style="width:50%;">Course Description</th>
                            <th style="width:10%; text-align: center">Lecture Unit</th>
                            <th style="width:10%; text-align: center">Lab Unit</th>
                            <th style="width:10%; text-align: center">Pre-requisite</th>
                            <th style="width:10%; text-align: center">No. of Sections</th>
                            <th style="width:10%;  text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="subjectsWrapper" style="overflow-y: scroll;">
                        <?php
                        foreach ($collegeSubjects->result() as $c):
                            $subs = Modules::run('college/subjectmanagement/getSubjectsOffered', $c->s_id);
                            ?>
                            <tr id="<?php echo $c->s_id ?>_li">
                                <td><?php echo $c->sub_code ?></td>
                                <td><?php echo $c->s_desc_title ?></td>
                                <td style="text-align: center"><?php echo $c->s_lect_unit ?></td>
                                <td style="text-align: center"><?php echo $c->s_lab_unit ?></td>
                                <td style="text-align: center"><?php echo $c->pre_req ?></td>
                                <td style="text-align: center" class="pointer">
                                    <button  onclick="getAdd('Section'), selectSubject('<?php echo $c->s_id ?>', '<?php echo $c->sub_code ?>')" class="btn btn-info btn-xs">
                                        <?php echo ($subs->num_rows() > 0 ? $subs->num_rows() : 0) ?>
                                    </button>
                                </td>
                                <td style="text-align: center" class="pointer">
                                    <div class="btn-group" role="group">
                                        <button onclick="editSubject('<?php echo $c->s_id ?>', '<?php echo $c->sub_code ?>', '<?php echo $c->s_desc_title ?>', '<?php echo $c->s_lect_unit ?>', '<?php echo $c->s_lab_unit ?>', '<?php echo $c->pre_req ?>')" title="Edit Subject" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square"></i></button>
                                        <button onclick="deleteSubject('<?php echo $c->s_id ?>')" title="Delete Subject" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                    </div>
                                    </td>
                            </tr>
<?php endforeach; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div> 
</div>
<input type="hidden" id="sub_id" />
<input type="hidden" id="subjects" />
<input type="hidden" id="grade_id" />
<input type="hidden" id="semester" />

<script type="text/javascript">
    $(document).ready(function () {
        $("#inputPreR").select2({tags: [<?php
foreach ($collegeSubjects->result() as $s) {
    echo '"' . $s->sub_code . '",';
}
?>]});

        $("#inputSem").select2();
        $("#searchCourse").select2();
        $('#dcms_tab a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        });

    });

    function deleteSubject(sub_id)
    {
        var url = '<?php echo base_url() . 'college/subjectmanagement/deleteSubject/' ?>';
        var school_year = $('#inputSY').val();
        var con = confirm('Are you sure you want to delete this subject? Please note that you cannot undo this action.');
        if (con == true) {
            $.ajax({
                type: "POST",
                url: url,
                beforeSend: function () {

                },
                data: "sub_id=" + sub_id +'&school_year='+school_year+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
                success: function (response)
                {
                    alert(response);
                    $('#'+sub_id+'_li').remove();
                }

            });
            return false;

        }

    }

    function searchSubject(value)
    {
        var url = '<?php echo base_url() . 'college/subjectmanagement/searchSubjectResult/' ?>' + value + '/' + $('#inputSY').val();
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function () {
                $('#searchLoading').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
            },
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#searchLoading').html('<i class="fa fa-search"></i>');
                $('#subjectsWrapper').html(data);
            }
        });

        return false;
    }

    function editSubject(sub_id, sub_code, sub_desc, lec_unit, lab_unit, pre_req)
    {
        var req = (pre_req == 'None' ? '' : pre_req);

        $('#editCollegeSubject').modal('show');

        $('#editSubId').val(sub_id);
        $('#editSubjectCode').val(sub_code);
        $('#editDesc').val(sub_desc);
        $('#editLectureUnits').val(lec_unit);
        $('#editLabUnits').val(lab_unit);
        $('#editPreR').val(req);

        $("#editPreR").select2({tags: [<?php
foreach ($allSubjects->result() as $s) {
    echo '"' . $s->sub_code . '",';
}
?>]});
    }

    function selectSubject(sub_id, code)
    {
        $('#inputSubject').val(sub_id);
        $('#Code').val(code);

        var url = "<?php echo base_url() . 'college/subjectmanagement/getSectionPerSubject/' ?>" + sub_id + '/' + $('#inputSY').val();
        $.ajax({
            type: "POST",
            url: url,
            data: "sub_id=" + $('#inputSubject').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            //dataType:'json',
            beforeSend: function () {
                $('#subjectPerSection').html('<h6 style="text-align:center;">System is Loading...Thank you for waiting patiently</h6>')
            },
            success: function (data)
            {
                $('#subjectPerSection').html(data)
            }
        });

//            return false;  
    }


    function getAdd(data)
    {
        $('#add' + data).modal('show');
    }

    function addSection()
    {
        var isRequested = 0;

        if ($('#isRequested').is(":checked"))
        {
            isRequested = 1;

        }
        var url = "<?php echo base_url() . 'college/subjectmanagement/addSection/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                sub_id: $('#inputSubject').val(),
                course_id: $('#searchCourse').val(),
                semester: $('#inputSem').val(),
                school_year: $('#inputSY').val(),
                subCode: $('#Code').val(),
                isRequested: isRequested,
                csrf_test_name: $.cookie('csrf_cookie_name')

            },
            dataType: 'json',
//                   beforeSend: function() {
//                            $('#subject_body').show('<i class="fa fa-spinner fa-spin fa-fw text-center"></i>');
//                        },
            success: function (data)
            {
                alert(data.msg)
                location.reload();
            }
        });

        return false;
    }

    function subjectList()
    {
        var url = "<?php echo base_url() . 'college/subjectmanagement/listOfSubjects/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: "value=''" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#subject_body').show('<i class="fa fa-spinner fa-spin fa-fw text-center"></i>');
            },
            success: function (data)
            {
                $('#subject_body').html(data);
                $("#searchCourse").select2({
                    placeholder: "Search Course"
                });
            }
        });

        return false;
    }

    function editCSubjects()
    {
        var allVal = '';
//        $("#addCollegeSubject :input").each(function() {
//          allVal += '&' + $(this).attr('name') + '=' + $(this).val();
//        });

        // alert(allVal)
        var url = "<?php echo base_url() . 'college/subjectmanagement/editCollegeSubject/' ?>" // the script where you handle the form input.
//        alert($('#editCollege').serialize())
        $.ajax({
            type: "POST",
            url: url,
            data: $('#editCollege').serialize() +'&school_year='+$('#inputSY').val()+ '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data)
                location.reload();
            }
        });
    }

    function addCollegeSubjects()
    {
//        var allVal = '';
//        $("#addCollegeSubject :input").each(function() {
//          allVal += '&' + $(this).attr('name') + '=' + $(this).val();
//        });

        // alert(allVal)
        var url = "<?php echo base_url() . 'college/subjectmanagement/addCollegeSubject/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: $('#addCollege').serialize()+'&school_year='+$('#inputSY').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data)
                location.reload();
            }
        });
    }


    function removeSubject()
    {
        var subjects = $('#subjects').val();
        var grade_level = $('#grade_id').val()
        var subject_id = $('#sub_id').val();

        if (grade_level == 12 || grade_level == 13) {
            var sem = $('#semester').val();
            var strand_id = $('#strand_id').val();
            var url = "<?php echo base_url() . 'subjectmanagement/removeSHSubject' ?>"
        } else {
            strand_id = 0;
            sem = 0;
            url = "<?php echo base_url() . 'main/removeSubject' ?>" // the script where you handle the form input.
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "gradeLevel=" + grade_level + "&subject_id=" + subject_id + "&subjects=" + subjects + '&sem=' + sem + '&strand_id=' + strand_id+'&school_year='+$('#inputSY').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                if (grade_level == 12 || grade_level == 13) {
                    $('#' + grade_level + '_' + strand_id + '_' + sem + '_' + subject_id + '_sub').addClass('hide');
                } else {
                    $('#' + subject_id + '_sub').addClass('hide');
                }
                alert(data)
            }
        });

        return false;
    }

</script>

<?php
$this->load->view('addSubject_modal');
