<div class="panel panel-primary">
    <div class="panel-heading">
        Overload Subject
        <span class="badge badge-pill badge-light nowrap pointer pull-right" onclick="$('#ovrSubj').modal('show')" style="cursor: pointer;"><i class="fa fa-plus-circle" title="Add Subject"></i> Add Subject</span>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th style="text-align: center">Subject</th>
                <th style="text-align: center">Grade Level - Section</th>
                <th style="text-align: center">First Quarter</th>
                <th style="text-align: center">Second Quarter</th>
                <th style="text-align: center">Third Quarter</th>
                <th style="text-align: center">Fourth Quarter</th>
                <th style="text-align: center">Action</th>
            </tr>
            <?php
            foreach ($olSubject as $s):
                $subList = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                $levelSec = Modules::run('registrar/getSectionById', $s->sec_id);
                ?>
                <tr>
                    <td style="text-align: center"><?php echo $subList->subject ?></td>
                    <td style="text-align: center"><?php echo $levelSec->level . ' - ' . $levelSec->section ?></td>
                    <td style="text-align: center"><?php echo ($s->first != 0 ? $s->first : '') ?></td>
                    <td style="text-align: center"><?php echo ($s->second != 0 ? $s->second : '') ?></td>
                    <td style="text-align: center"><?php echo ($s->third != 0 ? $s->third : '') ?></td>
                    <td style="text-align: center"><?php echo ($s->fourth != 0 ? $s->fourth : '') ?></td>
                    <td style="text-align: center" onclick="delSelSubj('<?php echo $s->so_id ?>')"><span class="badge badge-pill badge-light nowrap pointer" style="background-color: red"><i class="fa fa-trash" title="Delete Selected Subject"></i>&nbsp;Delete Subject</span></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

