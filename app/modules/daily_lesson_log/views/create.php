<div class="col-lg-12">
    <h3 class="page-header clearfix" style="margin:15px 0 0 0">Create a Lesson Log</h3>
</div>
<div class="col-lg-3"></div>
<div class="col-lg-6 no-padding">
    <div class="panel panel-green">
        <div class="panel-heading">
            <button title="Lesson List" onclick="getDLL('<?php echo base64_encode($this->session->userdata('username')) ?>')" class="btn btn-danger pull-right" style="margin-left:5px;"><i class="fa fa-list"></i></button>
            <h4 ondblclick="$('#a_dll_title').hide(), $('#dll_title').show(),$('#dll_title').val($(this).html())" id="a_dll_title" style="display: none;"></h4>
            <input placeholder="Please Enter your Lesson Title" style="width:300px; color:black" type="text" id="dll_title"
                       onkeypress="if (event.keyCode==13){$('#a_dll_title').html(this.value),$('#a_dll_title').show(), $('#dll_title').hide(), showRel()}"
                        title=""
                        onblur="if(this.value!=''){$('#a_dll_title').show(), $('#dll_title').hide()}"/> 
        </div>
        <div style="display: none;" id="dll_body" class="panel-body">
            <div class="form-control">
                <label>Select Subject ( Section )</label>
                <select class="pull-right" style="font-size:16px;"  name="subject"  onclick="getDetails(this.value)" >
                    <option></option>
                    <?php 
                          foreach ($getSubject as $s)
                            {   
                      ?>                        
                    <option value="<?php echo $s->subject_id.'-'.$s->section_id.'-'.$s->grade_level_id?>"><?php echo $s->subject.' ( '.$s->section.' )'; ?></option>

                    <?php }?>
                  </select>
                <input style="height:30px;" type="hidden" value="" id="section_id" /> 
                <input style="height:30px;" type="hidden" value="" id="subject_id" /> 
                <input style="height:30px;" type="hidden" value="" id="grade_id" /> 
            </div>
            <br />
            <div class="form-control">
                <label>Date of Lesson</label>
                <input style="height:23px; width:200px; font-size: 16px; margin-left:5px" class="pull-right" name="lessonDate" value="<?php echo date('Y-m-d') ?>" type="text" data-date-format="yyyy-mm-dd" id="lessonDate" placeholder="Date of Lesson" required>
            </div>
            <br />
            <div id="dll_ref" style="display: none;" class="panel panel-red col-lg-12 no-padding">
                <div class="panel-heading clearfix" style="padding:5px 10px;">
                    <button class="btn btn-sm btn-primary pull-right"
                            rel="clickoverDll" 
                            data-content=" 
                                    <?php
                                        $this->load->view('addReference');
                                    ?>
                                  "   
                            data-toggle="modal">
                        <i class="fa fa-plus"
                           ></i></button>
                    <h4 class="panel-title">References :</h4>
                </div>
            </div>
            
        </div>
        <div class="panel-footer clearfix" id="dll_footer" style="display: none;">
            <button onclick="createDLL()" class="btn btn-primary pull-right"><i class="fa fa-save"></i></button>
            <input style="height:30px;" type="hidden" value="" id="dll_id" /> 
        </div>
    </div>
</div>
<div class="col-lg-3"></div>

<script type="text/javascript">
$(document).ready(function() {
    $("#lessonDate").datepicker();
});


    function createDLL()
    {
        var dll_id = $('#dll_id').val();
        var dll_date = $('#lessonDate').val();
        var section_id = $('#section_id').val()
        var subject_id = $('#subject_id').val()
        var grade_id = $('#grade_id').val()
        
        if(dll_id==""){
            var url = "<?php echo base_url().'daily_lesson_log/saveDLL/'?>"; // the script where you handle the form input.

            $.ajax({
                   dataType: "json",
                   type: "POST",
                   url: url,
                   data: "title="+$('#dll_title').val()+'&section_id='+section_id+'&grade_id='+grade_id+'&subject_id='+subject_id+'&dll_date='+dll_date+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                        $('#dll_id').val(data.dll_id)
                        $('#a_dll_title').show()
                        $('#a_dll_title').html($('#dll_title').val())
                        $('#dll_title').hide()
                        alert('DLL Successfully Saved!')
                   }
                 });

            return false;
            
        }
    }
    
    function saveMatType()
    {
        var ref = $('#matType').val();
       var page_num = $('#mat_page_num').val()
       var dll_id = $('#dll_id').val();
       var url = "<?php echo base_url().'daily_lesson_log/addMaterial/'?>"+ref+'/'+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Material Reference Saved!')
                       $('#materialUsed').append(data);
                   }
                 });

            return false;
    }
    
    function getDLL(t_id)
    {
        var url = "<?php echo base_url().'daily_lesson_log/getDLL/'?>"+t_id; // the script where you handle the form input.
        document.location = url;
          
    }


    function addReference()
    {
       var ref = $('#refType').val();
       var page_num = $('#page_num').val()
       var dll_id = $('#dll_id').val();
       var url = "<?php echo base_url().'daily_lesson_log/addReference/'?>"+ref+'/'+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       
                   }
                 });

            return false;
    }
function showRel()
{
    $('#dll_body').show();
    $('#dll_footer').show();
    $('[rel="clickoverDll"]').clickover({
        placement: 'top',
        html: true
      }); 
    $('.addButton').clickover({
        placement: 'top',
        html: true
      }); 
    $('#refType').select2();
    
}
    function getDetails(section){
           
          var url = "<?php echo base_url().'gradingsystem/getSectionAndSubject/'?>"+section ;
          $.ajax({
           type: "GET",
           url: url,
           dataType: 'json',
           data: 'details='+section, // serializes the form's elements.
           success: function(data)
           {
              $('#section_id').val(data.section_id)
              $('#subject_id').val(data.subject_id)
              $('#grade_id').val(data.grade_id)
           }
         });
      }
</script>