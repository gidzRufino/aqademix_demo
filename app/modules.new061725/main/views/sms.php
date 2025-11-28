<div class="clearfix row-fluid span11">
    <div class="row">
        <div class="pull-left span12 ">
            <h3 class="text-center" style="">School Messaging System</h3>
        </div> 
    </div>
    <div class="row">
        <?php
            $attributes = array('class' => '', 'id'=>'sendSMS', 'style'=>'margin:0 37%;');
            echo form_open('', $attributes);
        ?>
            <div class="control-group">
              <div class="controls">
                <select id="inputPhoneNumber" name="dept" class="controls-row span12" required>
                    <option>Select Department</option>
                    <option value="0">Send to All</option>
                    <?php foreach ($departments as $dept){ ?>
                    <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->department; ?></option>
                    <?php } ?>
                  </select>
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                 <textarea onkeyup="checkTxtLength($('#counter').html())" style="margin-bottom:10px;" name="txtMsg"  id="txtMsg"  class="span12" id="txt-limit" rows="5" data-provide="txtlimit" data-counter="#counter" placeholder="Enter Text Here"></textarea>
                 <a onclick="sendSMS()"class="btn btn-primary pull-right">SEND SMS</a>
                 <em id="counter" style="">160</em>
              </div>
            </div>

        </form>
    </div>
</div>
<span id="sendResult"></span>

<script type="text/javascript">
    
    function checkTxtLength(val)
    {
        if(val==0){
            alert('sorry!')
        }
    }
    
    function sendSMS(){
        var url = "<?php echo base_url().'messaging/sendSMS' ?>"; // the script where you handle the form input.
        var msg = $('#txtMsg').val()
        var dept = $('#inputPhoneNumber').val()
        var cs = document.getElementsByName('csrf_test_name').value
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               //data: "msg="+msg+"&dept="+dept+'&csrf_test_name='+cs, // serializes the form's elements.
               data: $('#sendSMS').serialize(), // serializes the form's elements.
               success: function(data)
               {
                   alert('You Just Successfully send your message to the respective persons');
               }
           
        });

        
    }
    
    $(document).ready(function() {
          $("#inputPhoneNumber").select2(); 
                
        });
//    $(".limit").limit({
//       
//    })
</script>
    <script src="<?php echo base_url(); ?>assets/js/text-limit.js"></script>
