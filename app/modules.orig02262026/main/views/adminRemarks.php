<!-- Modal -->
<div class="modal fade" id="adminRemarks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" >&times;</button>
          <h3 id="myModalLabel">Update Student Status</h3>
        </div>
        
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label" for="input">Remarks:</label>
            <div class="controls">
              <input name="dateRemarked" type="hidden" id="dateRemarked" placeholder="Date" value="<?php echo date('m-d-Y'); ?>">
              <select id="inputRemarks" style="width:300px">
                 <option>Select Student Status</option>              
                 <?php foreach ($codeIndicators as $ci){ ?>
                    <option value ="<?php echo $ci->id ?>" ><?php echo $ci->Indicator ?></option>
                 <?php } ?>
             </select>
            </div>
            <input type="hidden" id="st_id" name="st_id" value="" />
            <input type="hidden" id="us_id" name="user_id" value="" />
          </div>
            <div class="form-group">
                <label class="control-label" for="input">Required Information for selected Remark:<br>
                    <small>( Please refer to DepEd forms for List and Code Indicators )</small>
                </label>
                <textarea style="width:300px;" id="required_information" name="required_information" rows="5" cols="20"></textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputPlaceOfBirth">Effectivity Date:</label>
                <div class="controls">
                    <input name="inputEffectivity" type="text" id="inputEffectivity" placeholder="Effectivity Date" required>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" onclick="submitRemarks(), $('#secretContainer').fadeOut(500)" class="btn btn-primary">Save </button>
          <div id="resultSection" class="help-block" ></div>
        </div>
    </div>
  </div>
</div>
<!--Deactivate-->
    <div style='width:450px; height:auto;margin-top:50px; margin-bottom: 10px;' id="deactivate" class="emailForm" >
        

      </div>

<script type="text/javascript">
    function submitRemarks()
    {
        var url = "<?php echo base_url().'main/saveAdmissionRemarks/'?>"; // the script where you handle the form input.
        var st_id = $('#st_id').val()
        var user_id = $('#us_id').val()
        var code = $('#inputRemarks').val()
        var info = $('#required_information').val()
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "codeIndicator_id="+code+"&required_information="+info+"&st_id="+$('#st_id').val()+"&user_id="+user_id+"&effectivity_date="+$('#inputEffectivity').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#remarks_'+st_id+"_td").html(data);
                       if(code==1||code==3){
                           $('#img_'+st_id+"_td img").attr("src",'<?php echo base_url();?>images/unofficial.png');
                       }else{
                           $('#img_'+st_id+"_td img").attr("src",'<?php echo base_url();?>images/official.png');
                       }
                       location.reload();
                   }
                 });

            return false;
    }
    $(document).ready(function() {
        $('#inputEffectivity').datepicker();
    });
</script>