<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/'); ?>bootstrap-timepicker.min.css" media="print" />
<div class="col-lg-12">
    <div style="position:absolute; top:30%; left:50%;" class="alert alert-error hide" id="notify" data-dismiss="alert-message">
        <h4></h4>
    </div>
    <?php $employeeTimeSettings = Modules::run('hr/payroll/getRawTimeShifting'); ?>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Employees Time Settings</h5>
                    </div>
                    <div class="panel-body">
                        <table class='editableTable table table-bordered table-hover pull-right'>
                            <tr style="font-weight: bold; text-align: center">
                                <td style="width: 25%">Department</td>
                                <td>Time In [AM]</td>
                                <td>Time Out [AM]</td>
                                <td>Time In [PM]</td>
                                <td>Time Out [PM]</td>
                                <td>Action</td>
                            </tr>
                            <?php foreach ($employeeTimeSettings as $setTime): ?>
                                <tr style="text-align: center">
                                    <td><?php echo $setTime->ps_department ?></td>
                                    <td>
                                        <?php echo $setTime->ps_from ?>
                                    </td>
                                    <td>
                                        <?php echo $setTime->ps_to ?>
                                    </td>
                                    <td>
                                        <?php echo $setTime->ps_from_pm ?>
                                    </td>
                                    <td>
                                        <?php echo $setTime->ps_to_pm ?>
                                    </td>
                                    <td>
                                        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
                                           rel="clickover"  id="<?php echo $setTime->ps_id ?>"
                                           data-content="<?php
                                           $data['optionToEdit'] = 'a';
                                           $data['timeInAM'] = $setTime->ps_from;
                                           $data['timeOutAM'] = $setTime->ps_to;
                                           $data['timeInPM'] = $setTime->ps_from_pm;
                                           $data['timeOutPM'] = $setTime->ps_to_pm;
                                           $data['sectionID'] = $setTime->ps_id;
                                           $data['section'] = $setTime->ps_department;
                                           $this->load->view('editTimeSettings', $data);
                                           ?>">
                                        </i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <div  class="alert alert-error hide" id="qnotify" data-dismiss="alert-message">
                    <h4></h4>

                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <?php $timeSet = Modules::run('main/getTimeSettingsPerSection') ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Students Time Settings</h5>
                    </div>
                    <div class="panel-body">
                        <table class='editableTable table table-bordered table-hover pull-right'>
                            <tr style="font-weight: bold; text-align: center">
                                <td style="width: 25%">Grade / Section</td>
                                <td>Time In [AM]</td>
                                <td>Time Out [AM]</td>
                                <td>Time In [PM]</td>
                                <td>Time Out [PM]</td>
                                <td>Action</td>
                            </tr>
                            <?php foreach ($timeSet as $setTime): ?>
                                <tr style="text-align: center">
                                    <td style="text-align: left"><?php echo $setTime->level.'-'.$setTime->section ?></td>
                                    <td>
                                        <?php echo $setTime->time_in ?>
                                    </td>
                                    <td>
                                        <?php echo $setTime->time_out ?>
                                    </td>
                                    <td>
                                        <?php echo $setTime->time_in_pm ?>
                                    </td>
                                    <td>
                                        <?php echo $setTime->time_out_pm ?>
                                    </td>
                                    <td>
                                        <i style="font-size:15px; color:#777;" class="fa fa-pencil-square-o clickover pointer "
                                           rel="clickover"  id="<?php echo $setTime->section_id ?>"
                                           data-content="<?php
                                           $data['optionToEdit'] = 'b';
                                           $data['timeInAM'] = $setTime->time_in;
                                           $data['timeOutAM'] = $setTime->time_out;
                                           $data['timeInPM'] = $setTime->time_in_pm;
                                           $data['timeOutPM'] = $setTime->time_out_pm;
                                           $data['sectionID'] = $setTime->section_id;
                                           $data['section'] = $setTime->section;
                                           $this->load->view('editTimeSettings', $data);
                                           ?>">
                                        </i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <div  class="alert alert-error hide" id="qnotify" data-dismiss="alert-message">
                    <h4></h4>

                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/bootstrap-timepicker.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'left',
            html: true
        });
    });
</script>

<?php //echo Modules::run('subjectmanagement/seniorHighModal');