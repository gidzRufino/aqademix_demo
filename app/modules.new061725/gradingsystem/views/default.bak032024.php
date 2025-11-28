<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header clearfix" style="margin:0">Grading System
        <div class="col-md-3 pull-right">
          <select style="font-size:16px;"  name="subject"  onclick="getDetails(this.value)" >
              <option>Select Subject ( Section )</option>
              <?php 
                    foreach ($getSubject as $s)
                      {   
                ?>                        
              <option value="<?php echo $s->subject_id.'-'.$s->section_id.'-'.$s->grade_level_id?>"><?php echo $s->subject.' ( '.$s->level.'-'.$s->section.' )'; ?></option>

              <?php }?>
            </select>
                <div id="strandWrapper">
                    
                </div> 
        </div>
        
        <div class="col-md-2 pull-right" id="month" style="">
            <div id="addTerm" class="pull-right">
              <select onclick="$('#importTerm').val(this.value)" style="font-size:16px;"  tabindex="-1" id="inputTerm" class="">
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
                    <option value="0">Select Grading</option>
                    <option <?php echo $first ?> value="1">First Grading</option>
                    <option <?php echo $second ?> value="2">Second Grading</option>
                    <option <?php echo $third ?> value="3">Third Grading</option>
                    <option <?php echo $fourth ?> value="4">Fourth Grading</option>
              </select> 
            </div>
             
        </div>
            <div class="col-md-3 pull-right">
                <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="font-size: 16px; margin-top: 16px;" class="pull-right">
                    <option>School Year</option>
                    <?php 
                          foreach ($ro_year as $ro)
                           {   
                              $roYears = $ro->ro_years+1;
                              if($this->session->userdata('school_year')==$ro->ro_years):
                                  $selected = 'Selected';
                              else:
                                  $selected = '';
                              endif;
                          ?>                        
                        <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                        <?php }?>
                </select>
            </div>
        <?php if(!Modules::run('main/isMobile')): ?>
            <button onclick="document.location='<?php echo base_url().'gradingsystem/downloadGStemplate/' ?>'+$('#section_id').val()+'/'+$('#subject_id').val()+'/'+$('#selectAssessmentCategory1').val()" id="q_template" class="hide btn btn-info btn-sm pull-left" style="margin-right: 10px; margin-top:5px;">Download Eskwela Quiz Template</button>
        <?php endif; ?>
        </h1>
            <input style="height:30px;" type="hidden" value="" id="section_id" /> 
            <input style="height:30px;" type="hidden" value="" id="subject_id" /> 
            <input style="height:30px;" type="hidden" value="" id="grade_id" /> 
            <input style="height:30px;" type="hidden" value="" id="level_id" />  
            <input style="height:30px;" type="hidden" value="0" id="strand_id" /> 
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row" style="margin-top:10px;">
    <div style="cursor: pointer;" onmouseover="$('#formController').val('createQuiz')" onclick="$('#createQuiz').fadeIn(),$('#recordScore').hide(),$('#classRecord').hide()"  class="col-md-4">
        <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i  class="fa fa-plus fa-2x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="text-center " style="cursor: pointer;">
                                <h3 style="margin:0;">
                                    Create Assessment
                                </h3>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    
        
    </div>
    <div class="col-md-4"  style="cursor: pointer;"  onmouseover="$('#formController').val('recordScore')" onclick="$('#createQuiz').hide(), $('#recordScore').fadeIn(),$('#classRecord').hide(), enterRawScore()" >
        <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i  class="fa fa-laptop fa-2x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="text-center " style="cursor: pointer;">
                                <h3 style="margin:0;">
                                    Enter Raw Score
                                </h3>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-md-4" style="cursor: pointer;" onmouseover="$('#formController').val('classRecord')" onclick="$('#createQuiz').hide(), $('#recordScore').hide(),$('#classRecord').fadeIn(), getClassRecord()"  >
        <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i  class="fa fa-file-text fa-2x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="text-center " style="cursor: pointer;">
                                <h3 style="margin:0;">
                                    View Grading Sheet
                                </h3>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
        
        

    <?php
   $is_admin = $this->session->userdata('is_admin');
?>


    <div id="success">
        
    </div>    
    <div class="row-fluid">
        <div class="span12" >
            <div class="span1 pull-left" style="margin:0; border-right:1px black solid; padding-right:5px;">
            </div>
            <div class="span10">
                <!--These are the forms used in the whole grading system-->
                <?php $this->load->view('gradingsystem/forms/createAssessment'); ?>
                <?php $this->load->view('gradingsystem/forms/recordScore'); ?>
                <?php $this->load->view('gradingsystem/classRecord'); ?>
                
            </div>
        </div>
        
    </div>
<input type="hidden" id="formController" value="0" />
<input type="hidden" id="formController2" value="0" />
<input type="hidden" id="setSection" />
<div id="assess_details" class="modal fade" style="width:450px; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<div id="cs_details" class="modal fade" style="width:95%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>

