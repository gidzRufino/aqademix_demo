
<style>

tr.strikeout td {
  text-decoration: line-through;
}

</style>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Collection Report
            <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url() ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
            <button type="button" class="btn btn-default" onclick="generateCollectible()">Generate Collectible</button>
            <button style="width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $semester ?> <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li onclick="$('#btnControl').html('First Semester <span class=\'caret\'></span>'), $('#inputSem').val(1)"><a href="#">First Semester</a></li>
                <li onclick="$('#btnControl').html('Second Semester <span class=\'caret\'></span>'), $('#inputSem').val(2)"><a href="#">Second Semester</a></li>
                <li onclick="$('#btnControl').html('Summer  <span class=\'caret\'></span>'), $('#inputSem').val(3)"><a href="#">Summer</a></li>
            </ul> 
            <input type="hidden" id="inputSem" value="<?php echo $sem ?>" />
            <div class="form-group pull-right">
                <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;">
                    <option>School Year</option>
                    <?php 
                          foreach ($ro_year as $ro)
                           {   
                              $roYears = $ro->ro_years+1;
                              if($school_year==NULL):
                                if($this->session->userdata('school_year')==$ro->ro_years):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                              else:
                                if($school_year==$ro->ro_years):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                                  
                              endif;  
                          ?>                        
                        <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                        <?php }?>
                </select>
             </div>
              </div>
        </h3>
    </div>
    <div class="col-lg-12" style="margin-bottom: 10px;">
        <div class="row pull-right">
            <input name="startDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(5)==NULL?date('Y-m-d'):$this->uri->segment(5)) ?>" id="startDate" placeholder="Select Start Date" />
            <input  name="endDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(6)==NULL?date('Y-m-d'):$this->uri->segment(6)) ?>" id="endDate" placeholder="Select End Date" />
            
            
            <div class="btn-group pull-right" role="group" aria-label="">
                <button onclick="generateCollection($('#reportType').val())" type="button" class="btn btn-medium btn-primary">Generate Collection</button>
                <button onclick="printSales($('#reportType').val())" type="button" class="btn btn-medium btn-info">Print</button>
            </div>
            <div class="form-group pull-right" id="itemBody" style="display: none;">
                <select style="width:200px;" tabindex="-1" id="item" name="item"  class="col-lg-12">
                    
                </select>
                
            </div>
            <div class="form-group pull-right">
                <select tabindex="-1" id="reportType" name="reportType"  class="col-lg-12">
                   <option value="0">Report Per Account</option>
                   <option value="1">Collection Report Per Teller</option>
                   <!--<option value="1">Report Per Item</option>-->
                   <option value="2">Report on Collection Summary </option>
                   <option value="10">Report on Collection Summary Per Semester </option>
                   <option value="3">Print Cash Breakdown</option>
                   <option value="5">Generate Assessment Summary - Elementary </option>
                   <option value="6">Generate Assessment Summary - Junior High </option>
                   <option value="7">Generate Assessment Summary - Senior High </option>
                   <option value="4">Generate Assessment Summary - College </option>
                   <option value="8">Generate List of Requested Subjects </option>
                   <option value="9">Generate List of Receivables </option>
                   <option value="11">Generate List of Scholarship Amounts </option>
                   
               </select>
             </div>
        </div>
    </div>
    
    <div class="row col-lg-12">
        <ul class="nav nav-tabs" role="tablist" id="sales_tab">
            <li class="active"><a href="#regularAccounts" onclick="location.reload()">Regular Accounts</a></li>
            <li><a href="#otherAccounts">Other Accounts</a></li>

        </ul>
    </div>
    <div class="tab-content col-lg-12">
        <div id="salesTable regularAccounts" class="tab-pane active" class="col-lg-12">
            <table class="table table-striped">
                <tr>
                    <th style="width:10%;">Date</th>
                    <th style="width:10%;">OR #</th>
                    <th style="width:30%;">Account Name</th>
                    <th style="width:20%;">Teller</th>
                    <th style="width:20%; text-align: right;">Amount</th>
                </tr>
                <tbody id="salesBody">
                    <?php 
                        $total = 0;
                        $overAll = 0;
                        foreach($collection->result() as $c): 
                            if($c->t_type != 3 && $c->t_type!=5):
                                $ctype = $c->acnt_type;
                                $a_id = $c->t_st_id;
                                if ($ctype!=1) {
                                  $overAll += $c->t_amount;
                                  $account_name = strtoupper($c->lastname.', '.$c->firstname); 
                                  $grade_level = $c->level;
                                  $teller = Modules::run('hr/getEmployeeName',$c->t_em_id);
                                  $tellerName = strtoupper(substr($teller->firstname, 0,1).'. '.$teller->lastname);

                                ?>

                                <tr>
                                    <td><?php echo $c->t_date ?></td>
                                    <td><?php echo $c->ref_number ?></td>
                                    <td><?php echo $account_name ?></td>
                                    <td><?php echo $tellerName ?></td>
                                    <td style="text-align: right;"><?php echo number_format($c->t_amount, 2, '.',',')?></td>
                                </tr>
                        <?php
                                }
                                unset($total);
                            endif;
                        endforeach; 
                        $cancelReceipt = $this->finance_model->getCollection($from, $to, 3, $school_year);
                        foreach($cancelReceipt->result() as $cr): 
                            $ctype = $cr->acnt_type;
                            $a_id = $cr->t_st_id;
                              $account_name = strtoupper($cr->lastname.', '.$cr->firstname); 
                              $grade_level = $cr->level;
                              $teller = Modules::run('hr/getEmployeeName',$cr->t_em_id);
                              $tellerName = strtoupper(substr($teller->firstname, 0,1).'. '.$teller->lastname);
                              
                            ?>

                            <tr class="strikeout">
                                <td><?php echo $cr->t_date ?></td>
                                <td><?php echo $cr->ref_number ?></td>
                                <td><?php echo $account_name ?></td>
                                <td><?php echo $tellerName ?></td>
                                <td style="text-align: right;"><?php echo number_format($cr->t_amount, 2, '.',',')?></td>
                            </tr>
                        <?php
                        endforeach;
                            if($overAll!=0):
                        ?>
                            <tr>
                                <th colspan="5"></th>
                                <th style="text-align: right;"> <?php echo number_format($overAll, 2, '.',',') ?></th>
                            </tr>
                        <?php
                            endif;
                            
                        ?>
                </tbody>
            </table>
        </div>
        <div id="otherAccounts" class="tab-pane">
            <table class="table table-striped">
                <tr>
                    <th style="width:10%;">Date</th>
                    <th style="width:10%;">OR #</th>
                    <th style="width:30%;">Account Name</th>
                    <th style="width:10%;">Teller ID</th>
                    <th style="width:15%; text-align: right;">Amount</th>
                    <th style="width:15%;"></th>
                </tr>
                <tbody id="otherSalesBody">
                    <?php
                        $totalOthers = 0;
                        $overAllOthers = 0;
                        foreach($collection->result() as $c): 
                            $ctype = $c->acnt_type;
                            $a_id = $c->t_st_id;
                            if ($ctype==1) {
                                $overAllOthers += $c->t_amount;
                                if($c->acnt_type==0):
                                    $student = Modules::run('college/getBasicStudent', $c->t_st_id, $this->session->school_year)->row();
                                    if($student->lastname!=""):
                                        $name = $student->lastname.', '.$student->firstname;
                                    else:
                                        $student = Modules::run('registrar/getRfidByStid', $c->t_st_id);
                                        $name = $student->lastname.', '.$student->firstname;
                                    endif;
                                else:
                                    $student = Modules::run('college/finance/getOtherAccountDetails', $c->t_st_id);
                                    $name = $student->fo_lastname.', '.$student->fo_firstname;
                                endif;
                                
                              $teller = Modules::run('hr/getEmployeeName',$c->t_em_id);
                              $tellerName = strtoupper(substr($teller->firstname, 0,1).'. '.$teller->lastname);
                            
                            ?>

                            <tr class="<?php echo ($c->t_type==3?'strikeout':'') ?>  ">
                                <td><?php echo $c->t_date ?></td>
                                <td><?php echo $c->ref_number ?></td>
                                <td><?php echo strtoupper($name) ?></td>
                                <td><?php echo $tellerName ?></td>
                                <td style="text-align: right;"><?php echo strtoupper($c->item_description) ?></td>
                                <td style="text-align: right;"><?php echo number_format($c->t_amount, 2, '.',',')?></td>
                                <td>
                                    <div class="btn-group pull-right" role="group" aria-label="">
                                        <button onclick="$('#editFinTransaction').modal('show'), loadFinanceTransaction('<?php echo $c->t_school_year ?>','<?php echo $c->trans_id ?>','<?php echo $c->t_charge_id ?>','<?php echo $c->acnt_type ?>')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                        <button title="Transfer Funds" onclick="$('#transferFinTransaction').modal('show'), prepareFundTransfer('<?php echo strtoupper($name) ?>','<?php echo $c->trans_id ?>','<?php echo $c->t_charge_id ?>','<?php echo $c->t_type ?>','<?php echo $c->t_st_id ?>','<?php echo $this->session->school_year ?>')" class="pointer btn btn-danger btn-xs">  <i class="fa fa-send fa-fw"></i></button>
                                        <!--<button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>-->
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                            unset($totalOthers);
                        endforeach; 
                            if($overAllOthers!=0):
                        ?>
                            <tr>
                                <th colspan="5"></th>
                                <th style="text-align: right;"> <?php echo number_format($overAllOthers, 2, '.',',') ?></th>
                            </tr>
                        <?php
                            endif;

                        ?>
                </tbody>
                
            </table>
        </div>
    </div>    
    
    
</div>

<div id="editFinTransaction"  style="margin: 50px auto;"  class="modal fade col-lg-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-yellow" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i>Edit Finance Transaction
            </h4>
        </div>
        <div class="panel-body" id="editTransBody">
                
           

        </div>
        <div class="panel-footer">
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='saveEditTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>Save Edit</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="transferFinTransaction"  style="margin: 50px auto;"  class="modal fade col-lg-5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i>Transfer Funds to Other Item / Account
            </h4>
        </div>
        <div class="panel-body" id="fundTransferBody">
            
        </div>
        <div class="panel-footer">
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='processFundTransfer()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>PROCESS FUND TRANSFER</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>


<div id="receivablesModal" style="width:30%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h3 class="col-lg-8">Generate List of Receivables</h3>
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
            
        </div>
        <div class="panel-body clearfix">
           <div class="form-group pull-right" required>
                <label>Please Select Department</label>
                <select onclick="if(this.value==4){$('#college').show(),$('#basic').hide()}else{$('#college').hide(),$('#basic').show()}" class="form-control" id="departmentSelect">
                    <option value="none">Select a Department</option>
                    <option value="0">Pre-school</option>
                    <option value="1">Grade School</option>
                    <option value="2">Junior High School</option>
                    <option value="3">Senior High School</option>
                    <option value="4">College</option>
                </select>
            </div>
            <div class="form-group col-lg-12" id="college" style="display: none;">
                 <label>Please Select Course</label> <br />
                 <select id="getCourse" style="width:100%">
                    <option value="none">Select Course</option>
                 <?php 
                    $courses = Modules::run('coursemanagement/getCourses');
                    foreach($courses as $course):
                 ?>
                    <option value="<?php echo $course->course_id ?>"><?php echo $course->course.' ('.$course->short_code.')' ?></option>
                 
                 <?php endforeach; ?>
                 </select>    
            </div>
            <div class="form-group col-lg-12" id="basic" style="display: none;">
                 <label>Please Select Grade Level</label> <br />
                 <select id="getGradeLevel" style="width:100%">
                    <option value="none">Select Course</option>
                 <?php 
                    $gradeLevel = Modules::run('registrar/getGradeLevel');
                    foreach($gradeLevel as $grade):
                 ?>
                    <option value="<?php echo $grade->grade_id ?>"><?php echo $grade->level ?></option>
                 
                 <?php endforeach; ?>
                 </select>    
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button onclick="printReceivables($('#departmentSelect').val())" data-dismiss="modal" class="btn btn-success pull-right">PRINT</button>
        </div>
    </div>
</div>

<div id="searchCashier" style="width:30%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h3 class="col-lg-8">Search Teller</h3>
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
            
        </div>
        <div class="panel-body">
            <input onkeyup="search(this.value)" id="searchBox" class="form-control" type="text" placeholder="Search Name Here" />
            <div onblur="$(this).hide()" style="min-height: 30px; margin-top:0; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

            </div>
            <input type="hidden" id="assign_employee_id" name="assign_employee_id" />
        </div>
        <div class="panel-footer clearfix">
            <button id="addSeriesBtn" onclick="printReportPerTeller()" data-dismiss="modal" class="btn btn-success pull-right">PRINT</button>
        </div>
    </div>
</div>



    <input type="hidden" id="sales_school_year" />
    <input type="hidden" id="sales_trans_id" />
    <input type="hidden" id="sales_trans_item_id" />
    <input type="hidden" id="sales_trans_type" />

<script type="text/javascript">
    
    $('#startDate').datepicker({
        orientation: 'left'
    });
    $('#endDate').datepicker({
        orientation: 'left'
    });
    $('#sales_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    
    $('#getCourse').select2();
    $('#getGradeLevel').select2();
           
    function loadFinanceTransaction(school_year, trans_id, item_id, trans_type)
    {
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/loadFinanceTransaction' ?>',
            //dataType: 'json',
            data: {
                school_year     : school_year,
                trans_id        : trans_id,
                item_id         : item_id,
                trans_type      : trans_type,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#editTransBody').html(response);
                $('#editTransactionDate').datepicker();
            }

        });
    }
        
    function searchTransferAccount(value)
    {
        var school_year = $('#transferSchoolYear').val()
        var url = '<?php echo base_url().'college/finance/searchFundTransferAccount/' ?>'+value+'/'+school_year;
          $.ajax({
             type: "GET",
             url: url,
             data: "id="+value, // serializes the form's elements.
             success: function(data)
             {
                   $('#searchTransferName').show();
                   $('#searchTransferName').html(data);
             }
           });

      return false;
    }
           
    function prepareFundTransfer(name,trans_id, item_id, trans_type, st_id, school_year)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/prepareFundTransfer' ?>',
            //dataType: 'json',
            data: {
                st_id           : st_id,
                name            : name,
                school_year     : school_year,
                semester        : $('#inputSem').val(),
                trans_id        : trans_id,
                item_id         : item_id,
                trans_type      : trans_type,
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#fundTransferBody').html(response);
            }

        });
    }
    
     function generateCollection()
    {
        var report_type = ($('#reportType').val()===0?'':$('#reportType').val());
        var sem = $('#inputSem').val();
        var sy = $('#inputSY').val();
        
        var url = '<?php echo base_url() . 'college/finance/collectionReport/' ?>'+sem+'/'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+report_type+'/'+sy;
        
        document.location = url;
    }
    
        
   function search(value)
      {
          var url = '<?php echo base_url().'finance/finance_reports/searchFinanceStaff/' ?>'+value+'/'+'<?php echo $this->session->school_year ?>';
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                     $('#searchName').show();
                     $('#searchName').html(data);
                     
               }
             });

        return false;
      }

    function printReceivables(dept_id)
    {
        var school_year = $('#inputSY').val();
        var sem = $('#inputSem').val();
        var semester    = (dept_id==4?sem:sem==3?3:0);
        var course_id = (dept_id==4?$('#getCourse').val():$('#getGradeLevel').val());
        
        var url = '<?php echo base_url() . 'college/finance/printReceivables/' ?>'+dept_id+'/'+semester+'/'+school_year+'/'+course_id;
        window.open(url, '_blank');
    }
    
    function printReportPerTeller()
    {
        var sy = $('#inputSY').val();
        var employee_id = $('#assign_employee_id').val();
        var url = '<?php echo base_url() . 'college/finance/printCollectionReportPerTeller/' ?>'+employee_id+'/'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+sy;
        window.open(url, '_blank');
       
    }
    
     function printSales(option)
    {
        
        var sy = $('#inputSY').val();
        switch(option)
        {
            case '0':
                var url = '<?php echo base_url() . 'college/finance/printCollectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val()+'/0/'+sy+'/'+$('#inputSem').val();
        
                window.open(url, '_blank');
            break;
            
            
            case '1':
                <?php if($this->session->position=='Cashier' || $this->session->position == 'Student Assistant (Finance)' || $this->session->position == 'Accounting Staff'): ?>
                    var url = '<?php echo base_url() . 'college/finance/printCollectionReportPerTeller/'.base64_encode($this->session->employee_id) ?>/'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+sy;
                    window.open(url, '_blank');
                <?php else: ?>
                    $('#searchCashier').modal('show');
                <?php endif; ?>    
            break;
            
            case '2':
                var url = '<?php echo base_url() . 'college/finance/collectionSummary/'?>'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+sy+'/'+$('#inputSem').val();
        
                window.open(url, '_blank');
            break;
            
            case '3':
                var url = '<?php echo base_url() . 'college/finance/printCashBreakDown/'?>'+$('#startDate').val()+'/'+$('#endDate').val();
        
                window.open(url, '_blank');
            break;
            
            case '4':
                var url = '<?php echo base_url() . 'college/finance/generateAssessementPerSem/'?>'+$('#inputSem').val()+'/'+$('#inputSY').val();
        
                window.open(url, '_blank');
            break;
            
            case '5':
                var url = '<?php echo base_url() . 'college/finance/generateAssessementForElementary/'?>'+$('#inputSY').val();
        
                window.open(url, '_blank');
            break;
            
            case '6':
                var url = '<?php echo base_url() . 'college/finance/generateAssessementForJuniorHigh/'?>'+$('#inputSY').val();
        
                window.open(url, '_blank');
            break;
            
            case '7':
                var url = '<?php echo base_url() . 'college/finance/generateAssessementForSeniorHigh/'?>'+$('#inputSY').val();
        
                window.open(url, '_blank');
            break;
            
            case '8':
                var url = '<?php echo base_url() . 'college/subjectmanagement/getListOfClasses/'?>'+$('#inputSY').val()+'/'+$('#inputSem').val()+'/1';
        
                window.open(url, '_blank');
            break;
            
            case '9':
                $('#receivablesModal').modal('show')
            break;    
            
            case '10':
                var url = '<?php echo base_url() . 'college/finance/collectionSummaryPerSem/'?>'+$('#inputSem').val()+'/'+$('#inputSY').val();
        
                window.open(url, '_blank');
            break;
            
            case '11':
                var url = '<?php echo base_url() . 'college/finance/generateScholarshipAmount/'?>'+$('#inputSY').val()+'/'+$('#inputSem').val();
        
                window.open(url, '_blank');
            break;
                
        }
        
    }
 
    function getSales()
    {
         $.ajax({
               type: 'GET',
               url: '<?php echo base_url() . 'canteen/getSales/' ?>'+$('#startDate').val()+'/'+$('#endDate').val(),
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function (response) {
                   //    alert(response);
                   $('#salesBody').html(response);
               }
           });
    }
    
    
    function saveEditTransaction()
    {
        var trans_id = $('#edit_trans_id').val();
        var ref_number = $('#editRefNumber').val();
        var editTransDate = $('#editTransactionDate').val();
        var transAmount = $('#editTransAmount').val();
        var receipt = $('#inputEditReceipt').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/saveEditTransaction' ?>',
            //dataType: 'json',
            data: {
                trans_id: trans_id,
                ref_number: ref_number,
                trans_date: editTransDate,
                amount: transAmount,
                receipt: receipt,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }

    
</script>