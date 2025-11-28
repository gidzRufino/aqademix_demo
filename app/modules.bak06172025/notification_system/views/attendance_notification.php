<?php foreach ($notification as $notify){ ?>
<div style='cursor:pointer; margin-bottom:5px;' class='alert alert-success alert-dismissable span11'>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <div class="notify">
       <?php echo $notify->noti_msg.'<br> [ '. $notify->noti_timestamp.' ]' ; 
       
       ?>
    </div>    

</div>

<?php } ?>