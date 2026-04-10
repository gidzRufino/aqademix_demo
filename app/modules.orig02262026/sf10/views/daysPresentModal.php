<div class=" col-lg-12">
    <div class="alert alert-success" style="margin-bottom: 0; padding: 3px;">
        <h4 class="text-center">Attendance Record - <?php echo $rfid ; ?>
        </h4>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="text-center" colspan="11">
                <?php echo $schoolDays->row()->school_year ?>
            </th>
        </tr>
    <tr>
        <td>Month</td>
        <td><?php echo substr(Modules::run('main/getMonthName', 6),0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 7), 0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 8), 0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 9), 0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 10), 0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 11), 0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 12), 0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 1),0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 2),0,3);  ?></td>
        <td><?php echo substr(Modules::run('main/getMonthName', 3),0,3);  ?></td>
        
    </tr> 
    <tr>
        <td>School Days</td>
        <td><?php echo $schoolDays->row()->June; ?></td>
        <td><?php echo $schoolDays->row()->July; ?></td>
        <td><?php echo $schoolDays->row()->August; ?></td>
        <td><?php echo $schoolDays->row()->September; ?></td>
        <td><?php echo $schoolDays->row()->October; ?></td>
        <td><?php echo $schoolDays->row()->November; ?></td>
        <td><?php echo $schoolDays->row()->December; ?></td>
        <td><?php echo $schoolDays->row()->January; ?></td>
        <td><?php echo $schoolDays->row()->February; ?></td>
        <td><?php echo $schoolDays->row()->March; ?></td>
    </tr>
    <tr>
        <td>Days Present</td>
        <td id="dp_June">
            <?php if($exist->row()->June > $schoolDays->row()->June): echo $schoolDays->row()->June;else: echo $exist->row()->June; endif; ?>
        </td>
        <td id="dp_July">
            <?php if($exist->row()->July > $schoolDays->row()->July): echo $schoolDays->row()->July;else: echo $exist->row()->July; endif; ?>
        </td>
        <td id="dp_August">
            <?php if($exist->row()->August > $schoolDays->row()->August): echo $schoolDays->row()->August;else: echo $exist->row()->August; endif; ?>
        </td>
        <td id="dp_September">
            <?php if($exist->row()->September > $schoolDays->row()->September): echo $schoolDays->row()->September;else: echo $exist->row()->September; endif; ?>
        </td>
        <td id="dp_October">
            <?php if($exist->row()->October > $schoolDays->row()->October): echo $schoolDays->row()->October;else: echo $exist->row()->October; endif; ?>
        </td>
        <td id="dp_November">
            <?php if($exist->row()->November > $schoolDays->row()->November): echo $schoolDays->row()->November;else: echo $exist->row()->November; endif; ?>
        </td>
        <td id="dp_December">
            <?php if($exist->row()->December > $schoolDays->row()->December): echo $schoolDays->row()->December;else: echo $exist->row()->December; endif; ?>
        
        </td>
        <td id="dp_January">
            <?php if($exist->row()->January > $schoolDays->row()->January): echo $schoolDays->row()->January;else: echo $exist->row()->January; endif; ?>
        </td>
        <td id="dp_February">
            <?php if($exist->row()->February > $schoolDays->row()->February): echo $schoolDays->row()->February;else: echo $exist->row()->February; endif; ?>
        </td>
        <td id="dp_March"><?php if($exist->row()->March > $schoolDays->row()->March): echo $schoolDays->row()->March;else: echo $exist->row()->March; endif; ?></td>
    </tr>       
    
  </table>
</div>
