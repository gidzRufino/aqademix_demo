<div id="studentDetails" style="width:90%; margin: 15px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger">
        <div class="panel-heading clearfix">
            <h4 class="no-margin col-lg-4" id="name"></h4>
            <input type="hidden" id="user_id" />
            <input type="hidden" id="grade_id" />
            <button style="margin-left:5px;" data-dismiss="modal" class="pull-right btn btn-danger btn-xs"><i class="fa fa-close fa-2x"></i></button>
            <div class="form-group pull-right">
                <select tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" >
                    <option value="0">Please Select School Year</option>
                    <?php 
                          foreach ($ro_years as $ro)
                           {   
                              $roYears = $ro->ro_years+1;
                              if($this->session->userdata('school_year')==$ro->ro_years):
                                  $selected = 'Selected';
                              else:
                                  $selected = '';
                              endif;
                          ?>                        
                        <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                        <?php }?>
                        
                </select>
            </div>
        </div>
        <div id="studentData" class="panel-body">
                <ul class="nav nav-tabs" role="tablist" id="profile_tab">
                    <li onclick="getStudentData('acad')" class="active"><a href="#acad">Academic Performance</a></li>
                    <li onclick="getStudentData('attend')"><a href="#attend">Attendance Record</a></li>
                    <?php
                        if($settings->use_canteen):
                            ?>
                                <li onclick="getStudentData('canteen')"><a href="#canteen">Cafeteria / Canteen Records</a></li>
                            <?php
                        endif;
                    ?>
                </ul>
                <div class="tab-content col-lg-12">
                    <div style="padding-top: 15px;" class="tab-pane active" id="acad">
                        <div id="acadBody" class="panel-body">
                        </div>
                    </div>
                    <div style="padding-top: 15px;" class="tab-pane" id="attend">
                        <div id="attendBody" class="panel-body">
                        
                            <?php
                                echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
                            ?>
                        </div>
                    </div>
                    <?php
                        if($settings->use_canteen):
                            ?>
                                <div style="padding-top: 15px;" class="tab-pane active" id="canteen">
                                    <div>
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <th>#</th>
                                                <th>Transaction #</th>
                                                <th>Canteen Items</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                            <tbody id="canteenBody">

                                            </tbody>    
                                        </table>
                                    </div>
                                </div>
                            <?php
                        endif;
                    ?>
                </div>
           
        </div>
    </div>
</div>


<script type="text/javascript">
    
    $('#profile_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
</script>

       