<?php
switch ($semester):
    case 1:
        $semName = 'First Semester';
        break;
    case 2:
        $semName = 'Second Semester';
        break;
    case 3:
        $semName = 'Summer';
        break;
endswitch;
?>    
<div class="row" style="height: 100vh;" >
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header clearfix"><span class="pull-left">List of Classes</span>
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college/subjectmanagement/listOfSubjects') ?>'">Subject Management</button>
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Generate</button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li onmouseover="$('#loadedValue').val(0)" onclick="generate()"><a href="#">Printed List of Requested Subject</a></li>
                    <li onmouseover="$('#loadedValue').val(1)" onclick="generate()"><a href="#">Printed List of Regular Subject</a></li>
                    <li onmouseover="$('#loadedValue').val(2)" onclick="generate()"><a href="#">Printed Summary of Teaching Load</a></li>
                </ul>
                <input type="hidden" id="loadedValue" />
            </div>
        </h3>
    </div>
    <div class="col-lg-12">
        <div class="input-group pull-right">
            <button style=" width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $school_year.' - '.$next ?> <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
                            <?php for ($sy = 2018; $sy <= date('Y'); $sy++): ?>
                                <li onclick="$('#inputSY').val('<?php echo $sy ?>'), $('#btnControl2').html('<?php echo $sy . ' - ' . ($sy + 1) ?>'),loadSubjectList('<?php echo $sy ?>',$('#inputSem').val())" ><a href="#"><?php echo $sy . ' - ' . ($sy + 1) ?></a></li>

                            <?php endfor; ?>
            </ul>
            <input type="hidden" id="inputSY" value="<?php echo $school_year ?>" />
        </div>
        <div class="input-group col-lg-8 pull-right">
            <input onkeypress="if (event.keyCode == 13) {
                        searchSubject(this.value, $('#inputSem').val())
                    }"  type="text"id="searchSubject" class="form-control col-lg-2" placeholder="Search Subject" /> 
            <div class="input-group-btn">
                <button type="button" class="btn btn-default" onclick="searchSubject($('#searchSubject').val(), $('#inputSem').val())" id="searchLoading"><i class="fa fa-search"></i></button>
                <button style=" width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $semName ?> <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="btnControl1">
                    <li onclick="$('#btnControl1').html('First Semester <span class=\'caret\'></span>'), $('#inputSem').val(1), loadSubjectList($('#inputSY').val(), '1')"><a href="#">First Semester</a></li>
                    <li onclick="$('#btnControl1').html('Second Semester <span class=\'caret\'></span>'), $('#inputSem').val(2),loadSubjectList($('#inputSY').val(), '2')"><a href="#">Second Semester</a></li>
                    <li onclick="$('#btnControl1').html('Summer  <span class=\'caret\'></span>'), $('#inputSem').val(3), loadSubjectList($('#inputSY').val(), '3')"><a href="#">Summer</a></li>
                </ul> 
                <input type="hidden" id="inputSem" value="<?php echo $semester ?>" />
            </div>
        </div>

    </div>
    <div class="col-lg-12">
        <table class="table table-stripped">
            <tr>
                <th>Subject</th>
                <th>Section Code</th>
                <th>Descriptive Title</th>
                <th>Unit/s</th>
                <th class="text-center">Days</th>
                <th class="text-center">Time</th>
                <th class="text-center">Room</th>
                <th class="text-center">Instructor</th>
                <th># of Students</th>
                <th class="text-center">Status</th>
            </tr>
            <tbody id="classListBody" class="text-center">
                <?php
                foreach ($subjects as $s):
                    $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester, $school_year);
                    $sched = json_decode($scheds);
                    $students = Modules::run('college/subjectmanagement/getStudentsPerSection', $s->sec_id, $semester, $school_year);
                    $instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);

                    if ($s->sec_sem == $semester):
                        ?>
                        <tr class="pointer" onclick="window.open('<?php echo base_url('college/subjectmanagement/printStudentsPerSubject/') . $s->s_id . '/' . $s->sec_id . '/' . $semester . '/' . $school_year ?>', '_blank')">
                            <td><?php echo $s->sub_code; ?></td>
                            <td><?php echo $s->section ?></td>
                            <td><?php echo $s->s_desc_title; ?></td>
                            <td class="text-center">
                                <?php echo ($s->sub_code == "NSTP 11" || $s->sub_code == "NSTP 12" || $s->sub_code == "NSTP 1" || $s->sub_code == "NSTP 2" ? 3 : ($s->s_lect_unit + $s->s_lab_unit)) ?>
                            </td>  
                            <td class="text-center">
                                <?php
                                echo ($sched->count > 0 ? $sched->day : 'TBA');
                                ?>
                            </td>  
                            <td class="text-center">
                                <?php
                                echo ($sched->count > 0 ? $sched->time : 'TBA');
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                echo ($sched->count > 0 ? $sched->room : 'TBA');
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                echo strtoupper($sched->instructor);
                                ?>
                            </td>
                            <td class="text-center"><?php
                                if ($students->num_rows() >= 45):
                                    $style = 'text-danger';
                                else:
                                    $style = 'text-success';
                                endif;
                                ?>
                                <span class="<?php echo $style ?>">
                                    <?php
                                    $totalEn = 0;
                                    foreach ($students->result() as $st):
                                        if ($st->status == 1):
                                            $totalEn++;
                                        endif;
                                    endforeach;
                                    echo $totalEn;
                                    ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php
                                if ($students->num_rows() > 45):
                                    $status = 'Over Populated';
                                elseif ($students->num_rows() == 45):
                                    $status = 'Closed';
                                elseif ($students->num_rows() < 45):
                                    $status = 'Open';
                                endif;
                                ?>
                                <span class="<?php echo $style ?>">
                                    <?php echo $status ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    endif;
                endforeach;
                ?>
            </tbody>        
        </table>
    </div>
</div>

<script type="text/javascript">

    function loadSubjectList(school_year, semester)
    {
        var url = '<?php echo base_url('college/subjectmanagement/classList/')  ?>'+school_year+'/'+semester;
        document.location = url;
    }

    function searchSubject(value, sem)
    {
        var url = '<?php echo base_url() . 'college/subjectmanagement/searchListOfClasses/' ?>' + value + '/' + sem + '/' + $('#inputSY').val();
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function () {
                $('#searchLoading').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>');
                $('#classListBody').html('<i class="fa fa-5x fa-spinner fa-spin fa-fw text-center" ></i>');
            },
            data: "value=" + value + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#searchLoading').html('<i class="fa fa-search"></i>');
                $('#classListBody').html(data);
            }
        });

        return false;
    }


    function generate()
    {
        var option = $('#loadedValue').val();
        switch (option)
        {
            case '0':
                var url = '<?php echo base_url() . 'college/finance/printCollectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val();
        
                window.open(url, '_blank');
            break;
            case '1':
                var url = '<?php echo base_url() . 'college/subjectmanagement/getListOfClasses/'?>'+$('#inputSY').val()+'/'+$('#inputSem').val()+'/1';
        
                window.open(url, '_blank');
            break;
            case '2':
                var url = '<?php echo base_url() . 'college/subjectmanagement/teachingLoad/'?>'+$('#inputSY').val()+'/'+$('#inputSem').val()+'/0';
        
                window.open(url, '_blank');
            break;
        }
    }
</script>    