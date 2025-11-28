<div id="classRecord" style="display: none;">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="pull-right" >
            <a onclick="document.location='<?php echo base_url().'reports/printClassRecord/' ?>'+$('#section_id').val()+'/'+$('#subject_id').val()+'/'+$('#inputTerm').val()" href="#">
                <img src="images/print.png" style="cursor:pointer; margin-right: 10px; width:32px;"/>
            </a>
            </div>
            <h4 id="myModalLabel">Class Record</h4>
        </div>
        <div class="panel-body" id="classRecordTables" style="height:350px; overflow-y: scroll;">

        </div>
    </div>
</div>