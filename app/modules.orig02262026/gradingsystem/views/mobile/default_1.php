<div data-role="page" id="default">
    <?php $this->load->view('headerPanel'); ?>
   <div style="height:55px;" data-role="header" data-theme="b">
        <?php
         if($this->session->userdata('is_logged_in')):
        ?>
            <a data-iconshadow="true" data-theme="b" data-toggle="modal" href="#leftpanel3">
                <i style="font-size: 25px; padding: 0; margin:0;" class="fa fa-list-alt"></i>
            </a>
        <?php     
         endif;
        ?>
        <h1 id="headerTitle" style="margin:0; font-size:18px;">Grading System</h1>
        <button onclick="window.history.back()" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-right ui-icon-back">Back</button>
    </div>
      <select id="inputTerm" data-native-menu="false">
          <?php
             $first = "";
             $second = "";
             $third = "";
             $fourth = "";
             switch($this->session->userdata('term')){
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
            <option >Select Grading</option>
            <option <?php echo $first ?> value="1">First Grading</option>
            <option <?php echo $second ?> value="2">Second Grading</option>
            <option <?php echo $third ?> value="3">Third Grading</option>
            <option <?php echo $fourth ?> value="4">Fourth Grading</option>

      </select>
    <select name="select-choice-a" id="select-choice-a" data-native-menu="false" onchange="getDetails(this.value)" >
        <option>Select Subject ( Section )</option>
            <?php 
              foreach ($getSubject as $s)
                {     
          ?>                        
            <option value="<?php echo $s->subject_id.'-'.$s->section_id.'-'.$s->grade_level_id?>"><?php echo $s->subject.' ( '.$s->section.' )'; ?></option>

            <?php }?>
    </select>

<input type="hidden" value="<?php echo $this->uri->segment(3); ?>" id="section_id" /> 
<input type="hidden" value="<?php echo $this->uri->segment(2); ?>" id="subject_id" /> 
<input type="hidden" value="<?php echo $this->uri->segment(3); ?>" id="grade_id" /> 
    <!--These are the forms used in the whole grading system-->

    <div id="gs_footer" class="hide" >
            <div data-position="fixed"  data-theme="b" data-role="footer" >
                <div data-role="navbar">
                    <ul>
                        <li><a data-transition="slideup"  href="#createQuiz" onclick="getAssessmentCategory()" data-icon="plus" >Create</a></li>
                        <li><a data-transition="slideup"  href="#recordScore"  onclick="enterRawScore()" data-icon="edit" class="">Enter RS</a></li>
                        <li><a data-transition="slideup"  href="#classRecord"  onclick="getClassRecord()" data-icon="grid" class="">View</a></li>
                    </ul>
                </div>

            </div>
    </div>
</div>
<?php $this->load->view('gradingsystem/forms/mobile/createAssessment'); ?>
<?php $this->load->view('gradingsystem/forms/mobile/recordScore'); ?>
<?php $this->load->view('gradingsystem/mobile/classRecord'); ?>

<div id="submitLoad" class="hide">
            <div class="submitLoad">
               <img src="<?php echo base_url().'images/loading.gif' ?>" style="width:50%" />
           </div>
</div>
<script type="text/javascript">
    function getClassRecord()
    {
        $('#submitLoad').removeClass('hide');
        $('#verify_icon').removeClass('hide');
        $('#classRecordTables').html($('#submitLoad').html());
        
          var section_id = $('#section_id').val()
            var subject_id = $('#subject_id').val()
            var grade_id = $('#grade_id').val()
            var term = $('#inputTerm').val()
            
           if(section_id!=""){
               var url = "<?php echo base_url().'gradingsystem/getClassRecord/'?>"+subject_id+'/'+section_id+'/'+grade_id+'/'+term  ;
                $.ajax({
                 type: "GET",
                 url: url,
                 data: 'details='+section_id, // serializes the form's elements.
                 success: function(data)
                 {
                     //$("form#quoteForm")[0].reset()
                    $('#classRecordTables').html(data)
                    $('#submitLoad').addClass('hide');
                    $('#verify_icon').addClass('hide');

                 }
               }); 
           }else{
                alert('Please Select Subject First');
                location.reload();
           } 
           
    }

     $(document).ready(function() {
          $("#inputBdate").datepicker();
          $("#headerTitle").html('Grading System');


          //from gradingSettingsForm
          
          $('#thisSubject').tap(function(){
                var section = $(this).val();
                alert(section)
                var url = "<?php echo base_url().'gradingsystem/getSectionAndSubject/'?>"+section ;
               $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: 'details='+section, // serializes the form's elements.
                success: function(data)
                {
                    //$("form#quoteForm")[0].reset()
                   $('#section_id').val(data.section_id)
                   $('#subject_id').val(data.subject_id)
                   $('#grade_id').val(data.grade_id)

                }
              });
          })
          
      
          
          
      });
      
      function getDetails(section){
        var url = "<?php echo base_url().'gradingsystem/getSectionAndSubject/'?>"+section ;
          $.ajax({
           type: "GET",
           url: url,
           dataType: 'json',
           data: 'details='+section, // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
              $('#section_id').val(data.section_id)
              $('#subject_id').val(data.subject_id)
              $('#grade_id').val(data.grade_id)
              $('#gs_footer').removeClass('hide')
           }
         });
      }
      function getAssessmentCategory()
      {
         // alert('hey')
           var department = document.getElementById('grade_id').value;
           var url = "<?php echo base_url().'gradingsystem/getAssessCatDropdown/'?>"+department ;
         if(department!=""){  
            $.ajax({
             type: "GET",
             url: url,
             data: 'details='+department, // serializes the form's elements.
             success: function(data)
             {
                 //$("form#quoteForm")[0].reset()
                //$('#selectAssessmentCategory').html(data)

             }
           });
         }else{
                alert('Please Select Subject First');
                location.reload();
           } 
      }
      
      function enterRawScore()
      {
            var section_id = $('#section_id').val()
            var subject_id = $('#subject_id').val()
            var term = $('#inputTerm').val()
            
            if(section_id!=""){
                //alert('ey')
                var url = "<?php echo base_url().'gradingsystem/getAssessment/'?>" ;
                    $.ajax({
                     type: "POST",
                     url: url,
                     data: 'section_id='+section_id+"&subject_id="+subject_id+"&term="+term+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                     success: function(data)
                     {
                         
                         $('#searchAssessDate').html(data);
                         $.mobile.loading( "hide" );
                   }
                 });
            }else{
                alert('Please Select Subject First');
                location.reload();
           } 
            
      }
      
     
      

      function getSubject(subject){
          document.getElementById('createSubjectId').value = subject;
    }
     
      function getQuizBySubject(subject){
          document.getElementById('setSection').value='getQuizBySubject'
          var date = document.getElementById('getDate').value
          
          
          var data = new Array();
          
          data[0] = subject;
          data[1] = date;
          
            if(data[0]!=""){
               // alert(subject)
                sectionAction(data)
            }
      }


</script>