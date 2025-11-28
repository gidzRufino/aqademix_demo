<div class="container" style="width: 50%; padding: 15px; margin-top: 20px; background-color: rgb(242, 241, 247); border-radius: 15px; border: 1px solid rgb(183, 175, 219)">
    <div style="width:165px;margin:0 auto;">
        <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:165px; background: white; margin:0 auto;" />
    </div>
    <h1 class="text-center" style="font-size:30px; color:black;"><?php echo $settings->set_school_name ?></h1>
    <h6 class="text-center" style="font-size:15px; color:black;"><?php echo $settings->set_school_address ?></h6>
    <div class="col-md-12" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-4 col-xs-12" style="text-align: center;">
                <!-- <button type="button" title="Student Login" style="width: 100%; padding 10px; margin: 10px" class="btn btn-success btn-md" onclick="$('#studentLogin').modal('show')"> -->
                <button type="button" title="Student Login" style="width: 100%; padding 10px; margin: 10px" class="btn btn-success btn-md" onclick="window.location='<?php echo base_url() . 'studentsEntrance' ?>'">
                    <i class="fa fa-graduation-cap fa-3x"></i> <br />Student's Login
                </button>
            </div>
            <div class="col-md-4 col-xs-12" style="text-align: center;">
                <!-- <button type="button" title="Parent Login" style="width: 100%; padding 10px; margin: 10px" class="btn btn-primary btn-md" onclick="$('#parentLogin').modal('show')"> -->
                <button type="button" title="Parent Login" style="width: 100%; padding 10px; margin: 10px" class="btn btn-primary btn-md" onclick="window.location='<?php echo base_url() . 'parentsEntrance' ?>'">
                    <i class="fa fa-users fa-3x"></i> <br />Parent's Login
                </button>
            </div>
            <div class="col-md-4 col-xs-12" style="text-align: center;">
                <!-- <button type="button" title="Online Enrollment System" style="width: 100%; padding 10px; margin: 10px" class="btn btn-info btn-md" onclick="$('#enrollmentLogin').modal('show')"> -->
                <button type="button" title="Online Enrollment System" style="width: 100%; padding 10px; margin: 10px" class="btn btn-info btn-md" onclick="window.location='<?php echo base_url() . 'enrollment' ?>'">
                    <i class="fa fa-globe fa-3x"></i> <br />Online Enrollment
                </button>
            </div>
        </div>
    </div>
</div>

<?php
// echo $this->load->view('studentLogin');
// echo $this->load->view('entranceForParents');
// echo $this->load->view('enrollmentMain');
// Modules::run('college/enrollment/studentsLogin');
