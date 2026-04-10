<?php
if($city_id == NULL):
    ?>
<div class="row">
    <div class="col-md-4 col-md-offset-3 input-group" style="margin-top: 10px;">
        <input type="text" class="form-control" placeholder="Search City">
        <div class="input-group-addon"><i class="fa fa-search"></i></div>
    </div>
    <div class="col-md-12" style="margin-top: 25px;">
        <div class="col-md-6">
            <ul>
                <?php 
                    foreach($cities AS $c):
                ?>
                    <li><a href="<?php echo site_url('main/demographics/').$c->id; ?>"><?php echo $c->mun_city; ?></a> | <span class='text-warning'>(<?php echo $c->student_count; ?>)</span> | <span class='text-success'>(<?php echo number_format((($c->student_count/$c->total)*100), 2)?>%)</span></li>
                <?php
                    endforeach;
                ?>
            </ul>
        </div>
    </div>
</div>
<?php
else:
    ?>
    <div class="row">
        <button type="button" onclick="location.href='<?php echo site_url('main/demographics'); ?>'" class="btn btn-default btn-sm pull-left" style="margin-top: 10px;"><i class="fa fa-arrow-left"></i></button>
        <div class="col-md-4 col-md-offset-3 input-group" style="margin-top: 10px;">
            <input type="text" class="form-control" placeholder="Search Barangay">
            <div class="input-group-addon"><i class="fa fa-search"></i></div>
        </div>
        <div class="col-md-12" style="margin-top: 25px;">
            <div class="col-md-6">
                <ul>
                    <?php 
                        foreach($cities AS $c):
                    ?>
                        <li><a href="<?php echo site_url('main/demograph_students/').$city_id.'/'.$c->barangay_id; ?>"><?php echo ($c->barangay != '') ? $c->barangay : "No Barangay"; ?></a> | <span class='text-warning'>(<?php echo $c->student_count; ?>)</span> | <span class='text-success'>(<?php echo number_format((($c->student_count/$c->total)*100), 2)?>%)</span></li>
                    <?php
                        endforeach;
                    ?>
                </ul>
            </div>
            <div class="col-md-4">
                <!-- <?php echo Modules::run('widgets/getWidget', 'demographics_widgets', 'demograph', $city_id); ?> -->
            </div>
        </div>
    </div>
<?php
endif;