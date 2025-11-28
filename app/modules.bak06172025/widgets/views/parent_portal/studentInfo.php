<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3">
                <i  class="fa fa-users fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
                <div class="huge"><?php echo $students   ?></div>
                <div>My Students</div>
            </div>
        </div>
    </div>
    <a href="#">
        <div class="panel-footer">
            <a href="<?php echo base_url().'pp/students/'.base64_encode($child_links) ?>" class="pull-left">View Details</a>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>
<?php 