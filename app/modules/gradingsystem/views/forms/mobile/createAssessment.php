<div data-role="page" id="createQuiz"  >
    <?php $this->load->view('headerPanel'); ?>
     <div data-position="fixed" data-role="header" data-theme="b">
         <button onclick="document.location='<?php echo base_url().'main/dashboard' ?>'" class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-notext ui-icon-home">Back</button>
        <h4 id="myModalLabel">Create Assessment</h4>
        <button onclick="window.history.back()" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-right ui-icon-back">Back</button>
    </div>

    <?php
            $assessment = Modules::run('gradingsystem/getAssessCatDropdown', 1);

     ?>
    <div data-role="content">
        <div class="ui-field-contain">
            <div class="controls">
                <input name="inputBdate" type="text" data-date-format="mm-dd-yyyy"  value="<?php echo date("m/d/Y"); ?>" id="inputBdate" placeholder="Search for Date" required>
            </div>        
            <input data-mini="true" name="assessTitle" type="text" id="assessTitle" placeholder="Assessment Title" required>
            <select onchange="$('#selectAssessmentCategoryValue').val($(this).val())" name="selectAssessmentCategory" style="width:93%; height:30px; margin-bottom:15px;" id="selectAssessmentCategory" required>
                <option>Select Assessment Category</option>   
                <?php //echo $assessment; ?>


            </select>
            <input type="hidden" id="selectAssessmentCategoryValue" />
            <input data-mini="true" style="border:none;"  name="noOfItems" type="text" id="noOfItems" placeholder="Number of Items" required>
        </div>
        <div class="ui-field-contain">
          <button onclick="saveAssessment()" id="saveAssessmentBtn" class="ui-shadow ui-btn ui-corner-all ui-mini ui-btn-b">Save </button>

        </div>
    </div>
    
    
      
      <div data-position="fixed"  data-theme="b" data-role="footer" >
                <div data-role="navbar">
                    <ul>
                        <li><a data-transition="slideup"  href="#" onclick="document.location='<?php echo base_url().'gradingsystem' ?>'" data-icon="home">GS Home</a></li>
                        <li><a data-transition="slideup"  href="#createQuiz" onclick="getAssessmentCategory()" data-icon="plus" class="ui-btn-active">Create</a></li>
                        <li><a data-transition="slideup"  href="#recordScore" href="#" onclick="enterRawScore()" data-icon="edit" class="">Enter RS</a></li>
                        <li><a data-transition="slideup"  href="#createQuiz"  onclick="$('#createQuiz').hide(), $('#recordScore').hide(),$('#classRecord').fadeIn(), getClassRecord()" data-icon="grid" class="">View</a></li>
                    </ul>
                </div>

            </div>
</div>
<script type="text/javascript">
$(document).ready(function() {

     $('#saveAssessmentBtn').click(function() {
     
       
    });
})

function saveAssessment()
{
     var url = "<?php echo base_url().'gradingsystem/saveAssessment' ?>"; // the script where you handle the form input.
        var title = $('#assessTitle').val()
        var date = $('#inputBdate').val()
        var section_id = $('#section_id').val()
        var subject_id = $('#subject_id').val()
        var faculty_id = "<?php echo $this->session->userdata('user_id') ?>"
        var no_items = $('#noOfItems').val()
        var quiz_cat = $('#selectAssessmentCategory').val()
        var term = $('#inputTerm').val()

        $.ajax({
               type: "POST",
               url: url,
               data: 'title='+title+"&date="+date+"&section_id="+section_id+"&subject_id="+subject_id+'&faculty_id='+faculty_id+"&no_items="+no_items+"&quiz_cat="+quiz_cat+"&term="+term+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert('Saved!');
//                   $('#success').html(data);
//                   $('#alert-info').fadeOut(5000);
//                   $('#createQuiz').hide();
               }
             });

        return false; // avoid to execute the actual submit of the form.
}
    
   
    
    
</script>