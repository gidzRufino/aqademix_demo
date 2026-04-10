<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="margin:0">Notifications</h1>
    </div>
    <div class="col-lg-12">
        <?php 
            if(!empty($notification)):
            foreach($notification->result() as $noti): ?>
            <div class="alert alert-success alert-dismissable " style="margin-bottom: 5px;">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <?php echo $noti->noti_msg ?>
                <a class="alert-link" href="<?php echo $noti->noti_link; ?>">Link</a>
                <span class="pull-right text-muted small"><em><?php echo $noti->noti_timestamp ?></em></span>
            </div>

            <?php endforeach; 
            endif;
            if($adminNotification!=NULL):
            foreach ($adminNotification->result() as $adminNotify): 
                $link = $adminNotify->noti_link;
                $pos = strpos($link,"e-sKwela");
                $sub = $pos + 9;
                $url = substr($link,$sub);
                $relink = base_url($url);
            ?>
            <div class="alert alert-success alert-dismissable " style="margin-bottom: 5px;">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <?php echo $adminNotify->noti_msg ?>
                <a class="alert-link" href="<?php echo $relink; ?>">[ CLICK HERE ]</a>
                <span class="pull-right text-muted small"><em><?php echo $adminNotify->noti_timestamp ?></em></span>
            </div>

            <?php endforeach; 
            endif;
        ?>
    </div>
    
</div>