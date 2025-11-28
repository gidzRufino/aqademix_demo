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
                    <?php
                        if($this->session->employee_id == $noti->noti_to):
                            $name = Modules::run('hr/getPersonName', $this->session->user_id);
                            $newnotif = str_replace($name." has", 'You have', $noti->noti_msg);
                            echo $newnotif;
                        else:
                            echo $noti->noti_msg;
                        endif;
                    ?>
                    <a class="alert-link" href="<?php echo $noti->noti_link; ?>">Link</a>
                    <span class="pull-right text-muted small"><em><?php echo $noti->noti_timestamp ?></em></span>
                </div>

                <?php endforeach;
            endif;
            if($assocHead->num_rows() != 0):
                $assocNotifcation = Modules::run('notification_system/getAssocNotifications');
                foreach($assocNotifcation AS $an):
                    if($an->noti_to != $this->session->employee_id):
                        foreach($assocHead->result() AS $ah):
                            $suborAssoc = Modules::run('notification_system/checkUserAssocHead', $ah->dh_assoc);
                            if($suborAssoc->num_rows() != 0):
                                foreach($suborAssoc->result() AS $sa):
                                    if($sa->dh_assoc == $an->noti_to):
                                        ?>
                                            <div class="alert alert-success alert-dismissable " style="margin-bottom: 5px;">
                                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                                                <?php
                                                    echo $an->noti_msg;
                                                ?>
                                                <a class="alert-link" href="<?php echo $an->noti_link; ?>">Link</a>
                                                <span class="pull-right text-muted small"><em><?php echo $an->noti_timestamp ?></em></span>
                                            </div>
                                        <?php
                                    endif;
                                endforeach;
                            endif;
                            if($ah->dh_assoc == $an->noti_to):
                    ?>
                            <div class="alert alert-success alert-dismissable " style="margin-bottom: 5px;">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                                <?php
                                    echo $an->noti_msg;
                                ?>
                                <a class="alert-link" href="<?php echo $an->noti_link; ?>">Link</a>
                                <span class="pull-right text-muted small"><em><?php echo $an->noti_timestamp ?></em></span>
                            </div>
                <?php
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
            if($adminNotification!=NULL):
                foreach ($adminNotification->result() as $adminNotify): ?>
                <div class="alert alert-success alert-dismissable " style="margin-bottom: 5px;">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <?php echo $adminNotify->noti_msg ?>
                    <a class="alert-link" href="<?php echo $adminNotify->noti_link; ?>">[ CLICK HERE ]</a>
                    <span class="pull-right text-muted small"><em><?php echo $adminNotify->noti_timestamp ?></em></span>
                </div>

                <?php endforeach;
            endif;
        ?>
    </div>

</div>
