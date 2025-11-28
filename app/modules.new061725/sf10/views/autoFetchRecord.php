<div class="col-lg-12" style="margin-top:10px;">
    <div class="alert alert-success clearfix" style="margin-bottom: 0; padding: 3px;">
        <h4 class="text-center">Academic Records
            <a href="#" onclick="getRecords()" onmouseover=" $('#saveController').val('1')" data-dismiss="modal"  id="saveAutoRecord"  class="pull-right">
                <i style="font-size: 30px;" class="fa fa-save pointer"></i>
            </a>
        </h4>

    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th style="vertical-align: middle; text-align: center;" class="col-lg-3" rowspan="2">Subjects</th>
            <th class="col-lg-8 text-center" colspan="4">Grading Periods</th>
        </tr>
        <tr>
            <th class="col-lg-2 text-center">1</th>
            <th class="col-lg-2 text-center">2</th>
            <th class="col-lg-2 text-center">3</th>
            <th class="col-lg-2 text-center">4</th>
        </tr>

        <?php
        //print_r($records->result());
        if ($records):
            foreach ($records as $r):
                $subj_desc = Modules::run('sf10/getSubjectDesc', $r->subject_id);
                ?>
                <tr>
                    <th class="text-center"><?php echo $subj_desc->short_code ?></th>
                    <th class="text-center"><?php echo $r->first; ?></th>
                    <th class="text-center"><?php echo $r->second; ?></th>
                    <th class="text-center"><?php echo $r->third; ?></th>
                    <th class="text-center"><?php echo $r->fourth; ?></th>
                </tr> 
                <?php
            endforeach;
        else:
            echo '<p style="color: red">Error: Unable to fetch Records. Records for S.Y. ' . $sySelect . ' - ' . ($sySelect + 1) . ' was not found on the system</p>';
        endif;
        ?>

    </table>
    <input type="hidden" id="saveController" value="0" />
</div>