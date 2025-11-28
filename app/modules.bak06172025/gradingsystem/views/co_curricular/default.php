<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:0"><span id="coTitle">Co-Curricular Management</span> <?php if($this->uri->segment(4)!=""): ?><small><a href="#" onclick="getRanking('<?php echo $this->uri->segment(4) ?>')">[ View Ranking ]</a></small><?php endif; ?>
           
    <?php if($this->uri->segment(4)!=""): ?>
            <small class="pull-right">
            <div class="control-group pull-right" style="width:230px;">
                <div class="controls" id="AddedSection">
                  <select  onclick="getCC(this.value)" style="width:230px; font-size:14px"  name="inputSection" id="inputStudent" class="pull-left col-lg-12" required>
                       <option>Select Student</option> 
                     <?php  foreach ($students->result() as $s)
                        {     
                     ?>
                       <option value="<?php echo base64_encode($s->stid) ?>"><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></option>  
                     <?php } ?>
                  </select>
                </div>
            </div>
            
               <select tabindex="-1" id="inputTerm" style="width:200px" class="span2">
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
            </small>
     <?php endif; ?>   
            
        </h3>
         
    </div>
</div>
<div class="row">
<?php if($this->uri->segment(4)==""): ?>
    <div class="col-lg-3"></div>

    <div class="col-lg-12 col-md-12" id="individual" style="margin:20px auto 0; ">
                <div class="pull-left" style="width:250px; margin-right:10px;">
                    <select  name="inputGrade" onclick="selectSection(this.value)" style="width:100%;" id="inputGrade" required>
                        <option>Select Grade Level</option> 
                       <?php 
                              foreach ($gradeLevel as $level)
                                {   
                          ?>                        
                        <option sec="<?php echo $level->level; ?>" value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                        <?php }?>
                  </select>
                </div>
                <div  class="pull-left" style="width:250px;">
                    <select onclick="getStudentsBySection(this.value)" style="width:100%;" name="inputSection" id="inputSection" required>
                      <option>Select Section</option>  
                  </select>
                </div>
    </div>
<?php endif; ?>
    <div id="cc_body" class="clearfix">
    
    </div>
</div>
<?php $this->load->view('cc_modal'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#selectReport').select2();
        $('#inputGrade').select2();
        $('#inputSection').select2();
        $('#inputStudent').select2();
        $('#eventDate_1').datepicker();
        $('.eventDate').click(function(){
            $(this).datepicker(); 
        })
    });
    
    
    function getRanking(grade_id)
    {
        var url = "<?php echo base_url()?>gradingsystem/co_curricular/getRanking/"+grade_id;
        $.ajax({
           type: "GET",
           url: url,
           data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
             $('#cc_body').html(data);
             $('#coTitle').html('Selected Honor Pupils / Students')
           }
         });
    }
    
    function getDate(id)
    {
       $('#'+id).datepicker(); 
    }
    
    function getCC(id)
    {
        var url = "<?php echo base_url()?>gradingsystem/co_curricular/getCC/"+id;
        $.ajax({
           type: "GET",
           url: url,
           data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
             $('#cc_body').html(data);
             $('#coTitle').html('Co-Curricular Management')
           }
         });

    return false;
    }
    
    function selectSection(level_id){
      var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputSection').html(data);
               }
             });

        return false;
      }
      
      function getStudentsBySection(section_id)
      {
          var url = "<?php echo base_url()?>gradingsystem/co_curricular/main/"+section_id;
          document.location = url;
      }
      
      function getCC_cat(id)
      {
          var url = "<?php echo base_url()?>gradingsystem/co_curricular/getCC/";
            $.ajax({
               type: "POST",
               url: url,
               data: 'id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   
               }
             });

    return false;
      }
      
      function getCC_level(part_pos, id)
      {
          
          var url = "<?php echo base_url()?>gradingsystem/co_curricular/getRank/";
            $.ajax({
               type: "POST",
               url: url,
               data: 'cat_id='+id+'&part_pos='+part_pos+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputPart_Pos_'+id).html(data);
               }
             });

        return false;
      }
      
      function deleteCC(id)
      {
          var answer = confirm("Do you really want to Delete this Particular Co-Curricular Record.");
          if(answer==true){
          var url = "<?php echo base_url()?>gradingsystem/co_curricular/deleteCCParticipation/"+id;
            $.ajax({
               type: "Get",
               url: url,
               data: 'cc_id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                  alert(data)
                  location.reload()
               }
             });

        return false;
        }else{
            
        }
      }
      
      function editCC(id, cat_id)
      {
          $('#cc_id_'+cat_id).val(id)
          var url = "<?php echo base_url()?>gradingsystem/co_curricular/getCCInvolvementById/"+id;
            $.ajax({
               type: "Get",
               url: url,
               dataType:'json',
               data: 'cc_id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#eventDate_'+cat_id).val(data.date)
                   $('#eventDate_'+cat_id).attr('placeholder',data.date)
                   $('#eventName_'+cat_id).val(data.name_event)
                   $('#level_'+cat_id).html('[ Current : '+data.part_pos+' ]')
                   $('#inputPart_Pos_current_'+cat_id).html('[ Current : '+data.rank+' ]')
               }
             });

        return false;
      }
      
      function saveCCParticipation(id)
      {
          
          var cc_id = $('#cc_id_'+id).val()
          var st_id  = $('#inputStudent').val()
          var event_date  = $('#eventDate_'+id).val()
          var event_name  = $('#eventName_'+id).val()
          var term  = $('#inputTerm').val()
          var inputPart_Pos  = $('#inputPart_Pos_'+id).val()
          
          var url = "<?php echo base_url()?>gradingsystem/co_curricular/saveCCParticipation/";
            $.ajax({
               type: "POST",
               url: url,
               data: 'part_id='+inputPart_Pos+'&cc_id='+cc_id+'&st_id='+st_id+'&event_name='+event_name+'&event_date='+event_date+'&term='+term+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data)
               }
             });

        return false;
      }
    
</script>