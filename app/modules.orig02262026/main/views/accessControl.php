<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header " style="margin:0">Access Control 
        <div class="pull-right" >
           <select onclick="getPosition(this.value)" tabindex="-1" id="inputTeacher" style="width:300px; font-size:15px;" class="span2">
               <option>Select Position Here</option>
               <?php 
                         foreach ($position as $position)
                      {   
                     ?>                        
                   <option value="<?php echo $position->position_id; ?>"><?php echo $position->position; ?></option>
                   <?php }?>
           </select>

        </div>
        </h3>
    </div>
       
</div>
<div id="alert-info"  style="position:absolute; top:30%; left:30%; display: none" class="alert alert-error" id="notify" data-dismiss="alert-message">
            <h4>Access Control Successfully Saved!</h4>
</div>
    
<div class="col-lg-12">
    <div id="accessResult">

    </div>

</div>
   
 
    </div>
    
</div>


<script type="text/javascript">
    
       function dumpInArray(){
           var arr = [];
           $('.menuChoices input[type="checkbox"]:checked').each(function(){
              arr.push($(this).val());
           });
           return arr; 
        }
        
       function dumpInArrayDash(){
           var arr = [];
           $('.dashChoices input[type="checkbox"]:checked').each(function(){
              arr.push($(this).val());
           });
           return arr; 
        }
        
       function getValue()
        {
//            document.getElementById('menuAccess').value = (dumpInArrayDash().join(","));
//            document.getElementById('dbAccess').value = (dumpInArray().join(","));
        }
        
        $('.select-roles').click(function () {
          // $('#result').html(dumpInArray().join(","));
          
           //document.location = '<?php echo base_url()?>index.php/main/saveAccess/'+document.getElementById('inputTeacher').value+'/'+(dumpInArray().join(",")+'/'+(dumpInArrayDash().join(",")));
           //document.location = '<?php echo base_url()?>index.php/admin/saveDashAccess/'+document.getElementById('userID').value+'/'+(dumpInArrayDash().join(","));
           
           var url = "<?php echo base_url().'main/saveAccess/'?>"// the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: 'csrf_test_name='+$.cookie('csrf_cookie_name')+"&position_id="+$('#inputTeacher').val()+"&menu_access="+$('#menuAccess').val()+"&dash_access="+$('#dbAccess').val(), // serializes the form's elements.
                   success: function(data)
                   {
                        location.reload()
//                       $('#alert-info').show();
//                       $('#alert-info').fadeOut(5000);
                   }
                 });

            return false;
    
        });
 
    
    function saveMenuAccess(value,userid){
        document.getElementById('setAction').value = 'saveMenuAccess';
        var data = new Array();
        data[0] = userid;
        data[1] = value;
        //adminRequest(data);
    }
    
    
    function getPosition(value)
    {
       
     var url = "<?php echo base_url().'main/getPositionAccess/'?>"+value// the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "position_id="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#accessResult').html(data)
                   $('#saveAccess').show();
               }
             });

        return false;
        
   }
   
   $(document).ready(function() {
          $("#inputTeacher").select2(); 
   });
    
</script>