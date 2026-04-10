<div class="col-lg-12 page-header no-margin">
    <h3 style="margin:10px 0;" class="col-lg-4"><a href="<?php echo base_url('college') ?>"><i class="fa fa-home fa-fw"></i></a> List of Classes</h3>
</div>
<div class="col-lg-8" style="margin-top: 10px;">
    <?php
    $sem = Modules::run('main/getSemester');
    switch ($sem):
        case 1:
            $semester = 'First Semester';
            break;
        case 2:
            $semester = 'Second Semester';
            break;
        case 3:
            $semester = 'Summer';
            break;
    endswitch;
    ?>              
    <select style="margin-right: 20px; width:200px; margin-top:3px;" onchange="changeSem(this.value)" id='semInput' class="input-group select2-searching select2-search pull-right">
        <option>Select Semester</option>
        <option value="1">First Semester</option>
        <option value="2">Second Semester</option>
        <option value="3">Summer</option>
    </select>
    <div class="form-group pull-right">
        <select tabindex="-1" id="inputSY" style="margin-right: 20px; width:200px; margin-top:3px;" >
            <option>School Year</option>
            <?php
            foreach ($ro_year as $ro) {
                $roYears = $ro->ro_years + 1;
                if ($this->session->userdata('school_year') == $ro->ro_years):
                    $selected = 'Selected';
                else:
                    $selected = '';
                endif;
                ?>                        
                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years . ' - ' . $roYears; ?></option>
            <?php } ?>
        </select>
    </div>

</div>
<div class="col-lg-12 no-padding" id="classList">

</div>

<script type="text/javascript">
    function changeSem(sem)
    {

        getTeachingAssignment(sem)
        $('#semester').val(sem)
    }
    
    function getTeachingAssignment(value)
    {
        var school_year = $('#inputSY').val()
        var url = '<?php echo base_url() . 'college/gradingsystem/getTeacherAssignmentDrop/' ?>' + '<?php echo $this->session->userdata('employee_id'); ?>' + '/' + value + '/' + school_year + '/1';
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function () {
                $('#gsMsg')
            },
            data: "id=" + value, // serializes the form's elements.
            success: function (data)
            {
                $('#classList').html(data);
            }
        });

        return false;
    }
    
    function loadAssignment(emp_id){
        alert(emp_id);
    }
</script>
