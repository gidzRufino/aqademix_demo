 <div id="selection" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            Select an Option:
        </div>
        <div class="modal-content">
            <div class="btn-group btn-group-justified" data-toggle="buttons">
                <label onclick="$('addRecords').addClass('hide')" class="btn btn-primary " data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#autoSelect"  >
                  <input type="radio" name="options" id="manual" value="manual"> Manual
                </label>
                <label class="btn btn-primary " data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#autoDataInput" >
                  <input type="radio" name="options" id="auto" value="auto"> Automatic
                </label>
            </div>
              
        </div>
    </div>
  </div>
</div>

<!--modal used for manual entry of data-->

<div class="modal fade" id="attendanceInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header clearfix">
          Attendance Information
          <a href="#" data-dismiss="modal">
                <i class="pull-right fa fa-close pointer"></i>
            </a>
      </div>
      <div class="modal-body clearfix" id="aiBody">
          <div class="col-lg-12" style="margin:10px 0; border-bottom: 1px solid #999999; padding-bottom: 5px;">
                <div class="col-lg-4">
                    <select tabindex="-1" onclick="getDaysPresent(this.value)" id="monthPresent" style="width:100%; height: 40px;">
                            <option value="1" >Select Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option> 
                   </select>
                </div>
                <div class="col-lg-5">
                    <input type="text" class="form-control" id="daysPresent" placeholder="Days Present" />
                </div>
                <div class="col-lg-3">
                    <button onclick="autoFetchDaysPresent()" class="btn btn-primary btn-xs"><i class="fa fa-database fa-2x"></i></button>
                    <button onclick="saveDaysPresent()" class="btn btn-primary btn-xs"><i class="fa fa-save fa-fw fa-2x"></i></button>
                </div>
                
            </div>
             <div class="row" id="daysPresentResult">

             </div> 
          
          </div>
      </div>
    </div>
  </div>
<!--modal used for manual entry of data-->

<div class="modal fade" id="autoSelect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header clearfix">
         Academic Information
         <div class="pull-right col-lg-8">
            <div class="form-group col-lg-12">
                    <select onclick="getAcadModal($('#form137School_year').val())" class="pull-right" style="width:40%;" name="inputSubject" id="inputSubject" required>
                        <option >Select Subject</option> 
                        <?php  foreach ($subjects as $ga)
                           {     
                        ?>
                         <option value="<?php echo $ga->subject_id; ?>"><?php echo $ga->subject ?></option>  
                        <?php } ?>
                    </select>
                    <select style="margin-right: 5px; width:40%;" onclick="checkAcad(this.value)"  class="pull-right" name="inputGrade" id="inputGradeLevel" required>
                        <option>Select Grade Level</option> 
                          <?php 
                                 foreach ($grade as $level)
                                   {   
                                     if($level->grade_id<14):
                             ?>                        
                                  <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                              <?php 
                                      endif;
                                   }?>
                    </select>
            </div>
         </div>
          
      </div>
      <div class="modal-body clearfix" style="padding:0;">
          <div class="col-lg-12" style="margin:0;">
                <div class="form-group">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            Basic Information
                            <i id="basicInfoMin" style="font-size: 20px;" class="fa fa-minus pull-right pointer fa-fw" onclick="maxMin('basicInfo','min')"></i>
                            <i id="basicInfoMax" style="font-size: 20px;" class="fa fa-plus pull-right pointer hide fa-fw" onclick="maxMin('basicInfo','max')"></i>
                            <i onclick="updateSPR()" style="font-size: 20px;" id="updateSY" class="pull-right fa fa-save fa-2x pointer hide"></i>
                        </div>
                        <div class="panel-body" id="basicInfoBody"> 
                            <input type="text" class="form-control" id="form137School_year" value="" placeholder="School Year"/>
                            <br />
                            <input type="text" class="form-control" id="school" value="" placeholder="Enter the Name of School"/>
                            <input type="hidden" id="spr_id" />
                        </div>
                    </div>
                    <hr />
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <h5 class="text-center">Grading Period</h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-3">
                                <label>First</label>
                                <input onclick="if($('#inputSubject').val()==''){alert('Please Select Subject First!')}" type="text" class="form-control text-center" id="first" value="" required/>
                            </div>
                              <div class="col-lg-3">
                                <label>Second</label>
                                <input type="text" class="form-control text-center" id="second" value="" required/>
                            </div>
                              <div class="col-lg-3">
                                <label>Third</label>
                                <input type="text" class="form-control text-center" id="third" value="" required/>
                            </div>
                              <div class="col-lg-3">
                                <label>Fourth</label>
                                <input type="text" class="form-control text-center" id="fourth" value="" required/>
                            </div>
                              <div class="col-lg-3">
                                <label>Average</label>
                                <input type="text" class="form-control text-center" id="average" value="" required/>
                            </div>
                            <div id="acadResults" class="col-lg-12">  
                        
                            </div>     
                        </div>
                    
                               
                    </div>
          
                      
               </div>

          
          </div>
        <div class="modal-footer clearfix">
            <button onclick="saveAcademicRecords()" type="button" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Save</button>
            <button data-dismiss="modal" type="button" class="btn btn-danger"><i class="fa fa-close fa-fw"></i> close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--modal used for settings for form137-->
