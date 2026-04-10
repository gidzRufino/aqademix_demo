    <table class="table table-stripped table-hover">
        <tr>
            <th colspan="4" class="text-center"> Subjects Taken </th>
        </tr>
        <tr>
            <th class="text-center">Code</th>
            <th class="text-center">Subject</th>
            <th class="text-center">Lecture Units</th>
            <th class="text-center">Lab Units</th>
            <th></th>
        </tr>
        <tbody id="subjectTaken">

            <?php
                $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $admission_id);
                
                foreach ($loadedSubject as $ls):
                   
                        if($ls->is_final):    
            ?>
                        
                            <tr class="pointer" id="trtaken_<?php echo $ls->s_id ?>" onclick="removeSubject('<?php echo $ls->s_id ?>','<?php echo $ls->pre_req ?>')">
                                <td class="text-center"><?php echo $ls->sub_code ?></td>
                                <td class="text-center"><?php echo $ls->s_desc_title ?></td>
                                <td id="<?php echo $ls->s_id ?>_lect" class="text-center"><?php echo $ls->s_lect_unit ?></td>
                                <td class="text-center"><?php echo $ls->s_lab_unit ?></td>
                            </tr>

            <?php       $totalUnitsLec += $ls->s_lect_unit;
                        $totalUnitsLab += $ls->s_lab_unit;
                        endif;
                endforeach;
            ?>

            <tr id="tr_total_taken">
                <td colspan="2"></td>
                <td id="totalLect_taken" class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLec==0?0:$totalUnitsLec) ?></td>
                <td class="text-center" style="font-weight: bold;"><?php echo ($totalUnitsLab==0?0:$totalUnitsLab) ?></td>
            </tr>    
        </tbody>
</table>
