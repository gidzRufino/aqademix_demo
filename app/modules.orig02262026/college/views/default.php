<h1 class="page-header" style="text-align: center">COLLEGE INFORMATION MANAGEMENT SYSTEM</h1>
<div class="col-lg-12">
    <div class="well" style="margin-bottom: 0px">
        <div class="row">
            <?php 
                foreach ($menus as $m):
                    $menu = Modules::run('college/getMenu', $m);
                    if($menu->cmenu_type=='main'):
                        ?>
                        <div class="col-lg-3" style="margin-top: 20px;">
                            <button onclick="document.location='<?php echo base_url($menu->cmenu_link) ?>'" type="button" class="btn <?php echo $menu->cmenu_btn_type ?>" style="text-align:center; width:100%; height:130px;">
                                    <div class="col-md-12">
                                            <i class="fa <?php echo $menu->cmenu_icon ?> fa-4x"></i><br/>
                                            <h4><?php echo $menu->cmenu_name ?></h4>
                                    </div>
                            </button>
                        </div>
                        <?php 
                    endif;
                endforeach;
                
                if($this->session->userdata('position_id') == 1 || 
                    $this->session->position == "Registrar" || 
                    $this->session->position == "Dean" ||
                    $this->session->position == "DSA" ||
                    $this->session->position == "Dean Secretary" || 
                    $this->session->position == "Quality Assurance Director"|| 
                    $this->session->position == "IBDE Department Head" ||
                    $this->session->position == "Accounting Staff" ||
                    $this->session->position == "Cashier"):
                ?>    
                  
                <div class="col-lg-3" style="margin-top: 20px;">
                    <button onclick="document.location='<?php echo base_url('college/enrollment/monitor/') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-calculator fa-4x"></i><br/>
                                    <h4><?php echo 'Online Enrollment' ?></h4>
                            </div>
                    </button>
                </div>
                
            
                <?php
                endif;
                ?>
                
                <div class="col-lg-3" style="margin-top: 20px;">
                    <button onclick="document.location='<?php echo base_url('college/gradingsystem') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-calculator fa-4x"></i><br/>
                                    <h4><?php echo 'Grading System' ?></h4>
                            </div>
                    </button>
                </div>
            
                <?php
                $assignedSubject = Modules::run('college/subjectmanagement/getAssignedSubjectRaw', $this->session->userdata('employee_id'));
                
                if(!empty($assignedSubject)):
            ?>
            
            
                <div class="col-lg-3" style="margin-top: 20px;">
                    <button onclick="document.location='<?php echo base_url('opl') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-calculator fa-4x"></i><br/>
                                    <h4><?php echo 'Learn Manager' ?></h4>
                            </div>
                    </button>
                </div>
            <?php
                endif;
            ?>    
            <br />
            <!--<button class="btn btn-danger" onclick="sendNotif()">fire</button>-->
            <div class="col-lg-12">
                <h4 class="page-header" style="text-align: center">School Calendar</h4>
            <?php
                $dbTime = Modules::run('main/refreshIdGeneration');
                foreach ($dbTime->result() as $dbT):
                    if(strtotime($dbT->timestamp)):
                        
                    endif;
                endforeach;
                echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
            ?>
            </div>
        </div>
    </div> <!-- <div class="well"> -->
</div>

<script type="text/javascript">

    
    
</script>    
