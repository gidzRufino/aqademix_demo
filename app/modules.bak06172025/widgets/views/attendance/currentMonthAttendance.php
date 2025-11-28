<div class="row table-responsive panel panel-info" style="margin-top:10px; max-height: 250px; overflow-y: scroll;" >
    <div class="panel-heading">
        <div class="btn-group">
          <input type="hidden" id="m_id" value="<?php echo date('m') ?>" />
          <input type="hidden" id="y_id" value="<?php echo date('Y') ?>" />
          <button onclick="getAttendance(parseInt($('#m_id').val()) - parseInt(1))" class="btn btn-small btn-group"><<</button>
          <button id="monthName" style="width:470px; font-weight: bold;" onclick="getAttendance(parseInt(<?php echo date('m') ?>)"  class="btn btn-small btn-group"><?php echo date('F') ?></button>
          <button onclick="getAttendance(parseInt($('#m_id').val()) + parseInt(1))"  class="btn btn-small btn-group">>></button>
      </div>
    </div>
    <div class="panel-body">
         <?php
          echo Modules::run('attendance/monthly', $option, base64_encode($st_id));
        ?> 
    </div>
    
</div>

