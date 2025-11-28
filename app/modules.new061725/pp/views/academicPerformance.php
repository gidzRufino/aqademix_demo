<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="6" class="text-center">ACADEMIC</th>
        </tr>
        <tr class="quarterTitle">
            <th style="width:20%;">SUBJECT</th>
            <th class="text-center" style="width:15%;">FIRST</th>
            <th class="text-center" style="width:15%;">SECOND</th>
            <th class="text-center" style="width:15%;">THIRD</th>
            <th class="text-center" style="width:15%;">FOURTH</th>
            <th class="text-center" style="width:15%;">FINAL</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subject = Modules::run('academic/getSpecificSubjectPerlevel', $grade_id); 
        $gs_settings = Modules::run('gradingsystem/getSet', $year);
        
        $i=0;
        foreach($subject as $s):
            $i++;
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            $grade = json_decode(Modules::run('gradingsystem/getGradeForCard', $student->st_id, $s->sub_id, $year));
            switch ($gs_settings->gs_used):
                case 1:
                    $first = $grade->first;
                    $second = $grade->second;
                    $third = $grade->third;
                    $fourth = $grade->fourth;
                break;
                case 2:
                    $first = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->first);
                    $second = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->second);
                    $third = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->third);
                    $fourth = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->fourth);
                    $fg = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $s->sub_id, $term, $year);
                break;
            endswitch;
            
        ?>
        <tr class="data">
            <td><?php echo $singleSub->subject ?></td>
            <td class="text-center text-strong value"><?php echo ($first==""? 0 : $grade->first) ?></td>
            <td class="text-center text-strong value"><?php echo ($second=="" ? 0 : $grade->second) ?></td>
            <td class="text-center text-strong value"><?php echo ($third=="" ? 0 : $grade->third) ?></td>
            <td class="text-center text-strong value"><?php echo ($fourth=="" ? 0 : $grade->fourth) ?></td>
            <td class="text-center"><strong class="sum"></td>
        </tr>
        <?php
        endforeach;    
        ?>
    </tbody>
    
</table>