<div class="modal fade" id="form137Settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header clearfix text-center">
                Write the number of school days per month
            </div>
            <div class="modal-body clearfix">
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="year" placeholder="School Year" />
                </div>
                <div class="col-lg-12">
                    <select onclick="getSchoolDays(this.value)" tabindex="-1" id="inputMonthForm137" style="width:100%; margin:10px 0; ">
                                <option >Select Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option> 
                       </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="numOfSchoolDays" placeholder="Number of School Days" />
                </div>
                
                <div id="tableDays" class="col-lg-12" style="margin-top:5px">
                    
                </div>
            </div>
            <div class="modal-footer clearfix">
                <button onclick="autoFetchDays()" class="btn btn-primary pull-left"><i class="fa fa-database fa-fw"></i>Auto Fetch</button>
                <button onclick="saveNumberOfDays()" id="btnsave" type="button" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('autoDataInput') ?>

<script type="text/javascript">
    
    function autoFetchDaysPresent()
    {
        var spr_id = $('#spr_id').val();
        var url = "<?php echo base_url().'reports/autoFetchDaysPresent' ?>"
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data:'csrf_test_name='+$.cookie('csrf_cookie_name')+'&spr_id='+spr_id,
            beforeSend: function() {
                showLoading('aiBody');
            },
            success: function(data)
            {
                //console.log(data)
                $('#aiBody').html(data);
                $('#autoSelect.in').modal('hide')
                
            }
        })
        
    }
    
    function autoFetchDays()
    {
        var year = $('#year').val()
        
        var url = "<?php echo base_url().'reports/autoFetchDays' ?>"
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data:'csrf_test_name='+$.cookie('csrf_cookie_name')+'&year='+year,
            beforeSend: function() {
                showLoading('tableDays');
            },
            success: function(data)
            {
                $('#tableDays').html(data)
                $('#btnsave').addClass('hide');
            }
        })
        
    }
    function checkAcad(value)
    {
        var url = "<?php echo base_url().'reports/reports_f137/checkAcad/' ?>"+value+'/'+$('#st_id').val();
        $.ajax({
            type: "GET",
            url: url,
            dataType:'json',
            data:'',
            success: function(data)
            {
                $('#form137School_year').val(data.school_year);
                $('#school').val(data.school_name);
                $('#spr_id').val(data.spr_id);
                
                getAcadModal(data.school_year)
            }
        })
        
    }
    function getAcadModal(school_year)
    {
        var url = "<?php echo base_url().'reports/reports_f137/showAcadRecordsModal/' ?>"+$('#st_id').val()+'/'+$('#inputGradeLevel').val()+'/'+school_year;
        $.ajax({
            type: "GET",
            url: url,
            data:'',
            success: function(data)
            {
               $('#acadResults').html(data)
            }
        })
        
    }
    function saveDaysPresent()
    {
        var month = $('#monthPresent').val();
        var days = $('#daysPresent').val();
        var spr_id = $('#spr_id').val();
        var url = "<?php echo base_url().'reports/savePresentDays' ?>"
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data:'csrf_test_name='+$.cookie('csrf_cookie_name')+'&month='+month+'&days='+days+'&spr_id='+spr_id,
            success: function(data)
            {
                
            }
        })
        
    }
    
    function updateSPR()
    {
        var spr_id = $('#spr_id').val();
        var url = "<?php echo base_url().'reports/updateBasicSPR' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            data:'csrf_test_name='+$.cookie('csrf_cookie_name')+'&school_year='+$('#form137School_year').val()+'&spr_id='+spr_id
                  +'&school='+$('#school').val(),
             success: function(data)
            {
               alert('Records Successfully Updated')
            }  
        })
        
    }
    

</script>