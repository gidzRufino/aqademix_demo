<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">College Settings
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
              </div>
        </h3>
    </div>
    
    <div class="row clearfix">
        <div class="col-lg-12">
            <div style="position:absolute; top:30%; left:50%;" class="alert alert-error hide" id="notify" data-dismiss="alert-message">
                    <h4></h4>
            </div>
            <div class="tabbable tabs-right">
                <ul class="nav nav-tabs" id="settings_tab" role="tablist">
                    <li class="active"><a href="#courseManagement">Menu Assignment</a></li>
                    <li><a href="#subjectSettings">Subject Management</a></li>
                    <li><a href="#scheduleSettings">Schedule Management</a></li>
                </ul>
                <div class="tab-content col-lg-12">
                    <div class="tab-pane active" style="padding-top: 15px;" id="courseManagement">
                        <div id="alert-info"  style="position:absolute; top:30%; left:30%; display: none" class="alert alert-error" id="notify" data-dismiss="alert-message">
                                    <h4>Access Control Successfully Saved!</h4>
                        </div>

                        <div class="col-lg-12">
                            <div id="accessResult">

                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" style="padding-top: 15px;" id="subjectSettings">
                        subjects
                    </div>
                    <div class="tab-pane" style="padding-top: 15px;" id="scheduleSettings">
                        schedule
                    </div>
                </div>
            </div>     
        </div>
    </div>
    
</div>

<script type="text/javascript">
        
        $(document).ready(function(){
            $('#settings_tab a').click(function(e) {
                    e.preventDefault()
                    $(this).tab('show')
                  })
            });
            
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
        
        function saveMenuAccess(value,userid){
            document.getElementById('setAction').value = 'saveMenuAccess';
            var data = new Array();
            data[0] = userid;
            data[1] = value;
            //adminRequest(data);
        }
    
</script>