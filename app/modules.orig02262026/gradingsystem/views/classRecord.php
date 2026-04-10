<div id="classRecord" style="display: none;">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="pull-right" >
<!--           <a onclick="printClassRecord()" href="#">
               <img src="<?php echo base_url() ?>images/print.png" style="cursor:pointer; margin-right: 10px; width:32px;"/>
            </a>-->
            <a onclick="classRecordDetails()" data-toggle="modal" href="#cs_details">
                <i style="color:white;" class="fa fa-plus-circle fa-3x"></i>
            </a>
            </div>
            <h4 id="myModalLabel">Class Record</h4>
        </div>
        <div class="panel-body" id="classRecordTables" style="height:350px; overflow-y: scroll;">

        </div>
    </div>
</div>