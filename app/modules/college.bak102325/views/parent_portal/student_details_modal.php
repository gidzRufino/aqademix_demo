<div id="studentDetails" style="width:90%; margin: 15px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger">
        <div class="panel-heading clearfix">
            <h4 class="no-margin col-lg-4" id="name"></h4>
            <input type="hidden" id="user_id" />
            <input type="hidden" id="grade_id" />
            <button style="margin-left:5px;" data-dismiss="modal" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close fa-2x"></i></button>
            <div class="form-group pull-right">
                <select onclick="getStudentData(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" >
                    <option>Please Select School Year</option>
                    <?php 
                          foreach ($ro_years as $ro)
                           {   
                              $roYears = $ro->ro_years+1;
                              
                          ?>                        
                        <option value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                        <?php }?>
                </select>
            </div>
        </div>
        <div id="studentData" class="panel-body">
            <div class="col-lg-7">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h5 class="text-center no-margin">Academic Performance</h5>
                    </div>
                    <div id="acadBody" class="panel-body">
                        <?php
                            echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
                        ?>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-5">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h5 class="text-center no-margin">Attendance Record</h5>
                    </div>
                    <div id="attendBody" class="panel-body">
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

       