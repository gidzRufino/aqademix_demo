<div style="margin-bottom: 100px; ">
    <div class="row-fluid contentHeader sticky" style="width:1080px; background: #FFF; z-index: 2000">
        <h3 class="pull-left" style="margin:0">Enrollment List </h3>
        <div class="control-group pull-right">
            <div class="controls">
                <select onclick="getStudentByLevel()" tabindex="-1" id="inputGrade" style="width:300px" class="populate select2-offscreen span2">
                    <option>Search Grade level here</option>
                    <?php 
                              foreach ($grade as $level)
                           {   
                          ?>                        
                        <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                        <?php }?>
                </select>

             </div>
         </div>
    </div> 
    <div class="span12" id="enrollmentResults">
        
        
    </div>
    
</div>

<script type="text/javascript">
    function getStudentByLevel()
    {
        var url = "<?php echo base_url().'registrar/generateReport2' ?>"; // the script where you handle the form input.

        $.ajax({
           type: "POST",
           url: url,
           data: "position="+position+"&grade="+grade+"&section="+section+"&month="+month, // serializes the form's elements.
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
             // $('#form2Results').html = data
             document.getElementById("form2Results").innerHTML = data
           }
         });
    
    return false;
    
        var data = new Array();
        document.getElementById('setAction').value = 'getEnrollmentList';
        data[0] = document.getElementById("inputGrade").value;
        data[1] = 'annual'
        document.getElementById('print').href = '<?php echo base_url();?>index.php/pdf/printEnrollmentList/'+data
        saveAdmission(data);             
    }
    $(document).ready(function() {
          $("#inputGrade").select2({
                minimumInputLength: 2
            });
     });
</script>
