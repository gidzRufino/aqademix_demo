<?php
session_start();
$_SESSION['username'] = $this->session->userdata('username');
?>

    <input type="hidden" id="chat_url" value="<?php echo base_url().'chat_system/chat/' ?>"/>

        
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
                    $employee = Modules::run('hr/getEmployee', base64_encode($id));
                    ?>
                        <li>
                            <a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $employee->firstname ?>','<?php echo $id ?>')"><?php echo $employee->firstname ?></a>
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

