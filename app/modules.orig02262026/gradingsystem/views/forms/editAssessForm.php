<div id="editAssessForm" class="modal fade" style="width:350px; margin: 10px auto 0;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>Edit Your Assessment</h4>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <!-- <label>Select Assessment</label>
                   <select class="form-control" name="selectAssessmentCat" id="selectAssessmentCat" required>
                       <option>Select Assessment Category</option>

                   </select> -->
                <label>Number of Items</label>
                <input class="form-control" style="height:30px;" name="no_Items" type="text" id="no_Items" placeholder="Number of Items" required>
                <label>Select Grading</label>
                <select tabindex="-1" id="editTerm" class="form-control">
                    <?php
                    $first = "";
                    $second = "";
                    $third = "";
                    $fourth = "";
                    switch ($this->session->userdata('term')) {
                        case 1:
                            $first = "selected = selected";
                            break;

                        case 2:
                            $second = "selected = selected";
                            break;

                        case 3:
                            $third = "selected = selected";
                            break;

                        case 4:
                            $fourth = "selected = selected";
                            break;
                    }
                    ?>
                    <option>Select Grading</option>
                    <option <?php echo $first ?> value="1">First Grading</option>
                    <option <?php echo $second ?> value="2">Second Grading</option>
                    <option <?php echo $third ?> value="3">Third Grading</option>
                    <option <?php echo $fourth ?> value="4">Fourth Grading</option>

                </select>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label>Assessment Title</label>
                    <input style="margin-right: 10px;" class="form-control" name="editAssessTitle" type="text" id="editAssessTitle" placeholder="Assessment Title" required>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label>Assessment Date</label>
                    <input style="margin-right: 10px;" class="form-control" name="editAssessDate" type="text" data-date-format="mm-dd-yy" id="editAssessDate" placeholder="Date of Assessment" required>
                </div>
            </div>
            <div class="control-group pull-left" id="month" style="width:230px;">

            </div>
        </div>
        <div class="panel-footer">
            <div>
                <button onclick="editAssessment()" data-dismiss="modal" id="saveScoreBtn" class="btn btn-primary col-lg-12" style="float: none;"><i class="fa fa-save fa-fw"></i>Save</button>
            </div>

        </div>
    </div>
</div>

<div id="createAssessment" class="modal fade" style="width:350px; margin: 10px auto 0;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>Create Assessment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="controls">
                    <input class="form-control" name="assessDate" type="text" data-date-format="mm-dd-yy" id="assessDate" placeholder="Date of Assessment" required>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <input class="form-control" name="assessTitle" type="text" id="assessTitle" placeholder="Assessment Title" required>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <input class="form-control" name="noOfItems" type="text" id="noOfItems" placeholder="Number of Items" required>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <input type="hidden" id="selectCategory" />
            <div>
                <button data-dismiss="modal" id="saveAssessment" class="btn btn-primary col-md-6" style="float: none;"><i class="fa fa-save fa-fw"></i> Save</button>
                <button data-dismiss="modal" class="btn btn-danger col-md-6 pull-right" style="float: none;">Cancel</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#assessDate").datepicker();
        $("#inputDll").select2();
    });

    $('#saveAssessment').click(function() {

        var url = "<?php echo base_url() . 'gradingsystem/saveAssessment' ?>"; // the script where you handle the form input.
        var title = $('#assessTitle').val()
        var date = $('#assessDate').val()
        var section_id = $('#section_id').val()
        var subject_id = $('#subject_id').val()
        var faculty_id = "<?php echo $this->session->userdata('username') ?>"
        var no_items = $('#noOfItems').val()
        var quiz_cat = $('#selectCategory').val()
        var term = $('#inputTerm').val();
        var dll_id = $('#inputDll').val();
        var strand_id = $('#strand_id').val();
        var level_id = $('#level_id').val();
        var sy = '<?php echo $sy ?>';
        var proceed = 1;

        if (level_id == 12 || level_id == 13) {
            if (strand_id == 0) {
                alert('Please Select Strand First!');
                proceed = 0;
            }
        }

        if (term == 0) {
            alert('Please Select Grading');
            proceed = 0;
        }

        if (proceed == 1) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    title: title,
                    dll_id: dll_id,
                    date: date,
                    section_id: section_id,
                    subject_id: subject_id,
                    faculty_id: faculty_id,
                    no_items: no_items,
                    quiz_cat: quiz_cat,
                    term: term,
                    strand_id: strand_id,
                    csrf_test_name: $.cookie('csrf_cookie_name')

                }, // serializes the form's elements.
                success: function(data) {
                    $('#success').html(data);
                    $('#alert-success').fadeOut(5000);
                    $('#createQuiz').hide();
                    $('#createAssessment').modal('hide');
                    var url2 = '<?php echo base_url() . 'gradingsystem/enterScore/' ?>' + subject_id + '/' + section_id + '/' + term + '/' + sy;
                    $.ajax({
                        type: 'GET',
                        url: url2,
                        success: function(data) {
                            $('#recordScore').html(data);
                        }
                    })
                }
            });
        }

        return false; // avoid to execute the actual submit of the form.
    });
</script>