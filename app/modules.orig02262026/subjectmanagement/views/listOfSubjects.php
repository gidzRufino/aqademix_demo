<div class="row" style="height: 100vh;" >
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">List of Subjects
             
        <div class="form-group input-group pull-right" id="searchBox" >
                    <input style="width:250px;" onkeyup="search(this.value)" class="form-control pull-left" id="verify" placeholder="Search" type="text">
                    <span class="input-group-btn pull-left">
                        <button class="btn btn-default">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>    
                        <button onclick="$('#addSubject').modal('show')" class="btn btn-success">
                            <i id="verify_icon" class="fa fa-plus"></i>
                        </button>    
                    </span> 
            </div>
        </h3>
            
    </div>
    
    <div style="width:80%; margin:0 auto;" class="clearfix">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width:5%;">ID</th>
                    <th style="width:50%;">Subject</th>
                    <th style="width:20%;">Subject Code</th>
                    <th style="width:35%; text-align: right">Action</th>
                    <th style="width:10%;">Is Core</th>
                </tr>
            </thead>
            <tbody id="subjectsWrapper" style="overflow-y: scroll;">
                <?php foreach($subjects as $s):
                        $isSubjUse = Modules::run('subjectmanagement/checkSubjectSettings', $s->subject_id);
                ?>
                        <tr id='tr_<?php echo $s->subject_id ?>'>
                            <td><?php echo $s->subject_id; ?></td>
                            <td id="td_<?php echo $s->subject_id; ?>"><?php echo $s->subject ?></td>
                            <td><?php echo $s->short_code ?></td>
                            <td>
                                <button onclick="showModal('<?php echo addslashes($s->subject) ?>','<?php echo $s->subject_id ?>','<?php echo addslashes($s->short_code) ?>')" class="btn btn-xs btn-warning pull-right"><i class="fa fa-edit fa-fw"></i></button>
                                <button onclick="deleteModal('<?php echo $s->subject ?>','<?php echo $s->subject_id ?>', '<?php echo ($isSubjUse->num_rows() > 0 ? 1 : 0) ?>')" class="btn btn-xs btn-danger pull-right"><i class="fa fa-trash fa-fw"></i></button>
                            
                            </td>
                            <td style="text-align: center"><input onclick="makeCore('<?php echo $s->subject_id; ?>')" type="checkbox" <?php if($s->is_core) echo "checked='checked'" ?> /></td>
                        </tr>
                <?php endforeach; ?>
                
            </tbody>
            <tfoot>
                <tr id="links">
                    <th colspan="3">
                        <?php echo $links ?>
                    </th>
                    <th>

                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    
    
</div>
<div id="addSubject"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Subject</h6>
        </div>
        <div class="panel-body">
            <label>Subject Description</label>
            <input value="" class="form-control"  name="inputAddSubject" type="text" id="inputAddSubject" placeholder="Add Subject" />
            <label>Subject Code</label>
            <input value="" class="form-control"  name="AddSubjectCode" type="text" id="AddSubjectCode" placeholder="Add Subject Code" />
            <input type="hidden" id="sub_id" />
            <div style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addSubject()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="editSubject"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Edit Subject</h6>
        </div>
        <div class="panel-body">
            <label>Subject Description</label>
            <input value="" class="form-control"  name="inputSubject" type="text" id="subject" placeholder="Edit Subject" />
            <label>Subject Code</label>
            <input value="" class="form-control"  name="subjectCode" type="text" id="subjectCode" placeholder="Edit Subject Code" />
            <input type="hidden" id="sub_id" />
            <div style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='editSubject()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<div id="deleteSubject"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to delete this subject, this might be connected to other modules of the system, make sure you know what you are doing
                ? Please note also that you can't undo this action.
            </h3>
        </div>
        <div class="panel-body">
                <input type="hidden" id="sub_id" />
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='deleteSubject()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-left'>Delete</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

function search(subject)
{

    var url = "<?php echo base_url().'subjectmanagement/searchSubject/'?>" // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: "subject="+subject+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
           success: function(data)
           {
               $('#subjectsWrapper').html(data);
               $('#links').hide();
           }
    });
}

function makeCore(sub_id)
{

    var url = "<?php echo base_url().'subjectmanagement/makeCore/'?>" // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: "sub_id="+sub_id+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
           success: function(data)
           {
              alert('Successfully Updated')
           }
    });
}

function deleteModal(subject, sub_id, isUse)
{
    if (isUse == 1){
        alert('Cannot delete the Subject. Subject is in use');
    } else {
        $('#deleteSubject').modal('show');
        setTimeout(function(){
            $('#subject').val(subject);
            $('#sub_id').val(sub_id);
        }, 100);
    }
}

function showModal(subject, sub_id, short_code)
{
    $('#editSubject').modal('show');
    setTimeout(function(){
        $('#subject').val(subject);
        $('#sub_id').val(sub_id);
        $('#subjectCode').val(short_code);
    }, 100);
}

function deleteSubject()
{
    var sub_id = $('#sub_id').val()
    var subjects = $('#subject').val()

    var url = "<?php echo base_url().'subjectmanagement/deleteSubject/'?>" // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: "sub_id="+sub_id+"&subject="+subjects+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                     , // serializes the form's elements.
           success: function(data)
           {
              $('#tr_'+sub_id).hide();
              $('#deleteSubject').modal('hide');
              alert('Successfully Deleted')
           }
    });
}


function addSubject()
{
    var subject = $('#inputAddSubject').val();
    var sCode = $('#AddSubjectCode').val();

    var url = "<?php echo base_url() . 'subjectmanagement/addSubject/' ?>"; // the script where you handle the form input.

    $.ajax({
        type: "POST",
        url: url,
        data: "subject=" + subject + "&subjectCode="+ sCode + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function (data)
        {
            alert(data)
        }
    });
}

function editSubject()
{
    var sub_id = $('#sub_id').val()
    var subjects = $('#subject').val()
    var sCode = $('#subjectCode').val();

    var url = "<?php echo base_url() . 'subjectmanagement/editSubject/' ?>" // the script where you handle the form input.

    $.ajax({
        type: "POST",
        url: url,
        data: "sub_id=" + sub_id + "&subject=" + subjects + "&subCode="+ sCode + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function (data)
        {
            $('#td_' + sub_id).html(subjects)
            $('#editSubject').modal('hide');
            alert('Successfully Updated')
        }
    });
}
 </script>