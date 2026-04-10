<div id="seniorHighModal"  style="width:30%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading">
            <h6>Add Senior High School Strands</h6>
        </div>
        <div class="panel-body">
                <input value="" style="width: 95%;" class="" multiple="multiple" name="addedStrands" type="text" id="addedStrands" placeholder="Select Strand" /> 
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveSHStrand()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>

<script type="text/javascript"> 
    $(document).ready(function() {
       $("#addedStrands").select2({tags:[<?php
         foreach ($strands as $s) { 
             echo '"'.$s->short_code.'",';
         }
                    ?>]});
       
       
    });
    
    
    function saveSHStrand()
    {
        var strands = $('#addedStrands').val()
        
        var url = "<?php echo base_url().'subjectmanagement/saveSHStrand/'?>" // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "strands="+strands+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                                  , // serializes the form's elements.
               success: function(data)
               {
                  //location.reload();    
               }
        });
    }
    
</script>    