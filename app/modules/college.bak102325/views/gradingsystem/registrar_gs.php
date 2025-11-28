<?php
$deadline = Modules::run('college/gradingsystem/getDeadlineDates', $sy);
$nxtSy = $sy + 1;
?>
<div class="clearfix" style="margin-top: 100px"></div>
<div class="col-lg-12 no-padding">
    <div id='gsFirst' class="col-lg-4">
        <div class="alert alert-info">
            <h4 class="text-center">First Semester [ S.Y. <?php echo $sy . ' - ' . $nxtSy ?> ]</h4>
            <hr>
            <p>Deadline for Submission of Grades</p><br>
            <label>Date :</label>
            <span id="spanFinFirst"><?php echo ($deadline->finFirst == '0000-00-00' || $deadline->finFirst == '' ? '' : date('F d, Y', strtotime($deadline->finFirst))) ?></span>
            <input style="display: none;" class="deadlineDate" name="finFirst" type="text" id="finFirst" value="<?php date() ?>" onblur="" required>
            <i id="editFinFirstBtn" class="fa fa-pencil-square-o clickover pointer" onclick="$('#spanFinFirst').hide(), $('#finFirst').show(), $(this).hide(), $('#saveFinFirstBtn').show(), $('#closeFinFirstBtn').show()"></i>   
            <i id="saveFinFirstBtn" class="fa fa-save clickover pointer" onclick="saveDdate($('#finFirst').val(), 'finFirst', $('#dd_id').val(), 'Finals', 1), $('#spanFinFirst').show(), $('#finFirst').hide(), $(this).hide(), $('#editFinFirstBtn').show(), $('#closeFinFirstBtn').hide()" style="display: none"></i>
            <i id="closeFinFirstBtn" class="fa fa-close clickover pointer text-danger" onclick="$('#spanFinFirst').show(), $('#finFirst').hide(), $(this).hide(), $('#editFinFirstBtn').show(), $('#saveFinFirstBtn').hide()" style="display: none"></i>
            <?php
            switch ($deadline->is_first_posted):
                case 0:
                    $val = 1;
                    $post = 'POST';
                    $btn = 'btn btn-sm btn-primary';
                    break;
                case 1:
                    $val = 0;
                    $post = 'POSTED';
                    $btn = 'btn btn-sm btn-success';
                    break;
            endswitch;
            ?>
            <button class="<?php echo $btn ?> pull-right" <?php echo ($deadline->finFirst == '0000-00-00' || $deadline->finFirst == '' ? 'disabled' : '') ?> onclick="postDate('<?php echo $val ?>', 'is_first_posted', '<?php echo $deadline->dd_id ?>', 1)"><?php echo $post ?></button>
        </div>
    </div>
    <div id='gsSecond' class="col-lg-4">
        <div class="alert alert-warning">
            <h4 class="text-center">Second Semester [ S.Y. <?php echo $sy . ' - ' . $nxtSy ?> ]</h4>
            <hr>
            <p>Deadline for Submission of Grades</p><br>
            <label>Date :</label>
            <span id="spanFinSecond"><?php echo ($deadline->finSecond == '0000-00-00' || $deadline->finSecond == '' ? '' : date('F d, Y', strtotime($deadline->finSecond))) ?></span>
            <input style="display: none;" class="deadlineDate" name="finSecond" type="text" id="finSecond" value="<?php date() ?>" onblur="" required>
            <i id="editFinSecondBtn" class="fa fa-pencil-square-o clickover pointer" onclick="$('#spanFinSecond').hide(), $('#finSecond').show(), $(this).hide(), $('#saveFinSecondBtn').show(), $('#closeFinSecondBtn').show()"></i>   
            <i id="saveFinSecondBtn" class="fa fa-save clickover pointer" onclick="saveDdate($('#finSecond').val(), 'finSecond', $('#dd_id').val(), 'Finals', 2), $('#spanFinSecond').show(), $('#finSecond').hide(), $(this).hide(), $('#editFinSecondBtn').show(), $('#closeFinSecondBtn').hide()" style="display: none"></i>
            <i id="closeFinSecondBtn" class="fa fa-close clickover pointer text-danger" onclick="$('#spanFinSecond').show(), $('#finSecond').hide(), $(this).hide(), $('#editFinSecondBtn').show(), $('#saveFinSecondBtn').hide()" style="display: none"></i>
            <?php
            switch ($deadline->is_second_posted):
                case 0:
                    $val = 1;
                    $post = 'POST';
                    $btn = 'btn btn-sm btn-primary';
                    break;
                case 1:
                    $val = 0;
                    $post = 'POSTED';
                    $btn = 'btn btn-sm btn-success';
                    break;
            endswitch;
            ?>
            <button class="<?php echo $btn ?> pull-right" <?php echo ($deadline->finSecond == '0000-00-00' || $deadline->finSecond == '' ? 'disabled' : '') ?> onclick="postDate('<?php echo $val ?>', 'is_second_posted', '<?php echo $deadline->dd_id ?>', 2)"><?php echo $post ?></button>
        </div>
    </div>
    <div id='gsSummer' class="col-lg-4">
        <div class="alert alert-danger">
            <h4 class="text-center">Summer [ S.Y. <?php echo $sy . ' - ' . $nxtSy ?> ]</h4>
            <hr>
            <p>Deadline for Submission of Grades</p><br>
            <label>Date :</label>
            <span id="spanFinSummer"><?php echo ($deadline->finSummer == '0000-00-00' || $deadline->finSummer == '' ? '' : date('F d, Y', strtotime($deadline->finSummer))) ?></span>
            <input style="display: none;" class="deadlineDate" name="finSummer" type="text" id="finSummer" value="<?php date() ?>" onblur="" required>
            <i id="editFinSummerBtn" class="fa fa-pencil-square-o clickover pointer" onclick="$('#spanFinSummer').hide(), $('#finSummer').show(), $(this).hide(), $('#saveFinSummerBtn').show(), $('#closeFinSummerBtn').show()"></i>   
            <i id="saveFinSummerBtn" class="fa fa-save clickover pointer" onclick="saveDdate($('#finSummer').val(), 'finSummer', $('#dd_id').val(), 'Finals', 3), $('#spanFinSummer').show(), $('#finSummer').hide(), $(this).hide(), $('#editFinSummerBtn').show(), $('#closeFinSummerBtn').hide()" style="display: none"></i>
            <i id="closeFinSummerBtn" class="fa fa-close clickover pointer text-danger" onclick="$('#spanFinSummer').show(), $('#finSummer').hide(), $(this).hide(), $('#editFinSummerBtn').show(), $('#saveFinSummerBtn').hide()" style="display: none"></i>
            <?php
            switch ($deadline->is_summer_posted):
                case 0:
                    $val = 1;
                    $post = 'POST';
                    $btn = 'btn btn-sm btn-primary';
                    break;
                case 1:
                    $val = 0;
                    $post = 'POSTED';
                    $btn = 'btn btn-sm btn-success';
                    break;
            endswitch;
            ?>
            <button class="<?php echo $btn ?> pull-right" <?php echo ($deadline->finSummer == '0000-00-00' || $deadline->finSummer == '' ? 'disabled' : '') ?> onclick="postDate('<?php echo $val ?>', 'is_summer_posted', '<?php echo $deadline->dd_id ?>', 3)"><?php echo $post ?></button>
        </div>
    </div>
