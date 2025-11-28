<div class="well col-lg-12 no-padding no-margin">
    <div class="col-lg-6">
        <h4 style="color:black; margin:3px 0;">
            <span id="name">
            <?php echo $basicInfo->firstname.' '.$basicInfo->lastname?></span>
        </h4>
        <h3 style="color:black; margin:3px 0;">
            <span  style="color:#BB0000;" id="grade">
            <?php echo $basicInfo->position ?> </span>
        </h3>
        <h5 style="color:black; margin:3px 0;">
            <small>
                <span>
                    <?php echo $basicInfo->employee_id ?>
                    <input type="hidden" id="em_id" value="<?php echo $basicInfo->employee_id ?>" />
                </span>
            </small>
         </h5>
    </div>
    <div class="col-lg-6 pull-right">
        <h5 class="text-right">Advisory : <?php if(!empty($getAdvisory->row())): echo $getAdvisory->row()->level.' [ '.$getAdvisory->row()->section.' ]'; else: echo 'NONE'; endif;?>&nbsp;&nbsp;&nbsp;<a onclick="removeAdvisory('<?php echo $getAdvisory->row()->adv_id ?>','<?php echo $basicInfo->employee_id ?>')" href="#" title="Remove Advisory"><i class="fa fa-close pointer"></i></a></h5>
    </div>
</div>