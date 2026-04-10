<input type="hidden" id="chat_url" value="<?php echo base_url().'chatsystem/chat/' ?>"/>
 <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-users fa-fw"></i>  <i class="fa fa-caret-down"></i>
    </a>
   <ul class="dropdown-menu dropdown-tasks">
        <?php 
             $userdata = Modules::run('users/checkWhosOnline');
            foreach($userdata as $ud){
                $eachData = $this->session->_unserialize($ud->user_data);
                $id = $eachData['user_id']; 
                if($id!=$this->session->userdata('user_id')&& $eachData!=""):
                    $employee = Modules::run('hr/getEmployee', base64_encode($eachData['username']));
                    ?>
                        <li>
                            <a href="#" id="createCB" user_id="<?php echo $id ?>" username="<?php echo $employee->firstname ?>" ><?php echo $employee->firstname ?></a>
                        </li>
                         <li class="divider"></li>
                   <?php
                endif;
            }
        ?>
        <li>

            <a class="text-center" href="#">
                <strong>See All Users</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </li>    

    </ul>
</li>

