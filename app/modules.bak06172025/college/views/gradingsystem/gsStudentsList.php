<table class="table table-bordered">
    <tr>
        <th>Student ID</th>
        <th>Student's Name</th>
        <th>Course</th>
        <th>Year Level</th>
        <th>Semester</th>
        <th>Action</th>
    </tr>
    <?php
    foreach ($students as $s):
        $name = strtoupper($s->lastname) . ', ' . ucwords(strtolower($s->firstname) . '' . ($s->middlename != '' ? ' ' . ' ' . substr($s->middlename, 0, 1) . '.' : ''));
        ?>
        <tr>
            <td><?php echo $s->stid ?></td>
            <td><?php echo $name ?></td>
            <td><?php echo $s->short_code ?></td>
            <td>
                <?php
                switch ($s->year_level):
                    case 1:
                        echo 'First Year';
                        break;
                    case 2:
                        echo 'Second Year';
                        break;
                    case 3:
                        echo 'Third Year';
                        break;
                    case 4:
                        echo 'Fourth Year';
                        break;
                endswitch;
                ?>
            </td>
            <td>
                <?php
                switch ($s->semester):
                    case 1:
                        echo '1st Sem';
                        break;
                    case 2:
                        echo '2nd Sem';
                        break;
                    case 3:
                        echo 'Summer';
                        break;
                endswitch;
                ?>
            </td>            
            <td class="pointer">
                <i class="fa fa-sm fa-eye" id="showGS<?php echo $s->uid ?>" style="color: green" onclick="$(this).hide(), $('#tr-<?php echo $s->uid ?>').show(), $('#hideGS<?php echo $s->uid ?>').show()"> Show</i>
                <i class="fa fa-sm fa-eye-slash" id="hideGS<?php echo $s->uid ?>" style="display: none; color: red" onclick="$(this).hide(), $('#tr-<?php echo $s->uid ?>').hide(), $('#showGS<?php echo $s->uid ?>').show()"> Hide</i>
            </td>
        </tr>
        <tr id="tr-<?php echo $s->uid ?>" hidden="">
            <?php
            $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $s->admission_id, NULL, $s->school_year);
            ?>
            <td colspan="6">
                <div class="col-md-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Subjects Taken
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center">Subject Code</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Units</th>
                                    <th class="text-center">GS Status</th>
                                </tr>
                                <?php
                                $v = 0;
                                foreach ($loadedSubject as $ls):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $ls->sub_code ?></td>
                                        <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                                        <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo ($ls->sub_code == "NSTP 11" || $ls->sub_code == "NSTP 12" || $ls->sub_code == "NSTP 1" || $ls->sub_code == "NSTP 2" ? 3 : ($ls->s_lect_unit)) ?></td>
                                        <?php
                                        $v++;
                                        switch ($ls->is_lock):
                                            case 1:
                                                $fa = 'fa fa-lock';
                                                $color = 'red';
                                                $txt = 'LOCKED';
                                                break;
                                            case 0:
                                                $fa = 'fa fa-unlock';
                                                $color = 'green';
                                                $txt = 'OPEN';
                                                break;
                                        endswitch;
                                        ?>
                                    <input type="hidden" id="newVal-<?php echo $s->stid . '-' . $v; ?>" value="<?php echo ($ls->is_lock ? 0 : 1); ?>">
                                    <td class="text-center pointer" id="tdn-<?php echo $s->stid . '-' . $v; ?>" style="color: <?php echo $color ?>" onclick="gsUnLock('<?php echo $s->admission_id ?>', '<?php echo $ls->s_id ?>', '<?php echo $s->school_year ?>', $('#newVal-<?php echo $s->stid . '-' . $v; ?>').val(), '<?php echo $s->semester ?>', '<?php echo base64_encode($name) ?>','<?php echo $v; ?>', '<?php echo  $s->stid; ?>')">
                                        
                                        <i class="<?php echo $fa ?>">&nbsp;<?php echo $txt ?></i>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>                            
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<ul>
</ul>