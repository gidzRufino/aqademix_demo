<div class="col-lg-4 col-xs-12">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i  class="fa fa-calendar fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo $numberOfPresents->num_rows() ?> / <?php echo $numberOfStudents->num_rows() ?></div>
                    <div>Number of Employees Present</div>
                </div>
            </div>
        </div>
        <a href="<?php echo base_url().'hr/getDailyAttendance' ?>">
            <div class="panel-footer">  
                <span onclick="" class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>