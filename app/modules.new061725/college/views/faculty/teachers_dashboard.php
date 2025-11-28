<h1 class="page-header" style="text-align: center">COLLEGE INFORMATION MANAGEMENT SYSTEM</h1>
<div class="col-lg-12">
    <div class="well" style="margin-bottom: 0px">
        <div class="row">
            <div class="col-lg-3" style="margin-top: 20px;">
                <button onclick="document.location = '<?php echo base_url('college/gradingsystem') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
                    <div class="col-md-12">
                        <i class="fa fa-calculator fa-4x"></i><br/>
                        <h4><?php echo 'Grading System' ?></h4>
                    </div>
                </button>
            </div>
            <div class="col-lg-3" style="margin-top: 20px;">
                <button onclick="document.location = '<?php echo base_url('college/subjectmanagement/classList') ?>'" type="button" class="btn btn-success" style="text-align:center; width:100%; height:130px;">
                    <div class="col-md-12">
                        <i class="fa fa-users fa-4x"></i><br/>
                        <h4><?php echo 'List of Classes' ?></h4>
                    </div>
                </button>
            </div>
            <div class="col-lg-3" style="margin-top: 20px;">
                <button onclick="document.location = '<?php echo base_url('opl') ?>'" type="button" class="btn btn-danger" style="text-align:center; width:100%; height:130px;">
                    <div class="col-md-12">
                        <i class="fa fa-book fa-4x"></i><br/>
                        <h4><?php echo 'Learn Manager' ?></h4>
                    </div>
                </button>
            </div>
            <?php
            $basicEdAssignment = modules::run('academic/getAssignment', $this->session->employee_id);
            if (count($basicEdAssignment) > 0):
                ?>
                <div class="col-lg-3" style="margin-top: 20px;">
                    <button onclick="document.location = '<?php echo base_url('gradingsystem') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
                        <div class="col-md-12">
                            <i class="fa fa-calculator fa-4x"></i><br/>
                            <h4><?php echo 'Basic Ed Grading System' ?></h4>
                        </div>
                    </button>
                </div>

                <?php
            endif;

            if ($this->session->userdata('position_id') == 1 ||
                    $this->session->position == "Registrar" ||
                    $this->session->position == "Dean" ||
                    $this->session->position == "DSA" ||
                    $this->session->position == "Dean Secretary" ||
                    $this->session->position == "Quality Assurance Director" ||
                    $this->session->position == "IBDE Department Head" ||
                    $this->session->position == "Cashier"):
                ?>    

                <div class="col-lg-3" style="margin-top: 20px;">
                    <button onclick="document.location = '<?php echo base_url('college/enrollment/monitor') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
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
                <div class="panel panel-yellow">
                    <div class="panel-heading" style="padding:25px 20px">
                        <div class="row">
                            <div class="col-xs-3">
                                <i  class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totalStudents ?></div>
                                <div>Total Number of Students</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (empty($pmenu)):
                $menu = Modules::run('college/getMenuByPosition', $this->session->userdata('position_id'));
                foreach ($menu as $m):
                    ?>
                    <div class="col-lg-3" style="margin-top: 20px;">
                        <button onclick="document.location = '<?php echo base_url($m->cmenu_link) ?>'" type="button" class="btn <?php echo $m->cmenu_btn_type ?>" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                <i class="fa <?php echo $m->cmenu_icon ?> fa-4x"></i><br/>
                                <h4><?php echo $m->cmenu_name ?></h4>
                            </div>
                        </button>
                    </div>
                    <?php
                endforeach;

            else:
                foreach ($menus as $m):
                    $menu = Modules::run('college/getMenu', $m);
                    if ($menu->cmenu_type == 'main'):
                        ?>
                        <div class="col-lg-3" style="margin-top: 20px;">
                            <button onclick="document.location = '<?php echo base_url($menu->cmenu_link) ?>'" type="button" class="btn <?php echo $menu->cmenu_btn_type ?>" style="text-align:center; width:100%; height:130px;">
                                <div class="col-md-12">
                                    <i class="fa <?php echo $menu->cmenu_icon ?> fa-4x"></i><br/>
                                    <h4><?php echo $menu->cmenu_name ?></h4>
                                </div>
                            </button>
                        </div>
                        <?php
                    endif;
                endforeach;
            endif;
            ?>

            <div class="col-lg-12">
                <h4 class="page-header" style="text-align: center">School Calendar</h4>
                <?php
                echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
                ?>
            </div>
        </div>
    </div> <!-- <div class="well"> -->
</div>

