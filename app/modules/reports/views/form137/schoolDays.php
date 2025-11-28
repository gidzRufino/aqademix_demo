<table class="table table-striped table-bordered">
        <tr>
            <th>Month</th>
            <th>School Days</th>
        </tr>

    <tr>
        <td><?php echo Modules::run('main/getMonthName', 6);  ?></td>
        <td id="sd_June"><?php echo $exist->row()->June; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 7);  ?></td>
        <td id="sd_July"><?php echo $exist->row()->July; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 8);  ?></td>
        <td id="sd_August"><?php echo $exist->row()->August; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 9);  ?></td>
        <td id="sd_September"><?php echo $exist->row()->September; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 10);  ?></td>
        <td id="sd_October"><?php echo $exist->row()->October; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 11);  ?></td>
        <td id="sd_November"><?php echo $exist->row()->November; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 12);  ?></td>
        <td id="sd_December"><?php echo $exist->row()->December; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 1);  ?></td>
        <td id="sd_January"><?php echo $exist->row()->January; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 2);  ?></td>
        <td id="sd_February"><?php echo $exist->row()->February; ?></td>
    </tr>       
    <tr>
        <td><?php echo Modules::run('main/getMonthName', 3);  ?></td>
        <td id="sd_March"><?php echo $exist->row()->March; ?></td>
    </tr>
  </table>