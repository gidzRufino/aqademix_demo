<?php
$is_admin = $this->session->userdata('is_admin');

?>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header" >Department Heads and Associates</h3>
        
        
    </div>
</div>
<div class="col-lg-12">
    <div class="pull-left" style="margin-top: 15px; margin-right: 15px;">
                       <select tabindex="-1" id="inputDepartment" style="width:200px" class="populate select2-offscreen span2">
                           <option>Select department</option>
                           <?php 
                                     foreach ($department as $dept)
                                  {   
                                 ?>                        
                               <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->department?></option>
                               <?php }?>
                       </select>
                       
    </div>
     <div class="controls pull-left" style="margin-top: 15px; margin-right: 15px;">
           <select tabindex="-1" id="inputDepartmentHeads" style="width:300px" class="populate select2-offscreen span2">
               <option>Select department Head</option>
               <?php 
                         foreach ($employeeList->result() as $EL)
                      {   
                     ?>                        
                   <option value="<?php echo $EL->uid; ?>"><?php echo $EL->lastname.', '.$EL->firstname; ?></option>
                   <?php }?>
           </select>

        </div>
       <div class="controls pull-left" style="margin-top: 15px;">
           <select tabindex="-1" id="inputAssociates" style="width:300px" class="populate select2-offscreen span2">
               <option>Select Associates</option>
               <?php 
                         foreach ($employeeList->result() as $EL)
                      {   
                     ?>                        
                   <option value="<?php echo $EL->uid; ?>"><?php echo $EL->lastname.', '.$EL->firstname; ?></option>
                   <?php }?>
           </select>

        </div>
    <button id="selectEm"  style=" margin-left:10px; margin-top:20px; " class="btn btn-danger pull-right">Delete</button>
        <button id="saveAccess" onclick="saveAssociates(document.getElementById('inputDepartment').value, document.getElementById('inputDepartmentHeads').value, document.getElementById('inputAssociates').value)" 
                style=" margin-left:10px; margin-top:20px; " class="pull-right btn btn-info">Add</button>

<div class="col-lg-12" style="margin-top:50px;">
        <div id="whereYouBelong">
            <?php
                foreach($whereYouBelong as $WYB){
             ?>
            <h4>Department Head: <?php echo $WYB->lastname.', '. $WYB->firstname ?> </h4>
            <ol>
            <?php
                $assoc = Modules::run('hr/getAssociates', $WYB->employee_id);
                foreach ($assoc as $assoc){
            ?>
            
                <h5><li><input style="margin:0 10px;"  type="checkbox" value="<?php echo $assoc->dh_id ?>" /><?php echo $assoc->lastname.', '. $assoc->firstname ?></li></h5>
            
            <?php
                }
             echo '</ol>' ;  
                }
            ?>
        </div>
        
    </div>
</div>

<input type="hidden" id="selectedEm" />


<script type="text/javascript">
    
       function dumpInArray(){
           var arr = [];
           $('#whereYouBelong input[type="checkbox"]:checked').each(function(){
              arr.push($(this).val());
           });
           return arr; 
        }
        

        $('#selectEm').click(function () {
          // $('#result').html(dumpInArray().join(","));
           document.getElementById('selectedEm').value = (dumpInArray().join(","));
           if($('#selectedEm').val()!=""){
               document.location = '<?php echo base_url()?>hr/deleteAssociates/'+(dumpInArray().join(","));
           }else{
               alert('Please Select Employee First');
           }
        //   
           //document.location = '<?php echo base_url()?>index.php/admin/saveDashAccess/'+document.getElementById('userID').value+'/'+(dumpInArrayDash().join(","));
        });
 
    
    function saveAssociates(dept, dhHead,associates){
       
             var url = "<?php echo base_url().'hr/saveDepartmentHeadsAssociates/'?>"; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "dept_id="+dept+"&dhHead="+dhHead+"&associate="+associates+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       //$('#Pos').show();
                       $('#whereYouBelong').html(data);
                       $('#notify').fadeOut(3000)
                   }
                 });

            return false;
    }
    
    
    function getEmployee()
    {
        var data;
        document.getElementById('setAction').value = 'getEmployee';
        data = document.getElementById("inputTeacher").value;
        //alert(data)
        adminRequest(data);
    }
    
        $(document).ready(function() {
          $("#inputAssociates").select2();
          $("#inputDepartmentHeads").select2();
          $("#inputDepartment").select2();
         
        });
    
</script>