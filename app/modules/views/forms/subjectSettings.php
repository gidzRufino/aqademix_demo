<div id="gradeSettings" style="display: none;">
    <div class="modal-header">
        <div class="pull-right">
            <button class="btn" aria-hidden="true">Cancel</button>
            <button id="setGradeSettingsBtn" class="btn btn-primary">Update</button>
        </div>
        <h4 id="myModalLabel">Academic Settings</h4>
    </div>
    <div class="modal-body">
    <form id="gradingSettingsForm" action="" method="post">  
        <ul class="nav nav-tabs" style="margin-bottom: 0" id="gradeSettingsTab">
            <li class="active"><a href="#quarterSet" style="color:black;">
                    Quarter Settings
                </a>
            </li>
            <li><a  href="#weights" style="color:black;">
                    Percentage / Weights Settings
                </a>
            </li>
        </ul>
        
        <div class="tab-content" style="margin-left: 0;">
            <div class="tab-pane active span7" id="quarterSet">
                  <?php $this->load->view('gradingsystem/forms/quarterSettings'); ?>
            </div>
            <div class="tab-pane span7" id="weights">
                <?php $this->load->view('gradingsystem/forms/weightSettings'); ?>
            </div>
        </div>
          
      </form> 
   </div>
</div>

<script type="text/javascript">
    
    $('#setGradeSettingsBtn').click(function() {
     
    var url = "<?php echo base_url().'index.php/gradingsystem/setGradeSetting' ?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#gradingSettingsForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               //$("form#addCategoryForm")[0].reset();
                alert('Settings Successfully Saved')
              //$("#msgResult").innerHTML='<textarea id="inputMessage" name="message"  onclick="" placeholder="Type in Your Message..." style="margin-left:4px;width:550px; "></textarea>'
               //alert(data) // show response from the php script.
               document.location = '<?php echo base_url()?>gradingsystem/'
               
               
               
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    })
    
    
    
    
</script>