<script type="text/javascript">
    
    function printClassRecord()
    {
        var url = "<?php echo base_url().'reports/printClassRecord/' ?>"+$('#section_id').val()+'/'+$('#subject_id').val()+'/'+$('#inputTerm').val();
        window.open(url, '_blank')
    }
    
    function classRecordDetails()
    {
        var strand_id = $('#strand_id').val()
        var url = "<?php echo base_url().'gradingsystem/classRecordDetails/'?>"+$('#section_id').val()+'/'+$('#subject_id').val()+'/'+$('#inputTerm').val()+'/'+$('#inputSY').val()+'/'+strand_id;
            $.ajax({
             type: "GET",
             url: url,
             data: 'details='+$('#section_id').val(), // serializes the form's elements.
            beforeSend: function() {
                showLoading('cs_details');
            },
             success: function(data)
             {
                $('#cs_details').html(data)

             }
           }); 
        
    }
    
    function getClassProgressReport()
    {
        var url = "<?php echo base_url().'gradingsystem/getClassProgressReport/'?>"+$('#section_id').val()+'/'+$('#subject_id').val()+'/'+$('#inputTerm').val()+'/'+$('#inputSY').val();
            $.ajax({
             type: "GET",
             url: url,
             data: 'details='+$('#section_id').val(), // serializes the form's elements.
             success: function(data)
             {
                $('#pbody').html(data)
                $('#tabular').removeClass('hide')
                $('#graphical').addClass('hide')

             }
           }); 
        
    }
    
    function getClassRecord()
    {
            var section_id = $('#section_id').val()
            var subject_id = $('#subject_id').val()
            var grade_id = $('#grade_id').val()
            var term = $('#inputTerm').val()
            var school_year = $('#inputSY').val()
            var strand_id = $('#strand_id').val()
            
//            $('#submitLoad').removeClass('hide');
//            $('#verify_icon').removeClass('hide');
//            $('#classRecordTables').html($('#submitLoad').html());
            //alert(grade_id)
           if(subject_id!=""){
               var url = "<?php echo base_url().'gradingsystem/getClassRecord/'?>"+subject_id+'/'+section_id+'/'+grade_id+'/'+term+'/'+school_year+'/'+strand_id ;
                $.ajax({
                 type: "GET",
                 url: url,
                 data: 'details='+section_id, // serializes the form's elements.
                beforeSend: function() {
                    showLoading('classRecordTables');
                },
                 success: function(data)
                 {
                     //$("form#quoteForm")[0].reset()
                    $('#classRecordTables').html(data)
//                    $('#submitLoad').addClass('hide');
//                    $('#verify_icon').addClass('hide');
                   
                 }
               }); 
           }else{
                //alert('Please Select Subject First');
                //location.reload();
           } 
           
    }

     $(document).ready(function() {
         
          $("#assessDate").datepicker();
          $("#searchAssessDate").select2();
          //$("#subject").select2();
          $("#selectQuizCategory").select2({
              
          });
          $('#recordStudent').select2({
               minimumInputLength: 1
          });
         
          $("#inputQuizCategory").select2(); 
          $("#recordSection").select2({
            }); 
          $("#selectSection").select2({
            }); 
          //$("#selectSubject").select2(); 
          $("#selectSubjectA").select2(); 
          $("#inputGradeModal").select2(); 
          $("#selectQuizSubject").select2(); 
          
          //from gradingSettingsForm
          $('#fromFirstQuarter').datepicker();
          
          
          
          
      });
      
      function getAssessmentCategory()
      {
           var department = $('#grade_id').val();
           var url = "<?php echo base_url().'gradingsystem/getAssessCatDropdown/'?>"+department ;
         if(department!=""){  
            $.ajax({
             type: "GET",
             url: url,
             data: 'details='+department, // serializes the form's elements.
             success: function(data)
             {
                 
                 //$("form#quoteForm")[0].reset()
                $('#selectAssessmentCategory').html(data)

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
            var sy = $('#inputSY').val()
            
            if(section_id!=""){
                var url = "<?php echo base_url().'gradingsystem/getAssessment/'?>" ;
                    $.ajax({
                     type: "POST",
                     url: url,
                     data: 'section_id='+section_id+"&subject_id="+subject_id+"&term="+term+"&school_year="+sy+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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
      
      function getDetails(section){
           
          var term = $('#inputTerm').val() 
          var url = "<?php echo base_url().'gradingsystem/getSectionAndSubject/'?>"+section+'/'+term ;
          $.ajax({
           type: "GET",
           url: url,
           dataType: 'json',
           data: 'details='+section, // serializes the form's elements.
           success: function(data)
           {
               //alert('hey')
               //$("form#quoteForm")[0].reset()
              // console.log(data)
              $('#section_id').val(data.section_id)
              $('#subject_id').val(data.subject_id)
              $('#grade_id').val(data.grade_id)
              $('#level_id').val(data.level_id)
              $('#strandWrapper').html(data.strand_id)
              $('#selectAssessmentCategory1').html(data.assessment)
              $('#selectAssessmentCat').html(data.assessment)
              $('#q_template').removeClass('hide')
              $('#importTempSub').val(data.subject_id);
              $('#importTempSection').val(data.section_id);
              $('#importTempTerm').val($('#inputTerm').val())
           }
         });
      }
      function getSubject(subject){
          $('#createSubjectId').val(subject);
    }
     
      function getQuizBySubject(subject){
          document.getElementById('setSection').value='getQuizBySubject'
          var date = $('#getDate').val()
          
          
          var data = new Array();
          
          data[0] = subject;
          data[1] = date;
          
            if(data[0]!=""){
               // alert(subject)
                sectionAction(data)
            }
      }

</script>