</div>
<input type="hidden" id="dd_id" value="<?php echo $deadline->dd_id ?>" />

<br>
<select id="sySem" class="pull-right">
    <option value="0">Select Semester</option>
    <option value="1">First Semester</option>
    <option value="2">Second Semester</option>
    <option value="3">Summer</option>
</select>
<select id="syGS" class="pull-right">
    <option value="0">Select School Year</option>
    <?php
    for ($y = $sy; $y >= 2019; $y--):
        echo '<option value="' . $y . '" ' . ($y == $sy ? 'selected' : '') . '>' . $y . ' - ' . ($y + 1) . '</option>';
    endfor;
    ?>
</select><br/><br/>
<div class="col-lg-12">
    <div class="pull-right">
        <div class="pull-left">
            <h5 style="margin:0;">Search By:
                <select id="searchOption" onclick="getSearchOption(this.value)" style="width:150px; margin-right:5px; height:40px;">
                    <option>Select Option</option>
                    <option value="profile_students.st_id">Student ID</option>
                    <option value="profile_employee">Faculty Assign</option>
                    <option  selected="selected"  value="lastname">Last Name</option>
                </select>
            </h5>
        </div>
        <div class="pull-left">
            <div class="form-group pull-right" id="section" style="display: none;">
                <select onclick="search(this.value)" tabindex="-1" id="inputSection" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                    <option>Search By Faculty Assign</option>
                    <?php
//                    foreach ($section->result() as $sec) {
                    ?>                        
                    <option value="<?php // echo $sec->section_id;    ?>"><?php // echo $sec->level . ' [ ' . $sec->section . ' ]';    ?></option>
                    <?php // } ?>
                </select>
            </div>
            <div class="form-group pull-right" id="searchEmp" style=" display: none;">
                <select onclick="searchEmp(this.value)" tabindex="-1" id="inputGrade" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
                    <option>Search Grade level here</option>
                    <?php
//                    foreach ($grade as $level) {
                    ?>                        
                    <option value="<?php // echo $level->grade_id;    ?>"><?php // echo $level->level;    ?></option>
                    <?php // } ?>
                </select>
            </div>
            <div class="form-group" id="searchBox" style="margin:5px 0;">
                <div class="controls">
                    <input type="hidden" id="gradeSection" value="<?php // echo $gradeSection    ?>" />
                    <input style="width:250px;" onkeyup="search(this.value)" class="form-control" id="verify" placeholder="Search" type="text">
                </div>
                <div style="min-height: 30px; background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

                </div> 
<!--                <span class="input-group-btn">
                    <button class="btn btn-default">
                        <i id="verify_icon" class="fa fa-search"></i>
                    </button>
                </span>-->
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" id="gsListTable">

</div>