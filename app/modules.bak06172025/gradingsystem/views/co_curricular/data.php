<div class="row">
    <h4 class="text-center">Extra-Curricular Performance in 5 Areas </h4>
</div>
<div class="col-lg-6 pull-left">
    <div class="panel panel-info">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Contest and Competitions
                    <a href="#cc" onclick="getCC_cat(1)" data-backdrop="static" data-toggle="modal"><i class="pull-right fa fa-plus-circle pointer"></i></a>
            </h4>
        </div>
        <div class="panel-body" id="cc_body" style="padding:0;">
            
            <table class="table table-bordered table-striped text-center" style="margin:0;">
                <tr>
                    <td>Name of Event</td>
                    <td>Date of Event</td>
                    <td>Level of Participation</td>
                    <td>Rank</td>
                    <td>Points Acquired</td>
                    <td>Verified</td>
                    <td>Action</td>
                </tr>
                <?php
                    //print_r($cc);
                    foreach ($cc as $cc):
                ?>
                <tr>
                    <td><?php echo $cc->event_name; ?></td>
                    <td><?php echo $cc->date_event; ?></td>
                    <td><?php echo $cc->part_pos; ?></td>
                    <td><?php echo $cc->rank; ?></td>
                    <td><?php echo $cc->points; ?></td>
                    <td><?php if($cc->is_verified == 1): echo 'Yes'; else: echo 'No'; endif; ?></td>
                    <td>
                       <a onclick="deleteCC('<?php echo $cc->cc_involvement_id ?>')"><i class="text-danger pull-right fa fa-trash pointer"></i></a> 
                       <a href="#cc" onclick="editCC('<?php echo $cc->cc_involvement_id ?>', 1)" data-backdrop="static" data-toggle="modal"><i class="pull-right fa fa-pencil pointer"></i></a> 
                    </td>
                </tr>
                        
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-6 pull-right">
    <div class="panel panel-red">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Student Leadership
                <a href="#sl" data-backdrop="static" data-toggle="modal"><i style="color:white;" class="pull-right fa fa-plus-circle pointer"></i></a>
            </h4>
        </div>
        <div class="panel-body" style="padding:0;">
            <table class="table table-bordered table-striped text-center" style="margin:0;">
                <tr>
                    <td>Position</td>
                    <td>Coverage</td>
                    <td>Points Acquired</td>
                    <td>Verified</td>
                    <td>Action</td>
                </tr>
                <?php
                    //print_r($cc);
                    foreach ($sl as $cc):
                ?>
                <tr>
                        <td><?php echo $cc->part_pos; ?></td>
                        <td><?php echo $cc->rank; ?></td>
                        <td><?php echo $cc->points; ?></td>
                        <td><?php if($cc->is_verified == 1): echo 'Yes'; else: echo 'No'; endif; ?></td>
                        <td>
                            <a onclick="deleteCC('<?php echo $cc->cc_involvement_id ?>')"><i class="text-danger pull-right fa fa-trash pointer"></i></a> 
                            <a href="#sl" onclick="editCC('<?php echo $cc->cc_involvement_id ?>', 2)" data-backdrop="static" data-toggle="modal"><i class="pull-right fa fa-pencil pointer"></i></a> 
                         </td>
                </tr>        
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>
</div>
<div class="row"></div>
<div class="col-lg-6 pull-left">
    <div class="panel panel-green">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Campus Journalism
                <a href="#cj" data-backdrop="static" data-toggle="modal"><i style=" color:white;" class="pull-right fa fa-plus-circle pointer"></i></a>
            </h4>
        </div>
        <div class="panel-body" style="padding:0;">
            <table class="table table-bordered table-striped table-condensed text-center" style="margin:0;">
                <tr>
                    <td>Position</td>
                    <td>Points Acquired</td>
                    <td>Verified</td>
                    <td>Action</td>
                </tr>
                <?php
                    //print_r($cc);
                    foreach ($cj as $cc):
                ?>
                <tr>
                    <td><?php echo $cc->part_pos; ?></td>
                    <td><?php echo $cc->points; ?></td>
                    <td><?php if($cc->is_verified == 1): echo 'Yes'; else: echo 'No'; endif; ?></td>
                    <td>
                       <a onclick="deleteCC('<?php echo $cc->cc_involvement_id ?>')"><i class="text-danger pull-right fa fa-trash pointer"></i></a> 
                       <a href="#cc" onclick="editCC('<?php echo $cc->cc_involvement_id ?>', 3)" data-backdrop="static" data-toggle="modal"><i class="pull-right fa fa-pencil pointer"></i></a> 
                    </td>
                </tr>
                        
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-6 pull-right">
    <div class="panel panel-yellow">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Officership and Membership
                <a href="#om" data-backdrop="static" data-toggle="modal"><i style=" color:white;" class="pull-right fa fa-plus-circle pointer"></i></a>
            </h4>
        </div>
        <div class="panel-body" style="padding:0;">
            <table class="table table-bordered table-striped table-condensed text-center" style="margin:0;">
                <tr>
                    <td>Level of Participation</td>
                    <td>Position</td>
                    <td>Points Acquired</td>
                    <td>Verified</td>
                    <td>Action</td>
                </tr>
                <?php
                    //print_r($cc);
                    foreach ($om as $cc):
                ?>
                <tr>
                    <td><?php echo $cc->part_pos; ?></td>
                    <td><?php echo $cc->rank; ?></td>
                    <td><?php echo $cc->points; ?></td>
                    <td><?php if($cc->is_verified == 1): echo 'Yes'; else: echo 'No'; endif; ?></td>
                    <td>
                       <a onclick="deleteCC('<?php echo $cc->cc_involvement_id ?>')"><i class="text-danger pull-right fa fa-trash pointer"></i></a> 
                       <a href="#cc" onclick="editCC('<?php echo $cc->cc_involvement_id ?>', 4)" data-backdrop="static" data-toggle="modal"><i class="pull-right fa fa-pencil pointer"></i></a> 
                    </td>
                </tr>
                        
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>
</div>
<div class="row"></div>
<div class="col-lg-3"></div>
<div class="col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading clearfix" style="height:40px;">
            <h4 style="margin:0;" class="text-center">Participation and Attendance
                <a href="#pa" data-backdrop="static" data-toggle="modal"><i style=" color:white;" class="pull-right fa fa-plus-circle pointer"></i></a>
            </h4>
        </div>
        <div class="panel-body" style="padding:0;">
            <table class="table table-bordered table-striped table-condensed text-center" style="margin:0;">
                <tr>
                    <td>Level of Participation</td>
                    <td>Name of Event</td>
                    <td>Date of Event</td>
                    <td>Points Acquired</td>
                    <td>Verified</td>
                    <td>Action</td>
                </tr>
                <?php
                    //print_r($cc);
                    foreach ($pa as $cc):
                ?>
                <tr>
                    <td><?php echo $cc->rank; ?></td>
                    <td><?php echo $cc->event_name; ?></td>
                    <td><?php echo $cc->date_event; ?></td>
                    <td><?php echo $cc->points; ?></td>
                    <td><?php if($cc->is_verified == 1): echo 'Yes'; else: echo 'No'; endif; ?></td>
                    <td>
                       <a onclick="deleteCC('<?php echo $cc->cc_involvement_id ?>')"><i class="text-danger pull-right fa fa-trash pointer"></i></a> 
                       <a href="#cc" onclick="editCC('<?php echo $cc->cc_involvement_id ?>', 5)" data-backdrop="static" data-toggle="modal"><i class="pull-right fa fa-pencil pointer"></i></a> 
                    </td>
                </tr>
                        
                <?php
                    endforeach;
                ?>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-3"></div>