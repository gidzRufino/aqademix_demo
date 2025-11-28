<div id="addCandidate"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h6 class="col-lg-6">Add Candidates</h6>
        </div>
        <div class="panel-body">
                <div class="col-lg-12">
                    <div class="controls " id="searchControls">
                        <input autocomplete="off"  class="form-control" onkeydown="searchStudent(this.value)" name="inputStudent" type="text" id="inputStudent" placeholder="Search Student" required>
                        <input type="hidden" id="userId" name="userId" value="0" />
                      </div>
                      <div style="position: absolute; min-height: 30px; background: #FFF; width:85%; display: none; z-index: 1000" class="resultOverflow" id="studentSearch">

                      </div>
                </div>

                <div class="col-lg-12" id="profile" style="display: none;">
                    <img id="profileImage" class="img-circle img-responsive pull-left" style="width:100px; border:5px solid #fff" src="<?php echo base_url().'uploads/noImage.png';  ?>" />
                    <div class="col-lg-8">
                        <h4 id="name">Firstname Lastname</h4>
                        <h5 class=" no-margin" style="color: red; font-weight: bold;"><span id="course" class="text-danger"></span></h5>
                        <h5 class=" no-margin" style="color: red; font-weight: bold; margin-left: 15px; float:left;"><span id="year_level" class="text-danger"></span></h5>
                    </div>
                    
                </div>
            <div class="form-group">
                <label class="control-label">Select Position</label>
                <select tabindex="-1" id="canPosition" name="canPosition"  class="col-lg-12">
                   <option>Select Position</option>
                   <?php 
                        foreach ($position as $p):
                   ?>         
                    <option value="<?php echo $p->pos_id ?>"><?php echo $p->candidate_position ?></option>  
                   <?php
                        endforeach;
                   ?>
                   
               </select>
             </div>
            
        </div>
        <div class="panel-footer" style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='addCandidate()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>
<div id="registerVoter"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h6 class="col-lg-6">SCAN VOTER's ID</h6>
        </div>
        <div class="panel-body">
                <div class="col-lg-12">
                    <div class="controls " id="scanControls">
                        <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
                        
                        <input type="hidden" id="scanUserId" name="scanUserId" value="0" />
                      </div>
                </div>

                <div class="col-lg-12" id="scanProfile" style="display: none;">
                    <img id="scanProfileImage" class="img-circle img-responsive pull-left" style="width:100px; border:5px solid #fff" src="<?php echo base_url().'uploads/noImage.png';  ?>" />
                    <div class="col-lg-8">
                        <h4 id="scanName">Firstname Lastname</h4>
                        <h5 class=" no-margin" style="color: red; font-weight: bold;"><span id="scanCourse" class="text-danger"></span></h5>
                        <h5 class=" no-margin" style="color: red; font-weight: bold; margin-left: 15px; float:left;"><span id="scanYear_level" class="text-danger"></span></h5>
                    </div>
                    
                </div>
            
        </div>
        <div class="panel-footer" style='margin:5px 0;'>
                <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='registerVoter()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>REGISTER</a>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>



<script type="text/javascript">
    
    function setFocus()
    {
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 500);
    }   
    function addCandidate()
     {
         var user_id = $('#userId').val()
         var position = $('#canPosition').val();
         
        var url = "<?php echo base_url().'college/election/addCandidate'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "user_id="+user_id+"&position_id="+position+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data.msg);
                   location.reload();
               }
             });

        return false; 
     }
       
function registerVoter()
      {
          var url = "<?php echo base_url().'college/election/registerVoter/'?>"; // the script where you handle the form input.

             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+$('#scanUserId').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   dataType:'json',
                   success: function(data)
                   {
                       alert(data.msg)
                   }
                 });

            return false;  
}

      
function searchStudent(value)
      {
          var url = "<?php echo base_url().'college/election/searchStudent/'?>"; // the script where you handle the form input.
          if(value==""){
              $('#studentSearch').hide();
              $('#userId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#studentSearch').show();
                       $('#studentSearch').html(data);
                   }
                 });

            return false;  
          }
            
      } 
      
function scanStudents(value)
{
     var url = "<?php echo base_url().'college/election/scanStudent/'?>"; // the script where you handle the form input.
         $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   if(data.status)
                   {
                        $('#scanName').html(data.firstname+' '+data.lastname);
                        $('#scanProfile').show();
                        $('#scanProfileImage').attr('src','<?php echo base_url().'uploads/' ?>'+data.avatar);
                        $('#scanUserId').val(data.user_id);
                        $('#scanCourse').html(data.course);
                        $('#scanYear_level').html(data.year);
                        $('#rfid').val('');
                    }else{
                        $('#registerVoter').modal('hide');
                        alert(data.msg);
                        location.reload();
                    }
                   
               }
             });

        return false;  
}      
    
    $(document).ready(function() {

          
          $("#inputGradeModal").select2();
          $("#inputCSubject").select2();
    });
    
    
</script>

<!-- End of Schedule Modal-->
