<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $list->level; ?>
        </div>
        <div class="panel-body no-padding">
            <div class="col-lg-6 no-padding">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        First Semester
                    </div>
                    <div class="panel-body no-padding" data-toggle="context" data-target="#SHMenu" >
                        <?php
                        $strand = Modules::run('subjectmanagement/getSHOfferedStrand');
                            foreach($strand as $st):
                                $subjects = Modules::run('subjectmanagement/getAllSHSubjects', $list->grade_id, 1, $st->st_id);
                        ?>
                        <div class="panel panel-danger" >
                            <div class="panel-heading">
                                <?php echo $st->strand; ?>
                            </div>
                            <div class="panel-body" onmouseover="$('#grade_id').val('<?php echo $list->grade_id; ?>'),$('#strand_id').val('<?php echo $st->st_id; ?>'),$('#semester').val('1')">
                                <ul id="<?php echo $list->grade_id; ?>_<?php echo $st->st_id; ?>_1">
                                    <?php foreach ($subjects as $sub):?>
                                        <li id="<?php echo $list->grade_id; ?>_<?php echo $st->st_id; ?>_1_<?php echo $sub->sh_sub_id; ?>_sub" onmouseover="$('#sub_id').val('<?php echo $sub->sh_sub_id; ?>')"><?php echo $sub->subject ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>    
                        </div>
                        <?php endforeach; ?>
                    </div>    
                </div>
            </div>
            <div class="col-lg-6 no-padding">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Second Semester
                    </div>
                    <div class="panel-body no-padding"  data-toggle="context" data-target="#SHMenu">
                        <?php
                        $strand = Modules::run('subjectmanagement/getSHOfferedStrand');
                            foreach($strand as $st):
                                $subjects = Modules::run('subjectmanagement/getAllSHSubjects', $list->grade_id, 2, $st->st_id);
                        ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <?php echo $st->strand; ?>
                            </div>
                            <div class="panel-body"  onmouseover="$('#grade_id').val('<?php echo $list->grade_id; ?>'),$('#strand_id').val('<?php echo $st->st_id; ?>'),$('#semester').val('2')">
                                <ul id="<?php echo $list->grade_id; ?>_<?php echo $st->st_id; ?>_2">
                                    <?php foreach ($subjects as $sub):?>
                                        <li id="<?php echo $list->grade_id; ?>_<?php echo $st->st_id; ?>_2_<?php echo $sub->sh_sub_id; ?>_sub" onmouseover="$('#sub_id').val('<?php echo $sub->sh_sub_id; ?>')"><?php echo $sub->subject ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>    
                        </div>
                        <?php endforeach; ?>
                    </div>    
                </div>

            </div>
        </div>
    </div>
</div>