<div class="row">
    <div class="col-lg-12">
        <h4>One Touch Grading System <i onclick="window.history.back()" class="fa fa-arrow-left pull-right"></i></h4>
    </div>
</div>

<div class="ui-grid-b"  id="gradingSystem_icons">
        <div class="ui-block-a">
            <div class="ui-bar ui-bar-a">
                <div class="panel panel-default" onclick="$('#gradingSystem_icons').hide(), $('#createQuiz').show(), getAssessmentCategory()" >
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-plus fa-2x text-center"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui-block-b"><div class="ui-bar ui-bar-a"> 
                <a href="#" onclick="$('#gradingSystem_icons').hide(),$('#subject_container').hide(), $('#recordScore').show(), enterRawScore()" class="text-center " style="cursor: pointer;">
                    <img  class="mobile-icon" style=" width:75px; margin:0 auto;" src="<?php echo base_url().'images/addQuiz.png'?>" /> <br />
                    Enter Raw Score
            </a>
            </div>
        </div>
        <div class="ui-block-c">
            <div class="ui-bar ui-bar-a">
                <a href="#" onmouseover="document.getElementById('formController').value='classRecord'" onclick="$('#createQuiz').hide(), $('#recordScore').hide(),$('#classRecord').fadeIn(), getClassRecord()" class="text-center " style="cursor: pointer;">
                    <img  class="mobile-icon" style="width:75px; margin:0 auto;" src="<?php echo base_url().'images/addQuiz.png'?>" /> <br />
                    View Grading Sheet
                </a>
            </div>
        </div>
</div>

<div class="span12">
    <!--These are the forms used in the whole grading system-->
    <?php $this->load->view('gradingsystem/forms/mobile/createAssessment'); ?>
    <?php $this->load->view('gradingsystem/forms/mobile/recordScore'); ?>
    <?php $this->load->view('gradingsystem/mobile/classRecord'); ?>

</div>
<input type="hidden" id="formController" value="0" />
<input type="hidden" id="formController2" value="0" />
<input type="hidden" id="setSection" />

<div data-position="fixed"  data-theme="b" data-role="footer" >
    <div data-role="navbar">
        <ul>
            <li><a href="#" onclick="$('#gradingSystem_icons').hide(), $('#createQuiz').show(), getAssessmentCategory()" data-icon="plus" class="ui-btn-active">Create</a></li>
            <li><a href="#" onclick="$('#gradingSystem_icons').hide(),$('#subject_container').hide(), $('#recordScore').show(), enterRawScore()" data-icon="edit" class="">Enter RS</a></li>
            <li><a href="#" onclick="$('#createQuiz').hide(), $('#recordScore').hide(),$('#classRecord').fadeIn(), getClassRecord()" data-icon="grid" class="">View</a></li>
        </ul>
    </div>
 
</div>
<script type="text/javascript">
    function getClassRecord()
    {
          var section_id = $('#section_id').val()
            var subject_id = $('#subject_id').val()
            var grade_id = $('#grade_id').val()
            
           if(section_id!=""){
               var url = "<?php echo base_url().'gradingsystem/getClassRecord/'?>"+subject_id+'/'+section_id+'/'+grade_id ;
                $.ajax({
                 type: "GET",
                 url: url,
                 data: 'details='+section_id, // serializes the form's elements.
                 success: function(data)
                 {
                     //$("form#quoteForm")[0].reset()
                    $('#classRecordTables').html(data)

                 }
               }); 
           }else{
                alert('Please Select Subject First');
                location.reload();
           } 
           
    }

     $(document).ready(function() {
         
          
          $("#assessDate").datepicker();


          //from gradingSettingsForm
          $('#fromFirstQuarter').datepicker();
          
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
        var  details = section.split('-');
     if(details[0]>0){
           var url = "<?php echo base_url().'gradingsystem/subject/'?>"+details[0]+'/'+details[1]
        document.location = url;
       }
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
            
            if(section_id!=""){
                var url = "<?php echo base_url().'gradingsystem/getAssessment/'?>" ;
                    $.ajax({
                     type: "POST",
                     url: url,
                     data: 'section_id='+section_id+"&subject_id="+subject_id, // serializes the form's elements.
                     success: function(data)
                     {
                         $('#searchAssessDate').html(data);

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
      
      
$(function(){ // document ready
 
  if (!!$('.sticky').offset()) { // make sure ".sticky" element exists
 
    var stickyTop = $('.sticky').offset().top; // returns number
 
    $(window).scroll(function(){ // scroll event
 
      var windowTop = $(window).scrollTop(); // returns number
 
      if (stickyTop < windowTop){
        $('.sticky').css({ position: 'fixed', top: 0 });
      }
      else {
        $('.sticky').css('position','static');
      }
 
    });
 
  }
 
});

</script>