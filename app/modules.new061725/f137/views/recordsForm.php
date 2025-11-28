
<!--End of Education History-->
<?php
// this will show or hide the buttons
if ($student->grade_level_id <= 7):
    $gs = '';
    $jhs = 'hide';
    $shs = 'hide';
elseif ($student->grade_level_id >= 7 && $student->grade_level_id < 12):
    $gs = '';
    $jhs = '';
    $shs = 'hide';
else:
    $gs = '';
    $jhs = '';
    $shs = '';
endif;
?> 
<!--Academic Records-->

<?php
$settings = Modules::run('main/getSet');
$year = $sy - ($student->grade_level_id - 2); ?>
<!--<button class="btn btn-sm btn-primary pull-right" onclick="printOpt('<?php echo $student->grade_level_id ?>')">Print Form137</button>-->
<button class="btn btn-sm btn-primary pull-right" onclick="printOpt('<?php echo $student->grade_level_id ?>')"><i class="fa fa-print"></i> Print Form137</button>
<a class="btn btn-sm btn-success pull-right" href="<?php echo base_url('opl/downloads/' . base64_encode('uploads/file/acad template.xls')) ?>"><i class="fa fa-download fa-fw "></i> Download Template</a>
<br/><br/><br/>
<div class="card">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li class="active <?php echo $gs ?>" id="gs" onclick="activePane(this.id, $('#eligElem').show(), $('#eligJHS').hide(), $('#eligSHS').hide())"><a href="#gsDisplay">Elementary Department</a></li>
        <li class=" <?php echo $jhs ?>" id="jhs" onclick="activePane(this.id, $('#eligJHS').show(), $('#eligElem').hide(), $('#eligSHS').hide())"><a href="#jhsDisplay">Junior High School</a></li>
        <li class=" <?php echo $shs ?>" id="shs" onclick="activePane(this.id, $('#eligSHS').show(), $('#eligElem').hide(), $('#eligJHS').hide())"><a href="#shsDisplay">Senior High School</a></li>
    </ul>

    <div class="col-md-12">
        <?php
        switch (strtolower($settings->short_name)):
            case 'csfl':
                echo Modules::run('customize/eligForm', strtolower($settings->short_name), base64_encode($student->st_id));
                break;
            default :
                echo $this->load->view('eligForm');
                break;
        endswitch;
        ?>
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="gsDisplay">
            <br>
            <div class="col-md-6">
                <div class="row">
                    <?php
                    for ($x = 2; $x <= $student->grade_level_id; $x++):
                        if ($x >= 2 && $x <= 4):
                            $acadRec = Modules::run('f137/showAcadRecords', base64_encode($student->st_id), $x, $year++, $student->spr_id);
                            ?>
                            <div class="col-md-12">
                                <?php echo $acadRec ?>
                            </div>
                            <?php
                        endif;
                    endfor;
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <?php
                    for ($x = 5; $x <= $student->grade_level_id; $x++):
                        if ($x >= 5 && $x <= 7):
                            $acadRec = Modules::run('f137/showAcadRecords', base64_encode($student->st_id), $x, $year++, $student->spr_id);
                            ?>
                            <div class="col-md-12">
                                <?php echo $acadRec ?>
                            </div>
                            <?php
                        endif;
                    endfor;
                    ?>
                </div>
            </div>
        </div>
        <input type="hidden" id="elemSY" value="<?php echo ($year - 1) ?>" />
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="jhsDisplay">
            <br>
            <div class="col-md-6">
                <div class="row">
                    <?php
                    for ($x = 8; $x <= $student->grade_level_id; $x++):
                        if ($x >= 8 && $x <= 9):
                            $acadRec = Modules::run('f137/showAcadRecords', base64_encode($student->st_id), $x, $year++, $student->spr_id);
                            ?>
                            <div class="col-md-12">
                                <?php echo $acadRec ?>
                            </div>
                            <?php
                        endif;
                    endfor;
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <?php
                    for ($x = 10; $x <= $student->grade_level_id; $x++):
                        if ($x >= 10 && $x <= 11):
                            $acadRec = Modules::run('f137/showAcadRecords', base64_encode($student->st_id), $x, $year++, $student->spr_id);
                            ?>
                            <div class="col-md-12">
                                <?php echo $acadRec ?>
                            </div>
                            <?php
                        endif;
                    endfor;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="shsDisplay">
            <br>
            <?php
            for ($x = 2; $x <= $student->grade_level_id; $x++):
                if ($x >= 12 && $x <= 13):
                    $acadRec = Modules::run('f137/showAcadRecords', base64_encode($student->st_id), $x, $year++);
                    ?>
                    <div class="col-md-12">
                        <?php echo $acadRec ?>
                    </div>
                    <?php
                endif;
            endfor;
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function activePane(id) {
        switch (id) {
            case 'gs':
                $('#gs').addClass('active');
                $('#jhs').removeClass('active');
                $('#shs').removeClass('active');
                $('#gsDisplay').addClass('active');
                $('#jhsDisplay').removeClass('active');
                $('#shsDisplay').removeClass('active');
                break;
            case 'jhs':
                $('#gs').removeClass('active');
                $('#jhs').addClass('active');
                $('#shs').removeClass('active');
                $('#gsDisplay').addClass('active');
                $('#gsDisplay').removeClass('active');
                $('#jhsDisplay').addClass('active');
                $('#shsDisplay').removeClass('active');
                break;
            case 'shs':
                $('#gs').removeClass('active');
                $('#jhs').removeClass('active');
                $('#shs').addClass('active');
                $('#gsDisplay').addClass('active');
                $('#gsDisplay').removeClass('active');
                $('#jhsDisplay').removeClass('active');
                $('#shsDisplay').addClass('active');
                break;
        }
    }
</script>