<div id="createQuiz" style="display: none;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="pull-right">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button id="saveAssessmentBtn" data-dismiss="modal" class="btn btn-primary">Save </button>

            </div>
            <h4 id="myModalLabel">Create Assessment</h4>
        </div>
        <div class="panel-body">
            
            <div class=" col-lg-6 col-md-6"> 
                
                <div class="form-group">
                    <div class="controls">
                          <input class="form-control" name="assessDate" type="text" data-date-format="mm-dd-yy" id="assessDate" placeholder="Date of Assessment" required>
                      </div>
                  </div>    
                <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  name="assessTitle" type="text" id="assessTitle" placeholder="Assessment Title" required>
                      </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-group">
                    <div class="controls">
                        <select class="form-control" name="selectAssessmentCategory" style="width:100%;" id="selectAssessmentCategory1" required>
                            <?php// echo $assessment ?>

                        </select>
                      </div>
                </div>
                 
                <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  name="noOfItems" type="text" id="noOfItems" placeholder="Number of Items" required>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#assessDate").datepicker();
    $("#inputDll").select2();
})
    
    $('#saveAssessmentBtn').click(function() {
     
    var url = "<?php echo base_url().'gradingsystem/saveAssessment' ?>"; // the script where you handle the form input.
    var title = $('#assessTitle').val()
    var date = $('#assessDate').val()
    var section_id = $('#section_id').val()
    var subject_id = $('#subject_id').val()
    var faculty_id = "<?php echo $this->session->userdata('username') ?>"
    var no_items = $('#noOfItems').val()
    var quiz_cat = $('#selectAssessmentCategory1').val()
    var term =  $('#inputTerm').val();
    var dll_id = $('#inputDll').val();
    var strand_id = $('#strand_id').val();
    var level_id = $('#level_id').val();
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
                data:{
                    title        : title,
                    dll_id       : dll_id,
                    date         : date,
                    section_id   : section_id,
                    subject_id   : subject_id,
                    faculty_id   : faculty_id,
                    no_items     : no_items,
                    quiz_cat     : quiz_cat,
                    term         : term,
                    strand_id    : strand_id,
                    csrf_test_name:$.cookie('csrf_cookie_name')
               
                }, // serializes the form's elements.
                success: function(data)
                {
                    $('#success').html(data);
                    $('#alert-success').fadeOut(5000);
                    $('#createQuiz').hide();
                }
            });
        }
    
        return false; // avoid to execute the actual submit of the form.
    });
    
    
</script>