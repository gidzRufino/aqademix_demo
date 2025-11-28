<div class="col-lg-4 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i style="margin-bottom: -10px" class="pull-left"><?php echo date('F') ?></i>
                    <span  class="huge"> <?php echo date('d') ?></span>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><span id="num_presents"><?php echo ($numberOfPresents->num_rows()>$numberOfStudents->num_rows()?$numberOfStudents->num_rows():$numberOfPresents->num_rows()) ?></span> / <?php echo $numberOfStudents->num_rows() ?></div>
                    <div>Number of Students Present</div>
                </div>
            </div>
        </div>
        <a href="<?php echo base_url().'attendance/dailyPerSubject'  ?>">
            <div class="panel-footer">  
                <span onclick="" class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>