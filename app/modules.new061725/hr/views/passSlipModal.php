<div id="passSlipModal"  style="width:25%; margin: 0 auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Pass Slip
        </div>
    <div class="panel-body clearfix no-padding">
        <?php
            $attributes = array('class' => '','role'=>'form', 'id'=>'passSlipForm');
            echo form_open(base_url().'hr/savePassSlip', $attributes);
        ?>
            <input name="inputPassSlipID" type="hidden" id="inputPassSlipID" placeholder="ID" value="0">
             <div class="col-lg-12">
                        <div class="col-lg-6">
                            <div class="control-group">
                            <label class="control-label" for="inputDate">Date Issue</label>
                                <div class="controls">
                                <input name="inputDate" type="text" id="inputDate" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                           <div class="control-group">
                              <label class="control-label" for="inputGradeLevel">Reason</label>
                              <div class="controls">
                                <select name="inputReason" id="inputReason" class="controls-row" required>
                                    <option value="0">Personal</option>
                                    <option value="1">Official</option>
                                  </select>
                                  <input name="inputReasonOthers" type="text" id="inputReasonOthers" placeholder="Reason">
                              </div>
                            </div>   
                    </div>

                    <div class="col-lg-6">
                        <div class="control-group">
                            <label class="control-label" for="inputPlace">Place</label>
                            <div class="controls">
                            <input name="inputPlace" type="text" id="inputPlace" placeholder="Place" required>
                            <input name="inputEmployeeID" type="hidden" id="inputEmployeeID" placeholder="Place" value="<?php if($this->session->userdata('rfid')!=""): echo $this->session->userdata('rfid'); else: echo $this->session->userdata('employee_id'); endif; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" id="approveInput" style="display:none">

                        <div class="control-group">
                       <?php
                        if ($this->session->userdata('position_id') == 41 || $this->session->userdata('position_id') == 42 || $this->session->userdata('position_id') == 38 || $this->session->userdata('position_id') == 1){
                        ?>
                            <label class="control-label" for="inputApproved">Approved</label>
                            <div class="controls">
                            <input onclick="approved(1)" name="inputApprovedHR" type="button" value="NO" class="btn btn-danger btn-xs" id="inputApproved" />
                            </div>
                       <?php
                        }
                        ?>
                        </div>
                    </div>
                    <input type="hidden" id="isUpdated" name="isUpdated" value="0" />
            </div>
            <div class="col-lg-12">
                <button id="submitPassSlip" data-dismiss="modal" class="btn btn-success btn-xs pull-right">Save </button>
                <button class="btn btn-xs pull-right btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>    
                            
        </form>
    </div> 
        
    </div>
</div>    
<script type="text/javascript"> 
    
$(document).ready(function() {
    $('#inputDate').datepicker();
    if($('#isUpdated').val()==0){
        $('#inputApproved').val('NO')
        $('#inputApproved').addClass('btn-danger')
    }else{
        $('#inputApproved').val('YES')
        $('#inputApproved').removeClass('btn-danger')
        $('#inputApproved').addClass('btn-success')
    }
});

$('#inputReason').change(function(){ 
    var value = $(this).val();
    if(value == '0'){
        $('#inputReasonOthers').show();
    }else{
        $('#inputReasonOthers').hide();
    }
});

$(document).ready(function() {
    $("#submitPassSlip").click(function() {
        $("#passSlipForm").submit();
    });
    
}); 

function approved(id)
{
      if($('#inputApproved').val()=='NO')
      {
          $('#isUpdated').val(id);
          
        $('#inputApproved').val('YES')
        $('#inputApproved').removeClass('btn-danger')
        $('#inputApproved').addClass('btn-success')
      }else{
          $('#isUpdated').val(0);
          
        $('#inputApproved').val('NO')
        $('#inputApproved').removeClass('btn-success')
        $('#inputApproved').addClass('btn-danger')
      }
}
</script>
<script src="<?php echo base_url(); ?>assets/js/passSlipRequest.js"></script>
