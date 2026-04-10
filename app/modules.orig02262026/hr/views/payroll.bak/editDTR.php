<div id="editDTR" class="modal fade" style="width:50%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="panel panel-primary" style="margin:0;">
        <div class="panel-heading">
            Edit DTR Info
            <small class="pull-right" >
                <div class="form-group input-group">
                    <input style="color:black;" name="inputBdate" type="text"  data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>" id="searchDate" placeholder="Search for Date" required>
                    <span class="input-group-btn">
                        <button style="height:25px;" class="btn btn-success btn-sm"onclick="searchAttendance(<?php echo $user_id ?>)">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </small>
        </div>
        <div class="panel-body clearfix">
            <div class='col-lg-12 form-group'>
                <b>Select Time </b><br />
                <div class="pull-left">
                    <select id='hr' style='width:50px;'>
                        <?php
                        for ($i=1; $i<=12; $i++)
                        {
                            if($i<10)
                            {
                                $i='0'.$i;
                            }
                        ?>
                        <option value='<?php echo $i ?>'><?php echo $i ?></option>
                        <?php } ?>
                    </select> :  
                    <select id='min' style='width:50px;'>
                        <?php
                        for ($i=0; $i<=60; $i++)
                        {
                            if($i<10)
                            {
                                $i='0'.$i;
                            }
                        ?>
                        <option value='<?php echo $i ?>'><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                    <select id='ampm' style='width:60px;'>
                        <option> Select Choice </option>
                        <option value='AM'>AM</option>
                        <option value='PM'>PM</option>
                    </select>

                    <select id='inout' style='width:60px;'>
                        <option value='in'>IN</option>
                        <option value='out'>OUT</option>
                    </select>
                </div>
                <input type="hidden" id="rfid" value="<?php echo $rfid ?>" />
               <div class='pull-right'>
                    <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                    <a href='#' data-dismiss='clickover' onclick='saveTime(<?php echo base64_decode($this->uri->segment(3)) ?>, <?php echo $user_id ?>)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
               </div>
            </div>
            <hr>
            <div class="col-lg-12" id="editDTR_body">
                
            </div>
            
        </div>
    </div>
</div>
<?php 
    $this->load->view('passSlipModal'); 
?>

<script type="text/javascript">
    $(document).ready(function() {
       $('#searchDate').datepicker()
    })
    
    function saveTime(id, user_id)
    {
        var rfid = $('#rfid').val()
        if(rfid == ""){
            rfid = id
        }
        var hour = $('#hr').val();
        var min = $('#min').val();
        var select = $('#ampm').val();
        var date = $('#searchDate').val();
        var inout = $('#inout').val();
        
        var url = "<?php echo base_url().'hr/saveManualHrAttendance/'?>"+user_id;
        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 't_id='+rfid+'&hour='+hour+'&min='+min+'&ampm='+select+'&date='+date+'&inout='+inout+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   $('#editDTR_body').html(data)
               }
        })
    }
    
    function searchAttendance(id)
    {
        var rfid = id   
        if(rfid == ""){
            rfid = id
        }
        var date = $('#searchDate').val();
        
        var url = "<?php echo base_url().'hr/getIndividualDTR/'?>";
        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 't_id='+rfid+'&date='+date+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   $('#editDTR_body').html(data)
               }
        })
    }
</script>
