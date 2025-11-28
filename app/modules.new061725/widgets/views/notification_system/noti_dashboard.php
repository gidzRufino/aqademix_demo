<div class="col-lg-4 pull-right">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bell fa-fw"></i> Notifications Panel
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body" style="height:200px; overflow-y: scroll">
            <div class="list-group">
                <?php
                    if(!empty($getNotification)):
                        foreach ($getNotification->result() as $notify):
                    ?>
                             <a href="#" class="list-group-item clearfix">
                                <i class="fa fa-comment fa-fw"></i> <?php echo $notify->noti_msg ?> <br />
                                <span class="pull-right text-muted small"><em><?php echo $notify->noti_timestamp ?></em>
                                </span>
                            </a>
                    <?php
                        endforeach;
                    endif;
                   
                ?>
               <?php
                    if($adminNotification!=NULL):
                        foreach ($adminNotification->result() as $adminNotify):
                            $link = $adminNotify->noti_link;
                            $pos = strpos($link,"e-sKwela");
                            $sub = $pos + 9;
                            $url = substr($link,$sub);
                            $relink = base_url($url);
                    ?>
                             <a href="<?php echo $relink ?>" class="list-group-item clearfix">
                                <i class="fa fa-comment fa-fw"></i> <?php echo $adminNotify->noti_msg ?> <br />
                                <span class="pull-right text-muted small"><em><?php echo $adminNotify->noti_timestamp ?></em>
                                </span>
                            </a>
                    <?php
                        endforeach;
                   endif;
                ?>

            </div>
            <!-- /.list-group -->
        </div>
        <!-- /.panel-body -->
        <div class="panel-footer">
            
            <a href="<?php echo base_url() ?>notification_system" class="btn btn-default btn-block">View All Alerts</a>
                
        </div>
    </div>
    <!-- /.panel -->

</div>